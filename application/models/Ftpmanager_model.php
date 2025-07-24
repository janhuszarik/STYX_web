<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Ftpmanager_model extends CI_Model
{
	public function connect_to_ftp($path = '', $search_query = '')
	{
		$this->load->driver('cache', ['adapter' => 'file']);
		$cache_key = 'ftp_list_' . md5(trim($path, '/'));

		if ($list = $this->cache->get($cache_key)) {
		} else {
			$ftp_server = "ftp.styxnatur.at";
			$ftp_user = "testujem@styxnatur.at";
			$ftp_pass = "tQS!2g-x6Oy3S_7.";
			$ftp_port = 21;

			$conn = ftp_connect($ftp_server, $ftp_port, 10);
			if (!$conn) return ['__error' => 'Verbindung zum FTP-Server konnte nicht hergestellt werden.'];

			if (!ftp_login($conn, $ftp_user, $ftp_pass)) {
				ftp_close($conn);
				return ['__error' => 'Fehler beim Anmelden.'];
			}

			ftp_pasv($conn, true);
			$path_normalized = trim($path ?? '', '/');
			$raw_list = @ftp_rawlist($conn, $path_normalized === '' ? '.' : $path_normalized);
			if ($raw_list === false) {
				ftp_close($conn);
				return ['__error' => 'Dateiliste des Verzeichnisses konnte nicht abgerufen werden: ' . $path_normalized];
			}

			$list = [];
			$ignore_files = ['.htaccess', '.ftpquota'];
			foreach ($raw_list as $item) {
				$info = preg_split("/\s+/", $item, 9);
				if (count($info) < 9) continue;

				$type = $info[0][0] === 'd' ? 'dir' : 'file';
				$name = $info[8];
				if ($name === '.' || $name === '..' || in_array($name, $ignore_files)) continue;

				$full_path = $path_normalized === '' ? $name : $path_normalized . '/' . $name;
				$size = $type === 'file' ? (int)$info[4] : null;

				$list[] = [
					'name' => $name,
					'type' => $type,
					'path' => $full_path,
					'size' => $size
				];
			}

			ftp_close($conn);

			usort($list, function($a, $b) {
				if ($a['type'] === $b['type']) {
					return strnatcmp($a['name'], $b['name']);
				}
				return $a['type'] === 'dir' ? -1 : 1;
			});

			$this->cache->save($cache_key, $list, 3600);
		}

		if (!empty($search_query) && is_array($list)) {
			$filtered_list = [];
			foreach ($list as $file) {
				if (stripos($file['name'], $search_query) !== false) {
					$filtered_list[] = $file;
				}
			}
			return $filtered_list;
		}

		return is_array($list) ? $list : ['__error' => 'Unexpected data format from FTP.'];
	}

	public function delete($path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindungsfehler zum FTP.'];

		$parent_path = dirname($path);

		if (@ftp_delete($conn, $path)) {
			ftp_close($conn);
			$this->invalidate_cache($parent_path);
			return true;
		}

		if (@ftp_rmdir($conn, $path)) {
			ftp_close($conn);
			$this->invalidate_cache($parent_path);
			return true;
		}

		ftp_close($conn);
		return ['__error' => 'Löschen fehlgeschlagen: ' . $path];
	}

	private function connect_raw()
	{
		$ftp_server = "ftp.styxnatur.at";
		$ftp_user = "testujem@styxnatur.at";
		$ftp_pass = "tQS!2g-x6Oy3S_7.";
		$conn = ftp_connect($ftp_server);
		if (!$conn || !ftp_login($conn, $ftp_user, $ftp_pass)) return false;
		ftp_pasv($conn, true);
		return $conn;
	}

	public function move($from, $to)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindungsfehler zum FTP.'];

		if (ftp_rename($conn, $from, $to)) {
			ftp_close($conn);
			$this->invalidate_cache(dirname($from));
			$this->invalidate_cache(dirname($to));
			return true;
		}
		ftp_close($conn);
		return ['__error' => 'Datei konnte nicht verschoben werden.'];
	}

	public function create_dir($path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindungsfehler zum FTP.'];

		if (@ftp_mkdir($conn, $path)) {
			ftp_close($conn);
			$this->invalidate_cache(dirname($path));
			return true;
		}

		ftp_close($conn);
		return ['__error' => 'Verzeichnis konnte nicht erstellt werden.'];
	}

	public function upload_file($local_path, $remote_path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindung zum FTP-Server konnte nicht hergestellt werden.'];

		$upload = ftp_put($conn, $remote_path, $local_path, FTP_BINARY);
		ftp_close($conn);

		if ($upload) {
			$this->invalidate_cache(dirname($remote_path));
			return true;
		}
		return ['__error' => 'Datei konnte nicht auf den FTP-Server hochgeladen werden.'];
	}

	public function invalidate_cache($path)
	{
		$this->load->driver('cache', ['adapter' => 'file']);
		$normalized_path = trim($path, '/');
		if ($normalized_path === '.') {
			$normalized_path = '';
		}
		$cache_key = 'ftp_list_' . md5($normalized_path);
		$this->cache->delete($cache_key);
	}
}

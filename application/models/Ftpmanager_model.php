<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Ftpmanager_model extends CI_Model
{
	public function connect_to_ftp($path = '')
	{
		$this->load->driver('cache', ['adapter' => 'file']);
		$cache_key = 'ftp_list_' . md5($path);

		if ($cached = $this->cache->get($cache_key)) {
			return $cached;
		}

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
		$path = trim($path ?? '', '/');

		if (function_exists('ftp_mlsd')) {
			$raw_list = @ftp_mlsd($conn, $path === '' ? '.' : $path);
			if ($raw_list === false) {
				ftp_close($conn);
				return ['__error' => 'Dateiliste (MLSD) des Verzeichnisses konnte nicht abgerufen werden: ' . $path];
			}

			$list = [];
			foreach ($raw_list as $item) {
				if ($item['name'] === '.' || $item['name'] === '..') continue;
				$type = $item['type'] === 'directory' ? 'dir' : 'file';
				$full_path = $path === '' ? $item['name'] : $path . '/' . $item['name'];
				$size = $type === 'file' ? (int)$item['size'] : null;
				$list[] = [
					'name' => $item['name'],
					'type' => $type,
					'path' => $full_path,
					'size' => $size
				];
			}
		} else {
			$names = @ftp_nlist($conn, $path === '' ? '.' : $path);
			if ($names === false) {
				ftp_close($conn);
				return ['__error' => 'Dateiliste (NLST) des Verzeichnisses konnte nicht abgerufen werden: ' . $path];
			}

			$list = [];
			foreach ($names as $name) {
				if ($name === '.' || $name === '..') continue;
				$full_path = $path === '' ? $name : $path . '/' . $name;
				$is_dir = ftp_size($conn, $full_path) === -1;
				$type = $is_dir ? 'dir' : 'file';
				$size = $is_dir ? null : ftp_size($conn, $full_path);
				$list[] = [
					'name' => basename($name),
					'type' => $type,
					'path' => $full_path,
					'size' => $size
				];
			}
		}

		ftp_close($conn);

		$this->cache->save($cache_key, $list, 600);

		return $list;
	}

	public function delete($path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindungsfehler zum FTP.'];

		if (@ftp_delete($conn, $path)) {
			ftp_close($conn);
			$this->invalidate_cache(dirname($path));
			return true;
		}

		if (@ftp_rmdir($conn, $path)) {
			ftp_close($conn);
			$this->invalidate_cache(dirname($path));
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
		$cache_key = 'ftp_list_' . md5(trim($path, '/'));
		$this->cache->delete($cache_key);
	}
}

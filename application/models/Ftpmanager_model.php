<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Ftpmanager_model extends CI_Model
{
	public function connect_to_ftp($path = '')
	{
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

		ftp_pasv($conn, true); // Passiver Modus

		$path = trim($path ?? '', '/');
		$raw_list = @ftp_rawlist($conn, $path === '' ? '.' : $path);
		if ($raw_list === false) {
			ftp_close($conn);
			return ['__error' => 'Dateiliste des Verzeichnisses konnte nicht abgerufen werden: ' . $path];
		}

		$list = [];
		foreach ($raw_list as $item) {
			$info = preg_split("/\s+/", $item, 9);
			if (count($info) < 9) continue;

			$type = $info[0][0] === 'd' ? 'dir' : 'file';
			$name = $info[8];
			if ($name === '.' || $name === '..') continue;

			$full_path = $path === '' ? $name : $path . '/' . $name;
			$size = $type === 'file' ? ftp_size($conn, $full_path) : null;

			$list[] = [
				'name' => $name,
				'type' => $type,
				'path' => $full_path,
				'size' => $size
			];
		}

		ftp_close($conn);
		return $list;
	}

	public function delete($path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Verbindungsfehler zum FTP.'];

		if (@ftp_delete($conn, $path)) {
			ftp_close($conn);
			return true;
		}

		if (@ftp_rmdir($conn, $path)) {
			ftp_close($conn);
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

		if (!$upload) {
			return ['__error' => 'Datei konnte nicht auf den FTP-Server hochgeladen werden.'];
		}
		return true;
	}
}

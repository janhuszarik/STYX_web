<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager_model extends CI_Model
{
	public function connect_to_ftp($path = '')
	{
		$ftp_server = "ftp.styxnatur.at";
		$ftp_user = "testujem@styxnatur.at";
		$ftp_pass = "tQS!2g-x6Oy3S_7.";
		$ftp_port = 21;

		$conn = ftp_connect($ftp_server, $ftp_port, 10);
		if (!$conn) return ['__error' => 'Nepodarilo sa pripojiť k FTP serveru.'];

		if (!ftp_login($conn, $ftp_user, $ftp_pass)) {
			ftp_close($conn);
			return ['__error' => 'Chyba pri prihlasovaní.'];
		}

		ftp_pasv($conn, true); // pasívny mód

		$path = trim($path ?? '', '/');
		$raw_list = @ftp_rawlist($conn, $path === '' ? '.' : $path);
		if ($raw_list === false) {
			ftp_close($conn);
			return ['__error' => 'Nepodarilo sa získať zoznam súborov v adresári: ' . $path];
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
		if (!$conn) return ['__error' => 'Chyba pripojenia k FTP.'];

		if (@ftp_delete($conn, $path)) {
			ftp_close($conn);
			return true;
		}

		if (@ftp_rmdir($conn, $path)) {
			ftp_close($conn);
			return true;
		}

		ftp_close($conn);
		return ['__error' => 'Nepodarilo sa vymazať: ' . $path];
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
		if (!$conn) return ['__error' => 'Chyba pripojenia k FTP.'];

		if (ftp_rename($conn, $from, $to)) {
			ftp_close($conn);
			return true;
		}
		ftp_close($conn);
		return ['__error' => 'Nepodarilo sa presunúť súbor.'];
	}
	public function create_dir($path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Chyba pripojenia k FTP.'];

		if (@ftp_mkdir($conn, $path)) {
			ftp_close($conn);
			return true;
		}

		ftp_close($conn);
		return ['__error' => 'Nepodarilo sa vytvoriť adresár.'];
	}

	public function upload_file($local_path, $remote_path)
	{
		$conn = $this->connect_raw();
		if (!$conn) return ['__error' => 'Nepodarilo sa pripojiť k FTP serveru.'];

		$upload = ftp_put($conn, $remote_path, $local_path, FTP_BINARY);
		ftp_close($conn);

		if (!$upload) {
			return ['__error' => 'Nepodarilo sa nahrať súbor na FTP.'];
		}
		return true;
	}







}

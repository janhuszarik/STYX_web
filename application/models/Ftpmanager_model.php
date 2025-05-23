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
}

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

		ftp_pasv($conn, true); // pasívny režim

		$path = trim($path ?? '', '/');

		$list = @ftp_nlist($conn, $path === '' ? '.' : $path);
		if ($list === false) {
			ftp_close($conn);
			return ['__error' => 'Nepodarilo sa získať zoznam súborov v adresári: ' . $path];
		}

		// Odstráň ./ a ../ z výpisu
		$list = array_filter($list, function($item) {
			return basename($item) !== '.' && basename($item) !== '..';
		});

		// Vyber len názvy (nie cesty)
		$list = array_map('basename', $list);

		ftp_close($conn);
		return $list;
	}
}


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

		if (!$conn) {
			return ['__error' => 'Nepodarilo sa pripojiť k FTP serveru.'];
		}

		if (!ftp_login($conn, $ftp_user, $ftp_pass)) {
			ftp_close($conn);
			return ['__error' => 'Chyba pri prihlasovaní.'];
		}

		ftp_pasv($conn, true); // zapni pasívny režim

		$path = trim($path ?? '', '/');

		if ($path !== '') {
			if (!@ftp_chdir($conn, $path)) {
				ftp_close($conn);
				return ['__error' => 'Nepodarilo sa zmeniť adresár: ' . $path];
			}
		}

		$list = @ftp_nlist($conn, ".");

		if ($list === false) {
			ftp_close($conn);
			return ['__error' => 'Nepodarilo sa získať zoznam súborov v adresári: ' . $path];
		}

		$list = array_filter($list, fn($item) => $item !== '.' && $item !== '..');
		ftp_close($conn);
		return $list;
	}
}

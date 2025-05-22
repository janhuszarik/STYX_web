<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager_model extends CI_Model
{
	public function connect_to_ftp()
	{
		$host = 'ftp.styxnatur.at';
		$username = 'testujem@styxnatur.at';
		$password = 'tQS!2g-x6Oy3S_7.';
		$port = 21;

		$ftp = ftp_connect($host, $port, 10);

		if (!$ftp) {
			return ['__error' => 'Pripojenie na FTP server zlyhalo.'];
		}

		if (!ftp_login($ftp, $username, $password)) {
			ftp_close($ftp);
			return ['__error' => 'Prihlásenie zlyhalo.'];
		}

		ftp_pasv($ftp, true); // pasívny mód

		$list = ftp_nlist($ftp, '.');

		ftp_close($ftp);

		if ($list === false) {
			return ['__error' => 'Nepodarilo sa získať zoznam súborov.'];
		}

		return $list;
	}
}

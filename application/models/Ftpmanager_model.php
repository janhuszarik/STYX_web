<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager_model extends CI_Model {

	private $ftp_config = [];

	public function __construct() {
		parent::__construct();

		$this->ftp_config = [
			'hostname' => 'ftp.styxnatur.at',
			'username' => 'testujem@styxnatur.at',
			'password' => 'tQS!2g-x6Oy3S_7.',
			'port'     => 21,
			'passive'  => FALSE,
			'debug'    => TRUE
		];
		$this->load->library('ftp'); // načítaj bez konfigurácie
	}

	public function list_files($path) {
		// 1. Inicializuj FTP knižnicu bez konfigurácie
		$this->load->library('ftp');

		// 2. Pripoj sa
		if (!$this->ftp->connect($this->ftp_config)) {
			log_message('error', '❌ FTP pripojenie zlyhalo');
			return ['Chyba: Pripojenie na FTP zlyhalo'];
		}

		log_message('debug', '✅ FTP pripojenie úspešné, čítam zoznam');

		// 3. Načítaj zoznam
		$list = $this->ftp->list_files($path);

		// 4. Zavri spojenie až po úspešnom načítaní
		$this->ftp->close();

		return $list;
	}




	public function delete_file($file) {
		if (!$this->ftp->connect($this->ftp_config)) {
			log_message('error', '❌ FTP pripojenie zlyhalo pri mazaní');
			return false;
		}

		$success = $this->ftp->delete_file($file);
		$this->ftp->close();
		return $success;
	}


}


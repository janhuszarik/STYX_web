<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager_model extends CI_Model {

	private $ftp_config = [];
	private $conn_status = false;

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

		// Načíta FTP knižnicu
		$this->load->library('ftp');
	}

	// Funkcia na pripojenie, ktorá si ukladá výsledok do premennej
	private function connect_ftp() {
		if ($this->conn_status === false) {
			$this->conn_status = $this->ftp->connect($this->ftp_config);
		}
		return $this->conn_status;
	}

	public function list_files($path) {
		if (!$this->connect_ftp()) {
			log_message('error', '❌ FTP pripojenie zlyhalo');
			return ['Chyba: Pripojenie na FTP zlyhalo'];
		}

		$list = $this->ftp->list_files($path);
		$this->ftp->close();
		$this->conn_status = false;  // reset pripojenia po close
		return $list;
	}

	public function delete_file($file) {
		if (!$this->connect_ftp()) {
			log_message('error', '❌ FTP pripojenie zlyhalo pri mazaní');
			return false;
		}

		$success = $this->ftp->delete_file($file);
		$this->ftp->close();
		$this->conn_status = false; // reset pripojenia po close
		return $success;
	}
}

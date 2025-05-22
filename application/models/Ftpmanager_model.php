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
			'passive'  => FALSE,  // môžeš neskôr vyskúšať TRUE, ak by boli problémy s výpisom
			'debug'    => TRUE
		];

		$this->load->library('ftp', $this->ftp_config);
	}

	public function list_files($path) {
		if (!$this->ftp->connect($this->ftp_config)) {
			log_message('error', '❌ FTP pripojenie zlyhalo');
			return ['Chyba: Nedá sa pripojiť na FTP server.'];
		}

		$list = $this->ftp->list_files($path);
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

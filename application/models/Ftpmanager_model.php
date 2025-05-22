<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager_model extends CI_Model {

	private $ftp_config = [];

	public function __construct() {
		parent::__construct();

		$this->ftp_config = [
			'hostname' => 'ftp.styxnatur.at',
			'username' => 'mediaftp@styxnatur.at',
			'password' => '5qogN!-J6ZX9G4-_',
			'port'     => 21,
			'passive' => FALSE,
			'debug'    => TRUE
		];


		$this->load->library('ftp', $this->ftp_config);
	}


	public function list_files($path) {
		if (!$this->ftp->connect($this->ftp_config)) return [];

		$list = $this->ftp->list_files($path);
		$this->ftp->close();
		return $list;
	}

	public function delete_file($file) {
		if (!$this->ftp->connect($this->ftp_config)) return false;

		$success = $this->ftp->delete_file($file);
		$this->ftp->close();
		return $success;
	}
}

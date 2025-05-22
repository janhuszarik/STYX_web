<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Ftpmanager_model');
		// Načítanie knižnice ftp tu už nie je potrebné!
	}

	public function index() {
		$path = '/'; // alebo "/shared" podľa FTP štruktúry

		$data['files'] = $this->Ftpmanager_model->list_files($path);
		$data['title'] = 'FTP správca';
		$data['page'] = 'admin/settings/ftpmanager_view';

		$this->load->view('admin/layout/normal', $data);
	}








	public function delete() {
		$file = $this->input->post('file');
		$result = $this->Ftpmanager_model->delete_file($file);
		echo json_encode(['success' => $result]);
	}
}


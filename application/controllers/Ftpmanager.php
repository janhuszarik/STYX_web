<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('ftp');
		$this->load->model('Ftpmanager_model');
		// Nezabudni na overenie, či je užívateľ prihlásený
	}

	public function index() {
		$path = $this->input->get('path') ?? '/Uploads/media/';
		$files = $this->Ftpmanager_model->list_files($path);
		$data['path'] = $path;
		$data['files'] = $files;
		$data['title'] = 'Správca Médií';
		$data['page'] = 'admin/ftpmanager';
		$this->load->view('admin/layout/normal', $data);
	}

	public function delete() {
		$file = $this->input->post('file');
		$result = $this->Ftpmanager_model->delete_file($file);
		echo json_encode(['success' => $result]);
	}

	// Môžeme doplniť aj metódy upload(), rename(), mkdir() atď.
}

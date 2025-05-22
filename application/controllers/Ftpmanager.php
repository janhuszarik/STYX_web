<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('ftp');
		$this->load->model('Ftpmanager_model', 'ftpmodel');
		// Nezabudni na overenie, či je užívateľ prihlásený
	}

	public function index() {
		$path = '/';

		$data['files'] = $this->ftpmodel->list_files($path);
		$data['title'] = 'FTP správca';
		$data['page'] = 'admin/settings/ftpmanager_view';

		$this->load->view('admin/layout/normal', $data);
	}


	public function delete() {
		$file = $this->input->post('file');
		$result = $this->ftpmodel->delete_file($file);
		echo json_encode(['success' => $result]);
	}

	// Môžeme doplniť aj metódy upload(), rename(), mkdir() atď.
}

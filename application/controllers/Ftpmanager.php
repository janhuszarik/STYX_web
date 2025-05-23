<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftpmanager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ftpmanager_model');
	}

	public function index()
	{
		$path = $this->input->get('path') ?? '';
		$data['current_path'] = $path;
		$data['files'] = $this->Ftpmanager_model->connect_to_ftp($path);

		$this->load->view('admin/layout/normal', [
			'title' => 'FTP Manager',
			'page' => 'admin/settings/ftpmanager_view',
			'files' => $data['files'],
			'current_path' => $data['current_path'],
		]);
	}
	public function ajax_list()
	{
		$path = $this->input->post('path') ?? '';
		$data = $this->Ftpmanager_model->connect_to_ftp($path);
		echo json_encode($data);
	}

}

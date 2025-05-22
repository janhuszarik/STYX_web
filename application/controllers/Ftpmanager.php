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
		$data['title'] = 'FTP Manager';
		$data['page'] = 'admin/settings/ftpmanager_view';
		$data['files'] = $this->Ftpmanager_model->connect_to_ftp();

		$this->load->view('admin/layout/normal', $data);
	}




}

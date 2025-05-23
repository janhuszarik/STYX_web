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

		$data['title'] = 'FTP Manager';
		$data['page'] = 'admin/settings/ftpmanager_view';
		$data['current_path'] = $path;
		$data['files'] = $this->Ftpmanager_model->connect_to_ftp($path);

		$this->load->view('admin/layout/normal', $data);
	}

	public function download()
	{
		$path = $this->input->get('path');
		if (!$path || !preg_match('/^[a-zA-Z0-9_\-\/\.]+$/', $path)) {
			show_error('Neplatná cesta.');
		}

		$filename = basename($path);
		$remote_url = 'https://styx.styxnatur.at/' . $path;

		$context = stream_context_create([
			"http" => [
				"follow_location" => true,
				"timeout" => 30
			]
		]);

		$data = @file_get_contents($remote_url, false, $context);
		if ($data === false) {
			show_error('Nepodarilo sa načítať súbor z URL.');
		}

		// MIME typ podľa prípony, fallback
		$extension = strtolower(pathinfo($remote_url, PATHINFO_EXTENSION));
		$mime_types = [
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'webp' => 'image/webp',
			'pdf' => 'application/pdf',
			'mp4' => 'video/mp4',
			'zip' => 'application/zip',
			// doplniť podľa potreby
		];
		$mime = $mime_types[$extension] ?? 'application/octet-stream';

		$this->output
			->set_content_type($mime)
			->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
			->set_output($data);
	}
	public function delete()
	{
		$path = $this->input->get('path');
		$result = $this->Ftpmanager_model->delete($path);

		if (is_array($result) && isset($result['__error'])) {
			$this->session->set_flashdata('error', $result['__error']);
		} else {
			$this->session->set_flashdata('success', 'Súbor bol vymazaný.');
		}

		$parent = dirname($path);
		redirect('admin/ftpmanager?path=' . urlencode($parent));
	}


	public function create_folder()
	{
		$name = $this->input->post('folder_name');
		$path = $this->input->post('current_path');
		$full_path = trim($path, '/') . '/' . trim($name, '/');

		$result = $this->Ftpmanager_model->create_dir($full_path);
		if (isset($result['__error'])) {
			$this->session->set_flashdata('error', $result['__error']);
		} else {
			$this->session->set_flashdata('success', 'Adresár bol vytvorený.');
		}
		redirect('admin/ftpmanager?path=' . urlencode($path));
	}
	public function move_file(){
	$from = $this->input->post('from');
	$to = $this->input->post('to');

	$result = $this->Ftpmanager_model->move($from, $to);
	if (isset($result['__error'])) {
		$this->session->set_flashdata('error', $result['__error']);
	} else {
		$this->session->set_flashdata('success', 'Súbor bol presunutý.');
	}
	redirect('admin/ftpmanager?path=' . urlencode(dirname($to)));
}





}

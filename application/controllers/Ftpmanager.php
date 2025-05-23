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




}

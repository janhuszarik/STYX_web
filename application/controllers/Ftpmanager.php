<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Ftpmanager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ftpmanager_model');
	}

	// Ftpmanager.php

	public function index()
	{
		$path = $this->input->get('path') ?? '';

		$data['title'] = 'FTP-Manager';
		$data['page'] = 'admin/settings/ftpmanager_view';
		$data['current_path'] = $path;
		$data['files'] = [];

		$this->load->view('admin/layout/normal', $data);
	}

	public function download()
	{
		$path = $this->input->get('path');
		if (!$path || !preg_match('/^[a-zA-Z0-9_\-\/\.]+$/', $path)) {
			show_error('Ungültiger Pfad.');
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
			show_error('Datei konnte nicht von der URL geladen werden.');
		}

		// MIME-Typ basierend auf der Erweiterung, Fallback
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
			// nach Bedarf ergänzen
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
			$this->session->set_flashdata('success', 'Datei wurde gelöscht.');
		}

		$parent = dirname($path);
		redirect('admin/ftpmanager?path=' . urlencode($parent));
	}

	public function create_folder()
	{
		$name = trim($this->input->post('folder_name'));
		$path = trim($this->input->post('current_path'), '/');
		$full_path = ($path ? $path . '/' : '') . $name;

		if ($name === '') {
			$this->session->set_flashdata('error', 'Der Ordnername darf nicht leer sein.');
			redirect('admin/ftpmanager?path=' . urlencode($path));
			return;
		}

		$result = $this->Ftpmanager_model->create_dir($full_path);
		if (isset($result['__error'])) {
			$this->session->set_flashdata('error', $result['__error']);
		} else {
			$this->session->set_flashdata('success', 'Ordner wurde erfolgreich erstellt.');
		}

		redirect('admin/ftpmanager?path=' . urlencode($path));
	}



	public function move_file()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$result = $this->Ftpmanager_model->move($from, $to);
		if (isset($result['__error'])) {
			$this->session->set_flashdata('error', $result['__error']);
		} else {
			$this->session->set_flashdata('success', 'Datei wurde verschoben.');
		}
		redirect('admin/ftpmanager?path=' . urlencode(dirname($to)));
	}
	public function upload()
	{
		$current_path = $this->input->get_post('path') ?? '';
		$current_path = trim($current_path, '/');

		if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
			$tmp_name = $_FILES['image']['tmp_name'];
			$filename = basename($_FILES['image']['name']);
			$remote_path = ($current_path ? $current_path . '/' : '') . $filename;

			// ✅ Erlaubte Dateiendungen
			$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

			if (!in_array($ext, $allowed_extensions)) {
				$this->session->set_flashdata('error', 'Nicht erlaubter Dateityp. Erlaubt sind: ' . implode(', ', $allowed_extensions));
				redirect('admin/ftpmanager?path=' . urlencode($current_path));
				return;
			}

			$result = $this->Ftpmanager_model->upload_file($tmp_name, $remote_path);

			if (isset($result['__error'])) {
				$this->session->set_flashdata('error', $result['__error']);
			} else {
				$this->session->set_flashdata('success', 'Datei wurde erfolgreich hochgeladen.');
			}
		} else {
			$this->session->set_flashdata('error', 'Keine Datei ausgewählt oder ein Fehler ist beim Hochladen aufgetreten.');
		}

		redirect('admin/ftpmanager?path=' . urlencode($current_path));
	}
	public function get_article_images()
	{
		$this->load->library('ftp');
		$config = [
			'hostname' => 'ftp.styxnatur.at',
			'username' => 'testujem@styxnatur.at',
			'password' => '***',
			'port'     => 21,
			'passive'  => TRUE,
			'debug'    => FALSE,
		];
		$this->ftp->connect($config);
		$list = $this->ftp->list_files('/articles');
		$this->ftp->close();

		header('Content-Type: application/json');
		echo json_encode($list);
	}
	public function modal()
	{
		$this->load->helper('directory');

		$path = './uploads/articles/'; // ✅ správna cesta podľa tvojho projektu
		$files = directory_map($path);

		$data['images'] = [];

		if (!empty($files)) {
			foreach ($files as $file) {
				if (is_string($file) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
					$data['images'][] = [
						'url' => base_url('uploads/articles/' . $file),
						'path' => 'uploads/articles/' . $file,
					];
				}
			}
		}

		$this->load->view('admin/settings/ftp_modal', $data);
	}



	public function browser()
	{
		$data['start_path'] = './uploads/articles/';
		$this->load->view('admin/ftp_browser', $data);
	}

	public function load_folder()
	{
		$folder = $this->input->post('folder') ?? '';
		$folder = trim($folder, '/');

		// Získame zoznam súborov a priečinkov z FTP
		$files = $this->Ftpmanager_model->connect_to_ftp($folder);

		if (isset($files['__error'])) {
			header('Content-Type: application/json');
			echo json_encode(['error' => $files['__error']]);
			return;
		}

		$list = [];
		foreach ($files as $file) {
			$full_path = $file['path'];
			$url = null;
			if ($file['type'] === 'file') {
				$url = 'https://styx.styxnatur.at/' . $full_path;
			}
			$list[] = [
				'name' => $file['name'],
				'type' => $file['type'],
				'url' => $url,
				'path' => $full_path,
				'size' => $file['size'] // Veľkosť je už zahrnutá z modelu
			];
		}

		header('Content-Type: application/json');
		echo json_encode($list);
	}






}

<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

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

		$data['title'] = 'FTP-Manager';
		$data['page'] = 'admin/settings/ftpmanager_view';
		$data['current_path'] = $path;
		$data['files'] = $this->Ftpmanager_model->connect_to_ftp($path);

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
			$this->session->set_flashdata('error', 'Názov priečinka nemôže byť prázdny.');
			redirect('admin/ftpmanager?path=' . urlencode($path));
			return;
		}

		$result = $this->Ftpmanager_model->create_dir($full_path);
		if (isset($result['__error'])) {
			$this->session->set_flashdata('error', $result['__error']);
		} else {
			$this->session->set_flashdata('success', 'Priečinok bol vytvorený.');
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

			// ✅ Povolené prípony
			$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

			if (!in_array($ext, $allowed_extensions)) {
				$this->session->set_flashdata('error', 'Nepovolený typ súboru. Povolené sú: ' . implode(', ', $allowed_extensions));
				redirect('admin/ftpmanager?path=' . urlencode($current_path));
				return;
			}

			$result = $this->Ftpmanager_model->upload_file($tmp_name, $remote_path);

			if (isset($result['__error'])) {
				$this->session->set_flashdata('error', $result['__error']);
			} else {
				$this->session->set_flashdata('success', 'Súbor bol úspešne nahratý.');
			}
		} else {
			$this->session->set_flashdata('error', 'Nebolo vybraté žiadne súbor alebo nastala chyba pri nahrávaní.');
		}

		redirect('admin/ftpmanager?path=' . urlencode($current_path));
	}


}

<?php
// application/controllers/admin/Shopfind.php

defined('BASEPATH') or exit('No direct script access allowed');

class Shopfind extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Shopfind_model');
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation', 'upload']);
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	public function shopfindSave()
	{
		$segment2 = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$post = $this->input->post();

		// Nastavenie pravidiel validácie
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('address', 'Adresse', 'required|trim');
		$this->form_validation->set_rules('zip_code', 'PLZ', 'required|trim');
		$this->form_validation->set_rules('city', 'Stadt', 'required|trim');
		$this->form_validation->set_rules('email', 'E-Mail', 'valid_email|trim');
		$this->form_validation->set_rules('latitude', 'Latitude', 'numeric|trim');
		$this->form_validation->set_rules('longitude', 'Longitude', 'numeric|trim');

		if (!empty($post)) {
			if ($this->form_validation->run()) {
				// Spracovanie nahrávania loga
				$logo_path = '';
				if (!empty($_FILES['logo']['name'])) {
					$logo_path = $this->upload_logo();
					if (!$logo_path) {
						$this->session->set_flashdata('error', 'Fehler beim Hochladen des Logos.');
						$data['edit'] = (object)$post;
						$data['location'] = (object)$post;
						$data['title'] = !empty($post['id']) ? 'Standort bearbeiten' : 'Standort hinzufügen';
						$data['page'] = 'admin/settings/shopfind_form';
						$this->load->view('admin/layout/normal', $data);
						return;
					}
				}

				// Príprava dát pre uloženie
				$data = [
					'id' => $post['id'] ?? null,
					'name' => $post['name'],
					'contact_person' => $post['contact_person'] ?? '',
					'address' => $post['address'],
					'zip_code' => $post['zip_code'],
					'city' => $post['city'],
					'country' => $post['country'] ?? 'Österreich',
					'email' => $post['email'] ?? '',
					'phone' => $post['phone'] ?? '',
					'website' => $post['website'] ?? '',
					'opening_hours' => isset($post['opening_hours']) && is_array($post['opening_hours']) ? json_encode($post['opening_hours']) : '',
					'latitude' => $post['latitude'] ?? null,
					'longitude' => $post['longitude'] ?? null,
					'active' => isset($post['active']) ? 1 : 0,
					'logo' => $logo_path ?: null,
				];

				// Uloženie do databázy cez model
				if ($this->Shopfind_model->saveLocation($data)) {
					$this->session->set_flashdata('success', 'Standort erfolgreich ' . (!empty($post['id']) ? 'bearbeitet' : 'hinzugefügt') . '.');
					redirect(BASE_URL . 'admin/shopfind');
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['edit'] = (object)$post;
				}
			} else {
				$this->session->set_flashdata('error', validation_errors());
				$data['edit'] = (object)$post;
			}
		}

		if ($segment2 === 'add' || ($segment2 === 'edit' && is_numeric($id))) {
			$data['location'] = $segment2 === 'edit' ? $this->Shopfind_model->getLocation($id) : null;
			$data['title'] = $segment2 === 'edit' ? 'Standort bearbeiten' : 'Standort hinzufügen';
			$data['page'] = 'admin/settings/shopfind_form';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Shopfind_model->deleteLocation($id)) {
				$this->session->set_flashdata('success', 'Standort erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/shopfind');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		$data['locations'] = $this->Shopfind_model->getAllLocations();
		$data['title'] = 'Shopfinder';
		$data['page'] = 'admin/settings/shopfind';
		$this->load->view('admin/layout/normal', $data);
	}

	private function upload_logo()
	{
		$config['upload_path'] = './uploads/shopfind/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'logo_' . time();

		$this->upload->initialize($config);

		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, true);
		}

		if ($this->upload->do_upload('logo')) {
			$upload_data = $this->upload->data();
			return 'shopfind/' . $upload_data['file_name'];
		}

		return false;
	}
}

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
		$this->load->library('session');
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	public function shopfindSave()
	{
		$segment2 = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$post = $this->input->post();

		if (!empty($post)) {
			if (!empty($post['id'])) {
				if ($this->Shopfind_model->saveLocation($post)) {
					$this->session->set_flashdata('success', 'Standort erfolgreich bearbeitet.');
					redirect(BASE_URL . 'admin/shopfind');
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Shopfind_model->saveLocation($post)) {
					$this->session->set_flashdata('success', 'Standort erfolgreich hinzugefügt.');
					redirect(BASE_URL . 'admin/shopfind');
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['edit'] = (object)$post;
				}
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
		$data['location'] = $this->Shopfind_model->getLocation($id);
		$data['title'] = 'Shopfinder';
		$data['page'] = 'admin/settings/shopfind';
		$this->load->view('admin/layout/normal', $data);
	}
}


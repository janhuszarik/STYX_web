<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Gallery extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model');

		if (!$this->ion_auth->is_admin()) {
			$this->session->set_flashdata('error', 'Zugriff verweigert.');
			redirect(BASE_URL);
		}
	}

	function galleryCategorySave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment3 = $this->uri->segment(3);
		$search = $this->input->get('search');

		// 🟢 SPRACOVANIE POST (pridanie alebo úprava)
		if (!empty($post)) {
			if ($this->Gallery_model->saveCategory($post)) {
				$this->session->set_flashdata('success', isset($post['id']) ? 'Kategorie erfolgreich aktualisiert.' : 'Kategorie erfolgreich hinzugefügt.');
				redirect(BASE_URL . 'admin/galleryCategory');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Speichern.');
				$data['category'] = (object)$post; // Predvyplnenie formulára pri chybe
			}
		}

		// 🟢 MAZANIE
		if ($segment3 == 'delete' && is_numeric($id)) {
			if ($this->Gallery_model->deleteCategory($id)) {
				$this->session->set_flashdata('success', 'Kategorie erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/galleryCategory');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		// 🟢 NAČÍTANIE NA ÚPRAVU ALEBO ZOBRAZENIE FORMULÁRA
		if ($segment3 == 'edit' && is_numeric($id)) {
			$data['category'] = $this->Gallery_model->getCategory($id);
			if (!$data['category']) {
				$this->session->set_flashdata('error', 'Kategorie nicht gefunden.');
				redirect(BASE_URL . 'admin/galleryCategory');
			}
			// Zobrazenie formulára pre editáciu
			$data['title'] = 'Kategorie bearbeiten';
			$data['page'] = 'admin/settings/galleryCategoriesForm';
			$this->load->view('admin/layout/normal', $data);
			return; // Ukončíme, aby sa nezobrazilo hlavné zobrazenie
		}

		// 🟢 NAČÍTANIE HLAVNÉHO ZOBRAZENIA (zoznam kategórií)
		$data['title'] = 'Galerie Kategorien';
		$data['categories'] = $this->Gallery_model->getAllCategories($search);
		$data['category'] = null; // Pre pridávanie nových kategórií
		$data['page'] = 'admin/settings/galleryCategories';

		$this->load->view('admin/layout/normal', $data);
	}

	function deleteCategory($id)
	{
		if ($this->Gallery_model->deleteCategory($id)) {
			$this->session->set_flashdata('success', 'Kategorie gelöscht.');
			redirect(BASE_URL . 'admin/galleryCategory');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Löschen.');
		}
	}

	function galleryCategoryForm($id = null)
	{
		$data['title'] = $id ? 'Kategorie bearbeiten' : 'Kategorie hinzufügen';
		$data['page'] = 'admin/settings/galleryCategoriesForm';

		if ($id) {
			$data['category'] = $this->Gallery_model->getCategory($id);
			if (!$data['category']) {
				$this->session->set_flashdata('error', 'Kategorie nicht gefunden.');
				redirect(BASE_URL . 'admin/galleryCategory');
			}
		} else {
			$data['category'] = null;
		}

		$this->load->view('admin/layout/normal', $data);
	}
}

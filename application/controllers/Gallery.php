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

		if (!empty($post)) {
			if ($this->Gallery_model->saveCategory($post)) {
				$this->session->set_flashdata('success', isset($post['id']) ? 'Kategorie erfolgreich aktualisiert.' : 'Kategorie erfolgreich hinzugefügt.');
				redirect(BASE_URL . 'admin/galleryCategory');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Speichern.');
				$data['category'] = (object)$post;
			}
		}

		if ($segment3 == 'delete' && is_numeric($id)) {
			if ($this->Gallery_model->deleteCategory($id)) {
				$this->session->set_flashdata('success', 'Kategorie erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/galleryCategory');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		if ($segment3 == 'edit' && is_numeric($id)) {
			$data['category'] = $this->Gallery_model->getCategory($id);
			if (!$data['category']) {
				$this->session->set_flashdata('error', 'Kategorie nicht gefunden.');
				redirect(BASE_URL . 'admin/galleryCategory');
			}
			$data['title'] = 'Kategorie bearbeiten';
			$data['page'] = 'admin/settings/galleryCategoriesForm';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		$data['title'] = 'Galerie Kategorien';
		$data['categories'] = $this->Gallery_model->getAllCategories($search);
		$data['category'] = null;
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

	function galleriesInCategory($category_id)
	{
		$data['category'] = $this->Gallery_model->getCategory($category_id);
		if (!$data['category']) {
			$this->session->set_flashdata('error', 'Kategorie nicht gefunden.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}

		$data['galleries'] = $this->Gallery_model->getGalleriesByCategoryId($category_id);
		$data['title'] = 'Galerien in Kategorie: ' . htmlspecialchars($data['category']->name);
		$data['page'] = 'admin/settings/galleriesInCategory';

		$this->load->view('admin/layout/normal', $data);
	}

	function galleryForm($category_id = null)
	{
		$data['category_id'] = $category_id;
		if ($category_id) {
			$data['category'] = $this->Gallery_model->getCategory($category_id);
			if (!$data['category']) {
				$this->session->set_flashdata('error', 'Kategorie nicht gefunden.');
				redirect(BASE_URL . 'admin/galleryCategory');
			}
		} else {
			$data['category'] = null;
		}

		$data['title'] = 'Galerie hinzufügen';
		$data['page'] = 'admin/settings/galleryForm';

		$this->load->view('admin/layout/normal', $data);
	}

	function saveGallery()
	{
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->Gallery_model->saveGallery($post)) {
				$this->session->set_flashdata('success', isset($post['id']) ? 'Galerie erfolgreich aktualisiert.' : 'Galerie erfolgreich hinzugefügt.');
				redirect(BASE_URL . 'admin/galleries_in_category/' . $post['category_id']);
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Speichern.');
				redirect(BASE_URL . 'admin/gallery/form/category/' . $post['category_id']);
			}
		} else {
			$this->session->set_flashdata('error', 'Keine Daten zum Speichern.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}
	}

	function imagesInGallery($gallery_id)
	{
		$data['gallery'] = $this->db->where('id', $gallery_id)->get('galleries')->row();
		if (!$data['gallery']) {
			$this->session->set_flashdata('error', 'Galerie nicht gefunden.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}

		$data['category'] = $this->Gallery_model->getCategory($data['gallery']->category_id);
		$data['images'] = $this->Gallery_model->getImagesByGalleryId($gallery_id);
		$data['title'] = 'Bilder in Galerie: ' . htmlspecialchars($data['gallery']->name);
		$data['page'] = 'admin/settings/imagesInGallery';

		$this->load->view('admin/layout/normal', $data);
	}

	function editGallery($id)
	{
		$data['gallery'] = $this->Gallery_model->getGallery($id);
		if (!$data['gallery']) {
			$this->session->set_flashdata('error', 'Galerie nicht gefunden.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}

		$data['category'] = $this->Gallery_model->getCategory($data['gallery']->category_id);
		$data['category_id'] = $data['gallery']->category_id;
		$data['title'] = 'Galerie bearbeiten';
		$data['page'] = 'admin/settings/galleryForm';

		$this->load->view('admin/layout/normal', $data);
	}

	function deleteGallery($id)
	{
		$gallery = $this->Gallery_model->getGallery($id);
		if (!$gallery) {
			$this->session->set_flashdata('error', 'Galerie nicht gefunden.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}

		if ($this->Gallery_model->deleteGallery($id)) {
			$this->session->set_flashdata('success', 'Galerie erfolgreich gelöscht.');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Löschen.');
		}
		redirect(BASE_URL . 'admin/galleries_in_category/' . $gallery->category_id);
	}
}

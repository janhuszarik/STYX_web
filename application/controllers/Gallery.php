<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Gallery extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model');
		$this->load->helper('App_helper');

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

		$category = $this->Gallery_model->getCategory($gallery->category_id);
		$category_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($category->name));
		$gallery_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($gallery->name));
		$gallery_path = './uploads/gallery/' . $category_name . '/' . $gallery_name . '/';

		if (is_dir($gallery_path)) {
			$this->deleteDirectory($gallery_path);
		}

		if ($this->Gallery_model->deleteGallery($id)) {
			$this->session->set_flashdata('success', 'Galerie erfolgreich gelöscht.');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Löschen.');
		}
		redirect(BASE_URL . 'admin/galleries_in_category/' . $gallery->category_id);
	}

	function imageForm($gallery_id)
	{
		$data['gallery'] = $this->Gallery_model->getGallery($gallery_id);
		if (!$data['gallery']) {
			$this->session->set_flashdata('error', 'Galerie nicht gefunden.');
			redirect(BASE_URL . 'admin/galleryCategory');
		}

		$data['category'] = $this->Gallery_model->getCategory($data['gallery']->category_id);
		$data['images'] = $this->Gallery_model->getImagesByGalleryId($gallery_id);
		$data['title'] = 'Bild hinzufügen zu Galerie: ' . htmlspecialchars($data['gallery']->name);
		$data['page'] = 'admin/settings/imageForm';

		$this->load->view('admin/layout/normal', $data);
	}

	function saveImage()
	{
		$gallery_id = $this->input->post('gallery_id');
		if (!$gallery_id) {
			echo json_encode(['success' => false, 'message' => 'Galerie nicht gefunden.']);
			return;
		}

		$gallery = $this->Gallery_model->getGallery($gallery_id);
		if (!$gallery) {
			echo json_encode(['success' => false, 'message' => 'Galerie nicht gefunden.']);
			return;
		}

		$category = $this->Gallery_model->getCategory($gallery->category_id);
		if (!$category) {
			echo json_encode(['success' => false, 'message' => 'Kategorie nicht gefunden.']);
			return;
		}

		$category_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($category->name));
		$gallery_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($gallery->name));
		$base_path = './uploads/gallery/' . $category_name . '/' . $gallery_name . '/';

		if (!is_dir($base_path)) {
			mkdir($base_path, 0755, TRUE);
		}

		$uploaded_files = [];
		$files = $_FILES['images'];
		$count = count($_FILES['images']['name']);

		for ($i = 0; $i < $count; $i++) {
			if (!empty($files['name'][$i])) {
				$image_number = $this->Gallery_model->getMaxImageNumber($gallery_id);
				$save_as_name = $gallery_name . '_' . $image_number;

				$_FILES['image'] = [
					'name' => $files['name'][$i],
					'type' => $files['type'][$i],
					'tmp_name' => $files['tmp_name'][$i],
					'error' => $files['error'][$i],
					'size' => $files['size'][$i]
				];

				$image_path = uploadImg('image', $base_path, $save_as_name, TRUE, FALSE);
				if ($image_path) {
					$extension = pathinfo($image_path, PATHINFO_EXTENSION);
					$basename = str_replace('.' . $extension, '', $image_path);
					$thumb_path = $basename . '_thumb.' . $extension;

					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_path;
					$config['new_image'] = $thumb_path;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 500;
					$config['height'] = 400;
					$this->image_lib->initialize($config);
					if (!$this->image_lib->resize()) {
						echo json_encode(['success' => false, 'message' => 'Fehler beim Erstellen des Thumbnails.']);
						return;
					}
					$this->image_lib->clear();

					$webp_path = $basename . '.webp';
					$thumb_webp_path = $basename . '_thumb.webp';
					$this->convertToWebp($image_path, $webp_path);
					$this->convertToWebp($thumb_path, $thumb_webp_path);

					$this->db->select_max('order_position');
					$this->db->where('gallery_id', $gallery_id);
					$result = $this->db->get('gallery_images')->row();
					$order_position = $result->order_position ? $result->order_position + 1 : 1;

					$this->Gallery_model->saveImage($gallery_id, $image_path, $order_position);
					$uploaded_files[] = ['path' => $image_path];
				} else {
					echo json_encode(['success' => false, 'message' => 'Fehler beim Hochladen des Bildes.']);
					return;
				}
			}
		}

		echo json_encode(['success' => true, 'files' => $uploaded_files]);
	}

	function deleteImage($id)
	{
		$image = $this->db->where('id', $id)->get('gallery_images')->row();
		if (!$image) {
			echo json_encode(['success' => false, 'message' => 'Bild nicht gefunden.']);
			return;
		}

		$gallery_id = $image->gallery_id;
		$gallery = $this->Gallery_model->getGallery($gallery_id);
		$category = $this->Gallery_model->getCategory($gallery->category_id);
		$category_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($category->name));
		$gallery_name = preg_replace('/[^a-zA-Z0-9-_]/', '_', strtolower($gallery->name));
		$base_path = './uploads/gallery/' . $category_name . '/' . $gallery_name . '/';

		$filename = basename($image->image_path);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$basename = str_replace('.' . $extension, '', $filename);
		$thumb_path = obrpridajthumb($image->image_path);
		$files_to_delete = [
			$image->image_path,
			$base_path . $basename . '.webp',
			$thumb_path,
			$base_path . $basename . '_thumb.webp'
		];

		foreach ($files_to_delete as $file) {
			if (file_exists($file)) {
				unlink($file);
			}
		}

		if ($this->Gallery_model->deleteImage($id)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen.']);
		}
	}

	function updateImageOrder()
	{
		$image_id = $this->input->post('image_id');
		$order_position = $this->input->post('order_position');

		if ($this->Gallery_model->updateImageOrder($image_id, $order_position)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Aktualisieren der Reihenfolge.']);
		}
	}

	private function convertToWebp($source, $destination)
	{
		$image = NULL;
		$extension = pathinfo($source, PATHINFO_EXTENSION);
		switch (strtolower($extension)) {
			case 'jpg':
			case 'jpeg':
				$image = imagecreatefromjpeg($source);
				break;
			case 'png':
				$image = imagecreatefrompng($source);
				break;
			case 'gif':
				$image = imagecreatefromgif($source);
				break;
		}

		if ($image) {
			imagewebp($image, $destination, 80);
			imagedestroy($image);
		}
	}

	private function deleteDirectory($dir)
	{
		if (!is_dir($dir)) {
			return;
		}
		$files = array_diff(scandir($dir), ['.', '..']);
		foreach ($files as $file) {
			$path = "$dir/$file";
			is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
		}
		rmdir($dir);
	}
}

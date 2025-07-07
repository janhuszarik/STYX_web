<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

/**
 * Class Admin
 * @property Admin_model|Admin_model $Admin_model
 * @property Mail_model|Mail_model $Mail_model
 */
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('app_model'));
		$this->load->model('Admin_model');
		$this->load->library('form_validation');

		if (!$this->ion_auth->is_admin()) {
			$this->session->set_flashdata('error', 'Dieser Weg führt nicht weiter!');
			redirect(BASE_URL);
		}
	}

	public function index()
	{
		$data['title'] = 'Admin - Dashboard';
		$data['page'] = 'admin/dashboard';

		$data['articleStats'] = $this->Admin_model->getArticleStats();
		$data['menuStats'] = $this->Admin_model->getMenuStats();
		$data['sliderStats'] = $this->Admin_model->getSliderStats();
		$data['newsStats'] = $this->Admin_model->getNewsStats();
		$data['productStats'] = $this->Admin_model->getBestProductStats();
		$data['articleCategoryStats'] = $this->Admin_model->getArticleCategoryStats();
		$data['galleryStats'] = $this->Admin_model->getGalleryStats();
		$data['calendar_events'] = array_map(function($n) {
			return [
				'id' => $n->id,
				'title' => $n->note,
				'start' => $n->date,
				'end' => $n->end_date ? date('Y-m-d', strtotime($n->end_date . ' +1 day')) : null,
				'raw_end' => $n->end_date,
				'color' => $n->color
			];
		}, $this->Admin_model->get_calendar_notes());

		$this->load->view('admin/layout/normal', $data);
	}

	public function save_calendar_note()
	{
		$post = json_decode(file_get_contents("php://input"), true);

		$this->db->insert('calendar_notes', [
			'note' => $post['note'],
			'date' => $post['date'],
			'end_date' => $post['end_date'] ?? null,
			'color' => $post['color'] ?? '#3788d8'
		]);

		$id = $this->db->insert_id();
		echo json_encode(['success' => true, 'id' => $id]);
	}

	public function update_calendar_note()
	{
		$post = json_decode(file_get_contents("php://input"), true);

		if (empty($post['id']) || empty($post['note'])) {
			echo json_encode(['success' => false, 'error' => 'Fehlende Daten']);
			return;
		}

		$this->db->where('id', $post['id']);
		$this->db->update('calendar_notes', [
			'note' => $post['note'],
			'date' => $post['start'],
			'end_date' => $post['end'],
			'color' => $post['color']
		]);

		echo json_encode(['success' => true]);
	}

	public function delete_calendar_note($id)
	{
		if (!is_numeric($id)) {
			echo json_encode(['success' => false, 'error' => 'Ungültige ID']);
			return;
		}

		if ($this->db->delete('calendar_notes', ['id' => $id])) {
			echo json_encode(['success' => true, 'id' => $id]);
		} else {
			echo json_encode(['success' => false, 'error' => 'Fehler beim Löschen']);
		}
	}

	public function menuSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment3 = $this->uri->segment(3);

		if (!empty($post)) {
			$post['active'] = isset($post['active']) ? $post['active'] : '0';
			$post['lang'] = isset($post['lang']) ? $post['lang'] : 'de';
			$post['base'] = isset($post['base']) ? $post['base'] : '0';

			// Clean URL if provided
			$existingUrl = trim($post['url']);
			$isExternal = (strpos($existingUrl, 'http://') === 0 || strpos($existingUrl, 'https://') === 0);

			if ($isExternal) {
				$post['url'] = $existingUrl;
			} else {
				// Ensure language prefix is added to the URL
				if (empty($existingUrl) || strpos($existingUrl, $post['lang'] . '/') !== 0) {
					$slugPart = !empty($existingUrl) ? $existingUrl : url_oprava($post['name']);
					$post['url'] = $post['lang'] . '/' . $slugPart;
				}

				// Ensure uniqueness if URL is generated
				$this->load->model('Admin_model');
				$uniqueUrl = $post['url'];
				$counter = 1;
				while ($this->Admin_model->urlExists($uniqueUrl, $post['id'] ?? null)) {
					$uniqueUrl = preg_replace('#/[^/]+$#', '/' . url_oprava($post['name']) . '-' . $counter, $post['url']);
					$counter++;
				}
				$post['url'] = $uniqueUrl;
			}

			if (!empty($id)) {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['menu'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['menu'] = (object)$post;
				}
			}
		}

		if ($segment3 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->menuDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
				redirect(BASE_URL . 'admin/menu/');
			} else {
				// Použi existujúcu chybovú hlášku z modelu, ak existuje
				if (!$this->session->flashdata('error')) {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
				}
				redirect(BASE_URL . 'admin/menu/');
			}
		}

		if ($segment3 == 'edit' || $segment3 == 'create') {
			$data['menu'] = $this->Admin_model->getMenu($id);
			$data['menuparent'] = $this->Admin_model->getMenu(false, true);
			$data['title'] = !empty($id) && isset($data['menu']->name)
				? 'Menüpunkt bearbeiten: ' . $data['menu']->name
				: 'Neues Menüelement erstellen';
			$data['page'] = 'admin/settings/menu_form';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		$data['menus'] = $this->Admin_model->getFullMenu();
		$data['title'] = 'Menüpunkte';
		$data['page'] = 'admin/settings/menu';
		$this->load->view('admin/layout/normal', $data);
	}

	function getMenuParentName($menus, $parentId)
	{
		foreach ($menus as $menu) {
			if ($menu->id == $parentId) {
				return $menu->name;
			}
		}
		return '';
	}

	public function sliderSave() {
		$post = $this->input->post(NULL, TRUE);
		$id = $post['id'] ?? $this->uri->segment(4);
		$segment3 = $this->uri->segment(3);

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->get_slider_image_by_id($id) : false;

			$image = $this->upload_image('image', 'uploads/sliders/');
			if (isset($image['error']) && $image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				$data['slider'] = (object)$post;
				$data['slider']->image = $old_image;
				$data['title'] = !empty($id) ? 'Slider bearbeiten' : 'Slider hinzufügen';
				$data['page'] = 'admin/settings/slider_form';
				$this->load->view('admin/layout/normal', $data);
				return;
			}

			if ($this->Admin_model->save_slider_full($post, $image, $id)) {
				if ($image && !isset($image['error']) && $old_image && file_exists(FCPATH . 'uploads/sliders/' . $old_image)) {
					unlink(FCPATH . 'uploads/sliders/' . $old_image);
				}
				$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
				redirect(BASE_URL . 'admin/slider');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
				$data['slider'] = (object)$post;
				$data['slider']->image = $old_image;
				$data['title'] = !empty($id) ? 'Slider bearbeiten' : 'Slider hinzufügen';
				$data['page'] = 'admin/settings/slider_form';
				$this->load->view('admin/layout/normal', $data);
				return;
			}
		}

		if ($segment3 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->delete_slider($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
			}
			redirect(BASE_URL . 'admin/slider');
		}

		if ($segment3 == 'edit' && is_numeric($id)) {
			$data['slider'] = $this->Admin_model->get_slider($id);
			if (!$data['slider']) {
				$this->session->set_flashdata('error', 'Slider nicht gefunden');
				redirect(BASE_URL . 'admin/slider');
			}
			$data['title'] = 'Slider bearbeiten';
			$data['page'] = 'admin/settings/slider_form';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		if ($segment3 == 'add') {
			$data['slider'] = new stdClass();
			$data['title'] = 'Slider hinzufügen';
			$data['page'] = 'admin/settings/slider_form';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		$data['sliders'] = $this->Admin_model->get_all_sliders();
		$data['title'] = 'Slider';
		$data['page'] = 'admin/settings/sliders';
		$this->load->view('admin/layout/normal', $data);
	}

	private function saveSlider($post, $id = null) {
		$image_upload_data = $this->upload_image('image');
		$thumb_upload_data = $this->upload_image('thumb');

		if ((isset($image_upload_data['error']) && $image_upload_data['error'] !== "<p>upload_no_file_selected</p>") ||
			(isset($thumb_upload_data['error']) && $thumb_upload_data['error'] !== "<p>upload_no_file_selected</p>")) {
			$this->session->set_flashdata('error', 'Bild-Upload fehlgeschlagen. Bitte versuchen Sie es erneut.');
			return false;
		} else {
			if (isset($image_upload_data['file_name'])) {
				$post['image'] = $image_upload_data['file_name'];
			}
			if (isset($thumb_upload_data['file_name'])) {
				$post['thumb'] = $thumb_upload_data['file_name'];
			}

			$result = $this->Admin_model->save_slider($post, $id);

			if (!$result) {
				$this->session->set_flashdata('error', 'Datenbankspeicherung fehlgeschlagen. Bitte versuchen Sie es erneut.');
			}

			return $result;
		}
	}

	private function upload_image($field_name, $path = 'uploads/sliders/') {
		if (empty($_FILES[$field_name]['name'])) {
			return false;
		}

		$upload_path = FCPATH . $path;

		if (!is_dir($upload_path)) {
			if (!mkdir($upload_path, 0777, true)) {
				return ['error' => 'Verzeichnis konnte nicht erstellt werden: ' . $upload_path];
			}
		}

		if (!is_writable($upload_path)) {
			return ['error' => 'Upload-Verzeichnis ist nicht beschreibbar: ' . $upload_path];
		}

		$ext = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);
		$timestamp = time();
		$new_name = 'slider_' . $timestamp . '.' . $ext;

		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['file_name']     = $new_name;
		$config['overwrite']     = FALSE;
		$config['encrypt_name']  = FALSE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload($field_name)) {
			$error = $this->upload->display_errors();
			return ['error' => $error];
		}

		return $this->upload->data();
	}

	private function uploadImageToPath($field_name, $path = 'uploads/news/') {
		$upload_path = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $path);

		if (!is_dir($upload_path)) {
			if (!mkdir($upload_path, 0777, true)) {
				return array('error' => 'Verzeichnis konnte nicht erstellt werden: ' . $upload_path);
			} else {
				chmod($upload_path, 0777);
			}
		}

		if (!is_writable($upload_path)) {
			return array('error' => 'Upload-Pfad ist nicht beschreibbar: ' . $upload_path);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload($field_name)) {
			$error = $this->upload->display_errors();
			return array('error' => $error);
		} else {
			$data = $this->upload->data();
			return array('url' => base_url($path . $data['file_name']));
		}
	}

	public function uploadImage() {
		$response = $this->uploadImageToPath('file', 'uploads/news/');
		echo json_encode($response);
	}

	public function newsSave() {
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment3 = $this->uri->segment(3);

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->getNews($id)->image : false;
			$image = $this->upload_image('image', 'uploads/news/');
			if (isset($image['error']) && $image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				$data['news'] = (object)$post;
				$data['title'] = !empty($id) ? 'News bearbeiten' : 'News hinzufügen';
				$data['page'] = 'admin/settings/news_form';
				$this->load->view('admin/layout/normal', $data);
				return;
			}

			if (!empty($id)) {
				if ($this->Admin_model->newsSave($post, $image, $old_image)) {
					if ($image && !isset($image['error']) && $old_image && file_exists(FCPATH . 'uploads/news/' . $old_image)) {
						unlink(FCPATH . 'Uploads/news/' . $old_image);
					}
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/news');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['news'] = (object)$post;
					$data['title'] = 'News bearbeiten';
					$data['page'] = 'admin/settings/news_form';
					$this->load->view('admin/layout/normal', $data);
				}
			} else {
				if ($this->Admin_model->newsSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/news');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['news'] = (object)$post;
					$data['title'] = 'News hinzufügen';
					$data['page'] = 'admin/settings/news_form';
					$this->load->view('admin/layout/normal', $data);
				}
			}
		}

		if ($segment3 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->newsDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
				redirect(BASE_URL . 'admin/news');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
				redirect(BASE_URL . 'admin/news');
			}
		}

		if ($segment3 == 'edit' && is_numeric($id)) {
			$data['news'] = $this->Admin_model->getNews($id);
			if (!$data['news']) {
				$this->session->set_flashdata('error', 'News nicht gefunden');
				redirect(BASE_URL . 'admin/news');
			}
			$data['title'] = 'News bearbeiten';
			$data['page'] = 'admin/settings/news_form';
			$this->load->view('admin/layout/normal', $data);
		} elseif ($segment3 == 'add') {
			$data['news'] = new stdClass();
			$data['title'] = 'News hinzufügen';
			$data['page'] = 'admin/settings/news_form';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['newss'] = $this->Admin_model->getNews();
			$data['title'] = 'Nachrichten';
			$data['page'] = 'admin/settings/news';
			$this->load->view('admin/layout/normal', $data);
		}
	}

	public function bestProductSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment2 = $this->uri->segment(3);

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->getProduct($id)->image : false;
			$image = $this->upload_image('image', 'uploads/product/');

			if (isset($image['error']) && $image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				redirect('admin/bestProduct/edit/' . $id);
				return;
			}

			if (!empty($id)) {
				if ($this->Admin_model->bestProductSave($post, $image, $old_image)) {
					if ($image && !isset($image['error']) && $old_image && file_exists(FCPATH . 'uploads/product/' . $old_image)) {
						unlink(FCPATH . 'uploads/product/' . $old_image);
					}
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect('admin/bestProduct');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					redirect('admin/bestProduct/edit/' . $id);
				}
			} else {
				if ($this->Admin_model->bestProductSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect('admin/bestProduct');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					redirect('admin/bestProduct/create');
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->bestProductDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
			}
			redirect('admin/bestProduct');
		}

		if (empty($segment2)) {
			$data['products'] = $this->Admin_model->getProduct();
			$data['title'] = 'Beliebte Produkte';
			$data['page'] = 'admin/settings/bestProduct_list';
			$this->load->view('admin/layout/normal', $data);
			return;
		}

		if ($segment2 == 'create' || ($segment2 == 'edit' && is_numeric($id))) {
			$data['product'] = $this->Admin_model->getProduct($id);
			$data['title'] = $segment2 == 'create' ? 'Neues Produkt erstellen' : 'Produkt bearbeiten';
			$data['page'] = 'admin/settings/bestProduct_form';
			$this->load->view('admin/layout/normal', $data);
		}
	}

	public function dokumentation()
	{
		$data['title'] = 'Dokumentation';
		$data['page']  = 'admin/settings/documentation';
		$this->load->view('admin/layout/normal', $data);
	}
}

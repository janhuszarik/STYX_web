<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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

		// Získanie štatistík
		$data['articleStats'] = $this->Admin_model->getArticleStats();
		$data['menuStats'] = $this->Admin_model->getMenuStats();
		$data['sliderStats'] = $this->Admin_model->getSliderStats();
		$data['newsStats'] = $this->Admin_model->getNewsStats();
		$data['productStats'] = $this->Admin_model->getBestProductStats();
		$data['articleCategoryStats'] = $this->Admin_model->getArticleCategoryStats();
		$data['galleryStats'] = $this->Admin_model->getGalleryStats();
		// Získanie udalostí do kalendára
		$data['calendar_events'] = array_map(function($n) {
			return [
				'id' => $n->id,
				'title' => $n->note,
				'start' => $n->date,
				'end' => $n->end_date ? date('Y-m-d', strtotime($n->end_date . ' +1 day')) : null, // pre kalendár
				'raw_end' => $n->end_date, // pre modálne okno
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
			echo json_encode(['success' => false, 'error' => 'Chýbajúce údaje']);
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
			echo json_encode(['success' => false, 'error' => 'Nesprávne ID']);
			return;
		}

		if ($this->db->delete('calendar_notes', ['id' => $id])) {
			echo json_encode(['success' => true, 'id' => $id]);
		} else {
			echo json_encode(['success' => false, 'error' => 'Chyba pri mazaní']);
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

			if (!empty($id)) {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment3 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->menuDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
				redirect(BASE_URL . 'admin/menu/');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
			}
		}

		$data['menus'] = $this->Admin_model->getFullMenu();
		$data['menu'] = $this->Admin_model->getMenu($id);
		$data['menuparent'] = $this->Admin_model->getMenu(false, true);
		$data['title'] = isset($menu->name) ? 'Menüpunkt bearbeiten: ' . $menu->name : 'Menüpunkte';
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

	function sliderSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(3);
		$segment2 = $this->uri->segment(2);

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->get_slider_image_by_id($id) : false;
			$image = uploadImg('image', 'uploads/sliders', 'slider_' . time(), true);

			if (isset($image['error']) && !$image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				$data['slider'] = (array)$post;
				$data['sliders'] = $this->Admin_model->get_all_sliders();
				$data['title'] = 'Slider';
				$data['page'] = 'admin/settings/sliders';
				$this->load->view('admin/layout/normal', $data);
				return;
			}

			if ($this->Admin_model->save_slider_full($post, $image, $old_image, $id)) {
				if ($image && !isset($image['error']) && $old_image && file_exists(FCPATH . 'uploads/sliders/' . $old_image)) {
					unlink(FCPATH . 'uploads/sliders/' . $old_image);
				}
				$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
				redirect(BASE_URL . 'admin/slider');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
				$data['slider'] = (array)$post;
			}
		}

		if ($segment2 == 'delete_slider' && is_numeric($id)) {
			if ($this->Admin_model->delete_slider($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen');
			}
			redirect(BASE_URL . 'admin/slider');
		}

		$data['sliders'] = $this->Admin_model->get_all_sliders();
		$data['slider'] = !empty($id) ? $this->Admin_model->get_slider($id) : array();
		$data['title'] = 'Slider';
		$data['page'] = 'admin/settings/sliders';
		$this->load->view('admin/layout/normal', $data);
	}



	private function saveSlider($post, $id = null) {
		log_message('debug', 'saveSlider post data before upload: ' . print_r($post, true));

		$image_upload_data = $this->upload_image('image');
		$thumb_upload_data = $this->upload_image('thumb');

		log_message('debug', 'Image upload data: ' . print_r($image_upload_data, true));
		log_message('debug', 'Thumb upload data: ' . print_r($thumb_upload_data, true));

		if ((isset($image_upload_data['error']) && $image_upload_data['error'] !== "<p>upload_no_file_selected</p>") ||
			(isset($thumb_upload_data['error']) && $thumb_upload_data['error'] !== "<p>upload_no_file_selected</p>")) {

			log_message('error', 'Image upload error: ' . print_r($image_upload_data['error'], true));
			log_message('error', 'Thumb upload error: ' . print_r($thumb_upload_data['error'], true));

			$this->session->set_flashdata('error', 'Bild-Upload fehlgeschlagen. Bitte versuchen Sie es erneut.');
			return false;
		} else {
			if (isset($image_upload_data['file_name'])) {
				$post['image'] = $image_upload_data['file_name'];
			}
			if (isset($thumb_upload_data['file_name'])) {
				$post['thumb'] = $thumb_upload_data['file_name'];
			}

			log_message('debug', 'saveSlider post data after upload: ' . print_r($post, true));

			$result = $this->Admin_model->save_slider($post, $id);

			log_message('debug', 'save_slider result: ' . $result);

			if (!$result) {
				log_message('error', 'Datenbankspeicherung für Slider fehlgeschlagen: ' . print_r($post, true));
				$this->session->set_flashdata('error', 'Datenbankspeicherung fehlgeschlagen. Bitte versuchen Sie es erneut.');
			}

			return $result;
		}
	}

	private function upload_image($field_name, $path = 'uploads/sliders/') {
		log_message('debug', 'FCPATH value: ' . FCPATH);
		log_message('debug', 'Current working directory: ' . getcwd());

		$upload_path = FCPATH . $path;
		log_message('debug', 'Upload path: ' . $upload_path);

		if (!is_dir($upload_path)) {
			log_message('debug', 'Verzeichnis existiert nicht: ' . $upload_path);
			if (!mkdir($upload_path, 0777, true)) {
				log_message('error', 'Fehler beim Erstellen des Verzeichnisses: ' . $upload_path);
				return array('error' => '<p>Fehler beim Erstellen des Verzeichnisses: ' . $upload_path . '</p>');
			} else {
				log_message('debug', 'Verzeichnis erstellt: ' . $upload_path);
			}
		} else {
			log_message('debug', 'Verzeichnis existiert bereits: ' . $upload_path);
		}

		if (!is_writable($upload_path)) {
			log_message('error', 'Upload-Pfad ist nicht beschreibbar: ' . $upload_path);
			return array('error' => '<p>Upload-Pfad ist nicht beschreibbar: ' . $upload_path . '</p>');
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		log_message('debug', 'Upload config: ' . print_r($config, true));

		if (!$this->upload->do_upload($field_name)) {
			$error = $this->upload->display_errors();
			log_message('error', 'Upload-Fehler für ' . $field_name . ': ' . $error);
			return array('error' => $error);
		} else {
			return $this->upload->data();
		}
	}

	private function uploadImageToPath($field_name, $path = 'uploads/news/') {
		log_message('debug', 'FCPATH value: ' . FCPATH);
		log_message('debug', 'Current working directory: ' . getcwd());

		$upload_path = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $path);
		log_message('debug', 'Upload path: ' . $upload_path);

		if (!is_dir($upload_path)) {
			log_message('debug', 'Verzeichnis existiert nicht: ' . $upload_path);
			if (!mkdir($upload_path, 0777, true)) {
				log_message('error', 'Fehler beim Erstellen des Verzeichnisses: ' . $upload_path);
				return array('error' => 'Fehler beim Erstellen des Verzeichnisses: ' . $upload_path);
			} else {
				chmod($upload_path, 0777);
				log_message('debug', 'Verzeichnis erstellt: ' . $upload_path);
			}
		} else {
			log_message('debug', 'Verzeichnis existiert bereits: ' . $upload_path);
		}

		if (!is_writable($upload_path)) {
			log_message('error', 'Upload-Pfad ist nicht beschreibbar: ' . $upload_path);
			return array('error' => 'Upload-Pfad ist nicht beschreibbar: ' . $upload_path);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		log_message('debug', 'Upload config: ' . print_r($config, true));

		if (!$this->upload->do_upload($field_name)) {
			$error = $this->upload->display_errors();
			log_message('error', 'Upload-Fehler für ' . $field_name . ': ' . $error);
			return array('error' => $error);
		} else {
			$data = $this->upload->data();
			return array('url' => base_url($path . $data['file_name']));
		}
	}

	public function uploadImage() {
		$response = $this->uploadImageToPath('file', 'uploads/news/');
		log_message('debug', 'Upload response: ' . json_encode($response));
		echo json_encode($response);
	}

	function newsSave() {
		$post = $this->input->post();
		$id = $this->uri->segment('4');
		$segment2 = $this->uri->segment('3');

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->getNews($id)->image : false;
			$image = $this->upload_image('image', 'uploads/news/');
			if (isset($image['error']) && !$image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				$data['edit'] = (object)$post;
				$this->load->view('admin/layout/normal', $data);
				return;
			}

			if (!empty($id)) {
				if ($this->Admin_model->newsSave($post, $image, $old_image)) {
					if ($image && !isset($image['error'])) {
						if ($old_image && file_exists(FCPATH . 'uploads/news/' . $old_image)) {
							unlink(FCPATH . 'uploads/news/' . $old_image);
						}
					}
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/news/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->newsSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/news');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->newsDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
				redirect(BASE_URL . 'admin/news');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
			}
		}

		if (empty($id)) {
			$data['newss'] = $this->Admin_model->getNews();
			$data['news'] = $this->Admin_model->getNews($id);
			$data['title'] = 'Nachrichten';
			$data['page'] = 'admin/settings/news';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['newss'] = $this->Admin_model->getNews();
			$data['news'] = $this->Admin_model->getNews($id);
			$data['title'] = 'Nachrichten';
			$data['page'] = 'admin/settings/news';
			$this->load->view('admin/layout/normal', $data);
		}
	}

	function bestProductSave() {
		$post = $this->input->post();
		$id = $this->uri->segment('4');
		$segment2 = $this->uri->segment('3');

		if (!empty($post)) {
			$old_image = !empty($id) ? $this->Admin_model->getNews($id)->image : false;
			$image = $this->upload_image('image', 'uploads/product/');
			if (isset($image['error']) && !$image['error']) {
				$this->session->set_flashdata('error', $image['error']);
				$data['edit'] = (object)$post;
				$this->load->view('admin/layout/normal', $data);
				return;
			}

			if (!empty($id)) {
				if ($this->Admin_model->bestProductSave($post, $image, $old_image)) {
					if ($image && !isset($image['error'])) {
						if ($old_image && file_exists(FCPATH . 'uploads/product/' . $old_image)) {
							unlink(FCPATH . 'uploads/product/' . $old_image);
						}
					}
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/bestProduct/');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->bestProductSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'Alle Daten wurden gespeichert');
					redirect(BASE_URL . 'admin/bestProduct');
				} else {
					$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->bestProductDelete($id)) {
				$this->session->set_flashdata('message', 'Die Daten wurden unwiderruflich gelöscht');
				redirect(BASE_URL . 'admin/bestProduct');
			} else {
				$this->session->set_flashdata('error', 'Fehler, versuchen Sie es noch einmal');
			}
		}

		if (empty($id)) {
			$data['products'] = $this->Admin_model->getProduct();
			$data['product'] = $this->Admin_model->getProduct($id);
			$data['title'] = 'Beliebte Produkte';
			$data['page'] = 'admin/settings/bestProduct';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['products'] = $this->Admin_model->getProduct();
			$data['product'] = $this->Admin_model->getProduct($id);
			$data['title'] = 'Beliebte Produkte';
			$data['page'] = 'admin/settings/bestProduct';
			$this->load->view('admin/layout/normal', $data);
		}
	}





}

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
			$this->session->set_flashdata('error', 'Tade cesta nevedie!');
			redirect(BASE_URL);
		}

	}

	public function index()
	{

		$data['title'] = 'Admin - Dashboard';
		$data['page'] = 'admin/dashboard';

		$this->load->view('admin/layout/normal', $data);
	}


	public function menuSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment3 = $this->uri->segment(3);

		if (!empty($post)) {
			$post['active'] = isset($post['active']) ? $post['active'] : '0';
			$post['lang'] = isset($post['lang']) ? $post['lang'] : 'de';
			$post['base'] = isset($post['base']) ? $post['base'] : '0'; // pridali sme base

			if (!empty($id)) {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->menuSave($post)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/menu/');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment3 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->menuDelete($id)) {
				$this->session->set_flashdata('message', 'die Daten werden unwiederbringlich gelöscht');
				redirect(BASE_URL . 'admin/menu/');
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
			}
		}

		$data['menus'] = $this->Admin_model->getFullMenu();
		$data['menu'] = $this->Admin_model->getMenu($id);
		$data['menuparent'] = $this->Admin_model->getMenu(false, true);
		$data['title'] = isset($menu->name) ? 'Upraviť MENU položku&nbsp: ' . $menu->name : 'MENU položky';
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
		$post = $this->input->post();
		$id = $this->uri->segment(3);

		log_message('debug', 'sliderSave post data: ' . print_r($post, true));
		log_message('debug', 'sliderSave id: ' . $id);

		if (!empty($post)) {
			$post['active'] = isset($post['active']) ? $post['active'] : '0';
			$post['orderBy'] = isset($post['orderBy']) ? $post['orderBy'] : '0';
			$post['float'] = isset($post['float']) ? $post['float'] : '0';

			if ($this->Admin_model->is_order_by_duplicate($post['orderBy'], $id)) {
				$post['orderBy'] = $this->Admin_model->get_next_order_by();
			}

			if ($this->saveSlider($post, $id)) {
				$this->session->set_flashdata('success', 'Slider erfolgreich gespeichert');
				redirect('admin/slider');
			} else {
				$this->session->set_flashdata('error', 'Es ist ein Fehler aufgetreten. Versuchen Sie es erneut');
				$data['edit'] = (object)$post;
			}
		} else {
			log_message('error', 'Form data is empty.');
		}

		$data['sliders'] = $this->Admin_model->get_all_sliders();

		if (!empty($id)) {
			$data['slider'] = $this->Admin_model->get_slider($id);
			$data['title'] = 'Edit Slider';
		} else {
			$data['slider'] = null;
			$data['title'] = 'Add Slider';
		}
		$data['page'] = 'admin/settings/sliders';
		$this->load->view('admin/layout/normal', $data);
	}

	public function delete_slider($id) {
		if ($this->Admin_model->delete_slider($id)) {
			$this->session->set_flashdata('message', 'Slider wurde erfolgreich gelöscht');
		} else {
			$this->session->set_flashdata('error', 'Es ist ein Fehler aufgetreten. Versuchen Sie es erneut');
		}
		redirect(BASE_URL . 'admin/slider/');
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

			$this->session->set_flashdata('error', 'Image upload failed. Please try again.');
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
				log_message('error', 'Database save failed for slider: ' . print_r($post, true));
				$this->session->set_flashdata('error', 'Database save failed. Please try again.');
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
			log_message('debug', 'Directory does not exist: ' . $upload_path);
			if (!mkdir($upload_path, 0777, true)) {
				log_message('error', 'Failed to create directory: ' . $upload_path);
				return array('error' => '<p>Failed to create directory: ' . $upload_path . '</p>');
			} else {
				log_message('debug', 'Directory created: ' . $upload_path);
			}
		} else {
			log_message('debug', 'Directory already exists: ' . $upload_path);
		}

		if (!is_writable($upload_path)) {
			log_message('error', 'Upload path is not writable: ' . $upload_path);
			return array('error' => '<p>Upload path is not writable: ' . $upload_path . '</p>');
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
			log_message('error', 'Upload error for ' . $field_name . ': ' . $error);
			return array('error' => $error);
		} else {
			return $this->upload->data();
		}
	}


	function newsSave() {
		$post = $this->input->post();
		$id = $this->uri->segment('4');
		$segment2 = $this->uri->segment('3'); // edit alebo del

		if (!empty($post)) {
			// Získanie starého obrázka, ak existuje
			$old_image = !empty($id) ? $this->Admin_model->getNews($id)->image : false;

			// Nahranie nového obrázka, ak bol nahraný
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
						// Odstránenie starého obrázka, ak bol nahradený novým
						if ($old_image && file_exists(FCPATH . 'uploads/news/' . $old_image)) {
							unlink(FCPATH . 'uploads/news/' . $old_image);
						}
					}
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/news/');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->newsSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/news');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->newsDelete($id)) {
				$this->session->set_flashdata('message', 'die Daten werden unwiederbringlich gelöscht');
				redirect(BASE_URL . 'admin/news');
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
			}
		}

		if (empty($id)) {
			$data['newss'] = $this->Admin_model->getNews();
			$data['news'] = $this->Admin_model->getNews($id);
			$data['title'] = 'News';
			$data['page'] = 'admin/settings/news';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['newss'] = $this->Admin_model->getNews();
			$data['news'] = $this->Admin_model->getNews($id);
			$data['title'] = 'News';
			$data['page'] = 'admin/settings/news';
			$this->load->view('admin/layout/normal', $data);
		}
	}


	function bestProductSave() {
		$post = $this->input->post();
		$id = $this->uri->segment('4');
		$segment2 = $this->uri->segment('3');

		if (!empty($post)) {
			// Získanie starého obrázka, ak existuje
			$old_image = !empty($id) ? $this->Admin_model->getNews($id)->image : false;

			// Nahranie nového obrázka, ak bol nahraný
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
						// Odstránenie starého obrázka, ak bol nahradený novým
						if ($old_image && file_exists(FCPATH . 'uploads/product/' . $old_image)) {
							unlink(FCPATH . 'uploads/product/' . $old_image);
						}
					}
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/bestProduct/');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->bestProductSave($post, $image, $old_image)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/bestProduct');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->bestProductDelete($id)) {
				$this->session->set_flashdata('message', 'die Daten werden unwiederbringlich gelöscht');
				redirect(BASE_URL . 'admin/bestProduct');
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
			}
		}

		if (empty($id)) {
			$data['products'] = $this->Admin_model->getProduct();
			$data['product'] = $this->Admin_model->getProduct($id);
			$data['title'] = 'Beliebte produkte';
			$data['page'] = 'admin/settings/bestProduct';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['products'] = $this->Admin_model->getProduct();
			$data['product'] = $this->Admin_model->getProduct($id);
			$data['title'] = 'Beliebte produkte';
			$data['page'] = 'admin/settings/bestProduct';
			$this->load->view('admin/layout/normal', $data);
		}
	}

	function commentarSave() {
		$post = $this->input->post();
		$id = $this->uri->segment('4');
		$segment2 = $this->uri->segment('3');

		if (!empty($post)) {

			if (!empty($id)) {
				if ($this->Admin_model->naturkosmetikSave($post)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/commentar/');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Admin_model->naturkosmetikSave($post)) {
					$this->session->set_flashdata('success', 'alle daten ist gespeichert');
					redirect(BASE_URL . 'admin/commentar');
				} else {
					$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
					$data['edit'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			if ($this->Admin_model->naturkosmetikDelete($id)) {
				$this->session->set_flashdata('message', 'die Daten werden unwiederbringlich gelöscht');
				redirect(BASE_URL . 'admin/commentar');
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
			}
		}

		if (empty($id)) {
			$data['komentars'] = $this->Admin_model->getKomentar();
			$data['komentar'] = $this->Admin_model->getKomentar($id);
			$data['title'] = 'Beliebte produkte';
			$data['page'] = 'admin/settings/commentar';
			$this->load->view('admin/layout/normal', $data);
		} else {
			$data['komentars'] = $this->Admin_model->getKomentar();
			$data['komentar'] = $this->Admin_model->getKomentar($id);
			$data['title'] = 'Beliebte produkte';
			$data['page'] = 'admin/settings/commentar';
			$this->load->view('admin/layout/normal', $data);
		}
	}




















































}






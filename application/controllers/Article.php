<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_URI $uri
 * @property CI_Session $session
 * @property Article_model $Article_model
 */
class Article extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Article_model', 'Admin_model'));
	}

	public function articleCategoriesSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment2 = $this->uri->segment(3);
		$search = $this->input->get('search'); // <- presunuté vyššie

		// Automatická synchronizácia menu položiek do článkových kategórií
		$this->Article_model->syncMenuWithArticleCategories();

		// Spracovanie POST
		if (!empty($post)) {
			// Zákaz úpravy systémovej kategórie (prepojenej s menu)
			if (!empty($post['id'])) {
				$existing = $this->Article_model->getArticleCategories($post['id']);
				if (!empty($existing->menu_id) || !empty($existing->submenu_id)) {
					$this->session->set_flashdata('error', 'Diese Kategorie wird automatisch vom Menü verwaltet und kann nicht bearbeitet werden.');
					redirect(BASE_URL . 'admin/article_categories');
				}
			}

			// Ak je to položka z menu/submenu, nastavíme menu_id alebo submenu_id a slug
			if (!empty($post['menu_id'])) {
				$post['menu_id'] = (int)$post['menu_id'];
				$post['slug'] = $this->Admin_model->getSlugById($post['menu_id']);
			} elseif (!empty($post['submenu_id'])) {
				$post['submenu_id'] = (int)$post['submenu_id'];
				$post['slug'] = $this->Admin_model->getSlugBySubId($post['submenu_id']);
			}

			if (!empty($post['id'])) {
				if ($this->Article_model->saveArticleCategory($post)) {
					$this->session->set_flashdata('success', 'Kategorie wurde erfolgreich bearbeitet.');
					redirect(BASE_URL . 'admin/article_categories');
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['edit'] = (object)$post;
				}
			} else {
				if ($this->Article_model->saveArticleCategory($post)) {
					$this->session->set_flashdata('success', 'Kategorie wurde erfolgreich hinzugefügt.');
					redirect(BASE_URL . 'admin/article_categories');
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['edit'] = (object)$post;
				}
			}
		}

		// Zákaz mazania systémovej kategórie (prepojenej s menu)
		if ($segment2 == 'del' && is_numeric($id)) {
			$category = $this->Article_model->getArticleCategories($id);
			if (!empty($category->menu_id) || !empty($category->submenu_id)) {
				$this->session->set_flashdata('error', 'Diese Kategorie wird automatisch vom Menü verwaltet und kann nicht gelöscht werden.');
				redirect(BASE_URL . 'admin/article_categories');
			}

			if ($this->Article_model->deleteArticleCategory($id)) {
				$this->session->set_flashdata('success', 'Kategorie wurde erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/article_categories');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		// Výpis paginovaných kategórií s vyhľadávaním
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/article_categories');
		$config['total_rows'] = $this->Article_model->countCategoriesFiltered($search);
		$config['per_page'] = 30;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = '«';
		$config['last_link'] = '»';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$offset = $this->uri->segment(3) ?? 0;

		$data['articleCategories'] = $this->Article_model->getPaginatedCategoriesFiltered($config['per_page'], $offset, $search);
		$data['pagination'] = $this->pagination->create_links();
		$data['articleCategory'] = $this->Article_model->getArticleCategories($id);
		$data['title'] = 'Artikelkategorien';
		$data['page'] = 'admin/settings/article_categories';
		$this->load->view('admin/layout/normal', $data);
	}




	public function articleCategoryForm($id = null)
	{
		$data['title'] = $id ? 'Kategorie bearbeiten' : 'Kategorie hinzufügen';
		$data['page'] = 'admin/settings/article_category_form';

		if ($id) {
			$data['articleCategory'] = $this->Article_model->getArticleCategories($id);
			if (!$data['articleCategory']) {
				show_404();
			}
		}

		$this->load->view('admin/layout/normal', $data);
	}

	public function articlesByCategory($categoryId)
	{
		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/articles_in_category/' . $categoryId);
		$config['total_rows'] = $this->Article_model->countArticlesByCategory($categoryId);
		$config['per_page'] = 30;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = '«';
		$config['last_link'] = '»';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$offset = $this->uri->segment(4) ?? 0;

		$data['articleCategories'] = $this->Article_model->getArticleCategoriesWithCount();
		$data['articles'] = $this->Article_model->getPaginatedArticlesByCategory($categoryId, $config['per_page'], $offset);
		$data['categoryId'] = $categoryId;
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = 'Artikel verwalten';
		$data['page'] = 'admin/settings/articles';
		$this->load->view('admin/layout/normal', $data);
	}

	public function articlesSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4); // ID článku (pre editáciu)
		$segment2 = $this->uri->segment(3); // Pre 'del' alebo iné akcie

		// Načítanie kategórií
		$this->load->model('Article_model');
		$articleCategories = $this->Article_model->getArticleCategories();
		log_message('debug', 'Loaded articleCategories: ' . print_r($articleCategories, true));

		// Konfigurácia pre nahrávanie súborov
		$config['upload_path'] = './Uploads/articles/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
		$config['max_size'] = 2048; // 2MB v KB
		$config['overwrite'] = FALSE;

		if (!file_exists($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, TRUE);
		}

		$this->load->library('upload');

		if (!empty($post)) {
			// Spracovanie category_id
			if (!empty($id)) {
				// Editácia: Použijeme category_id z existujúceho článku
				$article = $this->Article_model->getArticle($id);
				if ($article) {
					$post['category_id'] = $article->category_id;
				} else {
					$this->session->set_flashdata('error', 'Článok nebol nájdený.');
					redirect(BASE_URL . 'admin/articles_in_category/0');
				}
			} else {
				// Nový článok: Použijeme category_id z POST
				$post['category_id'] = $post['category_id'];
				if (empty($post['category_id'])) {
					$this->session->set_flashdata('error', 'Kategória nebola zadaná.');
					redirect(BASE_URL . 'admin/articles_in_category/0');
				}
			}

			// Spracovanie hlavného obrázka
			if (!empty($_FILES['image']['name'])) {
				$this->upload->initialize($config);
				if ($this->upload->do_upload('image')) {
					$upload_data = $this->upload->data();
					$post['image'] = $upload_data['file_name'];
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Hochladen des Hauptbildes: ' . $this->upload->display_errors());
				}
			} elseif (!empty($post['ftp_image'])) {
				$post['image'] = $post['ftp_image'];
			}

			// Spracovanie produktových obrázkov
			for ($i = 1; $i <= 3; $i++) {
				$file_key = "product_image$i";
				if (!empty($_FILES[$file_key]['name'])) {
					$this->upload->initialize($config);
					if ($this->upload->do_upload($file_key)) {
						$upload_data = $this->upload->data();
						$post["product_image$i"] = $upload_data['file_name'];
					} else {
						$this->session->set_flashdata('error', "Fehler beim Hochladen des Produktbildes $i: " . $this->upload->display_errors());
					}
				} elseif (!empty($post["ftp_product_image$i"])) {
					$post["product_image$i"] = $post["ftp_product_image$i"];
				}
			}

			// Spracovanie sekčných obrázkov
			if (!empty($post['sections'])) {
				$sections = $post['sections'];
				$ftp_section_images = $post['ftp_section_image'] ?? [];
				foreach ($_FILES['section_images']['name'] as $key => $section_image) {
					if (!empty($section_image)) {
						$section_config = $config;
						$section_config['file_name'] = time() . '_' . $section_image;
						$this->upload->initialize($section_config);

						$_FILES['temp_image']['name'] = $_FILES['section_images']['name'][$key];
						$_FILES['temp_image']['type'] = $_FILES['section_images']['type'][$key];
						$_FILES['temp_image']['tmp_name'] = $_FILES['section_images']['tmp_name'][$key];
						$_FILES['temp_image']['error'] = $_FILES['section_images']['error'][$key];
						$_FILES['temp_image']['size'] = $_FILES['section_images']['size'][$key];

						if ($this->upload->do_upload('temp_image')) {
							$upload_data = $this->upload->data();
							$post['section_images'][$key] = $upload_data['file_name'];
						} else {
							$this->session->set_flashdata('error', "Fehler beim Hochladen des Sektionsbildes $key: " . $this->upload->display_errors());
						}
					}
					if (!empty($ftp_section_images[$key])) {
						$post['section_images'][$key] = $ftp_section_images[$key];
					}
				}
			}

			// Uloženie do databázy
			if ($this->Article_model->saveArticle($post)) {
				$message = !empty($post['id']) ? 'Artikel wurde erfolgreich bearbeitet.' : 'Artikel wurde erfolgreich hinzugefügt.';
				$this->session->set_flashdata('success', $message);
				redirect(BASE_URL . 'admin/articles_in_category/' . $post['category_id']);
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Speichern.');
				$data['article'] = (object)$post;
				$data['categoryId'] = $post['category_id'];
				$data['articleCategories'] = $articleCategories;
				$data['sections'] = $post['sections'] ? array_map(function($content, $idx) use ($post) {
					return (object)[
						'content' => $content,
						'image' => $post['section_images'][$idx] ?? null,
						'image_title' => $post['section_image_titles'][$idx] ?? null,
						'ftp_image' => $post['ftp_section_image'][$idx] ?? null,
						'order' => $idx
					];
				}, $post['sections'], array_keys($post['sections'])) : [];
				$data['title'] = 'Artikel verwalten';
				$data['page'] = 'admin/settings/article_form';
				$this->load->view('admin/layout/normal', $data);
				return;
			}
		}

		// Načítanie dát pre formulár
		$article = $this->Article_model->getArticle($id);
		$categoryId = $article ? $article->category_id : 0; // Použijeme category_id z článku, ak editujeme
		log_message('debug', 'Category ID for view: ' . $categoryId);

		if ($segment2 == 'del' && is_numeric($id)) {
			$article = $this->Article_model->getArticle($id);
			if ($article && $this->Article_model->deleteArticle($id)) {
				$this->session->set_flashdata('success', 'Artikel wurde erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/articles_in_category/' . ($article->category_id ?? 0));
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		$data['article'] = $article;
		$data['categoryId'] = $categoryId; // Použijeme category_id z článku
		$data['articleCategories'] = $articleCategories;
		$data['sections'] = $article ? $this->Article_model->getSections($id) : [];
		$data['title'] = 'Artikel verwalten';
		$data['page'] = 'admin/settings/article_form';
		$this->load->view('admin/layout/normal', $data);
	}
	public function syncCategories()
	{
		$this->Article_model->syncMenuWithArticleCategories();
		$this->session->set_flashdata('success', 'Menu a submenu boli synchronizované s kategóriami článkov.');
		redirect(BASE_URL . 'admin/article_categories');
	}

}

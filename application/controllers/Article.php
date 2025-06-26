<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
		$search = $this->input->get('search');

		$this->Article_model->syncMenuWithArticleCategories();

		if (!empty($post)) {
			log_message('debug', 'Received POST data in articleCategoriesSave: ' . print_r($post, true));

			if (!empty($post['id'])) {
				$existing = $this->Article_model->getArticleCategories($post['id']);
				if (!empty($existing->menu_id) || !empty($existing->submenu_id)) {
					$this->session->set_flashdata('error', 'Diese Kategorie wird automatisch vom Menü verwaltet und kann nicht bearbeitet werden.');
					redirect(BASE_URL . 'admin/article_categories');
				}
			}

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

		$data['articleCategories'] = $this->Article_model->getPaginatedCategoriesFiltered(null, null, $search);
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
		$post = $this->input->post(NULL, FALSE);
		$segment3 = $this->uri->segment(3);
		$id = $this->uri->segment(4);

		if ($segment3 === 'del' && is_numeric($id)) {
			$article = $this->Article_model->getArticle($id);
			$categoryId = $article ? $article->category_id : 0;

			if ($this->Article_model->deleteArticle($id)) {
				$this->session->set_flashdata('success', 'Artikel wurde erfolgreich gelöscht.');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
			redirect(BASE_URL . 'admin/articles_in_category/' . $categoryId);
		}

		$this->load->model('Article_model');
		$articleCategories = $this->Article_model->getArticleCategories();
		$this->load->model('Gallery_model');
		$galleryCategories = $this->Gallery_model->getAllCategories();

		$dirs = [
			'articles' => './Uploads/articles/',
			'products' => './Uploads/articles/products/',
			'sections' => './Uploads/articles/sections/',
		];
		foreach ($dirs as $dir) {
			if (!file_exists($dir)) mkdir($dir, 0777, true);
		}

		$this->load->library('upload');

		if (!empty($post)) {
			log_message('debug', 'Received POST data in articlesSave: ' . print_r($post, true));

			if (!empty($id)) {
				$article = $this->Article_model->getArticle($id);
				$post['category_id'] = $article->category_id ?? null;
				if (!$post['category_id']) {
					$this->session->set_flashdata('error', 'Artikel wurde nicht gefunden.');
					redirect(BASE_URL . 'admin/articles_in_category/0');
				}
			} else {
				$post['category_id'] = $post['category_id'] ?? $this->uri->segment(3);
				if (empty($post['category_id'])) {
					$this->session->set_flashdata('error', 'Kategorie wurde nicht angegeben.');
					redirect(BASE_URL . 'admin/articles_in_category/0');
				}
			}

			// Handle slug with language prefix
			$lang = $post['lang'] ?? 'de';
			if (!empty($post['menu_select'])) {
				$parts = explode('/', trim($post['menu_select'], '/'));
				$parts = array_filter($parts, fn($part) => !in_array($part, ['de', 'en']));
				$post['slug'] = $lang . '/' . implode('/', $parts);
			} elseif (empty($post['slug']) && !empty($id)) {
				$article = $this->Article_model->getArticle($id);
				$post['slug'] = $article->slug ?? '';
			}

			if (empty($post['slug'])) {
				$this->session->set_flashdata('error', 'Slug ist erforderlich.');
				redirect(BASE_URL . 'admin/articles_in_category/' . $post['category_id']);
			}

			if (!empty($_FILES['image']['name'])) {
				$this->upload->initialize(['upload_path' => $dirs['articles'], 'allowed_types' => 'jpg|jpeg|png|gif|webp']);
				if ($this->upload->do_upload('image')) {
					$upload_data = $this->upload->data();
					$post['image'] = 'Uploads/articles/' . $upload_data['file_name'];
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Hochladen des Hauptbildes: ' . $this->upload->display_errors());
					$post['image'] = $post['old_image'] ?? null;
				}
			}

			$sections = [];
			if (!empty($post['sections'])) {
				foreach ($post['sections'] as $i => $content) {
					$image = '';

					if (!empty($post['ftp_section_image'][$i])) {
						$image = $post['ftp_section_image'][$i];
					} elseif (!empty($_FILES['section_images']['name'][$i])) {
						$_FILES_SINGLE = [
							'name'     => $_FILES['section_images']['name'][$i],
							'type'     => $_FILES['section_images']['type'][$i],
							'tmp_name' => $_FILES['section_images']['tmp_name'][$i],
							'error'    => $_FILES['section_images']['error'][$i],
							'size'     => $_FILES['section_images']['size'][$i],
						];

						$_FILES['temp_section_image'] = $_FILES_SINGLE;
						$this->upload->initialize([
							'upload_path' => $dirs['sections'],
							'allowed_types' => 'jpg|jpeg|png|gif|webp',
						]);

						if ($this->upload->do_upload('temp_section_image')) {
							$upload_data = $this->upload->data();
							$image = 'Uploads/articles/sections/' . $upload_data['file_name'];
						}
					} elseif (!empty($post['old_section_image'][$i])) {
						$image = $post['old_section_image'][$i];
					}

					$sections[$i] = [
						'content' => $content,
						'image' => $image,
						'image_title' => $post['section_image_titles'][$i] ?? '',
						'button_name' => $post['button_names'][$i] ?? '',
						'subpage' => $post['subpages'][$i] ?? '', // Subpage obsahuje slug článku
						'external_url' => $post['external_urls'][$i] ?? ''
					];
				}
			}

			log_message('debug', 'Processed sections: ' . print_r($sections, true));
			$post['sections_data'] = $sections;

			// Handle is_main
			$post['is_main'] = isset($post['is_main']) && $post['is_main'] == '1' ? 1 : 0;

			if ($this->Article_model->saveArticle($post)) {
				$this->session->set_flashdata('success', empty($post['id']) ? 'Artikel wurde erfolgreich hinzugefügt.' : 'Artikel wurde erfolgreich bearbeitet.');
				redirect(BASE_URL . 'admin/articles_in_category/' . $post['category_id']);
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Speichern.');
				$data['article'] = (object)$post;
				$data['categoryId'] = $post['category_id'];
				$data['articleCategories'] = $articleCategories;
				$data['galleryCategories'] = $galleryCategories;
				$data['selectedGalleries'] = !empty($post['gallery_category_id']) ? $this->Gallery_model->getGalleriesByCategoryId($post['gallery_category_id']) : [];
				$data['galleryCategoryId'] = $post['gallery_category_id'] ?? null;

				$data['sections'] = [];
				if (!empty($post['sections'])) {
					foreach ($post['sections'] as $i => $content) {
						$image = '';

						if (!empty($post['ftp_section_image'][$i])) {
							$image = $post['ftp_section_image'][$i];
						} elseif (!empty($post['old_section_image'][$i])) {
							$image = $post['old_section_image'][$i];
						}

						$data['sections'][$i] = (object)[
							'content' => $content,
							'image' => $image,
							'image_title' => $post['section_image_titles'][$i] ?? '',
							'button_name' => $post['button_names'][$i] ?? '',
							'subpage' => $post['subpages'][$i] ?? '', // Subpage obsahuje slug článku
							'external_url' => $post['external_urls'][$i] ?? ''
						];
					}
				}

				$data['title'] = 'Artikel verwalten';
				$data['page'] = 'admin/settings/article_form';
				$this->load->view('admin/layout/normal', $data);
				return;
			}
		}

		$article = $this->Article_model->getArticle($id);
		$categoryId = $article->category_id ?? ($this->uri->segment(3) ?? 0);

		$categoryName = 'Kategorie nicht gefunden';
		foreach ($articleCategories as $cat) {
			if ((int)$cat->id === (int)$categoryId) {
				$categoryName = $cat->name;
				break;
			}
		}

		$galleryCategoryId = null;
		$selectedGalleries = [];
		if ($article && $article->gallery_id) {
			$gallery = $this->Gallery_model->getGallery($article->gallery_id);
			if ($gallery) {
				$galleryCategoryId = $gallery->category_id;
				$selectedGalleries = $this->Gallery_model->getGalleriesByCategoryId($galleryCategoryId);
			}
		}

		$data['article'] = $article;
		$data['categoryId'] = $categoryId;
		$data['categoryName'] = $categoryName;
		$data['articleCategories'] = $articleCategories;
		$data['galleryCategories'] = $galleryCategories;
		$data['selectedGalleries'] = $selectedGalleries;
		$data['galleryCategoryId'] = $galleryCategoryId;
		$data['sections'] = $article ? $this->Article_model->getSections($id) : [];
		$data['title'] = 'Artikel verwalten';
		$data['page'] = 'admin/settings/article_form';
		$this->load->view('admin/layout/normal', $data);
	}

	public function getGalleriesByCategory()
	{
		$categoryId = $this->input->post('category_id');
		if (!$categoryId) {
			echo json_encode(['success' => false, 'message' => 'Kategorie nicht angegeben.']);
			return;
		}

		$this->load->model('Gallery_model');
		$galleries = $this->Gallery_model->getGalleriesByCategoryId($categoryId);

		$options = '<option value="">-- Galerie auswählen --</option>';
		foreach ($galleries as $gallery) {
			$options .= '<option value="' . htmlspecialchars($gallery->id) . '">' . htmlspecialchars($gallery->name) . '</option>';
		}

		echo json_encode(['success' => true, 'options' => $options]);
	}

	public function syncCategories()
	{
		$this->Article_model->syncMenuWithArticleCategories();
		$this->session->set_flashdata('success', 'Menu a submenu boli synchronizované s kategóriami článkov.');
		redirect(BASE_URL . 'admin/article_categories');
	}

	public function getMenuItems()
	{
		$result = $this->Article_model->getMenuItems();
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function upload_image()
	{
		$this->load->helper('app_helper');
		$response = ['success' => false, 'error' => ''];

		$dir = './Uploads/articles/summernote/';
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0777, true)) {
				$response['error'] = 'Fehler beim Erstellen des Ordners.';
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
				return;
			}
		}

		if (!empty($_FILES['image']['name'])) {
			$upload_path = uploadImg('image', 'Uploads/articles/summernote');
			if ($upload_path && file_exists($upload_path)) {
				$response['success'] = true;
				$response['image_url'] = $upload_path;
			} else {
				$response['error'] = 'Fehler beim Hochladen des Bildes: ' . ($_FILES['image']['error'] ?? 'Unbekannter Fehler');
			}
		} else {
			$response['error'] = 'Kein Bild wurde hochgeladen.';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function delete_image()
	{
		$response = ['success' => false, 'error' => ''];
		$image_url = $this->input->post('image_url');

		if ($image_url) {
			$base_url = rtrim(BASE_URL, '/');
			$file_path = FCPATH . str_replace($base_url . '/', '', $image_url);

			if (file_exists($file_path) && unlink($file_path)) {
				$response['success'] = true;
			} else {
				$response['error'] = 'Fehler beim Löschen des Bildes.';
			}
		} else {
			$response['error'] = 'Kein Bildpfad angegeben.';
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
}

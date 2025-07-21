<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

		$this->load->helper('app_helper');
		foreach ($post as $key => $value) {
			if (is_string($value) && !in_array($key, ['slug', 'image', 'start_date_from_date', 'start_date_from_time', 'end_date_to_date', 'end_date_to_time', 'created_at'])) {
				$post[$key] = clean_input_text($value);
				if (preg_match('/<o:p>/i', $post[$key])) {
					$this->session->set_flashdata('error', 'Neplatný text v poli ' . $key . '!');
				}
			}
		}

		if (isset($post['sections']) && is_array($post['sections'])) {
			foreach ($post['sections'] as $i => $content) {
				$post['sections'][$i] = clean_input_text($content);
			}
		}

		$this->load->model('Article_model');
		$articleCategories = $this->Article_model->getArticleCategories();
		$this->load->model('Gallery_model');
		$galleryCategories = $this->Gallery_model->getAllCategories();

		$dirs = [
			'articles' => './uploads/articles/',
			'products' => './uploads/articles/products/',
			'sections' => './uploads/articles/sections/',
		];
		foreach ($dirs as $dir) {
			if (!file_exists($dir)) mkdir($dir, 0777, true);
		}

		$this->load->library('upload');

		if (!empty($post)) {
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
				$post['image'] = '';
			} else {
				$post['image'] = $post['old_image'] ?? null;
			}

			$sections = [];
			if (!empty($post['sections'])) {
				foreach ($post['sections'] as $i => $content) {
					$image = $post['old_section_image'][$i] ?? '';

					if (!empty($_FILES['section_images']['name'][$i])) {
						$image = '';
					} elseif (!empty($post['ftp_section_image'][$i])) {
						$image = $post['ftp_section_image'][$i];
					}

					$sections[$i] = [
						'content' => $content,
						'image' => $image,
						'image_title' => $post['section_image_titles'][$i] ?? '',
						'image_description' => $post['section_image_descriptions'][$i] ?? '',
						'button_name' => $post['button_names'][$i] ?? '',
						'subpage' => $post['subpages'][$i] ?? '',
						'external_url' => $post['external_urls'][$i] ?? ''
					];
				}
			}

			$post['sections_data'] = $sections;

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
						$image = $post['old_section_image'][$i] ?? '';

						if (!empty($post['ftp_section_image'][$i])) {
							$image = $post['ftp_section_image'][$i];
						}

						$data['sections'][$i] = (object)[
							'content' => $content,
							'image' => $image,
							'image_title' => $post['section_image_titles'][$i] ?? '',
							'image_description' => $post['section_image_descriptions'][$i] ?? '',
							'button_name' => $post['button_names'][$i] ?? '',
							'subpage' => $post['subpages'][$i] ?? '',
							'external_url' => $post['external_urls'][$i] ?? ''
						];
					}
				}

				$data['subcategories'] = $this->Article_model->getSubcategoriesByCategory($post['category_id']);
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
		$data['subcategories'] = $this->Article_model->getSubcategoriesByCategory($categoryId);
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
		$category_id = $this->input->post('category_id');
		$subcategory_id = $this->input->post('subcategory_id');
		$title = $this->input->post('title') ?: 'article';

		if ($this->input->post('is_product')) {
			$baseDir = 'uploads/Produkte/';
		} else {
			if ($category_id == 100) {
				$categoryBaseDir = 'neuigkeiten';
				$suffix = '_neuigkeiten';
			} elseif ($category_id == 102) {
				$categoryBaseDir = 'tipps';
				$suffix = '_tipps';
			} elseif ($category_id == 104) {
				// Pri Jobs nejdeme cez uploads/articles
				$baseDir = 'uploads/Jobs/';
				$suffix = '_Jobs';
			} else {
				$categoryBaseDir = 'neuigkeiten';
				$suffix = '';
			}

			if (!isset($baseDir)) {
				// Iba ak sa nenastavil $baseDir vyššie (čiže nie pri Jobs)
				$subcategoryDir = '';
				if (in_array($category_id, [100, 102]) && !empty($subcategory_id) && $subcategory_id !== 'new') {
					$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
					$subcategory = $this->db->get_where($table, ['id' => $subcategory_id])->row();
					$subcategoryDir = $subcategory ? url_oprava($subcategory->name) : '';
				}
				$baseDir = "uploads/articles/{$categoryBaseDir}/" . ($subcategoryDir ? "{$subcategoryDir}/" : '');
			}
		}

		if (!file_exists(FCPATH . $baseDir)) {
			mkdir(FCPATH . $baseDir, 0755, true);
		}

		$imageName = url_oprava($title) . '_summernote_' . time() . $suffix;
		$uploadResult = uploadImg('image', $baseDir, $imageName, false, false, true);

		if ($uploadResult && file_exists($uploadResult)) {
			$response = [
				'success' => true,
				'image_url' => base_url($uploadResult)
			];
		} else {
			$response = [
				'success' => false,
				'error' => 'Fehler beim Hochladen des Bildes.'
			];
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
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

	public function getSubcategories()
	{
		$categoryId = $this->input->post('category_id');
		if (!$categoryId) {
			echo json_encode(['success' => false, 'message' => 'Kategorie nicht angegeben.']);
			return;
		}

		$subcategories = $this->Article_model->getSubcategoriesByCategory($categoryId);
		$options = '<option value="">-- Unterkategorie auswählen --</option>';
		$options .= '<option value="new">+ Neue Unterkategorie erstellen</option>';
		foreach ($subcategories as $sub) {
			$options .= '<option value="' . htmlspecialchars($sub->id) . '">' . htmlspecialchars($sub->name) . '</option>';
		}

		echo json_encode(['success' => true, 'options' => $options]);
	}

	public function manageSubcategory()
	{
		$category_id = $this->input->post('category_id');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$lang = $this->input->post('lang');
		$active = $this->input->post('active') ? 1 : 0;

		if (!$category_id || !$name) {
			echo json_encode(['success' => false, 'message' => 'Kategorie und Name sind erforderlich.']);
			return;
		}

		$data = [
			'category_id' => $category_id,
			'name' => $name,
			'lang' => $lang,
			'active' => $active
		];

		if ($id && is_numeric($id)) {
			$existing = $this->Article_model->getSubcategory($id, $category_id);
			if (!$existing) {
				echo json_encode(['success' => false, 'message' => 'Unterkategorie nicht gefunden.']);
				return;
			}
			$existing_by_name = $this->Article_model->getSubcategoryByNameAndCategory($category_id, $name);
			if ($existing_by_name && $existing_by_name->id != $id) {
				echo json_encode(['success' => false, 'message' => 'Eine Unterkategorie mit diesem Namen existiert bereits in dieser Kategorie.']);
				return;
			}
		} else {
			$existing = $this->Article_model->getSubcategoryByNameAndCategory($category_id, $name);
			if ($existing) {
				echo json_encode(['success' => false, 'message' => 'Eine Unterkategorie mit diesem Namen existiert bereits in dieser Kategorie.']);
				return;
			}
		}

		$result = $this->Article_model->saveSubcategory($data + ($id ? ['id' => $id] : []));
		if ($result) {
			$subcategory = $this->Article_model->getSubcategory($id ?: $result, $category_id);
			echo json_encode([
				'success' => true,
				'message' => $id ? 'Unterkategorie wurde aktualisiert.' : 'Unterkategorie wurde erstellt.',
				'subcategory' => $subcategory
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern der Unterkategorie.']);
		}
	}

	public function deleteSubcategory()
	{
		$id = $this->input->post('id');
		$category_id = $this->input->post('category_id');
		if (!$id || !is_numeric($id) || !$category_id) {
			echo json_encode(['success' => false, 'message' => 'Ungültige Unterkategorie-ID oder Kategorie-ID.']);
			return;
		}

		if ($this->Article_model->deleteSubcategory($id, $category_id)) {
			echo json_encode(['success' => true, 'message' => 'Unterkategorie erfolgreich gelöscht.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen der Unterkategorie.']);
		}
	}

	public function getSubcategoriesForManagement()
	{
		$category_id = $this->input->post('category_id');
		if (!$category_id) {
			echo json_encode(['success' => false, 'message' => 'Fehlende category_id.']);
			return;
		}

		$subcategories = $this->Article_model->getSubcategoriesByCategory($category_id);

		$html = '';
		foreach ($subcategories as $sub) {
			$html .= '<tr>';
			$html .= '<td>' . htmlspecialchars($sub->name) . '</td>';
			$html .= '<td>' . htmlspecialchars($sub->slug) . '</td>';
			$html .= '<td>';
			$html .= '<select name="lang_' . $sub->id . '" class="form-control">';
			$html .= '<option value="de" ' . ($sub->lang == 'de' ? 'selected' : '') . '>Deutsch</option>';
			$html .= '<option value="en" ' . ($sub->lang == 'en' ? 'selected' : '') . '>Englisch</option>';
			$html .= '</select>';
			$html .= '</td>';
			$html .= '<td>';
			$html .= '<input type="checkbox" name="active_' . $sub->id . '" ' . ($sub->active ? 'checked' : '') . ' value="1">';
			$html .= '</td>';
			$html .= '<td>';
			$html .= '<button class="btn btn-sm btn-primary edit-subcategory" data-id="' . $sub->id . '" data-name="' . htmlspecialchars($sub->name) . '">Bearbeiten</button>';
			$html .= '<button class="btn btn-sm btn-danger delete-subcategory" data-id="' . $sub->id . '">Löschen</button>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		if (empty($html)) {
			$html = '<tr><td colspan="5">Keine Unterkategorien.</td></tr>';
		}
		echo json_encode(['success' => true, 'html' => $html]);
	}

}

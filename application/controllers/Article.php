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
		$this->load->model('Article_model');
	}

	public function articleCategoriesSave()
	{
		$post = $this->input->post();
		$id = $this->uri->segment(4);
		$segment2 = $this->uri->segment(3);

		if (!empty($post)) {
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
			if ($this->Article_model->deleteArticleCategory($id)) {
				$this->session->set_flashdata('success', 'Kategorie wurde erfolgreich gelöscht.');
				redirect(BASE_URL . 'admin/article_categories');
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		$this->load->library('pagination');
		$config['base_url'] = base_url('admin/article_categories');
		$config['total_rows'] = $this->Article_model->countCategories();
		$config['per_page'] = 15;
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

		$data['articleCategories'] = $this->Article_model->getPaginatedCategories($config['per_page'], $offset);
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
		$config['per_page'] = 15;
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
		$id = $this->uri->segment(4);
		$segment2 = $this->uri->segment(3);

		if (!empty($post)) {
			if (!empty($post['id'])) {
				if ($this->Article_model->saveArticle($post)) {
					$this->session->set_flashdata('success', 'Artikel wurde erfolgreich bearbeitet.');
					redirect(BASE_URL . 'admin/articles_in_category/' . $post['category_id']);
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['article'] = (object)$post;
				}
			} else {
				if ($this->Article_model->saveArticle($post)) {
					$this->session->set_flashdata('success', 'Artikel wurde erfolgreich hinzugefügt.');
					redirect(BASE_URL . 'admin/articles_in_category/' . $post['category_id']);
				} else {
					$this->session->set_flashdata('error', 'Fehler beim Speichern.');
					$data['article'] = (object)$post;
				}
			}
		}

		if ($segment2 == 'del' && is_numeric($id)) {
			$article = $this->Article_model->getArticle($id);

			if ($this->Article_model->deleteArticle($id)) {
				$this->session->set_flashdata('success', 'Artikel wurde erfolgreich gelöscht.');
				$categoryId = $article->category_id ?? 0;
				redirect(BASE_URL . 'admin/articles_in_category/' . $categoryId);
			} else {
				$this->session->set_flashdata('error', 'Fehler beim Löschen.');
			}
		}

		$data['article'] = $this->Article_model->getArticle($id);
		$data['categoryId'] = $data['article']->category_id ?? $id;
		$data['articleCategories'] = $this->Article_model->getArticleCategories();
		$data['sections'] = $this->Article_model->getSections($id);
		$data['title'] = 'Artikel verwalten';
		$data['page'] = 'admin/settings/article_form';
		$this->load->view('admin/layout/normal', $data);
	}
}

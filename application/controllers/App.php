<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property Ion_auth|Ion_auth_model $ion_auth         The ION Auth spark
 * @property App_model|App_model     $App_model        App_model
 * @property CI_Form_validation      $form_validation  The form validation library
 */
class App extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('App_model','Mail_model'));
		$this->load->language('app_lang');
		$this->refresh = get_http_referer(); // Speichern des Referers in die Eigenschaft des Controllers / verwende redirect($this->refresh);
		setlocale(LC_ALL,'de_DE');
	}

	function index(){
		$this->home();
	}
	function error404(){

		header("HTTP/1.1 404 Not Found");
		$data['title'] = 'Error 404 ';
		$data['page'] = 'Error404';
		$data['description'] = '';
		$data['keywords'] = '';
		$this->load->view('layout/normal',$data);

	}

	public function home()
	{
		// Laden und Senden von Daten
		$data['user']           = $this->ion_auth->user()->row();
		$data['sliders']        = $this->App_model->getSliders(true);
		$data['news']           = $this->App_model->getAllActiveNews(); // angepasst
		$data['product']        = $this->App_model->getAllActiveProduct(); // angepasst

		// Laden der Controller-Daten
		$data['page']           = 'home';
		$data['title']          = lang('HOME_TITLE');
		$data['description']    = lang('HOME_DESCRIPTION');
		$data['keywords']       = lang('HOME_KEYWORDS');
		$data['image']          = BASE_URL . LOGO;

		$this->load->view('layout/normal', $data);
	}

	public function routes()
	{
		$lang = language();
		$segment1 = $this->uri->segment(2);
		$segment2 = $this->uri->segment(3);
		$segment3 = $this->uri->segment(4);

		$slug = $segment1 . '/' . $segment2;

		$this->load->model('App_model');

		$category = $this->App_model->getCategoryBySlug($slug, $lang);
		if (!$category) {
			$this->error404();
			return;
		}

		if (!empty($segment3)) {
			$article = $this->App_model->getExactArticle($segment3, $lang);

			if (!$article || $article->category_id != $category->id) {
				$this->error404();
				return;
			}

			$sections = $this->App_model->getSections($article->id);

			$galleryImages = [];
			if (!empty($article->gallery_id)) {
				$this->load->model('Gallery_model');
				$galleryImages = $this->Gallery_model->getImagesByGalleryId($article->gallery_id);
			}

			$data['article'] = $article;
			$data['sections'] = $sections;
			$data['galleryImages'] = $galleryImages;
			$data['title'] = $article->title;
			$data['description'] = $article->meta ?? '';
			$data['keywords'] = $article->keywords ?? '';
			$data['image'] = !empty($article->image) ? base_url($article->image) : BASE_URL . LOGO;
			$data['page'] = 'article/detail';

			$this->load->view('layout/normal', $data);
			return;
		}

		$articles = $this->App_model->getArticlesByCategory($category->id, $lang);

		if (empty($articles)) {
			$this->error404();
			return;
		}

		if (count($articles) === 1) {
			$article = $articles[0];
			$sections = $this->App_model->getSections($article->id);

			$galleryImages = [];
			if (!empty($article->gallery_id)) {
				$this->load->model('Gallery_model');
				$galleryImages = $this->Gallery_model->getImagesByGalleryId($article->gallery_id);
			}

			$data['article'] = $article;
			$data['sections'] = $sections;
			$data['galleryImages'] = $galleryImages;
			$data['title'] = $article->title;
			$data['description'] = $article->meta ?? '';
			$data['keywords'] = $article->keywords ?? '';
			$data['image'] = !empty($article->image) ? base_url($article->image) : BASE_URL . LOGO;
			$data['page'] = 'article/detail';

			$this->load->view('layout/normal', $data);
			return;
		}

		$data['articles'] = $articles;
		$data['category'] = $category;
		$data['title'] = $category->name ?? 'Artikelübersicht';
		$data['description'] = $category->description ?? 'Übersicht der Artikel in dieser Kategorie';
		$data['keywords'] = $category->keywords ?? '';
		$data['image'] = BASE_URL . LOGO;
		$data['page'] = 'article/list';

		$this->load->view('layout/normal', $data);
	}


	private function check_cookie_consent() {
		if (!$this->input->cookie('cookie_consent', TRUE)) {
			setcookie('cookie_consent', 'false', time() + 86400, "/");
		}
	}

	public function set_cookie_consent() {
		setcookie('cookie_consent', 'true', time() + 86400, "/");
		setcookie('performance_cookies', $this->input->post('performance_cookies') == 'true' ? 'true' : 'false', time() + 86400, "/");
		setcookie('functional_cookies', $this->input->post('functional_cookies') == 'true' ? 'true' : 'false', time() + 86400, "/");
		setcookie('targeting_cookies', $this->input->post('targeting_cookies') == 'true' ? 'true' : 'false', time() + 86400, "/");
		echo json_encode(array("status" => "success"));
	}

	public function decline_cookie_consent() {
		setcookie('cookie_consent', 'false', time() + 86400, "/");
		setcookie('performance_cookies', 'false', time() + 86400, "/");
		setcookie('functional_cookies', 'false', time() + 86400, "/");
		setcookie('targeting_cookies', 'false', time() + 86400, "/");
		echo json_encode(array("status" => "success"));
	}
}

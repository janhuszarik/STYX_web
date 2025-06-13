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
	public function error404()
	{
		log_message('error', '404 Page Not Found: ' . current_url());
		header("HTTP/1.1 404 Not Found");
		$data['user'] = $this->ion_auth->user()->row();
		$data['title'] = lang('ERROR_404_TITLE') ?: '404 - Seite nicht gefunden';
		$data['description'] = lang('ERROR_404_DESCRIPTION') ?: 'Die angeforderte Seite konnte nicht gefunden werden.';
		$data['keywords'] = '';
		$data['image'] = BASE_URL . LOGO;
		$data['page'] = 'error404';
		$this->load->view('layout/normal', $data);
	}

	public function kontakt()
	{
		$data['title'] = 'Kontakt & Anfahrt';
		$data['description'] = 'So erreichen Sie uns...';
		$data['page'] = 'app/kontakt';

		$this->load->view('layout/normal', $data);
	}
	public function send_contact()
	{



		$this->load->library('form_validation');
		$this->load->library('email');

		$this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('adresse', 'Adresse', 'required|trim|max_length[150]');
		$this->form_validation->set_rules('telefon', 'Telefon', 'required|trim|max_length[30]');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email|max_length[100]');
		$this->form_validation->set_rules('typ', 'Typ', 'required');
		$this->form_validation->set_rules('nachricht', 'Nachricht', 'required|trim|max_length[5000]');


		if ($this->form_validation->run() == FALSE) {
			ddd(validation_errors());

			$this->session->set_flashdata('error', 'Bitte füllen Sie alle Felder korrekt aus.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$recaptcha_response = $this->input->post('g-recaptcha-response');
		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Bitte bestätigen Sie das reCAPTCHA.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRETKEY . "&response=" . $recaptcha_response);
		$response = json_decode($verify);

		if (!$response->success) {
			$this->session->set_flashdata('error', 'reCAPTCHA Überprüfung fehlgeschlagen.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		// === Email odoslanie ===
		$data = [
			'name' => $this->input->post('name', true),
			'adresse' => $this->input->post('adresse', true),
			'telefon' => $this->input->post('telefon', true),
			'email' => $this->input->post('email', true),
			'typ' => $this->input->post('typ', true),
			'nachricht' => $this->input->post('nachricht', true),
		];

		$this->load->model('App_model');
		$sent = $this->App_model->sendContactMail($data);

		if ($sent) {
			$this->session->set_flashdata('success', 'Vielen Dank für Ihre Anfrage. Wir melden uns baldmöglichst bei Ihnen.');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	public function preview_email()
	{
		$data['name'] = 'Max Mustermann'; // testovacie dáta
		$this->load->view('emails/contact_reply', $data);
	}
	public function showMap()
	{
		$data['title'] = 'Pobočky & Mapa';
		$data['description'] = 'Prehľad našich pobočiek na mape...';
		$data['page'] = 'app/map_view';

		$locations = $this->App_model->getLocations();
		$data['locations'] = json_encode(array_map(function($loc) {
			return [
				'name' => $loc->name,
				'latitude' => $loc->latitude,
				'longitude' => $loc->longitude,
				'address' => $loc->address,
				'city' => $loc->city,
				'zip_code' => $loc->zip_code,
				'opening_hours' => $loc->opening_hours
			];
		}, $locations));
		$this->load->view('layout/normal', $data);
	}

}

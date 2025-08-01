<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');
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
		$this->load->model(array('App_model', 'Mail_model'));
		$this->load->language('app_lang');
		$this->refresh = get_http_referer();
		setlocale(LC_ALL, 'de_DE');
	}

	function index()
	{
		$this->home();
	}

	public function home()
	{
		$data['user'] = $this->ion_auth->user()->row();
		$data['sliders'] = $this->App_model->getSliders(true);
		$data['news'] = $this->App_model->getAllActiveNews();
		$data['products'] = $this->App_model->getAllActiveProduct();

		foreach ($data['products'] as $product) {
			if (!empty($product->image)) {
				$product->image = str_replace('uploads/product/', 'uploads/Produkte/', $product->image);
			}
		}

		$data['page'] = 'home';
		$data['title'] = lang('HOME_TITLE');
		$data['description'] = lang('HOME_DESCRIPTION');
		$data['keywords'] = lang('HOME_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;

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

		$isAdmin = $this->ion_auth->logged_in() && $this->ion_auth->is_admin();

		if (!empty($segment3)) {
			$article = $this->App_model->getExactArticle($segment3, $lang);
			if (!$article || $article->category_id != $category->id) {
				$this->error404();
				return;
			}
			if ($article->active != 1 && !$isAdmin) {
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
			$data['isAdmin'] = $isAdmin;

			$this->load->view('layout/normal', $data);
			return;
		}

		$subcategoryId = $this->input->get('sub');
		$subcategories = [];
		$articles = [];

		if (in_array((int)$category->id, [100, 102])) {
			$subcategories = $this->App_model->getSubcategoriesByCategory($category->id);

			if ($subcategoryId) {
				$articles = $this->App_model->getArticlesBySubcategory($category->id, $subcategoryId, $lang);
			} else {
				$articles = $this->App_model->getArticlesByCategory($category->id, $lang);
			}
		} else {
			$articles = $this->App_model->getArticlesByCategory($category->id, $lang);
		}

		$noArticles = empty($articles);

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
		$data['subcategories'] = $subcategories;
		$data['selectedSubcategory'] = $subcategoryId;
		$data['noArticles'] = $noArticles;
		$data['title'] = $category->name ?? 'Artikelübersicht';
		$data['description'] = $category->description ?? 'Übersicht der Artikel in dieser Kategorie';
		$data['keywords'] = $category->keywords ?? '';
		$data['image'] = BASE_URL . LOGO;
		$data['page'] = 'article/list';

		$this->load->view('layout/normal', $data);
	}

	public function error404()
	{
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
		$data['name'] = 'Max Mustermann';
		$this->load->view('emails/contact_reply', $data);
	}

	public function showMap()
	{
		$data['title'] = 'Shopfinder';
		$data['description'] = 'Das Beste was die Natur zu bieten hat';
		$data['page'] = 'app/map_view';

		$locations = $this->App_model->getLocations();
		$data['locations'] = json_encode(array_map(function ($loc) {
			return [
				'name' => $loc->name,
				'latitude' => $loc->latitude,
				'longitude' => $loc->longitude,
				'address' => $loc->address,
				'city' => $loc->city,
				'zip_code' => $loc->zip_code,
				'opening_hours' => $loc->opening_hours,
				'logo' => $loc->logo,
				'contact_person' => $loc->contact_person,
				'email' => $loc->email,
				'phone' => $loc->phone,
				'website' => $loc->website
			];
		}, $locations));

		$this->load->view('layout/normal', $data);
	}

	public function download_presse_login()
	{
		$post = $this->input->post();

		if ($post) {
			$username = trim($post['username']);
			$password = trim($post['password']);

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

			if ($username === 'styx' && $password === 'styx3100') {
				redirect('https://drive.google.com/drive/u/1/folders/1j-DjaM3af-ZAodvNLB-jNOLADFqaPoS9');
			} else {
				$this->session->set_flashdata('error', 'Ungültiger Benutzername oder Passwort.');
				redirect($_SERVER['HTTP_REFERER']);
			}
		} else {
			$data['title'] = 'Downloads & Presse';
			$data['description'] = 'Zugang zum geschützten Pressebereich.';
			$data['page'] = 'app/download_presse_login';

			$this->load->view('layout/normal', $data);
		}
	}

	public function kindergeburtstageAnfrage()
	{
		$data['title'] = 'Kontakt & Anfahrt';
		$data['description'] = 'So erreichen Sie uns...';
		$data['page'] = 'app/kindergeburtstageAnfrage';

		$this->load->view('layout/normal', $data);
	}

	public function send_kindergeburtstage()
	{
		$this->load->library('form_validation');
		$this->load->library('email');

		$this->form_validation->set_rules('event_date', 'Datum', 'required');
		$this->form_validation->set_rules('event_time', 'Uhrzeit', 'required');
		$this->form_validation->set_rules('child_name', 'Kind', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('child_age', 'Alter', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('num_children', 'Kinderanzahl', 'required|integer|greater_than[0]|less_than_equal_to[15]');
		$this->form_validation->set_rules('contact_person', 'Kontaktperson', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email|max_length[100]');
		$this->form_validation->set_rules('phone', 'Telefonnummer', 'required|trim|max_length[30]');
		$this->form_validation->set_rules('address', 'Adresse', 'required|trim|max_length[150]');
		$this->form_validation->set_rules('zip_city', 'Ort', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('paket', 'Paket', 'required|in_list[shampoo_badesalz,schokolade]');
		$this->form_validation->set_rules('torte', 'Torte', 'required|in_list[ja]');
		$this->form_validation->set_rules('jause', 'Jause', 'required|in_list[wurst,toast]');
		$this->form_validation->set_rules('notes', 'Anmerkung', 'trim|max_length[500]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$recaptcha_response = $this->input->post('g-recaptcha-response');
		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Bitte bestätigen Sie das reCAPTCHA.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRETKEY . "&response=" . $recaptcha_response . "&remoteip=" . $this->input->ip_address());
		$response = json_decode($verify);

		if (!$response->success) {
			$this->session->set_flashdata('error', 'reCAPTCHA Überprüfung fehlgeschlagen.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$data = [
			'event_date' => $this->input->post('event_date', true),
			'event_time' => $this->input->post('event_time', true),
			'child_name' => $this->input->post('child_name', true),
			'child_age' => $this->input->post('child_age', true),
			'num_children' => $this->input->post('num_children', true),
			'contact_person' => $this->input->post('contact_person', true),
			'email' => $this->input->post('email', true),
			'phone' => $this->input->post('phone', true),
			'address' => $this->input->post('address', true),
			'zip_city' => $this->input->post('zip_city', true),
			'paket' => $this->input->post('paket', true),
			'torte' => $this->input->post('torte', true),
			'jause' => $this->input->post('jause', true),
			'notes' => $this->input->post('notes', true),
		];

		$this->load->model('App_model');
		$sent = $this->App_model->sendKindergeburtstagMail($data);

		if ($sent) {
			$this->session->set_flashdata('success', 'Vielen Dank für Ihre Anfrage. Wir melden uns baldmöglichst bei Ihnen.');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function betriebsfuhrungen()
	{
		$data['title'] = 'Betriebsführungen';
		$data['description'] = 'Besuchen Sie uns in Ober-Grafendorf NÖ – Naturkosmetik, BIO Schokolade & vieles mehr';
		$data['keywords'] = 'World of STYX, Betriebsführung Naturkosmetik, BIO Schokolade Niederösterreich, Ausflugsziel Mostviertel, Erlebnisführung Ober-Grafendorf, Naturkosmetik Führung, Schokoladenführung, Kindergeburtstag STYX, Touren für Gruppen STYX, Führungen Ober-Grafendorf, Bahnerlebnis Niederösterreich, Bierverkostung STYX, Kräutergarten Natur im Garten, NÖ Card Ausflugsziel, Familienausflug STYX';
		$data['page'] = 'app/betriebsfuhrungen';

		$this->load->view('layout/normal', $data);
	}

	public function gruppenfuhrungen()
	{
		$data['title'] = 'Anfrage | Gruppenführung';
		$data['description'] = 'Besuchen Sie uns in Ober-Grafendorf NÖ – Naturkosmetik, BIO Schokolade & vieles mehr';
		$data['keywords'] = 'Gruppenführung STYX, Betriebsführung Naturkosmetik, BIO Schokolade Führung, STYX Erlebniswelt, Ausflugsziel Gruppen Niederösterreich, Firmenausflug STYX, Gruppenreise Mostviertel, Naturkosmetik Manufaktur Tour, Schokoladenverkostung Gruppe, STYX Gruppenanfrage, Bahnerlebnis Führung, STYX Kräutergarten Führung, NÖ Card Gruppenführung';
		$data['page'] = 'app/gruppenfuhrungen';

		$this->load->view('layout/normal', $data);
	}

	public function send_gruppenfuhrung()
	{
		$this->load->library('form_validation');
		$this->load->library('email');

		$this->form_validation->set_rules('group_type', 'Gruppe', 'required');
		$this->form_validation->set_rules('event_date', 'Wunschtermin', 'required');
		$this->form_validation->set_rules('organization', 'Organisation', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email|max_length[100]');
		$this->form_validation->set_rules('phone', 'Telefon', 'required|trim|max_length[30]');
		$this->form_validation->set_rules('street', 'Straße', 'required|trim|max_length[150]');
		$this->form_validation->set_rules('zip_city', 'PLZ / Ort', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('num_persons', 'Personenanzahl', 'required');
		$this->form_validation->set_rules('tour_type', 'Tour', 'required');
		$this->form_validation->set_rules('zahlung', 'Zahlung', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('besuchen/gruppenfuhrungen');
			return;
		}

		$recaptcha_response = $this->input->post('g-recaptcha-response');
		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Bitte bestätigen Sie das reCAPTCHA.');
			redirect('besuchen/gruppenfuhrungen');
			return;
		}

		$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRETKEY . "&response=" . $recaptcha_response . "&remoteip=" . $this->input->ip_address());
		$response = json_decode($verify);

		if (!$response->success) {
			$this->session->set_flashdata('error', 'reCAPTCHA Überprüfung fehlgeschlagen.');
			redirect('besuchen/gruppenfuhrungen');
			return;
		}

		$data = [
			'group_type' => $this->input->post('group_type', true),
			'event_date' => $this->input->post('event_date', true),
			'organization' => $this->input->post('organization', true),
			'name' => $this->input->post('name', true),
			'email' => $this->input->post('email', true),
			'phone' => $this->input->post('phone', true),
			'street' => $this->input->post('street', true),
			'zip_city' => $this->input->post('zip_city', true),
			'num_persons' => $this->input->post('num_persons', true),
			'tour_type' => $this->input->post('tour_type', true),
			'zahlung' => $this->input->post('zahlung', true),
			'rechnung_adresse' => $this->input->post('rechnung_adresse', true),
			'andere_adresse' => $this->input->post('andere_adresse', true),
			'extras_silber' => $this->input->post('extras_silber', true),
			'gold_option' => $this->input->post('gold_option', true),
			'extras_gold' => $this->input->post('extras_gold', true),
			'paket' => $this->input->post('paket', true)
		];

		$this->load->model('App_model');
		$sent = $this->App_model->sendGruppenfuhrungMail($data);

		if ($sent) {
			$this->session->set_flashdata('success', 'Vielen Dank für Ihre Anfrage. Wir melden uns baldmöglichst bei Ihnen.');
		} else {
			$this->session->set_flashdata('error', 'Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.');
		}

		redirect('besuchen/gruppenfuhrungen');
	}
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property Ion_auth|Ion_auth_model $ion_auth        	The ION Auth spark
 * @property App_model|App_model 	 $App_model        	App_model
 * @property CI_Form_validation      $form_validation 	The form validation library
 */
class App extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('App_model','Mail_model'));
		$this->load->language('app_lang');
		$this->refresh = get_http_referer(); // Uloženie referera do vlastnosti kontroléra / použijem redirect($this->refresh);
		setlocale(LC_ALL,'de_DE');


	}


	function index(){
		$this->home();
	}


	public function home()
	{
		// Načítanie a posielanie dát
		$data['user'] 			= $this->ion_auth->user()->row();
		$data['sliders'] 		= $this->App_model->getSliders(true);
		$data['news'] 			= $this->App_model->getAllActiveNews(); // upravené
		$data['product'] 		= $this->App_model->getAllActiveProduct(); // upravené


		// Načítanie dát kontrolera
		$data['page'] 			= 'home';
		$data['title'] 			= lang('HOME_TITLE');
		$data['description'] 	= lang('HOME_DESCRIPTION');
		$data['keywords'] 		= lang('HOME_KEYWORDS');
		$data['image'] 			= BASE_URL . LOGO;

		// Načítanie view
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

	function aboutStyx(){

		// Nastavenie rôznych stránok podľa jazyka
		if (language() == 'en') {
			$data['page'] = 'app/aboutStyx_en';
		} elseif (language() == 'de') {
			$data['page'] = 'app/aboutStyx_de';
		} else {
			$data['page'] = 'app/aboutStyx';
		}
		$data['title'] 				= lang('ABOUT_STYX_TITLE');
		$data['description'] 		= lang('ABOUT_STYX_DESCRIPTION');
		$data['keywords'] 			= lang('ABOUT_STYX_KEYWORDS');
		$data['image'] 				= BASE_URL . LOGO;
		$data['image1'] 			= BASE_URL.'img/breadcrumb/aboutStyx.jpg';
		$this->load->view('layout/normal', $data);

	}

	public function naturkosmetik() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Naturkosmetik');
		$data['sumComment'] = $this->App_model->countComments('Naturkosmetik');
		$data['page'] = 'app/Naturkosmetik';
		$data['title'] = lang('NATURKOSMETIK_TITLE');
		$data['description'] = lang('NATURKOSMETIK_DESCRIPTION');
		$data['keywords'] = lang('NATURKOSMETIK_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/naturkosmetic.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function aromaDerm() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Aroma-Derm');
		$data['sumComment'] = $this->App_model->countComments('Aroma-Derm');
		$data['page'] = 'app/Aroma-Derm';
		$data['title'] = lang('AROMA-DERM_TITLE');
		$data['description'] = lang('NATURKOSMETIK_DESCRIPTION');
		$data['keywords'] = lang('NATURKOSMETIK_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/naturkosmetic.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function schokoladen() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Schokolade');
		$data['sumComment'] = $this->App_model->countComments('Schokolade');
		$data['page'] = 'app/Schokoladen';
		$data['title'] = lang('SCHOKOLADE_TITLE');
		$data['description'] = lang('SCHOKOLADE_DESCRIPTION');
		$data['keywords'] = lang('SCHOKOLADE_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/schokolade.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function figuren() {
		$data['page'] = 'app/Figuren';
		$data['title'] = lang('FIGURTEN_TITLE');
		$data['description'] = lang('NATURKOSMETIK_DESCRIPTION');
		$data['keywords'] = lang('NATURKOSMETIK_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/schokolade.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function privateLabeling() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Private-Labeling');
		$data['sumComment'] = $this->App_model->countComments('Private-Labeling');
		$data['page'] = 'app/privateLabeling';
		$data['title'] = lang('PRIVATE_LABELING_TITLE');
		$data['description'] = lang('PRIVATE_LABELING_DESCRIPTION');
		$data['keywords'] = lang('PRIVATE_LABELING_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/privateLabeling.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function werbegeschenke() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Werbegeschenke');
		$data['sumComment'] = $this->App_model->countComments('Werbegeschenke');
		$data['page'] = 'app/Werbegeschenke';
		$data['title'] = lang('WERBEGESCHENKE_TITLE');
		$data['description'] = lang('WERBEGESCHENKE_DESCRIPTION');
		$data['keywords'] = lang('WERBEGESCHENKE_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/werbegeschenke.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function workshops() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('Workshops');
		$data['sumComment'] = $this->App_model->countComments('Workshops');
		$data['page'] = 'app/Workshops';
		$data['title'] = lang('WORKSHOPS_TITLE');
		$data['description'] = lang('WORKSHOPS_DESCRIPTION');
		$data['keywords'] = lang('WORKSHOPS_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/workshops.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function wordOfStyx() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->naturkosmetik($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		$data['comment'] = $this->App_model->getComments('WordOfStyx');
		$data['sumComment'] = $this->App_model->countComments('WordOfStyx');
		$data['page'] = 'app/WordOfStyx';
		$data['title'] = lang('WORDOFSTYX_TITLE');
		$data['description'] = lang('WORDOFSTYX_DESCRIPTION');
		$data['keywords'] = lang('WORDOFSTYX_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/worldOfStyx.jpg';

		$this->load->view('layout/normal', $data);
	}
	public function news_article($id = false) {

		$id = $this->uri->segment(3);

		$news_article = $this->App_model->getAllNews_article($id);

		// Priradenie údajov do poľa $data
		$data['news_article'] = $news_article;

		// Ak $news_article obsahuje 'name', nastavíme ho ako title
		if (!empty($news_article) && isset($news_article->name)) {
			$data['title'] ='AKTUELLES' .' | '.$news_article->name;
		} else {
			// Pôvodný title ako fallback
			$data['title'] = lang('FIGURTEN_TITLE');
		}

		$data['page'] = 'app/news_article';
		$data['description'] = lang('NATURKOSMETIK_DESCRIPTION');
		$data['keywords'] = lang('NATURKOSMETIK_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/schokolade.jpg';

		// Načítanie view s údajmi
		$this->load->view('layout/normal', $data);
	}

	public function philosophie() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->philosophie($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}




		// Nastavenie rôznych stránok podľa jazyka
		if (language() == 'en') {
			$data['page'] = 'app/Philosophie_en';
		} elseif (language() == 'de') {
			$data['page'] = 'app/Philosophie_de';
		} else {
			$data['page'] = 'app/Philosophie';
		}

		$data['title'] = lang('PHILOSOPHIE_TITLE');
		$data['sub_title'] = lang('PHILOSOPHIE_SUB_TITLE');
		$data['description'] = lang('PHILOSOPHIE_DESCRIPTION');
		$data['keywords'] = lang('PHILOSOPHIE_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/philosophie.jpg';

		$this->load->view('layout/normal', $data);
	}

	public function zertifizierungen() {
		$post = $this->input->post();
		if (!empty($post)) {
			if ($this->App_model->philosophie($post)) {
				$this->session->set_flashdata('success', 'alle daten sind gespeichert');
				redirect($this->refresh);
			} else {
				$this->session->set_flashdata('error', 'fehler, versuchen noch einmal');
				redirect($this->refresh);
			}
		}

		// Nastavenie rôznych stránok podľa jazyka
		if (language() == 'en') {
			$data['page'] = 'app/zertifizierungen_en';
		} elseif (language() == 'de') {
			$data['page'] = 'app/zertifizierungen_de';
		} else {
			$data['page'] = 'app/zertifizierungen';
		}

		$data['title'] = lang('ZERTIFIZIERUNGEN_TITLE');
		$data['sub_title'] = lang('ZERTIFIZIERUNGEN_SUB_TITLE');
		$data['description'] = lang('ZERTIFIZIERUNGEN_DESCRIPTION');
		$data['keywords'] = lang('ZERTIFIZIERUNGEN_KEYWORDS');
		$data['image'] = BASE_URL . LOGO;
		$data['image1'] = BASE_URL . 'img/breadcrumb/philosophie.jpg';

		$this->load->view('layout/normal', $data);
	}

	function worldwide(){

		// Nastavenie rôznych stránok podľa jazyka
		if (language() == 'en') {
			$data['page'] = 'app/worldwide_en';
		} elseif (language() == 'de') {
			$data['page'] = 'app/worldwide_de';
		} else {
			$data['page'] = 'app/worldwide';
		}
		$data['title'] 				= lang('WORLDWIDE_TITLE');
		$data['description'] 		= lang('WORLDWIDE_DESCRIPTION');
		$data['keywords'] 			= lang('WORLDWIDE_KEYWORDS');
		$data['image'] 				= BASE_URL . LOGO;
		$data['image1'] 			= BASE_URL.'img/breadcrumb/worldwide.jpg';
		$this->load->view('layout/normal', $data);

	}


	function error404(){
        
        header("HTTP/1.1 404 Not Found");
        $data['title'] = 'Fehler 404 ';
        $data['page'] = 'chyba';
        $data['description'] = '';
        $data['keywords'] = '';
        $this->load->view('layout/normal',$data);

    }







	function impressum() {

		$data['title'] 			= 'Impressum';
		$data['page'] 			= 'app/impressum';
		$data['description'] 	= 'Erfahren Sie mehr über unser Unternehmen und wie Sie uns erreichen können. Unsere Kontaktdaten und rechtlichen Hinweise finden Sie hier.';
		$data['keywords'] 		= 'impressum, kontakt, rechtliche hinweise, unternehmensinformation, adresse, telefon, email';

		$this->load->view('layout/normal', $data);
	}

	function GDPR() {

		$data['title'] 			= 'Datenschutzerklärung';
		$data['page'] 			= 'app/datenschutzerklarung';
		$data['description'] 	= 'Informieren Sie sich über unsere Datenschutzrichtlinien und wie wir Ihre persönlichen Daten schützen. Hier finden Sie alle wichtigen Informationen zum Thema Datenschutz.';
		$data['keywords'] 		= 'datenschutzerklärung, datenschutz, persönliche daten, datensicherheit, datenschutzrichtlinien, informationen, schutz';

		$this->load->view('layout/normal', $data);
	}

	function cookies() {

		$data['title'] 			= 'Cookies';
		$data['page'] 			= 'app/cookies';
		$data['description'] 	= 'Erfahren Sie mehr über unsere Cookie-Richtlinien und wie wir Ihre Daten verwenden. Hier finden Sie alle wichtigen Informationen zum Thema Cookies und Datenschutz.';
		$data['keywords'] 		= 'cookie-richtlinien, cookies, datenschutz, datenverwendung, datenschutzrichtlinien, informationen, schutz';

		$this->load->view('layout/normal', $data);
	}






}

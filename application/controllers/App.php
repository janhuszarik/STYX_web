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
		setlocale(LC_ALL,'de_DE');


	}


	function index(){
		$this->home();
	}

	function home(){


		if (empty($id)) {


			$data['user'] = $this->ion_auth->user()->row();
			$data['sliders'] = $this->App_model->getSliders(true);
			$data['news'] = $this->App_model->getNews();


			$data['description'] = lang('HOME_DESCRIPTION');
			$data['keywords'] = lang('HOME_KEYWORDS');
			$data['image'] = BASE_URL . 'img/metaOg1.jpg';
			$data['page'] = 'home';
			$data['title'] ='Minidoku';
			$this->load->view('layout/normal', $data);

		}else{


			$data['user'] = $this->ion_auth->user()->row();
			$data['sliders'] = $this->App_model->getSliders(true);
			$data['news'] = $this->App_model->getNews();

			$data['page'] = 'home';
			$data['description'] = lang('HOME_DESCRIPTION');
			$data['keywords'] = lang('HOME_KEYWORDS');
			$data['image'] = BASE_URL . 'img/metaOg1.jpg';
			$data['title'] ='Minidoku';
			$this->load->view('layout/normal', $data);
		}

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



	public function contact(){
        
        $this->load->library('session');
        
        $post = $this->input->post();
        if (isset($post) && !empty($post)){
            
            
            $ip = $this->input->ip_address();
            $r = validate_recaptcha_response($this->input->post('g-recaptcha-response'),$ip);

            if ($r['success'] == true){
                
                $this->session->set_flashdata('success', 'Výborne, email bol odoslaný.');
                if ($this->Mail_model->send_contact()) {
                    echo 'Správa bola odoslaná...  Ďakujeme.';
                }
                else {
                    echo 'Oj! Niečo sa pokazilo';
                }
            } else {
                $this->session->set_flashdata('error', 'Overenie ReCaptcha neprešlo! ...Skúste znovu');
                
            }
            redirect(BASE_URL.'kontakt');
        }
		$data['menu_items'] = $this->App_model->get_menu_items();

        $data['title'] = 'Kontakt ';
        $data['page'] = 'app/contact';
        $data['description'] = '';
        $data['keywords'] = '';
        $this->load->view('layout/normal',$data);
    }

	function error404(){
        
        header("HTTP/1.1 404 Not Found");
        $data['title'] = 'Chyba 404 ';
        $data['page'] = 'chyba';
        $data['description'] = '';
        $data['keywords'] = '';
        $this->load->view('layout/normal',$data);

    }

    function tagungSeminare(){

		$data['title'] 			= 'Tagung & Seminare';
		$data['page']			= 'app/tagung-seminare';
		$data['description'] 	= 'Entdecken Sie unsere erstklassigen Tagungs- und Seminarräume. Perfekt ausgestattet für erfolgreiche Veranstaltungen und Meetings.';
		$data['keywords'] 		= 'Tagungen, Seminare, Konferenzen, Meetingräume, Veranstaltungslocation, Business Events';

		$this->load->view('layout/normal',$data);

    }

	function hochzeiten(){

		$data['title'] 			= 'Hochzeiten';
		$data['page'] 			= 'app/hochzeiten';
		$data['description'] 	= 'Feiern Sie Ihre Traumhochzeit in unserer wunderschönen Location. Individuelle Gestaltungsmöglichkeiten für Ihren besonderen Tag.';
		$data['keywords'] 		= 'Hochzeit, Hochzeitslocation, Trauung, Hochzeitsfeier, Brautpaar, Heiraten';

		$this->load->view('layout/normal',$data);

    }

	function festeFeiern(){

		$data['title'] 			= 'Feste Feiern';
		$data['page'] 			= 'app/feste-feiern';
		$data['description'] 	= 'Ob Geburtstag, Jubiläum oder Firmenevent – unsere Location bietet den perfekten Rahmen für jedes Fest.';
		$data['keywords'] 		= 'Feiern, Partys, Geburtstagsfeier, Jubiläum, Firmenevent, Festlocation';

		$this->load->view('layout/normal',$data);

    }

	function bierWeinVerkostung(){

		$data['title'] 			= 'Bier- & Weinverkostung';
		$data['page'] 			= 'app/bier-wein-verkostung';
		$data['description'] 	= 'Genießen Sie exquisite Bier- und Weinverkostungen in angenehmer Atmosphäre. Perfekt für Kenner und Liebhaber.';
		$data['keywords'] 		= 'Weinverkostung, Bierverkostung, Degustation, Weinliebhaber, Bierkenner, Weinevents';

		$this->load->view('layout/normal',$data);

	}

	function rahmenprogramm(){

		$data['title'] 			= 'Rahmenprogramm';
		$data['page'] 			= 'app/rahmenprogramm';
		$data['description'] 	= 'Unser vielseitiges Rahmenprogramm bietet abwechslungsreiche Unterhaltung und Aktivitäten für Ihre Veranstaltung.';
		$data['keywords'] 		= 'Rahmenprogramm, Unterhaltung, Aktivitäten, Eventprogramm, Veranstaltungsideen';

		$this->load->view('layout/normal',$data);

	}

	function serviceCatering(){

		$data['title'] 			= 'Service & Catering';
		$data['page'] 			= 'app/service-catering';
		$data['description'] 	= 'Unser professionelles Catering sorgt für kulinarische Highlights und erstklassigen Service bei jedem Event.';
		$data['keywords'] 		= 'Catering, Eventservice, kulinarische Highlights, Cateringservice, Event Catering, Gastronomie';

		$this->load->view('layout/normal',$data);

	}

	function serviceRemise(){

		$data['title'] 			= 'Austattung Remise';
		$data['page'] 			= 'app/austattung';
		$data['description'] 	= 'Unsere professionellen Catering-Dienstleistungen bieten kulinarische Spezialitäten und erstklassigen Service bei jeder Veranstaltung.';
		$data['keywords'] 		= 'catering, veranstaltungsdienstleistungen, kulinarische spezialitäten, catering-dienstleistungen, event catering, gastronomie';

		$this->load->view('layout/normal', $data);
	}

	function downloads(){

		$data['title'] 			= 'Downloads | Remise';
		$data['page'] 			= 'app/downloads';
		$data['description'] 	= 'Laden Sie unsere Broschüren, Menüs und weitere Materialien herunter, um mehr über unsere Catering-Dienstleistungen und Angebote zu erfahren.';
		$data['keywords'] 		= 'downloads, broschüren, menüs, catering-dienstleistungen, catering-angebote, catering-informationen, veranstaltungsbroschüren';

		$this->load->view('layout/normal', $data);
	}

	function kontakt() {

		$data['title'] 			= 'Kontakt';
		$data['page'] 			= 'app/kontakt';
		$data['description'] 	= 'Nehmen Sie Kontakt mit uns auf, um mehr über unsere Catering-Dienstleistungen und Angebote zu erfahren.';
		$data['keywords'] 		= 'kontakt, anfrage, catering-dienstleistungen, catering-angebote, kundenservice, hilfe, unterstützung';

		$this->load->view('layout/normal', $data);
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

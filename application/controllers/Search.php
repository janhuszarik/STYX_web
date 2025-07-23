<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Search extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Search_model');
		$this->load->helper('app');
	}

	public function index() {
		$query = $this->input->get('q');
		error_log("Vyhľadávanie spustené s query: " . $query);

		$data = array();
		$data['query'] = $query;

		if (!empty($query)) {
			$data['results'] = $this->Search_model->search($query);
			error_log("Počet výsledkov pred odovzdaním do View: " . count($data['results']));
		} else {
			$data['results'] = array();
			error_log("Žiadny query parameter, výsledky nastavené na prázdne pole.");
		}

		$data['page'] = 'app/search_results';

		$data['generate_path'] = function($result) {
			switch ($result['type']) {
				case 'article':
					return 'Artikel > ' . $result['title'];
				case 'article_section':
					return 'Artikel > ' . (!empty($result['article_title']) ? $result['article_title'] : 'Unbekannt');
				default:
					return 'Unbekannter Pfad';
			}
		};

		if (empty($data['results'])) {
			error_log("Varovanie: Žiadne výsledky na odovzdanie do View.");
		}
		$this->load->view('layout/normal', $data);
	}
}

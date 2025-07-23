<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Search extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Search_model');
	}

	public function index() {
		$query = $this->input->get('q');

		$data = array();
		$data['query'] = $query;

		if (!empty($query)) {
			$data['results'] = $this->Search_model->search($query);
		} else {
			$data['results'] = array();
		}

		$data['page'] = 'app/search_results';

		$data['generate_path'] = function($result) {
			switch ($result['type']) {
				case 'article':
					return 'Artikel > ID ' . $result['id'];
				case 'article_category':
					return 'Menü > ' . $result['title'];
				case 'article_section':
					return 'Artikel > Sektion ' . $result['id'];
				case 'best_product':
					return 'Produkte > ' . $result['title'];
				case 'location':
					return 'Standorte > ' . $result['title'];
				case 'neuigkeiten_subcategory':
					return 'Neuigkeiten > ' . $result['title'];
				case 'news':
					return 'Neuigkeiten > ' . $result['title'];
				default:
					return 'Unbekannter Pfad';
			}
		};

		$this->load->view('layout/normal', $data);
	}
}

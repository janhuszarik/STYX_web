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
					return 'Artikel > ' . $result['title'];
				case 'article_section':
					return 'Artikel > ' . (!empty($result['article_title']) ? $result['article_title'] : 'Unbekannt');
				default:
					return 'Unbekannter Pfad';
			}
		};

		$this->load->view('layout/normal', $data);
	}
}

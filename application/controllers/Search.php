<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Search_model');
	}

	public function index() {
		$query = $this->input->get('q'); // Získanie vyhľadávacieho dotazu

		$data = array();
		$data['query'] = $query;

		if (!empty($query)) {
			// Vyhľadávanie pomocou modelu
			$data['results'] = $this->Search_model->search($query);
			log_message('debug', 'Results from search: ' . print_r($data['results'], TRUE));
		} else {
			$data['results'] = array();
			log_message('debug', 'No query provided');
		}

		// Ladenie načítania view
		$data['page'] = 'app/search_results';
		log_message('debug', 'Loading view: layout/normal with page: ' . $data['page'] . ' and data: ' . print_r($data, TRUE));

		$data['generate_path'] = function($result) {
			switch ($result['type']) {
				case 'article':
					return 'Artikel > ID ' . $result['id'];
				case 'article_category':
					return 'Menu > ' . $result['title'];
				case 'article_section':
					return 'Artikel > Sekcia ' . $result['id'];
				case 'best_product':
					return 'Produkty > ' . $result['title'];
				case 'location':
					return 'Lokality > ' . $result['title'];
				case 'neuigkeiten_subcategory':
					return 'Novinky > ' . $result['title'];
				case 'news':
					return 'Novinky > ' . $result['title'];
				default:
					return 'Neznáma cesta';
			}
		};

		$this->load->view('layout/normal', $data);
	}
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('app'); // Načítame helper, kde je url_oprava()
	}

	public function search($query) {
		$orig_query = $query;
		$query = $this->db->escape_like_str($query);
		$results = [];

		// ========================
		// ARTICLES
		// ========================
		$this->db->select([
			'articles.id',
			'articles.title',
			'articles.slug',
			'articles.image',
			'articles.keywords',
			'articles.text',
			'articles.subcategory_type', // Na určenie typu obsahu
			'articles.lang', // Pridáme jazyk
			"'article' as type"
		]);
		$this->db->from('articles');
		$this->db->group_start();
		$this->db->like('articles.title', $query);
		$this->db->or_like('articles.text', $query);
		$this->db->or_like('articles.keywords', $query);
		$this->db->or_like('articles.slug', $query);
		$this->db->group_end();
		$articles_results = $this->db->get();
		if ($articles_results === FALSE) {
			log_message('error', 'SQL Error (Articles): ' . $this->db->error()['message']);
			return [];
		}
		$articles_results = $articles_results->result_array();
		foreach ($articles_results as &$article) {
			// Ak je subcategory_type NULL alebo nie je "tipps" ani "neuigkeiten", predpokladáme podstránku
			if (empty($article['subcategory_type']) || !in_array($article['subcategory_type'], ['tipps', 'neuigkeiten'])) {
				$article['url'] = $article['slug']; // Iba slug pre podstránky
			} else {
				$article['url'] = $article['slug'] . '/' . url_oprava($article['title']); // Slug + title pre články
			}
		}
		$results = array_merge($results, $articles_results);

		// ========================
		// ARTICLE_SECTIONS
		// ========================
		$this->db->select([
			'article_sections.id',
			'article_sections.article_id',
			'article_sections.button_name as title',
			'article_sections.content',
			'articles.title as article_title',
			'articles.slug',
			'articles.image as article_image',
			'articles.subcategory_type', // Na určenie typu obsahu
			'articles.lang', // Pridáme jazyk
			"'article_section' as type"
		]);
		$this->db->from('article_sections');
		$this->db->join('articles', 'articles.id = article_sections.article_id', 'left');
		$this->db->group_start();
		$this->db->like('article_sections.button_name', $query);
		$this->db->or_like('article_sections.content', $query);
		$this->db->group_end();
		$article_sections_results = $this->db->get();
		if ($article_sections_results === FALSE) {
			log_message('error', 'SQL Error (Article Sections): ' . $this->db->error()['message']);
			return [];
		}
		$article_sections_results = $article_sections_results->result_array();
		foreach ($article_sections_results as &$section) {
			// Použijeme subcategory_type z príslušného článku
			if (empty($section['subcategory_type']) || !in_array($section['subcategory_type'], ['tipps', 'neuigkeiten'])) {
				$section['url'] = $section['slug']; // Iba slug pre podstránky
			} else {
				$section['url'] = $section['slug'] . '/' . url_oprava($section['article_title']); // Slug + title pre články
			}
		}
		$results = array_merge($results, $article_sections_results);

		// ========================
		// DEDUPLIZIERUNG (nur ein Ergebnis pro id a article_id kombinácie)
		// ========================
		$unique_results = [];
		$processed_ids = []; // Pole na sledovanie spracovaných id
		foreach ($results as $result) {
			$unique_key = $result['type'] . '|' . $result['id']; // Pre články a sekcie používame id
			if ($result['type'] === 'article') {
				if (!isset($processed_ids[$result['id']])) {
					$processed_ids[$result['id']] = true;
					$unique_results[$unique_key] = $result; // Pridáme iba prvý výskyt článku
				}
			} elseif ($result['type'] === 'article_section') {
				// Pre sekcie kombinujeme article_id a id sekcie
				$section_key = $result['type'] . '|' . $result['article_id'] . '|' . $result['id'];
				if (!isset($processed_ids[$result['article_id']])) {
					$unique_results[$section_key] = $result; // Pridáme sekciu, ak jej článok ešte nie je
				}
			}
		}
		$results = array_values($unique_results);

		// ========================
		// PHP FULLTEXT filter (case-insensitive)
		// ========================
		$final_results = [];
		$lower_query = mb_strtolower($orig_query, 'UTF-8');
		foreach ($results as $res) {
			$haystack = '';
			foreach ($res as $field => $value) {
				if (in_array($field, ['title', 'text', 'keywords', 'content', 'article_title'])) {
					$haystack .= ' ' . $value;
				}
			}
			$haystack = mb_strtolower($haystack, 'UTF-8');
			if (mb_strpos($haystack, $lower_query) !== false) {
				$final_results[] = $res;
			}
		}
		$results = $final_results;

		// ========================
		// Sortierung nach Relevanz
		// ========================
		usort($results, function($a, $b) use ($lower_query) {
			$a_match = 0;
			$b_match = 0;
			foreach (['title', 'article_title'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 3;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 3;
			}
			foreach (['text', 'content'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 2;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 2;
			}
			foreach (['keywords'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 1;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 1;
			}
			return $b_match - $a_match;
		});

		return $results;
	}
}

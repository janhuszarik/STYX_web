<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('app');
	}
	private function search_url_oprava($str, $separator = '-', $lowercase = true) {
		if ($separator === 'dash') $separator = '-';
		elseif ($separator === 'underscore') $separator = '_';

		$q_separator = preg_quote($separator, '#');

		$trans = [
			'ä' => 'a', 'ö' => 'o', 'ü' => 'u', 'ß' => 'ss',
			'Ä' => 'a', 'Ö' => 'o', 'Ü' => 'u',

			'á' => 'a', 'à' => 'a', 'â' => 'a', 'č' => 'c', 'ć' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e', 'ë' => 'e', 'í' => 'i', 'ĺ' => 'l',
			'ľ' => 'l', 'ň' => 'n', 'ó' => 'o', 'ô' => 'o', 'ŕ' => 'r', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ú' => 'u', 'ý' => 'y', 'ž' => 'z',

			'&.+?;' => '',     // HTML entities
			'[^\w\d _-]' => '', // Invalid chars
			'\s+' => $separator,
			'(' . $q_separator . ')+' => $separator
		];

		$str = strip_tags($str);
		foreach ($trans as $key => $val) {
			$str = preg_replace('#' . $key . '#i' . (UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase) {
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}

	public function search($query) {
		$orig_query = $query;
		$query = $this->db->escape_like_str($query);
		$results = [];

		$tipps_subcategories = $this->db->select('id, slug')->where('category_id', 102)->get('tipps_subcategories')->result_array();
		$neuigkeiten_subcategories = $this->db->select('id, slug')->where('category_id', 100)->get('neuigkeiten_subcategories')->result_array();
		$subcategory_slugs = array_merge($tipps_subcategories, $neuigkeiten_subcategories);
		$slug_map = [];
		foreach ($subcategory_slugs as $subcat) {
			$slug_map[$subcat['id']] = $subcat['slug'];
		}

		$this->db->select([
			'articles.id',
			'articles.category_id',
			'articles.title',
			'articles.slug',
			'articles.image',
			'articles.keywords',
			'articles.text',
			'articles.subcategory_id',
			'articles.subcategory_type',
			'articles.lang',
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
		error_log("Počet nájdených článkov: " . count($articles_results));

		$results = array_merge($results, $articles_results);

		$this->db->select([
			'article_sections.id',
			'article_sections.article_id',
			'article_sections.button_name as title',
			'article_sections.content',
			'articles.category_id',
			'articles.title as article_title',
			'articles.slug',
			'articles.image as article_image',
			'articles.subcategory_id',
			'articles.subcategory_type',
			'articles.lang',
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
		error_log("Počet nájdených sekcií: " . count($article_sections_results));

		$results = array_merge($results, $article_sections_results);

		$unique_results = [];
		$processed_ids = [];
		foreach ($results as $result) {
			$unique_key = $result['type'] . '|' . $result['id'];
			if ($result['type'] === 'article') {
				if (!isset($processed_ids[$result['id']])) {
					$processed_ids[$result['id']] = true;
					$unique_results[$unique_key] = $result;
				}
			} elseif ($result['type'] === 'article_section') {
				$section_key = $result['type'] . '|' . $result['article_id'] . '|' . $result['id'];
				if (!isset($processed_ids[$result['article_id']])) {
					$unique_results[$section_key] = $result;
				}
			}
		}
		$results = array_values($unique_results);
		error_log("Počet unikátnych výsledkov po deduplikácii: " . count($results));

		// Dočasne vypnutý fulltext filter
		/*
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
		*/
		error_log("Počet výsledkov po fulltext filtri (vypnutý): " . count($results));

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
		$this->load->helper('app');

		foreach ($results as &$result) {
			$slug = trim($result['slug'], '/');
			$title = $result['type'] === 'article' ? $result['title'] : ($result['article_title'] ?? '');
			$subcategory_id = $result['subcategory_id'] ?? null;

			if (empty($subcategory_id)) {
				$result['url'] = $slug;
			} else {
				$title_slug = $this->search_url_oprava($title);
				$result['url'] = $slug . '/' . $title_slug;
			}
		}





		return $results;
	}
}

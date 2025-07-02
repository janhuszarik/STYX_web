<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function search($query) {
		$orig_query = $query;
		$query = $this->db->escape_like_str($query);
		$results = [];

		// ========================
		// ARTICLES
		// ========================
		$this->db->select('
            articles.id,
            articles.title,
            articles.slug as url,
            articles.image,
            articles.keywords,
            articles.text,
            "article" as type
        ');
		$this->db->from('articles');
		$this->db->group_start();
		$this->db->like('articles.title', $query);
		$this->db->or_like('articles.text', $query);
		$this->db->or_like('articles.keywords', $query);
		$this->db->or_like('articles.slug', $query);
		$this->db->group_end();
		$articles_results = $this->db->get();
		$articles_results = $articles_results !== FALSE ? $articles_results->result_array() : [];
		$results = array_merge($results, $articles_results);

		// ========================
		// ARTICLE_SECTIONS
		// ========================
		$this->db->select('
            article_sections.id,
            article_sections.article_id,
            article_sections.button_name as title,
            article_sections.content,
            articles.title as article_title,
            articles.slug as url,
            articles.image as article_image,
            "article_section" as type
        ');
		$this->db->from('article_sections');
		$this->db->join('articles', 'articles.id = article_sections.article_id', 'left');
		$this->db->group_start();
		$this->db->like('article_sections.button_name', $query);
		$this->db->or_like('article_sections.content', $query);
		$this->db->group_end();
		$article_sections_results = $this->db->get();
		$article_sections_results = $article_sections_results !== FALSE ? $article_sections_results->result_array() : [];
		$results = array_merge($results, $article_sections_results);

		// ========================
		// DEDUPLIKÁCIA (unikátne záznamy podľa typu + id)
		// ========================
		$unique_results = [];
		foreach ($results as $result) {
			if ($result['type'] === 'article_section' && !empty($result['article_id'])) {
				$key = $result['type'].'|'.$result['article_id'];
			} else {
				$key = $result['type'].'|'.(isset($result['id']) ? $result['id'] : (isset($result['url']) ? $result['url'] : ''));
			}
			if (!isset($unique_results[$key])) {
				$unique_results[$key] = $result;
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
				if (in_array($field, ['title', 'text', 'keywords', 'content', 'description', 'article_title'])) {
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
		// Zoradenie podľa relevancie
		// ========================
		usort($results, function($a, $b) use ($lower_query) {
			$a_match = 0;
			$b_match = 0;
			foreach (['title', 'article_title'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 3;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 3;
			}
			foreach (['text', 'content', 'description'] as $f) {
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

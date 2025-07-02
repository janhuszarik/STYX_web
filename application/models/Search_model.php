<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function search($query) {
		$orig_query = $query; // pre PHP filter nižšie
		$query = $this->db->escape_like_str($query);
		$results = [];

		// --- Articles (title a content) ---
		$this->db->select('IFNULL(empfohlen_name1, CONCAT("Article ", id)) as title, content1 as content, empfohlen_url1 as url, "article" as type, id');
		$this->db->from('articles');
		$this->db->group_start();
		$this->db->like('empfohlen_name1', $query);
		$this->db->or_like('content1', $query);
		$this->db->group_end();
		$articles_results = $this->db->get();
		$articles_results = $articles_results !== FALSE ? $articles_results->result_array() : [];
		$results = array_merge($results, $articles_results);

		// --- Article categories (title) ---
		$this->db->select('ac.name as title, ac.id as id, IFNULL(m.url, ac.id) as url, "article_category" as type');
		$this->db->from('article_categories ac');
		$this->db->join('menu m', 'm.name = ac.name', 'left');
		$this->db->like('ac.name', $query);
		$article_categories_results = $this->db->get();
		$article_categories_results = $article_categories_results !== FALSE ? $article_categories_results->result_array() : [];
		foreach ($article_categories_results as &$cat) {
			if (strpos($cat['url'], 'http') === 0) {
				$cat['url'] = $cat['url'];
			} else {
				$cat['url'] = base_url() . 'de/' . str_replace(' ', '-', strtolower($cat['title']));
			}
		}
		$results = array_merge($results, $article_categories_results);

		// --- Article sections (title a content) ---
		$this->db->select('IFNULL(button_name, SUBSTRING_INDEX(content, "<", 1)) as title, content as content, IFNULL(article_link, external_url) as url, "article_section" as type, id');
		$this->db->from('article_sections');
		$this->db->group_start();
		$this->db->like('button_name', $query);
		$this->db->or_like('content', $query);
		$this->db->group_end();
		$article_sections_results = $this->db->get();
		$article_sections_results = $article_sections_results !== FALSE ? $article_sections_results->result_array() : [];
		$results = array_merge($results, $article_sections_results);

		// --- BestProduct (title a content) ---
		$this->db->select('name as title, aktion_name as content, url as url, "best_product" as type, id');
		$this->db->from('bestProduct');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('aktion_name', $query);
		$this->db->group_end();
		$best_product_results = $this->db->get();
		$best_product_results = $best_product_results !== FALSE ? $best_product_results->result_array() : [];
		foreach ($best_product_results as &$prod) {
			$prod['url'] = !empty($prod['url']) ? $prod['url'] : '#';
		}
		$results = array_merge($results, $best_product_results);

		// --- Locations (title a content) ---
		$this->db->select('name as title, CONCAT(opening_hours, " ", holidays) as content, website as url, "location" as type, id');
		$this->db->from('locations');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('CONCAT(opening_hours, " ", holidays)', $query);
		$this->db->group_end();
		$locations_results = $this->db->get();
		$locations_results = $locations_results !== FALSE ? $locations_results->result_array() : [];
		foreach ($locations_results as &$loc) {
			$loc['url'] = !empty($loc['url']) ? $loc['url'] : '#';
		}
		$results = array_merge($results, $locations_results);

		// --- Neuigkeiten subcategories (title) ---
		$this->db->select('name as title, id as url, "neuigkeiten_subcategory" as type, id');
		$this->db->from('neuigkeiten_subcategories');
		$this->db->like('name', $query);
		$neuigkeiten_results = $this->db->get();
		$neuigkeiten_results = $neuigkeiten_results !== FALSE ? $neuigkeiten_results->result_array() : [];
		foreach ($neuigkeiten_results as &$sub) {
			$sub['url'] = base_url() . 'news/category/' . $sub['id'];
		}
		$results = array_merge($results, $neuigkeiten_results);

		// --- News (title a content) ---
		$this->db->select('name as title, content as content, buttonUrl as url, "news" as type, id');
		$this->db->from('news');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('content', $query);
		$this->db->group_end();
		$news_results = $this->db->get();
		$news_results = $news_results !== FALSE ? $news_results->result_array() : [];
		foreach ($news_results as &$news) {
			$news['url'] = !empty($news['url']) ? $news['url'] : '#';
		}
		$results = array_merge($results, $news_results);

		// --- Unikátne výsledky (ID alebo URL) ---
		$unique_results = [];
		foreach ($results as $result) {
			$key = $result['type'] . '|' . ($result['type'] === 'article_section' ? $result['id'] : $result['url']);
			if (!isset($unique_results[$key]) && !empty($result['url']) && $result['url'] !== '#') {
				$unique_results[$key] = $result;
			}
		}
		$results = array_values($unique_results);

		// --- Filter: presná zhoda celej frázy v title alebo content (case-insensitive) ---
		$final_results = [];
		$lower_query = mb_strtolower($orig_query, 'UTF-8');
		foreach ($results as $res) {
			$haystack = '';
			if (!empty($res['title'])) $haystack .= ' ' . $res['title'];
			if (!empty($res['content'])) $haystack .= ' ' . $res['content'];
			$haystack = mb_strtolower($haystack, 'UTF-8');
			if (mb_strpos($haystack, $lower_query) !== false) {
				$final_results[] = $res;
			}
		}
		$results = $final_results;

		// --- Relevancia (zachovaj sort ak chceš) ---
		usort($results, function($a, $b) use ($lower_query) {
			$a_match = (mb_strpos(mb_strtolower($a['title'] ?? '', 'UTF-8'), $lower_query) !== false ? 2 : 0)
				+ (mb_strpos(mb_strtolower($a['content'] ?? '', 'UTF-8'), $lower_query) !== false ? 1 : 0);
			$b_match = (mb_strpos(mb_strtolower($b['title'] ?? '', 'UTF-8'), $lower_query) !== false ? 2 : 0)
				+ (mb_strpos(mb_strtolower($b['content'] ?? '', 'UTF-8'), $lower_query) !== false ? 1 : 0);
			return $b_match - $a_match;
		});

		return $results;
	}
}
?>

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
		// ARTICLES – úplný výber
		// ========================
		$this->db->select('
			id, 
			category_id, subcategory_id, lang, slug, title, subtitle, text, keywords, content1, meta, 
			gallery_id, image, image_title, slug_title, empfohlen_name1, empfohlen_name2, empfohlen_name3, 
			empfohlen_url1, empfohlen_url2, empfohlen_url3, 
			product_set1_product1_name, product_set1_product1_description, product_set1_product2_name, product_set1_product2_description, 
			product_set1_product3_name, product_set1_product3_description,
			product_set2_product1_name, product_set2_product1_description, product_set2_product2_name, product_set2_product2_description, 
			product_set2_product3_name, product_set2_product3_description,
			"article" as type
		');
		$this->db->from('articles');
		$this->db->group_start();
		// Všetky textové polia pre dôkladné vyhľadávanie
		$this->db->like('title', $query);
		$this->db->or_like('subtitle', $query);
		$this->db->or_like('text', $query);
		$this->db->or_like('keywords', $query);
		$this->db->or_like('content1', $query);
		$this->db->or_like('meta', $query);
		$this->db->or_like('slug', $query);
		$this->db->or_like('slug_title', $query);
		$this->db->or_like('empfohlen_name1', $query);
		$this->db->or_like('empfohlen_name2', $query);
		$this->db->or_like('empfohlen_name3', $query);
		$this->db->or_like('empfohlen_url1', $query);
		$this->db->or_like('empfohlen_url2', $query);
		$this->db->or_like('empfohlen_url3', $query);
		// Produkty v článkoch
		$this->db->or_like('product_set1_product1_name', $query);
		$this->db->or_like('product_set1_product1_description', $query);
		$this->db->or_like('product_set1_product2_name', $query);
		$this->db->or_like('product_set1_product2_description', $query);
		$this->db->or_like('product_set1_product3_name', $query);
		$this->db->or_like('product_set1_product3_description', $query);
		$this->db->or_like('product_set2_product1_name', $query);
		$this->db->or_like('product_set2_product1_description', $query);
		$this->db->or_like('product_set2_product2_name', $query);
		$this->db->or_like('product_set2_product2_description', $query);
		$this->db->or_like('product_set2_product3_name', $query);
		$this->db->or_like('product_set2_product3_description', $query);
		$this->db->group_end();
		$articles_results = $this->db->get();
		$articles_results = $articles_results !== FALSE ? $articles_results->result_array() : [];
		$results = array_merge($results, $articles_results);

		// ========================
		// ARTICLE_CATEGORIES
		// ========================
		$this->db->select('ac.id, ac.name as title, ac.slug, ac.lang, ac.active, ac.keywords, ac.description as description, IFNULL(m.url, ac.id) as url, "article_category" as type');
		$this->db->from('article_categories ac');
		$this->db->join('menu m', 'm.name = ac.name', 'left');
		$this->db->group_start();
		$this->db->like('ac.name', $query);
		$this->db->or_like('ac.slug', $query);
		$this->db->or_like('ac.keywords', $query);
		$this->db->or_like('ac.description', $query);
		$this->db->group_end();
		$article_categories_results = $this->db->get();
		$article_categories_results = $article_categories_results !== FALSE ? $article_categories_results->result_array() : [];
		foreach ($article_categories_results as &$cat) {
			if (strpos($cat['url'], 'http') !== false) {
				$cat['url'] = $cat['url'];
			} else {
				$cat['url'] = base_url() . 'de/' . str_replace(' ', '-', strtolower($cat['title']));
			}
		}
		$results = array_merge($results, $article_categories_results);

		// ========================
		// ARTICLE_SECTIONS
		// ========================
		$this->db->select('id, button_name as title, content, article_link as url, "article_section" as type');
		$this->db->from('article_sections');
		$this->db->group_start();
		$this->db->like('button_name', $query);
		$this->db->or_like('content', $query);
		$this->db->or_like('article_link', $query);
		$this->db->group_end();
		$article_sections_results = $this->db->get();
		$article_sections_results = $article_sections_results !== FALSE ? $article_sections_results->result_array() : [];
		$results = array_merge($results, $article_sections_results);

		// ========================
		// NEWS
		// ========================
		$this->db->select('id, name as title, name1, content, buttonUrl as url, "news" as type');
		$this->db->from('news');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('name1', $query);
		$this->db->or_like('content', $query);
		$this->db->or_like('buttonUrl', $query);
		$this->db->group_end();
		$news_results = $this->db->get();
		$news_results = $news_results !== FALSE ? $news_results->result_array() : [];
		foreach ($news_results as &$news) {
			$news['url'] = !empty($news['url']) ? $news['url'] : '#';
		}
		$results = array_merge($results, $news_results);


		// ========================
		// BEST PRODUCT
		// ========================
		$this->db->select('id, name as title, aktion_name as content, url, "best_product" as type');
		$this->db->from('bestProduct');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('aktion_name', $query);
		$this->db->or_like('url', $query);
		$this->db->group_end();
		$best_product_results = $this->db->get();
		$best_product_results = $best_product_results !== FALSE ? $best_product_results->result_array() : [];
		foreach ($best_product_results as &$prod) {
			$prod['url'] = !empty($prod['url']) ? $prod['url'] : '#';
		}
		$results = array_merge($results, $best_product_results);

		// ========================
		// LOCATIONS
		// ========================
		$this->db->select('id, name as title, CONCAT(opening_hours, " ", holidays) as content, website as url, "location" as type');
		$this->db->from('locations');
		$this->db->group_start();
		$this->db->like('name', $query);
		$this->db->or_like('opening_hours', $query);
		$this->db->or_like('holidays', $query);
		$this->db->or_like('website', $query);
		$this->db->group_end();
		$locations_results = $this->db->get();
		$locations_results = $locations_results !== FALSE ? $locations_results->result_array() : [];
		foreach ($locations_results as &$loc) {
			$loc['url'] = !empty($loc['url']) ? $loc['url'] : '#';
		}
		$results = array_merge($results, $locations_results);

		// ========================
		// NEUIGKEITEN SUBCATEGORIES
		// ========================
		$this->db->select('id, name as title, "" as content, "" as url, "neuigkeiten_subcategory" as type');
		$this->db->from('neuigkeiten_subcategories');
		$this->db->like('name', $query);
		$neuigkeiten_results = $this->db->get();
		$neuigkeiten_results = $neuigkeiten_results !== FALSE ? $neuigkeiten_results->result_array() : [];
		foreach ($neuigkeiten_results as &$sub) {
			$sub['url'] = base_url() . 'news/category/' . $sub['id'];
		}
		$results = array_merge($results, $neuigkeiten_results);

		// ========================
		// DEDUPLIKÁCIA (unikátne záznamy)
		// ========================
		$unique_results = [];
		foreach ($results as $result) {
			$key = $result['type'] . '|' . (isset($result['id']) ? $result['id'] : (isset($result['url']) ? $result['url'] : ''));
			if (!isset($unique_results[$key])) {
				$unique_results[$key] = $result;
			}
		}
		$results = array_values($unique_results);

		// ========================
		// PHP FULLTEXT filter – presná zhoda v textoch (case-insensitive)
		// ========================
		$final_results = [];
		$lower_query = mb_strtolower($orig_query, 'UTF-8');
		foreach ($results as $res) {
			$haystack = '';
			foreach ($res as $field => $value) {
				if (in_array($field, ['title', 'subtitle', 'text', 'keywords', 'content', 'content1', 'meta', 'description', 'empfohlen_name1', 'empfohlen_name2', 'empfohlen_name3', 'slug', 'slug_title', 'aktion_name', 'name', 'opening_hours', 'holidays'])) {
					$haystack .= ' ' . $value;
				}
				// Dynamicky pridaj všetky product_set polia
				if (strpos($field, 'product_set') === 0) {
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
		// Zoradenie podľa relevancie (match v title > content > description > ostatné)
		// ========================
		usort($results, function($a, $b) use ($lower_query) {
			$a_match = 0;
			$b_match = 0;
			foreach (['title', 'subtitle', 'name'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 3;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 3;
			}
			foreach (['text', 'content', 'content1', 'aktion_name'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 2;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 2;
			}
			foreach (['description', 'meta', 'keywords'] as $f) {
				if (isset($a[$f]) && mb_strpos(mb_strtolower($a[$f], 'UTF-8'), $lower_query) !== false) $a_match += 1;
				if (isset($b[$f]) && mb_strpos(mb_strtolower($b[$f], 'UTF-8'), $lower_query) !== false) $b_match += 1;
			}
			return $b_match - $a_match;
		});

		return $results;
	}
}
?>

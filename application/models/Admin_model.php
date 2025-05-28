<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

function getNewsletters(){

		$this->db->select('*');
		$this->db->where('active','1');
		return $this->db->get('newsletter')->result();

}

// MENU
	function menuSave($post = false)
	{
		if ($post) {
			// Nastavenie `orderBy` na `null` iba pre záznamy s rovnakým jazykom
			$this->db->where('orderBy', $post['orderBy']);
			$this->db->where('parent', $post['parent']);
			$this->db->where('lang', $post['lang']);
			$this->db->update('menu', array('orderBy' => null));

			$data = array(
				'name' => $post['name'],
				'url' => $post['url'],
				'parent' => $post['parent'],
				'orderBy' => $post['orderBy'],
				'active' => $post['active'],
				'lang' => $post['lang'],
				'base' => $post['base'], // pridali sme base
				'userId' => $this->ion_auth->user()->row()->id
			);

			if (is_numeric($post['id'])) {
				$data['updated_at'] = date('Y-m-d H:i:s');
				$this->db->where('id', $post['id']);
				return $this->db->update('menu', $data);
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				return $this->db->insert('menu', $data);
			}

		}
		return false;
	}


	function getMenu($id = false, $parent = false)
	{
		$this->db->select('m.*');

		if ($id == false) {
			if ($parent != false) {
				$this->db->where('m.parent', '');
			}

			$this->db->order_by('m.orderBy', 'ASC');
			return $this->db->get('menu as m')->result();
		} else {
			$this->db->where('m.id', $id);
			return $this->db->get('menu as m')->row();
		}
	}

	function getFullMenu()
	{
		$this->db->select('m.*');
		$this->db->where('m.parent', '0');
		$this->db->order_by('m.orderBy', 'ASC');
		$hmenu = $this->db->get('menu as m')->result();

		$menu = array();
		foreach ($hmenu as $key => $h) {
			$menu[$key] = $h;

			$this->db->select('m.*');
			$this->db->where('m.parent', $h->id);
			$this->db->order_by('m.orderBy', 'ASC');
			$submenu = $this->db->get('menu as m')->result();

			if (!empty($submenu)) {
				foreach ($submenu as $subkey => $s) {
					$menu[$key]->submenu[$subkey] = $s;
				}
			}
		}
		return $menu;
	}
	public function menuDelete($id) {

		$this->db->where('id', $id);
		return $this->db->delete('menu');

	}


	public function get_all_sliders() {
		$this->db->order_by('orderBy', 'ASC');
		return $this->db->get('slider')->result_array();
	}

	public function get_slider($id) {
		return $this->db->get_where('slider', array('id' => $id))->row_array();
	}

	public function save_slider_full($post = false, $image = false, $old_image = false, $id = null) {
		$data = array(
			'lang' => $post['lang'],
			'title' => $post['title'],
			'name1' => $post['name1'],
			'name2' => $post['name2'],
			'name3' => $post['name3'],
			'button_link' => $post['button_link'],
			'bg_color' => $post['bg_color'],
			'text_color' => $post['text_color'],
			'orderBy' => $post['orderBy'],
			'active' => $this->input->post('active'),
		);

		if ($image && !isset($image['error'])) {
			$data['image'] = basename($image);
		} else if ($old_image) {
			$data['image'] = $old_image;
		}

		if (!empty($id)) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			return $this->db->update('slider', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('slider', $data);
		}

	}

	public function get_slider_image_by_id($id) {
		$this->db->select('image');
		$this->db->where('id', $id);
		$row = $this->db->get('slider')->row();
		return $row ? $row->image : false;
	}



	public function delete_slider($id) {
		return $this->db->delete('slider', array('id' => $id));
	}



	public function is_order_by_duplicate($orderBy, $id = null) {
		$this->db->where('orderBy', $orderBy);
		if ($id) {
			$this->db->where('id !=', $id);
		}
		return $this->db->count_all_results('slider') > 0;
	}

	public function get_next_order_by() {
		$this->db->select_max('orderBy');
		$result = $this->db->get('slider')->row_array();
		return isset($result['orderBy']) ? $result['orderBy'] + 1 : 1;
	}



	function newsSave($post = false, $image = false, $old_image = false) {
		$data = array(
			'lang' => $this->input->post('lang'),
			'name' => $this->input->post('name'),
			'name1' => $this->input->post('name1'),
			'buttonUrl' => $this->input->post('buttonUrl'),
			'active' => $this->input->post('active'),
			'start_date' => $this->input->post('start_date') ?: date('Y-m-d'), // Ak nie je zadaný, použije aktuálny dátum
			'end_date' => $this->input->post('end_date') ?: NULL // Ak nie je zadaný, nastaví NULL
		);

		if ($image && !isset($image['error'])) {
			$data['image'] = $image['file_name'];
		} else if ($old_image) {
			$data['image'] = $old_image;
		}

		if (is_numeric($post['id'])) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('id', $post['id']);
			return $this->db->update('news', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('news', $data);
		}
	}


	function getNews($id = false)
	{

		if ($id == false) {
			$this->db->select('*');
			return $this->db->get('news')->result();

		} else {
			$this->db->select('*');
			$this->db->where('id', $id);
			return $this->db->get('news')->row();
		}
	}
	function newsDelete($id)
	{

		$this->db->where('id', $id);
		return $this->db->delete('news');

	}

	function bestProductSave($post = false, $image = false, $old_image = false) {
		$data = array(
			'lang'=> $this->input->post('lang'),
			'name' => $this->input->post('name'),
			'url' => $this->input->post('url'),
			'active' => $this->input->post('active'),
			'action' => $this->input->post('action'),
			'aktion_name' => $this->input->post('aktion_name'),
			'price' => $this->input->post('price'),
			'orderBy' => $this->input->post('orderBy'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date')
		);

		// Ak je nahraná nová fotka a neobsahuje chybu, nastavíme ju do dát
		if ($image && !isset($image['error'])) {
			$data['image'] = $image['file_name'];
		} else if ($old_image) {
			// Ak nie je nahraná nová fotka, ponecháme starú
			$data['image'] = $old_image;
		}

		if (is_numeric($post['id'])) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('id', $post['id']);
			return $this->db->update('bestProduct', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('bestProduct', $data);
		}

	}

	function getProduct($id = false)
	{

		if ($id == false) {
			$this->db->select('*');
			return $this->db->get('bestProduct')->result();

		} else {
			$this->db->select('*');
			$this->db->where('id', $id);
			return $this->db->get('bestProduct')->row();
		}
	}
	function bestProductDelete($id)
	{

		$this->db->where('id', $id);
		return $this->db->delete('bestProduct');

	}
	public function saveArticleCategory($post = false)
	{
		$data = [
			'name' => $post['name'],
			'slug' => url_title($post['name'], 'dash', true),
			'lang' => $post['lang'],
			'active' => $post['active'],
			'created_at' => date('Y-m-d H:i:s'),
			'keywords'    => $post['keywords'] ,
			'description' => $post['description']
		];

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('id', $post['id']);
			return $this->db->update('article_categories', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('article_categories', $data);
		}

	}

	public function getArticleCategories($id = false)
	{
		if ($id == false) {
			$this->db->select('*');
			return $this->db->get('article_categories')->result();
		} else {
			$this->db->select('*');
			$this->db->where('id', $id);
			return $this->db->get('article_categories')->row();
		}
	}


	public function deleteArticleCategory($id)
	{
		return $this->db->delete('article_categories', ['id' => $id]);
	}
	public function getArticlesByCategory($categoryId)
	{
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->result();
	}
	public function getArticleCategoriesWithCount()
	{
		$this->db->select('ac.*, COUNT(a.id) as article_count');
		$this->db->from('article_categories ac');
		$this->db->join('articles a', 'a.category_id = ac.id', 'left');
		$this->db->group_by('ac.id');
		return $this->db->get()->result();
	}
	public function getArticle($id)
	{
		return $this->db->get_where('articles', ['id' => $id])->row();
	}

	public function saveArticle($post)
	{
		$data = [
			'category_id' => $post['category_id'],
			'title' => $post['title'],
			'slug' => $post['slug'],
			'text' => $post['text'],
			'keywords' => $post['keywords'],
			'meta' => $post['meta'],
			'active' => $post['active'],
			'updated_at' => date('Y-m-d H:i:s')
		];

		if (!empty($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('articles', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('articles', $data);
		}
	}

	// ČLÁNKY
	public function getArticleStats()
	{
		$this->db->from('articles');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('articles', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('articles', 3)->result();

		return [
			'total' => $total,
			'last_title' => $last ? $last->title : '',
			'last_date' => $last ? date('d.m.Y', strtotime($last->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}

// MENU
	public function getMenuStats()
	{
		$this->db->from('menu');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('menu', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('menu', 3)->result();

		return [
			'total' => $total,
			'last_title' => $last ? $last->name : '',
			'last_date' => $last ? date('d.m.Y', strtotime($last->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}

// SLIDER
	public function getSliderStats()
	{
		$this->db->from('slider');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('slider', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('slider', 3)->result();

		// Najdi názov – skús name1, potom title, potom fallback
		$last_title = '';
		if ($last) {
			$last_title = $last->name1 ?: ($last->title ?: '[kein Titel]');
		}

		return [
			'total' => $total,
			'last_title' => $last_title,
			'last_date' => $last ? date('d.m.Y', strtotime($last->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}


// NEWS
	public function getNewsStats()
	{
		$this->db->from('news');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('news', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('news', 3)->result();

		return [
			'total' => $total,
			'last_title' => $last ? $last->name : '',
			'last_date' => $last ? date('d.m.Y', strtotime($last->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}


// BELIEBTE PRODUKTE
	public function getBestProductStats()
	{
		$this->db->from('bestProduct');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$top = $this->db->get('bestProduct', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('bestProduct', 3)->result();

		return [
			'total' => $total,
			'last_title' => $top ? $top->name : '',
			'last_date' => $top ? date('d.m.Y', strtotime($top->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}



	public function getArticleCategoryStats()
	{
		$this->db->from('article_categories');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('article_categories', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('article_categories', 3)->result();

		return [
			'total' => $total,
			'last_title' => $last ? ($last->title ?? $last->name) : '',
			'last_date' => $last ? date('d.m.Y', strtotime($last->updated_at ?? '')) : '',
			'recent' => $recent
		];
	}
	public function get_calendar_notes()
	{
		return $this->db->get('calendar_notes')->result();
	}








}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	function getNewsletters(){
		$this->db->select('*');
		$this->db->where('active','1');
		return $this->db->get('newsletter')->result();
	}

	function menuSave($post = false)
	{
		if ($post) {
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
				'base' => $post['base'],
				'userId' => $this->ion_auth->user()->row()->id
			);

			$isExternal = (strpos($post['url'], 'http://') === 0 || strpos($post['url'], 'https://') === 0);

			if (is_numeric($post['id'])) {
				$data['updated_at'] = date('Y-m-d H:i:s');
				$this->db->where('id', $post['id']);
				$existingMenu = $this->db->get('menu')->row();

				if (!$isExternal) {
					$slug = trim($post['url']);
					if (strpos($slug, $post['lang'] . '/') !== 0) {
						$slug = $post['lang'] . '/' . $slug;
					}
					$slug = preg_replace('#/' . preg_quote($post['lang'], '#') . '$#', '', $slug);
					$this->db->where('id', $post['id']);
					$this->db->update('menu', ['url' => $slug]);
				}
				$this->db->where('id', $post['id']);
				$this->db->update('menu', $data);
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('menu', $data);
				$insertId = $this->db->insert_id();

				if (!$isExternal) {
					$slug = $this->getFullSlugPathFromParent($insertId, $post['lang']);
					$this->db->where('id', $insertId);
					$this->db->update('menu', ['url' => $slug]);
				}
			}

			$this->load->model('Article_model');
			$this->Article_model->syncMenuWithArticleCategories();

			return true;
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

	public function menuDelete($id)
	{
		$this->db->where('menu_id', $id);
		$this->db->or_where('submenu_id', $id);
		$category = $this->db->get('article_categories')->row();

		if ($category) {
			$articleCount = $this->db->where('category_id', $category->id)
				->count_all_results('articles');
			if ($articleCount > 0) {
				$this->session->set_flashdata('error', 'Menüpunkt kann nicht gelöscht werden, da die zugeordnete Kategorie Artikel enthält.');
				return false;
			}

			$this->db->where('id', $category->id);
			$this->db->delete('article_categories');
		}

		$this->db->where('id', $id);
		return $this->db->delete('menu');
	}

	private function getFullSlugPathFromParent($menuId, $lang = 'de')
	{
		$segments = [];
		$currentMenuId = $menuId;

		while ($currentMenuId && $currentMenuId != '0') {
			$row = $this->db->select('id, parent, name, url, lang')
				->where('id', $currentMenuId)
				->get('menu')
				->row();
			if (!$row) break;

			$cleanSegment = !empty($row->url) ? $row->url : url_oprava($row->name);
			$cleanSegment = preg_replace('#^(de|sk|en)(/app)?/#', '', trim($cleanSegment, '/'));
			if (!empty($cleanSegment) && !in_array($cleanSegment, $segments)) {
				array_unshift($segments, $cleanSegment);
			}

			$currentMenuId = $row->parent;
		}

		$segments = array_unique($segments);

		if (empty($segments)) {
			$finalSlug = $lang . '/';
		} else {
			$finalSlug = $lang . '/' . implode('/', $segments);
		}

		$finalSlug = preg_replace('#^(de|sk|en)/(de|sk|en)/#', '$1/', $finalSlug);
		$finalSlug = preg_replace('#//+#', '/', $finalSlug);
		$finalSlug = trim($finalSlug, '/');

		return $finalSlug;
	}

	private function getParentSlug($parentId, $lang = 'de')
	{
		if ($parentId == 0) return '';
		$parent = $this->db->select('url')
			->where('id', $parentId)
			->get('menu')
			->row();
		if ($parent && !empty($parent->url)) {
			return preg_replace('#^(de|sk|en)/#', '', trim($parent->url, '/'));
		}
		return '';
	}

	public function urlExists($url, $excludeId = null)
	{
		$this->db->where('url', $url);
		if ($excludeId) {
			$this->db->where('id !=', $excludeId);
		}
		$query = $this->db->get('menu');
		return $query->num_rows() > 0;
	}

	public function get_all_sliders() {
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->order_by('orderBy', 'ASC');
		return $this->db->get()->result();
	}

	public function get_slider($id) {
		if (!is_numeric($id)) {
			return null;
		}
		$this->db->select('*');
		$this->db->from('slider');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : null;
	}

	public function get_slider_image_by_id($id) {
		if (!is_numeric($id)) {
			return null;
		}
		$this->db->select('image');
		$this->db->from('slider');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row()->image : null;
	}

	public function save_slider_full($post, $image = false, $id = null) {
		$data = array(
			'lang' => $this->db->escape_str($post['lang'] ?? 'de'),
			'title' => $this->db->escape_str($post['title'] ?? ''),
			'name2' => $this->db->escape_str($post['name2'] ?? ''),
			'button_link' => $this->db->escape_str($post['button_link'] ?? ''),
			'bg_color' => $this->db->escape_str($post['bg_color'] ?? '#ffffff'),
			'text_color' => $this->db->escape_str($post['text_color'] ?? '#000000'),
			'orderBy' => is_numeric($post['orderBy']) ? (int)$post['orderBy'] : 0,
			'active' => $post['active'],
		);

		if ($image && !isset($image['error']) && isset($image['file_name'])) {
			$data['image'] = $image['file_name'];
		}

		if (!empty($id) && is_numeric($id)) {
			$existing_slider = $this->get_slider($id);
			if (!$existing_slider) {
				return false;
			}

			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			return $this->db->update('slider', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('slider', $data);
		}
	}

	public function delete_slider($id) {
		if (!is_numeric($id)) {
			return false;
		}
		$slider = $this->get_slider($id);
		if (!$slider) {
			return false;
		}
		if ($slider->image && file_exists(FCPATH . 'uploads/sliders/' . $slider->image)) {
			unlink(FCPATH . 'uploads/sliders/' . $slider->image);
		}
		$this->db->where('id', $id);
		return $this->db->delete('slider');
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
			'start_date' => $this->input->post('start_date') ?: date('Y-m-d'),
			'end_date' => $this->input->post('end_date') ?: NULL,
			'order_by' => $this->input->post('order_by')
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

	function getNews($id = false) {
		if ($id == false) {
			$this->db->select('*');
			$this->db->order_by('order_by', 'ASC');
			return $this->db->get('news')->result();
		} else {
			$this->db->select('*');
			$this->db->where('id', $id);
			return $this->db->get('news')->row();
		}
	}

	function newsDelete($id) {
		$this->db->where('id', $id);
		return $this->db->delete('news');
	}

	function bestProductSave($post = false, $image = false, $old_image = false)
	{
		$data = array(
			'lang' => $this->input->post('lang'),
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

		if ($image && !isset($image['error'])) {
			$data['image'] = $image['file_name']; // Použije se plná relativní cesta
		} else if ($old_image) {
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
		if ($id === false) {
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
		$product = $this->getProduct($id);
		$this->db->where('id', $id);
		$result = $this->db->delete('bestProduct');
		return $result;
	}

	public function saveArticleCategory($post = false)
	{
		$data = [
			'name' => $post['name'],
			'slug' => url_title($post['name'], 'dash', true),
			'lang' => $post['lang'],
			'active' => $post['active'],
			'created_at' => date('Y-m-d H:i:s'),
			'keywords'    => $post['keywords'],
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

	public function getSliderStats()
	{
		$this->db->from('slider');
		$total = $this->db->count_all_results();

		$this->db->order_by('updated_at', 'DESC');
		$last = $this->db->get('slider', 1)->row();

		$this->db->order_by('updated_at', 'DESC');
		$recent = $this->db->get('slider', 3)->result();

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

	public function getGalleryStats() {
		$this->db->select('COUNT(*) as total');
		$query = $this->db->get('galleries');
		$total = $query->row()->total;

		$this->db->select('name, created_at');
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('galleries');
		$last = $query->row();

		$last_title = $last ? $last->name : '';
		$last_date = $last && $last->created_at ? date('d.m.Y', strtotime($last->created_at)) : '';

		$this->db->select('name');
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(3);
		$recent = $this->db->get('galleries')->result();

		$recent = array_map(function($item) {
			$item->title = $item->name;
			unset($item->name);
			return $item;
		}, $recent);

		return [
			'total' => $total,
			'last_title' => $last_title,
			'last_date' => $last_date,
			'recent' => $recent
		];
	}
}

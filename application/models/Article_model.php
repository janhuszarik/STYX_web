<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model
{
	public function saveArticleCategory($post = false)
	{
		$data = [
			'name' => $post['name'],
			'slug' => url_title($post['name'], 'dash', true),
			'lang' => $post['lang'],
			'active' => $post['active'],
			'created_at' => date('Y-m-d H:i:s'),
			'keywords' => $post['keywords'],
			'description' => $post['description']
		];

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('article_categories', $data);
		} else {
			return $this->db->insert('article_categories', $data);
		}
	}

	public function getArticleCategories($id = false)
	{
		if ($id === false) {
			return $this->db->get('article_categories')->result();
		} else {
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
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('articles')->result();
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
		$image = null;
		if (!empty($_FILES['image']['name'])) {
			$this->load->helper('app_helper');
			$uploadPath = uploadImg('image', 'uploads/articles');
			if (!empty($uploadPath)) {
				$image = basename($uploadPath); // uloží len názov súboru
			}
		}


		$data = [
			'category_id' => $post['category_id'],
			'title' => $post['title'],
			'subtitle' => $post['subtitle'],
			'slug' => url_title($post['title'], 'dash', true),
			'image' => $image ?? ($post['old_image'] ?? null),
			'text' => $post['text'],
			'keywords' => $post['keywords'],
			'meta' => $post['meta'],
			'active' => isset($post['active']) ? 1 : 0,
			'start_date_from' => !empty($post['start_date_from']) ? $post['start_date_from'] : null,
			'end_date_to' => !empty($post['end_date_to']) ? $post['end_date_to'] : null,
			'updated_at' => date('Y-m-d H:i:s')
		];

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('articles', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('articles', $data);
		}
	}

	public function deleteArticle($id)
	{
		return $this->db->delete('articles', ['id' => $id]);
	}
}

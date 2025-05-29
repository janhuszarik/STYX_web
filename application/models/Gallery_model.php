<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Gallery_model extends CI_Model
{
	function getAllCategories($search = null)
	{
		if ($search) {
			$this->db->like('name', $search);
		}
		$this->db->order_by('id', 'DESC');
		return $this->db->get('gallery_categories')->result();
	}

	function getCategory($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('gallery_categories')->row();
	}

	function saveCategory($post)
	{
		$data = [
			'name' => $post['name'],
			'lang' => $post['lang'],
			'keywords' => $post['keywords'],
			'description' => $post['description'],
			'active' => $post['active'] ? 1 : 0
		];

		$id = isset($post['id']) ? $post['id'] : null;

		if (is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('gallery_categories', $data);
		} else {
			return $this->db->insert('gallery_categories', $data);
		}
	}

	function deleteCategory($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('gallery_categories');
	}
}

<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

class Gallery_model extends CI_Model
{
	function getAllCategories($search = null)
	{
		$this->db->select('gallery_categories.*, COUNT(galleries.id) as gallery_count');
		$this->db->from('gallery_categories');
		$this->db->join('galleries', 'galleries.category_id = gallery_categories.id', 'left');
		if ($search) {
			$this->db->like('gallery_categories.name', $search);
		}
		$this->db->group_by('gallery_categories.id');
		$this->db->order_by('gallery_categories.id', 'DESC');
		return $this->db->get()->result();
	}

	function getCategory($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('gallery_categories')->row();
	}

	function getGalleriesByCategoryId($category_id)
	{
		$this->db->select('galleries.*, COUNT(gallery_images.id) as image_count');
		$this->db->from('galleries');
		$this->db->join('gallery_images', 'gallery_images.gallery_id = galleries.id', 'left');
		$this->db->where('galleries.category_id', $category_id);
		$this->db->group_by('galleries.id');
		$this->db->order_by('galleries.id', 'DESC');
		return $this->db->get()->result();
	}

	function getImagesByGalleryId($gallery_id)
	{
		$this->db->where('gallery_id', $gallery_id);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('gallery_images')->result();
	}

	function getGallery($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('galleries')->row();
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
		$this->db->where('category_id', $id);
		$count = $this->db->count_all_results('galleries');
		if ($count > 0) {
			return false;
		}
		$this->db->where('id', $id);
		return $this->db->delete('gallery_categories');
	}

	function saveGallery($post)
	{
		$data = [
			'category_id' => $post['category_id'],
			'name' => $post['name'],
			'active' => isset($post['active']) ? ($post['active'] ? 1 : 0) : 1
		];

		$id = isset($post['id']) ? $post['id'] : null;

		if (is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('galleries', $data);
		} else {
			return $this->db->insert('galleries', $data);
		}
	}

	function deleteGallery($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('galleries');
	}
}

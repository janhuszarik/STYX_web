<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopfind_model extends CI_Model
{
	public function saveLocation($post = false)
	{
		$data = [
			'name' => $post['name'],
			'contact_person' => $post['contact_person'] ?? '',
			'address' => $post['address'],
			'zip_code' => $post['zip_code'],
			'city' => $post['city'],
			'state' => $post['state'] ?? '',
			'country' => $post['country'],
			'email' => $post['email'] ?? '',
			'phone' => $post['phone'] ?? '',
			'website' => $post['website'] ?? '',
			'opening_hours' => $post['opening_hours'] ?? '',
			'latitude' => $post['latitude'],
			'longitude' => $post['longitude'],
			'logo' => $post['logo'] ?? '',
			'active' => isset($post['active']) ? 1 : 0,
			'updated_at' => date('Y-m-d H:i:s')
		];


		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('locations', $data);
		} else {
			return $this->db->insert('locations', $data);
		}
	}

	public function getAllLocations()
	{
		$this->db->order_by('name', 'ASC');
		return $this->db->get('locations')->result();
	}

	public function getLocation($id)
	{
		return $this->db->get_where('locations', ['id' => $id])->row();
	}

	public function deleteLocation($id)
	{
		return $this->db->delete('locations', ['id' => $id]);
	}
}


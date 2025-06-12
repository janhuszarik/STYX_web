<?php
// application/models/Shopfind_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shopfind_model extends CI_Model
{
	public function saveLocation($data)
	{
		$location_data = [
			'name' => $data['name'],
			'contact_person' => $data['contact_person'] ?? '',
			'address' => $data['address'],
			'zip_code' => $data['zip_code'],
			'city' => $data['city'],
			'state' => $data['state'] ?? '',
			'country' => $data['country'],
			'email' => $data['email'] ?? '',
			'phone' => $data['phone'] ?? '',
			'website' => $data['website'] ?? '',
			'opening_hours' => $data['opening_hours'] ?? '',
			'latitude' => $data['latitude'] ?: null,
			'longitude' => $data['longitude'] ?: null,
			'active' => $data['active'] ?? 0,
			'updated_at' => date('Y-m-d H:i:s')
		];

		// Spracovanie loga
		if (!empty($data['logo'])) {
			$location_data['logo'] = $data['logo'];
		} elseif (!empty($data['id'])) {
			// Zachovať existujúce logo, ak nebolo nahraté nové
			$existing = $this->getLocation($data['id']);
			if ($existing && !empty($existing->logo)) {
				$location_data['logo'] = $existing->logo;
			} else {
				$location_data['logo'] = null;
			}
		}

		if (!empty($data['id']) && is_numeric($data['id'])) {
			$this->db->where('id', $data['id']);
			return $this->db->update('locations', $location_data);
		} else {
			$location_data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('locations', $location_data);
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
		// Najskôr získame cestu k logu, aby sme ho mohli vymazať
		$location = $this->getLocation($id);
		if ($location && !empty($location->logo)) {
			$logo_path = './Uploads/' . $location->logo;
			if (file_exists($logo_path)) {
				unlink($logo_path);
			}
		}

		return $this->db->delete('locations', ['id' => $id]);
	}
}

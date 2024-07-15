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
			$this->db->where('orderBy', $post['orderBy']);
			$this->db->where('parent', $post['parent']);
			$this->db->update('menu', array('orderBy' => null));

			$data = array(
				'name' => $post['name'],
				'url' => $post['url'],
				'parent' => $post['parent'],
				'orderBy' => $post['orderBy'],
				'active' => $post['active'],
				'lang' => $post['lang'],
				'userId' => $this->ion_auth->user()->row()->id
			);

			if (is_numeric($post['id'])) {
				$this->db->where('id', $post['id']);
				return $this->db->update('menu', $data);
			} else {
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
		$this->db->order_by('orderBy', 'ASC'); // Order by orderBy field
		return $this->db->get('slider')->result_array();
	}

	public function get_slider($id) {
		return $this->db->get_where('slider', array('id' => $id))->row_array();
	}

	public function save_slider($data, $id = null) {
		if ($id) {
			$this->db->where('id', $id);
			$result = $this->db->update('slider', $data);
			log_message('debug', 'Update result: ' . $result);
			return $result;
		} else {
			$result = $this->db->insert('slider', $data);
			log_message('debug', 'Insert result: ' . $result);
			return $result;
		}
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



	function newsSave($post = false)
	{

		$data = array(
		'name' => $this->input->post('name'),
		'name1' => $this->input->post('name1'),
		'buttonName' => $this->input->post('buttonName'),
		'buttonUrl' => $this->input->post('buttonUrl'),
		'active' => $this->input->post('active'),
		);

		if (is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('news', $data);
		} else {
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
}

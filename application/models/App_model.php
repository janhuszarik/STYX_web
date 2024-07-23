<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_model extends CI_Model
{


	function routes($lang)
	{

		if ($this->uri->segment('2') == NULL) {
			$url = $this->uri->segment('1');
		} else {
			$url = $this->uri->segment('2');
		}
		$this->db->select('*');
		$this->db->where('lang', $lang);
		$this->db->where('url', $url);
		$article = $this->db->get('articles')->row();

//        ddd($article);
		return $article;
	}

	function getUser($id = false)
	{

		$this->db->select('*');
		$this->db->where('id', $id);
		return $this->db->get('users')->row();

	}


	public function getSliders($onlyActive = false)
	{
		$this->db->select('*');
		if ($onlyActive) {
			$this->db->where('active', '1');
		}
		$this->db->where('lang', language());
		$this->db->order_by('orderBy', 'ASC'); // Sort by orderBy

		return $this->db->get('slider')->result();
	}


	function getAllActiveNews()
	{
		$this->db->select('*');
		$this->db->where('active', '1');
		$this->db->where('lang', language());
		$this->db->where('start_date <=', date('Y-m-d H:i:s'));
		$this->db->where('end_date >=', date('Y-m-d H:i:s'));
		return $this->db->get('news')->result(); // upravené
	}

	function getAllActiveProduct()
	{
		$this->db->select('*');
		$this->db->where('active', '1');
		$this->db->where('lang', language());
		$this->db->where('start_date <=', date('Y-m-d H:i:s'));
		$this->db->where('end_date >=', date('Y-m-d H:i:s'));
		$this->db->order_by('orderBy', 'ASC');
		return $this->db->get('bestProduct')->result();
	}

	public function getCommentKosmetic()
	{
		$this->db->select('*');
		$this->db->where('section_id', 'Naturkosmetik');
		$this->db->where('active', '1');
		$this->db->where('lang', language());
		return $this->db->get('comments')->result();
	}
	public function sumCommentKosmetic()
	{
		$this->db->where('section_id', '1');
		$this->db->where('lang', language());
		return $this->db->count_all_results('comments');
	}


	public function naturkosmetik($data)
	{
		$data = array(
			'lang' => language(),
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'comment' => $this->input->post('comment'),
			'section_id' => $this->input->post('section_id'),
			'consent' => $this->input->post('consent'),
			'active' => $this->input->post('active'),
		);

		return $this->db->insert('comments', $data);
	}






//_________________________________________________________________________________________________


//
//
//
//	function getCounter(){
//
//		$this->db->select('*');                            // Vyber všetky záznamy z databázy
//		$this->db->where('id', 1);                        // Ktoré sú v riadku s id:1
//		return $this->db->get('counter')->row();            // V tabuľke databázy s názvom "settings" a
//
//	}
//
//	function getAboutUs(){
//
//		$this->db->select('*');                            // Vyber všetky záznamy z databázy
//		$this->db->where('id', 1);
//
//		return $this->db->get('aboutUs')->row();            // V tabuľke databázy s názvom "settings" a
//
//	}
//	function getGalleryByTestimonial(){
//		$this->db->select('*');
//		$this->db->where('category', 3);
//		return $this->db->get('photos')->result();
//	}
//	function getGalleryByHome(){
//		$this->db->select('*');
//		$this->db->where('category', 4);
//		return $this->db->get('photos')->result();
//	}
//	function getReview($id = false){
//
//
//		if ($id == false) {
//			$this->db->select('*');
//			return $this->db->get('reviews')->result();
//
//		} else {
//			$this->db->select('*');
//			$this->db->where('id', $id);
//			return $this->db->get('reviews')->row();
//		}
//	}
//	function userAll($post = false){
//		$id = $this->input->post('id');
//
//		if (!empty($post['id'])) {
//
//			if (!empty($_FILES['image']['name'])) {
//				$imageUrl = uploadImg('image', 'uploads', 'profilova_fotka', '800');
//				if (!empty($post['oldImage'])) {
//					unlink($post['oldImage']);
//				}
//			} else {
//				$imageUrl = $post['oldImage'];
//			}
//
//			$data = array(
//
//				'avatar' => $imageUrl,
//				'username' => string_replaceToDb($this->input->post('username')),
//				'email' => string_replaceToDb($this->input->post('email')),
//				'first_name' => string_replaceToDb($this->input->post('first_name')),
//				'last_name' => string_replaceToDb($this->input->post('last_name')),
//				'phone' => string_replaceToDb($this->input->post('phone')),
//				'user_id' => $this->ion_auth->user()->row()->id,
//				'birth' => string_replaceToDb($this->input->post('birth')),
//				'svn' => string_replaceToDb($this->input->post('svn')),
//				'address' => string_replaceToDb($this->input->post('address')),
//				'city' => string_replaceToDb($this->input->post('city')),
//				'zipCode' => string_replaceToDb($this->input->post('zipCode')),
//				'land' => string_replaceToDb($this->input->post('land'))
//
//			);
//
//			if (is_numeric($id)) {
//				$this->db->where('user_id', $id);
//				return $this->db->update('users', $data);
//			} else {
//				return $this->db->insert('users', $data);
//			}
//		}
//
//
//	function getUserAll ($id = false) {
//
//		if ($id == false){
//			$this->db->select('*');
//			return $this->db->get('users')->result();
//
//		}else {
//			$this->db->select('*');
//			$this->db->where('id',$id);
//			return $this->db->get('users')->row();
//		}
//
////			$this->db->select('p.*');
////			$this->db->where('p.active','1');
////			$this->db->like('p.name', $search,'both');
////			$this->db->or_like('p.short_text', $search,'both');
////			$this->db->group_by("p.id");
////			$products = $this->db->get('products as p')->result();
//
//
//	}
//	function getSlider($active = false){
//
//		$this->db->select('*');
//		if ($active){
//			$this->db->where('active','1');
//		}
//		return $this->db->get('sliders')->result();
//
//	}



}

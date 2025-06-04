<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_model extends CI_Model
{

	function routes($lang)
	{
		// poskladáme celý slug z segmentov
		$segment1 = $this->uri->segment(2);
		$segment2 = $this->uri->segment(3);
		$url = $segment1 . '/' . $segment2; // napr. 'app/Nachhaltigkeit-Philosophie'

		$this->db->select('*');
		$this->db->where('lang', $lang);
		$this->db->where('slug', $url); // porovná s 'app/Nachhaltigkeit-Philosophie'
		$this->db->where('active', 1);
		return $this->db->get('articles')->row();
	}
	public function getSections($articleId)
	{
		return $this->db
			->where('article_id', $articleId)
			->order_by('order', 'ASC')
			->get('article_sections')
			->result();
	}
	public function getExactArticle($slug_title, $lang)
	{
		$this->db->select('*');
		$this->db->where('slug_title', $slug_title); // <== TOTO je kľúčové!
		$this->db->where('lang', $lang);
		$this->db->where('active', 1);
		return $this->db->get('articles')->row();
	}



	public function getCategoryBySlug($slug, $lang)
	{
		$this->db->select('ac.*');
		$this->db->from('article_categories ac');
		$this->db->where('ac.slug', $lang . '/' . $slug);
		$this->db->where('ac.lang', $lang);
		$this->db->where('ac.active', 1);
		return $this->db->get()->row();
	}

	public function getArticlesByCategory($categoryId, $lang)
	{
		$this->db->select('a.*');
		$this->db->from('articles a');
		$this->db->where('a.category_id', $categoryId);
		$this->db->where('a.lang', $lang);
		$this->db->where('a.active', 1);
		$this->db->where('a.start_date_from IS NULL OR a.start_date_from <=', date('Y-m-d H:i:s'));
		$this->db->where('a.end_date_to IS NULL OR a.end_date_to >=', date('Y-m-d H:i:s'));
		$this->db->order_by('a.is_main DESC, a.created_at DESC');
		return $this->db->get()->result();
	}

	public function getArticlesBySlug($slug, $lang)
	{
		$this->db->select('a.*');
		$this->db->from('articles a');
		$this->db->join('article_categories ac', 'a.category_id = ac.id');
		$this->db->where('ac.slug', $lang . '/' . $slug);
		$this->db->where('a.lang', $lang);
		$this->db->where('a.active', 1);
		$this->db->where('a.start_date_from IS NULL OR a.start_date_from <=', date('Y-m-d H:i:s'));
		$this->db->where('a.end_date_to IS NULL OR a.end_date_to >=', date('Y-m-d H:i:s'));
		$this->db->order_by('a.is_main DESC, a.created_at DESC');
		return $this->db->get()->result();
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
		$this->db->from('news');
		$this->db->where('active', '1');
		$this->db->where('lang', language());
		$this->db->where('start_date IS NULL OR start_date <=', date('Y-m-d'));
		$this->db->where('end_date IS NULL OR end_date >=', date('Y-m-d'));
		$this->db->order_by('start_date', 'DESC');
		return $this->db->get()->result();
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

	public function naturkosmetik()
	{
		$data = array(
			'lang' => $this->input->post('lang'),
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'comment' => $this->input->post('comment'),
			'section_id' => $this->input->post('section_id'),
			'consent' => $this->input->post('consent'),
			'active' => $this->input->post('active'),
		);

		return $this->db->insert('comments', $data);
	}








}

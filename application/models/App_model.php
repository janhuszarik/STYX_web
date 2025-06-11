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



	public function sendContactMail($data)
	{
		$this->load->library('email');

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = SMTP;
		$config['smtp_user'] = SMTP_NAME;
		$config['smtp_pass'] = SMTP_PASS;
		$config['smtp_port'] = SMTP_PORT;
		$config['smtp_crypto'] = 'ssl';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";

		$this->email->initialize($config);

		$this->email->from(SMTP_NAME, 'Website Kontaktformular');
		$this->email->to(MAIL_ADMIN);
		$this->email->bcc(MAIL_MODERATOR);

		$this->email->subject('Neue Kontaktanfrage');
		$message = '
		<b>Name:</b> ' . htmlspecialchars($data['name']) . '<br>
		<b>Adresse:</b> ' . htmlspecialchars($data['adresse']) . '<br>
		<b>Telefon:</b> ' . htmlspecialchars($data['telefon']) . '<br>
		<b>E-Mail:</b> ' . htmlspecialchars($data['email']) . '<br>
		<b>Ich bin ein:</b> ' . htmlspecialchars($data['typ']) . '<br><br>
		<b>Nachricht:</b><br>' . nl2br(htmlspecialchars($data['nachricht'])) . '<br><br>
		<b>Datum:</b> ' . htmlspecialchars($data['datum']) . '
	';

		$this->email->message($message);
		return $this->email->send();
	}









}

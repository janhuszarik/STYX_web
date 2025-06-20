<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model
{

	function routes($lang)
	{
		$segment1 = $this->uri->segment(2);
		$segment2 = $this->uri->segment(3);
		$url = $segment1 . '/' . $segment2;

		$this->db->select('*');
		$this->db->where('lang', $lang);
		$this->db->where('slug', $url);
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
		$this->db->where('slug_title', $slug_title);
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
		$this->db->order_by('a.orderBy', 'ASC');
		$this->db->order_by('a.created_at', 'DESC');
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
		$this->db->order_by('a.orderBy', 'ASC');
		$this->db->order_by('a.created_at', 'DESC');
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
		$this->db->order_by('orderBy', 'ASC');
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

		$config['protocol']    = 'smtp';
		$config['smtp_host']   = SMTP;
		$config['smtp_user']   = SMTP_NAME;
		$config['smtp_pass']   = SMTP_PASS;
		$config['smtp_port']   = SMTP_PORT;
		$config['smtp_crypto'] = 'ssl';
		$config['mailtype']    = 'html';
		$config['charset']     = 'utf-8';
		$config['newline']     = "\r\n";

		$this->email->initialize($config);

		$this->email->from(SMTP_NAME, 'STYX Kontaktformular');
		$this->email->to(MAIL_ADMIN);
		$this->email->bcc(MAIL_MODERATOR);
		$this->email->reply_to($data['email'], $data['name']);
		$this->email->subject('Neue Kontaktanfrage über das Formular');

		$adminMessage = $this->load->view('emails/contact_admin', $data, TRUE);
		$this->email->message($adminMessage);
		$adminSent = $this->email->send();

		$this->email->clear();
		$this->email->from(SMTP_NAME, 'STYX Naturcosmetic');
		$this->email->to($data['email']);
		$this->email->subject('Vielen Dank für Ihre Anfrage');
		$userMessage = $this->load->view('emails/contact_reply', [
			'name' => $data['name']
		], TRUE);
		$this->email->message($userMessage);
		$userSent = $this->email->send();

		return $adminSent && $userSent;
	}

	public function getLocations()
	{
		$this->db->where('active', 1);
		$this->db->order_by('name', 'ASC');
		return $this->db->get('locations')->result();
	}
	public function sendKindergeburtstagMail($data)
	{
		$this->load->library('email');

		$this->email->from(MAIL_ADMIN, 'STYX Geburtstage');
		$this->email->to(MAIL_ADMIN); // alebo vlastný email

		$this->email->subject('Neue Kindergeburtstag Anfrage');

		$message = "<h3>Neue Kindergeburtstag Anfrage</h3>";
		$message .= "<p><strong>Datum:</strong> {$data['event_date']} um {$data['event_time']}</p>";
		$message .= "<p><strong>Kind:</strong> {$data['child_name']} ({$data['child_age']} Jahre alt)</p>";
		$message .= "<p><strong>Anzahl Kinder:</strong> {$data['num_children']}</p>";
		$message .= "<p><strong>Kontaktperson:</strong> {$data['contact_person']}</p>";
		$message .= "<p><strong>Email:</strong> {$data['email']}</p>";
		$message .= "<p><strong>Telefon:</strong> {$data['phone']}</p>";
		$message .= "<p><strong>Adresse:</strong> {$data['address']}, {$data['zip_city']}</p>";
		$message .= "<p><strong>Paket:</strong> {$data['paket']}</p>";
		$message .= "<p><strong>Torte:</strong> {$data['torte']}</p>";
		$message .= "<p><strong>Jause:</strong> {$data['jause']}</p>";
		if (!empty($data['notes'])) {
			$message .= "<p><strong>Anmerkung:</strong><br>" . nl2br($data['notes']) . "</p>";
		}

		$this->email->set_mailtype('html');
		$this->email->message($message);

		return $this->email->send();
	}

}

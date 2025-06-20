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
	public function send_kindergeburtstage()
	{
		$this->load->library('form_validation');
		$this->load->library('email');

		// Form validation rules
		$this->form_validation->set_rules('event_date', 'Datum', 'required');
		$this->form_validation->set_rules('event_time', 'Uhrzeit', 'required');
		$this->form_validation->set_rules('child_name', 'Kind', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('child_age', 'Alter', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('num_children', 'Kinderanzahl', 'required|integer|greater_than[0]|less_than_equal_to[15]');
		$this->form_validation->set_rules('contact_person', 'Kontaktperson', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('email', 'E-Mail', 'required|valid_email|max_length[100]');
		$this->form_validation->set_rules('phone', 'Telefonnummer', 'required|trim|max_length[30]');
		$this->form_validation->set_rules('address', 'Adresse', 'required|trim|max_length[150]');
		$this->form_validation->set_rules('zip_city', 'Ort', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('paket', 'Paket', 'required|in_list[shampoo_badesalz,schokolade]');
		$this->form_validation->set_rules('torte', 'Torte', 'required|in_list[ja]');
		$this->form_validation->set_rules('jause', 'Jause', 'required|in_list[wurst,toast]');
		$this->form_validation->set_rules('notes', 'Anmerkung', 'trim|max_length[500]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		// reCAPTCHA validation
		$recaptcha_response = $this->input->post('g-recaptcha-response');
		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Bitte bestätigen Sie das reCAPTCHA.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . SECRETKEY . "&response=" . $recaptcha_response);
		$response = json_decode($verify);

		if (!$response->success) {
			$this->session->set_flashdata('error', 'reCAPTCHA Überprüfung fehlgeschlagen.');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}

		// Form data
		$data = [
			'event_date' => $this->input->post('event_date', true),
			'event_time' => $this->input->post('event_time', true),
			'child_name' => $this->input->post('child_name', true),
			'child_age' => $this->input->post('child_age', true),
			'num_children' => $this->input->post('num_children', true),
			'contact_person' => $this->input->post('contact_person', true),
			'email' => $this->input->post('email', true),
			'phone' => $this->input->post('phone', true),
			'address' => $this->input->post('address', true),
			'zip_city' => $this->input->post('zip_city', true),
			'paket' => $this->input->post('paket', true),
			'torte' => $this->input->post('torte', true),
			'jause' => $this->input->post('jause', true),
			'notes' => $this->input->post('notes', true),
		];

		log_message('debug', 'Formulárové dáta: ' . print_r($data, true));

		$this->load->model('App_model');
		$sent = $this->App_model->sendKindergeburtstagMail($data);

		if ($sent) {
			$this->session->set_flashdata('success', 'Vielen Dank für Ihre Anfrage. Wir melden uns baldmöglichst bei Ihnen.');
		} else {
			log_message('error', 'Chyba pri odosielaní e-mailu: ' . $this->email->print_debugger());
			$this->session->set_flashdata('error', 'Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

}

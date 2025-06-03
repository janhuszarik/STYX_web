<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->model('ion_auth_model', 'admin_model');;
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);
		$this->lang->load('auth');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$users = $this->ion_auth->users()->result();
			// Filter out admin@admin user
			$data['users'] = array_filter($users, function($user) {
				return $user->email !== 'admin@admin.com';
			});
			foreach ($data['users'] as $k => $user)
			{
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			// Admin layout data
			$data['title'] = lang('index_heading');
			$data['page'] = 'auth/index';

			$this->load->view('admin/layout/normal', $data);
		}
	}

	/**
	 * Log the user in
	 */
	public function login() {
		// Check if the user is already logged in
		if ($this->ion_auth->logged_in()) {
			// Set flash message and redirect based on the user's role
			if ($this->ion_auth->is_admin()) {
				$this->session->set_flashdata('message', 'Sie sind bereits als Admin eingeloggt!');
				redirect(BASE_URL . 'admin');
			} else {
				$this->session->set_flashdata('message', 'Sie sind bereits eingeloggt!');
				redirect(BASE_URL);
			}
		}

		$this->data['title'] = $this->lang->line('login_heading');

		// Validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE) {
			// Check to see if the user is logging in
			// Check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
				// If the login is successful, redirect them based on the user's role
				if ($this->ion_auth->is_admin()) {
					$this->session->set_flashdata('message', 'Erfolgreich eingeloggt! Willkommen Admin!');
					redirect(BASE_URL . 'admin', 'refresh');
				} else {
					$this->session->set_flashdata('message', 'Erfolgreich eingeloggt! Willkommen ' . user(true) . '!');
					redirect(BASE_URL, 'refresh');
				}
			} else {
				// If the login was un-successful, redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(BASE_URL . 'login', 'refresh'); // Use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		} else {
			// The user is not logging in so display the login page
			// Set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			];

			$this->data['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			];

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}







	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";

		// Log the user out
		$this->ion_auth->logout();

		// Set flash message
		$this->session->set_flashdata('message', 'Sie wurden erfolgreich abgemeldet!');

		// Redirect them to the home page
		redirect(BASE_URL, 'refresh');
	}


	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect(BASE_URL.'login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// render
			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message',$this->ion_auth->messages());
				redirect('auth/change_password', 'refresh');
//					$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}
	public function delete_user($id)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		if (!$user)
		{
			$this->session->set_flashdata('message', 'Benutzer nicht gefunden.');
			redirect('auth', 'refresh');
		}

		// Prevent deletion of admin@admin user (for consistency with index filtering)
		if ($user->email === 'admin@admin')
		{
			$this->session->set_flashdata('message', 'Der Benutzer admin@admin kann nicht gelöscht werden.');
			redirect('auth', 'refresh');
		}

		// Prevent deletion of the currently logged-in user
		if ($this->ion_auth->user()->row()->id == $id)
		{
			$this->session->set_flashdata('message', 'Sie können Ihren eigenen Benutzer nicht löschen.');
			redirect('auth', 'refresh');
		}

		if ($this->ion_auth->delete_user($id))
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
		}

		redirect('auth', 'refresh');
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');

		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
			];

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$this->data['title'] = $this->lang->line('reset_password_heading');

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = [
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['new_password_confirm'] = [
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['user_id'] = [
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				];
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
			}
			else
			{
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($identity);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			$this->data['identity'] = $this->config->item('identity', 'ion_auth');

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	/**
	 * Create a new user
	 */
	public function create_user()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// Validate form input
		$this->form_validation->set_rules('first_name', lang('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', lang('create_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('email', lang('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone', lang('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', lang('create_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules('password', lang('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', lang('create_user_validation_password_confirm_label'), 'required');

		if ($this->input->post() && !empty($this->input->post()))
		{
			// Validate CSRF
			if ($this->_valid_csrf_nonce() === FALSE)
			{
				show_error(lang('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE)
			{
				$email = strtolower($this->input->post('email'));
				$identity = $email; // Ion Auth typically uses email as identity
				$password = $this->input->post('password');

				$additional_data = [
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
				];

				// Register the user
				$user_id = $this->ion_auth->register($identity, $password, $email, $additional_data);

				if ($user_id)
				{
					// Assign groups if admin
					if ($this->ion_auth->is_admin())
					{
						$groupData = $this->input->post('groups');
						if (isset($groupData) && !empty($groupData))
						{
							foreach ($groupData as $grp)
							{
								$this->ion_auth->add_to_group($grp, $user_id);
							}
						}
					}

					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('auth', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/create_user', 'refresh');
				}
			}
		}

		// Prepare view data
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$data['groups'] = $this->ion_auth->groups()->result_array();

		$data['first_name'] = [
			'name' => 'first_name',
			'id' => 'first_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('first_name'),
			'class' => 'form-control',
		];
		$data['last_name'] = [
			'name' => 'last_name',
			'id' => 'last_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('last_name'),
			'class' => 'form-control',
		];
		$data['email'] = [
			'name' => 'email',
			'id' => 'email',
			'type' => 'email',
			'value' => $this->form_validation->set_value('email'),
			'class' => 'form-control',
		];
		$data['company'] = [
			'name' => 'company',
			'id' => 'company',
			'type' => 'text',
			'value' => $this->form_validation->set_value('company'),
			'class' => 'form-control',
		];
		$data['phone'] = [
			'name' => 'phone',
			'id' => 'phone',
			'type' => 'text',
			'value' => $this->form_validation->set_value('phone'),
			'class' => 'form-control',
		];
		$data['password'] = [
			'name' => 'password',
			'id' => 'password',
			'type' => 'password',
			'value' => '',
			'class' => 'form-control',
			'autocomplete' => 'off',
		];
		$data['password_confirm'] = [
			'name' => 'password_confirm',
			'id' => 'password_confirm',
			'type' => 'password',
			'value' => '',
			'class' => 'form-control',
			'autocomplete' => 'off',
		];
		$data['csrf'] = $this->_get_csrf_nonce();

		// Admin layout data
		$data['title'] = lang('create_user_heading');
		$data['page'] = 'auth/create_user';

		$this->load->view('admin/layout/normal', $data);
	}
	public function register()
	{
		$this->data['title'] = $this->lang->line('register_user_heading');

		if ($this->ion_auth->logged_in())
		{
			redirect(BASE_URL, 'refresh');
		}


		// finta ako ban na robota

		$IP = array('178.159.37.84','193.33.250.4', '178.159.37.139','195.208.220.174','130.63.40.37','178.159.37.88','212.175.150.200');

//        if ($_SERVER['REMOTE_ADDR'] == '178.159.37.84'){
		if (in_array($_SERVER['REMOTE_ADDR'],$IP)){
			redirect(BASE_URL.'error404', 'refresh');
			die();
		}


		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required|strip_tags');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|strip_tags');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|strip_tags|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|strip_tags|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|strip_tags|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim|strip_tags|regex_match[/[0-9]|\s/]|max_length[14]');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim|strip_tags');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|strip_tags|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required|matches[password]');

		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');

			// nove URL usera moj kod
			$first_last_name = $this->input->post('first_name').'-'.$this->input->post('last_name').'_profil';
			$first_last_name = url_oprava($first_last_name);


			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
				'url' => $first_last_name,

			);
		}

		if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
//            redirect(BASE_URL, 'refresh');
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->data['keywords'] = 'Benutzerregistrierung';
			$this->data['titulok'] = 'Registrierung';
			$this->data['description'] = '';
			$this->data['page'] = 'admin/register';
			$this->load->view('admin/register', $this->data);

		}
	}
	/**
	 * Redirect a user checking if is admin
	 */
	protected function redirectUser(){
		if ($this->ion_auth->is_admin()){
			redirect('auth', 'refresh');
		}
		redirect('/', 'refresh');
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user($id)
	{
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result_array();

		// Validate form input
		$this->form_validation->set_rules('first_name', lang('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', lang('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('email', lang('edit_user_validation_email_label'), 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', lang('edit_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', lang('edit_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules('password', lang('edit_user_validation_password_label'), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', lang('edit_user_validation_password_confirm_label'), 'trim');

		if ($this->input->post() && !empty($this->input->post()))
		{
			// Validate CSRF
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error(lang('error_csrf'));
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = [
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => strtolower($this->input->post('email')),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
				];

				// Update password if provided
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Update groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					$groupData = $this->input->post('groups');
					$this->ion_auth->remove_from_group('', $id);
					if (isset($groupData) && !empty($groupData))
					{
						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				// Update user
				if ($this->ion_auth->update($user->id, $data))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/edit_user/' . $id, 'refresh');
				}
			}
		}

		// Prepare view data
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$data['user'] = $user;
		$data['groups'] = $groups;
		$data['currentGroups'] = $currentGroups;

		$data['first_name'] = [
			'name' => 'first_name',
			'id' => 'first_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		];
		$data['last_name'] = [
			'name' => 'last_name',
			'id' => 'last_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		];
		$data['email'] = [
			'name' => 'email',
			'id' => 'email',
			'type' => 'email',
			'value' => $this->form_validation->set_value('email', $user->email),
		];
		$data['company'] = [
			'name' => 'company',
			'id' => 'company',
			'type' => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		];
		$data['phone'] = [
			'name' => 'phone',
			'id' => 'phone',
			'type' => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		];
		$data['password'] = [
			'name' => 'password',
			'id' => 'password',
			'type' => 'password',
			'value' => '',
		];
		$data['password_confirm'] = [
			'name' => 'password_confirm',
			'id' => 'password_confirm',
			'type' => 'password',
			'value' => '',
		];
		$data['csrf'] = $this->_get_csrf_nonce();

		// Admin layout data
		$data['title'] = lang('edit_user_heading');
		$data['page'] = 'auth/edit_user';

		$this->load->view('admin/layout/normal', $data);
	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
			}
		}

		// display the create group form
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->data['group_name'] = [
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name'),
		];
		$this->data['description'] = [
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('description'),
		];

		$this->_render_page('auth/create_group', $this->data);

	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
					'description' => $_POST['group_description']
				));

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
					redirect("auth", 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = [
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
		];
		if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
			$this->data['group_name']['readonly'] = 'readonly';
		}

		$this->data['group_description'] = [
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		];

		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	protected function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return [$key => $value];
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	protected function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

	public function disconnectFacebookAccount_callback()
	{
		if (!session_id()) {
			session_start();
		}
		$this->facebook->disconnectFacebookAccount();
		redirect();
	}

	public function connectFacebookAccount_callback()
	{
		if (!session_id()) {
			session_start();
		}
		$this->facebook->connectFacebookAccount();
		redirect();
	}
	public function fb_register_callback()
	{
		if (!session_id()) {
			session_start();
		}

		if ($this->facebook->fb_callback()) {
//            redirect('user/account');
			$this->session->set_flashdata('message', 'Sie haben sich erfolgreich angemeldet. Willkommen!');
//            redirect($_SERVER['HTTP_REFERER']);
			redirect(BASE_URL);
//            header('Location: ' . $_SERVER['HTTP_REFERER']);
			$this->data['pages'] = 'pages/home';
			$this->data['toto'] = $_POST;
			$this->load->view('layout/normal', $this->data);
		} else {
			show_error('error');
			$this->data['pages'] = 'pages/home';
			$this->data['toto'] = $_POST;
			$this->load->view('layout/normal', $this->data);
		}
	}

}

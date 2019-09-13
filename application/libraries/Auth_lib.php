<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_lib
{
	private $error = NULL;

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('users');
		$this->ci->load->model('login_history');
	}

	function get_error_message()
	{
		return $this->error;
	}

	function login($email, $password)
	{
		if ($this->ci->users->verify_login($email, $password))
		{
			$user = $this->ci->users->get_user_by_email($email);

			// login
			$this->ci->session->set_userdata('user_id', $user['user_id']);

			// track login history
			$this->ci->login_history->create_log($user['user_id'], 'email');

			return $user['user_id'];
		}
		else
		{
			$this->error = 'Email / Password didn\'t match';
		}
	}

	function login_social($social)
	{
		$user = $this->ci->users->get_user_by_social($social['app'].'_id', $social['id']);

		if (!empty($user))
		{
			// login
			$this->ci->session->set_userdata('user_id', $user['user_id']);

			// track login history
			$this->ci->login_history->create_log($user['user_id'], $social['app']);

			return $user['user_id'];
		}
		else
		{
			$this->error = 'Account not found';
		}
	}

	function logout()
	{
		$this->ci->session->unset_userdata('user_id');

		$this->ci->session->sess_destroy();
	}

	function is_logged_in()
	{
		return $this->ci->session->userdata('user_id');
	}

	function create_user($name, $email, $age = NULL, $gender = 'male', $location = NULL, $social = NULL)
	{
		if (!empty($social))
		{
			$user = $this->ci->users->get_user_by_social($social['app'].'_id', $social['id']);

			if (!empty($user))
			{
				$this->error = 'Social login is already registerd';
				return NULL;
			}
		}

		if (!$this->ci->users->is_email_available($email))
		{
			$this->error = 'Email is already registerd';
			return NULL;
		}
		
		$this->ci->load->helper('string');
		$password = random_string('alnum', 8);

		$data = array(
			'name'		=> $name,
			'email'		=> $email,
			'password'	=> $password,
			'age'		=> $age,
			'gender'	=> $gender,
			'location'	=> $location
		);

		$medium = 'email';
		if (!empty($social))
		{
			$data[ $social['app'].'_id' ] = $social['id'];
			$medium = $social['app'];
		}
		
		if (!is_null($user_id = $this->ci->users->create_user($data)))
		{
			// login
			$this->ci->session->set_userdata('user_id', $user_id);

			// track login history
			$this->ci->login_history->create_log($user_id, $medium);

			// send email with password
			$data['user_id'] = $user_id;
			$this->_send_email($email, $data);

			return $user_id;
		}
	}

	function _send_email($email, &$data)
	{
		$this->ci->load->library('email');
		$this->ci->email->from('server@example.com', 'Demo');
		$this->ci->email->to($email);
		$this->ci->email->subject('Welcome to Demo');
		$this->ci->email->message($this->ci->load->view('email', $data, TRUE));
		$this->ci->email->set_alt_message($this->ci->load->view('email', $data, TRUE));
		$this->ci->email->send();
	}

	function delete_user($user_id)
	{
		$this->ci->users->delete_user($user_id);
		$this->logout();
	}
}
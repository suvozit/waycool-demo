<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		// $this->load->library('security');
		$this->load->library('auth_lib');
	}

	function _show_message($title, $template, $template_data = NULL)
    {
        $content = $this->load->view($template, $template_data, TRUE);

        $data = array('title' => $title, 'content' => $content);
        $this->load->view('layout', $data);
    }

	public function index()
	{
		redirect('auth/login');
	}

	public function login()
	{
		if ($this->auth_lib->is_logged_in())
		{
			redirect();
		}

		if (!is_null($social = $this->session->flashdata('social')))
		{
			if (is_null($user_id = $this->auth_lib->login_social($social)))
		    {
		    	$this->session->set_flashdata('error_message', $this->auth_lib->get_error_message());
				redirect('auth/login');
		    }

		    redirect();
		}

		if ($this->form_validation->run())
        {
        	$email = $this->form_validation->set_value('email');
        	$password = $this->form_validation->set_value('password');

        	if (is_null($user_id = $this->auth_lib->login($email, $password)))
            {
            	$this->session->set_flashdata('error_message', $this->auth_lib->get_error_message());
				redirect('auth/login');
            }

        	redirect();
        }

		$this->_show_message('Login', 'auth/login');
	}

	function logout()
	{
		$this->auth_lib->logout();
		redirect('auth/login');
	}

	public function register()
	{
		if ($this->auth_lib->is_logged_in())
		{
			redirect();
		}

		if (!is_null($social = $this->session->flashdata('social')))
		{
			if (is_null($user_id = $this->auth_lib->create_user($social['name'], $social['email'], '', 'male', '', $social)))
            {
                $this->session->set_flashdata('error_message', $this->auth_lib->get_error_message());
				redirect('auth/register');
            }

            redirect();
		}

        if ($this->form_validation->run())
        {
        	$name = $this->form_validation->set_value('name');
        	$age = $this->form_validation->set_value('age');
        	$gender = $this->form_validation->set_value('gender');
        	$location = $this->form_validation->set_value('location');
        	$email = $this->form_validation->set_value('email');

        	if (is_null($user_id = $this->auth_lib->create_user($name, $email, $age, $gender, $location)))
            {
                $this->session->set_flashdata('error_message', $this->auth_lib->get_error_message());
				redirect('auth/register');
            }

            redirect();
        }

		$this->_show_message('Sign Up', 'auth/register');
	}
}

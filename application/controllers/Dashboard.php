<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('auth_lib');
		
		// if not logged in reditect to sign in page
		if (is_null($user_id = $this->auth_lib->is_logged_in()))
		{
			redirect('auth');
		}

		$data = [];

		$this->load->model('login_history');
		$data['login_count'] = $this->login_history->get_logs_count($user_id);

		$data['login_history'] = $this->login_history->get_logs($user_id);

		$user = $this->users->get_user_by_id($user_id);
		$data['user'] = $user;
		$data['account_history'] = $this->users->get_deleted_accounts($user['email']);

		$content = $this->load->view('dashboard', $data, TRUE);

        $data = array('title' => 'Dashboard', 'content' => $content);
        $this->load->view('layout', $data);
	}
}

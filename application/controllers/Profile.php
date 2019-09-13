<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('auth_lib');
		
		// if not logged in reditect to sign in page
		if (is_null($user_id = $this->auth_lib->is_logged_in()))
		{
			redirect('auth');
		}

		$data = [];
		$user = $this->users->get_user_by_id($user_id);
		$data['user'] = $user;

		if ($this->form_validation->run('auth/register'))
        {
        	$updated['name'] = $this->form_validation->set_value('name');
        	$updated['age'] = $this->form_validation->set_value('age');
        	$updated['gender'] = $this->form_validation->set_value('gender');
        	$updated['location'] = $this->form_validation->set_value('location');
        	$updated['email'] = $this->form_validation->set_value('email');

        	if ($updated['email'] != $user['email'])
        	{
        		if (!$this->users->is_email_available($updated['email']))
        		{
        			$this->session->set_flashdata('error_message', 'Email already registered');
					redirect('profile');
        		}
        	}

        	$this->users->update_user($user_id, $updated);
        }

        if (!is_null($social = $this->session->flashdata('social')))
		{
			$social_user = $this->users->get_user_by_social($social['app'].'_id', $social['id']);

			if (!empty($social_user))
			{
				$this->session->set_flashdata('error_message', 'Social account already registered');
				redirect('profile');
			}
			else
			{
				$this->users->update_user($user_id, [$social['app'].'_id' => $social['id']]);

				$this->session->set_flashdata('success_message', 'Social account added');
				redirect('profile');
			}
		}
		

		$content = $this->load->view('profile', $data, TRUE);

        $data = array('title' => 'Profile', 'content' => $content);
        $this->load->view('layout', $data);
	}

	function delete_user()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('auth_lib');
		
		// if not logged in reditect to sign in page
		if (is_null($user_id = $this->auth_lib->is_logged_in()))
		{
			redirect('auth');
		}

		$this->auth_lib->delete_user($user_id);

		redirect('auth/login');
	}
}

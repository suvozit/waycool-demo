<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller
{
	public function add($app = NULL)
	{
		if (empty($app)) show_404();
		
		$this->load->library('social_lib', ['app' => $app]);
		if (is_null($this->social_lib->get_request_token()))
		{
			show_error($this->social_lib->get_error_message());
		}
	}
	
	public function callback($app = NULL)
	{
		if (empty($app)) show_404();

		$this->load->library('social_lib', ['app' => $app]);
		if (is_null($access_token = $this->social_lib->get_access_token()))
		{
			show_error($this->social_lib->get_error_message());
		}

		$method = 'fetch_'.$app;
		if (is_null($data = $this->social_lib->$method($access_token)))
		{
			show_error($this->social_lib->get_error_message());
		}

		$data['app'] = $app;

		$this->load->library('session');
		$this->session->set_flashdata('social', $data);

		exit('<script>parent.close()</script>');
	}
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_history extends CI_Model
{
	function create_log($user_id, $medium)
	{
		$data = array(
			'user_id' 		=> $user_id,
			'medium' 		=> $medium,
			'user_agent' 	=> substr($this->input->user_agent(), 0, 149),
			'ip' 			=> $this->input->ip_address()
		);

		$this->db->insert('login_history', $data);
	}

	function get_logs($user_id)
	{
		$this->db->limit(10);
		$this->db->order_by('created', 'DESC');

		$this->db->where('user_id', $user_id);

		$query = $this->db->get('login_history');
		return $query->result_array();
	}

	function get_logs_count($user_id)
	{
		$this->db->select('medium, COUNT(medium) as total');
		$this->db->group_by('medium');
		$this->db->order_by('total', 'desc');

		$this->db->where('user_id', $user_id);

		$query = $this->db->get('login_history');
		return $query->result_array();
	}
}
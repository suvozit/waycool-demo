<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model
{
	function get_user_by_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');

		return $query->row_array();
	}

	function get_user_by_email($email)
	{
		$this->db->where('email', $email);
		$this->db->where('deleted', '0000-00-00 00:00:00');
		$query = $this->db->get('users');

		return $query->row_array();
	}

	function get_user_by_social($social_id ,$id)
	{
		$this->db->where($social_id, $id);
		$this->db->where('deleted', '0000-00-00 00:00:00');
		$query = $this->db->get('users');

		return $query->row_array();
	}

	function create_user($data)
	{
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	function update_user($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}

	function delete_user($user_id)
	{
		$this->db->set('deleted', date('Y-m-d H:i:s'));

		$this->db->where('user_id', $user_id);
		$this->db->update('users');
	}

	function get_deleted_accounts($email)
	{
		$this->db->limit(10);
		$this->db->order_by('created', 'DESC');

		$this->db->where('email', $email);
		$this->db->where('deleted !=', '0000-00-00 00:00:00');

		$query = $this->db->get('users');
		return $query->result_array();
	}

	function is_email_available($email)
	{
		$this->db->where('email', $email);
		$this->db->where('deleted', '0000-00-00 00:00:00');

		$query = $this->db->get('users');
		return $query->num_rows() == 0;
	}

	function verify_login($email, $password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$this->db->where('deleted', '0000-00-00 00:00:00');

		$query = $this->db->get('users');
		return $query->num_rows() !== 0;
	}
}
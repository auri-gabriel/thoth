<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{

	public function check_email_unique($email)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this->db->count_all_results();

		if ($query > 0) {
			return false;
		}

		return true;
	}

	public function new_user($email, $password, $name)
	{
		$now = new DateTime();
		$now->getTimestamp();

		$data = array(
			'email' => $email,
			'name' => $name,
			'password' => $password,
			'created_at' => $now->format('Y-m-d H:i:s')
		);

		$this->db->insert('user', $data);

		$user = new User();
		$user->set_name($name);
		$user->set_email($email);

		return $user;
	}

	public function check_login($email, $password)
	{
		$user = new User();
		$password = md5($password);

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where(array('email =' => $email, 'password' => $password));
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$user->set_id($row['id_user']);
			$user->set_email($row['email']);
			$user->set_name($row->name);
			return $user;
		}

		return null;
	}

	// Find user by email
	public function find_by_email($email)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this->db->get();
		if ($row = $query->row()) {
			$user = new User();
			$user->set_name($row->name);
			$user->set_email($row->email);
			$user->set_id($row->id_user);
			return $user;
		}
		return null;
	}

	// Store password reset token
	public function store_reset_token($user_id, $token)
	{
		$data = array(
			'user_id' => $user_id,
			'token' => $token,
			'created_at' => date('Y-m-d H:i:s'),
			'is_used' => 0
		);
		$this->db->insert('password_resets', $data);
	}

	// Validate token (not expired, not used)
	public function is_valid_token($token)
	{
		$this->db->select('*');
		$this->db->from('password_resets');
		$this->db->where('token', $token);
		$this->db->where('is_used', 0);
		$this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour')));
		$query = $this->db->get();
		return $query->num_rows() > 0;
	}

	// Get user id by token
	public function get_user_id_by_token($token)
	{
		$this->db->select('user_id');
		$this->db->from('password_resets');
		$this->db->where('token', $token);
		$query = $this->db->get();
		if ($row = $query->row()) {
			return $row->user_id;
		}
		return null;
	}

	// Update password
	public function update_password($user_id, $new_password)
	{
		$password = md5($new_password);
		$this->db->where('id', $user_id);
		$this->db->update('user', array('password' => $password));
	}

	// Invalidate token after use
	public function invalidate_token($token)
	{
		$this->db->where('token', $token);
		$this->db->update('password_resets', array('is_used' => 1));
	}
}

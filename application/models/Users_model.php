<?php

class Users_model extends CI_Model 
  
{
	var $db1;
	var $_table='app_user';
	
	function __construct()
	{
		parent::__construct();		
		$this->db1 = $this->load->database('default', TRUE);
		
	}
	
	// General function
	
	function get_all($offset = 0, $row_count = 0)
	{
		$users_table = $this->_table;
		$roles_table = $this->_roles_table;
		
		if ($offset >= 0 AND $row_count > 0)
		{
			$this->db1->select("$users_table.*", FALSE);
			$this->db1->select("$roles_table.name AS role_name", FALSE);
			$this->db1->join($roles_table, "$roles_table.id = $users_table.role_id");
			$this->db1->order_by("$users_table.id", "ASC");
			
			$query = $this->db1->get($this->_table, $row_count, $offset); 
		}
		else
		{
			$query = $this->db1->get($this->_table);
		}
		
		return $query;
	}

	function get_user_by_id($user_id)
	{
		$this->db1->where('id', $user_id);
		return $this->db1->get($this->_table);
	}

	function get_user_by_username($username)
	{
		$this->db1->where('username', $username);
		return $this->db1->get($this->_table);
	}
	
	function get_user_by_email($email)
	{
		$this->db1->where('email', $email);
		return $this->db1->get($this->_table);
	}
	
	function get_login($login)
	{
		$this->db1->where('username', $login);
		$this->db1->or_where('email', $login);
		return $this->db1->get($this->_table);
	}
	
	function check_ban($user_id)
	{
		$this->db1->select('1', FALSE);
		$this->db1->where('id', $user_id);
		$this->db1->where('banned', '1');
		return $this->db1->get($this->_table);
	}
	
	function check_username($username)
	{
		$this->db1->select('1', FALSE);
		$this->db1->where('LOWER(username)=', strtolower($username));
		return $this->db1->get($this->_table);
	}

	function check_email($email)
	{
		$this->db1->select('1', FALSE);
		$this->db1->where('LOWER(email)=', strtolower($email));
		return $this->db1->get($this->_table);
	}
		
	function ban_user($user_id, $reason = NULL)
	{
		$data = array(
			'banned' 			=> 1,
			'ban_reason' 	=> $reason
		);
		return $this->set_user($user_id, $data);
	}
	
	function unban_user($user_id)
	{
		$data = array(
			'banned' 			=> 0,
			'ban_reason' 	=> NULL
		);
		return $this->set_user($user_id, $data);
	}
		
	function set_role($user_id, $role_id)
	{
		$data = array(
			'role_id' => $role_id
		);
		return $this->set_user($user_id, $data);
	}

	// User table function

	function create_user($data)
	{
		return $this->db1->insert($this->_table, $data);
	}

	function get_user_field($user_id, $fields)
	{
		$this->db1->select($fields);
		$this->db1->where('id', $user_id);
		return $this->db1->get($this->_table);
	}

	function set_user($user_id, $data)
	{
		$this->db1->where('id', $user_id);
		return $this->db1->update($this->_table, $data);
	}
	
	function delete_user($user_id)
	{
		$this->db1->where('id', $user_id);
		$this->db1->delete($this->_table);
		return $this->db1->affected_rows() > 0;
	}
	
	// Forgot password function

	function newpass($user_id, $pass, $key)
	{
		$data = array(
			'newpass' 			=> $pass,
			'newpass_key' 	=> $key,
			'newpass_time' 	=> date('Y-m-d h:i:s', time() + $this->config->item('DX_forgot_password_expire'))
		);
		return $this->set_user($user_id, $data);
	}

	function activate_newpass($user_id, $key)
	{
		$this->db1->set('password', 'newpass', FALSE);
		$this->db1->set('newpass', NULL);
		$this->db1->set('newpass_key', NULL);
		$this->db1->set('newpass_time', NULL);
		$this->db1->where('id', $user_id);
		$this->db1->where('newpass_key', $key);
		
		return $this->db1->update($this->_table);
	}

	function clear_newpass($user_id)
	{
		$data = array(
			'newpass' 			=> NULL,
			'newpass_key' 	=> NULL,
			'newpass_time' 	=> NULL
		);
		return $this->set_user($user_id, $data);
	}
	
	// Change password function

	function change_password($user_id, $new_pass)
	{
		$this->db1->set('password', $new_pass);
		$this->db1->where('id', $user_id);
		return $this->db1->update($this->_table);
	}
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Auth Class
 *
 * Authentication library for Code Igniter.
 * @author		Nur Muhamad Holik -2016
 * @version		1.0.0
 */
 
class Auth {
   var $_auth_message;
   
   
    function __construct()
    {
        $this->ci =& get_instance();
		$this->ci->load->library('Session');
		$this->ci->lang->load('auth');
    }
   
   public function loginUser()
   {
        $this->ci->load->model('Auth_model','users');
		
		$result = FALSE;
		
		if($query  = $this->ci->users->getUser() AND $query->num_rows()  == 1 )
        {
             $row 	      = $query->row();			 
			 $password 	  = $this->_encode();
			 $active      = $row->active;
		     $stored_hash = $row->password;
			 
			 if($password === $stored_hash)
			 {
			   
				// Set message
				$this->_auth_message = $this->ci->lang->line('auth_login_correct_username_password');	
                if(!empty($active))
				{
				  	$this->_set_session($row);
					$result =  TRUE;
				}
                else
                {
                    // Set message
				    $this->_auth_message = $this->ci->lang->line('auth_login_inactive_user');
                } 				
			 }
			 else
			 {
			      // Set message
				  $this->_auth_message = $this->ci->lang->line('auth_login_incorrect_password');
			 }
        }
        else
        {
            // Set message
			$this->_auth_message = $this->ci->lang->line('auth_login_incorrect_username');
        }

        return $result;		
   
   }
   
   public function logoutUser()
   {
       $this->ci->session->sess_destroy();
   }
   
   public function getMessage()
   {
      return $this->_auth_message;
   }
   
    public function getRegMessage()
   {
      return $this->_register_message;
   }
   
   public function isLoggedin()
   {
		return $this->ci->session->userdata('logged_in');
   }
   
   function _encode()
   {
       return SHA1($this->ci->input->post('password'));
   }
   
   function _set_session($data)
	{
		// Set session data array
		$user = array(						
			'user_id'						=> $data->user_id,
			'username'						=> $data->username,
			'firtsname'		                => $data->first_name,
            'lastname'						=> $data->last_name,
            'jabatan'						=> $data->jabatan,	
            'created'					    => $data->member,	
			'gender'                        => $data->gender,
			'logged_in'					    => TRUE
		);
		
		$this->ci->session->set_userdata($user);
	}
	
	public function getAvatar()
    {
		if($this->ci->session->userdata('gender') == 'L')
		{
		    $avatar = 'avatar5.png';
		}
		else
		{
		     $avatar = 'avatar3.png';
		}
		
		return $avatar;
    }
	
	public function getName()
    {
		return $this->ci->session->userdata('firtsname').' '.$this->ci->session->userdata('lastname') ;
    }
	
	public function getJabatan()
    {
		return $this->ci->session->userdata('jabatan');
    }
	
	public function getCreated()
    {
		return $this->ci->session->userdata('created');
    }
	public function register($username, $password,$firstname,$lastname,$gender,$unit_kerja,$jabatan)
	{		
		// Load Models
		$this->ci->load->model('users_model', 'users');
		$this->ci->load->model('user_temp_model', 'user_temp');

		$this->ci->load->helper('url');
		
		// Default return value
		$result = FALSE;

		// New user array
		$new_user = array(			
			'username'				    => $username,			
			'password'				    => SHA1($password),
			'first_name'				=> $firstname,
			'last_name'					=> $lastname,			
			'gender'					=> $gender,	
            'unit_kerja'				=> $unit_kerja,		
            'jabatan'					=> $jabatan,			
			'last_ip'					=> $this->ci->input->ip_address()
		);

		
			// Add activation key to user array
			//$new_user['activation_key'] = md5(rand().microtime());
			
			$check_user      = $this->ci->user_temp->check_username($username);
			$check_user_temp = $this->ci->users->check_username($username);
			
			if($check_user->num_rows() ==  1 || $check_user_temp->num_rows() == 1)
			{
			    $this->_register_message =' Username already exist ';
			}
			else
			{
			
				// Create temporary user in database which means the user still unactivated.
				$insert = $this->ci->users->create_user($new_user);
				
				if ($insert)
				{
					$result = $new_user;			
					
				}
		    }
		
		
		
		return $result;
	}

}


	
	
 

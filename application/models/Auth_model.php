<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends CI_Model {

    var $username;
	var $password;
	var $db1;
	var $table_user = 'app_user' ;
    function __construct()
    {
        parent::__construct();
		$this->db1 = $this->load->database('default', TRUE);
    }
		
	public function getUser()
	{
	     $this->username = $this->input->post('username');
		 $this->password = $this->input->post('password');	 
		
		 $this->db1->select('*');
		 $this->db1->select('date_format(created_date,"%d %M %Y") as member',FALSE);
		 $this->db1->where('username',$this->username);		 
		 $this->db1->or_where('email',$this->username);
		 $query = $this->db1->get($this->table_user);
		 return $query;
		 
	}
	
	
}
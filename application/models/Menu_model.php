<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
		$this->db1 = $this->load->database('default', TRUE);
    }
		
	public function getMenu()
	{
	    $user_id    = $this->session->userdata('user_id');
		
		$sql="SELECT a.menu_id , b.menu_name ,b.icon, b.link, b.parent, b.active FROM `menu_role` a
INNER JOIN menu b ON a.menu_id = b.menu_id WHERE user_id ='$user_id'
";
		 $query = $this->db1->query($sql);
		 return $query;
		 
	}
	
	public function getChildParent($id)
    {
        $sql ="SELECT * FROM menu where parent='$id' ";
	    $query = $this->db1->query($sql);
		return $query;
    }	
	
}
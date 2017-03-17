<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile_model extends CI_Model {

    var $table_app_user   = 'takahpns.app_user';
	var $table_unit_kerja = 'takahpns.unit_kerja';
	
	
    function __construct()
    {
        parent::__construct();
		$this->db1 = $this->load->database('default', TRUE);
    }
		
	public function getProfile()
	{
	   	$user_id    = $this->session->userdata('user_id');
		$this->db1->select('user_id,username,email,first_name,last_name,gender,active,unit_kerja,jabatan');
		$this->db1->where('user_id',$user_id);	
		return $this->db1->get($this->table_app_user); 
	}
	
	function getUnitKerja()
    {
        $this->db1->select('id_unit,nama_unit');
		$this->db1->order_by('nama_unit', 'asc');
        return $this->db1->get($this->table_unit_kerja);
    }	
	
	function setProfile($data)
	{
	    $user_id    = $this->session->userdata('user_id');
		$this->db1->where('user_id',$user_id);
		return $this->db1->update($this->table_app_user, $data); 
	}
	
	function setPassword($newPassword)
	{
	    $user_id     = $this->session->userdata('user_id');
		$newPassword = SHA1($newPassword);
		$this->db1->where('user_id',$user_id);
		$this->db1->set('password','$newPassword');
		return $this->db1->update($this->table_app_user); 
	}
	
	function getCurrentPassword()
	{
	    $user_id    = $this->session->userdata('user_id');
		$this->db1->where('user_id',$user_id);
		$this->db1->select('password');
		return $this->db1->get($this->table_app_user);
	
	}
	
	
	
}
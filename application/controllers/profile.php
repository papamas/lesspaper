<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();		
	    $this->db1   = $this->load->database('default', TRUE);
		$this->load->model('profile_model');
		$this->load->library('Auth');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	} 
	
	public function index()
	{
		
		$data['message']     = '';
		$data['name']        =  $this->auth->getName();
        $data['jabatan']     =  $this->auth->getJabatan();
		$data['member']	     =  $this->auth->getCreated();
		$data['avatar']	     =  $this->auth->getAvatar();
		$data['profile']     =  $this->_getProfile();
		$data['unit_kerja']  =  $this->_getUnitKerja();
		
		$this->load->view('profile/vprofile',$data);
	}
	
	function _getProfile()
	{
	    $row    =  $this->profile_model->getProfile()->row();
		return $row;
	}
	
	function _getUnitKerja()
    {
        return $this->profile_model->getUnitKerja();
    }

    public function setting()
    {    
		
		$first_name    = $this->input->post('first_name');
		$last_name     = $this->input->post('last_name');
		$email         = $this->input->post('email');
		$gender        = $this->input->post('gender');
		$jabatan       = $this->input->post('jabatan');
		$unit_kerja    = $this->input->post('unit_kerja');
		
		$data = array(
		   'first_name'       => $first_name ,
		   'last_name'        => $last_name ,
		   'email'            => $email,
		   'gender'           => $gender,
		   'jabatan'          => $jabatan,
		   'unit_kerja'       => $unit_kerja,		   
		);
		
		
		
		if($this->input->post())
		{
		   $this->profile_model->setProfile($data); 
		}
		
		$data['message']     = '';
		$data['name']        =  $this->auth->getName();
		$data['jabatan']     =  $this->auth->getJabatan();
		$data['member']	     =  $this->auth->getCreated();
		$data['avatar']	     =  $this->auth->getAvatar();
		$data['profile']     =  $this->_getProfile();
		$data['unit_kerja']  =  $this->_getUnitKerja();
		
		$this->load->view('profile/vprofile',$data); 
    }

    public function changePassword()
    {
       
		
		$this->form_validation->set_rules('currentPassword', 'Current Password', 'callback_currentPassword_check');
		$this->form_validation->set_rules('newPassword', 'new Password', 'required|matches[retypePassword]');
		$this->form_validation->set_rules('retypePassword', 'Password Confirmation', 'required');
		
		$this->form_validation->set_error_delimiters('<span class="text-red">', '</span>');
		
		
		//$currentPassword    = $this->input->post('currentPassword');
		//$newPassword        = $this->input->post('newPassword');
		//$retypePassword     = $this->input->post('retypePassword');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['message']     = '';
		}
		else
		{
		    $this->profile_model->setPassword($newPassword);
		}

        
		$data['name']                =  $this->auth->getName();
		$data['jabatan']             =  $this->auth->getJabatan();
		$data['member']	             =  $this->auth->getCreated();
		$data['avatar']	             =  $this->auth->getAvatar();
		$data['profile']             =  $this->_getProfile();
		$data['unit_kerja']  		 =  $this->_getUnitKerja();
		$data['tab_setting']     	 = '';
		$data['tab_change_password'] = 'active';
		$data['tab_activity']        = '';
		
		$this->load->view('profile/vprofile',$data);  		
    }

    public function currentPassword_check($str)
	{
		$row               = $this->profile_model->getCurrentPassword()->row();
		$currentPassword   = $row->password;
		
		if (SHA1($str) != $currentPassword)
		{
			$this->form_validation->set_message('currentPassword_check', 'The %s field not match');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	
}

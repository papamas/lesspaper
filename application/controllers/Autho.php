<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autho extends CI_Controller {

	
	public function index()
	{
		$data['message']    = ' <p class="login-box-msg text-info">Masukan Username dan Password</p>';
		$this->load->view('vlogin',$data);
	}
	
	public function login()
	{
		$this->load->library('Auth');
		if($this->auth->loginUser())
		{
		    redirect('welcome');
		}
		else
		{
		    $data['message']    = '<p class="login-box-msg text-red">'.$this->auth->getMessage().'</p>';
			$this->load->view('vlogin',$data);
		}
	}
	
	public function logout()
	{
	    $this->load->library('Auth');
		$this->auth->logoutUser();
		redirect('autho','refresh');
	}
}


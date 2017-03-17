<?php

class MY_Controller  extends CI_Controller  {
	function __construct()
	{
		parent::__construct();	
		//$message = "We're sorry for the inconvenience, Aplikasi Tata Naskah , is undergoing necessary scheduled maintenance.";
        //show_error($message, 500, "Scheduled Maintenance");
		$this->load->library('Auth');
		if(!$this->auth->isLoggedin())
		{
			redirect('autho','refresh');
	        		
		}
		
		
	}
	
}
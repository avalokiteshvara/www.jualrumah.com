<?php

class Changepass extends CI_Controller{


	function __construct(){
		
		parent::__construct();		
		header('Content-type: text/html; charset=iso-8859-1');

		if($this->session->userdata('adm_sudahlogin') != 1){
          redirect(base_url() . 'admin/login','refresh');
        }

        $this->load->model(array('admin/admin_model'));

	}


	function index(){

		$msg = NULL;
       	if(!empty($_POST)){
       	 	

	    	$this->form_validation->set_rules('old_pass', 'Password lama', 'xss_clean|required');
	        $this->form_validation->set_rules('new_pass', 'Password baru', 'xss_clean|required');
	        $this->form_validation->set_rules('repeat_pass', 'Repeat Password', 'xss_clean|required|matches[new_pass]');
	        
	        if ($this->form_validation->run() == TRUE)
	        {
				$old_pass = $this->input->post('old_pass');
	            $new_pass = $this->input->post('new_pass');
				
	            $ret =  $this->admin_model->change_password($old_pass, $new_pass);
				$msg= ($ret == TRUE) ? 'Password berhasil dirubah' : 'error: Password lama salah!';	
				
	        }else{
	           $msg = 'error:'.validation_errors();
	        }

	         $data['msg'] = $msg;

       	}

       	$data['page_title'] = 'Ganti Password'; 
       	$data['page_name'] = 'changepass';
       	$data['active_menu'] = 'changepass';

       	$this->load->view('admin/view_index',$data);
	}



	

}
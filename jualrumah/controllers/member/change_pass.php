<?php

class Change_pass extends CI_Controller{

	function __construct(){
		parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        
        $this->load->model(array('member_model'));
	}


	function index($msg=NULL)
    {       
        $page['profile'] = $this->member_model->retrieve_profile($this->session->userdata('user_id'));
        $page['mode'] = 'change_pass';
        $page['msg'] = $msg; 
        $page['page_name'] = 'member/profile';
        $page['page_title'] = 'Halaman Profile';
        $this->load->view('view_index', $page);
    }

    function change(){

        $msg = NULL;

    	$this->form_validation->set_rules('old_pass', 'Password lama', 'xss_clean|required');
        $this->form_validation->set_rules('new_pass', 'Password baru', 'xss_clean|required');
        $this->form_validation->set_rules('repeat_pass', 'Repeat Password', 'xss_clean|required|matches[new_pass]');
        
        if ($this->form_validation->run() == TRUE)
        {
			$old_pass = $this->input->post('old_pass');
            $new_pass = $this->input->post('new_pass');
			
            $ret =  $this->member_model->change_password($old_pass, $new_pass);
			$msg= ($ret == TRUE) ? 'Password berhasil dirubah' : 'error: Password lama salah!';	
			
        }else{
            $msg = 'error:'.validation_errors();
        }

        $this->index($msg);

    }

}
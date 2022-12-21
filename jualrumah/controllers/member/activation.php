<?php

class Activation extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        $this->load->model(array('listing_model'));  
                
    }

    function go_activate($verified_code = NULL){
    	$data['is_verified'] = 'Y';
    	$this->db->where('verified_code',$verified_code);
    	$this->db->update('tbl_member',$data);
    	
    	if($this->db->affected_rows() > 0){
    		//$this->form_validation->set_message('required','Akun anda telah aktif. Silahkan login');        	
    		redirect(base_url() . 'member/login/index/account_activated', 'refresh');
    	}

    	redirect(base_url() . 'member/login/', 'refresh');
    }


    function activate_listing($verified_code = NULL){

        $msg = $this->listing_model->activate_listing($verified_code);

        if($msg == "OK"){
            
            $page['page_name'] = 'message';
            $page['page_title'] = 'Listing Activation';
                    
            if($this->session->userdata('sudah_login') != 1){
                $page['msg'] = "Listing anda sudah diaktifkan</br><a href='".base_url()."member/login'>Silahkan login untuk melihat listing properti anda</a>" ;
            }else{
                $page['msg'] = "Listing anda sudah diaktifkan</br><a href='".base_url()."member/listing/show'>Silahkan klik disini untuk menuju ke daftar listing anda</a>" ;
            }
            
            $this->load->view('view_index', $page);
        }else{
            redirect(base_url() . 'member/login/', 'refresh');
        }
        
        


    }

}
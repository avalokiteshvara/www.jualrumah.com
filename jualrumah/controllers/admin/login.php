<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');



class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        
        $this->load->model(array('admin/admlogin_model'));
    }
    
    function index(){
       //jika sudah login maka -> dashboard 

      if($this->session->userdata('adm_sudahlogin') == 1){
        redirect(base_url() . 'admin/dashboard', 'refresh');
      }
       
      if(!empty($_POST)){    

        $this->form_validation->set_rules('user_name', 'Nama', 'xss_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required');

           if($this->form_validation->run() == TRUE){
              $data['user_name'] = $this->input->post('user_name');
              $data['password'] = md5($this->input->post('password'));

              $login_result = $this->admlogin_model->login($data);
              redirect(base_url() . 'admin/dashboard', 'refresh');
           }
      }      

       $this->load->view('admin/login');
    }
    
    
   
}




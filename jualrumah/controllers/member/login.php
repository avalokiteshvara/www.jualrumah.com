<?php

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        
        $this->load->model(array('member_model'));       
        
    }


    function index($message = NULL){
    	//jika sudah login, maka goto dashboard
    	if ($this->session->userdata('sudah_login') == 1)
        {
            redirect(base_url() . 'member/dashboard/' . $this->session->userdata('nama_lengkap'), 'refresh');
        }
        
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required');
        
        $msg = "";
        if ($this->form_validation->run() == TRUE)
        {
		    $data['email'] = $this->input->post('email');
		    $data['password'] = $this->input->post('password');
		    $msg = $this->member_model->login($data);
		    
		    if ($msg == 'OK_ORANG_NYA_UDAH_VERIFIED!')
		    {                
		        redirect(base_url() . 'member/dashboard/' . $this->session->userdata('nama_lengkap'), 'refresh');
		    }
    	}
        
        if($msg == 'OK_TAPI_BELUM_VERIFIED!'){
            $msg = 'Akun anda belum aktif. silahkan cek email anda untuk link aktivasi';
        }else if($msg == 'NGGA_ADA_ORANG_NYA!'){
            $msg = 'Email/Password anda salah';
        }

        if($message == 'check_verified_link'){
            $msg = 'Akun anda telah dibuat. silahkan cek email anda untuk link aktivasi';
        }else if($message == 'account_activated'){
            $msg = 'Akun anda sudah aktif!';
        }else{
            $page['msg'] = $msg;    
        }
        
        $page['msg'] = $msg;
        $page['page_name'] = 'member/login';
        $page['page_title'] = 'Login';
        $this->load->view('view_index', $page);

    }
}
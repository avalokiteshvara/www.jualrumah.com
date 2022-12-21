<?php

class Profile extends CI_Controller{


	function __construct(){

		parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('member_model'));
	}



	function index($msg=NULL){

		$page['profile'] = $this->member_model->retrieve_profile($this->session->userdata('user_id'));

        $page['mode'] = 'change_profile';
        $page['msg'] = $msg; 
        $page['page_name'] = 'member/profile';
        $page['page_title'] = 'Halaman Profile';
        $this->load->view('view_index', $page);
	}

	function change()
    {
        
        $msg = NULL;        
        
        $this->form_validation->set_rules('nama_depan', 'Nama depan', 'xss_clean|required');
        $this->form_validation->set_rules('nama_belakang', 'Nama belakang', 'xss_clean|required');

        $this->form_validation->set_rules('alamat', 'Alamat', 'xss_clean|required');
        $this->form_validation->set_rules('telp', 'No.Telp' , 'xss_clean|required');
         
        if($this->form_validation->run() == TRUE){

            $config['upload_path'] = './avatar/';   
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['encrypt_name'] = TRUE;

            $data['nama_depan'] = $this->input->post('nama_depan');
            $data['nama_belakang'] = $this->input->post('nama_belakang');
            $data['alamat'] = $this->input->post('alamat');
            $data['telp'] = $this->input->post('telp');
            
            $this->load->library('upload', $config);    

            if (!$this->upload->do_upload('foto')){
                $msg = $this->upload->display_errors();
            } else{
                $success = $this->upload->data();

                $photo = $this->db->query(
                    "SELECT photo ".
                    "FROM tbl_member ".
                    "WHERE id=".$this->session->userdata('user_id'))->row()->photo;

                if($photo != NULL){
                    if(file_exists('./avatar/' . $photo)){
                        unlink('./avatar/' . $photo);
                    }
                }                

                $data['photo'] = $success['file_name'];                
            } 
            
            $this->member_model->edit_profile($data);
            $msg = 'Profile berhasil di Update';
            
        }else{
            $msg = 'error:'.validation_errors();
        }
        
        
        $this->index($msg);
    }    
    
}
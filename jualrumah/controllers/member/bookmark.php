<?php

class Bookmark extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        
        $this->load->model(array('bookmark_model'));  

    }


    function index()
    {    	
        if($this->session->userdata('sudah_login') != 1){
            redirect(base_url(),'refresh');
        }
    	
        $page['bookmark_arr'] = $this->bookmark_model->get($this->session->userdata('user_id'));
    	$page['page_name'] = 'member/bookmark';
        $page['page_title'] = 'Bookmark';
        $this->load->view('view_index', $page);
    }


    function insert($id)
    {
        if($this->session->userdata('sudah_login') == 1){
               $data = array(
    		      'id_listing' => $id,
    		      'id_member' => $this->session->userdata('user_id')
    		    );

    	       echo  $this->bookmark_model->insert($data);
           }else{
               echo "NEED_LOGIN"; 
           }
    }

    function delete($id)
    {        
        if($this->session->userdata('sudah_login') == 1){
            echo $this->bookmark_model->delete($id,$this->session->userdata('user_id'));
        }else{
            echo "NEED_LOGIN"; 
        }
    }

}
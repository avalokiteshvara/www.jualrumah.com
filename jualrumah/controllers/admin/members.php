<?php

class Members extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('member_model','listing_model','pesan_model'));

        if($this->session->userdata('adm_sudahlogin') != 1){
          redirect(base_url() . 'admin/login','refresh');
        }
        
	}

    function delete($member_id){

        $this->member_model->delete($member_id);
        return 'OK';
    }

    function add_user()
    {
        $data = array();            
        $data['page_name'] = 'add_member';
        $data['active'] = 'members';

        $this->load->view('admin/view_index',$data);
    }

    function banned($member_id){

        $this->form_validation->set_rules('banned_reason','Alasan','xss_clean|required');

        if($this->form_validation->run()){
            
            $dt = array(
                'banned'=>'Y',
                'banned_reason' => $this->input->post('banned_reason')
                );
            $this->member_model->edit_member($member_id,$dt);
            echo 'OK';

        }else{
            
            echo 'Masukkan Alasan Untuk Banned Account ini!';

        }
    }

    function unbanned($member_id){
        $dt = array(
            'banned'=>'N',
            'banned_reason'=>'');
        $this->member_model->edit_member($member_id,$dt);

        echo 'OK';
    }

    function send_msg($id_penerima){
        
        $this->form_validation->set_rules('isi_pesan','Pesan','xss_clean|required');
        
   

        if($this->form_validation->run())
        {   
            $isi_pesan = $this->input->post('isi_pesan');

            $pesan= array(
                'id_penerima'   => $id_penerima,               
                'pesan' => $isi_pesan,
                'nama_pengirim' => 'admin',
                'email_pengirim' => 'admin@jualrumah.com',
                'from_admin' => 'Y'
                ); 

            $this->pesan_model->insert($pesan);            
            echo "OK";
        }else{            
            echo "Pesan kosong!" ;
        }   

    }


	function index(){
		//$this->show();

        //tampilkan email,nama depan, nama belakang, action (delete)
        

        $data = array();        

        //pagination
        $url = base_url() . 'admin/members/index/';
        $per_page = 10;
        $res = $this->db->count_all_results('tbl_member');
        $config = $this->paginate($url,$res,$per_page,4);
        $this->pagination->initialize($config);

        $data['jumlah_user'] = $res;
        $data['arr_users'] = $this->member_model->get_members($per_page,$this->uri->segment(4));
        
        $data['segment_4'] = $this->uri->segment(4);
        
        $data['page_title'] = 'Members'; 
        $data['page_name'] = 'members';
        $data['active_menu'] = 'members';
        
        $this->load->view('admin/view_index',$data);
	}

    function search(){

        $search_string = '';
        
        if(!empty($_POST)){
            $search_string = $this->input->post('search_string');       
        }   

        $url = base_url() . 'admin/members/search/';
        $per_page = 10;
        $res = $this->member_model->get_search_count($search_string);
        $config = $this->paginate($url,$res,$per_page,4);
        $this->pagination->initialize($config);         
        
        $data['page_title'] = 'Members'; 
        $data['page_name'] = 'members';
        $data['active_menu'] = 'members';
        $data['jumlah_user'] = $res;     
        $data['search_string'] = $search_string;            
        $data['arr_users'] = $this->member_model->get_search($search_string,$per_page,$this->uri->segment(4));
        
        $data['segment_4'] = $this->uri->segment(4);
    
        $this->load->view('admin/view_index',$data);
    }



	/*
     * Custom pagination function for easy usage Defines the css class for all
     * tags- numerical, open, close, next, previous, last, first
     */

	/* contoh penggunaan
		
		$url = base_url() . 'admin/channel/';
        $per_page = 10;
        $res = $this->db->count_all_results('community_user');
        $config = $this->paginate($url, $res, $per_page, 3);
        $this->pagination->initialize($config);

        $page['channels'] = $this->community_model->get_user_channel($per_page, $this->uri->segment(3));


	*/

    function paginate ($base_url, $total_rows, $per_page, $uri_segment)
    {
        $config = array('base_url' => $base_url, 'total_rows' => $total_rows, 
                'per_page' => $per_page, 'uri_segment' => $uri_segment);
        
        $config['anchor_class'] = 'class="page radius"';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li><span class="page-active radius">';
        $config['cur_tag_close'] = '</span></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        return $config;
    }


}
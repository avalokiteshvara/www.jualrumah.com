<?php

class Ver_by_email extends CI_Controller{


	function __construct(){

		parent::__construct();
		header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('admin/admconfig_model'));

	}


	function send_verified_code($id){

      $data['verification_code'] = generateRandomString();
      $this->listing_model->update($id,$data);

      $query = $this->db->query("SELECT b.email as email,".
                                "       a.judul_listing as judul_listing ,".
                                "       a.id as id, ".
                                "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama ".
                                "FROM tbl_listing a ".
                                "LEFT JOIN tbl_member b ".
                                "ON a.id_member = b.id ".
                                "WHERE a.id =".$id);

      $data['nama'] = $query->row()->nama;
      $data['id'] = $query->row()->id;
      $data['email'] = $query->row()->email;
      $data['judul_listing'] = $query->row()->judul_listing;


      $config = email_conf();

       //settings
      $this->load->library('email',$config);
      $this->email->set_newline("\r\n");
      $this->email->from('admin@jualrumah.com' , 'admin@jualrumah.com');
      $this->email->to($data['email']);
      $this->email->subject('Verifikasi kode listing property @jualrumah.com');

      $this->email->message($this->load->view('admin/emailverification', $data, true));

      if(@$this->email->send()){

          echo 'OK';

      }else{

          //echo 'ERROR';
					$this->db->where('id',$id);
					$this->db->update('tbl_listing',array('is_verified' => 'Y'));
					echo 'OK';

      }
    }
}

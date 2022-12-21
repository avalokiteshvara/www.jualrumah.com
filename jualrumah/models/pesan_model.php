<?php

class Pesan_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function _redirect_to_home(){
        redirect(base_url(),'refresh');
    }


    function _is_exist($id){
        $this->db->where('id',$id);
        $query = $this->db->get('tbl_pesan');

        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }
    
    function _is_listing_bellong2me($id){
        $this->db->where('id',$id);
        $this->db->where('id_penerima',$this->session->userdata('user_id'));        
        $query = $this->db->get('tbl_pesan');
        
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    function insert($data){
    	$this->db->insert('tbl_pesan',$data);
    	return 'Pesan telah terkirim. trimakasih';
    }

    function read($id){
        if(!$this->_is_exist($id) or !$this->_is_listing_bellong2me($id)){
            $this->_redirect_to_home();
        }

        $query = $this->db->query("SELECT pesan,nama_pengirim,telp FROM tbl_pesan WHERE id=".$id);
        $jsonData = array(
                "pesan" => $query->row()->pesan,
                "nama_pengirim" => $query->row()->nama_pengirim,
                "telp" => $query->row()->telp);

        return json_encode($jsonData);

    }

    function delete($id){

        if(!$this->_is_exist($id) or !$this->_is_listing_bellong2me($id)){
            $this->_redirect_to_home();
        }

        $this->db->delete('tbl_pesan',array('id' => $id));

        $query = $this->db->query("SELECT COUNT(*) as cnt " .
                                  "FROM tbl_pesan " .
                                  "WHERE id_penerima=" . $this->session->userdata('user_id'));
        return $query->row()->cnt;
    }

    function get_all(){
        $query=$this->db->query("SELECT a.id,a.pesan,CONCAT(a.nama_pengirim,' (',a.email_pengirim,')') as pengirim,".
                                "       a.telp,a.tgl_pesan,b.judul_listing ".
                                "FROM tbl_pesan a ".
                                "LEFT JOIN tbl_listing b ". 
                                "ON a.id_listing = b.id ".
                                "WHERE a.id_penerima = " . $this->session->userdata('user_id') ." ORDER BY a.tgl_pesan DESC");
        return $query;

    }
}
<?php


class Bookmark_model extends CI_Model
{

	
    function __construct()
    {
        parent::__construct();        
    }


    function get($id_member){    	
        $query = $this->db->query("SELECT a.id as id_bookmark, b.id as id_listing,b.tipe_listing as tipe,b.judul_listing as judul " . 
                                  "FROM tbl_bookmark a " .
                                  "LEFT JOIN tbl_listing b ".
                                  "ON a.id_listing = b.id ".
                                  "WHERE a.id_member =".$id_member);
    	return $query;
    }


    function insert($data){
        //cek apakah sudah ada di bookmark?
        
        $query = $this->db->get_where('tbl_bookmark',array('id_listing' => $data['id_listing'],
                                                          'id_member'  => $data['id_member'] ));

        if($query->num_rows() > 0){
            return 'Properti sudah ada dalam bookmark';
        }else{
            $this->db->insert('tbl_bookmark',$data);
            return 'Properti telah tersimpan';
        }
    }


    function delete($id,$id_member){        
    	$this->db->delete('tbl_bookmark',array('id' => $id));

        $query = $this->db->query('SELECT COUNT(*) as cnt FROM tbl_bookmark WHERE id_member='.$id_member);
        return $query->row()->cnt;
    }


}
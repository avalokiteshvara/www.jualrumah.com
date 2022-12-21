<?php

class Admmessage_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();        
    }


    function get_all(){
    	$query = $this->db->query("SELECT * FROM tbl_admin_messages");
    	return $query;
    }

	function read($id){
        
        $query = $this->db->query(
            "SELECT pesan,nama,email,from_member,id_member ".
            "FROM tbl_admin_messages WHERE id=".$id);
        $jsonData = array(
                "pesan"         => $query->row()->pesan,
                "nama"          => $query->row()->nama,
                "email"         => $query->row()->email,
                "from_member"   => $query->row()->from_member,
                "id_member"     => $query->row()->id_member);

        return json_encode($jsonData);

    }

	function delete($id){

        $this->db->delete('tbl_admin_messages',array('id' => $id));
        $query = $this->db->query("SELECT COUNT(*) as cnt " .
                                  "FROM tbl_admin_messages");
        return $query->row()->cnt;
    }


}
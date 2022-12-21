<?php 

class Admin_messages_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }


    function insert($data){
    	$this->db->insert('tbl_admin_messages',$data);
    }
}

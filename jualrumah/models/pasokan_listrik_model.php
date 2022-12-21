<?php 
class Pasokan_listrik_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get(){
        $this->db->cache_on();
        $query = $this->db->get('tbl_pasokan_listrik');
        return $query->result();
    }
}

?>
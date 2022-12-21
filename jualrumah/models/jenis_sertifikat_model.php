<?php 

class Jenis_sertifikat_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get(){
        $this->db->cache_on();
       	$query = $this->db->get('tbl_jns_sertifikat');
        return $query->result();
    }
    
}

?>
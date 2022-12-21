<?php

class Tipe_properti_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get($induk)
    {
        $this->db->cache_on();
        $data = array();
        $this->db->from('tbl_tipe_properti');
        $this->db->where('id_parent', $induk);
        $result = $this->db->get();
    
        foreach ($result->result() as $row)
        {
            $data[] = array(
                'id' => $row->id,
                'nama' => $row->nama,
                // recursive
                'child' => $this->get($row->id)
            );
        }
        return $data;
    }
}

?>

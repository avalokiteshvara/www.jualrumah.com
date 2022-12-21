<?php

class Admconfig_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $query = $this->db->query('SELECT * FROM tbl_config');

        return $query;
    }

    public function save($data)
    {
        $this->db->truncate('tbl_config');
        $this->db->insert_batch('tbl_config', $data);
    }
}

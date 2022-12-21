<?php

class Admlogin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();        
    }



    function login($data)
    {
        $query = $this->db->get_where('tbl_admin', array(
            'user_name' => $data['user_name'],
            'password' => $data['password']
        ));
        
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $this->session->set_userdata('adm_sudahlogin', 1);
            $this->session->set_userdata('adm_userid', $row->id);
            $this->session->set_userdata('adm_namalengkap', $row->nama_lengkap);
            $this->session->set_userdata('adm_username', $row->user_name);
            $this->session->set_userdata('adm_email', $row->email);
            return TRUE;
        } else
            return FALSE;
    }    

}
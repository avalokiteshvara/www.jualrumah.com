<?php 

class Admin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();        
    }


    function change_password($old_pass,$new_pass){
        
        $this->db->where('password',md5($old_pass));
        $this->db->where('id', $this->session->userdata('adm_userid'));
        $query = $this->db->get('tbl_admin');
        
        if ($query->num_rows() > 0){
            $this->db->flush_cache();     
            
            $data['password'] = md5($new_pass);
            $this->db->where('id', $this->session->userdata('adm_userid'));
            $this->db->update('tbl_admin', $data);
            
            return TRUE;
        }else{
            return FALSE;
        }
        
        
    }

}
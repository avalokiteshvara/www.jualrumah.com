<?php

class Comments_model extends CI_Model
{

	
    function __construct()
    {
        parent::__construct();        
    }


    function retrieve_comments($id_listing,$limit = NULL, $offset = 0){

        $offset = empty($offset) ? 0 : $offset;

        $query = $this->db->query(
        	"SELECT if(c.id_member = a.id_member,CONCAT('Pengiklan (',b.email,')'),b.email) as sender,".
        	"		a.comment as comment,".            
            "       a.insert_at as inserted_dtime ".
            "FROM tbl_comments a ".
            "LEFT JOIN tbl_member b ON a.id_member = b.id ".
            "LEFT JOIN tbl_listing c ON a.id_listing = c.id ".
            "WHERE a.id_listing =". $id_listing. 
            " ORDER BY a.insert_at DESC ".
            "LIMIT ".$offset.",".$limit);
        return $query;
    }

    function insert_comment($data){
        $this->db->insert('tbl_comments',$data);
        
        $owner_id = $this->db->query(
        	"SELECT id_member ".
        	"FROM tbl_listing ".
        	"WHERE id=".$data['id_listing'])->row()->id_member;

        $email = ($data['id_member'] == $owner_id) ? 'Pengiklan ('.$this->session->userdata('email').')' : $this->session->userdata('email');

        return '<tr>'.
               '      <th align="left" bgcolor="#F1F1F1">'.$email.'</th>'.
               '      <th align="right" bgcolor="#F1F1F1">'.date("Y-m-d H:i:s").'</th>'.
               '</tr>'.
               '<tr>'.
               '      <td colspan="2" ><blockquote>'.$data['comment'].'</blockquote></td>' .                      
               '</tr>';
    }

}
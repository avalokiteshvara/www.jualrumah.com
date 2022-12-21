<?php

class Images_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();        
    }


    function _is_bellong2me($id){
        $this->db->where('id',$id);
        $this->db->where('id_member',$this->session->userdata('user_id'));
        
        $query = $this->db->get('tbl_listing');
        
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

	function _is_item_bellong2me($id){
        $query = $this->db->query('select b.id_member ' . 
                                  'from tbl_images a left join tbl_listing b ' .
                                  'on a.listing_id = b.id ' . 
                                  'where a.id ='.$id);
        if($query->num_rows() > 0){
        	return ($query->row()->id_member == $this->session->userdata('user_id')) ? TRUE : FALSE;
        }else{
        	return FALSE;
        }
    }
    
    function delete_image($id){

        if(!$this->_is_item_bellong2me($id)){
            redirect(base_url(),'refresh');
        }  

        //remove file first
        $this->_remove_image($id);

        //and then remove from database
        $this->db->where('id',$id);
        $this->db->delete('tbl_images');
    }
    
    function _remove_image($image_id){
       $query =  $this->db->query('select file_name from tbl_images where id='.$image_id);
       $file_image = $query->row()->file_name;
       if( is_file( './media/'.$file_image ) ){
        @unlink('./media/'.$file_image);
       }
    }    

    function get($listing_id,$need_verification = TRUE){
        if($need_verification){
        	if(!$this->_is_bellong2me($listing_id)){
        		redirect(base_url(),'refresh');
        	}
        }

    	$this->db->where('listing_id',$listing_id);
        $query = $this->db->get('tbl_images');
        return $query;
    }

    function insert($data){
        $this->db->insert('tbl_images',$data);
    }

}
<?php

class Member_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function _remove_image($image_id){
       $query =  $this->db->query('select file_name from tbl_images where id='.$image_id);
       $file_image = $query->row()->file_name;
       if( is_file( './media/'.$file_image ) ){
        @unlink('./media/'.$file_image);
       }
    }    

    function delete($member_id){
        //aksi delete akan menghapus (sesuai urutan :)
        
        //1.data bookmark
        //2.data images
        //3.file images
        //4.data listing
        //5.data pesan
        //6.data member
        //7.delete comments

        //delete data bookmark
        $this->db->delete('tbl_bookmark',array('id_member'=>$member_id));

        $query_images = $this->db->query(
            "SELECT a.id as id, a.file_name as file_name ".
            "FROM tbl_images a ".
            "LEFT JOIN tbl_listing b ON a.listing_id = b.id ".
            "WHERE b.id_member =".$member_id);

        foreach ($query_images->result() as $image) {
            
            //delete image file
            if( is_file( './media/'.$image->file_name ) ){
                @unlink('./media/'.$image->file_name);
            }    

            //delete data row
            $this->db->delete('tbl_images',array('id'=>$image->id));

        }

        //delete listing
        $this->db->delete('tbl_listing',array('id_member'=>$member_id));

        //delete pesan
        $this->db->delete('tbl_pesan',array('id_penerima'=>$member_id));        

        //delete member
        $this->db->delete('tbl_member',array('id'=>$member_id));

        $this->db->delete('tbl_comments',array('id_member'=>$member_id));        
    }


    function get_search_count($search_string){

        $query = $this->db->query(
            "SELECT COUNT(*) as cnt ".
            "FROM tbl_member a ".
            "WHERE a.nama_depan LIKE '%$search_string%' ".
            "      OR a.nama_belakang LIKE '%$search_string%' ".
            "      OR a.email LIKE '%$search_string%' ");

        return $query->row()->cnt;

    }

    function get_search($search_string=NULL ,$limit=NULL,$offset= 0){
        
        $offset = empty($offset) ? 0 : $offset;

        $query = $this->db->query(
            "SELECT a.id,a.banned,a.created,a.email,a.nama_depan,".
            "       a.nama_belakang,a.is_verified,count(b.id) as cnt_listing ".
            "FROM tbl_member a ".
            "LEFT JOIN tbl_listing b ".
            "ON a.id = b.id_member ".            
            "WHERE a.nama_depan LIKE '%$search_string%' ".
            "      OR a.nama_belakang LIKE '%$search_string%' ".
            "      OR a.email LIKE '%$search_string%' ".
            "GROUP BY a.id ".
            "ORDER BY a.email ".
            "LIMIT ".$offset.",".$limit);
        return $query;
    }

    function get_members($limit = NULL, $offset = 0){
        
        $offset = empty($offset) ? 0 : $offset;

        $query = $this->db->query(
            "SELECT a.id,a.banned,a.created,a.email,a.nama_depan,".
            "       a.nama_belakang,a.is_verified,count(b.id) as cnt_listing ".
            "FROM tbl_member a ".
            "LEFT JOIN tbl_listing b ".
            "ON a.id = b.id_member ".            
            "GROUP BY a.id ".
            "ORDER BY a.email ".
            "LIMIT ".$offset.",".$limit);
        return $query;
    }    
    
    
    /*apakah listing dengan member_id, judul dan deskripsi ini sudah ada?*/
    function is_listing_exist($data){
        $this->db->where('judul_listing',$data['judul_listing']);
        $this->db->where('deskripsi_listing',$data['deskripsi_listing']);
        $this->db->where('id_member',$this->session->userdata('user_id'));
        $query = $this->db->get('tbl_listing');
        
        return  $query->num_rows() > 0 ? TRUE:FALSE;
        
    }
    
    function login($data)
    {
        $query = $this->db->get_where('tbl_member', array(
            'email' => $data['email'],
            'password' => md5($data['password'])
        ));
        
        //apakah ada row data ?
        if ($query->num_rows() > 0)
        {

            //cek apakah sudah verified?

            if($query->row()->is_verified == 'Y'){

                if($query->row()->banned =='Y'){
                    return "Account anda dibekukan! Alasan:".$query->row()->banned_reason;
                }else{
                    $row = $query->row();
                    $this->session->set_userdata('sudah_login', 1);
                    $this->session->set_userdata('user_id', $row->id);
                    $this->session->set_userdata('nama_depan', $row->nama_depan);
                    $this->session->set_userdata('nama_belakang', $row->nama_belakang);
                    $this->session->set_userdata('email', $row->email);
                    return 'OK_ORANG_NYA_UDAH_VERIFIED!';
                }
                

            } else{
                return 'OK_TAPI_BELUM_VERIFIED!';
            }
            
        } else
            return 'NGGA_ADA_ORANG_NYA!';
    }
    
    
    function retrieve_profile($id){
        $this->db->where('id',$id);
        $query = $this->db->get('tbl_member');
        return $query->result();        
    }
    
    //edit profile
    function edit_profile($data){
        $this->db->where('id',$this->session->userdata('user_id'));
        $this->db->update('tbl_member',$data);
        
    }
    
    //admin privilege
    function edit_member($id,$data){
        $this->db->where('id',$id);
        $this->db->update('tbl_member',$data);
    }

    function retrieve_messages($id_user,$tipe){
       if($tipe == "in")
       {
            $q= "SELECT a.id AS id,".
                "       a.tipe AS tipe,".
                "       a.tgl_pesan AS tanggal,".
                "       CASE a.is_member".
                "           WHEN 'Y' THEN b.nama_lengkap".
                "           WHEN 'N' THEN a.nama_pengirim".
                "       END AS	nama_pengirim,".
                "       CASE a.is_member".
                "           WHEN 'Y' THEN b.email".
                "           WHEN 'N' THEN a.email_pengirim".
                "       END AS	email_pengirim,".
                "       CASE a.is_member".
                "           WHEN 'Y' THEN b.telp".
                "           WHEN 'N' THEN a.telp".
                "       END AS	telp_pengirim,".
                "       CASE a.is_member".
                "           WHEN 'Y' THEN b.alamat".
                "           WHEN 'N' THEN a.alamat_pengirim".
                "       END AS	alamat_pengirim,".
                "a.id_listing,".
                "a.pesan ".
                "FROM tbl_pesan_masuk a ".
                "LEFT JOIN tbl_member b ".
                "ON a.id_pengirim = b.id ".
                "WHERE a.id_penerima =".$id_user;
       }      
         
               
        $query = $this->db->query($q);
        return $query->result();
    }
    
    function get_password($user_id){
        
        $this->db->select('password');
        $this->db->where('id', $user_id);
        $query = $this->db->get('tbl_member');
        
        $row = $query->row();
        
        return $row->password;
    }
    
    function is_email_exist($email){
        $this->db->where('email',$email);
        $query = $this->db->get('tbl_member');
        
        if ($query->num_rows() > 0){
          return TRUE;
        }else{
          return FALSE;
        }        
    }
    
    
    
    function change_password($old_pass,$new_pass){
        
        $this->db->where('password',md5($old_pass));
        $this->db->where('id', $this->session->userdata('user_id'));
        $query = $this->db->get('tbl_member');
        
        if ($query->num_rows() > 0){
            $this->db->flush_cache();     
			
            $data['password'] = md5($new_pass);
            $this->db->where('id', $this->session->userdata('user_id'));
            $this->db->update('tbl_member', $data);
            
            return TRUE;
        }else{
            return FALSE;
        }
        
        
    }
    
    
    function signup($data){
        $this->db->insert('tbl_member', $data);
    }

}

?>
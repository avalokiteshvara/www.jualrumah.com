<?php

class Listing_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _redirect_to_home()
    {
        redirect(base_url(), 'refresh');
    }

    public function activate_listing($verification_code)
    {
        $query = $this->db->query(
            'SELECT COUNT(*) as cnt '.
            'FROM tbl_listing '.
            "WHERE verification_code='".$verification_code."'");

        $msg = null;

        if ($query->row()->cnt != 0) {
            $this->db->query(
                'UPDATE tbl_listing '.
                "SET is_verified='Y' ".
                "WHERE verification_code='".$verification_code."'");

            $msg = 'OK';
        } else {
            $msg = 'NOT_FOUND';
        }

        return $msg;
    }

    public function slideshow()
    {
        $query = $this->db->query(
            'SELECT a.id, a.judul_listing,a.deskripsi_listing,b.file_name '.
            'FROM tbl_listing a '.
            'INNER JOIN (SELECT file_name,listing_id FROM tbl_images ORDER BY RAND()) b ON b.listing_id = a.id '.
            "WHERE a.is_verified='Y' ".
            'GROUP BY a.id '.
            'ORDER BY RAND() '.
            'LIMIT 3');

        return $query;
    }



    //admin
    public function get_search_count($search_string)
    {
        $query = $this->db->query(
                    'SELECT COUNT(*) as cnt '.
                    'FROM tbl_listing b '.
                    'LEFT JOIN tbl_member a ON b.id_member = a.id '.
                    'LEFT JOIN tbl_tipe_properti c ON b.id_tipe_properti = c.id '.

                    'LEFT JOIN t_provinsi d ON b.provinsi = d.id '.
                    'LEFT JOIN t_kabupaten e ON b.kabupaten = e.id '.
                    'LEFT JOIN t_kecamatan f ON b.kecamatan = f.id '.

                    "WHERE (a.nama_depan LIKE '%$search_string%' ".
                    "      OR a.nama_belakang LIKE '%$search_string%' ".
                    "      OR c.nama LIKE '%$search_string%' ".
                    "      OR e.name LIKE '%$search_string%' ".
                    "      OR f.name LIKE '%$search_string%' ".
                    "      OR b.tipe_listing LIKE '%$search_string%' ".
                    "      OR b.judul_listing LIKE '%$search_string%') ");

        return $query->row()->cnt;
    }

    //admin
    public function get_search($search_string = null, $limit = null, $offset = 0)
    {
        $offset = empty($offset) ? 0 : $offset;

        $query = $this->db->query(
                    "SELECT CONCAT_WS(' ',a.nama_depan,a.nama_belakang) as nama_member,
                            b.jenis_iklan,b.bukti_pembayaran_status,".
                    '       SUBSTRING(b.judul_listing,1,20) as judul,'.
                    '       b.tipe_listing as jual_sewa,'.
                    '       c.nama as tipe,'.
                    '       CONCAT(f.name , " , ", e.name) as lokasi,'.
                    "       CONCAT(b.harga,' ',b.satuan_harga) as harga,".
                    '       b.total_dilihat as dilihat, '.
                    '       b.has_sold as terjual,'.
                    '       b.is_verified, '.
                    '       b.id '.
                    'FROM tbl_listing b '.
                    'LEFT JOIN tbl_member a ON b.id_member = a.id '.
                    'LEFT JOIN tbl_tipe_properti c ON b.id_tipe_properti = c.id '.

                    'LEFT JOIN t_provinsi d ON b.provinsi = d.id '.
                    'LEFT JOIN t_kabupaten e ON b.kabupaten = e.id '.
                    'LEFT JOIN t_kecamatan f ON b.kecamatan = f.id '.

                    "WHERE  (a.nama_depan LIKE '%$search_string%' ".
                    "       OR a.nama_belakang LIKE '%$search_string%' ".
                    "       OR c.nama LIKE '%$search_string%' ".
                    "       OR e.name LIKE '%$search_string%' ".
                    "       OR f.name LIKE '%$search_string%' ".
                    "       OR b.tipe_listing LIKE '%$search_string%' ".
                    "       OR b.judul_listing LIKE '%$search_string%') ".
                    'ORDER BY nama_member,dilihat DESC '.
                    'LIMIT '.$offset.','.$limit);

        return $query;
    }

    //admin
    public function get_all($limit = null, $offset = 0)
    {
        $offset = empty($offset) ? 0 : $offset;

        $query = $this->db->query(
                    "SELECT b.bukti_pembayaran_status,
                            b.jenis_iklan,b.bukti_pembayaran,
                           CONCAT_WS(' ',a.nama_depan,a.nama_belakang) as nama_member,
                           SUBSTRING(b.judul_listing,1,20) as judul,
                           b.tipe_listing as jual_sewa,
                           c.nama as tipe,
                           CONCAT(f.name , ',', e.name) as lokasi,
                           CONCAT(b.harga,' ',b.satuan_harga) as harga,
                           b.total_dilihat as dilihat,
                           b.has_sold as terjual,
                           b.is_verified as is_verified,
                           b.id as id
                    FROM tbl_listing b
                    LEFT JOIN tbl_member a ON b.id_member = a.id
                    LEFT JOIN tbl_tipe_properti c ON b.id_tipe_properti = c.id

                    LEFT JOIN t_provinsi d ON b.provinsi = d.id
                    LEFT JOIN t_kabupaten e ON b.kabupaten = e.id
                    LEFT JOIN t_kecamatan f ON b.kecamatan = f.id

                    ORDER BY has_sold DESC,
                             IF(b.bukti_pembayaran_status <> 'pending',0,1) ASC,

                             last_edit DESC,
                             nama_member ASC,
                             dilihat DESC
                    LIMIT $offset, $limit");

        return $query;
    }

    //hanya untuk tipe properti yang bisa ditinggali. ex:rumah, villa dll
    //ditampilkan difront page
    public function get_mostviewed_for_personal($limit = 10)
    {
        $query = $this->db->query(
                    "SELECT CONCAT_WS(' ',c.nama ,'dengan',b.jml_kamar_tidur,'kamar tidur','untuk di',b.tipe_listing) as description,".
                    '       CONCAT(f.name," , ", e.name) as lokasi,'.
                    "       CONCAT(b.harga,' ',b.satuan_harga) as harga,".
                    '       b.id as id '.
                    'FROM tbl_listing b '.
                    'LEFT JOIN tbl_member a ON b.id_member = a.id '.
                    'LEFT JOIN tbl_tipe_properti c ON b.id_tipe_properti = c.id '.

                    'LEFT JOIN t_provinsi d ON b.provinsi = d.id '.
                    'LEFT JOIN t_kabupaten e ON b.kabupaten = e.id '.
                    'LEFT JOIN t_kecamatan f ON b.kecamatan = f.id '.

                    "WHERE  b.has_sold='N' ".
                    '       AND (c.id = 2 OR c.id = 3 OR c.id = 4 OR c.id = 6 OR c.id = 8) '.
                    "       AND b.is_verified='Y' ".
                    'ORDER BY b.total_dilihat DESC '.
                    'LIMIT '.$limit);

        return $query;
    }

    //admin
    public function get_mostviewed($limit = 10)
    {
        $query = $this->db->query(
                    "SELECT CONCAT_WS(' ',a.nama_depan,a.nama_belakang) as nama_member,".
                    '       SUBSTRING(b.judul_listing,1,20) as judul,'.
                    '       b.tipe_listing as jual_sewa,'.
                    '       c.nama as tipe,'.
                    '       CONCAT(f.name , " , ", e.name) as lokasi,'.
                    "       CONCAT(b.harga,' ',b.satuan_harga) as harga,".
                    '       b.total_dilihat as dilihat '.
                    'FROM tbl_listing b '.
                    'LEFT JOIN tbl_member a ON b.id_member = a.id '.
                    'LEFT JOIN tbl_tipe_properti c ON b.id_tipe_properti = c.id '.

                    'LEFT JOIN t_provinsi d ON b.provinsi = d.id '.
                    'LEFT JOIN t_kabupaten e ON b.kabupaten = e.id '.
                    'LEFT JOIN t_kecamatan f ON b.kecamatan = f.id '.


                    "WHERE  b.has_sold='N' ".
                    "       AND b.is_verified='Y' ".
                    'ORDER BY b.total_dilihat DESC '.
                    'LIMIT '.$limit);

        return $query;
    }

    public function get_last_upload($limit = 4)
    {
        $query = $this->db->query(
            'SELECT a.id as id,'.
            "       CONCAT(a.harga,' ',a.satuan_harga) as harga,".
            '       a.judul_listing as judul_listing, '.
            '       CONCAT(d.name," , ", c.name) as lokasi, '.
            "       IF(e.file_name IS NULL,'no_images.jpg',e.file_name) as file_name ".
            'FROM tbl_listing a '.

            'LEFT JOIN t_provinsi b ON a.provinsi = b.id '.
            'LEFT JOIN t_kabupaten c ON a.kabupaten = c.id '.
            'LEFT JOIN t_kecamatan d ON a.kecamatan = d.id '.

            'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) e ON a.id = e.listing_id '.

            "WHERE a.is_verified='Y' AND a.has_sold='N' ".
            'GROUP BY a.id '.
            'ORDER BY a.tgl_buat DESC '.
            'LIMIT '.$limit);

        return $query;
    }

    public function compare($id_listing)
    {
        $query = $this->db->query(
                    'SELECT a.id as id_listing,'.
                    '       a.id_member as id_member,'.
                    '       f.telp as telp,'.
                    '       a.tipe_listing as tipe_listing,'.
                    "       CONCAT_WS(' ',f.nama_depan,f.nama_belakang) as nama_kontak, ".
                    '       f.telp as tlp_kontak, '.
                    '       b.nama as tipe_properti,'.
                    '       a.judul_listing as judul,'.
                    '       a.deskripsi_listing as deskripsi,'.

                    '       CONCAT(e.name," , ",d.name) AS lokasi, '.

                    '       a.alamat_lengkap,'.
                    "       CONCAT(a.harga,' ',a.satuan_harga) as harga,".
                    '       a.jml_kamar_tidur as jml_kmr_tdr,'.
                    '       a.jml_kamar_mandi as jml_kmr_mandi,'.
                    '       a.jml_lantai as jml_lantai, '.
                    '       a.luas_tanah as luas_tanah, '.
                    '       a.dimensi_tanah as dimensi_tanah, '.
                    '       a.luas_bangunan as luas_bangunan, '.
                    '       a.dimensi_bangunan as dimensi_bangunan, '.
                    '       a.thn_pembangunan as thn_pembangunan, '.
                    "       IF(g.file_name IS NULL,'no_images.jpg',g.file_name) as file_name ".
                    'FROM tbl_listing a '.
                    'LEFT JOIN tbl_tipe_properti b ON a.id_tipe_properti = b.id '.

                    'LEFT JOIN t_provinsi c ON a.provinsi = c.id '.
                    'LEFT JOIN t_kabupaten d ON a.kabupaten = d.id '.
                    'LEFT JOIN t_kecamatan e ON a.kecamatan = e.id '.

                    'LEFT JOIN tbl_member f ON a.id_member = f.id '.
                    'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) g ON a.id = g.listing_id '.

                    'WHERE a.id IN('.substr($id_listing, 1).') '.
                    'GROUP BY a.id');

        return $query;
    }

    // function get_count($sql_where){
    //     $query = $this->db->query("SELECT COUNT(a.id) AS cnt ".
    //                               "FROM tbl_listing a ".$sql_where);
    //     return $query->row()->cnt;
    // }

    public function get_count_based_tipe_properti()
    {
        $query = $this->db->query('SELECT b.id,b.nama, COUNT(b.id) as cnt '.
                 'FROM tbl_listing a '.
                 'LEFT JOIN tbl_tipe_properti b ON a.id_tipe_properti = b.id '.
                 "WHERE a.has_sold = 'N' AND a.is_verified='Y' ".
                 'GROUP BY a.id_tipe_properti '.
                 'ORDER BY cnt DESC');

        return $query;
    }

    public function _is_exist($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_listing');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function _is_listing_bellong2me($listing_id)
    {
        $this->db->where('id', $listing_id);
        $this->db->where('id_member', $this->session->userdata('user_id'));

        $query = $this->db->get('tbl_listing');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($data)
    {
        //insert data then...
        $this->db->insert('tbl_listing', $data);
    }

    public function update($id, $data)
    {

        //override for admin
        if ($this->session->userdata('adm_sudahlogin') != 1) {
            if ((!$this->_is_exist($id)) or (!$this->_is_listing_bellong2me($id))) {
                $this->_redirect_to_home();
            }
        }

        $this->db->where('id', $id);
        $this->db->update('tbl_listing', $data);
    }

    public function delete($id)
    {

        //override for admin
        if ($this->session->userdata('adm_sudahlogin') != 1) {
            if ((!$this->_is_exist($id)) or (!$this->_is_listing_bellong2me($id))) {
                $this->_redirect_to_home();
            }
        }

        $query_images = $this->db->query(
            'SELECT a.id as id, a.file_name as file_name '.
            'FROM tbl_images a '.
            'LEFT JOIN tbl_listing b ON a.listing_id = b.id '.
            'WHERE b.id ='.$id);

        foreach ($query_images->result() as $image) {

            //delete image file
            if (is_file('./media/'.$image->file_name)) {
                @unlink('./media/'.$image->file_name);
            }

            //delete data row
            $this->db->delete('tbl_images', array('id' => $image->id));
        }

        $this->db->delete('tbl_listing', array('id' => $id));
    }

    public function get_max_id()
    {
        //get current id
        $this->db->select_max('id', 'curr_id');
        $this->db->where('id_member', $this->session->userdata('user_id'));
        $query = $this->db->get('tbl_listing');
        $row = $query->row();

        return $row->curr_id;
        //atau pake $this->db->insert_id()
    }

    public function update_viewed($id)
    {
        $this->db->where('id', $id);
        $this->db->set('total_dilihat', 'total_dilihat+1', false);
        $this->db->update('tbl_listing');
    }

    public function get($id)
    {

        $this->db->where('id', $id);
        $query = $this->db->get('tbl_listing');

        return $query;
    }

    public function get_edit_listing($id)
    {
        if ((!$this->_is_exist($id)) or (!$this->_is_listing_bellong2me($id))) {
            $this->_redirect_to_home();
        }

        // return $this->db->query('SELECT a.jenis_iklan,a.tipe_listing,a.judul_listing,a.id_tipe_properti,a.new_house,'.
        //                         '       a.deskripsi_listing,a.provinsi,a.kabupaten,a.kecamatan,a.alamat_lengkap,'.
        //                         '       a.tipe_harga,a.harga,a.id_jns_sertifikat,a.luas_bangunan,'.
        //                         '       a.luas_tanah,a.dimensi_bangunan,a.dimensi_tanah,a.satuan_harga,a.lat,a.lng '.
        //                         'FROM tbl_listing a '.
        //                         'WHERE id='.$id);
        $this->db->where('id',$id);
        return $this->db->get('tbl_listing');
    }

    public function get_edit_additional_info($id)
    {
        if ((!$this->_is_exist($id)) or (!$this->_is_listing_bellong2me($id))) {
            $this->_redirect_to_home();
        }

        return $this->db->query('SELECT jml_kamar_tidur,jml_kamar_pembantu,jml_kamar_mandi,jml_garasi,'.
                                '       jml_carport,jml_saluran_telp,jml_lantai,kondisi,pasokan_listrik,menghadap '.
                                'FROM tbl_listing '.
                                'WHERE id='.$id);
    }

    public function get_mylisting($limit = null, $offset = 0)
    {
        $this->db->where('id_member', $this->session->userdata('user_id'));
        $this->db->order_by('tgl_buat');
        $query = $this->db->get('tbl_listing', $limit, $offset);

        return $query;
    }
}

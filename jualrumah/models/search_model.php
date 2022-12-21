<?php

class Search_model extends CI_Model
{
    // var $default_order = 'tgl_buat DESC';

    public function __construct()
    {
        parent::__construct();
    }

    public function search($data, $harga_min = null, $harga_max = null, $limit = null, $offset = 0)
    {
        //lokasi,jual/sewa,tipe properti,jumlah kamar tidur,harga min, harga max

        //check
        if ((strlen($harga_min) > 0)  and ($harga_min != null)) {
            $harga_min = preg_replace('/[^0-9]/', '', $harga_min);
        }

        if ((strlen($harga_max) > 0)  and ($harga_max != null)) {
            $harga_max = preg_replace('/[^0-9]/', '', $harga_max);
        }

        //jika hanya harga min yang di masukkan
        if ($harga_min != null and $harga_max == null) {
            $this->db->where('harga >='.$harga_min);
        } else {
            if ($harga_min == null and $harga_max != null) {
                $this->db->where('harga <='.$harga_max);
            } else {
                if ($harga_min != null and $harga_max != null) {
                    $this->db->where('`satuan_sebenarnya` BETWEEN '.$harga_min.' AND '.$harga_max, null, false);
                }
            }
        }

        $this->db->select(
            'a.*,'.
            "CONCAT_WS(' ',b.nama_depan,b.nama_belakang ) as nama_lengkap, ".
            'b.telp,'.
            "IF( c.file_name IS NULL, 'no_images.jpg' ,c.file_name ) as file_name ", false);
        $this->db->join('tbl_member b', 'a.id_member = b.id', 'left');
        $this->db->join('(SELECT file_name,listing_id FROM tbl_images) c', 'a.id = c.listing_id', 'left');
        $this->db->where("a.is_verified = 'Y'");
        $this->db->order_by('a.tgl_buat DESC');
        $this->db->group_by('a.id');

        return $this->db->get_where('tbl_listing a', $data, $limit, $offset);
    }
}

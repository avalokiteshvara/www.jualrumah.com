<?php

class Agen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        $this->load->model(array('admin/admconfig_model'));
    }

    public function view_property($id_member){

      $data = array();

      $query = $this->admconfig_model->get()->result();

      foreach ($query as $row) {
          switch ($row->item) {
            case 'site_title':
                $data['site_title'] = $row->value;
                break;

            case 'cs_phone':
                $data['cs_phone'] = $row->value;
                break;

            case 'office_address':
                $data['office_address'] = $row->value;
                break;

            case 'office_town':
                $data['office_town'] = $row->value;
                break;

            case 'office_zip':
                $data['office_zip'] = $row->value;
                break;

            case 'use_email_verification':
                $data['use_email_verification'] = $row->value;
                break;

            case 'facebook_link'    :
                $data['facebook_link'] = $row->value;
                break;
            default:
                # code...
                break;
        }
      }

      $url = base_url().'agen/view_property/' . $id_member . '/';
      $per_page = 10;

      $property = $this->db->get_where('tbl_listing', array('id_member' => $id_member, 'is_verified' => 'Y'));
      $res = $property->num_rows();

      $config = $this->paginate($url, $res, $per_page, 4);
      $this->pagination->initialize($config);

      $this->db->select("a.id,a.judul_listing,a.deskripsi_listing,a.id_member,a.is_verified,a.total_dilihat,a.tipe_listing,
                        a.harga,a.satuan_harga,a.id_tipe_properti,a.has_sold,a.new_house,
                        a.jml_kamar_tidur,a.tgl_buat,CONCAT(b.nama_depan,' ',b.nama_belakang) AS nama_lengkap,b.telp",FALSE);
      $this->db->join('tbl_member b','a.id_member = b.id','left');
      $data['property'] = $this->db->get_where('tbl_listing a', array('a.id_member' => $id_member, 'a.is_verified' => 'Y'), $per_page, $this->uri->segment(4));

      $data['page_title'] = 'Daftar Property Untuk Agen';
      $data['page_name'] = 'agen_view_property';

      $this->load->view('view_index', $data);
    }

    public function view_list()
    {
        $data = array();

        $query = $this->admconfig_model->get()->result();

        foreach ($query as $row) {
            switch ($row->item) {
              case 'site_title':
                  $data['site_title'] = $row->value;
                  break;

              case 'cs_phone':
                  $data['cs_phone'] = $row->value;
                  break;

              case 'office_address':
                  $data['office_address'] = $row->value;
                  break;

              case 'office_town':
                  $data['office_town'] = $row->value;
                  break;

              case 'office_zip':
                  $data['office_zip'] = $row->value;
                  break;

              case 'use_email_verification':
                  $data['use_email_verification'] = $row->value;
                  break;

              case 'facebook_link'    :
                  $data['facebook_link'] = $row->value;
                  break;
              default:
                  # code...
                  break;
          }
        }

        $url = base_url().'agen/view_list/';
        $per_page = 10;

        $member = $this->db->get_where('tbl_member', array('is_verified' => 'Y', 'banned' => 'N'));
        $res = $member->num_rows();

        $config = $this->paginate($url, $res, $per_page, 3);
        $this->pagination->initialize($config);

        $data['member'] = $this->db->get_where('tbl_member', array('is_verified' => 'Y', 'banned' => 'N'), $per_page, $this->uri->segment(3));

        $data['page_title'] = 'Agen List';
        $data['page_name'] = 'agen_view_list';

        $this->load->view('view_index', $data);
    }


    public function paginate($base_url, $total_rows, $per_page, $uri_segment)
    {
        $config = array('base_url' => $base_url, 'total_rows' => $total_rows,
              'per_page' => $per_page, 'uri_segment' => $uri_segment, );

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }
}

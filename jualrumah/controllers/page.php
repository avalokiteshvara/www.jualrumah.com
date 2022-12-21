<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Page extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        header('Content-type: text/html; charset=iso-8859-1');

        //load model
        $this->load->model(array('tipe_properti_model','search_model','listing_model') );
    }

    function index($page_name = 'home', $transaksi = 'any', $lokasi = 'any',
                   $h_min = 'any',$h_max = 'any',$l_tanah = 'any',$kmrtidur = 'any')
    {
        $data['facebook_link'] = get_setting('facebook_link'); //$this->db->query("SELECT value FROM tbl_config WHERE item = 'facebook_link'")->row()->value;
        $data['page_name'] = $page_name;

        $data['m_jns_properti'] = $this->tipe_properti_model->get(0);
        $data['page_title'] = $page_name;
        $data['slideshow'] = $this->listing_model->slideshow();
        $data['count_based_tipe_property'] = $this->listing_model->get_count_based_tipe_properti();

        $data['arr_mostviewed'] = $this->listing_model->get_mostviewed_for_personal(10); //get most viewed listing

        $this->load->view('view_index',$data);
    }


    function penjualan(){
        $data['page_name'] = 'penjualan';
        $data['page_title'] = 'Penjualan';
        $this->load->view('view_index',$data);
    }


    //juni 25, 2013
    function search(){
        //lokasi,jual/sewa,tipe properti,jumlah kamar tidur,harga min, harga max
        $data = array();

        //pagination
        $url = base_url() . 'page/search/';
        $per_page = 10;


        $search_data = array();
        $id_lokasi = $this->input->post('lokasi_id');

        if($id_lokasi != 'any'){
            $search_data['id_lokasi'] = $id_lokasi;
        }

        $search_data['tipe_listing'] = $this->input->post('tipe_listing');
        $search_data['id_tipe_properti'] = $this->input->post('tipe_properti');

        $jml_kamar_tidur = $this->input->post('jml_kamar_tidur');
        if($jml_kamar_tidur != 'any'){
            $search_data['jml_kamar_tidur'] = $jml_kamar_tidur;
        }

        $harga_min = $this->input->post('harga_min');
        $harga_max = $this->input->post('harga_max');

        $harga_min = empty($harga_min) ? NULL : $harga_min;
        $harga_max = empty($harga_max) ? NULL : $harga_max;

        $res = $this->search_model->search($search_data,$harga_min,$harga_max)->num_rows();

        $config = $this->paginate($url,$res,$per_page,3);
        $this->pagination->initialize($config);

        $data['jumlah_pencarian'] = $res;
        $data['arr_pencarian'] = $this->search_model->search($search_data,$harga_min,$harga_max,$per_page,$this->uri->segment(3));

        $data['page_title'] = 'Search';
        $data['page_name'] = 'search';

        $this->load->view('view_index',$data);


    }

    //juni 25,2013
    function paginate ($base_url, $total_rows, $per_page, $uri_segment)
    {
        $config = array('base_url' => $base_url, 'total_rows' => $total_rows,
                'per_page' => $per_page, 'uri_segment' => $uri_segment);

        //$config['anchor_class'] = 'class="page radius"';

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

        $config['cur_tag_open'] = '<li class="active">';
        $config['cur_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

}

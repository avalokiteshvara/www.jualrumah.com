<?php


class Search extends CI_Controller
{
    public $default_order = 'tgl_buat DESC';
    //var $default_view = 'search';

    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        date_default_timezone_set('Asia/Jakarta');
        //load model
        $this->load->model(array('listing_model', 'tipe_properti_model', 'search_model'));

        //lets update premium properties
        $premium = $this->db->get_where('tbl_listing', array('jenis_iklan' => 'premium'));
        $now = new DateTime();
        $now->modify('-1 day');
        foreach ($premium->result_array() as $prem) {
            $premium_tgl_berakhir = new DateTime($prem['premium_tgl_berakhir']);
            if ($now > $premium_tgl_berakhir) {
                $this->db->where('id', $prem['id']);
                $this->db->update('tbl_listing', array('bukti_pembayaran_status' => 'none'));
            }
        }
    }

    public function lokasi()
    {
        header('content-type: application/json');

        $term = $this->input->get('term');

        $this->db->like('name', $term);
        $provinsi = $this->db->get('t_provinsi');

        $result = '';
        foreach ($provinsi->result_array() as $prov) {
            $result .= '{"lokasi_id":"'.$prov['id'].'|0|0","name":"'.$prov['name'].'"},';
        }

        $this->db->select("CONCAT(a.name,' , ',b.name) AS name,CONCAT(b.id,'|',a.id,'|0') AS lokasi_id", false);
        $this->db->like('a.name', $term);
        $this->db->join('t_provinsi b', 'a.provinsi_id = b.id', 'left');
        $kabupaten = $this->db->get('t_kabupaten a');

        foreach ($kabupaten->result_array() as $kab) {
            $result .= '{"lokasi_id":"'.$kab['lokasi_id'].'","name":"'.$kab['name'].'"},';
        }

        $this->db->select("CONCAT(a.name,' , ',b.name) AS name,CONCAT(c.id,'|',b.id,'|' , a.id) AS lokasi_id", false);
        $this->db->like('a.name', $term);
        $this->db->join('t_kabupaten b', 'a.kabupaten_id = b.id', 'left');
        $this->db->join('t_provinsi c', 'b.provinsi_id = c.id', 'left');
        $kecamatan = $this->db->get('t_kecamatan a');

        foreach ($kecamatan->result_array() as $kec) {
            $result .= '{"lokasi_id":"'.$kec['lokasi_id'].'","name":"'.$kec['name'].'"},';
        }

        $result = substr($result, 0, -1);

        echo '[' . $result . ']';
    }

    public function unset_search_session()
    {
        // $this->session->unset_userdata('src_id_lokasi');
        $this->session->unset_userdata('src_tipe_listing');
        $this->session->unset_userdata('src_id_tipe_properti');
        $this->session->unset_userdata('src_jml_kamar_tidur');
        $this->session->unset_userdata('src_harga_min');
        $this->session->unset_userdata('src_harga_max');
        $this->session->unset_userdata('src_has_sold');
        $this->session->unset_userdata('src_query');
        // $this->session->unset_userdata('src_view');
        $this->session->unset_userdata('src_order');
    }

    public function view($look_view = 'search')
    {
        $this->session->set_userdata('src_view', $look_view);
        $this->show();
    }

    public function sort($order)
    {
        $query = $this->session->userdata('src_query');

        //remove ORDER BY harga ASC
        //remove ORDER BY harga DESC


        // harga_asc = harga asc
        // harga_desc = harga desc
        // lihat_asc = total_dilihat asc
        // lihat_desc = total_dilihat desc


        $remove_order_by = array(
            '`',
            'ORDER BY a.'.$this->default_order,
            'ORDER BY a.satuan_sebenarnya ASC,a.'.$this->default_order,
            'ORDER BY a.satuan_sebenarnya DESC,a.'.$this->default_order,
            'ORDER BY a.total_dilihat ASC,a.'.$this->default_order,
            'ORDER BY a.total_dilihat DESC,a.'.$this->default_order, );

        $query = str_replace($remove_order_by, '', $query);

        $this->session->unset_userdata('src_query');
        $this->session->unset_userdata('src_order');

        $this->session->set_userdata('src_order', $order);

        switch ($order) {
            case 'harga_asc':
                $this->session->set_userdata('src_query', $query.' ORDER BY a.satuan_sebenarnya ASC,a.'.$this->default_order);
                break;
            case 'harga_desc':
                $this->session->set_userdata('src_query', $query.' ORDER BY a.satuan_sebenarnya DESC,a.'.$this->default_order);
                break;
            case 'lihat_asc':
                $this->session->set_userdata('src_query', $query.' ORDER BY a.total_dilihat ASC,a.'.$this->default_order);
                break;
            case 'lihat_desc':
                $this->session->set_userdata('src_query', $query.' ORDER BY a.total_dilihat DESC,a.'.$this->default_order);
                break;
            default:
                redirect(base_url(), 'refresh');
                break;
        }

        $this->show();
    }

    // public function location($id)
    // {
    //     $this->unset_search_session();
    //     $this->session->set_userdata('src_has_sold', 'N');
    //
    //     $src_query = 'SELECT a.*, '.
    //                  "       CONCAT_WS(' ', b.nama_depan, b.nama_belakang ) as nama_lengkap,".
    //                  '       b.telp, '.
    //                  "       IF(d.file_name IS NULL,'no_images.jpg',d.file_name) as file_name ".
    //                  'FROM tbl_listing a '.
    //                  'LEFT JOIN tbl_member b ON a.id_member = b.id ';
    //
    //     $arr_id = explode('|',$id);
    //     $provinsi = $arr_id[0];
    //     $kabupaten = $arr_id[1];
    //     $kecamatan = $arr_id[2];
    //
    //     $src_query .= 'LEFT JOIN t_provinsi c ON a.provinsi = c.id ' .
    //                   'LEFT JOIN t_kabupaten d ON a.kabupaten = d.id ' .
    //                   'LEFT JOIN t_kecamatan e ON a.kecamatan = e.id ' .
    //
    //     $src_query .= 'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) f ON a.id = f.listing_id '.
    //                   'WHERE a.provinsi = '.$provinsi .
    //                   "      AND a.kabupaten = " . $kabupaten .
    //                   "      AND a.kecamatan = " . $kecamatan .
    //                   "      AND a.has_sold = 'N' ".
    //                   "      AND a.is_verified='Y' ".
    //                   'GROUP BY a.id '.
    //                   'ORDER BY a.'.$this->default_order;
    //
    //     $this->session->set_userdata('src_query', $src_query);
    //
    //     $this->show();
    // }

    public function tipe($id)
    {
        $this->unset_search_session();
        $this->session->set_userdata('src_has_sold', 'N');
        $this->session->set_userdata('src_id_tipe_properti', $id);

        $this->session->set_userdata('src_query', 'SELECT a.*,'.
                                                 "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                                                 '       b.telp, '.
                                                 "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                                                 'FROM tbl_listing a '.
                                                 'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                                                 'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id '.
                                                 'WHERE a.id_tipe_properti ='.$id.
                                                 "      AND a.has_sold='N' ".
                                                 "      AND a.is_verified='Y' ".
                                                 'GROUP BY a.id '.
                                                 'ORDER BY a.'.$this->default_order);
        $this->show();
    }

    public function house_on_sale()
    {
        //delete all src_ session
        $this->unset_search_session();

        $this->session->set_userdata('src_id_tipe_properti', 2);
        $this->session->set_userdata('src_tipe_listing', 'jual');
        $this->session->set_userdata('src_has_sold', 'N');

        $src_query = 'SELECT a.*,'.
                     "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                     '       b.telp, '.
                     "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                     'FROM tbl_listing a '.
                     'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                     'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id ';

        $src_id_lokasi = $this->session->userdata('src_id_lokasi');
        if (!empty($src_id_lokasi)) {
            $id_lokasi = $this->session->userdata('src_id_lokasi');
            $lokasi = explode('|', $id_lokasi);

            $provinsi = $lokasi[0];
            $kabupaten = $lokasi[1];
            $kecamatan = $lokasi[2];

            $src_query .= 'LEFT JOIN t_provinsi d ON a.provinsi = d.id ';

            if ($kabupaten != 0) {
                $src_query .= 'LEFT JOIN t_kabupaten e ON a.kabupaten = e.id ';

                if ($kecamatan != 0) {
                    $src_query .= 'LEFT JOIN t_kecamatan f ON a.kecamatan = f.id ';
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                                '      AND a.kabupaten = '.$kabupaten.
                                '      AND a.kecamatan = '.$kecamatan.
                                "      AND a.tipe_listing='jual' ".
                                '      AND a.id_tipe_properti = 2 '.
                                "      AND a.has_sold='N' ".
                                "      AND a.is_verified='Y' ".
                                'GROUP BY a.id '.
                                'ORDER BY a.'.$this->default_order;
                } else {
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                              '      AND a.kabupaten = '.$kabupaten.
                              "      AND a.tipe_listing='jual' ".
                              '      AND a.id_tipe_properti = 2 '.
                              "      AND a.has_sold='N' ".
                              "      AND a.is_verified='Y' ".
                              'GROUP BY a.id '.
                              'ORDER BY a.'.$this->default_order;
                }
            } else {
                $src_query .=  'WHERE a.provinsi = '.$provinsi.
                          "      AND a.tipe_listing='jual' ".
                          '      AND a.id_tipe_properti = 2 '.
                          "      AND a.has_sold='N' ".
                          "      AND a.is_verified='Y' ".
                          'GROUP BY a.id '.
                          'ORDER BY a.'.$this->default_order;
            }
        } else {
            $src_query .=  "WHERE a.tipe_listing='jual' ".
                        '      AND a.id_tipe_properti = 2 '.
                        "      AND a.has_sold='N' ".
                        "      AND a.is_verified='Y' ".
                        'GROUP BY a.id '.
                        'ORDER BY a.'.$this->default_order;
        }

        $this->session->set_userdata('src_query', $src_query);
        $this->show();
    }

    public function house_on_rent()
    {
        //delete all src_ session
        $this->unset_search_session();

        $this->session->set_userdata('src_id_tipe_properti', 2);
        $this->session->set_userdata('src_tipe_listing', 'sewa');
        $this->session->set_userdata('src_has_sold', 'N');

        $src_query = 'SELECT a.*,'.
                     "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                     '       b.telp, '.
                     "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                     'FROM tbl_listing a '.
                     'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                     'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id ';

        $src_id_lokasi = $this->session->userdata('src_id_lokasi');
        if (!empty($src_id_lokasi)) {
            $id_lokasi = $this->session->userdata('src_id_lokasi');
            $lokasi = explode('|', $id_lokasi);

            $provinsi = $lokasi[0];
            $kabupaten = $lokasi[1];
            $kecamatan = $lokasi[2];

            $src_query .= 'LEFT JOIN t_provinsi d ON a.provinsi = d.id ';

            if ($kabupaten != 0) {
                $src_query .= 'LEFT JOIN t_kabupaten e ON a.kabupaten = e.id ';

                if ($kecamatan != 0) {
                    $src_query .= 'LEFT JOIN t_kecamatan f ON a.kecamatan = f.id ';
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                                '      AND a.kabupaten = '.$kabupaten.
                                '      AND a.kecamatan = '.$kecamatan.
                                "      AND a.tipe_listing='sewa' ".
                                '      AND a.id_tipe_properti = 2 '.
                                "      AND a.has_sold='N' ".
                                "      AND a.is_verified='Y' ".
                                'GROUP BY a.id '.
                                'ORDER BY a.'.$this->default_order;
                } else {
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                              '      AND a.kabupaten = '.$kabupaten.
                              "      AND a.tipe_listing='sewa' ".
                              '      AND a.id_tipe_properti = 2 '.
                              "      AND a.has_sold='N' ".
                              "      AND a.is_verified='Y' ".
                              'GROUP BY a.id '.
                              'ORDER BY a.'.$this->default_order;
                }
            } else {
                $src_query .=  'WHERE a.provinsi = '.$provinsi.
                          "      AND a.tipe_listing='sewa' ".
                          '      AND a.id_tipe_properti = 2 '.
                          "      AND a.has_sold='N' ".
                          "      AND a.is_verified='Y' ".
                          'GROUP BY a.id '.
                          'ORDER BY a.'.$this->default_order;
            }
        } else {
            $src_query .=  "WHERE a.tipe_listing='sewa' ".
                        '      AND a.id_tipe_properti = 2 '.
                        "      AND a.has_sold='N' ".
                        "      AND a.is_verified='Y' ".
                        'GROUP BY a.id '.
                        'ORDER BY a.'.$this->default_order;
        }

        $this->session->set_userdata('src_query', $src_query);
        $this->show();
    }

    public function new_house()
    {
        //delete all src_ session
        $this->unset_search_session();
        $this->session->set_userdata('src_id_tipe_properti', 2);

        $src_query = 'SELECT a.*,'.
                     "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                     '       b.telp, '.
                     "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                     'FROM tbl_listing a '.
                     'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                     'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id ';

        $src_id_lokasi = $this->session->userdata('src_id_lokasi');
        if (!empty($src_id_lokasi)) {
            $id_lokasi = $this->session->userdata('src_id_lokasi');
            $lokasi = explode('|', $id_lokasi);

            $provinsi = $lokasi[0];
            $kabupaten = $lokasi[1];
            $kecamatan = $lokasi[2];

            $src_query .= 'LEFT JOIN t_provinsi d ON a.provinsi = d.id ';

            if ($kabupaten != 0) {
                $src_query .= 'LEFT JOIN t_kabupaten e ON a.kabupaten = e.id ';

                if ($kecamatan != 0) {
                    $src_query .= 'LEFT JOIN t_kecamatan f ON a.kecamatan = f.id ';
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                                 '      AND a.kabupaten = '.$kabupaten.
                                 '      AND a.kecamatan = '.$kecamatan.
                                 '      AND a.id_tipe_properti = 2 '.
                                 "      AND a.new_house='Y' ".
                                 "      AND a.has_sold='N' ".
                                 "      AND a.is_verified='Y' ".
                                 'GROUP BY a.id '.
                                 'ORDER BY a.'.$this->default_order;
                } else {
                    $src_query .=  'WHERE a.provinsi = '.$provinsi.
                               '      AND a.kabupaten = '.$kabupaten.
                               '      AND a.id_tipe_properti = 2 '.
                               "      AND a.new_house='Y' ".
                               "      AND a.has_sold='N' ".
                               "      AND a.is_verified='Y' ".
                               'GROUP BY a.id '.
                               'ORDER BY a.'.$this->default_order;
                }
            } else {
                $src_query .=  'WHERE a.provinsi = '.$provinsi.
                           '      AND a.id_tipe_properti = 2 '.
                           "      AND a.new_house='Y' ".
                           "      AND a.has_sold='N' ".
                           "      AND a.is_verified='Y' ".
                           'GROUP BY a.id '.
                           'ORDER BY a.'.$this->default_order;
            }
        } else {
            $src_query .=  'WHERE a.id_tipe_properti = 2 '.
                         "      AND a.new_house='Y' ".
                         "      AND a.has_sold='N' ".
                         "      AND a.is_verified='Y' ".
                         'GROUP BY a.id '.
                         'ORDER BY a.'.$this->default_order;
        }

        $this->session->set_userdata('src_query', $src_query);
        $this->show();
    }

    public function preowned_house()
    {
        $this->unset_search_session();
        $this->session->set_userdata('src_id_tipe_properti', 2);

        $this->session->set_userdata('src_query', 'SELECT a.*,'.
                                                 "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                                                 '       b.telp, '.
                                                 "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                                                 'FROM tbl_listing a '.
                                                 'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                                                 'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id '.
                                                 'WHERE a.id_tipe_properti = 2 '.
                                                 "      AND a.new_house='N'".
                                                 "      AND a.has_sold='N' ".
                                                 "      AND a.is_verified='Y' ".
                                                 'GROUP BY a.id '.
                                                 'ORDER BY a.'.$this->default_order);
        $this->show();
    }

    public function index()
    {
        $this->unset_search_session();

        $this->session->set_userdata('src_query', 'SELECT a.*,'.
                                                 "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama_lengkap, ".
                                                 '       b.telp, '.
                                                 "       IF(c.file_name IS NULL,'no_images.jpg',c.file_name) as file_name ".
                                                 'FROM tbl_listing a '.
                                                 'LEFT JOIN tbl_member b ON a.id_member = b.id '.
                                                 'LEFT JOIN (SELECT file_name,listing_id FROM tbl_images) c ON a.id = c.listing_id '.
                                                 "WHERE a.has_sold='N' ".
                                                 "      AND a.is_verified='Y' ".
                                                 'GROUP BY a.id '.
                                                 'ORDER BY a.'.$this->default_order);
        $this->show();
    }

    public function show()
    {
        $data = array();
        $url = base_url().'search/show/';
        $src_view = $this->session->userdata('src_view');

        if (!isset($src_view)) {
            $per_page = 10;
        } else {
            $per_page = 16;
        }

        $data['count_based_tipe_property'] = $this->listing_model->get_count_based_tipe_properti();

        $this->db->select("a.id,a.judul_listing,CONCAT(a.harga,' ',a.satuan_harga) AS harga,
                           CONCAT(d.name,' ', c.name) AS lokasi, IFNULL(e.file_name,'no_images.jpg') AS file_name",FALSE);
        $this->db->join('t_provinsi b','a.provinsi = b.id','left');
        $this->db->join('t_kabupaten c','a.kabupaten = c.id','left');
        $this->db->join('t_kecamatan d','a.kecamatan = d.id','left');
        $this->db->join('(SELECT listing_id,IFNULL(file_name,"no_images.jpg") AS file_name FROM tbl_images GROUP BY listing_id) e','a.id = e.listing_id','left');

        $this->db->order_by('rand()');
        // $this->db->limit(4);
        $data['random_premium'] = $this->db->get_where('tbl_listing a',array('jenis_iklan' => 'premium'));

        $data['facebook_link'] = get_setting('facebook_link');//$this->db->query("SELECT value FROM tbl_config WHERE item = 'facebook_link'")->row()->value;

        if (!empty($_POST)) {
            //jika form pencarian submit, maka
            //delete all src_ session
            $this->unset_search_session();
            //array search_data untuk menampung var pencarian
            $search_data = array();
            // $search_data['view'] = $this->session->userdata('src_view');

            $id_lokasi = $this->input->post('lokasi_id');
            $nama_lokasi = $this->input->post('lokasi');
            //provinsi|kabupaten|kecamatan
            $lokasi = explode('|', $id_lokasi);

            $provinsi = $lokasi[0];
            $kabupaten = $lokasi[1];
            $kecamatan = $lokasi[2];

            $search_data['provinsi'] = $provinsi;

            if ($kabupaten != 0) {
                $search_data['kabupaten'] = $kabupaten;
            }

            if ($kecamatan != 0) {
                $search_data['kecamatan'] = $kecamatan;
            }

            $this->session->set_userdata('src_id_lokasi', $id_lokasi);
            $this->session->set_userdata('src_nama_lokasi', $nama_lokasi);

            //var tipe_listing
            $tipe_listing = $this->input->post('tipe_listing');
            if ($tipe_listing != 'any') {
                $search_data['tipe_listing'] = $tipe_listing;
                $this->session->set_userdata('src_tipe_listing', $tipe_listing);
            }

            //var id_tipe_properti
            $id_tipe_properti = $this->input->post('tipe_properti');
            if ($id_tipe_properti != 'any') {
                $search_data['id_tipe_properti'] = $id_tipe_properti;
                $this->session->set_userdata('src_id_tipe_properti', $id_tipe_properti);
            }

            //var jml_kamar_tidur
            $jml_kamar_tidur = $this->input->post('jml_kamar_tidur');
            if ($jml_kamar_tidur != 'any') {
                $search_data['jml_kamar_tidur'] = $jml_kamar_tidur;
                $this->session->set_userdata('src_jml_kamar_tidur', $jml_kamar_tidur);
            }

            $has_sold = $this->input->post('has_sold');
            if ($has_sold != 'any') {
                $search_data['has_sold'] = $has_sold;
                $this->session->set_userdata('src_has_sold', $has_sold);
            }

            $harga_min = $this->input->post('harga_min');
            $harga_max = $this->input->post('harga_max');

            $this->session->set_userdata('src_harga_min', $harga_min);
            $this->session->set_userdata('src_harga_max', $harga_max);

            $harga_min = empty($harga_min) ? null : $harga_min;
            $harga_max = empty($harga_max) ? null : $harga_max;

            $data['harga_min'] = $harga_min;
            $data['harga_max'] = $harga_max;

            $res = $this->search_model->search($search_data, $harga_min, $harga_max)->num_rows();
            $data['jumlah_pencarian'] = $res;

            $last_query = $this->db->last_query();
            $data['last_query'] = $last_query;
            $this->session->set_userdata('src_query', $last_query);

            $config = $this->paginate($url, $res, $per_page, 3);
            $this->pagination->initialize($config);

            $data['search_data'] = $search_data;
            $data['arr_pencarian'] = $this->search_model->search($search_data, $harga_min, $harga_max, $per_page, $this->uri->segment(3));
        } else {

            //array search_data untuk menampung var pencarian
            $search_data = array();

            // $id_lokasi = $this->session->userdata('src_id_lokasi');
            //
            // // echo $id_lokasi;
            // // exit(0);
            //
            // $lokasi = explode('|',$id_lokasi);
            //
            // $provinsi = $lokasi[0];
            // $kabupaten = $lokasi[1];
            // $kecamatan = $lokasi[2];
            //
            // $search_data['provinsi'] = $provinsi;
            //
            // if($kabupaten != 0){
            //   $search_data['kabupaten'] = $kabupaten;
            // }
            //
            // if($kecamatan != 0){
            //   $search_data['kecamatan'] = $kecamatan;
            // }


            $search_data['tipe_listing'] = $this->session->userdata('src_tipe_listing');
            $search_data['id_tipe_properti'] = $this->session->userdata('src_id_tipe_properti');
            $search_data['jml_kamar_tidur'] = $this->session->userdata('src_jml_kamar_tidur');
            $search_data['has_sold'] = $this->session->userdata('src_has_sold');
            $search_data['order'] = $this->session->userdata('src_order');
            $search_data['view'] = $this->session->userdata('src_view');

            $data['harga_min'] = $this->session->userdata('src_harga_min');
            $data['harga_max'] = $this->session->userdata('src_harga_max');

            $res = $this->db->query($this->session->userdata('src_query'))->num_rows();
            $data['jumlah_pencarian'] = $res;

            $segment_to_use = (
                ($this->uri->segment(3) == 'search') or
                ($this->uri->segment(3) == 'small_search') or
                ($this->uri->segment(3) == 'harga_asc') or
                ($this->uri->segment(3) == 'harga_desc') or
                ($this->uri->segment(3) == 'lihat_asc') or
                ($this->uri->segment(3) == 'lihat_desc') or
                ($this->uri->segment(2) == 'location') or
                ($this->uri->segment(2) == 'tipe')) ? 4 : 3;

            $config = $this->paginate($url, $res, $per_page, $segment_to_use);
            $this->pagination->initialize($config);

            $data['search_data'] = $search_data;

            $offset = ($this->uri->segment($segment_to_use) == false) ? 0 : $this->uri->segment($segment_to_use);

            $data['arr_pencarian'] = $this->db->query($this->session->userdata('src_query').' LIMIT '.$offset.','.$per_page);
            $last_query = $this->db->last_query();
            $data['last_query'] = $last_query;
        }

        $data['m_jns_properti'] = $this->tipe_properti_model->get(0);
        $data['page_title'] = 'Search';

        if (empty($src_view)) {
            $data['page_name'] = 'search';
        } else {
            $data['page_name'] = $this->session->userdata('src_view');
        }

        $this->load->view('view_index', $data);
    }

    //juni 25,2013
    public function paginate($base_url, $total_rows, $per_page, $uri_segment)
    {
        $config = array('base_url' => $base_url, 'total_rows' => $total_rows,
                'per_page' => $per_page, 'uri_segment' => $uri_segment, );

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

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }
}

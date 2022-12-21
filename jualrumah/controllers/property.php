<?php

class Property extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        //load model
        $this->load->model(
            array('tipe_properti_model', 'jenis_sertifikat_model',
                  'pasokan_listrik_model', 'images_model',
                  'listing_model', 'member_model',
                  'comments_model', )
            );

        date_default_timezone_set('Asia/Jakarta');
    }

    function percentage($percentage,$value){
      return ($percentage / 100) * $value;
    }

    function get_near_properties($tipe_listing,$lat,$lng,$distance,$harga){
      $CONST_MAX = 20;
      $CONST_MIN = 20;

      $harga_reduce_min = $harga - $this->percentage($harga,$CONST_MIN);
      $harga_plus_max   = $harga + $this->percentage($harga,$CONST_MAX);


      $sql = "SELECT a.id,a.judul_listing,CONCAT(a.harga,' ',a.satuan_harga) AS harga,
                     a.lat,a.lng,
                     b.name AS provinsi,
                     c.name AS kabupaten,
                     d.name AS kecamatan,
                     CONCAT(d.name,' , ', c.name) AS lokasi,
                     ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS jarak,
                     a.satuan_sebenarnya AS harga_sebenarnya,
                     a.tipe_listing
               FROM tbl_listing a

               LEFT JOIN t_provinsi b ON a.provinsi = b.id
               LEFT JOIN t_kabupaten c ON a.kabupaten = c.id
               LEFT JOIN t_kecamatan d ON a.kecamatan = d.id

               WHERE a.tipe_listing = '$tipe_listing'
               HAVING (jarak BETWEEN 0.1 AND $distance)
                      AND (harga_sebenarnya BETWEEN $harga_reduce_min AND $harga_plus_max)
               ORDER BY jarak
               LIMIT 0 , 5";
      return $this->db->query($sql);
    }


    // Function to get the client ip address
    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function show($listing_id = null)
    {
        $data['facebook_link'] = get_setting('facebook_link');//$this->db->query("SELECT value FROM tbl_config WHERE item = 'facebook_link'")->row()->value;

        //jika null atau $listing_id tidak ditemukan,maka redirect ke home
        if (($listing_id == null)) {
            redirect(base_url(), 'refresh');
        }

        $query = $this->db->get_where('tbl_listing', array('id' => $listing_id));
        if ($query->num_rows() == 0) {
            redirect(base_url(), 'refresh');
        }

        //cek apakah user sudah pernah lihat listing ini pada hari ini ?
        $myIp = $this->get_client_ip();
        $current_date = date('Y-m-d');

        $query = $this->db->query(
            'SELECT * FROM tbl_viewed '.
            "WHERE ip='".$myIp."' AND listing_id=".$listing_id." AND viewed_at='".$current_date."'");

        //jika belum maka,..
        if ($query->num_rows() == 0) {
            //tambahkan record ke tbl_viewed
            $viewed = array(
                'ip' => $myIp,
                'listing_id' => $listing_id,
                'viewed_at' => $current_date,
                );
            $this->db->insert('tbl_viewed', $viewed);
            //update viewed
            $this->listing_model->update_viewed($listing_id);
        }

        $data['active_tab'] = ($this->uri->segment(4) == false) ? 'descriptions' : 'comments';

        //pagination coments
        $url = base_url().'property/show/'.$listing_id;
        $per_page = 5;
        $res = $this->db->query('SELECT COUNT(*) as cnt FROM tbl_comments WHERE id_listing='.$listing_id)->row()->cnt;
        $config = $this->paginate($url, $res, $per_page, 4);
        $this->pagination->initialize($config);

        //lets generate some captcha image
        $cap = $this->generate_captcha();
        $data['captcha_image'] = $cap;

        $data['comments'] = $this->comments_model->retrieve_comments($listing_id, $per_page, $this->uri->segment(4));

        $data['listing_id'] = $listing_id;
        $data['comments_count'] = $res;
        $data['image_list'] = $this->images_model->get($listing_id, false);
        $data['property_data'] = $this->listing_model->get($listing_id)->row();

        $this->db->select("CONCAT(c.name , ' , ', b.name) AS lokasi",FALSE);
        $this->db->join('t_kabupaten b', 'a.id = b.provinsi_id','left');
        $this->db->join('t_kecamatan c','b.id = c.kabupaten_id','left');
        $this->db->where('a.id',$data['property_data']->provinsi);
        $this->db->where('b.id',$data['property_data']->kabupaten);
        $this->db->where('c.id',$data['property_data']->kecamatan);

        $data['lokasi_listing'] = $this->db->get('t_provinsi a')->row()->lokasi;

        if($data['property_data']->lat != null){
          // exit(0);
          $data['get_near_properties'] = $this->get_near_properties($data['property_data']->tipe_listing,$data['property_data']->lat,$data['property_data']->lng,2,$data['property_data']->satuan_sebenarnya);
        }

        $data['pengiklan_data'] = $this->member_model->retrieve_profile($data['property_data']->id_member);
        $data['page_title'] = 'property';
        $data['page_name'] = 'property';

        $this->load->view('view_index', $data);
    }

    public function generate_captcha($cmd = null)
    {
        $this->load->helper('captcha');
        $this->session->unset_userdata('captcha_world');
        $captcha_vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url().'captcha/' ,
            'font_path' => base_url().'./captcha/font/BRUSHSCI.TTF',
            'img_width' => 100,
            'img_height' => 30,
            'expiration' => 1800,
            );

        $cap = create_captcha($captcha_vals);
        $this->session->set_userdata('captcha_world', $cap['word']);

        if ($cmd == 'ajax') {
            echo $cap['image'];
        } else {
            return $cap['image'];
        }
    }

    public function insert_comment($listing_id)
    {
        $this->form_validation->set_rules('comment', 'Comment', 'required');
        $this->form_validation->set_rules('captcha', 'Captcha', 'required');

        $comment = $this->input->post('comment');
        $captcha = $this->input->post('captcha');

        if ($this->form_validation->run() and
        strcmp(strtoupper($this->session->userdata('captcha_world')), strtoupper($captcha)) == 0) {
            $comment = array(
                'id_listing' => $listing_id,
                'id_member' => $this->session->userdata('user_id'),
                'comment' => $comment,
                );

            echo $this->comments_model->insert_comment($comment);
        } else {
            echo '#error(captcha invalid atau comment kosong!)';
        }
    }

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

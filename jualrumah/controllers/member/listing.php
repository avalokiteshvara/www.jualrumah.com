<?php

class Listing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('listing_model', 'tipe_properti_model',
                                 'jenis_sertifikat_model', 'images_model',
                                 'pasokan_listrik_model', ));

        if ($this->session->userdata('sudah_login') == 0) {
            redirect(base_url().'member/login', 'refresh');
        }
    }

    public function show()
    {
        $url = base_url().'member/listing/show/';
        $per_page = 10;
        $res = $this->db->query('SELECT COUNT(a.id) AS cnt '.
                                'FROM tbl_listing a '.
                                'WHERE id_member='.$this->session->userdata('user_id'))->row()->cnt;

        $config = $this->paginate($url, $res, $per_page, 4);
        $this->pagination->initialize($config);

        $page['listing'] = $this->listing_model->get_mylisting($per_page, $this->uri->segment(4));
        $page['page_name'] = 'member/listing/list';
        $page['page_title'] = 'Halaman Listing';
        $this->load->view('view_index', $page);
    }

    public function index()
    {
        $this->show();
    }

    public function sold($id)
    {
        $data['has_sold'] = 'Y';
        $data['tgl_terjual'] = $date = date('Y-m-d H:i:s');
        $this->listing_model->update($id, $data);
        echo 'OK';
    }

    public function delete($listing_id)
    {
        $this->listing_model->delete($listing_id);
        echo 'OK';
    }

    public function kabupaten_ajax($provinsi_id)
    {
        $this->db->where('provinsi_id', $provinsi_id);
        $this->db->order_by('name ASC');
        $kabupaten = $this->db->get('t_kabupaten');

        $result = "<option value=''>Pilih kabupaten</option>";
        foreach ($kabupaten->result_array() as $kab) {
            $result .= "<option value='".$kab['id']."'>".$kab['name'].'</option>';
        }

        echo $result;
    }

    public function kecamatan_ajax($kabupaten_id)
    {
        $this->db->where('kabupaten_id', $kabupaten_id);
        $this->db->order_by('name ASC');
        $kecamatan = $this->db->get('t_kecamatan');

        $result = "<option value=''>Pilih kecamatan</option>";
        foreach ($kecamatan->result_array() as $kec) {
            $result .= "<option value='".$kec['id']."'>".$kec['name'].'</option>';
        }

        echo $result;
    }

    public function send_notif_to_admin($listing_id){


      date_default_timezone_set('Etc/UTC');

      $this->load->library('My_PHPMailer');

      $this->db->select("a.id,a.tgl_buat,a.tipe_listing,
                         b.nama AS jenis_properti,a.judul_listing,
                         CONCAT(e.name,', ',d.name,', ',c.name) AS lokasi",false);
      $this->db->join('tbl_tipe_properti b','a.id_tipe_properti = b.id','left');
      $this->db->join('t_provinsi c','a.provinsi = c.id','left');
      $this->db->join('t_kabupaten d','a.kabupaten = d.id','left');
      $this->db->join('t_kecamatan e','a.kecamatan = e.id','left');

      $data['listing'] = $this->db->get_where('tbl_listing a',array('a.id' => $listing_id))->row_array();

      $this->load->library('My_PHPMailer');

      $mail = new PHPMailer();

      // $mail->SMTPDebug = 3;

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;

      //feedback.kodeaplikasi@gmail.com : f#$3*86#$aa^gy$3be

      $mail->Username = 'jualrumahbwi001@gmail.com';
      $mail->Password = 'triasfahrudin001';
      $mail->setFrom('jualrumahbwi001@gmail.com', 'jualrumahbwi001@gmail.com');
      $mail->addReplyTo('jualrumahbwi001@gmail.com', 'jualrumahbwi001@gmail.com');
      $mail->addAddress('fitny.taurus@gmail.com', preg_replace('/@.*?$/', '', 'fitny.taurus@gmail.com'));
      $mail->Subject = 'Notifikasi Properti Baru';
      $mail->msgHTML($this->load->view('email_template_admin_notif',$data,true));

      if (!$mail->send()) {
        //return false;
        //echo 'Message could not be sent.';
        echo 'Mailer Error: <pre>' . $mail->ErrorInfo . '</pre>';
        //exit(0);
      }else{

        //echo 'OK';
      }

      /*
      $mail = new PHPMailer();



      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;
      $mail->Username = "seminar.mpipa.unja@gmail.com";
      $mail->Password = "0EWzNQhcrixo";
      $mail->setFrom('seminar.mpipa.unja@gmail.com', 'www.jualrumah.com');
      $mail->addReplyTo('seminar.mpipa.unja@gmail.com', 'www.jualrumah.com');
      $mail->addAddress(get_setting('admin_email'), 'Admin');
      $mail->Subject = 'Notifikasi Properti Baru';
      $mail->msgHTML($this->load->view('email_template_admin_notif',$data,true));

      // $this->load->view('email_template_admin_notif',$data);
      // $mail->msgHTML("test");
      if(!$mail->send()) {
        // echo $mail->ErrorInfo;
      }else{
        // echo "OK";
      }
      */

      // $this->load->library('My_PHPMailer');
      //
      // $mail = new PHPMailer();
      //
      // // $mail->SMTPDebug = 3;
      //
      // $mail->isSMTP();
      // $mail->Host = 'smtp.gmail.com';
      // $mail->Port = 587;
      // $mail->SMTPSecure = 'tls';
      // $mail->SMTPAuth = true;
      //
      // //feedback.kodeaplikasi@gmail.com : f#$3*86#$aa^gy$3be
      //
      // $mail->Username = 'jualrumahbwi001@gmail.com';
      // $mail->Password = 'triasfahrudin001';
      // $mail->setFrom('jualrumahbwi001@gmail.com', 'jualrumahbwi001@gmail.com');
      // $mail->addReplyTo('jualrumahbwi001@gmail.com', 'jualrumahbwi001@gmail.com');
      // $mail->addAddress(get_setting('admin_email'), preg_replace('/@.*?$/', '', 'admin jualrumah.com'));
      // $mail->Subject = 'Verifikasi kode listing property @jualrumah.com';
      // $mail->msgHTML($this->load->view('email_template_admin_notif',$data,true));
      //
      // if (!$mail->send()) {
      //   //return false;
      //   //echo 'Message could not be sent.';
      //   echo 'Mailer Error: <pre>' . $mail->ErrorInfo . '</pre>';
      //   //exit(0);
      // }else{
      //   echo 'OK';
      // }
    }

    public function add_basic($mode = null)
    {
        $data = array();

        if ($mode == 'submit') {
            $this->form_validation->set_rules('tipe_listing', 'Tipe Listing', 'xss_clean|required');
            $this->form_validation->set_rules('id_tipe_properti', 'Tipe Properti', 'xss_clean|required');
            $this->form_validation->set_rules('new_house', 'Status', 'xss_clean|required');

            $this->form_validation->set_rules('judul_listing', 'Judul Listing', 'xss_clean|required');
            $this->form_validation->set_rules('deskripsi_listing', 'Deskripsi Listing', 'xss_clean|required');

            // $this->form_validation->set_rules('id_lokasi', 'Lokasi', 'xss_clean|required');
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'xss_clean|required');
            $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'xss_clean|required');
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'xss_clean|required');

            $this->form_validation->set_rules('alamat_lengkap', 'Alamat Lengkap', 'xss_clean|required');

            $this->form_validation->set_rules('tipe_harga', 'Tipe Harga', 'xss_clean');
            $this->form_validation->set_rules('harga', 'Harga', 'xss_clean|numeric');
            $this->form_validation->set_rules('id_jns_sertifikat', 'Jenis Sertifikat', 'xss_clean');

            $this->form_validation->set_rules('luas_bangunan', 'Luas Bangunan', 'xss_clean');
            $this->form_validation->set_rules('dimensi_bangunan_a', 'dimensi bangunan', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_bangunan_b', 'dimensi bangunan', 'trim|xss_clean');

            $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'xss_clean');
            $this->form_validation->set_rules('dimensi_tanah_a', 'dimensi tanah', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_tanah_b', 'dimensi tanah', 'trim|xss_clean');

            //user_id
            $data['id_member'] = $this->session->userdata('user_id');
            $data['tgl_buat'] = $date = date('Y-m-d H:i:s');

            //required
            $data['tipe_listing'] = $this->input->post('tipe_listing');
            $data['id_tipe_properti'] = $this->input->post('id_tipe_properti');
            $data['new_house'] = $this->input->post('new_house');
            $data['judul_listing'] = $this->input->post('judul_listing');
            $data['deskripsi_listing'] = $this->input->post('deskripsi_listing');

            // $data['id_lokasi'] = $this->input->post('id_lokasi');
            $data['provinsi'] = $this->input->post('provinsi');
            $data['kabupaten'] = $this->input->post('kabupaten');
            $data['kecamatan'] = $this->input->post('kecamatan');

            $data['alamat_lengkap'] = $this->input->post('alamat_lengkap');

            //not required
            $data['tipe_harga'] = $this->input->post('tipe_harga');
            $data['harga'] = $this->input->post('harga');

            switch ($this->input->post('satuan_harga')) {
                case 'ribu':
                    $data['satuan_sebenarnya'] = $data['harga'];
                    break;

                case 'juta':
                    $data['satuan_sebenarnya'] = $data['harga'] * 1000000;
                    break;

                case 'milyar':
                    $data['satuan_sebenarnya'] = $data['harga'] * 1000000000;
                    break;
            }

            $data['id_jns_sertifikat'] = $this->input->post('id_jns_sertifikat');
            $data['satuan_harga'] = $this->input->post('satuan_harga');

            //luas dan dimensi
            $data['luas_bangunan'] = $this->input->post('luas_bangunan');
            $data['dimensi_bangunan'] = $this->input->post('dimensi_bangunan_a').'x'.$this->input->post('dimensi_bangunan_b');

            $data['luas_tanah'] = $this->input->post('luas_tanah');
            $data['dimensi_tanah'] = $this->input->post('dimensi_tanah_a').'x'.$this->input->post('dimensi_tanah_b');

            $data['lat'] = $this->input->post('lat');
            $data['lng'] = $this->input->post('lng');

            if ($this->form_validation->run() == true) {
                $config['upload_path'] = './uploads/pembayaran/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('bukti_pembayaran')) {

                } else {
                    $success = $this->upload->data();
                    $data['bukti_pembayaran'] = $success['file_name'];
                    $data['bukti_pembayaran_status'] = 'pending';
                }

                $this->listing_model->insert($data);

                $listing_id = $this->listing_model->get_max_id();

                @$this->send_notif_to_admin($listing_id);

                //tambahkan email pemberitahuan ke admin

                // $admin_email = $this->db->query("SELECT email FROM tbl_admin WHERE superadmin='Y'")->row()->email;
                // $config = email_conf();
                //
                //
                // $this->load->library('email', $config);
                // $this->email->set_newline("\r\n");
                // $this->email->from('admin@jualrumah.com', 'admin@jualrumah.com');
                // $this->email->to($admin_email);
                // $this->email->subject('Pemberitahuan Listing Baru (ID: '.$listing_id.')');
                //
                // $data_email['nama_member'] = $this->session->userdata('nama_depan').$this->session->userdata('nama_belakang');
                // $data_email['judul_listing'] = $this->input->post('judul_listing');
                // $data_email['listing_id'] = $listing_id;
                //
                // $this->email->message($this->load->view('admin/emailnewlisting', $data_email, true));
                //
                // @$this->email->send();

                redirect(base_url().'member/listing/additional_info/'.$listing_id.'/show_form/go_next', 'refresh');
            }
        }

        $page['data'] = $data;

        $page['m_jns_properti'] = $this->tipe_properti_model->get(0);
        $page['m_jns_sertifikat'] = $this->jenis_sertifikat_model->get();

        $page['status'] = 'new';
        $page['page_name'] = 'member/listing/basic';
        $page['page_title'] = 'Halaman Listing';
        $this->load->view('view_index', $page);
    }

    public function edit_basic($listing_id, $mode = null)
    {
        if ($mode == 'submit') {
            $this->form_validation->set_rules('tipe_listing', 'Tipe Listing', 'xss_clean|required');
            $this->form_validation->set_rules('id_tipe_properti', 'Tipe Properti', 'xss_clean|required');
            $this->form_validation->set_rules('new_house', 'Status', 'xss_clean|required');

            $this->form_validation->set_rules('judul_listing', 'Judul Listing', 'trim|xss_clean|required');
            $this->form_validation->set_rules('deskripsi_listing', 'Deskripsi Listing', 'trim|xss_clean|required');

            // $this->form_validation->set_rules('id_lokasi', 'Lokasi', 'xss_clean|required');
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'xss_clean|required');
            $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'xss_clean|required');
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'xss_clean|required');

            $this->form_validation->set_rules('alamat_lengkap', 'Alamat Lengkap', 'trim|xss_clean|required');

            $this->form_validation->set_rules('tipe_harga', 'Tipe Harga', 'xss_clean');
            $this->form_validation->set_rules('harga', 'Harga', 'trim|xss_clean|numeric|required');
            $this->form_validation->set_rules('id_jns_sertifikat', 'Jenis Sertifikat', 'xss_clean');

            $this->form_validation->set_rules('luas_bangunan', 'Luas Bangunan', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_bangunan_a', 'dimensi bangunan', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_bangunan_b', 'dimensi bangunan', 'trim|xss_clean');

            $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_tanah_a', 'dimensi tanah', 'trim|xss_clean');
            $this->form_validation->set_rules('dimensi_tanah_b', 'dimensi tanah', 'trim|xss_clean');

            //required
            $data['tipe_listing'] = $this->input->post('tipe_listing');
            $data['id_tipe_properti'] = $this->input->post('id_tipe_properti');
            $data['new_house'] = $this->input->post('new_house');

            $data['deskripsi_listing'] = $this->input->post('deskripsi_listing');
            // $data['id_lokasi'] = $this->input->post('id_lokasi');

            $data['provinsi'] = $this->input->post('provinsi');
            $data['kabupaten'] = $this->input->post('kabupaten');
            $data['kecamatan'] = $this->input->post('kecamatan');

            $data['alamat_lengkap'] = $this->input->post('alamat_lengkap');

            //not required
            $data['tipe_harga'] = $this->input->post('tipe_harga');
            $data['harga'] = $this->input->post('harga');

            switch ($this->input->post('satuan_harga')) {
                case 'ribu':
                    $data['satuan_sebenarnya'] = $data['harga'];
                    break;

                case 'juta':
                    $data['satuan_sebenarnya'] = $data['harga'] * 1000000;
                    break;

                case 'milyar':
                    $data['satuan_sebenarnya'] = $data['harga'] * 1000000000;
                    break;
            }

            $data['id_jns_sertifikat'] = $this->input->post('id_jns_sertifikat');
            $data['satuan_harga'] = $this->input->post('satuan_harga');

            //luas dan dimensi
            $data['luas_bangunan'] = $this->input->post('luas_bangunan');
            $data['dimensi_bangunan'] = $this->input->post('dimensi_bangunan_a').'x'.$this->input->post('dimensi_bangunan_b');

            $data['luas_tanah'] = $this->input->post('luas_tanah');
            $data['dimensi_tanah'] = $this->input->post('dimensi_tanah_a').'x'.$this->input->post('dimensi_tanah_b');

            $data['lat'] = $this->input->post('lat');
            $data['lng'] = $this->input->post('lng');

            if ($this->form_validation->run() == true) {
                //judul tidak boleh di edit, karena itu tidak diupdate
                $config['upload_path'] = './uploads/pembayaran/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['encrypt_name'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('bukti_pembayaran')) {

                } else {
                    $success = $this->upload->data();
                    $data['bukti_pembayaran'] = $success['file_name'];
                    $data['bukti_pembayaran_status'] = 'pending';
                }


                $this->listing_model->update($listing_id, $data);
                redirect(base_url().'member/listing/', 'refresh');
            } else {
                $data['judul_listing'] = $this->input->post('judul_listing');
                $page['data'] = $data;
            }
        }

        $page['data'] = $this->listing_model->get_edit_listing($listing_id)->row_array();

        $page['m_jns_properti'] = $this->tipe_properti_model->get(0);
        $page['m_jns_sertifikat'] = $this->jenis_sertifikat_model->get();

        $page['status'] = 'edit';
        $page['listing_id'] = $listing_id;
        $page['page_name'] = 'member/listing/basic';
        $page['page_title'] = 'Halaman Listing';
        $this->load->view('view_index', $page);
    }

    public function additional_info($listing_id, $mode = null, $status = 'go_next')
    {
        $data = array();

        if ($mode == 'show_edit') {
            //lets me get the data for you..
            $arr_basic_info = $this->listing_model->get_edit_additional_info($listing_id)->row();

            $data['jml_kamar_tidur'] = $arr_basic_info->jml_kamar_tidur;
            $data['jml_kamar_pembantu'] = $arr_basic_info->jml_kamar_pembantu;
            $data['jml_kamar_mandi'] = $arr_basic_info->jml_kamar_mandi;
            $data['jml_garasi'] = $arr_basic_info->jml_garasi;
            $data['jml_carport'] = $arr_basic_info->jml_carport;
            $data['jml_saluran_telp'] = $arr_basic_info->jml_saluran_telp;
            $data['jml_lantai'] = $arr_basic_info->jml_lantai;
            $data['kondisi'] = $arr_basic_info->kondisi;
            $data['pasokan_listrik'] = $arr_basic_info->pasokan_listrik;
            $data['menghadap'] = $arr_basic_info->menghadap;
        } elseif ($mode == 'submit') {
            $this->form_validation->set_rules('jml_kamar_tidur', 'Jumlah Kamar Tidur', 'xss_clean|required');
            $this->form_validation->set_rules('jml_kamar_pembantu', 'Jumlah Kamar Pembantu', 'xss_clean');
            $this->form_validation->set_rules('jml_kamar_mandi', 'Jumlah Kamar Mandi', 'xss_clean');
            $this->form_validation->set_rules('jml_garasi', 'Kapasitas Garasi', 'xss_clean');
            $this->form_validation->set_rules('jml_carport', 'Kapasitas Parkir', 'xss_clean');
            $this->form_validation->set_rules('jml_saluran_telp', 'Jumlah Saluran Telp', 'xss_clean');
            $this->form_validation->set_rules('jml_lantai', 'Jumlah Lantai', 'xss_clean');
            $this->form_validation->set_rules('kondisi', 'Kondisi', 'xss_clean');
            $this->form_validation->set_rules('pasokan_listrik', 'Pasokan Listrik', 'xss_clean|required');
            $this->form_validation->set_rules('menghadap', 'menghadap', 'xss_clean');

            $data['jml_kamar_tidur'] = $this->input->post('jml_kamar_tidur');
            $data['jml_kamar_pembantu'] = $this->input->post('jml_kamar_pembantu');
            $data['jml_kamar_mandi'] = $this->input->post('jml_kamar_mandi');
            $data['jml_garasi'] = $this->input->post('jml_garasi');
            $data['jml_carport'] = $this->input->post('jml_carport');
            $data['jml_saluran_telp'] = $this->input->post('jml_saluran_telp');
            $data['jml_lantai'] = $this->input->post('jml_lantai');
            $data['kondisi'] = $this->input->post('kondisi');
            $data['pasokan_listrik'] = $this->input->post('pasokan_listrik');
            $data['menghadap'] = $this->input->post('menghadap');

            if ($this->form_validation->run() == true) {
                $this->listing_model->update($listing_id, $data);
                $status == 'done' ? redirect(base_url().'member/listing/', 'refresh') : redirect(base_url().'member/listing/upload_images/'.$listing_id, 'refresh');
            }
        }

        $page['m_pasokan_listrik'] = $this->pasokan_listrik_model->get();
        $page['data'] = $data;
        $page['status'] = $status;
        $page['listing_id'] = $listing_id;
        $page['page_name'] = 'member/listing/additional_info';
        $page['page_title'] = 'Halaman Listing';
        $this->load->view('view_index', $page);
    }

    public function delete_image($listing_id, $image_id)
    {
        $this->images_model->delete_image($image_id);
        redirect(base_url().'member/listing/upload_images/'.$listing_id);
    }

    public function upload_images($listing_id, $mode = null)
    {
        if ($mode == 'submit') {
            $count = count($_FILES['img']['name']);

            $config['upload_path'] = './media/';
            $config['allowed_types'] = 'gif|jpeg|jpg|png';

            foreach ($_FILES['img'] as $key => $val) {
                $i = 1;
                // echo 'lol:' . $_FILES['img'];
                foreach ($val as $v) {
                    $field_name = 'file_'.$i;
                    $_FILES[$field_name][$key] = $v;
                    ++$i;
                }
            }

            // hapus array awal, karena kita sudah memiliki array baru
            unset($_FILES['img']);

            // variabel error diubah, dari string menjadi array
            $error = array();
            $success = array();
            foreach ($_FILES as $field_name => $file) {
                $config['encrypt_name'] = true;//ho ho, akhirnya ane ngerti cara generate random name
                $config['max_size'] = get_setting('max_image_listing_size');

                $this->load->library('upload', $config);
                if($file['name'] === "" ) continue;
                if (!$this->upload->do_upload($field_name)) {
                    //echo $this->upload->display_errors();
                    // exit(0);
                    continue;
                } else {
                    $success = $this->upload->data();

                    $data['file_name'] = $success['file_name'];
                    $data['listing_id'] = $listing_id;
                    $this->images_model->insert($data);
                }
            }
            redirect(base_url().'member/listing/upload_images/'.$listing_id, 'refresh');
            //redirect(base_url(). 'member/listing/index/','refresh');
        }

        $page['image_list'] = $this->images_model->get($listing_id);
        $page['listing_id'] = $listing_id;
        $page['page_name'] = 'member/listing/upload_images';
        $page['page_title'] = 'Halaman Listing';
        $this->load->view('view_index', $page);
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

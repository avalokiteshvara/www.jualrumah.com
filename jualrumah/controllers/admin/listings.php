<?php


class Listings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('listing_model'));

        if ($this->session->userdata('adm_sudahlogin') != 1) {
            redirect(base_url().'admin/login', 'refresh');
        }
    }

    function send_email(){
      $this->load->library('My_PHPMailer');

      $mail = new PHPMailer();

      $mail->SMTPDebug = 3;

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
      $mail->addAddress('triasfahrudin@gmail.com', preg_replace('/@.*?$/', '', 'triasfahrudin@gmail.com'));
      $mail->Subject = 'test-email';
      $mail->msgHTML('ini adalah test email');

      if (!$mail->send()) {
        //return false;
        //echo 'Message could not be sent.';
        echo 'Mailer Error: <pre>' . $mail->ErrorInfo . '</pre>';
        //exit(0);
      }

    }

    public function delete($listing_id)
    {
        $this->listing_model->delete($listing_id);
        echo 'OK';
    }

    public function set_status_bayar($param0, $param1)
    {
        $this->db->where('id', $param0);
        $this->db->update('tbl_listing', array('bukti_pembayaran_status' => $param1));
    }

    public function index()
    {
        $url = base_url().'admin/listings/index/';
        $per_page = 10;
        $res = $this->db->count_all_results('tbl_listing');
        $config = $this->paginate($url, $res, $per_page, 4);
        $this->pagination->initialize($config);

        $data['page_title'] = 'Members Listings';
        $data['page_name'] = 'listings';
        $data['active_menu'] = 'listings';
        $data['jumlah_listing'] = $res;
        $data['arr_listings'] = $this->listing_model->get_all($per_page, $this->uri->segment(4));

        $data['segment_4'] = $this->uri->segment(4);

        $this->load->view('admin/view_index', $data);
    }

    public function search()
    {
        $search_string = '';

        if (!empty($_POST)) {
            $search_string = $this->input->post('search_string');
        }

        $url = base_url().'admin/listings/search/';
        $per_page = 10;
        $res = $this->listing_model->get_search_count($search_string);
        $config = $this->paginate($url, $res, $per_page, 4);
        $this->pagination->initialize($config);

        $data['page_title'] = 'Members Listings';
        $data['page_name'] = 'listings';
        $data['active_menu'] = 'listings';
        $data['jumlah_listing'] = $res;
        $data['search_string'] = $search_string;
        $data['arr_listings'] = $this->listing_model->get_search($search_string, $per_page, $this->uri->segment(4));

        $data['segment_4'] = $this->uri->segment(4);

        $this->load->view('admin/view_index', $data);
    }

    public function send_verified_code($id)
    {
        $data['verification_code'] = generateRandomString();
        $this->listing_model->update($id, $data);

        $query = $this->db->query('SELECT b.email as email,'.
                                '       a.judul_listing as judul_listing ,'.
                                '       a.id as id, '.
                                "       CONCAT_WS(' ',b.nama_depan,b.nama_belakang) as nama ".
                                'FROM tbl_listing a '.
                                'LEFT JOIN tbl_member b '.
                                'ON a.id_member = b.id '.
                                'WHERE a.id ='.$id);

        $data['nama'] = $query->row()->nama;
        $data['id'] = $query->row()->id;
        $data['email'] = $query->row()->email;
        $data['judul_listing'] = $query->row()->judul_listing;

        /*
        $config = email_conf();

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('admin@jualrumah.com', 'admin@jualrumah.com');
        $this->email->to($data['email']);
        $this->email->subject('Verifikasi kode listing property @jualrumah.com');

        $this->email->message($this->load->view('admin/emailverification', $data, true));

        if (@$this->email->send()) {
            echo 'OK';
        } else {
            $this->db->where('id', $id);
            $this->db->update('tbl_listing', array('is_verified' => 'Y'));
            echo 'OK';
        }
        */
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
        $mail->addAddress($data['email'], preg_replace('/@.*?$/', '', $data['email']));
        $mail->Subject = 'Verifikasi kode listing property @jualrumah.com';
        $mail->msgHTML($this->load->view('admin/emailverification', $data, true));

        if (!$mail->send()) {
          //return false;
          //echo 'Message could not be sent.';
          echo 'Mailer Error: <pre>' . $mail->ErrorInfo . '</pre>';
          //exit(0);
        }else{
          $this->db->where('id', $id);
          $this->db->update('tbl_listing', array('is_verified' => 'Y'));
          echo 'OK';
        }
    }

    /*
     * Custom pagination function for easy usage Defines the css class for all
     * tags- numerical, open, close, next, previous, last, first
     */

    /* contoh penggunaan

        $url = base_url() . 'admin/channel/';
        $per_page = 10;
        $res = $this->db->count_all_results('community_user');
        $config = $this->paginate($url, $res, $per_page, 3);
        $this->pagination->initialize($config);

        $page['channels'] = $this->community_model->get_user_channel($per_page, $this->uri->segment(3));


    */

    public function paginate($base_url, $total_rows, $per_page, $uri_segment)
    {
        $config = array('base_url' => $base_url, 'total_rows' => $total_rows,
                'per_page' => $per_page, 'uri_segment' => $uri_segment, );

        $config['anchor_class'] = 'class="page radius"';

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

        $config['cur_tag_open'] = '<li><span class="page-active radius">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }
}

<?php

class Message extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        $this->load->model(array('pesan_model'));

        if ($this->uri->segment(3) != 'send') {
            if ($this->session->userdata('sudah_login') == 0) {
                redirect(base_url().'member/login', 'refresh');
            }
        }
    }

    public function index()
    {
        $page['messages_data'] = $this->pesan_model->get_all();
        $page['page_name'] = 'member/messages';
        $page['page_title'] = 'Halaman Profile';
        $this->load->view('view_index', $page);
    }

    public function read($msg_id)
    {
        //cek apakah sudah login ? if not then home
        //cek apakah message id ini milik saya ? if not then dashboard
        //
        echo $this->pesan_model->read($msg_id);
    }

    public function delete($msg_id)
    {
        echo $this->pesan_model->delete($msg_id);
    }

    public function send($penerima_val = null, $id_listing_val = null)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required');
        $this->form_validation->set_rules('telp', 'Telp', 'xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
        $this->form_validation->set_rules('pesan', 'Pesan', 'xss_clean|required');

        $id_penerima = 0;
        $id_listing = 0;

        if ($penerima_val == null and $id_listing_val == null) {
            $id_penerima = $this->input->post('penerima');
            $id_listing = $this->input->post('id_listing');
        } else {
            $id_penerima = $penerima_val;
            $id_listing = $id_listing_val;
        }

        $nama = $this->input->post('nama');
        $telp = $this->input->post('telp');
        $email = $this->input->post('email');
        $pesan = $this->input->post('pesan');

        if ($this->form_validation->run()) {
            $pesan = array(
                'id_penerima' => $id_penerima,
                'id_listing' => $id_listing,
                'nama_pengirim' => $nama,
                'email_pengirim' => $email,
                'telp' => $telp,
                'pesan' => $pesan,
                );

            echo $this->pesan_model->insert($pesan);
        } else {
            echo "#error(Ada kolom isian yang kosong!)\r\n".validation_errors();
        }
    }
}

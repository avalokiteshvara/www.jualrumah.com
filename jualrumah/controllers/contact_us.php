<?php

class Contact_us extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('admin/admconfig_model', 'admin_messages_model'));
    }

    public function index($msg = null)
    {
        if (!is_null($msg)) {
            if ($msg == 'terimakasih') {
                $data['msg'] = 'Pesan anda telah terkirim. Terimakasih';
            }
        }

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

        $data['page_title'] = 'Hubungi kami';
        $data['page_name'] = 'contact_us';
        $this->load->view('view_index', $data);
    }

    public function send_msg()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
        $this->form_validation->set_rules('pesan', 'Pesan', 'xss_clean|required');

        if ($this->form_validation->run()) {
            $dt = array();
            if ($this->session->userdata('sudah_login') == 1) {
                //jika member
                $dt = array(
                    'from_member' => 'Y',
                    'id_member' => $this->session->userdata('user_id'),
                    'nama' => $this->input->post('nama'),
                    'email' => $this->input->post('email'),
                    'pesan' => $this->input->post('pesan'),
                    'tgl' => date('Y-m-d H:i:s'),

                    );
            } else {
                $dt = array(
                    'nama' => $this->input->post('nama'),
                    'email' => $this->input->post('email'),
                    'pesan' => $this->input->post('pesan'),
                    'tgl' => $date = date('Y-m-d H:i:s'),
                    );
            }

            $this->admin_messages_model->insert($dt);
            //$data['msg'] = 'Pesan anda telah terkirim. Trimakasih';
            redirect(base_url().'contact_us/index/terimakasih', 'refresh');
        } else {
            $this->index();
        }
    }
}

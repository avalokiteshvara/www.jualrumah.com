<?php

//pendaftaran

class Signup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('member_model'));
    }

    function index()
    {
        // email,nama_lengkap,no_telp,pass, pass_confirm
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email|is_unique[tbl_member.email]');
        $this->form_validation->set_rules('nama_depan', 'Nama depan', 'xss_clean|required|min_length[2]');
        $this->form_validation->set_rules('nama_belakang', 'Nama belakang', 'xss_clean|min_length[2]');

        $this->form_validation->set_rules('no_telp', 'No.Telp', 'xss_clean|required|numeric');
        $this->form_validation->set_rules('pass', 'Password', 'xss_clean|required|matches[pass_confirm]|min_length[6]');
        $this->form_validation->set_rules('pass_confirm', 'Password Confirm', 'xss_clean|required|min_length[6]');

        if ($this->form_validation->run() == TRUE)
        {

            //data
            $data['email'] = $this->input->post('email');
            $data['password'] = $this->input->post('pass');
            $data['nama_depan'] = $this->input->post('nama_depan');
            $data['nama_belakang'] = $this->input->post('nama_belakang');
            $data['telp'] = $this->input->post('no_telp');

            $use_email_verification = get_setting('use_email_verification');//$this->db->query(
            //     "SELECT value ".
            //     "FROM tbl_config ".
            //     "WHERE item='use_email_verification'")->row()->value;

            if($use_email_verification == 'TRUE'){
                //send email

                $config = email_conf();

                //settings
                $this->load->library('email',$config);
                $this->email->set_newline("\r\n");
                $this->email->from('admin@jualrumah.com' , 'admin@jualrumah.com');
                $this->email->to($this->input->post('email'));
                $this->email->subject('Selamat Datang di www.jualrumah.com');

                $data['verified_code'] = generateRandomString();
                $data['is_verified'] = 'N';

                $this->email->message($this->load->view('member/emailform', $data, true));

                //send message
                if(@$this->email->send()){
                    //jika email send, maka save data
                    $data['password'] = md5($this->input->post('pass'));
                    $this->member_model->signup($data);
                    redirect(base_url() . 'member/login/index/check_verified_link', 'refresh');
                }else{
                  $data['is_verified'] = 'Y';
                  $data['password'] = md5($this->input->post('pass'));
                  $this->member_model->signup($data);
                  redirect(base_url() . 'member/login/index/account_activated', 'refresh');
                }

            }else{
                //ngga pake konfirmasi email
                $data['is_verified'] = 'Y';
                $data['password'] = md5($this->input->post('pass'));
                $this->member_model->signup($data);
                redirect(base_url() . 'member/login/index/account_activated', 'refresh');
            }
        }


        $page['page_name'] = 'member/signup';
        $page['page_title'] = 'Signup';
        $this->load->view('view_index', $page);
    }
}

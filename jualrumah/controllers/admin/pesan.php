<?php


class Pesan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('admin/Admmessage_model','pesan_model'));

        if($this->session->userdata('adm_sudahlogin') != 1){
          redirect(base_url() . 'admin/login','refresh');
        }
    }

    function index(){
        $data['messages_data'] = $this->Admmessage_model->get_all();
        $data['page_title'] = 'Kotak Pesan';
        $data['page_name'] = 'pesan';
        $data['active_menu'] = 'pesan';
        $this->load->view('admin/view_index',$data);

    }

     function read($msg_id){
        echo $this->Admmessage_model->read($msg_id);
    }

    function delete($msg_id){
        echo $this->Admmessage_model->delete($msg_id);
    }


    function kirim(){
        $this->form_validation->set_rules('email_balas', 'Email', 'xss_clean|required|valid_email');
        $this->form_validation->set_rules('subject_balas', 'Subject', 'xss_clean|required|min_length[2]');
        $this->form_validation->set_rules('pesan_balasan', 'Isi Pesan', 'xss_clean|min_length[2]');

        $msg = NULL;

        if ($this->form_validation->run() == TRUE)
        {

            //jika dia member, maka kirim juga ke inbox @jualrumah


            $id_member = $this->input->post('id_member');
            $data['jawaban'] = $this->input->post('pesan_balasan');

            if(isset($id_member)){
                $member_inbox['from_admin'] = 'Y';
                $member_inbox['id_penerima'] = $id_member;
                $member_inbox['nama_pengirim'] = 'admin';
                $member_inbox['email_pengirim'] = 'admin@jualrumah.com';
                $member_inbox['pesan'] = str_replace('{NEW_LINE}', '', $data['jawaban']);

                $this->pesan_model->insert($member_inbox);
            }


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
            $mail->addAddress($this->input->post('email_balas'), preg_replace('/@.*?$/', '', $this->input->post('email_balas')));
            $mail->Subject = 'Reply from jualrumah.com - '.$this->input->post('subject_balas');
            $mail->msgHTML($this->load->view('admin/emailform', $data, true));

            if (!$mail->send()) {
              //return false;
              //echo 'Message could not be sent.';
            echo '#ERROR:Gagal dalam mengirimkan Email';
              //exit(0);
            }else{
              echo 'OK:Email telah terkirim';
            }

            // $config = email_conf();
            //
            // //settings
            // $this->load->library('email',$config);
            // $this->email->set_newline("\r\n");
            // $this->email->from('admin@jualrumah.com' , 'admin@jualrumah.com');
            // $this->email->to($this->input->post('email_balas'));
            // $this->email->subject('Reply from admin@jualrumah.com - '.$this->input->post('subject_balas'));
            //
            // $this->email->message($this->load->view('admin/emailform', $data, true));
            //
            // if($this->email->send()){
            //
            //     echo 'OK:Email telah terkirim';
            //
            // }else{
            //
            //     echo '#ERROR:Gagal dalam mengirimkan Email';
            //
            // }
        }else{
            echo '#ERROR: '.validation_errors().$this->input->post('pertanyaan');
        }

    }

}

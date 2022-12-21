<?php

class Conditions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->model(array('admin/admconfig_model', 'admin_messages_model'));
    }

    public function index($msg = null)
    {
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

        $data['page_title'] = 'Ketentuan';
        $data['page_name'] = 'conditions';
        $this->load->view('view_index', $data);
    }


}

<?php


class Dashboard extends CI_Controller
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

    public function index()
    {
        $data['page_title'] = 'Dashboard';
        $data['page_name'] = 'dashboard';
        $data['active_menu'] = 'dashboard';
        $data['arr_mostviewed'] = $this->listing_model->get_mostviewed(10); //get most viewed listing

       $this->load->view('admin/view_index', $data);
    }
}

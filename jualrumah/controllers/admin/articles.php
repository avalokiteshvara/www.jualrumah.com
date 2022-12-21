<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');



class Articles extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        $this->load->helper('url');
    }



    function index(){
    	$this->manage();

    }

    function manage(){
        $data['page_name'] = 'manage_articles';
        $data['active'] = 'articles';

        $this->load->view('admin/view_index',$data);
    }

}    


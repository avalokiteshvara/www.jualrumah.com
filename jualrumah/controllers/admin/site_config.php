<?php

class Site_config extends CI_Controller{


	function __construct(){

		parent::__construct();
		header('Content-type: text/html; charset=iso-8859-1');

		if($this->session->userdata('adm_sudahlogin') != 1){
          redirect(base_url() . 'admin/login','refresh');
        }

    $this->load->model(array('admin/admconfig_model'));

	}


	function index(){

     $data['page_title'] = 'Admin Config';
     $data['page_name'] = 'site_config';
     $data['active_menu'] = 'site_config';
     // $data['arr_mostviewed'] = $this->listing_model->get_mostviewed(10); //get most viewed listing

     $query = $this->admconfig_model->get()->result();
    //  $email_admin = $this->db->query("SELECT email FROM tbl_admin WHERE superadmin='Y'")->row()->email;


     foreach ($query as $row) {
     		switch ($row->item) {
    	case 'site_title':
    		$data['site_title'] = $row->value;
    		break;

      case 'facebook_link':
        $data['facebook_link'] = $row->value;
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

			case 'admin_email' :
				$data['admin_email'] = $row->value;
				break;

			case 'max_image_listing_size' :
				$data['max_image_listing_size'] = $row->value;
				break;

    	default:
    		# code...
    		break;
     		}
     }

     $this->load->view('admin/view_index',$data);

	}

	function submit(){
		$this->form_validation->set_rules('site_title', 'Nama Situs', 'xss_clean');
    $this->form_validation->set_rules('facebook_link', 'Facebook Link', 'xss_clean');
		$this->form_validation->set_rules('office_zip', 'KodePOS', 'xss_clean|required');
    $this->form_validation->set_rules('office_address', 'Alamat kantor', 'xss_clean|required');
		$this->form_validation->set_rules('office_town', 'Kota kantor', 'xss_clean|required');
    $this->form_validation->set_rules('cs_phone', 'Nomor Telp', 'xss_clean');




    if ($this->form_validation->run() == TRUE){

        	$data = array(
        		array(
        			'item' =>'site_title',
        			'value' =>$this->input->post('site_title')
        			),
            array(
              'item' =>'facebook_link',
              'value' =>$this->input->post('facebook_link')
              ),
    				array(
            			'item' =>'office_zip',
            			'value' =>$this->input->post('office_zip')
            			),
    				array(
            			'item' =>'office_address',
            			'value' =>$this->input->post('office_address')
            			),
    				array(
            			'item' =>'office_town',
            			'value' =>$this->input->post('office_town')
            			),
    				array(
            			'item' =>'cs_phone',
            			'value' =>$this->input->post('cs_phone')
            			),
    				array(
            			'item' =>'use_email_verification',
            			'value' =>$this->input->post('use_email_verification')
									),
						array(
            			'item' =>'admin_email',
            			'value' =>$this->input->post('admin_email')
								),
						array(
            			'item' =>'max_image_listing_size',
            			'value' =>$this->input->post('max_image_listing_size')
            			)

        		);

        	$this->admconfig_model->save($data);
        	// $this->db->query("UPDATE tbl_admin SET email='".$this->input->post('email_admin')."' WHERE superadmin='Y'");

        }

    $this->index();


	}


}

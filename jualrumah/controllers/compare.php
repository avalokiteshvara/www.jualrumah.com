<?php

class Compare extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');
        
        $this->load->model(array('listing_model'));

    }



    //tampilkan listing yang akan di compare
    function show(){
        
        $compare = $this->session->userdata('compare');
        $compare =  empty($compare) ? 0 : $compare;
        
        if($compare != 0){
        
            $id_listing = "";
            foreach ($compare as $key => $value) {
                $id_listing   = $id_listing . "," . $value;
            }

            $q_compare = $this->listing_model->compare($id_listing);

            $data['q_compare'] = $q_compare->result();
        }

        $data['compare_num'] = $compare;        
        $data['page_title'] = 'Perbandingan';
        $data['page_name'] = 'compare';        
        $this->load->view('view_index',$data);

    }

    //tambah listing untuk dicompare
    function insert($id){
        
        $compare = $this->session->userdata('compare');

        if(count($compare) == 3){
            //echo print_r($compare);
            echo 'ERROR:COMPARE_BOX_FULL';
        }else{            
            $compare['id'.$id] = $id;
            $this->session->set_userdata('compare',$compare);
            //echo print_r($compare);
            echo 'Properti telah ditambahkan';
        }
    }

    function delete($id){
        //get data
        $compare = $this->session->userdata('compare');

        //unset spesific data
        unset($compare[$id]);

        //return data to session
        $this->session->set_userdata('compare',$compare);
    }

    //delete listing untuk dicompare
    function empty_compare_box(){
        $this->session->unset_userdata('compare');
    }




}

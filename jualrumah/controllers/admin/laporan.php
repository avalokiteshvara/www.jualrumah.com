<?php


class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-type: text/html; charset=iso-8859-1');

        if ($this->session->userdata('adm_sudahlogin') != 1) {
            redirect(base_url().'admin/login', 'refresh');
        }
    }

    function generate($tahun,$bulan){
      $this->db->select("a.tgl_buat AS `tanggal jual`,a.jenis_iklan,IF(a.is_verified = 'Y','SUDAH','BELUM') AS `Terverifikasi`,
                         a.tipe_listing,IF(a.has_sold = 'Y','SUDAH','BELUM') AS `terjual`,
                         b.nama AS tipe_properti,a.judul_listing,
                         CONCAT(a.harga, ' ',a.satuan_harga) AS harga,
                         CONCAT(d.name , ', ',c.name) AS lokasi",false);
      $this->db->join('tbl_tipe_properti b','a.id_tipe_properti = b.id','left');
      $this->db->join('t_kabupaten c','a.kabupaten = c.id','left');
      $this->db->join('t_kecamatan d','a.kecamatan = d.id','left');
      $this->db->where('YEAR(a.tgl_buat)',$tahun);
      $this->db->where('MONTH(a.tgl_buat)',$bulan);
      $this->db->order_by('tgl_buat DESC');

      $pencarian = $this->db->get('tbl_listing a');

      $this->pdf_report('laporan_bulanan',$pencarian);

    }

    function pdf_report($fileName, $recordSet)
    {

        $data = array();

        $pdfFilePath = FCPATH . 'pdf/' . $fileName . '-' . date('dMy') . '.pdf';

        //boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        ini_set('memory_limit', '32M');
        $data['rs'] = $recordSet;

        $html = $this->load->view('admin/pdf_report', $data, true); // render the view into HTML
        //$this->load->view('admin/pdf_report', $data); // render the view into HTML
        //exit();

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $param = '"en-GB-x","A4-L","","",10,10,10,10,6,3';
        $pdf   = new mPDF();

        $pdf->AddPage('L', '', '', '', '', 10, 10, 10, 10, 6, 3);

        // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822));
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        $this->load->helper('download');
        $data = file_get_contents($pdfFilePath); // Read the file's contents
        $name = $fileName . '_' . date('dMy') . '.pdf';

        force_download($name, $data);
    }

    public function bulanan(){

        if(!empty($_POST)){

          $tahun = $this->input->post('tahun');
          $bulan = $this->input->post('bulan');

          $this->db->select("a.tgl_buat,a.jenis_iklan,a.is_verified,
                             a.tipe_listing,a.has_sold,
                             b.nama AS tipe_properti,a.judul_listing,
                             CONCAT(a.harga, ' ',a.satuan_harga) AS harga,
                             CONCAT(d.name , ', ',c.name) AS lokasi",false);
          $this->db->join('tbl_tipe_properti b','a.id_tipe_properti = b.id','left');
          $this->db->join('t_kabupaten c','a.kabupaten = c.id','left');
          $this->db->join('t_kecamatan d','a.kecamatan = d.id','left');
          $this->db->where('YEAR(a.tgl_buat)',$tahun);
          $this->db->where('MONTH(a.tgl_buat)',$bulan);
          $this->db->order_by('tgl_buat DESC');

          $data['pencarian'] = $this->db->get('tbl_listing a');
        }

        $data['page_title'] = 'Laporan Bulanan';
        $data['page_name'] = 'laporan_bulanan';
        $data['active_menu'] = 'laporan-bulanan';

        $this->load->view('admin/view_index', $data);
    }
}

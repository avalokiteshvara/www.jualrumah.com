<?php
   if (! defined('BASEPATH'))
       exit('No direct script access allowed');
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->
      <meta charset="utf-8">
      <title><?php echo $this->config->item('site_title').'  .: '.$page_title.' :.' ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link id="switch_style" href="<?php echo base_url();?>assets/web/css/bootstrap.css" rel="stylesheet" />
      <!-- <link id="switch_style" href="<?php echo base_url();?>assets/web/bootstrap_2.3.2/css/bootstrap.css" rel="stylesheet" /> -->

      <link id="switch_style" href="<?php echo base_url();?>assets/web/css/real_estate.css" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo base_url()?>assets/web/js/jquery.aw-showcase/css/style.css" />
      <link rel="stylesheet" href="<?php echo base_url()?>assets/web/js/badger/badger.min.css" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/web/js/sticky/sticky.min.css" />
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/jquery.min.js"></script>
      <!-- autocomplete -->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/easy-autocomplete/easy-autocomplete.css" />


      <script type="text/javascript" src="<?php echo base_url();?>assets/easy-autocomplete/jquery.easy-autocomplete.min.js"></script>
      <style>
        body {
          background-image: url("<?php echo site_url('uploads/background.jpg')?>");
        }

        .well{min-height:20px;padding:19px;margin-bottom:20px;background-color: #eee;border:1px solid #eee;border:1px solid rgba(0, 0, 0, 0.05);-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);-moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);}

      </style>
   </head>
   <!-- ----------- body ------------- -->
   <body>
      <div class="container" style="background-color:#f5f5f5;padding:10px">
         <!-- start header -->
         <!---------------- header.php ---------------------->
         <?php
            // $query = $this->db->query("SELECT * FROM tbl_config WHERE item='site_title' OR item='cs_phone'")->result();

            $site_title = get_setting('site_title');
            $cs_phone = get_setting('cs_phone');

            // foreach ($query as $row) {
            //     switch ($row->item) {
            //         case 'site_title':
            //             $site_title = $row->value;
            //             break;
            //
            //         case 'cs_phone':
            //             $cs_phone = $row->value;
            //             break;
            //
            //         default:
            //             # code...
            //             break;
            //     }
            // }

            ?>
         <?php
            if (! defined('BASEPATH'))
                exit('No direct script access allowed');
            ?>
         <div class="row" style="height:100px">
            <div class="span4 logo">
               <a href="<?php echo base_url()?>">
                  <div class="row">
                     <div class="span1">
                        <img src="<?php echo base_url();?>uploads/logo.jpg" alt="" height="100" width="200"/>
                     </div>
                     <div class="span3">
                        <h1>
                           <small>Bursa Properti Online</small><br />
                           <span><?php echo $site_title;?></span>
                        </h1>
                     </div>
                  </div>
               </a>
            </div>
            <div class="span4 customer_service pull-right text-right">
               <br />
               <h4>Customer service: <?php echo $cs_phone;?></h4>
               <h4>
                  <small>24 hours a day, 7 days a week</small>
               </h4>
            </div>
         </div>
         <!-- end header -->
         <!-- start nav -->
         <!-- menu.php -->
         <div class="row">
            <div class="span12">
               <div class="navbar">
                  <div class="navbar-inner">
                     <div class="container">
                        <div class="nav-collapse">
                           <ul class="nav">

                              <?php if($this->session->userdata('sudah_login') == 1){ ?>

                                <li><a href="<?php echo base_url()?>member/profile/<?php echo $this->session->userdata('nama_lengkap')?>">Profile</a></li>
                                <li><a href="<?php echo base_url()?>member/message/<?php echo $this->session->userdata('nama_lengkap')?>">Pesan</a></li>
                                <li><a href="<?php echo base_url()?>member/listing/<?php echo $this->session->userdata('nama_lengkap')?>">Properti saya</a></li>
                                <li><a href="<?php echo base_url()?>conditions">Ketentuan</a></li>
                              <!-- <li class="dropdown"> -->
                                 <!-- <a href="<?php echo base_url()?>" class="dropdown-toggle" data-toggle="dropdown">Akun Saya <b class="caret"></b></a> -->
                                 <!-- <ul class="dropdown-menu"> -->
                                    <!-- <li><a href="<?php echo base_url()?>member/dashboard/<?php echo $this->session->userdata('nama_lengkap')?>">Dashboard</a></li> -->
                                    <!-- <li><a href="<?php echo base_url()?>member/profile/<?php echo $this->session->userdata('nama_lengkap')?>">Profile</a></li>
                                    <li><a href="<?php echo base_url()?>member/message/<?php echo $this->session->userdata('nama_lengkap')?>">Pesan</a></li>
                                    <li><a href="<?php echo base_url()?>member/listing/<?php echo $this->session->userdata('nama_lengkap')?>">Properti saya</a></li> -->
                                    <!-- <li><a href="<?php echo base_url()?>member/bookmark">Properti Tersimpan</a></li> -->
                                 <!-- </ul> -->
                              <!-- </li> -->
                            <?php }else{ ?>
                              <li><a href="<?php echo base_url();?>">Beranda</a></li>
                              <li class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo 'Pencarian Rumah'; ?> <b class="caret"></b>  </a>
                                 <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url()?>search/house_on_sale">Di Jual</a></li>
                                    <li><a href="<?php echo base_url()?>search/house_on_rent">Di Sewa</a></li>
                                 </ul>
                              </li>
                              <!-- <li><a href="<?php echo base_url();?>search/new_house">Rumah Baru</a></li> -->
                              <li><a href="<?php echo base_url();?>agen/view_list">Daftar Agen</a></li>
                              <!-- <li><a href="<?php echo base_url();?>compare/show">Bandingkan Properti</a></li> -->
                              <!-- <li><a href="<?php echo base_url()?>conditions">Ketentuan</a></li> -->
                              <li><a href="<?php echo base_url()?>contact_us">Hubungi Kami</a></li>

                            <?php } ?>
                           </ul>
                           <ul class="nav pull-right">
                              <?php if($this->session->userdata('sudah_login') == 0):?>
                              <li class="dropdown">
                                 <a class="dropdown-toggle" href="#" data-toggle="dropdown">Daftar <strong class="caret"></strong></a>
                                 <div class="dropdown-menu">
                                    <form action="<?php echo base_url()?>signup" method="post" >
                                       <input type="email" name="email" placeholder="Email" size="30" />
                                       <input type="text" name="nama_depan" placeholder="Nama Depan" size="30" />
                                       <input type="text" name="nama_belakang" placeholder="Nama belakang" size="30" />
                                       <input type="text" name="no_telp" placeholder="No.Telp" size="30" />
                                       <input type="password" name="pass" placeholder="Password" size="30" />
                                       <input type="password" name="pass_confirm" placeholder="Ulangi" size="30" />
                                       <input class="btn btn-primary" type="submit" name="commit" value="Daftar" />
                                    </form>
                                 </div>
                              </li>
                              <li class="dropdown">
                                 <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
                                 <div class="dropdown-menu">
                                    <form action="<?php echo base_url()?>member/login" method="post">
                                       <input type="text" name="email" placeholder="Email" size="30" />
                                       <input type="password" name="password" placeholder="Password" size="30" />
                                       <!-- <input id="remember_me" type="checkbox" name="user[remember_me]" value="1" /> -->
                                       <!-- <label class="string optional">Ingat saya</label> -->
                                       <input class="btn btn-primary" type="submit" name="commit" value="Login" />
                                    </form>
                                 </div>
                              </li>
                              <?php else:?>
                              <li><a href="<?php echo base_url()?>member/logout" class="first">Log Out ( <?php echo $this->session->userdata('nama_depan')?> )</a></li>
                              <?php endif;?>
                           </ul>
                        </div>
                        <!-- /.nav-collapse -->
                     </div>
                  </div>
                  <!-- /navbar-inner -->
               </div>
               <!-- /navbar -->
            </div>
         </div>
         <!-- end nav -->
         <?php      include $page_name . ".php";    ?>
         <!-- start footer -->
         <footer>
            <hr />
            <p class="pull-right"><a href="#">Back to top</a></p>
            <!-- <p>
               <a href="index.html">Home</a> |
               <a href="about.html">About</a> |
               <a href="typography.html">Typography</a> |
               <a href="terms.html">Terms and Conditions</a> |
               <a href="contact.html">Contact Us</a>

               </p> -->
         </footer>
         <!-- end footer -->
      </div>
      <!-- /container -->
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/jquery.aw-showcase/jquery.aw-showcase.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/bootstrap/js/bootstrap.js"></script>
      <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/web/bootstrap_2.3.2/js/bootstrap.js"></script> -->
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/badger/badger.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/sticky/sticky.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/portamento-min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>assets/web/js/global.js"></script>
   </body>
</html>

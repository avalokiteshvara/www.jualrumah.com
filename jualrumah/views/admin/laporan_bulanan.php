<script type="text/javascript" src="<?php echo site_url('assets/table-export/tableExport.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/table-export/jquery.base64.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/table-export/html2canvas.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/table-export/jspdf/libs/sprintf.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/table-export/jspdf/jspdf.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/table-export/jspdf/libs/base64.js')?>"></script>

<div class="span9" id="content" style="margin-top:25px">
   <div class="row-fluid">
      <div class="span12">
         <!-- block -->
         <form class="form-inline" action="" method="post">
           <input type="text" class="input-normal" placeholder="Tahun" name="tahun" required="" value="<?php echo @$_POST['tahun']?>">
           <select name="bulan" class="input-small">
             <option <?php echo @$_POST['bulan'] == 1 ? 'selected' : ''?> value="1">Januari</option>
             <option <?php echo @$_POST['bulan'] == 2 ? 'selected' : ''?> value="2">Februari</option>
             <option <?php echo @$_POST['bulan'] == 3 ? 'selected' : ''?> value="3">Maret</option>
             <option <?php echo @$_POST['bulan'] == 4 ? 'selected' : ''?> value="4">April</option>
             <option <?php echo @$_POST['bulan'] == 5 ? 'selected' : ''?> value="5">Mei</option>
             <option <?php echo @$_POST['bulan'] == 6 ? 'selected' : ''?> value="6">Juni</option>
             <option <?php echo @$_POST['bulan'] == 7 ? 'selected' : ''?> value="7">Juli</option>
             <option <?php echo @$_POST['bulan'] == 8 ? 'selected' : ''?> value="8">Agustus</option>
             <option <?php echo @$_POST['bulan'] == 9 ? 'selected' : ''?> value="9">September</option>
             <option <?php echo @$_POST['bulan'] == 10 ? 'selected' : ''?> value="10">Oktober</option>
             <option <?php echo @$_POST['bulan'] == 11 ? 'selected' : ''?> value="11">November</option>
             <option <?php echo @$_POST['bulan'] == 12 ? 'selected' : ''?> value="12">Desember</option>
           </select>
           <button type="submit" class="btn">Cari</button>
         </form>

          <?php if(!empty($_POST)){ ?>
            <div class="btn-group">
              <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
              <ul class="dropdown-menu " role="menu">
                <li><a href="<?php echo site_url('admin/laporan/generate/' . @$_POST['tahun'] . '/'. @$_POST['bulan'])?>" > PDF</a></li>

              </ul>
            </div>
            <div class="block">
               <div class="navbar navbar-inner block-header">
                  <div class="muted pull-left">Members</div>
                  <div class="pull-right"><span class="badge badge-info">6</span>
                  </div>
               </div>

               <div class="block-content collapse in">
                  <table class="table table-hover" id="table_properties">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>STATUS</th>
                           <th>TIPE</th>
                           <th>JUDUL</th>
                           <th>LOKASI</th>
                           <th>HARGA</th>
                        </tr>
                     </thead>
                     <tbody>
                       <?php $i=1;
                         foreach ($pencarian->result_array() as $p) { ?>
                         <tr>
                           <td><?php echo $i;?></td>
                           <td>
                             <?php if($p['is_verified'] === 'N'){
                               echo '<span class="label label-warning">Belum Terverifikasi</span>';
                             }else{
                                 if($p['has_sold'] === 'Y'){
                                   echo '<span class="label label-default">Terjual</span>';
                                 }else{
                                   echo '<span class="label label-success">Terverifikasi</span>&nbsp;';
                                   if($p['jenis_iklan'] === 'premium'){
                                     echo '<span class="label label-info">Premium</span>';
                                   }
                                 }
                             } ?>
                           </td>
                           <td><?php echo $p['tipe_properti']?></td>
                           <td><?php echo $p['judul_listing']?></td>
                           <td><?php echo $p['lokasi']?></td>
                           <td><?php echo $p['harga']?></td>
                         </tr>
                       <?php $i++;} ?>

                     </tbody>
                  </table>
               </div>
            </div>
            <!-- /block -->

          <?php } ?>


      </div>
   </div>
</div>

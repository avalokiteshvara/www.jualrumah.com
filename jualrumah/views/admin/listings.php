<script type="text/javascript">

    function setFocus(){
        document.getElementById("search_string").focus();
    }

    function del_list(id){

      var x = confirm("apakah anda yakin untuk menghapus data ini?");
      if (x){
        $.ajax({
            url:'<?php echo base_url() . 'admin/listings/delete/';?>' + id,
            type:"POST",
            async   : false,
            cache   : false,
            success : function(msg){
                $('#tr_' + id).remove();
            }
        })
      }

    }

    function send_verification_code(id){
        $.ajax({
            url: '<?php echo base_url() . 'admin/listings/send_verified_code/';?>' + id,
            type: "POST",
            async: false,
            cache: false,
            success: function(msg){
                if(msg == 'OK'){
                    // alert('Kode Verifikasi terkirim');
                    window.location = "<?php site_url('admin/listings')?>"
                }else{
                    // alert('ERROR! Kode verifikasi tidak terkirim');
                    window.location = "<?php site_url('admin/listings')?>"
                }

            }
        })
    }

    function set_status_bayar(id,status){
        $.ajax({
            url: '<?php echo base_url() . 'admin/listings/set_status_bayar/';?>' + id + '/' + status,
            type: "GET",
            async: false,
            cache: false,
            success: function(msg){
              window.location = "<?php site_url('admin/listings')?>"
            }
        })
    }

</script>

</br>
</br>


<div class="span9" id="content">


    <div class="row-fluid">
        <div class="span12">

            <form class="form-search" method="post" action="<?php echo base_url(); ?>admin/listings/search">
                <input id="search_string" name="search_string" type="text" class="input-large search-query" value="<?php echo isset($search_string) ? $search_string : '' ?>" />
                <button type="submit" class="btn"><i class="icon-search icon-white"></i>Search</button>
            </form>

            <!-- block -->
            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">Property Listings</div>
                    <div class="pull-right"><span class="badge badge-info"><?php echo $jumlah_listing;?></span>

                    </div>
                </div>
                <?php if($arr_listings->num_rows() != 0):?>

                <div class="block-content collapse in">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>STATUS</th>
                                <!-- <th>Nama member</th> -->
                                <th>Tipe</th>
                                <th>Judul Properti</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $i = empty($segment_4) ? 0 : $segment_4 ;

                                foreach ($arr_listings->result() as $r_listing) {
                                    $i +=1;
                            ?>


                        <?php if($r_listing->is_verified == 'N'){ ?>
                            <tr id="tr_<?php echo $r_listing->id;?>" class="warning">
                                <td><?php echo $i; ?></td>
                                <td><span class="label label-warning">Not Verified</span></td>
                        <?php }else{ ?>
                            <?php if($r_listing->terjual == 'Y'){ ?>
                                <tr id="tr_<?php echo $r_listing->id;?>" class="error">
                                    <td><?php echo $i; ?></td>
                                    <td><span class="label label-default">Sold !</span></td>
                            <?php }else{ ?>
                                <tr id="tr_<?php echo $r_listing->id;?>" class="success">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                      <span class="label label-success">verified</span>
                                      <?php if($r_listing->jenis_iklan === 'premium'){ ?>
                                        <span class="label label-info">Premium</span>
                                      <?php } ?>
                                    </td>

                            <?php } ?>
                        <?php } ?>

                                <!-- <td><?php echo $r_listing->nama_member; ?></td> -->
                                <td><?php echo $r_listing->tipe;?></td>

                                <td>
                                  <a href="<?php echo site_url('property/show/' . $r_listing->id)?>" target="_blank"><?php echo ' (' . strtoupper($r_listing->jual_sewa) . ') ' .$r_listing->judul;?></a>
                                </td>
                                <td><?php echo $r_listing->lokasi;?></td>
                                <td><?php echo $r_listing->harga;?></td>
                                <td>
                                  <?php if($r_listing->bukti_pembayaran_status === 'pending'){ ?>
                                  <a href="<?php echo site_url('uploads/pembayaran/' . $r_listing->bukti_pembayaran)?>" target="_blank">Lihat</a>
                                  <div class="btn-group">
                                      <button class="btn dropdown-toggle" data-toggle="dropdown">
                                          Options <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                          <li id="bayar_<?php echo $r_listing->id;?>">
                                              <a href="#" onclick="set_status_bayar(<?php echo $r_listing->id ?>,'ok');return false">
                                                <i class="icon-ok"></i> VALID
                                              </a>
                                          </li>
                                          <li id="bayar_<?php echo $r_listing->id;?>">
                                              <a href="#" onclick="set_status_bayar(<?php echo $r_listing->id?>,'error');return false">
                                                <i class="icon-remove"></i> ERROR
                                              </a>
                                          </li>
                                      </ul>

                                  </div>
                                  <?php } ?>
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                                            Options <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                    <?php if($r_listing->is_verified != 'Y'):?>
                                            <li id="verified_<?php echo $r_listing->id;?>"><a href="#" onclick="send_verification_code(<?php echo $r_listing->id?>);return false"><i class="icon-ok"></i> Verifikasi!</a></li>
                                    <?php endif; ?>

                                            <li><a href="#" onclick="del_list(<?php echo $r_listing->id?>);return false"><i class="icon-remove"></i> Hapus!</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <?php if($jumlah_listing > 10){?>
                    <div class="pagination" align="center">
                        <ul>
                            <?php echo $this->pagination->create_links(); ?>
                        </ul>
                    </div>
                    <?php }?>
                </div>

            <?php else:?>

                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Error</h4>
                    Data Property tidak ditemukan
                </div>

            <?php endif;?>

            </div>
            <!-- /block -->
        </div>
    </div>


    <div class="row-fluid">

    </div>
</div>

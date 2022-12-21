<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDy5ePPPOnm2Ix6_MU7SGsUX4QzrHfH1t4&sensor=false"></script>
<script type="text/javascript">
//<![CDATA[

     // global "map" variable
      var map = null;
      var marker = null;

      var infowindow = new google.maps.InfoWindow(
        {
          size: new google.maps.Size(150,50)
        }
      );

      // A function to create the marker and set up the event window function
      function createMarker(latlng, name, html) {
          var contentString = html;
          var marker = new google.maps.Marker({
              position: latlng,
              map: map,
              zIndex: Math.round(latlng.lat()*-100000)<<5
          });

          google.maps.event.addListener(marker, 'click', function() {
              infowindow.setContent(contentString);
              infowindow.open(map,marker);
          });

          google.maps.event.trigger(marker, 'click');
          return marker;
      }



      function initialize() {

        <?php if($status == 'new'):?>

        var myOptions = {
          zoom: 4,
          center: new google.maps.LatLng(-0.08789059053082422, 113.6865234375),
          mapTypeControl: true,
          mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
          navigationControl: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        <?php else : ?>

          <?php if($data['lat'] != null){ ?>

            var myLatLng = {lat: <?php echo $data['lat'];?>, lng: <?php echo $data['lng']?>};
            // create the map
            var myOptions = {
              zoom: 15,
              center: new google.maps.LatLng(<?php echo $data['lat'];?>, <?php echo $data['lng']?>),
              mapTypeControl: true,
              mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
              navigationControl: true,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }

          <?php }else{ ?>
            var myOptions = {
              zoom: 4,
              center: new google.maps.LatLng(-0.08789059053082422, 113.6865234375),
              mapTypeControl: true,
              mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
              navigationControl: true,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }

          <?php } ?>


        <?php endif; ?>


        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        <?php if($status == 'new'):?>

        <?php else: ?>
          <?php if($data['lat'] != null){ ?>
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
              });
          <?php } ?>

        <?php endif;?>

        google.maps.event.addListener(map, 'click', function() {
              infowindow.close();
        });

        google.maps.event.addListener(map, 'click', function(event) {
      	//call function to create marker
          if (marker) {
              marker.setMap(null);
              marker = null;
          }
	        marker = createMarker(event.latLng, "name", "<b>Location</b><br>"+event.latLng);
          // alert(event.latLng.lat());
          $('#lat').val(event.latLng.lat());
          $('#lng').val(event.latLng.lng());
        });

      }


      //]]>

    window.onload = initialize;
</script>

<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>



<div class="row">
    <div class="span12">
        <div class="page-header">
<?php if($status == 'new'):?>
            <h1><?php echo 'Tambah'; ?></h1>
<?php else:?>
            <h1>Edit : <?php echo $data['judul_listing']; ?> </h1>
<?php endif;?>
        </div>
    </div>
</div>

<div class="row">
<?php if(!validation_errors() == ""):?>
    <div class="span12">
        <div class="alert alert-error">
    	   <a class="close" data-dismiss="alert" href="#">x</a><?php echo validation_errors();?>
        </div>
    </div>
<?php endif;?>
</div>


<div class="row">
  <div class="span12">

<?php if($status == 'new'):?>
        <form class="form-horizontal" method="post" action="<?php echo base_url()?>member/listing/add_basic/submit" accept-charset="UTF-8" enctype="multipart/form-data">
<?php else:?>
        <form class="form-horizontal" method="post" action="<?php echo base_url()?>member/listing/edit_basic/<?php echo $listing_id;?>/submit/" accept-charset="UTF-8" enctype="multipart/form-data">
<?php endif;?>

  		<div class="page-header">
   			<h3>Properti Basic Info</h3>
   		</div>

      <div class="control-group">
        <label for="focusedInput" class="control-label">Jenis Iklan</label>
        <div class="controls">
          <input type="text" readonly="" value="<?php echo isset($data['jenis_iklan']) ? $data['jenis_iklan']:'gratis'?>" />


          <?php if($status !== 'new'){ ?>
            <?php if($data['jenis_iklan'] === 'premium'){ ?>
              s.d <?php echo $data['premium_tgl_berakhir']?>
            <?php }else{ ?>
              <p>* Transfer ke BCA 0000-0000-000 a/n Budi <br />
                 Sebesar Rp. 200.000 Untuk 90 hari<br />
                 Setelah melakukan pembayaran,<br />
                 silahkan upload bukti pembayaran pada halaman ini

               </p>
            <?php } ?>
          <?php }else{ ?>
            <p>* Transfer ke BCA 0000-0000-000 a/n Budi <br />
               Sebesar Rp. 200.000 Untuk 90 hari<br />
               Setelah melakukan pembayaran,<br />
               silahkan upload bukti pembayaran pada halaman ini

             </p>
          <?php } ?>

        </div>
      </div>

      <?php if($status === 'new'){ ?>
        <div class="control-group">
          <label for="focusedInput" class="control-label">Upload Pembayaran</label>
          <div class="controls">
            <input type="file" name="bukti_pembayaran" >

          </div>
        </div>
      <?php }else{ ?>
        <?php if($data['jenis_iklan'] !== 'premium'){ ?>
        <div class="control-group">
          <label for="focusedInput" class="control-label">Upload Pembayaran</label>
          <div class="controls">
            <input type="file" name="bukti_pembayaran" >
            <p>Transfer ke BCA 0000-0000-000 a/n Budi <br />
               Sebesar Rp. 200.000 Untuk 90 hari</p>
          </div>
        </div>
        <?php } ?>

        <?php if($data['bukti_pembayaran_status'] !== 'none'){ ?>
          <div class="control-group">
            <label for="focusedInput" class="control-label">Status Pembayaran</label>
            <div class="controls">
            <input type="text" readonly="" value="<?php echo $data['bukti_pembayaran_status']?>" /></p>
            </div>
          </div>

        <?php } ?>

      <?php } ?>


    	<div class="control-group">
    		<label for="focusedInput" class="control-label">*Jual/Sewa</label>
    		<div class="controls">
    			<select name="tipe_listing" id="tipe_listing" class="input-medium focused">
    				<option <?php if(isset($data['tipe_listing'])){ echo $data['tipe_listing'] == "jual" ? 'selected="selected"' : '';} ?>  value="jual">Jual</option>
    				<option <?php if(isset($data['tipe_listing'])){ echo $data['tipe_listing'] == "sewa" ? 'selected="selected"' : '';} ?>  value="sewa">Sewa</option>
    			</select>
    		</div>
    	</div>
    	<!-- jenis penjualan -->


    	<!-- tipe properti -->
    	<div class="control-group">
    		<label for="focusedInput" class="control-label">*Tipe Property</label>
    		<div class="controls">
    			<select name="id_tipe_properti" id="id_tipe_properti" class="input-medium focused">
    				<?php foreach($m_jns_properti as $data_jns_properti) { ?>
            <optgroup label="<?php echo $data_jns_properti['nama'];?>">
            <?php echo print_recursive_list($data_jns_properti['child'],@$data['id_tipe_properti']);    		     ?>
            </optgroup>
            <?php } ?>

    			</select>
    		</div>
    	</div>
    	<!-- end tipe properti -->

        <div class="control-group">
            <label for="focusedInput" class="control-label">*Status</label>
            <div class="controls">
                <select name="new_house" id="new_house" class="input-medium focused">
                    <option <?php if(isset($data['new_house'])){ echo $data['new_house'] == "Y" ? 'selected="selected"' : '';} ?>  value="Y">Baru</option>
                    <option <?php if(isset($data['new_house'])){ echo $data['new_house'] == "N" ? 'selected="selected"' : '';} ?>  value="N">Bekas</option>
                </select>
            </div>
        </div>

    	<!-- -------------------------------------------------------------- -->

    	<div class="span12">
    		<div class="page-header">
    			<h3>Judul dan Deskripsi</h3>
    		</div>
        </div>

        <!--  judul listing -->
        <div class="control-group">
    	   <label for="focusedInput" class="control-label">* Judul Properti</label>
    	   <div class="controls">
    			<input name="judul_listing"
    			       type="text"
    			       placeholder=""
    			       id="focusedInput"
    			       class="input-xlarge focused span6"
    			       value="<?php echo isset($data['judul_listing']) ? $data['judul_listing'] : '';?>"
        <?php if($status != 'new'):?>
    			       readonly="readonly"
        <?php endif;?>
    			/>
    	   </div>
    	</div>
    	<!-- end judul listing -->

    	<!-- deskripsi -->
    	<div class="control-group">
    		<label for="textarea" class="control-label">*<?php echo 'Deskripsi'; ?>:</label>
    		<div class="controls">
    			<textarea name="deskripsi_listing"
    			          rows="3"
    			          id="textarea"
    			          placeholder=""
    			          class="input-xlarge span6"><?php echo isset($data['deskripsi_listing']) ? $data['deskripsi_listing']:'';?>
    			</textarea>
    		</div>
    	</div>
    	<!-- end deskripsi -->

        <!-- -------------------------------------------------------------- -->

    	<div class="span12">
    		<div class="page-header">
    			<h3><?php echo 'Info Lokasi'; ?></h3>
    		</div>
        </div>


      <div class="control-group">
        <label for="textarea" class="control-label">*Provinsi:</label>
        <?php
        $this->db->order_by('name ASC');
        $provinsi = $this->db->get('t_provinsi')
        ?>
        <div class="controls">
          <select name="provinsi" id="provinsi" class="input-medium">
            <option value="">Pilih provinsi</option>
          <?php foreach ($provinsi->result_array() as $prov) { ?>
            <option value="<?php echo $prov['id']?>"><?php echo $prov['name']?></option>
          <?php } ?>
          </select>
        </div>
      </div>

      <div class="control-group">
        <label for="textarea" class="control-label">*Kabupaten/Kota:</label>
        <div class="controls">
          <select name="kabupaten" id="kabupaten" class="input-medium">
          </select>
        </div>
      </div>

      <div class="control-group">
        <label for="textarea" class="control-label">*Kecamatan:</label>
        <div class="controls">
          <select name="kecamatan" id="kecamatan" class="input-medium">
          </select>
        </div>
      </div>


    	<!-- deskripsi -->
    	<div class="control-group">
    		<label for="textarea" class="control-label">*<?php echo 'Alamat'; ?>:</label>
    		<div class="controls">
    			<textarea name= "alamat_lengkap" rows="3" id="textarea"  placeholder="" class="input-xlarge span6"><?php echo isset($data['alamat_lengkap']) ? trim($data['alamat_lengkap']) : ''; ?></textarea>
    		</div>
    	</div>
    	<!-- end deskripsi -->

    	<!-- TODO: add google map based location -->



    	<!-- -------------------------------------------------------------- -->

    	<div class="span12">
    		<div class="page-header">
    			<h3><?php echo 'Informasi Harga'; ?></h3>
    		</div>
        </div>


    	<!-- jenis harga -->
    	<div class="control-group">
    		<label for="focusedInput" class="control-label"><?php echo 'Tipe Harga'; ?></label>
    		<div class="controls">
    			<select name="tipe_harga" id="tipe_harga" class="input-medium focused">
    				<option <?php if(isset($data['tipe_harga'])){ echo $data['tipe_harga'] == "nego"    ? 'selected="selected"' : '';} ?> value="nego">Nego</option>
    				<option <?php if(isset($data['tipe_harga'])){ echo $data['tipe_harga'] == "diminta" ? 'selected="selected"' : '';} ?> value="diminta">Harga diminta</option>
    				<option <?php if(isset($data['tipe_harga'])){ echo $data['tipe_harga'] == "kisaran" ? 'selected="selected"' : '';} ?> value="kisaran">Kisaran harga</option>
    			</select>
    		</div>
    	</div>
    	<!-- end jenis harga -->

    	<!-- harga -->
    	<div class="control-group">
    	   <label for="focusedInput" class="control-label"><?php echo 'Harga'; ?> </label>
    	   <div class="controls">
        	   <div class="input-prepend input-append">
                    <span class="add-on"><?php echo 'Rp.'; ?></span>
                    <input value="<?php echo isset($data['harga']) ? $data['harga'] : '';?>" name="harga" class="span2" id="appendedPrependedInput" type="text">
                    <!-- <span class="add-on">.00</span> -->
              </div>
              <select name="satuan_harga" id="satuan_harga" class="input-small focused">
                    <option <?php if(isset($data['satuan_harga'])){ echo $data['satuan_harga'] == "ribu"    ? 'selected="selected"' : '';} ?> value="ribu">Ribu</option>
                    <option <?php if(isset($data['satuan_harga'])){ echo $data['satuan_harga'] == "juta" ? 'selected="selected"' : '';} ?> value="juta">Juta</option>
                    <option <?php if(isset($data['satuan_harga'])){ echo $data['satuan_harga'] == "milyar" ? 'selected="selected"' : '';} ?> value="milyar">Milyar</option>
              </select>
          </div>
    	</div>


    	<!-- jenis sertifikat -->

    	<div class="control-group">
    		<label for="focusedInput" class="control-label"><?php echo 'Jenis Sertifikat'; ?></label>

    		<div class="controls">
    			<select name="id_jns_sertifikat" id="id_jns_sertifikat" class="input-medium focused">
    				<?php foreach ($m_jns_sertifikat as $r_sertifikat) {?>
    				    <option <?php if(isset($data['id_jns_sertifikat'])) echo $r_sertifikat->id == $data['id_jns_sertifikat'] ? 'selected="selected"' : ''  ?> value="<?php echo $r_sertifikat->id;?>"><?php echo $r_sertifikat->nama;?></option>
    				<?php }?>
    			</select>
    		</div>
    	</div>
    	<!-- end jenis sertifikat -->


    	<!-- -------------------------------------------------------------- -->

    	<div class="span12">
    		<div class="page-header">
    			<h3><?php echo 'Informasi Ukuran' ;?></h3>
    		</div>
        </div>



    	<div class="control-group">
    	   <label for="focusedInput" class="control-label">*<?php echo 'Luas Bangunan'; ?></label>
    	   <div class="controls">
    			<input name="luas_bangunan"
    			       type="text"
    			       placeholder=""
    			       id="focusedInput"
    			       class="input-xlarge focused span1"
    			       value="<?php echo isset($data['luas_bangunan']) ? $data['luas_bangunan'] : '' ;?>"
    		    > m2
    	   </div>
    	</div>

    	<div class="control-group">
    	   <label for="focusedInput" class="control-label">Dimensi Bangunan</label>
    	   <div class="controls controls-row">
             <?php if(isset($data['dimensi_bangunan'])){ ?>
               <?php $arr_dimensi_bangunan = explode('x',$data['dimensi_bangunan']);?>
               <input name="dimensi_bangunan_a" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_bangunan[0]) ? $arr_dimensi_bangunan[0]: '' ;?>" > X
               <input name="dimensi_bangunan_b" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_bangunan[1]) ? $arr_dimensi_bangunan[1] : '' ;?>" > (ukuran dalam meter)
               <?php }else{ ?>
               <input name="dimensi_bangunan_a" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_bangunan[0]) ? $arr_dimensi_bangunan[0]: '' ;?>" > X
               <input name="dimensi_bangunan_b" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_bangunan[1]) ? $arr_dimensi_bangunan[1] : '' ;?>" > (ukuran dalam meter)
              <?php } ?>
          </div>
    	</div>

    	<div class="control-group">
    	   <label for="focusedInput" class="control-label">*<?php echo 'Luas Tanah'; ?></label>
    	   <div class="controls">
    			<input name="luas_tanah" type="text" id="focusedInput" class="input-xlarge focused span1" value="<?php echo isset($data['luas_tanah']) ? $data['luas_tanah'] : '' ;?>"> m2
    	   </div>
    	</div>

    	<div class="control-group">
    	   <label for="focusedInput" class="control-label">Dimensi Tanah</label>
         <?php if(isset($data['dimensi_bangunan'])){ ?>
           <?php $arr_dimensi_tanah = explode('x',$data['dimensi_tanah']);?>
      	   <div class="controls controls-row">
               <input name="dimensi_tanah_a" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_tanah[0]) ? $arr_dimensi_tanah[0]: '' ;?>" > X
               <input name="dimensi_tanah_b" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_tanah[0]) ? $arr_dimensi_tanah[0]: '' ;?>" > X (ukuran dalam meter)
            </div>
          <?php }else{ ?>
       	   <div class="controls controls-row">
                <input name="dimensi_tanah_a" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_tanah[0]) ? $arr_dimensi_tanah[0]: '' ;?>" > X
                <input name="dimensi_tanah_b" class="span1" type="text" placeholder="" value="<?php echo isset($arr_dimensi_tanah[0]) ? $arr_dimensi_tanah[0]: '' ;?>" > X (ukuran dalam meter)
             </div>
          <?php } ?>


    	</div>

      <!-- <div class="span12">
    		<div class="page-header">
    			<h3>Lokasi</h3>
    		</div>
        </div> -->

      <div class="span12" style="padding-top:10px;padding-bottom:10px">
        <div id="map_canvas" style="width:90%; height:350px;"></div>
        <input type="hidden" id="lat" name="lat" value="<?php echo isset($data['lat']) ? $data['lat'] : '' ;?>"/>
        <input type="hidden" id="lng" name="lng" value="<?php echo isset($data['lng']) ? $data['lng'] : '' ;?>"/>
      </div>

      <!-- <div class="control-group">
    	   <label for="focusedInput" class="control-label"><?php echo 'Dimensi Tanah'; ?></label>
    	   <div class="controls controls-row">
             <input name="dimensi_tanah_a" class="span1" type="text" placeholder=""> X
             <input name="dimensi_tanah_b" class="span1" type="text" placeholder=""> (ukuran dalam meter)
          </div>
    	</div> -->

    	<div class="control-group">
    		<div class="controls">

            <?php if($status == 'go_next' or $status == 'new') :?>
    			<button type="submit" class="btn btn-primary pull-right">Lanjut =></button>
            <?php else:?>
                <button type="submit" class="btn btn-primary pull-right">Simpan Perubahan</button>
            <?php endif;?>

    		</div>
    	</div>
    </form>
  </div>
</div>

<script>
    <?php if($status !== 'new'){ ?>
      $( document ).ready(function() {
        $('#provinsi').val('<?php echo $data['provinsi']?>');

        get_kabupaten('<?php echo $data['provinsi']?>',false);
        get_kecamatan('<?php echo $data['kabupaten']?>')

      });
    <?php } ?>

    function get_kabupaten(provinsi,reset_kecamatan){
      $.get( "<?php echo site_url("member/listing/kabupaten_ajax");?>/" + provinsi, function( data ) {
        $( "#kabupaten" ).html( data );

        <?php if($status !== 'new'){ ?>
          $('#kabupaten').val('<?php echo $data['kabupaten']?>');
        <?php } ?>

        if(reset_kecamatan){
          $( "#kecamatan").html("");
        }

      });
    }

    function get_kecamatan(kabupaten){
      $.get( "<?php echo site_url("member/listing/kecamatan_ajax");?>/" + kabupaten, function( data ) {
        $( "#kecamatan" ).html( data );

        <?php if($status !== 'new'){ ?>
          $('#kecamatan').val('<?php echo $data['kecamatan']?>');
        <?php } ?>

      });
    }

    $('#provinsi').on('change', function() {
      var val = this.value ;
      get_kabupaten(val,true);
    })

    $('#kabupaten').on('change', function() {
      var val = this.value ;
      get_kecamatan(val);
    })


</script>

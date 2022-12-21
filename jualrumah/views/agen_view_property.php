<script>
	var myVal;
	function set_value(val){
		myVal = val;
		clear_text();
	}

	function clear_text(){
		document.getElementById('nama').value="";
		document.getElementById('telp').value="";
		document.getElementById('email').value="";
		document.getElementById('pesan').value="";
	}

	function send_msg(){

	 $.ajax({
		 url:'<?php echo base_url() . 'member/message/send/';?>' + myVal,
		 type:"POST",
		 data : $('form').serialize(),
		 async: false,
		 cache   : false,
				 success: function(msg){
				 if(msg.indexOf("#error") != 0){

					 clear_text();
					 alert(msg);
					 $('#myModal').modal('hide');

					 }else{
						 alert(msg);
					 }
				 }
	 })
	}

</script>

<style type="text/css">
   .modal{
   width: 700px;
   left: 45%;
   }
   .input-xlarge{
   width: 330px;
   }
</style>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h3 id="myModalLabel">Kirim Pesan</h3>
   </div>
   <form class="well span8">
      <div class="row">
         <div class="span3">
            <label>Nama</label>
            <input name="nama" id="nama" type="text" class="span3" placeholder="Nama">
            <label>Email</label>
            <input name="email" id="email" type="text" class="span3" placeholder="Alamat Email">
            <label>No.Telp</label>
            <input name="telp" id="telp" type="text" class="span3" placeholder="Nomor Telp">
         </div>
         <div class="span5">
            <label>Message</label>
            <textarea name="pesan" id="pesan" class="input-xlarge span5" rows="10"></textarea>
         </div>
         <button type="submit" class="btn btn-primary pull-right" onclick="send_msg();return false;">Kirim</button>
      </div>
   </form>
</div>

<div class="row">
	<div class="span3">

		<h3>Alamat:</h3>
		<p>
			<?php echo $site_title;?><br />
			<?php echo $office_address;?><br />
			<?php echo $office_town;?><br />
			<?php echo $office_zip;?>
		</p>

		<h3>Telephone:</h3>
		<p><?php echo $cs_phone; ?></p>
		<br>

		<div class="row">
			<div class="span4">
				<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $facebook_link;?>&amp;width=200&amp;height=210&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:70px;" allowTransparency="true"></iframe>
			</div>
		</div>
	</div>

	<div class="span9">
		<div class="page-header">
			<h1>

        Daftar Property Agen
      </h1>
		</div>

    <?php foreach ($property->result_array() as $prop) { ?>
    <div class="row">
       <div class="span2">
          <a href="<?php echo base_url().'property/show/' . $prop['id']; ?>" class="thumbnail <?php echo ($prop['has_sold'] == 'Y') ? 'property_sold' : ''  ?>">
            <?php $prop_image = $this->db->get_where('tbl_images',array('listing_id' => $prop['id']),1,0)->row_array()?>
            <img src="<?php echo image(base_url() . "media/" . $prop_image['file_name'],'thumb') ?>" height="80" width="130"  />
          </a>
          <h5>Harga: Rp.<?php echo $prop['harga'].' '.$prop['satuan_harga'];?></h5>
          <?php
             if($prop['id_tipe_properti'] != 5){
              if($prop['new_house'] == 'Y'){
                echo '<h6>Status: Baru</h6>';
              }else{
                echo '<h6>Status: Bekas</h6>';
              }
              echo '<h6>Kamar tidur : '. $prop['jml_kamar_tidur'] .'</h6>';
             }
             ?>
          <h6>Tanggal: <?php echo date('d-m-Y',strtotime($prop['tgl_buat']));?></h6>
          <h6>Di Lihat: <?php echo $prop['total_dilihat'];?> kali</h6>
       </div>
       <div class="span6">
          <a href="<?php echo base_url().'property/show/' . $prop['id']; ?>">
             <h3><?php echo substr('('.strtoupper($prop['tipe_listing']).') '.$prop['judul_listing'],0,40);?></h3>
          </a>
          <p><?php echo substr($prop['deskripsi_listing'],0,300);?></p>
          <p>
            <!-- <a href="#" onclick="add_compare(<?php echo $prop['id'];?>);return false">Bandingkan</a> |  -->
            <!-- <a href="#" onclick="add_bookmark(<?php echo $prop['id'];?>);return false">Simpan</a> |  -->
            <a href="#myModal" data-toggle="modal" class="linkModal" onclick="set_value('<?php echo $prop['id_member'] . '/' . $prop['id']; ?>')">Kirim Pesan ke Pengiklan</a>
          </p>
          <p>Di Iklankan oleh: <?php echo $prop['nama_lengkap'] . ". Telephon: " . $prop['telp'];?></p>
       </div>
    </div>
    <hr />
    <?php
       }
       ?>
    <div class="pagination" align="center">
       <ul>
          <?php echo $this->pagination->create_links(); ?>
       </ul>
    </div>

	</div>
</div>

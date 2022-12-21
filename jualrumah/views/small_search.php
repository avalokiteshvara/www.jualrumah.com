<style>
/* Removes the default 20px margin and creates some padding space for the indicators and controls */
.carousel {
  margin-bottom: 0;
	padding: 10px 10px 30px 20px;
}
/* Reposition the controls slightly */
.carousel-control {
	left: -5px;
}
.carousel-control.right {
	right: -5px;
}
/* Changes the position of the indicators */
.carousel-indicators {
	right: 50%;
	top: auto;
	bottom: 0px;
	margin-right: -19px;
}
/* Changes the colour of the indicators */
.carousel-indicators li {
	background: #c0c0c0;
}
.carousel-indicators .active {
background: #333333;
}

</style>

<script type="text/javascript">

	function change_view(){
		var sel = document.getElementById('view');
		window.location.href = "<?php echo base_url().'search/view/' ?>" + sel.options[sel.selectedIndex].value;
	}

	function sort(){

		var sel = document.getElementById('order');
		if(sel.options[sel.selectedIndex].value != 'Pilih'){
			window.location.href = "<?php echo base_url().'search/sort/' ?>" + sel.options[sel.selectedIndex].value;
		}
	}

	function add_bookmark(id){

    	$.ajax({
    		url:'<?php echo base_url() . 'member/bookmark/insert/';?>' + id,
    		type:"POST",
    		async   : false,
    		cache   : false,
    		success : function(msg){
    			if(msg != 'NEED_LOGIN'){
    				alert(msg);
    			} else{
    				window.location.href = "<?php echo base_url().'member/login' ?>";
    			}

    		}
    	})
    }

    function add_compare(id){
    	$.ajax({
    		url:'<?php echo base_url() . 'compare/insert/';?>' + id,
    		type:"POST",
    		async:false,
    		cache:false,
    		success : function(msg){
    			if(msg!='ERROR:COMPARE_BOX_FULL'){
    				alert(msg);
    			}else{
    				alert('Hanya bisa membandingkan 3 properti!');
    			}
    		}
    	})
    }

    function clear_text(){
    	document.getElementById('nama').value="";
			document.getElementById('telp').value="";
			document.getElementById('email').value="";
			document.getElementById('pesan').value="";
    }

    var myVal;
    function set_value(val){
    	myVal = val;
    	clear_text();
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


<div class="row">
	<div class="span4">

  <!--<?php echo $last_query;?> -->


		<div class="row">
			<h4 class="span3 well">Ganti lokasi dan kriteria</h4>
			<div class="span3 well">

				<form class="" method="post" style="margin-bottom: 0px;" action="<?php echo base_url()?>search/show" />
				    <fieldset>
						<div class="row">
							<div class="span3">

								<div class="control-group">
									 <label for="lokasi" class="control-label">Lokasi</label>
									 <div class="controls">
											<input name="lokasi" type="text" value="<?php echo $this->session->userdata('src_nama_lokasi')?>" placeholder="" id="lokasi" class="" style="width:85%" required=""/>
											<input id="lokasi_id" type="hidden" name="lokasi_id" value="<?php echo $this->session->userdata('src_id_lokasi')?>"/>
									 </div>
								</div>
								<!-end lokasi->

								<div class="control-group">
									<label for="focusedInput" class="control-label">Jual/Sewa</label>
										<div class="controls">
											<select name="tipe_listing" id="tipe_listing" class="input-large focused">
												<option value="any">Semua</option>
												<option <?php if(isset($search_data['tipe_listing'])){ echo $search_data['tipe_listing'] == "jual" ? 'selected="selected"' : '';} ?>  value="jual">Jual</option>
		        						<option <?php if(isset($search_data['tipe_listing'])){ echo $search_data['tipe_listing'] == "sewa" ? 'selected="selected"' : '';} ?>  value="sewa">Sewa</option>
											</select>
										</div>
								</div>

								<div class="control-group">
									<label for="focusedInput" class="control-label">Tipe Prop.</label>
										<div class="controls">
											<select name="tipe_properti" id="tipe_properti" class="input-large focused">
													<option value="any">Semua</option>
													<?php foreach($m_jns_properti as $data_jns_properti){ ?>
				    								<optgroup label="<?php echo $data_jns_properti['nama'];?>">
				    								<?php  echo print_recursive_list($data_jns_properti['child'],isset($search_data['id_tipe_properti']) ? $search_data['id_tipe_properti'] : NULL); ?>
				    								</optgroup>
	    									    <?php	}  ?>
											</select>
										</div>
								</div>

								<div class="control-group">
									<label for="focusedInput" class="control-label">Kmr Tidur</label>
									<div class="controls">

										<select name="jml_kamar_tidur" id="jml_kamar_tidur" class="input-large focused">
											<option value="any">Semua</option>

											<?php
											for($i = 1;$i <= 10 ;$i++){
											 	if ($i == 10){ 	?>

		                  <option <?php if(isset($search_data['jml_kamar_tidur'])){ echo $search_data['jml_kamar_tidur'] == "10" ? 'selected="selected"' : ''; } ?> value="10">10+ <?php echo 'kamar tidur'; ?></option>
											<?php	}else{	?>
											<option <?php if(isset($search_data['jml_kamar_tidur'])){ echo $search_data['jml_kamar_tidur'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"> <?php echo $i . ' kamar tidur'; ?>  </option>

		                     <?php	}
		                  }	?>
										</select>
									</div>
								</div>

								<div class="control-group">
									<label for="focusedInput" class="control-label">Harga Min.</label>
									<div class="controls">
										<input name = "harga_min" type="text" value="<?php echo isset($harga_min) ? $harga_min : '' ?>" placeholder="" id="focusedInput" class="input-large-medium" />
									</div>
								</div>

								<div class="control-group">
									<label for="focusedInput" class="control-label">Harga Max.</label>
									<div class="controls">
										<input name = "harga_max" type="text" value="<?php echo isset($harga_max) ? $harga_max : '' ?>" placeholder="" id="focusedInput" class="input-large-medium" />
									</div>
								</div>

								<!-- <div class="control-group">
									<label for="focusedInput" class="control-label">Status</label>
									<div class="controls">
										<select name="has_sold" id="has_sold" class="input-large focused">
											<option value="any">Semua</option>
											<option <?php if(isset($search_data['has_sold'])){ echo $search_data['has_sold'] == "Y" ? 'selected="selected"' : '';} ?>  value="Y">Terjual</option>
	        						<option <?php if(isset($search_data['has_sold'])){ echo $search_data['has_sold'] == "N" ? 'selected="selected"' : '';} ?>  value="N">Belum Terjual</option>
										</select>
									</div>
								</div> -->
								<input type="hidden" name="has_sold" value="N" />

							</div>
							<div class="row">
								<div class="span2 pull-right" style="margin-top: 10px;">
								    <button class="btn btn-primary pull-right" type="submit" name="search">Search</button>
								</div>
							</div>
						</div>
				    </fieldset>
				</form>
			</div>
		</div>


		<div class="row">
		<h4 class="span3 well">Tipe Property</h4>
			<div class="span3 well">

				<!-- <h4>Type Properti:</h4> -->
				<ul class="nav">
					<?php foreach($count_based_tipe_property->result() as $r_tipe_properti) {?>
						<li><a href="<?php echo base_url()."search/tipe/".$r_tipe_properti->id; ?>"> <?php echo $r_tipe_properti->nama ." (".$r_tipe_properti->cnt.")" ?></a> </li>

					<?php }?>
				</ul>
			</div>
		</div>


		<div class="row">
			<div class="span3">
				<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $facebook_link;?>&amp;width=260&amp;height=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:300px;" allowTransparency="true"></iframe>
			</div>
		</div>


	</div>

	<div class="span8">
		<div class="row">
			<h4 class="span7 well" style="width: 580px">Iklan Properti Premium</h4>
			<div class="span8">
				<?php if($random_premium->num_rows() == 0){ ?>
				<div class="alert alert-success">
					<a class="close" data-dismiss="alert" href="#">x</a>
					Jadikan iklan anda mudah ditemukan dengan menjadikannya premium<br />
					dengan hanya 200 ribu untuk 90 hari
				</div>
				<?php }else{ ?>
					<ul class="thumbnails">


						 <div id="myCarousel" class="carousel slide">

							 <!-- <ol class="carousel-indicators">
									 <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
									 <li data-target="#myCarousel" data-slide-to="1"></li>
									 <li data-target="#myCarousel" data-slide-to="2"></li>
							 </ol> -->

							 <!-- Carousel items -->
							 <div class="carousel-inner">

								 <?php
								 $i = 1;
								 $total_rows = $random_premium->num_rows();

								 $open_tag_active = '<div class="item active">
																				<div class="row-fluid">' . PHP_EOL;

								 $open_tag        = '<div class="item">
																			 <div class="row-fluid">' . PHP_EOL;


								 $close_tag       = '  </div>
																		 </div>';

								 foreach ($random_premium->result() as $r_lastupload) {
									 //jika $i == 1 then
									 //        write open_tag
									 //        write data
									 //        jika $i = $total_rows then close_tag
									 // else jika $i % 4 then
									 //        write data
									 //        write close_tag
									 //        if($i != total_rows) then write open_tag
									 // else (jika $i < $total_rows) then
									 //        write data
									 // else
									 //      write data
									 //      write close_tag

									 if($i == 1){
										 echo $open_tag_active;
										 echo '<div class="span3">
														 <a href="'. base_url().'property/show/' . $r_lastupload->id .'" class="thumbnail mini_property">
															 <img width="130" height="80" src="' . image(base_url() . "media/" . $r_lastupload->file_name ,'thumb') . '" />
															 <h5>' . substr(strtoupper($r_lastupload->judul_listing),0,18) . '</h5>
															 <h6>' . $r_lastupload->harga . '</h6>
															 <h6>' . $r_lastupload->lokasi . '</h6>
														 </a>
													 </div>';

										 if($i == $total_rows){
											 echo $close_tag;
										 }
									 }elseif(($i % 4) == 0) {
										 echo '<div class="span3">
														 <a href="'. base_url().'property/show/' . $r_lastupload->id .'" class="thumbnail mini_property">
															 <img width="130" height="80" src="' . image(base_url() . "media/" . $r_lastupload->file_name ,'thumb') . '" />
															 <h5>' . substr(strtoupper($r_lastupload->judul_listing),0,18) . '</h5>
															 <h6>' . $r_lastupload->harga . '</h6>
															 <h6>' . $r_lastupload->lokasi . '</h6>
														 </a>
													 </div>';
										 echo $close_tag;

										 if($i != $total_rows){
											 echo $open_tag;
										 }

									 }elseif($i < $total_rows){
										 echo '<div class="span3">
														 <a href="'. base_url().'property/show/' . $r_lastupload->id .'" class="thumbnail mini_property">
															 <img width="130" height="80" src="' . image(base_url() . "media/" . $r_lastupload->file_name ,'thumb') . '" />
															 <h5>' . substr(strtoupper($r_lastupload->judul_listing),0,18) . '</h5>
															 <h6>' . $r_lastupload->harga . '</h6>
															 <h6>' . $r_lastupload->lokasi . '</h6>
														 </a>
													 </div>';
									 }else{
										 echo '<div class="span3">
														 <a href="'. base_url().'property/show/' . $r_lastupload->id .'" class="thumbnail mini_property">
															 <img width="130" height="80" src="' . image(base_url() . "media/" . $r_lastupload->file_name ,'thumb') . '" />
															 <h5>' . substr(strtoupper($r_lastupload->judul_listing),0,18) . '</h5>
															 <h6>' . $r_lastupload->harga . '</h6>
															 <h6>' . $r_lastupload->lokasi . '</h6>
														 </a>
													 </div>';
										 echo $close_tag;
									 }

									 $i++;
								 } ?>



							 </div><!--/carousel-inner-->

							 <a class="left carousel-control" href="#myCarousel" data-slide="prev"></a>
							 <a class="right carousel-control" href="#myCarousel" data-slide="next"></a>
							 </div><!--/myCarousel-->

					</ul>
				<?php } ?>
			</div>

		</div>

		<div class="row">
			<div class="span4">
				<div class="pull-left">
					Tampilan  :
					<select id="view" name="view" class="span2" onchange="change_view()">
						<option value="search" />Details
						<option selected="selected" value="small_search" />Small List
					</select>
				</div>
			</div>

			<!-- <div class="span4 select_height">	Showing 1 - 10 of <?php echo $jumlah_pencarian ?> results</div> -->
			<div class="span4">
				<div class="pull-right">
					Urutkan :
					<select id="order" name="order" class="span3" onchange="sort()">
						<option value="Pilih" />Pilih
						<!--
							// harga_asc = harga asc
					        // harga_desc = harga desc
					        // lihat_asc = total_dilihat asc
					        // lihat_desc = total_dilihat desc

						-->

						<option <?php if(isset($search_data['order'])){ echo $search_data['order'] == "harga_asc" ? 'selected="selected"' : '';} ?> value="harga_asc" />Harga: Rendah ke Tinggi
						<option <?php if(isset($search_data['order'])){ echo $search_data['order'] == "harga_desc" ? 'selected="selected"' : '';} ?> value="harga_desc" />Harga: Tinggi ke Rendah

						<option <?php if(isset($search_data['order'])){ echo $search_data['order'] == "lihat_asc" ? 'selected="selected"' : '';} ?> value="lihat_asc" />Dilihat: Sedikit ke Banyak
						<option <?php if(isset($search_data['order'])){ echo $search_data['order'] == "lihat_desc" ? 'selected="selected"' : '';} ?> value="lihat_desc" />Dilihat: Banyak ke Sedikit

					</select>
				</div>
			</div>
		</div>

		<ul class="thumbnails">

	<?php if($arr_pencarian->num_rows() == 0 ): ?>
		<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a>Hasil pencarian kosong!.
		</div>
	<?php endif;?>
		<br>
		<br>


		<?php foreach ($arr_pencarian->result() as $row_pencarian) { ?>

			<li class="span2">
				<div class="thumbnail mini_property">
					<a href="<?php echo base_url().'property/show/' . $row_pencarian->id; ?>"><h5 align="center"><?php echo substr($row_pencarian->judul_listing,0,16);?></h5> </a>
					<a href="<?php echo base_url().'property/show/' . $row_pencarian->id; ?>" class="thumbnail <?php echo ($row_pencarian->has_sold == 'Y') ? 'property_sold' : ''  ?>"><img src="<?php echo image(base_url() . "media/" . $row_pencarian->file_name,'thumb') ?>" height="80" width="130"  /></a>


					<h5>Rp.<?php echo $row_pencarian->harga.' '.$row_pencarian->satuan_harga;?></h5>

					<?php
						if($row_pencarian->id_tipe_properti != 5){
							if($row_pencarian->new_house == 'Y'){
								echo '<h6>Status: Baru</h6>';
							}else{
								echo '<h6>Status: Bekas</h6>';
							}

							echo '<h6>Kamar tidur : '. $row_pencarian->jml_kamar_tidur .'</h6>';
						}
				?>
				</div>
			</li>




		<?php
			}
		?>

		</ul>
		<div class="pagination" align="center">
			<ul>
				<?php echo $this->pagination->create_links(); ?>
			</ul>
		</div>

	</div>

</div>

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

<script>
    var options = {
      url: function(term){
        return "<?php echo site_url('search/lokasi?')?>term=" + term
      },
      getValue: "name",
      list: {
        match: {
          enabled: true
        },
        onSelectItemEvent: function() {
    			var value = $("#lokasi").getSelectedItemData().lokasi_id;

    			$("#lokasi_id").val(value).trigger("change");
    		}
      }
    };

    $("#lokasi").easyAutocomplete(options);

		$(document).ready(function() {
				 $('#myCarousel').carousel({
					 interval: 5000
			 })
		 });
</script>

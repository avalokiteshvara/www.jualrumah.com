<script type="text/javascript">
   function send_comment(){
   	$.ajax({
   		url : '<?php echo base_url() . 'property/insert_comment/'.$listing_id;?>',
              data : $('form').serialize(),
              type: "POST",
              success : function(comment){
                  var $tableComment = $('#tableComment');
                  var $error = comment.indexOf('#error');

                  if($error != -1){
                  	alert(comment);
                  }else{
                  	$(comment).prependTo($tableComment);
                  }

                  document.getElementById('captcha_text').value="";
                  get_captcha();

              }
   	})
   }

   function get_captcha(){
      	$.ajax({
      		url:'<?php echo base_url() . 'property/generate_captcha/ajax';?>',
      		type:"POST",
      		async   : false,
      		cache   : false,
      		success : function(capcha_link){
      			$('#captcha_div').replaceWith('<div style="margin:2px"  id="captcha_div">' + capcha_link + '</div>');

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

   function send_msg(){
   	$.ajax({
   		url:'<?php echo base_url() . 'member/message/send';?>',
   		type:"POST",
   		data : $('form').serialize(),
   		async: false,
   		cache   : false,
      		success: function(msg){
       		document.getElementById('nama').value="";
       		document.getElementById('telp').value="";
       		document.getElementById('email').value="";
       		document.getElementById('pesan').value="";

      			alert(msg);
      		}
   	})
   }

</script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDy5ePPPOnm2Ix6_MU7SGsUX4QzrHfH1t4&sensor=false"></script>
<script type="text/javascript">
   //<![CDATA[

        // global "map" variable
         var map = null;
         var marker = null;


         function initialize() {


           var myLatLng = {lat: <?php echo $property_data->lat;?>, lng: <?php echo $property_data->lng?>};
           // create the map
           var myOptions = {
             zoom: 15,
             center: new google.maps.LatLng(<?php echo $property_data->lat;?>, <?php echo $property_data->lng?>),
             mapTypeControl: true,
             mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
             navigationControl: true,
             mapTypeId: google.maps.MapTypeId.ROADMAP
           }


           map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

           var marker = new google.maps.Marker({
               position: myLatLng,
               map: map,
               title: 'Hello World!'
             });

   					google.maps.event.trigger(map, 'resize');

   	        $('a[href="#tab_map"]').on('shown', function(e) {
   	            google.maps.event.trigger(map, 'resize');
   	        });

   	        $('#myTab a[href="#tab_map"]').on('shown', function(){
   	            google.maps.event.trigger(map, 'resize');
   	            map.setCenter(latlng);
   	        });
         }


         //]]>

       window.onload = initialize;

   		// $("a[href='#my-tab']").on('shown.bs.tab', function(){
   		//   google.maps.event.trigger(map, 'resize');
   		// });
</script>
<style>
   .tab-content > .tab-pane {
   display: block;
   height:0;
   overflow:hidden;
   }
   .tab-content > .active {
   display: block;
   height:auto;
   }
</style>
<div class="row">
   <div class="span8">
      <div class="row">
         <div class="span5">
            <?php if($property_data->has_sold == 'Y'):?>
            <h2 style="color:#FF0000">Status: TERJUAL</h2>
            <?php endif;?>
            <h2><?php echo substr($property_data->judul_listing,0,30); ?></h2>
            <h6><?php echo $lokasi_listing?></h6>
            <div id="people_viewing"><strong>Properti ini telah dilihat <?php echo $property_data->total_dilihat;?> kali</strong></div>
         </div>
         <div class="span3 text-right">
            <h2>Rp.<?php echo $property_data->harga .' '.$property_data->satuan_harga; ?></h2>
         </div>
      </div>
      <div class="row">
         <br />
         <div class="span8">
            <!-- Start slideshow-carousel -->
            <div id="showcase-loader">
            </div>
            <div id="showcase" class="showcase">
               <?php foreach ($image_list->result() as $image_row) { ?>
               <!-loop code here->
               <div class="showcase-slide">
                  <div class="showcase-content">
                     <img src="<?php echo base_url() .'media/' . $image_row->file_name; ?>" alt="01" />
                  </div>
                  <div class="showcase-thumbnail">
                     <img src="<?php echo image(base_url()."media/" . $image_row->file_name,"thumb"); ?>" alt="01" height="116" width="116"/>
                     <div class="showcase-thumbnail-cover"></div>
                  </div>
               </div>
               <!-end loop->
               <?php }?>
            </div>
            <!-- // end of slideshow-carousel -->
         </div>
      </div>
      <div class="row">
         <br />
         <div class="span8">
            <ul class="nav nav-pills">
               <li class="<?php echo ($active_tab == 'descriptions') ? 'active':''?>"><a href="#tab_description" data-toggle="tab">Deskripsi</a></li>
               <!-- <li class="<?php echo ($active_tab == 'comments') ? 'active':''?>"><a href="#tab_comments" data-toggle="tab">Comments <span><?php echo $comments_count;?></span></a></li> -->
               <li class="<?php echo ($active_tab == 'map') ? 'active':''?>"><a href="#tab_map" data-toggle="tab">Peta</span></a></li>
							 <li class="<?php echo ($active_tab == 'near_property') ? 'active':''?>"><a href="#tab_near_property" data-toggle="tab">Properti sejenis disekitar</span></a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane <?php echo ($active_tab == 'descriptions') ? 'active':''?>" id="tab_description">
                  <!-- <h4>Description</h4> -->
                  <p><?php echo $property_data->deskripsi_listing; ?>.</p>
                  <h4>Features</h4>
                  <div class="row">
                     <div class="span3">
                        <ul>
                           <li><?php echo $property_data->jml_kamar_tidur;?> Kamar Tidur</li>
                           <li><?php echo $property_data->jml_kamar_mandi;?> Kamar Mandi</li>
                           <li><?php echo $property_data->jml_kamar_pembantu;?> Kamar Tidur Pembantu</li>
                           <li>Listrik <?php echo $property_data->pasokan_listrik;?> watt</li>
                        </ul>
                     </div>
                     <div class="span5">
                        <ul>
                           <li>Luas bangunan: <?php echo $property_data->luas_bangunan;?></li>
                           <li>Dimensi bangunan: <?php echo $property_data->dimensi_bangunan;?></li>
                           <li>Luas tanah: <?php echo $property_data->luas_tanah;?></li>
                           <li>Dimensi tanah: <?php echo $property_data->dimensi_tanah;?></li>
                        </ul>
                     </div>
                     <!-- <div class="span4">
                        <ul>
                        	<li>Kapasitas Garasi <?php echo $property_data->jml_garasi;?> Mobil</li>
                        	<li>Kapasitas Parkir <?php echo $property_data->jml_carport;?> Mobil</li>
                        </ul>
                        </div> -->
                  </div>


               </div>
               <div class="tab-pane <?php echo ($active_tab == 'comments') ? 'active':''?>" id="tab_comments">
                  <div class="row">
                     <div class="span 8">
                        <?php if($this->session->userdata('sudah_login') == 1): ?>
                        <!-- <form method="POST" action=""  class="form-inline span6" />
                           <fieldset>
                           	<div class="control-group">
                           		<div class="controls">
                           			<textarea name="comment" rows="5" id="comment" class="input-xlarge span7"></textarea>
                           		</div>
                           	</div>
                           	<div class="control-group">
                           		<div style="margin:2px"  id="captcha_div">
                           			<?php echo $captcha_image; ?>
                           		</div>
                           		<input style="font-size:20px" type="text" width="5px" name="captcha" id="captcha_text"/>
                           		<button class="btn btn-primary btn-large pull-right" type="submit" onclick="send_comment();return false;" >Kirim</button>
                           	</div>
                           </fieldset>
                           </form> -->
                        <?php else:?>
                        <!-- <div class="alert alert-error">
                           <a class="close" data-dismiss="alert" href="#">x</a>Untuk memberikan komentar, silahkan login dahulu
                           </div> -->
                        <?php endif;?>
                     </div>
                  </div>
                  <div class="row">
                     <div class="span 8">
                        <div style="margin: 4px; width: 590px;">
                           <!-- <table width="95%" border="0" id="tableComment">
                              <!-START loop here->
                              <?php foreach ($comments->result() as $r_comments) {
                                 $warna = '#F1F1F1';
                                 if(strpos($r_comments->sender, 'Pengiklan') !== false){
                                 	$warna = '#99CCFF';
                                 }

                                 ?>

                              	<tr>
                              		<th align="left" bgcolor="<?php echo $warna;?>"><?php echo $r_comments->sender; ?></th>
                              		<th align="right" bgcolor="<?php echo $warna;?>"><?php echo $r_comments->inserted_dtime; ?></th>
                              	</tr>
                              	<tr>
                              		<td colspan="2" ><blockquote><?php echo $r_comments->comment;?></blockquote> </td>
                              	</tr>
                              <?php } ?>
                              <!-END loop here->
                              </table> -->
                        </div>
                     </div>
                  </div>
                  <div class="pagination" align="center">
                     <ul>
                        <?php echo $this->pagination->create_links(); ?>
                     </ul>
                  </div>
               </div>
               <div class="tab-pane <?php echo ($active_tab == 'map') ? 'active':''?>" id="tab_map">
                  <div class="row">
                     <div class="span 8">
                        <div id="map_canvas" style="width:625px; height:400px;"></div>
                     </div>
                  </div>
               </div>
							 <div class="tab-pane <?php echo ($active_tab == 'near_property') ? 'active':''?>" id="tab_near_property">
                  <div class="row">
                     <div class="span 8">
											 <?php if($property_data->lat != null){ ?>
											 <h4>Properti sejenis disekitarnya</h4>
											 <ul class="thumbnails">
													<?php foreach ($get_near_properties->result_array() as $near_prop) {
														 $this->db->where('listing_id',$near_prop['id']);
														 $this->db->limit(1,0);
														 $img = $this->db->get('tbl_images');

														 $gambar = "no_images-116x116.jpg";
														 if($img->num_rows() > 0){
															 $gambar = $img->row()->file_name;
														 }
														 ?>
													<li class="span2">
														 <div class="thumbnail mini_property" style="height:200px">
																<a href="<?php echo site_url('property/show/' . $near_prop['id'])?>"><img src="<?php echo site_url('media/'. $gambar)?>" img width="130" height="90" alt=""></a>
																<h5><?php echo $near_prop['judul_listing']?></h5>
																<h5>Rp<?php echo $near_prop['harga']?></h5>
																<h5><?php echo $near_prop['lokasi']?></h5>
																<!-- <h5><?php echo round($near_prop['jarak'],2)?></h5> -->
																<!-- <p><a href="map_properties.html">7 bedroom house</a><br>The Vineyard, Richmond, TW10</p> -->
														 </div>
													</li>
													<?php } ?>
											 </ul>
											 <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="span4 pull-right" id="portamento_container">
      <br>
      <?php
         foreach ($pengiklan_data as $r_pengiklan) {
         	# code...
         }


         ?>
      <div id="" class="center">
         <a href="listings.html"><img width="100" height="100" alt="" src="<?php echo !empty($r_pengiklan->photo) ? base_url() .'avatar/'. $r_pengiklan->photo : base_url() . 'avatar/' . 'no_images.jpg';?>" /></a>
         <p><?php echo $r_pengiklan->nama_depan . ' ' . $r_pengiklan->nama_belakang; ?><br /><?php echo $r_pengiklan->alamat; ?></p>
         <h4>Hubungi Pengiklan</h4>
         <form method="POST" action=""  class="form-inline" />
            <fieldset>
               <input type="hidden" name="penerima" value="<?php echo $property_data->id_member; ?>">
               <input type="hidden" name="id_listing" value="<?php echo $property_data->id; ?>">
               <div class="control-group">
                  <div class="controls">
                     <input type="text" name="nama" id="nama" placeholder="Nama Anda" class="input-large" />
                  </div>
               </div>
               <div class="control-group">
                  <div class="controls">
                     <input type="text" name="telp" id="telp" placeholder="No.Telp" class="input-large" />
                  </div>
               </div>
               <div class="control-group">
                  <div class="controls">
                     <input type="text" name="email" id="email" placeholder="Email" class="input-large" />
                  </div>
               </div>
               <div class="control-group">
                  <div class="controls">
                     <textarea name="pesan" rows="3" id="pesan" class="input-xlarge"></textarea>
                  </div>
               </div>
               <div class="form-actions">
                  <button class="btn btn-primary btn-large" type="submit" onclick="send_msg();return false;" >Kirim Pesan</button>
                  <!-- <button class="btn btn-primary btn-large" onclick="add_compare(<?php echo $property_data->id;?>);return false">Bandingkan</button> -->
               </div>
            </fieldset>
         </form>
      </div>
      <div class="row center">
         <div class="span3">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $facebook_link;?>&amp;width=260&amp;height=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:300px;" allowTransparency="true"></iframe>
         </div>
      </div>
   </div>
</div>

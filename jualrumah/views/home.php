<style type="text/css">
   .span4-mod {
     width: 350px;
   }

   .span3-mod{
     width: 300px;
   }

   .span8-mod {
     width: 580px;
   }
</style>
<div class="row">
   <div class="span4 well lform.depan">
      <form class="form-inline" method="post" action="<?php echo base_url()?>search"/>
         <fieldset>
            <div class="row">
               <div class="span4">
               </div>
               <div class="span4">
                  <div class="row">
                     <div class="span4">
                        <div class="control-group">
                           <label for="lokasi" class="control-label">Lokasi</label>
                           <div class="controls">
                              <input name="lokasi" id="lokasi" type="text" value="" placeholder=""  class="" style="width:93%" required="" />
                              <input name="lokasi_id" id="lokasi_id" type="hidden"  />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="span4">
                        <label for="focusedInput" class="control-label"><?php echo 'Jual/Sewa';?></label>
                        <div class="controls">
                           <select name="tipe_listing" id="tipe_listing" class="" style="width:103%;margin-bottom:10px">
                              <option value="any">Semua</option>
                              <option value = "jual">Jual</option>
                              <option value = "sewa">Sewa</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <!-- class="row" -->
                  <div class="row">
                     <div class="span2 ">
                        <div class="control-group">
                           <label for="focusedInput" class="control-label"><?php echo 'Tipe Properti'; ?></label>
                           <div class="controls">
                              <select name="tipe_properti" id="tipe_properti" class="input-medium focused">
                                 <?php foreach($m_jns_properti as $data_jns_properti) { ?>
                                 <optgroup label="<?php echo $data_jns_properti['nama'];?>">
                                    <?php  echo print_recursive_list($data_jns_properti['child']); ?>
                                 </optgroup>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="span2">
                        <label for="focusedInput" class="control-label"><?php echo 'Jumlah kamar tidur'; ?></label>
                        <div class="controls">
                           <select name="jml_kamar_tidur" id="jml_kamar_tidur" class="input-medium focused">
                              <option value="any">Semua</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5+">5+</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="span2">
                        <div class="control-group">
                           <label for="focusedInput" class="control-label"><?php echo 'Harga Min.'; ?></label>
                           <div class="controls">
                              <input name = "harga_min" type="text" value="" placeholder="" id="focusedInput" class="input-small-medium" />
                           </div>
                        </div>
                     </div>
                     <div class="span2">
                        <label for="focusedInput" class="control-label"><?php echo 'Harga Max.' ;?></label>
                        <div class="controls">
                           <input name = "harga_max" type="text" value="" placeholder="" id="focusedInput" class="input-small-medium" />
                        </div>
                     </div>
                  </div>
                  <input name="has_sold" value="N" type="hidden">
               </div>
               <div class="row">
                  <div class="span2 pull-right" style="margin-top: 10px;">
                     <button class="btn btn-primary pull-right" type="submit">Search</button>
                  </div>
               </div>
            </div>
         </fieldset>
      </form>
   </div>
   <div class="span7 home_carousel no_margin_left pull-right">
      <!-- Start slideshow-carousel -->
      <div id="carousel-loader">
      </div>
      <div id="carousel" class="showcase">
         <?php foreach ($slideshow->result() as $r_slideshow) { ?>
         <div class="showcase-slide">
            <div class="showcase-content">
               <a href="<?php echo base_url().'property/show/'.$r_slideshow->id; ?> " target ="_blank"><img src="<?php echo image(base_url() . "media/" . $r_slideshow->file_name,'slideshow') ?>" height="326" width="590"  /></a>
            </div>
            <div class="showcase-caption carousel-caption">
               <a href="<?php echo base_url().'property/show/'.$r_slideshow->id; ?> " target ="_blank">
                  <h4><?php echo substr($r_slideshow->judul_listing,0,20); ?></h4>
                  <p><?php echo substr($r_slideshow->deskripsi_listing,0,50); ?></p>
               </a>
            </div>
         </div>
         <?php }?>
      </div>
      <!-- // end of slideshow-carousel -->
   </div>
</div>
<div class="row">
   <div class="span4-mod">
      <div class="row">
         <!-- <img src="<?php echo load_image('uploads/iklan-1.jpg',330,220)?>" style="margin-left:20px;margin-bottom:20px"/> -->
      </div>
      <div class="row">
         <h4 class="span4 well">Tipe Property</h4>
         <div class="span4 well">
            <ul class="nav">
               <?php foreach($count_based_tipe_property->result() as $r_tipe_properti) {?>
               <li><a href="<?php echo base_url()."search/tipe/".$r_tipe_properti->id; ?>"> <?php echo $r_tipe_properti->nama ." (".$r_tipe_properti->cnt.")" ?></a> </li>
               <?php }?>
            </ul>
         </div>
      </div>

   </div>
   <div class="span8-mod">
      <p style="padding:10px">
         Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
      </p>
      <!-- <br>
         <h3><span>Top 10</span> Properti paling banyak dilihat</h3>
         <table class="table table-bordered table-striped">
           <thead>
             <tr>
               <th>Deskripsi</th>
               <th>Lokasi</th>
               <th>Harga</th>
               <th>&nbsp;</th>
             </tr>
           </thead>
           <tbody>
         <?php foreach ($arr_mostviewed->result() as $r_mostviewed) { ?>
             <tr>
               <td><a href="<?php echo base_url().'property/show/'.$r_mostviewed->id; ?> " target ="_blank"><?php echo $r_mostviewed->description;?></a></td>
               <td><?php echo $r_mostviewed->lokasi;?></td>
               <td>Rp<?php echo $r_mostviewed->harga;?></td>
               <td><a href="<?php echo base_url().'property/show/'.$r_mostviewed->id; ?> " target ="_blank">View</a></td>
             </tr>
         <?php } ?>
           </tbody>
         </table> -->
   </div>
</div>
<div class="row">
   <!-- <br /> -->
   <div class="span4-mod">
   </div>
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
</script>

<?php
?>

<!-- 

# kamar tidur: studio,1 kamar tidur .. 10+ kamar tidur
Jumlah Kamar Pembantu: 1 kamar .. 10+ kamar
Jumlah Kamar Mandi: 1 kamar mandi .. 10+ kamar mandi
Jumlah Garasi: 1 mobil .. 10+ mobil
Jumlah Carport: 1 mobil .. 10+ mobil

Jumlah Saluran Telepon: 1 saluran .. 10+ saluran
Jumlah Lantai: 1 .. 50 
Kondisi: tak berperabot, sebagian, lengkap
* Pasokan Listrik: {text}
Menghadap (Pintu Depan): utara, timur laut, barat laut,timur, barat, tenggara,barat daya , selatan


-->
<div class="row">
    <div class="span12">
        <div class="page-header">
    		<h1><?php echo 'Tambah Baru';?></h1>
    	</div>
    </div>
</div>

<!-- jika ada error, maka tampilkan error message -->
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

      <form class="form-horizontal" method="post" action="<?php echo base_url()?>member/listing/additional_info/<?php echo $listing_id; ?>/submit/<?php echo $status; ?>" accept-charset="UTF-8">
           	<!-- jumlah kamar tidur -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label">(*) <?php echo 'Jumlah tempat tidur'; ?></label>
        	   <div class="controls">
        			<select name="jml_kamar_tidur" id="jml_kamar_tidur" class="input-medium focused">
        			<option value=""><?php echo '[Pilih]';?></option>
        			      
        			      <?php 
        			      for($i = 0;$i <= 10 ;$i++){
                             if($i == 0){
                               ?>
                                  <option  <?php if(isset($data['jml_kamar_tidur'])){ echo $data['jml_kamar_tidur'] == "0"  ? 'selected="selected"' : ''; } ?> value="0">Studio</option>
                               <?php          
                             }elseif ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_kamar_tidur'])){ echo $data['jml_kamar_tidur'] == "10" ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php echo 'kamar tidur'; ?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_kamar_tidur'])){ echo $data['jml_kamar_tidur'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"> <?php echo $i . ' kamar tidur'; ?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>
        	<!-- end jumlah kamar tidur -->
        	
        	<!-- jumlah kamar pembantu -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Jumlah kamar pembantu';?></label>
        	   <div class="controls">
        			<select name="jml_kamar_pembantu" id="jml_kamar_pembantu" class="input-medium focused">
        			    <option value=""><?php echo '[pilih]'; ?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_kamar_pembantu'])){ echo $data['jml_kamar_pembantu'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+</option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_kamar_pembantu'])){ echo $data['jml_kamar_pembantu'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' kamar tidur' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end jumlah kamar pembantu -->
        	
        	<!-- jumlah kamar mandi -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Jumlah kamar mandi'; ?></label>
        	   <div class="controls">
        			<select name="jml_kamar_mandi" id="jml_kamar_mandi" class="input-medium focused">
        			    <option value=""><?php echo '[pilih]';?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_kamar_mandi'])){ echo $data['jml_kamar_mandi'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php echo 'Kamar';?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_kamar_mandi'])){ echo $data['jml_kamar_mandi'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' kamar' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end jumlah kamar mandi -->
        	
        	<!-- jumlah garasi -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Jumlah Garasi'; ?></label>
        	   <div class="controls">
        			<select name="jml_garasi" id="jml_garasi" class="input-medium focused">
        			    <option value=""><?php echo  '[pilih]';?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_garasi'])){ echo $data['jml_garasi'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php echo 'mobil'?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_garasi'])){ echo $data['jml_garasi'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' ' . 'mobil' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end jumlah garasi -->
        	
        	<!-- kapasitas parkir -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Kapasitas Parkir'; ?></label>
        	   <div class="controls">
        			<select name="jml_carport" id="jml_carport" class="input-medium focused">
        			    <option value=""><?php echo  '[pilih]';?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_carport'])){ echo $data['jml_carport'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php echo 'mobil'?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_carport'])){ echo $data['jml_carport'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' ' . 'mobil' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end kapasitas parkir -->
        	
        	<!-- jumlah saluran telp -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Jumlah saluran telp'; ?></label>
        	   <div class="controls">
        			<select name="jml_saluran_telp" id="jml_saluran_telp" class="input-medium focused">
        			    <option value=""><?php echo  '[pilih]';?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_saluran_telp'])){ echo $data['jml_saluran_telp'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php 'saluran'; ?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_saluran_telp'])){ echo $data['jml_saluran_telp'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' saluran' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end jumlah saluran telp -->
        	
        
        	<!-- jumlah lantai  -->
        	<div class="control-group">
        	   <label for="focusedInput" class="control-label"><?php echo 'Jumlah lantai'; ?></label>
        	   <div class="controls">
        			<select name="jml_lantai" id="jml_lantai" class="input-medium focused">
        			    <option value=""><?php echo  '[pilih]';?></option>
        			    <?php 
        			      for($i = 1;$i <= 10 ;$i++){
                             if ($i == 10){
                                 ?>
                                  <option <?php if(isset($data['jml_lantai'])){ echo $data['jml_lantai'] == 10 ? 'selected="selected"' : ''; } ?> value="10+">10+ <?php echo 'saluran'; ?></option>        
                                 <?php 
                             }else{
                                 ?>
                                 <option <?php if(isset($data['jml_lantai'])){ echo $data['jml_lantai'] == $i ? 'selected="selected"' : ''; } ?> value="<?php echo $i;?>"><?php echo $i .' lantai' ;?>  </option>
                                 <?php 
                             }          
                          }  
        			    
        			    ?>	 
        			</select>				
        	  </div>
        	</div>	
        	<!-- end jumlah lantai -->
        	
        	<!-- kondisi -->
        	<div class="control-group">
        		<label for="focusedInput" class="control-label"><?php echo 'Perabotan'; ?></label>
        		<div class="controls">
        			<select name="kondisi" id="kondisi" class="input-medium focused">
        				<option value=""><?php echo  '[pilih]';?></option>
        				<option <?php if(isset($data['kondisi'])){ echo $data['kondisi'] == "TAK_BERPERABOT"    ? 'selected="selected"' : '';} ?> value="TAK_BERPERABOT"><?php echo 'tidak berperabot'; ?></option>
        				<option <?php if(isset($data['kondisi'])){ echo $data['kondisi'] == "SEBAGIAN" ? 'selected="selected"' : '';} ?> value="SEBAGIAN"><?php echo 'berperabot sebagian'; ?></option>
        				<option <?php if(isset($data['kondisi'])){ echo $data['kondisi'] == "LENGKAP" ? 'selected="selected"' : '';} ?> value="LENGKAP"><?php echo 'berperabot lengkap'; ?></option>
        			</select>
        		</div>
        	</div>
        	<!-- end kondisi -->
        	
        	
        	<!-- kapasitas listrik  -->
        	<div class="control-group">
        		<label for="focusedInput" class="control-label">(*) <?php echo 'Pasokan Listrik'; ?></label>
        		<div class="controls">
        			<select name="pasokan_listrik" id="pasokan_listrik" class="input-medium focused">
        			  <option value=""><?php echo  '[pilih]';?></option>
        			  <option <?php if(isset($data['pasokan_listrik'])){ echo $data['pasokan_listrik'] == "0" ? 'selected="selected"' : '' ;} ?>  value="0"><?php echo 'lainnya';?></option>
        				<?php foreach ($m_pasokan_listrik as $r_listrik) {?>				    
        				    <option <?php if(isset($data['pasokan_listrik'])){ echo $r_listrik->id == $data['pasokan_listrik'] ? 'selected="selected"' : ''  ?> value="<?php echo $r_listrik->id;}?>"><?php echo $r_listrik->besar;?></option>
        				<?php }?>
        			</select>
        		</div>
        	</div>
        	<!-- end kapasitas listrik -->
        	
        	
        	<!-- pintu depan menghadap ke ...-->
        	<div class="control-group">
        		<label for="focusedInput" class="control-label"><?php echo 'menghadap(Pintu depan)' ?></label>
        		<div class="controls">
        			<select name="menghadap" id="menghadap" class="input-medium focused">
        			    <option value=""><?php echo  '[pilih]';?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "NORTH"    ? 'selected="selected"' : '';} ?> value=NORTH><?php echo 'Utara'; ?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "NEAST" ? 'selected="selected"' : '';} ?> value="NEAST"><?php 'Timur Laut'; ?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "NWEST" ? 'selected="selected"' : '';} ?> value="NWEST"><?php echo 'Barat Laut'; ?></option>
        				
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "EAST" ? 'selected="selected"' : '';} ?> value="EAST"><?php echo 'Timur';?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "WEST" ? 'selected="selected"' : '';} ?> value="WEST"><?php echo 'Barat'; ?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "SEAST" ? 'selected="selected"' : '';} ?> value="SEAST"><?php echo 'Tenggara'; ?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "SWEST" ? 'selected="selected"' : '';} ?> value="SWEST"><?php echo 'Barat Daya'; ?></option>
        				<option <?php if(isset($data['menghadap'])){ echo $data['menghadap'] == "SOUTH" ? 'selected="selected"' : '';} ?> value="SOUTH"><?php echo 'Selatan'; ?></option>
        			</select>
        		</div>
        	</div>
        	<!-- end pintu depan menghadap -->
        	
        	
        	<!---->
        	<div class="control-group">
        		<div class="controls">

        		<?php if($status == 'go_next'):?>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo 'Lanjut =>'; ?></button>
                <?php else:?>        
                    <button type="submit" class="btn btn-primary pull-right"><?php echo 'Simpan Perubahan'; ?></button>
                <?php endif;?>  

        		</div>
        	</div>
        </form>
   </div>
</div>
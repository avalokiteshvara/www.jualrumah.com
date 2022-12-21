<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>



<ul class="tabs nav nav-tabs" id="myTab">
	<li <?php if($mode == "change_profile")echo 'class="active"'?>>
	   <a href="#profile" data-toggle="tab">Profile</a>
	</li>	
	<li <?php if($mode == "change_pass")echo 'class="active"'?>>
	   <a href="#password" data-toggle="tab">Ganti Password</a>
	</li>		
</ul>

<div class="tab-content">
	<div class="tab-pane <?php if($mode == "change_profile")echo 'active'?>" id="profile">
		
		<?php if(isset($msg) and $mode == "change_profile" ):?>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">				    
				  <?php $pos = strpos($msg, 'error:');?>  
				  <?php if($pos !== FALSE):?>
				    <div class="alert alert-error">
				  <?php else:?>
				    <div class="alert alert-success">
				  <?php endif;?>
					   <button type="button" class="close" data-dismiss="alert"> x </button>
					   <?php echo $msg;?>
					</div>				     							
				</div>
			</div>
		</div>		
        <?php endif;?>
		
		
		
		<div class="row">
			<div class="span12">
				<div class="page-header">
					<h2><?php echo $page_title;?></h2>
				</div>
			</div>




			<div class="span12">
				<form action="<?php echo base_url()?>member/profile/change"	method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="span2">
					</div>

					<div class="span10">
					<fieldset>	
					
					

					
					<?php foreach ($profile as $r_profile){} ?>
					
						<div class="control-group">							

							<div class="controls">
							<?php if (!is_null($r_profile->photo)):?>
								<img width="200" height="200" alt="" src="<?php echo base_url() .'avatar/'. $r_profile->photo; ?>">
							<?php else: ?>
								<img width="200" height="200" alt="" src="<?php echo base_url() .'avatar/no_images.jpg'; ?>">
							<?php endif; ?>	
							</div>		
							<br/>
							<label class="control-label">Foto:</label>
							<div class="controls">
								<input type="file" name="foto" >	
    	   					</div>
							
						</div>

						<div class="control-group">
							<label class="control-label">Email</label>
							<div class="controls">
								<input type="text" value="<?php echo $r_profile->email;?>" placeholder="your email" class="input-xlarge span6"	readonly="readonly" />
							</div>
						</div>

						<div class="control-group">
							<label for="focusedInput" class="control-label">Nama Depan:</label>
							<div class="controls">
								<input name="nama_depan" value="<?php echo $r_profile->nama_depan;?>" type="text" placeholder="" id="focusedInput" class="input-xlarge focused span6" />
							</div>
						</div>

						<div class="control-group">
							<label for="focusedInput" class="control-label">Nama Belakang:</label>
							<div class="controls">
								<input name="nama_belakang"	value="<?php echo $r_profile->nama_belakang;?>" type="text"	placeholder="" id="focusedInput" class="input-xlarge focused span6" />
							</div>
						</div>

						<div class="control-group">
							<label for="focusedInput" class="control-label">No.Telp:</label>
							<div class="controls">
								<input name="telp" value="<?php echo $r_profile->telp;?>" type="text" id="focusedInput"	class="input-xlarge focused span6" />
							</div>
						</div>

						<div class="control-group">
							<label for="textarea" class="control-label">Alamat:</label>
							<div class="controls">
								<textarea name="alamat" rows="3" id="textarea" placeholder="" class="input-xlarge span6"><?php echo $r_profile->alamat;?></textarea>
							</div>
						</div>

						<div class="span8">
							<button class="btn btn-primary pull-right"
								style="margin-right: 20px;" type="submit">Simpan</button>
						</div>
					</fieldset>
					</div>
				</form>
			</div>
		</div>
	</div>

	
	<!--tab change_pass -->
	<div class="tab-pane <?php if($mode == 'change_pass')echo 'active'?>" id="password">
	
       <?php if(isset($msg) and $mode == 'change_pass'):?>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">				    
				  <?php $pos = stripos($msg, 'error:');?>  
				  <?php if($pos !== FALSE):?>
				    <div class="alert alert-error">
				  <?php else:?>
				    <div class="alert alert-success">
				  <?php endif;?>
					   <button type="button" class="close" data-dismiss="alert"> x </button>
					   <?php echo $msg;?>
					</div>				     							
				</div>
			</div>
		</div>		
        <?php endif;?>
    
		
		<div class="row">
			<div class="span12">
				<div class="page-header">
					<h2>Halaman Ganti Password</h2>
				</div>
			</div>
			
			
			<div class="span12" >
				<form action="<?php echo base_url()?>member/change_pass/change"
					method="post" class="form-horizontal">
					<fieldset>


						<div class="control-group">
							<label class="control-label">Password Lama:</label>
							<div class="controls">
								<input name="old_pass" type="password" value="" placeholder=""
									class="input focused span4" />
							</div>
						</div>

						<div class="control-group">
							<label for="focusedInput" class="control-label">Password Baru:</label>
							<div class="controls">
								<input name="new_pass" value="" type="password" placeholder=""
									id="focusedInput" class="input span4" />
							</div>
						</div>

						<div class="control-group">
							<label for="focusedInput" class="control-label">Ulangi:</label>
							<div class="controls">
								<input name="repeat_pass" value="" type="password"
									id="focusedInput" class="input span4" />
							</div>
						</div>

						<div class="span6">
							<button class="btn btn-primary pull-right"
								style="margin-right: 20px;" type="submit">Simpan</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

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
			<h1>Hubungi kami</h1>
		</div>
		
		<!-- Headings &amp; Paragraph Copy -->
		<div class="row">
			<div class="span9">
			  <?php if(validation_errors() != ''): ?>
				<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">x</a><?php echo validation_errors();?>
				</div>
			  <?php endif; ?>
			  			
			  <?php if(isset($msg)): ?>	
			  	<div class="alert alert-error">
					<a class="close" data-dismiss="alert" href="#">x</a><?php echo '<br>'.$msg; ?>
				</div>
			  <?php endif;?>

				<form class="form-horizontal" method="POST" action="<?php echo base_url()?>contact_us/send_msg" />
					<fieldset>
						<p>Silahkan mengirimkan pertanyaan, saran maupun kritik yang membangun kepada kami.</p><br />
						<div class="control-group">
							<label for="focusedInput" class="control-label">Nama Anda:</label>
							<div class="controls">
								<input type="text" name="nama" placeholder="" id="focusedInput" class="input-xlarge focused span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Alamat E-Mail:</label>
							<div class="controls">
								<input type="text" name="email" placeholder="" class="input-xlarge span6" />
							</div>
						</div>
						<div class="control-group">
							<label for="textarea" class="control-label">Pesan:</label>
							<div class="controls">
								<textarea name="pesan" rows="3" id="textarea" placeholder="" class="input-xlarge span6"></textarea>
							</div>
						</div>
						
						<div class="span8">
							<button class="btn btn-primary pull-right" style="margin-right: 20px;" type="submit">Kirim</button>
						</div>
					</fieldset>
				</form>				
			</div>
			
			
			
			<!-- Misc Elements -->
			
		</div><!-- /row -->
		
	</div>
</div>
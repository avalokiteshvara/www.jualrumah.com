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

        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
        </p>
			</div>
      <!-- Misc Elements -->
		</div><!-- /row -->

	</div>
</div>

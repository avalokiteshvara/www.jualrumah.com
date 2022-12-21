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
			<h1>Daftar Agen / Pengiklan</h1>
		</div>

		<!-- Headings &amp; Paragraph Copy -->
		<?php foreach ($member->result_array() as $row) { ?>
		<div class="row">
         <div class="span2">
					 	<?php $photo = ($row['photo'] != null ? $row['photo'] : 'no_images.jpg') ?>
            <a href="" class="thumbnail "><img src="<?php echo site_url('avatar/' . $photo )?>" height="130" width="130"></a>
            <!-- <h5>Harga: Rp.12 milyar</h5>
            <h6>Status: Baru</h6><h6>Kamar tidur : 1</h6>            <h6>Tanggal: 06-08-2013</h6>
            <h6>Di Lihat: 22 kali</h6> -->
         </div>
         <div class="span6">
            <a href="#">
               <h3><?php echo $row['nama_depan'] . ' ' . $row['nama_belakang']?></h3>
            </a>
            <p><?php echo $row['alamat']?></p>
						<p><?php echo $row['email']?></p>
						<?php $jml_listing = $this->db->get_where('tbl_listing',array('id_member' => $row['id'],'is_verified' => 'Y'))->num_rows()?>
						<p>Memiliki <a href="<?php echo site_url('agen/view_property/' . $row['id'])?>"><?php echo $jml_listing?> Iklan Properti</a></p>
         </div>
      </div>
			<hr />
		<?php } ?>
		<div class="pagination" align="center">
			 <ul>
					<?php echo $this->pagination->create_links(); ?>
			 </ul>
		</div>

	</div>
</div>

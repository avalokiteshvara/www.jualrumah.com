<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">

	function gotolisting(){
		window.location.href = "<?php echo base_url().'member/listing/index' ?>";
	}


</script>

<style type="text/css">

.span5 {
    width: 360px;
}

.img_upload {
    border-bottom: 1px solid #DDDDDD;
    border-left: 1px solid #DDDDDD;
    border-right: 1px solid #DDDDDD;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
    margin-bottom: 19px;
    padding-top: 28px;
    width: 900px;
}


.img_upload .thumbnail {
    border: medium none;
    border-radius: 0 0 0 0;
    box-shadow: none;
}
.img_upload .span2 {
    text-align: center;
    width: 192px;
}
.img_upload {
    position: relative;
}

.thumbnails {
    list-style: none outside none;
    margin-left: 60px;
}

</style>

<div class="row">
    <div class="span12">
        <div class="page-header">
    		<h1>Tambah Baru</h1>
    	</div>
    </div>
    <div class="span12">
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a>Catatan: Tipe file yang diijinkan *.jpg;gif;png , dengan maksimal besar file : <?php echo get_setting('max_image_listing_size')?> KiloByte (<?php echo round(get_setting('max_image_listing_size') / 1024)?> MegaByte)
			</div>
		</div>
</div>


<?php if($image_list->num_rows() >=5): ?>
	<div class="row">
		<div class="span12">
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a>Jumlah gambar yang diperbolehkan: 5 Gambar.
			</div>
		</div>
	</div>
<?php endif;?>


<div class="row">
<h4 class="span12" style="width: 862px"></h4>
	<div class="span12">
	    <ul class="thumbnails">
			<!-- repeat here -->
			<?php foreach ($image_list->result() as $row){?>
			<li class="span2 premium_property" data-text="">
				<div class="thumbnail">
					<img width="100" height="100"
						src="<?php echo base_url()?>media/<?php echo $row->file_name;?>" alt="" />
				</div>

				<a href="<?php echo base_url();?>member/listing/delete_image/<?php echo $listing_id . '/' . $row->id;?>">
					<div id="Badger" class="badger-outter">
						<div class="badger-inner">
							<p id="Badge" class="badger-badge badger-text">x</p>
						</div>
					</div>
				</a>
			</li>
			<?php }?>

		</ul>

	</div>
</div>


<div class="row">
  <div class="span12">
      <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>member/listing/upload_images/<?php echo $listing_id; ?>/submit" accept-charset="UTF-8">

		<?php for($i = 1; $i <= (5 - $image_list->num_rows());$i++){ ?>


		<div class="control-group">
        	<label for="focusedInput" class="control-label">Image <?php echo $i;?> : </label>
			<div class="controls">
				<input type="file" name="img[]" >
    	   </div>
		</div>

		<?php } ?>


		<div class="row">
			<div class="span3">
				<div class="control-group">
					<div class="controls">
				<?php if($image_list->num_rows() < 5):?>
						<button type="submit" class="btn btn-primary " >Upload</button>
				<?php endif;?>
					</div>
				</div>
			</div>

			<div class="span9">
				<div class="control-group">
					<button type="button" class="btn btn-primary pull-right" onclick="gotolisting()" > Selesai</button>
				</div>
			</div>

		</div>

	  </form>
  </div>
</div>

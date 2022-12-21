<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>


<script type="text/javascript">

	function del_list(id){

		$.ajax({
    		url:'<?php echo base_url() . 'member/listing/delete/';?>' + id,
    		type:"POST",
    		async   : false,
    		cache   : false,
    		success : function(msg){
    			$('#row_' + id).remove();
    		}
    	})
	}

	function set_sold(id){
        $.ajax({
            url: '<?php echo base_url() . 'member/listing/sold/';?>' + id,
            type: "POST",
            dataType:'json',
            async: false,
            cache: false,
            success: function(msg){

                //$('#td_' + id).text('Terjual');


            }
        })

        location.reload(true);
    }


</script>

<div class="container">


	<div class="row">
		<div class="span12">
		   <?php if($listing->num_rows() == 0): ?>
		    <div class="alert alert-error">
    	     <a class="close" data-dismiss="alert" href="#">x</a>
    	       <?php echo 'Listing kosong'; ?>
    	       <br>
    	       <a href="<?php echo base_url()?>member/listing/add_basic/">
    	           <?php echo 'Klik disini untuk menambahkan'; ?>
    	       </a>

            </div>
            <?php for ($i=0; $i < 15 ; $i++) {
        		echo '<br>';
    		} ?>

		   <?php else:?>

		   	<div class="row">
				<div class="span12">
					<div class="alert alert-error">
						<a class="close" data-dismiss="alert" href="#">x</a>Catatan: Iklan Properti memerlukan verifikasi admin untuk bisa ditampilkan.
					</div>
				</div>
			</div>

			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>STATUS</th>
						<!-- <th>ID</th> -->
            <th>Jenis Iklan</th>
						<!-- <th>Jual/Sewa</th> -->
						<th>Judul</th>
						<th>Tanggal Buat</th>
						<th>Dilihat</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($listing->result() as $row){?>
					<tr id="row_<?php echo $row->id;?>">
						<?php if($row->is_verified == 'Y'):?>
							<td>VERIFIED</td>
						<?php else:?>
							<td>PENDING</td>
						<?php endif?>

						<!-- <td><?php echo $row->id;?></td> -->
            <td>
              <?php echo strtoupper( $row->jenis_iklan ) ?>
              <?php if($row->jenis_iklan === 'premium'){ ?>
                s/d <?php echo $row->premium_tgl_berakhir;?>
              <?php } ?>
            </td>


						<td>
              <a href="<?php echo base_url() .'property/show/'. $row->id; ?>" target="_blank"><?php echo '(' . strtoupper($row->tipe_listing) . ') ' . substr($row->judul_listing,0,30);?></a>
            </td>
						<td><?php echo $row->tgl_buat;?></td>
						<td><?php echo $row->total_dilihat;?></td>
						<td id="td_<?php echo $row->id;?>"><?php echo ($row->has_sold == 'Y') ? 'TERJUAL' : 'BELUM TERJUAL' ?></td>
						<td>
							<div class="btn-group">
								<button class="btn dropdown-toggle" data-toggle="dropdown">
									Options <span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url()?>member/listing/edit_basic/<?php echo $row->id;?>">Edit Basic</a></li>
									<li><a href="<?php echo base_url()?>member/listing/additional_info/<?php echo $row->id;?>/show_edit/done">Edit Info Tambahan</a></li>
									<li><a href="<?php echo base_url()?>member/listing/upload_images/<?php echo $row->id;?>">Edit Gambar</a></li>
									<li><a href="#" onclick="del_list(<?php echo $row->id;?>)">Hapus</a></li>
									<li><a href="#" onclick="set_sold(<?php echo $row->id;?>)">Terjual</a></li>
								</ul>
							</div>
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>

			<div class="pagination" align="center">
				<ul>
					<?php echo $this->pagination->create_links(); ?>
				</ul>
			</div>

			<fieldset>
				<a href="<?php echo base_url()?>member/listing/add_basic"
					class="btn btn-primary" type="button">Tambah</a>
			</fieldset>

			<?php endif;?>
		</div>
	</div>
</div>

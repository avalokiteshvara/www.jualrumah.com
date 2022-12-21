<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">
	
	function del_bookmark(id){
		
		$.ajax({
    		url:'<?php echo base_url() . 'member/bookmark/delete/';?>' + id,
    		type:"POST",
    		async   : false,
    		cache   : false,
    		success : function(msg){
    			if(msg != 'NEED_LOGIN'){
    				if(msg == 0){
    					window.location.href = "<?php echo base_url().'member/bookmark' ?>";
    				}else{
    					$('#row_' + id).remove();
    				}
				}else{
					window.location.href = "<?php echo base_url().'member/login' ?>";
				}
    		}
    	})
	}

</script>


<div class="container">
	<div class="row">
		<div class="span12">
		   <?php if($bookmark_arr->num_rows() == 0): ?>
		    <div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>
    	       Bookmark Kosong.    	     
            </div>  
            
            <?php for ($i=0; $i < 15 ; $i++) { 
        		echo '<br>';
    		} ?>

		   <?php else:?>
			<table class="table table-hover table-striped" id="bookmark_table">
				<thead>
					<tr>
						<th>#Kode</th>
						<th style="width: 100px;">Tipe</th>
						<th style="width: 650px;">Judul Properti</th>						
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($bookmark_arr->result() as $row){?>
					<tr id="row_<?php echo $row->id_bookmark;?>">
						<td><?php echo $row->id_listing;?></td>
						<td><?php echo $row->tipe;?></td>
						<td><a href="<?php echo base_url() .'property/show/'.$row->id_listing;?>" target="_blank"> <?php echo $row->judul;?> </a></td>
						<td>
							<div class="btn-group">
								<button class="btn dropdown-toggle" data-toggle="dropdown">
									Options <span class="caret"></span>
								</button>
								<ul class="dropdown-menu">																		
									<li><a class="deletelink" href="#" onclick="del_bookmark(<?php echo $row->id_bookmark;?>)">Hapus</a></li>	
								</ul>
							</div>
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>			
			<?php endif;?>
		</div>
	</div>
</div>



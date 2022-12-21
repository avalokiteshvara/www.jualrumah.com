<script type="text/javascript">

    function setFocus(){
        document.getElementById("search_string").focus();
    }

    function clear_text(){
    	document.getElementById('banned_reason').value="";
    }

    var myVal;
    function set_value(val){
    	myVal = val;
    	clear_text();
    }

    function del_member(id){

      var x = confirm("apakah anda yakin untuk menghapus data ini?");
      if (x){
        $.ajax({
            url:'<?php echo base_url() . 'admin/members/delete/';?>' + id,
            type:"POST",
            async   : false,
            cache   : false,
            success : function(msg){

                if(msg != 'OK'){
                        window.location.href = "<?php echo base_url().'admin/members/' ?>";
                }else{
                        $('#tr_user_' + id).remove();
                }

            }
        })
      }
    }

    function banned(){

    	$.ajax({
            url: '<?php echo base_url() . 'admin/members/banned/';?>' + myVal,
            type: "POST",
            data : $('form').serialize(),
            async: false,
            cache: false,
            success: function(msg){
            	if(msg == 'OK'){

            		$('#banned_' + myVal).replaceWith('<li id="unbanned_' + myVal + '"><a href="" onclick="unbanned(' + myVal + ');return false"><i class="icon-ok"></i> Un-Banned !</a></li>');
            		$('#tr_user_' + myVal).addClass('error');
            		clear_text();
	    			// alert(msg);
	    			$('#myModal').modal('hide');

            	}else{

            		alert(msg);

				}
            }
        })
    }

    function sendMsg(){

    	$.ajax({
            url: '<?php echo base_url() . 'admin/members/send_msg/';?>' + myVal,
            type: "POST",
            data : $('form').serialize(),
            async: false,
            cache: false,
            success: function(msg){
            	if(msg == 'OK'){

            		// $('#banned_' + myVal).replaceWith('<li id="unbanned_' + myVal + '"><a href="" onclick="unbanned(' + myVal + ');return false"><i class="icon-ok"></i> Un-Banned !</a></li>');
            		// $('#tr_user_' + myVal).addClass('error');
            		clear_text();
	    			$('#frmModalMsg').modal('hide');

            	}else{

            		alert(msg);

				}
            }
        })
    }

    function unbanned(id){
        $.ajax({
            url: '<?php echo base_url() . 'admin/members/unbanned/';?>' + id,
            type: "POST",
            async: false,
            cache: false,
            success: function(msg){

                $('#unbanned_' + id).replaceWith('<li id="banned_' + id + '"><a href="#myModal" data-toggle="modal" class="linkModal" onclick="set_value(' + id + ')"><i class="icon-ban-circle"></i> Banned !</a></li>');
                $('#tr_user_' + id).removeClass('error');
            }
        })
    }

</script>

<style type="text/css">

    .dropdown-menu {
        min-width: 80px;
    }

    .dropdown-menu > li > a {
	    line-height: 20px;
	    padding: 2px 10px;
	}

</style>

</br>
</br>
<div class="span9" id="content">


	<div class="row-fluid">
	    <div class="span12">
	        <!-- block -->
	        <form class="form-search" method="post" action="<?php echo base_url(); ?>admin/members/search">
            	<input id="search_string" name="search_string" type="text" class="input-large search-query" value="<?php echo isset($search_string) ? $search_string : '' ?>" />
            	<button type="submit" class="btn"><i class="icon-search icon-white"></i>Search</button>
            </form>

	        <div class="block">
	            <div class="navbar navbar-inner block-header">
	                <div class="muted pull-left">Members</div>
	                <div class="pull-right"><span class="badge badge-info"><?php echo $jumlah_user?></span>

	                </div>
	            </div>

	            <?php if($arr_users->num_rows() != 0):?>

	            <div class="block-content collapse in">
	                <table class="table table-hover">
	                    <thead>
	                        <tr>
	                            <th>#</th>
	                            <th>Daftar</th>
	                            <th>Email</th>
	                            <th>Nama Depan</th>
	                            <th>Nama Belakang</th>
	                            <th>Properti</th>
	                            <th></th>
	                            <th></th>
	                            <th></th>
	                        </tr>
	                    </thead>

	                    <tbody>
	                        <?php

	                        	$i = empty($segment_4) ? 0 : $segment_4 ;

	                        	foreach ($arr_users->result() as $r_users) {
	                        		$i +=1;
	                        ?>
	                        <tr id="tr_user_<?php echo $r_users->id;?>" <?php echo ($r_users->banned != 'N') ? 'class="error"' : '' ?> >
	                            <td><?php echo $i; ?></td>
	                            <td><?php echo $r_users->created; ?></td>
	                            <td><?php echo $r_users->email;?></td>
	                            <td><?php echo $r_users->nama_depan;?></td>
	                            <td><?php echo $r_users->nama_belakang;?></td>
	                            <td><?php echo $r_users->cnt_listing;?></td>
	                            <td>
									<div class="btn-group">
	   								   <!-- <button class="btn">Action</button> -->
										<button class="btn dropdown-toggle" data-toggle="dropdown">
											Aksi <span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-left">

										<?php if($r_users->banned == 'N'):?>
											<li id="banned_<?php echo $r_users->id;?>"><a href="#myModal" data-toggle="modal" class="linkModal" onclick="set_value(<?php echo $r_users->id;?>)"><i class="icon-ban-circle"></i> Banned !</a></li>
										<?php else:?>
											<li id="unbanned_<?php echo $r_users->id;?>"><a href="" onclick="unbanned(<?php echo $r_users->id?>);return false"><i class="icon-ok"></i> Un-Banned !</a></li>
										<?php endif;?>

											<li id="pesan_<?php echo $r_users->id;?>"><a href="#frmModalMsg" data-toggle="modal" class="linkModal" onclick="set_value(<?php echo $r_users->id;?>)"><i class="icon-envelope"></i> Kirim Pesan</a></li>

											<li class="divider"></li>
											<li><a href="" onclick="del_member(<?php echo $r_users->id?>);return false"><i class="icon-trash"></i> Hapus User !</li>
										</ul>

									</div>
								</td>
								<td></td>
								<td></td>
	                        </tr>
	                        <?php } ?>

	                    </tbody>
	                </table>

	                <br/>


	            	<div class="pagination" align="center">
						<ul>
							<?php echo $this->pagination->create_links(); ?>
						</ul>
					</div>

	            </div>
	        <?php else:?>
	        	<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
	        		<h4>Error</h4>
	    			Data Member tidak ditemukan
	    		</div>
	        <?php endif;?>



	        </div>
	        <!-- /block -->

	    </div>
    </div>
</div>

<style type="text/css">

	.modal{
		width: 400px;
		left: 60%;
	}

	.input-xlarge{
		width: 330px;
	}

</style>




<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="myModalLabel">Alasan Banned:</h3>
	</div>

	<form method="POST" class="form-inline" />
		<div class="modal-body">

			<div class="control-group">
				<div class="controls">
					<textarea name="banned_reason" id="banned_reason" rows="5" class="input-xlarge"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn btn-danger" type="submit" onclick="banned();return false;" >Banned!</button>
		</div>
	</form>
</div>

<!--kirim pesan -->
<div id="frmModalMsg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="myModalLabel">Pesan:</h3>
	</div>

	<form method="POST" class="form-inline" />
		<div class="modal-body">

			<div class="control-group">
				<div class="controls">
					<textarea name="isi_pesan" id="isi_pesan" rows="5" class="input-xlarge"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn btn-primary" type="submit" onclick="sendMsg();return false;" >Send!</button>
		</div>
	</form>
</div>

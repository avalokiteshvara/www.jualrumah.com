<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">
    function del_message(id){
        
        $.ajax({
            url:'<?php echo base_url() . 'member/message/delete/';?>' + id,
            type:"POST",
            async   : false,
            cache   : false,
            success : function(msg){
                
                if(msg == 0){
                        window.location.href = "<?php echo base_url().'member/message/' ?>";
                }else{
                        $('#row_' + id).remove();
                }

            }
        })
    }

    function read_message(id){
        $.ajax({
            url: '<?php echo base_url() . 'member/message/read/';?>' + id,
            type: "POST",
            dataType:'json',
            async: false,
            cache: false,
            success: function(msg){

                $("#subject").val(msg.pesan);                
                $('#nama_pengirim').replaceWith('<h4 id="nama_pengirim">' + msg.nama_pengirim + '</h4>');
                $('#no_telp').replaceWith('<h4 id="no_telp">No.Telp: ' + msg.telp + '</h4>');

            }
        })
    }

</script>

<style type="text/css">

    .dropdown-menu {
        min-width: 80px;
    }    

</style>

<ul class="tabs nav nav-tabs" id="myTab">
	<li class="active"><a href="#inbox" data-toggle="tab">Pesan Masuk</a></li>	
</ul>

<div class="tab-content">

<?php if ($messages_data->num_rows() == 0): ?>
    <div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>
       Tidak ada pesan dalam inbox.          
    </div>  
    <?php for ($i=0; $i < 15 ; $i++) { 
        echo '<br>';
    } ?>
<?php else: ?> 

    <div class="tab-pane active" id="inbox">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 350px;">Isi</th>
                <th style="width: 200px;">Dari</th>
                <th style="width: 100px;">No.Telp</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>

            </thead>
            <tbody>
            
    <?php 
        foreach ($messages_data->result() as $msg_row ) { ?>      

            <tr id="row_<?php echo $msg_row->id;?>">
                <td><a href="" onclick="read_message(<?php echo $msg_row->id;?>);return false"> <?php echo (strlen($msg_row->pesan) >= 50) ? substr($msg_row->pesan,0,50) .' ...' : $msg_row->pesan  ?></a></td>
                <td><?php echo (strlen($msg_row->pengirim) >= 30) ? substr($msg_row->pengirim,0,30) .' ...' : $msg_row->pengirim  ;?></td>
                <td><?php echo $msg_row->telp;?></td>
                <td><?php echo $msg_row->tgl_pesan;?></td>
                <td>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            Options <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">                                  
                            <li><a href="" onclick="del_message(<?php echo $msg_row->id; ?>);return false">Hapus</a></li>        
                        </ul>
                    </div>
                </td>
            </tr>            
    <?php }?>    

            </tbody>
        </table>
    </div> 

    <hr/>

    <div class="row">  
        <div class="span12">
            <div class="page-header">
                <h2>Dari:</h2>
                <h4 id="nama_pengirim"></h4>
                <h4 id="no_telp"></h4>
            </div>
        </div>          
        <div class="span12">
            <fieldset>                    
                <div class="control-group">
                    <label for="textarea" class="control-label">Pesan:</label>
                    <div class="controls">
                        <textarea name="alamat" rows="8" id="subject" placeholder="" class="input-xlarge span8"></textarea>
                    </div>
                </div>
            </fieldset>
        </div>
    </div> 

    <?php endif;?>

</div>
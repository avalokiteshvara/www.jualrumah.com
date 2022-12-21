<script type="text/javascript">
    function del_message(id){
        
        $.ajax({
            url:'<?php echo base_url() . 'admin/pesan/delete/';?>' + id,
            type:"POST",
            async   : false,
            cache   : false,
            success : function(msg){
                
                if(msg == 0){
                        window.location.href = "<?php echo base_url().'admin/pesan/' ?>";
                }else{
                        $('#row_' + id).remove();
                }

            }
        })
    }

    function read_message(id){
        $.ajax({
            url: '<?php echo base_url() . 'admin/pesan/read/';?>' + id,
            type: "POST",
            dataType:'json',
            async: false,
            cache: false,
            success: function(msg){
                $("#subject").val(msg.pesan); 
                $('#nama').replaceWith('<input class="input-xlarge focused" id="nama" type="text" value="' + msg.nama + '">');                
                $('#email').replaceWith('<input class="input-xlarge focused" id="email" type="text" value="' + msg.email + '">');
                
                $('#email_balas').replaceWith('<input class="input-xlarge focused" name="email_balas" id="email_balas" type="text" value="' + msg.email + '">');
                $('#pesan_balasan').val(
                    'Hai '+ msg.nama + ',{NEW_LINE} anda menerima pesan ini karena pertanyaan/saran yang anda kirimkan ke @jualrumah.com.{NEW_LINE}\n'  + 
                    'Pertanyaan/saran anda:{NEW_LINE}\n' + msg.pesan + '{NEW_LINE}{NEW_LINE}\n\n' + 
                    'Inilah jawaban atas pertanyaan/saran anda:{NEW_LINE}\n');

                if(msg.from_member == 'Y'){
                    $('#id_member').replaceWith('<input type="hidden" id="id_member" name="id_member" value="'+ msg.id_member +'">');
                }
            }
        })
    }


    function clear_text(){
        // document.getElementById('email_balas').value="";               
        document.getElementById('subject_balas').value="";
        document.getElementById('pesan_balasan').value="";  
        $('#id_member').replaceWith('<input type="hidden" id="id_member" name="id_member"');      
    }

    function send_msg(){

        $.ajax({
            url:'<?php echo base_url() . 'admin/pesan/kirim/';?>',
            type:"POST",
            data : $('form').serialize(),       
            async: false,
            cache   : false,    
            success: function(msg){
                if(msg.indexOf("#ERROR") != 0){                    
                    alert(msg); 
                    clear_text();                 

                }else{
                    alert(msg);
                } 
            }
        })      
    }

</script>

</br>
</br>

<style type="text/css">

    .dropdown-menu {
        min-width: 85px;
    }    

</style>

<div class="span9" id="content">   

    <div class="row-fluid">
        <div class="span12">                
            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">Pesan</div>
                    <div class="pull-right"><span class="badge badge-info"><?php echo $messages_data->num_rows();?></span>

                    </div>
                </div>
                <?php if($messages_data->num_rows() != 0):?>

                <div class="block-content collapse in">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 350px;">Isi</th>
                                <th style="width: 100px;">Dari</th>
                                <th style="width: 100px;">Email</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>                                             
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                foreach ($messages_data->result() as $msg_row ) { ?>      
                                    <tr id="row_<?php echo $msg_row->id;?>">
                                        <td><a href="" onclick="read_message(<?php echo $msg_row->id;?>);return false"> <?php echo (strlen($msg_row->pesan) >= 50) ? substr($msg_row->pesan,0,50) .' ...' : $msg_row->pesan  ?></a></td>
                                        <td><?php echo (strlen($msg_row->nama) >= 30) ? substr($msg_row->nama,0,30) .' ...' : $msg_row->nama  ;?></td>
                                        <td><?php echo $msg_row->email;?></td>
                                        <td><?php echo $msg_row->tgl;?></td>
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
                     </br>  
            </br>
            </br>
                </div>


            <?php else:?>

                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <!-- <h4>Error</h4> -->
                    Kotak pesan masuk kosong!
                </div>  

            <?php endif;?>   

            </div>  

        </div>
    </div>    
    
<?php if($messages_data->num_rows() != 0):?>
       <div class="row-fluid section">
             <!-- block -->
            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">Details dan Kirim Pesan</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <div id="rootwizard">
                            <div class="navbar">
                              <div class="navbar-inner">
                                <div class="container">
                            <ul>
                                <li><a href="#tab1" data-toggle="tab">Details</a></li>
                                <li><a href="#tab2" data-toggle="tab">Kirim Balasan</a></li>                                
                            </ul>
                             </div>
                              </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane" id="tab1">
                                   <form class="form">
                                      <fieldset>
                                        
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Nama</label>
                                          <div class="controls">
                                            <input class="input-xlarge focused" id="nama" type="text" value="">
                                          </div>
                                        </div>

                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Email</label>
                                          <div class="controls">
                                            <input class="input-xlarge focused" id="email" type="text" value="">
                                          </div>
                                        </div>    

                                        <div class="control-group">
                                            <label for="textarea" class="control-label">Pesan:</label>
                                            <div class="controls">
                                                <textarea rows="8" id="subject" placeholder="" class="input-xlarge span8"></textarea>
                                            </div>
                                        </div>

                                      </fieldset>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <form class="form">

                                      <!-- <input type="hidden" id="pertanyaan" name="pertanyaan" > -->
                                      <!-- <input type="hidden" id="nama_balas" name="nama_balas" > -->
                                      <input type="hidden" id="id_member" name="id_member" >

                                      <fieldset>
                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Email Tujuan</label>
                                          <div class="controls">
                                            <input class="input-xlarge focused" name="email_balas" id="email_balas" type="text" value="">
                                          </div>
                                        </div>

                                        <div class="control-group">
                                          <label class="control-label" for="focusedInput">Subject</label>
                                          <div class="controls">
                                            <input class="input-xlarge focused" name="subject_balas" id="subject_balas" type="text" value="">
                                          </div>
                                        </div>

                                        <div class="control-group">
                                            <label for="textarea" class="control-label">Pesan:</label>
                                            <div class="controls">
                                                <textarea rows="8" name="pesan_balasan" id="pesan_balasan" placeholder="" class="input-xlarge span8"></textarea>
                                            </div>
                                        </div>
                                        <div class="span8">
                                            <button class="btn btn-primary pull-right" style="margin-right: 20px;" type="submit" onclick="send_msg();return false;">Kirim</button>
                                        </div>

                                      </fieldset>
                                    </form>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <!-- /block -->
        </div> 
    
<?php endif;?>

    <div class="row-fluid">
        
    </div>
</div>
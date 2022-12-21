<div class="span9" id="content">                     
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <!-- <div class="muted pull-left">Site Config</div> -->
            </div>
			
            <div class="block-content collapse in">
                <div class="span12">
                    <?php if(isset($msg)):?>
                      <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">x</a><?php echo $msg;?>
                      </div>
                    <?php endif; ?>

                     <form class="form-horizontal" method="post" action="" accept-charset="UTF-8">
                      <fieldset>
                        <legend>Ganti Password</legend>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Password lama</label>
                          <div class="controls">
                            <input class="span3" name="old_pass" type="password" value="">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Password baru</label>
                          <div class="controls">
                            <input class="span3" name="new_pass" type="password" value="">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Ulangi</label>
                          <div class="controls">
                            <input class="span3" name="repeat_pass" type="password" value="">
                          </div>
                        </div>

                        <div class="form-actions">
                          <button type="submit" class="btn btn-primary">Save changes</button>
                          <!-- <button type="reset" class="btn">Cancel</button> -->
                        </div>
                      </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
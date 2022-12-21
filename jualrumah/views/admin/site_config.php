<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <!-- <div class="muted pull-left">Site Config</div> -->
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <?php if(validation_errors() != ''): ?>
                      <div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">x</a><?php echo validation_errors();?>
                      </div>
                    <?php endif; ?>

                     <form class="form-horizontal" method="post" action="<?php echo base_url()?>admin/site_config/submit" accept-charset="UTF-8">
                      <fieldset>
                        <legend>Site Config</legend>


                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Nama Situs</label>
                          <div class="controls">
                            <input class="span6" name="site_title" type="text" value="<?php echo isset($site_title) ? $site_title : ''; ?>">
                          </div>
                        </div>


                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Alamat Kantor</label>
                          <div class="controls">
                            <input class="span6" name="office_address" type="text" value="<?php echo isset($office_address) ? $office_address : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Telp</label>
                          <div class="controls">
                            <input class="span3" name="cs_phone" type="text" value="<?php echo isset($cs_phone) ? $cs_phone : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Kota</label>
                          <div class="controls">
                            <input class="span3" name="office_town" type="text" value="<?php echo isset($office_town) ? $office_town : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">KodePOS</label>
                          <div class="controls">
                            <input class="span3" name="office_zip" type="text" value="<?php echo isset($office_zip) ? $office_zip : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Email Admin:</label>
                          <div class="controls">
                            <input class="span4" name="admin_email" type="text" value="<?php echo isset($admin_email) ? $admin_email : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Facebook Link:</label>
                          <div class="controls">
                            <input class="span4" name="facebook_link" type="text" value="<?php echo isset($facebook_link) ? $facebook_link : ''; ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="selectError">Signup Email Verification</label>
                          <div class="controls">
                            <select name="use_email_verification">

                            <?php if(isset($use_email_verification)): ?>
                              <option <?php echo ($use_email_verification == 'TRUE') ? 'selected="selected"' : ''; ?> value="TRUE">YES</option>
                              <option <?php echo ($use_email_verification == 'FALSE') ? 'selected="selected"' : ''; ?> value="FALSE">NO</option>
                            <?php else:?>
                              <option value="TRUE">YES</option>
                              <option value="FALSE">NO</option>
                            <?php endif;?>

                            </select>
                            <!-- <span class="help-inline">Woohoo!</span> -->
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="focusedInput">Max Size Image Upload (KiloByte)</label>
                          <div class="controls">
                            <input class="span4" name="max_image_listing_size" type="text" value="<?php echo isset($max_image_listing_size) ? $max_image_listing_size : ''; ?>">
                          </div>
                        </div>

                        <div class="form-actions">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          <!-- <button type="reset" class="btn">Cancel</button> -->
                        </div>
                      </fieldset>
                    </form>

                </div>
            </div>
        </div>
        <!-- /block -->
    </div>
</div>

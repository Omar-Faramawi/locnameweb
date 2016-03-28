<div class="alert alert-error" id="infoMessage">
    <?php echo $message; ?>
</div>

<section class="section-content">
    <div class="section-content-head">
        <i class="fa fa-lock"></i>
        <div>
            <h3>Change Your Password:</h3>
            <p>Please enter your new password</p>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="row">
        <?php echo form_open('auth/reset_password/' . $code, array("class" => "form-1"));?>
      
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <label>New Password (at least <?php echo $min_password_length;?> characters long): <span class="required-label">*</span></label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($new_password);?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Confirm New Password: <span class="required-label">*</span></label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($new_password_confirm);?>

                    <?php echo form_input($user_id);?>
                    <?php echo form_hidden($csrf); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p><?php echo form_submit('submit', 'Reset');?></p>
                </div>
            </div>
        </div>
      
        <?php echo form_close();?>
    </div>
</section>

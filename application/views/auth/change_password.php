<div class="container main-content">
    <div class="pg-header">
        <h3 class="pg-title">Change Password</h3>
        <p>You are up to change your account password</p>
    </div>

    <div class="alert alert-error" id="infoMessage">
        <?php echo $message; ?>
    </div>

    <div class="row-fluid">
		<?php echo form_open("auth/change_password"); ?>
        
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Old Password:</label>
                <div class="controls">
                  <?php echo form_input($old_password);?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputEmail">New Password (at least <?php echo $min_password_length;?> characters long):</label>
                <div class="controls">
                  <?php echo form_input($new_password);?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputEmail">Confirm New Password:</label>
                <div class="controls">
                  <?php echo form_input($new_password_confirm);?>
                  <?php echo form_input($user_id);?>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn btn-success btn-large" value="Change" name="submit">
                </div>
            </div>
        </div>
        
        <?php echo form_close();?>
    </div>
</div>

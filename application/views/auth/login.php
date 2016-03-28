<section class="section-content section-login">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Login To Proceed</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="clearfix"></div>

    <div class="section-content-note section-content-note-error section-content-alert" style="<?php echo ($message) ? "display:block;" : "display:none;"; ?>">
        <?php if ($message) echo $message; ?>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-6">
            <div class="head-title section-content-title"><h3><span>Login With Social Networks</span></h3></div>
            <a class="facebook-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
            <a class="google-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Google/home") ?>');">Google+ Account</a>
        </div>
        <div class="col-md-6">
            <div class="head-title section-content-title"><h3><span>Login With Your Account</span></h3></div>
            <?php echo form_open("auth/login"); ?> 
            <div class="user-name" data-toggle="tooltip"  data-placement="left" title="Enter Your Email Address">
                <?php echo form_input($identity); ?>
                <i class="fa fa-user"></i>
            </div>
            <div class="user-pass" data-toggle="tooltip"  data-placement="left" title="Enter Your Password">
                <?php echo form_input($password); ?>
                <i class="fa fa-lock"></i>
            </div>
            <div class="clearfix"></div>
            <input type="checkbox" checked="checked"><label class="user-checked">Save my password</label>
            <div class="clearfix"></div>
            <input type="submit" value="Login Now">
            <div class="clearfix"></div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="section-login-r">Don't Have Account? <a href="<?= site_url("auth/register") ?>">Register Now</a> | <a href="<?= site_url("auth/forgot_password") ?>">Forgot Password</a></div>
</section><!-- End section-content -->

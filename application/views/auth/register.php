<section class="section-content section-register-user">
    <div class="section-content-head">
        <i class="fa fa-copy"></i>
        <div>
            <h3>Register Through Social Networks:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6">
            <a class="google-account margin-0" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Google/home") ?>');">Google+ Account</a>
        </div>
        <div class="col-md-6">
            <a class="facebook-account margin-0" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
        </div>
    </div>
</section><!-- End section-content -->

<section class="section-content">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Register Through Website:</h3>
            <p>Please enter the user information below </p>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (isset($message) && strlen($message) > 2) { ?>

        <div class="section-content-note section-content-note-error section-content-alert">
            <i class="fa fa-times"></i><span>ERROR:</span>
            <?php echo ($message); ?><?php echo ($upload_error); ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>

    <div class="row">
        <?php echo form_open_multipart("auth/register", array("id" => "regForm", "class" => "form-1")); ?>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label for="first_name">First Name: <span class="required-label">*</span></label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Enter Your First Name"><?php echo form_input($first_name, "", "onkeyup='fill_username()' onchange='fill_username()'"); ?></div>
                <div class="col-md-4"><label for="last_name">Last Name: <span class="required-label">*</span></label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Enter Your Last Name"> <?php echo form_input($last_name, "", "onkeyup='fill_username()' onchange='fill_username()'"); ?></div>
                <div class="col-md-4"><label for="email">Email: <span class="required-label">*</span></label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Enter Your Email Address"><?php echo form_input($email); ?></div>
                <div class="col-md-4"><label for="password">Password: <span class="required-label">*</span></label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Enter Password"><?php echo form_input(array('name' => 'password', 'id' => 'password_regform', 'type' => 'password')); ?></div>
                <div class="col-md-4"><label for="password_confirm" >Confirm Password: <span class="required-label">*</span></label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Confirm Password"> <?php echo form_input($password_confirm); ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!--<div class="col-md-4"><label for="username">Display Name:</label></div>
                <div class="col-md-8"><?php// echo form_input($username, "", "onkeyup='set_username_filled()' onchange='set_username_filled()'"); ?></div>-->
                <div class="col-md-4"><label for="company">Company Name:</label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" title="Enter Your Company Name"> <?php echo form_input($company); ?></div>
                <div class="col-md-4"><label for="photo">User Image:</label></div>
                <div class="col-md-8">
                    <div class="fileinputs">
                        <input type="file" id="photo" name="photo" class="file file-fake" accept="image/*" onchange="validateFileType(this.value)" />
                        <div class="fakefile">
                            <button id="photo_text" type="button" class="button small margin-0">Select File</button>
                            <span>Browse</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="small">800x600 is the best resolution & Allowed formats are: gif, jpg, png, and jpeg</p>
                </div>
                <div class="col-md-4"><label for="country">Country:</label></div>
                <div class="col-md-8">
                    <div class="select-div">
                        <select class="" id="country" name="country" onchange="populate_cities(this, '<?php echo site_url("api/city") ?>');">
                            <option value="0">Choose Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?= $country->country_symbol ?>" data-value="<?= $country->country_name ?>" ><?= $country->country_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4"><label for="city">City:</label></div>
                <div class="col-md-8">
                    <div class="select-div">
                        <select class="" id="city" name="city">
                            <option value="0">Choose City</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="section-content-note section-content-note-2 section-content-alert section-content-alert-r" style="padding-top: 0px; padding-bottom: 0px;">
                <label style="display:block;">
                    <span style="margin-left:5px;">By clicking "Register User" you are agreeing to the </span> <a href="<?php echo site_url('index/terms') ?>">Terms and Conditions.</a>
                </label>
            </div>
            <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Register User</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</section><!-- End section-content -->

<script type='text/javascript'>
    var username_filled = false;

    function fill_username() {
        if (!username_filled) {
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            document.getElementById('username').value = first_name + " " + last_name;
        }
    }
    
    function set_username_filled() {
        var first_name = document.getElementById('first_name').value;
        var last_name = document.getElementById('last_name').value;
        var username = document.getElementById('username').value;
    	username_filled = (username !== "" && username !== (first_name + " " + last_name));
    }
</script>


<section class="section-content" id="update_profile">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Update Your Profile:</h3>
            <p>Please enter the user information below. </p>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (isset($message) && strlen($message) > 2) { ?>

        <div class="section-content-note section-content-note-error section-content-alert">
            <i class="fa fa-times"></i><span>ERROR:</span><?php echo ($message); ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>



    <div class="row">
        <?php echo form_open_multipart("user/update", array("id" => "regForm", "class" => "form-1")); ?>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label>First Name:</label></div>
                <div class="col-md-8" data-toggle="tooltip" data-placement="left" ><?php echo form_input($first_name); ?></div>
                <div class="col-md-4"><label>Last Name:</label></div>
                <div class="col-md-8" data-toggle="tooltip" data-placement="left" > <?php echo form_input($last_name); ?></div>
                <div class="col-md-4"><label>Email:</label></div>
                <div class="col-md-8"><input type='email' disabled value="<?php echo $user->email; ?>"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label>User Image:</label></div>
                <div class="col-md-8">
                    <div class="fileinputs">
                        <input type="file" name="photo" class="file file-fake" accept="image/*" onchange="validateFileType()">
                        <div class="fakefile">
                            <button id="photo_text" type="button" class="button small margin-0">Select File</button>
                            <span>Browse</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <p class="small">800x600 is the best resolution & Allowed formats are: gif, jpg, png, and jpeg</p>
                </div>
                <div class="col-md-4"><label>Country:</label></div>
                <div class="col-md-8">
                    <div class="select-div">
                        <select class="" id="country" name="country" onchange="populate_cities(this, '<?php echo site_url("api/city") ?>');">
                            <option value="0">Choose Country</option>
                            <?php   foreach ($countries as $country) {  ?>
                                <option value="<?= $country->country_symbol ?>"  <?= ($country->country_symbol == $user->country) ? "selected=selected" : "" ?> data-value="<?= $country->country_name ?>" ><?= $country->country_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4"><label>City:</label></div>
                <div class="col-md-8">
                    <div class="select-div">
                        <select class="" id="city" name="city">
                            <option value="0">Choose City</option>
                            <?php foreach ($cities as $city) {  ?>
                                <option value="<?= $city->id ?>"  <?= ($city->id == $user->city_id) ? "selected=selected" : "" ?>  ><?= $city->city ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4"><label>Company Name:</label></div>
                <div class="col-md-8" data-toggle="tooltip"  data-placement="left" > <?php echo form_input($company); ?></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="section-content-note section-content-note-2 section-content-alert section-content-alert-r"><input data-toggle="tooltip" data-placement="left" title="Make sure you have read and agreed before checking"  required="required" type="checkbox" checked="checked"><span>I have read and accepted</span> <a href="#">Terms and condition.</a></div>
            <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Update User</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</section><!-- End section-content -->
<!-- Change password section -->
<section class="section-content" id="change_password">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Change Password:</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <?php if (isset($message2) && strlen($message2) > 2) { ?>

        <div class="section-content-note section-content-note-error section-content-alert">
            <i class="fa fa-times"></i><span>ERROR:</span><?php echo ($message2); ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
    <div class="row">
        <?php echo form_open_multipart("user/updatePassword", array("id" => "regForm", "class" => "form-1")); ?>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label>Old Password:</label></div>
                <div class="col-md-8" data-toggle="tooltip" data-placement="left" ><?php echo form_input($old_password); ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label>New Password:</label></div>
                <div class="col-md-8" data-toggle="tooltip" data-placement="left"><?php echo form_input($password); ?></div>
            </div>
        </div>
        <div class="col-md-6 pull-right">
            <div class="row">
                <div class="col-md-4"><label>Confirm Password:</label></div>
                <div class="col-md-8" data-toggle="tooltip" data-placement="left" > <?php echo form_input($password_confirm); ?></div>
            </div>
        </div>
        <div class="col-md-12">

            <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Change Password</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</section><!-- End of change password section -->

<section class="section-content" id="link_accounts" style="display:none;">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Link Accounts:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <?php echo form_open_multipart("", array("id" => "regForm", "class" => "form-1")); ?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-1">
                    <?php
                    $data = array(
                        'name'        => 'linkGoogle',
                        'id'          => 'lickGoogle',
                        'value'       => 'accept',
                        'checked'     => false
                        );

                    echo form_checkbox($data);
                    ?>
                </div>
                <div class="col-md-8">Link Google+</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-1">
                    <?php
                    $data = array(
                        'name'        => 'linkFacbook',
                        'id'          => 'lickFacebook',
                        'value'       => 'accept',
                        'checked'     => false
                        );

                    echo form_checkbox($data);
                    ?>
                </div>
                <div class="col-md-8"> Link Facebbok</div>  
            </div>
        </div>
        <div class="col-md-12">

            <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Link Accounts</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</section><!-- End of change password section -->



<section class="section-content" id="mail_settings">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Mail Settings:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6">
            <button id="checkall" class="btn btn-default">check all</button>
        </div>
        <div class="col-md-6">
            <button id="uncheckall" class="btn btn-default">Uncheck all</button>
        </div>
        <div class="col-md-12">
        <hr>
        </div>
        <?php echo form_open_multipart("user/mail_settings", array("id" => "mailSettingsForm", "class" => "form-1")); ?>
        <?php
        foreach ($prefs as $key) {
            //$this->load->model("userPreference_model", "userPref");
            //$checked = $this->userPref->check_mail_settings($key->id, $this->data['user']->id);
            ?>
            <div class="col-md-6">
            <div class="row">
                <div class="col-md-1">
                    <?php
                    if(in_array($key->id, $userPrefs)){
                    $data = array(
                        'name'        => 'mailSettings[]',
                        'value'       => $key->id,
                        'checked'     => true,
                        'class'       => 'checkmailsettings'
                        );
                    }else{
                        $data = array(
                        'name'        => 'mailSettings[]',
                        'value'       => $key->id,
                        'checked'     => false,
                        'class'       => 'checkmailsettings'
                        );
                    }
                    echo form_checkbox($data);
                    ?>
                </div>
                <div class="col-md-8"><?php echo $key->name;?></div>
            </div>
        </div>
            <?php
        }
        ?>
        <div class="col-md-12">
            <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Save Settings</button>
        </div>
        <?php echo form_close(); ?>
        
    </div>
</section><!-- End of change password section -->


<section class="section-content">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Account:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url();?>user/deactivate/<?php echo $user->id;?>" class='btn btn-default'>Deactivate Account</a>
        </div>
    </div>
</section>
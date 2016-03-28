<form id="AddLocation" class="form-1 form-js" name="addocation" method="POST" enctype='multipart/form-data' action="<?= site_url("location/create")?>"    >
    <section class="container clearfix main-container">
        <div class="recent-loc register-loc">
            <div   class=" register-loc-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="register-loc-content-6">
                            <i class="fa fa-map-marker"></i>
                            <div>
                                <h3>Register Your Current Place.</h3>
                                <p>If you want to register your current place, just check in now, in one click, and we’ll find your location.</p>
                                <?php if($templocation)
                                { ?>
                                <a class="btn btn-info checkin" id="checkin-here" onclick="getPosition(<?=$templocation->latitude ?>,<?=$templocation->longitude ?>);">Check In Now</a>
                                <?php } else {?>
                                <a class="btn btn-info checkin" id="checkin-here" onclick="getPosition();">Check In Now</a>                                
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-loc-content-6">
                            <i class="fa fa-crosshairs"></i>
                            <div>
                                <h3>Register a Remote Place or Your Business.</h3>
                                <p>If you’re not already in the address you want to register. Don’t worry, we’ll help you locate it.</p>
                                <a class="btn btn-info checkin" id="choose-place" onclick="showstep1();">Choose Place</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recent-footer">
                <div><i class="fa fa-file-text-o"></i><span>Note:</span> You have to allow us to locate your place to proceed. Make sure to click "allow" in the pop up message appearing on your screen.</div>
                <div class="clearfix"></div>
            </div>
        </div>
        <section id="step1" class="steps hide section-content">
            <div class="section-content-head">
                <i class="fa fa-crosshairs"></i>
                <div>
                    <h3>Register a Remote Place</h3>
                    <p>Help us locate you better by filling one of the 3 forms below </p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-1">
                <div class="row">
                    <div class="col-md-3"><label>Your Country</label></div>
                    <div class="col-md-9">
                        <div class="select-div">
                            <select id="country" name="country" onchange="populate_cities(this, '<?php echo site_url("api/city") ?>');">
                                <option value="0" data-value="">Choose Country</option>
                                <?php foreach ($countries as $country) { ?>
                                    <option value="<?= $country->country_symbol ?>" data-value="<?= $country->country_name ?>" ><?= $country->country_name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"><label>Your City</label></div>
                    <div class="col-md-9">
                        <div class="select-div">
                            <select id="city" name="city">
                                <option value="0" data-value="">Choose City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"><label>Write Your Search Keyword(s)</label></div>
                    <div class="col-md-9"><input id="searchKeywords"  type="text" data-toggle="tooltip"  data-placement="left" title="Write your Address details" ></div>

                    <div class="col-md-12">
                    	<div class="head-title section-content-title">
                            <h3><span style="color:black; font-size:18px">or</span></h3>
                        </div>
                    </div>

                    <div class="col-md-3"><label>Latitude</label></div>
                    <div class="col-md-3"><input name="latitude" id="lat" type="text" data-toggle="tooltip"  data-placement="left" title="Enter Longitude"></div>


                    <div class="col-md-3"><label>Longitude</label></div>
                    <div class="col-md-3"><input name="longitude"  id="lng" type="text" data-toggle="tooltip"  data-placement="left" title="Enter Latitude"></div>

                    <div class="col-md-12">
                    	<div class="head-title section-content-title">
                        	<h3><span style="color:black; font-size:18px">or</span></h3>
                        </div>
					</div>

                    <div class="col-md-3"><label>Google Map URL</label></div>
                    <div class="col-md-9"><input id="googleMapURL" type="text" data-toggle="tooltip"  data-placement="left" title="Google Map URL"></div>

                </div>
                <div class="clearfix"></div>

            </div>
            <div class="clearfix"></div>
             <a onclick="geocodePosition()" class="section-content-a checkin" id="choose-place"><i class="fa fa-arrow-right"></i>Choose Your Place</a>

            <div class="clearfix"></div>
        </section><!-- End section-content -->



        <!--Map Div-->
        <section id="step2" class="steps hide   section-content">
            <div class="section-content-head">
                <i class="fa fa-map-marker"></i>
                <div>
                    <h3>Register Your Place:</h3>
                    <p>To change your place on the map, please drag the map marker to the point you desire or double click it.</p>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="map" >
                <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading map" />
            </div>

            <div class="clearfix"></div>
            <div class="section-content-note"><i class="fa fa-file-text-o"></i><span>Note:</span> You have to allow us to locate your place to proceed. Make sure to click "allow" in the pop up message appearing on your screen.</div>
            <a href="javascript:" class="section-content-a tostep3" id="tostep3" onclick="showstep3()"><i class="fa fa-arrow-right"></i>Proceed to Step 2</a>
            <div class="clearfix"></div>
        </section><!-- End section-content -->






        <section  id="step3" class=" steps hide section-content">
            <div class="section-content-head">
                <i class="fa fa-copy"></i>
                <div>
                    <h3>Complete Location Details:</h3>
                    <p>Complete your LocName details, so that people can know more about your location. </p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">

                <div class="col-md-6 form-register-locname">
                    <div class="row">
                        <div class="col-md-4"><label>Your LocName<span class="required-label">*</span></label></div>
                        <div class="col-md-8">
                            <div class="name-available">
                                <div class="form-input">
                                    <input type="text" name="title" class="highlighted locNamebox" required id="title" maxlength="30" data-parsley-trim-value="true" parsley-type="alphanum" parsley-remote="<?= site_url("api/checkLocationName"); ?>" parsley-trigger="change" parsley-rangelength="[6,30]" placeholder="Choose LocName" data-toggle="tooltip"  data-placement="left" title="Choose Your LocName"  />
                                </div>
                                <div class="name-available-div name-available-yes"><i class="fa fa-check"></i>Available</div>
                                <div class="name-available-div name-available-not"><i class="fa fa-times"></i>Not available</div>
                            </div>
                        </div>
                        <div class="col-md-4"><label>Address<span class="required-label">*</span></label></div>
                        <div class="col-md-8">
                            <div class="form-input">
                                <input type="text" class="required-item" placeholder="Write Your Address" data-parsley-required="true" id="address" name="address" data-toggle="tooltip" data-placement="left" title="Edit Address" />
                                <input type="hidden" data-parsley-required="true" id="actual_address" name="actual_address" />
                            </div>
                        </div>
                        <div class="col-md-4"><label>Building & Flat</label></div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Building Number" id="building_number" name="building_number" data-toggle="tooltip" data-placement="right" title="Enter the building number" />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Flat Number" id="flat_number" name="flat_number" data-toggle="tooltip" data-placement="left" title="Enter Flat Number" />
                                </div>
                            </div>
                        </div>
                        <?php if($templocation){ ?>
                        <div class="col-md-4"><label>Postal Code </label></div>
                        <div class="col-md-8"> <input type="text" placeholder="Postal Code" id="postal_code" name="postal_code" data-toggle="tooltip" data-placement="left" title="Enter Postal Code "/></div>
                        <?php } ?>
                        <div class="col-md-4"><label>Mobile Number</label></div>
                        <div class="col-md-8"> <input type="text" placeholder="Location Mobile" id="mobile" name="mobile" data-toggle="tooltip" data-placement="left" title="Enter Mobile Number "/></div>
                        <div class="col-md-4"><label>Privacy</label></div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="select-div">

                                        <select class="privacy" name="is_private" id="is_private" >
                                            <option value="0">Public Place</option>
                                            <option value="1">Private Passcode</option>
                                            <option value="2">Private Facebook</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="passcode" placeholder="Write Your Passcode" id="passcode" name="passcode" data-toggle="tooltip" data-placement="left" title="Enter Private Passcode" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"><label>Location Type</label></div>
                        <div class="col-md-8">

                            <div class="">
                                <div class="select-div">
                                    <select class="location-type locationType" required name="type" id="locationType">
                                        <option value="general">General</option>
                                        <option value="public">Public</option>
                                        <option value="business">Business</option>
                                        <option value="personal">Personal</option>
                                        <option value="event">Event</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"><label id="locationCategoryLbl" style="display: none;">Location Category</label></div>
                        <div class="col-md-8">
                            <div class="select-div locationCategoryDiv" style="display: none;">
                                <select class="dlocationCategory locationCategory" name="category_id" id="locationCategory">
                                    <option value="0">Select Category</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4"><label>Website URL</label></div>
                        <div class="col-md-8"><input class="" type="text" name="website" id="locationWebsite" placeholder="Location Website" data-toggle="tooltip" data-placement="left" title="Enter Website Address"></div>
                        <div class="col-md-4"><label>Email Account</label></div>

                        <div class="col-md-8"><input type="text" name="email" id="locationMail" placeholder="Location Email" data-toggle="tooltip" data-placement="left" title="Enter You Email Address"></div>
                        <div class="col-md-4"><label>Add Gallery</label></div>
                        <div class="col-md-8">
                            <div class="fileinputs">
                                <input type="file" multiple="" name="photos[]" class="file file-fake" accept="image/*" onchange="gallery(this)">
                                <div class="fakefile">
                                    <button id="photo_text" type="button" class="button small margin-0">Select Files</button>
                                    <span>Browse</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id='files-names' style="padding-left:10px;"><ul></ul></div>
                        </div>
                        <div class="col-md-12">
                            <p class="small">800x600 is the best resolution & Allowed formats are: gif, jpg, png, and jpeg</p>
                        </div>
                        <div class="col-md-4"><label>Description</label></div>
                        <div class="col-md-8">
                            <textarea rows="5" name="details" id="details" placeholder="Write here a brief description what is this LocName about" data-toggle="tooltip" data-placement="left" title="Write Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="button" class="section-content-a tostep4" id="tostep4" onclick="showstep4(<?= (isset($user->id) ? $user->id : false ) ?>)"><i class="fa fa-arrow-right"></i>Proceed to Step 3</button>
                    <button type="reset" class="section-content-a section-content-reset" onclick="resetFile()"><i class="fa fa-eraser"></i>Empty All Fields</button>
                </div>

            </div>
        </section><!-- End section-content -->



        <section id="step4" class="steps hide section-content section-login">
            <div class="section-content-head">
                <i class="fa fa-user"></i>
                <div>
                    <h3>Login To Proceed</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="section-content-note"><i class="fa fa-file-text-o"></i><span>Note:</span> Be careful, if you don’t login, your LocName will not be registered.</div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="head-title section-content-title"><h3><span>Login With Social Networks</span></h3></div>
                    <a class="facebook-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
                    <a class="google-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Google/home") ?>');">Google+ Account</a>
                </div>
                <div class="col-md-6">
                    <div class="head-title section-content-title"><h3><span>Login With Your Account</span></h3></div>
                    <div class="section-content-note section-content-note-4 section-content-alert autherror" style="display: none"><i class="fa fa-times"></i><span>Note:</span> <span class="autherror"></span></div>
                    <div class="user-name">
                        <input type="text" placeholder="Email" id="identity" name="username" data-toggle="tooltip" data-placement="left" title="Enter Your Email"/>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="user-pass">
                        <input type="password" class="" placeholder="Password" id="userpassword" name="password" data-toggle="tooltip" data-placement="left" title="Enter Your Password" />
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="clearfix"></div>
                    <input type="checkbox" checked="checked"><label class="user-checked">Save my password</label>
                    <div class="clearfix"></div>

                    <input type="submit" class="login-loc-login-home" value="Login Now">
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="section-login-r">Don’t Have Account? <a class="register_popup" href="<?= site_url("auth/register")?>">Register Now</a> | <a href="<?= site_url("auth/forgot_password")?>">Forgot password</a></div>
            <div id="finishing"  class="hide"></div>
        </section><!-- End section-content -->

    </section><!-- End main-container -->
</form>
<script type="text/javascript">
$(document).ready(function() {
    var templocation=<?php echo json_encode($templocation )?>;
    if(templocation)
    {
        $('#checkin-here').click();
        $('#tostep3').click();
        $('#building_number').val(templocation.building_number); 
        $('#address').val(templocation.address);
        $('#flat_number').val(templocation.flat_number);
        $('#country').val(templocation.country);
        $('#city').val(templocation.city);
        $('#lat').val(templocation.latitude);
        $('#lng').val(templocation.longitude);
        $('#postal_code').val(templocation.postal_code);

        console.log(templocation);
    }
});
</script>
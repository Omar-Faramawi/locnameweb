<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" prefix="og: http://ogp.me/ns#"  lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" prefix="og: http://ogp.me/ns#" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html  prefix="og: http://ogp.me/ns#" lang="en"> <!--<![endif]-->
    <head>
        <!-- Optimizely Code -->
        <script src="//cdn.optimizely.com/js/2320730256.js"></script>

        <style>
            .controls {
                margin-top: 16px;
                border: 1px solid transparent;
                border-radius: 2px 0 0 2px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                height: 32px;
                outline: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            }

            #pac-input {
                background-color: #fff;
                font-family: Roboto;
                font-size: 15px;
                font-weight: 300;
                margin-left: 12px;
                padding: 0 11px 0 13px;
                text-overflow: ellipsis;
                width: 400px;
            }

            #pac-input:focus {
                border-color: #4d90fe;
            }

            .pac-container {
                font-family: Roboto;
            }

            #type-selector {
                color: #fff;
                background-color: #4d90fe;
                padding: 5px 11px 0px 11px;
            }

            #type-selector label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }

        </style>

        <style type="text/css">
            .fb-flash{
                position: fixed;
                width:70%;
                padding: 10px;
                color:#000;
                background-color: #DFD281;
                border:1px solid #C9BB5D;
                z-index : 5;
                top:15%;
                left:15%;
                border-radius: 3px;
                display: none;
            }
            .twitter-typeahead{
                width:100%;
            }
            .tt-input{
                width:inherit;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #e0e0e0;
                outline: none;
            }
            .tt-dropdown-menu{
                width:100%;
                background-color: #fff;
                border-radius: 5px;
                border: 1px solid #e0e0e0;
                margin-top: 5px;
                margin-bottom: 30px;
            }
            .tt-suggestion.tt-cursor{
                background-color: #0097cf;
                color:#fff;
            }
            .tt-suggestion{
                padding: 5px 10px;
                margin:0;
                cursor: pointer;
            }
            .tt-suggestion p{
                margin: 5px 0;
            }
            .league-name{
                padding:5px 0px 5px 5px;
                color:#585858;
                text-align: center;
                background-color: #efefef;
                margin-top: 0px;
            }
            .custom-tooltip-styling div{
                font-size: 10px !important;
                color:#000;
                width:230px;
            }
        </style>
        <!-- KISSmetrics Script -->
        <script type="text/javascript">var _kmq = _kmq || [];
            var _kmk = _kmk || '2e9ab1315413d58421ecbf4673e39f4a2d70b82a';
            function _kms(u) {
                setTimeout(function () {
                    var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script');
                    s.type = 'text/javascript';
                    s.async = true;
                    s.src = u;
                    f.parentNode.insertBefore(s, f);
                }, 1);
            }
            _kms('//i.kissmetrics.com/i.js');
            _kms('//doug1izaerwt3.cloudfront.net/' + _kmk + '.1.js');</script>

        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title><?php if ($site_title) { ?><?= $site_title ?> |  <?php } ?><?= $page_title ?></title>
        <meta name="description" content="LocName web and mobile applications convert GPS coordinates to short & unique names, users can find & reach locations easily using our GPS navigation system">
        <meta name="keywords" content="GPS coordinates, navigation app, GPS converter, coordinates converter,GPS navigation, address book">

        <link rel="shortcut icon" type="image/png" href="<?= base_url("assets") ?>/favicon.png"/>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- Main Style -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url("assets/main") ?>/css/rateit.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <!-- Tooltip  -->
        <script type="text/javascript">
            $(function () {
                $("input[data-toggle='tooltip']").tooltip({
                    tooltipClass: "custom-tooltip-styling"
                });
            });
        </script>
        <!-- Responsive Style -->
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/css/responsive.css">
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/css/colorbox.css">
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/css/slick.css">
        <link rel="stylesheet" href="<?= base_url("assets/main") ?>/css/demo.css">

        <meta property="og:site_name" content="<?= $site_title ?>"/>
        <meta property="og:description" content="<?= (isset($metaDesc) && strlen($metaDesc) > 2 ) ? $metaDesc : site_url() ?>"/>
        <meta property="og:image" content="<?= (isset($metaImg) && strlen($metaImg) > 2 ) ? $metaImg : base_url("assets/loc/images/Logo_full_big.png") ?>"/>
        <!-- <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="300" />-->
        <meta property="og:title" content="<?= $site_title ?>|<?= $page_title ?> "/>

        <script type="text/javascript" src="<?= base_url("assets/mobile/redirection-mobile.js") ?>"></script>
        <script type="text/javascript">
             SA.redirection_mobile ({
             redirection_param : "mobile_redirection",
             mobile_prefix : "m",
             cookie_hours : "1"
             });
        </script>

        <script>
            window.site_url = "<?= site_url() ?>";
        </script>

        <script>
            function loadNumNotifications()
            {
                $(function () {
                    $.get("<?= site_url("api/num_new_notifications") ?>", function (data) {
                        $("#num_notifications").html(data);
                    });
                });
            }
<?php
if ($this->ion_auth->logged_in()) {
    ?>
                setInterval(loadNumNotifications, 5000);
    <?php
}
?>
        </script>

        <script>
            //setTimeout(function () {
            //var url = document.URL;
            //url = url.substring(url.indexOf(":") + 3);
            //alert(url);
            //window.location = "locname://" + url;
            //window.location = "https://itunes.apple.com/app/id832556410";
            //}, 25);
            function ucfirst(string) {
                var title = string;
                var firstChar = title.charAt(0).toUpperCase();
                var restString = title.substring(1);
                var finalString = firstChar.concat(restString);
                return finalString;
            }
        </script>

        <?php
        if ($this->session->userdata('location_just_created')) {
            ?>
            <!-- Facebook Conversion Code for LocName - Register place -->
            <script>(function () {
                    var _fbq = window._fbq || (window._fbq = []);
                    if (!_fbq.loaded) {
                        var fbds = document.createElement('script');
                        fbds.async = true;
                        fbds.src = '//connect.facebook.net/en_US/fbds.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(fbds, s);
                        _fbq.loaded = true;
                    }
                })();
                window._fbq = window._fbq || [];
                window._fbq.push(['track', '6024718737107', {'value': '0.00', 'currency': 'USD'}]);
            </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6024718737107&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
    <?php } ?>

</head>
<body>
    <?php include_once APPPATH . "views/common/analyticstracking.php" ?>

    <?php
    //$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    //if(stripos($ua,'iphone') !== false || stripos($ua,'ipad') !== false || stripos($ua,'ipod') !== false) {
    //$url = "locname://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //try {
    //get_headers($url);
    //$ch = curl_init();
    //curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //$data = curl_exec($ch);
    //$headers = curl_getinfo($ch);
    //curl_close($ch);
    //print_r($headers);
    //if(file_get_contents($url) !== false)
    //header("Location: $url", true, 302);
    //}
    //catch (Exception $e) {
    //}
    //}
    ?>
    <?php
    if (strpos(base_url(uri_string()), 'auth/login') === FALSE)
        $this->session->set_userdata(array('current_url' => base_url(uri_string())));
    ?>
    <?php
    $message = $this->session->flashdata('success2');
    if ($message) {
        ?>
        <div class="fb-flash"><?php echo $message; ?></div>
        <script type="text/javascript">
            $('.fb-flash').show();
            setTimeout(fadeflash, 3000);
            function fadeflash() {
                $('.fb-flash').fadeOut(2000);
            }
        </script>
        <?php
    }
    ?>

    <div class="modal fade" id="suggestionsModal" tabindex="-1" role="dialog" aria-labelledby="suggestionsModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="z-index:1060;">
            <div class="modal-content invite-box">
                <div class="modal-header header-invite-box">
                    <!--<h4>Promot your profile</h4>-->
                    <button type="button" class="close" data-dismiss="modal" style="margin-top: -4px;margin-right: 1px;" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="padding-bottom:29px;">
                  <center><h4 class="modal-title" id="suggestionsModalLabel">You have used all your free LocNames</h4>
                  <ul id="suggestionsList" style="list-style:none; padding: 16px;">
                    <li>To get more free LocNames please</li>
                  </ul>
                  </center>
                  <div><center><a class="btn btn-danger btn-block" id="ifg2" data-dismiss="modal"><img style="width: 34px;height: 26px;" src='assets/images/gmail_new.png'>Invite your Gmail contacts</a></center></div>
                  <div><center>~ OR ~</center></div>
                  <div>
                    <center>
                      <textarea class='text-area-box' placeholder="Add emails (each in one line)" name="emailsToInvite" id="emailsToInvite"></textarea>
                      <button  class='btn btn-primary btn-block' id="do_manual_invite" style="margin-top: 10px;margin-bottom: -13px;">Send</button>
                  </center>
                </div>
                </div>
                <div class="modal-footer" style="background-color: #efefef; display:none;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success" id="sc" href="<?= site_url("user/friends") ?>">Sync Contacts</a>
                </div>
            </div>
        </div>
    </div>

    <div class="feedback-badge" id='open-feedback'>Feedback</div>
    <div class="panel-pop panel-pop-feedback" style="width:500px;">
        <div align="right"><a class="hide-popup" title="Close" style="color:#FF0000"><b>close</b></a>&nbsp;</div>

        <h3>Feedback</h3>
        <div class="panel-pop-content">
            <form id="feedbackform" class="form-js form-contact" method="POST" action="<?php echo site_url() . 'index/feedback'; ?>">
                <div class="row">
                    <div class="col-md-6"><div class="form-input">
                            <input type="text" name="name" class="required-item" placeholder="Name:" value="<?= set_value('name') ?>" data-toggle="tooltip"  data-placement="left" title="Enter Your Name">
                            <i class="fa fa-user"></i>
                        </div></div>
                    <div class="col-md-6"><div class="form-input">
                            <input type="text"  name="email" class="required-item" placeholder="Email:" value="<?= set_value('email') ?>" data-toggle="tooltip"  data-placement="left" title="Enter Your Email">
                            <i class="fa fa-envelope"></i>
                        </div></div>
                    <div class="col-md-12" style="margin-bottom:5px;"><div class="form-input">
                            <select class='select-feedback-cat required-item' name='feedback-cat'>
                                <option value="category">Category</option>
                                <option value="problem">Problem</option>
                                <option value="idea">Idea</option>
                                <option value="compliment">Compliment</option>
                                <option value="question">Question</option>
                            </select>
                            <i class="fa fa-folder"></i>
                        </div></div>
                    <div class="col-md-12"style="margin-bottom:5px;"><div class="form-input">
                            <textarea style="background-color: #f5f6f8;
                                      color: #848994; width:100%; border-radius:5px; border:1px solid #e9eaec;" rows="8" name="message" class="required-item" placeholder="Message:" data-toggle="tooltip"  data-placement="left" title="Write Your Feedback"><?= set_value('message') ?></textarea>
                            <i class="fa fa-comment"></i>
                        </div></div>
                        <div class="col-md-12" style="margin-bottom:5px;">
                            Type this captcha in the field below it:<br>
                            <?php
                            //var_dump($captcha);
                             echo $image; ?>
                        </div>
                        <div class="col-md-12">
                            <div class="form-input">
                            <input type="text" id='captcha' name="captcha" class="required-item" placeholder="captcha:">
                            </div>
                        </div>
                    <div class="col-md-12"><div class="form-input">
                            <button type="submit" class='btn btn-primary' style="width:100%; margin-top:5px;">Send Message</button>
                        </div></div>
                </div>
            </form>
        </div>
    </div><!-- End panel-pop -->
    <div class="panel-pop panel-pop-login">
        <div align="right"><a class="hide-popup" title="Close" style="color:#FF0000"><b>Close</b></a>&nbsp;</div>
        <h3>Login Area</h3>
        <div class="panel-pop-content">
            <form method="post" action="<?= site_url("auth/login") ?>">
                <div class="user-name">
                    <input type="email" placeholder="Email Address" name="identity" id="identityinput" data-toggle="tooltip"  data-placement="left" title="Enter Your Email" />
                    <i class="fa fa-user"></i>
                </div>
                <div class="user-pass">
                    <input type="password" name="password" id="password" placeholder="Password" data-toggle="tooltip"  data-placement="left" title="Enter Your Password" />
                    <i class="fa fa-lock"></i>
                </div>
                <div class="clearfix"></div>
                <input id="save_password" type="checkbox" checked="checked" /><label for="save_password" class="user-checked">Save my password</label>
                <div class="clearfix"></div>
                <input type="submit" value="Login Now" />
                <div class="clearfix"></div>
                <div class="head-title"><h3><span>Login With</span></h3></div>
                <a class="facebook-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
                <a class="google-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Google/home") ?>');">Google+ Account</a>
                <div class="clearfix"></div>
            </form>
        </div>
        <div class="panel-pop-footer">
            <a class='register_popup' href="<?= site_url("auth/register") ?>">Register Now</a> | <a href="<?= site_url("auth/forgot_password") ?>">Forgot Password</a>
        </div>
    </div><!-- End panel-pop -->

    <div class="panel-pop panel-pop-register">
        <div align="right"><a class="hide-popup" title="Close" style="color:#FF0000"><b>Close</b></a>&nbsp;</div>
        <h3>Register A New User</h3>
        <div class="panel-pop-content">
            <form method="post" action="<?= site_url("auth/register") ?>">
                <input type="email" placeholder="Email Address" name="email" id="email" data-toggle="tooltip"  data-placement="left" title="Enter Email Address" />
                <input type="text" placeholder="First Name" name="first_name" id="first_name" data-toggle="tooltip"  data-placement="left" title="Enter Your First Name" />
                <input type="text" placeholder="Last Name" name="last_name" id="last_name" data-toggle="tooltip"  data-placement="left" title="Enter Your Last Name" />
                <input type="password" placeholder="Password" name="password" id="password" data-toggle="tooltip"  data-placement="left" title="Enter Password" />
                <input type="password" placeholder="Confirm Password" name="password_confirm" id="password_confirm" data-toggle="tooltip"  data-placement="left" title="Confirm Password" />
                <div class="clearfix"></div>
                <span class="small">By clicking "Register Now" you are agreeing to the </span> <a class="small" href="<?php echo site_url('index/terms') ?>">Terms and Conditions.</a>
                <input type="submit" value="Register Now" />
                <div class="clearfix"></div>
                <div class="head-title"><h3><span>Register With</span></h3></div>
                <a class="facebook-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
                <a class="google-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Google/home") ?>');">Google+ Account</a>
                <div class="clearfix"></div>
            </form>
        </div>
    </div><!-- End panel-pop -->

    <div class="panel-pop panel-pop-invite">
        <div align="right"><a class="hide-popup" title="Close" style="color:#FF0000"><b>Close</b></a>&nbsp;</div>
        <h3>Invite Google+ Friends</h3>
        <div class="panel-pop-content" style="max-height: 417px;overflow: auto;">
            <form method="post" onsubmit="return false;" >
                <div id="invite_emails"></div>
                <div class="clearfix"></div>
                <input type="submit" value="Invite" id="do_google_invite" />
                <div class="clearfix"></div>
            </form>
        </div>
    </div><!-- End panel-pop -->

    <div id='geolocerror' style='background-color:#DFD281; color:#000; text-align:left; padding:10px; display:none;'>
        <i class="glyphicon glyphicon-exclamation-sign"></i> <span id='geolocation-error'></span> <a style="cursor:pointer;" id='learn-enable-browser-location'>Learn how to enable it</a>
        <div id='enable-for-chrome' style='display:none;'>
            <h4>Chrome : </h4>
            <ol>
                <li>Click the Chrome menu <img src="//storage.googleapis.com/support-kms-prod/4003BF51063E6DC3E65713AE5B50EE797EE6" width="18" height="18" alt="Chrome menu" title="Chrome menu"> on the browser toolbar.</li>
                <li>Select <strong>Settings</strong>.</li>
                <li>Click <strong>Show advanced settings</strong>.</li>
                <li>In the "Privacy" section, click <strong>Content settings</strong>.</li>
                <li>In the dialog that appears, scroll down to the "Location" section. Select your default permission for future location requests:
                    <ul>
                        <li><strong>Allow all sites to track your physical location</strong>: Select this option to let all sites automatically access your location.</li>
                        <li><strong>Ask&nbsp;when a site tries to track your&nbsp;physical location</strong>: Select this option if you want Google Chrome to alert you whenever a site requests your location.</li>
                        <li><strong>Do not allow any site to track your&nbsp;physical location</strong>: Select this option to automatically deny site requests for your location.</li>
                    </ul>

                </li>
            </ol>
        </div>
        <div id='enable-for-firefox' style="display:none;">
            <h4>Firefox : </h4>
            <ul><li>Click the "Site Identity Button" (globe/padlock) on the location bar
                </li><li>Click "More Information" to open "Tools &gt; Page Info" with the Security tab selected
                </li><li>Go to the Permissions tab (Tools &gt; Page Info &gt; Permissions) to check the permissions for the domain in the currently selected tab
                </li></ul>
        </div>
        <div id='enable-for-opera' style='display:none;'>
            <h4>Opera : </h4>
            go to Settings > Preferences > Advanced > Network, and check "Enable geolocation".
        </div>
        <div id='enable-for-ie' style='display:none;'>
            <h4>IE : </h4>
            Under Tools>> Internet Options>> Privacy - look under the Location section, press the "Clear Sites" button and be sure "Never allow websites to request your physical location" is unchecked. Press OK.
        </div>
        <div id='enable-for-safari' style='display:none;'>
            <h4>Safari : </h4>
            You can reset website authorizations in Safari 5 by choosing Reset Safari from the Safari menu, then enabling "Reset all location warnings" checkbox (don't select the other checkboxes unless you are sure you want to reset those as well).
        </div>
    </div>

    <header id="header">
        <div class="warning-message" style="display:none"><p>Please accept to find your exact address</p><span class="msg-close"></span></div>
        <div id="top-thin-bar">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-xs-10 col-sm-6 clearfix">
                        <h3 class="pull-left">Mobile App</h3>
                        <ul class="pull-left">
                            <li class="pull-left android-app"><a href="https://play.google.com/store/apps/details?id=com.locname.v2"></a></li>
                            <li class="pull-left vertical-sep"></li>
                            <li class="pull-left ios-app"><a href="https://itunes.apple.com/app/id832556410"></a></li>
                        </ul>
                    </div>
                    <ul class="thin-menu pull-right clearfix hidden-xs">
                        <li class="pull-left"><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="<?php echo site_url() . 'index/about'; ?>">About Us</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="http://blog.locname.com">Blog</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="http://api.locname.com"> API</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="<?php echo site_url() . 'index/contact'; ?>">Contact Us</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right visible-xs-inline-block" id="xs-navbar">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url(); ?>">Home</a></li>
                                <li><a href="<?php echo site_url() . 'index/about'; ?>">About Us</a></li>
                                <li><a href="http://blog.locname.com">Blog</a></li>
                                <li><a href="<?php echo site_url() . 'index/api'; ?>">API</a></li>
                                <li><a href="<?php echo site_url() . 'index/contact'; ?>">Contact Us</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="beta-label"></div>
        </div>
        <nav id="main-header" class="navbar navbar-default custom" style="z-index:2;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <img class="header-logo" src="<?= site_url("assets/loc/images/logo.png") ?>" style='cursor:pointer;' onclick="window.location = '<?= site_url(); ?>'">
                        <img class="header-logo-small" src="<?= site_url("assets/loc/images/logo-small.png") ?>"  style='cursor:pointer;' onclick="window.location = '<?= site_url(); ?>'">
                        <?php
                        $this->user = $this->ion_auth->user()->row();
                        $user = $this->user;
                        $this->data['user'] = $user;
                        $username = (strlen($this->data["user"]->first_name) > 15) ? substr($this->data["user"]->first_name, 0, 15) . "..." : $this->data["user"]->first_name;
                        $user_id = $this->data["user"]->id;
                        $user_group = $this->session->userdata('user_group');
                        ?>
                        <script> window.user_id = "<?= $user_id ?>";</script>
                        <ul class="nav nav-pills navbar-right">
                            <?php if ($this->ion_auth->logged_in()) { ?>
                                <li class="pull-right">
                                    <div class="dropdown" style="margin-top:5px;">
                                        <a class="x" style='border:none;' type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                            <?php echo $username; ?>
                                            <span class="caret" style="color:#2c3e50;border-top: 5px solid;border-right: 5px solid transparent;border-left: 5px solid transparent; margin-left:7px;"></span>
                                        </a>
                                        <ul class="dropdown-menu ddlist" role="menu" aria-labelledby="dropdownMenu1" style="margin-top: 21px; margin-right:-23px !important;">
                                            <li style="height:0px;"><span class="caret caret-reversed"></span> </li>
                                            <?php if ($user_group == 1 || $user_group == 3) { ?>
                                                <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("admin/index") ?>">Admin Control Panel</a></li>
                                            <?php } ?>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("user/locations") ?>">Locations</a></li>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("user/friends") ?>">Friends</a></li>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("user/favorites") ?>">Favourites</a></li>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("notifications") ?>">Notifications</a></li>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("user/update") ?>">Edit Profile</a></li>
                                            <li role="presentation"><a class='ddlistlink' role="menuitem" tabindex="-1" href="<?= site_url("auth/logout") ?>">Log out</a></li>
                                        </ul>
                                        &nbsp;&nbsp;&nbsp;<a id="num_notifications" href="<?= site_url("notifications") ?>"></a>
                                    </div>
                                </li>
                            <?php } else { ?>
                                <li class="li-custom pull-right"><a href="<?= site_url("auth/register") ?>" id='registerHome' style="padding: 6px 5px;width:80px;border-radius: 2px;" class="btn btn-custom-spin">Sign Up</a></li>
                                <li class="pull-right"><a id='loginHome' style="cursor:pointer;padding: 6px 5px;width:67px;border-radius: 2px;" class="btn btn-custom-lighten">Login</a></li>
                            <?php } ?>
                            <li class='delitmeter li-custom pull-right'></li>
                            <li class="li-custom pull-right" id="header-search">
                                <div class="input-group custom-li" style="width:308px;" id="remote">
                                    <input class="header-search form-control" id="searchlocations" country="<?= $this->data['user']->country ?>" type="text" data-toggle="tooltip"  data-placement="left" style='margin-bottom:-5px; height:34px;background-color: #f7f7f7; border-bottom:1px solid #efefef; border-left:1px solid #efefef; border-top:0px solid #efefef; border-radius: 2px 0px 0px 2px;' placeholder="Search LocNames" data-provide="typeahead" autocomplete="off" id="appendedInputButton">
                                    <span class="input-group-btn">
                                        <button id="search-in-nav" class="btn btn-custom-darken" style="border-radius: 0px 2px 2px 0px;" type="button"><i class='glyphicon glyphicon-search'></i></button>
                                    </span>
                                </div>
                            </li>


                        </ul>
                        <!-- <div class="col-md-4">
                             <div class="input-group">
                               <input type="text" class="form-control" placeholder="Search for...">
                               <span class="input-group-btn">
                                 <button class="btn btn-default" type="button"><i class='glyphicon glyphicon-search'></i></button>
                               </span>
                             </div>
                         </div>
                         <div class="col-md-2">
                            <a href="" class='btn btn-success'>Register</a><a href="" class='btn btn-primary'>Log in</a>
                         </div>-->
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <?php
    if ($showSearchHeader)
        $this->load->view("layouts/breadcrumbs");
    ?>
    <?php if (is_home()) { ?>
        <div id="map-helper">
            <div id="mapScrollingHelper"></div>
            <input id="pac-input" class="controls" type="text" placeholder="Search Box">
            <div id='maphomeinfo' style="width:100%; height:549px;">
                <div id='maphomeinfo2' style="width:100%; height:627px; z-index:1;position:relative;"></div>
            </div>
            <!-- on Mobile browsers only -->
            <div class="row" id="addressform" style="margin-top:-110px;">
                <div class='col-md-12'>
                    <div class="form-group">
                        <input type="text" style="border-radius:0;" class="form-control" id="locationtitle" placeholder="Choose a Locname">
                        <input type="text" style="border-radius:0;" class="form-control" id="locationAddresstext" placeholder="Address">
                        <button type="button" style="border-radius:0;" id='createLocation3' class="btn btn-primary btn-lg btn-block">Save Now</button>
                    </div>
                </div>
            </div>
            <!---->
        </div>
    <?php } else { ?>
    <?php } ?>

    <div style="background-color:#e0e0e0; display:none; padding:50px;">
        <div id='infoboxHome'>
            <div class="head">
                <strong><h3 style="margin: 0;text-align: left;font-size: 20px;padding: 5px 16px; line-height: 26px; font-weight: 400;">Transform all your address details to a short unique name</h3></strong>
            </div>
            <div class='info-box-form'>
                <div style='color:#a94442; margin-top:-10px;'>
                 <!--<i class='glyphicon glyphicon-exclamation-sign'></i>--><label>1- Drag the pin to your exact place</label>
                </div>
                <form>
                    <p>
                        <label>2- Choose Your LocName<span class="required-label">*</span> <span style="font-size:10px;"> Min. Characters 6</span></label>
                        <br>
                        <input type='text' placeholder="Enter New LocName" data-toggle="tooltip"  data-placement="left" title="LocName must be at minimum 6 characters. LocName must not contain any special characters i.e ( . ) ( , ) ( / ) ...etc "  id='title' class='locNamebox' <?php
                        if ($this->session->userdata('title')) {
                            echo "value = '" . $this->session->userdata('title') . "'";
                        }
                        ?> >
                    <div class="name-available-div name-available-not" style="position:relative;width:127px;display:none;margin-top: -52px;margin-left: 172px;"><i class="fa fa-times"></i>Not available</div>
                    <div class="name-available-div name-available-yes" style="position:relative;width:127px; display:none;margin-top: -52px;margin-left: 172px;"><i class="fa fa-check"></i>Available</div>
                    </p>

                    <p>
                        <label>3- Complete Your Address<span class="required-label">*</span></label>
                        <br>
                        <input type='text' data-toggle="tooltip" autocomplete="off" data-placement="left" id="address2">
                    </p>
                    <p style="margin-top: -8px;">
                        <input id="password-on-map" type="checkbox"/>Make this place private
                        <input type='password' placeholder="Password" id="passwordInfobox" style="display:none;">
                    </p>
                    <p style="text-align:center;">
                        <a class="btn btn-custom-spin" style="margin-top: 0px; font-size: 16px; padding: 8px 28px;height: auto;font-weight: normal;" id='createLocation'>Save Now</a>
                        <img src='<?= site_url("assets/main/img/sloading.gif") ?>' id='loadingIcon' style="display:none;width:30px;height:30px;">
                    </p>
                </form>
            </div>
            <div class="arrow-left"></div>
        </div>
        <div id='infoboxHome2'>
            <div class="head">
                <strong><h3 style="margin: 0;text-align: left;font-size: 20px;padding: 5px 16px; line-height: 26px; font-weight: 400;">Transform all your address details to a short unique name</h3></strong>
            </div>
            <div class='info-box-form'>
                <div style='color:#a94442; margin-top:-10px;'>
                 <!--<i class='glyphicon glyphicon-exclamation-sign'></i>--><label>1- Drag the pin to your exact place</label>
                </div>
                <form>
                    <p>
                        <label>2- Choose Your LocName<span class="required-label">*</span> <span style="font-size:10px;"> Min. Characters 6</span></label>
                        <br>
                        <input type='text' placeholder="Enter New LocName" data-toggle="tooltip"  data-placement="left"  id='title2' class='locNamebox' <?php
                        if ($this->session->userdata('title')) {
                            echo "value = '" . $this->session->userdata('title') . "'";
                        }
                        ?> >
                    <div class="name-available-div name-available-not" style="position:relative;width:127px;display:none;margin-top: -52px;margin-left: 172px;"><i class="fa fa-times"></i>Not available</div>
                    <div class="name-available-div name-available-yes" style="position:relative;width:127px; display:none;margin-top: -52px;margin-left: 172px;"><i class="fa fa-check"></i>Available</div>
                    </p>

                    <p>
                        <label>3- Complete Your Address<span class="required-label">*</span></label>
                        <br>
                        <input type='text' autocomplete="off" data-toggle="tooltip"  data-placement="left" id="address4">
                    </p>
                    <p style="margin-top: -8px;">
                        <input id="password-on-map2" type="checkbox"/>Make this place private
                        <input type='password' placeholder="Password" id="passwordInfobox2" style="display:none;">
                    </p>
                    <p style="text-align:center;">
                        <a class="btn btn-custom-spin" style="margin-top: 0px; font-size: 16px; padding: 8px 28px;height: auto;font-weight: normal;" id='createLocation2'>Save Now</a>
                        <img src='<?= site_url("assets/main/img/sloading.gif") ?>' id='loadingIcon2' style="display:none;width:30px;height:30px;">
                    </p>
                </form>
            </div>
            <div class="arrow-left"></div>
        </div>
    </div>
    <section class="clearfix <?php
    if (is_location() || is_about() || is_home()) {
        echo 'main-container';
    } else {
        echo 'container';
    }
    ?>">

        <?php
        if (is_location() || is_home()) {

        } else {
            echo '<br/><br/>';
        }
        ?>

<?php if ($this->session->flashdata('success')): ?>

            <div class="section-content-note section-content-note-success section-content-alert">
                <i class="fa fa-check"></i><span>Success:</span> <?= get_flashdata("success") ?>
            </div>


        <?php endif ?>

<?php if ($this->session->flashdata('error')): ?>
            <div class="section-content-note section-content-note-error section-content-alert">
                <i class="fa fa-times"></i><span>ERROR:</span> <?= get_flashdata("error") ?>
            </div>


        <?php endif ?>

<?php if ($this->session->flashdata('info')): ?>

            <div class="section-content-note section-content-note-info section-content-alert">
                <i class="fa fa-info"></i><span>Info:</span> <?= get_flashdata("info") ?>
            </div>

        <?php endif ?>

<?php if ($this->session->flashdata('warning')): ?>
            <div class="section-content-note section-content-note-warning section-content-alert">
                <i class="fa fa-warning"></i><span>Warning:</span> <?= get_flashdata("warning") ?>
            </div>

        <?php endif ?>

<?= $yield ?>
    </section><!-- End main-container -->

    <footer id="footer-top" class="footer-inside">
        <section class="lets-get-started clearfix">
            <h3 id="x2x1">Let's get started</h3>
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-5"  id='x2x2'>
                        <h4>Register</h4>
                        <ul class="footer-register clearfix">
                            <?php if (is_home()) { ?>
                                <li><a class="goToHomeMap" href="#maphomeinfo"  id="regscroll"></a></li>
                            <?php } else { ?>
                                <li><a class="goToHomeMap" href="<?= site_url() ?>"></a></li>
<?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-7">
                        <h4>Download Our APPs</h4>
                        <ul class="locname-apps clearfix">
                            <li class="android-app"><a href="https://play.google.com/store/apps/details?id=com.locname.v2"></a></li>
                            <li class="ios-app"><a href="https://itunes.apple.com/app/id832556410"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-social clearfix">
                <ul class="clearfix">
                    <li class="footer-social-title pull-left">Connect us</li>
                    <li class="pull-left"><a target="_blank" href="https://www.google.com/+Locname"><i class="fa fa-google-plus"></i></a></li>
                    <li class="pull-left"><a target="_blank" href="https://www.facebook.com/locname"><i class="fa fa-facebook"></i></a></li>
                    <li class="pull-left"><a target="_blank" href="https://www.twitter.com/loc_name"><i class="fa fa-twitter"></i></a></li>
                    <li class="pull-left"><a target="_blank" href="https://www.linkedin.com/company/locname"><i class="fa fa-linkedin"></i></a></li>
                    <li class="pull-left"><a target="_blank" href="https://www.youtube.com/channel/UC3FKdTUA-kDbMuDYorke6Vg"><i class="fa fa-youtube-play"></i></a></li>
                </ul>
                <div class="centered-line"></div>
            </div>
        </section>
    </footer><!-- End footer-top -->
    <footer id="footer-bottom">
        <section class="container clearfix">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <ul class="clearfix">
                        <li class="pull-left"><a href="<?= site_url("index/contact") ?>">Contact us</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="<?= site_url("index/about") ?>">About Us</a></li>
                        <li class="pull-left vertical-sep"></li>
                        <li class="pull-left"><a href="<?= site_url("index/privacy") ?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="pull-right">
                    &copy; 2015 LocName.com | <a href="<?= site_url("index/terms") ?>">Terms & Conditions</a>
                </div>
            </div>
        </section>
    </footer><!-- End footer-bottom -->

    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="<?= base_url("assets/main") ?>/js/bootstrap-typeahead.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="<?= base_url("assets/main") ?>/js/parsley.min.js"></script>
    <script src="<?= base_url("assets/main") ?>/js/bootstrap.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery-ui.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/html5.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery.tipsy.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/tabs.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery.prettyPhoto.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery.bxslider.min.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery.appear.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/count-to.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/jquery.inview.min.js"></script>
    <script src="<?= base_url("assets/main/") ?>/js/jquery.cookie.js"></script>
    <script src="<?= base_url("assets/main/") ?>/js/jquery.nicescroll.js"></script>
    <script src="<?= base_url("assets/main/") ?>/js/jquery.colorbox-min.js"></script>
    <script src="<?= base_url("assets/main/") ?>/js/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url() . 'assets/loc/js/typeahead.bundle.js' ?>"></script>
    <script type="text/javascript" src="<?php echo site_url() . 'assets/loc/js/searchloc.js' ?>"></script>

    <?php if ($this->router->fetch_method() != "takeme") { ?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
<?php } ?>
    <script src="<?= base_url("assets/main/") ?>/js/scripts.js"></script>
    <script type="text/javascript" src="<?= base_url("assets/main") ?>/js/jquery.rateit.min.js"></script>
    <script src="<?= base_url("assets/loc/") ?>/js/custom.js"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
    <script type="text/javascript">
                            /* Map Code */

                            var lat, lng, lat2, lng2, flag;
                            var mapHome, markerHome, infobox;
                            $.get('http://ip-api.com/json', function (data) {
                                // initializeMap(data.lat, data.lon, 16, "maphomeinfo2", "infoboxHome2", "address4", "isp");
                                initializeMap(data.lat, data.lon, 16, "maphomeinfo", "infoboxHome", "address2", "isp");
                                if (navigator.geolocation) {
                                    flag = 1;
                                    navigator.geolocation.getCurrentPosition(showP, showE);
                                    setTimeout(function () {
                                        showWarning();
                                    }, 500);

                                } else {
                                    error('Geo Location is not supported');
                                }
                            });


                            ///////////////////////////Center Map contrller/////////////////////////////////////////////////////////////////////////////
                            function CenterControl(controlDiv, map, coords, markerHome, infobox) {
                                var controlUI = document.createElement('div');
                                controlUI.style.backgroundColor = "#ffffff";
                                controlUI.style.backgroundImage = "url('assets/Maps-Center-Direction-icon.png')";
                                controlUI.style.backgroundSize = "28px 28px";
                                controlUI.style.backgroundRepeat = "no-repeat";
                                controlUI.style.marginRight = "10px";
                                controlUI.style.height = "28px";
                                controlUI.style.width = "28px";
                                controlUI.style.cursor = 'pointer';
                                controlUI.title = 'Click to recenter the map';
                                controlDiv.appendChild(controlUI);

                                google.maps.event.addDomListener(controlUI, 'click', function () {
                                    if (navigator.geolocation) {
                                        flag = 1;
                                        navigator.geolocation.getCurrentPosition(showP, showE);
                                    } else {
                                        error('Geo Location is not supported');
                                    }


                                });

                            }
                            /////////////////////////////////////////////////////////////////////////////////////////

                            function initializeMap(latitude, longitude, zoom, mapCon, infoBoxCon, addressCon, provider) {
                                switch (provider) {
                                    case "isp":
                                        lat2 = latitude;
                                        lng2 = longitude;
                                        break;
                                    case "geo":
                                        lat = latitude;
                                        lng = longitude;
                                }
                                lat = latitude;
                                lng = longitude;
                                var coords = new google.maps.LatLng(lat, lng);
                                var options = {
                                    zoom: zoom,
                                    center: coords,
                                    panControl: true,
                                    mapTypeControl: true,
                                    zoomControl: true,
                                    zoomControlOptions: {
                                        style: google.maps.ZoomControlStyle.LARGE,
                                        position: google.maps.ControlPosition.RIGHT_BOTTOM
                                    },
                                    navigationControlOptions: {
                                        style: google.maps.NavigationControlStyle.SMALL
                                    },
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                mapHome = new google.maps.Map(document.getElementById(mapCon), options);

                                markerHome = new google.maps.Marker({
                                    map: mapHome,
                                    position: coords,
                                    visible: true,
                                    draggable: true
                                });

                                infobox = new InfoBox({
                                    content: document.getElementById(infoBoxCon),
                                    disableAutoPan: false,
                                    maxWidth: 150,
                                    pixelOffset: new google.maps.Size(30, -205),
                                    zIndex: null,
                                    boxStyle: {
                                        width: "370px"
                                    },
                                    infoBoxClearance: new google.maps.Size(1, 1)
                                });
                                infobox.open(mapHome, markerHome);
                                mapHome.panTo(coords);
                                var geocoderObject = new google.maps.Geocoder();
                                var latlng = new google.maps.LatLng(lat, lng);
                                geocoderObject.geocode({'latLng': latlng}, function (results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        if (results[0]) {
                                            document.getElementById(addressCon).value = results[0].formatted_address;
                                            document.getElementById("locationAddresstext").value = results[0].formatted_address;

                                        }
                                    } else {
                                        alert("Geocoder failed due to: " + status);
                                    }
                                });
                                var input = (document.getElementById('pac-input'));
                                mapHome.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                var searchBox = new google.maps.places.SearchBox((input));
                                google.maps.event.addListener(searchBox, 'places_changed', function () {
                                    var places = searchBox.getPlaces();
                                    var cords = places[0].geometry.location;
                                    lat=cords.lat();
                                    lng=cords.lng();
                                    mapHome.setCenter(cords);
                                    markerHome.setPosition(cords);
                                    infobox.open(mapHome, markerHome);

                                    geocoderObject.geocode({'latLng': cords}, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            if (results[0]) {
                                                document.getElementById(addressCon).value = results[0].formatted_address;
                                                console.log(results);
                                            }
                                        } else {
                                            alert("Geocoder failed due to: " + status);
                                        }
                                    });
                                });
                                google.maps.event.addListener(mapHome, 'click', function (event) {
                                    markerHome.setPosition(event.latLng);
                                    infobox.open(mapHome, markerHome);
                                    lat =event.latLng.lat();
                                    lng=event.latLng.lng();
                                    mapHome.panTo(event.latLng);
                                    geocoderObject.geocode({'latLng': event.latLng}, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            if (results[0]) {
                                                document.getElementById(addressCon).value = results[0].formatted_address;
                                                console.log(results);
                                            }
                                        } else {
                                            alert("Geocoder failed due to: " + status);
                                        }
                                    });


                                });

                                google.maps.event.addListener(markerHome, 'dragend', function (event) {
                                    infobox.open(mapHome, markerHome);
                                    mapHome.panTo(coords);
                                    lat = event.latLng.lat();
                                    lng = event.latLng.lng();
                                    latlng = new google.maps.LatLng(lat, lng);
                                    geocoderObject.geocode({'latLng': latlng}, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            if (results[0]) {
                                                document.getElementById(addressCon).value = results[0].formatted_address;
                                                document.getElementById("locationAddresstext").value = results[0].formatted_address;
                                                console.log(results);
                                            }
                                        } else {
                                            alert("Geocoder failed due to: " + status);
                                        }
                                    });
                                });
                                var centerControlDiv = document.createElement('div');
                                var centerControl = new CenterControl(centerControlDiv, mapHome, coords, markerHome, infobox);

                                centerControlDiv.index = 1;
                                mapHome.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(centerControlDiv);
                                // console.log($('#maphomeinfo').html());
                                google.maps.event.addDomListener(window, 'load', initialize);
                            }

                            function showP(position) {
                                flag = 0;
                                showWarning();
                                var cords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                lat=position.coords.latitude;
                                lng=position.coords.longitude;
                                mapHome.setCenter(cords);
                                markerHome.setPosition(cords);
                                infobox.open(mapHome, markerHome);
                                //initializeMap(position.coords.latitude, position.coords.longitude, 16, "maphomeinfo", "infoboxHome", "address2", "geo");
                                var geocoderObject = new google.maps.Geocoder();
                                geocoderObject.geocode({'latLng': cords}, function (results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        if (results[0]) {
                                            document.getElementById("address2").value = results[0].formatted_address;
                                            document.getElementById("locationAddresstext").value = results[0].formatted_address;
                                            console.log(results);
                                        }
                                    } else {
                                        alert("Geocoder failed due to: " + status);
                                    }
                                });
                            }

                            function showE(error) {
                                flag = 0;
                                showWarning();
                                switch (error.code) {
                                    case error.PERMISSION_DENIED:
                                        initializeMap("<?= $current_country->latitude ?>", "<?= $current_country->longitude ?>", 6);
                                        break;
                                }
                            }
                            function showWarning()
                            {
                                if (flag == 1) {
                                    $(".warning-message").show();
                                } else {
                                    $(".warning-message").hide();
                                }
                            }
                            /* End of Map Code */
                            $(document).ready(function () {
                                $('#loginHome').click(function () {
                                    jQuery(".panel-pop-login").show().animate({"top": "50%"}, 500);
                                    jQuery("body").prepend("<div class='wrap-pop' style='top:0;left:0;'></div>");
                                    wrap_pop();
                                });
                                $("#createLocation").on('click', function () {
                                    if ($(".name-available-not").is(":visible")) {
                                        alert("LocName must be unique");
                                    } else {
                                        $(this).hide();
                                        $("#loadingIcon").show();
                                        var title = $('#title').val();
                                        var lateVar = lat;
                                        var langVar = lng;
                                        var detailsVar = "";
                                        var address = $('#address2').val();
                                        var actual_address = address;
                                        var typeVar = "general";
                                        var categoryVar = 0;
                                        var duration_to = 0;
                                        var duration_from = 0;
                                        var passcode = "";
                                        var is_private = 0;

                                        if ($("#password-on-map").is(':checked') && $('#passwordInfobox').val() != "") {

                                            passcode = $('#passwordInfobox').val();
                                            is_private = 1;
                                        }
                                        var is_event = 0;
                                        var mobile = "";
                                        var website = "";
                                        var email = "";
                                        var building_number = 0;
                                        var flat_number = 0;
                                        if ($('#loginHome').length > 0) {
                                            $.post(site_url + "location/temporary", {
                                                title: title,
                                                latitude: lateVar,
                                                longitude: langVar,
                                                details: detailsVar,
                                                type: typeVar,
                                                category_id: categoryVar,
                                                is_private: is_private,
                                                passcode: passcode,
                                                duration_from: duration_from,
                                                duration_to: duration_to,
                                                is_event: is_event,
                                                mobile: mobile,
                                                address: address,
                                                actual_address: actual_address,
                                                email: email,
                                                website: website,
                                                building_number: building_number,
                                                flat_number: flat_number
                                            });
                                            jQuery(".panel-pop-login").show().animate({"top": "50%"}, 500);
                                            jQuery("body").prepend("<div class='wrap-pop' style='top:0;left:0;'></div>");
                                            $('#loadingIcon').hide();
                                            $('#createLocation').show();
                                            wrap_pop();
                                        } else {
                                            $.post(site_url + "api/check_profile_feature", {feature: "create_location"}, function (result) {
                                                console.log(result);
                                                if (result == "true") {
                                                    $.post(site_url + "location/create", {
                                                        title: title,
                                                        latitude: lateVar,
                                                        longitude: langVar,
                                                        details: detailsVar,
                                                        type: typeVar,
                                                        category_id: categoryVar,
                                                        is_private: is_private,
                                                        passcode: passcode,
                                                        duration_from: duration_from,
                                                        duration_to: duration_to,
                                                        is_event: is_event,
                                                        mobile: mobile,
                                                        address: address,
                                                        actual_address: actual_address,
                                                        email: email,
                                                        website: website,
                                                        building_number: building_number,
                                                        flat_number: flat_number,
                                                    },
                                                            function (result) {
                                                                console.log(result);
                                                                if (result.search(title) < 0) {
                                                                    alert("LocName must be unique");
                                                                    $('#loadingIcon').hide();
                                                                    $("#createLocation").show();
                                                                }
                                                                else {
                                                                    // everything is ok
                                                                    window.location = site_url + title + "?ref=NL";
                                                                }
                                                            });
                                                }
                                                else {
                                                    // get suggestions to promote profile
                                                    $.post(site_url + "api/get_promote_actions", {feature: "create_location"}, function (result) {
//                                    console.log(result);
//                                var obj  = jQuery.parseJSON(result);
//                                    console.log(obj);
                                                        $("#suggestionsList").empty();
                                                        $.each(result, function (key, value) {
                                                            // create list item in suggestions list
                                                            $("#suggestionsList").append(
                                                                    $("<li></li>")
                                                                    .text("To get more free LocNames please "+value)
                                                                    );
                                                            // display corresponding buttons

                                                        });
                                                    });
                                                    $('#loadingIcon').hide();
                                                    $("#createLocation").show();
                                                    $('#suggestionsModal').modal('show');
                                                }
                                            });
                                        }
                                    }

                                });


                                $("#createLocation2").on('click', function () {
                                    if ($(".name-available-not").is(":visible")) {
                                        alert("LocName must be unique");
                                    } else {
                                        $(this).hide();
                                        $("#loadingIcon2").show();
                                        var title = $('#title2').val();
                                        var lateVar = lat2;
                                        var langVar = lng2;
                                        var detailsVar = "";
                                        var address = $('#address4').val();
                                        var actual_address = address;
                                        var typeVar = "general";
                                        var categoryVar = 0;
                                        var duration_to = 0;
                                        var duration_from = 0;
                                        var passcode = "";
                                        var is_private = 0;

                                        if ($("#password-on-map2").is(':checked') && $('#passwordInfobox2').val() != "") {

                                            passcode = $('#passwordInfobox2').val();
                                            is_private = 1;
                                        }
                                        var is_event = 0;
                                        var mobile = "";
                                        var website = "";
                                        var email = "";
                                        var building_number = 0;
                                        var flat_number = 0;
                                        if ($('#loginHome').length > 0) {
                                            $.post(site_url + "location/temporary", {
                                                title: title,
                                                latitude: lateVar,
                                                longitude: langVar,
                                                details: detailsVar,
                                                type: typeVar,
                                                category_id: categoryVar,
                                                is_private: is_private,
                                                passcode: passcode,
                                                duration_from: duration_from,
                                                duration_to: duration_to,
                                                is_event: is_event,
                                                mobile: mobile,
                                                address: address,
                                                actual_address: actual_address,
                                                email: email,
                                                website: website,
                                                building_number: building_number,
                                                flat_number: flat_number
                                            });
                                            jQuery(".panel-pop-login").show().animate({"top": "50%"}, 500);
                                            jQuery("body").prepend("<div class='wrap-pop' style='top:0;left:0;'></div>");
                                            $('#loadingIcon2').hide();
                                            $('#createLocation2').show();
                                            wrap_pop();
                                        } else {
                                            $.post(site_url + "location/create", {
                                                title: title,
                                                latitude: lateVar,
                                                longitude: langVar,
                                                details: detailsVar,
                                                type: typeVar,
                                                category_id: categoryVar,
                                                is_private: is_private,
                                                passcode: passcode,
                                                duration_from: duration_from,
                                                duration_to: duration_to,
                                                is_event: is_event,
                                                mobile: mobile,
                                                address: address,
                                                actual_address: actual_address,
                                                email: email,
                                                website: website,
                                                building_number: building_number,
                                                flat_number: flat_number,
                                            },
                                                    function (result) {
                                                        console.log(result);
                                                        if (result.search(title) < 0)
                                                        {
                                                            alert("LocName must be unique");
                                                            $('#loadingIcon2').hide();
                                                            $("#createLocation2").show();
                                                        }
                                                        else
                                                        {
                                                            // everything is ok
                                                            window.location = site_url + title + "?ref=NL";
                                                        }
                                                    });
                                        }
                                    }
                                });


                                $("#createLocation3").on('click', function () {
                                    // alert("ok");
                                    if ($(".name-available-not").is(":visible")) {
                                        alert("LocName must be unique");
                                    } else {
                                        $(this).val("Saving...");
                                        // $("#loadingIcon2").show();
                                        var title = $('#locationtitle').val();
                                        var lateVar = lat;
                                        var langVar = lng;
                                        var detailsVar = "";
                                        var address = $('#locationAddresstext').val();
                                        var actual_address = address;
                                        var typeVar = "general";
                                        var categoryVar = 0;
                                        var duration_to = 0;
                                        var duration_from = 0;
                                        var passcode = "";
                                        var is_private = 0;

                                        /*if($("#password-on-map2").is(':checked') && $('#passwordInfobox2').val() != ""){

                                         passcode = $('#passwordInfobox2').val();
                                         is_private= 1;
                                         }*/
                                        var is_event = 0;
                                        var mobile = "";
                                        var website = "";
                                        var email = "";
                                        var building_number = 0;
                                        var flat_number = 0;
                                        if ($('#loginHome').length > 0) {
                                            $.post(site_url + "location/temporary", {
                                                title: title,
                                                latitude: lateVar,
                                                longitude: langVar,
                                                details: detailsVar,
                                                type: typeVar,
                                                category_id: categoryVar,
                                                is_private: is_private,
                                                passcode: passcode,
                                                duration_from: duration_from,
                                                duration_to: duration_to,
                                                is_event: is_event,
                                                mobile: mobile,
                                                address: address,
                                                actual_address: actual_address,
                                                email: email,
                                                website: website,
                                                building_number: building_number,
                                                flat_number: flat_number
                                            });
                                            jQuery(".panel-pop-login").show().animate({"top": "50%"}, 500);
                                            jQuery("body").prepend("<div class='wrap-pop' style='top:0;left:0;'></div>");
                                            $('#loadingIcon2').hide();
                                            $('#createLocation2').show();
                                            wrap_pop();
                                        } else {
                                            $.post(site_url + "location/create", {
                                                title: title,
                                                latitude: lateVar,
                                                longitude: langVar,
                                                details: detailsVar,
                                                type: typeVar,
                                                category_id: categoryVar,
                                                is_private: is_private,
                                                passcode: passcode,
                                                duration_from: duration_from,
                                                duration_to: duration_to,
                                                is_event: is_event,
                                                mobile: mobile,
                                                address: address,
                                                actual_address: actual_address,
                                                email: email,
                                                website: website,
                                                building_number: building_number,
                                                flat_number: flat_number,
                                            },
                                                    function (result) {
                                                        console.log(result);
                                                        if (result.search(title) < 0)
                                                        {
                                                            alert("LocName must be unique");
                                                            $('#loadingIcon2').hide();
                                                            $("#createLocation2").show();
                                                        }
                                                        else
                                                        {
                                                            // everything is ok
                                                            window.location = site_url + title + "?ref=NL";
                                                        }
                                                    });
                                        }
                                    }
                                });

                            });
                            function wrap_pop() {
                                jQuery(".wrap-pop").click(function () {
                                    jQuery(".panel-pop,.video-popup,.panel-pop-report").animate({"top": "-100%"}, 500).hide(function () {
                                        jQuery(this).animate({"top": "-100%"}, 500);
                                    });
                                    if (jQuery(this).hasClass("wrap-pop-video")) {
                                        player.pauseVideo();
                                    }
                                    jQuery(this).remove();
                                });
                            }
    </script>



    <?php if (is_home()) { ?>

        <script>
            $("section.main-container").removeClass("container");
        </script>
    <?php } ?>
    <!-- End js -->
<?php
if ($this->session->userdata('location_just_created')) {
    $this->session->unset_userdata('location_just_created');
    ?>
        <!-- Google Code for Place register Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 971030152;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "3_HmCK2gr1gQiP2CzwM";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="//www.googleadservices.com/pagead/conversion/971030152/?label=3_HmCK2gr1gQiP2CzwM&amp;guid=ON&amp;script=0"/>
        </noscript>
<?php } ?>
    <!-- Start of Crazy Egg Script -->
    <script type="text/javascript">
        setTimeout(function () {
            var a = document.createElement("script");
            var b = document.getElementsByTagName("script")[0];
            a.src = document.location.protocol + "//dnn506yrbagrg.cloudfront.net/pages/scripts/0028/2570.js?" + Math.floor(new Date().getTime() / 3600000);
            a.async = true;
            a.type = "text/javascript";
            b.parentNode.insertBefore(a, b)
        }, 1);
    </script>
    <!-- End of Crazy Egg Script -->

    <!-- Google Code for Remarketing Tag -->
    <!--------------------------------------------------
    Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
    --------------------------------------------------->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 971030152;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/971030152/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>
    <!-- End of Google Code for Remarketing Tag -->

    <!-- Facebook Code for Remarketing Tag -->
    <script>(function () {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s);
                _fbq.loaded = true;
            }
            _fbq.push(['addPixelId', '391435477693231']);
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', 'PixelInitialized', {}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=391435477693231&amp;ev=PixelInitialized" /></noscript>
    <!-- End of Facebook Code for Remarketing Tag -->
</body>
</html>
<?php
if ($this->data['user']->id && $this->session->userdata('title')) {
    redirect(site_url('location/create_from_session'));
}
?>

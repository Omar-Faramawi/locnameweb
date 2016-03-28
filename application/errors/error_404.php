<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" prefix="og: http://ogp.me/ns#"  lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" prefix="og: http://ogp.me/ns#" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html  prefix="og: http://ogp.me/ns#" lang="en"> <!--<![endif]-->
    <head>
        <!-- Basic Page Needs -->
        <meta charset="utf-8">
        <title>404 Page Not Found</title>
        <meta name="description" content="Ask me Responsive Questions and Answers Template">

        <link rel="shortcut icon" type="image/png" href="<?= base_url("assets")?>/favicon.png"/>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- Main Style -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url("assets/main") ?>/css/rateit.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <!-- Responsive Style -->
        <link rel="stylesheet" href="<?= base_url("assets/loc") ?>/css/responsive.css">
        <link rel="stylesheet" href="<?= base_url("assets/main") ?>/css/demo.css">

        <meta property="og:site_name" content="<?= $site_title ?>"/>
        <meta property="og:description" content="<?= (isset($metaDesc) && strlen($metaDesc) > 2 ) ? $metaDesc : site_url() ?>"/>
        <meta property="og:image" content="<?= (isset($metaImg) && strlen($metaImg) > 2 ) ? $metaImg : base_url("assets/loc/images/loclogo.png") ?>"/>
        <meta property="og:title" content="<?= $site_title ?>|<?= $page_title ?> #locname"/>

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
			//setTimeout(function () {
				//var url = document.URL;
				//url = url.substring(url.indexOf(":") + 3);
				//alert(url);
				//window.location = "locname://" + url;
				// window.location = "https://itunes.apple.com/app/id832556410";
			//}, 25);
		</script>

        <style type="text/css">
			/* Sub Menu */
			.mymenu li {
				position: relative;
			}
			/* hide the second level menu */
			.mymenu ul {
				display: none;
				margin: 0;
				padding: 0;
				width: 150px;
				position: absolute;
				border:solid 1px #DDD;
				z-index: 1000;
				top: 30px;
				left: 10px;
				background: #ffffff;
			}

			/* display second level menu on hover */
			.mymenu li:hover > ul {
				display: block;
			}

			.mymenu ul li {
				display:block;
				float: none;
				background:none;
				margin:0;
				padding:0;
			}

			.mymenu ul li a {
				font-size:12px;
				font-weight:normal;
				display:block;
				color:#999999;
				border-left:3px solid #ffffff;
				background:#ffffff;
			}

			.mymenu ul li a:hover, .mymenu ul li:hover > a {
				background:#DDD;
				border-left:3px solid #BBB;
				color:#777777;
			}
		</style>
        <script type="text/javascript">
			$(document).ready(function() {
				var touch = $('#touch-menu');
				var menu = $('.mymenu');

				$(touch).on('click', function(e) {
					e.preventDefault();
					menu.slideToggle();
				});

				$(window).resize(function(){
					var w = $(window).width();
					if(w > 767 && menu.is(':hidden')) {
						menu.removeAttr('style');
					}
				});
			});
		</script>

    </head>
    <body class="fixed-enabled" style="padding-top:217px;">
		<?php include_once APPPATH . "views/common/analyticstracking.php" ?>

        <div class="panel-pop panel-pop-login">
        <div align="right"><a class="hide-popup" title="Close" style="color:#FF0000"><b>Close</b></a>&nbsp;</div>
            <h3>Login Area</h3>
            <div class="panel-pop-content">
                <form method="post" action="<?= site_url("auth/login") ?>">
                    <div class="user-name">
                        <input type="text" placeholder="Email Address" name="identity" id="identityinput" placeholder="Email">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="user-pass">
                        <input type="password" name="password" id="password" placeholder="Password">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="clearfix"></div>
                    <input type="checkbox" checked="checked"><label class="user-checked">Save my password</label>
                    <div class="clearfix"></div>
                    <input type="submit" value="Login Now">
                    <div class="clearfix"></div>
                    <div class="head-title"><h3><span>Login With</span></h3></div>
                    <a class="facebook-account" href="JavaScript:newPopup('<?= site_url("auth/login_provider/Facebook/home") ?>');">Facebook Account</a>
                    <a class="google-account hidden" href="#">Google+ Account</a>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="panel-pop-footer">
                <a href="<?= site_url("auth/register") ?>">Register Now</a> | <a href="<?= site_url("auth/forgot_password")?>">Forgot Password</a>
            </div>
        </div><!-- End panel-pop -->

        <nav class="navbar navbar-default navbar-fixed-top custom" style="z-index:1;">
          <div class="container">
            <div class='row'>
                <div class="col-md-6" >
                    <img src="<?= site_url("assets/loc/images/logo.png") ?>"  style='cursor:pointer;' onclick="window.location='<?= site_url(); ?>'">
                </div>
                <div class="col-md-6" style="padding-top:17px;">
                    <ul class="nav nav-pills navbar-right" >
                    
                        <li><a href="<?php echo site_url(); ?>" style='margin-top:-4px;' class='x'>Home</a></li>
                    </ul>
                </div>
            </div>
          </div>
        </nav>
        <section class="container clearfix main-container">
           	<div id="container" class="text-center">
				<h1><?php echo $heading; ?></h1>
				<?php echo $message; ?>
			</div>
        </section><!-- End main-container -->

        <footer id="footer-top" class="footer-inside">
            <section class="container clearfix">
                <div class="row">
                    <div class="col-md-4 widget-footer-1">
                        <h3>ABOUT LocName</h3>
                        <p>
                            <strong>LocName</strong> is an abbreviation of <strong>"Location Name"</strong> which is represented in a web and mobile App that gives a <strong>Short, Unique</strong> Name for your address, and then you can <strong>Share</strong> it with anyone easily in <strong> 2 seconds</strong>
                        </p>
                    </div>
                    <div class="col-md-1 widget-footer-2"></div>
                    <div class="col-md-3 widget-footer-3">
                        <h3>Links</h3>
                        <ul>

                            <li><a href="<?= site_url("index/contact")?>">Contact us </a></li>
                            <li><a href=<?= site_url("index/about")?>>About</a></li>
                            <li><a href="<?= site_url("index/terms") ?>">Terms </a></li>
                            <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.locname">Android App</a></li>
                            <li><a target="_blank" href="https://itunes.apple.com/eg/app/locname/id832556410?mt=8">iOS App</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 widget-footer-4">
                        <h3>Contact Us</h3>
                        <ul>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <div><strong>Address:</strong> The GrEEK Campus, 28 Falaki St., Bab Ellouk, Downtown, Cairo, Egypt</div>
                            </li>

                            <li>
                                <i class="fa fa-envelope"></i>
                                <div><strong>Email:</strong>
                                    <span>info@locname.com</span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </footer><!-- End footer-top -->
        <footer id="footer-bottom">
            <section class="container clearfix">
                <div class="row">
                    <div class="col-md-8">
                        &copy; 2014 LocName.com | <div><a href="<?= site_url("index/terms") ?>">Terms & Conditions</a></div>
                    </div>
                    <div class="col-md-4">
                        <ul class="social">
                            <!--<li><a href="#"><i class="fa fa-mobile-phone"></i></a></li>-->
                            <li><a target="_blank" href="https://plus.google.com/115089269623592028236"><i class="fa fa-play"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/Locname"><i class="fa fa-facebook"></i></a></li>
                            <li><a target="_blank" href="https://twitter.com/Loc_Name"><i class="fa fa-twitter"></i></a></li>
                            <!--<li><a href="#"><i class="fa fa-rss"></i></a></li>-->
                        </ul>
                    </div>
                </div>
            </section>
        </footer><!-- End footer-bottom -->
    </body>
</html>
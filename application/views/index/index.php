<style>
	.ome_bg { background: #f1f1f3; }
	.ome_h3 { color: #2c3f50 !important; font-size: 28px; font-weight: bold; margin-bottom: 0 !important; }
	.ome_span { color: #3399d9 !important; }
	.apu22 { text-align: center; margin: 0 0 30px; }
	.apu22 img { margin-left: 19px; }
	.ome_p { font-family: open sans; font-size: 16px; font-weight: 100; }
</style>


<section id="problem" class="about-sec home-about">
    <div class="wide-section-title">
        <h1>Welcome to <strong>LocName</strong></h1>
    </div>
    <div class="lead"><p>LocName is a web and mobile application that gives a short unique name for your GPS coordinates<br/><br/>Which you can then share easily in just 2 seconds!</p></div>
    <div class="video-player">
        <iframe width="560" height="280" src="//www.youtube.com/embed/GTDMtXLOhn4" frameborder="0" allowfullscreen>It seems that your browser does not support iFrames. You can watch the video on Youtube https://www.youtube.com/watch?v=GTDMtXLOhn4</iframe>
        <div class="lead"><p class="lead"> </p></div>
        <a class="btn btn-info" href="https://www.youtube.com/channel/UC3FKdTUA-kDbMuDYorke6Vg" target="_blank">Check more Videos here</a>
    </div>
    <!-- Display only on Mobile browsers -->
    <div class="video-container"> <iframe src="https://www.youtube.com/embed/GTDMtXLOhn4" frameborder="0" width="560" height="315"></iframe> </div>
    <!---->
</section>
<!-- End section-1 -->

<section class="section-2">
    <div class="why-background"></div>
    <h2 class="why-locname clearfix">How to use <strong>LocName</strong>?</h2>
    <section class="container clearfix">
        <div class="row">
              <div class="why-slider">
                <i class="why-arrow-left disabled"></i>
                <i class="why-arrow-right"></i>
                <div class="slides-cont">
                    <ul class="slides clearfix">
                        <li class="current clearfix pull-left">
                            <div class="why-image pull-right col-xs-12"><img
                                    src="<?= site_url("assets/loc/images/business card 2.png") ?>" style="width:481px; height:316px;" alt=""/></div>
                            <div class="pull-right col-xs-12">
                                <h3>Use <strong>LocName</strong> in your business card</h3>

                                <p>Put your LocName address on your business cards so your clients can easily find your location online. </p>
                            </div>
                        </li>
                        <li class="clearfix pull-left">
                            <div class="why-image pull-right col-xs-12"><img
                                    src="<?= site_url("assets/loc/images/flyer homepage.png") ?>" style="width:481px; height:316px;" alt=""/></div>
                            <div class="pull-right col-xs-12">
                                <h3>Use <strong>LocName</strong> in your flyer</h3>

                                <p>By having your LocName address and QR code on your flyer, your customers will have no trouble finding your place or event!</p>
                            </div>
                        </li>
                        <li class="clearfix pull-left">
                            <div class="why-image pull-right col-xs-12"><img
                                    src="<?= site_url("assets/loc/images/email homepage.png") ?>" style="width:481px; height:316px;" alt=""/></div>
                            <div class="pull-right col-xs-12">
                                <h3>Use <strong>LocName</strong> in your email signature</h3>

                                <p>No email signature is complete without an address. But with a LocName   address, your clients can instantly access your location details by clicking on your LocName hyperlink in your email signature. </p>
                            </div>
                        </li>
                        <li class="clearfix pull-left">
                            <div class="why-image pull-right col-xs-12"><img
                                    src="<?= site_url("assets/loc/images/facebook event homepage.png") ?>" style="width:481px; height:316px;"  alt=""/></div>
                            <div class="pull-right col-xs-12">
                                <h3>Use <strong>LocName</strong> in your facebook event</h3>

                                <p>LocName makes it easier for your clients to reach your events. By clicking the LocName hyperlink or scanning the QR code, your clients can instantly access your address information on the web or mobile applications.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="bullets">
                    <li class="current"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </section>
</section>
<!-- End section-2 -->

<section class="section-3">
    <section class="container clearfix">
        <div class="row">
            <div class="col-md-7">
                <div class="sub-sec-title clearfix">
                    <h3 class="clearfix pull-left">Testimonials</h3>
                    <span class="more-testimonials pull-right">Get more at <a  href="https://play.google.com/store/apps/details?id=com.locname.v2" >“Google Play”</a> or <a href="https://itunes.apple.com/app/id832556410">“App Store”</a></span>
                </div>
                <div class="testimonials-cont">
                    <div class="testimonials-hide">
                        <div class="testimonials-animator">
                            <?php foreach($testimonials as $testimonial) { ?>
                                <div class="single-test">
                                    <div class="test-img pull-left"><img src="<?= $testimonial->photoURL ?>" width="77" height="80" alt=""/></div>
                                    <div class="test-body">
                                        <a><h4><?= $testimonial->name ?></h4></a>
                                        <p>
                                            <img src="<?= site_url("assets/loc/images/test-quote-start.png") ?>" alt=""/>
                                            <span><?= $testimonial->comment ?></span>
                                            <img src="<?= site_url("assets/loc/images/test-quote-end.png") ?>" alt=""/>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="nav-btns">
                        <i class="arrow-left disabled"></i><i class="arrow-right"></i>
                    </div>
                </div>

            </div>
            <div class="col-md-5">
                <div class="sub-sec-title clearfix">
                    <h3 class="clearfix pull-left">Latest locations</h3>
                </div>
                <div class="recent-loc-cont">
                    <div class="recent-loc-hide">
                        <div class="recent-loc-animator">
                        <?php foreach ($recentLocations as $recent) { ?>
                            <div class="single-loc">
                                <div class="loc-img pull-left">
								<?php
								if ($recent->user->photo) {
									if (substr($recent->user->photo, 0, 4) === "http")
										$userphoto = $recent->user->photo;
									else
										$userphoto = base_url("assets") . "/uploads/users_images/" . $recent->user->photo;
									?>
									<img style='width:48px; height:48px;' src="<?=$userphoto ?>" alt=""/>
								<?php }else { ?>
									<i class="fa fa-user fa-3x" style='width:48px; height:48px;color:#3498db' ></i>
								<?php } ?>
								</div>
                                <div class="loc-body">
                                    <h4><?= (strlen($recent->user->first_name." ".$recent->user->last_name) < 25) ? $recent->user->first_name." ".$recent->user->last_name : substr($recent->user->first_name." ".$recent->user->last_name, 0, 22) . "..." ?> created <a href="<?= site_url($recent->title) ?> "><?= ucfirst($recent->title) ?></a></h4>
                                    <p><strong>Address:</strong> <?= $recent->address ?></p>
                                </div>
                            </div>
                        <?php } ?>

                            <!--<div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-2.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Ali Mohsen created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-3.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Ali Mohsen created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-4.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Norah El Ghazouly created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-1.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Ali Mohsen created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-2.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Ali Mohsen created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-3.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Ali Mohsen created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>
                            <div class="single-loc">
                                <div class="loc-img pull-left"><img src="<?= site_url("assets/loc/images/loc-img-4.png") ?>" alt=""/></div>
                                <div class="loc-body">
                                    <h4>Norah El Ghazouly created <a>Mcdonalds-El-Tahrir</a></h4>
                                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="nav-btns">
                        <i class="arrow-left disabled"></i><i class="arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<!-- End section-3 -->

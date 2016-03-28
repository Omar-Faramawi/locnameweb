<section class="contacts-map">
    <iframe title="LocName Location" height="340" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;sspn=0.128988,0.222988&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;t=m&amp;iwloc=A&amp;ll=30.0220726,31.2169516&amp;spn=0.006295,0.006295&amp;output=embed">It seems that your browser does not support iFrames. The map content will not be loaded.</iframe>
</section>
<div class="row">
    <div class="col-md-9">
        <section class="section-content section-register-user section-main-contacts">
            <div class="form-1">
                <?php if (validation_errors()) { ?>
                    <div class="section-content-note section-content-note-4 section-content-alert">
                        <i class="fa fa-times"></i><span>Note:</span>
                        <?= validation_errors() ?>
                    </div>
                    
                <?php } ?>
                <form method="post" class="form-js form-contact" action="">
                    <div class="row">
                        <div class="col-md-6"><div class="form-input">
                                <input type="text" name="name" class="required-item" placeholder="Name:" value="<?= set_value('name') ?>"  data-toggle="tooltip"  data-placement="left">
                                <i class="fa fa-user"></i>
                            </div></div>
                        <div class="col-md-6"><div class="form-input">
                                <input type="text"  name="email" class="required-item" placeholder="Email:" value="<?= set_value('email') ?>" data-toggle="tooltip"  data-placement="left">
                                <i class="fa fa-envelope"></i>
                            </div></div>
                        <div class="col-md-12"><div class="form-input">
                                <textarea rows="8" name="message" class="required-item" placeholder="Message: Feel free to ask us anything, even if you just want to say hello!" data-toggle="tooltip"  data-placement="left"><?= set_value('message') ?></textarea>
                                <i class="fa fa-comment"></i>
                            </div></div>
                        <div class="col-md-12"><div class="form-input">
                                <input value="Send Message" name="send" type="submit">
                            </div></div>
                    </div>
                </form>
            </div>
        </section><!-- End section-content -->
    </div>
    <div class="col-md-3">
        <div class="section-content section-contact">
            <div class="section-content-head">

                <div>

                </div>
            </div>

            <ul>
                <li>
                    <i class="fa fa-map-marker"></i>
                    <div><strong><a href="<?php echo site_url().'locname';?>">Address:</a></strong></div>
                    <p> 2 Dr Mohammed Sobhy, Giza, Egypt</p>
                </li>
                <li class="hidden">
                    <i class="fa fa-mobile-phone"></i>
                    <div><strong>Phone:</strong></div>
                    <p>Mobiles <br><span>002 01065370701<span> / </span>002 01065370701</span></p>
                </li>
                <li>
                    <i class="fa fa-envelope"></i>
                    <div><strong>Emails:</strong></div>
                    <p>info@locname.com</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<section class="section-content section-register-user">
    <div class="section-content-head">
        <i class="fa fa-retweet"></i>
        <div>
            <h3>Subscribe and follow us now!</h3>
            <p>Want to follow all our updates? Just click the links below, or enter your email and we will be sure to keep you updated with all that is happening at LocName!</p>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-5">
            <div class="social-contacts">
                <ul class="social">
                    <li class="social-contacts-r"><a href="#"><i class="fa fa-rss"></i></a></li>
                    <li class="social-contacts-f"><a href="https://www.facebook.com/Locname"><i class="fa fa-facebook"></i></a></li>
                    <li class="social-contacts-g"><a href="https://plus.google.com/115089269623592028236"><i class="fa fa-google-plus"></i></a></li>
                    <li class="social-contacts-t"><a href="https://twitter.com/Loc_Name"><i class="fa fa-twitter"></i></a></li>
                    <li class="social-contacts-y"><a href="#"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-7">
            <div class="subscribe-contacts">
                <form method="post" action="">
                    <input type="text" placeholder="Enter Your Email To Receive All Our News">
                    <input type="submit" value="Subscribe">
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</section><!-- End section-content -->
</section><!-- End main-container -->

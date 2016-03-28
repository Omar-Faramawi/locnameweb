<div class="row">
    <div class="col-md-12">
        <section class="section-content section-members-page">
            <div class="members-img"><?= userPhoto(array("class" => ""), $profile->id) ?></div>
            <div class="section-members-content">

                <h1><?= $profile->full_name ?></h1>
                <ul>
                    <li><i class="fa fa-map-marker"></i><span>Country :</span> <?= $profile->country ?></li>
                    <li><i class="fa fa-calendar"></i><span>Joined :</span> <?= $profile->joined_at ?></li>
                    <li><i class="fa fa-user"></i><span>Followers :</span> <?= $profile->followers_count ?></li>
                </ul>
            </div>
            <div class="follow-report">
                <?php if($user->provider == "Facebook") { ?>
                    <a class=" follow-member" href="<?= site_url("user/mutualFriends") ?>"><i class="fa fa-users"></i>Facebook Friends</a>
                <?php }
                if($profile->id  != $user->id) {  ?>
                <a class="follow-member" href="#" id="followUser" userid="<?= $profile->id?>" ><i class="fa fa-arrow-down"></i>Follow</a>
                <?php } else  { ?>
                <a class="report-member" href="<?= site_url("user/update") ?>"><i class="fa fa-user"></i>update profile</a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </section>
    </div>
    <div class="col-md-8">
        <div class="member-page">
            <section class="section-content">
                <div class="time-line"><span></span></div>
                <div class="section-content-head">
                    <i class="fa fa-map-marker"></i>
                    <div>
                        <h3 class="section-content-head-h3">Mahmoud At Sterio Restaurant :</h3>
                        <span class="section-content-head-span">March 29, 2014    |    03:02 PM</span>
                        <div class="clearfix"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="recent-loc member-page-map">
                            <div>
                                <iframe height="195" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=usa&amp;hl=en&amp;sll=26.820553,30.802498&amp;sspn=16.874794,19.753418&amp;hnear=usa&amp;t=m&amp;z=10&amp;output=embed">It seems that your browser does not support iFrames. The map content will not be loaded.</iframe>
                            </div>
                            <div class="recent-footer">
                                <div><i class="fa fa-briefcase"></i><span>Category :</span> Food & Restaurant</div>
                                <div><i class="fa fa-map-marker"></i><span>Address :</span> Algharbia, Tanta</div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section><!-- End section-content -->

            <section class="section-content">
                <div class="time-line"><span></span></div>
                <div class="section-content-head">
                    <i class="fa fa-picture-o"></i>
                    <div>
                        <h3 class="section-content-head-h3">Mahmoud Add Photos :</h3>
                        <span class="section-content-head-span">March 29, 2014    |    03:02 PM</span>
                        <div class="clearfix"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="section-content-images">
                            <ul>
                                <li><img alt="" src="http://placehold.it/570x240/222/FFF"></li>
                                <li><img alt="" src="http://placehold.it/570x240/FFF/000"></li>
                                <li><img alt="" src="http://placehold.it/570x240/555/FFF"></li>
                            </ul>
                            <div class="bx-pager">
                                <a data-slide-index="0" href=""><img src="http://placehold.it/160x85/222/FFF"></a>
                                <a data-slide-index="1" href=""><img src="http://placehold.it/160x85/FFF/000"></a>
                                <a data-slide-index="2" href=""><img src="http://placehold.it/160x85/555/FFF"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section><!-- End section-content -->

            <section class="section-content">
                <div class="time-line"><span></span></div>
                <div class="section-content-head">
                    <i class="fa fa-check-square"></i>
                    <div>
                        <h3 class="section-content-head-h3">Mahmoud Add Friends :</h3>
                        <span class="section-content-head-span">March 29, 2014    |    03:02 PM</span>
                        <div class="clearfix"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="member-page-friends">
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                            <div class="friends-img"><a href="#"><img alt="" src="images/testimonials-img.png"></a></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section><!-- End section-content -->

            <section class="section-content">
                <div class="time-line"><span></span></div>
                <div class="section-content-head">
                    <i class="fa fa-map-marker"></i>
                    <div>
                        <h3 class="section-content-head-h3">Mahmoud Is Going To Event :</h3>
                        <span class="section-content-head-span">March 29, 2014    |    03:02 PM</span>
                        <div class="clearfix"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="recent-loc member-page-map">
                            <div>
                                <iframe height="195" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=usa&amp;hl=en&amp;sll=26.820553,30.802498&amp;sspn=16.874794,19.753418&amp;hnear=usa&amp;t=m&amp;z=10&amp;output=embed">It seems that your browser does not support iFrames. The map content will not be loaded.</iframe>
                            </div>
                            <div class="recent-footer">
                                <div><i class="fa fa-calendar"></i><span>Date :</span> April 3, 2014 - 8:00 PM</div>
                                <div><i class="fa fa-map-marker"></i><span>Address :</span> Algharbia, Tanta</div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section><!-- End section-content -->

            <section class="section-content">
                <div class="time-line"><span></span></div>
                <div class="section-content-head">
                    <i class="fa fa-map-marker"></i>
                    <div>
                        <h3 class="section-content-head-h3">Mahmoud Add Anew Place :</h3>
                        <span class="section-content-head-span">March 29, 2014    |    03:02 PM</span>
                        <div class="clearfix"></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <div class="recent-loc">
                            <div class="recent-content">
                                <div><img alt="" src="images/recent-content-1.png"></div>
                                <div>
                                    <h3><a href="#">CookDoor Restaurant, Cairo Branch</a></h3>
                                    <p><span>About / Address :</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                </div>
                            </div>
                            <div class="recent-footer">
                                <div><i class="fa fa-briefcase"></i><span>Category :</span> Food & Restaurant</div>
                                <div><i class="fa fa-user"></i><span>Owner :</span> Begha</div>
                                <a class="recent-more" href="#">ReadMore</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section><!-- End section-content -->
            <div class="member-page-time-line"><div></div></div>
        </div>
    </div>
    <div class="col-md-4 member-page-sidebar">
        <div class="section-content">
            <div class="section-content-head">
                <i class="fa fa-map-marker"></i>
                <div>
                    <h3>Locations :</h3>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet, consetur adipisicing elit, sed do eiusmod tempor .</p>
            <div class="member-page-sidebar-recent">
                <ul>
                    <?php $recentCount = 0; foreach($profile->locations as $recentLocation) {  
                        ++$recentCount;
						if($recentCount == 8)
							break;
					?>
                    <li>
                        <div class="recent-loc">
                            <div class="recent-content">
                                <div><img alt="" src="<?= base_url("assets/images/categories") ?>/<?= $recentLocation->type ?>.png"></div>
                                <div>
                                    <h3>
                                        <a href="<?= site_url($recentLocation->title) ?>"><?= $recentLocation->title ?></a>
                                    </h3>
                                </div>
                                <div class="clearfix"></div>
                                <p><?= $recentLocation->details ?></p>
                            </div>
                            <div class="recent-footer">
                                <div><i class="fa fa-calendar"></i><span>Created : </span><?= $recentLocation->created_at?></div>
                                <a class="recent-more" href="<?= site_url($recentLocation->title)?>">ReadMore</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="section-content">
            <div class="section-content-head">
                <i class="fa fa-heart"></i>
                <div>
                    <h3>Favorite locations</h3>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet, consetur adipisicing elit, sed do eiusmod tempor.</p>
            <div class="member-page-sidebar-recent-2">
                <ul>
                   <?php $recentCount = 0; foreach($profile->locations as $recentLocation) {
						++$recentCount;
						if($recentCount == 8)
							break;
					?>
                    <div class="recent-loc">
                         
                        <div class="recent-content">
                            <div><img alt="" src="<?= base_url("assets/images/categories") ?>/<?= $recentLocation->type ?>.png"></div>
                            <div>
                                <h3><a href="<?= site_url($recentLocation->title) ?>"><?= $recentLocation->title?></a></h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                       
                        <div class="recent-footer">
                            <div><i class="fa fa-briefcase"></i><span>Category :</span> Food & Restaurant</div>
                            <a class="recent-more" href="#">View</a>
                            <div class="clearfix"></div>
                        </div>
                         
                    </div>
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
        <div class="section-content section-member-page-members">
            <div class="section-content-head">
                <i class="fa fa-user"></i>
                <div>
                    <h3>Friends</h3>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet, consetur adipisicing elit, sed do eiusmod tempor .</p>
            <div class="member-page-members">
                <ul>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                    <section class="section-content section-members">
                        <div class="members-img"><img alt="" src="images/members.png"></div>
                        <div class="section-members-content">
                            <h3><a href="#">Ahmed Hassan</a></h3>
                            <p>Saudi Arbia</p>
                        </div>
                    </section>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

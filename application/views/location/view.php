<?php if (isset($passcode) && strlen($passcode) > 0) { ?>
    <section class="container">
        <div class="animated bounceInUp" animate_attr="bounceInUp" style="visibility: visible; opacity: 1;">
            <div class="panel-pop panel-pop-passcode" style="margin-top: -113.5px;">
                <h3>Passcode</h3>
                <div class="panel-pop-content">
                    <form action="<?= base_url("location/passcode") ?>" >
                        <div class="user-name">
                            <input type="password" placeholder="Write Passcode" name="passcode" id="passcodeinput" required   data-toggle="tooltip" data-placement="left" title="Enter Passcode"/>
                            <input type="text" name="location" value="<?= $location->title ?>" required style="display: none;" data-toggle="tooltip"  data-placement="left" title="Title"   />
                            <i class="fa fa-lock"></i>
                        </div>
                        <div class="clearfix"></div>
                        <input type="submit" value="Validate">
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div><!-- End panel-pop -->
        </div>
    </section>
    <script>
        document.querySelector("section.breadcrumbs").remove();
        var pp = document.querySelector(".main-container");
        pp.setAttribute("class", pp.className.replace("container", "") + " section-passcode");
    </script>
<?php } else { ?>
    <script>
        $(window).resize(function () {
            if ($(window).width() < 990) {
                $('#map-section').insertBefore($('#details-section'));
            }
            else {
                $('#details-section').insertBefore($('#map-section'));
            }
        });
    </script>
    <?php
    //print_r($location);
    $arrayOfSix = array();
    if($location->details != "") {
        array_push($arrayOfSix, "details");
    }
    if($location->address != ""){
        array_push($arrayOfSix, "address");
    }
    if($location->building_number != 0){
        array_push($arrayOfSix, "building");
    }
    if($location->flat_number != 0){
        array_push($arrayOfSix, "flat");
    }
    if($location->user->first_name != "" && $location->user->last_name != ""){
        array_push($arrayOfSix, "addedby");
    }
    if($location->mobile != "" && $location->mobile != 0){
        array_push($arrayOfSix, "mobile");
    }
    if($location->type != ""){
        array_push($arrayOfSix, "type");
    }
    array_push($arrayOfSix, "privacy");
    if($location->category->title != ""){
        array_push($arrayOfSix, "category");
    }
    if($location->email != ""){
        array_push($arrayOfSix, "email");
    }
    if($location->website != ""){
        array_push($arrayOfSix, "website");
    }
    if($location->short_code != ""){
        array_push($arrayOfSix, "shortcode");
    }
    array_push($arrayOfSix, "coords");
    array_push($arrayOfSix, "addedon");
    if($location->country != ""){
        array_push($arrayOfSix, "country");
    }
    if($location->city != ""){
        array_push($arrayOfSix, "city");
    }
    ?>
    <section id="location-header">
        <div class="container">
            <div class="content-cont clearfix">
                <div class="loc-img pull-left">
                    <?php if($gallery){?>
                    <img id='location-avatar' src="<?php echo site_url().'assets/uploads/location_gallery/'.$gallery[count($gallery)-1]->image_name; ?>" alt=""/>
                    <?php }else{ ?>
                        <img id='location-avatar' src="<?php echo site_url().'assets/loc/images/location-img-placeholder.png'; ?>" alt=""/>
                   <?php }?>
                   <script>
                   $('#openUpload').click(function(){
                     $('#upload').click();
                   });
                   function readURL(input) {
                  	if(input.files && input.files[0]) {
                    		var reader = new FileReader();
                    		reader.onload = function(e) {
                    			$('#location-avatar').attr('src', e.target.result);
                    		}
                    		reader.readAsDataURL(input.files[0]);
                    	}
                      $('#openUpload').hide();
                      $('#submit-upload').show();
                    }
                   </script>
                   <?php
                      $this->user = $this->ion_auth->user()->row();
                      $user = $this->user;
                      $this->data['user'] = $user;
                      $user_id = $this->data["user"]->id;

                     ?>
                   <?php if($location->user_id == $user_id){?>
                   <form action='<?php echo site_url()."location/uploadDirectAvatar/".$location->id."/".$location->title; ?>' method='post' enctype="multipart/form-data">
                     <a class='upload-avatar pull-right' id="openUpload" title='Upload Avatar'><i class="glyphicon glyphicon-camera"></i></a>
                     <input type="file" name="picture" id="upload" style="width:0px; height:0px;visibility:hidden;" onchange="readURL(this);">
                     <button type="submit" class='btn btn-primary pull-right upload-avatar-btn' id="submit-upload"><i class="glyphicon glyphicon-upload"></i> Upload</button>
                   </form>
                   <?php } ?>
                </div>
                <div class="loc-details clearfix pull-left">
                    <div class="name-rating clearfix">
                        <h1 class="loc-name pull-left"><?= ucfirst($location->title) ?> <small>short Code : <?php echo $location->short_code; ?></small></h1>
                        <div class="loc-rating pull-left">
                            <span id="ratings">
                                <div data-locationid="<?= $location->id ?>" data-rateit-ispreset="true" data-rateit-readonly="true" data-rateit-value="<?= $location->rating->rate ?>" class="rateit"></div>
                                <p><?php echo $location->rating->rate*2;?>/10 from <?php echo $location->rating->count;?> Reviews</p>
                            </span>
                        </div>
                    </div>
                    <div class="loc-info clearfix">
                        <?php
                            for($i = 0; $i < 6; $i++){
                                if($i == 1 || $i == 4){
                                    ?><?php
                                }
                                switch ($arrayOfSix[$i]) {
                                    case 'details':
                                      if($location->details != "" && $location->details != 0){
                                       ?><p class="with-icon description"><i class="fa fa-lightbulb-o"></i><?= ($location->details != "" && $location->details != 0 ? substr($location->details, 0, 80)." ..." : "") ?></p><?php
                                     }
                                        break;
                                    case 'address':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-map-marker"></i><strong>Address: </strong><?php echo substr($location->address, 0, 100)." ..."; ?></p>
                                        <br>
                                        <?php
                                        break;
                                    case 'building':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-home"></i><strong>Building No: </strong><?= ($location->building_number == 0 ? "" : $location->building_number) ?></p>

                                        <?php
                                        break;
                                    case 'flat':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-building-o"></i><strong>Flat No: </strong><?= ($location->flat_number == 0 ? "" : $location->flat_number ) ?></p>

                                        <?php
                                        break;
                                   case 'addedby':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-user"></i><strong>Added by: </strong>
                                            <?php if ($my_location) { ?>
                                                <a href="<?= site_url("user/locations/") ?>"><?= $location->user->first_name . " " . $location->user->last_name ?></a>
                                            <?php } else { ?>
                                                <a href="<?= site_url("user/user_locations/" . $location->user_id) ?>"><?= $location->user->first_name . " " . $location->user->last_name ?></a>
                                            <?php } ?></p>

                                        <?php
                                        break;
                                   case 'mobile':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-mobile"></i><strong>Mobile: </strong><?= $location->mobile ?></p>

                                        <?php
                                        break;
                                   case 'type':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-circle"></i><strong>Type: </strong><?= $location->Type ?></p>

                                        <?php
                                        break;
                                   case 'privacy':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-lock"></i><strong>Privacy: </strong><?= ($location->is_private == 0 ? "Public" : "Private") ?></p>

                                        <?php
                                        break;
                                   case 'category':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-folder"></i><strong>Category: </strong><?= $location->category->title ?></p>

                                        <?php
                                        break;
                                   case 'email':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-envelope"></i><strong>Email: </strong><?= $location->email ?></p>

                                        <?php
                                        break;
                                   case 'website':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-globe"></i><strong>Website: </strong><?= $location->Website ?></p>

                                        <?php
                                        break;
                                   /*case 'shortcode':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-cut"></i><strong>Short Code: </strong><?= $location->short_code ?></p>

                                        <?php
                                        break;*/
                                   case 'coords':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-map-marker"></i><strong>Coordinates: </strong><?= $location->latitude.", ".$location->longitude ?></p>

                                        <?php
                                        break;
                                   case 'addedon':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-calendar"></i><strong>Added on: </strong><?=  $location->created_at ?></p>

                                        <?php
                                        break;
                                   case 'country':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-flag"></i><strong>Country: </strong><?=  $location->country ?></p>

                                        <?php
                                        break;
                                   case 'city':
                                        ?>
                                        <p class="with-icon"><i class="fa fa-building"></i><strong>City: </strong><?=  $location->city ?></p>

                                        <?php
                                        break;

                                }
                              if($i != 5){
                                //echo "<p class='ver-separator'></p>";
                                //echo "&nbsp;";
                              }
                            }
                        ?>
                        <br />
                        <div class="with-icon in-touch" style="display: none;">
                            <i class="fa fa-hand-o-right"></i>
                            <ul>
                                <p><strong>Be in touch</strong></p>
                                <li><a href=""><i class="fa fa-facebook-square"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter-square"></i></a></li>
                                <li><a href=""><i class="fa fa-google-plus-square"></i></a></li>
                                <li><a href=""><i class="fa fa-linkedin-square"></i></a></li>
                            </ul>
                        </div>
                        <br />
                        <p>
                            <a id="moreInfoClick">More Info ...</a>
                        </p>
                    </div>
                </div>
                <div class="loc-actions pull-left clearfix">


                 <?php
                    $this->user = $this->ion_auth->user()->row();
                    $user = $this->user;
                    $this->data['user'] = $user;
                    $user_id = $this->data["user"]->id;

                   ?>
                    <div class="content">
                        <div class="bookmark-menu">
                            <div>
                            <?php
                            if (!$this->favModel->verify_favourite($user_id, $location->id)) { ?>
                                <a class="loc-bookmark" href="<?= site_url("favourite/createnew/" . $location->id . '/' . $location->title) ?>"><i class="fa fa-bookmark"></i>Add to Favorites</a>
                                <?php } else {
                                      $fId = $this->favModel->check_favourite($user_id, $location->id);
                                    ?>
                                <a class="loc-bookmark" href="<?=site_url('favourite/delete_from_location_view/' . $fId) ?>"><i class="fa fa-bookmark"></i>Unfavorite</a>
                                <?php } ?>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <?php
                                         if ($my_location == false) {
                                              ?>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"  class="report-member report-this" href="#">Report this place</a></li>
                                        <?php }else {?>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url("location/update/" . $location->title) ?>">Edit Location</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#exampleModal" data-location="<?= $location->title ?>" data-whatever="<?= site_url("location/delete_location/" . $location->id) ?>">Delete Location</a></li>
                                        <?php }?>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url().'location/embed/'.$location->title; ?> ">Embed map</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"  class="report-member share-this" href="#">Share this place</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="share-loc">
                            <p><i class="fa fa-share-alt"></i>Share this location</p>
                              <div class="pw-widget pw-size-medium">
                                    <a class="pw-button-facebook"></a>
                                    <a class="pw-button-twitter"></a>
                                    <a class="pw-button-googleplus"></a>
                                    <a class="pw-button-linkedin"></a>
                              </div>
                              <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ebr1659qcbkmroo84rtp&retina=true" type="text/javascript"></script>

                        </div>
                        <div class="action-links">
                            <a href="#navigateWithMobile" id="navigateWithMobileLink"><i class="fa fa-navicon"></i>Navigate by mobile</a>
                            <a href="#writeReview" id="writeReviewLink"><i class="fa fa-pencil-square-o"></i>Write review </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="location-map">
        <div class="container">
            <div class="content">
                <div id="map">
                    <?php echo $map['js']; ?>
                    <?php echo $map['html']; ?>
                </div>
                <div onclick="getMyLocation('<?= $location->longitude ?>','<?= $location->latitude ?>')" class="show-directions"><span>Show</span><span>Directions</span></div>
                <div class="hide-directions"><i class="fa fa-close"></i></div>
                <div class="directions-hider">
                    <div class="loc-directions">
                        <div jstcache="0" id="directionsDiv">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="loc-sections">
        <div class="clearfix container">
            <article class="pull-left">
                <div class="section-with-title" id="navigateWithMobile">
                    <div class="sec-title">
                        <h1><i class="fa fa-qrcode"></i>Location QRcode</h1>
                    </div>
                    <div class="sec-body">
                        <div class="qr-code">
                            <img class="qr-desc" src="<?= site_url("assets/loc/images/qr-code-bg.png") ?>" alt=""/>
                            <img class="qr-desc-small" src="<?= site_url("assets/loc/images/qr-code-bg-small.png") ?>" alt=""/>
                            <img id="qrcode" src="<?= site_url("qr/index/" . $location->title) ?>" alt="" />
                        </div>
                    </div>
                </div>
                <?php if($gallery){ ?>
                <div class="section-with-title">
                    <div class="sec-title">
                        <h1><i class="fa fa-camera-retro"></i>Location Gallery</h1>
                    </div>
                    <div class="sec-body">

                        <div id="loc-gallery">
                            <div class="hider">


                                <?php  foreach ($gallery as $image) { ?>
                                    <a class="gal-item clearfix" href="<?php echo site_url().'assets/uploads/location_gallery/'.$image->image_name; ?>"><img  src="<?php echo site_url().'assets/uploads/location_gallery/'.$image->image_name; ?>" alt=""/></a>
                               <?php } ?>

                            </div>
                        </div>

                    </div>
                </div>
                 <?php } ?>
                <div class="section-with-title" id="writeReview">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#reviews">Reviews (<?php echo count($reviews); ?>)</a></li>
                        <li role="presentation"><a href="#details">Location details</a></li>
                    </ul>
                    <div class="sec-body equal-padding with-scrollbar">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="reviews">
                                <div class="add-review clearfix">
                                    <div class="profile-placeholder pull-left">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="review-form pull-left">
                                        <form >
                                            <div class="username-stars">
                                                <input id ="reviewer" placeholder="Your name" type="text" value="<?php if($this->data["user"]->first_name != '') $this->data["user"]->first_name.' '. $this->data["user"]->last_name;  ?>"/>
                                                <span id="ratings">
                                                    <span>Rate it:</span>
                                                    <div data-locationid="<?= $location->id ?>" data-rateit-ispreset="true" data-rateit-readonly="false" data-rateit-value="<?= $location->rating->rate ?>" class="rateit"></div>
                                                </span>
                                            </div>
                                            <div class="review-content">
                                                <input type="hidden" value="<?= $location->id ?>" id="locationid">
                                                <textarea locationid="<?= $location->id ?>" name="" id="reviewarea" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="review-submit clearfix" >
                                                <input id="addreview" class="pull-right btn btn-primary" type="submit"  />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php foreach($reviews as $rev ) {?>
                                <div class="current-reviews clearfix">
                                    <div class="profile-placeholder pull-left">
                                      <?php
                                        if ($rev->photo) {
                                           if (substr($rev->photo, 0, 4) === "http")
                                             $userphoto = $rev->photo;
                                           else
                                             $userphoto = base_url("assets") . "/uploads/users_images/" . $rev->photo;
                                       ?>
                                            <img src="<?= $userphoto ?>" alt=""/>
                                        <?php }else { ?>
                                    <i class="fa fa-user"></i>
                                     <?php } ?>

                                    </div>
                                    <div class="review-body pull-left">
                                        <div class="review-head clearfix">
                                            <div class="review-rating pull-left"><div data-locationid="<?= $location->id ?>" data-rateit-ispreset="true" data-rateit-readonly="true" data-rateit-value="<?= $location->rating->rate ?>" class="rateit"></div></div>
                                            <h3 class="review-name pull-left"><?php echo ($rev->first_name." ".$rev->last_name);?></h3>
                                            <p class="review-date"><?php echo $rev->created_at;?></p>
                                        </div>
                                        <div class="review-text">
                                            <p><?php echo $rev->review;?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="details">
                                <p class="with-icon"><i class="fa fa-circle"></i> <strong>Type:</strong><?= $location->type ?></p>
                                <p class="with-icon"><i class="fa fa-map-marker"></i> <strong>Address:</strong><?= $location->address ?></p>
                                <p class="with-icon"><i class="fa fa-folder"></i> <strong>Category:</strong><?= $location->category->title ?></p>
                                <p class="with-icon"><i class="fa fa-lock"></i> <strong>Privacy:</strong><?= ($location->is_private == 0 ? "Public" : "Private") ?></p>
                                <p class="with-icon"><i class="fa fa-lightbulb-o"></i> <strong>Description:</strong><?= $location->details ?></p>
                                <p class="with-icon"><i class="fa fa-envelope"></i> <strong>Email:</strong><?= $location->email ?></p>
                                <p class="with-icon"><i class="fa fa-globe"></i> <strong>Website:</strong><?= $location->website ?></p>
                                <p class="with-icon"><i class="fa fa-cut"></i> <strong>Short Code:</strong><?= $location->short_code ?></p>
                                <p class="with-icon"><i class="fa fa-map-marker"></i> <strong>Coordinates:</strong><?= $location->latitude.", ".$location->longitude ?></p>
                                <p class="with-icon"><i class="fa fa-calendar"></i> <strong>Added on:</strong><?= $location->created_at ?></p>
                                <p class="with-icon"><i class="fa fa-flag"></i> <strong>Country:</strong><?= $location->country ?></p>
                                <p class="with-icon"><i class="fa fa-building"></i> <strong>City:</strong><?= $location->city ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-with-title" id="facebookComments">
                    <div class="sec-title">
                        <h1><i class="fa fa-comments"></i>Comments</h1>
                    </div>
                    <div class="sec-body with-scrollbar">
                        <div class="fb-comments"  data-href="<?= site_url($location->title) ?>" data-numposts="20" data-colorscheme="light" data-width="100%"></div>
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=249539705113023&version=v2.0";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                    </div>
                </div>
            </article>
            <!--<aside class="pull-right">
                <div class="a_s_d">
                    <img src="<?= site_url("assets/loc/images/aside_A_D.jpg") ?>" alt=""/>
                </div>
                <div class="section-with-title"  >
                    <div class="sec-title">
                        <h1><i class="fa fa-users"></i>Location Events</h1>
                    </div>
                    <div class="sec-body">

                        <div class="loc-event clearfix" style="visibility: hidden">
                            <div class="event-placeholder pull-left">
                                <img src="<?= site_url("assets/loc/images/aside_A_D.jpg") ?>" alt=""/>
                            </div>
                            <div class="event-content pull-left">
                                <a href="#"><h4>Cloud Weekend 2015</h4></a>
                                <p>Saturday, February 21 at 10:00am</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="a_s_d">
                    <img src="<?= site_url("assets/loc/images/aside_A_D1.jpg") ?>" alt=""/>
                </div>
            </aside>-->
        </div>
    </section>

    <div id="location-page-mobile-footer">
        <link rel="stylesheet" type="text/css" href="//ubutton.github.io/css/v1/ubutton.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//ubutton.github.io/js/v1/ubutton.js"></script>
<script>generateUbutton(<?= $location->latitude ?>,<?= $location->longitude ?>,"<?= $location->address ?>");</script>
        <div class="col-md-12" style="text-align:center;">
            <div class="well" style="margin-bottom:1px;border-radius:0;">Do you see how easy it was to find your friend location</div>
            <div class="well" style="margin-bottom:-21px;border-radius:0;">Now create your own LocName on the mobile App</div>
        </div>
    </div>
<?php } ?>

 <div class="panel-pop panel-pop-report">
        <h3>Report this place</h3>
        <div class="panel-pop-content">

            <form method="post" action="<?= site_url("report/send") ?>" class=" form-js form-1">
                <div class="select-div">
                    <select name="about" class="required-item">
                        <option>Report about</option>
                        <option value="myname">It is my name</option>
                        <option value="invalid">Invalid location</option>
                        <option value="Inappropriate">Inappropriate location</option>
                    </select>
                </div>
                <div class="form-input">
                    <textarea class="required-item" rows="4" name="message" placeholder="Message"></textarea>
                </div>
                <input type="hidden" name="location_id" value=<?php echo $location->id ?> >
                <input type="submit" value="Save">
            </form>
        </div>
    </div><!-- End panel-pop -->

     <!-- sharing panel-popup -->
     <div class="panel-pop panel-pop-sharing" style="width:400px;height: 400px;overflow-y:scroll;">
        <h3>Share with your friends</h3>
        <div class="panel-pop-content" id="friends">
           <?php
              foreach ($friends as $friend)
              {?>
            <div class="friends"  style="width:90%;height: 40px">
                <input   type="checkbox" value="<?= $friend->id ?>" /> <?= $friend->first_name ." ".$friend->last_name?><br />
            </div>
             <?php }
           ?>
            <center> <button id="share" style="width:100px;height: 50px;background-color: #005702;color: #FFF;">Share</button></center>
            <input type="hidden" id="user" value="<?=$user->id ?>"/>
            <input type="hidden" id="location" value="<?=$location->title?>" />
        </div>
    </div>

     <!-- End sharing popup -->

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="z-index:1060;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Are your sure you want to delete this location:</h4>
      </div>
      <!--<div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="deleteLocationBtn" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var recipient;
        $("#deleteLocationBtn").click(function(){
            window.location = recipient;
        });
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            recipient = button.data('whatever');
            var locationName = button.data('location'); // Extract info from data-* attributes
            // alert(recipient);
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-title').html('Are your sure you want to delete this location: <br><a style="color:red;">' + locationName+"</a>");
           // modal.find('.modal-body input').val(recipient);
        });
    });
</script>

<script type="text/javascript">
    function fbs_click()
    {
        u = "<?= current_url() ?>";
        t = "#locname";
        window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
        return false;
    }


    function googleShare_click()
    {
        u = "<?= site_url() ?>";
        t = "";
        window.open('https://plus.google.com/share?url=<?= site_url($location->title) ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');
        return false;
    }

</script>
<script language="javascript" type="text/javascript">
    function addToFavourites(location) {
        $.post(<?= site_url('favourite/test') ?>, {location: location}, function (data) {

            if (data == "true") {
                $("#addToFav").html("added successfully");
                return true;
            } else if (data == "founded") {

                return $("#addToFav").html("you have added this location before");
            }
            else {
                alert('aa');
            }
            $("#addToFav").html("You have to logged in first .");
            $("#addToFav").attr("href", site_url + "/auth/login");

        });
    }
</script>
<?php
if ($this->session->userdata('location_just_created')) {
    ?>
    <!-- Facebook Popup Widget START -->
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript'></script>
    <style>
        #fanback {
            display:none;
            background:rgba(0,0,0,0.8);
            width:100%;
            height:100%;
            position:fixed;
            top:0;
            left:0;
            z-index:99999;
        }
        #fan-exit {
            width:100%;
            height:100%;
        }
        #JasperRoberts {
            background:white;
            width:402px;
            height:270px;
            position:absolute;
            top:58%;
            left:63%;
            margin:-220px 0 0 -375px;
            -webkit-box-shadow: inset 0 0 50px 0 #939393;
            -moz-box-shadow: inset 0 0 50px 0 #939393;
            box-shadow: inset 0 0 50px 0 #939393;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            margin: -220px 0 0 -375px;
        }
        #TheBlogWidgets {
            float:right;
            cursor:pointer;
            background:url(<?= site_url("assets/loc/images") . "/fanclose.png" ?>) no-repeat;
            height:15px;
            padding:20px;
            position:relative;
            padding-right:20px;
            margin-top:-20px;
            margin-right:-22px;
        }
        .remove-borda {
            height:1px;
            width:366px;
            margin:0 auto;
            background:#F3F3F3;
            margin-top:20px;
            position:relative;
            margin-left:20px;
        }
        #linkit,#linkit a.visited,#linkit a,#linkit a:hover {
            color:#80808B;
            font-size:10px;
            margin: 0 auto 5px auto;
            float:center;
        }
    </style>
    <script type='text/javascript'>
    //<![CDATA[
    jQuery.cookie = function (key, value, options) {
        // key and at least value given, set cookie...
        if (arguments.length > 1 && String(value) !== "[object Object]") {
            options = jQuery.extend({}, options);
            if (value === null || value === undefined) {
                options.expires = -1;
            }
            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }
            value = String(value);
            return (document.cookie = [
                encodeURIComponent(key), '=',
                options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }
        // key and possibly options given, get cookie...
        options = value || {};
        var result, decode = options.raw ? function (s) {
            return s;
        } : decodeURIComponent;
        return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
    };
    //]]>
    </script>
    <script type='text/javascript'>
        jQuery(document).ready(function ($) {
            if ($.cookie('popup_user_login') != 'yes') {
                $('#fanback').delay(1000).fadeIn('medium');
                $('#TheBlogWidgets, #fan-exit').click(function () {
                    $('#fanback').stop().fadeOut('medium');
                });
            }
            //$.cookie('popup_user_login', 'yes', {path: '/', expires: 7});
        });
    </script>
    <div id='fanback'>
        <div id='fan-exit'>
        </div>
        <div id='JasperRoberts'>
            <div id='TheBlogWidgets'>
            </div>
            <div class='remove-borda'>
            </div>
            <iframe allowtransparency='true' frameborder='0' scrolling='no' src='//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FLocname&amp;width&amp;height=270&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false&amp;appId=1376235535961215' style='border: none; overflow: hidden; margin-top: -19px; width: 402px; height: 230px;'>Like us on Facebook http://www.facebook.com/Locname</iframe>
        </div>
    </div>
    <!-- Facebook Popup Widget END -->
<?php } ?>

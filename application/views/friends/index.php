<section class="container clearfix main-container">
    <div class="panel-pop panel-pop-sync_contacts panel-pop-google text-center">
        <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading Contacts" >
    </div>
    <div class="panel-pop panel-pop-sync_contacts panel-pop-facebook text-center">
        <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading Contacts" >
    </div>
    <div class="col-md-8">
        <?php if ($friends) { ?>
            <?php foreach ($friends as $friend) { ?>
                <div class="friends-container clearfix">
                    <div class="profile-img col-md-2">
                        <?php
                        if ($friend->photo) {
                            if (substr($friend->photo, 0, 4) === "http")
                                $userphoto = $friend->photo;
                            else
                                $userphoto = base_url("assets") . "/uploads/users_images/" . $friend->photo;
                            ?>
                            <img alt="<?= $friend->first_name . " " . $friend->last_name ?>" src="<?= $userphoto ?>" width="50">
                        <?php }else { ?>
                            <i class="fa fa-user"></i>
                        <?php } ?>
                    </div>
                    <div class="user-data col-md-10">
                        <h3><?= $friend->first_name . " " . $friend->last_name ?></h3>
                        <div class="more-data col-md-6">
                        <a href="<?= site_url("friends/locations/" . $friend->id) ?>" style="font-size:21px;">
                            <i class="fa fa-map-marker"></i>
                            <span><?= $friend->num_locations ?> </span>
                        </a>
                        </div>
                        <div class="more-data col-md-6">
                        <a href="<?= site_url("friends/favourites/" . $friend->id) ?>"  style="font-size:21px;">
                            <i class="fa fa-star"></i>
                            <span><?= $friend->num_fav_locations ?></span>
                        </a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> You don't have any friends on LocName. </div>
        <?php } ?>
        <div class="pagination">
            <?= $links ?>
        </div>
    </div>
    <div class="col-md-4 sync-contacts">
        <a class="btn btn-danger" id="ifg">Invite Friends g+</a>
        <h2 class="text-center">
            Sync Your Contacts
        </h2>
        <div>
            <a class="col-md-6 text-right">
                <i id="facebook_sync" class="fa fa-facebook"></i>
            </a>
            <a class="col-md-6 text-left" href="JavaScript:newPopup('<?= site_url("api/google_connect?close=1") ?>');">
                <i id="google_sync" class="fa fa-google-plus"></i>
            </a>
        </div>
    </div>
</section><!-- End main-container -->
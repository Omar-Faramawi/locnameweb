<div class="row">
    <?php if ($followers) { ?>
	    <?php foreach ($followers as $follower) { ?>
            <div class="col-md-3">
                <section class="section-content section-members">
                    <div class="members-img"><?= userPhoto(array(), $follower->user->id) ?></div>
                    <div class="section-members-content">
                        <h3> <a href="<?= site_url("user/profile/" . $follower->user->id) ?>"><?= $follower->user->username ?></a></h3>
                        <ul>
                            <li><i class="fa fa-map-marker"></i><span>Country: </span><?= $follower->user->country ?></li>
                            <li><i class="fa fa-calendar"></i><span>Joined: </span><?= $follower->user->joined_at ?></li>
                            <li><i class="fa fa-user"></i><span>Followers: </span><?= $follower->user->followers_count ?></li>
                        </ul>
                    </div>
                </section>
            </div>
	    <?php } ?>

    <?php } else { ?>
        <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> You didn't follow any user yet. </div>
    <?php } ?>

</div>
<div class="pagination">
    <?php // echo $links ?>
</div><!-- End pagination -->

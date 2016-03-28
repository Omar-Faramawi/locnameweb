<?php
if ($isFriend) {
    ?>
    <div class="row">
        <?php if ($favs) { ?>
            <?php foreach ($favs as $fav) { ?>
                <div class="col-md-4">
                    <div class="recent-loc favorites">
                        <div class="favorites-img"><img alt="<?= $fav->title ?>" src="<?= base_url("assets/uploads/locations/" . $fav->title) ?>.png"></div>
                        <div class="recent-content">
                            <div>
                                <img alt="<?= $fav->title ?>" src="<?= base_url("assets/images/categories") ?>/<?= ($fav->type) ? $fav->type : "general" ?>.png">                        </div>
                            <div>
                                <h3><a href="<?= site_url($fav->title) ?>"><?= ucfirst($fav->title) ?></a></h3>
                                <p><?= (strlen($fav->address) < 26) ? $fav->address : substr($fav->address, 0, 23) . "..." ?></p>
                            </div>
                        </div>
                        <div class="recent-footer">
                            <div><i class="fa fa fa-briefcase"></i><span>Type :</span> <?= ucfirst(($fav->type) ? $fav->type : "general") ?></div>
                            <a class="favorites-view" href="<?= site_url($fav->title) ?>">View</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> This user has no favorite locations </div>
        <?php } ?>
    </div>
    <div class="pagination">
        <?= $links ?>
    </div><!-- End pagination -->

    <?php
} else {
    ?>
    <div class="alert alert-danger" role="alert">This user is not your friend; you can't view this user's locations</div>
    <?php
}
?>
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
                            <h3><a href="<?= site_url($fav->title) ?>"><?= $fav->title ?></a></h3>
                            <p><?= (strlen($fav->address) < 26) ? $fav->address : substr($fav->address, 0, 23) . "..." ?></p>
                        </div>
                    </div>
                    <div class="recent-footer">
                        <div><i class="fa fa fa-briefcase"></i><span>Type :</span> <?= ucfirst(($fav->type) ? $fav->type : "general") ?></div>
                        <a class="favorites-x delete-fav"  href="<?= site_url("favourite/delete/" . $fav->id) ?>" ><i class="fa fa-times"></i></a>
                        <a class="favorites-view" href="<?= site_url($fav->title) ?>" style="margin-bottom:10px;">View</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="section-content-note section-content-note-5 section-content-alert margin-0"><i class="fa fa-microphone"></i><span>Note:</span> you didn't add any locations in your favorites. </div>
    <?php } ?>
</div>
<div class="pagination">
    <?php //  $links ?>
</div><!-- End pagination -->

<section class="container clearfix main-container">
    <div class="row">
        <?php if ($locations) {
            foreach ($locations as $location) { ?>
                <div class="col-md-4">
                    <div class="recent-loc favorites locations">
                        <div class="favorites-img">
                            <img alt="<?= $location->title ?>" src="<?= base_url("assets/uploads/locations/" . $location->title) ?>.png">
                        </div>
                        <div class="recent-content">
                            <div>
                                <img alt="" src="<?= base_url("assets/images/categories") ?>/<?= ($location->type) ? $location->type : "general" ?>.png">
                            </div>
                            <div>
                                <h3><a href="<?= site_url($location->title) ?>"><?= $location->title ?></a></h3>
                                <p style="height: 23px;" ><?= character_limiter($location->address . $location->details, 25) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            } else { ?>
            <div class="col-md-4" align="center" style="width:100%;">
                <div class="recent-loc favorites locations">
                    <div class="favorites-img">No Records Found.</div>
                </div>
            </div>                 
            <?php } ?>
        </div>
    </section><!-- End main-container -->
    <div class="pagination">
        <?= $links ?>
    </div>
    
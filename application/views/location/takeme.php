 <?php echo $map['js']; ?>
 
	<section class="section-content section-take-me">
		<div class="section-content-map section-content-map-pic">
			<?php echo $map['html']; ?>
        </div>
		<div class="clearfix"></div>
		<div class="section-content-note section-content-note-2 section-content-alert margin-0">
            <i class="fa fa-map-marker"></i><span>Address:</span> <?= $location->address ?>
        </div>
		<div class="clearfix"></div>
	</section><!-- End section-content -->
	 
	<div class="row">
		<div class="col-md-9" id="directionsDiv">
			 
		</div>
		<div class="col-md-3">
			<div class="adv"><img alt="" src="<?= site_url("assets/loc/images") ?>/adv.png"></div>
		</div>
	</div>
 
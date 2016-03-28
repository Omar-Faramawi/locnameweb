<section class="section-content">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Update Location:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <?php echo validation_errors(); ?>

        <div class="section-content-map section-content-map-pic">

            <?php echo $map['js']; ?>
            <?php echo $map['html']; ?>
        </div>

        <form role="form" class="form-1">

            <input type="hidden" name="latitude" id="latitude" value="<?= $location->latitude ?>" />
            <input type="hidden" name="longitude" id="longitude" value="<?= $location->longitude ?>" />

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-4"><label>Map Type</label></div>
                    <div class="col-md-8">
                                <div class="select-div">
                                    <select class="location-type location-type" name="type">
										<option value="ROADMAP">Roadmap</option>
										<option value="SATELLITE">Satellite</option>
										<option value="HYBRID">Satellite with street names</option>
										<option value="TERRAIN">Terrain</option>
									</select>
                                </div>
                            
                    </div>

                    <div class="col-md-4"><label>Zoom</label></div>
                    <div class="col-md-8">

                        <div class="select-div">
                                <select class="location-type location-type" name="zoom">
									<option value="0" id="zoom_custom">Fully Zoomed out</option>
									<option value="1">4000 km</option>
									<option value="2">2000 km (world)</option>
									<option value="3">1000 km</option>
									<option value="4">400 km (continent)</option>
									<option value="5">200 km</option>
									<option value="6">100 km (country)</option>
									<option value="7">50 km</option>
									<option value="8">30 km</option>
									<option value="9">15 km (area)</option>
									<option value="10">8 km</option>
									<option value="11">4 km</option>
									<option value="12">2 km (city)</option>
									<option value="13">1 km</option>
									<option value="14" selected="selected">400 m (district)</option>
									<option value="15">200 m</option>
									<option value="16">100 m</option>
									<option value="17">50 m (street)</option>
									<option value="18">20 m</option>
									<option value="19">10 m</option>
									<option value="20">5 m - (house)</option>
									<option value="21">2.5 m</option>
								</select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4"><label>Width</label></div>
                    <div class="col-md-8"><input class="span3" name="width" id="width" type="text"  placeholder="Canvas width" data-toggle="tooltip"  data-placement="left" title="Canvas width">
                    </div>

                    <div class="col-md-4"><label>Height</label></div>
                    <div class="col-md-8"><input class="span3" name="height" id="height" type="text" placeholder="Canvas height" data-toggle="tooltip"  data-placement="left" title="Canvas height"></div>
                </div>
            </div>
            <div class="col-md-12">
                <button id="embedMap" locationTitle="<?php echo $headerTitle;?>" class="section-content-a"><i class="fa fa-arrow-right"></i>Embed Map</button>
            </div>
        </form>
    </div>
</section>
<section class="section-content" id='embeded-map-section' style="display:none;">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Embeded Map</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row" id='embeded-map'>
        <div class="col-md-12" style="padding:15px;background-color:#fff; border:1px solid #e0e0e0;"></div>
    </div>
</section>
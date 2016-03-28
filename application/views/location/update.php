
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

        <form role="form" class="form-1" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="latitude" id="latitude" value="<?= $location->latitude ?>" />
            <input type="hidden" name="longitude" id="longitude" value="<?= $location->longitude ?>" />

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4"><label>Address</label></div>
                    <div class="col-md-8"><input class="span3" name="address" id="address" type="text" placeholder="Location Adress" value="<?= set_value("address", $location->address) ?>" data-toggle="tooltip"  data-placement="left" ></div>
                    <div class="col-md-4"><label>Building & Flat</label></div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" placeholder="Building Number" id="building_number" name="building_number" value="<?= set_value("address", $location->building_number) ?>" data-toggle="tooltip"  data-placement="left"  />
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="Flat Number" id="flat_number" name="flat_number" value="<?= (set_value("address", $location->flat_number) > 0) ? set_value("address", $location->flat_number) : '' ?>" data-toggle="tooltip"  data-placement="left"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"><label>Mobile Number</label></div>
                    <div class="col-md-8"><input class="span3"  name="mobile" id="locationMobile" type="text" placeholder="Location Mobile" value="<?= set_value("mobile", $location->mobile) ?>" data-toggle="tooltip"  data-placement="left" ></div>

                    <div class="col-md-4"><label>Privacy</label></div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="select-div">
                                    <select class="privacy" name="is_private" id="is_private" >
                                        <option value="0" <?= ($location->is_private == "0") ? "selected" : "" ?> >Public Place</option>
                                        <option value="1" <?= ($location->is_private == "1") ? "selected" : "" ?> >Private Passcode</option>
                                        <option value="2" <?= ($location->is_private == "2") ? "selected" : "" ?> >Private Facebook</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" <?= ($location->is_private != "1") ? "style='display:none;'" : "style='display:block;'" ?> value="<?= $location->passcode ?>" class="passcode" placeholder="Write Your Passcode" id="passcode" name="passcode" data-toggle="tooltip"  data-placement="left" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4"><label>Location Type</label></div>
                    <div class="col-md-8">

                        <div class="select-div">
                                <?php
                                $js = 'name="type" id="locationType" class="location-type locationType" cat-val="' . $location->category_id . '"';
                                echo form_dropdown('type', $types, $location->type, $js);
                                ?>
                        </div>
                    </div>
                    <div class="col-md-4"><label>Category</label></div>
                    <div class="col-md-8">
                        <div class="select-div locationCategoryDiv" >
                            <?php
                            $js = 'id="locationCategory" class="locationCategory" ';
                            echo form_dropdown('category', $categories, $location->category_id, $js);
                            ?>
                        </div>

                        <div class="row durationRow" <?= ($location->type != "event") ? "style='display:none;'" : "style='display:block;'" ?>>
                            <div class="col-md-4"><label>From date</label></div>
                            <div class="col-md-8"><input type="text" id="duration_from" name="duration_from"  value="<?= set_value("duration_from", $location->duration_from) ?>" class="datepicker" data-toggle="tooltip"  data-placement="left" ></div>
                            <div class="col-md-4"><label>To date</label></div>
                            <div class="col-md-8"><input type="text" class="datepicker" id="duration_to"  name="duration_to" value="<?= set_value("duration_to", $location->duration_to) ?>"  ></div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4"><label>Website URL</label></div>
                    <div class="col-md-8"><input class="span3" name="website" id="website" type="text"  placeholder="Location Website" value="<?= set_value("website", $location->website) ?>" data-toggle="tooltip"  data-placement="left">
                    </div>

                    <div class="col-md-4"><label>Email Account</label></div>
                    <div class="col-md-8"><input class="span3" name="email" id="email" type="text" placeholder="Location Email" value="<?= set_value("email", $location->email) ?>" data-toggle="tooltip"  data-placement="left" ></div>

                    <!--<div class="col-md-4"><label>Location Image</label></div>
                    <div class="col-md-8">
                        <div class="fileinputs">
                            <input type="file"  name="photo" class="file file-fake" accept="image/*" onchange="validateFileType()">
                            <div class="fakefile">
                                <button id="photo_text" type="button" class="button small margin-0">Select File</button>
                                <span>Browse</span>
                            </div>
                        </div>
                    </div>-->
                    
                    <div class="col-md-4"><label>Add Gallery</label></div>
                    <div class="col-md-8">
                        <div class="fileinputs">
                            <input type="file" multiple="" name="photos[]" class="file file-fake" accept="image/*" onchange="gallery(this)">
                            <div class="fakefile">
                                <button id="photo_text" type="button" class="button small margin-0">Select Files</button>
                                <span>Browse</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id='files-names' style="padding-left:10px;"><ul></ul></div>
                    </div>
                    <div class="col-md-12">
                        <p class="small">800x600 is the best resolution & Allowed formats are: gif, jpg, png, and jpeg</p>
                    </div>
                    
                    <input type="hidden" name="is_event" id="is_event" class="" value="<?= $location->is_event ?>"  />

                    <div class="col-md-4"><label>Description</label></div>
                    <div class="col-md-8">
                        <textarea rows="5" class="textarea span7" name="details" id="details" placeholder="Briefly describe this place" data-toggle="tooltip"  data-placement="left" ><?= set_value("details", $location->details) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <button type="submit" class="section-content-a"><i class="fa fa-arrow-right"></i>Update</button>
            </div>
        </form>
    </div>
</section>

<section class="section-content">
    <div class="section-content-head">
        <i class="fa fa-user"></i>
        <div>
            <h3>Gallery:</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <?php foreach ($gallery as $image) {
         ?>
        <div class="col-md-4">
            <img class="img img-responsive"  src="<?php echo site_url().'assets/uploads/location_gallery/'.$image->image_name; ?>">
            <a href="<?php echo site_url().'location/delete_image/'.$image->id;?>">Delete</a>
        </div>
        <?php } ?>
    </div>
</section>

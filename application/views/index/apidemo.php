<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url("assets/apidemo") ?>/js/apidemo.js"></script>
<style>
    .gm-style{
        position: relative !important;
    }
    #apidemomap,#locnamemap{
        height: 250px;
    }
    .place-meta{
        padding-right: 10px;
    }
    .tab-pane{
        padding-top: 20px;
    }
    .input-group{
        margin-bottom: 20px;
    }
</style>
<div class="container">
    <div id="demoform">
        <div class="col-md-6">
            <div class="input-group input-group">
                <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                <input id="user_email" name="email" type="text" class="form-control" placeholder="Email" tabindex="1" title="Email" data-toggle="tooltip"  data-placement="left" title="Enter Email Address" />
            </div>

            <div class="input-group input-group">
                <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                <input id="user_firstname" name="firstname" type="text" class="form-control" placeholder="First Name" tabindex="2" data-toggle="tooltip"  data-placement="left" title="Enter First Name" />
                <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                <input id="user_lastname" name="lastname" type="text" class="form-control" placeholder="Last Name" tabindex="3" data-toggle="tooltip"  data-placement="left" title="Enter Last Name" />
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#existing" role="tab" data-toggle="tab">Existing LocName</a></li>
                <li><a href="#new" class="newlocname" role="tab" data-toggle="tab">New LocName</a></li>
                <li><a href="#addressform" role="tab" data-toggle="tab">Address Form</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="existing">
                    <form name="existinglocnameform" id="existinglocnameform" method="post" action="" class="col-md-6">
                        <div class="input-group input-group">
                            <span class="input-group-addon "><span class="glyphicon glyphicon-pencil"></span></span>
                            <input name="title" id="existingTitle" type="text" class="form-control" placeholder="Title" tabindex="1" data-toggle="tooltip"  data-placement="left" title="Title" />
                        </div>
                        <input name="existingsubmit" id="existingsubmit" class="btn btn-success" type="submit" value="Submit" />
                    </form>
                </div>
                <div class="tab-pane fade" id="new">
                    <form name="newlocnameform" id="newlocnameform" method="post" action="" class="col-md-6">
                        <div class="name-available">
                            <div class="input-group input-group form-input">
                                <span class="input-group-addon "><span class="glyphicon glyphicon-pencil"></span></span>
                                <input type="text" name="newtitle" class="form-control highlighted locNamebox" required id="title" data-parsley-trim-value="true" parsley-type="alphanum" parsley-remote="<?= site_url("api/checkLocationName"); ?>" parsley-trigger="change" parsley-rangelength="[3,25]" placeholder="Choose LocName" data-toggle="tooltip"  data-placement="left" title="Choose Your LocName" />
                            </div>
                            <div class="name-available-div name-available-yes" style="z-index: 100; margin-top: -5px;"><i class="fa fa-check"></i>Available</div>
                            <div class="name-available-div name-available-not" style="z-index: 100; margin-top: -5px;"><i class="fa fa-times"></i>Not available</div>
                        </div>
                        <div class="input-group input-group">
                            <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                            <input id="loc_country" name="country" type="text" class="form-control" placeholder="Country" tabindex="-1" readonly="readonly" data-toggle="tooltip"  data-placement="left" title="Country" />
                        </div>
                        <div class="input-group input-group">
                            <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                            <input id="loc_state" name="state" type="text" class="form-control" placeholder="State" tabindex="-1" readonly="readonly" data-toggle="tooltip"  data-placement="left" title="State" />
                        </div>
                        <div class="input-group input-group">
                            <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                            <input id="loc_address"  name="address" type="text" class="form-control" placeholder="Address" tabindex="5" data-toggle="tooltip"  data-placement="left" title="Address" />
                        </div>
                        <div class="input-group input-group">
                            <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                            <input id="loc_bn"  name="building" type="text" class="form-control" placeholder="Building Number" tabindex="6" data-toggle="tooltip"  data-placement="left" title="Building Number" />
                            <span class="input-group-addon "><span class="glyphicon glyphicon-user"></span></span>
                            <input id="loc_fn"  name="flat" type="text" class="form-control" placeholder="Flat Number" tabindex="7" data-toggle="tooltip"  data-placement="left" title="Flat Number" />
                        </div>
                        <input name="newsubmit" id="newsubmit" class="btn btn-success" type="submit" value="Submit" tabindex="8" />

                        <input id="loc_lat" name="latitude" type="hidden" class="form-control" placeholder="Latitude" tabindex="-1" data-toggle="tooltip"  data-placement="left" title="Latitude" />
                        <input id="loc_lng" name="longitude" type="hidden" class="form-control" placeholder="Longitude" tabindex="-1" data-toggle="tooltip"  data-placement="left" title="Longitude" />
                    </form>
                    <div id="apidemomap" class="col-md-6">
                        <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading map" >
                    </div>

                </div>
                <div class="tab-pane fade" id="addressform">
                    <h3>Your Default Address Form</h3>
                    <form name="addressform" method="post" action="" class="col-md-6">
                        <input type="text" class="form-control" placeholder="Country" tabindex="1" data-toggle="tooltip"  data-placement="left" title="Country" />
                        <input type="text" class="form-control" placeholder="State" tabindex="2" data-toggle="tooltip"  data-placement="left" title="State" />
                        <input type="text" class="form-control" placeholder="Address" tabindex="3" data-toggle="tooltip"  data-placement="left" title="Address" />
                        <input type="text" class="form-control" placeholder="Building Number" tabindex="4" data-toggle="tooltip"  data-placement="left" title="Building Number" />
                        <input type="text" class="form-control" placeholder="Flat Number" tabindex="5" title="Flat Number" data-toggle="tooltip"  data-placement="left"  />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="locnamedetails" class="col-md-12 hidden">
        <ul class="place-meta col-md-6">
            <li>
                <div><i class="fa fa-map-marker"></i>LocName: <span id="locname_title"></span></div>
                <div><i class="fa fa-info"></i>Short Code: <span id="locname_shortcode"></span></div>
            </li>
            <li>
                <div><i class="fa fa-building-o"></i>Building Number <span id="locname_buildingno"></span></div>
                <div><i class="fa fa-home"></i>Flat Number: <span id="locname_flatno"></div>
            </li>
            <li>
                <div><i class="fa fa-map-marker"></i>Address: <span id="locname_address"></span></div>
            </li>
        </ul>
        <div id="locnamemap" class="col-md-6">
            <img src="<?= base_url("assets/main/img/sloading.gif"); ?>" alt="Loading map" >
        </div>
    </div>
</div>
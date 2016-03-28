<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <h1>Report  <small>select Your criteria </small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-edit"></i> Report Tool</li>
            </ol>
            
        </div>
    </div><!-- /.row -->

    <div class="row">
        <div class="col-lg-6">

            <form role="form" method="post" >
                <div class="form-group">
                    <label>Select Country</label>
                    <select class="form-control" id="countrySearch" name="country">
                        <option value="">Choose Country</option>
                        <?php foreach ($countries as $country) { ?>
                            <option value="<?= $country->country_symbol ?>" data-value="<?= $country->country_name ?>" ><?= $country->country_name ?></option>

                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Privacy</label>
                    <select name="privacy" class="form-control">
                        <option value="">All Privacy</option>
                        <option value="0">Public Place</option>
                        <option value="1">private passcode</option>
                        <option value="2">Private Facebook</option>
                    </select>
                </div>

                <div class="form-group">
                    <label >Location Type</label>
                    <select class="form-control  locationType" name="type" id="locationType">
                        <option value="">Select Type</option>
                        <option value="business">Business</option>
                        <option value="personal">Personal</option>
                        <option value="event">Event</option>
                    </select>
                </div>

                <div class="form-group">
                    <label >Category </label>
                    <select class="form-control   locationCategory" name="category" id="locationCategory" >
                        <option value="">Select Category</option>
                    </select>
                </div>

                <div class="form-group input-group hidden">
                    <span class="input-group-addon">@</span>
                    <input type="text" class="form-control" name="username" placeholder="Username" data-toggle="tooltip"  data-placement="left" title="User Name" >
                </div>
                
                <input type="submit"  value="Get Report" name="submit" class="btn btn-default" >
                <button type="reset" class="btn btn-default">Reset </button>  

            </form>

        </div>
        <?php if(isset($count)) : ?>
        <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?= $count ?></p>
                    <p class="announcement-text">Location(s) !</p>
                  </div>
                </div>
              </div>
                <a href="<?= site_url("admin/location") ?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View  All Locations
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        <?php endif;?>

    </div><!-- /.row -->
</div><!-- /#page-wrapper -->

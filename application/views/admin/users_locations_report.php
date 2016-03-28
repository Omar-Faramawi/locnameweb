<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1>New Users & Locations Report <small>select your criteria</small></h1>
            <ol class="breadcrumb">
                <li><a href="<?= site_url('admin/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-edit"></i>New Users & Locations</li>
            </ol>
        </div>
    </div>
    
    <!-- row -->
    <div class="row">
        <div class="col-lg-6">
            <form role="form" method="post" >
                <div class="form-group">
                    <label>From:</label>
                    <div class="input-append date">
                        <input size="16" type="text" id="from_date" name="from_date" autocomplete="off" value="<?= $from_date ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>To:</label>
                    <div class="input-append date">
                        <input size="16" type="text" id="to_date" name="to_date" autocomplete="off" value="<?= $to_date ?>">
                    </div>
                </div>
                
                <input type="submit" value="Get Report" name="submit" class="btn btn-default" >
                <button type="reset" class="btn btn-default">Reset</button>
            </form>
        </div>
        <?php if(isset($location_count)) : ?>
            <div class="col-lg-3">
            	<div class="panel panel-info">
            		<div class="panel-heading">
            			<div class="row">
            				<div class="col-xs-6">
            					<i class="fa fa-comments fa-5x"></i>
            				</div>
                            <div class="col-xs-6 text-right">
                                <p class="announcement-heading"><?= $location_count ?></p>
                                <p class="announcement-text">Location(s)!</p>
                            </div>
                        </div>
                    </div>
                    <? 
					if($from_date != '')
					{	$exp_from_date = explode('/',$from_date); $res_from_date = $exp_from_date[0].'-'.$exp_from_date[1].'-'.$exp_from_date[2];	}
					if($to_date != '')
					{	$exp_to_date = explode('/',$to_date); $res_to_date = $exp_to_date[0].'-'.$exp_to_date[1].'-'.$exp_to_date[2];	}
					?>
                    <a href="<?= site_url("admin/location/$res_from_date/$res_to_date") ?>">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-7">
                                    View  All Locations
                                </div>
                                <div class="col-xs-5 text-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif;?>
        <?php if(isset($user_count)) : ?>
            <div class="col-lg-3">
            	<div class="panel panel-info">
            		<div class="panel-heading">
            			<div class="row">
            				<div class="col-xs-6">
            					<i class="fa fa-comments fa-5x"></i>
            				</div>
                            <div class="col-xs-6 text-right">
                                <p class="announcement-heading"><?= $user_count ?></p>
                                <p class="announcement-text">User(s)!</p>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url("admin/users/$res_from_date/$res_to_date") ?>">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-6">
                                    View  All Users
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
    </div>
    <!-- row -->
</div>
<!-- /#page-wrapper -->

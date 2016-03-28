<?php
if(isset($_POST['submit'])){
    $name       = $_POST['name'];
    $title      = $_POST['title'];
    $company    = $_POST['company'];
    $website    = $_POST['website'];
    $email      = $_POST['email'];
    $mobile     = $_POST['mobile'];

    $message  = "<b> Name: </b> $name <br/>";
    $message .= "<b> Title: </b> $title <br/>";
    $message .= "<b> Company: </b> $company <br/>";
    $message .= "<b> Website: </b> $website <br/>";
    $message .= "<b> Email: </b> $email <br/>";
    $message .= "<b> Mobile: </b> $mobile <br/>";

    $this->email->clear();
    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
    $this->email->to('mouradashry@gmail.com');
    $this->email->subject('API - New Entry');
    $this->email->message($message);

    $this->email->send();
}
?>
<div class="container main-content">
    <style>
        .api-page{
            color : #666666;
        }
        .page-intro{
            font-size: 18px;
            line-height: 27px;
        }
        .main-hd{
            color:#3498db;
            margin-top:50px;
            margin-bottom:50px;
            font-weight: 500;
            text-align: center;
        }
        .page-content{
            text-align: left;
            margin-bottom: 50px;
        }
        #aboutus-img{
            max-width: 100%;
        }
        .page-point{
            text-align: left;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .page-point .point-img{
            color :#fff;
            text-align: center;
            background-color: #3498db;
            border-radius: 100px;
            padding:10px;
            vertical-align: middle;
            display: inline-block;
            width: 70px;
            height: 70px;
        }
        .page-point .point-block{
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            text-align: center;
        }
        .page-point .point-block h3{
            margin-top: 0px;
            color: #111;
        }
        .page-point .point-block p{
            font-size: 14px;
        }
        .btn-info{
            background-color: #3498db;
            margin-bottom: 10px;
        }
        .btn_submit{
            float: right;
            margin-top: 0px !important;
        }
        #form_partner *{
            margin-bottom: 10px;
        }
    </style>
    <!-- ABOUT US PAGE STARTS HERE -->

    <div class="text-center row-fluid">
        <div class="api-page">
            <div class="page-intro">
                <p>LocName has developed an API for websites to capture their users' addresses easily and accurately using LocName's technology.</p>
                <p style="margin-top:30px;">LocName’s  API removes lengthy forms and replaces them with one single field, enhancing customer experience and reducing the amount of returned goods.</p>
            </div>
            <div class="row-fluid">
                <div class="page-content">
                    <h1 class="main-hd">Benefits of the LocName API:</h1>
                    <div class="container">
                        <div id="aboutus-img" class="col-md-6">
                            <img class="img-responsive" src="<?= base_url("assets/loc") ?>/images/api.png" alt="" />
                        </div>
                        <div class="col-md-6">
                            <div class="page-point">
                                
                                <span class="point-block col-md-9 col-xs-12">
                                    <h3 style="font-size:19px;">Simple Process</h3>
                                    <p class="lead" style="margin-bottom:10px;">Filling out just one field means shorter checkout times for the customer.</p>
                                </span>
                                <span class="point-img-container col-md-3 col-xs-12 text-center clearfix">
                                    <div class="point-img">
                                        <img src="<?= base_url("assets/loc") ?>/images/api/cog.png" alt="" />
                                    </div>
                                </span>
                            </div>
                            <div class="page-point">
                               
                                <span class="point-block col-md-9 col-xs-12">
                                    <h3 style="font-size:19px;">Details Auto filled</h3>
                                    <p class="lead" style="margin-bottom:10px;">By writing in their LocName, the customers' address details will be auto filled to your system.</p>
                                </span>
                                 <span class="point-img-container col-md-3 col-xs-12 text-center clearfix">
                                    <div class="point-img">
                                        <img src="<?= base_url("assets/loc") ?>/images/api/time.png" alt="" />
                                    </div>
                                </span>
                            </div>
                             <div class="page-point">
                                
                                <span class="point-block col-md-9 col-xs-12">
                                    <h3 style="font-size:19px;">Verified Address</h3>
                                    <p class="lead" style="margin-bottom:10px;">LocName provides information on verified addresses based on previous customer experience.</p>
                                </span>
                                <span class="point-img-container col-md-3 col-xs-12 text-center clearfix">
                                    <div class="point-img">
                                        <img src="<?= base_url("assets/loc") ?>/images/api/pin.png" alt="" />
                                    </div>
                                </span>
                            </div>

                            <div class="page-point">
                                
                                <span class="point-block col-md-9 col-xs-12">
                                    <h3 style="font-size:19px;">Saving Old Data</h3>
                                    <p class="lead" style="margin-bottom:10px;">Participate in the LocName community to receive historical details about your customer, location and verification of address.</p>
                                </span>
                                <span class="point-img-container col-md-3 col-xs-12 text-center clearfix">
                                    <div class="point-img">
                                        <img src="<?= base_url("assets/loc") ?>/images/api/note.png" alt="" />
                                    </div>
                                </span>
                            </div>
                            <div class="page-point">
                                
                                <span class="point-block col-md-9 col-xs-12">
                                    <h3 style="font-size:19px;">Accurate</h3>
                                    <p class="lead" style="margin-bottom:10px;">Confirm your customers' addresses by obtaining their exact location on the map.</p>
                                </span>
                                <span class="point-img-container col-md-3 col-xs-12 text-center clearfix">
                                    <div class="point-img">
                                        <img src="<?= base_url("assets/loc") ?>/images/api/world.png" alt="" />
                                    </div>
                                </span>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="container">
                        <div class="col-md-6">
                            <p>By joining LocName so early on, you can enjoy many perks like free membership and potentially a long-term investment with LocName.</p>
                            <a class="btn btn-info" href="<?= site_url("index/apidemo") ?>">Check a DEMO here</a>
                            <p>If you are interested, please send us your details on the right and we will be happy to answer any questions you may have.</p>
                            <a class="btn btn-info" href="<?= site_url("index/partner") ?>">Check our partners page</a>
                        </div>
                        <div class="col-md-6">
                            <form name="locnametest" id="form_partner" method="post" action="">
                                <div class="col-md-6">
                                    <input name="Name" type="text" class="form-control" placeholder="Name" maxlength="20" tabindex=1 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-6">
                                    <input name="title" type="text" class="form-control" placeholder="Title" maxlength="20" tabindex=2 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-6">
                                    <input name="company" type="text" class="form-control" placeholder="Company" maxlength="20" tabindex=3 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-6">
                                    <input name="website" type="text" class="form-control" placeholder="Website" maxlength="20" tabindex=4 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-12">
                                    <input name="email" type="text" class="form-control" placeholder="Email" maxlength="20" tabindex=5 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-12">
                                    <input name="mobile" type="text" class="form-control" placeholder="Mobile number" maxlength="20" tabindex=6 data-toggle="tooltip"  data-placement="left" />
                                </div>
                                <div class="col-md-12">
                                    <input name="submit" class="btn btn-info btn_submit" type="submit" value="Submit" tabindex=7 />
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.span4 -->
            </div>
        </div>
    </div>
    <!-- ABOUT US PAGE ENDS HERE -->
</div>

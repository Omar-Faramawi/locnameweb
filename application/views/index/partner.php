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
    $this->email->to('');
    $this->email->subject('Partner - New Entry');
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
.btn-info{
    background-color: #3498db;
    margin-bottom: 10px;
}
.btn_submit{
    width:20% !important;
    float: right;
    margin-top: 0px !important;
}
#form_partner *{
    margin-bottom: 10px;
}
</style>

        <div class="text-center row-fluid">

            <div class="api-page">
                <div class="page-intro">
                    <p>Do you want to take part in the success of a new promising idea!? And invest in a new promising startup?!</p>
                </div>
              <div class="row-fluid">
                <div class="page-content">
                    <h1 class="main-hd">Now it's possible and this is how ...</h1>
                    <div class="container">
                        <div class="col-md-6">
                            <p>Use LocName API and participate in our partnership program which will grant you many free perks and long term investment with LocName</p>
                            <p>If you interested to know how it works and want more details please send us your contact information and we will contact you very soon.. </p>
                        </div>
                        <div class="col-md-6">
                            <form name="locnametest" id="form_partner" method="post" action="">
                                <div class="col-md-6">
                                    <input name="Name" type="text" class="form-control" placeholder="Name" maxlength="50" tabindex=1 data-toggle="tooltip"  data-placement="left" title="Enter Name"/>
                                </div>
                                <div class="col-md-6">
                                    <input name="title" type="text" class="form-control" placeholder="Title" maxlength="50" tabindex=2 data-toggle="tooltip"  data-placement="left" title="Enter Title"/>
                                </div>
                                <div class="col-md-6">
                                    <input name="company" type="text" class="form-control" placeholder="Company" maxlength="50" tabindex=3 data-toggle="tooltip"  data-placement="left" title="Enter Company Name"/>
                                </div>
                                <div class="col-md-6">
                                    <input name="website" type="text" class="form-control" placeholder="Website" maxlength="100" tabindex=4 data-toggle="tooltip"  data-placement="left" title="Enter Website Address" />
                                </div>
                                <div class="col-md-12">
                                    <input name="email" type="text" class="form-control" placeholder="Email" maxlength="50" tabindex=5 data-toggle="tooltip"  data-placement="left" title="Enter Email Address" />
                                </div>
                                <div class="col-md-12">
                                    <input name="mobile" type="text" class="form-control" placeholder="Mobile number" maxlength="20" tabindex=6 data-toggle="tooltip"  data-placement="left" title="Enter Mobile Number"/>
                                </div>
                                <div class="col-md-12">
                                    <input name="submit" class="btn btn-info btn_submit" type="submit" value="Submit" tabindex=7 />
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        <!-- ABOUT US PAGE ENDS HERE -->


    </div>                </div>
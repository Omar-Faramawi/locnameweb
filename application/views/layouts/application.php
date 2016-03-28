<html prefix="og: http://ogp.me/ns#">
    <head>
        <title><? if($site_title) {?><?= $site_title?> |  <? } ?><?= $page_title ?></title>
        <meta charset="utf-8">
        <link rel="icon" href="<?= base_url("assets/main/img/blueicon.ico")?>" type="image/x-icon">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
        <!-- Meta [ Describtion - Keywords - Social ] -->
        <meta name="description" content="" /> <!-- TODO  -->
         <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">
        
        <meta property="og:url" content="<?= current_url(); ?>">
        <meta property="og:title" content="<?= $site_title?>|<?= $page_title ?> "/>
        <meta property="og:image" content="<?= (isset($metaImg) && strlen($metaImg) > 2 ) ? $metaImg : base_url("assets/main/img/logo.png")  ?>"/>
	 


        <!-- STYLES -->
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/normalize.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/bootstrap.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/main.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/bootstrap-social.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/jquery.feedback_me.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/perfect-scrollbar.css" type="text/css"/>
        <link rel="stylesheet" href="<?= base_url("assets/main")  ?>/css/bootstrap-responsive.min.css" type="text/css"/>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url("assets/main") ?>/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url("assets/main") ?>/css/rateit.css">

        <!-- JAVASCRIPT -->
        <script>
            window.site_url = "<?= site_url() ?>";

        // TWITTER WIDGET
            !function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = p + '://platform.twitter.com/widgets.js';
                fjs.parentNode.insertBefore(js, fjs);
            }
            }(document, 'script', 'twitter-wjs');

        // FACEBOOK WIDGET
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1376235535961215";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

    </head>
    <body>
        
        <!-- <div id="header-back"></div> -->
        <?php if (!$showSearchHeader) { ?>
            <!-- <div id="search-back"></div> -->
        <?php } ?>

        <div id="wrapper">
            
            <?php $this->load->view("layouts/nav") ?>

            <?php if (!$showSearchHeader) { ?>

                <div id="search-header">

                    <a href="<?= site_url() ?>" class="top-logo">
                        <img src="<?= base_url("assets/main") ?>/img/logo.png" alt="logo" />
                    </a>

                    <div class="input-append input-append-top">
                         <form  method="GET" action="<?= site_url("location/redirect") ?>" >
                             <input class="span4 search-box"  autocomplete="off" name="title" placeholder="Write here a LocName to look up it" id="appendedInputButton" type="text" data-toggle="tooltip"  data-placement="left" title="Write LocName">
                        <input type="submit" name="" value="SEARCH"  class="btn search-button" />
                        </form>
                    </div>

                </div>
            <?php } ?>


            <div id="body">

                <div class="">

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> <?= get_flashdata("success") ?>
                        </div>
                    <?php endif ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-error">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> <?= get_flashdata("error") ?>
                        </div>
                    <?php endif ?>

                    <?php if ($this->session->flashdata('info')): ?>
                        <div class="alert alert-info">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Note!</strong> <?= get_flashdata("info") ?>
                        </div>
                    <?php endif ?>

                    <?php if ($this->session->flashdata('warning')): ?>
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Warning!</strong> <?= get_flashdata("warning") ?>
                        </div>
                    <?php endif ?>
                    <?= $yield ?>
                </div>


            </div>

            <?php $this->load->view("layouts/footer") ?>
        </div>
        
        <!-- JAVASCRIPT -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="<?= base_url("assets/main") ?>/js/bootstrap-typeahead.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="<?= base_url("assets/main") ?>/js/parsley.min.js"></script>
        <script src="<?= base_url("assets/main") ?>/js/bootstrap.js"></script>
       
        <script src="<?= base_url("assets/main") ?>/js/jquery.autocomplete.js"></script>
        <script src="<?= base_url("assets/main") ?>/js/perfect-scrollbar.js"></script>
        <!--<script src="<?= base_url("assets/main") ?>/js/jquery.js"></script>-->
        <!--<script src="<?= base_url("assets/main") ?>/js/jquery.ui.js"></script>-->
        <script src="<?= base_url("assets/main") ?>/js/jquery.feedback_me.js"></script>
        
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <?php if($this->router->fetch_method() != "takeme") { ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
        <?php } ?>
 <script src="<?= base_url("assets/main") ?>/js/scripts.js"></script>
        <script type="text/javascript" src="<?= base_url("assets/main") ?>/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?= base_url("assets/main") ?>/js/jquery.rateit.min.js"></script>

        

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  
  ga('create', 'UA-51530230-1', 'locname.com');
  ga('send', 'pageview');

</script>


    </body>
</html>

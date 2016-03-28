<!DOCTYPE html><html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Dashboard - LocName Admin</title>
        <!-- Bootstrap core CSS -->
        <link href="<?= base_url();?>assets/admin/css/bootstrap.css" rel="stylesheet">
        <!-- Add custom CSS here -->
        <link href="<?= base_url()?>assets/admin/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url()?>assets/admin/font-awesome/css/font-awesome.min.css">
        <?php if(isset($css_files)) {foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach;  }?>
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	</head>
    <body>
        <div id="wrapper">
            <!-- start of sidebar and header -->
            <?php $this->load->view('admin/header')?>
            <!--  contents section -->
            <?= $yield ;?>
        </div><!-- /#wrapper -->
        <!-- JavaScript -->
        <script src="<?= base_url()?>assets/admin/js/jquery-1.10.2.js"></script>
        <script src="<?= base_url()?>assets/admin/js/bootstrap.js"></script>
        <!-- Page Specific Plugins -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
        <script src="<?= base_url()?>assets/admin/js/morris/chart-data-morris.js"></script>
        <script src="<?= base_url()?>assets/admin/js/tablesorter/jquery.tablesorter.js"></script>
        <script src="<?= base_url()?>assets/admin/js/tablesorter/tables.js"></script>
        <script src="<?= base_url()?>assets/admin/js/scripts.js"></script>
        <script type="text/javascript" src="<?= base_url()?>assets/admin/js/jquery-1.6.2.min.js"></script>
        <script src="<?= base_url()?>assets/admin/js/jquery-ui-1.8.min.js"></script>
        <?php if(isset($js_files))  { foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script><?php endforeach; }  ?>
		<script>
			$(document).ready(function() {
				$("#from_date").datepicker();
				$("#to_date").datepicker();
			});
        </script>
    </body>
</html>

 <!-- begin of header -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= site_url(); ?>">Back to LocName</a>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <!-- begin of navbar -->
        <?php $this->load->view('admin/navbar');?>
        <!-- end of navbar -->
        <!-- rest of the header code -->
        <ul class="nav navbar-nav navbar-left navbar-user hide">
            <li class="dropdown messages-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope"></i> Messages <span class="badge">
                <?php // echo count($latestContacts) ?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header"><?php // echo count($latestContacts) ?> New Messages</li>
						<?php //foreach($latestContacts as $contact) {  ?>
                    <li class="message-preview">
                        <a href="#">
                            <span class="avatar"><img src="http://placehold.it/50x50"></span>
                            <span class="name"><?php // $contact->name ?></span>
                            <span class="message"><?php  //$contact->subject ?></span>
                            <span class="time">
                            	<i class="fa fa-clock-o"></i><?php // unix_to_human($contact->sent_date) ?>
                            </span>
                        </a>
                    </li>
                    <li class="divider"></li>
					<?php // } ?>
                </ul>
            </li>
            <li class="dropdown alerts-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i> Alerts <span class="badge">3</span><b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Default <span class="label label-default">Default</span></a></li>
                    <li><a href="#">Primary <span class="label label-primary">Primary</span></a></li>
                    <li><a href="#">Success <span class="label label-success">Success</span></a></li>
                    <li><a href="#">Info <span class="label label-info">Info</span></a></li>
                    <li><a href="#">Warning <span class="label label-warning">Warning</span></a></li>
                    <li><a href="#">Danger <span class="label label-danger">Danger</span></a></li>
                    <li class="divider"></li>
                    <li><a href="#">View All</a></li>
                </ul>
            </li>
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Amr Soliman <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li>
                    <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-power-off"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
	</div>
</nav>
<!-- end of header -->

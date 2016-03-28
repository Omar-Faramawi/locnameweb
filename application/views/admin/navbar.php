<!-- sidebar code -->
<ul class="nav navbar-nav side-nav">
    <li <?= ($this->uri->segment(2) === FALSE || $this->uri->segment(2) === "index")? "class='active'" : "" ?> ><a href="<?= site_url('admin/index');  ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li <?= ($this->uri->segment(2) === "category")? "class='active'" : "" ?> ><a href="<?= site_url('admin/category');?>"><i class="fa fa-file"></i> Categories</a></li>
    <li <?= ($this->uri->segment(2) === "location")? "class='active'" : "" ?> ><a href="<?= site_url('admin/location');?>"><i class="fa fa-file"></i> Locations </a></li>
    <li <?= ($this->uri->segment(2) === "users")? "class='active'" : "" ?> ><a href="<?= site_url('admin/users');?>"><i class="fa fa-file"></i> Users</a></li>
    <li <?= ($this->uri->segment(2) === "contact_messages")? "class='active'" : "" ?> ><a href="<?= site_url('admin/contact_messages');?>"><i class="fa fa-file"></i> Contact Messages</a></li>
    <li <?= ($this->uri->segment(2) === "testimonials")? "class='active'" : "" ?> ><a href="<?= site_url('admin/testimonials');?>"><i class="fa fa-file"></i> Testimonials</a></li>
    <li <?= ($this->uri->segment(2) === "location_meta")? "class='active'" : "" ?> ><a href="<?= site_url('admin/location_meta');?>"><i class="fa fa-file"></i> Location Meta </a></li>
    <li <?= ($this->uri->segment(2) === "verify")? "class='active'" : "" ?> ><a href="<?= site_url('admin/verify');?>"><i class="fa fa-file"></i> Verify Location  </a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> LocName Reports <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li <?= ($this->uri->segment(2) === "report")? "class='active'" : "" ?> ><a href="<?= site_url('admin/report');?>"><i class="fa fa-file"></i> Report Tool </a></li>
            <li <?= ($this->uri->segment(2) === "users_locations_report")? "class='active'" : "" ?> ><a href="<?= site_url('admin/users_locations_report');?>"><i class="fa fa-file"></i> New Users & LocNames </a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> User Retention Module <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li <?= ($this->uri->segment(2) === "ret_no_locations")? "class='active'" : "" ?> ><a href="<?= site_url('admin/ret_no_locations');?>"><i class="fa fa-file"></i> No Locations </a></li>
            <li <?= ($this->uri->segment(2) === "ret_no_visits")? "class='active'" : "" ?> ><a href="<?= site_url('admin/ret_no_visits');?>"><i class="fa fa-file"></i> No Visits </a></li>
            <li <?= ($this->uri->segment(2) === "ret_loc_became_inactive")? "class='active'" : "" ?> ><a href="<?= site_url('admin/ret_loc_became_inactive');?>"><i class="fa fa-file"></i> Locations Became Inactive </a></li>
            <li <?= ($this->uri->segment(2) === "ret_app_became_inactive")? "class='active'" : "" ?> ><a href="<?= site_url('admin/ret_app_became_inactive');?>"><i class="fa fa-file"></i> App Became Inactive </a></li>
            <li <?= ($this->uri->segment(2) === "ret_settings")? "class='active'" : "" ?> ><a href="<?= site_url('admin/ret_settings');?>"><i class="fa fa-file"></i> Settings </a></li>
        </ul>
    </li>
    <li <?= ($this->uri->segment(2) === "update_mailchimp")? "class='active'" : "" ?> ><a href="<?= site_url('admin/update_mailchimp');?>"><i class="fa fa-file"></i> Update Mailchimp List</a></li>
    <li <?= ($this->uri->segment(2) === "locationReports")? "class='active'" : "" ?> ><a href="<?= site_url('admin/locationReports');?>"><i class="fa fa-file"></i> Report Weekly </a></li>
    <li <?= ($this->uri->segment(2) === "bulk")? "class='active'" : "" ?> ><a href="<?= site_url('admin/bulk');?>"><i class="fa fa-file"></i> Bulk Tool</a></li>
    <li><a href="<?= site_url('auth/logout');?>"><i class="fa fa-file"></i> logout </a></li>
    <!--
    <li><a href="<?= site_url('admin/users');?>"><i class="fa fa-file"></i> Users</a></li>
    -->
</ul>
<!-- end of side bar -->
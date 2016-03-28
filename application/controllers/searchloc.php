<?php

class SearchLoc extends User_Controller{
	
	function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in()) {
            $this->session->set_userdata(array('current_url' => base_url(uri_string())));
            redirect("auth/login");
        }
    }

    function index() {
        $this->data["headerTitle"] = "Search Locname";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Search Locname";
    }
}
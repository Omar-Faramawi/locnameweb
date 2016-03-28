<?php

class Notifications extends User_Controller {

    function __construct() {
        parent::__construct();
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->session->set_userdata(array('current_url' => base_url(uri_string())));
            redirect("auth/login");
        }
    }

    function index($offset = 0) {
        $this->load->model("notification_model");

        $this->data["headerTitle"] = "Notifications";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Notifications";

        $notifications = $this->notification_model->get_notifications($this->user->id);

        /* Load the 'pagination' library */
        $this->load->library('pagination');

        /* Set the config parameters */
        $config['base_url'] = site_url("notifications/index");
        $config['total_rows'] = count($notifications);
        $config['per_page'] = 9;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $this->data["notifications"] = $notifications;
        $this->data["links"] = $this->pagination->create_links();
    }
    
    function read_all() {
        $this->load->model("notification_model");
        $this->notification_model->read_all_notifications($this->user->id);
        redirect("notifications");
    }
    
    function read_notification($notification_id = 0) {
        $this->load->model("notification_model");
        $this->notification_model->read_notification($notification_id);
        $notification = $this->notification_model->get_notification($notification_id);

        switch($notification->call_to_action) {
            case "friend_profile":
                redirect("friends/locations/" . $notification->friend_id);
                break;
            case "location":
                redirect($notification->location_title);
                break;
            case "create_location":
                redirect(site_url());
                break;
        }
        redirect("notifications");
    }

}

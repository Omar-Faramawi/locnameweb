<?php

/**
 * Description of Report API
 *
 * @author  Amr Soliman
 * @email <info@mezatech.com>
 */
class Report extends USER_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->layout = false;
    }

    function send() {
        $this->load->library('user_agent');

        $this->load->model("report_model", "reportModel");
        $this->reportModel->insert(array(
            "message" => $this->input->post("message"),
            "reason" => $this->input->post("about"),
            "location_id" => $this->input->post("location_id"),
            "user_id" => $this->data["user"]->id
        ));
        $this->session->set_flashdata("success", "Thanks, we will contact you soon.");
        redirect($this->agent->referrer());
    }

}

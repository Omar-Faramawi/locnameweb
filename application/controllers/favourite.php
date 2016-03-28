<?php
/**
 * Description of Favorite
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class Favourite extends User_Controller {

    function __construct() {
        parent::__construct();
        if(!$this->ion_auth->logged_in()) {
            $this->session->set_userdata(array('current_url' => base_url(uri_string())));
            redirect("auth/login");
        }
        $this->load->model("favourite_model", "favModel");
        $this->load->model("location_model", "locModel");
    }

    function index() {
//        $this->data["favs"] = $this->favModel->with("location")->get_many_by("user_id"  , $this->data["user"]->id);
        $this->data["headerTitle"] = "Favorites";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Favorites";
        $this->data["favs"] = $this->favModel->order_by("id", "DESC")->with("location")->getFavsByUserId($this->data["user"]->id);
    }

    function delete($id = 0) {
		$result = $this->favModel->delete_by(array("id" => $id , "user_id" => $this->data["user"]->id));
        if($result)
			flashdata("success", "Location has been deleted successfully from your favorites");
        else
             flashdata("error", "Location has not been deleted from your favorites");
        redirect("favourite");
    }

    function delete_from_location_view($id = 0) {
        $result = $this->favModel->delete_by(array("id" => $id , "user_id" => $this->data["user"]->id));
        if($result){
            flashdata("success", "Location has been deleted successfully from your favorites");
            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');
        }
        else{
            flashdata("error", "Location has not been deleted from your favorites");
            
        }
    }

    function create() {
        $this->view = false;
        $this->layout = false;
        if(!$this->ion_auth->logged_in()) {
            return false;
        }
        $this->load->model("favourite_model" , "favModel");
        //if($this->favModel->get_by(array("user_id" => $this->data["user"]->id , "location_id" => $this->input->post("location") ))) {
		if($this->favModel->verify_favourite($this->data["user"]->id , $this->input->post("location")))
		{
            die("founded");
        }
        $result = $this->favModel->insert(array(
           "location_id" => $this->input->post("location"),
            "user_id" => $this->data["user"]->id
        ));
        if($result) {
            die("true");
        }
    }

	function createnew() {
        /*$this->view = false ;
        $this->layout = false ;*/
		$loc_id = $this->uri->segment(3);
		$loc_title = $this->uri->segment(4);
        if(!$this->ion_auth->logged_in()) {
            return false;
        }
        $this->load->model("favourite_model" , "favModel");
		if($this->favModel->verify_favourite($this->data["user"]->id , $loc_id))
		{
            //die("founded");
			//$this->session->set_flashdata('message', 'founded');
        }
        $result = $this->favModel->insert(array(
           "location_id" => $loc_id,
            "user_id" => $this->data["user"]->id
        ));
        if($result) {
            //die("true");
			//$this->session->set_flashdata('message', 'true');
        }
		redirect(site_url($loc_title));
    }
}

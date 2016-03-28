<?php
/* To Do : Build search query once */
class Search extends User_Controller {

    public $locationTypes = array("business" => "business", "event" => "event", "personal" => "personal", "public" => "public");

    function __construct() {
        parent::__construct();
        $this->load->model("location_model", "locationModel");
		$this->load->library('pagination');
        $this->load->helper("public");
    }

    function index() {
       if($this->input->get("per_page") > 0){
            $offset = $this->input->get("per_page");
       }else{
        $offset = 0;
       }
       if (strlen($this->input->get("username")) > 2) {
            $this->load->model("user_model", "userModel");
            $user = $this->userModel->get_by(array("username" => $this->input->get("username")));
        }
		
        $this->data["headerTitle"] = "Search Results";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Search Results";

	    if($user->id) {
			$this->db->where("user_id", $user->id);
		}	
		if (strlen($this->input->get("title")) > 1) {
            $this->db->like("title", $this->input->get("title"));
        }
        if (strlen($this->input->get("mobile")) > 1) {
            $this->db->where("mobile", $this->input->get("mobile"));
        }
        if (strlen($this->input->get("country")) > 1) {
            $this->db->where("country", $this->input->get("country"));
        }
        if (strlen($this->input->get("type")) > 1) {
            $this->db->where("type", $this->input->get("type"));
        }
        if (strlen($this->input->get("category")) > 1) {
            $this->db->where("category_id", $this->input->get("category"));
        }
		
        $this->db->where("is_private", 0);
        $query = $this->db->get('location');
        $config["total_rows"] = $query->num_rows();
		$config["base_url"] = site_url("search/index?mobile=".$this->input->get("mobile")."&country=".$this->input->get("country")."&type=".$this->input->get("type")."&username=".$this->input->get("username"));
		$config["per_page"] = 9;
		$config["uri_segment"] = 3;
		$config["num_links"] = 10;
		$this->pagination->initialize($config);
        if (strlen($this->input->get("username")) > 2) {
            $this->load->model("user_model", "userModel");
            $user = $this->userModel->get_by(array("username" => $this->input->get("username")));
        }

        if($user->id) {
            $this->db->where("user_id", $user->id);
        }   
        if (strlen($this->input->get("title")) > 1) {
            $this->db->like("title", $this->input->get("title"));
        }
        if (strlen($this->input->get("mobile")) > 1) {
            $this->db->where("mobile", $this->input->get("mobile"));
        }
        if (strlen($this->input->get("country")) > 1) {
            $this->db->where("country", $this->input->get("country"));
        }
        if (strlen($this->input->get("type")) > 1) {
            $this->db->where("type", $this->input->get("type"));
        }
        if (strlen($this->input->get("category")) > 1) {
            $this->db->where("category_id", $this->input->get("category"));
        }
        
        $this->db->where("is_private", 0);

        $last_query = $this->db->last_query();
		$this->data["locations"] = $this->db->limit($config["per_page"], $offset)
                                            ->get('location')
                                            ->result();
		$this->data["links"] = $this->pagination->create_links();
    }
}

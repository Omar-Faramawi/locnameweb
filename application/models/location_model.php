<?php

/**
 * Description of Location Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */

class Location_model extends MY_Model {

    protected $_table = 'location';
    protected $after_get = array('afterGet');
    protected $validate = array(
        array(
            'field' => 'title',
            'label' => 'lang:title',
            'rules' => 'trim|required|is_unique[location.title]'),
        array(
            'field' => 'latitude',
            'label' => 'lang:latitude',
            'rules' => 'trim'),
        array(
            'field' => 'longitude',
            'label' => 'lang:longitude',
            'rules' => 'trim'),
        array(
            'field' => 'user_id',
            'label' => 'lang:user_id',
            'rules' => 'trim'),
        array(
            'field' => 'details',
            'label' => 'lang:details',
            'rules' => 'trim'),
    );

    public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "user_id"),
        'category' => array('model' => 'category_model', "primary_key" => "category_id"),
        'meta' => array('model' => 'location_meta_model', "primary_key" => "id")
    );

    public $before_create = array('created_at', 'updated_at');
    public $before_update = array('beforeEdit');

    function __construct() {
        parent::__construct();
    }

    function valid_locname($title) {
        // check premium short codes
        if(strlen($title) == 1 || strlen($title) == 2)
            return false;
        if(strlen($title) == 3 && (($title[0] == chr(ord($title[1]) - 1) && $title[1] == chr(ord($title[2]) - 1)) || ($title[0] == $title[1] || $title[1] == $title[2] || $title[0] == $title[2])))
            return false;
        if(strlen($title) == 4 && (($title[0] == chr(ord($title[1]) - 1) && $title[1] == chr(ord($title[2]) - 1) && $title[2] == chr(ord($title[3]) - 1)) || ($title[0] == $title[1] || $title[1] == $title[2] || $title[2] == $title[3] || ($title[0] == $title[2] && $title[1] == $title[3]))))
            return false;
        if(strlen($title) == 5 && (($title[0] == $title[1] && $title[1] == $title[2] && $title[2] == $title[3] && $title[3] == $title[4]) || ($title[0] == $title[1] && $title[1] == $title[2] && $title[2] == $title[3]) || ($title[1] == $title[2] && $title[2] == $title[3] && $title[3] == $title[4]) || ($title[0] == $title[1] && $title[1] == $title[3] && $title[3] == $title[4])))
            return false;
        // check special characters
        $chars = preg_quote( ' ~`!@#$%^&*()+={}[]|:;,<>.?/\\\'', '#' );
        $regex = "#[$chars]+#";
        return ( !preg_match($regex, $title) ) ? true : false;
    }

    function afterGet($row) {
        if ($row) {
            $this->load->model("rating_model", "ratingModel");
            $row->rating = $this->ratingModel->calcLocationRate($row->id);
            //$row->imagePath = base_url("assets/uploads/locations_images/" . $row->photo);
            $date = date_create($row->created_at);
            $row->privacy = "Public";
            if ($row->is_private == "0")
                $row->privacy = "Public";
            else
                $row->privacy = "Private";
            $row->date = date_format($date, 'jS F Y');
            $verified = $this->is_verified($row->id);
            $row->verified = ($verified) ? $verified->status : 0;
            return $row;
        }
    }

    function beforeEdit($row) {
        $query = $this->db->from($this->_table)->where("title", $row["title"])->limit(1)->get();
		//die(var_dump($query->row()));
        if ($query->row() && $query->row()->id == $row["location_id"]) {
            $this->validate[0]["rules"] = 'trim|required';
        }

        if ($row["is_private"] == 0 || $row["is_private"] == 2) {
            $row["passcode"] = "";
        }

        unset($row["location_id"]);
        return $row;
    }

    function autocomplete($title = "") {
        $this->db->where('temporary', 0);
        //$this->db->where('country', 'United States');
        return $this->db->select("id, title, country")->where("temporary", "0")->like("title", $title)->get($this->_table)->result();
    }
     function autocompleteForEngine($title = "") {
        $this->db->where('temporary', 0);
        //$this->db->where('country', 'United States');
        return $this->db->select("title as description,address as formatted_address,latitude,longitude,country,governorate,city,area_level_2 as district,street as street_address,street_number,building_number,flat_number as floor_number,postal_code,is_private,passcode")->where("temporary", "0")->like("title", $title)->limit(5)->get($this->_table)->result();
    }

    function autocompleteWeb($title = "", $country_name = "") {
        $this->db->where('temporary', 0);
        $this->db->where('country', $country_name);
        return $this->db->select("id, title, country")->where("temporary", "0")->like("title", $title, 'after')->get($this->_table)->result();
    }

    function is_verified($location_id) {
        $this->load->model("verify_model");
        return $this->verify_model->get_by(array("location_id" => $location_id));
    }

    function get_user_locations($user_id) {
        return $this->db
                    ->select("location.id, location.title, COALESCE(category.title, '') as category, COALESCE(category.type, 'general') as type", FALSE)
                    ->join("category", "location.category_id = category.id", "left")
                    ->where("user_id", $user_id)
                    ->where("temporary", 0)
                    ->order_by("location.title")
                    ->get($this->_table)
                    ->result();
    }

    function get_location($location_id = false) {
        return $this->db
                    ->select("location.*, COALESCE(category.title, '') as category, COALESCE(category.type, 'general') as type", FALSE)
                    ->join("category", "location.category_id = category.id", "left")
                    ->where("location.id", $location_id)
                    ->get($this->_table)->row();
    }

    function get_location_api($title = false) {
        return $this->db
                    ->select("title, short_code, country, city, address, latitude, longitude, building_number, flat_number")
                    ->where("title", $title)
                    ->get($this->_table)->row();

    }
    function getAllLocations(){
      return $this->db->get($this->_table)->result();
    }
    function update_location_short_code($location_id = false, $short_code = false){
      $data = array(
               'short_code' => $short_code
            );

      $this->db->where('id', $location_id);
      $this->db->update($this->_table, $data);
    }
 function get_location_by_title($title = false){
         return $this->db
                    ->select("location.*, COALESCE(category.title, '') as category, COALESCE(category.type, 'general') as type", FALSE)
                    ->join("category", "location.category_id = category.id", "left")
                    ->where("location.title", $title)
                    ->get($this->_table)->row();
    }
}

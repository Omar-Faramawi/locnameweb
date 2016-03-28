<?php

class Location_Images_model extends MY_Model {

	 protected $_table = 'location_images';

    function __construct() {
        parent::__construct();
    }

    public $belongs_to = array(
        'location' => array('model' => 'location_model', "primary_key" => "location_id")
    );

    function get_location_images($location_id){
        return $this->db->where("location_id", $location_id)
                        ->get($this->_table)
                        ->result();
    }

}
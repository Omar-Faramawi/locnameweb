<?php

class Temp_location_model extends MY_Model {

    protected $_table = 'temp_location';

    function __construct() {
        parent::__construct();
    }
    function getLocation($id="",$email="") {
        $location = $this->db
                ->select("*")
                ->where("id",$id)
                ->where("email",$email)
                ->get($this->_table)
                ->result();
        
        
        return $location[0];
    }
}

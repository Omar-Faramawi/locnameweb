<?php

class Preference_model extends MY_Model{

    protected $_table = 'preference';

    function __construct() {
        parent::__construct();
    }

    function get_preferences(){
    	return $this->db->get($this->_table)->result();
    }
}
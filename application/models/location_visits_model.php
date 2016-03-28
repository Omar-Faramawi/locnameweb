<?php

/**
 * Description of Location_Visits Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class Location_visits_model extends MY_Model {

    protected $_table = 'location_visits';
    protected $after_get = array('prepare');

    function __construct() {
        parent::__construct();
    }

    public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "user_id"),
        'users' => array('model' => 'user_model', "primary_key" => "user_id"),
        'location' => array('model' => 'location_model', "primary_key" => "location_id")
    );

    function prepare($row) {
        return $row;
    }
}
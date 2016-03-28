<?php

/**
 * Description of Rating Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class rating_model extends MY_Model {

    protected $_table = 'rating';
    protected $before_create = array('beforeInsert');

    function __construct() {
        parent::__construct();
    }

    function beforeInsert($row) {

        if($row) {
           $is_voted = $this->delete_by(array("user_id" => $row["user_id"], "location_id" => $row["location_id"]));
        }
        return $row;
    }

    function calcLocationRate($location_id) {
        $ratings = $this->db->where("location_id", $location_id)->select("SUM(`rating`) AS ratings")->get($this->_table)->row()->ratings;
        $counts = $this->count_by("location_id", $location_id);
        if($counts == 0)
            $rate->rate = $ratings ;
        else 
            $rate->rate = $ratings / $counts;
        $rate->count=$counts;
        return $rate;
    }
}

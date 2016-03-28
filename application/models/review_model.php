<?php

/**
 * Description of Rating Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class review_model extends MY_Model {

    protected $_table = 'review';
	public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "user_id"),
        'location' => array('model' => 'location_model', "primary_key" => "location_id")
    );
	
    protected $before_create = array('beforeInsert');

    function __construct() {
        parent::__construct();
    }

function beforeInsert($row) {

        
        return $row;
    }
    function getReviews($location_id) {
        
                $review=$this->db->query("select * from review left join users on users.id=review.user_id where review.location_id=$location_id order by review.id DESC")->result();
        return $review;
    }
}

<?php

/**
 * Description of Favourite Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class favourite_model extends MY_Model {

    protected $_table = 'favourite';
    public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "user_id"),
        'location' => array('model' => 'location_model', "primary_key" => "location_id"),
        'category' => array('model' => 'category_model', "primary_key" => "location_id")
    );
    public $before_create = array('created_at');

    function __construct() {
        parent::__construct();
    }

    function getFavsByUserId($userId) {
        return $this->db
                        ->select("category.title as category, location.title , location.address , location.details, location.type, favourite.* ")
                        ->join("location", "favourite.location_id = location.id", "left")
                        ->join("category", "category.id = location.category_id", "left")
                        ->get_where($this->_table, array("favourite.user_id" => $userId))
                        ->result();
    }

    function get_fav_locations($user_id) {
        return $this->db
                        ->select("location.id, location.title, category.title as category, category.type, location.user_id")
                        ->join("location", "location.id = favourite.location_id", "left")
                        ->join("category", "location.category_id = category.id", "left")
                        ->where("favourite.user_id", $user_id)
                        ->order_by("location.title")
                        ->get($this->_table)
                        ->result();
    }

    function verify_favourite($user_id, $location_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get('favourite');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function check_favourite($user_id, $location_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get('favourite');
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach ($result as $row) {
                return $row->id;
            }
        }
        return 0;
    }
    
    function delete_favorite($user_id, $location_id) {
        $this->db->delete($this->_table, array('user_id' => $user_id, 'location_id' => $location_id));
    }
}

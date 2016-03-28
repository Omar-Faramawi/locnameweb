<?php

/**
 * Description of User Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class User_model extends MY_Model {

    protected $_table = 'users';
    protected $after_get = array('prepare');
    protected $validate = array(
        array(
            'field' => 'username',
            'label' => 'lang:title',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required|valid_email|is_unique[users.email]'
        ),
        array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required'
        ),
        array(
            'field' => 'password_confirm',
            'label' => 'confirm password',
            'rules' => 'required|matches[password]'
        ),
    );
    public $has_many = array('locations' => array('model' => 'location_model', "primary_key" => "user_id"));
    public $belongs_to = array(
        'provider' => array('model' => 'authentications_model', "primary_key" => "user_id"),
        'user_group' => array('model' => 'user_group_model', "primary_key" => "user_id")
    );

    function __construct() {
        parent::__construct();
    }

    protected function prepare($row) {
        if ($row) {
            $row->full_name = $row->first_name . ' ' . $row->last_name;
            $row->joined_at = date("F j, Y, g:i a", $row->created_on);
            $this->load->model("follow_model", "followModel");
            $row->followers_count = $this->followModel->count_by("follow_id", $row->id);
            $row->imagePath = userPhotoPath($row->id);
            return $row;
        }
    }

    function getUser($id = false) {
        return $this->db
                        ->select("users.*, authentications.provider")
                        ->where("users.id", $id)
                        ->join("authentications", "authentications.user_id = users.id ", "LEFT")
                        ->get("users")->row();
    }

    function getUserByEmail($email = false) {
        return $this->db
                        ->select("id, email, first_name, last_name")
                        ->where("email", $email)
                        ->get("users")->row();
    }

    function update_last_open_app($user_id = false) {
        $this->db->query("UPDATE `users` SET `last_open_app` = UNIX_TIMESTAMP(NOW()) WHERE `id` = " . $user_id);
    }

    function getFacebookFriends($friends = array()) {
        return $this->db->select("user_id, displayName, photoURL, profileURL")
                        ->where_in('provider_uid', $friends)
                        ->get("authentications")->result();
    }

    function addUDID($id, $mobile_id) {
        $this->db->where('id', $id);
        return $this->db->update($this->_table, array("UDID" => $mobile_id));
    }

    function getFacebookUsers() {
        return $this->db
                        ->select("users.first_name, users.last_name, users.email")
                        ->where("authentications.provider", "Facebook")
                        ->join("authentications", "authentications.user_id = users.id ", "LEFT")
                        ->get("users")->result();
    }

    function getEmailUsers() {
        return $this->db->query("SELECT first_name, last_name, email FROM users WHERE id NOT IN (SELECT user_id FROM authentications)")->result();
    }
    
    function getNumOfUserLocations($id = false) {
        return $this->db
                        ->select("count(id) as num_locations")
                        ->where("user_id", $id)
                        ->get("location")->row()->num_locations;
    }
    
    function getNumOfUserFavLocations($id = false) {
        return $this->db
                        ->select("count(location_id) as num_fav_locations")
                        ->where("user_id", $id)
                        ->get("favourite")->row()->num_fav_locations;
    }
    
    function getNumOfUserInvites($id = false) {
        return $this->db
                        ->select("count(id) as num_invites")
                        ->where("user_id", $id)
                        ->get("invitation")->row()->num_invites;
    }
    
    function getNumOfUserFriends($id = false) {
        return $this->db
                        ->select("count(id) as num_friends")
                        ->where("user1_id", $id)
                        ->or_where("user2_id", $id)
                        ->get("friends")->row()->num_friends;
    }
    
    function getNumPlacesVisits($id = false) {
        return $this->db
                        ->select("count(location_visits.id) as num_visits")
                        ->join("location_visits", "location.id = location_visits.location_id", "left")
                        ->where(array("location.user_id" => $id, "location_visits.user_id <> " => $id))
                        ->get("location")->row()->num_visits;
    }
    
    function update_profile_type($id = false, $profile_type_id = false) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, array("profile_type_id" => $profile_type_id));
    }
    function verify_account($email) {
        $this->db->where('email', $email);
        $this->db->update($this->_table, array("verified" => 1));
    }
    
}

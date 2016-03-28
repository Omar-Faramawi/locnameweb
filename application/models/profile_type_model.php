<?php

class Profile_type_model extends MY_Model{

    protected $_table = 'profile_type';

    function __construct() {
        parent::__construct();
    }
    
    function getProfileTypeDetails($id) {
        $profile_type = $this->get_by("id", $id);
        $profile_type->features = $this->db->select("feature_id, amount")->where("type_id", $profile_type->id)->get("profile_type_feature")->result();
        $profile_type->actions = $this->db->select("action_id, amount")->where("type_id", $profile_type->id)->get("profile_type_action")->result();
        return $profile_type;
    }
    
    function isTopProfile($profile_id) {
        $top_id = $this->db
                        ->select("max(id) as id")
                        ->get($this->_table)
                        ->row()->id;
        if($top_id == $profile_id)
            return true;
        return false;
    }
    
    function addHistory($user_id, $profile_id) {
        $this->db->insert("profile_type_history", array("user_id" => $user_id, "profile_type_id" => $profile_id));
    }

}

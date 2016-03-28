<?php

class User_Preference_model extends MY_Model {

    protected $_table = 'user_preference';

    function __construct() {
        parent::__construct();
    }

    public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "user_id"),
        'preference' => array('model' => 'preference_model', "primary_key" => "preference_id")
    );

    function check_mail_settings($settings_id, $user_id) {
        $query = $this->db
                ->where(array("preference_id" => $settings_id, "user_id" => $user_id))
                ->get($this->_table);
        return $query->num_rows() !== 0;
    }

    function get_user_settings($user_id) {
        $query = $this->db->select('preference_id')
                ->where("user_id", $user_id)
                ->get($this->_table);
        $prefArray = array();
        foreach ($query->result() as $row) {
            array_push($prefArray, $row->preference_id);
        }
        return $prefArray;
    }

}

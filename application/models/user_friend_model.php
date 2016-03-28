<?php

/**
 * Description of Users_Friends Table
 *
 * @author Ranya Maher < ranya.maher@locname.com >
 * @company LocName < http://locname.com >
 * @version  1.0
 */
class user_friend_model extends MY_Model {

    protected $_table = 'users_friends';

    function __construct() {
        parent::__construct();
    }

    function getNewFacebookUsers() {
        return $this->db
                    ->select("provider_uid, name")
                    ->where("provider", "Facebook")
                    ->get($this->_table)->result();
    }

    function getNewEmailUsers() {
        return $this->db
                    ->select("email")
                    ->where("provider", "Contact")
                    ->get($this->_table)->result();
    }
    function checkByEmail($email = false , $user_id = false , $provider = false){
        return $this->db
                    ->select("id")
                    ->where("email", $email,'user_id',$user_id , 'provider',$provider)
                    ->get($this->_table)->row();
    }
}

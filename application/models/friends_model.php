<?php

/**
 * Description of Friends Table
 *
 * @author Ranya Maher < ranya.maher@locname.com >
 * @company LocName < http://locname.com >
 * @version  1.0
 */
class friends_model extends MY_Model {

    protected $_table = 'friends';

    function __construct() {
        parent::__construct();
    }

    function get_friend_list($user_id) {
        $users1 = $this->db
                ->select("distinct users.id, users.first_name, users.last_name,users.email, friends.since", FALSE)
                ->join("users", "friends.user1_id = users.id", "left")
                ->where("friends.user2_id", $user_id)
                ->get($this->_table)
                ->result();
        $users2 = $this->db
                ->select("distinct users.id, users.first_name, users.last_name,users.email, friends.since", FALSE)
                ->join("users", "friends.user2_id = users.id", "left")
                ->where("friends.user1_id", $user_id)
                ->get($this->_table)
                ->result();
        $users = array_merge($users1, $users2);
        usort($users, function ($a, $b) {
            return strcmp(strtolower($a->first_name . $a->last_name), strtolower($b->first_name . $b->last_name));
        });
        return $users;
    }

    function is_friend($user1_id, $user2_id) {
        $result = $this->db
                ->select("user1_id, user2_id")
                ->where("(friends.user1_id = '$user1_id' AND friends.user2_id = '$user2_id') OR (friends.user1_id = '$user2_id' AND friends.user2_id = '$user1_id')")
                ->get($this->_table)
                ->result();
        if ($result) {
            return true;
        }
        return false;
    }

     function get_friends_for_share($user_id)
    {

        $query="select distinct users.id,users.first_name,users.last_name,users.photo,
            (select count(location.id) as locations from  location where location.user_id = users.id) as locations,
            (select count(favourite.id) as favourite from  favourite where favourite.user_id = users.id) as favorites
             from friends left join users on (friends.user2_id = users.id or friends.user1_id=users.id) and users.id != $user_id where friends.user1_id = $user_id or friends.user2_id = $user_id";        

        $result = $this->db->query($query);
         return $result->result();
    }

}

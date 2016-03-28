<?php

/**
 * Description of notification Table
 *
 * @author Ranya Maher < ranya.maher@locname.com >
 * @company LocName < http://locname.com >
 * @version  1.0
 */
class notification_model extends MY_Model {

    protected $_table = 'notification';

    function __construct() {
        parent::__construct();
    }

    function get_notifications($user_id) {
        $notifications = $this->db
                        ->select("*")
                        ->where("user_id", $user_id)
                        ->order_by("date", "DESC")
                        ->get($this->_table)
                        ->result();
        
        foreach($notifications as $notification) {
            $notification->content = $this->db->select("content")->where("id", $notification->notification_type_id)->get("notification_type")->row()->content;
            $notification->call_to_action = $this->db->select("call_to_action")->where("id", $notification->notification_type_id)->get("notification_type")->row()->call_to_action;
            $notification->notification_type = $this->db->select("title")->where("id", $notification->notification_type_id)->get("notification_type")->row()->title;
            
            //$date = date('', $notification->date);
            $timestamp = strtotime($notification->date);
            $notification->date = date('F d, Y', $timestamp) . " at " . date('h:ia', $timestamp);
            
            if($notification->friend_id != null) {
                $friend = $this->db->select("first_name, last_name, photo")->where("id", $notification->friend_id)->get("users")->row();
                $notification->friend_name = $friend->first_name . " " . $friend->last_name;
                $notification->photo = $friend->photo;
            }
            
            if($notification->location_id != null) {
                $notification->location_title = $this->db->select("title")->where("id", $notification->location_id)->get("location")->row()->title;
            }
        }
        
        return $notifications;
    }
    
    function get_notification($notification_id) {
        $notification = $this->db
                        ->select("*")
                        ->where("id", $notification_id)
                        ->get($this->_table)
                        ->row();
        
        $notification->content = $this->db->select("content")->where("id", $notification->notification_type_id)->get("notification_type")->row()->content;
        $notification->call_to_action = $this->db->select("call_to_action")->where("id", $notification->notification_type_id)->get("notification_type")->row()->call_to_action;
        $notification->notification_type = $this->db->select("title")->where("id", $notification->notification_type_id)->get("notification_type")->row()->title;

        if($notification->friend_id != null) {
            $friend = $this->db->select("first_name, last_name, photo")->where("id", $notification->friend_id)->get("users")->row();
            $notification->friend_name = $friend->first_name . " " . $friend->last_name;
            $notification->photo = $friend->photo;
        }
        
        if($notification->location_id != null) {
            $notification->location_title = $this->db->select("title")->where("id", $notification->location_id)->get("location")->row()->title;
        }
        
        return $notification;
    }
    
    function num_new_notifications($user_id) {
        return $this->db
                ->select("count(*) as num")
                ->where(array("user_id" => $user_id, "read" => 0))
                ->get($this->_table)
                ->row()->num;
    }

    function read_notification($notification_id) {
        $this->db
                ->where("id", $notification_id)
                ->update($this->_table, array("read" => 1));
        return $this->db->affected_rows();
    }

    function read_all_notifications($user_id) {
        $this->db
             ->where("user_id", $user_id)
             ->update($this->_table, array("read" => 1));
        return $this->db->affected_rows();
    }
}

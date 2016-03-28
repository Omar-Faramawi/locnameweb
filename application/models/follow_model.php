<?php

/**
 * Description of Follow Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class follow_model extends MY_Model {

    protected $_table = 'follow';
    protected $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'lang:title',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'follow_id',
            'label' => 'Follower',
            'rules' => 'required'
        ),
    );
    public $belongs_to = array(
        'user' => array('model' => 'user_model', "primary_key" => "follow_id"),
    );
    public $before_create = array('created_at');

    function __construct() {
        parent::__construct();
    }

    protected function prepare($row) {

    }

    function create($user_id = 0, $follow_id = 0) {

        if ($this->is_following($user_id, $follow_id)) {
            return false;
        }
        $this->insert(array(
            "user_id" => $user_id,
            "follow_id" => $follow_id
        ));
        return true;
    }

    function is_following($user_id = 0, $follow_id = 0) {
        return $this->count_by(array("user_id" => $user_id, "follow_id" => $follow_id));
    }

    function favourite_users($id = false) {
        return $this->db
                    ->select("users.id, users.first_name, users.last_name, users.photo")
                    ->join("users", "follow.follow_id = users.id", "left")
                    ->where("follow.user_id", $id)
                    ->order_by("users.first_name, users.last_name")
                    ->get($this->_table)
                    ->result();
    }

    function following($id = false) {
        $this->belongs_to["user"]["primary_key"] = "user_id";
        $following = $this->with("user")->get_many_by(array("follow_id"=> $id));
        usort($following, function ($a, $b) {
            return strcmp(strtolower($a->user->first_name . $a->user->last_name), strtolower($b->user->first_name . $b->user->last_name));
        });
        return $following;
    }

    function followers($id = false) {
        $this->belongs_to["user"]["primary_key"] = "follow_id";
        $followers = $this->with("user")->get_many_by(array("user_id"=> $id));
        usort($followers, function ($a, $b) {
            return strcmp(strtolower($a->user->first_name . $a->user->last_name), strtolower($b->user->first_name . $b->user->last_name));
        });
        return $followers;
    }

    function followez() {
        return $this->get_many_by();
    }
}

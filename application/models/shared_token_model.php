<?php

class shared_token_model extends MY_Model {

    protected $_table = 'share_tokens';



    public $before_create = array( 'created_at' );

    function __construct() {
        parent::__construct();
    }

    function getToken($token = false) {
        return $this->db
            ->where("token", $token)
            ->get("share_tokens")->row();
    }


}

<?php

/**
 * Description of Verify Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class verify_model extends MY_Model {

    protected $_table = 'verify';

    protected $validate = array(
        array(
            'field' => 'user_id',
            'label' => 'lang:user',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'location_id',
            'label' => 'lang:location',
            'rules' => 'trim|required'
        )
    );

    public $belongs_to = array(
        'user' => array('model' => 'user_model' , "primary_key" => "user_id"),
        'location' => array('model' => 'location_model' , "primary_key" => "location_id"),
    );

    public $before_create = array( 'created_at' );

    function __construct() {
        parent::__construct();
    }
}

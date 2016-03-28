<?php

/**
 * Description of Contact Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class contact_model extends MY_Model {

    protected $_table = 'contact';

    protected $validate = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'required|min_length[10]'
        )
    );

    function __construct() {
        parent::__construct();
    }
}

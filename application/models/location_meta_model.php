<?php

/**
 * Description of Location_Meta Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class location_meta_model extends MY_Model {

    protected $_table = 'location_meta';
    public $primary_key = 'location_id';

    function __construct() {
        parent::__construct();
    }
}

<?php

/**
 * Description of Partner Table
 *
 * @author Ranya Maher < ranya.maher@hotmail.com >
 * @company LocName < http://locname.com >
 * @version  1.0
 */
class partner_model extends MY_Model {

    protected $_table = 'partner';

    function __construct() {
        parent::__construct();
    }

    function findBy($field, $value) {
        return $this->db
                    ->select("*")
                    ->where($field, $value)
                    ->get($this->_table);
    }
}

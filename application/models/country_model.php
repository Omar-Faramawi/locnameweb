<?php

/**
 * Description of Country Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class country_model extends MY_Model {

    protected $_table = 'country';

    function __construct() {
        parent::__construct();
    }

    function prepare($row) {
        return $row;
    }

    function get_country_name_by_symbol($symbol){
    	return $this->db->select('country_name')->where('country_symbol', $symbol)->get($this->_table)->result();
    }

    function getBySymbol($symbol) {
        return $this->db
                        ->select("*")
                        ->where("country_symbol", $symbol)
                        ->get($this->_table)
                        ->row();
    }
}

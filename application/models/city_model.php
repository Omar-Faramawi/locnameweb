<?php

/**
 * Description of City Table
 *
 * @author Amr Soliman < info@mezatech.com >
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */
class city_model extends MY_Model {

    protected $_table = 'city';

    function __construct() {
        parent::__construct();
    }

	function getcity($id) {
		$this->db->select('*');
		$this->db->where_not_in('city', 'NULL');
		$this->db->where('country', $id);
		$query = $this->db->get('city');
		if($query->num_rows() > 0)
			return $query->result();
	 }
}

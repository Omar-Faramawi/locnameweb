<?php

Class seo_model extends CI_Model {

    function sitemap() {
        $this->db->select("title")->from('location');
        $query = $this->db->get();
        return $query->result_array();
    }

}

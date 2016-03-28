<?php

class Testimonial_model extends MY_Model {

    protected $_table = 'testimonial';

    function __construct() {
        parent::__construct();
    }

    function getAllTestimonials() {
        $testimonials = $this->db
                ->select("*")
                ->order_by("date", "DESC")
                ->get($this->_table)
                ->result();
        
        // prepare URL
        foreach($testimonials as $testimonial) {
            if(strpos($testimonial->photo,'/') !== false) { // URL is saved
                $testimonial->photoURL = $testimonial->photo;
            } else { // image name is saved after upload
                $testimonial->photoURL = site_url("assets/images/testimonials") . "/" . $testimonial->photo;
            }
        }
        return $testimonials;
    }
}

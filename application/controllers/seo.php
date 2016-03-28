<?php

Class Seo extends CI_Controller {

    function index() {
        $this->load->model('seo_model', 'seoModel');
        $data['urls'] = $this->seoModel->sitemap();
        $this->load->view("sitemap", $data);
    }

}

?>
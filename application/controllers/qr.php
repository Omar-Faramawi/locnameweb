<?php

/**
 * Description of test
 *
 * @author  Amr Soliman
 * @email <info@mezatech.com>
 */
class Qr extends MY_Controller {

    function index($title = false) {
        $this->load->library('ciqrcode');

        header("Content-Type: image/png");


        $config['cacheable'] = false; //boolean, the default is true
        $config['cachedir'] = ''; //string, the default is application/cache/
        $config['errorlog'] = ''; //string, the default is application/logs/
        $config['quality'] = true; //boolean, the default is true
        $config['size'] = '100'; //interger, the default is 1024
        $config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
        // $this->ciqrcode->initialize($config);

        $params['data'] = site_url($title);
//        $params['name'] = ($title);
        $params['level'] = 'H';
        $params['size'] = 10;
        // $params['savename'] = FCPATH . 'assets/uploads/tes.png';
        $this->ciqrcode->generate($params);

        // echo '<img src="' . base_url() . '/assets/uploads/tes.png" />';
    }

}

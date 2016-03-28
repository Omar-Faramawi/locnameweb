<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of HybridAuthLib config
 *
 * @author Amr Soliman < info@mezatech.com>
 * @company MezaTech < http://mezatech.com >
 * @version  1.0
 */

// ----------------------------------------------------------------------------------------
// set on "base_url" the relative url that point to HybridAuth Endpoint
// IMPORTANT: If the "index.php" is removed from the URL (http://codeigniter.com/user_guide/general/urls.html) the
// "/index.php/" part __MUST__ be prepended to the base_url.


$config['base_url'] = 'auth/provider_endpoint';
//$config['base_url'] = '/';

$config['providers'] = array(
// openid providers
    "OpenID" => array(
        "enabled" => true
    ),
    "Yahoo" => array(
        "enabled" => false,
        "keys" => array("id" => "", "secret" => ""),
    ),
    "AOL" => array(
        "enabled" => false
    ),
    "Google" => array(
        "enabled" => true,
        "keys" => array("id" => "758109528207-rkassf02mls9584c00c7nnm692a0g2bd.apps.googleusercontent.com",
            "secret" => "HmbGkReueODuZpUXZ_Lp7nyO"),
        "scope" => "https://www.googleapis.com/auth/userinfo.profile   https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.google.com/m8/feeds"
    ),
    "Facebook" => array(
        "enabled" => true,
        "keys" => array("id" => "1376235535961215", "secret" => "42055f0ce428faf9fb56e60f9690f7e5"),
        "scope"=> "email, user_about_me, user_birthday, user_hometown, user_website, read_stream, read_friendlists" , 
         "display" => "popup" // optional

    ),
    "Twitter" => array(
        "enabled" => false,
        "keys" => array("key" => "", "secret" => "")
    ),
    // windows live
    "Live" => array(
        "enabled" => false,
        "keys" => array("id" => "", "secret" => "")
    ),
    "MySpace" => array(
        "enabled" => false,
        "keys" => array("key" => "", "secret" => "")
    ),
    "LinkedIn" => array(
        "enabled" => false,
        "keys" => array("key" => "", "secret" => "")
    ),
    "Foursquare" => array(
        "enabled" => false,
        "keys" => array("id" => "", "secret" => "")
    ),
);

// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
//$config['debug_mode'] = (ENVIRONMENT == 'development');

//$config['debug_file'] = APPPATH.'/logs/hybridauth.log';


/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */

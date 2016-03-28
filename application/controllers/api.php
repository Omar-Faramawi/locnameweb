<?php

/**
 * Description of mobile API
 *
 * @author  Amr Soliman
 * @email <info@mezatech.com>
 */
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{
    
    var $fbid = "1376235535961215";
    var $secret = "42055f0ce428faf9fb56e60f9690f7e5";
    var $user;
    
    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
    }
    
    /*
    function find_premium_short_codes_get() {
    $this->load->helper("public"); // for short code & short url
    $this->load->model("location_model", "locationModel");
    $locations = $this->locationModel->get_all();
    $used_short_codes = array();
    foreach($locations as $loc) {
    $used_short_codes[] = $loc->short_code;
    }
    echo "Two:" . "\n<br/>";
    echo "--------------" . "\n<br/>";
    echo "00" . "\n<br/>";
    for($i = 36; $i < 1306; $i++) {
    $x = base_convert($i, 10, 36);
    if($x[0] == $x[1])
    echo $x . "\n<br/>";
    }
    echo "Three:" . "\n<br/>";
    echo "--------------" . "\n<br/>";
    for($i = 0; $i < 36; $i++) {
    $x = base_convert($i, 10, 36);
    $x = "00" . $x;
    echo "MEDIUM: ";
    echo $x . "\n<br/>";
    }
    for($i = 36; $i < 1296; $i++) {
    $x = base_convert($i, 10, 36);
    $x = "0" . $x;
    if($x[0] == chr(ord($x[1]) - 1) && $x[1] == chr(ord($x[2]) - 1))
    {
    echo "TOP: ";
    echo $x . "\n<br/>";
    }
    else if($x[1] == $x[2] || $x[0] == $x[2])
    {
    echo "MEDIUM: ";
    echo $x . "\n<br/>";
    }
    }
    for($i = 1296; $i < 46656; $i++) {
    $x = base_convert($i, 10, 36);
    if($x[0] == chr(ord($x[1]) - 1) && $x[1] == chr(ord($x[2]) - 1))
    {
    echo "TOP: ";
    echo $x . "\n<br/>";
    }
    else if($x[0] == $x[1] || $x[1] == $x[2] || $x[0] == $x[2])
    {
    if($x[0] == $x[1] && $x[1] == $x[2])
    echo "TOP: ";
    else
    echo "MEDIUM: ";
    echo $x . "\n<br/>";
    }
    }
    echo "Four:" . "\n<br/>";
    echo "------------" . "\n<br/>";
    echo "TOP: 0000\n<br/>";
    for($i = 0; $i < 36; $i++) {
    $x = base_convert($i, 10, 36);
    $x = "000" . $x;
    if(!in_array($x, $used_short_codes))
    echo "MEDIUM: " . $x . "\n<br/>";
    }
    for($i = 36; $i < 1296; $i++) {
    $x = base_convert($i, 10, 36);
    $x = "00" . $x;
    if(!in_array($x, $used_short_codes))
    {
    if($x[2] == $x[3])
    echo "MEDIUM: ";
    else
    echo "LOW: ";
    
    echo $x . "\n<br/>";
    }
    }
    for($i = 1296; $i < 46656; $i++) {
    $x = base_convert($i, 10, 36);
    $x = "0" . $x;
    if($x[0] == chr(ord($x[1]) - 1) && $x[1] == chr(ord($x[2]) - 1) && $x[2] == chr(ord($x[3]) - 1))
    {
    echo "TOP: ";
    echo $x . "\n<br/>";
    }
    if($x[1] == $x[2] || $x[2] == $x[3])
    if(!in_array($x, $used_short_codes))
    {
    if($x[1] == $x[2] && $x[2] == $x[3]) // last 3
    echo "MEDIUM: ";
    else if($x[0] == $x[3] && $x[1] == $x[2]) // first & last, middle 2
    echo "MEDIUM: ";
    else if($x[0] == $x[2] && $x[1] == $x[3]) // first & third, second & fourth
    echo "MEDIUM: ";
    else
    echo "LOW: ";
    
    echo $x . "\n<br/>";
    }
    }
    for($i = 46656; $i < 1679616; $i++) {
    $x = base_convert($i, 10, 36);
    if($x[0] == chr(ord($x[1]) - 1) && $x[1] == chr(ord($x[2]) - 1) && $x[2] == chr(ord($x[3]) - 1))
    {
    echo "TOP: ";
    echo $x . "\n<br/>";
    }
    if($x[0] == $x[1] || $x[1] == $x[2] || $x[2] == $x[3] || ($x[0] == $x[2] && $x[1] == $x[3]))
    if(!in_array($x, $used_short_codes))
    {
    if($x[0] == $x[1] && $x[1] == $x[2] && $x[2] == $x[3]) // all the same
    echo "TOP: ";
    else if($x[0] == $x[1] && $x[1] == $x[2]) // first 3
    echo "MEDIUM: ";
    else if($x[1] == $x[2] && $x[2] == $x[3]) // last 3
    echo "MEDIUM: ";
    else if($x[0] == $x[1] && $x[2] == $x[3]) // first 2, last 2
    echo "MEDIUM: ";
    else if($x[0] == $x[3] && $x[1] == $x[2]) // first & last, middle 2
    echo "MEDIUM: ";
    else if($x[0] == $x[2] && $x[1] == $x[3]) // first & third, second & fourth
    echo "MEDIUM: ";
    else
    echo "LOW: ";
    
    echo $x . "\n<br/>";
    }
    }
    }
    */
    function google_connect_get()
    {
        $this->load->spark("auth/2.0");
        
        $this->load->library('HybridAuthLib');
        //echo "ues";
        
        $provider = 'Google';
        if ($this->hybridauthlib->serviceEnabled($provider))
            $service = $this->hybridauthlib->authenticate($provider);
        if ($service->isUserConnected()) {
            if (isset($_GET['close']))
                echo "<script> window.close(); </script>";
        }
        
    }
    function google_friends_get()
    {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("user_model", "userModel");
        $this->load->model("user_friend_model");
        $this->load->spark("auth/2.0");
        $this->view = false;
        $provider   = 'Google';
        
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->response(array());
        }
        
        try {
            $this->load->library('HybridAuthLib');
            if ($this->hybridauthlib->serviceEnabled($provider)) {
                $service = $this->hybridauthlib->authenticate($provider);
                if ($service->isUserConnected()) {
                    $user_contacts = $service->getUserContacts();
                    $notadded      = array();
                    $counter       = 0;
                    foreach ($user_contacts as $user) {
                        $tempuser = $this->userModel->getUserByEmail($user->email);
                        if ($tempuser->id) {
                            $check = $this->friendsModel->get_by(array(
                                "user1_id" => $this->user->id,
                                "user2_id" => $tempuser->id
                            ));
                            if (!$check) {
                                $this->friendsModel->insert(array(
                                    "user1_id" => $this->user->id,
                                    "user2_id" => $tempuser->id,
                                    "source" => 'google'
                                ));
                                $counter += 1;
                            }
                        } else {
                            $already_friend = $this->user_friend_model->checkByEmail($user->email, $this->user->id, $provider);
                            if (!$already_friend->id) {
                                $this->user_friend_model->insert(array(
                                    "user_id" => $this->user->id,
                                    "provider" => $provider,
                                    "email" => $user->email
                                ));
                                $notadded[] = $user->email;
                            }
                        }
                    }
                    $arrays_counters = array();
                    array_unshift($arrays_counters, $counter, count($notadded));
                    $this->response($arrays_counters);
                    redirect("index/close");
                } else {
                    // $failure = "This account is not linked to google+ account";
                    $this->response(array());
                }
            } else {
                $this->response(array());
            }
        }
        catch (Exception $e) {
            $this->response(array());
        }
    }
    function google_invite_get()
    {
        //return $this->response(array("hhh@hhh.hhh", "xxx@xxx.xxx", "ccc@ccc.ccc", "ddd@ddd.ddd", "abc@abc.abc"));
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("user_model", "userModel");
        $this->load->spark("auth/2.0");
        $provider = 'Google';
        
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->response(array());
        }
        
        try {
            $this->load->spark("auth/2.0");
            $this->load->library('HybridAuthLib');
            if ($this->hybridauthlib->serviceEnabled($provider)) {
                $service = $this->hybridauthlib->authenticate($provider);
                if ($service->isUserConnected()) {
                    $user_contacts = $service->getUserContacts();
                    $notadded      = array();
                    foreach ($user_contacts as $user) {
                        $tempuser = $this->userModel->getUserByEmail($user->email);
                        if (!$tempuser->id)
                            $notadded[] = $user->email;
                    }
                    //$arrays_counters = array();
                    //array_unshift($arrays_counters , count($notadded)) ;
                    $this->response($notadded);
                }
            }
        }
        catch (Exception $e) {
            $this->response(array());
        }
    }
    function google_invite_post()
    {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("user_model", "userModel");
        $this->load->spark("auth/2.0");
        $provider = 'Google';
        
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->response(array());
        }
        
        try {
            $this->load->spark("auth/2.0");
            $this->load->library('HybridAuthLib');
            if ($this->hybridauthlib->serviceEnabled($provider)) {
                $service = $this->hybridauthlib->authenticate($provider);
                if ($service->isUserConnected()) {
                    $user_contacts = $service->getUserContacts();
                    $notadded      = array();
                    foreach ($user_contacts as $user) {
                        $tempuser = $this->userModel->getUserByEmail($user->email);
                        if (!$tempuser->id)
                            $notadded[] = $user->email;
                    }
                    $arrays_counters = array();
                    array_unshift($arrays_counters, count($notadded));
                    $this->response($arrays_counters);
                }
            }
        }
        catch (Exception $e) {
            $this->response(array());
        }
    }
    
    function do_google_invite_post()
    {
        $emails = $this->post('emails');
        $this->do_invite($emails);
    }
    
    function do_manual_invite_post()
    {
        $emails = split("\n", $this->post('emailsToInvite'));
        $this->do_invite($emails);
    }
    
    function do_invite($emails)
    {
        $this->load->spark("auth/2.0");
        $this->load->model("invitation_model");
        $this->load->model("user_model");
        $this->load->helper("public");
        $count = 0;
        
        if ($this->ion_auth->logged_in()) {
            $user_id       = $this->ion_auth->user()->row()->id;
            $inviting_user = $this->user_model->getUser($user_id);
            $mail_data     = array(
                "username" => $inviting_user->username,
                "photo" => $inviting_user->photo
            );
            
            foreach ($emails as $email) {
                if (!$this->invitation_model->get_by(array(
                    "user_id" => $user_id,
                    "email" => $email
                ))) {
                    $this->invitation_model->insert(array(
                        "user_id" => $user_id,
                        "email" => $email
                    ));
                    $count++;
                    
                    // send email
                    $user        = new stdClass();
                    $user->email = $email;
                    send_email("invite", $user, $mail_data);
                }
            }
            // check if this updates the user profile type
            if ($count > 0) {
                $this->load->helper("public");
                $this->load->model("profile_type_model", "profileTypeModel");
                $this->load->model("user_model", "userModel");
                $user         = $this->userModel->getUser($this->ion_auth->user()->row()->id);
                $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
                check_profile_action("invite", $user_id, $profile_type);
            }
        }
        $this->response($count);
    }
    
    function facebook_friends_get()
    {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("user_model", "userModel");
        $this->load->spark("auth/2.0");
        
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->response(array());
        }
        
        $data = array();
        
        $user_id = $this->user->id;
        $this->load->library("facebook", array(
            'appId' => $this->fbid,
            'secret' => $this->secret
        ));
        // request user profile from fb api
        $result = array();
        try {
            $this->load->model("authentications_model", "authenticationsModel");
            $this->db->where(array(
                "user_id" => $user_id
            ));
            $user = $this->authenticationsModel->get_by();
            if ($user) {
                $data = $this->facebook->api('/' . $user->provider_uid . "/friends");
                foreach ($data["data"] as $user) {
                    $user = $this->db->select("user_id as id, firstName as first_name, lastName as last_name, photoURL as photo")->where(array(
                        "provider_uid" => $user["id"]
                    ))->get("authentications")->row();
                    if ($user) {
                        $result[] = $user;
                        $check    = $this->friendsModel->get_by(array(
                            "user1_id" => $user_id,
                            "user2_id" => $user->id
                        ));
                        if (!$check) {
                            $this->friendsModel->insert(array(
                                "user1_id" => $user_id,
                                "user2_id" => $user->id,
                                "source" => 'Facebook'
                            ));
                        }
                    }
                }
                usort($result, function($a, $b)
                {
                    return strcmp(strtolower($a->first_name . $a->last_name), strtolower($b->first_name . $b->last_name));
                });
            } else {
                $result = array(
                    "message" => "Invalid user"
                );
            }
        }
        catch (FacebookApiException $e) {
            $result = array(
                "message" => "An Error occurred while retrieving your friend list !"
            );
        }
        if (empty($result))
            $result = array(
                "message" => "None of your friends has LocName installed!"
            );
        $this->response($result);
    }
    
    function getCityByCountry_get($city = false)
    {
        $this->load->model("city_model", "cityModel");
        $this->response($this->cityModel->order_by("city", "ASC")->get_many_by(array(
            "country" => $city,
            "city != " => "NULL"
        )));
    }
    
    function getCategoryByType_get($type = FALSE)
    {
        if ($type == FALSE) {
            $this->response(array());
        }
        $this->load->model("category_model", "categoryModel");
        $this->response($this->categoryModel->get_many_by(array(
            "type" => $type,
            "active" => 1
        )));
    }
    
    function checkauth_post()
    {
        $this->load->library('form_validation');
        $this->load->spark("auth/2.0");
        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true) {
            $result = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), TRUE);
            if ($result) {
                $this->response("true");
            } else {
                $this->response("Incorrect Login");
            }
        } else {
            $result = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        }
        $this->response($result);
    }
    
    function checkName_post()
    {
        $this->load->model("location_model", "locationModel");
        $title = $this->post("title");
        if ($title != "") {
            if (strlen($title) < 6) {
                return $this->response("Too Short");
            } else if (strlen($title) > 30) {
                return $this->response("Too Long");
            }
            
            $exists = $this->locationModel->count_by("title", $title);
            if ($exists == 0) {
                if ($this->locationModel->valid_locname($this->post("title"))) {
                    return $this->response("available");
                }
                return $this->response("Invalid LocName");
            }
            return $this->response("Already Exists");
        }
        return $this->response("Not Available");
    }
    
    function checkEmailValidation_post()
    {
        $this->load->model("user_model", "userModel");
        $is_available = $this->userModel->count_by("email", $this->post("email"));
        if ($is_available == 0) {
            return $this->response("true");
        }
        $this->response("Not available");
    }
    
    function autocompleteLocations_get($title = "")
    {
        $this->load->model('location_model');
        $locations = $this->location_model->autocomplete($this->input->get("term"));
        $data      = array();
        foreach ($locations as $row) {
            $data['message'][] = array(
                'label' => $row->title,
                'value' => $row->title
            ); //Add a row to array
        }
        return $this->response($locations);
    }
    function autocompleteForEngine_get($title = "")
    {
        $this->load->model('location_model');
        $locations = $this->location_model->autocompleteForEngine($title);
        $data      = array();
        $res       = array();
        foreach ($locations as $row) {
            $res[] = array(
                'description' => $row->description,
                'formatted_address' => $row->formatted_address,
                'geometry' => array(
                    'location' => $row->latitude . ',' . $row->longitude
                ),
                'address_components' => array(
                    'floor_number' => $row->floor_number,
                    'postal_code ' => $row->postal_code,
                    'street_number' => $row->street_number,
                    'district' => $row->district,
                    'city' => $row->city,
                    'governorate' => $row->governorate,
                    'country' => $row->country,
                    'street_address' => $row->street_address,
                    'building_number' => $row->building_number
                ),
                'source' => 'LocName',
                'cacheId' => 'LocName',
                'editted' => true,
                'is_private' => $row->is_private,
                'passcode' => $row->passcode
            );
        }
        return $this->response($res);
    }
    
    function autocompleteLocationsWeb_get($title = "")
    {
        $this->load->model('location_model');
        $locations = $this->location_model->autocomplete($title);
        $data      = array();
        foreach ($locations as $row) {
            $data['message'][] = array(
                'label' => $row->title,
                'value' => $row->title
            ); //Add a row to array
        }
        return $this->response($locations);
    }
    
    function autocompleteLocationsNearWeb_get($title = "")
    {
        //$this->load->spark("auth/2.0");
        $this->load->model('country_model');
        $this->load->model('location_model');
        //if ($this->ion_auth->logged_in()) {
        // $this->user = $this->ion_auth->user()->row();
        //$countryName = $this->country_model->get_country_name_by_symbol($this->user->country);
        $countryName = $this->country_model->get_country_name_by_symbol($this->input->server("HTTP_CF_IPCOUNTRY"));
        foreach ($countryName as $row) {
            $locations = $this->location_model->autocompleteWeb($title, $row->country_name);
        }
        return $this->response($locations);
        // }
    }
    
    function report_post()
    {
        $this->load->model("report_model", "reportModel");
        $this->reportModel->insert(array(
            "name" => $this->post("name"),
            "message" => $this->post("message"),
            "about" => $this->post("about"),
            "email" => $this->post("email")
        ));
        return $this->response($this->post());
    }
    
    function partner_post()
    {
        $this->load->model("location_model", "locationModel");
        $this->load->model("partner_model", "partnerModel");
        $this->load->model("user_model", "userModel");
        $this->load->helper("public");
        
        /** check provided:
         * app_key
         * action
         * title
         * address, country, city
         * latitude
         * longitude
         * email
         * first_name
         * last_name
         */
        $result = array(
            "status" => "success",
            "message" => "LocName registered Successfully"
        );
        if (!isset($_POST['app_key']) || $this->post("app_key") == "") {
            $result["status"]  = "fail";
            $result["message"] = "Unauthorized request. Please provide a valid App key.";
        } else if (!isset($_POST['action']) || $this->post("action") == "") {
            $result["status"]  = "fail";
            $result["message"] = "Action should be provided (new or existing).";
        } else if (!isset($_POST['title']) || $this->post("title") == "") {
            $result["status"]  = "fail";
            $result["message"] = "Title should be provided.";
        } else if (($this->post("action") == "new") && (!isset($_POST['address']) || $this->post("address") == "")) {
            $result["status"]  = "fail";
            $result["message"] = "Address should be provided.";
        } else if (($this->post("action") == "new") && (!isset($_POST['latitude']) || !isset($_POST['longitude']) || $this->post("latitude") == "" || $this->post("longitude") == "")) {
            $result["status"]  = "fail";
            $result["message"] = "Both latitude and longitude should be provided.";
        } else if (($this->post("action") == "new") && (!isset($_POST['email']) || $this->post("email") == "")) {
            $result["status"]  = "fail";
            $result["message"] = "Email should be provided.";
        } else if (($this->post("action") == "new") && (!isset($_POST['first_name']) || !isset($_POST['last_name']) || $this->post("first_name") == "" || $this->post("last_name") == "")) {
            $result["status"]  = "fail";
            $result["message"] = "Both first_name and last_name should be provided.";
        } else {
            // all required data are provided, validate them
            // TODO: validate input data
            
            // check app_key existance
            $partner = $this->partnerModel->findBy("app_key", $this->post("app_key"));
            
            if ($partner) {
                if ($this->post("action") == "existing") {
                    $location = $this->locationModel->get_location_api($this->post("title"));
                    if ($location) {
                        $result["message"]  = "LocName found.";
                        $result["location"] = $location;
                    } else {
                        $result["status"]  = "fail";
                        $result["message"] = "LocName doesn't exist.";
                    }
                } else {
                    // check locname validity and non-premium shortcode
                    $valid = $this->locationModel->valid_locname($this->post("title"));
                    if ($valid) {
                        // check LocName non-existance
                        $already_exists = $this->locationModel->count_by("title", $this->post("title"));
                        if ($already_exists) {
                            $result["status"]  = "fail";
                            $result["message"] = "LocName already exists. Please select another LocName.";
                        } else {
                            // prepare array to hold location data to be inserted in database
                            $location = array(
                                'title' => $this->post("title"),
                                'latitude' => $this->post("latitude"),
                                'longitude' => $this->post("longitude"),
                                'address' => $this->post("address"),
                                'country' => $this->post("country"),
                                'city' => $this->post("city"),
                                'building_number' => $this->post("building_number"),
                                'flat_number' => $this->post("flat_number"),
                                'is_private' => 0,
                                'is_event' => 0,
                                'short_code' => $short_code,
                                'registered_from' => "P"
                            );
                            
                            // check user existance (or create one)
                            $user = $this->userModel->getUserByEmail($this->post("email"));
                            if ($user) {
                                // add the user_id to the location info
                                $location["user_id"] = $user->id;
                            } else {
                                $this->load->spark("auth/2.0");
                                $this->load->library('HybridAuthLib');
                                $this->load->library('form_validation');
                                
                                // register the user and get their id
                                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
                                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|alpha');
                                $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
                                
                                if ($this->form_validation->run() == true) {
                                    $username = $this->input->post('first_name') . " " . $this->input->post('last_name');
                                    $email    = $this->input->post('email');
                                    
                                    // create random temp password for the new user
                                    $password = gen_location_code($this->config->item('min_password_length', 'ion_auth'));
                                    
                                    $additional_data = array(
                                        'first_name' => $this->input->post('first_name'),
                                        'last_name' => $this->input->post('last_name'),
                                        'registered_from' => 'P'
                                    );
                                    
                                    $user_id = $this->ion_auth->register($username, $password, $email, $additional_data);
                                    if ($user_id !== false) {
                                        // get the newly created user_id & add it to the location info
                                        $location["user_id"] = $user_id;
                                        
                                        // TODO: send email to this new user containing the temp password
                                        // send success email (welcome)
                                        $this->load->library('email');
                                        $mailData = array(
                                            "fullName" => $username,
                                            "password" => $password
                                        );
                                        $message  = $this->load->view("auth/email/welcome_api.tpl.php", $mailData, true);
                                        $this->email->clear();
                                        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                                        $this->email->to($email);
                                        $this->email->subject("Welcome to LocName");
                                        $this->email->message($message);
                                        
                                        //$this->email->send();
                                    } else {
                                        $result["status"]  = "fail";
                                        $result["message"] = "Invalid User Data. Please provide valid first_name, last_name, and email";
                                    }
                                } else {
                                    $result["status"]  = "fail";
                                    $result["message"] = "Invalid User Data. Please provide valid first_name, last_name, and email";
                                }
                            }
                            
                            // generate short code for the new location
                            do {
                                $short_code = gen_location_code(4);
                                while (!preg_match("/[0-9]+/", $short_code) || !preg_match("/[a-z]+/", $short_code) || ($short_code[0] == chr(ord($short_code[1]) - 1) && $short_code[1] == chr(ord($short_code[2]) - 1) && $short_code[2] == chr(ord($short_code[3]) - 1)) || ($short_code[0] == $short_code[1] || $short_code[1] == $short_code[2] || $short_code[2] == $short_code[3] || ($short_code[0] == $short_code[2] && $short_code[1] == $short_code[3])))
                                    $short_code = gen_location_code(4);
                                
                                $where     = "short_code` = '$short_code' OR `title` = '$short_code'";
                                $codecount = $this->locationModel->count_by($where);
                            } while ($codecount);
                            $location["short_code"] = $short_code;
                            
                            // register locname and return success message
                            if (!isset($_POST["demo"])) {
                                $newLocation = $this->locationModel->insert($location, TRUE);
                                if ($newLocation) {
                                    $result["message"]  = "LocName found.";
                                    $result["location"] = $location;
                                } else {
                                    $result["status"]  = "fail";
                                    $result["message"] = "An error occurred while creating your LocName.";
                                }
                            }
                        }
                    } else {
                        $result["status"]  = "fail";
                        $result["message"] = "Invalid LocName. Please provide a valid LocName.";
                    }
                }
            } else {
                $result["status"]  = "fail";
                $result["message"] = "Unauthorized request. Please provide a valid App key.";
            }
        }
        return $this->response($result);
    }
    
    function checkLocationName_get()
    {
        if (!$this->post("title"))
            $this->load->model("location_model", "locationModel");
        $is_available = $this->locationModel->count_by("title", $this->get("title"));
        
        if ($is_available == 0) {
            $this->response(TRUE);
        }
        return $this->response("This name seems to be invalid.");
    }
    
    function getLocation_get()
    {
        $url    = 'https://www.google.com/maps/place/Flat6Labs/@30.021929,31.21705,17z/data=!3m1!4b1!4m2!3m1!1s0x14584720a6315061:0xcdf1116b4579dd1f';
        $result = explode("@", $url);
        $result = explode(",", $result[1]);
        
        die(var_dump($result));
    }
    
    function remove_temp_places_get()
    {
        $this->db->where("temporary` = 1 AND DATEDIFF(NOW(), created_at) > 1");
        $this->db->delete('location');
    }
    
    function remove_registered_friends_get()
    {
        $this->db->query("DELETE FROM `users_friends` WHERE (email IN (SELECT email FROM `users`)) OR (provider_uid IN (SELECT provider_uid FROM `authentications`))");
    }
    
    function send_retention_email($user, $template, $subject, $mailData)
    {
        $message = $this->load->view("admin/email/" . $template . ".tpl.php", $mailData, true);
        $this->email->clear();
        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
        $this->email->to($user->email);
        $this->email->subject("LocName - " . $subject);
        $this->email->message($message);
        $this->email->send();
    }
    
    function run_retention_module($no_location_days, $no_visits_days, $loc_inactive_days, $app_inactive_days)
    {
        // users who created no locations
        echo "<br>no location<br>";
        $users = $this->db->select("id, first_name, last_name, email, TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(created_on)) AS num_days")->where("users`.id <> 0 AND NOT EXISTS (SELECT * FROM `location` WHERE `location`.user_id = `users`.id) AND TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(created_on)) = " . $no_location_days)->get("users")->result();
        
        foreach ($users as $user) {
            //** send email **//
            $mailData = array(
                "username" => $user->first_name . " " . $user->last_name
            );
            send_email("no_location_created", $user, $mailData);
            
            //** send push notification **//
            // prepare the message to be sent
            $msg       = "You still haven't registered a location! Save one now!";
            // prepare the additional data to be sent
            $more_data = array(
                "page_type" => "add_location"
            );
            // prepare the channel to send on
            $ch        = $user->id;
            echo $ch . " ";
            // send them push notifcations
            appcelerator_push($msg, $ch, $more_data);
        }
        
        // users who have locations that have no visits
        echo "<br>no visits<br>";
        $users = $this->db->select("id, first_name, last_name, email")->where("users`.id IN (SELECT DISTINCT `location`.user_id FROM `location` WHERE `location`.id NOT IN (SELECT `location_id` FROM `location_visits WHERE temporary <> 1`) AND TO_DAYS(NOW()) - TO_DAYS(created_at) = " . $no_visits_days . ")")->get("users")->result();
        
        foreach ($users as $user) {
            // select those locations, if one location send push notification with page_type = place
            $locations = $this->db->select("id, title")->where("user_id` =" . $user->id . " AND id NOT IN (SELECT `location_id` FROM `location_visits`) AND TO_DAYS(NOW()) - TO_DAYS(created_at) = " . $no_visits_days)->get("location")->result();
            
            //** send email **//
            $mailData = array(
                "username" => $user->first_name . " " . $user->last_name,
                "locations" => $locations
            );
            //send_email("no_location_visit", $user, $mailData);
            $this->send_retention_email($user, "ret_no_visit", "No one has visited your location! Share it with your friends!", $mailData);
            
            //** send push notification **//
            // prepare the message to be sent
            $msg = "No one has visited your location! Share it with your friends!";
            // prepare the additional data to be sent
            if (sizeof($locations) == 1) {
                $more_data = array(
                    "page_type" => "place",
                    "user_id" => $user->id,
                    "location_id" => $locations[0]->id
                );
            } else {
                $more_data = array(
                    "page_type" => "user_locations",
                    "user_id" => $user->id
                );
            }
            // prepare the channel to send on
            $ch = $user->id;
            echo $ch . " ";
            // send them push notifcations
            appcelerator_push($msg, $ch, $more_data);
        }
        
        // users who have locations that became inactive
        echo "<br>location inactive<br>";
        $users = $this->db->select("id, first_name, last_name, email")->where("users`.id IN (SELECT DISTINCT `location`.user_id FROM `location` WHERE EXISTS (SELECT `location_visits`.location_id, MAX(`location_visits`.created_at) FROM `location_visits` WHERE `location_visits`.location_id = `location`.id GROUP BY `location_visits`.location_id HAVING TO_DAYS(NOW())-TO_DAYS(MAX(`location_visits`.created_at)) = " . $loc_inactive_days . "))")->get("users")->result();
        
        foreach ($users as $user) {
            // select those locations, if one location send push notification with page_type = place
            $locations = $this->db->select("id, title")->where("user_id` =" . $user->id . " AND EXISTS (SELECT `location_visits`.location_id, MAX(created_at) FROM `location_visits` WHERE `location_visits`.location_id = `location`.id GROUP BY `location_visits`.location_id HAVING TO_DAYS(NOW())-TO_DAYS(MAX(`location_visits`.created_at)) = " . $loc_inactive_days . ")")->get("location")->result();
            
            //** send email **//
            $mailData = array(
                "username" => $user->first_name . " " . $user->last_name,
                "locations" => $locations
            );
            $this->send_retention_email($user, "ret_location_inactive", "Your location has not been used for a while. Reactivate it by sharing it!", $mailData);
            
            //** send push notification **//
            // prepare the message to be sent
            $msg = "Your location has not been used for a while. Reactivate it by sharing it!";
            // prepare the additional data to be sent
            if (sizeof($locations) == 1) {
                $more_data = array(
                    "page_type" => "place",
                    "user_id" => $user->id,
                    "location_id" => $locations[0]->id
                );
            } else {
                $more_data = array(
                    "page_type" => "user_locations",
                    "user_id" => $user->id
                );
            }
            // prepare the channel to send on
            $ch = $user->id;
            echo $ch . " ";
            // send them push notifcations
            appcelerator_push($msg, $ch, $more_data);
        }
        
        // users who have their app became inactive
        echo "<br>app inactive<br>";
        $users = $this->db->select("id, first_name, last_name, email")->where("users`.id <> 0 AND TO_DAYS(NOW())-TO_DAYS(FROM_UNIXTIME(GREATEST(last_login, last_open_app))) = " . $app_inactive_days)->get("users")->result();
        foreach ($users as $user) {
            //** send email **//
            $mailData = array(
                "username" => $user->first_name . " " . $user->last_name,
                "num-days" => $app_inactive_days
            );
            send_email("inactive_user", $user, $mailData);
            
            //** send push notification **//
            $msg       = "We missed you at LocName! Sign in to continue your LocName experience!";
            // prepare the additional data to be sent
            $more_data = array(
                "page_type" => "main"
            );
            // prepare the channel to send on
            $ch        = $user->id;
            echo $ch . " ";
            // send them push notifcations
            appcelerator_push($msg, $ch, $more_data);
        }
    }
    
    function configure_retention_module_get()
    {
        $this->load->helper("public"); // load appcelerator_push function nd email function
        
        $this->run_retention_module(2, 2, 30, 15); // first trial
        $this->run_retention_module(7, 7, 60, 30); // second trial
    }
    
    function city_get()
    {
        $data = "";
        if ($this->uri->segment(3)) {
            $id = $this->uri->segment(3);
            $this->load->model("city_model", "cityModel");
            $query = $this->cityModel->getcity($id);
            if ($query) {
                foreach ($query as $name) {
                    if ($name->id != '') {
                        $data .= $name->city . ":" . $name->id . ",";
                    }
                }
            }
        }
        echo $data;
    }
    
    ////////////////////////////////////////  new APIs/////////////////////////////////////////////
    
    ////////////////////////////////location API/////////////////////////////////
    function locations_get($user_id = 0, $count = 9, $offset = 0, $order = " title ")
    {
        $this->load->model("location_model", "locationModel");
        $query  = "select location.* from location where location.user_id=$user_id order by $order DESC ";
        $result = $this->locationModel->pagination_by_query($query, $offset, $count);
        for ($i = 0; $i < count($result["data"]); $i++) {
            $result["data"][$i] = $this->locationModel->afterGet($result["data"][$i]);
            
        }
        return $this->response($result);
    }
    ////////////////////////////////friends API/////////////////////////////////////////////////
    
    function friends_get($user_id = 0, $count = 9, $offset = 0)
    {
        $this->load->model("friends_model", "friendsModel");
        $query = "select users.id,users.first_name,users.last_name,users.photo,
            (select count(location.id) as locations from  location where location.user_id = users.id) as locations,
            (select count(favourite.id) as favourite from  favourite where favourite.user_id = users.id) as favorites
             from friends left join users on (friends.user2_id = users.id or friends.user1_id=users.id) and users.id != $user_id where friends.user1_id = $user_id or friends.user2_id = $user_id";
        
        $result = $this->friendsModel->pagination_by_query($query, $offset, $count);
        return $this->response($result);
        
    }
    ///////////////////////////////favorite//////////////////////////////////////////////
    function favorite_get($user_id = 0, $count = 9, $offset = 0)
    {
        $this->load->model("favourite_model", "favModel");
        $this->load->model("location_model", "locationModel");
        $query = "select favourite.id as favoriteId,favourite.user_id as favoriteUser,location.* from favourite left join location on favourite.location_id=location.id where favourite.user_id=$user_id";
        
        $result = $this->favModel->pagination_by_query($query, $offset, $count);
        for ($i = 0; $i < count($result["data"]); $i++) {
            $result["data"][$i] = $this->locationModel->afterGet($result["data"][$i]);
            
        }
        return $this->response($result);
        
    }
    
    function add_favorite_post()
    {
        $this->load->model("favourite_model", "favModel");
        $this->load->model("location_model", "locationModel");
        $location = $this->locationModel->get_by("title", $this->input->post("title"));
        if ($this->session->userdata["user_id"]) {
            if ($this->favModel->verify_favourite($this->session->userdata["user_id"], $location->id)) {
                $this->favModel->delete_favorite($this->session->userdata["user_id"], $location->id);
                echo "unfav";
            } else {
                $this->favModel->insert(array(
                    "location_id" => $location->id,
                    "user_id" => $this->session->userdata["user_id"]
                ));
                echo "fav";
            }
        } else {
            echo "not logged in";
        }
    }
    
    function check_profile_feature_post()
    {
        $feature = $this->input->post("feature");
        $user_id = $this->session->userdata["user_id"];
        $this->load->model("profile_type_model", "profileTypeModel");
        $this->load->model("user_model", "userModel");
        $user         = $this->userModel->getUser($user_id);
        $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
        $this->load->helper("public");
        $check = check_profile_feature($feature, $user_id, $profile_type);
        if ($check) {
            // can use feature
            $this->response("true");
        } else {
            // can't use feature
            $this->response("false");
        }
    }
    
    function check_profile_action_post()
    {
        $action  = $this->input->post("action");
        $user_id = $this->session->userdata["user_id"];
        $this->load->model("profile_type_model", "profileTypeModel");
        $this->load->model("user_model", "userModel");
        $user         = $this->userModel->getUser($user_id);
        $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
        $this->load->helper("public");
        $check = check_profile_action($action, $user_id, $profile_type);
        if ($check) {
            // promote
            $this->response("true");
        } else {
            // don't promote
            $this->response("false");
        }
    }
    
    function get_promote_actions_post()
    {
        $feature = $this->input->post("feature");
        $user_id = $this->session->userdata["user_id"];
        $this->load->model("profile_type_model", "profileTypeModel");
        $this->load->model("user_model", "userModel");
        $user         = $this->userModel->getUser($user_id);
        $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
        $this->load->helper("public");
        return $this->response(get_promote_actions($feature, $user_id, $profile_type));
    }
    
    function sess_get()
    {
        var_dump($this->session);
    }
    function saveAsLocname_post()
    {
        $this->load->model("temp_location_model");
        $title           = $this->post('title');
        $address         = $this->post('address');
        $latitude        = $this->post('latitude');
        $longitude       = $this->post('longitude');
        $country         = $this->post('country');
        $city            = $this->post('city');
        $building_number = $this->post('building_number');
        $flat_number     = $this->post('flat_number');
        $governorate     = $this->post('governorate');
        $area_level_2    = $this->post('area_level_2');
        $area_level_3    = $this->post('area_level_3');
        $street          = $this->post('street');
        $street_number   = $this->post('street_number');
        $postal_code     = $this->post('postal_code');
        $email           = $this->post('email');
        $location        = array(
            "title" => $title,
            "address" => $address,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "country" => $country,
            "city" => $city,
            "building_number" => $building_number,
            "flat_number" => $flat_number,
            "governorate" => $governorate,
            "area_level_2" => $area_level_2,
            "area_level_3" => $area_level_3,
            "street" => $street,
            "street_number" => $street_number,
            "postal_code" => $postal_code,
            "email" => $email
        );
        $id              = $this->temp_location_model->insert($location);
        $this->load->model('temp_location_model', 'tempLocationModel');
        $location = $this->tempLocationModel->getLocation($id, $email);
        $this->response(base_url("index/main/" . $id . "?email=" . $email));
    }
    
    function num_new_notifications_get()
    {
        $this->load->model("notification_model");
        $num = $this->notification_model->num_new_notifications($this->session->userdata["user_id"]);
        $this->response($num);
    }
}

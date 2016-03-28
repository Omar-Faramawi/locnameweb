<?php

/**
 * Description of mobile API
 *
 * @author  Amr Soliman
 * @email <info@mezatech.com>
 */
require APPPATH . '/libraries/REST_Controller.php';

class mobile extends REST_Controller
{

    var $fbid = "1376235535961215";
    var $secret = "42055f0ce428faf9fb56e60f9690f7e5";
    var $user;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("public");
        $this->load->model("user_model", "userModel");
        $this->load->model("location_model", "location_model");
        error_reporting(1);
    }

    /**
     * load the user profile from the Facebook  api client
     */
    function getUserProfile()
    {
        $id = $this->post("provider_uid");
        $provider = $this->post("provider");
        if ($provider == "Google") {

            global $apiConfig;

            require_once SPARKPATH . "GoogleAPIClient/0.6.0/src/Google_Client.php";
            require_once SPARKPATH . "GoogleAPIClient/0.6.0/src/contrib/Google_PlusService.php";

            session_start();

            $client = new Google_Client();
            $client->setApplicationName("Locname");
            $client->setClientId('758109528207-rkassf02mls9584c00c7nnm692a0g2bd.apps.googleusercontent.com');
            $client->setClientSecret('HmbGkReueODuZpUXZ_Lp7nyO');
            $client->setDeveloperKey('AIzaSyBlbLUET8CfSWYshLxjVokjmKxK9BQ3rAg');
            $client->setScopes('https://www.googleapis.com/auth/userinfo.profile   https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.google.com/m8/feeds');

            $client->setRedirectUri(site_url() . 'auth/provider_endpoint?hauth.done=Google');

            $plus = new Google_PlusService($client);
            try {
                $data = $plus->people->get($id);
            } catch (Google_ServiceException $e) {
                throw new Exception("User profile request failed! {$this->providerId} returned an error: $e", 6);
            }
            if (!isset($data["id"])) {
                throw new Exception("User profile request failed! {$this->providerId} api returned an invalid response.", 6);
            }
            $user->identifier = (array_key_exists('id', $data)) ? $data['id'] : "";
            $user->displayName = (array_key_exists('displayName', $data)) ? $data['displayName'] : "";
            $user->firstName = (array_key_exists('name', $data)) ? $data['name']['givenName'] : "";
            $user->lastName = (array_key_exists('name', $data)) ? $data['name']['familyName'] : "";
            $user->profileURL = (array_key_exists('image', $data)) ? $data['image']['url'] : "";
            // $user->webSiteURL = (array_key_exists('website', $data)) ? $data['website'] : "";
            $user->gender = (array_key_exists('gender', $data)) ? $data['gender'] : "";
            $user->description = (array_key_exists('aboutMe', $data)) ? $data['aboutMe'] : "";
            $user->email = (array_key_exists('email', $data)) ? $data['email'] : "";
            $user->emailVerified = (array_key_exists('email', $data)) ? $data['email'] : "";
            $user->region = (array_key_exists('placesLived', $data)) ? $data['placesLived'][0]['value'] : "";

            return $user;
        } else if ($provider == "Facebook") {
            $this->load->library("facebook", array(
                'appId' => $this->fbid,
                'secret' => $this->secret));
            // request user profile from fb api
            try {
                if ($id !== FALSE) {
                    $data = $this->facebook->api('/' . $id);
                } else {
                    $data = $this->facebook->api('/me');
                }
            } catch (FacebookApiException $e) {
                throw new Exception("User profile request failed! {$this->providerId} returned an error: $e", 6);
            }

            // if the provider identifier is not recived, we assume the auth has failed
            if (!isset($data["id"])) {
                throw new Exception("User profile request failed! {$this->providerId} api returned an invalid response.", 6);
            }

            # store the user profile.
            $user->identifier = (array_key_exists('id', $data)) ? $data['id'] : "";
            $user->displayName = (array_key_exists('name', $data)) ? $data['name'] : "";
            $user->firstName = (array_key_exists('first_name', $data)) ? $data['first_name'] : "";
            $user->lastName = (array_key_exists('last_name', $data)) ? $data['last_name'] : "";
            $user->photoURL = "https://graph.facebook.com/" . $user->identifier . "/picture?type=large";
            $user->profileURL = (array_key_exists('link', $data)) ? $data['link'] : "";
            $user->webSiteURL = (array_key_exists('website', $data)) ? $data['website'] : "";
            $user->gender = (array_key_exists('gender', $data)) ? $data['gender'] : "";
            $user->description = (array_key_exists('bio', $data)) ? $data['bio'] : "";
            $user->email = (array_key_exists('email', $data)) ? $data['email'] : "";
            $user->emailVerified = (array_key_exists('email', $data)) ? $data['email'] : "";
            $user->region = (array_key_exists("hometown", $data) && array_key_exists("name", $data['hometown'])) ? $data['hometown']["name"] : "";

            if (array_key_exists('birthday', $data)) {
                list($birthday_month, $birthday_day, $birthday_year) = explode("/", $data['birthday']);

                $user->birthDay = (int)$birthday_day;
                $user->birthMonth = (int)$birthday_month;
                $user->birthYear = (int)$birthday_year;
            }
        }

        return $user;
    }

    /**
     *
     */
    function user_get()
    {
        if (!$this->get('id')) {
            $this->response(NULL, 400);
        }
        $user = $this->userModel->get($this->get('id'));

        if ($user) {
            $this->response($user, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

    /**
     *
     * @return string error if user registration or login failed
     * @return string josn with current userdata  login or register success
     * @param string $provider provider name { Facebook , Google  , Linkedin , "Locname_register"  , "locname_login"}
     */
    function user_post()
    {
        $this->load->spark("auth/2.0");
        if ($this->post("provider") != false) {
            $this->load->library('HybridAuthLib');
            // Handle Registration and login with Social Login
            $provider = ucfirst($this->post("provider"));
            if (in_array($provider, array("Facebook", "Google"))) {

                // grab the user profile
                $user_profile = $this->getUserProfile($this->post("provider_uid"));
                $provider_uid = $user_profile->identifier;

                if ($this->ion_auth->login_by_provider($provider, $provider_uid)) {
                    $data['user_profile'] = $this->ion_auth->user_by_provider();
                    return $this->response($data['user_profile']);
                } else { // if authentication does not exist and email is not in use, then we create a new user
                    $username = $user_profile->firstName . ' ' . $user_profile->lastName;
                    $password = rand(8, 15);
                    //$email = ((strlen($user_profile->email) > 3) ? $user_profile->email : $this->post("user_email"));
                    if ($user_profile->email != "") {
                        $email = $user_profile->email;
                    } else {
                        $email = $this->post("user_email");
                    }
                    $additional_data['profileURL'] = $user_profile->profileURL;
                    $additional_data['webSiteURL'] = $user_profile->webSiteURL;
                    $additional_data['photoURL'] = $user_profile->photoURL;
                    $additional_data['displayName'] = $user_profile->displayName;
                    $additional_data['description'] = $user_profile->description;
                    $additional_data['firstName'] = $user_profile->firstName;
                    $additional_data['lastName'] = $user_profile->lastName;
                    $additional_data['gender'] = $user_profile->gender;
                    $additional_data['language'] = $user_profile->language;
                    $additional_data['age'] = $user_profile->age;
                    $additional_data['birthDay'] = $user_profile->birthDay;
                    $additional_data['birthMonth'] = $user_profile->birthMonth;
                    $additional_data['birthYear'] = $user_profile->birthYear;
                    $additional_data['email'] = $email;
                    $additional_data['emailVerified'] = $user_profile->emailVerified;
                    $additional_data['phone'] = $user_profile->phone;
                    $additional_data['address'] = $user_profile->address;
                    $additional_data['region'] = $user_profile->region;
                    $additional_data['zip'] = $user_profile->zip;
                    $additional_data['mobile_id'] = $this->post("mobile_id");
                    $additional_data['country'] = "";
                    $additional_data['city'] = "";
                    $additional_data['registered_from'] = $this->post('registered_from');

                    // split region into country and city (if possible)
                    if ($user_profile->region != "") {
                        $arr = explode(", ", $user_profile->region);
                        if (sizeof($arr) >= 2) {
                            $additional_data['country'] = array_pop($arr); // last element
                            $additional_data['city'] = array_pop($arr); // element before the last
                        }
                    }

                    // get country code from cloudflare
                    if ($additional_data['country'] == NULL || $additional_data['country'] == "0" || $additional_data['country'] == "") {
                        $additional_data['country'] = $this->input->server("HTTP_CF_IPCOUNTRY");
                    }

                    if ($email != null && $this->ion_auth->register_by_provider($provider, $provider_uid, $username, $password, $email, $additional_data)) { // create new user && create a new authentication for him
                        if ($this->ion_auth->login_by_provider($provider, $provider_uid)) { // log user in :)
                            // get user profile from authentications table.
                            $data['user_profile'] = $this->ion_auth->user_by_provider();
                            $data['user_profile']->registered_from = "facebook";
                            /** ** Send push notification for the new user's friends *** */
                            $this->load->helper("public"); // load appcelerator_push function
                            //Facebook Friends Push Notifications
                            if ($provider == "Facebook") {
                                // set the message to be pushed
                                $message = "Your friend " . $username . " has joined LocName. Click here to view their profile.";

                                $this->load->model("authentications_model", "authenticationsModel");
                                $this->db->where(array("email" => $user_profile->email));
                                $user = $this->authenticationsModel->get_by(); // get the new user full information
                                if ($user) {
                                    // prepare the additional data to be sent
                                    $more_data = array("page_type" => "profile", "user_id" => $user->user_id);

                                    // get friends of the new user
                                    try {
                                        $fb_data = $this->facebook->api('/' . $user->provider_uid . "/friends");
                                        foreach ($fb_data["data"] as $fb_user) {
                                            // get those friends whom we have in database
                                            $friend = $this->db
                                                ->select("user_id as id, firstName as first_name, lastName as last_name")
                                                ->where(array("provider_uid" => $fb_user["id"]))
                                                ->get("authentications")->row();
                                            if ($friend) { // This is a LocName user
                                                $this->load->model("friends_model");
                                                $check = $this->friends_model->is_friend($friend->id, $user->user_id);
                                                if (!$check) {
                                                    $this->friends_model->insert(array("user1_id" => $friend->id, "user2_id" => $user->user_id, "source" => 'Facebook'));
                                                }
                                                $ch = $friend->id;
                                                // send them push notifcations
                                                appcelerator_push($message, $ch, $more_data);

                                                // send them email
                                                $friend->username = $friend->first_name . " " . $friend->last_name;
                                                $mailData = array(
                                                    "username" => $friend->username,
                                                    "friend-username" => $user->first_name . " " . $user->last_name,
                                                    "friend-first-name" => $user->first_name
                                                );
                                                send_email(2, $friend, $mailData);

                                                // add new notification for them
                                                $this->load_model("notification_model");
                                                $notification = array(
                                                    "user_id" => $user->user_id,
                                                    "notification_type_id" => 1,
                                                    "friend_id" => $friend->id
                                                );
                                                $this->notification_model->insert($notification);

                                            } else { // we don't have this user
                                                $this->load->model("user_friend_model");
                                                $this->user_friend_model->insert(array("user_id" => $user->user_id, "provider" => "Facebook", "name" => $fb_user["name"], "provider_uid" => $fb_user["id"]));
                                            }
                                        }
                                    } catch (FacebookApiException $e) {
                                        $result = array("message" => "An Error occurred while retrieving your friend list");
                                    }
                                }
                            }
                            /** ** End of push notification *** */

                            return $this->response($data['user_profile']);
                        } else {
                            //if the login was un-successful
                            //redirect them back to the login page
                            $this->data['message'] = 'Cannot authenticate user wa7ed';
                            return $this->response(array("error" => $this->data["message"]));
//                                $this->view = 'auth/login';
                        }
                    } else {
                        //if the register was un-successful
                        //redirect them back to the login page
                        $this->data['message'] = "$provider, $provider_uid, $username, $password,$email";
                        return $this->response(array("error" => $this->data["message"]));
                        //  return $this->response($this->data);
                        // $this->view = 'auth/login';
                    }
                }
            } elseif ($provider == "Locname_register") {
                //$username = $this->post('username'); // username is removed from the mobile
                $username = $this->post('first_name') . " " . $this->post('last_name');
                $email = $this->post('email');
                $password = $this->post('password');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[users.email]');
                if ($this->form_validation->run() === false) {
                    $this->response(array("error" => "Invalid Email Address"));
                }
                $additional_data = array(
                    'first_name' => $this->post('first_name'),
                    'last_name' => $this->post('last_name'),
                    'phone' => $this->post('phone'),
                    'mobile_id' => $this->post('mobile_id'),
                    'registered_from' => $this->post('registered_from'),
                    'country' => ""
                );

                // get country code from cloudflare
                if ($additional_data['country'] == NULL || $additional_data['country'] == "0" || $additional_data['country'] == "") {
                    $additional_data['country'] = $this->input->server("HTTP_CF_IPCOUNTRY");
                }

                if ($this->post("has_photo")) {
                    $img = $this->upload();
                    $additional_data["photo"] = $img["upload_data"]["file_name"];
                }

                $result = $this->ion_auth->register($username, $password, $email, $additional_data);
                if ($result == false) {
                    $this->response(array("error" => strip_tags($this->ion_auth->errors())));
                } else {
                    // send success email (welcome)
                    $this->load->helper('public');
                    $this->load->model("user_model");
                    $mailData = array(
                        "username" => $this->input->post('first_name') . " " . $this->input->post('last_name')
                    );
                    send_email("welcome", $this->user_model->getUserByEmail($email), $mailData);
                }
                $this->response($this->ion_auth->user($result)->row());
            } elseif ($provider == "Locname_login") {
                if ($this->ion_auth->login($this->post('email'), $this->post('password'))) {
                    return $this->response($this->ion_auth->user($this->ion_auth->id_by_email($this->post('email')))->row());
                } else {
                    return $this->response(array("error" => strip_tags($this->ion_auth->errors())));
                }
            }
        }

        $this->response($message, 200); // 200 being the HTTP response code
    }

    function get_friend_list_post()
    {
        $this->load->model("friends_model");
        $this->load->model("user_model");
        $all_friends = $this->friends_model->get_friend_list($this->post("user_id"));
        $existing = array();
        foreach ($all_friends as $friend) {
            $user = $this->user_model->getUser($friend->id);

            $temp['id'] = $user->id;
            $temp['first_name'] = $user->first_name;
            $temp['last_name'] = $user->last_name;
            $temp['photo'] = (substr($user->photo, 0, 8) == "https://") ? $user->photo : site_url("assets/uploads") . "/users_images/" . $user->photo;
            $temp['small_photo'] = (substr($user->photo, 0, 8) == "https://") ? substr($user->photo, 0, strrpos($user->photo, "?")) . "?width=50&height=50" : site_url("assets/uploads") . "/users_images/" . $user->photo;
            $temp['email'] = $user->email;
            $temp['since'] = $friend->since;
            if ($user->photo == "0" || $user->photo == null) {
                $temp['photo'] = null;
                $temp['small_photo'] = null;
            }
            $existing[] = $temp;
        }
        return $this->response($existing);
    }

    function sync_contacts_post()
    {
        $this->load->model("friends_model");
        $this->load->model("user_model");
        $user_id = $this->post("user_id");
        $contacts = json_decode($this->post('contacts'));
        $existing = array();
        foreach ($contacts as $contact) {
            $user = $this->user_model->getUserByEmail($contact);
            print_r($user);
            if ($user) {
                $temp['id'] = $user->id;
                $temp['email'] = $contact;
                $existing[] = $temp;
                $check = $this->friends_model->is_friend($user_id, $user->id);
                if (!$check) {
                    $this->friends_model->insert(array("user1_id" => $user_id, "user2_id" => $user->id, "source" => 'contact'));
                }
            } else {
                $this->load->model("user_friend_model");
                $this->user_friend_model->insert(array("user_id" => $user_id, "provider" => "Contact", "email" => $contact));
            }
        }
        if (count($existing) != 0) {
            return $this->response(array("users" => $existing));
        } else {
            return $this->response(array("message" => "You don't have new friends who use LocName"));
        }
    }

    function addUDID_post()
    {
        $this->load->model("user_model", "userModel");
        $result = $this->userModel->addUDID($this->post("user_id"), $this->post("UDID"));
        $this->response(array("result" => $result));
    }

    /**
     * update user profile
     */
    function userUpdate_post()
    {
        $this->load->spark("auth/2.0");

        $data = array(
            "email" => $this->post('email'),
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'phone' => $this->post('phone'),
            'photo' => $this->post('photo'),
        );
        if ($this->post("password")) {
            $data["password"] = $this->post("password");
        }
        $result = ($this->ion_auth->update($this->post("user_id"), $data)) ? true : strip_tags($this->ion_auth->errors());
        return $this->response(array("code" => $result));
    }

    function checkuser_post()
    {
        $this->load->spark("auth/2.0");
        if (!$this->post("by") || !$this->post("value")) {
            $this->response("Check by What??", 400);
        }

        if ($this->post("by") == "email") {
            $result = $this->ion_auth->email_check($this->post("value"));
            return $this->response($result);
        }

        if ($this->post("by") == "username") {
            $result = $this->ion_auth->username_check($this->post("value"));
            return $this->response($result);
        }
        return $this->response("error", 400);
    }

    function forgotPassword_post()
    {
        $this->load->spark("auth/2.0");
        if ($this->input->post('email')) {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->post('email'));

            if ($forgotten) {
                $result = array("message" => "true");
            } else {
                $result = array("message" => "false");
            }
        } else {
            $result = array("message" => "false");
        }
        return $this->response($result);
    }

    function AddLocation_post()
    {
        $this->load->model("location_model");

        if ($this->post("location_id")) {
            //$this->load->library('form_validation'); //TODO PHP form validation
            if ($this->location_model->valid_locname($this->post("title"))) {
                $post = array(
                    "title" => $this->post("title"),
                    "latitude" => $this->post("latitude"),
                    "longitude" => $this->post("longitude"),
                    "is_private" => $this->post("is_private"),
                    "passcode" => $this->post("passcode"),
                    "details" => $this->post("details"),
                    "duration_from" => (strlen($this->post("duration_from")) > 1) ? date("Y-m-d H:i:s", strtotime(str_replace('at', '', $this->post("duration_from")))) : "",
                    "duration_to" => (strlen($this->post("duration_to")) > 1) ? date("Y-m-d H:i:s", strtotime(str_replace('at', '', $this->post("duration_to")))) : "",
                    "user_id" => $this->post("user_id"),
                    "type" => $this->post("type"),
                    "category_id" => $this->post("category_id"),
                    "mobile" => $this->post("mobile"),
                    "address" => $this->post("address"),
                    "website" => $this->post("website"),
                    "email" => $this->post("email"),
                    "location_id" => $this->post("location_id"),
                    "building_number" => $this->post("building_number"),
                    "flat_number" => $this->post("flat_number")
                );
                if ($this->post("photo")) {
                    $img = $this->upload();
                    $post["photo"] = $img["upload_data"]["file_name"];
                }
                // return $this->response($post);
                $result = $this->location_model->update($this->post("location_id"), $post);
                // $result = $this->db->last_query();
            } else {
                $this->response(array("message" => "false"));
            }
        } else {
            if ($this->location_model->valid_locname($this->post("title")) || $this->post("temporary") == 1) {
                // generate short code for the new location
                do {
                    $short_code = gen_location_code(4);
                    while (!preg_match("/[0-9]+/", $short_code) || !preg_match("/[a-z]+/", $short_code) || ($short_code[0] == chr(ord($short_code[1]) - 1) && $short_code[1] == chr(ord($short_code[2]) - 1) && $short_code[2] == chr(ord($short_code[3]) - 1)) || ($short_code[0] == $short_code[1] || $short_code[1] == $short_code[2] || $short_code[2] == $short_code[3] || ($short_code[0] == $short_code[2] && $short_code[1] == $short_code[3])))
                        $short_code = gen_location_code(4);

                    $where = "short_code` = '$short_code' OR `title` = '$short_code'";
                    $result = $this->location_model->count_by($where);
                } while ($result);

                $post = array(
                    "title" => ($this->post("temporary") == 1) ? $short_code : $this->post("title"),
                    "latitude" => $this->post("latitude"),
                    "longitude" => $this->post("longitude"),
                    "is_private" => $this->post("is_private"),
                    "passcode" => $this->post("passcode"),
                    "details" => $this->post("details"),
                    "duration_from" => $this->post("duration_from"),
                    "duration_to" => $this->post("duration_to"),
                    "user_id" => $this->post("user_id"),
                    "category_id" => $this->post("category_id"),
                    "type" => $this->post("type"),
                    "mobile" => $this->post("mobile"),
                    "address" => $this->post("address"),
                    "website" => $this->post("website"),
                    "email" => $this->post("email"),
                    "short_code" => $short_code,
                    "registered_from" => $this->post("registered_from"),
                    "building_number" => $this->post("building_number"),
                    "flat_number" => $this->post("flat_number"),
                    "temporary" => $this->post("temporary")
                );

                // get country & city from google maps API
                $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $post['latitude'] . "," . $post['longitude'] . "&sensor=true";
                $data = file_get_contents($url);
                $jsondata = json_decode($data, true);

                if (is_array($jsondata) && $jsondata['status'] == "OK") {
                    foreach ($jsondata["results"] as $result) {
                        foreach ($result["address_components"] as $address) {
                            if (in_array("locality", $address["types"])) {
                                $post['city'] = $address["long_name"];
                            }
                            if (in_array("country", $address["types"])) {
                                $post['country'] = $address["long_name"];
                            }
                        }
                    }
                }

                // return $this->response($post);
                if (isset($_FILES["photo"]["name"])) {
                    $img = $this->upload();
                    $post["photo"] = $img["upload_data"]["file_name"];
                }

                $result = $this->location_model->insert($post);

                if (isset($result) && $result == false) {
                    $this->response(array("error" => strip_tags(validation_errors())));
                } else {
                    $this->load->model("location_model");

                    // get the new location as a full object and return it to the caller as a reponse
                    $location = $this->location_model->with("user")->with("meta")->with("category")->get_by(array("title" => $post["title"]));
                    if ($this->post("temporary") == 0) {
                        // send an email with the details of the new location
                        $mailData = array(
                            "title" => $this->input->post("title"),
                            "privacy" => ($this->input->post("is_private") == 1) ? "Private (Passcode: " . $this->input->post("passcode") . ")" : "Public",
                            "address" => $this->input->post("address"),
                            "flat_number" => $this->input->post("flat_number"),
                            "building_number" => $this->input->post("building_number"),
                            "city" => $post['city'],
                            "country" => $post['country'],
                            "latitude" => $this->input->post("latitude"),
                            "longitude" => $this->input->post("longitude"),
                            "username" => $location->user->username
                        );
                        $otherData = array("TITLE" => $this->input->post("title"));
                        send_email(1, $location->user, $mailData, $otherData);
                    }

                    $this->response($location);
                }
            } else {
                $this->response(array("message" => "false"));
            }
        }

        $this->response(array("id" => $result));
    }

    /* check if locname is valid */

    function is_valid_locname_post()
    {
        $this->load->model("location_model", "locationModel");
        // check locname validity and non-premium shortcode
        $valid = $this->locationModel->valid_locname($this->post("title"));
        if ($valid) {
            // check LocName non-existance
            $already_exists = $this->locationModel->count_by("title", $this->post("title"));
            if ($already_exists) {
                return $this->response(array("status" => "false", "message" => "LocName already exists"));
            } else {
                return $this->response(array("status" => "true", "message" => "Available"));
            }
        }
        return $this->response(array("status" => "false", "message" => "Invalid LocaName"));
    }

    function location_visit_post()
    {
        $result = "false";
        if ($this->post("user_id") && $this->post("location_id")) {

            $this->load->model("location_visits_model");
            $this->location_visits_model->insert(array(
                "location_id" => $this->post("location_id"),
                "user_id" => $this->post("user_id"),
                "visited_from" => $this->post("visited_from")
            ));

            $result = "true";

            // prepare push data
            $owner_id = $this->post("owner_id");
            $owner_name = $this->post("owner_name");
            $owner_img = $this->post("owner_img");
            $location_name = $this->post("location_name");

            // send push notification
            $message = $owner_name . " viewed " . $location_name . ". Click here to view their profile.";
            $more_data = array("page_type" => "profile", "user_id" => $this->post("user_id"));
            //appcelerator_push($message, $owner_id, $more_data);
        }
        return $this->response(array("message" => $result));
    }

    function location_post()
    {
        $this->load->model("location_model");
        $location = $this->location_model->with("user")->with("meta")->with("category")->get_by(array("title" => $this->post("name")));

        if ($location) {
            if ($location->is_event == "0") {
                $location->duration_from = "";
                $location->duration_to = "";
            }
            if ($location->mobile == "0") {
                $location->mobile = "Unspecified";
            }
            if ($location->website == "0") {
                $location->website = "Unspecified";
            }
            if ($location->email == "0") {
                $location->email = "Unspecified";
            }
            if ($location->details == "0") {
                $location->details = "Unspecified";
            }
            return $this->response($location);
        } else {
            $this->db->select('*');
            $this->db->from('location');
            $this->db->like("location.title", substr($this->post("name"), 0, 3), 'after');
            $this->db->or_like("location.title", substr($this->post("name"), -3), 'after');

            $suggested = $this->db->get()->result();
            return $this->response(array("suggested" => $suggested));

            //return $this->response(array("message" => "location not found"));
        }
    }

    // TODO: replace with the upper function in the new version
    function location_temp_post()
    {
        $this->load->model("location_model");
        $location = $this->db
            ->select("location.*, COALESCE(category.title, '') as category, COALESCE(category.type, 'general') as type", FALSE)
            ->from('location')
            ->join("category", "location.category_id = category.id", "left")
            ->where(array("location.title" => $this->post("name"), "temporary" => 0))
            ->get()->row();

        if ($location) {
            $location = $this->location_model->afterGet($location);
            if ($location->is_event == "0") {
                $location->duration_from = "";
                $location->duration_to = "";
            }
            if ($location->mobile == "0") {
                $location->mobile = "Unspecified";
            }
            if ($location->website == "0") {
                $location->website = "Unspecified";
            }
            if ($location->email == "0") {
                $location->email = "Unspecified";
            }
            if ($location->details == "0") {
                $location->details = "Unspecified";
            }
            return $this->response($location);
        } else {
            $this->db
                ->select("location.id, location.title, COALESCE(category.title, '') as category, COALESCE(category.type, 'general') as type", FALSE)
                ->from('location')
                ->join("category", "location.category_id = category.id", "left")
                ->where(array("temporary" => 0))
                ->order_by("location.title")
                ->like("location.title", substr($this->post("name"), 0, 3), 'after')
                ->or_like("location.title", substr($this->post("name"), -3), 'after');

            $suggested = $this->db->get()->result();
            return $this->response(array("suggested" => $suggested));

            //return $this->response(array("message" => "location not found"));
        }
    }

    /**
     * Favorites API
     *
     */
    function AddTofavourite_post()
    {

        $this->load->model("favourite_model", "favModel");
        if ($this->favModel->get_by(array("user_id" => $this->post("user_id"), "location_id" => $this->post("location_id")))) {
            $code = ("duplicatd");
            return $this->response(array("code" => $code));
        }
        $result = $this->favModel->insert(array(
            "location_id" => $this->post("location_id"),
            "user_id" => $this->post("user_id")
        ));
        if ($result) {
            $code = true;
        } else {
            $code = "server error";
        }

        return $this->response(array("code" => $code));
    }

    function deleteFromFavourite_post()
    {
        $this->load->model("favourite_model", "favModel");
        if (!isset($_POST["location_id"]) || $this->post("location_id") == "")
            return $this->response(array("code" => "location_id not found"));
        if (!isset($_POST["user_id"]) || $this->post("user_id") == "")
            return $this->response(array("code" => "user_id not found"));
        $code = $this->favModel->delete_by(array("location_id" => $this->post("location_id"), "user_id" => $this->post("user_id")));
        $this->response(array("code" => $code));
    }

    /**
     * @param int location_id
     * @return boolean success or failure
     */
    function deleteLocation_post()
    {
        $this->load->model("location_model", "locModel");
        if (!isset($_POST["location_id"]) || $this->post("location_id") == "") {
            return $this->response(array("code" => "location_id not found"));
        }

        $code = $this->locModel->delete_by(array("id" => $this->post("location_id")));
        $this->response(array("code" => $code));
    }

    /**
     * @param int user_id
     * @return array of user's favorite places
     */
    function getFavourites_post()
    {
        $this->load->model("favourite_model", "favModel");
        $favs = $this->favModel->with("location")->with("user")->with("category")->get_many_by("user_id", $this->post("user_id"));
        usort($favs, function ($a, $b) {
            return strcmp(strtolower($a->location->title), strtolower($b->location->title));
        });
//        $favs = $this->favModel->getFavsByUserId($this->post("user_id"));
        return $this->response($favs);
    }

    function getFavourites_temp_post()
    {
        $this->load->model("favourite_model");
        //$favs = $this->favModel->with("location")->with("user")->with("category")->get_many_by("user_id", $this->post("user_id"));
        //usort($favs, function ($a, $b) {
        //return strcmp(strtolower($a->location->title), strtolower($b->location->title));
        //});
        $favs = $this->favourite_model->get_fav_locations($this->post("user_id"));
        return $this->response($favs);
    }

    function isFavouriteLocation_post()
    {
        $this->load->model("favourite_model", "favModel");
        $user_id = $this->post("user_id");
        $location_id = $this->post("location_id");
        $count = $this->favModel->count_by(array("user_id" => $user_id, "location_id" => $location_id));
        if ($count == 1)
            return $this->response(array("result" => "true"));
        else
            return $this->response(array("result" => "false"));
    }

    function userLocations_post()
    {
        $this->load->model("location_model");
        $locations = $this->location_model->with("category")->order_by("title")->get_many_by(array("user_id" => $this->post("user_id")));
        return $this->response($locations);
    }

    function userLocations_temp_post()
    {
        $this->load->model("location_model");
        //$locations = $this->location_model->with("category")->order_by("title")->get_many_by(array("user_id" => $this->post("user_id")));
        $locations = $this->location_model->get_user_locations($this->post("user_id"));
        return $this->response($locations);
    }

    function categories_get()
    {
        $this->load->model("category_model");
        $categories = $this->category_model->get_all();
        $this->response($categories);
    }

    function categories_post()
    {
        $this->load->model("category_model");
        $categories = $this->category_model->get_many_by(array("type" => $this->post("type")));

        $this->response($categories);
    }

    function upload()
    {
        //load the helper
        $this->load->helper('form');

        //Configure
        //set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
        $config['upload_path'] = 'assets/uploads';

        // set the filter image types
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        //load the upload library
        $this->load->library('upload', $config);

        $data['upload_data'] = '';

        //if not successful, set the error message
        if (!$this->upload->do_upload('photo')) {
            $data = array('msg' => $this->upload->display_errors());
        } else { //else, set the success message
            $data = array('msg' => "Upload success!");

            //[ MAIN IMAGE ]
            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
            $config['maintain_ratio'] = TRUE;
            $config['overwrite'] = TRUE; // allow overwrite to replace image
            $config['width'] = 800;
            $config['height'] = 600;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $data['upload_data'] = $this->upload->data();
        }
        return $data;
        //load the view/upload.php
        //$this->response($data);
    }

    function report_post()
    {

        $this->load->model("report_model", "reportModel");

        $report = array(
            "user_id" => $this->post("user_id"),
            "location_id" => $this->post("location_id"),
            "reason" => $this->post("reason"),
            "message" => $this->post("message")
        );

        if ($this->reportModel->insert($report)) {
            return $this->response(array("code" => true));
        }
        return $this->response(array("code" => false));
    }

    function open_app_post()
    {
        $this->load->model("user_model");
        $this->user_model->update_last_open_app($this->post("user_id"));
    }

    function edit_unique($value, $params)
    {

        $this->form_validation->set_message('edit_unique', "Sorry, that %s is already being used.");

        list($table, $field, $current_id) = explode(".", $params);

        $query = $this->db->select()->from($table)->where($field, $value)->limit(1)->get();

        if ($query->row() && $query->row()->id != $current_id) {
            return FALSE;
        }
    }

//      -------------------    This Functions related to V2 of locname  ----------------
    function getFacebookFriends_post()
    {
        $data = array();
        $this->load->library("facebook", array(
            'appId' => $this->fbid,
            'secret' => $this->secret));
        // request user profile from fb api
        $result = array();
        try {
            $this->load->model("authentications_model", "authenticationsModel");
            $this->db->where(array("user_id" => $this->post("user_id")));
            $user = $this->authenticationsModel->get_by();
            if ($user) {
                $data = $this->facebook->api('/' . $user->provider_uid . "/friends");
                foreach ($data["data"] as $user) {
                    $this->db->where(array("provider_uid" => $user["id"]));
                    $user = $this->authenticationsModel->get_by();
                    if ($user) {
                        $result[] = $user;
                    }
                }
            } else {
                $result = array("message" => "Invalid user");
            }
        } catch (FacebookApiException $e) {
            $result = array("message" => "An Error occurred while retrieving your friend list");
        }
        if (empty($result))
            $result = array("message" => "None of your friends has LocName installed!");
        $this->response($result);
    }

    function get_facebook_friends_post()
    {
        $data = array();
        $user_id = $this->post("user_id");
        $this->load->library("facebook", array(
            'appId' => $this->fbid,
            'secret' => $this->secret));
        // request user profile from fb api
        $result = array();
        try {
            $this->load->model("authentications_model", "authenticationsModel");
            $this->db->where(array("user_id" => $user_id));
            $user = $this->authenticationsModel->get_by();
            if ($user) {
                $data = $this->facebook->api('/' . $user->provider_uid . "/friends");
                foreach ($data["data"] as $user) {
                    $user = $this->db
                        ->select("user_id as id, firstName as first_name, lastName as last_name, photoURL as photo")
                        ->where(array("provider_uid" => $user["id"]))
                        ->get("authentications")->row();
                    if ($user) {
                        $this->load->model("friends_model");
                        $result[] = $user;
                        $check = $this->friends_model->is_friend($user_id, $user->id);
                        if (!$check) {
                            $this->friends_model->insert(array("user1_id" => $user_id, "user2_id" => $user->id, "source" => 'Facebook'));
                        }
                    }
                }
                usort($result, function ($a, $b) {
                    return strcmp(strtolower($a->first_name . $a->last_name), strtolower($b->first_name . $b->last_name));
                });
            } else {
                $result = array("message" => "Invalid user");
            }
        } catch (FacebookApiException $e) {
            $result = array("message" => "An Error occurred while retrieving your friend list");
        }
        if (empty($result))
            $result = array("message" => "None of your friends has LocName installed!");
        $this->response($result);
    }

    /**
     *  get user's followers
     * @return array
     */
    function following_post()
    {
        $this->load->model("follow_model", "followModel");
        $followers = $this->followModel->followers($this->post("user_id"));
        return $this->response(array("followers" => $followers));
    }

    function favourite_users_post()
    {
        $this->load->model("follow_model", "followModel");
        //$followers = $this->followModel->followers($this->post("user_id"));
        $following = $this->followModel->favourite_users($this->post("user_id"));
        foreach ($following as $user) {
            if (isset($user->photo) && strlen($user->photo) > 2) {

                if (is_url($user->photo) && !empty($user->photo))
                    $user->photo = $user->photo . "&width=1000&height=1000";
                else
                    $user->photo = base_url("assets/uploads/users_images/" . $user->photo);
            } else {
                $user->photo = base_url("assets/main/img/user.png");
            }
        }
        return $this->response(array("favourite_users" => $following));
    }

    /**
     *  get user's followers
     * @return array
     */
    function followers_post()
    {
        $this->load->model("follow_model", "followModel");
        $followers = $this->followModel->following($this->post("user_id"));
        return $this->response(array("followers" => $followers));
    }

    function follow_post()
    {
        $this->load->model("follow_model", "followModel");
        $insert = $this->followModel->create($this->post("user_id"), $this->post("follow_id"));
        $this->response(array("result" => $insert));
    }

    function unFollow_post()
    {
        $this->load->model("follow_model", "followModel");

        $delete = $this->followModel->delete_by(array(
            "user_id" => $this->post("user_id"),
            "follow_id" => $this->post("follow_id")
        ));
        if ($delete)
            $delete = false;

        return $this->response(array("result" => $delete));
    }

    /**
     *  check if user follow  another user
     * @return boolean
     */
    function is_follower_post()
    {
        $this->load->helper("public");
        $result = is_follwing($this->post("follow_id"), $this->post("user_id"));
        if ($result)
            $result = true;
        else
            $result = false;
        return $this->response(array("result" => $result));
    }

    /**
     *  user can send verification request to make his location verified  with  yellow sign
     * @param type $locationId
     * @return type
     */
    function askverify_post()
    {
        $result = "ERROR";
        $locationId = $this->input->post("location_id");
        if ($locationId != false && $this->post("user_id") != false) {

            $this->load->model("verify_model");
            $is_asked_before = $this->verify_model->count_by(array(
                "user_id" => $this->post("user_id"),
                "location_id" => $locationId
            ));
            if ($is_asked_before == 0) {
                $this->verify_model->insert(array(
                    "user_id" => $this->post("user_id"),
                    "location_id" => $locationId
                ));
                $result = "success";
            } else {
                $result = "in progress";
            }
        }
        return $this->response(array("result" => $result));
    }

    /**
     * rate Location
     * @param int user_id
     * @param int location_id
     * @param int value
     * return boolean
     */
    function rateLocation_post()
    {

        if ($this->post("location_id") == false || $this->post("user_id") == FALSE || $this->post("value") == FALSE)
            $this->response(array("result" => "ERROR in Params"));

        $this->load->model("rating_model", "ratingModel");
        $result = $this->ratingModel->insert(array(
            "user_id" => $this->post("user_id"),
            "location_id" => $this->post("location_id"),
            "rating" => $this->post("value")
        ));

        $this->response(array("result" => $this->ratingModel->calcLocationRate($this->post("location_id"))));
    }

    /**
     * Advanced Search
     */
    function advanced_search_post()
    {

        $this->db->from("location");

        if (strlen($this->post("username")) > 3) {
            $this->load->model("user_model", "userModel");
            $user = $this->userModel->get_by("username");
            if (isset($user_id))
                $this->db->where("user_id", $user->id);
        }

        if (strlen($this->post("title")) > 1) {
            $this->db->like("title", $this->post("title"));
        }

        if (strlen($this->post("mobile")) > 1) {
            $this->db->where("mobile", $this->post("mobile"));
        }

        if (strlen($this->post("country")) > 1) {
            $this->db->where("country", $this->post("country"));
        }

//        if(strlen($this->post("city")) > 1) {
//            $this->db->where("city" , $this->post("city"));
//        }

        if (strlen($this->post("type")) > 1) {
            $this->db->where("type", $this->post("type"));
        }
        if (strlen($this->post("category")) > 1) {
            $this->db->where("category_id", $this->post("category"));
        }

        $this->response(array("locations" => $this->db->get("location")->result()));
    }

    /*     * *********************************************** */

    function doPostRequest($url, $data, $optional_headers = null)
    {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            ));
        if ($optional_headers !== null)
            $params['http']['header'] = $optional_headers;

        $ctx = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $ctx);
        if (!$fp)
            throw new Exception("Problem with $url, $php_errmsg");

        $response = @stream_get_contents($fp);
        if ($response === false)
            return false;
        return $response;
    }

    function pwCall($action, $data = array())
    {
        $url = 'https://cp.pushwoosh.com/json/1.3/' . $action;
        $json = json_encode(array('request' => $data));
        $res = $this->doPostRequest($url, $json, 'Content-Type: application/json');
        print_r(@json_decode($res, true));
    }

    function pushcall_post()
    {

        /*        $params = array(
          'application' => "7113C-34107",
          'auth' => "AmswsSqPHavXGwoxkjADvbo0eRpQXOodnVmEhXXdN1KSsjJVOiucM0caRUVyHrDc5aLiNSTCECtMzeX9T8uE",
          'notifications' => array(
          array(
          'send_date' => 'now',
          'content' => $this->post("content"),
          //                    "content" => json_encode(array("message" => $this->post("content"), "long" => $this->post("long"), "lat" => $this->post("lat"), "status" => $this->post("status"))),
          //                    'ios_badges' => 3,
          'data' => array('content' => 'json data'),
          'link' => 'http://locname.com/'
          )
          )
          );
          if (strlen($this->post("device")) > 1) {
          $params["notifications"][0]["devices"] = array($this->post("device"));
          }
          //       die(var_dump($params));

          $this->pwCall('createMessage', $params);
         */
    }

    /*     * ***************************************** */

    /*     * ***************************************** */

    function allCountries_get()
    {
        $this->load->model("country_model", "countryModel");
        $this->response(array($this->countryModel->get_all()));
    }

    function cityByCountry_get()
    {
        $this->load->model("city_model", "cityModel");
        $this->response(array($this->cityModel->get_many_by(array())));
    }

    function sendinvitationMail_post()
    {
        $this->load->library('email');

        $emails = $this->post("emails");

        // Start sending Emails
        $config['protocol'] = 'sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->email->initialize($config);
        $this->email->from('info@locname.com', 'Locname website');
        $this->email->bcc($emails);
        $this->email->subject('invite Test');
        $this->email->message('Testing the email invitation.');
        $this->email->send();
    }

    function autocompleteLocations_get($title = "")
    {
        $this->load->model('location_model');
        $locations = $this->location_model->autocomplete($this->input->get("term"));
        $data = array();
        foreach ($locations as $row) {
            $data['message'][] = array('label' => $row->title, 'value' => $row->title); //Add a row to array
        }
        return $this->response($locations);
    }

    function autocomplete_post($title = "")
    {
        $this->load->model('location_model');
        $locations = $this->location_model->autocomplete($this->input->post("term"));
        return $this->response($locations);
    }

    function get_user_post()
    {
        $this->load->model('user_model');
        $user = $this->user_model->getUser($this->post("user_id"));
        return $this->response($user);
    }

    function get_location_post()
    {
        $this->load->model('location_model');
        $this->load->model("rating_model", "ratingModel");
        $location = $this->location_model->get_location($this->post("location_id"));
        $location->rating = $this->ratingModel->calcLocationRate($this->post("location_id"));
        if ($location) {
            if ($location->is_event == "0") {
                $location->duration_from = "";
                $location->duration_to = "";
            }
            if ($location->mobile == "0") {
                $location->mobile = "Unspecified";
            }
            if ($location->website == "0") {
                $location->website = "Unspecified";
            }
            if ($location->email == "0") {
                $location->email = "Unspecified";
            }
            if ($location->details == "0") {
                $location->details = "Unspecified";
            }
        }
        return $this->response($location);
    }

    function get_location_by_tile_post()
    {
        $this->load->model('location_model');
        $this->load->model("rating_model", "ratingModel");
        $location = $this->location_model->get_location_by_title($this->post("location_title"));
        $location->rating = $this->ratingModel->calcLocationRate($location->id);
        if ($location) {
            if ($location->is_event == "0") {
                $location->duration_from = "";
                $location->duration_to = "";
            }
            if ($location->mobile == "0") {
                $location->mobile = "Unspecified";
            }
            if ($location->website == "0") {
                $location->website = "Unspecified";
            }
            if ($location->email == "0") {
                $location->email = "Unspecified";
            }
            if ($location->details == "0") {
                $location->details = "Unspecified";
            }
        }
        return $this->response($location);
    }

    function sync_all_friends_post()
    {
        $this->sync_contacts_post();
        $this->get_facebook_friends_post();
    }

    function contact_us_post()
    {
        $this->load->model("contact_model");
        $this->load->model("user_model");
        $user_id = $this->post("user_id");
        $subject = $this->post("subject");
        $message = $this->post("message");
        $user = $this->user_model->getUser($user_id);
        $this->contact_model->insert(array("name" => $user->first_name . " " . $user->last_name, "email" => $user->email, "message" => $subject . "\n" . $message));
        $this->response(array("status" => "success"));
    }

    function get_notifications_post()
    {
        $this->load->model("notification_model");
        $notifications = $this->notification_model->get_notifications($this->input->post("user_id"));
        return $this->response(array("result" => $notifications));
    }

    function read_notification_post()
    {
        $this->load->model("notification_model");
        $result = $this->notification_model->read_notification($this->input->post("notification_id"));
        if ($result) {
            return $this->response(array("status" => "success"));
        }
        return $this->response(array("status" => "fail"));
    }

    function read_all_notifications_post()
    {
        $this->load->model("notification_model");
        $result = $this->notification_model->read_all_notifications($this->input->post("user_id"));
        if ($result) {
            return $this->response(array("status" => "success"));
        }
        return $this->response(array("status" => "fail"));
    }


    /* share location to a friend*/

    function shareloc_get()
    {

        $this->load->helper('public');
        $this->load->model("user_model");
        $this->load->model("location_model", "locationModel");
        $this->load->model("shared_token_model", "sharedTokenModel");




        // get data sent
        $sender_id = $this->get('sender_id');
        $friend_id = $this->get('friend_id');
        $location_id = $this->get('location_id');
        $sh1STR = $sender_id . $friend_id . $location_id . "very secret key";
        $token = sha1($sh1STR);

        // get location
        $location = $this->locationModel->get_by("id", $location_id);
        $sender = $this->user_model->getUser($sender_id); //user info
        $friendinfo = $this->user_model->getUser($friend_id); //friend info




        // validate token
        // get token
        $findToken = $this->sharedTokenModel->getToken($token); //user info
        if($findToken) {
            $msg = $location->title . " shared before from you to friend " . $friendinfo->first_name . ' ' . $friendinfo->last_name;
            return $this->response(array("status" => "fail" , "message" => $msg) , 400);
        }
        else {

            $mailData = array(
                "friendname" => $sender->first_name . " " . $sender->last_name,
                "username" => $friendinfo->first_name . " " . $friendinfo->last_name,
                "title" => $location->title,
                "privacy" => $location->privacy,
                "flat_number" => $location->flat_number,
                "building_number" => $location->building_number,
                "address" => $location->address,
                "city" => $location->city,
                "country" => $location->country,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude
            );
            $otherData = array("TITLE" => base_url($location->title));
            send_email("3", $friendinfo, $mailData, $otherData);
            $msg = "You shared " . $location->title . " with " . $friendinfo->first_name . ' ' . $friendinfo->last_name;

            $tokenInsert = array(
                "token" => $token,

            );
            $this->sharedTokenModel->insert($tokenInsert);

            return $this->response(array("status" => "success" , "message" => $msg),200);
        }






    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Amr Soliman
 * @link		http://www.mezatech.com
 * @filesource
 */
// --------------------------------------------------------------------


function is_home() {
    $CI = & get_instance();
    return ($CI->router->fetch_class() === 'index' && $CI->router->fetch_method() === 'index') ? true : false;
}
function is_location() {
    $CI = & get_instance();
    return ($CI->router->fetch_class() === 'location' && $CI->router->fetch_method() === 'view') ? true : false;
}
function is_about() {
    return strpos(base_url(uri_string()),'about');
}
/**
 * Returns a session variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */
function session_userdata($key) {
    $CI = & get_instance();
    if (!isset($CI->session)) {
        $CI->load->library('session');
    }
    return $CI->session->userdata($key);
}

// --------------------------------------------------------------------

/**
 * Sets a session variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */
function session_set_userdata($key, $value) {
    $CI = & get_instance();
    if (!isset($CI->session)) {
        $CI->load->library('session');
    }
    return $CI->session->set_userdata($key, $value);
}

// --------------------------------------------------------------------

/**
 * Returns a session flash variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */
function get_flashdata($key) {
    $CI = & get_instance();
    if (!isset($CI->session)) {
        $CI->load->library('session');
    }

    return $CI->session->flashdata($key);
}

/**
 * Returns a session flash variable
 *
 * @access	public
 * @param	string	variable name [ warning ,info , error , success ]
 * @return	boolean
 */
function flashdata($key, $msg) {
    $CI = & get_instance();
    if (!isset($CI->session)) {
        $CI->load->library('session');
    }

    return $CI->session->set_flashdata($key, $msg);
}

// --------------------------------------------------------------------
/**
 * display a readable array - Laravel
 *  @author Amr soliman <info@mezatech.com>
 */
function dd() {
    echo '<pre>';
    $args = func_get_args();
    call_user_func('var_dump', $args);
    echo '</pre>';
    die;
}

/**
 * Sets a session flash variable
 *
 * @access	public
 * @param	string	variable name
 * @return	boolean
 */
function session_set_flashdata($key, $value) {
    $CI = & get_instance();
    if (!isset($CI->session)) {
        $CI->load->library('session');
    }
    return $CI->session->set_flashdata($key, $value);
}

/**
 * Set message
 * Used in any place you want to push a message
 *
 * @access public
 * @param  string $status -> values are 'success', 'warning', 'error', 'notice'
 * @param  string $message -> the message you want to view in page
 * @return void
 * @author Amr Soliman <info@mezatech.com>
 */
function message($status = '', $message = '') {
    $CI = & get_instance();

    $CI->session->set_flashdata('status', $status);
    $CI->session->set_flashdata('message', $message);

    $CI->template->status = $status;
    $CI->template->message = $message;
}

/**
 * Populate message in template
 * Use only in template, don't use anywhere
 *
 * @access private
 * @return void
 * @author Amr Soliman <info@mezatech.com>
 */
function get_message() {
    $CI = & get_instance();

    $CI->template->status || $CI->template->status = '';
    $CI->template->message || $CI->template->message = '';

    // Publish flash data
    if ($CI->session->flashdata('status') && !$CI->session->flashdata('remove_message')) {
        $CI->template->status = $CI->session->flashdata('status');
        $x = $CI->session->flashdata('remove_message');
    }

    if ($CI->session->flashdata('message') && !$CI->session->flashdata('remove_message')) {
        $CI->template->message = $CI->session->flashdata('message');
        $x = $CI->session->flashdata('remove_message');
    }

    $CI->session->set_flashdata('remove_message', 'ok');
}

function is_url($url = "") {


    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        return false;
    } else {
        return true;
    }
}

function userPhoto($attr = array(), $userid = false) {
    $attrs = "";
    $ci = & get_instance();

    if (count($attr)) {
        foreach ($attr as $key => $value) {
            $attrs .= " $key = '$value'";
        }
    }
    // $photo = base_url("assets/uploads/users_images/" . $ci->ion_auth->user()->row($userid)->photo);
    $user = $ci->ion_auth->user($userid)->row($userid);
    if (isset($user->photo) && strlen($user->photo) > 2) {
        if (is_url($user->photo))
            $photo = $user->photo;
        else
            $photo = base_url("assets/uploads/users_images/" . $user->photo);
    } else {
        $photo = base_url("assets/main/img/user.png");
    }
    return "<img src='$photo'  $attrs >";
}

function userPhotoPath($userid = false) {

    $ci = & get_instance();
    $ci->load->spark("auth/2.0");
    // $photo = base_url("assets/uploads/users_images/" . $ci->ion_auth->user()->row($userid)->photo);
    $user = $ci->ion_auth->user($userid)->row();


    if (isset($user->photo) && strlen($user->photo) > 2) {

        if (is_url($user->photo) && !empty($user->photo))
            $photo = $user->photo . "&width=1000&height=1000";
        else
            $photo = base_url("assets/uploads/users_images/" . $user->photo);
    } else {
        $photo = base_url("assets/main/img/user.png");
    }
    return $photo;
}

function getCountryWithLats($lats) {
    $googleApiUrl = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lats&sensor=true";
    $googleCode = file_get_contents($googleApiUrl);
    $googleCode = json_decode($googleCode);
    return @$googleCode->results[0]->address_components[4]->short_name;
}

/**
 *
 * @param int $location_id
 * @param int $user_id
 * @return  boolean
 */
function is_favourite($location_id = false, $user_id = false) {
    $CI = & get_instance();
    $CI->load->model("favourite_model");
    return $CI->favourite_model->count_by(array("user_id" => $user_id, "location_id" => $location_id));
}

// ---------------------------- Version 2 -------------------------
/**
 *
 * @param type $follow_id
 * @param type $user_id
 * @return boolean
 */
function is_follwing($follow_id = false, $user_id = false) {
    $CI = & get_instance();
    if ($user_id == false && isset($CI->ion_auth->user()->row()->id))
        $user_id = $CI->ion_auth->user()->row()->id;
    if ($user_id == false && !isset($CI->ion_auth->user()->row()->id))
        return false;

    $CI->load->model("follow_model");
    return $CI->follow_model->count_by(array("user_id" => $user_id, "follow_id" => $follow_id));
}

function myFacebookFriends($provider_uid = "me") {
    $data = array();
    $CI = & get_instance();
    $CI->load->library("facebook", $CI->config->item("facebook"));
    // request user profile from fb api
    try {
        $data = $CI->facebook->api('/' . $provider_uid . "/friends");
    } catch (FacebookApiException $e) {
        $data = array();
    }
    return $data;
}

/**
 *   formula for calculating the distance between two points:


 * @param type $latitude1
 * @param type $longitude1
 * @param type $latitude2
 * @param type $longitude2
 * @param type $unit
 * @return type
 */
function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))
            ));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;
    switch ($unit) {
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance, 2));
}

/** * ********************      PUSH Notification            ************************** */
function doPostRequest($url, $data, $optional_headers = null) {
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

function pwCall($action, $data = array()) {
    $url = 'https://cp.pushwoosh.com/json/1.3/' . $action;
    $json = json_encode(array('request' => $data));
    $res = doPostRequest($url, $json, 'Content-Type: application/json');
    print_r(@json_decode($res, true));
    dd($res);
}

function pushcall($content, $device) {
    $CI = & get_instance();
    $config = $CI->config->item("pushwoosh");




    $config = array(
        'application' => "7113C-34107",
        'auth' => "AmswsSqPHavXGwoxkjADvbo0eRpQXOodnVmEhXXdN1KSsjJVOiucM0caRUVyHrDc5aLiNSTCECtMzeX9T8uE",
    );

    $params = array(
        'application' => $config["application"],
        'auth' => $config["auth"],
        'notifications' => array(
            array(
                'send_date' => 'now',
                "content" => json_encode(array("message" => $content)),
//                    'ios_badges' => 3,
                'data' => array('content' => 'json data'),
                'link' => 'http://locname.com/'
            )
        )
    );
    if (strlen($device) > 1) {
        $params["notifications"][0]["devices"] = array($device);
    }
//       die(var_dump($params));

    pwCall('createMessage', $params);
}

/* * ***************************************** */


/* * *********************  ACS appcelerator   ******************** */
/**
 *
 * @param string  $url
 * @param string  $method
 * @param array $data
 * $data example array('where' => json_encode(array('user_id' => '4f9eb57a0020440def0056d3')),
 * @param boolean $secure
 * @return json
 */

function appcelerator($url, $method, $data, $secure=TRUE) {

    $CI = & get_instance();
    $CI->load->library("appcelerator" , $CI->config->item("appcelerator"));

//    $data = array(
//        "payload" => "notificación",
//        "channel" => "alert"
//    );


//    $output = $CI->appcelerator->send_request('push_notification/notify.json', 'POST', $data);
    return  $CI->appcelerator->send_request($url, $method, $data, $secure=TRUE);
}

function gen_location_code($len=8) {
	$hex = md5("LocName" . uniqid("", true));

	$pack = pack('H*', $hex);
	$tmp =  base64_encode($pack);

	$uid = preg_replace("#(*UTF8)[^0-9a-z]#", "", $tmp);

	$len = max(4, min(128, $len));

	while (strlen($uid) < $len)
		$uid .= gen_location_code(22);

	return substr($uid, 0, $len);
}
function gen_location_new_short_code(){
    $digits = 3;
    $letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $shortCode = $letters[rand(0, sizeof($letters) - 1)]."".$letters[rand(0, sizeof($letters) - 1)]."".$letters[rand(0, sizeof($letters) - 1)]."".rand(pow(10, $digits-1), pow(10, $digits)-1);
    return $shortCode;
}
function check_short_code($string){
  $numbers = substr($string, 3);
  $letters = substr($string, 0, 3);
  if(($letters[0] == $letters[1]) == $letters[2]){
    return "FALSE";
    if(($numbers[0] == $numbers[1]) == $numbers[2]){
      return "FALSE";
    }else{
      return "FALSE";
    }
  }else if(($numbers[0] == $numbers[1]) == $numbers[2]){
    return "FALSE";
  }else if( $letters[0] == chr(ord($letters[1]) - 1) && $letters[1] == chr(ord($letters[2]) - 1) ){
    return "FALSE";
    if( ($numbers[2] - $numbers[1]) == 1 && ($numbers[1] - $numbers[0]) == 1 ){
      return "FALSE";
    }else{
      return "FALSE";
    }
  }else if( ($numbers[2] - $numbers[1]) == 1 && ($numbers[1] - $numbers[0]) == 1 ){
    return "FALSE";
  }else{
    return "TRUE";
  }
}

// TODO: split this function into login and push
function appcelerator_push($msg, $ch, $data) { // THIS IS THE ONE WE ARE USING (WORKING)
	/*** SETUP ***************************************************/
	//$key        = " 2T5EUb8Lm3ArmPz5ARhChWLp0hYbSAs2"; // app key (development)
    $key        = "5IGBg1nsLQA7xukAsTUfC5d3NLHGCK0O"; // app key (production)

	$username   = "mourad@Locname.com"; // app admin user name
	$password   = "1234"; // app admin password
	$to_ids     = "everyone"; // all users on the channel
	$channel    = "$ch"; // user_id (a channel is created for each user)
	$message    = $msg; // the message to be displayed
	$title      = "LocName";
	$tmp_fname  = 'cookie.txt';

    $json       = '{"alert":"'. $message .'","title":"'. $title .'","vibrate":true,"sound":"default","icon":"myicon"';
    // copy data from array to json to be sent
    foreach ($data as $k => $v)
    {
        $json .= ', "' . $k . '":"' . $v . '"';
    }
    $json .= '}';

	if (!is_null($key) && !is_null($username) && !is_null($password) && !is_null($channel) && !is_null($message) && !is_null($title)){
		/*** PUSH NOTIFICATION ***********************************/

		/*** INIT CURL *******************************************/
		$curlObj    = curl_init();
		$c_opt      = array(CURLOPT_URL => 'https://api.cloud.appcelerator.com/v1/users/login.json?key='.$key,
							CURLOPT_POST => true,
							CURLOPT_POSTFIELDS => "login=".$username."&password=".$password,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_COOKIEFILE => $tmp_fname,
                            CURLOPT_COOKIEJAR => $tmp_fname
							);

		/*** LOGIN **********************************************/
		curl_setopt_array($curlObj, $c_opt);
		$session = curl_exec($curlObj);

		/*** SEND PUSH ******************************************/
		$c_opt[CURLOPT_URL]         = "https://api.cloud.appcelerator.com/v1/push_notification/notify.json?key=".$key;
		$c_opt[CURLOPT_POSTFIELDS]  = "channel=".$channel."&payload=".$json."&to_ids=".$to_ids;
		//$c_opt[CURLOPT_SSL_VERIFYPEER] = true;

		curl_setopt_array($curlObj, $c_opt);
		$session = curl_exec($curlObj);

		/*** THE END ********************************************/
		curl_close($curlObj);

		//header('Content-Type: application/json');
		//die(json_encode(array('response' => json_decode($session))));
	} else {
		//header('Content-Type: application/json');
		//die(json_encode(array('response' => json_decode($session))));
	}
}

function send_email($type, $user, $mail_data, $other_mail_data = null, $loop_mail_data = null) {
    $CI = & get_instance();
    $CI->load->model("user_preference_model");
    $CI->config->load('mandrill');
    $apikey = $CI->config->item("mandrill_api_key");

    if(is_string($type) === TRUE || $CI->user_preference_model->check_mail_settings($type, $user->id) === TRUE) {
        $CI->load->library('mandrill', array($apikey));
        $message = array(
            "html" => null,
            "text" => null,
            "from_email" => "info@locname.com",
            "from_name" => "LocName",
            "to" => array(array("email" => $user->email)),
            "track_opens" => true,
            "track_clicks" => true,
            "auto_text" => true
        );

        $template_name = "";
        $template_content = array();
        foreach($mail_data as $key => $val) {
            $template_content[] = array("name" => $key, "content" => $val);
        }

        if($other_mail_data !== null || $loop_mail_data !== null) {
            $message["global_merge_vars"] = array();
        }

        if($other_mail_data !== null) {
            foreach($other_mail_data as $key => $val) {
                $message["global_merge_vars"][] = array("name" => $key, "content" => $val);
            }
        }

        if($loop_mail_data !== null) {
            $message["merge_language"] = "handlebars";
            $message["global_merge_vars"][] = array("name" => "items", "content" => $loop_mail_data);
        }

        switch($type) {
            case 1:
                $template_name = "after-locname-registration";
                $message["subject"] = "New Location: " . $mail_data["title"];
                break;
            case 2:
                $template_name = "when-friend-joins";
                $message["subject"] = "Your friend " . $mail_data["friend_username"] . " has joined LocName";
                break;
            case 3:
                $template_name = "when-friend-share-locname";
                $message["subject"] = "Your friend " . $mail_data->friendname . " has shared the the LocName". $mail_data->title;
                break;
            case 4:
                $template_name = "reminder";
                $message["subject"] = "Please complete your LocName '" . $user->username . "' information";
                break;
            case 5:
                $template_name = "inactivelocname";
                $message["subject"] = "One or more of your LocNames has been inactive";
                break;
            case "welcome":
                $template_name = "welcome-email-for-facebook-sign-up";
                $message["subject"] = "Welcome to LocName";
                break;
            case "inactive_user":
                $template_name = "inactive-account";
                $message["subject"] = "We missed you at LocName! Sign in to continue your LocName experience!";
                break;
            case "no_location_created":
                $template_name = "have-not-registered-locname-yet";
                $message["subject"] = "You still haven't registered a location! Save one now!";
                break;
            case "no_location_visit":
                $template_name = "no-visits-to-locname";
                $message["subject"] = "No one has visited your location! Share it with your friends!";
                break;
            case "forgot_password":
                $template_name = "forgot-your-password";
                $message["subject"] = "Change Password Request";
                break;
            case "invite":
                $template_name = "friend-has-invited-you-to-locname";
                $message["subject"] = "Your friend " . $mail_data["username"] . " has invited you to LocName";
                break;
            case "verify":
                $template_name = "verification-email-for-email-sign-up";
                $message["subject"] = "Verify your account" ;
                break;
            default:
                return FALSE;
        }

        $CI->mandrill->messages->sendTemplate($template_name, $template_content, $message);
        return TRUE;
    }
    return FALSE;
}

function check_profile_feature($feature, $user_id, $profile_type) {
    $CI = & get_instance();
    $CI->load->model("user_model");
    switch($feature) {
        case "create_location":
            foreach($profile_type->features as $profile_feature) {
                if($profile_feature->feature_id == 1) { // create locname feature
                    $current_amount = $CI->user_model->getNumOfUserLocations($user_id);
                    $amount = $profile_feature->amount;
                    break;
                }
            }
            break;
    }

    if($current_amount < $amount) {
        // can create
        return true;
    }
    else {
        // can't create
        return false;
    }
}

function check_profile_action($action, $user_id, $profile_type) {
    $CI = & get_instance();
    $CI->load->model("user_model");
    switch($action) {
        case "friend_list":
            foreach($profile_type->actions as $profile_action) {
                if($profile_action->action_id == 1) {
                    $current_amount = $CI->user_model->getNumOfUserFriends($user_id);
                    $amount = $profile_action->amount;
                    break;
                }
            }
            break;
        case "places_hits":
            foreach($profile_type->actions as $profile_action) {
                if($profile_action->action_id == 2) {
                    $current_amount = $CI->user_model->getNumPlacesVisits($user_id);
                    $amount = $profile_action->amount;
                    break;
                }
            }
            break;
        case "favorite_places":
            foreach($profile_type->actions as $profile_action) {
                if($profile_action->action_id == 3) {
                    $current_amount = $CI->user_model->getNumOfUserFavLocations($user_id);
                    $amount = $profile_action->amount;
                    break;
                }
            }
            break;
        case "invite":
            foreach($profile_type->actions as $profile_action) {
                if($profile_action->action_id == 4) {
                    $current_amount = $CI->user_model->getNumOfUserInvites($user_id);
                    $amount = $profile_action->amount;
                    break;
                }
            }
            break;
    }

    if($current_amount >= $amount) {
        // promote
        return promote_profile($user_id);
    }
    else {
        // don't promote
        return false;
    }
    return false;
}

function promote_profile($user_id) {
    // load user profile actions and features
    $CI = & get_instance();
    $CI->load->model("profile_type_model", "profileTypeModel");
    $CI->load->model("user_model", "userModel");
    $user = $CI->userModel->getUser($user_id);

    if($CI->profileTypeModel->isTopProfile($user->profile_type_id)) {
        return false;
    }

    $CI->userModel->update_profile_type($user_id, $user->profile_type_id + 1);
    $CI->profileTypeModel->addHistory($user_id, $user->profile_type_id);

    $profile_type = $CI->profileTypeModel->getProfileTypeDetails($user->profile_type_id);

    if($CI->session->userdata["user_id"] == $user_id) {
        $CI->session->set_userdata('profile_type', $profile_type);
    }
    return true;
}

function get_promote_actions($feature, $user_id, $profile_type) {
    $CI = & get_instance();
    $suggestions = array();
    switch($feature) {
        case "create_location":
            foreach($profile_type->features as $profile_feature) {
                if($profile_feature->feature_id == 1) { // 1 = create locname feature
                    $suggestions = get_suggestions($user_id, $profile_type);
                }
            }
            break;
    }
    return $suggestions;
}

function get_suggestions($user_id, $profile_type) {
    $CI = & get_instance();
    $CI->load->model("user_model");
    $suggestions = array();
    if(count($profile_type->actions) == 0) {
        $suggestions["maximum"] = "do nothing! You have reached the ultimate profile type!";
    }
    else {
        foreach($profile_type->actions as $profile_action) {
            switch($profile_action->action_id) {
                case 1:
                    // friend list
                    $numFriends = $CI->user_model->getNumOfUserFriends($user_id);
                    $req_amount = $profile_action->amount - $numFriends;
                    $suggestions["friend_list"] = "have " . $req_amount . " more friend(s) in your friend list";
                    break;
                case 2:
                    // places hits
                    $numPlacesVisits = $CI->user_model->getNumPlacesVisits($user_id);
                    $req_amount = $profile_action->amount - $numPlacesVisits;
                    $suggestions["places_hits"] = "share your location(s) to have " . $req_amount . " more visit(s) to your location(s)";
                    break;
                case 3:
                    // favorite locations list
                    $numFavLocations = $CI->user_model->getNumOfUserFavLocations($user_id);
                    $req_amount = $profile_action->amount - $numFavLocations;
                    $suggestions["favorite_list"] = "add " . $req_amount . " more location(s) to your favorite list";
                    break;
                case 4:
                    // invite
                    $numInvites = $CI->user_model->getNumOfUserInvites($user_id);
                    $req_amount = $profile_action->amount - $numInvites;
                    $suggestions["invite"] = "invite " . $req_amount . " more friend(s) to join LocName";
                    break;
            }
        }
    }
    return $suggestions;
}

/* End of file public_helper.php */

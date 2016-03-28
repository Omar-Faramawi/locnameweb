<?php

/**
 * Description of auth
 *
 * @author Ahmed Shaher
 * @email <a.shaher16@gmail.com>
 */
class Friends extends User_Controller {

    function __construct() {
        parent::__construct();
     
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        } else {
            $this->session->set_userdata(array('current_url' => base_url(uri_string())));
            redirect("auth/login");
        }
        $this->load->helper("public");

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    function index($offset = 0) {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("user_model", "userModel");
        $this->data["headerTitle"] = "Friend List";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Friend List";

        /* Load the 'pagination' library */
        $this->load->library('pagination');

        /* Set the config parameters */
        $config['base_url'] = site_url("friends/index");
        $config['total_rows'] = count($this->friendsModel->get_friend_list($this->user->id));
        $config['per_page'] = 9;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);
        $allfriends = $this->friendsModel->get_friend_list($this->user->id);
        $friendsprofiles = array();
        for ($start = $offset; $start < $config['per_page'] + $offset && $start < $config['total_rows']; $start++) {
            $friend_profile = $this->userModel->getUser($allfriends[$start]->id);
            $friend_profile->num_locations = $this->userModel->getNumOfUserLocations($allfriends[$start]->id);
            $friend_profile->num_fav_locations = $this->userModel->getNumOfUserFavLocations($allfriends[$start]->id);
            $friendsprofiles[$start - $offset] = $friend_profile;
        }
        $this->data["friends"] = $friendsprofiles;
        $this->data["links"] = $this->pagination->create_links();
    }

    function locations($id = 0, $offset = 0) {
       
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("location_model", "locationModel");
        $this->view = "friends/locations";
        $this->data["headerTitle"] = "Friends Locations";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Locations";
        $this->data['friend_id'] = $id;
        $this->data['isFriend'] = $this->friendsModel->is_friend($id, $this->user->id);
        $this->data['locations']= $this->locationModel->count_by("user_id", $id);
    }

    function favourites($id = 0, $offset = 0) {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("favourite_model", "favModel");
        $this->view = "friends/locations";
        $this->data["headerTitle"] = "Friend Favorites";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Favorites";
        $this->data['friend_id'] = $id;
        $this->data['isFriend'] = $this->friendsModel->is_friend($id, $this->user->id);
        $this->data['locations']= $this->favModel->count_by("user_id", $id); 
    }

    function invite_windows_live_friends(){
        $this->load->model("user_model", "userModel");
        //setting parameters
        $client_id     = '0000000040158220';
        $client_secret = '0xubbx7IabjLSq4HBzNczUpYQZmwtisx';
        $redirect_uri  = site_url('friends/invite_windows_live_friends');

        $auth_code = $_GET["code"];
        $fields=array(
            'code'=>  urlencode($auth_code),
            'client_id'=>  urlencode($client_id),
            'client_secret'=>  urlencode($client_secret),
            'redirect_uri'=>  urlencode($redirect_uri),
            'grant_type'=>  urlencode('authorization_code')
        );

        $post = '';
        foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }

        $post = rtrim($post,'&');
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
        curl_setopt($curl,CURLOPT_POST,5);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
        $result = curl_exec($curl);
        curl_close($curl);
        $response =  json_decode($result);
        $accesstoken = $response->access_token;

        $url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken;
        $xmlresponse =  $this->curl_file_get_contents($url);
        $xml = json_decode($xmlresponse, true);
        $contacts_email = "";

        $count = 0;
        $emails = array();
        foreach ($xml['data'] as $title) {
            $user_id = $this->ion_auth->user()->row()->id;
            $inviting_user = $this->userModel->getUser($user_id);
            $mail_data = array(
                "username" => $inviting_user->first_name." ".$inviting_user->last_name,
            );
            $count++;
            //echo $count.". ".$title['emails']['personal'] . "<br><br>";
            $mailData = array("username" => $myName);
            $exist = $this->userModel->getUserByEmail($title['emails']['personal']);
            if(!$exist->id){
                if(!in_array($title['emails']['personal'], $emails)){
                    array_push($emails, $title['emails']['personal']);
                }
                /*$user = new stdClass();
                $user->email = $title['emails']['personal'];
                $other_mail_data = NULL;
                send_email("invite", $user, $mail_data, $other_mail_data);*/
            }
        }

        $this->session->set_userdata('invite_live_emails', $emails);
        redirect("user/friends");
    }

    function curl_file_get_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    function invite_yahoo_friends(){
        $this->load->model("user_model", "userModel");
        require("yahoo/Yahoo.inc");  
  
          // Your Consumer Key (API Key) goes here.  
        define('CONSUMER_KEY', "dj0yJmk9Q1pVNk9hSkVSWE53JmQ9WVdrOVdtbHJla2d3TnpRbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD02Mw--");  
          
          // Your Consumer Secret goes here.  
        define('CONSUMER_SECRET', "a367c4942dbd1f7f22c79027d72433b57ae71b87");  
          
          // Your application ID goes here.  
        define('APPID', "ZikzH074");  
          
        $session = YahooSession::requireSession(CONSUMER_KEY,CONSUMER_SECRET,APPID);

        $user = $session->getSessionedUser();  

        $contacts = $user->getContacts();

        $user_id = $this->ion_auth->user()->row()->id;
        $inviting_user = $this->userModel->getUser($user_id);
        $mail_data = array(
            "username" => $inviting_user->first_name." ".$inviting_user->last_name,
        );
        $emails = array();
        foreach ($contacts->contacts->contact as $index => $value) {
          $arrayOfFields = $contacts->contacts->contact[$index]->fields;
          foreach ($arrayOfFields as $key => $value) {
              if( $arrayOfFields[$key]->type == "yahooid" ){
                $email = $arrayOfFields[$key]->value."@yahoo.com";
                //echo $email;
                $exist = $this->userModel->getUserByEmail($email);
                if(!$exist->id){
                   /* $userobj = new stdClass();
                    $userobj->email = $email;
                    $other_mail_data = NULL;
                    send_email("invite", $userobj, $mail_data, $other_mail_data);*/
                    if(!in_array($email, $emails)){
                        array_push($emails, $email);
                    }
                }
              }
             
          }
          
          // echo $email."<br>";
        }
        $this->session->set_userdata('invite_emails', $emails);
        redirect("user/friends");
    }
}

<?php

/**
 * Description of auth
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class Auth extends User_Controller {

    var $fbid = "1376235535961215";
    var $secret = "42055f0ce428faf9fb56e60f9690f7e5";

    function __construct() {
        parent::__construct();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    //redirect if needed, otherwise display the user list
    function index() {

        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        redirect(site_url(), 'refresh');
    }

    //log the user in
    function login() {

        $this->data["headerTitle"] = "Login";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Login";

        if ($this->ion_auth->logged_in()) {
            //redirect them to the previous page or to the home page
            if($this->session->userdata('current_url'))
                redirect($this->session->userdata('current_url'), 'refresh');
            else
                redirect(site_url(), 'refresh');
        }

        $this->data['title'] = "Login";

        //validate form input
        $this->form_validation->set_rules('identity', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

                //if the login is successful
                //redirect them back to where they came from
                $this->load->model("user_group_model", "userGroupModel");
                $user_group = $this->userGroupModel->get_by("user_id", $this->ion_auth->user()->row()->id)->group_id;
                $this->session->set_userdata('user_group', $user_group);
                
                // load user profile actions and features
                $this->load->model("profile_type_model", "profileTypeModel");
                $this->load->model("user_model", "userModel");
                $user = $this->userModel->getUser($this->ion_auth->user()->row()->id);
                $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
                $this->session->set_userdata('profile_type', $profile_type);

                $this->session->set_flashdata('success', $this->ion_auth->messages());

                if($this->session->userdata('current_url')) {
                    redirect($this->session->userdata('current_url'), 'refresh');
                }
                else {
                    redirect(site_url(), 'refresh');
                }
            } else {
                //if the login was un-successful
                //redirect them back to the login page
                //$this->session->set_flashdata('message', $this->ion_auth->errors());
		$this->session->set_flashdata('message', 'Wrong Email or Password');
                redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                "placeholder" => "Email"
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                "placeholder" => "Password"
            );

            $this->view = 'auth/login';
        }
    }

    //log the user in by provider
    function login_provider($provider = '') {
        if (empty($provider)) {
            redirect();
        }

        // prepare url for next page
        $next_page = site_url();
        if ($this->session->userdata('current_url')) {
            $next_page = $this->session->userdata('current_url');
        }


        try {
            $this->load->spark("auth/2.0");

            // create an instance for Hybridauth with the configuration file
            $this->load->library('HybridAuthLib');
            $this->load->library("facebook", array(
                'appId' => $this->fbid,
                'secret' => $this->secret));

            if ($this->hybridauthlib->serviceEnabled($provider)) {
                // try to authenticate the selected $provider
                $service = $this->hybridauthlib->authenticate($provider);

                if ($service->isUserConnected()) {
                    // grab the user profile
                    $user_profile = $service->getUserProfile();

                    $provider_uid = $user_profile->identifier;

                    if ($this->ion_auth->login_by_provider($provider, $provider_uid)) {
                        $data['user_profile'] = $this->ion_auth->user_by_provider();

                        if ($this->uri->segment(4) == "home") {
                            redirect("index/close");
                        }

                        if ($this->session->userdata('current_url')) {
                            redirect($this->session->userdata('current_url'), 'refresh');
                        } else {
                            redirect(site_url(), 'refresh');
                        }
                    } else { // if authentication does not exist and email is not in use, then we create a new user
                        $username = $user_profile->firstName . ' ' . $user_profile->lastName;
                        $password = rand(8, 15);
                        $email = $user_profile->email;

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
                        $additional_data['email'] = $user_profile->email;
                        $additional_data['emailVerified'] = $user_profile->emailVerified;
                        $additional_data['phone'] = $user_profile->phone;
                        $additional_data['address'] = $user_profile->address;
                        $additional_data['region'] = $user_profile->region;
                        $additional_data['zip'] = $user_profile->zip;
                        $additional_data['country'] = "";
                        $additional_data['city'] = "";
                        $additional_data['registered_from'] = 'W';



                        // split region into country and city (if possible)
                        if ($user_profile->region != "") {
                            $arr = explode(", ", $user_profile->region);
                            if (sizeof($arr) >= 2) {
                                $additional_data['country'] = array_pop($arr); // last element
                                $additional_data['city'] = array_pop($arr); // element before the last
                            }
                        }
                        
                        // get country code from cloudflare
                        if($additional_data['country'] == NULL || $additional_data['country'] == "0" || $additional_data['country'] == "") {
                            $additional_data['country'] = $this->input->server("HTTP_CF_IPCOUNTRY");
                        }

                        if ($email != null && $this->ion_auth->register_by_provider($provider, $provider_uid, $username, $password, $email, $additional_data)) { // create new user && create a new authentication for him
                            if ($this->ion_auth->login_by_provider($provider, $provider_uid)) { // log user in :)
                                // send welcome email for the new user
                                $this->load->helper("public");
                                $this->load->model("user_model");
                                $mailData = array(
                                    "username" => $username
                                );
                                send_email("welcome", $this->user_model->getUserByEmail($email), $mailData);

                                // get user profile from authentications table.
                                $data['user_profile'] = $this->ion_auth->user_by_provider();

                                /* *** Send push notification for the new user's friends *** */
                                // set the message to be pushed
                                $message = "Your friend " . $username . " has joined LocName. Click here to view their profile.";

                                $this->load->model("authentications_model", "authenticationsModel");
                                $this->db->where(array("email" => $user_profile->email));
                                $user = $this->authenticationsModel->get_by(); // get the new user full information
                                if ($user) {
                                    // prepare the additional data to be sent
                                    $more_data = array("page_type" => "profile", "user_id" => $user->user_id);
                                    // get facebook friends of the new user
                                    try {
                                        if($provider == "Google"){
                                            $this->load->model("user_model", "userModel");
                                            $user_contacts = $service->getUserContacts();
                                            foreach ($user_contacts as $user){
                                                $tempuser = $this->userModel->getUserByEmail($user->email);
                                                if ($tempuser->id){
                                                     // send them email
                                                    $friend_username =  $tempuser->first_name." ". $tempuser->last_name;
                                                    $mailData = array(
                                                        "username" => $friend_username,
                                                        "friend_username" => $user_profile->firstName . " " . $user_profile->lastName,
                                                        "friend_first_name" => $user_profile->firstName
                                                    );

                                                    $receiver->email = $tempuser->email;
                                                    $receiver->id = $tempuser->id;
                                                    
                                                    send_email(2, $receiver, $mailData);

                                                    // add new notification for them
                                                    $this->load->model("notification_model");
                                                    $notification = array(
                                                        "user_id" => $tempuser->id,
                                                        "notification_type_id" => 1,
                                                        "friend_id" => $user->user_id
                                                    );

                                                    $this->notification_model->insert($notification);

                                                   $ch = $tempuser->id;
                                                   appcelerator_push($message, $ch, $more_data);
                                                }
                                            }
                                          
                                        }else{
                                            $fb_data = $this->facebook->api('/' . $user->provider_uid . "/friends");
                                            foreach ($fb_data["data"] as $fb_user) {
                                                // get those friends whom we have in database
                                                $friend = $this->db
                                                                ->select("user_id as id, firstName as first_name, lastName as last_name, email")
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
                                                        "friend_username" => $user->firstName . " " . $user->lastName,
                                                        "friend_first_name" => $user->firstName
                                                    );
                                                    $otherMailData = array("URL" => site_url("friends/locations/" . $user->user_id));
                                                    send_email(2, $friend, $mailData, $otherMailData);

                                                    // add new notification for them
                                                    $this->load->model("notification_model");
                                                    $notification = array(
                                                        "user_id" => $friend->id,
                                                        "notification_type_id" => 1,
                                                        "friend_id" => $user->user_id
                                                    );

                                                    $this->notification_model->insert($notification);
                                                    
                                                } else { // we don't have this user
                                                    $this->load->model("user_friend_model");
                                                    $this->user_friend_model->insert(array("user_id" => $user->user_id, "provider" => "Facebook", "provider_uid" => $fb_user["id"], "name" => $fb_user["name"]));
                                                }
                                            }
                                        }
                                        
                                        
                                    } catch (FacebookApiException $e) {
                                        echo "An Error occurred while retrieving your friend list";
                                    }
                                }
                                /* *** End of push notification *** */
                            } else {
                                //if the login was un-successful
                                //redirect them back to the login page
                                $this->session->set_flashdata('error', "Cannot authenticate user");
                                $next_page = site_url('auth/login');
                            }
                        } else {
                            //if the register was un-successful
                            //redirect them back to the login page
                            $this->session->set_flashdata('error', "Cannot authenticate user");
                            $next_page = site_url('auth/login');
                        }
                    }
                } else { // Cannot authenticate user
                    // You are not logged in to Facebook or Google+
                    // TODO: popup to allow user to login using Facebook or Google+
                    $this->session->set_flashdata('error', "Cannot authenticate user");
                    $next_page = site_url('auth/login');
                }

                // close the popup
                if ($this->uri->segment(4) == "home") {
                    redirect("index/close");
                }

                // redirect the user to where they came from or to the home page
                redirect($next_page, 'refresh');
            } else { // This service is not enabled.
                show_404($_SERVER['REQUEST_URI']);
            }
        } catch (Exception $e) {
            // Display the recived error
            $error = 'Unexpected error';

            switch ($e->getCode()) {
                case 0 : $error = 'Unspecified error.';
                    break;
                case 1 : $error = 'Hybriauth configuration error.';
                    break;
                case 2 : $error = 'Provider not properly configured.';
                    break;
                case 3 : $error = 'Unknown or disabled provider.';
                    break;
                case 4 : $error = 'Missing provider application credentials.';
                    break;
                case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
                    //redirect();
                    if (isset($service)) {
                        log_message('debug', 'controllers.HAuth.login: logging out from service.');
                        $service->logout();
                    }
                    show_error('User has cancelled the authentication or the provider refused the connection.');
                    break;
                case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
                    break;
                case 7 : $error = 'User not connected to the provider.';
                    break;
            }

            if (isset($service)) {
                $service->logout();
            }

            // well, basically your should not display this to the end user, just give him a hint and move on..
            $this->data['message'] = $error;

            // load error view

            $this->view = 'auth/login';
        }
    }

    // important for HybridIgniter library..
    public function provider_endpoint() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $_GET = $_REQUEST;
        }
        require_once SPARKPATH . 'auth/2.0/third_party/hybridauth/index.php';
    }

    //log the user out
    function logout() {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('success', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
		$user_data = $this->session->all_userdata(); 
		 foreach ($user_data as $key => $value) {
         $this->session->unset_userdata($key);
        }
    }

    //change password
    function change_password() {
        $this->data["headerTitle"] = "Change Password";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Change Password";
        $this->form_validation->set_rules('old', 'Old Password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            //render

            $this->view = 'auth/change_password';
        } else {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password() {
        $this->data["headerTitle"] = "Forgot Password";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Forgot Password";
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        if ($this->form_validation->run() == false) {
            //setup the input
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
                "placeholder" => "Your Email Account"
            );

            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->view = 'auth/forgot_password';
        } else {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

            if ($forgotten) {
                //if there were no errors
//                $this->session->set_flashdata('message', $this->ion_auth->messages());
//                message("notice", $this->ion_auth->messages());
                session_set_flashdata("success", $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
//                $this->session->set_flashdata('message', $this->ion_auth->errors());
                session_set_flashdata("error", $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }
        $this->data["headerTitle"] = "Reset Password";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Reset Password";
        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

            if ($this->form_validation->run() == false) {
                //display the form
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                //$this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                //render
                $this->view = 'auth/reset_password';
            } else {
                // do we have a valid request?
                if ($user->id != $this->input->post('user_id')) {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error('This form post did not pass our security checks.');
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        //if the password was successfully changed
                        session_set_flashdata("success", $this->ion_auth->messages());
                        redirect('auth/login', 'refresh');
                        //$this->logout();
                    } else {
                        session_set_flashdata("error", $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL) {
        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', 'confirmation', 'required');
        $this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();


            $this->view = 'auth/deactivate_user';
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    //  show_error('This form post did not pass our security checks.');
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //create a new user
    function register() {
        $this->data['title'] = "Create User";

        $this->data["headerTitle"] = "Register New User";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Register New User";

        if ($this->ion_auth->logged_in()) {
            redirect('user/update', 'refresh');
        }
        $this->load->model("country_model", "countryModel");
        $this->data["countries"] = $this->countryModel->get_all();

        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|alpha');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean|min_length[7]|max_length[15]');
        $this->form_validation->set_rules('company', 'Company Name', 'trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('country', 'Country', '');
        $this->form_validation->set_rules('city', 'City', '');

        if ($this->form_validation->run() == true) {
            $username = $this->input->post('first_name') . " " . $this->input->post('last_name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'type' => $this->input->post('type'),
                'country' => $this->input->post('country'),
                'city_id' => $this->input->post('city'),
                'registered_from' => 'W'
            );
            
            // get country code from cloudflare
            if($additional_data['country'] == 0) {
                $additional_data['country'] = $this->input->server("HTTP_CF_IPCOUNTRY");
            }

            if (strlen($_FILES["photo"]["name"])) {
                //$this->form_validation->set_rules('photo', 'Photo', 'file_required');
                $config['upload_path'] = 'assets/uploads/users_images';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                //if not successful, set the error message
                if (!$this->upload->do_upload('photo')) {
                    $photoError = true;
                    flashdata("error", $this->upload->display_errors());
                    $this->data['upload_error'] = $this->upload->display_errors();

                } else {
                    //[ MAIN IMAGE ]
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['maintain_ratio'] = TRUE;
                    $config['overwrite'] = TRUE; // allow overwrite to replace image
                    $config['width'] = 800;
                    $config['height'] = 600;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $file['upload_data'] = $this->upload->data();
                    $additional_data["photo"] = $file['upload_data']["file_name"];
                }
            }
        }
	
        if ($this->form_validation->run() == true && $id_back_from_ion_auth = $this->ion_auth->register($username, $password, $email, $additional_data)) {
            //check to see if we are creating the user
            /*Set the default mail noftification settings*/
            $this->load->model('preference_model', 'prefModel');
            $this->load->model('user_preference_model', 'userPref');
            $prefTypes = $this->prefModel->get_preferences();
            foreach ($prefTypes as $pref) {
                $post = array(
                        'user_id' => $id_back_from_ion_auth,
                        'preference_id' => $pref->id
                    );
                $this->userPref->insert($post);
            }

            // send success email (welcome)
            $this->load->helper('public');
            $this->load->model("user_model");
            $mailData = array(
                "username" => $this->input->post('first_name') . " " . $this->input->post('last_name')
            );
             $otherData = array("VERIFICATION" =>  $this->getVerificationLink($email));
            send_email("verify", $this->user_model->getUserByEmail($email), $mailData,$otherData);
            
            $this->session->set_flashdata('success', 'User registered successfully'); // waiting test

            // login the user
            $this->ion_auth->login($email, $password, true);
            
            // load the user group
            $this->load->model("user_group_model", "userGroupModel");
            $user_group = $this->userGroupModel->get_by("user_id", $this->ion_auth->user()->row()->id)->group_id;
            $this->session->set_userdata('user_group', $user_group);

            // load user profile actions and features
            $this->load->model("profile_type_model", "profileTypeModel");
            $this->load->model("user_model", "userModel");
            $user = $this->userModel->getUser($this->ion_auth->user()->row()->id);
            $profile_type = $this->profileTypeModel->getProfileTypeDetails($user->profile_type_id);
            $this->session->set_userdata('profile_type', $profile_type);

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                "placeholder" => "Email"
            );
            
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                "placeholder" => "Password"
            );

            redirect("auth/login", 'refresh');
        } else {

            //display the c register  form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['username'] = array(
                'name' => 'username',
                'id' => 'username',
                'type' => 'text',
                'value' => $this->form_validation->set_value('username'),
            );

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                "required" => "required",
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );

            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                "required" => "required",
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                "required" => "required",
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->data['type'] = array(
                'name' => 'type',
                'id' => 'type',
                'value' => $this->form_validation->set_value('type'),
            );

            $this->view = 'auth/register';
        }
    }

    //edit a user
    function edit_user($id) {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();

        //process the phone number
        if (isset($user->phone) && !empty($user->phone)) {
            $user->phone = explode('-', $user->phone);
        }

        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('phone1', 'First Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error('This form post did not pass our security checks.');
            }

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );

            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE) {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                redirect("auth", 'refresh');
            }
        }

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone1',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone[0]),
        );

        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );

        $this->view = 'auth/edit_user';
    }

    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function verify()
    {
        $email=$_GET['email'];
        $code=$_GET['verify'];
        $this->load->helper('public');
        $this->load->model("user_model");
        $secret = "35onoi2=-7#%g03kl";
        $hash = MD5($email.$secret);
        $user_id= $this->user_model->getUserByEmail($email)->id;
        $user=$this->user_model->getUser($user_id);
        if($hash==$code)
        {
            $this->user_model->verify_account($email);
            $mailData = array(
                "username" => $user->first_name . " " . $user->last_name 
            );
            send_email("welcome", $this->user_model->getUserByEmail($email), $mailData);
            redirect(base_url());
            echo '<script>alert("Your account has been verified");</script>';
        }
    }
    function getVerificationLink($email)
    {
            $secret = "35onoi2=-7#%g03kl";
            $hash = MD5($email.$secret);
            $link=  base_url("/auth/verify?email=$email&verify=$hash");
            return $link;
         
    }
}

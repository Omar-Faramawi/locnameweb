<?php

/**
 * Description of auth
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class User extends User_Controller {

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

    /*
     * Dashboard for current user
     */

    function index() {
        
    }

    /*
     * Display user profile
     */

    function profile($id = false) {
//        $this->data["profile"] = $this->ion_auth->user($id)->row();
        $this->load->model("user_model");
        if ($id == false && isset($this->data["user"]->id))
            $id = $this->data["user"]->id;
        elseif ($id == false && !isset($this->data["user"]->id)) {
            flashdata("error", "user not found");
            redirect(site_url());
        }
        $profile = $this->user_model->with("locations")->get($id);
        if (!$profile) {
            flashdata("error", "user not found");
            redirect(site_url());
        }
        if (!$profile)
            show_404();
        $this->data["headerTitle"] = $profile->username;
        $this->data["site_title"] = "";
        $this->data["page_title"] = $profile->username;
        $this->data["profile"] = $profile;
    }

    /**
     *  user locations
     * @param type $offset
     */
//    function locations($offset = 0) {
//        $this->load->model("location_model", "locationModel");
//        $this->data["headerTitle"] = "Locations";
//        $this->data["site_title"] = "";
//        $this->data["page_title"] = "Locations";
//
//        /* Load the 'pagination' library */
//        $this->load->library('pagination');
//
//        /* Set the config parameters */
//        $config['base_url'] = site_url("user/locations");
//        $config['total_rows'] = $this->locationModel->count_by("user_id", $this->data["user"]->id);
//        $config['per_page'] = 9;
//        $config['uri_segment'] = 3;
//
//        /* Initialize the pagination library with the config array */
//        $this->pagination->initialize($config);
//        $this->data["locations"] = $this->locationModel->order_by("id", "DESC")->limit($config['per_page'], $offset)->get_many_by("user_id", $this->data["user"]->id);
//        $this->data["links"] = $this->pagination->create_links();
//    }
    ////////////////////////////////////////////user_locations/////////////////////
     function user_locations($id = 0, $offset = 0) {
        $this->load->model("friends_model", "friendsModel");
        $this->load->model("location_model", "locationModel");
        $this->view = "friends/locations";
        $this->data["headerTitle"] = "Locations";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Locations";
        $this->data['friend_id'] = $id;
        $this->data['isFriend'] =true;//$this->friendsModel->is_friend($id, $this->user->id);

        $this->load->library('pagination');

        /* Set the config parameters */
        $config['page_query_string'] = FALSE;
        $config['base_url'] = site_url("friends/locations/$id");
        $config['per_page'] = 9;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->locationModel->count_by("user_id", $id);

        /* Initialize the pagination library with the config array */
        $this->pagination->initialize($config);
        $this->data["locations"] = $this->locationModel->order_by("id", "DESC")->limit($config['per_page'], $offset)->get_many_by("user_id", $id);
        $this->data["links"] = $this->pagination->create_links();
    }

    ////////////////////////////////////////////////////////////////////////////////////

    function save() {
        
    }

    function verify() {
        if (!($this->data["user"]->verified == 1)) {
            $this->userModel->update_by(array("user_id" => $this->data["user"]->id), array("verified" => 2));
            flashdata("success", "you account in progress of verification ");
        } else {
            flashdata("success", "you account already verified");
        }
        redirect("user/update");
    }

    //change password
    function updatePassword() {
        if (isset($_POST) && !empty($_POST)) {
            $data = array();
        if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
                $this->form_validation->set_rules('old_password', 'Old Password', 'required');
                $data['password'] = $this->input->post('password');
            }else{
                flashdata("error", "Old password, Password and Password Confirmation fields are required.");
                redirect("user/update");        
            }
            if ($this->form_validation->run() === TRUE && $photoError == false) {
                $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

                $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('password'));

                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('success', $this->ion_auth->messages());
                    redirect("user/update");
                } else {
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect("user/update");
                }
            }

        }
        $this->data['message2'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message2')));
        flashdata("error", $this->data['message2']);
        redirect("user/update");
    }

    //edit a user
    function update() {

        $user = $this->user;
        $photoError = false;
        
        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('country', 'Country Name', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST)) {

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'country' => $this->input->post('country'),
                'city_id' => $this->input->post('city'),
                'address' => $this->input->post('address'),
            );

            if (strlen($_FILES["photo"]["name"])) {
                $this->form_validation->set_rules('photo', 'Photo', 'file_required');
                $config['upload_path'] = 'assets/uploads/users_images';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                
                //if not successful, set the error message
                if (!$this->upload->do_upload('photo')) {
                    $photoError = true;
                    flashdata("error", $this->upload->display_errors());
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
                    $data["photo"] = $file['upload_data']["file_name"];
                }
            }

            //update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE && $photoError == false) {
                $this->ion_auth->update($user->id, $data);
                flashdata("success", "Your account is updated.");
                redirect(current_url(), 'refresh');
            }
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        flashdata("success", $this->data['message']);
        
        //pass the user to the view
        $this->data['user'] = $user;
        $this->load->model("country_model", "countryModel");
        $this->load->model("city_model", "cityModel");

        $this->data["countries"] = $this->countryModel->get_all();
        $this->data["cities"] = $this->cityModel->get_many_by(array("country" => $this->data["user"]->country));
        
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name)
        );
        
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name)
        );
        
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company)
        );
        
        $this->data['photo'] = array(
            'name' => 'photo',
            'id' => 'photo',
            'type' => 'text',
            'value' => $this->form_validation->set_value('photo', $user->photo)
        );
        
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone)
        );

        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'textarea',
            'value' => $this->form_validation->set_value('address', $user->address)
        );

        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'placeholder' => 'Make sure passwords match'
        );
        
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'placeholder' => 'Make sure passwords match'
        );

        $this->data['old_password'] = array(
            'name' => 'old_password',
            'id' => 'old_password',
            'type' => 'password'
        );

        $this->data["headerTitle"] = $user->first_name." ".$user->last_name;
        $this->data["site_title"] = "";
        $this->data["page_title"] = $user->first_name." ".$user->last_name;

        $this->load->model("preference_model", "prefModel");
        $this->data['prefs'] = $this->prefModel->get_preferences();
        $this->load->model('user_preference_model', 'userPref');
        $this->data['userPrefs'] = $this->userPref->get_user_settings($this->data['user']->id);
    }

    function mail_settings(){
        $this->load->model('user_preference_model', 'userPref');
        if($_POST && !empty($_POST)){
            $this->userPref->delete_by(array('user_id' => $this->data['user']->id));
            $mailSettings = $this->input->post('mailSettings');
            foreach ($mailSettings as $prefId) {
                $post = array(
                    'user_id' => $this->data['user']->id,
                    'preference_id' => $prefId
                );
                $this->userPref->insert($post);
            }
        }else{
            $this->userPref->delete_by(array('user_id' => $this->data['user']->id));
        }
        $this->session->set_flashdata('success',"Mail Settings updated Successfully");
        redirect("user/update");
    }

    function deactivate($id){
        $this->load->model("ion_auth_model", "ion");
        $this->ion->deactivate($id);
        redirect("auth/logout");
    }
    
    function follow() {
        $this->layout = false;
        $this->view = "layouts/ajax";
        $this->load->model("follow_model", "followModel");
        $follow_id = $this->input->post("user_id");
        $insert = $this->followModel->create(
                $this->data["user"]->id, $follow_id
        );
        echo $insert;
    }

    function unfollow() {
        $this->load->model("follow_model", "followModel");
        $follow_id = $this->input->post("user_id");
        $delete = $this->followModel->delete_by(array(
            "user_id" => $this->data["user"]->id,
            "follow_id" => $follow_id
        ));
        echo $delete;
    }

    function followers($who = false) {
        $this->load->model("follow_model", "followModel");
        if ($who == "me") {
            $this->data["headerTitle"] = "Following";
            $this->data["site_title"] = "";
            $this->data["page_title"] = "Following";
            $this->data["followers"] = $this->followModel->following($this->data["user"]->id);
        } else {
            $this->data["headerTitle"] = "Followers";
            $this->data["site_title"] = "";
            $this->data["page_title"] = "Followers";
            $this->data["followers"] = $this->followModel->followers($this->data["user"]->id);
        }
    }

    function invite() {
        $this->data["headerTitle"] = "Invite Friends";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Invite Friends";
        $this->load->model("user_model", "userModel");
        $user = $this->userModel->getUSer($this->data["user"]->id);
        //  if ($user->provider == "Facebook") {
        $this->view = "user/invite_facebook";
        // } else {
            // flashdata("error", "Sorry , you are not allowed to access this area");
            // redirect("user/profile");
        // }
    }

    function mutualFriends() {

        $this->data["headerTitle"] = "Mutual Friends";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Mutual Friends";
        error_reporting(0);
        if ($this->data["user"]->provider == "Facebook") {
            $this->view = "user/facebook_friends";
            $this->data["socialFriends"] = myFacebookFriends();
            $this->data["socialFriends"] = $this->data["socialFriends"]["data"];
            $userFriends = array(0);
            foreach ($this->data["socialFriends"] as $friend) {
                $userFriends[] = $friend["id"];
            }

            $this->data["friends"] = $this->userModel->getFacebookFriends($userFriends);
        } else {
            flashdata("error", "Sorry , you are not allowed to access this area");
            redirect("user/profile");
        }
    }

    function sendinvitationMail() {
        $this->load->library('email');
        
        $this->view = false;
        $emails = str_replace("\n", ",", $this->input->post("emails"));

        // Start sending Emails
        $config['protocol'] = 'sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        
        $this->email->initialize($config);
        $this->email->from('info@locname.com', 'LocName website');
        $this->email->bcc($emails);
        $this->email->subject('invite  Test');
        $this->email->message('Testing the email invitation.');
        $this->email->send();
        ///// End of sending
    }
    function locations() {
  
        $this->load->model("location_model", "locationModel");
        $this->data["headerTitle"] = "Locations";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Locations";
        $this->view = "user/locations";
        $this->data['id'] = $this->user->id;
        $this->data['locations']= $this->locationModel->count_by("user_id", $this->user->id);
    }

    
    function favorites() {
        $this->load->model("favourite_model", "favModel");
        $this->data["headerTitle"] = "Favorites";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Favorites";
        $this->view = "user/favorites";
         $this->data['id'] = $this->user->id;
        $this->data['locations']= $this->favModel->count_by("user_id", $this->user->id);
       

    }
    
    function friends() {
        
        $this->load->model("friends_model", "friendsModel");
        $this->data["headerTitle"] = "Friends";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Friends";
        $this->view = "user/friends";
        $this->data['id'] = $this->user->id;
        $this->data['friends']= $this->friendsModel->count_by("user1_id", $this->user->id)+$this->friendsModel->count_by("user2_id", $this->user->id);

       

    }
    
    

}

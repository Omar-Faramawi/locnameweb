<?php

/**
 * Description of Location
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class location extends User_Controller {

    public $allowed = true;
    public $locationTypes = array("general" => "General", "public" => "Public", "business" => "Business", "personal" => "Personal", "event" => "Event");

    function __construct() {
        parent::__construct();
        $this->load->helper("public"); // for email
        $this->load->model("location_model", "locationModel");
        $this->load->model("user_model", "userModel");
        $this->load->model("category_model", "categoryModel");
        $this->load->model("favourite_model", "favModel");
    }

    function index() {

    }

    function temporary(){
        $this->view = false;
        $this->layout = false;
        $post = array(
                "title" => $this->input->post("title"),
                "latitude" => $this->input->post("latitude"),
                "longitude" => $this->input->post("longitude"),
                "is_private" => $this->input->post("is_private"),
                "is_event" => $this->input->post("is_event"),
                "passcode" => $this->input->post("passcode"),
                "details" => $this->input->post("details"),
                "duration_from" => $this->input->post("duration_from"),
                "duration_to" => $this->input->post("duration_to"),
                "user_id" => $this->ion_auth->user()->row()->id,
                "category_id" => $this->input->post("category_id"),
                "type" => $this->input->post("type"),
                "mobile" => $this->input->post("mobile"),
                "address" => $this->input->post("address"),
                "email" => $this->input->post("email"),
                "website" => prep_url($this->input->post("website")),
                "short_code" => $short_code,
                "registered_from" => "W",
                "building_number" => $this->input->post("building_number"),
                "flat_number" => $this->input->post("flat_number")
            );

        //echo $title." ".$latitude." ".$longitude." ".$address;
        $this->session->set_userdata($post);
        //echo $this->session->userdata('title');
    }

    function create_from_session(){

        $this->view = false;
        $this->layout = false;
        //$this->load->library('form_validation'); //TODO php Validation
        $this->load->model("location_model");
        if ($this->location_model->valid_locname($this->session->userdata("title"))) {
            // generate short code for the new location
            do {
                //$short_code = gen_location_code(4);
                $short_code = gen_location_new_short_code();
                while(check_short_code($short_code) == "FALSE"){
                  $short_code = gen_location_new_short_code();
                }
		/*while(!preg_match("/[0-9]+/", $short_code) || !preg_match("/[a-z]+/", $short_code)
                || ($short_code[0] == chr(ord($short_code[1]) - 1) && $short_code[1] == chr(ord($short_code[2]) - 1) && $short_code[2] == chr(ord($short_code[3]) - 1))
                || ($short_code[0] == $short_code[1] || $short_code[1] == $short_code[2] || $short_code[2] == $short_code[3] || ($short_code[0] == $short_code[2] && $short_code[1] == $short_code[3])))
                    $short_code = gen_location_code(4);*/

                $where = "short_code` = '$short_code' OR `title` = '$short_code'";
                $result = $this->location_model->count_by($where);
            } while ($result);

            $post = array(
                "title" => $this->session->userdata("title"),
                "latitude" => $this->session->userdata("latitude"),
                "longitude" => $this->session->userdata("longitude"),
                "is_private" => $this->session->userdata("is_private"),
                "is_event" => $this->session->userdata("is_event"),
                "passcode" => $this->session->userdata("passcode"),
                "details" => $this->session->userdata("details"),
                "duration_from" => $this->session->userdata("duration_from"),
                "duration_to" => $this->session->userdata("duration_to"),
                "user_id" => $this->ion_auth->user()->row()->id,
                "category_id" => $this->session->userdata("category_id"),
                "type" => $this->session->userdata("type"),
                "mobile" => $this->session->userdata("mobile"),
                "address" => $this->session->userdata("address"),
                "email" => $this->session->userdata("email"),
                "website" => prep_url($this->session->userdata("website")),
                "short_code" => $short_code,
                "registered_from" => "W",
                "building_number" => $this->session->userdata("building_number"),
                "flat_number" => $this->session->userdata("flat_number")
            );

            // get country & city from google maps API
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $post['latitude'] . "," . $post['longitude'] . "&sensor=true";
            $data = @file_get_contents($url);
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
                        if (in_array("administrative_area_level_1", $address["types"])) {
                            $post['governorate'] = $address["long_name"];
                        }
                        if (in_array("administrative_area_level_2", $address["types"])) {
                            $post['area_level_2'] = $address["long_name"];
                        }
                        if (in_array("administrative_area_level_3", $address["types"])) {
                            $post['area_level_3'] = $address["long_name"];
                        }
                        if (in_array("route", $address["types"])) {
                            $post['street'] = $address["long_name"];
                        }
                        if (in_array("street_number", $address["types"])) {
                            $post['street_number'] = $address["long_name"];
                        }
                    }
                }
            }

            if (isset($_FILES["photo"]["name"])) {
                $img = $this->upload();
                //flashdata("error", $img["error"]); // TEMPORARY REMOVE THIS LINE
                $post["photo"] = $img["upload_data"]["file_name"];
            }

            $result = $this->location_model->insert($post);
            if ($result) {
                $mailData = array(
                    "title" => $this->session->userdata("title"),
                    "privacy" => ($this->session->userdata("is_private") == 1)? "Private (Passcode: " . $this->session->userdata("passcode") . ")" : "Public",
                    "address" => $this->session->userdata("address"),
                    "flat_number" => $this->session->userdata("flat_number"),
                    "building_number" => $this->session->userdata("building_number"),
                    "city" => $post['city'],
                    "country" => $post['country'],
                    "latitude" => $this->session->userdata("latitude"),
                    "longitude" => $this->session->userdata("longitude"),
                    "username" => $this->data["user"]->username
                );
                $otherData = array("TITLE" => $this->session->userdata("title"));
                send_email(1, $this->data["user"], $mailData, $otherData);

                $this->session->set_userdata("location_just_created", true);
                $redirectTo=$this->session->userdata('title')."?ref=NL";
                $post2 = array(
                    "title" => "",
                    "latitude" => "",
                    "longitude" => "",
                    "is_private" => "",
                    "is_event" => "",
                    "passcode" => "",
                    "details" => "",
                    "duration_from" => "",
                    "duration_to" =>"",
                    "category_id" => "",
                    "type" => "",
                    "mobile" => "",
                    "address" => "",
                    "email" => "",
                    "website" => "",
                    "short_code" => "",
                    "registered_from" => "",
                    "building_number" => "",
                    "flat_number" => ""
                );
            $this->session->unset_userdata($post2);
            redirect(site_url($redirectTo));
            } else {
                echo validation_errors();
            }
        } else {
            echo "Invalid LocName";
        }

    }

    function create() {
        $this->view = false;
        $this->layout = false;
        //$this->load->library('form_validation'); //TODO php Validation
        $this->load->model("location_model");
        if ($this->location_model->valid_locname($this->input->post("title"))) {
            // generate short code for the new location
            do {
                //$short_code = gen_location_code(4);
                $short_code = gen_location_new_short_code();
                while(check_short_code($short_code) == "FALSE"){
                  $short_code = gen_location_new_short_code();
                }
		/*while(!preg_match("/[0-9]+/", $short_code) || !preg_match("/[a-z]+/", $short_code)
                || ($short_code[0] == chr(ord($short_code[1]) - 1) && $short_code[1] == chr(ord($short_code[2]) - 1) && $short_code[2] == chr(ord($short_code[3]) - 1))
                || ($short_code[0] == $short_code[1] || $short_code[1] == $short_code[2] || $short_code[2] == $short_code[3] || ($short_code[0] == $short_code[2] && $short_code[1] == $short_code[3])))
                    $short_code = gen_location_code(4);*/

                $where = "short_code` = '$short_code' OR `title` = '$short_code'";
                $result = $this->location_model->count_by($where);
            } while ($result);

            $post = array(
                "title" =>strip_tags( $this->input->post("title")),
                "latitude" => strip_tags($this->input->post("latitude")),
                "longitude" =>strip_tags( $this->input->post("longitude")),
                "is_private" => strip_tags($this->input->post("is_private")),
                "is_event" => strip_tags($this->input->post("is_event")),
                "passcode" =>strip_tags( $this->input->post("passcode")),
                "details" =>strip_tags( $this->input->post("details")),
                "duration_from" => $this->input->post("duration_from"),
                "duration_to" => $this->input->post("duration_to"),
                "user_id" => $this->ion_auth->user()->row()->id,
                "category_id" => $this->input->post("category_id"),
                "type" => $this->input->post("type"),
                "mobile" => strip_tags($this->input->post("mobile")),
                "address" => strip_tags($this->input->post("address")),
                "email" => strip_tags($this->input->post("email")),
                "website" => prep_url($this->input->post("website")),
                "short_code" => $short_code,
                "registered_from" => "W",
                "building_number" => $this->input->post("building_number"),
                "flat_number" => $this->input->post("flat_number"),
                "postal_code" => $this->input->post("postal_code")
            );

            // get country & city from google maps API
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $post['latitude'] . "," . $post['longitude'] . "&sensor=true";
            $data = @file_get_contents($url);
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
                        if (in_array("administrative_area_level_1", $address["types"])) {
                            $post['governorate'] = $address["long_name"];
                        }
                        if (in_array("administrative_area_level_2", $address["types"])) {
                            $post['area_level_2'] = $address["long_name"];
                        }
                        if (in_array("administrative_area_level_3", $address["types"])) {
                            $post['area_level_3'] = $address["long_name"];
                        }
                        if (in_array("route", $address["types"])) {
                            $post['street'] = $address["long_name"];
                        }
                        if (in_array("street_number", $address["types"])) {
                            $post['street_number'] = $address["long_name"];
                        }
                        if (in_array("postal_code", $address["types"])) {
                            $post['postal_code'] = $address["long_name"];
                        }
                    }
                }
            }

            /*if (isset($_FILES["photo"]["name"])) {
                $img = $this->upload();
                //flashdata("error", $img["error"]); // TEMPORARY REMOVE THIS LINE
                $post["photo"] = $img["upload_data"]["file_name"];
            }*/


            $result = $this->location_model->insert($post);
            //$location_id = $this->location_model->insert_id();
            /** ** Start Upload  Photos **/

            if (isset($_FILES['photos'])) {
                if($_FILES['photos']['name'][0] != ""){

                $arrayOfPaths = array();
                $this->load->model('location_images_model', 'locImg');
                $count = count($_FILES['photos']['size']);
                foreach($_FILES as $key=>$value){
                    for($s=0; $s<=$count-1; $s++) {
                        $_FILES['photos']['name']=$value['name'][$s];
                        $_FILES['photos']['type']    = $value['type'][$s];
                        $_FILES['photos']['tmp_name'] = $value['tmp_name'][$s];
                        $_FILES['photos']['error']       = $value['error'][$s];
                        $_FILES['photos']['size']    = $value['size'][$s];

                        $config['upload_path'] = 'assets/uploads/location_gallery';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['file_name'] = $this->input->post("title")."_".$result.".".pathinfo($_FILES['photos']['name'], PATHINFO_EXTENSION);

                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('photos')){
                             $this->upload->display_errors();
                        }
                        $data = $this->upload->data();
                        $name_uploaded = $data['file_name'];
                        $path_uploaded = $data['file_path'];
                        $img = array(
                            'image_name' => $name_uploaded,
                            'location_id' => $result
                            );
                        $this->locImg->insert($img);
                        array_push($arrayOfPaths, $this->upload->upload_path . $this->upload->file_name);

                    }
                    }
                    foreach ($arrayOfPaths as $key) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $key;
                        $config['maintain_ratio'] = TRUE;
                        $config['overwrite'] = TRUE; // allow overwrite to replace image
                        $config['width'] = 800;
                        $config['height'] = 600;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                    }
                }
            }

            /** *********** End Upload Photos **/
            if ($result) {
                $mailData = array(
                    "title" => $this->input->post("title"),
                    "privacy" => ($this->input->post("is_private") == 1)? "Private (Passcode: " . $this->input->post("passcode") . ")" : "Public",
                    "address" => $this->input->post("address"),
                    "flat_number" => $this->input->post("flat_number"),
                    "building_number" => $this->input->post("building_number"),
                    "city" => $post['city'],
                    "country" => $post['country'],
                    "latitude" => $this->input->post("latitude"),
                    "longitude" => $this->input->post("longitude"),
                    "username" => $this->data["user"]->username
                );
                $otherData = array("TITLE" => $this->input->post("title"));
                send_email(1, $this->data["user"], $mailData, $otherData);

                $this->session->set_userdata("location_just_created", true);
                redirect(site_url($this->input->post("title")."?ref=NL"));
            } else {
                echo validation_errors();
            }
        } else {
            echo "Invalid LocName";
        }
    }

    function uploadDirectAvatar($location = false, $locationTitle = false){
      if(isset($_FILES['picture'])){
        $this->load->model('location_images_model', 'locImg');
        $config['upload_path'] = 'assets/uploads/location_gallery';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = $locationTitle."_".$location.".jpg";

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('picture')){
             $this->upload->display_errors();
        }
        $data = $this->upload->data();
        $name_uploaded = $data['file_name'];
        $path_uploaded = $data['file_path'];
        $img = array(
            'image_name' => $name_uploaded,
            'location_id' => $location
            );
        $this->locImg->insert($img);
        redirect($locationTitle);
      }
    }

    function upload() {
        //load the helper
        $this->load->helper('form');

        //Configure
        //set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
        $config['upload_path'] = 'assets/uploads/locations_images';

        // set the filter image types
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        //load the upload library
        $this->load->library('upload', $config);

        $data['upload_data'] = '';

        //if not successful, set the error message
        if (!$this->upload->do_upload('photo')) {
            $data['error'] = $this->upload->display_errors();
        } else { //else, set the success message
            $data['success'] = "Upload successful!";

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

    function view($location = false) {
        if ($location == FALSE) {
            show_404("location not found");
        }
        $this->data["location"] = $this->locationModel->with("meta")->with("category")->with("user")->get_by("title", urldecode($location));
        if (!$this->data["location"]) {
            $this->data["location"] = $this->locationModel->with("meta")->with("category")->with("user")->get_by("short_code", urldecode($location));
            if (!$this->data["location"]) {
                show_404("location not found");
            }
        }

        $this->data["site_title"] = "";
        $this->data["page_title"] = $this->data["location"]->title . "@LocName";

        $this->data["headerTitle"] = $this->data["location"]->title;

        $this->load->model("location_visits_model", "visitsModel");
        $this->load->model("friends_model","friendsModel");
        if ($this->ion_auth->logged_in()) {
            $this->data['friends']=  $this->friendsModel->get_friends_for_share($this->data["user"]->id);
        }else{
            $this->data['friends'] = "";
        }
        if ($this->ion_auth->logged_in()) {
            $this->visitsModel->insert(array("user_id" => $this->data["user"]->id, "location_id" => $this->data["location"]->id, "visited_from" => "W"));
        } else {
            $this->visitsModel->insert(array("location_id" => $this->data["location"]->id, "visited_from" => "W"));
        }

        $is_owner = @($this->data["user"]->id == $this->data["location"]->user_id);
        $this->data['my_location'] = $is_owner;

        if ($this->data["location"]->is_private != 0 && $is_owner == false) {

            $this->allowed = false;
            if ($this->data["location"]->is_private == 2) {
                $isFriend = $this->passAsFacebookFriend();
                if ($isFriend == false)
//                    show_error("sorry , this location is private for owner facebook friends");
                    $this->view = "location/facebook_locked";
                return;
            } elseif ($this->data["location"]->is_private == 1) {

                // Check if he passed the passcode and in locations  session
                $sessionLocations = (array) $this->session->userdata("allowed_locations");
                if (in_array($location, $sessionLocations)) {
                    $this->allowed = true;

//                  $this->data["passcode"] = $this->data["location"]->passcode;
                }

                if ($this->allowed == false) {
                    $this->data["passcode"] = $this->data["location"]->passcode;
                    // redirect("location/passcode?location=" . $location);
                }
            }
        }
        /// Create map view
        $this->load->library('googlemaps');
        $config['map_height'] = "500px";
        //$config['$map_width']='955px';
        $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
        $config['center'] = $latLang;
        $config['zoom'] = '15';
        $config['panoramioTag'] = 'sunset';
        $config['scrollwheel'] = false;

        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $latLang;
        $marker['draggable'] = false;
        // $marker['icon'] = base_url("assets/main/img/LocPin.png");
        $this->googlemaps->add_marker($marker);
        $this->data['map'] = $this->googlemaps->create_map();
        $this->data['metaDesc'] = ($this->data["location"]->details) ? $this->data["location"]->details : $this->data["location"]->address;
        //// Check  location map's image
        // if not found in our server  catch it to our server
        $mapImage = (FCPATH . "assets/uploads/locations/" . $this->data["location"]->title . ".png");
        if (!is_file($mapImage)) {
            $GooglePath = "http://maps.googleapis.com/maps/api/staticmap?center=" . $latLang . "&zoom=16&size=256x256&maptype=roadmap&markers=color:blue%7Clabel:S%7C" . $latLang . "&sensor=false";
            copy($GooglePath, $mapImage);
        }

        $this->data['metaImg'] = base_url("assets/uploads/locations/" . $this->data["location"]->title . ".png");
        $this->load->model('location_images_model', 'locImg');
            $this->data['gallery'] = $this->locImg->get_location_images($this->data['location']->id);
        // get Latest user's locations
        $this->data["sidebarLocations"] = $this->locationModel->limit(4)->get_many_by(array("user_id" => $this->data["location"]->user_id));
        //$this->data["reviews"]=$this->getreview($this->data["location"]->id);
        $this->load->model("review_model", "reviewModel");
        $this->data["reviews"] = $this->reviewModel->getReviews($this->data["location"]->id);
    }

    function update($loc = false) {
        $this->load->helper('form');
        $this->data["types"] = $this->locationTypes;

        if ($loc == false) {
            show_error("you have to specify location to update");
        }

        $this->data["location"] = $this->locationModel->get_by(array("title" => $loc, "user_id" => $this->data["user"]->id));

        if (!$this->ion_auth->logged_in()) {
            flashdata("error", "You have to login first");
            redirect("auth/login");
        }

        if ($this->data["location"]->user_id != $this->data["user"]->id) {
//             flashdata("error","you can");
            redirect("user/locations");
        }

        //$this->data["categories"] = $this->categoryModel->get_by(array("type" => $this->data["location"]->type));
       // echo $this->data["location"]->type;
        $this->data["categories"] = $this->categoryModel->order_by("title", "ASC")->dropdown("id", "title", array("type" => $this->data["location"]->type));
        //print_r($this->data['categories']);
        // Form Validation

        $this->load->library('form_validation');

        //$this->form_validation->set_rules('category', 'Category', 'required|greater_than[0');
        $this->form_validation->set_rules('type', 'Type', 'required|greater_than[0');
        $this->form_validation->set_rules('longitude', 'Coordinates', 'required');
        $this->form_validation->set_rules('latitude', 'Coordinates', 'required');
        $this->locationModel->skip_validation();

        /// Create map view
        $this->load->library('googlemaps');
        $config['map_height'] = "500px";
        //$config['$map_width']='955px';
        $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
        $config['center'] = $latLang;
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $latLang;
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updatelocationCoordinates(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $this->data['map'] = $this->googlemaps->create_map();
        $this->load->model('location_images_model', 'locImg');
        if ($this->form_validation->run() == TRUE) {
            $post = array(
                "location_id" => $this->data["location"]->id,
                "title" => $this->data["location"]->title,
                "latitude" => $this->input->post("latitude"),
                "longitude" => $this->input->post("longitude"),
                "is_private" => $this->input->post("is_private"),
                "is_event" => $this->input->post("is_event"),
                "passcode" => $this->input->post("passcode"),
                "details" => $this->input->post("details"),
                "duration_from" => $this->input->post("duration_from"),
                "duration_to" => $this->input->post("duration_to"),
                "user_id" => $this->data["user"]->id,
                "category_id" => $this->input->post("category"),
                "type" => $this->input->post("type"),
                "mobile" => $this->input->post("mobile"),
                "address" => $this->input->post("address"),
                "email" => $this->input->post("email"),
                "website" => $this->input->post("website"),
                "building_number" => $this->input->post("building_number"),
                "flat_number" => $this->input->post("flat_number"),
            );
            /** ** Start Upload  Photos **/
            if (isset($_FILES['photos'])) {
                if($_FILES['photos']['name'][0] != ""){

                $arrayOfPaths = array();
                $count = count($_FILES['photos']['size']);
                foreach($_FILES as $key=>$value){
                    for($s=0; $s<=$count-1; $s++) {
                        $_FILES['photos']['name']=$value['name'][$s];
                        $_FILES['photos']['type']    = $value['type'][$s];
                        $_FILES['photos']['tmp_name'] = $value['tmp_name'][$s];
                        $_FILES['photos']['error']       = $value['error'][$s];
                        $_FILES['photos']['size']    = $value['size'][$s];

                        $config['upload_path'] = 'assets/uploads/location_gallery';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['file_name'] = $this->data['location']->title."_".$this->data['location']->id.".".pathinfo($_FILES['photos']['name'], PATHINFO_EXTENSION);

                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('photos')){
                             $this->upload->display_errors();
                        }
                        $data = $this->upload->data();
                        $name_uploaded = $data['file_name'];
                        $path_uploaded = $data['file_path'];
                        $img = array(
                            'image_name' => $name_uploaded,
                            'location_id' => $this->data['location']->id
                            );
                        $this->locImg->insert($img);
                        array_push($arrayOfPaths, $this->upload->upload_path . $this->upload->file_name);

                    }
                    }
                    /*foreach ($arrayOfPaths as $key) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $key;
                        $config['maintain_ratio'] = TRUE;
                        $config['overwrite'] = TRUE; // allow overwrite to replace image
                        $config['width'] = 800;
                        $config['height'] = 600;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                    }*/
                }
            }
            /** *********** End Upload Photos **/
            $result = $this->locationModel->update($this->data["location"]->id, $post, true);

        }
        $this->data['gallery'] = $this->locImg->get_location_images($this->data['location']->id);
        $this->data["headerTitle"] = $this->data["location"]->title;
    }

    function passAsFacebookFriend() {

        if ($this->ion_auth->logged_in()) {

            $owner = $this->userModel->getUser($this->data["location"]->user_id);

            // check if this  current user is friend  with the owner
            if ($this->session->userdata("provider") == "Facebook" && $owner->provider == "Facebook") {
                $provider_uid = $this->userModel->getUser($this->data["location"]->user_id)->provider_uid;

                $this->load->library("facebook", array(
                    'appId' => '1376235535961215',
                    'secret' => '42055f0ce428faf9fb56e60f9690f7e5'));

                try {
                    $isFriend = $this->facebook->api("me/friends/" . $provider_uid);

                    if ($isFriend) {
                        $this->allowed = true;
                        return true;
                    }
                } catch (FacebookApiException $ex) {
                    die("ex");
                }
            }
        }
        return false;
    }

    function passcode() {

        $this->load->library("form_validation");

        $this->data["location"] = "PassCode for" . $this->input->get("location");

        //$this->form_validation->set_rules('passcode', 'Passcode', 'trim|required');
        if (($this->input->get("location") && $this->input->get("passcode"))) {
            $result = $this->locationModel->count_by(array(
                "title" => $this->input->get("location"),
                "passcode" => $this->input->get("passcode"),
                    // "is_active" => 1
                    )
            );

            // Add this location to allowed location for current session
            if ($result != 0) {

                $locations = $this->session->userdata("allowed_locations");
                //die(var_dump($locations));
                if (is_array($locations) && count($locations) > 0) {
                    if (!in_array($this->input->get("location"), $locations))
                        array_push($locations, $this->input->get("location"));
                } else {
                    $locations = array($this->input->get("location"));
                }

                $this->session->set_userdata("allowed_locations", $locations);
                redirect(site_url($this->input->get("location")));
            } else {
                message("error", "Invalid Passcode ");
                $this->session->set_flashdata("message", "invalid Passcode");
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                redirect(current_url() . "?location=" . $this->input->get("location"));
            }
        }
        redirect($this->input->get("location"));
    }

    function checkpass() {
        $this->layout = false;
        $this->view = false;
        echo $this->locationModel->count_by(array("title" => $this->input->post("title"), "passcode" => $this->input->post("passcode")));
    }

    function takeme($location = false) {
        if ($location == FALSE) {
            show_404("location not found");
        }

        $this->data["location"] = $this->locationModel->with("user")->get_by("title", urldecode($location));
        if (!$this->data["location"]) {
            show_404("location not found");
        }

        /// Create map view
        $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
        $currentLocation = $this->input->get("lat") . ',' . $this->input->get("long");
        $this->load->library('googlemaps');
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['map_height'] = "500px";
        $config['directions'] = true;
        $config['directionsStart'] = $currentLocation;
        $config['directionsEnd'] = $latLang;
        $config['directionsDivID'] = 'directionsDiv';
        $config['drawingDefaultMode'] = NULL;

        $marker = array();
        $marker['position'] = $latLang;
        $marker['zIndex'] = 100;
        //  $marker['icon'] = base_url("assets/main/img/LocPin.png");
        $this->googlemaps->add_marker($marker);

        $marker = array();
        $marker['position'] = $currentLocation;
        $marker['zIndex'] = 100;
        // $marker['icon'] = base_url("assets/main/img/LocPin.png");
        $this->googlemaps->add_marker($marker);

        $this->googlemaps->initialize($config);
        $this->data["headerTitle"] = "Take Me to " . $this->data["location"]->title;
        $this->data['map'] = $this->googlemaps->create_map();
        $this->view = "location/takeme";
    }

    function redirect() {
        $title = urlencode($this->input->get("title"));
        if (!$title) {
            redirect(site_url());
        } else {

            redirect(site_url(urldecode($title)));
        }
    }
    function embed($loc = false){
        $this->load->helper('form');

        if ($loc == false) {
            show_error("you have to specify location to update");
        }

        $this->data["location"] = $this->locationModel->get_by(array("title" => $loc));

        /*if (!$this->ion_auth->logged_in()) {
            flashdata("error", "You have to login first");
            redirect("auth/login");
        }*/

        /*if ($this->data["location"]->user_id != $this->data["user"]->id) {
//             flashdata("error","you can");
            redirect("user/locations");
        }*/

        $this->load->library('form_validation');

        //$this->form_validation->set_rules('category', 'Category', 'required|greater_than[0');
        $this->form_validation->set_rules('type', 'Type', 'required|greater_than[0');
        $this->form_validation->set_rules('longitude', 'Coordinates', 'required');
        $this->form_validation->set_rules('latitude', 'Coordinates', 'required');
        $this->locationModel->skip_validation();

        /// Create map view
        $this->load->library('googlemaps');
        $config['map_height'] = "500px";
        //$config['$map_width']='955px';
        $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
        $config['center'] = $latLang;
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $latLang;
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updatelocationCoordinates(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $this->data['map'] = $this->googlemaps->create_map();

        $this->data["headerTitle"] = $this->data["location"]->title;

    }

    function share($location = false, $type = "ROADMAP", $zoom = 13, $width = 400, $height = 600) {
        if ($location == FALSE) {
            show_404("location not found");
        }

        $this->data["location"] = $this->locationModel->with("category")->with("user")->get_by("title", urldecode($location));
        if (!$this->data["location"]) {
            show_404("location not found");
        }

        $this->data["site_title"] = "";
        $this->data["page_title"] = $this->data["location"]->title . "@LocName";

        /// Create map view
        $this->load->library('googlemaps');
        $config['map_height'] = $width;
        $config['map_width'] = $height;
        $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
        $config['center'] = $latLang;
        $config['zoom'] = $zoom;
        $config['map_type'] = $type;
        if ($this->input->get("action") == "takeme") {

            $latLang = $this->data["location"]->latitude . ',' . $this->data["location"]->longitude;
            $currentLocation = $this->input->get("lat") . ',' . $this->input->get("long");

            $config['directions'] = true;
            $config['directionsStart'] = $currentLocation;
            $config['directionsEnd'] = $latLang;
            //$config['directionsDivID'] = 'directionsDiv';

            $marker = array();
            $marker['position'] = $latLang;
            $marker['zIndex'] = 100;
            //$marker['icon'] = base_url("assets/main/img/LocPin.png");
            $this->googlemaps->add_marker($marker);

            $marker2 = array();
            $marker2['position'] = $currentLocation;
            $marker2['zIndex'] = 100;
            //$marker2['icon'] = base_url("assets/main/img/LocPin.png");
            $this->googlemaps->add_marker($marker2);
        }

        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $latLang;
        $marker['draggable'] = false;
        //$marker['icon'] = base_url("assets/main/img/LocPin.png");
        $this->googlemaps->add_marker($marker);
        $this->data['map'] = $this->googlemaps->create_map();
        $this->data['metaDesc'] = ($this->data["location"]->details) ? $this->data["location"]->details : $this->data["location"]->address;

        $this->data['metaImg'] = base_url("assets/uploads/locations/" . $this->data["location"]->title . ".png");

        if($this->session->userdata["user_id"]) {
            $this->load->model("favourite_model", "favModel");
            $this->data['isFavorite'] = $this->favModel->verify_favourite($this->session->userdata["user_id"], $this->data["location"]->id);
        }
        else {
            $this->data['isFavorite'] = false;
        }
        $this->layout = false;
    }

    function askverify($locationId = FALSE) {

        $this->view = false;
        if ($locationId != false && isset($this->data["user"]->id)) {

            $this->load->model("verify_model");
            $is_asked_before = $this->verify_model->count_by(array(
                "user_id" => $this->data["user"]->id,
                "location_id" => $locationId
            ));
            if ($is_asked_before == 0) {
                echo $this->verify_model->insert(array(
                    "user_id" => $this->data["user"]->id,
                    "location_id" => $locationId
                ));
                flashdata("success", "Verifing in progress");
                redirect("user/locations");
            }
        }
        flashdata("success", "Verifing in progress");
        redirect("user/locations");
    }

    function rate() {
        $this->layout = false;
        $this->view = false;
        $this->load->model("rating_model", "ratingModel");
        $userId = isset($this->data["user"]->id) ? $this->data["user"]->id : 0;
        $result = $this->ratingModel->insert(array(
            "user_id" => $userId,
            "location_id" => $this->input->post("locationID"),
            "rating" => $this->input->post("value")
        ));

        echo $result;
    }

       function review() {
        $this->layout = false;
        $this->view = false;
        $this->load->model("review_model", "reviewModel");
        $userId = isset($this->data["user"]->id) ? $this->data["user"]->id : 0;
        $result = $this->reviewModel->insert(array(
            "user_id" => $userId,
            "location_id" => $this->input->post("locationID"),
            "review" => $this->input->post("review")
        ));
        echo $result;

    }

    function getreview($locationid=88)
    {
        $this->load->model("review_model", "reviewModel");
        $result = $this->reviewModel->getReviews($locationid);
        return $result;
    }


    function delete_location($id = 0) {
        $result = $this->locationModel->delete_by(array("id" => $id, "user_id" => $this->data["user"]->id));
        if ($result) {
            flashdata("success", "Location has been deleted successfully");
            redirect("user/locations");
        } else {
            flashdata("error", "Location has not been deleted");
        }
    }
    function delete_image($id = 0){
        $this->load->model('location_images_model', 'locImg');
        $image = $this->locImg->get_by("id", $id);
        $location = $this->locationModel->get_location($image->location_id);
        $result = $this->locImg->delete_by(array('id' => $id));
        if ($result) {
            unlink('assets/uploads/location_gallery/'.$image->image_name);
            flashdata("success", "Image has been deleted successfully");
            redirect("location/update/".$location->title);
        } else {
            flashdata("error", "Image has not been deleted");
            redirect("location/update/".$location->title);
        }
    }
}

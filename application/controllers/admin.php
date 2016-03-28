<?php

/**
 * Description of  admin
 *   Main function  for  locname controll
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * Dashboard with analytics
     * and some graph sharts
     */

    function index() {
        $this->view = ("admin/crud");
    }

    // ************* GROCERY CRUD Replacement Functions **************** //
    function getCreationPlatform($value, $row) {
        switch($value) {
            case 'A':
                $value = "Android";
                break;
            case 'I':
                $value = "IOS";
                break;
            case 'W':
                $value = "WEB";
                break;
            case 'P':
                $value = "Partner";
                break;
        }
        return $value;
    }

    function getLocationURL($value, $row) {
        return "<a href='" . site_url() . $value . "'>" . $value . "</a>";
    }

    function getUserURL($value, $row) {
        return "<a href='" . site_url("admin/users/read") . "/" . $row->user_id . "'>" . $value . "</a>";
    }

    // ******************* END ****************** //

    /**
     * this function controll  CRUD of web site
     * @param type $table  tableName
     */
    function cp($type = "news") {

        $this->grocery_crud->set_theme("flexigrid");
        $this->grocery_crud->set_table($type)->set_subject($type);
        $this->grocery_crud->unset_add_fields("created_date");
        $this->grocery_crud->set_field_upload('image', 'assets/uploads');
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function location($first = "", $second = "") {
		if ($first !== "" && $second !== "") {
            $where_loc = "";

			$this->data["from_date"] = $first;
			$this->data["to_date"] = $second;

			$where_loc = "location`.created_at BETWEEN str_to_date('" . $first . "', '%m-%d-%Y') AND str_to_date('" . $second . " 23:59:59', '%m-%d-%Y %H:%i:%s')";

			$this->grocery_crud->where($where_loc);
		}
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("location")->set_subject("Location");
        $this->grocery_crud->set_model("locations_report_model");
        $this->grocery_crud->unset_texteditor('details', 'address');
        $this->grocery_crud->field_type('duration_from', 'date');
        $this->grocery_crud->field_type('duration_to', 'date');
        $this->grocery_crud->unset_add_fields("updated_at", "created_at");
        $this->grocery_crud->unset_edit_fields("updated_at", "created_at");
        $this->grocery_crud->columns("title", "short_code", "owner", "country", "city", "address", "creation_platform", "creation_date", "hits_from_web", "hits_from_mobile", "total_hits", "last_visited");
        $this->grocery_crud->callback_column('creation_platform', array($this, 'getCreationPlatform'));
        $this->grocery_crud->callback_column('title', array($this, 'getLocationURL'));
        $this->grocery_crud->callback_column('owner', array($this, 'getUserURL'));
        $this->grocery_crud->display_as("creation_platform", "Creation Platform");
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function category() {

        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("category")->set_subject("Category");
        $this->grocery_crud->set_relation('parent', 'category', 'title');
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function users($first = "", $second = "") {
        if ($first !== "" && $second !== "") {
            $where_loc = "";

            $this->data["from_date"] = $first;
            $this->data["to_date"] = $second;

            $where_loc = "users`.created_on BETWEEN unix_timestamp(str_to_date('" . $first . "', '%m-%d-%Y')) AND unix_timestamp(str_to_date('" . $second . " 23:59:59', '%m-%d-%Y %H:%i:%s'))";

            $this->grocery_crud->where($where_loc);
        }
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("users")->set_subject("User");
        $this->grocery_crud->set_model("users_report_model");
        $this->grocery_crud->unset_add_fields("ip_address", "activation_code", "forgotten_password_code", "forgotten_password_time", "remember_code", "last_login", "created_on");
        $this->grocery_crud->unset_edit_fields("ip_address", "activation_code", "forgotten_password_code", "forgotten_password_time", "remember_code", "lastLogin", "created_on");
        $this->grocery_crud->columns("first_name", "last_name", "email", "account_type", "country", "city_id", "creation_date", "creation_platform", "lastLogin", "number_of_locations", "number_of_friends");
        $this->grocery_crud->callback_column('creation_platform', array($this, 'getCreationPlatform'));
        $this->grocery_crud->set_relation('city_id', 'city', 'city');
        $this->grocery_crud->display_as("provider", "Account Type");
        $this->grocery_crud->display_as("city_id", "City");
        $this->grocery_crud->display_as("created_on", "Creation Date");
        $this->grocery_crud->display_as("creation_platform", "Creation Platform");
        $this->grocery_crud->callback_before_insert(array($this, 'encrypt_password_and_insert_callback'));
        $this->grocery_crud->callback_before_update(array($this, 'encrypt_password_and_insert_callback'));
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function encrypt_password_and_insert_callback($post_array) {
        $post_array['password'] = sha1($post_array["password"] . $post_array["salt"]);

        return $post_array;
    }

    /**
     * Reports
     */
    function report() {

        $this->load->model("country_model", "countryModel");
        $this->data["countries"] = $this->countryModel->get_all();

        $this->load->model("location_model", "locationModel");

        if (isset($_POST["submit"])) {
            $this->load->model("location_model", "LoctionModel");
            $where = array();
            if (strlen($_POST["country"]))
                $where["country"] = $this->input->post("country");

            if (strlen($_POST["privacy"]))
                $where["is_private"] = $this->input->post("privacy");

            if (strlen($_POST["type"]))
                $where["type"] = $this->input->post("type");

            if (isset($_POST["category"]) && strlen($_POST["category"]))
                $where["category_id"] = $this->input->post("category");

            if (strlen($_POST["username"]))
                $where["user_id"] = $this->input->post("username");

            $this->data["count"] = $this->locationModel->count_by($where);
        } else {
            $this->data["count"] = $this->locationModel->count_all();
        }
    }

    function users_locations_report() {

        $this->load->model("location_model", "locationModel");
        $this->load->model("user_model", "userModel");

		if (isset($_POST["from_date"]) && isset($_POST["to_date"])) {
            $where_loc = "";
			$where_user = "";

			$this->data["from_date"] = $this->input->post("from_date");
			$this->data["to_date"] = $this->input->post("to_date");

			$where_loc = "created_at` BETWEEN str_to_date('" . $this->input->post("from_date") . "', '%m/%d/%Y') AND str_to_date('" . $this->input->post("to_date") . " 23:59:59', '%m/%d/%Y %H:%i:%s')";
			$where_user = "created_on` BETWEEN unix_timestamp(str_to_date('" . $this->input->post("from_date") . "', '%m/%d/%Y')) AND unix_timestamp(str_to_date('" . $this->input->post("to_date") . " 23:59:59', '%m/%d/%Y %H:%i:%s'))";

			$this->data["location_count"] = $this->locationModel->count_by($where_loc);
			$this->data["user_count"] = $this->userModel->count_by($where_user);
        } else {
			$this->data["location_count"] = $this->locationModel->count_all();
			$this->data["user_count"] = $this->userModel->count_all();
		}
    }

    function verify() {
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("verify")->set_subject("Verfication");
        $this->grocery_crud->set_relation('location_id', 'location', 'title');
                $this->grocery_crud->set_relation('user_id', 'users', 'username');

        $this->grocery_crud->unset_edit_fields("created_at", "updated_at");

        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function location_meta() {
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("location_meta")->set_subject("Meta");
        $this->grocery_crud->set_relation('location_id', 'location', 'title');
        $this->grocery_crud->unset_edit_fields("created_at", "updated_at");
        $this->grocery_crud->set_field_upload('logo', 'assets/uploads/locations_meta_images');
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function contact_messages() {
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("contact")->set_subject("Contact Message");
        $this->grocery_crud->unset_add_fields("is_readed", "created_at");
        $this->grocery_crud->unset_edit_fields("is_readed", "created_at");
        $this->grocery_crud->order_by("created_at", "desc");
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    function testimonials() {
        $this->grocery_crud->set_theme("datatables");
        $this->grocery_crud->set_table("testimonial")->set_subject("Testimonial");
        $this->grocery_crud->order_by("date", "desc");
        $this->grocery_crud->set_field_upload("photo", "assets/images/testimonials");
        $output = $this->grocery_crud->render();
        $this->data["output"] = $output->output;
        $this->data["js_files"] = $output->js_files;
        $this->data["css_files"] = $output->css_files;
        $this->view = ("admin/crud");
    }

    // ---------------------  Bulk Upload  --------------------------------
    function bulk() {
        if (isset($_POST["create"])) {

             $contents= file_get_contents($_FILES['file']['tmp_name']);


            include FCPATH . 'application/libraries/Csvreader.php';
            $reader = new Csvreader();
//            $rows = $reader->parse_file(FCPATH . "assets/uploads/bulk.csv");
            $rows = $reader->parse_file($_FILES['file']['tmp_name']);
            $notInserted = array();
            $this->view = false ;
            foreach ($rows as $row) {
//                dd($row);
                if (! $this->checkLocationTitle($row["title"])) {
                    $row["user_id"] = $this->getUser($row["Owner"]);
                    $row["category_id"] = $this->getCategoryID($row["category"]);
                    $row["type"] = $this->locationType($row["type"]);
                    unset($row["Owner"]);
                    unset($row["category"]);
                     $insert = $this->locationModel->insert($row);

                } else {
                     dd("xx");
                    $notInserted[] = $row["title"];
                }
            }
        }
    }

    function getUser($username = false) {
        $this->load->model("user_model", "userModel");
        $user = $this->userModel->get_by(array("username" => $username));
        if ($user)
            return $user->id;
        else
            return false;
    }

    function getCategoryID($title) {
        $this->load->model("category_model", "categoryModel");
        $category = $this->categoryModel->get_by(array("title" => $title));


        if ($category)
            return $category->id;
        else
            return "0";
    }

    function checkLocationTitle($title = "locname") {

        $this->load->model("location_model", "locationModel");
        return $this->locationModel->count_by(array("title" => $title));
    }

    function locationType($type) {
        if($type == "public")
            return "0";
        elseif($type == "passcode")
            return "1";
        elseif($type == "facebook")
            return "2";
        else
            return "0";
    }

//   ===========================  End Bulk Upload  ===========================

    function locationReports() {
//        error_reporting(0);
        $lastWeek = time() - (7 * 24 * 60 * 60);
        $lastWeek = date('Y-m-d H:i:s', $lastWeek);

        $this->load->model("user_model", "userModel");
        $this->load->model("location_visits_model", "visitsModel");
        $users = $this->userModel->with("locations")->get_all();
//        $sendMail = false;
        foreach ($users as $user) {
            $sendMail = false;
            if (count($user->locations)) {
                foreach ($user->locations as $loc) {
                    $report[$loc->title]["visitors"] = $this->visitsModel->with("users")->with("location")->get_many_by(array("location_id" => $loc->id, "created_at >= " => $lastWeek));
                    $report[$loc->title]["count"] = count($report[$loc->title]["visitors"]);
                    if ($report[$loc->title]["count"]) {
                        $sendMail = true;
                    } else {
                        unset($report[$loc->title]);
                    }
                }
				//echo $user->email;
				//print_r($report);
                if ($sendMail && isset($report) && $user->email == "locname.test@yahoo.com") {
//                    dd($report);
                    $message = $this->load->view("location/email/weeklyReport_mail.tpl.php", array("report" => $report), true);
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                    $this->email->to($user->email);
                    $this->email->subject('LocName - Locations Weekly Report');
                    $this->email->message($message);
                    $this->email->send();
                    //echo $this->email->print_debugger();
                    //die();
                }
            }
        }
        $this->data["output"] = "DONE!! All reports have been sent...";
        $this->view = ("admin/crud");
        //dd("Done .. All Reports Sent ");
    }

    function update_mailchimp_list($users, $list_id, $batch = FALSE) {
        $this->load->library('mailchimp');

        $batch_users = array();
        if($batch) {
            $batch_users = $users;
        } else {
            foreach($users as $user) {
                $batch_users[] = array(
                    'email'             => array('email'=>$user->email),
                    'merge_vars'        => array('FNAME'=>$user->first_name, 'LNAME'=>$user->last_name),
                );
            }
        }

        $params = array(
            'id'                => $list_id,
            'batch'             => $batch_users,
            'double_optin'      => false,
            'update_existing'   => true,
            'replace_interests' => false,
            'send_welcome'      => false
        );

        $result = $this->mailchimp->call('lists/batch-subscribe', $params);
    }

    function update_mailchimp() {
        $this->load->model('user_model');
        $this->load->model('user_friend_model');

        // all current users
        $users = $this->user_model->get_all();
        $this->update_mailchimp_list($users, '7d63c829a2');

        // current facebook users
        $users = $this->user_model->getFacebookUsers();
        $this->update_mailchimp_list($users, 'af173f1cf8');

        // current email users
        $users = $this->user_model->getEmailUsers();
        $this->update_mailchimp_list($users, '9f67681f77');

        // new facebook users
        $users = $this->user_friend_model->getNewFacebookUsers();
        $batch_users = array();
        foreach($users as $user) {
            $batch_users[] = array(
                'email'             => array('email'=>$user->provider_uid . "@facebook.com"),
                'merge_vars'        => array('FB_UID'=>$user->provider_uid, 'NAME'=>$user->name),
            );
        }
        $this->update_mailchimp_list($batch_users, 'aa2ead2f16', TRUE);

        // new email users
        $users = $this->user_friend_model->getNewEmailUsers();
        $this->update_mailchimp_list($users, '60e03dcdaf');

        $this->data["output"] = "DONE!! MailChimp List has been updated...";
        $this->view = "admin/crud";
    }

    function ret_no_locations() {
        $where_loc = "users`.id <> 0 AND NOT EXISTS (SELECT * FROM `location` WHERE `location`.user_id = `users`.id)";
        $this->grocery_crud->where($where_loc);
        $this->users();
    }

    function ret_no_visits() {
        $where_loc = "location`.id <> 0 AND NOT EXISTS (SELECT * FROM `location_visits` WHERE `location_visits`.location_id = `location`.id)";
        $this->grocery_crud->where($where_loc);
        $this->location();
    }

    function ret_loc_became_inactive() {
        $where_loc = "location`.id <> 0 AND EXISTS (SELECT `location_visits`.location_id, MAX(created_at) FROM `location_visits` WHERE `location_visits`.location_id = `location`.id GROUP BY `location_visits`.location_id HAVING TO_DAYS(NOW())-TO_DAYS(MAX(created_at)) > 30)";
        $this->grocery_crud->where($where_loc);
        $this->location();
    }

    function ret_app_became_inactive() {
        $where_loc = "users`.id <> 0 AND TO_DAYS(NOW())-TO_DAYS(FROM_UNIXTIME(last_login)) > 30";
        $this->grocery_crud->where($where_loc);
        $this->users();
    }

    function ret_settings() {
        $this->config->load('retention_settings', TRUE);
        //$this->config->set_item('INACTIVE_PERIOD', 30);
        //$inactive_period = $this->config->item('INACTIVE_PERIOD');
        //$where_loc = "location`.id <> 0 AND EXISTS (SELECT `location_visits`.location_id, MAX(created_at) FROM `location_visits` WHERE `location_visits`.location_id = `location`.id GROUP BY `location_visits`.location_id HAVING TO_DAYS(NOW())-TO_DAYS(MAX(created_at)) > $inactive_period)";
        //$this->grocery_crud->where($where_loc);
        //$this->location();
    }
}

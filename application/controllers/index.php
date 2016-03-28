<?php

/**
 * Description of auth
 *
 * @author Amr Soliman
 * @email <info@mezatech.com>
 */
class Index extends User_Controller {

    function __construct() {
        parent::__construct();
    }

    function main($id="",$email="") {
        $email=$this->input->get('email',true);
        $this->data["headerTitle"] = "Home Page";
        $this->load->model("country_model", "countryModel");
        $this->data["countries"] = $this->countryModel->get_all();
        $this->data["current_country"] = $this->countryModel->getBySymbol($this->input->server("HTTP_CF_IPCOUNTRY"));
        $this->data["headerTitle"] = "Register New LocName";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Register New LocName";
        $this->load->model('temp_location_model','tempLocationModel');
        $location=$this->tempLocationModel->getLocation($id,$email);
        $this->data['templocation']=$location;
    }

    function testing_post() {
        $this->load->library('google');
        echo $this->google->getLibraryVersion();
    }

    function index() {
        $this->data["showSearchHeader"] = false;
        $this->load->model("location_model", "locationModel");
        //$this->data["recentLocations"]= $this->locationModel->with("user")->with("category")->limit(12)->get_many_by();
        $this->db->where("temporary", "0");
        $where="location.user_id in (select user_id from users_groups where users_groups.group_id =2)";
        $this->data["recentLocations"] = $this->locationModel->with("user")->with("category")->order_by("created_at", "DESC")->limit(12)->get_many_by($where);
        $this->load->model("country_model", "countryModel");
        $this->data["countries"] = $this->countryModel->get_all();
        $this->data["current_country"] = $this->countryModel->getBySymbol($this->input->server("HTTP_CF_IPCOUNTRY"));
        $this->load->model("testimonial_model", "testimonialModel");
        $this->data["testimonials"] = $this->testimonialModel->getAllTestimonials();
        //$this->load->librar(array('form_validation','session'));
        $this->load->helper(array('captcha','form','url'));
        $vals = array(
            'img_path' => 'assets/captcha/',
            'img_url' => site_url().'assets/captcha/',
            'font_path' => 'assets/texb.ttf',
            'img_width' => '150',
            'img_height' => 50,
            'expiration' => 7200
            );

        $captcha = create_captcha($vals);
        //echo $captcha['image'];
        //die();
        $this->session->set_userdata('captchaWord', $captcha['word']);

        $this->data['image'] = $captcha['image'];
    }

    function page($slug = "terms") {

        $this->load->model("page_model", "pageModel");
        $this->data["page"] = $this->pageModel->get_by(array("slug" => $slug));
        if (!$this->data["page"])
            show_404();
        else {
            $this->data["headerTitle"] = $this->data["page"]->title;
            $this->data["site_title"] = "";
            $this->data["page_title"] = $this->data["page"]->title;
        }
    }

    function about() {
        $this->data["headerTitle"] = "About us";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "About us";
    }
    /*function update_short_code(){
      $this->load->helper('public');
      $this->load->model('location_model','locationModel');
      $location = $this->locationModel->getAllLocations();
      foreach($location as $key){
        echo $key->id."- ".$key->short_code." - ".strlen($key->short_code)."<br>";
        if(strlen($key->short_code) == 4){
          do {
              $short_code = gen_location_new_short_code();
              while(check_short_code($short_code) == "FALSE"){
                $short_code = gen_location_new_short_code();
              }
              $where = "short_code` = '$short_code' OR `title` = '$short_code'";
              $result = $this->locationModel->count_by($where);
          } while ($result);
          $this->locationModel->update_location_short_code($key->id, $short_code);
        }
      }
    }*/
    function api() {
        $this->data["headerTitle"] = "API";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "API";
    }

    function blog() {
        $this->data["headerTitle"] = "Blog";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Blog";
    }

    function apidemo() {
        $this->data["headerTitle"] = "API Demo";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "API Demo";
    }

    function partner() {
        $this->data["headerTitle"] = "Partner";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Partner";
    }

    function terms() {
        $this->data["headerTitle"] = "Our Terms";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Our Terms";
    }

    function privacy() {
        $this->data["headerTitle"] = "Privacy Policy";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Privacy Policy";
    }

    function contact() {
        $this->data["headerTitle"] = "Contact us";
        $this->data["site_title"] = "";
        $this->data["page_title"] = "Contact us";
        if (isset($_POST["send"])) {
            // send the message to the email "info@locname.com"
            $mailData["name"] = $this->input->post("name");
            $mailData["email"] = $this->input->post("email");
            $mailData["message"] = str_replace("\n", "<br/>", $this->input->post("message"));
            if(isset($_POST['feedback-cat'])){
                $mailData['category'] = $this->input->post("feedback-cat");
            }else{
                $mailData['category'] = "category";
            }
            $message = $this->load->view("auth/email/contact.tpl.php", $mailData, true);
            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($this->config->item('admin_email', 'ion_auth'));
            $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - Contact Message from ' . $this->input->post("name"));
            $this->email->message($message);
            $this->email->send();

            // add the message to the database
            $this->load->model("contact_model");
            $result = $this->contact_model->insert(array(
                "name" => $this->input->post("name"),
                "email" => $this->input->post("email"),
                "message" => $this->input->post("message"),
                "type" => $mailData['category']
            ));

            if ($result) {
                $this->session->set_flashdata("success", "Thanks, Your message has been sent successfully. We will contact you soon.");
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
    }

    function feedback() {
        $this->load->library(array('form_validation','session'));
        $this->load->helper(array('captcha','form','url'));

            $this->form_validation->set_rules('captcha', 'Captcha', 'required');

            $userCaptcha = $this->input->post('captcha');
            $word = $this->session->userdata('captchaWord');

            if ($this->form_validation->run() == TRUE &&
                strcmp(strtoupper($userCaptcha), strtoupper($word)) == 0)
            {
                $mailData["name"] = $this->input->post("name");
                $mailData["email"] = $this->input->post("email");

                $mailData["message"] = str_replace("\n", "<br/>", $this->input->post("message"));
                if(isset($_POST['feedback-cat'])){
                    $mailData['category'] = $this->input->post("feedback-cat");
                }else{
                    $mailData['category'] = "category";
                }
                $message = $this->load->view("auth/email/contact.tpl.php", $mailData, true);
                $this->email->clear();
                $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
                $this->email->to($this->config->item('admin_email', 'ion_auth'));
                $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - Contact Message from ' . $this->input->post("name"));
                $this->email->message($message);
                $this->email->send();

                // add the message to the database
                $this->load->model("contact_model");
                $result = $this->contact_model->insert(array(
                    "name" => $this->input->post("name"),
                    "email" => $this->input->post("email"),
                    "message" => $this->input->post("message"),
                    "type" => $mailData['category']
                ));

               if ($result) {
                    $this->session->set_flashdata("success2", "Thanks, Your message has been sent successfully. We will contact you soon.");
                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                }else{
                    $this->session->set_flashdata("success2", validation_errors());
                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                }
            }else{
                $this->session->set_flashdata("success2", "Wrong Captcha");
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
    }

    function close() {
        $this->layout = false;
    }

}

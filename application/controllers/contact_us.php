<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends Public_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/contact_us_page_model");
        $this->lang->load("contact_us_page", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        $this->view();
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view()
    {


        $contact_us_page_id = 1;
        $this->data["contact_us_page"] = $contact_us_page = $this->contact_us_page_model->get_contact_us_page($contact_us_page_id);
        $this->data['pageTitle'] = $contact_us_page[0]->contact_us_page_title;
        $this->data['pageDescription'] = $contact_us_page[0]->contact_us_page_description;
        $this->data['pageKeywords'] = $contact_us_page[0]->contact_us_page_keyword;
        $this->data["title"] = $this->lang->line("Contact Us Page");
        $this->data["view"] = PUBLIC_DIR . "contact_us_page/contact_us_page";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_contact_us_page($contact_us_page_id)
    {

        $contact_us_page_id = (int) $contact_us_page_id;

        $this->data["contact_us_page"] = $this->contact_us_page_model->get_contact_us_page($contact_us_page_id);
        $this->data["title"] = "Contact Us Page Details";
        $this->data["view"] = PUBLIC_DIR . "contact_us_page/view_contact_us_page";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    public function send_email(){
        $validation_config = array(

            array(
                "field"  =>  "name",
                "label"  =>  "Name",
                "rules"  =>  "trim|required"
            ),
            array(
                "field"  =>  "email",
                "label"  =>  "Email",
                "rules"  =>  "trim|required|valid_email"
            ),
            array(
                "field"  =>  "message",
                "label"  =>  "message",
                "rules"  =>  "trim|required"
            ),
            array(
                "field"  =>  "phone",
                "label"  =>  "Phone",
                "rules"  =>  "trim|required"
            ),

            array(
                "field"  =>  "valuecaptchaCode",
                "label"  =>  "Captcha Code",
                "rules"  =>  "trim|required"
            ),

        );

        $this->load->database();

        //set and run the validation
        $this->form_validation->set_rules($validation_config);

        if ($this->form_validation->run() === TRUE) {
            $inputs = array();

            $input['name'] = $this->input->post('name');
            $input['email'] = $this->input->post('email');
            $input['phone'] = $this->input->post('phone');
            $input['message'] = 
            $formCaptcha = $this->input->post('valuecaptchaCode');
            $sessCaptcha = $this->session->userdata('valuecaptchaCode');
            if($sessCaptcha==$formCaptcha){
                $to      = 'info@darewro.com';
                $subject = $this->input->post('subject');
                $message = $this->input->post('message');
                $message .= "<br />Name: ".$this->input->post('name')."<br />";
                $message .= "Contact No: ".$this->input->post('phone')."<br />";
                $message .= "Email Address: ".$this->input->post('email')."<br />";
                $headers = 'From: '.$this->input->post('email'). "\r\n" .
                    'Reply-To: '.$this->input->post('email') . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                if(mail($to, $subject, $message, $headers)){
                    echo '<div class="alert alert-success" role="alert">';
                    echo "Thank you for getting in touch!";
                    echo '</div>';
                }else{
                    echo '<div class="alert alert-danger" role="alert">';
                    echo "Error while sending mail. try again later.";
                    echo '</div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">';
                echo "Captcha code is not correct. try again with valid catcha code.";
                echo '</div>';
            }


           
        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo validation_errors();
            echo '</div>';
        }
    }
    //-----------------------------------------------------

}

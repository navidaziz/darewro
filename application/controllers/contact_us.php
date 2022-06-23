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

}

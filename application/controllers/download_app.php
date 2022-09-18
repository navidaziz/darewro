<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Download_app extends Public_Controller
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


        $this->data["about_us"] = "Download Mobile App";
        $this->data['pageTitle'] = "Download Mobile App";
        $this->data['pageDescription'] = "Darewro has a feature rich app which offers an extensive range of services, being the best Delivery Service in Peshawar, we believe in taking ownership of our customers needs, wants and future requirements.";
        $this->data['pageKeywords'] = 'darewro android app, mobile app, darewro mobile app, darewro ios app';
        $this->data["title"] = "Download Mobile App";
        $this->data["view"] = PUBLIC_DIR . "download_app/download_app";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends Public_Controller
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
        $query = "select * from about_us WHERE about_us_page_id = 1";
        $about_us = $this->db->query($query)->row();

        $this->data["about_us"] = $about_us;
        $this->data['pageTitle'] = $about_us->about_us_page_title;
        $this->data['pageDescription'] = $about_us->about_us_page_description;
        $this->data['pageKeywords'] = $about_us->about_us_page_keyword;
        $this->data["title"] = "About Us";
        $this->data["view"] = PUBLIC_DIR . "about_us/about_us";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
}

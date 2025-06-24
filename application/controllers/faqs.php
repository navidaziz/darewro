<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faqs extends Public_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/post_model");
        $this->lang->load("services", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);


    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {

        $this->data['pageTitle'] = "FAQs";
        $this->data['pageDescription'] = "Blog About";
        $keywords = '';
        $this->data["title"] = "FAQs";
        $this->data["view"] = PUBLIC_DIR . "faqs/faqs";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //---------------------------------------------------------------



    /**
     * get a list of all items that are not trashed
     */
    public function view($post_id)
    {
        $post_id = (int) $post_id;
        $where = "`status` IN (1) and post_id = '" . $post_id . "' ORDER BY `order`";
        $post =  $this->post_model->get_post_list($where, FALSE);

        $this->data['pageTitle'] = $post[0]->post_title;
        $this->data['pageDescription'] = $post[0]->post_summary;
        $this->data['pageKeywords'] = rtrim($post[0]->post_keywords, ',');
        //var_dump($post[0]);
        $this->data["post"] = $post[0];
        $where = "`status` IN (1) and post_id != '" . $post_id . "' ORDER BY  post_id DESC LIMIT 10";
        $this->data["posts"] =  $this->post_model->get_post_list($where, FALSE);

        $this->data["title"] = "Blogs";
        $this->data["view"] = PUBLIC_DIR . "posts/post_view";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_service($service_id)
    {

        $this->data['service_id'] =  $service_id = (int) $service_id;
        //get all service for side navigation list 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["services"] = $this->service_model->get_service_list($where, FALSE);

        $this->data["service"] = $service = $this->service_model->get_service($service_id)[0];

        $this->data["title"] = $service->service_title;
        $this->data["view"] = PUBLIC_DIR . "services/view_service";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

}

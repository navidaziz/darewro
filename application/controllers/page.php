<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Public_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/page_model");
        $this->lang->load("pages", 'english');
        $this->load->model("admin/page_content_model");
        $this->lang->load("page_contents", 'english');
        $this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);


    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {

        $mobile_number = '03244424414';
        $masking = 'DareWro';
        $user_name = '03043883037';
        $password = '123.123';
        $message = 'test message from Jazz';
        $url = "http://119.160.92.2:7700/sendsms_url.html?Username=" . $user_name . "&Password=" . $password .
            "&From=" . urlencode($masking) . "&To=" . $mobile_number . "&Message=" . urlencode($message);

        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_PORT, 7700);
        curl_exec($conn);
        echo curl_error($conn);
    }


    public function view_page($page_id)
    {

        $page_id = (int) $page_id;
        $query = "SELECT * FROM pages where page_id = '" . $page_id . "' and status='1'";

        $this->data["pages"] = $page = $this->db->query($query)->result();
        //$this->data["pages"] = $page = $this->page_model->get_page($page_id);

        if ($this->data["pages"]) {
            $this->data['pageTitle'] = $page[0]->page_title;
            $this->data['pageDescription'] = $page[0]->page_description;
            $this->data['pageKeywords'] = $page[0]->page_keywords;

            $where = "`page_contents`.`status` IN (1) AND `page_contents`.`page_id` = $page_id ORDER BY `order`";
            $this->data["page_contents"] = $this->page_content_model->get_page_content_list($where, FALSE, FALSE);

            $this->data["title"] = $page[0]->page_title;
            $this->data["view"] = PUBLIC_DIR . "pages/view_page";
            $this->load->view(PUBLIC_DIR . "layout", $this->data);
        } else {
            $this->data['pageTitle'] = "";
            $this->data['pageDescription'] = "";
            $this->data['pageKeywords'] = "";
            $this->data["view"] = PUBLIC_DIR . "pages/error_404";
            $this->load->view(PUBLIC_DIR . "layout", $this->data);
        }
    }

    public function view_page_content($page_content_id)
    {

        $page_content_id = (int) $page_content_id;

        $this->data["page_contents"] = $this->page_content_model->get_page_content($page_content_id);
        $this->data["title"] = "Page Contents Details";
        $this->data["view"] = PUBLIC_DIR . "pages/view_page_content";
        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    //-----------------------------------------------------

}

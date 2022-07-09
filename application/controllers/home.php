<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();


        //$this->output->enable_profiler(TRUE);


    }

    public function sms()
    {
        $this->sms_jazz('03244424414', 'hi');
    }

    public function info()
    {

        if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
            echo 'you dont have';
        } else {
            echo 'you have!';
        }
    }





    //---------------------------------------------------------------
    public function test_c_job()
    {

        $query = "UPDATE `orders` SET `orders`.`order_status`=4 WHERE DATE_ADD(`delivery_time`, INTERVAL 40 MINUTE) < NOW() AND `orders`.`order_status`=3 AND `delivery_time`!='1970-01-01 05:00:00'";
        $query_result = $this->db->query($query);
    }

    /**
     * Default action to be called
     */
    public function index()
    {

        $where = "`restaurants`.`status` IN (1) ORDER BY `restaurants`.`order`";
        $this->data["restaurants"] = $this->restaurants_model->get_restaurants_list($where, false);

        //get home page content....
        $this->data["home_page"] = $home_page = $this->home_page_model->get_home_page(1);

        $this->data['pageTitle'] = $home_page[0]->home_page_title;
        $this->data['pageDescription'] = $home_page[0]->home_page_description;
        $this->data['pageKeywords'] = $home_page[0]->home_page_keyword;

        //get slider banners 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["slider_banners"] = $this->slider_banner_model->get_slider_banner_list($where, FALSE);

        //get testimonials 

        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["testimonials"] = $this->testimonial_model->get_testimonial_list($where, FALSE);

        //get services 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["services"] =  $this->service_model->get_service_list($where, FALSE);

        //why choose us 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["why_choose_us"] = $this->why_choose_us_model->get_why_choose_us_list($where, FALSE);

        //get gallery 
        $where = "`status` IN (1) ";
        $this->data["albums"] = $this->gallery_model->get_gallery_list($where, FALSE);

        $this->data["title"] = "Home Page";
        $this->data["view"] = PUBLIC_DIR . "home/home_page";


        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
    public function index2()
    {

        $where = "`restaurants`.`status` IN (1) ORDER BY `restaurants`.`order`";
        $this->data["restaurants"] = $this->restaurants_model->get_restaurants_list($where, false);

        //get home page content....
        $this->data["home_page"] = $home_page = $this->home_page_model->get_home_page(1);

        $this->data['pageTitle'] = $home_page[0]->home_page_title;
        $this->data['pageDescription'] = $home_page[0]->home_page_description;
        $this->data['pageKeywords'] = $home_page[0]->home_page_keyword;

        //get slider banners 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["slider_banners"] = $this->slider_banner_model->get_slider_banner_list($where, FALSE);

        //get testimonials 

        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["testimonials"] = $this->testimonial_model->get_testimonial_list($where, FALSE);

        //get services 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["services"] =  $this->service_model->get_service_list($where, FALSE);

        //why choose us 
        $where = "`status` IN (1) ORDER BY `order`";
        $this->data["why_choose_us"] = $this->why_choose_us_model->get_why_choose_us_list($where, FALSE);

        //get gallery 
        $where = "`status` IN (1) ";
        $this->data["albums"] = $this->gallery_model->get_gallery_list($where, FALSE);

        $this->data["title"] = "Home Page";
        $this->data["view"] = PUBLIC_DIR . "home/home_page_2";


        $this->load->view(PUBLIC_DIR . "layout", $this->data);
    }
}

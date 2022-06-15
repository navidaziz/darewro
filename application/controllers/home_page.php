<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Home_page extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/home_page_model");
		$this->lang->load("home_page", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
		
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->home_page_model->get_home_page_list($where,TRUE, TRUE);
		 $this->data["home_page"] = $data->home_page;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Home Page";
         $this->data["view"] = PUBLIC_DIR."home_page/home_page";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_home_page($home_page_id){
        
        $home_page_id = (int) $home_page_id;
        
        $this->data["home_page"] = $this->home_page_model->get_home_page($home_page_id);
        $this->data["title"] = "Home Page Details";
        $this->data["view"] = PUBLIC_DIR."home_page/view_home_page";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        

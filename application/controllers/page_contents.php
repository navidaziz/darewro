<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Page_contents extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/page_content_model");
		$this->lang->load("page_contents", 'english');
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
		
        $where = "`status` IN (1) ORDER BY `order`";
		$data = $this->page_content_model->get_page_content_list($where,TRUE, TRUE);
		 $this->data["page_contents"] = $data->page_contents;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Page Contents";
         $this->data["view"] = PUBLIC_DIR."page_contents/page_contents";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_page_content($page_content_id){
        
        $page_content_id = (int) $page_content_id;
        
        $this->data["page_contents"] = $this->page_content_model->get_page_content($page_content_id);
        $this->data["title"] = "Page Contents Details";
        $this->data["view"] = PUBLIC_DIR."page_contents/view_page_content";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        

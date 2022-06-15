<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Service extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/service_model");
		$this->lang->load("services", 'english');
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
		$this->data["services"] = $this->service_model->get_service_list($where,FALSE);
		
		 $this->data["title"] = $this->lang->line("Services");
         $this->data["view"] = PUBLIC_DIR."services/services";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_service($service_id){
        
        $this->data['service_id'] =  $service_id = (int) $service_id;
        //get all service for side navigation list 
		$where = "`status` IN (1) ORDER BY `order`";
		$this->data["services"] = $this->service_model->get_service_list($where,FALSE);
		
        $this->data["service"]= $service = $this->service_model->get_service($service_id)[0];
		
        $this->data["title"] = $service->service_title;
        $this->data["view"] = PUBLIC_DIR."services/view_service";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Customer_locations extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/customer_location_model");
		$this->lang->load("customer_locations", 'english');
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
		$data = $this->customer_location_model->get_customer_location_list($where,TRUE, TRUE);
		 $this->data["customer_locations"] = $data->customer_locations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Customer Locations";
         $this->data["view"] = PUBLIC_DIR."customer_locations/customer_locations";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_customer_location($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
        
        $this->data["customer_locations"] = $this->customer_location_model->get_customer_location($customer_location_id);
        $this->data["title"] = "Customer Locations Details";
        $this->data["view"] = PUBLIC_DIR."customer_locations/view_customer_location";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        

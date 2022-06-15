<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Restaurant_Controller extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";
    
    public function __construct(){
        
        parent::__construct();
		 
		 
		 
       //$this->output->enable_profiler(TRUE);
       //var_dump($this->session->all_userdata());
        //$this->output->cache(60);
       // $this->output->delete_cache();
        $this->load->helper("form");
        $this->load->helper("my_functions");
        $this->load->library('form_validation');
        $this->load->library("session");
        $this->load->model("user_m");
        $this->load->model("mr_m");
        $this->load->model("module_m");
		
		$this->load->model("admin/system_global_setting_model");
		$this->load->model("admin/restaurants_model");
		
		
       // $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
       // $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        //$this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));
		
		$system_global_setting_id = 1;
		$fields = $fields = array("sytem_admin_logo", "system_title", "sytem_public_logo" );
		$join_table = $join_table = array();
		$where = "system_global_setting_id = $system_global_setting_id";
		$this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true);
		
		//get resturent detail 
			if($this->session->userdata('restaurant_id')){
			$this->data["restaurants"] = $this->restaurants_model->get_restaurants($this->session->userdata('restaurant_id'));
			}
        
        //login check
        $exception_uri = array(
            MANAGE_RESTAURANT_DIR."home/login",
            MANAGE_RESTAURANT_DIR."home/logout"
        );
		
		
		//var_dump($this->session->userdata());
		//exit();
        
       if(!in_array(uri_string(), $exception_uri)){
		   
		 //  var_dump($this->session->userdata);
		   
		   if($this->session->userdata("logged_in") === TRUE){
			   redirect(MANAGE_RESTAURANT_DIR."home/logout");
			   }
		   
		 
		  if($this->session->userdata("restaurant_logged_in") == false){
				
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				echo "<h4>Your session has expired. Please log-in again.</4>";
				exit();
				}else{
					redirect(MANAGE_RESTAURANT_DIR."home/login");
					}
					
					
	 }
	 
	  	
			
			 
            //now we will check if the current module is assigned to the user or not
            //$this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);
           // $allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));
            
            //add role homepage to allowed modules
           // $allowed_modules[] = $this->session->userdata("role_homepage_id");
            
            //var_dump($allowed_modules);
            
           // if(!in_array($current_action_id, $allowed_modules)){
                //$this->session->set_flashdata('msg_error', 'You are not allowed to access this module');
                //redirect(MANAGE_RESTAURANT_DIR.$this->session->userdata("role_homepage_uri"));
           // }
        }
    }
    
    
}
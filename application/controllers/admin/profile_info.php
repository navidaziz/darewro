<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Profile_info extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/user_model");
		$this->lang->load("users", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		redirect(ADMIN_DIR."profile_info/search");
       // $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		//redirect($main_page); 
    }
	
	
  
    public function search(){
        
       
        $this->data["title"] = 'Search User Profile';
		if($this->input->post('user_name')){
		$user_name = $this->input->post('user_name');
		$user_name = $this->db->escape($user_name);
		$query="SELECT `users`.`user_email`,
						`users`.`user_password`,
						`users`.`user_name`,
						`users`.`user_title`
				FROM `users`
				WHERE `users`.`user_name` =$user_name
				AND `users`.`role_id` IN (2,23,24)";
		$user = $this->user_model->runQuery($query);
		if($user){
			$this->data['users'] = $user;
			$this->data['message'] = 'User Found';
			}else{
				$this->data['message'] = 'User Not Found';
				}
				
		$query="SELECT `sms`.`message` FROM `sms` WHERE `sms`.`mobile_number` =".$user_name."
		ORDER BY `sms`.`sms_id` DESC LIMIT 1";
		$query_result = $this->db->query($query);
		
		if($query_result->result()){
			$user_password_code  = $query_result->result()[0]->message;
		$this->data['user_password_code'] = $user_password_code;
		}else{
		$this->data['user_password_code']=NULL;	
			}		
				
		}
		
		$this->data["view"] = ADMIN_DIR."users/user_search";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
   
    
}        

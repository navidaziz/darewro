<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Home extends Restaurant_Controller{
    
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
		redirect(MANAGE_RESTAURANT_DIR.$this->session->userdata('role_homepage_uri'));
       // $main_page=base_url().MANAGE_RESTAURANT_DIR.$this->router->fetch_class()."/view";
  		//redirect($main_page); 
    }
    //---------------------------------------------------------------

     /**
      * logout a user
      */
     public function logout(){
        //$this->user_m->logout();
		
		$this->session->sess_destroy();
        redirect(MANAGE_RESTAURANT_DIR."home/login");
     }
    //-----------------------------------------------------
	
	/**
      * function to login a user
      */
     public function login(){
		 
        
        //check if the user is already logedin
        if($this->session->userdata("restaurant_logged_in") == TRUE){
            redirect(MANAGE_RESTAURANT_DIR."restaurants/orders");
        }
        
        //load other models
        $this->load->model("role_m");
        $this->load->model("module_m");
        
        $validations = array(
            array(
                'field' =>  'user_email',
                'label' =>  'User Name',
                'rules' =>  'required'
            ),
            
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'required'
            )
        );
        $this->form_validation->set_rules($validations);
        if($this->form_validation->run() === TRUE){
            
            $input_values = array(
                'user_name' => $this->input->post("user_email"),
                'user_password' => $this->input->post("user_password")
            );
            
            //get the user
            $user = $this->user_m->getBy($input_values, TRUE);
			//var_dump($user);
			//exit;
            
            if(count($user) > 0 and $user->restaurant_id>0){
                
                //
                /*$role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
                $role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);
                
                //now create homepage path
                $homepage_path = "";
                if($role_homepage_parent_id != 0){
                    $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id)."/";
                }
                $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);
				
				$fields = "roles.*";
				$join  = array();
				$where = "roles.role_id = $user->role_id";
                $role=$roles= $this->role_m->joinGet($fields, "roles", $join, $where);*/
				
				//get user projects  by role id
				
				$homepage_path='restaurants/orders';		
				
                $user_data = array(
					"user_id"  => $user->user_id,
                    "user_email" => $user->user_email,
                    "user_title" => $user->user_title,
                    "role_id" => $user->role_id,
					"role_level" =>  $role[0]->role_level,
                    "role_homepage_id" => $role_homepage_id,
                    "role_homepage_uri" => $homepage_path,
					"user_image" => $user->user_image ,
					"restaurant_id" => $user->restaurant_id ,
                    "restaurant_logged_in" => TRUE
                );
				
				
				
                
                //add to session
                $this->session->set_userdata($user_data);
				//var_dump($this->session->userdata);
				//exit;
                $this->session->set_flashdata('msg_success', "<strong>".$user->user_title.'</strong><br/><i>welcome to admin panel</i>');
                redirect(MANAGE_RESTAURANT_DIR.$homepage_path);
				 
				
            }else{
                $this->session->set_flashdata('msg', 'User Name or Password is incorrect');
                redirect(MANAGE_RESTAURANT_DIR."home/login");
            }
        }else{
            
            $this->data['title'] = "Login to dashboard";
            $this->load->view(MANAGE_RESTAURANT_DIR."home/login", $this->data);
        }
        
     }
	 
	 
public function update_profile(){
		 
		 $user_id = (int) $this->session->userdata('user_id');
        $this->data["user"] = $this->user_model->get($user_id);
        
        
        $validation_config = array(
						array(
                            "field"  =>  "user_email",
                            "label"  =>  "User Email",
                            "rules"  =>  "required"
                        ),
                        
                        
                        array(
                            "field"  =>  "user_password",
                            "label"  =>  "User Password",
                            "rules"  =>  "required"
                        ),
						
						  array(
                            "field"  =>  "user_mobile_number",
                            "label"  =>  "Mobile Number",
                            "rules"  =>  "required"
                        ),
						
                        
            );
        
        
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
            
            
                    $config = array(
                        "upload_path" => "./assets/uploads/".$this->router->fetch_class()."/",
                        "allowed_types" => "jpg|jpeg|bmp|png|gif",
                        "max_size" => 10000,
                        "max_width" => 0,
                        "max_height" => 0,
                        "remove_spaces" => true,
                        "encrypt_name" => true
                    );
                    if(!$this->upload_file("user_image", $config)){
                        //var_dump($this->data["upload_error"]);
                    }else{
                        //var_dump($this->data["upload_data"]);
                        $user_image = $this->data["upload_data"]["file_name"];
                    }
                    
            
            $inputs = array();
            
                    
                    
                     $inputs["user_email"]  =  $this->input->post("user_email");
                    
                     $inputs["user_password"]  =  $this->input->post("user_password");
					
					$inputs["user_mobile_number"]  =  $this->input->post("user_mobile_number");
					
					
                    
                    if($_FILES["user_image"]["size"] > 0){
                        $inputs["user_image"]  =  $this->router->fetch_class()."/".$user_image;
                    }
                    
            
            if($this->user_model->save($inputs, $user_id)){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(MANAGE_RESTAURANT_DIR."home/update_profile");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(MANAGE_RESTAURANT_DIR."home/update_profile");
            }
        }
        
        $this->data["title"] = 'Update Restaurant Profile';
		$this->data["view"] = MANAGE_RESTAURANT_DIR."home/update_profile";
        $this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
     
		  
	  } 	 
	 
    
}        

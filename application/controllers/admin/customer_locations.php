<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Customer_locations extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "latitude IS NULL AND longitude IS NULL and province IS NULL and city IS NULL and country IS NULL and country IS NULL";
		$data = $this->customer_location_model->get_customer_location_list($where);
		 $this->data["customer_locations"] = $data->customer_locations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Customer Locations');
		$this->data["view"] = ADMIN_DIR."customer_locations/customer_locations";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_customer_location($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
        
        $this->data["customer_locations"] = $this->customer_location_model->get_customer_location($customer_location_id);
        $this->data["title"] = $this->lang->line('Customer Location Details');
		$this->data["view"] = ADMIN_DIR."customer_locations/view_customer_location";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->customer_location_model->get_customer_location_list($where);
		 $this->data["customer_locations"] = $data->customer_locations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Customer Locations');
		$this->data["view"] = ADMIN_DIR."customer_locations/trashed_customer_locations";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        
        
        $this->customer_location_model->changeStatus($customer_location_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."customer_locations/view/".$page_id);
    }
    
    /**
      * function to restor customer_location from trash
      * @param $customer_location_id integer
      */
     public function restore($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        
        
        $this->customer_location_model->changeStatus($customer_location_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."customer_locations/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft customer_location from trash
      * @param $customer_location_id integer
      */
     public function draft($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        
        
        $this->customer_location_model->changeStatus($customer_location_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."customer_locations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish customer_location from trash
      * @param $customer_location_id integer
      */
     public function publish($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        
        
        $this->customer_location_model->changeStatus($customer_location_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."customer_locations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Customer_location
      * @param $customer_location_id integer
      */
     public function delete($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        //$this->customer_location_model->changeStatus($customer_location_id, "3");
        
		$this->customer_location_model->delete(array( 'customer_location_id' => $customer_location_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."customer_locations/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Customer_location
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Customer Location');$this->data["view"] = ADMIN_DIR."customer_locations/add_customer_location";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->customer_location_model->validate_form_data() === TRUE){
		  
		  $customer_location_id = $this->customer_location_model->save_data();
          if($customer_location_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."customer_locations/edit/$customer_location_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customer_locations/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Customer_location
      */
     public function edit($customer_location_id){
		 $customer_location_id = (int) $customer_location_id;
        $this->data["customer_location"] = $this->customer_location_model->get($customer_location_id);
		  
        $this->data["title"] = $this->lang->line('Edit Customer Location');$this->data["view"] = ADMIN_DIR."customer_locations/edit_customer_location";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($customer_location_id){
		 
		 $customer_location_id = (int) $customer_location_id;
       
	   if($this->customer_location_model->validate_form_data() === TRUE){
		  
		  $customer_location_id = $this->customer_location_model->update_data($customer_location_id);
          if($customer_location_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."customer_locations/edit/$customer_location_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customer_locations/edit/$customer_location_id");
            }
        }else{
			$this->edit($customer_location_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["customer_locations"] = $this->customer_location_model->getBy($where, false, "customer_location_id" );
				$j_array[]=array("id" => "", "value" => "customer_location");
				foreach($data["customer_locations"] as $customer_location ){
					$j_array[]=array("id" => $customer_location->customer_location_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
	
	public function update_customer_location(){
		
		$customer_location_id = (int) $this->input->post("customer_location_id");
       
	   $customer_location_id = $this->customer_location_model->update_data($customer_location_id);
          
		  $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."customer_locations/view/");
            
			
		
		
		
		}
	
	
	
	
    //-----------------------------------------------------
    
}        

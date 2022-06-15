<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Services extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`services`.`status` IN (0, 1) ORDER BY `services`.`order`";
		$data = $this->service_model->get_service_list($where);
		 $this->data["services"] = $data->services;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Services');
		$this->data["view"] = ADMIN_DIR."services/services";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_service($service_id){
        
        $service_id = (int) $service_id;
        
        $this->data["services"] = $this->service_model->get_service($service_id);
        $this->data["title"] = $this->lang->line('Service Details');
		$this->data["view"] = ADMIN_DIR."services/view_service";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`services`.`status` IN (2) ORDER BY `services`.`order`";
		$data = $this->service_model->get_service_list($where);
		 $this->data["services"] = $data->services;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Services');
		$this->data["view"] = ADMIN_DIR."services/trashed_services";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
        
        $this->service_model->changeStatus($service_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."services/view/".$page_id);
    }
    
    /**
      * function to restor service from trash
      * @param $service_id integer
      */
     public function restore($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
        
        $this->service_model->changeStatus($service_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."services/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft service from trash
      * @param $service_id integer
      */
     public function draft($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
        
        $this->service_model->changeStatus($service_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."services/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish service from trash
      * @param $service_id integer
      */
     public function publish($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
        
        $this->service_model->changeStatus($service_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."services/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Service
      * @param $service_id integer
      */
     public function delete($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        //$this->service_model->changeStatus($service_id, "3");
        //Remove file....
						$services = $this->service_model->get_service($service_id);
						$file_path = $services[0]->service_image;
						$this->service_model->delete_file($file_path);
		$this->service_model->delete(array( 'service_id' => $service_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."services/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Service
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Service');$this->data["view"] = ADMIN_DIR."services/add_service";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->service_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("service_image")){
                       $_POST['service_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $service_id = $this->service_model->save_data();
          if($service_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."services/edit/$service_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."services/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Service
      */
     public function edit($service_id){
		 $service_id = (int) $service_id;
        $this->data["service"] = $this->service_model->get($service_id);
		  
        $this->data["title"] = $this->lang->line('Edit Service');$this->data["view"] = ADMIN_DIR."services/edit_service";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($service_id){
		 
		 $service_id = (int) $service_id;
       
	   if($this->service_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("service_image")){
                         $_POST["service_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $service_id = $this->service_model->update_data($service_id);
          if($service_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."services/edit/$service_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."services/edit/$service_id");
            }
        }else{
			$this->edit($service_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $service_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
		//get order number of this record
        $this_service_where = "service_id = $service_id";
        $this_service = $this->service_model->getBy($this_service_where, true);
        $this_service_id = $service_id;
        $this_service_order = $this_service->order;
        
        
        //get order number of previous record
        $previous_service_where = "order <= $this_service_order AND service_id != $service_id ORDER BY `order` DESC";
        $previous_service = $this->service_model->getBy($previous_service_where, true);
        $previous_service_id = $previous_service->service_id;
        $previous_service_order = $previous_service->order;
        
        //if this is the first element
        if(!$previous_service_id){
            redirect(ADMIN_DIR."services/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_service_inputs = array(
            "order" => $previous_service_order
        );
        $this->service_model->save($this_service_inputs, $this_service_id);
        
        $previous_service_inputs = array(
            "order" => $this_service_order
        );
        $this->service_model->save($previous_service_inputs, $previous_service_id);
        
        
        
        redirect(ADMIN_DIR."services/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $service_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($service_id, $page_id = NULL){
        
        $service_id = (int) $service_id;
        
        
        
        //get order number of this record
         $this_service_where = "service_id = $service_id";
        $this_service = $this->service_model->getBy($this_service_where, true);
        $this_service_id = $service_id;
        $this_service_order = $this_service->order;
        
        
        //get order number of next record
		
        $next_service_where = "order >= $this_service_order and service_id != $service_id ORDER BY `order` ASC";
        $next_service = $this->service_model->getBy($next_service_where, true);
        $next_service_id = $next_service->service_id;
        $next_service_order = $next_service->order;
        
        //if this is the first element
        if(!$next_service_id){
            redirect(ADMIN_DIR."services/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_service_inputs = array(
            "order" => $next_service_order
        );
        $this->service_model->save($this_service_inputs, $this_service_id);
        
        $next_service_inputs = array(
            "order" => $this_service_order
        );
        $this->service_model->save($next_service_inputs, $next_service_id);
        
        
        
        redirect(ADMIN_DIR."services/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["services"] = $this->service_model->getBy($where, false, "service_id" );
				$j_array[]=array("id" => "", "value" => "service");
				foreach($data["services"] as $service ){
					$j_array[]=array("id" => $service->service_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

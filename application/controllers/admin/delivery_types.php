<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Delivery_types extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/delivery_type_model");
		$this->lang->load("delivery_types", 'english');
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
		
        $where = "`delivery_types`.`status` IN (0, 1) ";
		$data = $this->delivery_type_model->get_delivery_type_list($where);
		 $this->data["delivery_types"] = $data->delivery_types;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Delivery Types');
		$this->data["view"] = ADMIN_DIR."delivery_types/delivery_types";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_delivery_type($delivery_type_id){
        
        $delivery_type_id = (int) $delivery_type_id;
        
        $this->data["delivery_types"] = $this->delivery_type_model->get_delivery_type($delivery_type_id);
        $this->data["title"] = $this->lang->line('Delivery Type Details');
		$this->data["view"] = ADMIN_DIR."delivery_types/view_delivery_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`delivery_types`.`status` IN (2) ";
		$data = $this->delivery_type_model->get_delivery_type_list($where);
		 $this->data["delivery_types"] = $data->delivery_types;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Delivery Types');
		$this->data["view"] = ADMIN_DIR."delivery_types/trashed_delivery_types";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($delivery_type_id, $page_id = NULL){
        
        $delivery_type_id = (int) $delivery_type_id;
        
        
        $this->delivery_type_model->changeStatus($delivery_type_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."delivery_types/view/".$page_id);
    }
    
    /**
      * function to restor delivery_type from trash
      * @param $delivery_type_id integer
      */
     public function restore($delivery_type_id, $page_id = NULL){
        
        $delivery_type_id = (int) $delivery_type_id;
        
        
        $this->delivery_type_model->changeStatus($delivery_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."delivery_types/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft delivery_type from trash
      * @param $delivery_type_id integer
      */
     public function draft($delivery_type_id, $page_id = NULL){
        
        $delivery_type_id = (int) $delivery_type_id;
        
        
        $this->delivery_type_model->changeStatus($delivery_type_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."delivery_types/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish delivery_type from trash
      * @param $delivery_type_id integer
      */
     public function publish($delivery_type_id, $page_id = NULL){
        
        $delivery_type_id = (int) $delivery_type_id;
        
        
        $this->delivery_type_model->changeStatus($delivery_type_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."delivery_types/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Delivery_type
      * @param $delivery_type_id integer
      */
     public function delete($delivery_type_id, $page_id = NULL){
        
        $delivery_type_id = (int) $delivery_type_id;
        //$this->delivery_type_model->changeStatus($delivery_type_id, "3");
        
		$this->delivery_type_model->delete(array( 'delivery_type_id' => $delivery_type_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."delivery_types/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Delivery_type
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Delivery Type');$this->data["view"] = ADMIN_DIR."delivery_types/add_delivery_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->delivery_type_model->validate_form_data() === TRUE){
		  
		  $delivery_type_id = $this->delivery_type_model->save_data();
          if($delivery_type_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."delivery_types/edit/$delivery_type_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."delivery_types/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Delivery_type
      */
     public function edit($delivery_type_id){
		 $delivery_type_id = (int) $delivery_type_id;
        $this->data["delivery_type"] = $this->delivery_type_model->get($delivery_type_id);
		  
        $this->data["title"] = $this->lang->line('Edit Delivery Type');$this->data["view"] = ADMIN_DIR."delivery_types/edit_delivery_type";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($delivery_type_id){
		 
		 $delivery_type_id = (int) $delivery_type_id;
       
	   if($this->delivery_type_model->validate_form_data() === TRUE){
		  
		  $delivery_type_id = $this->delivery_type_model->update_data($delivery_type_id);
          if($delivery_type_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."delivery_types/edit/$delivery_type_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."delivery_types/edit/$delivery_type_id");
            }
        }else{
			$this->edit($delivery_type_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["delivery_types"] = $this->delivery_type_model->getBy($where, false, "delivery_type_id" );
				$j_array[]=array("id" => "", "value" => "delivery_type");
				foreach($data["delivery_types"] as $delivery_type ){
					$j_array[]=array("id" => $delivery_type->delivery_type_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

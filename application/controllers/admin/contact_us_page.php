<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Contact_us_page extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/contact_us_page_model");
		$this->lang->load("contact_us_page", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view_contact_us_page/1";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view_contact_us_page/1";
  		redirect($main_page);
		
        $where = "";
		$data = $this->contact_us_page_model->get_contact_us_page_list($where);
		 $this->data["contact_us_page"] = $data->contact_us_page;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Contact Us Page');
		$this->data["view"] = ADMIN_DIR."contact_us_page/contact_us_page";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_contact_us_page($contact_us_page_id){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        
        $this->data["contact_us_page"] = $this->contact_us_page_model->get_contact_us_page($contact_us_page_id);
        $this->data["title"] = $this->lang->line('Contact Us Page Details');
		$this->data["view"] = ADMIN_DIR."contact_us_page/view_contact_us_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->contact_us_page_model->get_contact_us_page_list($where);
		 $this->data["contact_us_page"] = $data->contact_us_page;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Contact Us Page');
		$this->data["view"] = ADMIN_DIR."contact_us_page/trashed_contact_us_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($contact_us_page_id, $page_id = NULL){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        
        
        $this->contact_us_page_model->changeStatus($contact_us_page_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."contact_us_page/view/".$page_id);
    }
    
    /**
      * function to restor contact_us_page from trash
      * @param $contact_us_page_id integer
      */
     public function restore($contact_us_page_id, $page_id = NULL){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        
        
        $this->contact_us_page_model->changeStatus($contact_us_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."contact_us_page/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft contact_us_page from trash
      * @param $contact_us_page_id integer
      */
     public function draft($contact_us_page_id, $page_id = NULL){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        
        
        $this->contact_us_page_model->changeStatus($contact_us_page_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."contact_us_page/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish contact_us_page from trash
      * @param $contact_us_page_id integer
      */
     public function publish($contact_us_page_id, $page_id = NULL){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        
        
        $this->contact_us_page_model->changeStatus($contact_us_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."contact_us_page/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Contact_us_page
      * @param $contact_us_page_id integer
      */
     public function delete($contact_us_page_id, $page_id = NULL){
        
        $contact_us_page_id = (int) $contact_us_page_id;
        //$this->contact_us_page_model->changeStatus($contact_us_page_id, "3");
        
		$this->contact_us_page_model->delete(array( 'contact_us_page_id' => $contact_us_page_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."contact_us_page/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Contact_us_page
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Contact Us Page');$this->data["view"] = ADMIN_DIR."contact_us_page/add_contact_us_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->contact_us_page_model->validate_form_data() === TRUE){
		  
		  $contact_us_page_id = $this->contact_us_page_model->save_data();
          if($contact_us_page_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."contact_us_page/edit/$contact_us_page_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."contact_us_page/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Contact_us_page
      */
     public function edit($contact_us_page_id){
		 $contact_us_page_id = (int) $contact_us_page_id;
        $this->data["contact_us_page"] = $this->contact_us_page_model->get($contact_us_page_id);
		  
        $this->data["title"] = $this->lang->line('Edit Contact Us Page');$this->data["view"] = ADMIN_DIR."contact_us_page/edit_contact_us_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($contact_us_page_id){
		 
		 $contact_us_page_id = (int) $contact_us_page_id;
       
	   if($this->contact_us_page_model->validate_form_data() === TRUE){
		  
		  $contact_us_page_id = $this->contact_us_page_model->update_data($contact_us_page_id);
          if($contact_us_page_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."contact_us_page/edit/$contact_us_page_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."contact_us_page/edit/$contact_us_page_id");
            }
        }else{
			$this->edit($contact_us_page_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["contact_us_page"] = $this->contact_us_page_model->getBy($where, false, "contact_us_page_id" );
				$j_array[]=array("id" => "", "value" => "contact_us_page");
				foreach($data["contact_us_page"] as $contact_us_page ){
					$j_array[]=array("id" => $contact_us_page->contact_us_page_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

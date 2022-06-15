<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Messages extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/message_model");
		$this->lang->load("messages", 'english');
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
		
        $where = "`messages`.`status` IN (0, 1) ";
		$data = $this->message_model->get_message_list($where);
		 $this->data["messages"] = $data->messages;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Messages');
		$this->data["view"] = ADMIN_DIR."messages/messages";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_message($message_id){
        
        $message_id = (int) $message_id;
        
        $this->data["messages"] = $this->message_model->get_message($message_id);
        $this->data["title"] = $this->lang->line('Message Details');
		$this->data["view"] = ADMIN_DIR."messages/view_message";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`messages`.`status` IN (2) ";
		$data = $this->message_model->get_message_list($where);
		 $this->data["messages"] = $data->messages;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Messages');
		$this->data["view"] = ADMIN_DIR."messages/trashed_messages";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($message_id, $page_id = NULL){
        
        $message_id = (int) $message_id;
        
        
        $this->message_model->changeStatus($message_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."messages/view/".$page_id);
    }
    
    /**
      * function to restor message from trash
      * @param $message_id integer
      */
     public function restore($message_id, $page_id = NULL){
        
        $message_id = (int) $message_id;
        
        
        $this->message_model->changeStatus($message_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."messages/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft message from trash
      * @param $message_id integer
      */
     public function draft($message_id, $page_id = NULL){
        
        $message_id = (int) $message_id;
        
        
        $this->message_model->changeStatus($message_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."messages/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish message from trash
      * @param $message_id integer
      */
     public function publish($message_id, $page_id = NULL){
        
        $message_id = (int) $message_id;
        
        
        $this->message_model->changeStatus($message_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."messages/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Message
      * @param $message_id integer
      */
     public function delete($message_id, $page_id = NULL){
        
        $message_id = (int) $message_id;
        //$this->message_model->changeStatus($message_id, "3");
        
		$this->message_model->delete(array( 'message_id' => $message_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."messages/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Message
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Message');$this->data["view"] = ADMIN_DIR."messages/add_message";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->message_model->validate_form_data() === TRUE){
		  
		  $message_id = $this->message_model->save_data();
          if($message_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."messages/edit/$message_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."messages/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Message
      */
     public function edit($message_id){
		 $message_id = (int) $message_id;
        $this->data["message"] = $this->message_model->get($message_id);
		  
        $this->data["title"] = $this->lang->line('Edit Message');$this->data["view"] = ADMIN_DIR."messages/edit_message";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($message_id){
		 
		 $message_id = (int) $message_id;
       
	   if($this->message_model->validate_form_data() === TRUE){
		  
		  $message_id = $this->message_model->update_data($message_id);
          if($message_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."messages/edit/$message_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."messages/edit/$message_id");
            }
        }else{
			$this->edit($message_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["messages"] = $this->message_model->getBy($where, false, "message_id" );
				$j_array[]=array("id" => "", "value" => "message");
				foreach($data["messages"] as $message ){
					$j_array[]=array("id" => $message->message_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

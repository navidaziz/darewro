<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Promo_codes extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/promo_code_model");
		$this->lang->load("promo_codes", 'english');
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
		
        $where = "`promo_codes`.`status` IN (0, 1) ORDER BY `promo_code_id` DESC";
		$data = $this->promo_code_model->get_promo_code_list($where);
		 $this->data["promo_codes"] = $data->promo_codes;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Promo Codes');
		$this->data["view"] = ADMIN_DIR."promo_codes/promo_codes";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_promo_code($promo_code_id){
        
        $promo_code_id = (int) $promo_code_id;
        
        $this->data["promo_codes"] = $this->promo_code_model->get_promo_code($promo_code_id);
        $this->data["title"] = $this->lang->line('Promo Code Details');
		$this->data["view"] = ADMIN_DIR."promo_codes/view_promo_code";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`promo_codes`.`status` IN (2) ";
		$data = $this->promo_code_model->get_promo_code_list($where);
		 $this->data["promo_codes"] = $data->promo_codes;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Promo Codes');
		$this->data["view"] = ADMIN_DIR."promo_codes/trashed_promo_codes";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($promo_code_id, $page_id = NULL){
        
        $promo_code_id = (int) $promo_code_id;
        
        
        $this->promo_code_model->changeStatus($promo_code_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."promo_codes/view/".$page_id);
    }
    
    /**
      * function to restor promo_code from trash
      * @param $promo_code_id integer
      */
     public function restore($promo_code_id, $page_id = NULL){
        
        $promo_code_id = (int) $promo_code_id;
        
        
        $this->promo_code_model->changeStatus($promo_code_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."promo_codes/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft promo_code from trash
      * @param $promo_code_id integer
      */
     public function draft($promo_code_id, $page_id = NULL){
        
        $promo_code_id = (int) $promo_code_id;
        
        
        $this->promo_code_model->changeStatus($promo_code_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."promo_codes/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish promo_code from trash
      * @param $promo_code_id integer
      */
     public function publish($promo_code_id, $page_id = NULL){
        
        $promo_code_id = (int) $promo_code_id;
        
        
        $this->promo_code_model->changeStatus($promo_code_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."promo_codes/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Promo_code
      * @param $promo_code_id integer
      */
     public function delete($promo_code_id, $page_id = NULL){
        
        $promo_code_id = (int) $promo_code_id;
        $this->promo_code_model->changeStatus($promo_code_id, "3");
        
		/*$this->promo_code_model->delete(array( 'promo_code_id' => $promo_code_id));*/
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."promo_codes/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Promo_code
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Promo Code');$this->data["view"] = ADMIN_DIR."promo_codes/add_promo_code";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
         
         
	  if($this->promo_code_model->validate_form_data() === TRUE){
		  
		  $promo_code_id = $this->promo_code_model->save_data();
          if($promo_code_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."promo_codes/edit/$promo_code_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."promo_codes/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Promo_code
      */
     public function edit($promo_code_id){
		 $promo_code_id = (int) $promo_code_id;
        $this->data["promo_code"] = $this->promo_code_model->get($promo_code_id);
		  
        $this->data["title"] = $this->lang->line('Edit Promo Code');$this->data["view"] = ADMIN_DIR."promo_codes/edit_promo_code";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($promo_code_id){
		 
		 $promo_code_id = (int) $promo_code_id;
       
	   if($this->promo_code_model->validate_form_data() === TRUE){
		  
		  $promo_code_id = $this->promo_code_model->update_data($promo_code_id);
          if($promo_code_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."promo_codes/edit/$promo_code_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."promo_codes/edit/$promo_code_id");
            }
        }else{
			$this->edit($promo_code_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["promo_codes"] = $this->promo_code_model->getBy($where, false, "promo_code_id" );
				$j_array[]=array("id" => "", "value" => "promo_code");
				foreach($data["promo_codes"] as $promo_code ){
					$j_array[]=array("id" => $promo_code->promo_code_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

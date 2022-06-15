<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Page_contents extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/page_content_model");
		$this->lang->load("page_contents", 'english');
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
		
        $where = "`page_contents`.`status` IN (0, 1) ORDER BY `page_contents`.`order`";
		$data = $this->page_content_model->get_page_content_list($where);
		 $this->data["page_contents"] = $data->page_contents;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Page Contents');
		$this->data["view"] = ADMIN_DIR."page_contents/page_contents";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_page_content($page_content_id){
        
        $page_content_id = (int) $page_content_id;
        
        $this->data["page_contents"] = $this->page_content_model->get_page_content($page_content_id);
        $this->data["title"] = $this->lang->line('Page Content Details');
		$this->data["view"] = ADMIN_DIR."page_contents/view_page_content";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`page_contents`.`status` IN (2) ORDER BY `page_contents`.`order`";
		$data = $this->page_content_model->get_page_content_list($where);
		 $this->data["page_contents"] = $data->page_contents;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Page Contents');
		$this->data["view"] = ADMIN_DIR."page_contents/trashed_page_contents";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
        
        $this->page_content_model->changeStatus($page_content_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."page_contents/view/".$page_id);
    }
    
    /**
      * function to restor page_content from trash
      * @param $page_content_id integer
      */
     public function restore($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
        
        $this->page_content_model->changeStatus($page_content_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."page_contents/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft page_content from trash
      * @param $page_content_id integer
      */
     public function draft($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
        
        $this->page_content_model->changeStatus($page_content_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."pages/view_page/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish page_content from trash
      * @param $page_content_id integer
      */
     public function publish($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
        
        $this->page_content_model->changeStatus($page_content_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."pages/view_page/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Page_content
      * @param $page_content_id integer
      */
     public function delete($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        //$this->page_content_model->changeStatus($page_content_id, "3");
        //Remove file....
						$page_contents = $this->page_content_model->get_page_content($page_content_id);
						$file_path = $page_contents[0]->attachment;
						$this->page_content_model->delete_file($file_path);
		$this->page_content_model->delete(array( 'page_content_id' => $page_content_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."pages/view_page/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Page_content
      */
     public function add(){
		
    $this->data["pages"] = $this->page_content_model->getList("PAGES", "page_id", "page_name", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Page Content');$this->data["view"] = ADMIN_DIR."page_contents/add_page_content";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
		 $page_id = $this->input->post('page_id');
	  if($this->page_content_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("attachment")){
                       $_POST['attachment'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $page_content_id = $this->page_content_model->save_data();
          if($page_content_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."pages/view_page/$page_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(ADMIN_DIR."pages/view_page/$page_id");
            }
        }else{
			 $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
             redirect(ADMIN_DIR."pages/view_page/$page_id");
			}
	 }


     /**
      * function to edit a Page_content
      */
     public function edit($page_content_id){
		 $page_content_id = (int) $page_content_id;
        $this->data["page_content"] = $this->page_content_model->get($page_content_id);
		  
    $this->data["pages"] = $this->page_content_model->getList("PAGES", "page_id", "page_name", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Page Content');$this->data["view"] = ADMIN_DIR."page_contents/edit_page_content";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($page_content_id){
		 $page_id = $this->input->post('page_id');
		 $page_content_id = (int) $page_content_id;
       
	   if($this->page_content_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("attachment")){
                         $_POST["attachment"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $page_content_id = $this->page_content_model->update_data($page_content_id);
          if($page_content_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."pages/view_page/$page_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."pages/view_page/$page_id");
            }
        }else{
			$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
            redirect(ADMIN_DIR."pages/view_page/$page_id");
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $page_content_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
		//get order number of this record
        $this_page_content_where = "page_content_id = $page_content_id";
        $this_page_content = $this->page_content_model->getBy($this_page_content_where, true);
        $this_page_content_id = $page_content_id;
        $this_page_content_order = $this_page_content->order;
        
        
        //get order number of previous record
        $previous_page_content_where = "order <= $this_page_content_order AND page_content_id != $page_content_id ORDER BY `order` DESC";
        $previous_page_content = $this->page_content_model->getBy($previous_page_content_where, true);
        $previous_page_content_id = $previous_page_content->page_content_id;
        $previous_page_content_order = $previous_page_content->order;
        
        //if this is the first element
        if(!$previous_page_content_id){
            redirect(ADMIN_DIR."pages/view_page/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_page_content_inputs = array(
            "order" => $previous_page_content_order
        );
        $this->page_content_model->save($this_page_content_inputs, $this_page_content_id);
        
        $previous_page_content_inputs = array(
            "order" => $this_page_content_order
        );
        $this->page_content_model->save($previous_page_content_inputs, $previous_page_content_id);
        
        
        
        redirect(ADMIN_DIR."pages/view_page/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $page_content_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($page_content_id, $page_id = NULL){
        
        $page_content_id = (int) $page_content_id;
        
        
        
        //get order number of this record
         $this_page_content_where = "page_content_id = $page_content_id";
        $this_page_content = $this->page_content_model->getBy($this_page_content_where, true);
        $this_page_content_id = $page_content_id;
        $this_page_content_order = $this_page_content->order;
        
        
        //get order number of next record
		
        $next_page_content_where = "order >= $this_page_content_order and page_content_id != $page_content_id ORDER BY `order` ASC";
        $next_page_content = $this->page_content_model->getBy($next_page_content_where, true);
        $next_page_content_id = $next_page_content->page_content_id;
        $next_page_content_order = $next_page_content->order;
        
        //if this is the first element
        if(!$next_page_content_id){
            redirect(ADMIN_DIR."pages/view_page/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_page_content_inputs = array(
            "order" => $next_page_content_order
        );
        $this->page_content_model->save($this_page_content_inputs, $this_page_content_id);
        
        $next_page_content_inputs = array(
            "order" => $this_page_content_order
        );
        $this->page_content_model->save($next_page_content_inputs, $next_page_content_id);
        
        
        
        redirect(ADMIN_DIR."pages/view_page/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["page_contents"] = $this->page_content_model->getBy($where, false, "page_content_id" );
				$j_array[]=array("id" => "", "value" => "page_content");
				foreach($data["page_contents"] as $page_content ){
					$j_array[]=array("id" => $page_content->page_content_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

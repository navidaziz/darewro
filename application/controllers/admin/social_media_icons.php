<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Social_media_icons extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/social_media_icon_model");
		$this->lang->load("social_media_icons", 'english');
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
		
        $where = "`social_media_icons`.`status` IN (0, 1) ORDER BY `social_media_icons`.`order`";
		$data = $this->social_media_icon_model->get_social_media_icon_list($where);
		 $this->data["social_media_icons"] = $data->social_media_icons;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Social Media Icons');
		$this->data["view"] = ADMIN_DIR."social_media_icons/social_media_icons";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_social_media_icon($social_media_icon_id){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        $this->data["social_media_icons"] = $this->social_media_icon_model->get_social_media_icon($social_media_icon_id);
        $this->data["title"] = $this->lang->line('Social Media Icon Details');
		$this->data["view"] = ADMIN_DIR."social_media_icons/view_social_media_icon";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`social_media_icons`.`status` IN (2) ORDER BY `social_media_icons`.`order`";
		$data = $this->social_media_icon_model->get_social_media_icon_list($where);
		 $this->data["social_media_icons"] = $data->social_media_icons;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Social Media Icons');
		$this->data["view"] = ADMIN_DIR."social_media_icons/trashed_social_media_icons";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        
        $this->social_media_icon_model->changeStatus($social_media_icon_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
    }
    
    /**
      * function to restor social_media_icon from trash
      * @param $social_media_icon_id integer
      */
     public function restore($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        
        $this->social_media_icon_model->changeStatus($social_media_icon_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."social_media_icons/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft social_media_icon from trash
      * @param $social_media_icon_id integer
      */
     public function draft($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        
        $this->social_media_icon_model->changeStatus($social_media_icon_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish social_media_icon from trash
      * @param $social_media_icon_id integer
      */
     public function publish($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        
        $this->social_media_icon_model->changeStatus($social_media_icon_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Social_media_icon
      * @param $social_media_icon_id integer
      */
     public function delete($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        //$this->social_media_icon_model->changeStatus($social_media_icon_id, "3");
        //Remove file....
						$social_media_icons = $this->social_media_icon_model->get_social_media_icon($social_media_icon_id);
						$file_path = $social_media_icons[0]->social_media_image;
						$this->social_media_icon_model->delete_file($file_path);
		$this->social_media_icon_model->delete(array( 'social_media_icon_id' => $social_media_icon_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."social_media_icons/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Social_media_icon
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Social Media Icon');$this->data["view"] = ADMIN_DIR."social_media_icons/add_social_media_icon";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->social_media_icon_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("social_media_image")){
                       $_POST['social_media_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $social_media_icon_id = $this->social_media_icon_model->save_data();
          if($social_media_icon_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."social_media_icons/edit/$social_media_icon_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."social_media_icons/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Social_media_icon
      */
     public function edit($social_media_icon_id){
		 $social_media_icon_id = (int) $social_media_icon_id;
        $this->data["social_media_icon"] = $this->social_media_icon_model->get($social_media_icon_id);
		  
        $this->data["title"] = $this->lang->line('Edit Social Media Icon');$this->data["view"] = ADMIN_DIR."social_media_icons/edit_social_media_icon";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($social_media_icon_id){
		 
		 $social_media_icon_id = (int) $social_media_icon_id;
       
	   if($this->social_media_icon_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("social_media_image")){
                         $_POST["social_media_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $social_media_icon_id = $this->social_media_icon_model->update_data($social_media_icon_id);
          if($social_media_icon_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."social_media_icons/edit/$social_media_icon_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."social_media_icons/edit/$social_media_icon_id");
            }
        }else{
			$this->edit($social_media_icon_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $social_media_icon_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
		//get order number of this record
        $this_social_media_icon_where = "social_media_icon_id = $social_media_icon_id";
        $this_social_media_icon = $this->social_media_icon_model->getBy($this_social_media_icon_where, true);
        $this_social_media_icon_id = $social_media_icon_id;
        $this_social_media_icon_order = $this_social_media_icon->order;
        
        
        //get order number of previous record
        $previous_social_media_icon_where = "order <= $this_social_media_icon_order AND social_media_icon_id != $social_media_icon_id ORDER BY `order` DESC";
        $previous_social_media_icon = $this->social_media_icon_model->getBy($previous_social_media_icon_where, true);
        $previous_social_media_icon_id = $previous_social_media_icon->social_media_icon_id;
        $previous_social_media_icon_order = $previous_social_media_icon->order;
        
        //if this is the first element
        if(!$previous_social_media_icon_id){
            redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_social_media_icon_inputs = array(
            "order" => $previous_social_media_icon_order
        );
        $this->social_media_icon_model->save($this_social_media_icon_inputs, $this_social_media_icon_id);
        
        $previous_social_media_icon_inputs = array(
            "order" => $this_social_media_icon_order
        );
        $this->social_media_icon_model->save($previous_social_media_icon_inputs, $previous_social_media_icon_id);
        
        
        
        redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $social_media_icon_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($social_media_icon_id, $page_id = NULL){
        
        $social_media_icon_id = (int) $social_media_icon_id;
        
        
        
        //get order number of this record
         $this_social_media_icon_where = "social_media_icon_id = $social_media_icon_id";
        $this_social_media_icon = $this->social_media_icon_model->getBy($this_social_media_icon_where, true);
        $this_social_media_icon_id = $social_media_icon_id;
        $this_social_media_icon_order = $this_social_media_icon->order;
        
        
        //get order number of next record
		
        $next_social_media_icon_where = "order >= $this_social_media_icon_order and social_media_icon_id != $social_media_icon_id ORDER BY `order` ASC";
        $next_social_media_icon = $this->social_media_icon_model->getBy($next_social_media_icon_where, true);
        $next_social_media_icon_id = $next_social_media_icon->social_media_icon_id;
        $next_social_media_icon_order = $next_social_media_icon->order;
        
        //if this is the first element
        if(!$next_social_media_icon_id){
            redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_social_media_icon_inputs = array(
            "order" => $next_social_media_icon_order
        );
        $this->social_media_icon_model->save($this_social_media_icon_inputs, $this_social_media_icon_id);
        
        $next_social_media_icon_inputs = array(
            "order" => $this_social_media_icon_order
        );
        $this->social_media_icon_model->save($next_social_media_icon_inputs, $next_social_media_icon_id);
        
        
        
        redirect(ADMIN_DIR."social_media_icons/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["social_media_icons"] = $this->social_media_icon_model->getBy($where, false, "social_media_icon_id" );
				$j_array[]=array("id" => "", "value" => "social_media_icon");
				foreach($data["social_media_icons"] as $social_media_icon ){
					$j_array[]=array("id" => $social_media_icon->social_media_icon_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

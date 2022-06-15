<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Testimonials extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/testimonial_model");
		$this->lang->load("testimonials", 'english');
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
		
        $where = "`testimonials`.`status` IN (0, 1) ORDER BY `testimonials`.`order`";
		$data = $this->testimonial_model->get_testimonial_list($where);
		 $this->data["testimonials"] = $data->testimonials;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Testimonials');
		$this->data["view"] = ADMIN_DIR."testimonials/testimonials";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_testimonial($testimonial_id){
        
        $testimonial_id = (int) $testimonial_id;
        
        $this->data["testimonials"] = $this->testimonial_model->get_testimonial($testimonial_id);
        $this->data["title"] = $this->lang->line('Testimonial Details');
		$this->data["view"] = ADMIN_DIR."testimonials/view_testimonial";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`testimonials`.`status` IN (2) ORDER BY `testimonials`.`order`";
		$data = $this->testimonial_model->get_testimonial_list($where);
		 $this->data["testimonials"] = $data->testimonials;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Testimonials');
		$this->data["view"] = ADMIN_DIR."testimonials/trashed_testimonials";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
        
        $this->testimonial_model->changeStatus($testimonial_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."testimonials/view/".$page_id);
    }
    
    /**
      * function to restor testimonial from trash
      * @param $testimonial_id integer
      */
     public function restore($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
        
        $this->testimonial_model->changeStatus($testimonial_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."testimonials/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft testimonial from trash
      * @param $testimonial_id integer
      */
     public function draft($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
        
        $this->testimonial_model->changeStatus($testimonial_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."testimonials/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish testimonial from trash
      * @param $testimonial_id integer
      */
     public function publish($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
        
        $this->testimonial_model->changeStatus($testimonial_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."testimonials/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Testimonial
      * @param $testimonial_id integer
      */
     public function delete($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        //$this->testimonial_model->changeStatus($testimonial_id, "3");
        //Remove file....
						$testimonials = $this->testimonial_model->get_testimonial($testimonial_id);
						$file_path = $testimonials[0]->image;
						$this->testimonial_model->delete_file($file_path);
		$this->testimonial_model->delete(array( 'testimonial_id' => $testimonial_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."testimonials/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Testimonial
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Testimonial');$this->data["view"] = ADMIN_DIR."testimonials/add_testimonial";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->testimonial_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("image")){
                       $_POST['image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $testimonial_id = $this->testimonial_model->save_data();
          if($testimonial_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."testimonials/edit/$testimonial_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."testimonials/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Testimonial
      */
     public function edit($testimonial_id){
		 $testimonial_id = (int) $testimonial_id;
        $this->data["testimonial"] = $this->testimonial_model->get($testimonial_id);
		  
        $this->data["title"] = $this->lang->line('Edit Testimonial');$this->data["view"] = ADMIN_DIR."testimonials/edit_testimonial";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($testimonial_id){
		 
		 $testimonial_id = (int) $testimonial_id;
       
	   if($this->testimonial_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("image")){
                         $_POST["image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $testimonial_id = $this->testimonial_model->update_data($testimonial_id);
          if($testimonial_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."testimonials/edit/$testimonial_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."testimonials/edit/$testimonial_id");
            }
        }else{
			$this->edit($testimonial_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $testimonial_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
		//get order number of this record
        $this_testimonial_where = "testimonial_id = $testimonial_id";
        $this_testimonial = $this->testimonial_model->getBy($this_testimonial_where, true);
        $this_testimonial_id = $testimonial_id;
        $this_testimonial_order = $this_testimonial->order;
        
        
        //get order number of previous record
        $previous_testimonial_where = "order <= $this_testimonial_order AND testimonial_id != $testimonial_id ORDER BY `order` DESC";
        $previous_testimonial = $this->testimonial_model->getBy($previous_testimonial_where, true);
        $previous_testimonial_id = $previous_testimonial->testimonial_id;
        $previous_testimonial_order = $previous_testimonial->order;
        
        //if this is the first element
        if(!$previous_testimonial_id){
            redirect(ADMIN_DIR."testimonials/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_testimonial_inputs = array(
            "order" => $previous_testimonial_order
        );
        $this->testimonial_model->save($this_testimonial_inputs, $this_testimonial_id);
        
        $previous_testimonial_inputs = array(
            "order" => $this_testimonial_order
        );
        $this->testimonial_model->save($previous_testimonial_inputs, $previous_testimonial_id);
        
        
        
        redirect(ADMIN_DIR."testimonials/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $testimonial_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($testimonial_id, $page_id = NULL){
        
        $testimonial_id = (int) $testimonial_id;
        
        
        
        //get order number of this record
         $this_testimonial_where = "testimonial_id = $testimonial_id";
        $this_testimonial = $this->testimonial_model->getBy($this_testimonial_where, true);
        $this_testimonial_id = $testimonial_id;
        $this_testimonial_order = $this_testimonial->order;
        
        
        //get order number of next record
		
        $next_testimonial_where = "order >= $this_testimonial_order and testimonial_id != $testimonial_id ORDER BY `order` ASC";
        $next_testimonial = $this->testimonial_model->getBy($next_testimonial_where, true);
        $next_testimonial_id = $next_testimonial->testimonial_id;
        $next_testimonial_order = $next_testimonial->order;
        
        //if this is the first element
        if(!$next_testimonial_id){
            redirect(ADMIN_DIR."testimonials/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_testimonial_inputs = array(
            "order" => $next_testimonial_order
        );
        $this->testimonial_model->save($this_testimonial_inputs, $this_testimonial_id);
        
        $next_testimonial_inputs = array(
            "order" => $this_testimonial_order
        );
        $this->testimonial_model->save($next_testimonial_inputs, $next_testimonial_id);
        
        
        
        redirect(ADMIN_DIR."testimonials/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["testimonials"] = $this->testimonial_model->getBy($where, false, "testimonial_id" );
				$j_array[]=array("id" => "", "value" => "testimonial");
				foreach($data["testimonials"] as $testimonial ){
					$j_array[]=array("id" => $testimonial->testimonial_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

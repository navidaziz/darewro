<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Slider_banners extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/slider_banner_model");
		$this->lang->load("slider_banners", 'english');
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
		
        $where = "`status` IN (0, 1) ORDER BY `order`";
		$data = $this->slider_banner_model->get_slider_banner_list($where);
		 $this->data["slider_banners"] = $data->slider_banners;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Slider Banners');
		$this->data["view"] = ADMIN_DIR."slider_banners/slider_banners";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_slider_banner($slider_banner_id){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        $this->data["slider_banners"] = $this->slider_banner_model->get_slider_banner($slider_banner_id);
        $this->data["title"] = $this->lang->line('Slider Banner Details');
		$this->data["view"] = ADMIN_DIR."slider_banners/view_slider_banner";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`status` IN (2) ORDER BY `order`";
		$data = $this->slider_banner_model->get_slider_banner_list($where);
		 $this->data["slider_banners"] = $data->slider_banners;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Slider Banners');
		$this->data["view"] = ADMIN_DIR."slider_banners/trashed_slider_banners";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        
        $this->slider_banner_model->changeStatus($slider_banner_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."slider_banners/view/".$page_id);
    }
    
    /**
      * function to restor slider_banner from trash
      * @param $slider_banner_id integer
      */
     public function restore($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        
        $this->slider_banner_model->changeStatus($slider_banner_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."slider_banners/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft slider_banner from trash
      * @param $slider_banner_id integer
      */
     public function draft($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        
        $this->slider_banner_model->changeStatus($slider_banner_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."slider_banners/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish slider_banner from trash
      * @param $slider_banner_id integer
      */
     public function publish($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        
        $this->slider_banner_model->changeStatus($slider_banner_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."slider_banners/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Slider_banner
      * @param $slider_banner_id integer
      */
     public function delete($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        //$this->slider_banner_model->changeStatus($slider_banner_id, "3");
        //Remove file....
						$slider_banners = $this->slider_banner_model->get_slider_banner($slider_banner_id);
						$file_path = $slider_banners[0]->slider_banner_image;
						$this->slider_banner_model->delete_file($file_path);
		$this->slider_banner_model->delete(array( 'slider_banner_id' => $slider_banner_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."slider_banners/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Slider_banner
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Slider Banner');$this->data["view"] = ADMIN_DIR."slider_banners/add_slider_banner";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->slider_banner_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("slider_banner_image")){
                       $_POST['slider_banner_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $slider_banner_id = $this->slider_banner_model->save_data();
          if($slider_banner_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."slider_banners/edit/$slider_banner_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."slider_banners/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Slider_banner
      */
     public function edit($slider_banner_id){
		 $slider_banner_id = (int) $slider_banner_id;
        $this->data["slider_banner"] = $this->slider_banner_model->get($slider_banner_id);
		  
        $this->data["title"] = $this->lang->line('Edit Slider Banner');$this->data["view"] = ADMIN_DIR."slider_banners/edit_slider_banner";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($slider_banner_id){
		 
		 $slider_banner_id = (int) $slider_banner_id;
       
	   if($this->slider_banner_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("slider_banner_image")){
                         $_POST["slider_banner_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $slider_banner_id = $this->slider_banner_model->update_data($slider_banner_id);
          if($slider_banner_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."slider_banners/edit/$slider_banner_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."slider_banners/edit/$slider_banner_id");
            }
        }else{
			$this->edit($slider_banner_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $slider_banner_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
		//get order number of this record
        $this_slider_banner_where = "slider_banner_id = $slider_banner_id";
        $this_slider_banner = $this->slider_banner_model->getBy($this_slider_banner_where, true);
        $this_slider_banner_id = $slider_banner_id;
        $this_slider_banner_order = $this_slider_banner->order;
        
        
        //get order number of previous record
        $previous_slider_banner_where = "order <= $this_slider_banner_order AND slider_banner_id != $slider_banner_id ORDER BY `order` DESC";
        $previous_slider_banner = $this->slider_banner_model->getBy($previous_slider_banner_where, true);
        $previous_slider_banner_id = $previous_slider_banner->slider_banner_id;
        $previous_slider_banner_order = $previous_slider_banner->order;
        
        //if this is the first element
        if(!$previous_slider_banner_id){
            redirect(ADMIN_DIR."slider_banners/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_slider_banner_inputs = array(
            "order" => $previous_slider_banner_order
        );
        $this->slider_banner_model->save($this_slider_banner_inputs, $this_slider_banner_id);
        
        $previous_slider_banner_inputs = array(
            "order" => $this_slider_banner_order
        );
        $this->slider_banner_model->save($previous_slider_banner_inputs, $previous_slider_banner_id);
        
        
        
        redirect(ADMIN_DIR."slider_banners/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $slider_banner_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($slider_banner_id, $page_id = NULL){
        
        $slider_banner_id = (int) $slider_banner_id;
        
        
        
        //get order number of this record
         $this_slider_banner_where = "slider_banner_id = $slider_banner_id";
        $this_slider_banner = $this->slider_banner_model->getBy($this_slider_banner_where, true);
        $this_slider_banner_id = $slider_banner_id;
        $this_slider_banner_order = $this_slider_banner->order;
        
        
        //get order number of next record
		
        $next_slider_banner_where = "order >= $this_slider_banner_order and slider_banner_id != $slider_banner_id ORDER BY `order` ASC";
        $next_slider_banner = $this->slider_banner_model->getBy($next_slider_banner_where, true);
        $next_slider_banner_id = $next_slider_banner->slider_banner_id;
        $next_slider_banner_order = $next_slider_banner->order;
        
        //if this is the first element
        if(!$next_slider_banner_id){
            redirect(ADMIN_DIR."slider_banners/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_slider_banner_inputs = array(
            "order" => $next_slider_banner_order
        );
        $this->slider_banner_model->save($this_slider_banner_inputs, $this_slider_banner_id);
        
        $next_slider_banner_inputs = array(
            "order" => $this_slider_banner_order
        );
        $this->slider_banner_model->save($next_slider_banner_inputs, $next_slider_banner_id);
        
        
        
        redirect(ADMIN_DIR."slider_banners/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["slider_banners"] = $this->slider_banner_model->getBy($where, false, "slider_banner_id" );
				$j_array[]=array("id" => "", "value" => "slider_banner");
				foreach($data["slider_banners"] as $slider_banner ){
					$j_array[]=array("id" => $slider_banner->slider_banner_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

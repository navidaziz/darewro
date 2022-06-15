<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Album_images extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/album_image_model");
		$this->lang->load("album_images", 'english');
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
		
        $where = "`album_images`.`status` IN (0, 1) ORDER BY `album_images`.`order`";
		$data = $this->album_image_model->get_album_image_list($where);
		 $this->data["album_images"] = $data->album_images;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Album Images');
		$this->data["view"] = ADMIN_DIR."album_images/album_images";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_album_image($album_image_id){
        
        $album_image_id = (int) $album_image_id;
        
        $this->data["album_images"] = $this->album_image_model->get_album_image($album_image_id);
        $this->data["title"] = $this->lang->line('Album Image Details');
		$this->data["view"] = ADMIN_DIR."album_images/view_album_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`album_images`.`status` IN (2) ORDER BY `album_images`.`order`";
		$data = $this->album_image_model->get_album_image_list($where);
		 $this->data["album_images"] = $data->album_images;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Album Images');
		$this->data["view"] = ADMIN_DIR."album_images/trashed_album_images";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
        
        $this->album_image_model->changeStatus($album_image_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."album_images/view/".$page_id);
    }
    
    /**
      * function to restor album_image from trash
      * @param $album_image_id integer
      */
     public function restore($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
        
        $this->album_image_model->changeStatus($album_image_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."album_images/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft album_image from trash
      * @param $album_image_id integer
      */
     public function draft($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
        
        $this->album_image_model->changeStatus($album_image_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."gallery/view_gallery/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish album_image from trash
      * @param $album_image_id integer
      */
     public function publish($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
        
        $this->album_image_model->changeStatus($album_image_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."gallery/view_gallery/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Album_image
      * @param $album_image_id integer
      */
     public function delete($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        //$this->album_image_model->changeStatus($album_image_id, "3");
        //Remove file....
						$album_images = $this->album_image_model->get_album_image($album_image_id);
						$file_path = $album_images[0]->image;
						
						$query = "SELECT COUNT(image) as total_count FROM gallery WHERE image = '".$file_path."'";
						$query_result = $this->db->query($query);
						$image_count = $query_result->result()[0]->total_count;
						if(!$image_count){
							$this->album_image_model->delete_file($file_path);
							$this->album_image_model->delete(array( 'album_image_id' => $album_image_id));
							$this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
							redirect(ADMIN_DIR."gallery/view_gallery/".$page_id);
							}else{
							$this->session->set_flashdata("msg_success", $this->lang->line("its a cover image"));
							redirect(ADMIN_DIR."gallery/view_gallery/".$page_id);	
								}
						
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Album_image
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Album Image');$this->data["view"] = ADMIN_DIR."album_images/add_album_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->album_image_model->validate_form_data() === TRUE){
		  
                    /*if($this->upload_file("image")){
                       $_POST['image'] = $this->data["upload_data"]["file_name"];
                    }*/
                    
		  $album_image_id = $this->album_image_model->save_data();
          if($album_image_id){
			  
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."album_images/edit/$album_image_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."album_images/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Album_image
      */
     public function edit($album_image_id){
		 $album_image_id = (int) $album_image_id;
        $this->data["album_image"] = $this->album_image_model->get($album_image_id);
		  
        $this->data["title"] = $this->lang->line('Edit Album Image');
		$this->data["view"] = ADMIN_DIR."album_images/edit_album_image";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($album_image_id){
		 
		 $album_image_id = (int) $album_image_id;
		 $gallery_id = $this->input->post("gallery_id");
         
		 $album_image_id = $this->album_image_model->update_data($album_image_id);
          if($album_image_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."gallery/view_gallery/$gallery_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."gallery/view_gallery/$gallery_id");
            }
        
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $album_image_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
		//get order number of this record
        $this_album_image_where = "album_image_id = $album_image_id";
        $this_album_image = $this->album_image_model->getBy($this_album_image_where, true);
        $this_album_image_id = $album_image_id;
        $this_album_image_order = $this_album_image->order;
        
        
        //get order number of previous record
        $previous_album_image_where = "order <= $this_album_image_order AND album_image_id != $album_image_id ORDER BY `order` DESC";
        $previous_album_image = $this->album_image_model->getBy($previous_album_image_where, true);
        $previous_album_image_id = $previous_album_image->album_image_id;
        $previous_album_image_order = $previous_album_image->order;
        
        //if this is the first element
        if(!$previous_album_image_id){
            redirect(ADMIN_DIR."album_images/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_album_image_inputs = array(
            "order" => $previous_album_image_order
        );
        $this->album_image_model->save($this_album_image_inputs, $this_album_image_id);
        
        $previous_album_image_inputs = array(
            "order" => $this_album_image_order
        );
        $this->album_image_model->save($previous_album_image_inputs, $previous_album_image_id);
        
        
        
        redirect(ADMIN_DIR."album_images/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $album_image_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($album_image_id, $page_id = NULL){
        
        $album_image_id = (int) $album_image_id;
        
        
        
        //get order number of this record
         $this_album_image_where = "album_image_id = $album_image_id";
        $this_album_image = $this->album_image_model->getBy($this_album_image_where, true);
        $this_album_image_id = $album_image_id;
        $this_album_image_order = $this_album_image->order;
        
        
        //get order number of next record
		
        $next_album_image_where = "order >= $this_album_image_order and album_image_id != $album_image_id ORDER BY `order` ASC";
        $next_album_image = $this->album_image_model->getBy($next_album_image_where, true);
        $next_album_image_id = $next_album_image->album_image_id;
        $next_album_image_order = $next_album_image->order;
        
        //if this is the first element
        if(!$next_album_image_id){
            redirect(ADMIN_DIR."album_images/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_album_image_inputs = array(
            "order" => $next_album_image_order
        );
        $this->album_image_model->save($this_album_image_inputs, $this_album_image_id);
        
        $next_album_image_inputs = array(
            "order" => $this_album_image_order
        );
        $this->album_image_model->save($next_album_image_inputs, $next_album_image_id);
        
        
        
        redirect(ADMIN_DIR."album_images/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["album_images"] = $this->album_image_model->getBy($where, false, "album_image_id" );
				$j_array[]=array("id" => "", "value" => "album_image");
				foreach($data["album_images"] as $album_image ){
					$j_array[]=array("id" => $album_image->album_image_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Gallery extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/gallery_model");
		$this->load->model("admin/album_image_model");
		$this->lang->load("album_images", 'english');
		$this->lang->load("gallery", 'english');
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
		
        $where = "`gallery`.`status` IN (0, 1) ";
		$data = $this->gallery_model->get_gallery_list($where);
		 $this->data["albums"] = $data->gallery;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Gallery');
		$this->data["view"] = ADMIN_DIR."gallery/gallery";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_gallery($gallery_id){
        
        $this->data['gallery_id'] = $gallery_id = (int) $gallery_id;
        
        $this->data["albums"] = $album = $this->gallery_model->get_gallery($gallery_id);
		
		$where = "`album_images`.`status` IN (0, 1) AND `album_images`.`gallery_id` = $gallery_id ORDER BY `album_images`.`order`";
		$this->data["album_images"] = $this->album_image_model->get_album_image_list($where, FALSE);
		
        //$this->data["title"] = $this->lang->line('Gallery Details');
		 
		$this->data["title"] = $album[0]->album_title;
		$this->data["view"] = ADMIN_DIR."gallery/view_gallery";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`gallery`.`status` IN (2) ";
		$data = $this->gallery_model->get_gallery_list($where);
		 $this->data["albums"] = $data->gallery;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Gallery');
		$this->data["view"] = ADMIN_DIR."gallery/trashed_gallery";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($gallery_id, $page_id = NULL){
        
        $gallery_id = (int) $gallery_id;
        
        
        $this->gallery_model->changeStatus($gallery_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."gallery/view/".$page_id);
    }
    
    /**
      * function to restor gallery from trash
      * @param $gallery_id integer
      */
     public function restore($gallery_id, $page_id = NULL){
        
        $gallery_id = (int) $gallery_id;
        
        
        $this->gallery_model->changeStatus($gallery_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."gallery/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft gallery from trash
      * @param $gallery_id integer
      */
     public function draft($gallery_id, $page_id = NULL){
        
        $gallery_id = (int) $gallery_id;
        
        
        $this->gallery_model->changeStatus($gallery_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."gallery/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish gallery from trash
      * @param $gallery_id integer
      */
     public function publish($gallery_id, $page_id = NULL){
        
        $gallery_id = (int) $gallery_id;
        
        
        $this->gallery_model->changeStatus($gallery_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."gallery/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Gallery
      * @param $gallery_id integer
      */
     public function delete($gallery_id, $page_id = NULL){
        
        $gallery_id = (int) $gallery_id;
		$query="SELECT `album_image_id`, `image` FROM album_images WHERE gallery_id =".$gallery_id;
		$query_result = $this->db->query($query);
		$album_images = $query_result->result();
		foreach($album_images as $album_image){
			$this->album_image_model->delete_file($album_image->image);
			$this->album_image_model->delete(array( 'album_image_id' => $album_image->album_image_id));
			}
        //$this->gallery_model->changeStatus($gallery_id, "3");
        //Remove file....
						$gallery = $this->gallery_model->get_gallery($gallery_id);
						/*$file_path = $gallery[0]->image;
						$this->gallery_model->delete_file($file_path);*/
		$this->gallery_model->delete(array( 'gallery_id' => $gallery_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."gallery/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Gallery
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Gallery');$this->data["view"] = ADMIN_DIR."gallery/add_gallery";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function upload_images(){
		 
			  $_POST['gallery_id'] = $gallery_id =  $this->input->post('gallery_id');
			  
			  $_FILES['temp_images'] = $_FILES['image'];
			  $filesCount = count($_FILES['temp_images']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['image']['name'] = $_FILES['temp_images']['name'][$i];
                $_FILES['image']['type'] = $_FILES['temp_images']['type'][$i];
                $_FILES['image']['tmp_name'] = $_FILES['temp_images']['tmp_name'][$i];
                $_FILES['image']['error'] = $_FILES['temp_images']['error'][$i];
                $_FILES['image']['size'] = $_FILES['temp_images']['size'][$i];
				
				
				if($this->upload_file("image")){
					$_POST['image'] = $this->data["upload_data"]["file_name"];
					
					$_POST['image_detail'] = $_FILES['temp_images']['name'][$i];
					
				
				$album_image_id = $this->album_image_model->save_data();
					
				}else{
					//echo "error";
					}
				/*if($this->upload_file("image")){
					
					
				          
				}*/
				
				
			}
			 
			
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."gallery/view_gallery/$gallery_id");
            
		 }
	 
     public function save_data(){
	  if($this->gallery_model->validate_form_data() === TRUE){
		  
                   /*if($this->upload_file("image")){
                       $_POST['image'] = $this->data["upload_data"]["file_name"];
                    }*/
                    
		  $gallery_id = $this->gallery_model->save_data();
          if($gallery_id){
			  
			  $_FILES['temp_images'] = $_FILES['image'];
			  $filesCount = count($_FILES['temp_images']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['image']['name'] = $_FILES['temp_images']['name'][$i];
                $_FILES['image']['type'] = $_FILES['temp_images']['type'][$i];
                $_FILES['image']['tmp_name'] = $_FILES['temp_images']['tmp_name'][$i];
                $_FILES['image']['error'] = $_FILES['temp_images']['error'][$i];
                $_FILES['image']['size'] = $_FILES['temp_images']['size'][$i];
				
				
				if($this->upload_file("image")){
					$_POST['image'] = $this->data["upload_data"]["file_name"];
					$_POST['gallery_id'] = $gallery_id;
					$_POST['image_detail'] = $_FILES['temp_images']['name'][$i];
					
					if($i == 0){
						$inputs['image'] = $this->router->fetch_class()."/".$_POST['image'];
						$this->gallery_model->save($inputs, $gallery_id);	
					}
				
				$album_image_id = $this->album_image_model->save_data();
					
				}else{
					//echo "error";
					}
				/*if($this->upload_file("image")){
					
					
				          
				}*/
				
				
			}
			 
			
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."gallery/edit/$gallery_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."gallery/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Gallery
      */
     public function edit($gallery_id){
		 $gallery_id = (int) $gallery_id;
        $this->data["albums"] = $this->gallery_model->get($gallery_id);
		  
        $this->data["title"] = $this->lang->line('Edit Gallery');$this->data["view"] = ADMIN_DIR."gallery/edit_gallery";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($gallery_id){
		 
		 $gallery_id = (int) $gallery_id;
       
	   if($this->gallery_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("image")){
                         $_POST["image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $gallery_id = $this->gallery_model->update_data($gallery_id);
          if($gallery_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."gallery/edit/$gallery_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."gallery/edit/$gallery_id");
            }
        }else{
			$this->edit($gallery_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["gallery"] = $this->gallery_model->getBy($where, false, "gallery_id" );
				$j_array[]=array("id" => "", "value" => "gallery");
				foreach($data["gallery"] as $gallery ){
					$j_array[]=array("id" => $gallery->gallery_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

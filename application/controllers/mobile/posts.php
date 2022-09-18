<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Posts extends Admin_Controller_Mobile{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/post_model");
		$this->lang->load("posts", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`posts`.`status` IN (0, 1) ";
		$data = $this->post_model->get_post_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_post($post_id){
        
        $post_id = (int) $post_id;
		$data = $this->post_model->get_post($post_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`posts`.`status` IN (2) ";
		$data = $this->post_model->get_post_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($post_id){
        
        $post_id = (int) $post_id;
		$this->post_model->changeStatus($post_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor post from trash
      * @param $post_id integer
      */
     public function restore($post_id){
        
        $post_id = (int) $post_id;
		$this->post_model->changeStatus($post_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft post from trash
      * @param $post_id integer
      */
     public function draft($post_id){
        
        $post_id = (int) $post_id;
		$this->post_model->changeStatus($post_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish post from trash
      * @param $post_id integer
      */
     public function publish($post_id){
        
        $post_id = (int) $post_id;
		$this->post_model->changeStatus($post_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Post
      * @param $post_id integer
      */
     public function delete($post_id, $page_id = NULL){
        
        $post_id = (int) $post_id;
        //$this->post_model->changeStatus($post_id, "3");
        //Remove file....
						$posts = $this->post_model->get_post($post_id);
						$file_path = $posts[0]->image;
						$this->post_model->delete_file($file_path);$this->post_model->delete(array( 'post_id' => $post_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$post_id = $this->post_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($post_id){
		$post_id = $this->post_model->update_data($post_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        

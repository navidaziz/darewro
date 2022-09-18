<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Posts extends Public_Controller{
    
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
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`status` IN (1) ";
		$data = $this->post_model->get_post_list($where,TRUE, TRUE);
		 $this->data["posts"] = $data->posts;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Posts";
         $this->data["view"] = PUBLIC_DIR."posts/posts";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_post($post_id){
        
        $post_id = (int) $post_id;
        
        $this->data["posts"] = $this->post_model->get_post($post_id);
        $this->data["title"] = "Posts Details";
        $this->data["view"] = PUBLIC_DIR."posts/view_post";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        

<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Post_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "posts";
        $this->pk = "post_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "post_title",
                            "label"  =>  "Post Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "post_summary",
                            "label"  =>  "Post Summary",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "post_detail",
                            "label"  =>  "Post Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "post_type",
                            "label"  =>  "Post Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "post_keywords",
                            "label"  =>  "Post Keywords",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["post_title"]  =  $this->input->post("post_title");
                    
                    $inputs["post_summary"]  =  $this->input->post("post_summary");
                    
                    $inputs["post_detail"]  =  $this->input->post("post_detail");
                    
                    $inputs["post_type"]  =  $this->input->post("post_type");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
                    $inputs["video_link"]  =  $this->input->post("video_link");
                    
                    $inputs["post_keywords"]  =  $this->input->post("post_keywords");
                    
	return $this->post_model->save($inputs);
	}	 	

public function update_data($post_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["post_title"]  =  $this->input->post("post_title");
                    
                    $inputs["post_summary"]  =  $this->input->post("post_summary");
                    
                    $inputs["post_detail"]  =  $this->input->post("post_detail");
                    
                    $inputs["post_type"]  =  $this->input->post("post_type");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$posts = $this->get_post($post_id);
						$file_path = $posts[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
                    $inputs["video_link"]  =  $this->input->post("video_link");
                    
                    $inputs["post_keywords"]  =  $this->input->post("post_keywords");
                    
	return $this->post_model->save($inputs, $post_id);
	}	
	
    //----------------------------------------------------------------
 public function get_post_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("posts.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->post_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->post_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->post_model->joinGet($fields, "posts", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->posts = $this->post_model->joinGet($fields, "posts", $join_table, $where);
			return $data;
		}else{
			return $this->post_model->joinGet($fields, "posts", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_post($post_id){
	
		$fields = array("posts.*");
		$join_table = array();
		$where = "posts.post_id = $post_id";
		
		return $this->post_model->joinGet($fields, "posts", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


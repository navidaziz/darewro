<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Gallery_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "gallery";
        $this->pk = "gallery_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "album_title",
                            "label"  =>  "Album Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "album_description",
                            "label"  =>  "Album Description",
                            "rules"  =>  "required"
                        )
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["album_title"]  =  $this->input->post("album_title");
                    
                    $inputs["album_description"]  =  $this->input->post("album_description");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->gallery_model->save($inputs);
	}	 	

public function update_data($gallery_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["album_title"]  =  $this->input->post("album_title");
                    
                    $inputs["album_description"]  =  $this->input->post("album_description");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$gallery = $this->get_gallery($gallery_id);
						$file_path = $gallery[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->gallery_model->save($inputs, $gallery_id);
	}	
	
    //----------------------------------------------------------------
 public function get_gallery_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("gallery.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->gallery_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->gallery_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->gallery_model->joinGet($fields, "gallery", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->gallery = $this->gallery_model->joinGet($fields, "gallery", $join_table, $where);
			return $data;
		}else{
			return $this->gallery_model->joinGet($fields, "gallery", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_gallery($gallery_id){
	
		$fields = array("gallery.*");
		$join_table = array();
		$where = "gallery.gallery_id = $gallery_id";
		
		return $this->gallery_model->joinGet($fields, "gallery", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Page_content_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "page_contents";
        $this->pk = "page_content_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "page_id",
                            "label"  =>  "Page Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "page_content_title",
                            "label"  =>  "Page Content Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "page_content_sub_title",
                            "label"  =>  "Page Content Sub Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "page_content_detail",
                            "label"  =>  "Page Content Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["page_id"]  =  $this->input->post("page_id");
                    
                    $inputs["page_content_title"]  =  $this->input->post("page_content_title");
                    
                    $inputs["page_content_sub_title"]  =  $this->input->post("page_content_sub_title");
                    
                    $inputs["page_content_detail"]  =  $this->input->post("page_content_detail");
                    
                    if($_FILES["attachment"]["size"] > 0){
                        $inputs["attachment"]  =  $this->router->fetch_class()."/".$this->input->post("attachment");
                    }
                    
	return $this->page_content_model->save($inputs);
	}	 	

public function update_data($page_content_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["page_id"]  =  $this->input->post("page_id");
                    
                    $inputs["page_content_title"]  =  $this->input->post("page_content_title");
                    
                    $inputs["page_content_sub_title"]  =  $this->input->post("page_content_sub_title");
                    
                    $inputs["page_content_detail"]  =  $this->input->post("page_content_detail");
                    
                    if($_FILES["attachment"]["size"] > 0){
						//remove previous file....
						$page_contents = $this->get_page_content($page_content_id);
						$file_path = $page_contents[0]->attachment;
						$this->delete_file($file_path);
                        $inputs["attachment"]  =  $this->router->fetch_class()."/".$this->input->post("attachment");
                    }
                    
	return $this->page_content_model->save($inputs, $page_content_id);
	}	
	
    //----------------------------------------------------------------
 public function get_page_content_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("page_contents.*"
                , "pages.page_name"
            );
		$join_table = array(
            "pages" => "pages.PAGE_ID = page_contents.PAGE_ID",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->page_content_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->page_content_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->page_content_model->joinGet($fields, "page_contents", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->page_contents = $this->page_content_model->joinGet($fields, "page_contents", $join_table, $where);
			return $data;
		}else{
			return $this->page_content_model->joinGet($fields, "page_contents", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_page_content($page_content_id){
	
		$fields = array("page_contents.*"
                , "pages.page_name"
            );
		$join_table = array(
            "pages" => "pages.PAGE_ID = page_contents.PAGE_ID",
        );
		$where = "page_contents.page_content_id = $page_content_id";
		
		return $this->page_content_model->joinGet($fields, "page_contents", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


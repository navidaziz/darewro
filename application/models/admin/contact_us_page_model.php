<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Contact_us_page_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "contact_us_page";
        $this->pk = "contact_us_page_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "contact_us_page_content",
                            "label"  =>  "Contact Us Page Content",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "contact_us_page_title",
                            "label"  =>  "Contact Us Page Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "contact_us_page_description",
                            "label"  =>  "Contact Us Page Description",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "contact_us_page_keyword",
                            "label"  =>  "Contact Us Page Keyword",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "google_map_link",
                            "label"  =>  "Google Map Link",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["contact_us_page_content"]  =  $this->input->post("contact_us_page_content");
                    
                    $inputs["contact_us_page_title"]  =  $this->input->post("contact_us_page_title");
                    
                    $inputs["contact_us_page_description"]  =  $this->input->post("contact_us_page_description");
                    
                    $inputs["contact_us_page_keyword"]  =  $this->input->post("contact_us_page_keyword");
                    
                    $inputs["google_map_link"]  =  $this->input->post("google_map_link");
                    
	return $this->contact_us_page_model->save($inputs);
	}	 	

public function update_data($contact_us_page_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["contact_us_page_content"]  =  $this->input->post("contact_us_page_content");
                    
                    $inputs["contact_us_page_title"]  =  $this->input->post("contact_us_page_title");
                    
                    $inputs["contact_us_page_description"]  =  $this->input->post("contact_us_page_description");
                    
                    $inputs["contact_us_page_keyword"]  =  $this->input->post("contact_us_page_keyword");
                    
                    $inputs["google_map_link"]  =  $this->input->post("google_map_link");
                    
	return $this->contact_us_page_model->save($inputs, $contact_us_page_id);
	}	
	
    //----------------------------------------------------------------
 public function get_contact_us_page_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("contact_us_page.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->contact_us_page_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->contact_us_page_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->contact_us_page_model->joinGet($fields, "contact_us_page", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->contact_us_page = $this->contact_us_page_model->joinGet($fields, "contact_us_page", $join_table, $where);
			return $data;
		}else{
			return $this->contact_us_page_model->joinGet($fields, "contact_us_page", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_contact_us_page($contact_us_page_id){
	
		$fields = array("contact_us_page.*");
		$join_table = array();
		$where = "contact_us_page.contact_us_page_id = $contact_us_page_id";
		
		return $this->contact_us_page_model->joinGet($fields, "contact_us_page", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


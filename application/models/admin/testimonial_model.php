<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Testimonial_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "testimonials";
        $this->pk = "testimonial_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "client_name",
                            "label"  =>  "Client Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "client_designation",
                            "label"  =>  "Client Designation",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "statement",
                            "label"  =>  "Statement",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["client_name"]  =  $this->input->post("client_name");
                    
                    $inputs["client_designation"]  =  $this->input->post("client_designation");
                    
                    $inputs["statement"]  =  $this->input->post("statement");
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->testimonial_model->save($inputs);
	}	 	

public function update_data($testimonial_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["client_name"]  =  $this->input->post("client_name");
                    
                    $inputs["client_designation"]  =  $this->input->post("client_designation");
                    
                    $inputs["statement"]  =  $this->input->post("statement");
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$testimonials = $this->get_testimonial($testimonial_id);
						$file_path = $testimonials[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->testimonial_model->save($inputs, $testimonial_id);
	}	
	
    //----------------------------------------------------------------
 public function get_testimonial_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("testimonials.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->testimonial_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->testimonial_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->testimonial_model->joinGet($fields, "testimonials", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->testimonials = $this->testimonial_model->joinGet($fields, "testimonials", $join_table, $where);
			return $data;
		}else{
			return $this->testimonial_model->joinGet($fields, "testimonials", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_testimonial($testimonial_id){
	
		$fields = array("testimonials.*");
		$join_table = array();
		$where = "testimonials.testimonial_id = $testimonial_id";
		
		return $this->testimonial_model->joinGet($fields, "testimonials", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


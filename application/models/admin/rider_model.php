<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Rider_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "riders";
        $this->pk = "rider_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "rider_name",
                            "label"  =>  "Rider Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "office_no",
                            "label"  =>  "Office No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "personal_no",
                            "label"  =>  "Personal No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "duty_start",
                            "label"  =>  "Duty Start",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "duty_end",
                            "label"  =>  "Duty End",
                            "rules"  =>  "required"
                        ),
                        
                        
                        
                        array(
                            "field"  =>  "ability_level",
                            "label"  =>  "Ability Level",
                            "rules"  =>  "required"
                        )
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["rider_name"]  =  $this->input->post("rider_name");
                    
                    if($_FILES["rider_image"]["size"] > 0){
                        $inputs["rider_image"]  =  $this->router->fetch_class()."/".$this->input->post("rider_image");
                    }
                    
                    $inputs["office_no"]  =  $this->input->post("office_no");
                    
                    $inputs["personal_no"]  =  $this->input->post("personal_no");
                    
                    $inputs["duty_start"]  =  $this->input->post("duty_start");
                    
                    $inputs["duty_end"]  =  $this->input->post("duty_end");
                    
                    $inputs["is_available"]  =  $this->input->post("is_available");
                    
                    $inputs["is_absent"]  =  $this->input->post("is_absent");
                    
                    $inputs["ability_level"]  =  $this->input->post("ability_level");
                    
                    $inputs["comments"]  =  $this->input->post("comments");
                    
	return $this->rider_model->save($inputs);
	}	 	

public function update_data($rider_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["rider_name"]  =  $this->input->post("rider_name");
                    
                    if($_FILES["rider_image"]["size"] > 0){
						//remove previous file....
						$riders = $this->get_rider($rider_id);
						$file_path = $riders[0]->rider_image;
						$this->delete_file($file_path);
                        $inputs["rider_image"]  =  $this->router->fetch_class()."/".$this->input->post("rider_image");
                    }
                    
                    $inputs["office_no"]  =  $this->input->post("office_no");
                    
                    $inputs["personal_no"]  =  $this->input->post("personal_no");
                    
                    $inputs["duty_start"]  =  $this->input->post("duty_start");
                    
                    $inputs["duty_end"]  =  $this->input->post("duty_end");
                    
                    $inputs["is_available"]  =  $this->input->post("is_available");
                    
                    $inputs["is_absent"]  =  $this->input->post("is_absent");
                    
                    $inputs["ability_level"]  =  $this->input->post("ability_level");
                    
                    $inputs["comments"]  =  $this->input->post("comments");
                    
	return $this->rider_model->save($inputs, $rider_id);
	}	
	
    //----------------------------------------------------------------
 public function get_rider_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("riders.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->rider_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					
					$this->rider_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->rider_model->joinGet($fields, "riders", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->riders = $this->rider_model->joinGet($fields, "riders", $join_table, $where);
			return $data;
		}else{
			return $this->rider_model->joinGet($fields, "riders", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_rider($rider_id){
	
		$fields = array("riders.*");
		$join_table = array();
		$where = "riders.rider_id = $rider_id";
		
		return $this->rider_model->joinGet($fields, "riders", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


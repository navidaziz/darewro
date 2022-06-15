<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Service_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "services";
        $this->pk = "service_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "service_title",
                            "label"  =>  "Service Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "service_summery",
                            "label"  =>  "Service Summery",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "service_discription",
                            "label"  =>  "Service Discription",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["service_title"]  =  $this->input->post("service_title");
                    
                    $inputs["service_summery"]  =  $this->input->post("service_summery");
                    
                    $inputs["service_discription"]  =  $this->input->post("service_discription");
                    
                    if($_FILES["service_image"]["size"] > 0){
                        $inputs["service_image"]  =  $this->router->fetch_class()."/".$this->input->post("service_image");
                    }
                    
	return $this->service_model->save($inputs);
	}	 	

public function update_data($service_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["service_title"]  =  $this->input->post("service_title");
                    
                    $inputs["service_summery"]  =  $this->input->post("service_summery");
                    
                    $inputs["service_discription"]  =  $this->input->post("service_discription");
                    
                    if($_FILES["service_image"]["size"] > 0){
						//remove previous file....
						$services = $this->get_service($service_id);
						$file_path = $services[0]->service_image;
						$this->delete_file($file_path);
                        $inputs["service_image"]  =  $this->router->fetch_class()."/".$this->input->post("service_image");
                    }
                    
	return $this->service_model->save($inputs, $service_id);
	}	
	
    //----------------------------------------------------------------
 public function get_service_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("services.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->service_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->service_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->service_model->joinGet($fields, "services", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->services = $this->service_model->joinGet($fields, "services", $join_table, $where);
			return $data;
		}else{
			return $this->service_model->joinGet($fields, "services", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_service($service_id){
	
		$fields = array("services.*");
		$join_table = array();
		$where = "services.service_id = $service_id";
		
		return $this->service_model->joinGet($fields, "services", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


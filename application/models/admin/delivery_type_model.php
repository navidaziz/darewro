<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Delivery_type_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "delivery_types";
        $this->pk = "delivery_type_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "delivery_type_title",
                            "label"  =>  "Delivery Type Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expected_charges",
                            "label"  =>  "Expected Charges",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expected_delivery_time",
                            "label"  =>  "Expected Delivery Time",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["delivery_type_title"]  =  $this->input->post("delivery_type_title");
                    
                    $inputs["expected_charges"]  =  $this->input->post("expected_charges");
                    
                    $inputs["expected_delivery_time"]  =  $this->input->post("expected_delivery_time");
                    
	return $this->delivery_type_model->save($inputs);
	}	 	

public function update_data($delivery_type_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["delivery_type_title"]  =  $this->input->post("delivery_type_title");
                    
                    $inputs["expected_charges"]  =  $this->input->post("expected_charges");
                    
                    $inputs["expected_delivery_time"]  =  $this->input->post("expected_delivery_time");
                    
	return $this->delivery_type_model->save($inputs, $delivery_type_id);
	}	
	
    //----------------------------------------------------------------
 public function get_delivery_type_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("delivery_types.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->delivery_type_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->delivery_type_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->delivery_type_model->joinGet($fields, "delivery_types", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->delivery_types = $this->delivery_type_model->joinGet($fields, "delivery_types", $join_table, $where);
			return $data;
		}else{
			return $this->delivery_type_model->joinGet($fields, "delivery_types", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_delivery_type($delivery_type_id){
	
		$fields = array("delivery_types.*");
		$join_table = array();
		$where = "delivery_types.delivery_type_id = $delivery_type_id";
		
		return $this->delivery_type_model->joinGet($fields, "delivery_types", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Message_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "messages";
        $this->pk = "message_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "name",
                            "label"  =>  "Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "email_address",
                            "label"  =>  "Email Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "other_detail",
                            "label"  =>  "Other Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["email_address"]  =  $this->input->post("email_address");
                    
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["moving_from"]  =  $this->input->post("moving_from");
                    
                    $inputs["moving_to"]  =  $this->input->post("moving_to");
                    
                    $inputs["movement_expected_date"]  =  $this->input->post("movement_expected_date");
                    
                    $inputs["other_detail"]  =  $this->input->post("other_detail");
                    
	return $this->message_model->save($inputs);
	}	 	

public function update_data($message_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["email_address"]  =  $this->input->post("email_address");
                    
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["moving_from"]  =  $this->input->post("moving_from");
                    
                    $inputs["moving_to"]  =  $this->input->post("moving_to");
                    
                    $inputs["movement_expected_date"]  =  $this->input->post("movement_expected_date");
                    
                    $inputs["other_detail"]  =  $this->input->post("other_detail");
                    
	return $this->message_model->save($inputs, $message_id);
	}	
	
    //----------------------------------------------------------------
 public function get_message_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("messages.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->message_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->message_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->message_model->joinGet($fields, "messages", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->messages = $this->message_model->joinGet($fields, "messages", $join_table, $where);
			return $data;
		}else{
			return $this->message_model->joinGet($fields, "messages", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_message($message_id){
	
		$fields = array("messages.*");
		$join_table = array();
		$where = "messages.message_id = $message_id";
		
		return $this->message_model->joinGet($fields, "messages", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


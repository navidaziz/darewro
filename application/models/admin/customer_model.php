<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Customer_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "customers";
        $this->pk = "customer_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "mobile_number",
                            "label"  =>  "Mobile Number",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "customer_name",
                            "label"  =>  "Customer Name",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["customer_name"]  =  $this->input->post("customer_name");
                    
                    $inputs["comment"]  =  $this->input->post("comment");
                    
                    $inputs["customer_email_address"]  =  $this->input->post("customer_email_address");
                    
	return $this->customer_model->save($inputs);
	}	 	

public function update_data($customer_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["mobile_number"]  =  $this->input->post("mobile_number");
                    
                    $inputs["customer_name"]  =  $this->input->post("customer_name");
                    
                    $inputs["comment"]  =  $this->input->post("comment");
                    
                    $inputs["customer_email_address"]  =  $this->input->post("customer_email_address");
                    
	return $this->customer_model->save($inputs, $customer_id);
	}	
	
    //----------------------------------------------------------------
 public function get_customer_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("customers.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 30;
					$config['uri_segment'] = 3;
					$this->customer_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					
					$this->customer_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
					
			$config["total_rows"] = $this->customer_model->joinGet($fields, "customers", $join_table, $where, true);
			
	        $this->pagination->initialize($config);
			
	        $data->pagination = $this->pagination->create_links();
			$data->customers = $this->customer_model->joinGet($fields, "customers", $join_table, $where);
			return $data;
		}else{
			return $this->customer_model->joinGet($fields, "customers", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_customer($customer_id){
	
		$fields = array("customers.*");
		$join_table = array();
		$where = "customers.customer_id = $customer_id";
		
		return $this->customer_model->joinGet($fields, "customers", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Customer_location_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "customer_locations";
        $this->pk = "customer_location_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "location_address",
                            "label"  =>  "Location Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "latitude",
                            "label"  =>  "Latitude",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "longitude",
                            "label"  =>  "Longitude",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "street_number",
                            "label"  =>  "Street Number",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "route",
                            "label"  =>  "Route",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "city",
                            "label"  =>  "City",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "province",
                            "label"  =>  "Province",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "country",
                            "label"  =>  "Country",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "postal_code",
                            "label"  =>  "Postal Code",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["location_address"]  =  $this->input->post("location_address");
                    
                    $inputs["latitude"]  =  $this->input->post("latitude");
                    
                    $inputs["longitude"]  =  $this->input->post("longitude");
                    
                    $inputs["street_number"]  =  $this->input->post("street_number");
                    
                    $inputs["route"]  =  $this->input->post("route");
                    
                    $inputs["city"]  =  $this->input->post("city");
                    
                    $inputs["province"]  =  $this->input->post("province");
                    
                    $inputs["country"]  =  $this->input->post("country");
                    
                    $inputs["postal_code"]  =  $this->input->post("postal_code");
                    
	return $this->customer_location_model->save($inputs);
	}	 	

public function update_data($customer_location_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["location_address"]  =  $this->input->post("location_address");
                    
                    $inputs["latitude"]  =  $this->input->post("latitude");
                    
                    $inputs["longitude"]  =  $this->input->post("longitude");
                    
                    $inputs["street_number"]  =  $this->input->post("street_number");
                    
                    $inputs["route"]  =  $this->input->post("route");
                    
                    $inputs["city"]  =  $this->input->post("city");
                    
                    $inputs["province"]  =  $this->input->post("province");
                    
                    $inputs["country"]  =  $this->input->post("country");
                    
                    $inputs["postal_code"]  =  $this->input->post("postal_code");
                    
	return $this->customer_location_model->save($inputs, $customer_location_id);
	}	
	
    //----------------------------------------------------------------
 public function get_customer_location_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("customer_locations.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->customer_location_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->customer_location_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->customer_location_model->joinGet($fields, "customer_locations", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->customer_locations = $this->customer_location_model->joinGet($fields, "customer_locations", $join_table, $where);
			return $data;
		}else{
			return $this->customer_location_model->joinGet($fields, "customer_locations", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_customer_location($customer_location_id){
	
		$fields = array("customer_locations.*");
		$join_table = array();
		$where = "customer_locations.customer_location_id = $customer_location_id";
		
		return $this->customer_location_model->joinGet($fields, "customer_locations", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


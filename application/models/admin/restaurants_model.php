<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Restaurants_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "restaurants";
        $this->pk = "restaurant_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "restaurant_name",
                            "label"  =>  "Restaurant Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_location",
                            "label"  =>  "Restaurant Location",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_detail",
                            "label"  =>  "Restaurant Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_contact_no",
                            "label"  =>  "Restaurant Contact No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_start_time",
                            "label"  =>  "Restaurant Start Time",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_close_time",
                            "label"  =>  "Restaurant Close Time",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_name"]  =  $this->input->post("restaurant_name");
                    
                    $inputs["restaurant_location"]  =  $this->input->post("restaurant_location");
                    
                    $inputs["restaurant_detail"]  =  $this->input->post("restaurant_detail");
                    
                    $inputs["restaurant_contact_no"]  =  $this->input->post("restaurant_contact_no");
                    
                    if($_FILES["restaurant_logo"]["size"] > 0){
                        $inputs["restaurant_logo"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_logo");
                    }
                    
                    $inputs["restaurant_start_time"]  =  $this->input->post("restaurant_start_time");
                    
                    $inputs["restaurant_close_time"]  =  $this->input->post("restaurant_close_time");
					
					 $inputs["restaurant_latitude"]  =  $this->input->post("restaurant_latitude");
					 $inputs["restaurant_longitude"]  =  $this->input->post("restaurant_longitude");
					 
					 
					//$inputs["restaurant_address"]  =  $this->input->post("restaurant_address");
					
					$inputs["restaurant_address"]  =  ucwords(strtolower($this->input->post("restaurant_name").", ".$this->input->post("restaurant_street_number").", ".$this->input->post("restaurant_route").", ".$this->input->post("restaurant_city").", ".$this->input->post("restaurant_province").", ".$this->input->post("restaurant_country")));
					
					$inputs["restaurant_street_number"]  =  $this->input->post("restaurant_street_number");
					$inputs["restaurant_route"]  =  $this->input->post("restaurant_route"); 
					$inputs["restaurant_city"]  =  $this->input->post("restaurant_city");
					$inputs["restaurant_province"]  =  $this->input->post("restaurant_province");
					$inputs["restaurant_country"]  =  $this->input->post("restaurant_country");
						 
					 
					 
                    
	return $this->restaurants_model->save($inputs);
	}	 	

public function update_data($restaurant_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_name"]  =  $this->input->post("restaurant_name");
                    
                    $inputs["restaurant_location"]  =  $this->input->post("restaurant_location");
                    
                    $inputs["restaurant_detail"]  =  $this->input->post("restaurant_detail");
                    $inputs["restaurant_contact_no"]  =  $this->input->post("restaurant_contact_no");
                    $inputs["restaurant_latitude"]  =  $this->input->post("restaurant_latitude");
					 $inputs["restaurant_longitude"]  =  $this->input->post("restaurant_longitude");
					 
					 
					 
					//$inputs["restaurant_address"]  =  $this->input->post("restaurant_address");
					
					$inputs["restaurant_address"]  =  ucwords(strtolower($this->input->post("restaurant_name").", ".$this->input->post("restaurant_street_number").", ".$this->input->post("restaurant_route").", ".$this->input->post("restaurant_city").", ".$this->input->post("restaurant_province").", ".$this->input->post("restaurant_country")));
					$inputs["restaurant_street_number"]  =  $this->input->post("restaurant_street_number");
					$inputs["restaurant_route"]  =  $this->input->post("restaurant_route"); 
					$inputs["restaurant_city"]  =  $this->input->post("restaurant_city");
					$inputs["restaurant_province"]  =  $this->input->post("restaurant_province");
					$inputs["restaurant_country"]  =  $this->input->post("restaurant_country");
                    
                    if($_FILES["restaurant_logo"]["size"] > 0){
						//remove previous file....
						$restaurants = $this->get_restaurants($restaurant_id);
						$file_path = $restaurants[0]->restaurant_logo;
						$this->delete_file($file_path);
                        $inputs["restaurant_logo"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_logo");
                    }
                    
                    $inputs["restaurant_start_time"]  =  $this->input->post("restaurant_start_time");
                    
                    $inputs["restaurant_close_time"]  =  $this->input->post("restaurant_close_time");
                    
	return $this->restaurants_model->save($inputs, $restaurant_id);
	}	
	
    //----------------------------------------------------------------
 public function get_restaurants_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("restaurants.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->restaurants_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->restaurants_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->restaurants_model->joinGet($fields, "restaurants", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->restaurants = $this->restaurants_model->joinGet($fields, "restaurants", $join_table, $where);
			return $data;
		}else{
			return $this->restaurants_model->joinGet($fields, "restaurants", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_restaurants($restaurant_id){
	
		$fields = array("restaurants.*");
		$join_table = array();
		$where = "restaurants.restaurant_id = $restaurant_id";
		
		return $this->restaurants_model->joinGet($fields, "restaurants", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


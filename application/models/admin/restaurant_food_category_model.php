<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Restaurant_food_category_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "restaurant_food_categories";
        $this->pk = "restaurant_food_category_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "restaurant_food_category",
                            "label"  =>  "Restaurant Food Category",
                            "rules"  =>  "required"
                        )
                      
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_food_category"]  =  $this->input->post("restaurant_food_category");
                    
                    if($_FILES["restaurant_food_category_image"]["size"] > 0){
                        $inputs["restaurant_food_category_image"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_food_category_image");
                    }
                    
	return $this->restaurant_food_category_model->save($inputs);
	}	 	

public function update_data($restaurant_food_category_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_food_category"]  =  $this->input->post("restaurant_food_category");
                    
                    if($_FILES["restaurant_food_category_image"]["size"] > 0){
						//remove previous file....
						$restaurant_food_categories = $this->get_restaurant_food_category($restaurant_food_category_id);
						$file_path = $restaurant_food_categories[0]->restaurant_food_category_image;
						$this->delete_file($file_path);
                        $inputs["restaurant_food_category_image"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_food_category_image");
                    }
                    
	return $this->restaurant_food_category_model->save($inputs, $restaurant_food_category_id);
	}	
	
    //----------------------------------------------------------------
 public function get_restaurant_food_category_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("restaurant_food_categories.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->restaurant_food_category_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->restaurant_food_category_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->restaurant_food_category_model->joinGet($fields, "restaurant_food_categories", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->restaurant_food_categories = $this->restaurant_food_category_model->joinGet($fields, "restaurant_food_categories", $join_table, $where);
			return $data;
		}else{
			return $this->restaurant_food_category_model->joinGet($fields, "restaurant_food_categories", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_restaurant_food_category($restaurant_food_category_id){
	
		$fields = array("restaurant_food_categories.*");
		$join_table = array();
		$where = "restaurant_food_categories.restaurant_food_category_id = $restaurant_food_category_id";
		
		return $this->restaurant_food_category_model->joinGet($fields, "restaurant_food_categories", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


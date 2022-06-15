<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Restaurant_food_menu_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "restaurant_food_menus";
        $this->pk = "restaurant_food_menu_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "restaurant_food_category_id",
                            "label"  =>  "Restaurant Food Category Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_id",
                            "label"  =>  "Restaurant Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_food_name",
                            "label"  =>  "Restaurant Food Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "restaurant_food_price",
                            "label"  =>  "Restaurant Food Price",
                            "rules"  =>  "required"
                        ),
                        
                       /* array(
                            "field"  =>  "restaurant_food_quantity",
                            "label"  =>  "Restaurant Food Quantity",
                            "rules"  =>  "required"
                        ),*/
                        
                       /* array(
                            "field"  =>  "restaurant_food_description",
                            "label"  =>  "Restaurant Food Description",
                            "rules"  =>  "required"
                        ),*/
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_food_category_id"]  =  $this->input->post("restaurant_food_category_id");
                    
                    $inputs["restaurant_id"]  =  $this->input->post("restaurant_id");
                    
                    $inputs["restaurant_food_name"]  =  $this->input->post("restaurant_food_name");
                    
                    $inputs["restaurant_food_price"]  =  $this->input->post("restaurant_food_price");
                    
                    $inputs["restaurant_food_quantity"]  =  $this->input->post("restaurant_food_quantity");
                    
                    $inputs["restaurant_food_description"]  =  $this->input->post("restaurant_food_description");
                    
                    if($_FILES["restaurant_food_image"]["size"] > 0){
                        $inputs["restaurant_food_image"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_food_image");
                    }
                    
	return $this->restaurant_food_menu_model->save($inputs);
	}	 	

public function update_data($restaurant_food_menu_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["restaurant_food_category_id"]  =  $this->input->post("restaurant_food_category_id");
                    
                    $inputs["restaurant_id"]  =  $this->input->post("restaurant_id");
                    
                    $inputs["restaurant_food_name"]  =  $this->input->post("restaurant_food_name");
                    
                    $inputs["restaurant_food_price"]  =  $this->input->post("restaurant_food_price");
                    
                    $inputs["restaurant_food_quantity"]  =  $this->input->post("restaurant_food_quantity");
                    
                    $inputs["restaurant_food_description"]  =  $this->input->post("restaurant_food_description");
                    
                    if($_FILES["restaurant_food_image"]["size"] > 0){
						//remove previous file....
						$restaurant_food_menus = $this->get_restaurant_food_menu($restaurant_food_menu_id);
						$file_path = $restaurant_food_menus[0]->restaurant_food_image;
						$this->delete_file($file_path);
                        $inputs["restaurant_food_image"]  =  $this->router->fetch_class()."/".$this->input->post("restaurant_food_image");
                    }
                    
	return $this->restaurant_food_menu_model->save($inputs, $restaurant_food_menu_id);
	}	
	
    //----------------------------------------------------------------
 public function get_restaurant_food_menu_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("restaurant_food_menus.*"
                , "restaurant_food_categories.restaurant_food_category"
            
                , "restaurants.restaurant_name"
            );
		$join_table = array(
            "restaurant_food_categories" => "restaurant_food_categories.restaurant_food_category_id = restaurant_food_menus.restaurant_food_category_id",
        
            "restaurants" => "restaurants.restaurant_id = restaurant_food_menus.restaurant_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->restaurant_food_menu_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->restaurant_food_menu_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->restaurant_food_menu_model->joinGet($fields, "restaurant_food_menus", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->restaurant_food_menus = $this->restaurant_food_menu_model->joinGet($fields, "restaurant_food_menus", $join_table, $where);
			return $data;
		}else{
			return $this->restaurant_food_menu_model->joinGet($fields, "restaurant_food_menus", $join_table, $where, FALSE, TRUE, 'restaurant_food_name ASC');
		}
		
	}

public function get_restaurant_food_menu($restaurant_food_menu_id){
	
		$fields = array("restaurant_food_menus.*"
                , "restaurant_food_categories.restaurant_food_category"
            
                , "restaurants.restaurant_name"
            );
		$join_table = array(
            "restaurant_food_categories" => "restaurant_food_categories.restaurant_food_category_id = restaurant_food_menus.restaurant_food_category_id",
        
            "restaurants" => "restaurants.restaurant_id = restaurant_food_menus.restaurant_id",
        );
		$where = "restaurant_food_menus.restaurant_food_menu_id = $restaurant_food_menu_id";
		
		return $this->restaurant_food_menu_model->joinGet($fields, "restaurant_food_menus", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


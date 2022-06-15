<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Cart_item_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "item_cart";
        $this->pk = "item_cart_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function get_cart_items(){
	$query='SELECT
				`restaurant_food_menus`.`restaurant_food_name`
				, `restaurant_food_menus`.`restaurant_food_price`
				, `restaurant_food_menus`.`restaurant_food_quantity`
				, `restaurant_food_menus`.`restaurant_food_description`
				, `restaurant_food_menus`.`restaurant_food_menu_id`
				, `item_cart`.`quantity`
				, `restaurant_food_categories`.`restaurant_food_category`
				, `restaurants`.`restaurant_name`
				, `restaurants`.`restaurant_id`
				, `restaurants`.`restaurant_location`
				, `item_cart`.`item_cart_id`
			FROM
			`restaurant_food_menus`,
			`item_cart`,
			`restaurant_food_categories`,
			`restaurants` 
			WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `item_cart`.`restaurant_food_menu_id`
			AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
			AND `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
			AND `item_cart`.`user_id`="'.$this->session->userdata("user_id").'"
			AND `user_unique_id`="'.$this->session->userdata("user_unique_id").'"';
	
	$result = $this->db->query($query);		
	return $result->result();
	}	


}


	


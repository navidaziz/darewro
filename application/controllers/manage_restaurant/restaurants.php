<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Restaurants extends Restaurant_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/restaurants_model");
		$this->lang->load("restaurants", 'english');
		$this->lang->load("system", 'english');
		
		$this->load->model("admin/restaurant_food_menu_model");
		$this->lang->load("restaurant_food_menus", 'english');
		$this->load->model("admin/order_model");
		$this->lang->load("orders", 'english');
		 $this->load->model("admin/user_model");
		$this->lang->load("users", 'english');
		
		$this->load->model("admin/restaurant_food_category_model");
		$this->lang->load("restaurant_food_categories", 'english');
		
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().MANAGE_RESTAURANT_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`restaurants`.`status` IN (0, 1) ORDER BY `restaurants`.`order`";
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants_list($where, false);
		// $this->data["restaurants"] = $data->restaurants;
		 //$this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Restaurants');
		$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurants/restaurants";
		$this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
	 
	 public function order_history(){
	    $restaurant_id = $this->session->userdata("restaurant_id");
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `customers`.`mobile_number`,
				  `orders`.`order_detail`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
				  FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND `restaurant_id` = '".$restaurant_id."' 
				  AND DATE(`orders`.`created_date`) = '".date('Y-m-d',time())."'
				  AND `orders`.`order_status` > 2
				  ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$to_day_orders = $query_result->result();
		
		foreach($to_day_orders as $to_day_order){
			$query = "SELECT
						`restaurant_food_menus`.`restaurant_food_name`
						, `restaurant_food_menus`.`restaurant_food_price`
						, `restaurant_food_menus`.`restaurant_food_quantity`
						, `restaurant_food_menus`.`restaurant_food_description`
						, `restaurant_food_menus`.`restaurant_food_image`
						, `restaurant_food_categories`.`restaurant_food_category`
						, `restaurant_food_categories`.`restaurant_food_category_image`
						, `restaurant_food_orders`.`quantity`
						, (`restaurant_food_orders`.`quantity`*`restaurant_food_menus`.`restaurant_food_price`) as total
					FROM `restaurant_food_menus`,
						 `restaurant_food_orders`,
						 `restaurant_food_categories`
					WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `restaurant_food_orders`.`restaurant_food_menu_id`
					AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
					AND `restaurant_food_orders`.`order_id` = '".$to_day_order->order_id."';";
			$query_result = $this->db->query($query);
			$to_day_order->order_lists = $query_result->result();	 
					
			}
		//var_dump($wating_orders); exit();
		$this->data['to_day_orders'] = $to_day_orders;
		
		
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `customers`.`mobile_number`,
				  `orders`.`order_detail`,
				  `orders`.`order_drop_address`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
				  FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND DATE(`orders`.`created_date`) = '".date('Y-m-d',time())."'
				  AND `orders`.`created_by` = '".$this->session->userdata("user_id")."'
				  ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$to_day_delivery_requests = $query_result->result();
		$this->data['to_day_delivery_requests'] = $to_day_delivery_requests;
		
		$this->data["title"] = 'Restaurant Orders History';
		$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurants/orders_history";
		$this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
	
	}		
   
public function request_order(){
	
	 $query ="SELECT restaurant_name FROM restaurants WHERE restaurant_id = '".$this->session->userdata("restaurant_id")."'";
	 $query_result = $this->db->query($query);
	 $restaurant_name = $query_result->result()[0]->restaurant_name;
	 $picking_location = $restaurant_name;
	 $inputs["order_picking_address"] = $picking_location = str_replace('[', '', $picking_location);
	 $order_picking_addresses = explode(",", $picking_location);
	 if(!is_array($picking_location)){  $picking_location[0] = $picking_location; }
	 
	 
	 $delivery_location = str_replace('"', '',  strip_hidden_chars($this->input->post("delivery_location")));
	 $delivery_location = str_replace(']', '', $delivery_location);
	 $inputs["order_drop_address"] = $delivery_location = str_replace('[', '', $delivery_location);
	 $delivery_locations = explode(",", $delivery_location);
	 if(!is_array($delivery_locations)){  $delivery_locations[0] = $delivery_location;  }
	 
	 $inputs["order_detail"]  =  $this->input->post("order_detail");
	 $inputs["mobile_or_call"] = 'Restaurant Portal';
	 //check mobile number already exist or not 
	 $customer_mobile_no  =  $this->input->post("customer_mobile_no");
	 $customer_name = $this->input->post("customer_name");
	 $query="SELECT * FROM `customers` WHERE mobile_number='".$customer_mobile_no."'";
	 $query_result = $this->db->query($query);
	 $customer_information = $query_result->result()[0];
	 if($customer_information){
			$inputs["customer_id"] = $customer_information->customer_id;
			$customer_name =   $customer_information->customer_name;
					
		 }else{
			$comment =  '';
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES ('".$customer_mobile_no."','".ucwords($customer_name)."','".$comment."')";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
			 }
	
	$order_ready_time = strtotime("+".$this->input->post('order_ready_time_field')." minutes", time());
	$inputs["order_ready_time"]  =  date("Y-m-d G:i:s", $order_ready_time);
	$inputs["orderer_name"]  =  $customer_name;
	
	//for auto expected time and price for order 
	$query = "SELECT expected_charges,
					 expected_delivery_time
			  FROM `delivery_types` 
			  WHERE `general_or_food`=1 
			  AND `delivery_type_title`='Food'";
	$query_result = $this->db->query($query);
	$order_type_info = $query_result->result()[0];	
	$inputs["delivery_charges"]  =  $order_type_info->expected_charges;
	$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$order_type_info->expected_delivery_time." minutes", time()));
	$inputs["created_by"] = $this->session->userdata("user_id");
	$inputs["is_pre_order"]  =  '1';
	$inputs["order_type"]  =  'Food Order';
	$inputs["order_status"]  =  '2';
	$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
	$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
	$inputs["last_updated"] = date('Y-m-d G:i:s', time());	
	
	
	
		 
	$order_id = $this->order_model->save($inputs);
	 foreach($delivery_locations as $delivery_location){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES ('".$order_id."', '".$delivery_location."', 'drop')";
			$this->db->query($query);
			
			}
		foreach($order_picking_addresses as $order_picking_address){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES ('".$order_id."', '".$order_picking_address."','pick' )";
			$this->db->query($query);
			}
	 $this->session->set_flashdata("msg_success", 'Order Successfuly Save and Forwarded');
	 redirect(MANAGE_RESTAURANT_DIR."restaurants/orders");
	 
	}	 
	 
public function orders(){
		$restaurant_id = $this->session->userdata('restaurant_id');
		//// --------------
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_date_time`,
				  `customers`.`customer_name` 
				FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND `restaurant_id` = '".$restaurant_id."'
				  AND `order_status` IN (1) ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$new_orders = $query_result->result();
		
		foreach($new_orders as $new_order){
			$query = "SELECT
						`restaurant_food_menus`.`restaurant_food_name`
						, `restaurant_food_menus`.`restaurant_food_price`
						, `restaurant_food_menus`.`restaurant_food_quantity`
						, `restaurant_food_menus`.`restaurant_food_description`
						, `restaurant_food_menus`.`restaurant_food_image`
						, `restaurant_food_categories`.`restaurant_food_category`
						, `restaurant_food_categories`.`restaurant_food_category_image`
						, `restaurant_food_orders`.`quantity`
						, (`restaurant_food_orders`.`quantity`*`restaurant_food_menus`.`restaurant_food_price`) as total
					FROM `restaurant_food_menus`,
						 `restaurant_food_orders`,
						 `restaurant_food_categories`
					WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `restaurant_food_orders`.`restaurant_food_menu_id`
					AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
					AND `restaurant_food_orders`.`order_id` = '".$new_order->order_id."';";
			$query_result = $this->db->query($query);
			$new_order->order_lists = $query_result->result();	 
					
			}
		
		$this->data['new_orders'] = $new_orders;
			
		//// --------------
		
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `orders`.`order_detail`
				FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND `restaurant_id` = '".$restaurant_id."'
				  AND `order_status` IN (2) ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$wating_orders = $query_result->result();
		
		foreach($wating_orders as $wating_order){
			$query = "SELECT
						`restaurant_food_menus`.`restaurant_food_name`
						, `restaurant_food_menus`.`restaurant_food_price`
						, `restaurant_food_menus`.`restaurant_food_quantity`
						, `restaurant_food_menus`.`restaurant_food_description`
						, `restaurant_food_menus`.`restaurant_food_image`
						, `restaurant_food_categories`.`restaurant_food_category`
						, `restaurant_food_categories`.`restaurant_food_category_image`
						, `restaurant_food_orders`.`quantity`
						, (`restaurant_food_orders`.`quantity`*`restaurant_food_menus`.`restaurant_food_price`) as total
					FROM `restaurant_food_menus`,
						 `restaurant_food_orders`,
						 `restaurant_food_categories`
					WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `restaurant_food_orders`.`restaurant_food_menu_id`
					AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
					AND `restaurant_food_orders`.`order_id` = '".$wating_order->order_id."';";
			$query_result = $this->db->query($query);
			$wating_order->order_lists = $query_result->result();	 
					
			}
		//var_dump($wating_orders); exit();
		$this->data['wating_orders'] = $wating_orders;
		
		
				
		$this->data["title"] = 'Restaurant Orders';
		$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurants/orders";
		$this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
		 }
	 
	 
	 public function food_menu_trashed(){$restaurant_id = $this->session->userdata('restaurant_id');
		$this->data['restaurant_id'] = $restaurant_id;
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants($restaurant_id);
		
		//get restaurant food categories 
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (2)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id`";
				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
		//get restaurant food menu
		$where = "`restaurant_food_menus`.`status` IN (2)
		AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id
		AND `restaurant_food_menus`.`restaurant_food_category_id` = ".$restaurant_food_category->restaurant_food_category_id;
		$restaurant_food_category->restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		
		}
		$this->data["restaurant_food_categories"] = $restaurant_food_categories;
        //$this->data["title"] = $this->lang->line('Restaurants Details');
		$this->data["backlink"] = $this->data["restaurants"][0]->restaurant_name;
		$this->data["title"] = $this->data["restaurants"][0]->restaurant_name. " ( Trashed )";
		$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurants/view_restaurant_food_trash";
        $this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
    }
	 

	 
	 
    public function view_restaurants(){
        
        $restaurant_id = $this->session->userdata('restaurant_id');
		$this->data['restaurant_id'] = $restaurant_id;
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants($restaurant_id);
		/*$this->data['restaurant_user'] = NULL;
		$query="SELECT * FROM `users` WHERE `users`.`restaurant_id` ='".$restaurant_id."'";
		$query_result = $this->db->query($query);
		$restaurant_user = $query_result->result();
		if($restaurant_user){ $this->data['restaurant_user'] = $restaurant_user[0]; }*/
		
		$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`restaurant_id` = $restaurant_id");
		
		
		
		//get restaurant food categories 
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
					,`restaurant_food_categories`.`restaurant_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			/*$this->data["restaurant_food_categories_list"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;*/
		//get restaurant food menu
		$where = "`restaurant_food_menus`.`status` IN (1,0)
		AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id
		AND `restaurant_food_menus`.`restaurant_food_category_id` = ".$restaurant_food_category->restaurant_food_category_id;
		$restaurant_food_category->restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		
		}
		$this->data["restaurant_food_categories"] = $restaurant_food_categories;
        //$this->data["title"] = $this->lang->line('Restaurants Details');
		
		$this->data["title"] = $this->data["restaurants"][0]->restaurant_name;
		$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurants/view_restaurants";
        $this->load->view(MANAGE_RESTAURANT_DIR."layout", $this->data);
    }
   
	/**
     * function to send a user to trash
     */
    public function food_menu_trash($restaurant_food_menu_id){$restaurant_id = $this->session->userdata('restaurant_id');
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
    }
    
    /**
      * function to restor restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_restore($restaurant_food_menu_id){$restaurant_id = $this->session->userdata('restaurant_id');
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_draft($restaurant_food_menu_id){
		 $restaurant_id = $this->session->userdata('restaurant_id');
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_publish($restaurant_food_menu_id){
		 $restaurant_id = $this->session->userdata('restaurant_id');
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Restaurant_food_menu
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_delete($restaurant_food_menu_id){
		 $restaurant_id = $this->session->userdata('restaurant_id');
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "3");
        //Remove file....
		/*$restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu($restaurant_food_menu_id);
						$file_path = $restaurant_food_menus[0]->restaurant_food_image;
						if($file_path){
						$this->restaurant_food_menu_model->delete_file($file_path);
						}
		$this->restaurant_food_menu_model->delete(array( 'restaurant_food_menu_id' => $restaurant_food_menu_id));*/
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
     }
     //----------------------------------------------------
    
	
public function get_food_edit_form(){
	
	$restaurant_food_menu_id = (int) $this->input->post('id');
	$this->data['restaurant_id'] = $restaurant_id = (int) $this->session->userdata("restaurant_id");
	
	$this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`restaurant_id` = $restaurant_id");
		
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			$this->data["restaurant_food_categories"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;
		
		}
	
	
	
	 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        $this->data["restaurant_food_menu"] = $this->restaurant_food_menu_model->get($restaurant_food_menu_id);
		  
    /*$this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("RESTAURANT_FOOD_CATEGORIES", "restaurant_food_category_id", "restaurant_food_category", $where ="restaurant_food_categories.status IN (0, 1) ");*/
   
		//$this->data["view"] = MANAGE_RESTAURANT_DIR."restaurant_food_menus/edit_restaurant_food_menu";
        $this->load->view(MANAGE_RESTAURANT_DIR."restaurant_food_menus/food_edit_form", $this->data);
	
	}
	
	
	 public function update_restaurant_food_data($restaurant_food_menu_id){
		
		 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
		 $restaurant_id = (int) $this->session->userdata("restaurant_id");
		 
       
	   if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                         $_POST["restaurant_food_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->update_data($restaurant_food_menu_id);
          if($restaurant_food_menu_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success")); redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error")); redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }
        }else{ redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
			}
		 
		 }
		 
public function get_restaurant_food_categorie_edit_form(){
	 $restaurant_id = (int) $this->session->userdata("restaurant_id");
	 $restaurant_food_category_id = (int) $this->input->post('id');
	 $this->data["restaurant_food_category"] = $this->restaurant_food_category_model->get($restaurant_food_category_id);
	 $this->load->view(MANAGE_RESTAURANT_DIR."restaurant_food_categories/edit_restaurant_food_category_form", $this->data);
	
	}	

public function update_restaurant_food_categories(){
	
		 
		 $restaurant_food_category_id = (int) $this->input->post('restaurant_food_category_id');
		 $restaurant_id = (int) $this->session->userdata("restaurant_id");
       
	   if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                         $_POST["restaurant_food_category_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->update_data($restaurant_food_category_id);
          if($restaurant_food_category_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success")); redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error")); redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }
        }else{
			$this->get_restaurant_food_categorie_edit_form($restaurant_food_category_id);
			}
		 
		 
	}	 
	
   
		
	public function get_food_category_form(){
		
		$this->data['restaurant_id'] = $this->session->userdata("restaurant_id");
		$this->load->view(MANAGE_RESTAURANT_DIR."restaurant_food_categories/add_restaurant_food_category_form", $this->data);
		}
	public function get_add_food_with_category_form(){
		
		$this->data['restaurant_id']= $restaurant_id = $this->session->userdata("restaurant_id");
		
		
		$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`status` = 1 and `restaurant_food_categories`.`restaurant_id` =$restaurant_id");
		
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
					,`restaurant_food_categories`.`restaurant_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			$this->data["restaurant_food_categories_list"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;
			
			
			
		}
		$this->load->view(MANAGE_RESTAURANT_DIR."/restaurant_food_menus/add_restaurant_food_menu_with_category_form", $this->data);
		}	
		
	public function get_add_food_menu_form(){
		$this->data['restaurant_id'] = $this->session->userdata("restaurant_id");
		$this->data['restaurant_food_category_id'] = $this->input->post('id');
	$this->load->view(MANAGE_RESTAURANT_DIR."/restaurant_food_menus/add_restaurant_food_menu_form", $this->data);
		}		
		
		
		
	public function add_food_category($restaurant_id){
		
		$restaurant_id = (int) $this->session->userdata("restaurant_id");
	
			
			 if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                       $_POST['restaurant_food_category_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->save_data();
          if($restaurant_food_category_id){
			  	//just update the result for this restaurant 
			  	$this->db->query("UPDATE `restaurant_food_categories` SET `restaurant_id`='".$restaurant_id."' 
								  WHERE `restaurant_food_category_id`='".$restaurant_food_category_id."'");
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }
        }else{
			$this->session->set_flashdata("msg_error", "Validation Error");
			redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
			}
		
	}	
	
	
	public function add_food_menu(){
		$restaurant_id = (int) $this->session->userdata("restaurant_id");
		$restaurant_food_category_id = (int) $this->input->post('restaurant_food_category_id');
		
	  if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                       $_POST['restaurant_food_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->save_data();
          if($restaurant_food_menu_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
               redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }
        }else{
			$this->session->set_flashdata("msg_error", "Validation Error");
			redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
			}
	
		
	}
	
	public function get_restaurant_edit_form(){
	 $restaurant_id = $this->session->userdata('restaurant_id');
        $this->data["restaurants"] = $this->restaurants_model->get($restaurant_id);
	$this->load->view(MANAGE_RESTAURANT_DIR."restaurants/restaurant_edit_form", $this->data);
	}	
	
	 public function update_data($restaurant_id){
		 
		 $restaurant_id = (int) $this->session->userdata('restaurant_id');
       
	   if($this->restaurants_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_logo")){
                         $_POST["restaurant_logo"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_id = $this->restaurants_model->update_data($restaurant_id);
          if($restaurant_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
               redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
            }
        }else{
			$this->session->set_flashdata("msg_error", "Validation Error");
			redirect(MANAGE_RESTAURANT_DIR."restaurants/view_restaurants/");
			}
		 
		 }
		 
		 
public function place_order(){
	
		$order_id  =  (int) $this->input->post("order_id");
		$orderer_name  =  $this->input->post("order_name");
		//order ready time 
		$order_ready_time = (int) $this->input->post('order_ready_time');
		//get order delivery time for add the ready time....
		$query="SELECT `orders`.`delivery_time` FROM `orders` WHERE `orders`.`order_id`='".$order_id."'";
		$query_result = $this->db->query($query);
		$order_delivery_time = strtotime($query_result->result()[0]->delivery_time);
		$order_delivery_time = strtotime("+".$order_ready_time." minutes", $order_delivery_time);
		$order_delivery_time = date("Y-m-d G:i:s", $order_delivery_time);
		
		
		$order_ready_time = strtotime("+".$order_ready_time." minutes", time());
		$order_ready_time = date("Y-m-d G:i:s", $order_ready_time);
		//order place time 
		$order_place_time = date("Y-m-d G:i:s", time());
		$query = "UPDATE `orders` SET `orderer_name`='".$orderer_name."',
				  `order_ready_time`='".$order_ready_time."',
				  `order_placed_by`='".$this->session->userdata("user_id")."',
				  `order_place_time`='".$order_place_time."', 
				  `order_status`='2',
				  `delivery_time`='".$order_delivery_time."'
				  WHERE `order_id`='".$order_id."'";
				 
		if($this->db->query($query)){ $this->push_notification($order_id,2); }
		
		$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
		redirect(MANAGE_RESTAURANT_DIR."restaurants/orders");
		}		 
}        

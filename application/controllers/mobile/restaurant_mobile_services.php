<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Restaurant_mobile_services extends Admin_Controller_Mobile{ 
    /**
     * constructor method
     */
    public function __construct(){
        
       parent::__construct();
        $this->load->model("admin/restaurants_model");
		 $this->load->model("admin/order_model");
		
		$this->lang->load("restaurants", 'english');
		$this->lang->load("system", 'english');
		
		$this->load->model("admin/restaurant_food_menu_model");
		$this->lang->load("restaurant_food_menus", 'english');
		
		$this->load->model("admin/restaurant_food_category_model");
        //$this->output->enable_profiler(TRUE);
		
    }
	
	public function change_restaurant_title(){
		$response = array();
		$user_id = $this->input->post('user_id');
		$user_title = $this->input->post('user_title');
		$query = "UPDATE `users` SET `user_title`='".$user_title."' WHERE `user_id`='".$user_id."';";
		if( $this->db->query($query)){
			$response["message"] = 'You name update successfully';
			$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}
		
		
	public function change_restaurant_location(){
		$response = array();
		$user_id = $this->input->post('user_id');
		$user_email = $this->input->post('user_email');
		$query = "UPDATE `users` SET `user_email`='".$user_email."' WHERE `user_id`='".$user_id."';";
		if( $this->db->query($query)){
			$response["message"] = 'You email addresss update successfully';
			$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}	
	
	
	public function change_restaurant_detail(){
		$response = array();
		$user_id = $this->input->post('user_id');
		$user_email = $this->input->post('user_email');
		$query = "UPDATE `users` SET `user_email`='".$user_email."' WHERE `user_id`='".$user_id."';";
		if( $this->db->query($query)){
			$response["message"] = 'You email addresss update successfully';
			$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}	
		
		
	public function change_restaurant_password(){
		$response = array();
		$user_id = $this->input->post('user_id');
		$user_password = $this->input->post('user_password');
		$new_password = $this->input->post('new_password');
		
		$query="SELECT `user_password` FROM `users` WHERE `user_id`='".$user_id ."'";
		$query_result = $this->db->query($query);
		$user_old_assword = $query_result->result()[0]->user_password;
		if($user_password==$user_old_assword){
			$query = "UPDATE `users` SET `user_password`='".$new_password."' WHERE `user_id`='".$user_id."';";
			if( $this->db->query($query)){
				$response["message"] = 'You password update successfully';
				$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
			}else{
				$response["message"] = 'Whoops!! Incorrect password try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}
		
		
		public function new_orders(){
 		$restaurant_id = (int) $this->input->post('restaurant_id');
		//$restaurant_id = 2;
		//// --------------
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`order_date_time`,
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
		$response = array();
		//// --------------
		    if($new_orders){
		       $response["new_orders_available"] = true;
		       $response["new_orders"] = $new_orders;
		    }
		    else{
		        $response["new_orders_available"] = false;
				$response['message'] = 'No new orders available.';
		    }
		   
		    echo json_encode($response);

		 }
public function waiting_orders(){
 		$restaurant_id = (int) $this->input->post('restaurant_id');
	//	$restaurant_id = 2;
		
		//// --------------
		
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`order_date_time`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`,
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
		
			$response = array();
		    
		    if($wating_orders){
		        $response["waiting_orders_available"] = true;
		        $response["waiting_orders"] = $wating_orders;
		    }
		    else{
		        $response["waiting_orders_available"] = false;
				$response['message'] = 'No waiting orders available.';
		    }
		    echo json_encode($response);

		 }
		 
		 
		 public function today_orders_history(){
	 		$restaurant_id = (int) $this->input->post('restaurant_id');
	//	$restaurant_id = 2;
	$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`order_date_time`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `orders`.`order_detail`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
				  FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND `restaurant_id` = '".$restaurant_id."' 
				  AND DATE(`orders`.`created_date`) = '".date('Y-m-d',time())."'
				 
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
		$response = array();
		    
		    if($to_day_orders){
		        $response["today_orders_history_available"] = true;
		        $response["to_day_orders"] = $to_day_orders;
		    }
		    else{
		        $response["today_orders_history_available"] = false;
				$response['message'] = 'No orders recieved today.';
		    }
		    echo json_encode($response);
	}		
	
		 public function previous_orders_history(){
	 		$restaurant_id = (int) $this->input->post('restaurant_id');
	//$restaurant_id = 2;
		$query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`order_date_time`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `orders`.`order_detail`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
				  FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND `restaurant_id` = '".$restaurant_id."'
				  ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$previous_orders = $query_result->result();
		
		foreach($previous_orders as $previous_order){
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
					AND `restaurant_food_orders`.`order_id` = '".$previous_order->order_id."';";
			$query_result = $this->db->query($query);
			$previous_order->order_lists = $query_result->result();	 
					
			}
		$response = array();
		    
		    if($previous_orders){
		        $response["previous_orders_history_available"] = true;
		        $response["previous_orders"] = $previous_orders;
		    }
		    else{
		        $response["previous_orders_history_available"] = false;
				$response['message'] = 'No previous orders.';
		    }
		    echo json_encode($response);
	}
	
	public function today_delivery_requests_history(){
 		$restaurant_id = (string) $this->input->post('restaurant_id');
		//$restaurant_id = 2;		
	    $user_id = (string) $this->input->post('user_id');
	    //$user_id=79;
       $query ="SELECT 
				  `orders`.`order_id`,
				  `orders`.`order_date_time`,
				  `orders`.`restaurant_id`,
				  `orders`.`order_status`,
				   `orders`.`order_ready_time`,
				  `customers`.`customer_name`,
				  `orders`.`order_detail`,
				  `orders`.`order_drop_address`,
				  IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
				  FROM
				 `customers`, 
				  `orders` 
				  WHERE `orders`.`customer_id` = `customers`.`customer_id` 
				  AND DATE(`orders`.`created_date`) = '".date('Y-m-d',time())."'
				  AND `orders`.`created_by` = ".$this->db->escape($user_id)."
				  ORDER BY `orders`.`order_id` DESC";
		$query_result = $this->db->query($query);
		$to_day_delivery_requests = $query_result->result();
		$response = array();
		    
		    if($to_day_delivery_requests){
		        $response["today_delivery_requests_history_available"] = true;
		        $response["to_day_delivery_requests"] = $to_day_delivery_requests;
		    }
		    else{
		        $response["today_delivery_requests_history_available"] = false;
				$response['message'] = 'No delivery request today.';
		    }
		    echo json_encode($response);
	
	}		

    
	public function restaurant_login(){
		$user_name = (string) $this->input->post('user_name');
		$password = (string) $this->input->post('password');
		
		$response = array();
		$query="SELECT `user_id`
		            , `role_id`
					, `user_title`
					, `user_email`
					, `user_mobile_number`
					, `user_image`
					, `restaurant_id`
				FROM
				`users`
				WHERE `user_name` = '".$user_name."'
				AND `user_password` = '".$password."';";
		$query_result = $this->db->query($query);
		$user = $query_result->result();
		if($user){
		    $query="SELECT `restaurant_id`
		            , `restaurant_name`
					, `restaurant_location`
					, `restaurant_detail`
					, `restaurant_contact_no`
					, `restaurant_logo`
					, `restaurant_start_time`
					, `restaurant_close_time`
					, `status`
				FROM
				`restaurants`
				WHERE `restaurant_id` = '".$user[0]->restaurant_id."';";
		        $query_result = $this->db->query($query);
		        $restaurant = $query_result->result();
		        if($restaurant){
		            $response['success'] = true;
			        $response['user_id'] = $user[0]->user_id;
        			$response['role_id'] = $user[0]->role_id;
        			$response['user_title'] = $user[0]->user_title;
        			$response['user_email'] = $user[0]->user_email;
        			$response['user_mobile_number'] = $user[0]->user_mobile_number;
        			$response['user_image'] = $user[0]->user_image;
        			$response['restaurant_id'] = $restaurant[0]->restaurant_id;
        			$response['restaurant_name'] = $restaurant[0]->restaurant_name;
        			$response['restaurant_location'] = $restaurant[0]->restaurant_location;
        			$response['restaurant_detail'] = $restaurant[0]->restaurant_detail;
        			$response['restaurant_contact_no'] = $restaurant[0]->restaurant_contact_no;
        			$response['restaurant_logo'] = $restaurant[0]->restaurant_logo;
        			$response['restaurant_start_time'] = $restaurant[0]->restaurant_start_time;
        			$response['restaurant_close_time'] = $restaurant[0]->restaurant_close_time;
        			$response['status'] = $restaurant[0]->status;
			        $response['message'] = 'Welcome '.$user[0]->user_title;
		        }
		        else{
		            $response['success'] = false;
			        $response['message'] = 'No restaurant found';
		        }
			
		}else{
			$response['success'] = false;
			$response['message'] = 'Whoops!! Incorrect username or password';
			}
			echo json_encode($response);
		}
	
	//-----------------------------------------------------
    /**
     * get single record by id
     */
	public function user_token_update(){
		$response = array();
		$user_id = $this->input->post('user_id');
		$mobile_token = $this->input->post('mobile_token');

		$query = "UPDATE `users` SET `mobile_token`='".$mobile_token."' WHERE `user_id`='".$user_id."';";
		$result = $this->db->query($query);
		if ($result) {
			$response["success"] = true;
			$response["message"] = "Your Token Key updated";
		} 
		else{
			$response["success"] = true;
			$response["message"] = "Token Key Not updated";
		}
		// echoing JSON response
		echo json_encode($response);
	}
	
	

	public function request_order(){
	  $restaurant_id = (int) $this->input->post("restaurant_id");
	 $query ="SELECT restaurant_name FROM restaurants WHERE restaurant_id =".$this->db->escape($restaurant_id);
	 $query_result = $this->db->query($query);
	 $restaurant_name = $query_result->result()[0]->restaurant_name;
	 $inputs["order_picking_address"] = $restaurant_name;
	 $inputs["order_drop_address"] =$this->input->post("delivery_location");
	 
	 $inputs["order_detail"]  =  $this->input->post("order_detail");
	 $inputs["mobile_or_call"] = 'Restaurant Portal';
	 //check mobile number already exist or not 
	 $customer_mobile_no  =  $this->input->post("customer_mobile_no");
	 $customer_name = $this->input->post("customer_name");
	 $query="SELECT * FROM `customers` WHERE mobile_number=".$this->db->escape($customer_mobile_no);
	 $query_result = $this->db->query($query);
	 $customer_information = $query_result->result()[0];
	 
	 if($customer_information){
		 $inputs["customer_id"]= $customer_id = $this->input->post("customer_id");	
			//check the user name is same or not 
			$this->db->query("UPDATE `customers` SET `customer_name`=".$this->db->escape($customer_name)." 
			WHERE `customer_id`=".$this->db->escape($customer_id));
			
		}else{
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES (".$this->db->escape($customer_mobile_no).",".$this->db->escape(ucwords($customer_name)).",".$this->db->escape($comment).")";
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
	$inputs["created_by"] = $this->input->post('user_id');
	$inputs["is_pre_order"]  =  '1';
	$inputs["order_type"]  =  'Food Order';
	$inputs["order_status"]  =  '2';
	$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
	$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
	$inputs["last_updated"] = date('Y-m-d G:i:s', time());	
	
	$order_id = $this->order_model->save($inputs);
	 /*foreach($delivery_locations as $delivery_location){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES ('".$order_id."', '".$delivery_location."', 'drop')";
			$this->db->query($query);
			
			}
		foreach($order_picking_addresses as $order_picking_address){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES ('".$order_id."', '".$order_picking_address."','pick' )";
			$this->db->query($query);
			}*/
	 if($order_id){
			$response['success'] = true;
			$response['message'] = 'Request Submit Successfully.';
		}else{
			$response['success'] = false;
			$response['message'] = "Error Try Again.";
			}
		echo json_encode($response);		
	 
	}	 
	
	
	public function request_order_old(){
	 $restaurant_id = (int) $this->input->post("restaurant_id");
	 $query ="SELECT restaurant_name FROM restaurants WHERE restaurant_id = '".$restaurant_id."'";
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
	$inputs["created_by"] = $this->input->post('user_id');
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
	 if($order_id){
			$response['success'] = true;
			$response['message'] = 'Request Submit Successfully.';
		}else{
			$response['success'] = false;
			$response['message'] = "Error Try Again.";
			}
		echo json_encode($response);	
	 
	}	 
	
	public function place_order(){
	    $order_id  =  (int) $this->input->post("order_id");
	    $response['refresh'] = false;
	    $query="SELECT `order_status` FROM `orders` WHERE `order_id`=".$this->db->escape($order_id);
	    $query_result = $this->db->query($query);
	    $order_status = $query_result->result()[0]->order_status;
	    if($order_status==1){
	    $user_id  =  (int) $this->input->post("user_id");
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
				  `order_placed_by`=".$this->db->escape($user_id).",
				  `order_place_time`='".$order_place_time."', 
				  `order_status`='2',
				  `delivery_time`='".$order_delivery_time."'
				  WHERE `order_id`='".$order_id."'";
				 
		if($this->db->query($query)){ $this->push_notification($order_id,2); 
			$response['success'] = true;
			$response['message'] = 'Order Placed.';
		}else{
			$response['success'] = false;
			$response['message'] = "Error Try Again.";
			}
	    }else{
	        $response['success'] = false;
	         $response['refresh'] = true;
			$response['message'] = 'Sorry! Order is processed by Darewro.';
	        
	    }
		echo json_encode($response);
		}
		
public function cancel_order(){
		$order_id  =  (int) $this->input->post("order_id");
		$order_status =5;
		$reason  =  $this->input->post("reason");
		$query = "UPDATE `orders` SET `reason`=".$this->db->escape($reason).", 
				  `order_status`='".$order_status."'
				  WHERE `order_id`='".$order_id."'";
		if($this->db->query($query)){ 
		$this->push_notification($order_id, $order_status); 
		$response['success'] = true;
		$response['message'] = 'Order Cancelled Successfully.';
		}else{
			$response['success'] = false;
			$response['message'] = "Error Try Again.";
			}
		echo json_encode($response);
		
		}
		
public function get_cancel_reasons(){
	//we can change the option after review .....
	$reasons = array("Option 1", 
					 "Option 2", 
					 "Option 3", 
					 "Option 4");
	echo json_encode(array('reasons' => $reasons));
	}
	
public function get_restaurant_food_menu(){
		$restaurant_id = (int) $this->input->post('restaurant_id');
		
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
			
		$where = "`restaurant_food_menus`.`status` IN (1)
		AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id
		AND `restaurant_food_menus`.`restaurant_food_category_id` = ".$restaurant_food_category->restaurant_food_category_id;
		$restaurant_food_category->restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		
		}
	
		if($restaurant_food_categories){
			$response['exist'] = true;
			$response['message'] = 'Food Menu Found';
			$response['restaurant_food_categories'] = $restaurant_food_categories;
		}else{
			$response['exist'] = false;
			$response['message'] = "Food Menu Not Found";
			$response['restaurant_food_categories'] = false;
			}
		echo json_encode($response);
	
	
	}				
	
 public function get_restaurant(){
        
        $restaurant_id = (int) $this->input->post('restaurant_id');
		$restaurant_id=1;
		$restaurant = $this->restaurants_model->get_restaurants($restaurant_id);
		
		/*$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`restaurant_id` = $restaurant_id");*/
		
		
		
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
	   
	   $response["restaurants"] = $restaurant;
	   $response['success'] = true;
	   if($restaurant_food_categories){
			
			$response['message'] = 'Food Menu Found';
			$response['restaurant_food_categories'] = $restaurant_food_categories;
		}else{
			$response['success'] = false;
			$response['message'] = "Food Menu Not Found";
			$response['restaurant_food_categories'] = false;
			}
		echo json_encode($response);
	    
    }	
    
    public function order_detail_list(){
        $order_id = (int) $this->input->post('order_id');
        //$order_id=10;
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
					AND `restaurant_food_orders`.`order_id` = ".$this->db->escape($order_id).";";
			$query_result = $this->db->query($query);
			$order_lists = $query_result->result();	 
					
	
		$response = array();
		    
		    if($order_lists){
		        $response["success"] = true;
		        $response["order_lists"] = $order_lists;
		    }
		    else{
		        $response["success"] = false;
			$response["order_lists"] = false;
		    }
		    echo json_encode($response);
        
        
        
    }

}        

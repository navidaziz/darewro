<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class mobile_services extends Admin_Controller_Mobile{ 
    /**
     * constructor method
     */
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        $this->load->model("admin/restaurants_model");
		$this->load->model("admin/restaurant_food_menu_model");
		$this->load->model("admin/order_model");
		$this->lang->load("restaurants", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
	
	public function change_user_title(){
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
		
		
	public function change_user_email(){
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
	
	
	public function change_user_password(){
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
	//-----------------------------------------------------
    /**
     * get a list of all items that are not trashed
     */
    public function get_restaurants(){
		$query='SELECT
					`restaurant_id`
					,`restaurant_name`
					, `restaurant_logo`
					, `restaurant_start_time`
					, `restaurant_close_time`
					, `restaurant_location`
				FROM `restaurants`
				WHERE `restaurants`.`status`=1 ORDER BY `restaurants`.`order` ASC;';
		$query_result = $this->db->query($query);
		$restaurants = 	$query_result->result();	
		//var_dump($restaurants);
		$current_hours = Date('H',time());	
		foreach($restaurants as $restaurant){
		if($restaurant->restaurant_start_time < $restaurant->restaurant_close_time){
			//echo "Some Day";
			if($current_hours>=$restaurant->restaurant_start_time and $current_hours< $restaurant->restaurant_close_time ){
					$restaurant->closed_open=true;
				}else{
					$restaurant->closed_open=false;
					
					}
			}else{
			//	echo "Next Day";
			if($current_hours>=$restaurant->restaurant_start_time or $current_hours<$restaurant->restaurant_close_time ){
					$restaurant->closed_open=true;
				}else{
					$restaurant->closed_open=false;
					}
				}
			$restaurant->restaurant_start_time.=':00';
			$restaurant->restaurant_close_time.=':00';
		}
		
		
		if($restaurants){
			$general_or_food = '1';
	
			$query="SELECT `delivery_id`, `delivery_type_title`, `delivery_type_detail`, `expected_charges`, `expected_delivery_time` FROM `delivery_types` WHERE `general_or_food`=$general_or_food AND `status`= 1 AND (`show_timing_start`<=HOUR(CURRENT_TIMESTAMP( )) AND `show_timing_end`>HOUR(CURRENT_TIMESTAMP( ))) ;";
			$result = $this->db->query($query);
			//full array 
			$query_result = $result->result();
			if($query_result){
				$response["exist"] = true;
				$response['delivery_types'] = $query_result;
				$response['restaurants'] = $restaurants;
			}
			else{
				$response["exist"] = false;
			}
		}
		else{
			$response["exist"] = false;
		}
		echo json_encode($response);
    }
	//-----------------------------------------------------
    /**
     * get single record by id
     */
    public function get_food_items(){
        $restaurant_id = $this->input->post('restaurant_id');
       
		$this->data['restaurant_id'] = $restaurant_id;
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants($restaurant_id);
		
		$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`status` = 1");
		
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
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0) GROUP BY `restaurant_food_categories`.`restaurant_food_category_id`";
				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
		foreach($restaurant_food_categories as $restaurant_food_category){
		
		$query="SELECT
				`restaurant_food_menu_id`
				,`restaurant_food_name`
				, `restaurant_food_quantity`
				, COUNT(`restaurant_food_name`) AS total_sub_menus
				, `restaurant_id`
				, `restaurant_food_category_id`
				, `restaurant_food_name`
				, `restaurant_food_price`
				, `restaurant_food_quantity`
				, `restaurant_food_description`
				, `restaurant_food_image`
				, `restaurant_id`
   				, `restaurant_food_category_id`
			FROM
			`restaurant_food_menus`
			WHERE `restaurant_id`='".$restaurant_id."'
			AND `restaurant_food_category_id`='".$restaurant_food_category->restaurant_food_category_id."'
			AND `restaurant_food_menus`.`status` IN (1)
			GROUP BY `restaurant_food_name`;";	
		$query_result = $this->db->query($query);
		$restaurant_foods = $query_result->result();	
		foreach($restaurant_foods as $restaurant_food){
			if($restaurant_food->total_sub_menus>1){
				$query="SELECT
				`restaurant_food_menu_id`
				,`restaurant_food_name`
				, `restaurant_food_quantity`
				, `restaurant_id`
				, `restaurant_food_category_id`
				, `restaurant_food_name`
				, `restaurant_food_price`
				, `restaurant_food_quantity`
				, `restaurant_food_description`
				, `restaurant_food_image`
				, `restaurant_id`
   				, `restaurant_food_category_id`
					FROM
					`restaurant_food_menus`
					WHERE `restaurant_id`='".$restaurant_id."'
				AND `restaurant_food_category_id`='".$restaurant_food_category->restaurant_food_category_id."'
				AND `restaurant_food_name`='".$restaurant_food->restaurant_food_name."'
				;";	
				$query_result = $this->db->query($query);
				$restaurant_food->restaurant_food_sub_menus = $query_result->result();
				}
			}
			$restaurant_food_category->restaurant_food_menus = $restaurant_foods;
		}
        echo json_encode(array('food_data' => $restaurant_food_categories));
    }
	
	public function check_username_and_password(){
		$user_name = (string) $this->input->post('user_name');
		$password = (string) $this->input->post('password');
		$response = array();
		$query="SELECT `user_id`, `user_title`
				FROM
				`users`
				WHERE `user_name` = '".$user_name."'
				AND `user_password` = '".$password."';";
		$query_result = $this->db->query($query);
		$user = $query_result->result();
		if($user){
			$response['success'] = true;
			$response['message'] = 'Welcome '.$user[0]->user_title;
		}else{
			$response['success'] = false;
			$response['message'] = 'Whoops!! Incorrect password';
			}
			echo json_encode($response);
		}
	
	
	//-----------------------------------------------------
    /**
     * get single record by id
     */
	public function check_user(){
	    
		$user_name = (string) $this->input->post('user_name');
		$pin_code  =  (string) $this->input->post('pin_code');
		$response = array();	
		$query="SELECT
					`user_id`
					, `role_id`
					, `user_title`
					, `user_email`
					, `user_mobile_number`
					, `user_name`
				FROM
				`users`
				WHERE `user_name` = '".$user_name."';";
		$query_result = $this->db->query($query);
		$user = $query_result->result();
		if($user){
			
			$response["exist"] = true;
			$response["user_id"]=$user[0]->user_id;
			$response["role_id"]=$user[0]->role_id;
			$response["user_email"]=$user[0]->user_email;
			$response["user_mobile_number"]=$user[0]->user_mobile_number;
			$response["user_title"]=$user[0]->user_title;
			$response["user_name"]=$user[0]->user_name;
		}
		else{
		    	
		   
			$result_SMS = $this->sms_jazz($user_name, $pin_code.' is your Darewro code.');	
			$response["code_send"] = $result_SMS;
			$response["exist"] = false;
		}
	
		echo json_encode($response);
	}
	
	public function check_user_email(){
        $user_name = (string) $this->input->post('user_name');
		$pin_code  =  (string) $this->input->post('pin_code');
		$user_email = (string) $this->input->post('user_email'); 
		
		$response = array();
		$query="SELECT `user_email`
				FROM
				`users`
				WHERE `user_name` = '".$user_name."'
				AND `user_email` = '".$user_email."';";
		$query_result = $this->db->query($query);
		$user = $query_result->result();
	
		if($user){
			$response['exist'] = true;
			
			
			
			$result_SMS = $this->sms_jazz($user_name, $pin_code.' is your Darewro password. For security reasons, please change your password once you login. Thanks.');
			$query = "UPDATE `users` SET `user_password`='".$pin_code."' WHERE `user_name`='".$user_name."' AND `user_email` = '".$user_email."';";
			$response["code_send"] = $result_SMS;
			if( $this->db->query($query)){
				$response["message"] = 'Please hold on: Your new password is on the way via sms.';
			}else{
				$response["message"] = 'Some thing wrong try again';
				}
			
		}else{
			$response['exist'] = false;
			$response['message'] = 'Email incorrect please try again';
			}
			echo json_encode($response);
		}
	
// 	//-----------------------------------------------------
//     /**
//      * get single record by id
//      */
// 	public function send_recovery_password(){
// 		$user_name = (string) $this->input->post('user_name');
// 		$pin_code  =  (string) $this->input->post('pin_code');
// 		$response = array();	
// 		$query="SELECT
// 					`user_id`
// 					, `role_id`
// 					, `user_title`
// 					, `user_email`
// 					, `user_mobile_number`
// 					, `user_name`
// 				FROM
// 				`users`
// 				WHERE `user_name` = '".$user_name."';";
// 		$query_result = $this->db->query($query);
// 		$user = $query_result->result();
// 		if($user){
			
// 			$response["exist"] = true;
// 			$response["user_id"]=$user[0]->user_id;
// 			$response["role_id"]=$user[0]->role_id;
// 			$response["user_email"]=$user[0]->user_email;
// 			$response["user_mobile_number"]=$user[0]->user_mobile_number;
// 			$response["user_title"]=$user[0]->user_title;
// 			$response["user_name"]=$user[0]->user_name;
// 		}
// 		else{
// 			$response["message"] = 'Please enter, and try again';
// 			$response["exist"] = false;
// 		}
	
// 		echo json_encode($response);
// 	}
	//-----------------------------------------------------
    /**
     * get single record by id
     */
	public function user_registration(){
		$response = array();
		$user_mobile_number = $this->input->post('user_mobile_number');
		$user_title = $this->input->post('user_title');
		$user_email = $this->input->post('user_email');
		$password = $this->input->post('password');
		$mobile_token = $this->input->post('mobile_token');
		$query="INSERT INTO `users`(`role_id`, 
									`user_title`, 
									`user_email`, 
									`user_mobile_number`, 
									`user_name`, 
									`user_password`, 
									`mobile_token`
									) VALUES ('2', 
									'".$user_title."',
									'".$user_email."',
									'".$user_mobile_number."',
									'".$user_mobile_number."',
									'".$password."',
									'".$mobile_token."'
									)";
		if ($this->db->query($query)) {
			$user_id = $this->db->insert_id();
			$response["success"] = true;
			$response["user_id"] = $user_id;
			$response["message"] = "Welcome to Darewro Services";

		} else {
			$response["success"] = false;
			$response["message"] = "Some thing wrong try again.";
		}
		// echoing JSON response
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
	public function check_time(){
	    $Current = date('Y-m-d H:i:s');
	    $cur_time = date('H:i:s');
	    if($cur_time>='00:00:00' && $cur_time<'00:30:00'){
	        $today = date('Y-m-d', time() - 86400);
	        $tomorrow = date('Y-m-d');
	    }
	    else{
	        $today = date('Y-m-d');
	        $tomorrow = date('Y-m-d', time() + 86400);
	    }
        $Start = $today.' 09:15:00';
        $End = $tomorrow.' 00:30:00';
        if (($Current > $Start) && ($Current < $End))
        {
            echo "is between";
        }
        else
        {
            echo "Nope";  
        }
	}
	//-----------------------------------------------------
    /**
     * get single record by id
     */
	public function save_and_process(){
	    
	     
	    
	        $response = array();
            $response["success"] = false;
			$response["message"] = "In committment to the services excellence we've upgraded the app. 
Have the amazing experience with our upgraded and more user friendly app by downloading it from the google play store.";

			echo json_encode($response);
			exit();
	    
	    
	    $Current = date('Y-m-d H:i:s');
	    $cur_time = date('H:i:s');
	    if($cur_time>='00:00:00' && $cur_time<'00:30:00'){
	        $today = date('Y-m-d', time() - 86400);
	        $tomorrow = date('Y-m-d');
	    }
	    else{
	        $today = date('Y-m-d');
	        $tomorrow = date('Y-m-d', time() + 86400);
	    }
        $Start = $today.' 09:15:00';
        $End = $tomorrow.' 00:30:00';
        if (($Current > $Start) && ($Current < $End))
        {
            $order_type  =  $this->input->post("order_type");
		$inputs["order_detail"]  =  $this->input->post("order_detail");
		$inputs["order_picking_address"]  =  $this->input->post("picking_location");
	    $inputs["order_drop_address"]  =  $this->input->post("delivery_location");
		$inputs["mobile_or_call"] = 'Mobile';
		$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
		$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
		$inputs["last_updated"] = date('Y-m-d G:i:s', time());  
		$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$this->input->post('delivery_time')." minutes", time()));
		$inputs["delivery_charges"]  =  $this->input->post("delivery_charges");

		//Add as new customer  
		$customer_mobile_no  =  $this->input->post("customer_mobile_no");
		
		if(substr($customer_mobile_no,0,1)=='+'){ $customer_mobile_no = str_replace('+92','0', $customer_mobile_no); }
		
		$customer_name =  $this->input->post("customer_name");
		if($order_type=="General"){
			$general_order_type = $this->input->post("general_order_type");
			$second_person_name = $this->input->post("second_person_name");
			$second_person_mobile_no = $this->input->post("second_person_mobile_no");
			if($general_order_type=="0"){
				$inputs["order_detail"] = "Take: ".$inputs["order_detail"]." from @".$second_person_name." #".$second_person_mobile_no."\nDrop it to: @".$customer_name." #".$customer_mobile_no;
			}
			else{
				$inputs["order_detail"] = "Take: ".$inputs["order_detail"]." from @".$customer_name." #".$customer_mobile_no."\nDrop it to: @".$second_person_name." #".$second_person_mobile_no;
			}
		}
		
		$comment =  '';
		$query="SELECT `customer_id` FROM `customers` WHERE `mobile_number`= ".$this->db->escape($customer_mobile_no);
		$result = $this->db->query($query);
		//full array 
		$query_result = $result->result()[0];
		if($query_result){
			$customer_id = $query_result->customer_id;
		}
		else{
			$customer_id = 0;
		}
		if($customer_id==0){
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES (".$this->db->escape($customer_mobile_no).",".$this->db->escape($customer_name).",".$this->db->escape($comment).")";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
		}else{
			$inputs["customer_id"] = $customer_id;	
			}
			
		/**********************************end here*******************************************/
		
		$inputs["order_type"]  =  'General Order';
		$inputs["order_status"]  =  '1';
		
		//check user cart if there any food items avaliable or not 
		// in case of avalibility and not pre order the >> to Order placer .order status == 2 for order process 
		//empty means the order is general>>suppervisor.order status == 2 or pre order>>suppervisor.order status == 2
		
		if($order_type=="Food"){
			$inputs["order_type"]  =  'Food Order';
			$inputs["order_status"]  =  '1';
			$cart_items = $this->input->post("cart_items");
			$cart_items = json_decode($cart_items);
			$food_Item_ID = $cart_items->{'food_Item_ID'};
			$food_Item_quantity = $cart_items->{'food_Item_quantity'};
			$restaurantId = array();
			$inputs["order_detail"].= "<br />".$this->input->post("picking_location");
			for ($x = 0; $x < sizeof($food_Item_ID); $x++) {
				$fi = array_values($food_Item_ID)[$x];
				$qty = array_values($food_Item_quantity)[$x];
				$query="SELECT `restaurants`.`restaurant_id`,`restaurants`.`restaurant_name`,`restaurant_food_name`,`restaurant_food_quantity`,`restaurant_food_price` FROM `restaurant_food_menus` JOIN `restaurants` ON `restaurants`.`restaurant_id`=`restaurant_food_menus`.`restaurant_id` WHERE `restaurant_food_menus`.`restaurant_food_menu_id`=".$this->db->escape($fi);
				$result = $this->db->query($query);
				$query_result = $result->result()[0];
				$restaurant_id = $query_result->restaurant_id;
				$restaurantId[$restaurant_id] = $restaurant_id; 
				$inputs["order_detail"].= "<br />".$query_result->restaurant_food_name.": ".$query_result->restaurant_food_quantity.": ".$query_result->restaurant_food_price.": ".$qty.": ".$query_result->restaurant_name;
			} 
		}
		
		if(count($restaurantId)==1){
				$inputs["restaurant_id"] = reset($restaurantId);
				$this->restaurant_push_notification($inputs["restaurant_id"]);
				}
		/**********************************end here*******************************************/
		//check order type
		
		// set order status
		
		// for pre order 

		//$inputs["comment"]  =  '';
		//change time 
		$inputs["created_by"] = $this->input->post("user_id");
		
		$order_id = $this->order_model->save($inputs);
		if($order_type=="Food"){
			$food_Item_ID = $cart_items->{'food_Item_ID'};
			$food_Item_quantity = $cart_items->{'food_Item_quantity'};
			for ($x = 0; $x < sizeof($food_Item_ID); $x++) {
				$fi = array_values($food_Item_ID)[$x];
				$qty = array_values($food_Item_quantity)[$x];
				$query = "INSERT INTO `restaurant_food_orders`(`restaurant_id`, `restaurant_food_menu_id`, `quantity`, `order_id`) 
				  VALUES (".$this->db->escape($restaurant_id).",".$this->db->escape($fi).",".$this->db->escape($qty).",".$this->db->escape($order_id).")";
				$this->db->query($query);
			} 
		}
		
		$response = array();
		if($order_id){
			$response["success"] = true;
			$response["message"] = "Your Order Submitted";
			
			echo json_encode($response);
		}
		else{
			$response["success"] = false;
			$response["message"] = "Some thing wrong try again.";

			echo json_encode($response);
		}
        }
        else
        {
           $response = array();
           $response["success"] = false;
			$response["message"] = "Service timming is 9:15am till 12:30am";

			echo json_encode($response);
        }
		
	} 	
	//-----------------------------------------------------
    /**
     * get single record by id
     */
	public function get_delivery_types(){
		$general_or_food = $this->input->post('general_or_food');
	
		$query="SELECT
		`delivery_id`, `delivery_type_title`
		, `delivery_type_detail`
		, `expected_charges`
		, `expected_delivery_time` FROM `delivery_types` WHERE `general_or_food`=$general_or_food AND `status`= 1 AND (`show_timing_start`<=HOUR(CURRENT_TIMESTAMP( )) AND `show_timing_end`>HOUR(CURRENT_TIMESTAMP( ))) ;";
		$result = $this->db->query($query);
		//full array 
		$query_result = $result->result();
		$response = array();
		if($query_result){
			$response["exist"] = true;
			$response['delivery_types'] = $query_result;
		}
		else{
			$response["exist"] = false;
		}
		echo json_encode($response);
	}
	//-----------------------------------------------------
    /**
     * get single record by id
     */	
	public function send_pin_code(){
	    	
		$user_mobile_number  =  $this->input->post("user_mobile_number");
		$pin_code  =  $this->input->post("pin_code");
		$this->sms_jazz($user_mobile_number, $pin_code.' is your Darewro code.');	
	}
	//-----------------------------------------------------
    /**
     * get single record by id
     */	
	public function test_query($id){
		//$id = $this->input->post('id');
		$query="";
		$result = $this->db->query($query);
		//full array 
		$query_result = $result->result();	
		// only for one record
		$query_result = $result->result()[0];
	
	}	
	
	public function get_current_order_by_user_id(){
		
		$user_id = (int) $this->input->post('user_id');	
			
		$query = "SELECT 
					`orders`.`order_id`,
					`orders`.`order_type`,
					`orders`.`order_date_time`,
					`orders`.`order_place_time`,
					`orders`.`order_ready_time`,
					`orders`.`order_rider_assign_time`,
					`orders`.`order_rider_acknowledge`,
					`orders`.`order_picking_time`,
					`orders`.`order_ready_time`,
					`orders`.`order_detail`,
					`orders`.`order_status`,
					`orders`.`delivery_time`,
					`orders`.`delivery_charges`,
					IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered Order',IF(`orders`.`order_status`=5,'Canceled Order',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`,
					`riders`.`rider_name`,
  					`riders`.`office_no`,
  					`riders`.`rider_image` 
					FROM `riders` 
					 RIGHT JOIN `orders` ON ( `riders`.`rider_id` = `orders`.`rider_id` ) 
					WHERE `orders`.`created_by` ='".$user_id."'
					AND `orders`.`order_status` <=3 
					ORDER BY `orders`.`order_id` DESC LIMIT 1;";
		$query_result = $this->db->query($query);
		$order_detail = $query_result->result();
	
		if($order_detail){
			$order_detail = $query_result->result()[0];
			//order ready time in case of food order 
			$order_ready_time = strtotime($order_detail->order_ready_time)-time();
			$order_detail->remaining_ready_time = $order_ready_time; // in secounds 
			//order delivery time 
			$delivery_remaining_time = strtotime($order_detail->delivery_time)-time();
			$order_detail->remaining_delivery_time = $delivery_remaining_time;  // in secounds
			
			$query="SELECT SUM(`restaurant_food_menus`.`restaurant_food_price`*`restaurant_food_orders`.`quantity`) AS restauranat_total FROM `restaurant_food_menus`,`restaurant_food_orders` WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `restaurant_food_orders`.`restaurant_food_menu_id` AND `restaurant_food_orders`.`order_id` =".$order_detail->order_id;
			$restuarant_order_total = $this->db->query($query);
			$restuarant_total = $restuarant_order_total->result()[0];
			$response['restuarant_total'] = $restuarant_total->restauranat_total;
			$response['order'] = true;
			$response['max_time'] = '45';
			$response['min_time'] = '25';
			$response['order_detail'] = $order_detail;
		}else{
			$response['order'] = false;
			$response['message'] = 'No order inprocess.';
			}
		echo json_encode($response);			
		
		}
		
		
public function get_past_orders_by_user_id(){
		
		$user_id = (int) $this->input->post('user_id');
		$query = "SELECT 
					`orders`.`order_id`,
					`orders`.`order_date_time`,
					`orders`.`order_ready_time`,
					`customers`.`customer_name`,
					`orders`.`delivery_charges`,
					`orders`.`order_detail`,
					`orders`.`order_status`,
					`orders`.`order_picking_address`,
					`orders`.`order_drop_address`,
					`orders`.`reason`,
					IF(`orders`.`order_status`=1,'Unplaced Order',IF(`orders`.`order_status`=2,'Ready Order',IF(`orders`.`order_status`=3,'Running Order',IF(`orders`.`order_status`=4,'Delivered',IF(`orders`.`order_status`=5,'Cancelled',IF(`orders`.`order_status`=6,'Awating Order',IF(`orders`.`order_status`=7,'Scheduled Order', 'NULL'))))))) AS `OrderStatus`
					FROM
					`customers`, 
					`orders` 
					WHERE `orders`.`customer_id` = `customers`.`customer_id` 
					AND `orders`.`created_by` ='".$user_id."'
					AND `orders`.`order_status` >3 
					ORDER BY `orders`.`order_id` DESC ;";
		$query_result = $this->db->query($query);
		$order_detail = $query_result->result();
		if($order_detail){
			$order_detail = $query_result->result();
			$response['order'] = true;
			$response['order_detail'] = $order_detail;
		}else{
			$response['order'] = false;
			$response['message'] = "Order not found.";
			}
		echo json_encode($response);			
		
		}
		
		
		public function get_order_by_id(){
		$order_id = (int) $this->input->post('order_id');
		$order_id = 21455;
$query="SELECT
    `customers`.`mobile_number`
    , `customers`.`customer_name`
    , `customers`.`comment`
    , `riders`.`rider_name` as rider_name
    , `orders`.`reason`
    , `orders`.`mobile_or_call`
    , `orders`.`customer_id`
    , `orders`.`order_detail`
    , `orders`.`order_picking_address`
    , `orders`.`order_drop_address`
    , `orders`.`delivery_charges`
    , `orders`.`orderer_name`,
   DATE_FORMAT( `orders`.`order_date_time`,\"%d %b, %y %h:%i %p\" ) AS order_date_time,
  DATE_FORMAT( `orders`.`delivery_time`,\"%d %b, %y %h:%i %p\" ) AS delivery_time,
  DATE_FORMAT( `orders`.`order_place_time`,\"%d %b, %y %h:%i %p\" ) AS order_place_time,
  DATE_FORMAT( `orders`.`order_ready_time`,\"%d %b, %y %h:%i %p\" ) AS order_ready_time,
  DATE_FORMAT( `orders`.`order_rider_assign_time`,\"%d %b, %y %h:%i %p\" ) AS order_rider_assign_time,
  DATE_FORMAT( `orders`.`order_picking_time`,\"%d %b, %y %h:%i %p\" ) AS order_picking_time,
  DATE_FORMAT( `orders`.`order_rider_acknowledge`,\"%d %b, %y %h:%i %p\" ) AS order_rider_acknowledge,
  DATE_FORMAT( `orders`.`order_rider_picking_time`,\"%d %b, %y %h:%i %p\" ) AS order_rider_picking_time,
  DATE_FORMAT( `orders`.`order_rider_delivery_time`,\"%d %b, %y %h:%i %p\" ) AS order_rider_delivery_time,
  DATE_FORMAT( `orders`.`created_date`,\"%d %b, %y %h:%i %p\" ) AS created_date,
    `users`.`user_title`
	, `orders`.`order_type`
	, `orders`.`order_status`
	,IF(`orders`.`order_status`=1,'Unplaced Order',
  IF(`orders`.`order_status`=2,'Ready Order',
  IF(`orders`.`order_status`=3,'Running Order',
  IF(`orders`.`order_status`=4,'Delivered Order',
  IF(`orders`.`order_status`=5,'Canceled Order',
  IF(`orders`.`order_status`=6,'Awating Order',
  IF(`orders`.`order_status`=7,'Scheduled Order','Not Define'))))))) AS `order_status_title`
	
FROM
    `customers`
    INNER JOIN `orders` 
        ON (`customers`.`customer_id` = `orders`.`customer_id`)
    LEFT JOIN `riders` 
        ON (`orders`.`rider_id` = `riders`.`rider_id`)
    LEFT JOIN `users` 
        ON (`users`.`user_id` = `orders`.`created_by`) WHERE `orders`.`order_id`=".$order_id;
		$result = $this->db->query($query);
		$order_detail = $result->result()[0];
		
		$response = array();
		
	
		if( $order_detail){
			$response["order_detail"] = $order_detail;
			$response["message"] = 'Order Detail Found.';
			$response["success"] = true;
			}else{
				$response["order_detail"] = false;
				$response["message"] = 'Order Detail Not Found.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		
}
		
	public function test_sms_jazz(){
		
	//echo 	$this->sms_jazz('03244424414', 'test message using jazz sms.');
		}		


public function save_and_process_food(){
    
    
    
     $response = array();
            $response["success"] = false;
			$response["message"] = "In committment to the services excellence we've upgraded the app. 
Have the amazing experience with our upgraded and more user friendly app by downloading it from the google play store.";

			echo json_encode($response);
			exit();
    
    
    
    
   
    
    
	    $Current = date('Y-m-d H:i:s');
	    $cur_time = date('H:i:s');
	    if($cur_time>='00:00:00' && $cur_time<'00:30:00'){
	        $today = date('Y-m-d', time() - 86400);
	        $tomorrow = date('Y-m-d');
	    }
	    else{
	        $today = date('Y-m-d');
	        $tomorrow = date('Y-m-d', time() + 86400);
	    }
        $Start = $today.' 09:15:00';
        $End = $tomorrow.' 00:30:00';
        if (($Current > $Start) && ($Current < $End))
        {
			
			//if the darewro open......
			
			
        $order_type  =  $this->input->post("order_type");
		$inputs["order_detail"]  =  $this->input->post("order_detail");
		$inputs["mobile_or_call"] = 'Mobile';
		$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
		$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
		$inputs["last_updated"] = date('Y-m-d G:i:s', time());  
		$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$this->input->post('delivery_time')." minutes", time()));
		$inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
		
		
		//get picking order informaiton here ......
		$inputs["order_picking_address"]  =  $this->input->post("picking_location");
	
		//get drop address here .... 
	    $inputs["order_drop_address"]  =  $this->input->post("delivery_location");
	    $inputs["drop_other_address"]  =  $this->input->post("drop_other_address");
		$inputs["drop_latitude"]  =  $this->input->post("drop_latitude");
		$inputs["drop_longitude"]  =  $this->input->post("drop_longitude");
		$inputs["delivery_street_number"]  =  $this->input->post("delivery_street_number");
		$inputs["delivery_route"]  =  $this->input->post("delivery_route");
		$inputs["delivery_city"]  =  $this->input->post("delivery_city");
		$inputs["delivery_province"]  =  $this->input->post("delivery_province");
		$inputs["delivery_country"]  =  $this->input->post("delivery_country");
		$inputs["delivery_postal_code"]  =  $this->input->post("delivery_postal_code");
		
		
		
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
			$comment =  '';
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES (".$this->db->escape($customer_mobile_no).",".$this->db->escape(ucwords($customer_name)).",".$this->db->escape($comment).")";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
			
			}
		
	
			$inputs["order_type"]  =  'Food Order';
			$inputs["order_status"]  =  '1';
			$cart_items = $this->input->post("cart_items");
			$cart_items = json_decode($cart_items);
			$food_Item_ID = $cart_items->{'food_Item_ID'};
			$food_Item_quantity = $cart_items->{'food_Item_quantity'};
			$restaurantId = array();
			$inputs["order_detail"].= "<br />".$this->input->post("picking_location");
			for ($x = 0; $x < sizeof($food_Item_ID); $x++) {
				$fi = array_values($food_Item_ID)[$x];
				$qty = array_values($food_Item_quantity)[$x];
				$query = "INSERT INTO `restaurant_food_orders`(`restaurant_id`, `restaurant_food_menu_id`, `quantity`, `order_id`) 
				  VALUES ('".$restaurant_id."','".$fi."','".$qty."','".$order_id."')";
				$this->db->query($query);
				$query="SELECT `restaurants`.`restaurant_id`,`restaurants`.`restaurant_name`,`restaurant_food_name`,`restaurant_food_quantity`,`restaurant_food_price` FROM `restaurant_food_menus` JOIN `restaurants` ON `restaurants`.`restaurant_id`=`restaurant_food_menus`.`restaurant_id` WHERE `restaurant_food_menus`.`restaurant_food_menu_id`=$fi;";
				$result = $this->db->query($query);
				$query_result = $result->result()[0];
				$restaurant_id = $query_result->restaurant_id;
				$restaurantId[$restaurant_id] = $restaurant_id; 
				$inputs["order_detail"].= "<br />".$query_result->restaurant_food_name.": ".$query_result->restaurant_food_quantity.": ".$query_result->restaurant_food_price.": ".$qty.": ".$query_result->restaurant_name;
			} 
		
		if(count($restaurantId)==1){
				$inputs["restaurant_id"] = reset($restaurantId);
				$this->restaurant_push_notification($inputs["restaurant_id"]);
				}
		/**********************************end here*******************************************/
		//check order type
		
		// set order status
		
		// for pre order 

		//$inputs["comment"]  =  '';
		//change time 
		$inputs["created_by"] = $this->input->post("user_id");
		
		$order_id = $this->order_model->save($inputs);

		$response = array();
		if($order_id){
			$response["success"] = true;
			$response["message"] = "Your Order Submitted";
			
			echo json_encode($response);
		}
		else{
			$response["success"] = false;
			$response["message"] = "Some thing wrong try again.";

			echo json_encode($response);
		}
		
		
        }
        else
        {
           $response = array();
           $response["success"] = false;
			$response["message"] = "Service timming is 9:15am till 12:30am";

			echo json_encode($response);
        }
		
	} 	


	public function save_and_process_general(){
	    
	    
	    
	     $response = array();
            $response["success"] = false;
			$response["message"] = "In committment to the services excellence we've upgraded the app. 
Have the amazing experience with our upgraded and more user friendly app by downloading it from the google play store.";

			echo json_encode($response);
			exit();
	   
	    
	    
	    
	    $Current = date('Y-m-d H:i:s');
	    $cur_time = date('H:i:s');
	    if($cur_time>='00:00:00' && $cur_time<'00:30:00'){
	        $today = date('Y-m-d', time() - 86400);
	        $tomorrow = date('Y-m-d');
	    }
	    else{
	        $today = date('Y-m-d');
	        $tomorrow = date('Y-m-d', time() + 86400);
	    }
        $Start = $today.' 09:15:00';
        $End = $tomorrow.' 00:30:00';
        if (($Current > $Start) && ($Current < $End))
        {
			
			//if the darewro open......
			
			
        $order_type  =  $this->input->post("order_type");
		$inputs["order_detail"]  =  $this->input->post("order_detail");
		$inputs["mobile_or_call"] = 'Mobile';
		$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
		$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
		$inputs["last_updated"] = date('Y-m-d G:i:s', time());  
		$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$this->input->post('delivery_time')." minutes", time()));
		$inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
		
		
		//get picking order informaiton here ......
		$inputs["order_picking_address"]  =  $this->input->post("picking_location");
		$inputs["pick_other_address"]  =  $this->input->post("pick_other_address");
		//get drop address here .... 
	    $inputs["order_drop_address"]  =  $this->input->post("delivery_location");
	    $inputs["drop_other_address"]  =  $this->input->post("drop_other_address");
		$inputs["drop_latitude"]  =  $this->input->post("drop_latitude");
		$inputs["drop_longitude"]  =  $this->input->post("drop_longitude");
		$inputs["delivery_street_number"]  =  $this->input->post("delivery_street_number");
		$inputs["delivery_route"]  =  $this->input->post("delivery_route");
		$inputs["delivery_city"]  =  $this->input->post("delivery_city");
		$inputs["delivery_province"]  =  $this->input->post("delivery_province");
		$inputs["delivery_country"]  =  $this->input->post("delivery_country");
		$inputs["delivery_postal_code"]  =  $this->input->post("delivery_postal_code");
		
		
		
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
			$comment =  '';
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES (".$this->db->escape($customer_mobile_no).",".$this->db->escape(ucwords($customer_name)).",".$this->db->escape($comment).")";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
			
			}
			
	
		    $inputs["pick_latitude"]  =  $this->input->post("pick_latitude");
		    $inputs["pick_longitude"]  =  $this->input->post("pick_longitude");
		    $inputs["picking_street_number"]  =  $this->input->post("picking_street_number");
		    $inputs["picking_route"]  =  $this->input->post("picking_route");
		    $inputs["picking_city"]  =  $this->input->post("picking_city");
		    $inputs["picking_province"]  =  $this->input->post("picking_province");
		    $inputs["picking_country"]  =  $this->input->post("picking_country");
		    $inputs["picking_postal_code"]  =  $this->input->post("picking_postal_code");
			$general_order_type = $this->input->post("general_order_type");
			$second_person_name = $this->input->post("second_person_name");
			$second_person_mobile_no = $this->input->post("second_person_mobile_no");
			if($general_order_type=="0"){
				$inputs["order_detail"] = "Take: ".$inputs["order_detail"]." from @".$second_person_name." #".$second_person_mobile_no."\nDrop it to: @".$customer_name." #".$customer_mobile_no;
			}
			else{
				$inputs["order_detail"] = "Take: ".$inputs["order_detail"]." from @".$customer_name." #".$customer_mobile_no."\nDrop it to: @".$second_person_name." #".$second_person_mobile_no;
			}
		
		
		$inputs["order_type"]  =  'General Order';
		$inputs["order_status"]  =  '1';
	

		$inputs["created_by"] = $this->input->post("user_id");
		
		$order_id = $this->order_model->save($inputs);

		$response = array();
		if($order_id){
			$response["success"] = true;
			$response["message"] = "Your Order Submitted";
			
			echo json_encode($response);
		}
		else{
			$response["success"] = false;
			$response["message"] = "Some thing wrong try again.";

			echo json_encode($response);
		}
		
		
        }
        else
        {
           $response = array();
           $response["success"] = false;
			$response["message"] = "Service timming is 9:15am till 12:30am";

			echo json_encode($response);
        }
		
	} 	
	
	
	
			
			
public function track_rider_order_id(){
$order_id = (int) $this->input->post('order_id');
//$order_id = 1;
//get reider information ....
		$query='SELECT
			`latitude`
			, `longitude`
			, `created_date`
			, `last_updated`
			, `rider_id`
		FROM
		`rider_order_tracks`
					WHERE  `rider_order_tracks`.`order_id` = '.$this->db->escape($order_id).'
					ORDER BY  `rider_order_tracks`.`created_date` DESC
					LIMIT 10';
		$result = $this->db->query($query);
		$rider_track = $result->result();
		if($rider_track){
			$rider_id=$rider_track[0]->rider_id;
			$query='SELECT
			`rider_name`
			, `rider_image`
			, `office_no`
			, `personal_no`
			FROM
			`riders`
			WHERE 
			`rider_id` = '.$this->db->escape($rider_id).';';
			$result = $this->db->query($query);
			$rider_info = $result->result()[0];
			$response["success"] = true;
			$response["message"] = "Order Track Found";
			$response["ride_track"] = $rider_track;
			$response["rider_info"] = $rider_info;
			
		echo json_encode($response);
		}else{
			
			$response["success"] = false;
			$response["message"] = "Order Track Not Found";
			
		echo json_encode($response);
			
			}
		
}
			
			
			
		 

}        

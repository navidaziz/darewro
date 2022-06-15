<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Orders extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/order_model");
		$this->lang->load("orders", 'english');
		
		$this->load->model("admin/restaurant_food_menu_model");
		$this->lang->load("restaurant_food_menus", 'english');
		$this->load->model("admin/restaurants_model");
		$this->lang->load("restaurants", 'english');
		
		
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		redirect(ADMIN_DIR.$this->session->userdata("role_homepage_uri"), 'refresh');
    }
    //---------------------------------------------------------------



public function save_agent_extention(){
		$extention_id = (int) $this->input->post('extention_id');
		$user_data = array( "extention_id"  => $extention_id  );
		$this->session->set_userdata($user_data);
		}
	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		redirect(ADMIN_DIR.$this->session->userdata("role_homepage_uri"), 'refresh');
    }
    //-----------------------------------------------------
    
	
	public function unplaced_orders(){
		
		$this->data["order_status"] =1;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =1 ORDER BY `orders`.`order_id` DESC";
		$this->data["orders"] = $this->order_model->get_order_list($where, false);
		// $this->data["orders"] = $data->orders;
		// $this->data["pagination"] = $data->pagination;
		$this->data["pagination"] = '';
		 $this->data["title"] = 'Unplaced Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	public function ready_orders(){
		
		$query="SELECT
				`supervisor_tag`,
					COUNT(`supervisor_tag`) AS total
				FROM
				`orders`
				WHERE `orders`.`status` IN (0, 1) AND `order_status` =2 
				GROUP BY supervisor_tag;";
		$query_result = $this->db->query($query);
		$supervisor_tags = $query_result->result();
		foreach($supervisor_tags as $supervisor_tag){
			$this->data["order_status"] =2;
        	$where = "`orders`.`status` IN (0, 1) 
			AND  `order_status` =2
			AND `supervisor_tag` = ".$this->db->escape($supervisor_tag->supervisor_tag)." 
			ORDER BY `orders`.`order_id` DESC";
			$supervisor_tag->orders = $this->order_model->get_order_list($where, false);
		}
		
		$this->data['supervisor_tags'] = $supervisor_tags;
		// $this->data["orders"] = $data->orders;
		//$this->data["pagination"] = $data->pagination;
		$this->data["pagination"] = '';
		$this->data["title"] = 'Ready Orders';
		$this->data["view"] = ADMIN_DIR."orders/supervisor_orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	public function running_orders(){
		$this->data["order_status"] =3;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =3 ORDER BY `orders`.`order_id` DESC";
		$this->data["orders"] = $this->order_model->get_order_list($where, false);
		/* $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;*/
		 $this->data["pagination"] ='';
		 $this->data["title"] = 'Running Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	public function delivered_orders(){
		$this->data["order_status"] =4;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =4 ORDER BY `orders`.`order_id` DESC";
		$data = $this->order_model->get_order_list($where);
		 $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = 'Delivered Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	
	public function canceled_orders(){
		$this->data["order_status"] =5;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =5 ORDER BY `orders`.`order_id` DESC";
		$data = $this->order_model->get_order_list($where);
		 $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = 'Canceled Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	
	
	
	public function awaited_orders(){
		$this->data["order_status"] =6;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =6 ORDER BY `orders`.`order_id` DESC";
		$data = $this->order_model->get_order_list($where);
		 $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = 'Awaiting Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	
	public function scheduled_order(){
	$this->data["order_status"] =7;
        $where = "`orders`.`status` IN (0, 1) and `order_status` =7 ORDER BY `orders`.`order_id` DESC";
		$data = $this->order_model->get_order_list($where);
		 $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = 'Sheduled Orders';
		$this->data["view"] = ADMIN_DIR."orders/orders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
    /**
     * get single record by id
     */
    public function view_order($order_id){
        
        $order_id = (int) $order_id;
        
        $this->data["orders"] = $this->order_model->get_order($order_id);
        $this->data["title"] = $this->lang->line('Order Details');
		$this->data["view"] = ADMIN_DIR."orders/view_order";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`orders`.`status` IN (2)  ORDER BY `orders`.`order_id` DESC";
		$data = $this->order_model->get_order_list($where);
		 $this->data["orders"] = $data->orders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Orders');
		$this->data["view"] = ADMIN_DIR."orders/trashed_orders";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	
	 
	
	
	
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($order_id, $page_id = NULL){
        
        $order_id = (int) $order_id;
        
        
        $this->order_model->changeStatus($order_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."orders/view/".$page_id);
    }
    
    /**
      * function to restor order from trash
      * @param $order_id integer
      */
     public function restore($order_id, $page_id = NULL){
        
        $order_id = (int) $order_id;
        
        
        $this->order_model->changeStatus($order_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."orders/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft order from trash
      * @param $order_id integer
      */
     public function draft($order_id, $page_id = NULL){
        
        $order_id = (int) $order_id;
        
        
        $this->order_model->changeStatus($order_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."orders/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish order from trash
      * @param $order_id integer
      */
     public function publish($order_id, $page_id = NULL){
        
        $order_id = (int) $order_id;
        
        
        $this->order_model->changeStatus($order_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."orders/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Order
      * @param $order_id integer
      */
     public function delete($order_id, $page_id = NULL){
        
        $order_id = (int) $order_id;
        //$this->order_model->changeStatus($order_id, "3");
        
		$this->order_model->delete(array( 'order_id' => $order_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."orders/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 public function add_new_order(){
		 
		 $query="DELETE FROM `item_cart` WHERE `user_id`='".$this->session->userdata("user_id")."' AND `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
		$this->db->query($query);
		 //get restorent data
		 $this->data["restaurants"] = $this->restaurants_model->getList("restaurants", "restaurant_id", "restaurant_name", $where ="`restaurants`.`status` = 1", "restaurant_name ASC");
		 
		 $query='SELECT * FROM `address` WHERE `address`.`address_parent_id`=0';
		$result = $this->db->query($query);
		$this->data['addresses'] = $result->result();
		 
		 
        $this->data["title"] = $this->lang->line('Add New Order');
		$this->data["view"] = ADMIN_DIR."orders/add_order";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     
     
     
     public function add_order_new(){
		 
		 $query="DELETE FROM `item_cart` WHERE `user_id`='".$this->session->userdata("user_id")."' AND `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
		$this->db->query($query);
		 //get restorent data
		 $this->data["restaurants"] = $this->restaurants_model->getList("restaurants", "restaurant_id", "restaurant_name", $where ="`restaurants`.`status` = 1", "restaurant_name ASC");
		 
		 $query='SELECT * FROM `address` WHERE `address`.`address_parent_id`=0';
		$result = $this->db->query($query);
		$this->data['addresses'] = $result->result();
		 
		 
        $this->data["title"] = $this->lang->line('Add New Order');
		$this->data["view"] = ADMIN_DIR."orders/add_order_new";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     
 public function save_and_process_new(){
     
		
		$inputs["order_detail"]  =  $this->input->post("order_detail");
		
		//Add as new customer  
		$customer_mobile_no  =  $this->input->post("customer_mobile_no");
		$customer_name =  $this->input->post("customer_name");
		$comment =  $this->input->post("comment");
		if($this->input->post("customer_id")==0){
			$query = "INSERT INTO `customers`(
					 `mobile_number`, 
					 `customer_name`, 
					 `comment`) 
					 VALUES (".$this->db->escape($customer_mobile_no).",
					         ".$this->db->escape(ucwords($customer_name)).",
							 ".$this->db->escape($comment).")";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
		}else{
			$inputs["customer_id"]= $customer_id = $this->input->post("customer_id");	
			//check the user name is same or not 
			$this->db->query("UPDATE `customers` 
							  SET `customer_name`=".$this->db->escape($customer_name)." 
							  WHERE `customer_id`=".$this->db->escape($customer_id));
			
			
			}
		
		
		
		//get picking order informaiton here ......
		$inputs["order_picking_address"]  =  $this->input->post("picking_location");
		$inputs["pick_latitude"]  =  $this->input->post("pick_latitude");
		$inputs["pick_longitude"]  =  $this->input->post("pick_longitude");
		$inputs["picking_street_number"]  =  $this->input->post("picking_street_number");
		$inputs["picking_route"]  =  $this->input->post("picking_route");
		$inputs["picking_city"]  =  $this->input->post("picking_city");
		$inputs["picking_province"]  =  $this->input->post("picking_province");
		$inputs["picking_country"]  =  $this->input->post("picking_country");
		$inputs["picking_postal_code"]  =  $this->input->post("picking_postal_code");
		
			//save customer picking locaiton .....
			if($this->input->post("address_save")=='save_picking_location'){
			$query ="SELECT COUNT(`customer_location_id`) as total 
					FROM `customer_locations` 
					WHERE `location_address`=".$this->db->escape($inputs["order_picking_address"])."";
			$result = $this->db->query($query);
				if($result->result()[0]->total == 0){
				$query = "INSERT INTO `customer_locations` (
						`location_address`,
						`customer_id`,
						`latitude`, 
						`longitude`, 
						`street_number`, 
						`route`, 
						`city`, 
						`province`, 
						`country`, 
						`postal_code`) 
				VALUES (".$this->db->escape($inputs["order_picking_address"]).", 
						".$this->db->escape($inputs["customer_id"]).",
						".$this->db->escape($inputs["pick_latitude"]).",
						".$this->db->escape($inputs["pick_longitude"]).",
						".$this->db->escape($inputs["picking_street_number"]).",
						".$this->db->escape($inputs["picking_route"]).",
						".$this->db->escape($inputs["picking_city"]).",
						".$this->db->escape($inputs["picking_province"]).",
						".$this->db->escape($inputs["picking_country"]).",
						".$this->db->escape($inputs["picking_postal_code"]).");";
				$this->db->query($query);
				}
			}
		
		
		//end here .....
		
		//get drop address here .... 
	    $inputs["order_drop_address"]  =  $this->input->post("delivery_location");
		$inputs["drop_latitude"]  =  $this->input->post("drop_latitude");
		$inputs["drop_longitude"]  =  $this->input->post("drop_longitude");
		$inputs["delivery_street_number"]  =  $this->input->post("delivery_street_number");
		$inputs["delivery_route"]  =  $this->input->post("delivery_route");
		$inputs["delivery_city"]  =  $this->input->post("delivery_city");
		$inputs["delivery_province"]  =  $this->input->post("delivery_province");
		$inputs["delivery_country"]  =  $this->input->post("delivery_country");
		$inputs["delivery_postal_code"]  =  $this->input->post("delivery_postal_code");
			
			//save customer delivery location .....
			if($this->input->post("address_save")=='save_delivery_location'){
			$query ="SELECT COUNT(`customer_location_id`) as total FROM `customer_locations` 
			WHERE `location_address`=".$this->db->escape($inputs["order_drop_address"])."";
			$result = $this->db->query($query);
				if($result->result()[0]->total == 0){
				$query = "INSERT INTO `customer_locations` (
						`location_address`,
						`customer_id`,
						`latitude`, 
						`longitude`, 
						`street_number`, 
						`route`, 
						`city`, 
						`province`, 
						`country`, 
						`postal_code`) 
				VALUES (".$this->db->escape($inputs["order_picking_address"]).", 
						".$this->db->escape($inputs["customer_id"]).",
						".$this->db->escape($inputs["drop_latitude"]).",
						".$this->db->escape($inputs["drop_longitude"]).",
						".$this->db->escape($inputs["delivery_street_number"]).",
						".$this->db->escape($inputs["delivery_route"]).",
						".$this->db->escape($inputs["delivery_city"]).",
						".$this->db->escape($inputs["delivery__province"]).",
						".$this->db->escape($inputs["delivery_country"]).",
						".$this->db->escape($inputs["delivery_postal_code"])."
						
						);";
				$this->db->query($query);
				}
			}
		
		//end here .....
		
		
		
		
				
		/**********************************end here*******************************************/
		$inputs["mobile_or_call"] = 'Call';
		$inputs["order_type"]  =  'General Order';
		$inputs["order_status"]  =  '1';
		if($this->input->post('need_to_placed')){
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			}
		
		//check user cart if there any food items avaliable or not 
		// in case of avalibility and not pre order the >> to Order placer .order status == 2 for order process 
		//empty means the order is general>>suppervisor.order status == 2 or pre order>>suppervisor.order status == 2
		$this->load->model("admin/cart_item_model");
		
		$cart_items = $this->cart_item_model->get_cart_items();
		if($cart_items){
			$food_items = array();
			$total_restaurant = 0;
			$restaurantId = array();
			foreach($cart_items as $cart_item){
				$restaurantId[$cart_item->restaurant_id] = $cart_item->restaurant_id; 
				$food_items[$cart_item->restaurant_name][] = $cart_item->restaurant_food_name.": ".$cart_item->restaurant_food_quantity.": ".$cart_item->restaurant_food_price.": ".$cart_item->quantity;
				
				}
			foreach($food_items as $restorent_name => $restorent_item_orders){
				
				$inputs["order_detail"].= "<br />".$restorent_name;
				foreach($restorent_item_orders as $restorent_item_order){
					$inputs["order_detail"].= "<br />".$restorent_item_order;
				}
				}
			
			//if the order for only one restaurant the send assign the order the restaurant id 
			if(count($restaurantId)==1){
				$inputs["restaurant_id"] = reset($restaurantId);
				$this->restaurant_push_notification($inputs["restaurant_id"]);
				//get restaurant coordiantes 
				/*$query="SELECT `restaurant_latitude`,`restaurant_longitude`
						FROM `restaurants` 
						WHERE `restaurant_id`=".$this->db->escape($inputs["restaurant_id"]);
				$query_result = $this->db->query($query);
				$restaurant_coordinates = $query_result->result()[0];
				$inputs["pick_latitude"] = $restaurant_coordinates->restaurant_latitude;
				$inputs["pick_longitude"] = $restaurant_coordinates->restaurant_longitude;*/
				}else{
					$restaurantIds = $restaurantId;
					$inputs['pick_location_multiple']=1;
					$inputs["pick_latitude"]  = NULL;
					$inputs["pick_longitude"]  =  NULL;
					$inputs["picking_street_number"]  =  NULL;
					$inputs["picking_route"]  =  NULL;
					}
			
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			
			
			
			
			
		}
		//exit();
		//incase of pre order
		//and direct send supervisor 
		if($this->input->post("pre_order")=='pre_order'){
			//create ready time 
			$order_ready_time = strtotime("+".$this->input->post('order_ready_time')." minutes", time());
			$inputs["order_ready_time"]  =  date("Y-m-d G:i:s", $order_ready_time);
			$inputs["orderer_name"]  =  $this->input->post("orderer_name");
			$inputs["is_pre_order"]  =  '1';
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			
		}
		
		/**********************************end here*******************************************/
		//check order type
		
		// set order status
		
		// for pre order 
		
		
		$inputs["comment"]  =  '';
		//get promocode
		$inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
		$inputs["delivery_charges_org"]  =  $this->input->post("delivery_charges");
		 $inputs["delivery_discount_amount"]  =  0;
		$promo_code = $this->input->post("promo_code");
		
		$query = "SELECT * FROM `promo_codes` 
				  WHERE `promo_code`=".$this->db->escape($promo_code)."
				  AND DATE(`expiry`)='".date("Y-m-d", time())."'
				  AND status=1";
		$query_result = $this->db->query($query);
		$promo_code_info = $query_result->result();
		if($promo_code_info){
			$promo_code_info = $promo_code_info[0];
			//var_dump($promo_code_info);
			switch($promo_code_info->discount_operation){
				case '%':
				  $inputs["delivery_charges"] = ($promo_code_info->discount_amount*$this->input->post("delivery_charges"))/100;
				  $inputs["delivery_charges_org"]  =  $this->input->post("delivery_charges");
				  $inputs["delivery_discount_amount"]  =  $promo_code_info->discount_amount;
				  $inputs["delivery_discount_operation"]  =  $promo_code_info->discount_operation;
				break;
				
				case '-':
				  $inputs["delivery_charges"] = ($this->input->post("delivery_charges")-$promo_code_info->discount_amount);
				  $inputs["delivery_charges_org"]  =  $this->input->post("delivery_charges");
				  $inputs["delivery_discount_amount"]  =  $promo_code_info->discount_amount;
				  $inputs["delivery_discount_operation"]  =  $promo_code_info->discount_operation;
				break;
				
				}
			
			
			}
			
		
		//change time 
		$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$this->input->post('delivery_time')." minutes", time()));
		$inputs["created_by"] = $this->session->userdata("user_id");
		
		//incase of sehcule order 
		if($this->input->post("shedule")=='shedule'){
			$inputs["order_status"]  =  '7';
			$shedule_date_time = $this->input->post("shedule_date")." ".date('G:i:s',time());
			$inputs["order_date_time"] = date('Y-m-d G:i:s',strtotime($shedule_date_time));
			}
		if($this->input->post("extra")){	
		$inputs["order_detail"].= "<br />Ex:".$this->input->post("extra");
		}
		
		$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
		$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
		$inputs["last_updated"] = date('Y-m-d G:i:s', time()); 
		
		$order_id = $this->order_model->save($inputs);
		
		if(isset($inputs['pick_location_multiple']) and $inputs['pick_location_multiple']=1){
			foreach($restaurantIds as $index => $restaurantId){
				$query="SELECT
							`restaurant_address`
							, `restaurant_street_number`
							, `restaurant_route`
							, `restaurant_city`
							, `restaurant_province`
							, `restaurant_country`
							, `restaurant_latitude`
							, `restaurant_longitude`
						FROM
							`restaurants`
						WHERE `restaurants`.`restaurant_id`=".$this->db->escape($restaurantId);
				$query_result = $this->db->query($query);
				$restaurant_address_info = $query_result->result()[0];
				$query = "INSERT INTO `order_locations` (
						`location_address`,
						`order_id`,
						`latitude`, 
						`longitude`, 
						`street_number`, 
						`route`, 
						`city`, 
						`province`, 
						`country`, 
						`postal_code`) 
				VALUES (".$this->db->escape($restaurant_address_info->restaurant_address).", 
						".$this->db->escape($order_id).",
						".$this->db->escape($restaurant_address_info->restaurant_latitude).",
						".$this->db->escape($restaurant_address_info->restaurant_longitude).",
						".$this->db->escape($restaurant_address_info->restaurant_street_number).",
						".$this->db->escape($restaurant_address_info->restaurant_route).",
						".$this->db->escape($restaurant_address_info->restaurant_city).",
						".$this->db->escape($restaurant_address_info->restaurant_province).",
						".$this->db->escape($restaurant_address_info->restaurant_country).",
						'');";
				$this->db->query($query);	
				}
			}
		
		
		foreach($cart_items as $cart_item){
			
			//get restaurant food price ....
			
			$query="SELECT `restaurant_food_price` 
					FROM `restaurant_food_menus` 
					WHERE restaurant_food_menu_id=".$this->db->escape($cart_item->restaurant_food_menu_id);
			$query_result = $this->db->query($query);
			$restaurant_food_price = $query_result->result()[0]->restaurant_food_price;
			
		
		$query = "INSERT INTO `restaurant_food_orders`(`restaurant_id`, `restaurant_food_menu_id`, `restaurant_food_price`, `quantity`, `order_id`) 
				  VALUES (".$this->db->escape($cart_item->restaurant_id).",
				          ".$this->db->escape($cart_item->restaurant_food_menu_id).",
						  ".$this->db->escape($restaurant_food_price).",
						  ".$this->db->escape($cart_item->quantity).",
						  ".$this->db->escape($order_id).")";
		$this->db->query($query);		  
				  
		}
		
		
		
		
		
		
		$query="DELETE FROM `item_cart` WHERE `user_id`='".$this->session->userdata("user_id")."' AND `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
		$this->db->query($query);
		
		$this->session->set_flashdata("msg_success", 'Order Successfuly Save and Forwarded');
		
		redirect(ADMIN_DIR."orders/add_order_new");	 
		
		
		
		} 
	 
     /**
      * function to add new Order
      */
     /*public function add(){
		
		 
     }*/
     //--------------------------------------------------------------------
    /* public function save_data(){
	  if($this->order_model->validate_form_data() === TRUE){
		  
		  $order_id = $this->order_model->save_data();
          if($order_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."orders/edit/$order_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."orders/add");
            }
        }else{
			$this->add();
			}
	 }*/
	 
	public function save_and_process(){
	 $picking_location = str_replace('"', '', strip_hidden_chars($this->input->post("picking_location")));
	 $picking_location = str_replace(']', '', $picking_location);
	 $inputs["order_picking_address"] = $picking_location = str_replace('[', '', $picking_location);
	 $order_picking_addresses = explode(",", $picking_location);
	  if(!is_array($picking_location)){
		  $picking_location[0] = $picking_location;
		 }
		// var_dump($order_picking_address);
		
	 $delivery_location = str_replace('"', '',  strip_hidden_chars($this->input->post("delivery_location")));
	 $delivery_location = str_replace(']', '', $delivery_location);
	 $inputs["order_drop_address"] = $delivery_location = str_replace('[', '', $delivery_location);
	 $delivery_locations = explode(",", $delivery_location);
	 if(!is_array($delivery_locations)){
		  $delivery_locations[0] = $delivery_location;
		 }
		 
		
		
		$inputs["order_detail"]  =  $this->input->post("order_detail");
		//$inputs["order_picking_address"]  =  $this->input->post("picking_location");
	   // $inputs["order_drop_address"]  =  $this->input->post("delivery_location");
		$inputs["mobile_or_call"] = 'Call';
		//Add as new customer  
		$customer_mobile_no  =  $this->input->post("customer_mobile_no");
		$customer_name =  $this->input->post("customer_name");
		$comment =  $this->input->post("comment");
		if($this->input->post("customer_id")==0){
			$query = "INSERT INTO `customers`(`mobile_number`, `customer_name`, `comment`) 
			VALUES (".$this->db->escape($customer_mobile_no).",".$this->db->escape(ucwords($customer_name)).",".$this->db->escape($comment).")";
			$result = $this->db->query($query);
			$inputs["customer_id"] = $this->db->insert_id();
		}else{
			$inputs["customer_id"]= $customer_id = $this->input->post("customer_id");	
			//check the user name is same or not 
			$this->db->query("UPDATE `customers` SET `customer_name`=".$this->db->escape($customer_name)." 
			WHERE `customer_id`=".$this->db->escape($customer_id));
			
			
			}
		
		if($this->input->post("address_save")=='save_picking_location'){
			$query ="SELECT COUNT(`customer_location_id`) as total 
					FROM `customer_locations` 
					WHERE `location_address`=".$this->db->escape($inputs["order_picking_address"])."";
			$result = $this->db->query($query);
				if($result->result()[0]->total == 0){
				$query = "INSERT INTO `customer_locations` (`location_address`,`customer_id`) 
				VALUES (".$this->db->escape($inputs["order_picking_address"]).", ".$this->db->escape($inputs["customer_id"]).");";
				$this->db->query($query);
				}
			}
		if($this->input->post("address_save")=='save_delivery_location'){
			$query ="SELECT COUNT(`customer_location_id`) as total FROM `customer_locations` 
			WHERE `location_address`=".$this->db->escape($inputs["order_drop_address"])."";
			$result = $this->db->query($query);
				if($result->result()[0]->total == 0){
				$query = "INSERT INTO `customer_locations` (`location_address`,`customer_id`) VALUES (".$this->db->escape($inputs["order_drop_address"]).", ".$this->db->escape($inputs["customer_id"]).");";
				$this->db->query($query);
				}
			}		
		/**********************************end here*******************************************/
		
		$inputs["order_type"]  =  'General Order';
		$inputs["order_status"]  =  '1';
		if($this->input->post('need_to_placed')){
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			}
		
		//check user cart if there any food items avaliable or not 
		// in case of avalibility and not pre order the >> to Order placer .order status == 2 for order process 
		//empty means the order is general>>suppervisor.order status == 2 or pre order>>suppervisor.order status == 2
		$this->load->model("admin/cart_item_model");
		
		$cart_items = $this->cart_item_model->get_cart_items();
		if($cart_items){
			$food_items = array();
			$total_restaurant = 0;
			$restaurantId = array();
			foreach($cart_items as $cart_item){
				$restaurantId[$cart_item->restaurant_id] = $cart_item->restaurant_id; 
				$food_items[$cart_item->restaurant_name][] = $cart_item->restaurant_food_name.": ".$cart_item->restaurant_food_quantity.": ".$cart_item->restaurant_food_price.": ".$cart_item->quantity;
				
				}
			foreach($food_items as $restorent_name => $restorent_item_orders){
				
				$inputs["order_detail"].= "<br />".$restorent_name;
				foreach($restorent_item_orders as $restorent_item_order){
					$inputs["order_detail"].= "<br />".$restorent_item_order;
				}
				}
			
			//if the order for only one restaurant the send assign the order the restaurant id 
			if(count($restaurantId)==1){
				$inputs["restaurant_id"] = reset($restaurantId);
				$this->restaurant_push_notification($inputs["restaurant_id"]);
				
				$query="SELECT `restaurant_latitude`,`restaurant_longitude`
						FROM `restaurants` 
						WHERE `restaurant_id`=".$this->db->escape($inputs["restaurant_id"]);
				$query_result = $this->db->query($query);
				$restaurant_coordinates = $query_result->result()[0];
				$inputs["pick_latitude"] = $restaurant_coordinates->restaurant_latitude;
				$inputs["pick_longitude"] = $restaurant_coordinates->restaurant_longitude;
				
				
				}
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			
			
			
			
			
		}
		//exit();
		//incase of pre order
		//and direct send supervisor 
		if($this->input->post("pre_order")=='pre_order'){
			//create ready time 
			$order_ready_time = strtotime("+".$this->input->post('order_ready_time')." minutes", time());
			$inputs["order_ready_time"]  =  date("Y-m-d G:i:s", $order_ready_time);
			$inputs["orderer_name"]  =  $this->input->post("orderer_name");
			$inputs["is_pre_order"]  =  '1';
			$inputs["order_status"]  =  '1';
			$inputs["order_type"]  =  'Food Order';
			
		}
		
		/**********************************end here*******************************************/
		//check order type
		
		// set order status
		
		// for pre order 
		
		
		$inputs["comment"]  =  '';
		$inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
		//change time 
		$inputs["delivery_time"]  =  date("Y-m-d G:i:s", strtotime("+".$this->input->post('delivery_time')." minutes", time()));
		$inputs["created_by"] = $this->session->userdata("user_id");
		
		//incase of sehcule order 
		if($this->input->post("shedule")=='shedule'){
			$inputs["order_status"]  =  '7';
			$shedule_date_time = $this->input->post("shedule_date")." ".date('G:i:s',time());
			$inputs["order_date_time"] = date('Y-m-d G:i:s',strtotime($shedule_date_time));
			}
		if($this->input->post("extra")){	
		$inputs["order_detail"].= "<br />Ex:".$this->input->post("extra");
		}
		
		$inputs["order_date_time"] = date('Y-m-d G:i:s', time());
		$inputs["created_date"] = date('Y-m-d G:i:s', time()); 
		$inputs["last_updated"] = date('Y-m-d G:i:s', time()); 
		
		$order_id = $this->order_model->save($inputs);
		foreach($cart_items as $cart_item){
		
		$query = "INSERT INTO `restaurant_food_orders`(`restaurant_id`, `restaurant_food_menu_id`, `quantity`, `order_id`) 
				  VALUES (".$this->db->escape($cart_item->restaurant_id).",
				          ".$this->db->escape($cart_item->restaurant_food_menu_id).",
						  ".$this->db->escape($cart_item->quantity).",
						  ".$this->db->escape($order_id).")";
		$this->db->query($query);		  
				  
		}
		
		foreach($delivery_locations as $delivery_location){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES (".$this->db->escape($order_id).",
				  ".$this->db->escape($delivery_location).", 
				  'drop')";
			$this->db->query($query);
			
			}
		foreach($order_picking_addresses as $order_picking_address){
			$query = "INSERT INTO `order_location_tags`(`order_id`, `location`, `location_type`) 
				  VALUES (".$this->db->escape($order_id).",
				  ".$this->db->escape($order_picking_address).",
				  'pick' )";
			$this->db->query($query);
			}
		
		
		
		
		$query="DELETE FROM `item_cart` WHERE `user_id`='".$this->session->userdata("user_id")."' AND `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
		$this->db->query($query);
		
		$this->session->set_flashdata("msg_success", 'Order Successfuly Save and Forwarded');
		
		redirect(ADMIN_DIR."orders/add_new_order");	 
		
		} 
	 
	 


     /**
      * function to edit a Order
      */
    /* public function edit($order_id){
		 $order_id = (int) $order_id;
        $this->data["order"] = $this->order_model->get($order_id);
		  
        $this->data["title"] = $this->lang->line('Edit Order');$this->data["view"] = ADMIN_DIR."orders/edit_order";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }*/
     //--------------------------------------------------------------------
	 
	/* public function update_data($order_id){
		 
		 $order_id = (int) $order_id;
       
	   if($this->order_model->validate_form_data() === TRUE){
		  
		  $order_id = $this->order_model->update_data($order_id);
          if($order_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."orders/edit/$order_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."orders/edit/$order_id");
            }
        }else{
			$this->edit($order_id);
			}
		 
		 }*/
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["orders"] = $this->order_model->getBy($where, false, "order_id" );
				$j_array[]=array("id" => "", "value" => "order");
				foreach($data["orders"] as $order ){
					$j_array[]=array("id" => $order->order_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	public function check_customer_detail($mobile_number){
		$mobile_number = (double) $mobile_number;
		$query='SELECT * FROM `customers` WHERE `customers`.`mobile_number`='.$mobile_number." AND `status`=1";
		$result = $this->db->query($query);
		$customer_informaton = $result->result();
		$j_array['found'] =0; 
		if($customer_informaton){
			$customer_informaton = $result->result()[0];
			$j_array['found'] =1;
			$j_array['customer_name'] =$customer_informaton->customer_name; 
			$j_array['comment'] =$customer_informaton->comment; 
			$j_array['customer_id'] =$customer_informaton->customer_id; 
				$query='SELECT * FROM `customer_locations` WHERE `customer_locations`.`customer_id`='.$customer_informaton->customer_id;
				$result = $this->db->query($query);
				$locations = $result->result();
				foreach($locations as $index => $location){
					$j_array['customer_locations'][$index]['id']=$location->customer_location_id;
					$j_array['customer_locations'][$index]['name']=$location->location_address;
					}
			}
		echo json_encode($j_array);
		}
		
	public function get_address($location){
		//$location_address_id = (double) $location_address_id;
		//$query="SELECT * FROM `address` WHERE `address`.`address_parent_id`=$location_address_id";
		 $query="SELECT * FROM `address` WHERE `address`.`address_title` LIKE '".$location."%' ORDER BY`address`.`address_title` ASC LIMIT 10";
		$result = $this->db->query($query);
		$addresses = $result->result();
		$address_array = array();
		$i=0;
		foreach($addresses as $address){
			$address_array[$i]['id'] = $address->address_title;
			$address_array[$i]['name'] = $address->address_title;
			$i++;
			}
		echo json_encode($address_array);
		}
		
	public function place_order(){
		$order_id  =  (int) $this->input->post("order_id");
		$orderer_name  =  $this->input->post("order_name");
		$delivery_charges  =  (int) $this->input->post("delivery_charges");
		$order_type  =  $this->input->post("order_type");
		//order ready time 
		$order_ready_time = (int) $this->input->post('order_ready_time');
		//get order delivery time for add the ready time....
		$query="SELECT `orders`.`delivery_time`, `orders`.`delivery_charges` 
		FROM `orders` WHERE `orders`.`order_id`='".$order_id."'";
		$query_result = $this->db->query($query);
		
		
		$org_delivery_charges = $query_result->result()[0]->delivery_charges;
		//if the order chargers changer add to order edit ..
		if($org_delivery_charges!=$delivery_charges){
			$query="INSERT INTO `order_edits`(`order_id`, `delivery_charges`, `order_detail`, `date`, `order_edited_by`) 
		        VALUES ('".$order_id."','".$org_delivery_charges."','','".date("Y-m-d G:i:s", time())."', '".$this->session->userdata("user_id")."')";
				
				$this->db->query($query);
			}
		
		
		$order_delivery_time = strtotime($query_result->result()[0]->delivery_time);
		$order_delivery_time = strtotime("+".$order_ready_time." minutes", $order_delivery_time);
		$order_delivery_time = date("Y-m-d G:i:s", $order_delivery_time);
		
		
		$order_ready_time = strtotime("+".$order_ready_time." minutes", time());
		$order_ready_time = date("Y-m-d G:i:s", $order_ready_time);
		//order place time 
		$order_place_time = date("Y-m-d G:i:s", time());
		$query = "UPDATE `orders` SET `orderer_name`=".$this->db->escape($orderer_name).",
				  `order_ready_time`=".$this->db->escape($order_ready_time).",
				  `delivery_charges`=".$this->db->escape($delivery_charges).",
				  `order_type`=".$this->db->escape($order_type).",
				  `order_placed_by`=".$this->db->escape($this->session->userdata("user_id")).",
				  `order_place_time`=".$this->db->escape($order_place_time).", 
				  `order_status`='2',
				  `delivery_time`=".$this->db->escape($order_delivery_time)."
				  WHERE `order_id`=".$this->db->escape($order_id);
				 
		if($this->db->query($query)){ $this->push_notification($order_id,2); }
		
		$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
		redirect(ADMIN_DIR."orders/unplaced_orders");
		}
		
	public function order_delivered(){
		$order_id  =  (int) $this->input->post("order_id");
		
		$order_rider_delivery_time = date("Y-m-d G:i:s", time());
		$query = "UPDATE `orders` SET `order_rider_delivery_time`='".$order_rider_delivery_time."', 
				  `order_status`='4'
				  WHERE `order_id`='".$order_id."'";
		if($this->db->query($query)){ $this->push_notification($order_id,4); }
		$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
		//$this->ready_orders();
		redirect(ADMIN_DIR."orders/ready_orders");
		}
		
	public function order_cancel_or_awaiting(){
		$order_id  =  (int) $this->input->post("order_id");
		if($this->input->post("buttom")=='cancel_order'){
			$order_status =5;
			}	
		if($this->input->post("buttom")=='awaiting_order'){
			$order_status =6;
			}	
		$reason  =  $this->input->post("reason");
		$query = "UPDATE `orders` SET `reason`=".$this->db->escape($reason).", 
				  `order_status`='".$order_status."',
				  `cancelled_by`='".$this->session->userdata("user_id")."',
				  `cancelled_time`='".date("Y-m-d G:i:s", time())."'
				  WHERE `order_id`='".$order_id."'";
		if($this->db->query($query)){ $this->push_notification($order_id, $order_status); }
		$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
		redirect(ADMIN_DIR."orders/ready_orders");
		//$this->();
		}	
		
	public function get_riders(){
		$hour = date("H", time());
		/*$query="SELECT `rider_id`, `rider_name`,`ability_level`, `office_no` FROM `riders` 
		WHERE (`duty_start`<='".$hour."' AND `duty_end`>='".$hour."'
		AND `is_absent`=0) OR `is_available`=1 ORDER BY `rider_name` ASC";*/
		
		$query="SELECT `rider_id`, `rider_name`,`ability_level`, `office_no` FROM `riders` 
		WHERE `is_available`=1 ORDER BY `rider_name` ASC";
		
		$result = $this->db->query($query);
		$riders = $result->result();
		foreach($riders as $rider){
			$query="SELECT COUNT(`order_id`) as total 
			FROM `orders`
			WHERE `order_status`='3' 
			AND `rider_id`='".$rider->rider_id."' ORDER BY `order_id` DESC";
					
		$result = $this->db->query($query);
		$rider_orders = $result->result()[0];
			if($rider_orders->total){
				$rider->status='';
				$rider->total_order=$rider_orders->total;
				
				//get last assignment....
				$query="SELECT  `order_rider_assign_time`  
							FROM `orders` 
					WHERE `order_status`='3' 
					AND `rider_id`='".$rider->rider_id."' ORDER BY `order_rider_assign_time` DESC LIMIT 1";
					$result = $this->db->query($query);
					$order_rider_assign_time = $result->result()[0];
					$rider->last_assigned_time = strtotime($order_rider_assign_time->order_rider_assign_time).' - '.ucfirst(strtolower(get_timeago($order_rider_assign_time->order_rider_assign_time)));
					$rider->lastassignedtime = $order_rider_assign_time->order_rider_assign_time;
				
				$query="SELECT 
							`order_picking_address`, 
							`order_drop_address`
							FROM `orders`
					WHERE `order_status`='3' 
					AND `rider_id`='".$rider->rider_id."' ORDER BY `order_id` DESC LIMIT 3";
				
				$query_result = $this->db->query($query);
				$order_addresses = $query_result->result();
				$pick_address ='';
				$drop_address='';
				foreach($order_addresses as $order_address){
					$pick_address.=ucwords(strtolower($order_address->order_picking_address)).", <br /> ";
					$drop_address.=ucwords(strtolower($order_address->order_drop_address)).", <br /> ";
					}
				$rider->order_picking_address = $pick_address;
				$rider->order_drop_address = $drop_address;
				
				
				$query="SELECT COUNT(`orders`.`order_id`) as total_delivery
							FROM `orders`
					WHERE `order_status` IN (4,5) 
					AND `rider_id`='".$rider->rider_id."'
					AND DATE(`order_date_time`)=".$this->db->escape(date('Y-m-d', time()));
				
				$query_result = $this->db->query($query);
				$rider->total_delivery = $query_result->result()[0]->total_delivery;
				
				
			}
			else{
				$rider->status='-';
				$rider->total_order=false;
				$rider->last_assigned_time = false;
				$rider->order_picking_address = '-';
				$rider->order_drop_address = '-';
				$rider->total_delivery=0;
				}
			}
		echo json_encode($riders);
		exit();
		
		}	
	public function assign_rider(){
		
		//echo SYSTEM_TEST;
		
		$order_id  =  (int) $this->input->post("order_id");
		$rider_id  =  (int) $this->input->post("rider_id");
		
		if($rider_id==0){
			$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
			$this->ready_orders();
			
			}else{
		$query = "UPDATE `orders` SET `rider_id`='".$rider_id."', 
				  `order_status`='3',
				  `order_rider_assign_time`='".date("Y-m-d G:i:s", time())."',
				  `order_rider_assign_by` ='".$this->session->userdata("user_id")."' 
				  WHERE `order_id`='".$order_id."'";
		$this->db->query($query);
		$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
		//$this->ready_orders();
		
		$query="SELECT
				`customers`.`mobile_number`
				, `customers`.`customer_name`
				, `orders`.`order_detail`
				, `orders`.`order_picking_address`
				, `orders`.`order_drop_address`
				, `orders`.`delivery_charges`
				, `orders`.`orderer_name`
				, DATE_FORMAT( `orders`.`order_date_time`,\"%d %b, %y %h:%i %p\" ) AS order_date_time
				, DATE_FORMAT( `orders`.`delivery_time`,\"%d %b, %y %h:%i %p\" ) AS delivery_time
				, DATE_FORMAT( `orders`.`order_ready_time`,\"%d %b, %y %h:%i %p\" ) AS order_ready_time
				, `orders`.`is_pre_order`
				, `orders`.`order_type`
				, `riders`.`office_no`
				, `riders`.`rider_name`
				, `orders`.`mobile_or_call`
				FROM
				`orders`
				,`customers` 
				,`riders` 
				WHERE `orders`.`customer_id` = `customers`.`customer_id`
				AND `riders`.`rider_id` = `orders`.`rider_id`
				AND `orders`.`order_id`=".$order_id;
			$result = $this->db->query($query);
			$order = $result->result()[0];
			
			if($order->order_type=='General Order'){
				if($order->mobile_or_call=='Mobile'){
					$this->push_notification($order_id,3);
				}
				$message='#'.$order_id.' Pick:'.$order->order_picking_address.' Detail: '.strip_tags($order->order_detail).' Drop: '.$order->order_drop_address.' : '.ucwords($order->customer_name).' '.$order->mobile_number.' Rs: '.$order->delivery_charges;
			//	$this->send_sms($order->office_no, 'SMS Alert', $message);
				$this->sms_jazz($order->office_no, $message);
				$this->rider_push_notification($rider_id);
				
				$message='Hi '.ucwords(strtolower($order->customer_name)).', Your Order has been assigned to '.ucwords($order->rider_name).' '.$order->office_no.'. Delivery Charges for your order will be '.$order->delivery_charges.'. For Complaint please call on 03005703875';
				$this->send_sms($order->mobile_number, 'SMS Alert', $message);
				
				
				}
			if($order->order_type=='Food Order'){
				if($order->mobile_or_call=='Mobile'){
					$this->push_notification($order_id,3);
				}
				$message='#'.$order_id.' Pick:'.$order->order_picking_address.' Detail: '.strip_tags($order->order_detail).' Drop: '.$order->order_drop_address.' : '.ucwords($order->customer_name).' '.$order->mobile_number.' Rs: '.$order->delivery_charges;
			//	$this->send_sms($order->office_no, 'SMS Alert', $message);
				$this->sms_jazz($order->office_no, $message);
				$this->rider_push_notification($rider_id);
				
				$message='Hi '.ucwords(strtolower($order->customer_name)).', Your Order has been assigned to '.ucwords($order->rider_name).' '.$order->office_no.'. Delivery Charges for your order will be '.$order->delivery_charges.'. For Complaint please call on 03005703875';
				$this->send_sms($order->mobile_number, 'SMS Alert', $message);
				
				}	
		
		//end order detail to the rider
		
		
			}
			
			
			//exit();
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/ready_orders";
  		redirect($main_page); 	
			
		}	
			
				
		
	public function get_order_by_id($order_id){
		$order_id = (int) $order_id;
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
		
		$order_detail->print_time = date('d M, y G:i:s A', time());
		$order_detail->print_by = ucwords($this->session->userdata("user_title")).'('.$this->session->userdata("user_id").")";
		echo json_encode($order_detail);
		}
		
function get_mobiles_numbers(){
    //echo '[{"department":"Fast Food","caller_id":"03244424414","datetime":"2019-02-28 00:03:57"},{"department":"Fast Food","caller_id":"03429040048","datetime":"2019-02-28 00:05:40"}]';
    
   // exit();
	 $result = file_get_contents("https://businessline.mobilink.com.pk/BusinesslineAPI/?menu=get_call_details&password=SBwyBtZ2ns&masterno=3000341381");
	 if($result !='{"status":"fail","description":"No Calls in Queue"}'){ echo $result; }
     
	}	

function mobile(){
	//$this->send_sms('03005717174', 'SMS Alert', 'test message');
	}	
	
function searched_order($customer_mobile_no=NULL){
	
	if($customer_mobile_no){
	$query="SELECT
    `customers`.`mobile_number`
    , `customers`.`customer_name`
    , `customers`.`comment`
    , `riders`.`rider_name` as rider_name
	, `riders`.`office_no` as office_no
    , `orders`.`reason`
	, `orders`.`order_id`
    , `orders`.`mobile_or_call`
    , `orders`.`customer_id`
    , `orders`.`order_detail`
    , `orders`.`order_picking_address`
    , `orders`.`order_drop_address`
    , `orders`.`delivery_charges`
    , `orders`.`orderer_name`
	, `orders`.`order_date_time` as orderdatetime
	, `orders`.`delivery_time` AS deliverytime
	, `orders`.`order_place_time` as orderplacetime
	, `orders`.`order_ready_time` as orderreadytime
	, `orders`.`order_rider_assign_time` as `orderriderassigntime`
	, `orders`.`order_rider_acknowledge` as `orderrideracknowledge`
	, `orders`.`order_picking_time` as`orderpickingtime`
	, `orders`.`order_rider_delivery_time` as `orderriderdeliverytime`
    ,DATE_FORMAT( `orders`.`order_date_time`,\"%d %b, %y %h:%i %p\" ) AS order_date_time,
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
  IF(`orders`.`order_status`=2,'Ready',
  IF(`orders`.`order_status`=3,'Running',
  IF(`orders`.`order_status`=4,'Delivered',
  IF(`orders`.`order_status`=5,'Canceled',
  IF(`orders`.`order_status`=6,'Awating',
  IF(`orders`.`order_status`=7,'Scheduled','Not Define'))))))) AS `order_status_title`
	
FROM
    `customers`
    INNER JOIN `orders` 
        ON (`customers`.`customer_id` = `orders`.`customer_id`)
    LEFT JOIN `riders` 
        ON (`orders`.`rider_id` = `riders`.`rider_id`)
    LEFT JOIN `users` 
        ON (`users`.`user_id` = `orders`.`created_by`) 
WHERE `customers`.`mobile_number` ='".$customer_mobile_no."' OR 
`orders`.`order_id`= '".$customer_mobile_no."'
ORDER BY `orders`.`order_id` DESC LIMIT 10";
		$result = $this->db->query($query);
		if($result->result()){
		$orders = $result->result();
		$order_all_detail ='';
	foreach($orders as $order_detail){
	$pos = strpos(substr($order_detail->order_detail,0,6), '<br />');
if ($pos !== false) {
    $orderdetail = substr_replace($order_detail->order_detail, '', $pos, strlen('<br />'));
}else{
	$orderdetail = $order_detail->order_detail;
	}
	
	$order_all_detail.='<div id="order_id_'.$order_detail->order_id.'" style="border:1px solid #d3d3d3; padding:5px !important; margin:5px;"><strong>#'.$order_detail->order_id.'</strong> @<strong><em>'.$order_detail->order_date_time.' - '.ucwords($order_detail->customer_name).'</em></strong> @<strong>'.ucwords($order_detail->order_status_title).'</strong> Rider: @<strong ><em>'.$order_detail->rider_name.' ('.$order_detail->office_no.')</em> <br /></strong> '.ucwords(time_elapsed_string($order_detail->orderdatetime)).'. <em>Rs:'.$order_detail->delivery_charges.'</em><a href="javascript:$(\'#order_id_'.$order_detail->order_id.'\').remove();" class="pull-right" style="margin-right:5px; color:red;"><i class="fa fa-times"></i> </a>
	 <button class="btn btn-link pull-right" onclick="open_model_edit(\''.$order_detail->order_id.'\')">Edit Order</button>
	 <button class="btn btn-link pull-right" onclick="open_model_resend_sms(\''.$order_detail->order_id.'\')">Resend SMS</button>
	 <button class="btn btn-link pull-right" onclick="open_model_reassign_rider(\''.$order_detail->order_id.'\')">Reassign Rider</button>
	 ';
	 if($this->session->userdata("role_id")!='19'){
	$order_all_detail.=' <button class="btn btn-link pull-right" onclick="open_model(\''.$order_detail->order_id.'\')">View Detail</button>';
	 }
	
$order_all_detail.='<details>
  <summary>More Detail</summary>
  <table  class="table table-bordered">
  <tr><th>Order Detail</th>
  <th>Location Detail</th>
  <th>Other Detail</th>
  
  </tr>
  <tr>
	  <td width="400">'.$orderdetail.'</td>
	  <td width="200">
	  <strong>Pick Location:</strong> <i>'.$order_detail->order_picking_address.'</i><br />
	  <strong>Delivery Location:</strong> <i>'.$order_detail->order_drop_address.'</i>
	  </td>
	  <td>Delivery Time: '.$order_detail->delivery_time.' '.time_left($order_detail->deliverytime).'<br />
	  Order Placed Time: '.$order_detail->order_place_time.' '.time_left($order_detail->orderplacetime).'<br />
	  Order Ready Time: '.$order_detail->order_ready_time.' '.time_left($order_detail->orderreadytime).'<br />
	  Rider Assigned Time: '.$order_detail->order_rider_assign_time.' '.time_left($order_detail->orderriderassigntime).'<br />
	  Rider Acknowledge Time: '.$order_detail->order_rider_acknowledge.' '.time_left($order_detail->orderrideracknowledge).'<br />
	  Rider Delivery Time: '.$order_detail->orderriderdeliverytime.' '.time_left($order_detail->orderriderdeliverytime).'<br />
	  </td>
	  
  </tr></table>
</details></div>';
	}

	
echo $order_all_detail;
	}else{
		echo '<div id="order_id_0"><em>Record Not Found...</em><a href="javascript:$(\'#order_id_0\').remove();" class="pull-right" style="margin-right:5px; color:red;"><i class="fa fa-times"></i> </a>';
		}
	}else{
		echo '<div id="order_id_0"><em>Enter Mobile Number...</em><a href="javascript:$(\'#order_id_0\').remove();" class="pull-right" style="margin-right:5px; color:red;"><i class="fa fa-times"></i> </a>';
		}
 
		
}

function get_new_orders($order_last_id, $order_status){
	$order_last_id = (int) $order_last_id;
	$order_status = (int) $order_status;
	$where = "`orders`.`status` IN (0, 1) 
				   AND  `orders`.`order_status`='".$order_status."' 
				   AND  `orders`.`order_id`>'".$order_last_id."'
				   LIMIT 1";
				$data = $this->order_model->get_order_list($where,false);
	echo json_encode($data);
	exit();
		
	}
	
function set_location($location){
			$address_array[0]['id'] = $location;
			$address_array[0]['name'] = $location;
			
		echo json_encode($address_array);
	}
	
function set_location_array($location){
			$address_array[0] = $location;
			
		echo json_encode($address_array);
	}
	
function get_order_edit_form($order_id){
	$order_id = (int) $order_id;
	$query="SELECT
				`order_detail`
				, `order_picking_address`
				, `order_drop_address`
				, `delivery_charges`
			FROM `orders`
			WHERE `order_id`='".$order_id."'";
	$query_result = $this->db->query($query);
	$order_detail  = $query_result->result()[0];
	
	$pos = strpos(substr($order_detail->order_detail,0,6), '<br />');
if ($pos !== false) {
    $orderdetail = substr_replace($order_detail->order_detail, '', $pos, strlen('<br />'));
}else{
	$orderdetail = $order_detail->order_detail;
	}
	echo '<table class="table table-bordered">
	<tr>
	<td>Order Detail</td>
	</tr><tr>
	<td> 
	<input type="hidden" id="order_detail_orignal" name="order_detail_orignal" value="'.$orderdetail.'" />
	<textarea name="edit_order_detail" cols="" rows="5" id="edit_order_detail" class="form-control" style="" title="Order Detail" placeholder="Order Detail">'.str_replace("<br />", "\n", $order_detail->order_detail).'</textarea></td>
	</tr>
	<tr><td>
	Picking Address:
	<input  required="required" type="text" name="order_picking_address" id="order_picking_address" class="form-control" value="'.$order_detail->order_picking_address.'" ></td></tr>
	<tr><td>
	Delivery Address:
	<input  required="required" type="text" name="order_drop_address" id="order_drop_address" class="form-control" value="'.$order_detail->order_drop_address.'" ></td></tr>
	
   <tr><td> 
	<input type="hidden" id="delivery_charges_orignal" name="delivery_charges_orignal" value="'.$order_detail->delivery_charges.'" />
	Delivery Charges:
	<input  required="required" type="number" name="edit_delivery_charges" id="edit_delivery_charges" class="form-control" value="'.$order_detail->delivery_charges.'" ></td></tr>
	<tr><td><input type="submit" name="button" value="Update Order" class="btn btn-primary pull-right" style=" margin:5px;" onclick="update_order('.$order_id.')"></td></tr>
         <table>
		  
		  ';
			
	}
	
	
public function edit_order_detail(){
	
		$order_id= 			(int)   $this->input->post('order_id');
		$edit_delivery_charges=     $this->input->post('edit_delivery_charges');
		$delivery_charges_orignal=  $this->input->post('delivery_charges_orignal');
		$edit_order_detail= 		$this->input->post('edit_order_detail');
		$delivery_charges_orignal=  $this->input->post('delivery_charges_orignal');
		$order_picking_address=  $this->input->post('order_picking_address');
		$order_drop_address=  $this->input->post('order_drop_address');
		
		$query="UPDATE `orders` 
				SET `order_detail`=".$this->db->escape($edit_order_detail).", 
				`delivery_charges`=".$this->db->escape($edit_delivery_charges).",
				`order_picking_address`=".$this->db->escape($order_picking_address).",
				 `order_drop_address`=".$this->db->escape($order_drop_address)."
				WHERE `order_id`='".$order_id."'";
		if($this->db->query($query)){
			$query="INSERT INTO `order_edits`(`order_id`, `delivery_charges`, `order_detail`, `date`) 
		        VALUES ('".$order_id."','".$delivery_charges_orignal."','".$delivery_charges_orignal."','".date("Y-m-d G:i:s", time())."')";
				if($this->db->query($query)){
					echo '<div style="text-align:center !important"><h1>Order updated successfully.</h1></div>';
					}
			}	
		
		
		
		
	
	}	
	
public function get_resend_sms_form($order_id){
	$order_id = (int) $order_id;
	$query="SELECT `riders`.`office_no`, 
				   `riders`.`rider_name`,
				   `riders`.`personal_no`
				FROM
				`orders`
				,`customers` 
				,`riders` 
				WHERE `orders`.`customer_id` = `customers`.`customer_id`
				AND `riders`.`rider_id` = `orders`.`rider_id`
				AND `orders`.`order_id`='".$order_id."'";
			$result = $this->db->query($query);
			if($result->result()){
			$order_rider_info = $result->result()[0];
			//var_dump($order_rider_info);
			echo '<div class="row">
			<div class="col-md-12">
			<h4>Mr. '.ucwords($order_rider_info->rider_name).'</h4>
			</div>
			<div class="col-md-8">
			<select id="rider_mobile_number" class="form-control" name="rider_mobile_number">
			<option value="'.$order_rider_info->office_no.'">Office No: '.$order_rider_info->office_no.'</option>
			<option value="'.$order_rider_info->personal_no.'">Personal No: '.$order_rider_info->personal_no.'</option>
			</select></div>
			<div class="col-md-4">
			<input type="button" value="Resend" class="btn btn-primary" onclick="resend_sms(\''.$order_id.'\')" />
			</div>
			';
			}else{
				echo "<h4>Rider Not Assigned Yet...</h5>";
				}
			
	
	}
	
public function get_rider_reassign_form($order_id){
	$order_id = (int) $order_id;
	$hour = date("H", time());
		$query="SELECT `rider_id`, `rider_name`,`ability_level`, `office_no` FROM `riders` 
		WHERE (`duty_start`<='".$hour."' AND `duty_end`>='".$hour."'
		AND `is_absent`=0) OR `is_available`=1 ORDER BY `rider_name` ASC";
		$result = $this->db->query($query);
		$riders = $result->result();
		
	$query="SELECT `riders`.`office_no`, 
				   `riders`.`rider_name`,
				   `riders`.`personal_no`
				FROM
				`orders`
				,`customers` 
				,`riders` 
				WHERE `orders`.`customer_id` = `customers`.`customer_id`
				AND `riders`.`rider_id` = `orders`.`rider_id`
				AND `orders`.`order_id`='".$order_id."'";
			$result = $this->db->query($query);
			if($result->result()){
			$order_rider_info = $result->result()[0];
			//var_dump($order_rider_info);
			echo '<div class="row">
			<div class="col-md-12">
			<h5><em>Already assigned to Mr. '.ucwords($order_rider_info->rider_name).'</em></h5>
				<h4>Select other rider</h4>			</div>
				<form name="assign_rider" action="'.site_url(ADMIN_DIR."orders/assign_rider/").'" method="post">
			<div class="col-md-8">
			 <input required name="order_id" type="hidden" class="order_id" value="'.$order_id.'" />
			<select required class="form-control" name="rider_id" id="rider_id">';
			echo '<option value="">Select Rider</option>';
			foreach($riders as $rider){
			echo '<option value="'.$rider->rider_id.'">'.$rider->rider_name.' ('.$rider->office_no.')</option>';
			}
			echo '</select></div>
			<div class="col-md-4">
			<input type="submit" value="Reassign" class="btn btn-primary" onclick="reassign_rider(\''.$order_id.'\')" />
			</div>
			</form>
			';
			}else{
				echo "<h4>Rider Not Assigned Yet...</h5>";
				}
			
	
	}			
	
public function resend_sms($order_id){
	$order_id = (int) $order_id;
	$mobile_number = $this->input->post('rider_mobile_number');
	
	$query="SELECT
				`customers`.`mobile_number`
				, `customers`.`customer_name`
				, `orders`.`order_detail`
				, `orders`.`order_picking_address`
				, `orders`.`order_drop_address`
				, `orders`.`delivery_charges`
				, `orders`.`orderer_name`
				, DATE_FORMAT( `orders`.`order_date_time`,\"%d %b, %y %h:%i %p\" ) AS order_date_time
				, DATE_FORMAT( `orders`.`delivery_time`,\"%d %b, %y %h:%i %p\" ) AS delivery_time
				, DATE_FORMAT( `orders`.`order_ready_time`,\"%d %b, %y %h:%i %p\" ) AS order_ready_time
				, `orders`.`is_pre_order`
				, `orders`.`order_type`
				, `riders`.`office_no`
				, `riders`.`rider_name`
				, `orders`.`mobile_or_call`
				FROM
				`orders`
				,`customers` 
				,`riders` 
				WHERE `orders`.`customer_id` = `customers`.`customer_id`
				AND `riders`.`rider_id` = `orders`.`rider_id`
				AND `orders`.`order_id`=".$order_id;
			$result = $this->db->query($query);
			$order = $result->result()[0];
			
			if($order->order_type=='General Order'){
				if($order->mobile_or_call=='Mobile'){
					$this->push_notification($order_id,3);
				}else{
				$message='#'.$order_id.' Pick:'.$order->order_picking_address.' Detail: '.strip_tags($order->order_detail).' Drop: '.$order->order_drop_address.' : '.ucwords($order->customer_name).' '.$order->mobile_number.' Rs: '.$order->delivery_charges;
				if($this->send_sms($mobile_number , 'SMS Alert', $message)){
					echo "<h4>Message Sent Successfully.</h4>";
					}
				/*
				$message='Dear '.ucwords($order->customer_name).', Your Order has been assigned to '.ucwords($order->rider_name).' '.$order->office_no;
				$this->send_sms($order->mobile_number, 'SMS Alert', $message);*/
				}
				
				
				
				}
			if($order->order_type=='Food Order'){
				if($order->mobile_or_call=='Mobile'){
					$this->push_notification($order_id,3);
				}else{
				$message='#'.$order_id.' Pick:'.$order->order_picking_address.' Detail: '.strip_tags($order->order_detail).' Drop: '.$order->order_drop_address.' : '.ucwords($order->customer_name).' '.$order->mobile_number.' Rs: '.$order->delivery_charges;
				if($this->send_sms($mobile_number , 'SMS Alert', $message)){
					echo "<h4>Message Sent Successfully.</h4>";
					}
				/*
				$message='Dear '.ucwords($order->customer_name).', Your Order has been assigned to '.ucwords($order->rider_name).' '.$order->office_no;
				$this->send_sms($order->mobile_number, 'SMS Alert', $message);*/
				}
				}	
		
		
		//end order detail to the rider
	
	
	} 	
	
	public function tag_order($order_id){
		$order_id = (int) $order_id;
		$order_tag = $this->input->post('order_tag');
		$query="UPDATE `orders` 
				SET `supervisor_tag`= ".$this->db->escape($order_tag)."
		        WHERE `order_id`= ".$this->db->escape($order_id);
		if($this->db->query($query)){
			$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/ready_orders";
  			redirect($main_page);
			}		
		
		}	
		
	public function customer_location_detail($locatoin_id){
		$locatoin_id = (int) $locatoin_id;
		$query="SELECT * FROM `customer_locations` 
				WHERE  `customer_locations`.`customer_location_id`=".$locatoin_id;
			$result = $this->db->query($query);
			$location_detail = $result->result()[0];
	echo json_encode($location_detail);
	exit();
		}	
    
}        

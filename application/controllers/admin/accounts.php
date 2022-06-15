<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Accounts extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
       // $this->load->model("admin/album_image_model");
	   
	    $this->load->model("admin/order_model");
		$this->lang->load("orders", 'english');
	    $this->load->model("admin/rider_model");
		$this->lang->load("riders", 'english');
	   
		$this->lang->load("album_images", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/account_modules";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function account_modules(){
		
       
		 $this->data["title"] = "Accounts";
		$this->data["view"] = ADMIN_DIR."accounts/account_modules";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
	
	
	
	
	
	public function riders_rides(){
		$time = '06:00:00';
		if($this->input->post("date")){
			$this->data['date'] = $date = $this->input->post("date")." ".$time;
			$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
		}else{
			
			$this->data['date'] = $date = date("Y-m-d",time())." ".$time;
			$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
		
		}
		
		
		//$this->data['date'] = $date = '2018-6-25';
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders,
				   SUM(`orders`.`delivery_charges`) AS total_orders_charges
				FROM
				  `orders` 
				WHERE `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_orders"]	 =  $result[0]->total_orders;
		$this->data["total_orders_charges"]	 =  $result[0]->total_orders_charges;
		
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders` 
				WHERE `orders`.`order_status` = '1'
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_unplaced_orders"]	 =  $result[0]->total_orders;
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders` 
				WHERE `orders`.`order_status` = '2'
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_ready_orders"]	 =  $result[0]->total_orders;
		
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders` 
				WHERE `orders`.`order_status` = '3'
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_running_orders"]	 =  $result[0]->total_orders;
		
		
		
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders,
				   SUM(`orders`.`delivery_charges`) AS total_delivery_charges
				FROM
				  `orders` 
				WHERE `orders`.`order_status` = '4'
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_delivered_orders"]	 =  $result[0]->total_orders;
		$this->data["total_delivery_charges"]	 =  $result[0]->total_delivery_charges;
		
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_cancel_orders
				FROM
				  `orders`
				WHERE  `orders`.`order_status` = '5'
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		$this->data["total_cancel_orders"]	 =  $result[0]->total_cancel_orders;
		
		
	
		 
		  
		  
		  
		
		$query="SELECT 
				`riders`.`rider_id`,
			  `riders`.`rider_name`,
			  `riders`.`office_no`,
			  `riders`.`personal_no`,
			  `riders`.`is_available`,
			  COUNT(orders.`order_id`) AS total_orders
			FROM
			  `orders`,
			  `riders` 
			WHERE `orders`.`rider_id` = `riders`.`rider_id`
			AND `orders`.`order_status` = '4'
			AND `orders`.`created_date` > ".$this->db->escape($date)."
				AND `orders`.`created_date` <= ".$this->db->escape($next_date)."
			GROUP BY `riders`.`rider_id`
			ORDER BY total_orders DESC ";
		$query_result = $this->db->query($query);
		$riders_rides = $query_result->result();
		
		foreach($riders_rides as $riders_ride){
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$riders_ride->rider_timings = $query_result->result();
			
			//get rider duty start time ...
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
			AND `timing_type` = 'DST'
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$riders_ride->duty_start_time = $duty_start_time = $query_result->result();
			
			//get rider duty end time ...
			
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
			AND `timing_type` = 'DET'
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$riders_ride->duty_end_time = $duty_end_time = $query_result->result();
			/*var_dump($duty_start_time);
			var_dump($duty_end_time);*/
			
			// rider total hours....
			$riders_ride->duty_hours = $this->get_hours($duty_end_time[0]->timing, $duty_start_time[0]->timing);

			
			
			
			// get rider in and out timing ...
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
			AND `timing_type` != 'DET' 
			AND  `timing_type` != 'DST' 
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$riders_ride->rider_timings = $query_result->result();
			if($riders_ride->rider_timings){
				$timing = array();
				foreach($riders_ride->rider_timings as $rider_timing){
					$timing[strtotime($rider_timing->timing)] = $rider_timing->timing;
					}
					 ksort($timing);
				$riders_ride->on_duty_hours = $this->get_hours(reset($timing), end($timing));
				}
			
			
			$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '4'
				AND `orders`.`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
		$riders_ride->rider_total_delivered_orders =  $result[0]->total_orders;
		}
		
		$query="SELECT 
				  SUM(`orders`.`delivery_charges`) AS tota_delivery_charges
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '4'
				AND `orders`.`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		 $result = $query_result->result();	
		 if($result){
		 $riders_ride->rider_total_delivery_charge =  $result[0]->tota_delivery_charges;
		 }
		  
		  $query="SELECT 
				  COUNT(orders.`order_id`) AS total_cancel_orders
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '5'
				AND `orders`.`rider_id` = ".$this->db->escape($riders_ride->rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
		$riders_ride->rider_total_cancel_orders =  $result[0]->total_cancel_orders;
		}
			
			
			
			
			
			
			}
		
		$this->data["riders_rides"] = $riders_rides;
		$this->data["title"] = "Rider's Rides";
		$this->data["view"] = ADMIN_DIR."accounts/riders_rides";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		
		
		}
		
		
	
		
function get_rider_orders(){
	//var_dump($_REQUEST);
		$rider_id = $this->input->post("rider_id");
		$get_orders = $this->input->post("get_orders");
		$this->data['date'] = $date = $this->input->post("date");
			$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
		
		$where = "`orders`.`status` IN (0, 1)
				 AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
				 
		
		//$where = "DATE(orders.`created_date`) = ".$this->db->escape($date)." ";
				 		 
				 
				 
		if($rider_id!=0){
			$where.=" AND `orders`.`rider_id`= ".$this->db->escape($rider_id)." ";
			
			
			$query="SELECT * FROM `riders` WHERE `riders`.`rider_id`=".$this->db->escape($rider_id);
		$result = $this->db->query($query);
		$rider = $result->result();
		
		$this->data['rider_name'] = $rider[0]->rider_name;
			
			}	else{
				$this->data['rider_name'] = NULL;
				}	 
		
			
		if($get_orders=='unplaced'){
			$where.= " AND `orders`.`order_status` = '1' ";
			}	
			
		if($get_orders=='ready'){
			$where.= " AND `orders`.`order_status` = '2' ";
			}
			
		if($get_orders=='running'){
			$where.= " AND `orders`.`order_status` = '3' ";
			}	
				
		if($get_orders=='cancelled'){
			$where.= " AND `orders`.`order_status` = '5' ";
			}	
			
		if($get_orders=='delivered'){
			$where.= " AND `orders`.`order_status` = '4' ";
			}
			
		$where.= " ORDER BY `orders`.`order_id` DESC ";			
		
		$this->data["orders"] = $this->order_model->get_order_list($where, false);
		
		
		$this->load->view(ADMIN_DIR."accounts/rider_orders_list", $this->data);
	
	}	
	

	function riders(){
		$this->lang->load("riders", 'english');
		$query="SELECT * FROM `riders` WHERE `riders`.`status`=1";
		$result = $this->db->query($query);
		$this->data['riders'] = $result->result();
		
		 $this->data["title"] = "All Riders";
		$this->data["view"] = ADMIN_DIR."accounts/riders_list";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		
		}	
	
	function rider_riders($rider_id){
		
		
		
	
	$this->data['rider_id'] = $rider_id = (int) $rider_id;
	$this->data["riders"] = $this->rider_model->get_rider($rider_id);
	
	if($this->input->post("start_date")){
		$start_date = $this->input->post("start_date");; 	
		}else{ 
		$start_date = date("Y-m",time())."-1";
		}
		
		if($this->input->post("end_date")){
		$end_date = $this->input->post("end_date");; 	
		}else{ 
		$end_date = date("Y-m",time())."-".cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($start_date)),date("y",strtotime($start_date)));
		}
		
		
		
		/*$start_date = "2018-2-1";
		$end_date = "2018-2-".cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($start_date)),date("y",strtotime($start_date)));
		*/
		$this->data['start_date'] = $start_date;
		$this->data['end_date']  = $end_date;
	
		$start_year = date("Y", strtotime($start_date));
		$end_year = date("Y", strtotime($end_date));
	
	
		$start_month = date("n", strtotime($start_date));
		$end_month = date("n", strtotime($end_date));
		
		
		$start_day = date("j", strtotime($start_date));
		$end_day = date("j", strtotime($end_date));
		
		$rider_rides = array();
		for($year = $start_year; $year <= $end_year; $year++){
			
				for($month = $start_month; $month <= $end_month; $month++){
					for($day = $start_day; $day <= $end_day; $day++){
						
						$date = date("Y-m-d h:i:s", strtotime($year."-".$month."-".$day." 06:00:00"));
						$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
						
			$rider_rides[$year][$month][$day]['date'] = $date;
		
		$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '4'
				AND `orders`.`rider_id` = ".$this->db->escape($rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
		$rider_rides[$year][$month][$day]['total_orders'] =  $result[0]->total_orders;
		}
						
						
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($rider_id)."
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$rider_rides[$year][$month][$day]['rider_timings'] = $query_result->result();
			
			
			//get rider duty start time ...
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($rider_id)."
			AND `timing_type` = 'DST'
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$rider_rides[$year][$month][$day]['duty_start_time'] = $duty_start_time = $query_result->result();
			
			//get rider duty end time ...
			
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($rider_id)."
			AND `timing_type` = 'DET'
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$rider_rides[$year][$month][$day]['duty_end_time'] = $duty_end_time = $query_result->result();
			/*var_dump($duty_start_time);
			var_dump($duty_end_time);*/
			
			// rider total hours....
			@$rider_rides[$year][$month][$day]['duty_hours'] = $this->get_hours($duty_end_time[0]->timing, $duty_start_time[0]->timing);

			
			
			
			// get rider in and out timing ...
			
			$query="SELECT
			`timing`
			, `timing_type`
			, `created_date`
			FROM
			`riders_timing`
			WHERE 
			`rider_id` = ".$this->db->escape($rider_id)."
			AND `timing_type` != 'DET' 
			AND  `timing_type` != 'DST' 
			AND `created_date` > ".$this->db->escape($date)."
				AND `created_date` <= ".$this->db->escape($next_date);
			$query_result = $this->db->query($query);
			$rider_rides[$year][$month][$day]['rider_timings'] = $rider_timings = $query_result->result();
			if($rider_timings){
				$timing = array();
				foreach($rider_timings as $rider_timing){
					$timing[strtotime($rider_timing->timing)] = $rider_timing->timing;
					}
					 ksort($timing);
				$rider_rides[$year][$month][$day]['on_duty_hours'] = $this->get_hours(reset($timing), end($timing));
				}
			
			
			$query="SELECT 
				  COUNT(orders.`order_id`) AS total_orders
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '4'
				AND `orders`.`rider_id` = ".$this->db->escape($rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
		$rider_rides[$year][$month][$day]['rider_total_delivered_orders'] =  $result[0]->total_orders;
		}
		
		$query="SELECT 
				  SUM(`orders`.`delivery_charges`) AS tota_delivery_charges
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '4'
				AND `orders`.`rider_id` = ".$this->db->escape($rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		 $result = $query_result->result();	
		 if($result){
		 $rider_rides[$year][$month][$day]['rider_total_delivery_charge'] =  $result[0]->tota_delivery_charges;
		 }
		  
		  $query="SELECT 
				  COUNT(orders.`order_id`) AS total_cancel_orders
				FROM
				  `orders`,
				  `riders` 
				WHERE `orders`.`rider_id` = `riders`.`rider_id`
				AND `orders`.`order_status` = '5'
				AND `orders`.`rider_id` = ".$this->db->escape($rider_id)."
				AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)."
				AND  ".$this->db->escape($next_date);
		$query_result = $this->db->query($query);
		$result = $query_result->result();
		if($result){
		$rider_rides[$year][$month][$day]['rider_total_cancel_orders'] =  $result[0]->total_cancel_orders;
		}
			
			
			
			
			
			
			
						
						
						
						
						
						}
				}
			}
		
	
			
		
		$this->data["rider_rides"] = $rider_rides;
		$this->data["title"] = "Rider's Rides";
		$this->data["view"] = ADMIN_DIR."accounts/rider_rides";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		
		
		
	
	
		
		}
	
private function get_hours($date_1, $date_2){
	
	@$date1 = new DateTime($date_1);
	@$date2 = new DateTime($date_2);
	$diff = $date2->diff($date1);
    return $diff->h.".".$diff->i;
	
	
	}  	
	
public function staff_report(){
	
	
	$time = '06:00:00';
		if($this->input->post("date")){
			$this->data['date'] = $date = $this->input->post("date")." ".$time;
			$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
		}else{
			
			$this->data['date'] = $date = date("Y-m-d",time())." ".$time;
			$next_date = date("Y-m-d h:i:s", strtotime('+1 day', strtotime($date)));
		
		}
	
	$query = "SELECT `role_id`, `role_title` FROM `roles` WHERE `roles`.`role_id` IN(25,22,21,20,19)";
	$query_result = $this->db->query($query);
	$roles = $query_result->result();
	 foreach($roles as $role){
		 
		 $query = "SELECT `user_id`, `user_title` FROM `users` WHERE `users`.`role_id`=".$role->role_id;
		 $query_result = $this->db->query($query);
		 $users = $query_result->result();
		 $role->users= $users;
		 	foreach($role->users as $user){
				//get register orders.......
				 $query = "SELECT COUNT(*) as total_orders FROM `orders` WHERE `orders`.`created_by`='".$user->user_id."' AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)." AND  ".$this->db->escape($next_date);
		 		 $query_result = $this->db->query($query);
		 		 $user->register_orders = $query_result->result()[0]->total_orders;
				 //order placed by 
				 echo $query = "SELECT COUNT(*) as total_orders FROM `orders` WHERE `orders`.`order_placed_by`='".$user->user_id."' AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)." AND  ".$this->db->escape($next_date);
				 
		 		 $query_result = $this->db->query($query);
		 		 $user->placed_orders = $query_result->result()[0]->total_orders;
				 // canceled by 
				 $query = "SELECT COUNT(*) as total_orders FROM `orders` WHERE `orders`.`cancelled_by`='".$user->user_id."' AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)." AND  ".$this->db->escape($next_date);
		 		 $query_result = $this->db->query($query);
		 		 $user->cancelled_orders = $query_result->result()[0]->total_orders;
				 
				 //order edit
				 $query = "SELECT  COUNT(*) as total_edit FROM `order_edits` WHERE `order_edited_by`='".$user->user_id."' AND `order_edits`.`date`  BETWEEN   ".$this->db->escape($date)." AND  ".$this->db->escape($next_date);
		 		 $query_result = $this->db->query($query);
		 		 $user->edited_orders = $query_result->result()[0]->total_edit;
				 
				 //get orders assigned rider...
				 $query = "SELECT  COUNT(*) as assigned_orders FROM `orders` WHERE `order_rider_assign_by`='".$user->user_id."' AND `orders`.`created_date`  BETWEEN   ".$this->db->escape($date)." AND  ".$this->db->escape($next_date);
		 		 $query_result = $this->db->query($query);
		 		 $user->assigned_orders = $query_result->result()[0]->assigned_orders;
				 
				}
		 }
	
	
	
	
		$this->data["staff_report"] = $roles;
		$this->data["title"] = "Staff Report ". date("d F, Y", strtotime($start_date));
		$this->data["view"] = ADMIN_DIR."accounts/staff_report";
		$this->load->view(ADMIN_DIR."layout", $this->data);
	
	
	}				
   
    
	

	
	
	
}      




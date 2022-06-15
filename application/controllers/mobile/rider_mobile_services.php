<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class rider_mobile_services extends Admin_Controller_Mobile{ 
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/restaurants_model");
		$this->load->model("admin/restaurant_food_menu_model");
		$this->load->model("admin/order_model");
		$this->lang->load("restaurants", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
	
	public function change_rider_name(){
		$response = array();
		$rider_id = (int) $this->input->post('rider_id');
		$rider_name = $this->input->post('rider_name');
		$query = "UPDATE `riders` 
				  SET `rider_name`=".$this->db->escape($rider_name)." 
				  WHERE `rider_id`=".$this->db->escape($rider_id).";";
		if( $this->db->query($query)){
			$response["message"] = 'You name update successfully';
			$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}
		
		
	public function change_rider_email(){
		$response = array();
		$rider_id = (int) $this->input->post('rider_id');
		$rider_email = $this->input->post('rider_email');
		$query = "UPDATE `riders` 
				  SET `rider_email`=".$this->db->escape($rider_email)." 
				  WHERE `rider_id`=".$this->db->escape($rider_id).";";
		if( $this->db->query($query)){
			$response["message"] = 'You email addresss update successfully';
			$response["success"] = true;
			}else{
				$response["message"] = 'Some thing wrong try again.';
				$response["success"] = false;	
				}
		echo json_encode($response);
		}	
	
	
	public function change_rider_password(){
		$response = array();
		$rider_id = (int) $this->input->post('rider_id');
		$rider_password = $this->input->post('rider_password');
		$new_password = $this->input->post('new_password');
		
		$query="SELECT `rider_password` 
				FROM `riders` 
				WHERE `rider_id`=".$this->db->escape($rider_id).";";
		$query_result = $this->db->query($query);
		$rider_old_assword = $query_result->result()[0]->rider_password;
		if($rider_password==$rider_old_assword){
			$query = "UPDATE `riders` SET `rider_password`=".$this->db->escape($new_password)." 
					  WHERE `rider_id`=".$this->db->escape($rider_id).";";
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
	
	public function rider_login(){
		$office_no = (string) $this->input->post('office_no');
		$rider_password = (string) $this->input->post('rider_password');
		$response = array();
		$query="SELECT
					`rider_id`
					, `rider_name`
					, `rider_email`
					, `office_no`
				FROM
				`riders`
				WHERE `office_no` = ".$this->db->escape($office_no)."
				AND `rider_password` = ".$this->db->escape($rider_password).";";
		$query_result = $this->db->query($query);
		$rider = $query_result->result();
		if($rider){
			
			$response['success'] = true;
			$response['rider_id'] = $rider[0]->rider_id;
			$response['rider_name'] = $rider[0]->rider_name;
			$response['rider_email'] = $rider[0]->rider_email;
			$response['office_no'] = $rider[0]->office_no;
			$response['message'] = 'Welcome '.$rider[0]->rider_name;
		}else{
			$response['success'] = false;
			$response['message'] = 'Whoops!! Incorrect password';
			}
			echo json_encode($response);
		}
	
	
	public function check_rider(){
		$office_no = (string) $this->input->post('office_no');
		$pin_code  =  (string) $this->input->post('pin_code');
		$response = array();	
		$query="SELECT
					`rider_id`, 
					`rider_name`, 
					`rider_image`, 
					`office_no`, 
					`personal_no`, 
					`rider_password`, 
					`rider_email`, 
					`duty_start`, 
					`duty_end`, 
					`is_next_day`, 
					`is_available`, 
					`is_absent`, 
					`ability_level`, 
					`comments`, 
					`mobile_token`,
				FROM
				`riders`
				WHERE `office_no`=".$this->db->escape($office_no).";";
		$query_result = $this->db->query($query);
		$rider = $query_result->result()[0];
		if($rider){
			
			$response["exist"] = true;
			$response["rider_info"]=$rider;
		}
		else{
		   
			$result_SMS = $this->send_sms($rider_name, 'SMS Alert', $pin_code.' is your Darewro code.');	
			$response["code_send"] = $result_SMS;
			$response["exist"] = false;
		}
	
		echo json_encode($response);
	}
	
	public function check_rider_email(){
        $office_no = (string) $this->input->post('office_no');
		$pin_code  =  (string) $this->input->post('pin_code');
		$rider_email = (string) $this->input->post('rider_email'); 
		
		$response = array();
		$query="SELECT `rider_email`
				FROM
				`riders`
				WHERE `office_no` = ".$this->db->escape($office_no)."'
				AND `rider_email` = ".$this->db->escape($rider_email)."';";
		$query_result = $this->db->query($query);
		$rider = $query_result->result();
	
		if($rider){
			$response['exist'] = true;
			$result_SMS = $this->send_sms($rider_name, 'SMS Alert', $pin_code.' is your Darewro password. For security reasons, please change your password once you login. Thanks.');
			$query = "UPDATE `riders` SET `rider_password`='".$pin_code."' 
					 WHERE `office_no` = ".$this->db->escape($office_no)."'
					 AND `rider_email` = ".$this->db->escape($rider_email)."';";
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
	
	/*public function rider_registration(){
		$response = array();
		$rider_mobile_number = $this->input->post('rider_mobile_number');
		$rider_name = $this->input->post('rider_name');
		$rider_email = $this->input->post('rider_email');
		$password = $this->input->post('password');
		$mobile_token = $this->input->post('mobile_token');
		$query="INSERT INTO `riders`(`role_id`, 
									`rider_name`, 
									`rider_email`, 
									`rider_mobile_number`, 
									`rider_name`, 
									`rider_password`, 
									`mobile_token`
									) VALUES ('2', 
									'".$rider_name."',
									'".$rider_email."',
									'".$rider_mobile_number."',
									'".$rider_mobile_number."',
									'".$password."',
									'".$mobile_token."'
									)";
		if ($this->db->query($query)) {
			$rider_id = $this->db->insert_id();
			$response["success"] = true;
			$response["rider_id"] = $rider_id;
			$response["message"] = "Welcome to Darewro Services";

		} else {
			$response["success"] = false;
			$response["message"] = "Some thing wrong try again.";
		}
		// echoing JSON response
		echo json_encode($response);
	}*/
	public function rider_token_update(){
		$response = array();
		$rider_id = (int) $this->input->post('rider_id');
		$mobile_token = $this->input->post('mobile_token');
		// check rider mobile token is same or not if not same the update mobile token....
		$query="SELECT mobile_token as total
					FROM riders 
				WHERE `rider_id` = ".$this->db->escape($rider_id)."";
		$query_result = $this->db->query($query);
		
		if($query_result->num_rows()>0){
		if($query_result->result()[0]->mobile_token!=$mobile_token){
			$query = "UPDATE `riders` 
					  SET `mobile_token` = ".$this->db->escape($mobile_token)."
					  WHERE `rider_id` = ".$this->db->escape($rider_id).";";
			$result = $this->db->query($query);
			if($result){
				$response["success"] = true;
				$response["message"] = "Your Token Key updated";
			}else{
				$response["success"] = false;
				$response["message"] = "Token Key Not updated";
			}
		}else{
			$response["success"] = true;
			$response["message"] = "No need to Update token same!";
			}
		}else{
			$response["success"] = false;
			$response["message"] = "Rider Not Found";
			}
		
		// echoing JSON response
		echo json_encode($response);
	}
	
	public function send_pin_code(){
		$office_no  =  $this->input->post("office_no");
		$pin_code  =  $this->input->post("pin_code");
		$this->send_sms($rider_mobile_number, 'SMS Alert', $pin_code.' is your Darewro code.');	
	}
	
	public function get_rider_orders(){
		$rider_id = (int)  $this->input->post('rider_id');
		//$rider_id = 70;
		// we need to get those order which assigne to rider either the 
		//2 means preparing => after picked we need to change the status into  3 which means to dilever..
		$query="SELECT
					`customers`.`mobile_number`
					, `customers`.`customer_name`
					, `orders`.*
				FROM
				`customers`,
				`orders`
				WHERE `customers`.`customer_id` = `orders`.`customer_id`
				AND `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_status` IN(2,3) ORDER BY `orders`.`order_id` DESC
				";
		$query_result = $this->db->query($query);
		$rider_orders = $query_result->result();
		if($rider_orders){
			$response['rider_orders'] = $rider_orders;
			$response['success'] = true;
			$response['message'] = 'Order Found.';
		}else{
			$response['success'] = false;
			$response['message'] = 'No New Orders.';
			}
			
		//Note: the order is consider to be new if the order order_rider_acknowledge is NULL	
			echo json_encode($response);
		
		}
	
	public function get_rider_delivered_orders_today(){
		
		$rider_id = (int)  $this->input->post('rider_id');
		$query="SELECT
					`customers`.`mobile_number`
					, `customers`.`customer_name`
					, `orders`.*
				FROM
				`customers`,
				`orders`
				WHERE `customers`.`customer_id` = `orders`.`customer_id`
				AND `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_status` =4 ORDER BY `orders`.`order_id` DESC
				";
		$query_result = $this->db->query($query);
		$rider_orders = $query_result->result();
		if($rider_orders){
			$response['rider_orders'] = $rider_orders;
			$response['success'] = true;
			$response['message'] = 'Order Found.';
		}else{
			$response['success'] = false;
			$response['message'] = 'Order Not Found.';
			}
			echo json_encode($response);
		
		
		}	
		
	
	public function get_rider_cancelled_orders_today(){
		
		$rider_id = (int)  $this->input->post('rider_id');
		$query="SELECT
					`customers`.`mobile_number`
					, `customers`.`customer_name`
					, `orders`.*
				FROM
				`customers`,
				`orders`
				WHERE `customers`.`customer_id` = `orders`.`customer_id`
				AND `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_status` =5 ORDER BY `orders`.`order_id` DESC
				";
		$query_result = $this->db->query($query);
		$rider_orders = $query_result->result();
		if($rider_orders){
			$response['rider_orders'] = $rider_orders;
			$response['success'] = true;
			$response['message'] = 'Order Found.';
		}else{
			$response['success'] = false;
			$response['message'] = 'Order Not Found.';
			}
			echo json_encode($response);
		
		
		}	
		

		
	public function rider_acknowledge(){
		
		$order_id = (int) $this->input->post('order_id');
		$rider_id  = (int) $this->input->post('rider_id');
		$query="UPDATE `orders` SET `orders`.`order_rider_acknowledge` = '".date("Y-m-d G:i:s", time())."'
				WHERE `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_id` =".$this->db->escape($order_id);
		if($this->db->query($query)){
			
			$response['success'] = true;
			$response['message'] = 'Order Acknoledged';
		}else{
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		
		}	
	public function rider_order_pick(){
		
		$order_id = (int) $this->input->post('order_id');
		$rider_id  = (int) $this->input->post('rider_id');
		$query="UPDATE `orders` SET `orders`.`order_rider_picking_time` = '".date("Y-m-d G:i:s", time())."'
				WHERE `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_id` =".$this->db->escape($order_id);
		if($this->db->query($query)){
			
			$response['success'] = true;
			$response['message'] = 'Order Picked';
		}else{
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		
		}		
		
	public function rider_order_deliver(){
		
		$order_id = (int) $this->input->post('order_id');
		$rider_id  = (int) $this->input->post('rider_id');
		$query="UPDATE `orders` SET `orders`.`order_rider_delivery_time` = '".date("Y-m-d G:i:s", time())."',
		`orders`.`order_status` = '4'
				WHERE `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_id` =".$this->db->escape($order_id);
		if($this->db->query($query)){
			
			$response['success'] = true;
			$response['message'] = 'Order Delivered';
		}else{
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		
		}
		
	public function order_reject(){
		$order_id = (int) $this->input->post('order_id');
		$rider_id  = (int) $this->input->post('rider_id');
		$query="UPDATE `orders` SET 
		`orders`.`order_status` = '2',
		`orders`.`rider_id`= NULL
		WHERE `orders`.`rider_id`=".$this->db->escape($rider_id)."
		AND `orders`.`order_id` =".$this->db->escape($order_id);
		if($this->db->query($query)){
			
			$response['success'] = true;
			$response['message'] = 'Order Reject Successfully';
		}else{
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		
		}
	
	public function get_rider_today_orders(){
		$rider_id = (int) $this->input->post('rider_id');
	
	$query="SELECT
    `customers`.`mobile_number`
    , `customers`.`customer_name`
    
    , `orders`.`order_id`
    , `orders`.`reason`
    , `orders`.`mobile_or_call`
    , `orders`.`customer_id`
    , `orders`.`order_detail`
    , `orders`.`order_picking_address`
    , `orders`.`order_drop_address`
    , `orders`.`delivery_charges`
    , `orders`.`order_date_time`
    , `orders`.`orderer_name`
  
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
    `customers`,
	`orders` 
WHERE `customers`.`customer_id` = `orders`.`customer_id`
AND DATE(`orders`.`created_date`) = '".date('Y-m-d',time())."'
AND `orders`.`rider_id`=".$this->db->escape($rider_id);
$query_result = $this->db->query($query);
		$rider_today_orders = $query_result->result();
		if($rider_today_orders){
			$response['rider_today_orders'] = $rider_today_orders;
			$response['success'] = true;
			$response['message'] = 'Rider Today Orders.';
		}else{
			$response['false'] = $rider_today_orders;
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		}
		
	
public function get_rider_all_orders(){
	$rider_id = (int) $this->input->post('rider_id');
	//$rider_id = 1;
	//You need to send the "off_set" variable and the value are on scroll 1,2,3,4,5........ 
	//default its 0
	if(isset($_POST['off_set'])){ $off_set = (int) $this->input->post('off_set'); }else{ $off_set = 0;	 }
	$limit = 10;
	$off_set = (int) $off_set*$limit;
	
		
	$query="SELECT
	`orders`.`order_id`
    , `customers`.`mobile_number`
    , `customers`.`customer_name`
    , `orders`.`order_id`
    , `orders`.`reason`
    , `orders`.`mobile_or_call`
    , `orders`.`customer_id`
    , `orders`.`order_detail`
    , `orders`.`order_picking_address`
    , `orders`.`order_drop_address`
    , `orders`.`delivery_charges`
    , `orders`.`order_date_time`
    , `orders`.`orderer_name`
  
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
    `customers`,
	`orders` 
WHERE `customers`.`customer_id` = `orders`.`customer_id`
AND `orders`.`rider_id`=".$this->db->escape($rider_id)."
LIMIT ".$off_set.", ".$limit." ORDER BY `orders`.`order_id` DESC";
$query_result = $this->db->query($query);
		$rider_today_orders = $query_result->result();
		if($rider_today_orders){
			$response['rider_today_orders'] = $rider_today_orders;
			$response['success'] = true;
			$response['message'] = 'Rider Today Orders.';
		}else{
			$response['false'] = $rider_today_orders;
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		}		
	public function update_rider_location(){
		
		
		
		$rider_id =    (int) $this->input->post('rider_id');
		if($_POST['order_id']){
		$order_id  =   (int) $this->input->post('order_id');
		}else{
			$order_id = NULL;
			}
		$latitude  =   $this->input->post('latitude');
		$longitude  =  $this->input->post('longitude');
		$date_time  =  $this->input->post('date_time');
		//$date_time =   date("Y-m-d G:i:s", time());
		$query="
		INSERT INTO `rider_order_tracks`(`rider_id`, `order_id`, `latitude`, `longitude`, `created_date`) 
		VALUES (".$this->db->escape($rider_id).", ".$this->db->escape($order_id).", ".$this->db->escape($latitude).", ".$this->db->escape($longitude).", ".$this->db->escape($date_time).")";
		if($this->db->query($query)){
			
			$response['success'] = true;
			$response['message'] = 'location inserted';
		}else{
			$response['success'] = false;
			$response['message'] = 'Error Try Again.';
			}
			echo json_encode($response);
		
		}

}        

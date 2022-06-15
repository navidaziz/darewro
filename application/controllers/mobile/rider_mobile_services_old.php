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
	
	public function rider_login(){
		$rider_user_name = (string) $this->input->post('rider_user_name');
		$rider_password = (string) $this->input->post('rider_password');
		$response = array();
		$query="SELECT
					`rider_id`
					, `rider_name`
				FROM
				`riders`
				WHERE `$rider_user_name` = '".$rider_user_name."'
				AND `$rider_password` = '".$rider_password."';";
		$query_result = $this->db->query($query);
		$rider = $query_result->result();
		if($rider){
			$response['success'] = true;
			$response['message'] = 'Welcome '.$rider[0]->rider_name;
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
		   
			$result_SMS = $this->send_sms($user_name, 'SMS Alert', $pin_code.' is your Darewro code.');	
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
			$result_SMS = $this->send_sms($user_name, 'SMS Alert', $pin_code.' is your Darewro password. For security reasons, please change your password once you login. Thanks.');
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
	
	//-----------------------------------------------------
    /**
     * get single record by id
     */	
	public function send_pin_code(){
		$user_mobile_number  =  $this->input->post("user_mobile_number");
		$pin_code  =  $this->input->post("pin_code");
		$this->send_sms($user_mobile_number, 'SMS Alert', $pin_code.' is your Darewro code.');	
	}
	
	public function get_rider_running_orders(){
		$rider_id = (int)  $this->input->post('user_id');
		$query="SELECT
					`customers`.`mobile_number`
					, `customers`.`customer_name`
					, `orders`.*
				FROM
				`customers`,
				`orders`
				WHERE `customers`.`customer_id` = `orders`.`customer_id`
				AND `orders`.`rider_id`=".$this->db->escape($rider_id)."
				AND `orders`.`order_status` =3 ORDER BY `orders`.`order_id` DESC
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
			
		//Note: the order is consider to be new if the order order_rider_acknowledge is NULL	
			echo json_encode($response);
		
		}
	
	public function get_rider_delivered_orders(){
		
		$rider_id = (int)  $this->input->post('user_id');
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
	public function get_rider_cancelled_orders(){
		
		$rider_id = (int)  $this->input->post('user_id');
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
		$user_id  = (int) $this->input->post('user_id');
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
		$user_id  = (int) $this->input->post('user_id');
		$query="UPDATE `orders` SET `orders`.`order_picking_time` = '".date("Y-m-d G:i:s", time())."'
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
		$user_id  = (int) $this->input->post('user_id');
		$query="UPDATE `orders` SET `orders`.`order_rider_delivery_time` = '".date("Y-m-d G:i:s", time())."',7
		`orders`.`order_status` = '4'
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

}        

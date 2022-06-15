<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Dashboard extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
       
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		
		$hours = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
		$orderhours = array();
		$count=0;
		foreach($hours as $hour){
			$query = "SELECT 
				  HOUR(`order_date_time`) AS `hour`,
				  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`='4'
				   AND HOUR(`order_date_time`) ='".$hour."'
				GROUP BY `hour` ";
		$query_result = $this->db->query($query);
		if($query_result->result()){
		@$orderhours[$count] = $query_result->result()[0];
		}else{
			@$orderhours[$count]->total = 0;
			@$orderhours[$count]->hour = $hour;
			}
			$count++;
		}
		
		
		
		$this->data["order_hours"] = $orderhours;
		//$this->data["order_hours"] = array();
		
		//get months
		$query="SELECT MONTH(`order_date_time`) AS `month` FROM `orders`  WHERE  `orders`.`order_status`='4'  GROUP BY `month`;";
		$query_result = $this->db->query($query);
		$months = $query_result->result();
		foreach($months  as $month){
			
			
			$query="SELECT  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`=4
				   AND MONTH(`order_date_time`) ='".$month->month."'";
			$query_result = $this->db->query($query);
			$month->total_orders = $query_result->result()[0]->total;
			
			$query="SELECT  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`=5
				   AND MONTH(`order_date_time`) ='".$month->month."'";
			$query_result = $this->db->query($query);
			$month->cancelled_orders = $query_result->result()[0]->total;
			
			$query="SELECT  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`=4
				   AND MONTH(`order_date_time`) ='".$month->month."'
				   AND `order_type`='General Order' ";
				   
				   //Food Order
			$query_result = $this->db->query($query);
			$month->general_orders = $query_result->result()[0]->total;
			
			$query="SELECT  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`=4
				   AND MONTH(`order_date_time`) ='".$month->month."'
				   AND `order_type`='Food Order' ";
				   
			$query_result = $this->db->query($query);
			$month->food_orders = $query_result->result()[0]->total;
			
		$hours = array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5);
		$orderhours = array();
		$count=0;
		foreach($hours as $hour){
			$query="SELECT 
				  HOUR(`order_date_time`) AS `hour`,
				  COUNT(*)  as `total`
				FROM
				  `orders` 
				   WHERE  `orders`.`order_status`=4
				   AND MONTH(`order_date_time`) =".$month->month."
				   AND HOUR(`order_date_time`) ='".$hour."'
				GROUP BY `hour`";
			$query_result = $this->db->query($query);
			$orderhours[$count]['hour'] = $hour;
			if($query_result->result()){
			$orderhours[$count]['total'] = $query_result->result()[0]->total;
			}else{
				$orderhours[$count]['total'] = 0;
				}
			$count++;
		}
		
		
			$month->order_hours = $orderhours;
			
			}
		
		
    $this->data["months"] = $months;
	$this->data["view"] = ADMIN_DIR."dashboard/order_time_line";
	//$this->load->view(ADMIN_DIR."layout", $this->data);    
    $this->load->view(ADMIN_DIR."dashboard/order_time_line", $this->data);    
    
	}
	
	public function order_records(){
		
		/*$array = array (
  0 => 
  array (
    0 => 1167609600000,
    1 => 0.7537,
  ),
  1 => 
  array (
    0 => 1167696000000,
    1 => 0.7537,
  )
 );
  
  echo json_encode($array);*/
		
		
		
		
		$query = "SELECT
    COUNT(`order_id`) AS `total`
    , DATE(`order_date_time`) as `date`
FROM
    `orders`
	 `orders` WHERE order_status=4
    GROUP BY `date` ORDER BY `order_date_time`";
		$query_result = $this->db->query($query);
		$order_times = $query_result->result();
		$array = array();
		foreach($order_times as $order_time){
			$array[] = array(strtotime($order_time->date)*1000, (int) $order_time->total);
			}
  echo json_encode($array);
		exit();
		
   
	}
public function order_cancelled(){
	$query = "SELECT
    COUNT(`order_id`) AS `total`
    , DATE(`order_date_time`) as `date`
FROM
    `orders` WHERE order_status=5
    GROUP BY `date` ORDER BY `order_date_time`
	
	";
		$query_result = $this->db->query($query);
		$order_times = $query_result->result();
		$array = array();
		foreach($order_times as $order_time){
			$array[] = array(strtotime($order_time->date)*1000, (int) $order_time->total);
			}
  echo json_encode($array);
		exit();
	}
	
		
    
}        

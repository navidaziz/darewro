<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Cron_job extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
      
		
        //$this->output->enable_profiler(TRUE);
		
		
    }
    //---------------------------------------------------------------
    public function off_riders(){
		
		

		$query="SELECT `rider_id`, `duty_end` FROM `riders` WHERE `riders`.`is_available`";
		$query_result = $this->db->query($query);
		$available_riders = $query_result->result();
		foreach($available_riders as $available_rider){
			$rider_duty_end_time = "";
			//check the rider duty end date is within same day or in the next day ................
			if($available_rider->duty_end<=23){
				$rider_duty_end_time = date('Y-m-d ',time()).$available_rider->duty_end.':00:00';
				}else{
				$hour = $available_rider->duty_end-24;
				if($hour<10){ $hour='0'.$hour; }
				if((int) date("H", time())<=6){
					$rider_duty_end_time = date('Y-m-d ', time()).($hour).':00:00';
						
				}else{
					$rider_duty_end_time = date('Y-m-d ', strtotime('+1 day')).($hour).':00:00';
					}
				
				echo "Next day ";	
					}
			
		//$rider_duty_end_time = date('Y-m-d ',time()).$available_rider->duty_end.':00:00';	
			//.............................................. rider duty end date check end here ......
			
			if(strtotime($rider_duty_end_time)<time()){
				echo "<span style='color:red;'>We Need to off line the rider now here .......</span>";
				echo "<br />";
				//check rider last order timing..........
				$query="SELECT `delivery_time` 
						FROM `orders` 
						WHERE rider_id=".$available_rider->rider_id." 
						ORDER BY `delivery_time` DESC LIMIT 1;";
				$query_result = $this->db->query($query);
				@$R_order_D_time = $query_result->result()[0]->delivery_time;
				
				//check if the last delivery order date is greater the rider duty end time at the order delivery time as duty end time 
				if(strtotime($rider_duty_end_time)<strtotime($R_order_D_time)){
							$query="UPDATE `riders` SET `is_available`=0 
									WHERE `rider_id`=".$available_rider->rider_id;
							$current_date_time = date('Y-m-d H:i:s',time());
							if($this->db->query($query)){
								$query="INSERT INTO 
								`riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
								VALUES ('".$available_rider->rider_id."','".$R_order_D_time."','OCOUTT','".$current_date_time."', '1')";
							$this->db->query($query);
							}
				}else{
				
				
				$query="UPDATE `riders` SET `is_available`=0 WHERE `rider_id`=".$available_rider->rider_id;
						if($this->db->query($query)){
										$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
									VALUES ('".$available_rider->rider_id."','".$rider_duty_end_time."','COUTT','".date('Y-m-d H:i:s',time())."', '1')";
									$this->db->query($query);
						}	
					
					
					}
				//last order timing check end here ......
				}else{
				 echo "Ignore the rider ";
				 echo "<br />";
					}
			}
		}
   
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Mobile_messages extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
      
		
		
    }
   
    public function index(){
        
        echo  date_default_timezone_get (  );
	 echo date('Y-m-d H:i:s', time());
echo "<br />";
$newTime = strtotime('-10 minutes');
echo date('Y-m-d H:i:s', strtotime('-10 minutes'));
exit();
        
        
    }
  
     public function get_message(){
      $sms_date = date('Y-m-d H:i:s', strtotime('-10 minutes'));
	 $query="SELECT * FROM `sms`
	 		 WHERE `sms`.`status`=0 
	 		 AND `sms`.`date` >='".$sms_date."' LIMIT 1";
	 $query_result = $this->db->query($query);
	 $mobile_sms = $query_result->result()[0];
	if($mobile_sms){
	$response["id"] = $mobile_sms->sms_id; 
	$response["mobile_number"] = $mobile_sms->mobile_number;
	$response["sms_detail"] = $mobile_sms->message;
	$response["message"] = 'Message Found.';
	$response["success"] = true;
	
	$query="UPDATE `sms` SET `sms`.`status`=1
	 		 WHERE `sms`.`sms_id`=".$mobile_sms->sms_id;
	$this->db->query($query);
	$effect_rows = $this->db->affected_rows();
	
	}else{
		$response["message"] = 'Message Not Found.';
		$response["success"] = false;
		}
	echo json_encode($response);
	
	
	  
	
	
	 }
	 
	 
	 public function update_sms(){ 
	 $sms_id = (int) $this->input->post('sms_id');
	  $query="UPDATE `sms` SET `sms`.`status`=1
	 		 WHERE `sms`.`sms_id`=".$sms_id;
	$this->db->query($query);
	$effect_rows = $this->db->affected_rows();
		 
	if($effect_rows){
	$response["message"] = 'Message Update Successfully.';
	$response["success"] = true;
	}else{
		$response["message"] = 'Message Not Updated';
		$response["success"] = false;
		}
	echo json_encode($response);
	 }
	 
	 
}        

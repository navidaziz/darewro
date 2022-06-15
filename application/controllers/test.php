<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class test extends Public_Controller{
    
    public function __construct(){
           parent::__construct();
	 }
    
	public function index(){
		
		$_POST['test']='test';
		$_POST['test2']='test2';
		$_POST['test3']='test3';
		
		$query = "UPDATE `post_data` SET `post_data`='".implode("",$_POST)."' WHERE `id`=1";
		$result = $this->db->query($query);
		
		
		exit();
		
		
		error_reporting();
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="2" />
<title>Untitled Document</title>


</head>

<body>
</body>
</html>
';
		
		$query="SELECT `order_id`,`created_date` FROM `order_dates` WHERE `done`='0' LIMIT 200";
		$query_result = $this->db->query($query);
		$orders = $query_result->result();
		foreach($orders as $order){
			
			
			$this->db->query("UPDATE `orders` SET `created_date`='".$order->created_date."', `order_date_time`='".$order->created_date."' WHERE `order_id`='".$order->order_id."'");
			
			$this->db->query("UPDATE `order_dates` SET `done`='1' WHERE `order_id`='".$order->order_id."'");
			
			
			}
		}
}
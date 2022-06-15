<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Order_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "orders";
        $this->pk = "order_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "order_type",
                            "label"  =>  "Order Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "customer_id",
                            "label"  =>  "Customer Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "order_detail",
                            "label"  =>  "Order Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "order_picking_address",
                            "label"  =>  "Order Picking Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "order_drop_address",
                            "label"  =>  "Order Drop Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "delivery_charges",
                            "label"  =>  "Delivery Charges",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "delivery_time",
                            "label"  =>  "Delivery Time",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "order_status",
                            "label"  =>  "Order Status",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "comment",
                            "label"  =>  "Comment",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["order_type"]  =  $this->input->post("order_type");
                    
                    $inputs["customer_id"]  =  $this->input->post("customer_id");
                    
                    $inputs["order_detail"]  =  $this->input->post("order_detail");
                    
                    $inputs["order_picking_address"]  =  $this->input->post("order_picking_address");
                    
                    $inputs["order_drop_address"]  =  $this->input->post("order_drop_address");
                    
                    $inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
                    
                    $inputs["delivery_time"]  =  $this->input->post("delivery_time");
                    
                    $inputs["order_status"]  =  $this->input->post("order_status");
                    
                    $inputs["comment"]  =  $this->input->post("comment");
                    
	return $this->order_model->save($inputs);
	}	 	

public function update_data($order_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["order_type"]  =  $this->input->post("order_type");
                    
                    $inputs["customer_id"]  =  $this->input->post("customer_id");
                    
                    $inputs["order_detail"]  =  $this->input->post("order_detail");
                    
                    $inputs["order_picking_address"]  =  $this->input->post("order_picking_address");
                    
                    $inputs["order_drop_address"]  =  $this->input->post("order_drop_address");
                    
                    $inputs["delivery_charges"]  =  $this->input->post("delivery_charges");
                    
                    $inputs["delivery_time"]  =  $this->input->post("delivery_time");
                    
                    $inputs["order_status"]  =  $this->input->post("order_status");
                    
                    $inputs["comment"]  =  $this->input->post("comment");
                    
	return $this->order_model->save($inputs, $order_id);
	}	
	
    //----------------------------------------------------------------
 public function get_order_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("orders.*"
                , "customers.customer_name"
				, "customers.mobile_number"
            );
		$join_table = array(
            "customers" => "customers.customer_id = orders.customer_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->order_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->order_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->order_model->joinGet($fields, "orders", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->orders = $this->order_model->joinGet($fields, "orders", $join_table, $where);
			return $data;
		}else{
			return $this->order_model->joinGet($fields, "orders", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_order($order_id){
	
		$fields = array("orders.*"
                , "customers.customer_name"
				, "customers.mobile_number"
            );
		$join_table = array(
            "customers" => "customers.customer_id = orders.customer_id",
        );
		$where = "orders.order_id = $order_id";
		
		return $this->order_model->joinGet($fields, "orders", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


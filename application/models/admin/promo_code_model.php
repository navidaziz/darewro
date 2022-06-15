<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Promo_code_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "promo_codes";
        $this->pk = "promo_code_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "promo_code",
                            "label"  =>  "Promo Code",
                            "rules"  =>  "required|is_unique[promo_codes.promo_code]"
                        ),
                        
                        array(
                            "field"  =>  "min_basket_cost",
                            "label"  =>  "Min Basket Cost",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "discount_operation",
                            "label"  =>  "Discount Operation",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "discount_amount",
                            "label"  =>  "Discount Amount",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "num_vouchers",
                            "label"  =>  "Num Vouchers",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "expiry",
                            "label"  =>  "Expiry",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["promo_code"]  =  $this->input->post("promo_code");
                    
                    $inputs["min_basket_cost"]  =  $this->input->post("min_basket_cost");
                    
                    $inputs["discount_operation"]  =  $this->input->post("discount_operation");
                    
                    $inputs["discount_amount"]  =  $this->input->post("discount_amount");
                    
                    $inputs["num_vouchers"]  =  $this->input->post("num_vouchers");
                    
                    $inputs["expiry"]  =  $this->input->post("expiry");
                    
                    
	return $this->promo_code_model->save($inputs);
	}	 	

public function update_data($promo_code_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["promo_code"]  =  $this->input->post("promo_code");
                    
                    $inputs["min_basket_cost"]  =  $this->input->post("min_basket_cost");
                    
                    $inputs["discount_operation"]  =  $this->input->post("discount_operation");
                    
                    $inputs["discount_amount"]  =  $this->input->post("discount_amount");
                    
                    $inputs["num_vouchers"]  =  $this->input->post("num_vouchers");
                    
                    $inputs["expiry"]  =  $this->input->post("expiry");
                    
	return $this->promo_code_model->save($inputs, $promo_code_id);
	}	
	
    //----------------------------------------------------------------
 public function get_promo_code_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("promo_codes.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->promo_code_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->promo_code_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->promo_code_model->joinGet($fields, "promo_codes", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->promo_codes = $this->promo_code_model->joinGet($fields, "promo_codes", $join_table, $where);
			return $data;
		}else{
			return $this->promo_code_model->joinGet($fields, "promo_codes", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_promo_code($promo_code_id){
	
		$fields = array("promo_codes.*");
		$join_table = array();
		$where = "promo_codes.promo_code_id = $promo_code_id";
		
		return $this->promo_code_model->joinGet($fields, "promo_codes", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	


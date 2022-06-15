<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Customer_locations extends Admin_Controller_Mobile{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/customer_location_model");
		$this->lang->load("customer_locations", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
    }
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "";
		$data = $this->customer_location_model->get_customer_location_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_customer_location($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
		$data = $this->customer_location_model->get_customer_location($customer_location_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "";
		$data = $this->customer_location_model->get_customer_location_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
		$this->customer_location_model->changeStatus($customer_location_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor customer_location from trash
      * @param $customer_location_id integer
      */
     public function restore($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
		$this->customer_location_model->changeStatus($customer_location_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft customer_location from trash
      * @param $customer_location_id integer
      */
     public function draft($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
		$this->customer_location_model->changeStatus($customer_location_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish customer_location from trash
      * @param $customer_location_id integer
      */
     public function publish($customer_location_id){
        
        $customer_location_id = (int) $customer_location_id;
		$this->customer_location_model->changeStatus($customer_location_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Customer_location
      * @param $customer_location_id integer
      */
     public function delete($customer_location_id, $page_id = NULL){
        
        $customer_location_id = (int) $customer_location_id;
        //$this->customer_location_model->changeStatus($customer_location_id, "3");
        $this->customer_location_model->delete(array( 'customer_location_id' => $customer_location_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$customer_location_id = $this->customer_location_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($customer_location_id){
		$customer_location_id = $this->customer_location_model->update_data($customer_location_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        

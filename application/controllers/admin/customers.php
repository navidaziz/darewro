<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Customers extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/customer_model");
		$this->lang->load("customers", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`customers`.`status` IN (0, 1) ORDER BY `mobile_number` DESC";
		$data = $this->customer_model->get_customer_list($where);
		 $this->data["customers"] = $data->customers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Customers');
		$this->data["view"] = ADMIN_DIR."customers/customers";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_customer($customer_id){
        
        $customer_id = (int) $customer_id;
        
        $this->data["customers"] = $this->customer_model->get_customer($customer_id);
        $this->data["title"] = $this->lang->line('Customer Details');
		$this->data["view"] = ADMIN_DIR."customers/view_customer";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`customers`.`status` IN (2) ";
		$data = $this->customer_model->get_customer_list($where);
		 $this->data["customers"] = $data->customers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Customers');
		$this->data["view"] = ADMIN_DIR."customers/trashed_customers";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($customer_id, $page_id = NULL){
        
        $customer_id = (int) $customer_id;
        
        
        $this->customer_model->changeStatus($customer_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."customers/view/".$page_id);
    }
    
    /**
      * function to restor customer from trash
      * @param $customer_id integer
      */
     public function restore($customer_id, $page_id = NULL){
        
        $customer_id = (int) $customer_id;
        
        
        $this->customer_model->changeStatus($customer_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."customers/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft customer from trash
      * @param $customer_id integer
      */
     public function draft($customer_id, $page_id = NULL){
        
        $customer_id = (int) $customer_id;
        
        
        $this->customer_model->changeStatus($customer_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."customers/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish customer from trash
      * @param $customer_id integer
      */
     public function publish($customer_id, $page_id = NULL){
        
        $customer_id = (int) $customer_id;
        
        
        $this->customer_model->changeStatus($customer_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."customers/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Customer
      * @param $customer_id integer
      */
     public function delete($customer_id, $page_id = NULL){
        
        $customer_id = (int) $customer_id;
        //$this->customer_model->changeStatus($customer_id, "3");
        
		$this->customer_model->delete(array( 'customer_id' => $customer_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."customers/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Customer
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Customer');$this->data["view"] = ADMIN_DIR."customers/add_customer";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->customer_model->validate_form_data() === TRUE){
		  
		  $customer_id = $this->customer_model->save_data();
          if($customer_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customers/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Customer
      */
     public function edit($customer_id){
		 $customer_id = (int) $customer_id;
        $this->data["customer"] = $this->customer_model->get($customer_id);
		  
        $this->data["title"] = $this->lang->line('Edit Customer');$this->data["view"] = ADMIN_DIR."customers/edit_customer";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($customer_id){
		 
		 $customer_id = (int) $customer_id;
       
	   if($this->customer_model->validate_form_data() === TRUE){
		  
		  $customer_id = $this->customer_model->update_data($customer_id);
          if($customer_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
            }
        }else{
			$this->edit($customer_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["customers"] = $this->customer_model->getBy($where, false, "customer_id" );
				$j_array[]=array("id" => "", "value" => "customer");
				foreach($data["customers"] as $customer ){
					$j_array[]=array("id" => $customer->customer_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	public function update_customer_location($customer_id){
		$customer_id = (int) $customer_id;
		$customer_location_id = (int) $this->input->post('customer_location_id');
		$customer_location =  $this->input->post('customer_location');
		$query="UPDATE `customer_locations` SET
		`location_address`=".$this->db->escape($customer_location)."
		 WHERE `customer_location_id`=".$this->db->escape($customer_location_id).";";
		 if($this->db->query($query)){
			 $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
			 }else{
				 $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
				 }
		}
		
	public function delete_customer_location($customer_id, $customer_location_id){
		$customer_id = (int) $customer_id;
		$customer_location_id = (int) $customer_location_id;
		$customer_location =  $this->input->post('customer_location');
		$query="DELETE FROM `customer_locations` WHERE `customer_location_id`=".$this->db->escape($customer_location_id).";";
		 if($this->db->query($query)){
			 $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
			 }else{
				 $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."customers/edit/$customer_id");
				 }
		}
	public function searched_customer($customer_mobile_no=NULL){
	
	if($customer_mobile_no){
		$query="SELECT * FROM `customers` WHERE `customers`.`mobile_number` like ".$this->db->escape($customer_mobile_no);
		$query_result = $this->db->query($query);
		$customers = $query_result->result();
		?>
        <table class="table table-bordered">
            <thead>
              <tr>
                 <th>Mobile Number</th>
                <th><?php echo $this->lang->line('customer_name'); ?></th>
                <th><?php echo $this->lang->line('comment'); ?></th>
                <th><?php echo $this->lang->line('customer_email_address'); ?></th>
                 <th>Saved Locations</th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
        <?php 
		foreach($customers as $customer){ ?>
			<tr>
                <td><?php echo $customer->mobile_number; ?></td>
                <td><?php echo $customer->customer_name; ?></td>
                <td><?php echo $customer->comment; ?></td>
                <td><?php echo $customer->customer_email_address; ?></td>
                <td>
                <?php 
				$query="SELECT * FROM `customer_locations` WHERE `customer_id`=".$this->db->escape($customer->customer_id).";";
		$query_result = $this->db->query($query);
		$customer_locations = $query_result->result();
				
				foreach($customer_locations as $customer_location){ ?>
                <?php echo $customer_location->location_address; ?><br />
                <?php } ?>
                
                </td>
                <td><?php echo status($customer->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($customer->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."customers/publish/".$customer->customer_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($customer->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."customers/draft/".$customer->customer_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."customers/view_customer/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."customers/edit/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."customers/trash/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
			
			<?php }?>
             </tbody>
          </table>
            <?php 
	}else{
		echo "Enter mobile number.....";
		}
	}
    
}        

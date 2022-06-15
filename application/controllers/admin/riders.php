<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Riders extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/rider_model");
		$this->load->model("admin/user_model");
		$this->lang->load("riders", 'english');
		$this->lang->load("users", 'english');
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
	public function rider_roster(){
		$hour = date("H", time());
		if($hour<1){ $hour=24;}
		$query="SELECT * FROM `riders` 
		WHERE `is_available`=1 AND `is_absent`=0";
		
		$result = $this->db->query($query);
		$on_duty_riders = $result->result();
		$this->data['on_duty_riders'] = $on_duty_riders;
		$on_duty_rider_ids ="0,";
		foreach($on_duty_riders as $on_duty_rider){
			$on_duty_rider_ids=$on_duty_rider_ids.$on_duty_rider->rider_id.",";
			}
		
		$on_duty_rider_ids = substr($on_duty_rider_ids,0, (strlen($on_duty_rider_ids)-1));
		$hour = date("H", time());
		$query="SELECT * FROM `riders` 
		WHERE `rider_id` NOT IN($on_duty_rider_ids) AND `is_absent`=0 AND `status`=1";
		//exit();
		$result = $this->db->query($query);
		$off_duty_riders = $result->result();
		$this->data['off_duty_riders'] = $off_duty_riders;
		
		$query="SELECT * FROM `riders` 
		WHERE `is_absent`=1";
		$result = $this->db->query($query);
		$on_leave_riders = $result->result();
		$this->data['on_leave_riders'] = $on_leave_riders;
		
		$this->data["title"] = 'Rider Daily Roster';
		$this->data["view"] = ADMIN_DIR."riders/roster";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		
		}

	function make_avaliable($rider_id){
		$rider_id = (int) $rider_id;
		$query="UPDATE `riders` SET `is_available`=1 WHERE `rider_id`=".$rider_id;
		if($this->db->query($query)){
			//need to check for today .... if their is not entry today the add duty start and end time for today ...
			$query="SELECT COUNT(`rider_timing_id`) as `today_entry` FROM `riders_timing` WHERE `rider_id`=".$this->db->escape($rider_id)." AND DATE(`created_date`) ='".date('Y-m-d',time())."' AND `timing_type`='DST'";
			
			$query_result = $this->db->query($query);
			$today_entry = $query_result->result()[0];
			if($today_entry->today_entry>0){
				$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`,`created_by` ) 
					VALUES ('".$this->db->escape($rider_id)."','".date('Y-m-d H:i:s',time())."','CINT','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
					$this->db->query($query);
				}else{
					
					//get rider timing ....
					
					$query="SELECT `duty_start`, `duty_end`
							FROM `riders` WHERE `rider_id` = ".$this->db->escape($rider_id);
					$query_result = $this->db->query($query);
					$rider_timing = $query_result->result()[0];		
					
					//insert start timing
					$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
					VALUES ('".$this->db->escape($rider_id)."','".date('Y-m-d ',time()).$rider_timing->duty_start.":00:00','DST','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
					$this->db->query($query);
					//insert end time 
					
					if($rider_timing->duty_end>23){
						//next day time stamp ....
						 $rider_end_time = date('Y-m-d ', strtotime('+1 day')).($rider_timing->duty_end-24).':00:00';
						
						}else{
							//today time stamp ...
						$rider_end_time = date('Y-m-d ',time()).$rider_timing->duty_end.':00:00';
						
							}
							
					$rider_end_time;
					
					$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
					VALUES ('".$this->db->escape($rider_id)."','".$rider_end_time."','DET','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
					$this->db->query($query);
					// current avaliable checked in time ....
					
					$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
					VALUES ('".$this->db->escape($rider_id)."','".date('Y-m-d H:i:s',time())."','CINT','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
					$this->db->query($query);
					
					}
			
			}
		
		
		
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/rider_roster";
  		redirect($main_page); 
		}
	
	function make_un_available($rider_id){
		$rider_id = (int) $rider_id;
		
		$query="SELECT `duty_start`, `duty_end` FROM `riders` WHERE `rider_id` = ".$this->db->escape($rider_id);
		$query_result = $this->db->query($query);
		$rider_timing = $query_result->result()[0];	
		
		if($rider_timing->duty_end>23){
			//next day time stamp ....
			$rider_end_time = date('Y-m-d ', strtotime('+1 day')).($rider_timing->duty_end-24).':00:00';
			}else{
				//today time stamp ...
				$rider_end_time = date('Y-m-d ',time()).$rider_timing->duty_end.':00:00';
				}
		
		$query="SELECT `delivery_time` 
						FROM `orders` 
						WHERE rider_id=".$this->db->escape($rider_id)." 
						ORDER BY `delivery_time` DESC LIMIT 1;";
				$query_result = $this->db->query($query);
				$rider_last_order_expected_time = $query_result->result()[0];
			
		if(strtotime($rider_end_time)>time()){
			
			$query="UPDATE `riders` SET `is_available`=0 WHERE `rider_id`=".$rider_id;
			if($this->db->query($query)){
				$query="INSERT INTO `riders_timing`
				(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` )
				VALUES 
				('".$this->db->escape($rider_id)."','".date('Y-m-d H:i:s',time())."','COUTT','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
				$this->db->query($query);
				}
			
		}else{
			
		if(strtotime($rider_end_time)>strtotime($rider_last_order_expected_time->delivery_time)){
		
		$query="UPDATE `riders` SET `is_available`=0 WHERE `rider_id`=".$rider_id;
			if($this->db->query($query)){
				$query="INSERT INTO `riders_timing`
				(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` )
				VALUES 
				('".$this->db->escape($rider_id)."','".date('Y-m-d H:i:s',time())."','COUTT','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
				$this->db->query($query);
				}
				
		}else{
			
		$query="UPDATE `riders` SET `is_available`=0 WHERE `rider_id`=".$rider_id;
		if($this->db->query($query)){
						$query="INSERT INTO `riders_timing`(`rider_id`, `timing`, `timing_type`, `created_date`, `created_by` ) 
					VALUES ('".$this->db->escape($rider_id)."','".$rider_last_order_expected_time->delivery_time."','COUTT','".date('Y-m-d H:i:s',time())."', '".$this->session->userdata('user_id')."')";
					$this->db->query($query);
		}
		}
			
			
			}
					
	
	
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/rider_roster";
  		redirect($main_page); 
		}
		
		
		
	function assign_leave($rider_id){
		$rider_id = (int) $rider_id;
		$query="UPDATE `riders` SET `is_absent`=1 WHERE `rider_id`=".$rider_id;
		$this->db->query($query);
		
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/rider_roster";
  		redirect($main_page); 
		}
	function make_present($rider_id){
		$rider_id = (int) $rider_id;
		$query="UPDATE `riders` SET `is_absent`=0 WHERE `rider_id`=".$rider_id;
		$this->db->query($query);
		$main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/rider_roster";
  		redirect($main_page); 
		}
			
		
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`riders`.`status` IN (0, 1) ORDER BY `riders`.`rider_name` ASC";
		 $this->data["riders"] = $this->rider_model->get_rider_list($where, false);
		//$data = $this->rider_model->get_rider_list($where);
		// $this->data["riders"] = $data->riders;
		// $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Riders');
		$this->data["view"] = ADMIN_DIR."riders/riders";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_rider($rider_id){
        
        $rider_id = (int) $rider_id;
        
        $this->data["riders"] = $this->rider_model->get_rider($rider_id);
        $this->data["title"] = $this->lang->line('Rider Details');
		$this->data["view"] = ADMIN_DIR."riders/view_rider";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`riders`.`status` IN (2) ";
		$data = $this->rider_model->get_rider_list($where);
		 $this->data["riders"] = $data->riders;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Riders');
		$this->data["view"] = ADMIN_DIR."riders/trashed_riders";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($rider_id, $page_id = NULL){
        
        $rider_id = (int) $rider_id;
        
        
        $this->rider_model->changeStatus($rider_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."riders/view/".$page_id);
    }
    
    /**
      * function to restor rider from trash
      * @param $rider_id integer
      */
     public function restore($rider_id, $page_id = NULL){
        
        $rider_id = (int) $rider_id;
        
        
        $this->rider_model->changeStatus($rider_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."riders/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft rider from trash
      * @param $rider_id integer
      */
     public function draft($rider_id, $page_id = NULL){
        
        $rider_id = (int) $rider_id;
        
        
        $this->rider_model->changeStatus($rider_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."riders/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish rider from trash
      * @param $rider_id integer
      */
     public function publish($rider_id, $page_id = NULL){
        
        $rider_id = (int) $rider_id;
        
        
        $this->rider_model->changeStatus($rider_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."riders/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Rider
      * @param $rider_id integer
      */
     public function delete($rider_id, $page_id = NULL){
        
        $rider_id = (int) $rider_id;
       $this->rider_model->changeStatus($rider_id, "3");
        //Remove file....
		/*				$riders = $this->rider_model->get_rider($rider_id);
						$file_path = $riders[0]->rider_image;
						$this->rider_model->delete_file($file_path);
		$this->rider_model->delete(array( 'rider_id' => $rider_id));*/
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."riders/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Rider
      */
     public function add(){
		 
		
        $this->data["title"] = $this->lang->line('Add New Rider');$this->data["view"] = ADMIN_DIR."riders/add_rider";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->rider_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("rider_image")){
                       $_POST['rider_image'] = $this->data["upload_data"]["file_name"];
                    }
		if($this->input->post('duty_end')>=24){ $_POST['is_next_day']=1; }else{ $_POST['is_next_day']=0; }			
                    
		  $rider_id = $this->rider_model->save_data();
          if($rider_id){
			  $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."riders/edit/$rider_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."riders/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Rider
      */
     public function edit($rider_id){
		 $rider_id = (int) $rider_id;
        $this->data["rider"] = $this->rider_model->get($rider_id);
		  
        $this->data["title"] = $this->lang->line('Edit Rider');$this->data["view"] = ADMIN_DIR."riders/edit_rider";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($rider_id){
		 
		 $rider_id = (int) $rider_id;
       
	   if($this->rider_model->validate_form_data($rider_id) === TRUE){
		  
                    if($this->upload_file("rider_image")){
                         $_POST["rider_image"] = $this->data["upload_data"]["file_name"];
                    }
					
		if($this->input->post('duty_end')>=24){ $_POST['is_next_day']=1; }else{ $_POST['is_next_day']=0; }			
                    
		  $rider_id = $this->rider_model->update_data($rider_id);
          if($rider_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."riders/edit/$rider_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."riders/edit/$rider_id");
            }
        }else{
			$this->edit($rider_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["riders"] = $this->rider_model->getBy($where, false, "rider_id" );
				$j_array[]=array("id" => "", "value" => "rider");
				foreach($data["riders"] as $rider ){
					$j_array[]=array("id" => $rider->rider_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
	

    //-----------------------------------------------------
    
}        

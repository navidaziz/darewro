<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Restaurant_food_categories extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/restaurant_food_category_model");
		$this->lang->load("restaurant_food_categories", 'english');
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
		
        $where = "`restaurant_food_categories`.`status` IN (0, 1) ORDER BY `restaurant_food_categories`.`order`";
		$data = $this->restaurant_food_category_model->get_restaurant_food_category_list($where);
		 $this->data["restaurant_food_categories"] = $data->restaurant_food_categories;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Restaurant Food Categories');
		$this->data["view"] = ADMIN_DIR."restaurant_food_categories/restaurant_food_categories";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_restaurant_food_category($restaurant_food_category_id){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        $this->data["restaurant_food_categories"] = $this->restaurant_food_category_model->get_restaurant_food_category($restaurant_food_category_id);
        $this->data["title"] = $this->lang->line('Restaurant Food Category Details');
		$this->data["view"] = ADMIN_DIR."restaurant_food_categories/view_restaurant_food_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`restaurant_food_categories`.`status` IN (2) ORDER BY `restaurant_food_categories`.`order`";
		$data = $this->restaurant_food_category_model->get_restaurant_food_category_list($where);
		 $this->data["restaurant_food_categories"] = $data->restaurant_food_categories;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Restaurant Food Categories');
		$this->data["view"] = ADMIN_DIR."restaurant_food_categories/trashed_restaurant_food_categories";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        
        $this->restaurant_food_category_model->changeStatus($restaurant_food_category_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
    }
    
    /**
      * function to restor restaurant_food_category from trash
      * @param $restaurant_food_category_id integer
      */
     public function restore($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        
        $this->restaurant_food_category_model->changeStatus($restaurant_food_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_categories/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft restaurant_food_category from trash
      * @param $restaurant_food_category_id integer
      */
     public function draft($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        
        $this->restaurant_food_category_model->changeStatus($restaurant_food_category_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish restaurant_food_category from trash
      * @param $restaurant_food_category_id integer
      */
     public function publish($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        
        $this->restaurant_food_category_model->changeStatus($restaurant_food_category_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Restaurant_food_category
      * @param $restaurant_food_category_id integer
      */
     public function delete($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        //$this->restaurant_food_category_model->changeStatus($restaurant_food_category_id, "3");
        //Remove file....
						$restaurant_food_categories = $this->restaurant_food_category_model->get_restaurant_food_category($restaurant_food_category_id);
						$file_path = $restaurant_food_categories[0]->restaurant_food_category_image;
						$this->restaurant_food_category_model->delete_file($file_path);
		$this->restaurant_food_category_model->delete(array( 'restaurant_food_category_id' => $restaurant_food_category_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_categories/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Restaurant_food_category
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Restaurant Food Category');$this->data["view"] = ADMIN_DIR."restaurant_food_categories/add_restaurant_food_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                       $_POST['restaurant_food_category_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->save_data();
          if($restaurant_food_category_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."restaurant_food_categories/edit/$restaurant_food_category_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurant_food_categories/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Restaurant_food_category
      */
     public function edit($restaurant_food_category_id){
		 $restaurant_food_category_id = (int) $restaurant_food_category_id;
        $this->data["restaurant_food_category"] = $this->restaurant_food_category_model->get($restaurant_food_category_id);
		  
        $this->data["title"] = $this->lang->line('Edit Restaurant Food Category');
		$this->data["view"] = ADMIN_DIR."restaurant_food_categories/edit_restaurant_food_category";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($restaurant_food_category_id){
		 
		 $restaurant_food_category_id = (int) $restaurant_food_category_id;
       
	   if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                         $_POST["restaurant_food_category_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->update_data($restaurant_food_category_id);
          if($restaurant_food_category_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."restaurant_food_categories/edit/$restaurant_food_category_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurant_food_categories/edit/$restaurant_food_category_id");
            }
        }else{
			$this->edit($restaurant_food_category_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $restaurant_food_category_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
		//get order number of this record
        $this_restaurant_food_category_where = "restaurant_food_category_id = $restaurant_food_category_id";
        $this_restaurant_food_category = $this->restaurant_food_category_model->getBy($this_restaurant_food_category_where, true);
        $this_restaurant_food_category_id = $restaurant_food_category_id;
        $this_restaurant_food_category_order = $this_restaurant_food_category->order;
        
        
        //get order number of previous record
        $previous_restaurant_food_category_where = "order <= $this_restaurant_food_category_order AND restaurant_food_category_id != $restaurant_food_category_id ORDER BY `order` DESC";
        $previous_restaurant_food_category = $this->restaurant_food_category_model->getBy($previous_restaurant_food_category_where, true);
        $previous_restaurant_food_category_id = $previous_restaurant_food_category->restaurant_food_category_id;
        $previous_restaurant_food_category_order = $previous_restaurant_food_category->order;
        
        //if this is the first element
        if(!$previous_restaurant_food_category_id){
            redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_restaurant_food_category_inputs = array(
            "order" => $previous_restaurant_food_category_order
        );
        $this->restaurant_food_category_model->save($this_restaurant_food_category_inputs, $this_restaurant_food_category_id);
        
        $previous_restaurant_food_category_inputs = array(
            "order" => $this_restaurant_food_category_order
        );
        $this->restaurant_food_category_model->save($previous_restaurant_food_category_inputs, $previous_restaurant_food_category_id);
        
        
        
        redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $restaurant_food_category_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($restaurant_food_category_id, $page_id = NULL){
        
        $restaurant_food_category_id = (int) $restaurant_food_category_id;
        
        
        
        //get order number of this record
         $this_restaurant_food_category_where = "restaurant_food_category_id = $restaurant_food_category_id";
        $this_restaurant_food_category = $this->restaurant_food_category_model->getBy($this_restaurant_food_category_where, true);
        $this_restaurant_food_category_id = $restaurant_food_category_id;
        $this_restaurant_food_category_order = $this_restaurant_food_category->order;
        
        
        //get order number of next record
		
        $next_restaurant_food_category_where = "order >= $this_restaurant_food_category_order and restaurant_food_category_id != $restaurant_food_category_id ORDER BY `order` ASC";
        $next_restaurant_food_category = $this->restaurant_food_category_model->getBy($next_restaurant_food_category_where, true);
        $next_restaurant_food_category_id = $next_restaurant_food_category->restaurant_food_category_id;
        $next_restaurant_food_category_order = $next_restaurant_food_category->order;
        
        //if this is the first element
        if(!$next_restaurant_food_category_id){
            redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_restaurant_food_category_inputs = array(
            "order" => $next_restaurant_food_category_order
        );
        $this->restaurant_food_category_model->save($this_restaurant_food_category_inputs, $this_restaurant_food_category_id);
        
        $next_restaurant_food_category_inputs = array(
            "order" => $this_restaurant_food_category_order
        );
        $this->restaurant_food_category_model->save($next_restaurant_food_category_inputs, $next_restaurant_food_category_id);
        
        
        
        redirect(ADMIN_DIR."restaurant_food_categories/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["restaurant_food_categories"] = $this->restaurant_food_category_model->getBy($where, false, "restaurant_food_category_id" );
				$j_array[]=array("id" => "", "value" => "restaurant_food_category");
				foreach($data["restaurant_food_categories"] as $restaurant_food_category ){
					$j_array[]=array("id" => $restaurant_food_category->restaurant_food_category_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

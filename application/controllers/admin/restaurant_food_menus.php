<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Restaurant_food_menus extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/restaurant_food_menu_model");
		$this->lang->load("restaurant_food_menus", 'english');
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

	public function get_food_menu($restaurant_id){
		$restaurant_id = (int) $restaurant_id;
		$where = "`restaurant_food_menus`.`status` IN (1) AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id";
		$data['restaurant_food_menu'] = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		echo json_encode($data['restaurant_food_menu']);
		}
	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`restaurant_food_menus`.`status` IN (0, 1) ";
		$data = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where);
		 $this->data["restaurant_food_menus"] = $data->restaurant_food_menus;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Restaurant Food Menus');
		$this->data["view"] = ADMIN_DIR."restaurant_food_menus/restaurant_food_menus";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_restaurant_food_menu($restaurant_food_menu_id){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        $this->data["restaurant_food_menus"] = $this->restaurant_food_menu_model->get_restaurant_food_menu($restaurant_food_menu_id);
        $this->data["title"] = $this->lang->line('Restaurant Food Menu Details');
		$this->data["view"] = ADMIN_DIR."restaurant_food_menus/view_restaurant_food_menu";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`restaurant_food_menus`.`status` IN (2) ";
		$data = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where);
		 $this->data["restaurant_food_menus"] = $data->restaurant_food_menus;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Restaurant Food Menus');
		$this->data["view"] = ADMIN_DIR."restaurant_food_menus/trashed_restaurant_food_menus";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($restaurant_food_menu_id, $page_id = NULL){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_menus/view/".$page_id);
    }
    
    /**
      * function to restor restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function restore($restaurant_food_menu_id, $page_id = NULL){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_menus/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function draft($restaurant_food_menu_id, $page_id = NULL){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_menus/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function publish($restaurant_food_menu_id, $page_id = NULL){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_menus/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Restaurant_food_menu
      * @param $restaurant_food_menu_id integer
      */
     public function delete($restaurant_food_menu_id, $page_id = NULL){
        
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        //$this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "3");
        //Remove file....
						$restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu($restaurant_food_menu_id);
						$file_path = $restaurant_food_menus[0]->restaurant_food_image;
						$this->restaurant_food_menu_model->delete_file($file_path);
		$this->restaurant_food_menu_model->delete(array( 'restaurant_food_menu_id' => $restaurant_food_menu_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."restaurant_food_menus/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Restaurant_food_menu
      */
     public function add(){
		
    $this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("RESTAURANT_FOOD_CATEGORIES", "restaurant_food_category_id", "restaurant_food_category", $where ="");
    
    $this->data["restaurants"] = $this->restaurant_food_menu_model->getList("RESTAURANTS", "restaurant_id", "restaurant_name", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Restaurant Food Menu');$this->data["view"] = ADMIN_DIR."restaurant_food_menus/add_restaurant_food_menu";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                       $_POST['restaurant_food_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->save_data();
          if($restaurant_food_menu_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."restaurant_food_menus/edit/$restaurant_food_menu_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurant_food_menus/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Restaurant_food_menu
      */
     public function edit($restaurant_food_menu_id){
		 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        $this->data["restaurant_food_menu"] = $this->restaurant_food_menu_model->get($restaurant_food_menu_id);
		  
    $this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("RESTAURANT_FOOD_CATEGORIES", "restaurant_food_category_id", "restaurant_food_category", $where ="");
    
    $this->data["restaurants"] = $this->restaurant_food_menu_model->getList("RESTAURANTS", "restaurant_id", "restaurant_name", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Restaurant Food Menu');$this->data["view"] = ADMIN_DIR."restaurant_food_menus/edit_restaurant_food_menu";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($restaurant_food_menu_id){
		 
		 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
       
	   if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                         $_POST["restaurant_food_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->update_data($restaurant_food_menu_id);
          if($restaurant_food_menu_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."restaurant_food_menus/edit/$restaurant_food_menu_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurant_food_menus/edit/$restaurant_food_menu_id");
            }
        }else{
			$this->edit($restaurant_food_menu_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["restaurant_food_menus"] = $this->restaurant_food_menu_model->getBy($where, false, "restaurant_food_menu_id" );
				$j_array[]=array("id" => "", "value" => "restaurant_food_menu");
				foreach($data["restaurant_food_menus"] as $restaurant_food_menu ){
					$j_array[]=array("id" => $restaurant_food_menu->restaurant_food_menu_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
	

public function add_food_to_cart($restaurant_food_menu_id){
	 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
	 /*$where = "`restaurant_food_menus`.`restaurant_food_menu_id` =".$restaurant_food_menu_id;
	 $restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where, false)[0];*/
	 
	 $query='INSERT INTO `item_cart`(`restaurant_food_menu_id`, `quantity`, `user_id`, `user_unique_id`) 
	 		 VALUES ("'.$restaurant_food_menu_id.'", "1","'.$this->session->userdata("user_id").'", "'.$this->session->userdata("user_unique_id").'")';
	
	 $result = $this->db->query($query);
	 
		
	$restaurant_food_categories = $this->get_cart_items();
	echo json_encode($restaurant_food_categories);
	
	}
	
public function get_cart_items(){
	$query='SELECT
				`restaurant_food_menus`.`restaurant_food_name`
				, `restaurant_food_menus`.`restaurant_food_price`
				, `restaurant_food_menus`.`restaurant_food_quantity`
				, `restaurant_food_menus`.`restaurant_food_description`
				, `item_cart`.`quantity`
				, `restaurant_food_categories`.`restaurant_food_category`
				, `restaurants`.`restaurant_name`
				, `restaurants`.`restaurant_address`
				, `restaurants`.`restaurant_street_number`
				, `restaurants`.`restaurant_route`
				, `restaurants`.`restaurant_city`
				, `restaurants`.`restaurant_province`
				, `restaurants`.`restaurant_country`
				, `restaurants`.`restaurant_latitude`
				, `restaurants`.`restaurant_longitude`
				, `item_cart`.`item_cart_id`
			FROM
			`restaurant_food_menus`,
			`item_cart`,
			`restaurant_food_categories`,
			`restaurants` 
			WHERE `restaurant_food_menus`.`restaurant_food_menu_id` = `item_cart`.`restaurant_food_menu_id`
			AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
			AND `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
			AND `item_cart`.`user_id`="'.$this->session->userdata("user_id").'" 
			AND `item_cart`.`user_unique_id`="'.$this->session->userdata("user_unique_id").'"';
	
	$result = $this->db->query($query);		
	return $result->result();
	}		
	

public function remove_cart_item($item_cart_id){
	$item_cart_id = (int) $item_cart_id;
	$query ="DELETE FROM `item_cart` WHERE `item_cart_id`='".$item_cart_id."' and `user_id`='".$this->session->userdata("user_id")."' and `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
	$result = $this->db->query($query);		
	$restaurant_food_categories = $this->get_cart_items();
	echo json_encode($restaurant_food_categories);
	}
	
	
public function icrement_cart_item_quantity($item_cart_id){
	$item_cart_id = (int) $item_cart_id;
	 $quantity  =  $this->input->post("quantity");
	$query ="UPDATE `item_cart` SET `quantity` = '".$quantity."' WHERE `item_cart_id`='".$item_cart_id."' and `user_id`='".$this->session->userdata("user_id")."' and `user_unique_id`='".$this->session->userdata("user_unique_id")."'";
	$result = $this->db->query($query);		
	
	
	$restaurant_food_categories = $this->get_cart_items();
	echo json_encode($restaurant_food_categories);
	}		
    //-----------------------------------------------------
    
}        

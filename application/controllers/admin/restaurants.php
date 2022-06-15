<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Restaurants extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/restaurants_model");
		$this->lang->load("restaurants", 'english');
		$this->lang->load("system", 'english');
		
		$this->load->model("admin/restaurant_food_menu_model");
		$this->lang->load("restaurant_food_menus", 'english');
		
		 $this->load->model("admin/user_model");
		$this->lang->load("users", 'english');
		
		$this->load->model("admin/restaurant_food_category_model");
		$this->lang->load("restaurant_food_categories", 'english');
		
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
		
        $where = "`restaurants`.`status` IN (0, 1) ORDER BY `restaurants`.`order`";
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants_list($where, false);
		// $this->data["restaurants"] = $data->restaurants;
		 //$this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Restaurants');
		$this->data["view"] = ADMIN_DIR."restaurants/restaurants";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
	 
	 
	 
	 
	 public function food_menu_trashed($restaurant_id){
        
        $restaurant_id = (int) $restaurant_id;
		$this->data['restaurant_id'] = $restaurant_id;
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants($restaurant_id);
		
		//get restaurant food categories 
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (2)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id`";
				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
		//get restaurant food menu
		$where = "`restaurant_food_menus`.`status` IN (2)
		AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id
		AND `restaurant_food_menus`.`restaurant_food_category_id` = ".$restaurant_food_category->restaurant_food_category_id;
		$restaurant_food_category->restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		
		}
		$this->data["restaurant_food_categories"] = $restaurant_food_categories;
        //$this->data["title"] = $this->lang->line('Restaurants Details');
		$this->data["backlink"] = $this->data["restaurants"][0]->restaurant_name;
		$this->data["title"] = $this->data["restaurants"][0]->restaurant_name. " ( Trashed )";
		$this->data["view"] = ADMIN_DIR."restaurants/view_restaurant_food_trash";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
	 
	 
	 
    public function view_restaurants($restaurant_id){
        
        $restaurant_id = (int) $restaurant_id;
		$this->data['restaurant_id'] = $restaurant_id;
		$this->data["restaurants"] = $this->restaurants_model->get_restaurants($restaurant_id);
		$this->data['restaurant_user'] = NULL;
		$query="SELECT * FROM `users` WHERE `users`.`restaurant_id` ='".$restaurant_id."'";
		$query_result = $this->db->query($query);
		$restaurant_user = $query_result->result();
		if($restaurant_user){ $this->data['restaurant_user'] = $restaurant_user[0]; }
		
		$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`restaurant_id` = $restaurant_id");
		
		
		
		//get restaurant food categories 
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
					,`restaurant_food_categories`.`restaurant_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			/*$this->data["restaurant_food_categories_list"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;*/
		//get restaurant food menu
		$where = "`restaurant_food_menus`.`status` IN (1,0)
		AND `restaurant_food_menus`.`restaurant_id` = $restaurant_id
		AND `restaurant_food_menus`.`restaurant_food_category_id` = ".$restaurant_food_category->restaurant_food_category_id;
		$restaurant_food_category->restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu_list($where,false);
		
		}
		$this->data["restaurant_food_categories"] = $restaurant_food_categories;
        //$this->data["title"] = $this->lang->line('Restaurants Details');
		
		$this->data["title"] = $this->data["restaurants"][0]->restaurant_name;
		$this->data["view"] = ADMIN_DIR."restaurants/view_restaurants";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`restaurants`.`status` IN (2) ORDER BY `restaurants`.`order`";
		$data = $this->restaurants_model->get_restaurants_list($where);
		 $this->data["restaurants"] = $data->restaurants;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Restaurants');
		$this->data["view"] = ADMIN_DIR."restaurants/trashed_restaurants";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
        
        $this->restaurants_model->changeStatus($restaurant_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."restaurants/view/".$page_id);
    }
    
    /**
      * function to restor restaurants from trash
      * @param $restaurant_id integer
      */
     public function restore($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
        
        $this->restaurants_model->changeStatus($restaurant_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."restaurants/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft restaurants from trash
      * @param $restaurant_id integer
      */
     public function draft($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
        
        $this->restaurants_model->changeStatus($restaurant_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."restaurants/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish restaurants from trash
      * @param $restaurant_id integer
      */
     public function publish($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
        
        $this->restaurants_model->changeStatus($restaurant_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."restaurants/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Restaurants
      * @param $restaurant_id integer
      */
     public function delete($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        //$this->restaurants_model->changeStatus($restaurant_id, "3");
        //Remove file....
						$restaurants = $this->restaurants_model->get_restaurants($restaurant_id);
						$file_path = $restaurants[0]->restaurant_logo;
						$this->restaurants_model->delete_file($file_path);
		$this->restaurants_model->delete(array( 'restaurant_id' => $restaurant_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."restaurants/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Restaurants
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Restaurants');$this->data["view"] = ADMIN_DIR."restaurants/add_restaurants";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->restaurants_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_logo")){
                       $_POST['restaurant_logo'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_id = $this->restaurants_model->save_data();
          if($restaurant_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."restaurants/edit/$restaurant_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurants/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Restaurants
      */
     public function edit($restaurant_id){
		 $restaurant_id = (int) $restaurant_id;
        $this->data["restaurants"] = $this->restaurants_model->get($restaurant_id);
		  
        $this->data["title"] = $this->lang->line('Edit Restaurants');$this->data["view"] = ADMIN_DIR."restaurants/edit_restaurants";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($restaurant_id){
		 
		 $restaurant_id = (int) $restaurant_id;
       
	   if($this->restaurants_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_logo")){
                         $_POST["restaurant_logo"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_id = $this->restaurants_model->update_data($restaurant_id);
          if($restaurant_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."restaurants/edit/$restaurant_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurants/edit/$restaurant_id");
            }
        }else{
			$this->edit($restaurant_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $restaurant_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
		//get order number of this record
        $this_restaurants_where = "restaurant_id = $restaurant_id";
        $this_restaurants = $this->restaurants_model->getBy($this_restaurants_where, true);
        $this_restaurants_id = $restaurant_id;
        $this_restaurants_order = $this_restaurants->order;
        
        
        //get order number of previous record
        $previous_restaurants_where = "order <= $this_restaurants_order AND restaurant_id != $restaurant_id ORDER BY `order` DESC";
        $previous_restaurants = $this->restaurants_model->getBy($previous_restaurants_where, true);
        $previous_restaurants_id = $previous_restaurants->restaurant_id;
        $previous_restaurants_order = $previous_restaurants->order;
        
        //if this is the first element
        if(!$previous_restaurants_id){
            redirect(ADMIN_DIR."restaurants/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_restaurants_inputs = array(
            "order" => $previous_restaurants_order
        );
        $this->restaurants_model->save($this_restaurants_inputs, $this_restaurants_id);
        
        $previous_restaurants_inputs = array(
            "order" => $this_restaurants_order
        );
        $this->restaurants_model->save($previous_restaurants_inputs, $previous_restaurants_id);
        
        
        
        redirect(ADMIN_DIR."restaurants/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $restaurant_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($restaurant_id, $page_id = NULL){
        
        $restaurant_id = (int) $restaurant_id;
        
        
        
        //get order number of this record
         $this_restaurants_where = "restaurant_id = $restaurant_id";
        $this_restaurants = $this->restaurants_model->getBy($this_restaurants_where, true);
        $this_restaurants_id = $restaurant_id;
        $this_restaurants_order = $this_restaurants->order;
        
        
        //get order number of next record
		
        $next_restaurants_where = "order >= $this_restaurants_order and restaurant_id != $restaurant_id ORDER BY `order` ASC";
        $next_restaurants = $this->restaurants_model->getBy($next_restaurants_where, true);
        $next_restaurants_id = $next_restaurants->restaurant_id;
        $next_restaurants_order = $next_restaurants->order;
        
        //if this is the first element
        if(!$next_restaurants_id){
            redirect(ADMIN_DIR."restaurants/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_restaurants_inputs = array(
            "order" => $next_restaurants_order
        );
        $this->restaurants_model->save($this_restaurants_inputs, $this_restaurants_id);
        
        $next_restaurants_inputs = array(
            "order" => $this_restaurants_order
        );
        $this->restaurants_model->save($next_restaurants_inputs, $next_restaurants_id);
        
        
        
        redirect(ADMIN_DIR."restaurants/view/".$page_id);
    }
    
	
	public function add_food_menu(){
		$restaurant_id = (int) $this->input->post('restaurant_id');
		$restaurant_food_category_id = (int) $this->input->post('restaurant_food_category_id');
		
	  if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                       $_POST['restaurant_food_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->save_data();
          if($restaurant_food_menu_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
               redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
            }
        }else{
			$this->session->set_flashdata("msg_error", "Validation Error");
			redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
			}
	
		
	}
	
	
	public function add_food_category($restaurant_id){
		$restaurant_id = (int) $restaurant_id;
	
			
			 if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                       $_POST['restaurant_food_category_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->save_data();
          if($restaurant_food_category_id){
			  	//just update the result for this restaurant 
			  	$this->db->query("UPDATE `restaurant_food_categories` SET `restaurant_id`='".$restaurant_id."' 
								  WHERE `restaurant_food_category_id`='".$restaurant_food_category_id."'");
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
            }
        }else{
			$this->session->set_flashdata("msg_error", "Validation Error");
			redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
			}
		
	}
	
	
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["restaurants"] = $this->restaurants_model->getBy($where, false, "restaurant_id" );
				$j_array[]=array("id" => "", "value" => "restaurants");
				foreach($data["restaurants"] as $restaurants ){
					$j_array[]=array("id" => $restaurants->restaurant_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
	
	
	
	/**
     * function to send a user to trash
     */
    public function food_menu_trash($restaurant_food_menu_id,$restaurant_id){
        $restaurant_id = (int) $restaurant_id;
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
    }
    
    /**
      * function to restor restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_restore($restaurant_food_menu_id,$restaurant_id){
        $restaurant_id = (int) $restaurant_id;
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_draft($restaurant_food_menu_id,$restaurant_id){
        $restaurant_id = (int) $restaurant_id;
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish restaurant_food_menu from trash
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_publish($restaurant_food_menu_id,$restaurant_id){
        $restaurant_id = (int) $restaurant_id;
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        
        
        $this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Restaurant_food_menu
      * @param $restaurant_food_menu_id integer
      */
     public function food_menu_delete($restaurant_food_menu_id,$restaurant_id){
        $restaurant_id = (int) $restaurant_id;
        $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        //$this->restaurant_food_menu_model->changeStatus($restaurant_food_menu_id, "3");
        //Remove file....
		$restaurant_food_menus = $this->restaurant_food_menu_model->get_restaurant_food_menu($restaurant_food_menu_id);
						$file_path = $restaurant_food_menus[0]->restaurant_food_image;
						if($file_path){
						$this->restaurant_food_menu_model->delete_file($file_path);
						}
		$this->restaurant_food_menu_model->delete(array( 'restaurant_food_menu_id' => $restaurant_food_menu_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."restaurants/view_restaurants/".$restaurant_id);
     }
     //----------------------------------------------------
    
	
public function get_food_edit_form(){
	
	$restaurant_food_menu_id = (int) $this->input->post('id');
	$this->data['restaurant_id'] = $restaurant_id = (int) $this->input->post('restaurant_id');
	
	$this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`restaurant_id` = $restaurant_id");
		
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			$this->data["restaurant_food_categories"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;
		
		}
	
	
	
	 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
        $this->data["restaurant_food_menu"] = $this->restaurant_food_menu_model->get($restaurant_food_menu_id);
		  
    /*$this->data["restaurant_food_categories"] = $this->restaurant_food_menu_model->getList("RESTAURANT_FOOD_CATEGORIES", "restaurant_food_category_id", "restaurant_food_category", $where ="restaurant_food_categories.status IN (0, 1) ");*/
   
		//$this->data["view"] = ADMIN_DIR."restaurant_food_menus/edit_restaurant_food_menu";
        $this->load->view(ADMIN_DIR."restaurant_food_menus/food_edit_form", $this->data);
	
	}
	
	
	 public function update_restaurant_food_data($restaurant_food_menu_id){
		
		 $restaurant_food_menu_id = (int) $restaurant_food_menu_id;
		 $restaurant_id = (int) $this->input->post('restaurant_id');
		 
       
	   if($this->restaurant_food_menu_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_image")){
                         $_POST["restaurant_food_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_menu_id = $this->restaurant_food_menu_model->update_data($restaurant_food_menu_id);
          if($restaurant_food_menu_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."restaurants/view_restaurants/$restaurant_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."restaurants/view_restaurants/$restaurant_id");
            }
        }else{
			
			 redirect(ADMIN_DIR."restaurants/view_restaurants/$restaurant_id");
			}
		 
		 }
		 
public function get_restaurant_food_categorie_edit_form(){
	 $restaurant_id = (int) $this->input->post('restaurant_id');
	 $restaurant_food_category_id = (int) $this->input->post('id');
	 $this->data["restaurant_food_category"] = $this->restaurant_food_category_model->get($restaurant_food_category_id);
	 $this->load->view(ADMIN_DIR."restaurant_food_categories/edit_restaurant_food_category_form", $this->data);
	
	}	

public function update_restaurant_food_categories(){
	
		 
		 $restaurant_food_category_id = (int) $this->input->post('restaurant_food_category_id');
		 $restaurant_id = (int) $this->input->post('restaurant_id');
       
	   if($this->restaurant_food_category_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("restaurant_food_category_image")){
                         $_POST["restaurant_food_category_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $restaurant_food_category_id = $this->restaurant_food_category_model->update_data($restaurant_food_category_id);
          if($restaurant_food_category_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."restaurants/view_restaurants/$restaurant_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(ADMIN_DIR."restaurants/view_restaurants/$restaurant_id");
            }
        }else{
			$this->get_restaurant_food_categorie_edit_form($restaurant_food_category_id);
			}
		 
		 
	}	 
	
   
		
	public function get_food_category_form(){
		
		$this->data['restaurant_id'] = $this->input->post('restaurant_id');
		$this->load->view(ADMIN_DIR."restaurant_food_categories/add_restaurant_food_category_form", $this->data);
		}
	public function get_add_food_with_category_form(){
		$this->data['restaurant_id']= $restaurant_id = $this->input->post('restaurant_id');
		$this->data["restaurant_food_categories_list"] = $this->restaurant_food_menu_model->getList("restaurant_food_categories", "restaurant_food_category_id", "restaurant_food_category", $where ="`restaurant_food_categories`.`status` = 1 and `restaurant_food_categories`.`restaurant_id` =$restaurant_id");
		$query = "SELECT
					DISTINCT (`restaurant_food_categories`.`restaurant_food_category`)
					,`restaurant_food_categories`.`restaurant_food_category_id`
					,`restaurant_food_categories`.`restaurant_id`
				FROM
				`restaurants`,
				`restaurant_food_menus`,
				`restaurant_food_categories`
				WHERE `restaurants`.`restaurant_id` = `restaurant_food_menus`.`restaurant_id`
				AND `restaurant_food_categories`.`restaurant_food_category_id` = `restaurant_food_menus`.`restaurant_food_category_id`
				AND `restaurants`.`restaurant_id`='". $restaurant_id."'
				AND `restaurant_food_menus`.`status` IN (1,0)
				AND `restaurant_food_categories`.`status` IN (1,0)
GROUP BY `restaurant_food_categories`.`restaurant_food_category_id` ORDER BY `restaurant_food_categories`.`restaurant_food_category` ASC ";


				
		$result = $this->db->query($query);		
		$restaurant_food_categories = $result->result();
		
				
		foreach($restaurant_food_categories as $restaurant_food_category){
			$this->data["restaurant_food_categories_list"][$restaurant_food_category->restaurant_food_category_id]=$restaurant_food_category->restaurant_food_category;
		}
		$this->load->view(ADMIN_DIR."/restaurant_food_menus/add_restaurant_food_menu_with_category_form", $this->data);
		}	
		
	public function get_add_food_menu_form(){
		$this->data['restaurant_id'] = $this->input->post('restaurant_id');
		$this->data['restaurant_food_category_id'] = $this->input->post('id');
	$this->load->view(ADMIN_DIR."/restaurant_food_menus/add_restaurant_food_menu_form", $this->data);
		}		
}        

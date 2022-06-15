<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Menu_pages extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/menu_page_model");
		$this->lang->load("menu_pages", 'english');
		$this->load->model("admin/menu_sub_page_model");
		$this->lang->load("menu_sub_pages", 'english');
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
		
        $where = "`menu_pages`.`status` IN (0, 1) ORDER BY `menu_pages`.`order`";
		$this->data["menu_pages"] = $this->menu_page_model->get_menu_page_list($where, FALSE);
		
		foreach($this->data["menu_pages"] as $menu_page){
			$where = "`menu_sub_pages`.`status` IN (0, 1) AND `menu_sub_pages`.`menu_page_id` =".$menu_page->menu_page_id." ORDER BY `menu_sub_pages`.`order`";
			$menu_page->menu_sub_pages = $this->menu_sub_page_model->get_menu_sub_page_list($where, FALSE);
			
			}
		
		
		 $this->data["title"] = $this->lang->line('Menu Pages');
		$this->data["view"] = ADMIN_DIR."menu_pages/menu_pages";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_menu_page($menu_page_id){
        
        $menu_page_id = (int) $menu_page_id;
        
        $this->data["menu_pages"] = $this->menu_page_model->get_menu_page($menu_page_id);
		
        $this->data["title"] = $this->lang->line('Menu Page Details');
		$this->data["view"] = ADMIN_DIR."menu_pages/view_menu_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`menu_pages`.`status` IN (2) ORDER BY `menu_pages`.`order`";
		$data = $this->menu_page_model->get_menu_page_list($where);
		 $this->data["menu_pages"] = $data->menu_pages;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Menu Pages');
		$this->data["view"] = ADMIN_DIR."menu_pages/trashed_menu_pages";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
        
        $this->menu_page_model->changeStatus($menu_page_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
    }
    
    /**
      * function to restor menu_page from trash
      * @param $menu_page_id integer
      */
     public function restore($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
        
        $this->menu_page_model->changeStatus($menu_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."menu_pages/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft menu_page from trash
      * @param $menu_page_id integer
      */
     public function draft($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
        
        $this->menu_page_model->changeStatus($menu_page_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish menu_page from trash
      * @param $menu_page_id integer
      */
     public function publish($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
        
        $this->menu_page_model->changeStatus($menu_page_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Menu_page
      * @param $menu_page_id integer
      */
     public function delete($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        //$this->menu_page_model->changeStatus($menu_page_id, "3");
        
		$this->menu_page_model->delete(array( 'menu_page_id' => $menu_page_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Menu_page
      */
     public function add(){
		
	$query = "SELECT 
				  `pages`.*
				FROM
				  `pages` 
				WHERE `pages`.`page_id` NOT IN  (SELECT `page_id`  FROM `menu_pages`) ;";	
	$query_result = $this->db->query($query);
	$all_page = array();	
	$pages = $query_result->result();	
	foreach($pages as $page){
		$all_page[$page->page_id] = $page->page_name;
		}
	
	$this->data["pages"] = $all_page;	
    
        $this->data["title"] = $this->lang->line('Add New Menu Page');$this->data["view"] = ADMIN_DIR."menu_pages/add_menu_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->menu_page_model->validate_form_data() === TRUE){
		  
		  $menu_page_id = $this->menu_page_model->save_data();
          if($menu_page_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."menu_pages/view");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."menu_pages/view");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Menu_page
      */
     public function edit($menu_page_id){
		 $menu_page_id = (int) $menu_page_id;
        $this->data["menu_page"] = $this->menu_page_model->get($menu_page_id);
		  
    $this->data["pages"] = $this->menu_page_model->getList("PAGES", "page_id", "page_name", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Menu Page');$this->data["view"] = ADMIN_DIR."menu_pages/edit_menu_page";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($menu_page_id){
		 
		 $menu_page_id = (int) $menu_page_id;
       
	   if($this->menu_page_model->validate_form_data() === TRUE){
		  
		  $menu_page_id = $this->menu_page_model->update_data($menu_page_id);
          if($menu_page_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."menu_pages/edit/$menu_page_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."menu_pages/edit/$menu_page_id");
            }
        }else{
			$this->edit($menu_page_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $menu_page_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
		//get order number of this record
        $this_menu_page_where = "menu_page_id = $menu_page_id";
        $this_menu_page = $this->menu_page_model->getBy($this_menu_page_where, true);
        $this_menu_page_id = $menu_page_id;
        $this_menu_page_order = $this_menu_page->order;
        
        
        //get order number of previous record
        $previous_menu_page_where = "order <= $this_menu_page_order AND menu_page_id != $menu_page_id ORDER BY `order` DESC";
        $previous_menu_page = $this->menu_page_model->getBy($previous_menu_page_where, true);
        $previous_menu_page_id = $previous_menu_page->menu_page_id;
        $previous_menu_page_order = $previous_menu_page->order;
        
        //if this is the first element
        if(!$previous_menu_page_id){
            redirect(ADMIN_DIR."menu_pages/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_menu_page_inputs = array(
            "order" => $previous_menu_page_order
        );
        $this->menu_page_model->save($this_menu_page_inputs, $this_menu_page_id);
        
        $previous_menu_page_inputs = array(
            "order" => $this_menu_page_order
        );
        $this->menu_page_model->save($previous_menu_page_inputs, $previous_menu_page_id);
        
        
        
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $menu_page_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($menu_page_id, $page_id = NULL){
        
        $menu_page_id = (int) $menu_page_id;
        
        
        
        //get order number of this record
         $this_menu_page_where = "menu_page_id = $menu_page_id";
        $this_menu_page = $this->menu_page_model->getBy($this_menu_page_where, true);
        $this_menu_page_id = $menu_page_id;
        $this_menu_page_order = $this_menu_page->order;
        
        
        //get order number of next record
		
        $next_menu_page_where = "order >= $this_menu_page_order and menu_page_id != $menu_page_id ORDER BY `order` ASC";
        $next_menu_page = $this->menu_page_model->getBy($next_menu_page_where, true);
        $next_menu_page_id = $next_menu_page->menu_page_id;
        $next_menu_page_order = $next_menu_page->order;
        
        //if this is the first element
        if(!$next_menu_page_id){
            redirect(ADMIN_DIR."menu_pages/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_menu_page_inputs = array(
            "order" => $next_menu_page_order
        );
        $this->menu_page_model->save($this_menu_page_inputs, $this_menu_page_id);
        
        $next_menu_page_inputs = array(
            "order" => $this_menu_page_order
        );
        $this->menu_page_model->save($next_menu_page_inputs, $next_menu_page_id);
        
        
        
        redirect(ADMIN_DIR."menu_pages/view/".$page_id);
    }
	
	
	public function get_sub_menu_form($menu_page_id){
		$this->data['menu_page_id'] = $menu_page_id = (int) $menu_page_id;
		$query = "SELECT 
				  `pages`.*
				FROM
				  `pages` 
				WHERE `pages`.`page_id` NOT IN  (SELECT `page_id`  FROM `menu_sub_pages` WHERE menu_page_id =".$menu_page_id." ) ;";	
	$query_result = $this->db->query($query);
	$all_page = array();	
	$pages = $query_result->result();	
	foreach($pages as $page){
		$all_page[$page->page_id] = $page->page_name;
		}
	
	$this->data["pages"] = $all_page;
	
		$this->load->view(ADMIN_DIR."menu_pages/add_menu_sub_page", $this->data);
		}
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["menu_pages"] = $this->menu_page_model->getBy($where, false, "menu_page_id" );
				$j_array[]=array("id" => "", "value" => "menu_page");
				foreach($data["menu_pages"] as $menu_page ){
					$j_array[]=array("id" => $menu_page->menu_page_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        

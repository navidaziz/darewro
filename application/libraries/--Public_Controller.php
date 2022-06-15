<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Public_Controller extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";
	
    public function __construct(){
		
		 parent::__construct();
		$this->load->helper("my_functions");
		$this->load->model("admin/system_global_setting_model");
		
		  
		 
		 // $this->load->model("admin/menu_page_model");
		 $system_global_setting_id = 1;
		 $fields = "";
		 $join_table = array();
		 $where = "system_global_setting_id = $system_global_setting_id";
		 $this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true)[0];
		 //get menu pages
		 
		/*$where = "`menu_pages`.`status` IN (0, 1) ORDER BY `menu_pages`.`order`";
		$this->data["menu_pages"] = $this->menu_page_model->get_menu_page_list($where, FALSE);
		
		foreach($this->data["menu_pages"] as $menu_page){
			$where = "`menu_sub_pages`.`status` IN (0, 1) AND `menu_sub_pages`.`menu_page_id` =".$menu_page->menu_page_id." ORDER BY `menu_sub_pages`.`order`";
			$menu_page->menu_sub_pages = $this->menu_sub_page_model->get_menu_sub_page_list($where, FALSE);
			
			}*/
		//social media icons 
		/*$this->load->model("admin/social_media_icon_model");
			$where = "`status` IN (1) ORDER BY `order`";
		$this->data["social_media_icons"] = $this->social_media_icon_model->get_social_media_icon_list($where,FALSE);*/
		 		
		

		
		
       
    }
	
    
    
}
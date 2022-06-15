<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller_Mobile extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";
    
    public function __construct(){
        
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
       //var_dump($this->session->all_userdata());
        
        $this->load->helper("form");
        $this->load->helper("my_functions");
        $this->load->library('form_validation');
        $this->load->library("session");
        $this->load->model("user_m");
        $this->load->model("mr_m");
        $this->load->model("module_m");
		
    }
    
    
}
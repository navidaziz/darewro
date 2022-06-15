<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Results extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
       // $this->load->model("admin/album_image_model");
		$this->lang->load("album_images", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		//SELECT COUNT(*) AS total_students FROM `results`;
		//SELECT COUNT(*) AS total_students FROM `results` WHERE `obtain_marks`!='';
		//SELECT COUNT(*) AS total_students FROM `results` WHERE `obtain_marks`='';
		
		
		$query="SELECT COUNT(*) AS total_students FROM `results`";
		$query_result = $this->db->query($query);
		$total_students = $query_result->result()[0]->total_students;
		
		$query="SELECT COUNT(*) AS total_students FROM `results`";
		$query_result = $this->db->query($query);
		$total_students = $query_result->result()[0]->total_students;
		
		$query="SELECT COUNT(*) AS total_fail_students FROM `results` WHERE `obtain_marks`=''";
		$query_result = $this->db->query($query);
		$total_fail_students = $query_result->result()[0]->total_fail_students;
		
		$query="SELECT COUNT(*) AS total_pass_students FROM `results` WHERE `obtain_marks`!=''";
		$query_result = $this->db->query($query);
		$total_pass_students = $query_result->result()[0]->total_pass_students;
		
		echo "$total_pass_students Total Pass %=".($total_pass_students *100/$total_students);
		echo "<br />";
		echo " $total_fail_students Total Fail %=".($total_fail_students *100/$total_students);
		echo "<br />";
		echo "$total_students Total %:".(($total_pass_students *100/$total_students)+($total_fail_students *100/$total_students));
		
		exit();
		
		
        $query="SELECT * FROM results WHERE remarks!=''";
		$query_result = $this->db->query($query);
		$results = $query_result->result();
		
		foreach($results as $result){
			echo $result->remarks."<br />";
			$subjects = explode(",", trim($result->remarks,","));
			foreach($subjects as $index=>$subject){
				/*$this->db->query("INSERT INTO `result_subjects`(`roll_no`, `subject`) 
				VALUES ('".$result->roll_no."','".$subject."')");*/
				}
			
		}
		
    }
    //---------------------------------------------------------------


	
    
}        

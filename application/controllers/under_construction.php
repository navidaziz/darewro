<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Under_construction extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
      
		
        //$this->output->enable_profiler(TRUE);
		
		
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
		echo '<!DOCTYPE html>

<html>
<style>
body, html {
	height: 100%;
	margin: 0;
}
.bgimg {
	background-image: url(\'https://www.w3schools.com//w3images/forestbridge.jpg\');
	height: 100%;
	background-position: center;
	background-size: cover;
	position: relative;
	color: white;
	font-family: "Courier New", Courier, monospace;
	font-size: 25px;
}
.topleft {
	position: absolute;
	top: 0;
	left: 16px;
}
.bottomleft {
	position: absolute;
	bottom: 0;
	left: 16px;
}
.middle {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
}
hr {
	margin: auto;
	width: 40%;
}
</style>

<body>
<div class="bgimg">
  <div class="topleft">
    <p></p>
  </div>
  <div class="middle">
    <h1>COMING SOON</h1>
    <hr>
    <p></p>
  </div>
  <div class="bottomleft">
    <p></p>
  </div>
</div>
</body>
</html>
';
		
    }
  
    
}        

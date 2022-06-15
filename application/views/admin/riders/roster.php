<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <!--<div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>-->
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-motorcycle"></i> Off Duty Riders</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table" id="offline_riders">
            <thead>
              <tr>
              <th>#</th>
              <th>Rider Name</th>
              <th>Timing</th>
              <th>Hours</th>
              <th>Live</th>
            </tr>
            </thead>
            <tbody>
            <?php 
		$count=1;
		foreach($off_duty_riders as $off_duty_riders){
			$next_day=0;
			  $day = date("d-m-y", time());
			  $duty_start = date("d-m-y h a", strtotime($day." ".$off_duty_riders->duty_start.":00:00"));
			
			if($off_duty_riders->duty_end>23){
				$day = date("d-m-y", strtotime("+ 1 day"));
				$duty_end = date("d-m-y h a", strtotime($day." ".($off_duty_riders->duty_end-24).":00:00"));
				$next_day=1;
			}else{
				
				$duty_end = date("d-m-y h a", strtotime($day." ".$off_duty_riders->duty_end.":00:00"));
				}
				
					
			 ?>
            <tr <?php if($off_duty_riders->is_available==1){ ?> style="text-decoration: line-through; color:green !important" <?php } ?>>
              <td><?php echo $count++; ?></td>
              <td> <?php echo ucwords(strtolower($off_duty_riders->rider_name)); ?></td>
              <td><?php echo date("h A", strtotime($duty_start)); 
				//echo $duty_start;
				?> - <?php echo date("h A", strtotime($duty_end));
				//echo $duty_end;
				if($next_day){
					echo '<span style="font-size:9px; color:red;"> Next Day</span>';
					}
				
				
				 ?></td>
              <td><?php
			  
			  echo (abs(strtotime($duty_start) - strtotime($duty_end))/3600);
			   ?></td>
              <td>
            
              <form id="avaliable_form_<?php echo $off_duty_riders->rider_id;  ?>" action="<?php echo site_url(ADMIN_DIR."riders/make_avaliable/".$off_duty_riders->rider_id); ?>" method="post">
            
              <input onclick="$('#avaliable_form_<?php echo $off_duty_riders->rider_id;  ?>').submit();" name="avaliable" type="radio" value="1" />
              </form>
             
              </td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-motorcycle"></i> On Duty Riders</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        <table class="table" id="online_riders">
        <thead>
            <tr>
              <th>#</th>
              <th>Rider Name</th>
              <th>Timing</th>
              <th>Hours</th>
              <th>Off Line</th>
              
            </tr>
            </thead>
             <tbody>
            <?php 
		$count=1;
		foreach($on_duty_riders as $on_duty_riders){
			$next_day=0;
			  $day = date("d-m-y", time());
			  $duty_start = date("d-m-y h a", strtotime($day." ".$on_duty_riders->duty_start.":00:00"));
			
			if($on_duty_riders->duty_end>23){
				$day = date("d-m-y", strtotime("+ 1 day"));
				$duty_end = date("d-m-y h a", strtotime($day." ".($on_duty_riders->duty_end-24).":00:00"));
				$next_day=1;
			}else{
				
				$duty_end = date("d-m-y h a", strtotime($day." ".$on_duty_riders->duty_end.":00:00"));
				}
			 ?>
            <tr<?php if($on_duty_riders->is_available==1){ ?> style="color:green !important;" <?php } ?>>
              <td><?php echo $count++; ?></td>
             <td> <?php echo ucwords(strtolower($on_duty_riders->rider_name)); ?></td>
              
              <td><?php echo date("h A", strtotime($duty_start)); 
				//echo $duty_start;
				?> - <?php echo date("h A", strtotime($duty_end));
				//echo $duty_end;
				if($next_day){
					echo '<span style="font-size:9px; color:red;"> Next Day</span>';
					}
				
				
				 ?></td>
               <td><?php
			  
			  echo (abs(strtotime($duty_start) - strtotime($duty_end))/3600);
			   ?></td>
              <td>
              <?php   if($on_duty_riders->is_available==0){ ?>
              <form id="leave_form_<?php echo $on_duty_riders->rider_id;  ?>" action="<?php echo site_url(ADMIN_DIR."riders/assign_leave/".$on_duty_riders->rider_id); ?>" method="post">
            
             <input onclick="$('#leave_form_<?php echo $on_duty_riders->rider_id;  ?>').submit();" name="leave" type="radio" value="1" />
              </form>
              <?php } ?>
              
               <?php   if($on_duty_riders->is_available==1){ ?>
              <form id="un_available_<?php echo $on_duty_riders->rider_id;  ?>" action="<?php echo site_url(ADMIN_DIR."riders/make_un_available/".$on_duty_riders->rider_id); ?>" method="post">
            <i class="fa fa-times fa-fw" style=" cursor: pointer;" onclick="$('#un_available_<?php echo $on_duty_riders->rider_id;  ?>').submit();"></i>
            
              </form>
              <?php } ?>
              </td>
              
            </tr>
            <?php } ?>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
  <!--<div class="col-md-4">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-times fa-fw"></i> On Leave Riders</h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
        
        <table class="table">
            <tr>
              <th>#</th>
              <th>Rider Name</th>
              <td>Timing</td>
              <th>Present</th>
            </tr>
            <?php 
		$count=1;
		foreach($on_leave_riders as $on_leave_riders){
			$duty_start = date("h a", strtotime("00-00-00 ".$on_leave_riders->duty_start.":00:00"));
			if($on_duty_riders->duty_end>24){
				$duty_end = date("h a", strtotime("00-00-00 ".($on_leave_riders->duty_end-24).":00:00"));
			}else{
				$duty_end = date("h a", strtotime("00-00-00 ".$on_leave_riders->duty_end.":00:00"));
				}
			 ?>
            <tr<?php if($on_leave_riders->is_available==1){ ?> style="color:green !important;" <?php } ?>>
              <td><?php echo $count++; ?></td>
              <td > <?php echo $on_leave_riders->rider_name; ?> </td>
             <td><?php echo $duty_start." - ".$duty_end; ?></td>
              <td>
              
              <form id="present_<?php echo $on_leave_riders->rider_id;  ?>" action="<?php echo site_url(ADMIN_DIR."riders/make_present/".$on_leave_riders->rider_id); ?>" method="post">
            <i class="fa fa-times fa-fw" style=" cursor: pointer;" onclick="$('#present_<?php echo $on_leave_riders->rider_id;  ?>').submit();"></i>
             
              </form>
              
              </td>
            </tr>
            <?php } ?>
          </table>
        
        
         
        </div>
      </div>
    </div>
  </div>-->
  
  <!-- /MESSENGER --> 
</div>


<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />


<script>
$(document).ready(function(){
  $('#online_riders').DataTable({
                "bPaginate": false
            });
});

$(document).ready(function(){
  $('#offline_riders').DataTable({
                "bPaginate": false
            });
});
</script>
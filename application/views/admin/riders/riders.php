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
        <div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="rider_table">
            <thead>
              <tr>
              <th>#</th>
              <th>Rider ID</th>
              <th><?php echo $this->lang->line('rider_image'); ?></th>
                <th><?php echo $this->lang->line('rider_name'); ?></th>
               
                <th><?php echo $this->lang->line('office_no'); ?></th>
                <th><?php echo $this->lang->line('personal_no'); ?></th>
                <th><?php echo $this->lang->line('duty_start'); ?></th>
                <th><?php echo $this->lang->line('duty_end'); ?></th>
                <th><?php echo 'Total Hour\'s'; ?></th>
               <!-- <th><?php echo $this->lang->line('is_available'); ?></th>
                <th><?php echo $this->lang->line('is_absent'); ?></th>-->
                <th><?php echo $this->lang->line('ability_level'); ?></th>
                <th><?php echo $this->lang->line('comments'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count=1;
			  foreach($riders as $rider): 
			  $next_day=0;
			  $day = date("d-m-y", time());
			  $duty_start = date("d-m-y h a", strtotime($day." ".$rider->duty_start.":00:00"));
			
			if($rider->duty_end>23){
				$day = date("d-m-y", strtotime("+ 1 day"));
				$duty_end = date("d-m-y h a", strtotime($day." ".($rider->duty_end-24).":00:00"));
				$next_day=1;
			}else{
				
				$duty_end = date("d-m-y h a", strtotime($day." ".$rider->duty_end.":00:00"));
				}
			  
			  
			  ?>
              <tr>
              <td><?php echo $count++;  ?></td>
              <td><?php echo $rider->rider_id; ?></td>
              <td><?php
                echo file_type(base_url("assets/uploads/".$rider->rider_image),false, 20,20);
            ?></td>
                <td><?php echo  ucwords(strtolower($rider->rider_name)); ?></td>
                
                <td><?php echo $rider->office_no; ?></td>
                <td><?php echo $rider->personal_no; ?></td>
                <td>
                <?php echo date("h A", strtotime($duty_start)); 
				//echo $duty_start;
				?>
                </td>
                <td>
				<?php echo date("h A", strtotime($duty_end));
				//echo $duty_end;
				if($next_day){
					echo '<span style="font-size:9px; color:red;"> Next Day</span>';
					}
				
				
				 ?></td>
                <td>
				
				
				
				<?php
			  
			  echo (abs(strtotime($duty_start) - strtotime($duty_end))/3600);
			   ?></td>
               <!-- <td><?php echo $rider->is_available; ?></td>
                <td><?php echo $rider->is_absent; ?></td>-->
                <td><?php echo $rider->ability_level; ?></td>
                <td><?php echo $rider->comments; ?></td>
                <td><?php echo status($rider->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($rider->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."riders/publish/".$rider->rider_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($rider->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."riders/draft/".$rider->rider_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."riders/view_rider/".$rider->rider_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."riders/edit/".$rider->rider_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."riders/trash/".$rider->rider_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php //echo $pagination; ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>


<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />

<script>
$(document).ready(function(){
  $('#rider_table').DataTable({
                "bPaginate": false
            });
});
</script>
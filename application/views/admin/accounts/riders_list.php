<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
         <i class="fa fa-home"></i> 
         <li>
        <a href="<?php echo site_url(ADMIN_DIR."accounts/account_modules/"); ?>">Account Home</a>
         </li>
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
                <!-- <th><?php echo $this->lang->line('rider_image'); ?></th>-->
                <th><?php echo $this->lang->line('rider_name'); ?></th>
                <th><?php echo $this->lang->line('office_no'); ?></th>
                <th><?php echo $this->lang->line('personal_no'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count=1;
			  foreach($riders as $rider): 
			  
			  
			  ?>
              <tr>
                <td><?php echo $count++;  ?></td>
                <!--<td><?php
                echo file_type(base_url("assets/uploads/".$rider->rider_image),false, 20,20);
            ?></td>-->
                <td><a href="<?php echo site_url(ADMIN_DIR."accounts/rider_riders/")."/".$rider->rider_id; ?>" > <?php echo  ucwords(strtolower($rider->rider_name)); ?> </a></td>
                <td><?php echo $rider->office_no; ?></td>
                <td><?php echo $rider->personal_no; ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php //echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


<script>
$(document).ready(function(){
  $('#rider_table').DataTable({
               
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ]
            
            });
});
</script>
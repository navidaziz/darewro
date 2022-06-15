<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <i class="fa fa-table"></i>
        <li> <a href="<?php echo site_url(ADMIN_DIR."accounts/account_modules/"); ?>">Accounts</a> <i class="fa fa-table"></i>
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
        
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <div class="col-md-12" >
    <div class="box border blue" id="messenger" style="background:#FFF; padding:5px">
      <form class="form-horizontal" method="post" action="<?php echo site_url(ADMIN_DIR."accounts/staff_report")."/" ?>" >
        <table>
          
            <td>Select Date</td>
            <td>
              <input class="form-control" type="date" name="date" required="required" /></td>
         
         
            <td><input class="btn btn-primary btn-sm" type="submit" /></td>
        </table>
      </form>
    </div>
  </div>
</div>
<div class="row"> 
  
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="ta ble table-bo rdered display dataTable" id="staff_report"  style="font-size:10px !important;">
            <thead>
              <tr>
                <th>Staff Name</th>
                <th>Role</th>
                <th>Order Registered</th>
                <th>Order Placed</th>
                <th>Order Cancelled</th>
                <th>Order Edit</th>
                <th>Order Forwarded</th>
              </tr>
            </thead>
            <tbody>
              <?php 
        
        
        foreach($staff_report as $role){
		
		?>
              <?php   foreach($role->users as $user){ ?>
              <tr>
                <td><?php echo $user->user_title ?></td>
                <td><?php echo $role->role_title; ?></td>
                <td><?php echo $user->register_orders ?></td>
                <td><?php echo $user->placed_orders ?></td>
                <td><?php echo $user->cancelled_orders ?></td>
                <td><?php echo $user->edited_orders ?></td>
                <td><?php echo $user->assigned_orders ?></td>
              </tr>
              <?php }  ?>
              <?php } ?>
            </tbody>
          </table>
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
  $('#staff_report').DataTable({
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ]
            });
});

</script> 
<script>
document.title = "<?php echo $title; ?>";
</script>
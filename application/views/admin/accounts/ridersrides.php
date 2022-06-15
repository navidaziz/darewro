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
        <li> <a href="<?php echo site_url(ADMIN_DIR."accounts/account_modules/"); ?>">Account Home</a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-3">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-9">
          <form class="form-horizontal" method="post" action="<?php echo site_url(ADMIN_DIR."accounts/riders_rides") ?>" >
            <table class="pull-right">
              
                <td>Filter:</td>
                <td><input class="form-control" type="date" name="date" /></td>
                <td><input class="btn btn-primary btn-sm" type="submit" /></td>
            </table>
          </form>
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
          <?php 
			  $count=1;
			 foreach($rider_rides as $year => $months) {
				 echo "<h3>".$year."</h3>";
				 foreach($months as $month => $days){
					  echo "<h4>".$month."</h4>";
					  ?>
          <table class="ta ble table-bo rdered display dataTable" id="riders_rides"  style="font-size:11px !important;">
            <thead>
              <tr>
                <td colspan="10"></td>
              </tr>
              <tr> 
                <!-- <th>#</th>-->
                <th>Date</th>
                <th>Cancelled</th>
                <th>Delivered</th>
                <th>Total Orders</th>
                <th>Total Delivery Charges (Rs)</th>
                <th>Duty Timing</th>
                <th>Hour's</th>
                <th>On Duty Timing</th>
                <th>Duty Hour's</th>
              </tr>
            </thead>
            <tbody>
              <?php   
					 foreach($days as $day => $rider_ride){
						
					?>
              <tr> 
                <!--<td><?php echo $count++;  ?></td>-->
                <td><?php echo date("d M, Y", strtotime($rider_ride['date']));  ?></td>
                <td><a href="javascript: return false;" onclick="get_rider_orders('<?php echo $rider_id; ?>', 'cancelled', '<?php echo $rider_ride['date'];?>')"><?php echo $rider_ride['rider_total_cancel_orders']; ?></a></td>
                <td><a href="javascript: return false;" onclick="get_rider_orders('<?php echo $rider_id; ?>', 'delivered', '<?php echo $rider_ride['date'];?>')"><?php echo $rider_ride['rider_total_delivered_orders']; ?></a></td>
                <td><a href="javascript: return false;" onclick="get_rider_orders('<?php echo $rider_id; ?>', 'all', '<?php echo $rider_ride['date'];?>')"><?php echo $rider_ride['total_orders']; ?></a></td>
                <td><?php echo $rider_ride['rider_total_delivery_charge']; ?></td>
                <td><?php 
				if($rider_ride['duty_start_time']){ 
				echo @date('h:i A', strtotime($rider_ride['duty_start_time'][0]->timing))." To "; }
				 ?>
                  <?php 
				if($rider_ride['duty_end_time']){
					echo @date('h:i A', strtotime($rider_ride['duty_end_time'][0]->timing));
				}
				 ?></td>
                <td><?php echo @$rider_ride['duty_hours']; ?></td>
                <td><?php 
				$timing = array();
				if($rider_ride['rider_timings']){
				foreach($rider_ride['rider_timings'] as $rider_timing){ 
				
				$timing[strtotime($rider_timing->timing)] = $rider_timing->timing;
				
				?>
                  <?php } 
				  ksort($timing);
				 // var_dump($timing);
				  echo date('h:i A', strtotime(reset($timing)))." To ".date('h:i A', strtotime(end($timing))); 
				  
				}?></td>
                <td><?php 
				   if(@$rider_ride['on_duty_hours']){
				   
				   echo @$rider_ride['on_duty_hours']; ?>
                  <?php if(@$rider_ride['on_duty_hours']<$rider_ride['duty_hours']){ ?>
                  <i class="fa fa-sort-desc" style="color:red"></i>
                  <?php } ?>
                  <?php if(@$rider_ride['on_duty_hours']>$rider_ride['duty_hours']){ ?>
                  <i class="fa fa-sort-asc" style="color:green"></i>
                  <?php } 
				  
				   }?></td>
              </tr>
              <?php
					 }
					 ?>
            </tbody>
          </table>
          <?php       
				 }
			 }
			  
			  ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script>
function get_rider_orders(rider_id, get_orders, date){
	$('#rider_order_list').html('');
	if(get_orders=='all'){
		 $('#order_title').html("Rider All Orders");
		 if(rider_id==0){
			 $('#order_title').html("All Orders Orders");
			 }
	}
	if(get_orders=='unplaced'){
		 $('#order_title').html("Unplaced Orders");
		 if(rider_id==0){
			 $('#order_title').html("All UnPlaced Orders");
			 }
	}
	
	if(get_orders=='ready'){
		 $('#order_title').html("Ready Orders");
		 if(rider_id==0){
			 $('#order_title').html("All Ready Orders");
			 }
	}
	
	if(get_orders=='running'){
		 $('#order_title').html("Running Orders");
		 if(rider_id==0){
			 $('#order_title').html("All Running Orders");
			 }
	}
	
	
	
	if(get_orders=='cancelled'){
		 $('#order_title').html("Rider Cancelled Orders");
		 if(rider_id==0){
			 $('#order_title').html("All Cancelled Orders");
			 }
		}
	
	if(get_orders=='delivered'){
		 $('#order_title').html("Rider Delivered Orders");
		 if(rider_id==0){
			 $('#order_title').html("All Delivered Orders");
			 }
		}
	
	$.ajax({
        type: "POST",
        url: site_url + "/accounts/get_rider_orders/",
        data: {
			rider_id:rider_id,get_orders:get_orders, date:date
			}
    }).done(function(data) {

        $('#rider_order_list').html(data);
    });

    $('#riders_orders_model').modal('toggle');
	
	$('#order_table').DataTable({
                paging: false,
				retrieve: true,
            });
		
	}
</script>
<div class="modal" id="riders_orders_model" data-backdrop="static"  >
  <div class="modal-dialog" style="width:90% !important" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="order_title"></h4>
      </div>
      <div class="modal-body" id="rider_order_list"> </div>
      <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> 
<script>
$(document).ready(function(){
  $('#riders_rides').DataTable({
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ]
            });
});
</script> 
<script>
document.title = "<?php echo 'Date: '.date("d F, Y", strtotime($date)); ?>";
</script>
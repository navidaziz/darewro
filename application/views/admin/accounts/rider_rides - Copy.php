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
			<li>	<a href="<?php echo site_url(ADMIN_DIR."accounts/riders/"); ?>"><?php echo $this->lang->line('Riders'); ?></a>
                 <i class="fa fa-table"></i>
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
        <div class="col-md-9"> </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row">




  <div class="col-md-12" >
    <div class="box border blue" id="messenger" style="background:#FFF; padding:5px">
      <h5>From<strong> <?php echo date("d F, y", strtotime($start_date)); ?></strong> To <strong> <?php echo date("d F, y", strtotime($end_date)); ?></strong></h5>
      
    </div>
  </div>
  <div class="col-md-4">
	<div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> <?php echo "Rider Information" ?></h4>
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($riders as $rider): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('rider_name'); ?></th>
                <td>
                    <?php echo $rider->rider_name; ?>
                </td>
            </tr>
            <tr>
                <th>Rider Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$rider->rider_image));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('office_no'); ?></th>
                <td>
                    <?php echo $rider->office_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('personal_no'); ?></th>
                <td>
                    <?php echo $rider->personal_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('duty_start'); ?></th>
                <td>
                    <?php echo $rider->duty_start; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('duty_end'); ?></th>
                <td>
                    <?php echo $rider->duty_end; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('is_available'); ?></th>
                <td>
                    <?php echo $rider->is_available; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('is_absent'); ?></th>
                <td>
                    <?php echo $rider->is_absent; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('ability_level'); ?></th>
                <td>
                    <?php echo $rider->ability_level; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('comments'); ?></th>
                <td>
                    <?php echo $rider->comments; ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($rider->status); ?>
                                </td>
                            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
  <!-- MESSENGER -->
  <div class="col-md-8">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <form class="form-horizontal" method="post" action="<?php echo site_url(ADMIN_DIR."accounts/rider_riders")."/$rider_id" ?>" >
            <table class="pull-right">
              
                <td>Filter:</td>
                 <td>
                 Start Date: 
                 <input class="form-control" type="date" name="start_date" required="required" /></td>
                <td>
                 End Date: 
                <input class="form-control" type="date" name="end_date"  required="required" /></td>
                <td><input class="btn btn-primary btn-sm" type="submit" /></td>
            </table>
          </form>
          <table class="table table-bordered" id="rider_rides">
            <thead>
              <tr>
                <th>#</th>
                
                <th>Date</th>
                <th>Total Orders</th>
                <th>Total Delivery Charges (Rs)</th>
                
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count=1;
			 foreach($rider_rides as $rider_ride){ ?>
              <tr>
                <td><?php echo $count++;  ?></td>
               <td><?php echo $rider_ride->formated_date;  ?></td>
                <td><a href="javascript: return false;" onclick="get_rider_orders('<?php echo $rider_id; ?>', 'delivered', '<?php echo  $rider_ride->created_date ?>')"><?php echo $rider_ride->rider_total_delivered_orders; ?></a></td>
                
                <td><?php echo $rider_ride->rider_total_delivered_order_charges; ?></td>
                
              </tr>
              <?php } ?>
             <tfoot><tr>
             <td colspan="2">Total</td>
             <td><?php echo $rider_total_delivered; ?></td>
             <td><?php echo $rider_total_chages; ?></td>
             </tr>
             </tfoot>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>


<script>
function get_rider_orders(rider_id, get_orders,date){
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

<script>
$(document).ready(function(){
  $('#rider_rides').DataTable({
                "bPaginate": false,
				
            });
});
</script>
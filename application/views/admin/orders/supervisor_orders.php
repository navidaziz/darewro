<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/count_down/jquery.countdown.js"></script>


<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 20px !important;">
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div style=" background-color:#FBFBFB; min-height:40px; margin-bottom:10px;">
          <table width="100%">
            <tr>
              <td width="250" valign="top"><input style="margin:5px;" onkeypress="on_enter_press_search()" type="text" name="search" value="" id="search" class="form-control pull-left"  required="" title="Mobile No" placeholder="Search Order By Mobile No...." /></td>
              <td width="10" valign="top"><input onClick="on_click_search_button()" type="button" class="btn btn-link pull-left" value="Search" style="margin:5px;"></td>
              <td id="search_order_detail"></td>
            </tr>
          </table>
        </div>
        <div class="table-responsive">
       <?php   
	     $order_last_id = 0;
		 $count=1;
	   foreach($supervisor_tags as $supervisor_tag){ ?>
       <h5 style="text-align:center;"><span class="label label-danger label-sm"><?php if($supervisor_tag->supervisor_tag!='#'){ ?> # <?php } ?> <?php echo  $supervisor_tag->supervisor_tag; ?></span></h5>
          <table class="table table-bordered" <?php if($count==1){ ?>id="order_table" <?php } ?> style="margin-top:2px;">
            <thead>
              <tr> 
                <!-- <th>#</th>-->
                <th></th>
                <th></th>
                <th>ID</th>
                <th width="300"><?php echo $this->lang->line('order_detail'); ?></th>
                <th>Address</th>
                <th>Rs:</th>
                <th width="80">Ready T:</th>
                <th width="91">Delivery T:</th>
                <th>Customer</th>
                <?php  if($order_status>=3){ ?>
                <th>Assigned Rider</th>
                <?php } ?>
                <th>#tag</th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  
			
			  
			  
			 
			  
			  foreach($supervisor_tag->orders as $order): ?>
              <?php 
			  
			   
			  
			  
			  
			  if($order_last_id < $order->order_id){  $order_last_id = $order->order_id;  } ?>
              <tr id="order_row_<?php echo $order->order_id; ?>" > 
                <!--<td><?php echo $count++; ?></td>-->
                <td><?php if($order->mobile_or_call=='Call'){ ?>
                  <i class="fa fa-phone" title="<?php echo $order->mobile_or_call; ?>" aria-hidden="true"></i>
                  <?php }else{?>
                  <i class="fa fa-mobile" title="<?php echo $order->mobile_or_call; ?>" aria-hidden="true"></i>
                  <?php } ?></td>
                <td><?php if($order->order_type=='Food Order'){ ?>
                  <i style="color:#F33" title="<?php echo $order->order_type; ?>" class="fa fa-cutlery" aria-hidden="true"></i>
                  <?php }else{?>
                  <i title="<?php echo $order->order_type; ?>" class="fa fa-shopping-bag" aria-hidden="true"></i>
                  <?php } ?></td>
                <td><?php echo $order->order_id; ?></td>
                <td><?php echo strip_tags(substr($order->order_detail,0,100))." ... <span class=\"btn btn-link\" onclick=\"open_model('".$order->order_id."')\" style=\"display:inline\">Read More</span>"; ?></td>
                <td><strong>Picking:</strong> <em><?php echo $order->order_picking_address; ?></em><br />
                  <strong>Delivery:</strong> <em><?php echo $order->order_drop_address; ?></em></td>
                <td><?php echo $order->delivery_charges; ?></td>
                <td><?php  if($order_status>1){?>
                  <?php if($order->order_type=='Food Order'){ ?>
                  <?php if(strtotime($order->order_ready_time)<time()){
					 echo "<span style=\"color:red\">".ucwords(get_timeago($order->order_ready_time))."<span>";
				 }else{?>
                  <em title=" <?php echo date('j M,y g:i A', strtotime($order->order_ready_time)); ?>" id="order_ready_time_<?php echo $order->order_id; ?>"></em> 
                  <script type="text/javascript">
  $('#order_ready_time_<?php echo $order->order_id; ?>').countdown('<?php echo $order->order_ready_time; ?>', function(event) {
   // $(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
	$(this).html(event.strftime('%H:%M:%S'));
  });
</script>
                  <?php }?>
                  <?php }else{
					echo '<span style="color:green">Ready...</span>';
					} ?>
                  <?php }else{?>
                  Unplaced
                  <?php } ?>
                  <?php //echo $order->order_ready_time; ?></td>
                <td><em title=" <?php echo date('j M,y g:i A', strtotime($order->delivery_time)); ?>"><?php echo date('j M,y g:i A', strtotime($order->delivery_time)); ?></em>
                  <?php if($order_status==2){ ?>
                  <script type="text/javascript">
  /*$('#order_delivery_time_<?php echo $order->order_id; ?>').countdown('<?php echo $order->delivery_time; ?>', function(event) {
   // $(this).html(event.strftime('%w weeks %d days %H:%M:%S'));
   //console.log(event.offset);
    if(event.offset.hours!=0 && event.offset.minutes!=0 && event.offset.seconds!=0){
		if(event.offset.hours==0 && event.offset.minutes<15){
			$('#order_delivery_time_<?php echo $order->order_id; ?>').css('background-color', '#6C3');
			$('#order_delivery_time_<?php echo $order->order_id; ?>').html(event.strftime('%H:%M:%S'));
		}else{
			$('#order_delivery_time_<?php echo $order->order_id; ?>').html(event.strftime('%H:%M:%S'));
		}
	}else{
		$('#order_row_<?php echo $order->order_id; ?>').css('color', '#FF0000');
		//$('#order_row_<?php echo $order->order_id; ?>').css('color', '#FFF');
	    $('#order_delivery_time_<?php echo $order->order_id; ?>').html('Need To Deliver');	
		}
  });*/
</script>
                  <?php } ?></td>
                <td><?php echo $order->customer_name; ?><br />
                  <em><?php echo $order->mobile_number; ?></em></td>
                <?php  if($order_status>=3){ ?>
                <td><?php  if($order->rider_id){ 
				   $query="SELECT `rider_name`,`office_no`,`personal_no` FROM `riders` WHERE `rider_id`=".$this->db->escape($order->rider_id);
				   $query_result = $this->db->query($query);
				   if($query_result->result()){
				   $rider = $query_result->result()[0];
				   echo "<strong>".$rider->rider_name."</strong><br />";
				   echo "<em>".$rider->office_no.'</em><br /><button class="btn btn-link pull-right" onclick="open_model_reassign_rider(\''.trim($order->order_id).'\')">Reassign Rider</button>';
				    } 
				   }?></td>
                <?php } ?>
                <td>
                <form  method="post" action="<?php echo site_url(ADMIN_DIR."orders/tag_order/$order->order_id"); ?>" >
                <input required="required" id="submit_on_enter" type="text" name="order_tag" style="width:70px !important" value="<?php echo $order->supervisor_tag; ?>" />
                <input type="submit" hidden />
                </form></td>
                <td><button class="btn btn-link" onclick="open_model('<?php echo $order->order_id; ?>')">View Detail</button></td>
              </tr>
              <?php endforeach; ?>
              
            </tbody>
          </table>
          <?php } ?>
          <?php echo $pagination; ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<input type="hidden" name="order_last_id" id="order_last_id" value="<?php echo $order_last_id; ?>" />
<input type="hidden" name="order_status_id" id="order_status_id" value="<?php echo $order_status; ?>" />
<script>

window.setInterval(function(){ 
    var order_last_id = $('#order_last_id').val();
	var order_status_id = $('#order_status_id').val();
	//alert(order_last_id);
	$.ajax({ type: "POST",
			 url: site_url+"/orders/get_new_orders/"+order_last_id+"/"+order_status_id,
			 data:{}}).done(function(data){
				// alert(data);
				
				 data = jQuery.parseJSON(data);
				 if(data){
				  for(var i in data) {
					  var new_row = '';
					   var counter = data[i];
					    $('#order_last_id').val(counter.order_id);
					   //order_last_id = $('#order_last_id').val();
					   //if(counter.order_id>order_last_id){  }
					    new_row+='<tr onclick="this.attr(\"style\",\"background-color: none\");" style="background-color:#ffe5e5;">';
					   new_row+='<td>';
						if(counter.mobile_or_call=='Call'){ new_row+='<i class="fa fa-phone" aria-hidden="true"></i>'; }else{
							new_row+='<i class="fa fa-mobile" aria-hidden="true"></i>';
							}
						new_row+='</td>';
					   
					   new_row+='<td>';
						if(counter.order_type=='Food Order'){ new_row+='<i title="'+counter.order_type+'" class="fa fa-shopping-bag" aria-hidden="true"></i>'; 
						
						}
						if(counter.order_type=='General Order'){ new_row+='<i title="'+counter.order_type+'" class="fa fa-shopping-bag" aria-hidden="true"></i>';
						}
						new_row+='</td>';
						
						
					   
						new_row+='<td>'+counter.order_id+'</td>';
						
						
							
						
						new_row+='<td>'+strip(counter.order_detail)+'<span class=\"btn btn-link\" onclick=\"open_model(\''+counter.order_id+'\')\" style="display:inline">Read More...</span></td>'; 
						new_row+='<td><strong>Packing:</strong> <em>'+counter.order_picking_address+'</em><br /><strong>Delivery:</strong> <em>'+counter.order_drop_address+'</em></td><td>'+counter.delivery_charges+'</td><td>'+counter.order_ready_time+'</td><td>'+counter.delivery_time+'</td>';
						
						 new_row+='<td>'+counter.customer_name+'</td>'
						 
						 new_row+='<td><form  method="post" action="<?php echo site_url(ADMIN_DIR."orders/tag_order/"); ?>/'+counter.order_id+'" ><input required="required" id="submit_on_enter" type="text" name="order_tag" style="width:70px !important" value="#" /><input type="submit" hidden /></form></td>';
						 
						new_row+='<td><button class="btn btn-link" onclick="open_model(\''+counter.order_id+'\')">View Detail</button></td></tr>';
						 
						//new_row+='</td></tr>';  
					   $("#order_table tbody").prepend(new_row).show('slow');;
				  }
				 }
				 
				});	
 }, 10000);
 

</script>
<div class="modal" id="order_view" data-backdrop="static" >
  <div class="modal-dialog" style="width:99%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="order_view_title"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span id="orderId"></span> Order Detail</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="list-group">
                  <div class="list-group-item profile-details">
                    <div id="receipt" style="display:none" > </div>
                    <h4><!--<i class="fa fa-user fa-fw"></i>--> <span id="customer_name"></span> (<span id="customer_mobile_no"></span>) <span class="pull-right" style="margin-top:-10px"><a class="btn btn-small btn-link" id="print_button" onclick="javascript:print_receipt('PrintOrder');"> <i class="fa fa-print"></i> Print</a></span> </h4>
                    <p> <i class="fa fa-circle text-green"></i> <span id="order_status"></span> <span id="order_type" class="pull-right"></span> </p>
                    <p>
                    <span>
                    <h5><i class="fa fa fa-money fa-fw"></i> Delivery Charges: <strong><span id="delivery_charges">150</span> Rs</strong></h5>
                    </span>
                    </p>
                    <p id="order_detail" style="min-height:100px; border:1px solid #CCC; border-radius:5px; padding:5px;"></p>
                    <address>
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Picking Location: </strong> <span id="pickinglocation">Picking Location</span> <br />
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Delivery Location: </strong> <span id="deliverylocation">Delivery Location</span>
                    </address>
                    <p><em>Registered by <strong><span id="created_by">CSR Name</span></strong> Through <strong><span id="mobile_or_call">Mobile / Call</span></strong> on <strong><span id="order_date_time">0000-00-00 00:00:00</span></strong> </em></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <ul style="border:1px solid #CCC; list-style:none; padding-left:0px; border-radius:5px;">
                  <li><i class="fa fa-user fa-fw"></i> Order on the name: <span id="orderer_name"> Order on the name</span></li>
                  <li><i class="fa fa-clock-o fa-fw"></i> Order Placed: <span id="order_place_time"> 0000-00-00 00:00:00</span></li>
                  <li><i class="fa fa-check fa-fw"></i> Order Ready: <span id="order_ready_time"> 0000-00-00 00:00:00</span></li>
                </ul>
                <ul style="border:1px solid #CCC; list-style:none; padding-left:0px; border-radius:5px;">
                  <li><i class="fa fa-cog fa-fw"></i> Expected Delivery: <span id="delivery_time">0000-00-00 00:00:00</span></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul style="border:1px solid #CCC; list-style:none; padding-left:0px; border-radius:5px;">
                  <li><i class="fa fa-user fa-fw"></i> Rider: <span id="rider_name">Rider Name</span></li>
                  <li><i class="fa fa-calendar fa-fw"></i> Assigned: <span id="order_rider_assign_time">0000-00-00 00:00:00</span></li>
                  <!--<a href="#" class="list-group-item"><i class="fa fa-crosshairs fa-fw"></i> Pick Time: <span id="order_rider_picking_time">Pick Time</span></a>-->
                  <li><i class="fa fa-comment-o fa-fw"></i> Owned: <span id="order_rider_acknowledge">0000-00-00 00:00:00</span></li>
                  <li><i class="fa fa-crosshairs fa-fw"></i> Order Pick: <span id="order_picking_time">0000-00-00 00:00:00</span></li>
                </ul>
                <ul style="border:1px solid #CCC; list-style:none; padding-left:0px; border-radius:5px;">
                  <li><i class="fa fa-cog fa-fw"></i> Delivered: <span id="order_rider_delivery_time">0000-00-00 00:00:00</span></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="list-group" style="display:none" id="show_button">
              <div class="list-group-item profile-details" style="min-height:10px;" >
                <form name="order_cancle_or_awating" action="<?php echo site_url(ADMIN_DIR."orders/order_cancel_or_awaiting/"); ?>" method="post">
                  <input name="order_id" type="hidden" class="order_id" />
                  <table width="100%" id="order_cancle_or_awating_table" class="table" style="width:100% !important;">
                    <tr>
                      <td style="width:500px !important" ><input required type="text" name="reason" class="form-control" style="width:100%"  placeholder="Why you want to cancel or awating the order? Write here.."/></td>
                      <td><button name="buttom" value="cancel_order" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> Cancel Order </button></td>
                      <td id="awaiting_order_button" ><button name="buttom" value="awaiting_order" class="btn btn-danger"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Awaiting </button></td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
            <div class="list-group">
              <div class="list-group-item profile-details" style="min-height:110px;">
                <form name="order_placer" action="<?php echo site_url(ADMIN_DIR."orders/place_order/"); ?>" method="post">
                  <input name="order_id" type="hidden" class="order_id" />
                  <table width="100%" id="order_place_form">
                    
                      <td colspan="1"><strong>Delivery Charges </strong><br />
                        <input required class="form-control" id="deliveryCharges" name="delivery_charges" placeholder="Delivery Charges" type="number" min="100" /></td>
                      <td colspan="2"><input id="general_order_radio_button" name="order_type" type="radio" value="General Order" />
                        <strong>General Order</strong>
                        <input id="food_order_radio_button" name="order_type" type="radio" value="Food Order" />
                        <strong>Food Order</strong></td>
                    <tr>
                      <th height="30">Order on the name </th>
                      <th colspan="2" style="cursor:pointer">Ready Time: <span onclick="set_order_ready_time('20')" class="label label-warning label-sm">20</span> <span onclick="set_order_ready_time('40')" class="label label-warning label-sm">40</span> <span onclick="set_order_ready_time('60')" class="label label-warning label-sm">60</span> <span onclick="set_order_ready_time('120')" class="label label-warning label-sm">120</span> <span onclick="set_order_ready_time('300')" class="label label-warning label-sm">300</span> </th>
                    </tr>
                    <tr>
                      <td><input required class="form-control" id="order_name_field" name="order_name" placeholder="Order Name" /></td>
                      <td><input required id="order_ready_time_field" class="form-control" name="order_ready_time" placeholder="Order Reay Time" /></td>
                      <td><button class="btn btn-primary">Process <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></button></td>
                    </tr>
                    <tr>
                      <td ></td>
                      <td colspan="2"></td>
                    </tr>
                  </table>
                </form>
                <table id="assign_rider_deliver">
                    <tr>
                  
                    <td >
                  
                  <form name="assign_rider" action="<?php echo site_url(ADMIN_DIR."orders/assign_rider/"); ?>" method="post">
                    <input required name="order_id" type="hidden" class="order_id" />
                    <div id="rider_list" style="    height: 470px !important;
    overflow: auto;">
                      <table class="table table-stats" id="rider_table_list">
                        <thead>
                          <tr>
                            <th width="10"></th>
                            <th>Rider Name</th>
                            <th>C.</th>
                            <th>Assigned</th>
                            <th>Picking Add:</th>
                            <th>Drop Add:</th>
                            <th width="5">D.</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                      </td>
                    
                      </tr>
                    
                    <tr>
                      <td style="text-align:center">
                      <input class="btn btn-danger" type="button"  name="Cancel / Awating" value="Cancel / Awating" onclick="$('#show_button').toggle();" />
                      <button class="btn btn-primary"><i class="fa fa-motorcycle" aria-hidden="true"></i> Assign Rider </button>
                      
                  </form>
                  
                    </td>
                  
                  
                    <td><span id="deliver_button">
                      <form name="order_placer" action="<?php echo site_url(ADMIN_DIR."orders/order_delivered/"); ?>" method="post">
                        <input name="order_id" type="hidden" class="order_id" />
                        <button class="btn btn-success" ><i class="fa fa-check fa-fw"></i> Deliver</button>
                      </form>
                      </span></td>
                  </tr>
                </table>
                <span class="pull-right" id="deliver_button2">
                <form name="order_placer" action="<?php echo site_url(ADMIN_DIR."orders/order_delivered/"); ?>" method="post">
                  <input name="order_id" type="hidden" class="order_id" />
                  <button class="btn btn-success" ><i class="fa fa-check fa-fw"></i> Deliver</button>
                </form>
                </span> </div>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="modal-footer"><a class="btn btn-small btn-default" id="print_button" onclick="javascript:print_receipt('PrintOrder');"> <i class="fa fa-print"></i> Print</a> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>
<script>
function open_model_resend_sms(order_id){
	$.ajax({
        type: "POST",
        url: site_url + "/orders/get_resend_sms_form/" + order_id,
        data: {}
    }).done(function(data) {

        $('#resend_sms_body').html(data);
    });

    $('#resend_sms').modal('toggle');
	}
</script>
<div class="modal" id="resend_sms" data-backdrop="static" >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="order_view_title"><i class="fa fa-comment-o" aria-hidden="true"></i> Resend Order Detail to Rider</h4>
      </div>
      <div class="modal-body" id="resend_sms_body"> </div>
      <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>
<script>
function resend_sms(order_id){
	//alert(order_id);
	var rider_mobile_number = $('#rider_mobile_number').val();
	$.ajax({
        type: "POST",
        url: site_url + "/orders/resend_sms/" + order_id,
        data: {rider_mobile_number:rider_mobile_number}
    }).done(function(data) {

        $('#resend_sms_body').html(data);
    });

   // $('#resend_sms').modal('toggle');
	}
	
function open_model_reassign_rider(order_id){
	$.ajax({
        type: "POST",
        url: site_url + "/orders/get_rider_reassign_form/" + order_id,
        data: {}
    }).done(function(data) {

        $('#reassign_rider_body').html(data);
    });

    $('#reassign_rider').modal('toggle');
	}


	
function reassign_rider(order_id){
	
	}	
</script>
<div class="modal" id="reassign_rider" data-backdrop="static" >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="order_view_title"><i class="fa fa-motorcycle fa-fw" aria-hidden="true"></i> Assign Rider Again</h4>
      </div>
      <div class="modal-body" id="reassign_rider_body"> </div>
      <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/".ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />

<script>
/*$(document).ready(function(){
  $('#order_table').DataTable({
                "bPaginate": false
            });
});*/
</script>
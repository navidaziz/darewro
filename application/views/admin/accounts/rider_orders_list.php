



<table class="table table-bordered" id="order_table">
<?php if($rider_name){ ?>
<h4 class="pull-left">Rider Name: <?php echo ucwords(strtolower($rider_name)); ?></h4>
<?php } ?>
<h4 class="pull-right">Date: <?php echo $date; ?></h4>
  <thead>
    <tr>
      <th>#</th>
      <th></th>
      <th></th>
      <th>ID</th>
      <th width="300"><?php echo $this->lang->line('order_detail'); ?></th>
      <th>Address</th>
      <th>Rs:</th>
      <th>Customer</th>
      <th>Registered by</th>
       <?php if($orders[0]->order_status==5){ ?>
       <th>Cancellation Reason</th>
       <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php 
			  
			  $order_last_id = 0;
			  $count=1;
			  $rs_total=0;
			  foreach($orders as $order): ?>
    <?php 
			  
			   
			  
			  
			  
			  if($order_last_id < $order->order_id){  $order_last_id = $order->order_id;  } ?>
    <tr id="order_row_<?php echo $order->order_id; ?>" >
      <td><?php echo $count++; ?></td>
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
      <td><?php echo $order->order_detail; ?></td>
      <td><strong>Picking:</strong> <em><?php echo $order->order_picking_address; ?></em><br />
        <strong>Delivery:</strong> <em><?php echo $order->order_drop_address; ?></em></td>
      <td><?php echo $order->delivery_charges; 
	  
	  $rs_total=$rs_total+$order->delivery_charges;
	  ?></td>
      <td><?php echo $order->customer_name; ?><br />
        <em>
        <?php 
		echo "DT: ".date('h:i A d M, Y', strtotime($order->delivery_time));
		//echo $order->mobile_number; ?>
        </em></td>
        <td>
        <?php $query="SELECT 
				  `roles`.`role_title`,
				  `users`.`user_title` 
				FROM
				  `users`,
				  `roles` 
				WHERE `users`.`role_id` = `roles`.`role_id`
				AND `users`.`user_id`=".$this->db->escape($order->created_by);
				$query_result = $this->db->query($query);
				$register_by = $query_result->result()[0];
				echo $register_by->user_title." (".$register_by->role_title.")";
				echo "<br />".date('h:i A d M, Y', strtotime($order->created_date));
								  ?>
        </td>
        <?php if($order->order_status==5){ ?>
        
        <td><em><?php echo $order->reason; ?></em>
        
        
         <?php $query="SELECT 
				  `roles`.`role_title`,
				  `users`.`user_title` 
				FROM
				  `users`,
				  `roles` 
				WHERE `users`.`role_id` = `roles`.`role_id`
				AND `users`.`user_id`=".$this->db->escape($order->cancelled_by);
				$query_result = $this->db->query($query);
				if($query_result->result()){
				$cancelled_by = $query_result->result()[0];
				echo "<strong>Cancalled By: ".$cancelled_by->user_title." (".$cancelled_by->role_title.")</strong>";
				echo "<br />".$order->cancelled_time;
				}
								  ?>
        
        
        </td>
        <?php } ?>
    </tr>
    <?php endforeach; ?>
   <tfoot> <tr>
    <td colspan="6">Total</td><td><?php echo $rs_total; ?></td>
     <?php if($order->order_status==5){ ?>
      <td colspan="3"></td>
     <?php }else{ ?>
    <td colspan="2"></td>
    <?php } ?>
    </tr>
    </tfoot>
  </tbody>
</table>


<script>

$('#order_table').DataTable({
                "bPaginate": false,
				 dom: 'Bfrtip',
        buttons: [
            'print'
        ]
            });

</script>
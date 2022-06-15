<script type="text/javascript">
      $(document).ready(function() {
		  $("select.flexselect").flexselect({
  allowMismatch: true,
  inputNameTransform:  function(name) { return "new_" + name; }
});
        $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
        $("select.flexselect").flexselect();
        $("input:text:enabled:first").focus();
        $("form").submit(function() {
          alert($(this).serialize());
          return false;
        });
      });
    </script>
<script>
		  
function add_food_menu_order(){	
alrt();
}



function get_food_menu(){
	restaurant_id = $('#restaurant_id').val();
	//get food menu using restorent menu
	//alert();
	//$('#restaurant_food_menu_id').remove();
	$('#restaurant_food_menu_id').children('option:not(:first)').remove();
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/get_food_menu/"); ?>/"+restaurant_id,
			 data:{}}).done(function( data ){
				 data = jQuery.parseJSON(data);
				 //	$('#ms g').html(data);
					//console.log(data);
					for(var i in data) {
						var counter = data[i];
						food_menu = counter.restaurant_food_category+' | '+counter.restaurant_food_name+' | Rs:'+counter.restaurant_food_price+' | '+counter.restaurant_food_description;
						$('#restaurant_food_menu_id').append($('<option>',{value: counter.restaurant_food_menu_id,text : food_menu }));
					}
					
					
					
					
					
			// refresh the list
			$("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
			$("select.flexselect").flexselect();
			$("input:text:enabled:first").focus();
			$("form").submit(function() {
			alert($(this).serialize());
			return false;
			});
					
					});	
					
	
	}
	
function remove_cart_item(item_cart_id){
	
	$('#r_'+item_cart_id).remove();
	
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/remove_cart_item/"); ?>/"+item_cart_id,
			 data:{}}).done(function( data ){
				 $('#r_'+item_cart_id).remove();
				 data = jQuery.parseJSON(data);
				 create_items_table(data);
				 });	
}

function add_food_to_cart(){
	restaurant_food_menu_id = $('#restaurant_food_menu_id').val();
	//alert(restaurant_food_menu_id);
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/add_food_to_cart/"); ?>/"+restaurant_food_menu_id,
			 data:{}}).done(function( data ){
				 //alert(data);
				 data = jQuery.parseJSON(data);
				 create_items_table(data);
			});		 
	
	}
	

	
function icrement_cart_item_quantity(item_cart_id){
	var quantity = $('#quantity_'+item_cart_id).val();
	var restaurant_food_price_ = $('#restaurant_food_price_'+item_cart_id).val();
	
	
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/icrement_cart_item_quantity/"); ?>/"+item_cart_id,
			 data:{quantity:quantity}}).done(function( data ){
				// $('#r_'+item_cart_id).remove();
				data = jQuery.parseJSON(data);
				 create_items_table(data);
				 
				 
				 });
	}	
	
	
function create_items_table(data){
	//alert();
	var total_sum = 0;
	cart_list ='<table class="table-bordered" style="width:100%"><tr><th>Restaurant</th><th>Food Cetegory</th><th>Food Name</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>';
				 //$('#msg').html(data);
					//console.log(data);
					for(var i in data) {
						var counter = data[i];
						 cart_list= cart_list+'<tr id="r_'+counter.item_cart_id+'"><td>'+counter.restaurant_name+'</td><td>'+counter.restaurant_food_category+'</td><td>'+counter.restaurant_food_name+'</td><td><input id="restaurant_food_price_'+counter.item_cart_id+'" type="hidden" value="'+counter.restaurant_food_price+'"  />'+counter.restaurant_food_price+'</td><td><input id="quantity_'+counter.item_cart_id+'" type="number" value="'+counter.quantity+'" style="width: 52px;" onclick="icrement_cart_item_quantity('+counter.item_cart_id+')" onkeyup="icrement_cart_item_quantity('+counter.item_cart_id+')"/></td><td>'+(counter.quantity*counter.restaurant_food_price)+'</td><td><button onclick="remove_cart_item('+counter.item_cart_id+')" type="button" class="close">×</button></td></tr>';
						 total_sum= total_sum+(counter.quantity*counter.restaurant_food_price);
					}
					
					cart_list= cart_list+'</table><h4 class="pull-right">Total Rs: '+total_sum+'</h4>';
					$('#cart_list').html(cart_list);
					
					
					
	
	}	
	
</script>
<script>
		function check_customer_mobile_no(){
			if (event.keyCode == 13) {
				var customer_mobile_no = $('#customer_mobile_no').val();
				$.ajax({ type: "POST",
			 	url: "<?php echo base_url(ADMIN_DIR."orders/check_customer_detail/"); ?>/"+customer_mobile_no,
			 	data:{}}).done(function( data ){
				 //alert(data);
				 data = jQuery.parseJSON(data);
				 
					if(data.found){
						$('#customer_name').val(data.customer_name);
						$('#comment').val(data.comment);
						}
					
					});	
			}
		}
          </script>

<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height:1px; !important;"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."orders/view/"); ?>"><?php echo $this->lang->line('Orders'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS --> 
      <!--<div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>--> 
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<form action="" method="post" >
<div class="row">
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4" >
            <label for="customer_id" class="col-md-12 control-label" style="">Mobile No.</label>
            <input onkeypress="check_customer_mobile_no()" type="text" name="customer_mobile_no" value="" id="customer_mobile_no" class="form-control" style="" required="required" title="Mobile No" placeholder="Customer Mobile No">
          </div>
          <div class="col-md-4" >
            <label for="customer_name" class="col-md-12 control-label" style="">Customer Name</label>
            <input type="text" name="customer_name" value="" id="customer_name" class="form-control" style="" required="required" title="User Title" placeholder="Customer Name">
          </div>
          <div class="col-md-4" >
            <label for="comment" class="col-md-12 control-label" style="">Comment</label>
            <input type="text" name="comment" value="" id="comment" class="form-control" style="" required="required" title="User Title" placeholder="Comment">
          </div>
          <div style="clear:both;"></div>
          <br />
          <div class="col-md-12" >
            <label for="comment" class="col-md-12 control-label" style="">Picking Location</label>
            <input  type="hidden" name="PLID" id="PLID" value="0" />
            <input  class="form-control" name="picking_location" id="picking_ location" type="text" value=""/>
          </div>
          <div style="clear:both;"></div>
         
          <br />
          <div class="col-md-12">
            <?php
                    $label = array(
                        "class" => "col-md-12 control-label",
                        "style" => "",
                    );
                   echo form_label("General ".$this->lang->line('order_detail'), "order_detail", $label);
                ?>
            <?php
                    
                    $textarea = array(
                        "name"          =>  "order_detail",
                        "id"            =>  "order_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('order_detail'),"required"	  => "required",
                        "rows"          =>  "7",
                        "cols"          =>  "",
                        "value"         => set_value("order_detail"),
                        "placeholder"   =>  $this->lang->line('order_detail')
                    );
                    echo form_textarea($textarea);
                ?>
            <?php echo form_error("order_detail", "<p class=\"text-danger\">", "</p>"); ?> </div>
            
            
          <div class="col-md-12" >
            <label for="comment" class="col-md-12 control-label" style="">Delivery Location</label>
            <input  type="hidden" name="DLID" id="DLID" value="0" />
            <input  class="form-control" name="delivery_location" id="delivery_ location" type="text" value=""/>
          </div>
          <div style="clear:both;"></div>   
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <select onchange="get_food_menu()" class="special-flexselect form-control" id="restaurant_id" name="restaurant_id" tabindex="1" data-placeholder="Restaurant Name...">
              <option value=""></option>
              <?php foreach($restaurants as $restaurant_id => $restaurant_name){?>
              <option value="<?php echo $restaurant_id; ?>"><?php echo $restaurant_name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div  class="col-md-8">
            <select onchange="add_food_to_cart()" class="special-flexselect form-control" id="restaurant_food_menu_id" name="restaurant_food_menu_id" tabindex="1" data-placeholder="Food Menu...." >
              <option value=""></option>
            </select>
          </div>
          <div  style="clear:both !important;"></div>
          <div class="col-md-12" style="margin-top:5px; min-height:200px !important;" id="cart_list" >
            <table class="table-bordered" style="width:100%;">
              <tbody>
                <tr>
                  <th>Food Cetegory</th>
                  <th>Food Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                </tr>
                <tr>
                  <td colspan="4"><em>Food Item</em></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div  style="clear:both !important;"></div>
          <br />
          <script>
         $(document).ready(function(){
        $('#pre_order').click(function(){
            if($(this).prop("checked") == true){
                $('.preorder').show();
            }
            else if($(this).prop("checked") == false){
                 $('.preorder').hide();
				  $('#order_ready_time').val("");
				  $('#orderer_name').val("");
            }
        });
    });
          </script>
          <div class="col-md-12">
            <label class="checkbox-inline" style="padding-left:0px !important;" >
              <input  type="checkbox" id="pre_order" value="pre_order">
              <strong>Pre Order</strong> </label>
          </div>
          
          <div class="col-md-6 preorder" style="display:none">
            <label for="customer_id" class="col-md-12 control-label" style="">Orderer Name</label>
            <input onkeypress="check_customer_mobile_no()" type="text" name="orderer_name" value="" id="orderer_name" class="form-control" style="" required="required" title="Orderer Name" placeholder="Orderer Name">
          </div>
          <div class="col-md-6 preorder" style="display:none"> 
            <script>
			  function add_order_ready_time(add_order_ready_time){
				  $('#order_ready_time').val(add_order_ready_time);
				  }
              
              </script>
            <table width="100%">
              <tr>
                <td><strong>Order Ready Time (Minutes):</strong></td>
              </tr>
              <tr>
                <td><button onclick="add_order_ready_time('0')" class="btn btn-success btn-sm">0</button>
                  <button onclick="add_order_ready_time('10')" class="btn btn-success btn-sm">10</button>
                  <button onclick="add_order_ready_time('20')" class="btn btn-success btn-sm">20</button>
                  <button onclick="add_order_ready_time('30')" class="btn btn-success btn-sm">30</button>
                  <button onclick="add_order_ready_time('75')" class="btn btn-success btn-sm">75</button></td>
              </tr>
              <tr>
                <td><input type="text" name="order_ready_time" id="order_ready_time" class="form-control" /></td>
              </tr>
            </table>
          </div>
          <br />
          <div class="col-md-6"> 
            <script>
			  function add_delivery_charges(add_delivery_charges){
				  $('#delivery_charges').val(add_delivery_charges);
				  }
              
              </script>
            <table width="100%">
              <tr>
                <td><strong>Delivery Charges (Rs)</strong></td>
              </tr>
              <tr>
                <td><button onclick="add_delivery_charges('100')" class="btn btn-primary btn-sm">100</button>
                  <button onclick="add_delivery_charges('150')" class="btn btn-primary btn-sm">150</button>
                  <button onclick="add_delivery_charges('200')" class="btn btn-primary btn-sm">200</button>
                  <button onclick="add_delivery_charges('250')" class="btn btn-primary btn-sm">250</button>
                  <button onclick="add_delivery_charges('300')" class="btn btn-primary btn-sm">300</button></td>
              </tr>
              <tr>
                <td><input type="text" name="delivery_charges" id="delivery_charges" class="form-control" /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6"> 
            <script>
			  function add_delivery_time(add_delivery_time){
				  $('#delivery_time').val(add_delivery_time);
				  }
              
              </script>
            <table width="100%">
              <tr>
                <td><strong>Delivery Time (Minutes):</strong></td>
              </tr>
              <tr>
                <td><button onclick="add_delivery_time('40')" class="btn btn-danger btn-sm">40</button>
                  <button onclick="add_delivery_time('60')" class="btn btn-danger btn-sm">60</button>
                  <button onclick="add_delivery_time('90')" class="btn btn-danger btn-sm">90</button>
                  <button onclick="add_delivery_time('120')" class="btn btn-danger btn-sm">120</button>
                  <button onclick="add_delivery_time('300')" class="btn btn-danger btn-sm">300</button></td>
              </tr>
              <tr>
                <td><input type="text" name="delivery_time" id="delivery_time" class="form-control" /></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR."jquery-flexselect/flexselect.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

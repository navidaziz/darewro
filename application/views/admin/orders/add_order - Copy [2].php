<script type="text/javascript">
      $(document).ready(function() {
		  $("select.flexselect").flexselect({
  allowMismatch: true,
  inputNameTransform:  function(name) { return "new_" + name; }
});
        $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
        $("select.flexselect").flexselect();
        $("input:text:enabled:first").focus();
        /*$("form").submit(function() {
          alert($(this).serialize());
          return false;
        });*/
      });
    </script>
<script>
		  
function add_food_menu_order(){	
alrt();
}



function get_food_menu(){
	restaurant_id = $('#restaurant_id').val();
	
	$('#restaurant_food_menu_id').children('option:not(:first)').remove();
	if(restaurant_id){
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/get_food_menu/"); ?>/"+restaurant_id,
			 data:{}}).done(function( data ){
				 data = jQuery.parseJSON(data);
					for(var i in data) {
						var counter = data[i];
						food_menu = counter.restaurant_food_category+' | '+counter.restaurant_food_name+' | Rs:'+counter.restaurant_food_price+' | '+counter.restaurant_food_description;
						$('#restaurant_food_menu_id').append($('<option>',{value: counter.restaurant_food_menu_id,text : food_menu }));
					}
					
					
					$('#restaurant_food_menu_id').focus();
					
					
			/*// refresh the list
			$("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
			$("select.flexselect").flexselect();
			$("input:text:enabled:first").focus();
			$("form").submit(function() {
			alert($(this).serialize());
			return false;
			});*/
					
					});	
	}
					
	
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
	if(restaurant_food_menu_id){
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/add_food_to_cart/"); ?>/"+restaurant_food_menu_id,
			 data:{}}).done(function( data ){
				 //alert(data);
				 data = jQuery.parseJSON(data);
				 create_items_table(data);
			});	
	}
	
	}
	

	
function icrement_cart_item_quantity(item_cart_id){
	var restaurant_food_price = $("#restaurant_food_price_"+item_cart_id).val();
	var quantity = $("#quantity_"+item_cart_id).val();
	$("#total_"+item_cart_id).val(restaurant_food_price*quantity);
	$("#total_td_"+item_cart_id).html(restaurant_food_price*quantity);
	var total_rs = 0;
	$('.total').each(function (index, element) {
        total_rs = total_rs + parseFloat($(element).val());
    });
	$('#total_rs').html(total_rs);
	
	
	
	var quantity = $('#quantity_'+item_cart_id).val();
	var restaurant_food_price_ = $('#restaurant_food_price_'+item_cart_id).val();
	
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."restaurant_food_menus/icrement_cart_item_quantity/"); ?>/"+item_cart_id,
			 data:{quantity:quantity}}).done(function( data ){
				// $('#r_'+item_cart_id).remove();
				data = jQuery.parseJSON(data);
				 //create_items_table(data);
				 
				 
				 });
	}	
	
	
function create_items_table(data){
	//alert();
	var total_sum = 0;
	cart_list ='<table class="table-bordered" style="width:100%"><tr><th>Restaurant</th><th>Food Cetegory</th><th>Food Name</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>';
				 //$('#msg').html(data);
					//console.log(data);
					restaurant_names = {};
					for(var i in data) {
						var counter = data[i];
						restaurant_names[counter.restaurant_name] = counter.restaurant_name;
						 cart_list= cart_list+'<tr id="r_'+counter.item_cart_id+'"><td>'+counter.restaurant_name+'</td><td>'+counter.restaurant_food_category+'</td><td>'+counter.restaurant_food_name+'</td><td><input id="restaurant_food_price_'+counter.item_cart_id+'" type="hidden" value="'+counter.restaurant_food_price+'"  />'+counter.restaurant_food_price+'</td><td><input  id="quantity_'+counter.item_cart_id+'" min="1" max="10" type="number" value="'+counter.quantity+'" style="width: 52px;" onclick="icrement_cart_item_quantity('+counter.item_cart_id+')" onkeyup="icrement_cart_item_quantity('+counter.item_cart_id+')"/></td><td><input type="hidden" class="total" id="total_'+counter.item_cart_id+'" name="total['+counter.item_cart_id+']" value="'+(counter.quantity*counter.restaurant_food_price)+'" /><span id="total_td_'+counter.item_cart_id+'">'+(counter.quantity*counter.restaurant_food_price)+'</span></td><td><button onclick="remove_cart_item('+counter.item_cart_id+')" type="button" class="close">×</button></td></tr>';
						 total_sum= total_sum+(counter.quantity*counter.restaurant_food_price);
					}
					
					cart_list= cart_list+'</table><h4 class="pull-right" >Total Rs: <span id="total_rs">'+total_sum+'</span></h4>';
					$('#cart_list').html(cart_list);
					restaurantNames ='';
					
					for(var i in restaurant_names){
						restaurantNames=restaurantNames+restaurant_names[i]+', ';
						}
						//alert(restaurantNames);
					if(restaurantNames!=''){	
					$('#picking_location').val(restaurantNames);
					$('#picking_location_suggestion').hide();
					}else{
						$('#picking_location').val("");
						//if($('#picking_location_suggestion').css('display') != 'none'){
							$('#picking_location_suggestion').show();
						//}
						
						}
					
					 
					
					
					
	
	}	
	
</script>
<script>

function set_mobile_number_in_field(customer_mobile_no){
	$('#customer_mobile_no').val(customer_mobile_no);
	$('#search').val(customer_mobile_no);
	get_mobile_detail();
	//searched_order();
	}



function check_customer_mobile_no(){
			if (event.keyCode == 13) {
				get_mobile_detail();
				}
		}
function get_mobile_detail(){
	
				var customer_mobile_no = $('#customer_mobile_no').val();
				$.ajax({ type: "POST",
			 	url: "<?php echo base_url(ADMIN_DIR."orders/check_customer_detail/"); ?>/"+customer_mobile_no,
			 	data:{}}).done(function( data ){
				 //alert(data);
				 data = jQuery.parseJSON(data);
				 
					if(data.found){
						$('#customer_name').val(data.customer_name);
						$('#comment').val(data.comment);
						$('#customer_id').val(data.customer_id);
						
						
						customer_locations = data.customer_locations;
						var picking_location_suggestion = '';
						var delivery_location_suggestion = '';
						for(var i in customer_locations) {
							var customer_location = customer_locations[i];
							picking_location_suggestion=picking_location_suggestion+'<span class="ms-sel-item"> '+customer_location.location_address+' <i class="fa fa-check" onclick="add_to_picking_location(\''+customer_location.location_address+'\')"></i> </span>';
							delivery_location_suggestion=delivery_location_suggestion+'<span class="ms-sel-item"> '+customer_location.location_address+' <i class="fa fa-check" onclick="add_to_delivery_location(\''+customer_location.location_address+'\')"></i> </span>';
							
						}
					   $('#picking_location_suggestion').html(picking_location_suggestion);
					   $('#picking_location_suggestion').show();
					   $('#delivery_location_suggestion').html(delivery_location_suggestion);
					   $('#delivery_location_suggestion').show();
						
						}else{
							//alert();
							$('#customer_name').val('');
							$('#comment').val('');
							$('#customer_id').val('0');
							
							$('#picking_location_suggestion').html('');
					   		$('#picking_location_suggestion').hide();
					   		$('#delivery_location_suggestion').html('');
					   		$('#delivery_location_suggestion').hide();
							
							}
					
					});	
			
	}
		
function add_to_delivery_location(delivery_location_suggestion){
	$('#delivery_location').val(delivery_location_suggestion);
	
	}		
function add_to_picking_location(picking_location_suggestion){
	$('#picking_location').val(picking_location_suggestion);
	}		
          </script>

<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height:1px; !important;"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb pull-left">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <!--<li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."orders/view/"); ?>"><?php echo $this->lang->line('Orders'); ?></a> </li>-->
        <li><?php echo $title; ?></li>
      </ul>
      
      <ul id="mobile_numbers" class="breadcrumb pull-right">
       
      </ul>
     
    </div>
    
    
    
  </div>
  
  
</div>

<div class="row" style="margin-top:-25px !important; ">
<div class="col-md-12">
        <div style=" background-color:#FBFBFB; min-height:40px; margin-bottom:10px;">
        <table width="100%">
        <tr><td width="250" valign="top">
        <input style="margin:5px;" onkeypress="on_enter_press_search()" type="text" name="search" value="" id="search" class="form-control pull-left"  required="" title="Mobile No" placeholder="Search Order By Mobile No...." />
        </td>
        <td width="10" valign="top"><input onClick="on_click_search_button()" type="button" class="btn btn-link pull-left" value="Search" style="margin:5px;"></td>
        <td id="search_order_detail"></td>
        </tr>
        </table>
        
        </div>
        </div>
        
   <?php $edit_form_attr = array();
echo form_open_multipart(ADMIN_DIR."orders/save_and_process", $edit_form_attr);  ?>
     
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-body">
        <div class="row">
        
          <div class="col-md-4" >
          <input type="hidden" name="customer_id" id="customer_id" value="0" />
            <label for="customer_id" class="col-md-12 control-label" style="">Mobile No.</label>
            <input onKeyPress="check_customer_mobile_no(1)" type="text" name="customer_mobile_no" value="" id="customer_mobile_no" class="form-control" style="" required title="Mobile No" placeholder="Customer Mobile No">
          </div>
          <div class="col-md-4" >
            <label for="customer_name" class="col-md-12 control-label" style="">Customer Name</label>
            <input type="text" name="customer_name" value="" id="customer_name" class="form-control" style="" required title="User Title" placeholder="Customer Name">
          </div>
          <div class="col-md-4" >
            <label for="comment" class="col-md-12 control-label" style="">Comment</label>
            <input type="text" name="comment" value="" id="comment" class="form-control" style=""  title="User Title" placeholder="Comment">
          </div>
          <div style="clear:both;"></div>
          <br />
          <div class="col-md-12" >
            
          
          <table width="100%">
          <tr>
          <td> <label for="comment" class="col-md-12 control-label" style="">Picking Location</label>
            <input  type="hidden" name="PLID" id="PLID" value="0" />
            <input style="width:100%" required    class="form-control" name="picking_location" id="picking_location" type="text" value=""/>
          </td>
          <td width="1">
          <br />
          <input  style="width: 20px; height: 20px; cursor:pointer;"  name="address_save" type="radio" value="save_picking_location" title="Customer Location tag" /></td>
          </tr>
          <tr><td colspan="2" style="display:none" id="picking_location_suggestion">
          <span class="help-block">Customer Location suggestions</span>
          </td></tr>
          </table>
          
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
                        "title"         =>  $this->lang->line('order_detail'),
						
                        "rows"          =>  "7",
                        "cols"          =>  "",
                        "value"         => set_value("order_detail"),
                        "placeholder"   =>  $this->lang->line('order_detail')
                    );
                    echo form_textarea($textarea);
                ?>
            <?php echo form_error("order_detail", "<p class=\"text-danger\">", "</p>"); ?> </div>
            
            
          <div class="col-md-12" >
          <table width="100%">
          <tr>
          <td> <label for="comment" class="col-md-12 control-label" style="">Delivery Location</label>
            <input  type="hidden" name="DLID" id="DLID" value="0" />
            <input required  class="form-control" name="delivery_location" id="delivery_location" type="text" value=""/> </td>
          <td width="1">
          <br />
          <input style="width: 20px; height: 20px; cursor:pointer;" name="address_save" type="radio" value="save_delivery_location" title="Customer Location tag" /></td>
          </tr>
          <tr><td colspan="2" style="display:none" id="delivery_location_suggestion">
          <span class="form-control-static">Customer Location suggestions</span>
          </td></tr>
          
          </table>
           
          </div>
          <div style="clear:both;"></div>
          
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
                <td><button type="button" onClick="add_delivery_charges('100')" class="btn btn-primary btn-sm">100</button>
                  <button type="button" onClick="add_delivery_charges('150')" class="btn btn-primary btn-sm">150</button>
                  <button type="button" onClick="add_delivery_charges('200')" class="btn btn-primary btn-sm">200</button>
                  <button type="button" onClick="add_delivery_charges('250')" class="btn btn-primary btn-sm">250</button>
                  <button type="button" onClick="add_delivery_charges('300')" class="btn btn-primary btn-sm">300</button></td>
             
                <td><input required type="text" name="delivery_charges" id="delivery_charges" class="form-control" style="width:50px !important" /></td>
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
                <td><button type="button" onClick="add_delivery_time('40')" class="btn btn-danger btn-sm">40</button>
                  <button type="button" onClick="add_delivery_time('60')" class="btn btn-danger btn-sm">60</button>
                  <button type="button" onClick="add_delivery_time('90')" class="btn btn-danger btn-sm">90</button>
                  <button type="button" onClick="add_delivery_time('120')" class="btn btn-danger btn-sm">120</button>
                  <button type="button" onClick="add_delivery_time('300')" class="btn btn-danger btn-sm">300</button></td>
              
                <td><input type="text" name="delivery_time" id="delivery_time" class="form-control" style="width:50px !important" /></td>
              </tr>
            </table>
          </div>
          
             
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <select style="width:100% !important; padding:2px; border: 1px solid #ccc; border-radius: 4px;" onChange="get_food_menu()"  id="restaurant_id" name="restaurant_id" tabindex="1" class="special-flexselect form-control" data-placeholder="Restaurant Name...">
              <option value="">Select Restaurant...</option>
              <?php foreach($restaurants as $restaurant_id => $restaurant_name){?>
              <option value="<?php echo $restaurant_id; ?>"><?php echo $restaurant_name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div  class="col-md-8">
            <select style="width:100% !important; padding:2px;     border: 1px solid #ccc; border-radius: 4px;" onChange="add_food_to_cart()"  id="restaurant_food_menu_id" name="restaurant_food_menu_id" tabindex="1" class="special-flexselect form-control" data-placeholder="Food Menu...." >
              <option value="">Restaurant Foods.....</option>
            </select>
          </div>
          <div  style="clear:both !important;"></div>
          <div class="col-md-12"  >
          <div style="margin-top:5px; min-height:200px !important; border: 1px solid #ccc;  border-radius:5px; padding:2px;" id="cart_list">
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
          </div>
          <div  style="clear:both !important;"></div>
          <br />
          <script>
		  
		  function show_pre_oreder_options(){
			  
			  var check = document.getElementById("pre_order").checked;
			  
                if(check){
					//document.getElementsByClassName('preorder')[0].style.display = 'block';
					//document.getElementsByClassName('preorder')[0]setAttribute("display", "block");
					$('.preorder').show();
					}else{
					$('.preorder').hide();
					$('#orderer_name').val("");	
					$('#order_ready_time').val("");
					
						/*document.getElementsByClassName('preorder')[0].style.display = 'none';
						 var order_ready_time = document.getElementById('order_ready_time');
            				order_ready_time.value = "";
						var orderer_name = document.getElementById('orderer_name');
            				orderer_name.value = "";*/
						
					}
			  }
       
          </script>
          <div class="col-md-12" >
          <p style="border: 1px solid #ccc;  border-radius:5px; padding:2px;">
            <label class="checkbox-inline" style="padding-left:0px !important;" ><strong>Pre Order</strong>
              <input onChange="show_pre_oreder_options()" name="pre_order"  type="checkbox" id="pre_order" value="pre_order">
               </label>
              </p>
              <script>
			  function add_order_ready_time(add_order_ready_time){
				  $('#order_ready_time').val(add_order_ready_time);
				  }
              
              </script>
              <table width="100%" class="preorder" style="display:none">
              <tr>
              <td width="400"> <label for="customer_id" class="col-md-12 control-label" style="">Orderer Name</label>  </td>
                <td colspan="6"><strong>Order Ready Time (Minutes):</strong></td>
              </tr>
              <tr>
              <td ><input  type="text" name="orderer_name" value="" id="orderer_name" class="form-control" style=""  title="Orderer Name" placeholder="Orderer Name"></td>
                <td><button type="button" onClick="add_order_ready_time('0')" class="btn btn-success btn-sm">0</button></td>
                  <td><button type="button" onClick="add_order_ready_time('10')" class="btn btn-success btn-sm">10</button></td>
                  <td><button type="button" onClick="add_order_ready_time('20')" class="btn btn-success btn-sm">20</button></td>
                 <td> <button type="button" onClick="add_order_ready_time('30')" class="btn btn-success btn-sm">30</button></td>
                  <td><button type="button" onClick="add_order_ready_time('75')" class="btn btn-success btn-sm">75</button></td>
              
                <td><input type="text" name="order_ready_time" id="order_ready_time" class="form-control" style="width:50px !important" /></td>
              </tr>
            </table>
              
          </div>
          <script>
          function set_extra(extra){
			  var extra_value = $('#extra').val();
			  $('#extra').val(extra_value+' '+extra+', ');
			  }
          </script>
          
          <div class="col-md-12"> 
         <table class="table table-bordered">
         <tr><th style="background:#0F5FB8; color:white; cursor:pointer" onClick="set_extra('1-Pepsi')"><i class="fa fa-glass" aria-hidden="true"></i> Pepsi</th>
         <th style="background:#E61D2B; color:white; color:white; cursor:pointer" onClick="set_extra('1-Coke')"><i class="fa fa-glass" aria-hidden="true"></i> Coke</th>
         <th style="background:#4FA43F; color:white; cursor:pointer" onClick="set_extra('1-Dew')"><i class="fa fa-glass" aria-hidden="true"></i> Dew</th>
         <th style="background:#14A651; color:white; cursor:pointer" onClick="set_extra('1-7up')"><i class="fa fa-glass" aria-hidden="true"></i> 7up</th>
         <th style="background:#0F9B58; color:white; cursor:pointer" onClick="set_extra('1-Sprite')"><i class="fa fa-glass" aria-hidden="true"></i> Sprite</th>
         <th style="background:#FF8300; color:white; cursor:pointer" onClick="set_extra('1-Fanta')"><i class="fa fa-glass" aria-hidden="true"></i> Fanta</th></tr>
         <tr><td colspan="3" width="300">
         <span class="label label-primary" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('1-liter')"><i class="fa fa-check" aria-hidden="true"  ></i> 1-liter</span>
         <span class="label label-success" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('1.5-liter')"><i class="fa fa-check" aria-hidden="true" ></i> 1.5-Liter</span> 
         <span class="label label-info" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('Jumbo')"><i class="fa fa-check" aria-hidden="true" ></i> Jumbo</span> 
         <span class="label label-danger" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('Cane')"><i class="fa fa-check" aria-hidden="true" ></i> Cane</span>  
         
           </td>
         <td colspan="3"><input placeholder="Extra like Cold Drinks..." class="form-control" type="text" id="extra" name="extra" /></td></tr>
         </table>
         </div>
          <div class="col-md-12"> 
          <table width="100%">
          <tr>
          <td> 
          <label class="checkbox-inline" style="padding-left:0px !important;" ><strong>Shedule Order</strong>
          <input  onchange="$('#shedule_date').toggle();" name="shedule"  type="checkbox" id="shedule" value="shedule">
          </label>
          </td>
          <td><input style="display:none" class="form-control" type="date" id="shedule_date" name="shedule_date" /></td>
          <td> <input required type="submit" name="submit" value="Save and Process" class="btn btn-primary pull-right" style=" margin:5px;"></td>
          </tr>
          </table>
         
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</form>

<script>
window.setInterval(function(){ get_all_mobile_numbers(); }, 5000);

$(document).ready(function(){ get_all_mobile_numbers(); });

function get_all_mobile_numbers(){
	$.ajax({ type: "POST",
			 url: "<?php echo base_url(ADMIN_DIR."orders/get_mobiles_numbers/"); ?>/",
			 data:{}}).done(function( data ){
				 //alert(data);
				 data = jQuery.parseJSON(data);
				 //alert(data);
				var mobile_numbers = '<li style="color:red;"> <strong>Live Mobile No.</strong> </li>';
				for(var i in data) {
						var counter = data[i];
						mobile_numbers+='<li> <a href="javascript:set_mobile_number_in_field(\''+counter.caller_id+'\');" ><i class="fa fa-mobile" aria-hidden="true"></i>  '+counter.caller_id+'</a></li>';
				}
				$('#mobile_numbers').html(mobile_numbers);
				});	
	}

</script>
<script src="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/liquidmetal.js"); ?>"></script>
<script src="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/jquery.flexselect.js"); ?>"></script>
<link href="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/flexselect.css"); ?>" rel="stylesheet" />

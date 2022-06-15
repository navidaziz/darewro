<link rel="stylesheet" href="<?php echo site_url("assets/".ADMIN_DIR."jquery-flexselect/flexselect.css"); ?>" type="text/css" media="screen" />
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
				 cart_list ='<table class="table-bordered" style="width:100%"><tr><th>Food Cetegory</th><th>Food Name</th><th>Price</th><th>Quantity</th><th></th></tr>';
				 //$('#msg').html(data);
					//console.log(data);
					for(var i in data) {
						var counter = data[i];
						 cart_list= cart_list+'<tr id="r_'+counter.item_cart_id+'"><td>'+counter.restaurant_food_category+'</td><td>'+counter.restaurant_food_name+'</td><td>'+counter.restaurant_food_price+'</td><td>'+counter.quantity+'</td><td><button onclick="remove_cart_item('+counter.item_cart_id+')" type="button" class="close">×</button></td></tr>';
					}
					cart_list= cart_list+'</table>';
					$('#cart_list').html(cart_list);
					
					
					});	
	
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
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <div class="col-md-6">
    <div class="box border blue" id="messenger">
      <div class="box-body">
        <div class="row">
        
        <div class="col-md-4" >
          <div class="form-group">
            <label for="customer_id" class="col-md-12 control-label" style="">Mobile No.</label>
              <input onkeypress="check_customer_mobile_no()" type="text" name="customer_mobile_no" value="" id="customer_mobile_no" class="form-control" style="" required="required" title="Mobile No" placeholder="Customer Mobile No">
          </div>
          </div>
          <div class="col-md-4" >
          <div class="form-group">
            <label for="customer_name" class="col-md-12 control-label" style="">Customer Name</label>
            <input type="text" name="customer_name" value="" id="customer_name" class="form-control" style="" required="required" title="User Title" placeholder="Customer Name">
            </div>
          </div>
          <div class="col-md-4" >
          <div class="form-group">
            <label for="comment" class="col-md-12 control-label" style="">Comment</label>
            <input type="text" name="comment" value="" id="comment" class="form-control" style="" required="required" title="User Title" placeholder="Comment">
            </div>
          </div>
          </div>
          
          <div class="row">
         
          <div class="col-md-12" >
           <div class="form-group">
            <label for="comment" class="col-md-12 control-label" style="">Picking Location</label>
            <input  type="hidden" name="PLID" id="PLID" value="0" />
            <input  class="form-control" name="picking_location" id="picking_location" type="text" value=""/>
            </div>
          </div>
          
          <div class="col-md-12" >
           <div class="form-group">
            <label for="comment" class="col-md-12 control-label" style="">Delivery Location</label>
            <input  type="hidden" name="DLID" id="DLID" value="0" />
            <input  class="form-control" name="delivery_location" id="delivery_location" type="text" value=""/>
            </div>
          </div>
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
          <div class="col-md-12" style="margin-top:5px;" id="cart_list" >
            <table class="table-bordered" style="width:100%">
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
          <div  style="clear:both !important;"></div>
          <br />
          <div class="col-md-6"> 
            <script>
			  function add_delivery_charges(add_delivery_charges){
				  $('#delivery_charges').val(add_delivery_charges);
				  }
              
              </script>
            <table>
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
            <table>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

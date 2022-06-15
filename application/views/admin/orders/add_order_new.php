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
	  
	  
window.setInterval(function() {
    get_all_mobile_numbers();
}, 30000);

$(document).ready(function() {
    get_all_mobile_numbers();
});	  
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
      <ul  id="mobile_numbers" class="breadcrumb pull-right">
        <li style="color:red; cursor:pointer" onclick="get_all_mobile_numbers()"> <strong>Live Mobile No.</strong> </li>
      </ul>
    </div>
  </div>
</div>
<div class="row" style="margin-top:-25px !important; ">
  <div class="col-md-12">
    <div style=" background-color:#FBFBFB; min-height:40px; margin-bottom:10px;">
      <table width="100%">
        <tr>
          <td width="250" valign="top"><input style="margin:5px;" onkeypress="on_enter_press_search()" type="text" name="search" value="" id="search" class="form-control pull-left"  required="" title="Mobile No" placeholder="Search Order By Mobile No...." /></td>
          <td width="10" valign="top"><input onClick="on_click_search_button()" type="button" class="btn btn-link pull-left" value="Search" style="margin:5px;"></td>
          <td id="search_order_detail"></td>
        </tr>
      </table>
    </div>
  </div>
  <script>
 $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.which == 13) {
    e.preventDefault();
    return false;
  }
});
  </script>
  <?php $edit_form_attr = array("id" => "order_form");
echo form_open_multipart(ADMIN_DIR."orders/save_and_process_new", $edit_form_attr);  ?>
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
                <td><label for="comment" class="col-md-12 control-label" style="">Picking Location</label>
                  <table width="100%">
                    <tr>
                      <td width="400px"><input style="width:100% !important" id="pac-input2" class="controls" type="text" placeholder="Search Picking Location" name="picking_location"></td>
                      <td ><input style="width:120px !important"  class="field" id="street_number2" placeholder="Other Address" name="picking_street_number" >
                        </input></td>
                      <td ><input style="width:120px !important" class="field" id="route2" placeholder="Route" name="picking_route" >
                        </input></td>
                    </tr>
                    <tr>
                      <td colspan="3" ><input class="field" id="locality2" name="picking_city" readonly="readonly" >
                        </input>
                        <input  class="field" id="administrative_area_level_12" name="picking_province" readonly="readonly">
                        </input>
                        <input class="field" id="country2" name="picking_country" readonly="readonly">
                        </input>
                        <input class="field" id="postal_code2" name="picking_postal_code" readonly="readonly">
                        <input class="field" id="latitude2" name="pick_latitude" readonly="readonly">
                        </input>
                        <input class="field" id="longitude2"  name="pick_longitude" readonly="readonly">
                        </input></td>
                    </tr>
                  </table>
                  
                  <!-- <input  type="hidden" name="PLID" id="PLID" value="0" />
                  <input required  class="form-control" name="picking_location" id="picking_location" type="text" value=""/>--></td>
                <td width="1"><br />
                  <input  style="width: 20px; height: 20px; cursor:pointer;"  name="address_save" type="radio" value="save_picking_location" title="Customer Location tag" /></td>
              </tr>
              <tr>
                <td colspan="2" style="display:none" id="picking_location_suggestion"><span class="help-block">Customer Location suggestions</span></td>
              </tr>
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
                   echo form_label('General <span style="margin-left:20px !important; color:red"> Need To Place<input name="need_to_placed" type="checkbox" value="1" style="width: 15px !important; height: 15px !important" /> </span>', "order_detail", $label);
                ?>
            <?php
                    
                    $textarea = array(
                        "name"          =>  "order_detail",
                        "id"            =>  "order_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('order_detail'),
						
                        "rows"          =>  "5",
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
                <td><label for="comment" class="col-md-12 control-label" style="">Delivery Location</label>
                  <table width="100%">
                    <tr>
                      <td width="400px"><input style="width:100% !important" id="pac-input" class="controls" type="text" placeholder="Search Drop Location" name="delivery_location"></td>
                      <td ><input style="width:120px !important"  class="field" id="street_number" placeholder="Other Address" name="delivery_street_number" >
                        </input></td>
                      <td ><input style="width:120px !important" class="field" id="route" placeholder="Route"  name="delivery_route">
                        </input></td>
                    </tr>
                    <tr>
                      <td colspan="3" ><input class="field" id="locality" name="delivery_city" readonly="readonly">
                        </input>
                        <input class="field" id="administrative_area_level_1" name="delivery_province" readonly="readonly">
                        </input>
                        <input class="field" id="country"  name="delivery_country" readonly="readonly">
                        </input>
                        <input class="field" id="postal_code" name="delivery_postal_code" readonly="readonly">
                        <input class="field" id="latitude" name="drop_latitude" readonly="readonly">
                        </input>
                        <input class="field" id="longitude" name="drop_longitude" readonly="readonly">
                        </input></td>
                    </tr>
                  </table>
                  
                  <!--<input  type="hidden" name="DLID" id="DLID" value="0" />
                  <input required  class="form-control" name="delivery_location" id="delivery_location" type="text" value=""/>--></td>
                <td width="1"><br />
                  <input style="width: 20px; height: 20px; cursor:pointer;" name="address_save" type="radio" value="save_delivery_location" title="Customer Location tag" /></td>
              </tr>
              <tr>
                <td colspan="2" style="display:none" id="delivery_location_suggestion"><span class="form-control-static">Customer Location suggestions</span></td>
              </tr>
            </table>
          </div>
          <div style="clear:both;"></div>
          <div class="col-md-6">
            <table width="100%">
              <tr>
                <td><strong>Delivery Charges (Rs)</strong></td>
              </tr>
              <tr>
                <td><button  type="button" onClick="add_delivery_charges('100')" class="btn btn-primary btn-sm" style="padding:7px !important">100</button>
                  <button type="button" onClick="add_delivery_charges('150')" class="btn btn-primary btn-sm" style="padding:7px !important">150</button>
                  <button type="button" onClick="add_delivery_charges('200')" class="btn btn-primary btn-sm" style="padding:7px !important">200</button>
                  <button type="button" onClick="add_delivery_charges('250')" class="btn btn-primary btn-sm" style="padding:7px !important">250</button>
                  <button type="button" onClick="add_delivery_charges('300')" class="btn btn-primary btn-sm" style="padding:7px !important">300</button></td>
                <td><input required type="number" name="delivery_charges" id="delivery_charges" class="form-control" style="width:70px !important" value="150" /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table width="100%">
              <tr>
                <td><strong>Delivery Time (Minutes):</strong></td>
              </tr>
              <tr>
                <td><button type="button" onClick="add_delivery_time('20')" class="btn btn-danger btn-sm" >20</button>
                  <button type="button" onClick="add_delivery_time('25')" class="btn btn-danger btn-sm">25</button>
                  <button type="button" onClick="add_delivery_time('30')" class="btn btn-danger btn-sm">30</button>
                  <button type="button" onClick="add_delivery_time('35')" class="btn btn-danger btn-sm">35</button>
                  <button type="button" onClick="add_delivery_time('40')" class="btn btn-danger btn-sm">40</button></td>
                <td><input type="number" name="delivery_time" id="delivery_time" class="form-control" style="width:70px !important" value="25" /></td>
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
          <div class="col-md-12" >
            <p style="border: 1px solid #ccc;  border-radius:5px; padding:2px;">
              <label class="checkbox-inline" style="padding-left:0px !important;" ><strong>Pre Order</strong>
                <input onChange="show_pre_oreder_options()" name="pre_order"  type="checkbox" id="pre_order" value="pre_order">
              </label>
            </p>
            <table width="100%" class="preorder" style="display:none">
              <tr>
                <td width="400"><label for="customer_id" class="col-md-12 control-label" style="">Orderer Name</label></td>
                <td colspan="6"><strong>Order Ready Time (Minutes):</strong></td>
              </tr>
              <tr>
                <td ><input  type="text" name="orderer_name" value="" id="orderer_name" class="form-control" style=""  title="Orderer Name" placeholder="Orderer Name"></td>
                <td><button type="button" onClick="add_order_ready_time('0')" class="btn btn-success btn-sm">0</button></td>
                <td><button type="button" onClick="add_order_ready_time('10')" class="btn btn-success btn-sm">10</button></td>
                <td><button type="button" onClick="add_order_ready_time('20')" class="btn btn-success btn-sm">20</button></td>
                <td><button type="button" onClick="add_order_ready_time('30')" class="btn btn-success btn-sm">30</button></td>
                <td><button type="button" onClick="add_order_ready_time('75')" class="btn btn-success btn-sm">75</button></td>
                <td><input type="text" name="order_ready_time" id="order_ready_time" class="form-control" style="width:50px !important" /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
            <table class="table table-bordered">
              <tr>
                <th style="background:#0F5FB8; color:white; cursor:pointer" onClick="set_extra('1-Pepsi')"><i class="fa fa-glass" aria-hidden="true"></i> Pepsi</th>
                <th style="background:#E61D2B; color:white; color:white; cursor:pointer" onClick="set_extra('1-Coke')"><i class="fa fa-glass" aria-hidden="true"></i> Coke</th>
                <th style="background:#4FA43F; color:white; cursor:pointer" onClick="set_extra('1-Dew')"><i class="fa fa-glass" aria-hidden="true"></i> Dew</th>
                <th style="background:#14A651; color:white; cursor:pointer" onClick="set_extra('1-7up')"><i class="fa fa-glass" aria-hidden="true"></i> 7up</th>
                <th style="background:#0F9B58; color:white; cursor:pointer" onClick="set_extra('1-Sprite')"><i class="fa fa-glass" aria-hidden="true"></i> Sprite</th>
                <th style="background:#FF8300; color:white; cursor:pointer" onClick="set_extra('1-Fanta')"><i class="fa fa-glass" aria-hidden="true"></i> Fanta</th>
              </tr>
              <tr>
                <td colspan="3" width="300"><span class="label label-primary" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('1-liter')"><i class="fa fa-check" aria-hidden="true"  ></i> 1-liter</span> <span class="label label-success" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('1.5-liter')"><i class="fa fa-check" aria-hidden="true" ></i> 1.5-Liter</span> <span class="label label-info" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('Jumbo')"><i class="fa fa-check" aria-hidden="true" ></i> Jumbo</span> <span class="label label-danger" style="cursor:pointer; font-size:14px !important;" onClick="set_extra('Cane')"><i class="fa fa-check" aria-hidden="true" ></i> Can</span></td>
                <td colspan="3"><input placeholder="Extra like Cold Drinks..." class="form-control" type="text" id="extra" name="extra" /></td>
              </tr>
              <tr>
              <td colspan="6">Promo Code <input type="text" name="promo_code" id="promo_code"  /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-12">
            <table width="100%">
              <tr>
                <td><label class="checkbox-inline" style="padding-left:0px !important;" ><strong>Shedule Order</strong>
                    <input  onchange="$('#shedule_date').toggle();" name="shedule"  type="checkbox" id="shedule" value="shedule">
                  </label></td>
                <td><input style="display:none" class="form-control" type="date" id="shedule_date" name="shedule_date" /></td>
                <td><input required type="submit" name="submit" id="save_and_process" value="Save and Process" class="btn btn-primary pull-right" style=" margin:5px;"></td>
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
<style>
.ms-sel-item {
    background: #666;
    color: #EEE;
    float: left;
    font-size: 12px;
    padding: 0 10px;
    border-radius: 3px;
    margin-left: 5px;
    margin-top: 4px;
}


</style>
<script src="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/liquidmetal.js"); ?>"></script> 
<script src="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/jquery.flexselect.js"); ?>"></script>
<link href="<?php echo site_url("assets/".ADMIN_DIR."search_dropdown/flexselect.css"); ?>" rel="stylesheet" />
<script>
     
      function initMap() {
      	var input2 = document.getElementById('pac-input2');
		var autocomplete2 = new google.maps.places.Autocomplete(input2);
		// Set initial restrict to the greater list of countries.
        autocomplete2.setComponentRestrictions(  {'country': ['pk']});
		autocomplete2.addListener('place_changed', function() {
        var place = autocomplete2.getPlace();
		
		 if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
		 
		 console.log(place.address_components);
		 document.getElementById('latitude2').value = place.geometry.location.lat();
		 document.getElementById('longitude2').value = place.geometry.location.lng();
		
		 var componentForm = {
				street_number: 'short_name',
				route: 'long_name',
				locality: 'long_name',
				administrative_area_level_1: 'short_name',
				country: 'long_name',
				postal_code: 'short_name'
			};
		for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType+"2").value = val;
			}
			}
		  
		  return;
		});

        
		var input = document.getElementById('pac-input');
		var autocomplete = new google.maps.places.Autocomplete(input);
		// Set initial restrict to the greater list of countries.
        autocomplete.setComponentRestrictions(  {'country': ['pk']});
		autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
		
		 if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }
		 
		 console.log(place.address_components);
		 document.getElementById('latitude').value = place.geometry.location.lat();
		 document.getElementById('longitude').value = place.geometry.location.lng();
		
		 var componentForm = {
				street_number: 'short_name',
				route: 'long_name',
				locality: 'long_name',
				administrative_area_level_1: 'short_name',
				country: 'long_name',
				postal_code: 'short_name'
			};
		for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType).value = val;
			}
			}
		  
		  return;
		});

		

        
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkc2_xU5HENksemFjVUENh15qVKPRNOyE&libraries=places&callback=initMap"
        async defer></script>
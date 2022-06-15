<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
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
          <div class="pull-right"> <!--<a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."customer_locations/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."customer_locations/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>--> </div>
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
        <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>--> 
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('location_address'); ?></th>
                <th><?php echo $this->lang->line('latitude'); ?></th>
                <th><?php echo $this->lang->line('longitude'); ?></th>
                <th><?php echo $this->lang->line('street_number'); ?></th>
                <th><?php echo $this->lang->line('route'); ?></th>
                <th><?php echo $this->lang->line('city'); ?></th>
                <th><?php echo $this->lang->line('province'); ?></th>
                <th><?php echo $this->lang->line('country'); ?></th>
                <th><?php echo $this->lang->line('postal_code'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($customer_locations as $customer_location): ?>
              <tr>
                <td><?php echo $customer_location->location_address; ?></td>
                <td><?php echo $customer_location->latitude; ?></td>
                <td><?php echo $customer_location->longitude; ?></td>
                <td><?php echo $customer_location->street_number; ?></td>
                <td><?php echo $customer_location->route; ?></td>
                <td><?php echo $customer_location->city; ?></td>
                <td><?php echo $customer_location->province; ?></td>
                <td><?php echo $customer_location->country; ?></td>
                <td><?php echo $customer_location->postal_code; ?></td>
                <td>
                  <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."customer_locations/view_customer_location/".$customer_location->customer_location_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> 
                  
                   
                  <a class="llink llink-edit" onclick="get_location_update_modal('<?php echo $customer_location->customer_location_id; ?>', '<?php echo $customer_location->location_address; ?>')"  href="javascript:void(0);"><i class="fa fa-pencil-square-o"></i></a>
                  <!--<a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."customer_locations/edit/".$customer_location->customer_location_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>--> <!--<a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."customer_locations/trash/".$customer_location->customer_location_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>--></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php echo $pagination; ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script>
function get_location_update_modal(customer_location_id, location_title){
	
	$('#customer_location_id').val(customer_location_id);
	$('#customer_location_title').html(location_title);
 $('#customer_location_modal').modal('toggle');
	}
</script>
<div class="modal" id="customer_location_modal" data-backdrop="static" >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="title">Update Customer Location</h4>
      </div>
      <div class="modal-body" id="customer_location_body">
        <h5  id="customer_location_title"></h5>
        <h5><strong>Update Customer Location Detail</strong></h5>
        <?php $edit_form_attr = array("id" => "customer_location_form");
echo form_open_multipart(ADMIN_DIR."customer_locations/update_customer_location", $edit_form_attr);  ?>
        <table width="100%">
          <tr>
            <td width="400px"><input type="hidden" name="customer_location_id" id="customer_location_id" />
              <input required="required" style="width:100% !important" id="pac-input2" class="controls" type="text" placeholder="Search Location" name="location_address"></td>
            <td ><input required="required" style="width:120px !important"  class="field" id="street_number2" placeholder="Other Address" name="street_number" >
              </input></td>
            <td ><input style="width:120px !important" class="field" id="route2" placeholder="Route" name="route" >
              </input></td>
          </tr>
          <tr>
            <td colspan="3" ><input required="required" class="field" id="locality2" name="city" readonly="readonly" >
              </input>
              <input required="required"  class="field" id="administrative_area_level_12" name="province" readonly="readonly">
              </input>
              <input required="required" class="field" id="country2" name="country" readonly="readonly">
              </input>
              <input  class="field" id="postal_code2" name="postal_code" readonly="readonly">
              <input required="required" class="field" id="latitude2" name="latitude" readonly="readonly">
              </input>
              <input required="required" class="field" id="longitude2"  name="longitude" readonly="readonly">
              </input></td>
          </tr>
          <tr>
          <td>
          <input type="submit"  name="submit" value="Update Customer Location" />
          </td>
          </tr>
        </table>
        </form>
      </div>
      <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>
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

        

		

        
      }
	  
	  $('form input').keydown(function (e) {
    if (e.keyCode == 13) {
		
        e.preventDefault();
        return false;
    }
});
	  
	  
	  
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkc2_xU5HENksemFjVUENh15qVKPRNOyE&libraries=places&callback=initMap"
        async defer></script>
        
        
        
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url(ADMIN_DIR."restaurants/view/"); ?>"><?php echo $this->lang->line('Restaurants'); ?></a>
			</li><li><?php echo $title; ?></li>
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
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
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
        <div class="row">
		<!-- MESSENGER -->
	<div class="col-md-5">
        
       

            <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/save_data", $add_form_attr);
            ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_name'), "restaurant_name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_name",
                        "id"            =>  "restaurant_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_name'),
                        "value"         =>  set_value("restaurant_name"),
                        "placeholder"   =>  $this->lang->line('restaurant_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("restaurant_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_location'), "restaurant_location", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_location",
                        "id"            =>  "restaurant_location",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_location'),
                        "value"         =>  set_value("restaurant_location"),
                        "placeholder"   =>  $this->lang->line('restaurant_location')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("restaurant_location", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_detail'), "restaurant_detail", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_detail",
                        "id"            =>  "restaurant_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_detail"),
                        "placeholder"   =>  $this->lang->line('restaurant_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("restaurant_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_contact_no'), "restaurant_contact_no", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "restaurant_contact_no",
                        "id"            =>  "restaurant_contact_no",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_contact_no'),
                        "value"         =>  set_value("restaurant_contact_no"),
                        "placeholder"   =>  $this->lang->line('restaurant_contact_no')
                    );
                    echo  form_input($number);
                ?>
                <?php echo form_error("restaurant_contact_no", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_logo'), "restaurant_logo", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_logo",
                        "id"            =>  "restaurant_logo",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('restaurant_logo'),
                        "value"         =>  set_value("restaurant_logo"),
                        "placeholder"   =>  $this->lang->line('restaurant_logo')
                    );
                    echo  form_input($file);
                ?>
                <?php echo form_error("restaurant_logo", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
   
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_start_time'), "restaurant_start_time", $label);      ?>

                <div class="col-md-10">
               <select name="restaurant_start_time" id="restaurant_start_time"  class="form-control">
    <?php for($i=0; $i<=23; $i++){ ?>
    	<option value="<?php echo $i; ?>"><?php echo date("h a", strtotime("00-00-00 $i:00:00")); ?></option>
    <?php } ?>
    </select>
                <?php echo form_error("restaurant_start_time", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_close_time'), "restaurant_close_time", $label);      ?>

                <div class="col-md-10">
               
                 <select name="restaurant_close_time" id="restaurant_close_time"  class="form-control">
    <?php for($i=0; $i<=23; $i++){ ?>
    	<option value="<?php echo $i; ?>"><?php echo date("h a", strtotime("00-00-00 $i:00:00")); ?></option>
    <?php } ?>
    </select>
               
                </div>
                
                
                
            </div>
    
            <div class="col-md-offset-2 col-md-10">
            <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Save'),
					 "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
            
            
            
            <?php
                $reset = array(
                    "type"  =>  "reset",
                    "name"  =>  "reset",
                    "value" =>  $this->lang->line('Reset'),
                    "class" =>  "btn btn-default",
                    "style" =>  ""
                );
                echo form_reset($reset); 
            ?>
            </div>
            <div style="clear:both;"></div>
            
           
            
        </div>
		
	<div class="col-md-7">
    
    <input id="pac-input" class="form-control" style="width:75% !important; margin-top:5px !important" type="text" placeholder="Search Box">
    <div id="map" style="height:400px"></div>
    <table class="table"><tr>
    <td><input required="required" type="text" class="form-control" id="restaurant_latitude" name="restaurant_latitude" value=""  /></td>
    <td><input  required="required" type="text" name="restaurant_longitude" id="restaurant_longitude" class="form-control" value="" /></td>
    </tr></table>
    <script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
		 //34.0070679,71.5071946,15z 
		 
		 var myLatlng = new google.maps.LatLng(34.0070679,71.5071946);
		 
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 34.0070679, lng: 71.5071946},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
             // url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
			  draggable:true,
              position: place.geometry.location
            }).addListener('drag', function() {
        		
				$('#restaurant_latitude').val(place.geometry.location.lat());
				$('#restaurant_longitude').val(place.geometry.location.lng());
				
				//console.log();
				//console.log();
		
			}));
			
			

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
		

var marker = new google.maps.Marker({
    position: myLatlng,
    title:"Title",
	 draggable:true,
});

// To add the marker to the map, call setMap();
marker.setMap(map);
google.maps.event.addListener(marker, 'drag', function() {
	$('#restaurant_latitude').val(marker.getPosition().lat());
	$('#restaurant_longitude').val(marker.getPosition().lng());
});
		
		
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkc2_xU5HENksemFjVUENh15qVKPRNOyE&libraries=places&callback=initAutocomplete"
         async defer></script>
     <?php echo form_close(); ?>
    
    </div>
    </div>
    </div>
	</div>
	</div>
	<!-- /MESSENGER -->
</div>

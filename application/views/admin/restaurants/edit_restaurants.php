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
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/update_data/$restaurants->restaurant_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("restaurant_id", $restaurants->restaurant_id); ?>
            
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
                        "value"         =>  set_value("restaurant_name", $restaurants->restaurant_name),
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
                        "value"         =>  set_value("restaurant_location", $restaurants->restaurant_location),
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
                        "value"         => set_value("restaurant_detail", $restaurants->restaurant_detail),
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
                        "value"         =>  set_value("restaurant_contact_no", $restaurants->restaurant_contact_no),
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
                    );  /*echo form_label($this->lang->line('restaurant_logo')."<br />".file_type(base_url("assets/uploads/".$restaurants->restaurant_logo), 30, 30), "restaurant_logo", $label);*/
					
					echo form_label(file_type(base_url("assets/uploads/".$restaurants->restaurant_logo), 30, 30), "restaurant_logo", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_logo",
                        "id"            =>  "restaurant_logo",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('restaurant_logo'),
                        "value"         =>  set_value("restaurant_logo", $restaurants->restaurant_logo),
                        "placeholder"   =>  $this->lang->line('restaurant_logo')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$restaurants->restaurant_logo")); ?>-->
                    
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
    	<option <?php if($restaurants->restaurant_start_time==$i){ ?> selected="selected" <?php } ?> value="<?php echo $i; ?>"><?php echo date("h a", strtotime("00-00-00 $i:00:00")); ?></option>
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
    	<option <?php if($restaurants->restaurant_close_time==$i){ ?> selected="selected" <?php } ?>  value="<?php echo $i; ?>"><?php echo date("h a", strtotime("00-00-00 $i:00:00")); ?></option>
    <?php } ?>
    </select>
                <?php echo form_error("restaurant_close_time", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="col-md-offset-2 col-md-10">
            <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
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
    
    <div id="floating-panel">
      <input id="address" type="textbox" placeholder="Enter Location Name ">
      <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map" style="height:400px"></div>
    
    
    
    <table width="100%">
              <tr>
                <td>
                
                      <input style="width:100% !important" id="restaurant_address" class="controls" type="text" name="restaurant_address" placeholder="Address" value="<?php echo $restaurants->restaurant_address; ?>"></input>
                      <br />
                      <input style="width:120px !important"  class="field" id="street_number" placeholder="Street Address" name="restaurant_street_number" value="<?php echo $restaurants->restaurant_street_number; ?>" >
                        </input>
                      <input style="width:120px !important" class="field" id="route" placeholder="Route"  name="restaurant_route" value="<?php echo $restaurants->restaurant_route; ?>">
                        </input>
                      <input class="field" id="locality" name="restaurant_city" value="<?php echo $restaurants->restaurant_city; ?>" readonly="readonly">
                        </input>
                        <input class="field" id="administrative_area_level_1" name="restaurant_province" value="<?php echo $restaurants->restaurant_province; ?>" readonly="readonly">
                        </input>
                        <input class="field" id="country"  name="restaurant_country" value="<?php echo $restaurants->restaurant_country; ?>" readonly="readonly">
                        </input>
                        <input class="field" id="postal_code" name="restaurant_postal_code" readonly="readonly">
                        <input class="field" id="restaurant_latitude" name="restaurant_latitude" value="<?php echo $restaurants->restaurant_latitude; ?>" readonly="readonly">
                        </input>
                        <input class="field" id="restaurant_longitude" name="restaurant_longitude" value="<?php echo $restaurants->restaurant_longitude; ?>" readonly="readonly">
                        </input></td>
                        
                        
                    </tr>
                  </table>
                  
              
   
    <script>
	var infowindow;
	var map;
	 var geocoder;
	 var marker;

      function initMap() {
		  
         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: {lat: <?php echo $restaurants->restaurant_latitude; ?>, lng: <?php echo $restaurants->restaurant_longitude; ?>}
        });
		
		 infowindow = new google.maps.InfoWindow({size: new google.maps.Size(150,50)});
 			
		var marker = new google.maps.Marker({
          position: {lat: <?php echo $restaurants->restaurant_latitude; ?>, lng: <?php echo $restaurants->restaurant_longitude; ?>},
		   draggable: true,
          map: map,
          title: 'Hello World!'
        });
		
		
		google.maps.event.addListener(marker, 'dragend', function() {
              // updateMarkerStatus('Drag ended');
              geocodePosition(marker.getPosition());
            });
            google.maps.event.addListener(marker, 'click', function() {
              if (marker.formatted_address) {
                infowindow.setContent('<?php echo $restaurants->restaurant_name; ?>');
              } else  {
                infowindow.setContent('<?php echo $restaurants->restaurant_name; ?>');
              }
              infowindow.open(map, marker);
            });
            google.maps.event.trigger(marker, 'click');
		
         geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }
	  
	  
	  function geocodePosition(pos) {
		  
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
		
		console.log(responses[0]);
		
		
		var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
			   
	
	 for (var i = 0; i < responses[0].address_components.length; i++) {
          var addressType = responses[0].address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = responses[0].address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
		$('#restaurant_address').val(responses[0].formatted_address);
		$('#restaurant_latitude').val(responses[0].geometry.location.lat());
		$('#restaurant_longitude').val(responses[0].geometry.location.lng());
		
		
		
      marker.formatted_address = '<?php echo $restaurants->restaurant_name; ?>';
    } else {
      marker.formatted_address = 'Cannot determine address at this location.';
    }
    infowindow.setContent('<?php echo $restaurants->restaurant_name; ?>');
    infowindow.open(map, marker);
  });
}


      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
             marker = new google.maps.Marker({
              map: resultsMap,
			  draggable: true,
              position: results[0].geometry.location
            });
			
			
	console.log(results[0].name);
			
			
			var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
			   
	
	 for (var i = 0; i < results[0].address_components.length; i++) {
          var addressType = results[0].address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = results[0].address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
		
		
		$('#restaurant_address').val(results[0].formatted_address);
			$('#restaurant_latitude').val(results[0].geometry.location.lat());
				$('#restaurant_longitude').val(results[0].geometry.location.lng());
			
			
			
			
			google.maps.event.addListener(marker, 'dragend', function() {
              // updateMarkerStatus('Drag ended');
              geocodePosition(marker.getPosition());
            });
            google.maps.event.addListener(marker, 'click', function() {
              if (marker.formatted_address) {
                infowindow.setContent(marker.formatted_address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
              } else  {
                infowindow.setContent(address+"<br>coordinates: "+marker.getPosition().toUrlValue(6));
              }
              infowindow.open(map, marker);
            });
            google.maps.event.trigger(marker, 'click');
			
			
			
			
			
			
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    
    
     
	  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkc2_xU5HENksemFjVUENh15qVKPRNOyE&callback=initMap">
    </script>

     <?php echo form_close(); ?>
    
    </div>
    </div>
    </div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>


<div class="modal top_model" id="open_modal"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="open_model_title">Title</h4>
      </div>
      <div class="modal-body" >
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue">
              <div class="box-body" id="open_model_body">
               
              </div>
            </div>
          </div>
         
        </div>
      </div> 
    </div>
  </div>
</div>
<script>

function open_modal(modal_title, controller, con_function, id){
	if(id){ id=id; }else{ id=0; }
		$.ajax({
			type: "POST",
			url: site_url + "/"+controller+"/"+con_function+"/",
			data: {restaurant_id : '<?php echo $restaurant_id ?>', id:id}
		}).done(function(data) {
			 $('#open_model_body').html(data);
		});
	
	$('#open_model_title').html(modal_title);
	$('#open_modal').modal('show');
	
	}










function get_food_edit_form(restaurant_food_menu_id){
	$.ajax({
        type: "POST",
        url: site_url + "/restaurants/get_food_edit_form/"+restaurant_food_menu_id,
        data: {restaurant_id : '<?php echo $restaurant_id ?>'}
    }).done(function(data) {
		$('#food_edit_form').html(data);
    });
	$('#get_food_edit_form').modal('toggle');
	}
	<?php if($restaurant_user){ ?> 
	function get_user_edit_form(){
		$('#restaurant_form_title').html('Update Restaurant Manager Profile');
	$.ajax({
        type: "POST",
        url: site_url + "/users/get_user_edit_form/",
        data: { 
		 restaurant_id : '<?php echo $restaurant_id ?>', 
		 role_id : '23',
		 user_id : '<?php echo $restaurant_user->user_id ?>'}
    }).done(function(data) {
		$('#restaurant_user_form').html(data);
    });
	$('#restaurant_form').modal('toggle');
	}
	<?php }else{ ?> 
	
	
	function get_user_add_form(){
		$('#restaurant_form_title').html('Add Restaurant Manager Profile');
		
	$.ajax({
        type: "POST",
        url: site_url + "/users/get_user_add_form/",
        data: { restaurant_id : '<?php echo $restaurant_id ?>', role_id : '23'}
    }).done(function(data) {
		$('#restaurant_user_form').html(data);
    });
	$('#restaurant_form').modal('toggle');
	}
	<?php }?> 
	
function restaurant_category_edit(restaurant_food_category_id){
//restaurant_category_edit_body
$('#restaurant_category_edit_title').html('Edit Food Category');
$.ajax({
        type: "POST",
        url: site_url + "/restaurants/get_restaurant_food_categorie_edit_form/",
        data: { restaurant_id : '<?php echo $restaurant_id ?>',
		restaurant_food_category_id:restaurant_food_category_id
		}
    }).done(function(data) {
		$('#restaurant_category_edit_body').html(data);
    });
$('#restaurant_category_edit').modal('toggle');
}	

</script>



<div class="modal top_model" id="restaurant_category_edit"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="restaurant_category_edit_title">Title</h4>
      </div>
      <div class="modal-body" >
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue">
              <div class="box-body" id="restaurant_category_edit_body">
               
              </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <!--<div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>--> 
    </div>
  </div>
</div>




<div class="modal top_model" id="restaurant_form"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="restaurant_form_title">Title</h4>
      </div>
      <div class="modal-body" >
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue">
              <div class="box-body" id="restaurant_user_form">
               
              </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <!--<div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>--> 
    </div>
  </div>
</div>
<div class="modal top_model" id="get_food_edit_form"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Edit Food</h4>
      </div>
      <div class="modal-body" id="form_add_food_category">
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue">
              <div class="box-body" id="food_edit_form"> </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <!--<div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>--> 
    </div>
  </div>
</div>
<div class="modal top_model" id="add_food_category"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Food Category</h4>
      </div>
      <div class="modal-body" id="form_add_food_category">
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue" id="messenger">
              <div class="box-body">
                <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/add_food_category/".$restaurant_id, $add_form_attr);
            ?>
            
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_category'), "restaurant_food_category", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_food_category",
                        "id"            =>  "restaurant_food_category",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_category'),
                        "value"         =>  set_value("restaurant_food_category"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_category')
                    );
                    echo  form_input($text);
                ?>
                    <?php echo form_error("restaurant_food_category", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_category_image'), "restaurant_food_category_image", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_food_category_image",
                        "id"            =>  "restaurant_food_category_image",
                        "class"         =>  "form-control",
                        "style"         =>  "",
						"title"         =>  $this->lang->line('restaurant_food_category_image'),
                        "value"         =>  set_value("restaurant_food_category_image"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_category_image')
                    );
                    echo  form_input($file);
                ?>
                    <?php echo form_error("restaurant_food_category_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
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
                <?php echo form_close(); ?> </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>
    </div>
  </div>
</div>
<div class="modal top_model" id="add_food_menu_with_food_category"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Food Menu</h4>
      </div>
      <div class="modal-body" id="add_food_body">
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue" id="messenger">
              <div class="box-body">
                <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/add_food_menu/".$restaurant_id, $add_form_attr);
            ?>
                <input type="hidden"  name="restaurant_id" value="<?php echo $restaurant_id; ?>" />
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('restaurant_food_category'), "Restaurant Food Category Id" , $label);
                ?>
                  <div class="col-md-8">
                    <?php
                    echo form_dropdown("restaurant_food_category_id", $restaurant_food_categories_list, "", "class=\"form-control\" required style=\"\"");
                    ?>
                  </div>
                  <?php echo form_error("restaurant_food_category_id", "<p class=\"text-danger\">", "</p>"); ?> </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_name'), "restaurant_food_name", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_food_name",
                        "id"            =>  "restaurant_food_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_name'),
                        "value"         =>  set_value("restaurant_food_name"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_name')
                    );
                    echo  form_input($text);
                ?>
                    <?php echo form_error("restaurant_food_name", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_price'), "restaurant_food_price", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "restaurant_food_price",
                        "id"            =>  "restaurant_food_price",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_price'),
                        "value"         =>  set_value("restaurant_food_price"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_price')
                    );
                    echo  form_input($number);
                ?>
                    <?php echo form_error("restaurant_food_price", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_quantity'), "restaurant_food_quantity", $label);
                ?>
                  <div class="col-md-8">
                    <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_quantity",
                        "id"            =>  "restaurant_food_quantity",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_quantity'),
						
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_quantity"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_quantity')
                    );
                    echo form_textarea($textarea);
                ?>
                    <?php echo form_error("restaurant_food_quantity", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_description'), "restaurant_food_description", $label);
                ?>
                  <div class="col-md-8">
                    <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_description",
                        "id"            =>  "restaurant_food_description",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_description'),
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_description"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_description')
                    );
                    echo form_textarea($textarea);
                ?>
                    <?php echo form_error("restaurant_food_description", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_image'), "restaurant_food_image", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_food_image",
                        "id"            =>  "restaurant_food_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('restaurant_food_image'),
                        "value"         =>  set_value("restaurant_food_image"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_image')
                    );
                    echo  form_input($file);
                ?>
                    <?php echo form_error("restaurant_food_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
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
                <?php echo form_close(); ?> </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>
    </div>
  </div>
</div>
<div class="modal top_model" id="add_food_menu"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add Food Menu</h4>
      </div>
      <div class="modal-body" id="add_food_body">
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue" id="messenger">
              <div class="box-body">
                <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/add_food_menu/".$restaurant_id, $add_form_attr);
            ?>
                <input type="hidden" name="restaurant_food_category_id" id="restaurant_food_category_id" value="" />
                <input type="hidden"  name="restaurant_id" value="<?php echo $restaurant_id; ?>" />
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_name'), "restaurant_food_name", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_food_name",
                        "id"            =>  "restaurant_food_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_name'),
                        "value"         =>  set_value("restaurant_food_name"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_name')
                    );
                    echo  form_input($text);
                ?>
                    <?php echo form_error("restaurant_food_name", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_price'), "restaurant_food_price", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "restaurant_food_price",
                        "id"            =>  "restaurant_food_price",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_price'),
                        "value"         =>  set_value("restaurant_food_price"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_price')
                    );
                    echo  form_input($number);
                ?>
                    <?php echo form_error("restaurant_food_price", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_quantity'), "restaurant_food_quantity", $label);
                ?>
                  <div class="col-md-8">
                    <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_quantity",
                        "id"            =>  "restaurant_food_quantity",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_quantity'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_quantity"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_quantity')
                    );
                    echo form_textarea($textarea);
                ?>
                    <?php echo form_error("restaurant_food_quantity", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_description'), "restaurant_food_description", $label);
                ?>
                  <div class="col-md-8">
                    <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_description",
                        "id"            =>  "restaurant_food_description",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_description'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_description"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_description')
                    );
                    echo form_textarea($textarea);
                ?>
                    <?php echo form_error("restaurant_food_description", "<p class=\"text-danger\">", "</p>"); ?> </div>
                </div>
                <div class="form-group">
                  <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_image'), "restaurant_food_image", $label);      ?>
                  <div class="col-md-8">
                    <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_food_image",
                        "id"            =>  "restaurant_food_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('restaurant_food_image'),
                        "value"         =>  set_value("restaurant_food_image"),
                        "placeholder"   =>  $this->lang->line('restaurant_food_image')
                    );
                    echo  form_input($file);
                ?>
                    <?php echo form_error("restaurant_food_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
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
                <?php echo form_close(); ?> </div>
            </div>
          </div>
          <!-- /MESSENGER --> 
        </div>
      </div>
      <div class="modal-footer"> <a  href="#" data-dismiss="modal" class="btn btn-primary" >Close</a></div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."restaurants/view/"); ?>"><?php echo $this->lang->line('Restaurants'); ?></a> </li>
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
          <div class="pull-right"> 
    <?php if($restaurant_user){ ?> 
	<button  onclick="open_modal('Add Restaurant Manager Profile','restaurants', 'get_user_edit_form','<?php echo $restaurant_user->user_id ?>')"  class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i> Edit Manager</button>
	<?php }else{ ?> 
	<button   onclick="open_modal('Add Restaurant Manager Profile','restaurants', 'get_user_add_form' )"  class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Manager</button>
	<?php }?>     
    
   
   <a onclick="open_modal('Add Restaurant Manager Profile','restaurants', 'get_user_add_form' )"   data-toggle="modal" href="#add_food_category" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Food Category</a> <a   data-toggle="modal" href="#add_food_menu_with_food_category" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Food With New Category</a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/food_menu_trashed/$restaurant_id"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-3">
    <div class="box border blue" id="messenger"> 
      <!--<div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
        
      </div>-->
      <div class="box-body">
        <div class="table-responsive">
          <div style=" text-align:center; padding:10px;">
            <?php
                    echo file_type(base_url("assets/uploads/".$restaurants[0]->restaurant_logo),true, 100, 100);
                ?>
          </div>
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($restaurants as $restaurants): ?>
              <tr>
                <th><?php echo $this->lang->line('restaurant_name'); ?></th>
                <td><?php echo $restaurants->restaurant_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_location'); ?></th>
                <td><?php echo $restaurants->restaurant_location; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_detail'); ?></th>
                <td><?php echo $restaurants->restaurant_detail; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_contact_no'); ?></th>
                <td><?php echo $restaurants->restaurant_contact_no; ?></td>
              </tr>
              <!--<tr>
                <th>Restaurant Logo</th>
                <td><?php
                    echo file_type(base_url("assets/uploads/".$restaurants->restaurant_logo));
                ?></td>
              </tr>-->
              <tr>
                <th><?php echo $this->lang->line('restaurant_start_time'); ?></th>
                <td><?php echo $restaurants->restaurant_start_time; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_close_time'); ?></th>
                <td><?php echo $restaurants->restaurant_close_time; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <td><?php echo status($restaurants->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> Food Menu</h4>
      </div>
      <script>
      function set_restaurant_food_category_id(restaurant_food_category_id){
		  $('#restaurant_food_category_id').val(restaurant_food_category_id);
		  
		  }
      </script>
      <div class="box-body">
        <div class="table-responsive">
          <?php 
		  foreach($restaurant_food_categories as $restaurant_food_category){ ?>
          <h4 class="pull-left"><?php echo $restaurant_food_category->restaurant_food_category; ?>
          <?php if($restaurant_food_category->restaurant_id==$restaurant_id){ ?><a style="font-size:13px !important" href="javascript:;" onclick="restaurant_category_edit('<?php echo $restaurant_food_category->restaurant_food_category_id; ?>')" >Edit</a><?php } ?>
          </h4>
          
          <a onclick="set_restaurant_food_category_id('<?php echo $restaurant_food_category->restaurant_food_category_id;  ?>');"  data-toggle="modal" href="#add_food_menu" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"></i> Add Food</a>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('restaurant_food_name'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_price'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_quantity'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_description'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_image'); ?></th>
                <!--<th><?php echo $this->lang->line('restaurant_food_category'); ?></th>--> 
                <!-- <th><?php echo $this->lang->line('restaurant_name'); ?></th>-->
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count =1;
			  foreach($restaurant_food_category->restaurant_food_menus as $restaurant_food_menu): ?>
              <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_name; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_price; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_quantity; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_description; ?></td>
                <td><?php
                echo file_type(base_url("assets/uploads/".$restaurant_food_menu->restaurant_food_image));
            ?></td>
                <!--<td><?php echo $restaurant_food_menu->restaurant_food_category; ?></td>--> 
                <!-- <td><?php echo $restaurant_food_menu->restaurant_name; ?></td>-->
                <td><?php echo status($restaurant_food_menu->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($restaurant_food_menu->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/food_menu_publish/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($restaurant_food_menu->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/food_menu_draft/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurant_food_menu/".$restaurant_food_menu->restaurant_food_menu_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> --> 
                  <a href="javascript:;" onclick="get_food_edit_form('<?php echo $restaurant_food_menu->restaurant_food_menu_id ?>')" ><i class="fa fa-pencil-square-o"></i></a> <!--<a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."restaurant_food_menus/edit/".$restaurant_food_menu->restaurant_food_menu_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>--> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."restaurants/food_menu_trash/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php 
		}
		  //echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- /MESSENGER --> 
</div>

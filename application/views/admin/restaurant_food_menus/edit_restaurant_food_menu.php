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
				<a href="<?php echo site_url(ADMIN_DIR."restaurant_food_menus/view/"); ?>"><?php echo $this->lang->line('Restaurant Food Menus'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurant_food_menus/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurant_food_menus/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurant_food_menus/update_data/$restaurant_food_menu->restaurant_food_menu_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("restaurant_food_menu_id", $restaurant_food_menu->restaurant_food_menu_id); ?>
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('restaurant_food_category'), "Restaurant Food Category Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("restaurant_food_category_id", $restaurant_food_categories, $restaurant_food_menu->restaurant_food_category_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("restaurant_food_category_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('restaurant_name'), "Restaurant Id" , $label);
                ?>

                <div class="col-md-10">
                    <?php
                    echo form_dropdown("restaurant_id", $restaurants, $restaurant_food_menu->restaurant_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("restaurant_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_name'), "restaurant_food_name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "restaurant_food_name",
                        "id"            =>  "restaurant_food_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_name'),
                        "value"         =>  set_value("restaurant_food_name", $restaurant_food_menu->restaurant_food_name),
                        "placeholder"   =>  $this->lang->line('restaurant_food_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("restaurant_food_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('restaurant_food_price'), "restaurant_food_price", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "restaurant_food_price",
                        "id"            =>  "restaurant_food_price",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('restaurant_food_price'),
                        "value"         =>  set_value("restaurant_food_price", $restaurant_food_menu->restaurant_food_price),
                        "placeholder"   =>  $this->lang->line('restaurant_food_price')
                    );
                    echo  form_input($number);
                ?>
                <?php echo form_error("restaurant_food_price", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_quantity'), "restaurant_food_quantity", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_quantity",
                        "id"            =>  "restaurant_food_quantity",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_quantity'),
						
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_quantity", $restaurant_food_menu->restaurant_food_quantity),
                        "placeholder"   =>  $this->lang->line('restaurant_food_quantity')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("restaurant_food_quantity", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('restaurant_food_description'), "restaurant_food_description", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "restaurant_food_description",
                        "id"            =>  "restaurant_food_description",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('restaurant_food_description'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("restaurant_food_description", $restaurant_food_menu->restaurant_food_description),
                        "placeholder"   =>  $this->lang->line('restaurant_food_description')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("restaurant_food_description", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('restaurant_food_image')."<br />".file_type(base_url("assets/uploads/".$restaurant_food_menu->restaurant_food_image)), "restaurant_food_image", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "restaurant_food_image",
                        "id"            =>  "restaurant_food_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('restaurant_food_image'),
                        "value"         =>  set_value("restaurant_food_image", $restaurant_food_menu->restaurant_food_image),
                        "placeholder"   =>  $this->lang->line('restaurant_food_image')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$restaurant_food_menu->restaurant_food_image")); ?>-->
                    
                <?php echo form_error("restaurant_food_image", "<p class=\"text-danger\">", "</p>"); ?>
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
            
            <?php echo form_close(); ?>
            
        </div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>

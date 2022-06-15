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
                <div class="col-md-12">
                  <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Save'),
					 "class" =>  "btn btn-primary pull-right",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
              
                </div>
                <div style="clear:both;"></div>
                <?php echo form_close(); ?> </div>
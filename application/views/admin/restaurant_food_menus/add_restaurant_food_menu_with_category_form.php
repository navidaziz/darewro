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
                        "value"         => set_value("restaurant_food_quantity"),
                        "placeholder"   =>  'Small'
                    );
                    echo form_input($textarea);
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
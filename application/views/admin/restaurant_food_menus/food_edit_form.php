<div class="box-body">

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."restaurants/update_restaurant_food_data/$restaurant_food_menu->restaurant_food_menu_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("restaurant_food_menu_id", $restaurant_food_menu->restaurant_food_menu_id); ?>
             <?php echo form_hidden("restaurant_id", $restaurant_id); ?>
            
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
                    echo form_dropdown("restaurant_food_category_id", $restaurant_food_categories, $restaurant_food_menu->restaurant_food_category_id, "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("restaurant_food_category_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div>
            
            <input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo $restaurant_food_menu->restaurant_id; ?>" />
            
            
            
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
                        "value"         => set_value("restaurant_food_quantity", $restaurant_food_menu->restaurant_food_quantity),
                        "placeholder"   =>  'Small'
                    );
                    echo form_input($textarea);
                ?>
                <?php echo form_error("restaurant_food_quantity", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
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
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('restaurant_food_image')."<br />".file_type(base_url("assets/uploads/".$restaurant_food_menu->restaurant_food_image)), "restaurant_food_image", $label);     ?>

                <div class="col-md-8">
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
    
            <div class="col-md-12">
            <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
                    "class" =>  "btn btn-primary pull-right",
                    "style" =>  " margin-left:10px !important"
                );
                echo form_submit($submit); 
            ?>
            
            
            
            <?php
                $reset = array(
                    "type"  =>  "reset",
                    "name"  =>  "reset",
                    "value" =>  $this->lang->line('Reset'),
                    "class" =>  "btn btn-default pull-right",
                    "style" =>  ""
                );
                echo form_reset($reset); 
            ?>
            </div>
            <div style="clear:both;"></div>
            
            <?php echo form_close(); ?>
            
        </div>
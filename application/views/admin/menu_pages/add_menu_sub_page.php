<div class="box-body">

            <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."menu_sub_pages/save_data", $add_form_attr);
            ?>
            <input type="hidden" name="menu_page_id" value="<?php echo $menu_page_id; ?>" />
            
            
            
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-4 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_name'), "Page Id" , $label);
                ?>

                <div class="col-md-8">
                    <?php
                    echo form_dropdown("page_id", $pages, "", "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("page_id", "<p class=\"text-danger\">", "</p>"); ?>
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
            
            <?php echo form_close(); ?>
            
        </div>
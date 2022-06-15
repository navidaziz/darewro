<div class="box border blue" >
		
        <div class="box-body">

            <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."page_contents/save_data", $add_form_attr);
            ?>
            <input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
            
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('page_content_title'), "page_content_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "page_content_title",
                        "id"            =>  "page_content_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('page_content_title'),
                        "value"         =>  set_value("page_content_title"),
                        "placeholder"   =>  $this->lang->line('page_content_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("page_content_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('page_content_sub_title'), "page_content_sub_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "page_content_sub_title",
                        "id"            =>  "page_content_sub_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('page_content_sub_title'),
                        "value"         =>  set_value("page_content_sub_title"),
                        "placeholder"   =>  $this->lang->line('page_content_sub_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("page_content_sub_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('page_content_detail'), "page_content_detail", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "page_content_detail",
                        "id"            =>  "page_content_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('page_content_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("page_content_detail"),
                        "placeholder"   =>  $this->lang->line('page_content_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("page_content_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('attachment'), "attachment", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "attachment",
                        "id"            =>  "attachment",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('attachment'),
                        "value"         =>  set_value("attachment"),
                        "placeholder"   =>  $this->lang->line('attachment')
                    );
                    echo  form_input($file);
                ?>
                <?php echo form_error("attachment", "<p class=\"text-danger\">", "</p>"); ?>
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
            
            <?php echo form_close(); ?>
            
        </div>
		
	</div>
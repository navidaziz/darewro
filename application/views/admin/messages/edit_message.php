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
				<a href="<?php echo site_url(ADMIN_DIR."messages/view/"); ?>"><?php echo $this->lang->line('Messages'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."messages/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."messages/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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

            <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."messages/update_data/$message->message_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("message_id", $message->message_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('name'), "name", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "name",
                        "id"            =>  "name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('name'),
                        "value"         =>  set_value("name", $message->name),
                        "placeholder"   =>  $this->lang->line('name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('email_address'), "email_address", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "email_address",
                        "id"            =>  "email_address",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('email_address'),
                        "value"         =>  set_value("email_address", $message->email_address),
                        "placeholder"   =>  $this->lang->line('email_address')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("email_address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('mobile_number'), "mobile_number", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "mobile_number",
                        "id"            =>  "mobile_number",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('mobile_number'),
                        "value"         =>  set_value("mobile_number", $message->mobile_number),
                        "placeholder"   =>  $this->lang->line('mobile_number')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("mobile_number", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('moving_from'), "moving_from", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "moving_from",
                        "id"            =>  "moving_from",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('moving_from'),
                        "value"         =>  set_value("moving_from", $message->moving_from),
                        "placeholder"   =>  $this->lang->line('moving_from')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("moving_from", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('moving_to'), "moving_to", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "moving_to",
                        "id"            =>  "moving_to",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('moving_to'),
                        "value"         =>  set_value("moving_to", $message->moving_to),
                        "placeholder"   =>  $this->lang->line('moving_to')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("moving_to", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('movement_expected_date'), "movement_expected_date", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "movement_expected_date",
                        "id"            =>  "movement_expected_date",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('movement_expected_date'),
                        "value"         =>  set_value("movement_expected_date", $message->movement_expected_date),
                        "placeholder"   =>  $this->lang->line('movement_expected_date')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("movement_expected_date", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('other_detail'), "other_detail", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "other_detail",
                        "id"            =>  "other_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('other_detail'),
                        "value"         =>  set_value("other_detail", $message->other_detail),
                        "placeholder"   =>  $this->lang->line('other_detail')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("other_detail", "<p class=\"text-danger\">", "</p>"); ?>
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

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
				<a href="<?php echo site_url(ADMIN_DIR."orders/view/"); ?>"><?php echo $this->lang->line('Orders'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."orders/save_data", $add_form_attr);
            ?>
            
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('order_type'), "order_type", $label);
                ?>

                <div class="col-md-8">
                    <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "order_type",
                                "id"          => "order_type",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );
                            echo form_radio($data)."<label for=\"order_type\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("order_type", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('customer_id'), "customer_id", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "customer_id",
                        "id"            =>  "customer_id",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('customer_id'),
                        "value"         =>  set_value("customer_id"),
                        "placeholder"   =>  $this->lang->line('customer_id')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("customer_id", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('order_detail'), "order_detail", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "order_detail",
                        "id"            =>  "order_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('order_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("order_detail"),
                        "placeholder"   =>  $this->lang->line('order_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("order_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('order_picking_address'), "order_picking_address", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "order_picking_address",
                        "id"            =>  "order_picking_address",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('order_picking_address'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("order_picking_address"),
                        "placeholder"   =>  $this->lang->line('order_picking_address')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("order_picking_address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('order_drop_address'), "order_drop_address", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "order_drop_address",
                        "id"            =>  "order_drop_address",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('order_drop_address'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("order_drop_address"),
                        "placeholder"   =>  $this->lang->line('order_drop_address')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("order_drop_address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('delivery_charges'), "delivery_charges", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "delivery_charges",
                        "id"            =>  "delivery_charges",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('delivery_charges'),
                        "value"         =>  set_value("delivery_charges"),
                        "placeholder"   =>  $this->lang->line('delivery_charges')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("delivery_charges", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('delivery_time'), "delivery_time", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "delivery_time",
                        "id"            =>  "delivery_time",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('delivery_time'),
                        "value"         =>  set_value("delivery_time"),
                        "placeholder"   =>  $this->lang->line('delivery_time')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("delivery_time", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('order_status'), "order_status", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "order_status",
                        "id"            =>  "order_status",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('order_status'),
                        "value"         =>  set_value("order_status"),
                        "placeholder"   =>  $this->lang->line('order_status')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("order_status", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('comment'), "comment", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "comment",
                        "id"            =>  "comment",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('comment'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("comment"),
                        "placeholder"   =>  $this->lang->line('comment')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("comment", "<p class=\"text-danger\">", "</p>"); ?>
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
	</div>
	<!-- /MESSENGER -->
</div>

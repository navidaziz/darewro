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
				<a href="<?php echo site_url(ADMIN_DIR."promo_codes/view/"); ?>"><?php echo $this->lang->line('Promo Codes'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."promo_codes/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."promo_codes/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR."promo_codes/update_data/$promo_code->promo_code_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("promo_code_id", $promo_code->promo_code_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('promo_code'), "promo_code", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "promo_code",
                        "id"            =>  "promo_code",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('promo_code'),
                        "value"         =>  set_value("promo_code", $promo_code->promo_code),
                        "placeholder"   =>  $this->lang->line('promo_code')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("promo_code", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            
    
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('discount_operation'), "discount_operation", $label);
                ?>

                <div class="col-md-8">
                    <?php 
					$options = array("%" => "Percentage", "-" => "Fixed");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "discount_operation",
                                "id"          => "discount_operation",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );if($option_value == $promo_code->discount_operation){
                                    $data["checked"] = TRUE;
                                }
                            echo form_radio($data)."<label for=\"discount_operation\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("discount_operation", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('discount_amount'), "discount_amount", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "discount_amount",
                        "id"            =>  "discount_amount",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('discount_amount'),
                        "value"         =>  set_value("discount_amount", $promo_code->discount_amount),
                        "placeholder"   =>  $this->lang->line('discount_amount')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("discount_amount", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            
    
    		<div class="form-group">
            
                <label for="expiry" class="col-md-2 control-label" style="">Expiry</label>
                <div class="col-md-4">
                <input type="date" name="expiry" 
                value="<?php echo date("Y-m-d", strtotime($promo_code->expiry."00:00:00")); ?>" id="expiry" class="form-control" style="" required="required" title="Expiry" placeholder="Expiry">  
                </div>
                <!-- <div class="col-md-4">
                <input type="time" name="expiry_time" value="<?php echo set_value("expiry", $promo_code->expiry); ?>" id="expiry_time" class="form-control" style="" required="required" title="Expiry" placeholder="Expiry"> 
                                              </div>-->
                
                
                
            </div>
    
    <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('min_basket_cost'), "min_basket_cost", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "min_basket_cost",
                        "id"            =>  "min_basket_cost",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('min_basket_cost'),
                        "value"         =>  set_value("min_basket_cost", $promo_code->min_basket_cost),
                        "placeholder"   =>  $this->lang->line('min_basket_cost')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("min_basket_cost", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
    <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('num_vouchers'), "num_vouchers", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "num_vouchers",
                        "id"            =>  "num_vouchers",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('num_vouchers'),
                        "value"         =>  set_value("num_vouchers", $promo_code->num_vouchers),
                        "placeholder"   =>  $this->lang->line('num_vouchers')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("num_vouchers", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <!--<div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('expiry'), "expiry", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "date",
                        "name"          =>  "expiry",
                        "id"            =>  "expiry",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('expiry'),
                        "value"         =>  set_value("expiry", $promo_code->expiry),
                        "placeholder"   =>  $this->lang->line('expiry')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("expiry", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>-->
    
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

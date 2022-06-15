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
				<a href="<?php echo site_url(ADMIN_DIR."customers/view/"); ?>"><?php echo $this->lang->line('Customers'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."customers/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."customers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
	<div class="col-md-6">
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
                echo form_open_multipart(ADMIN_DIR."customers/update_data/$customer->customer_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("customer_id", $customer->customer_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('mobile_number'), "mobile_number", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "mobile_number",
                        "id"            =>  "mobile_number",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('mobile_number'),
                        "value"         =>  set_value("mobile_number", $customer->mobile_number),
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
                    ); echo form_label($this->lang->line('customer_name'), "customer_name", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "customer_name",
                        "id"            =>  "customer_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('customer_name'),
                        "value"         =>  set_value("customer_name", $customer->customer_name),
                        "placeholder"   =>  $this->lang->line('customer_name')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("customer_name", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('comment'), "comment", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "comment",
                        "id"            =>  "comment",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('comment'),
                        "value"         =>  set_value("comment", $customer->comment),
                        "placeholder"   =>  $this->lang->line('comment')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("comment", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('customer_email_address'), "customer_email_address", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $email = array(
                        "type"          =>  "email",
                        "name"          =>  "customer_email_address",
                        "id"            =>  "customer_email_address",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('customer_email_address'),
                        "value"         =>  set_value("customer_email_address", $customer->customer_email_address),
                        "placeholder"   =>  $this->lang->line('customer_email_address')
                    );
                    echo  form_input($email);
                ?>
                <?php echo form_error("customer_email_address", "<p class=\"text-danger\">", "</p>"); ?>
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
  <div class="col-md-6">
  <div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> Update Customer Addresses</h4>
			
		</div>
        <div class="box-body">
  
  
  
     <?php $query="SELECT * FROM `customer_locations` WHERE `customer_id`=".$this->db->escape($customer->customer_id).";";
		$query_result = $this->db->query($query);
		$customer_locations = $query_result->result();
		//var_dump($customer_locations);
		$count=1;
		foreach($customer_locations as $customer_location){ ?>
                <?php //echo $customer_location->location_address; ?><br />
                <form action="<?php echo site_url(ADMIN_DIR."customers/update_customer_location/$customer->customer_id"); ?>" method="post">
                <?php echo $count++; ?>. <input type="hidden" name="customer_location_id" value="<?php echo $customer_location->customer_location_id; ?>" />
                <input style="width:300px" type="text" name="customer_location" value="<?php echo $customer_location->location_address; ?>" />
                <input type="submit" name="update_location" value="Update" />
                <a  href="<?php echo site_url(ADMIN_DIR."customers/delete_customer_location/$customer->customer_id/$customer_location->customer_location_id"); ?>" onclick="return confirm('Are you sure? you want to delete the customer address.')" >Delete</a>
                </form>
    <?php } ?>
    </div>
    </div>
    </div>
    
	<!-- /MESSENGER -->
</div>

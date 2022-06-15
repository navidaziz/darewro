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
				<a href="<?php echo site_url(ADMIN_DIR."slider_banners/view/"); ?>"><?php echo $this->lang->line('Slider Banners'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."slider_banners/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."slider_banners/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR."slider_banners/update_data/$slider_banner->slider_banner_id", $edit_form_attr);
            ?>
            <?php echo form_hidden("slider_banner_id", $slider_banner->slider_banner_id); ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('slider_banner_title'), "slider_banner_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "slider_banner_title",
                        "id"            =>  "slider_banner_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('slider_banner_title'),
                        "value"         =>  set_value("slider_banner_title", $slider_banner->slider_banner_title),
                        "placeholder"   =>  $this->lang->line('slider_banner_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("slider_banner_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('slider_banner_sub_title'), "slider_banner_sub_title", $label);      ?>

                <div class="col-md-10">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "slider_banner_sub_title",
                        "id"            =>  "slider_banner_sub_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('slider_banner_sub_title'),
                        "value"         =>  set_value("slider_banner_sub_title", $slider_banner->slider_banner_sub_title),
                        "placeholder"   =>  $this->lang->line('slider_banner_sub_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("slider_banner_sub_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('slider_banner_detail'), "slider_banner_detail", $label);
                ?>

                <div class="col-md-10">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "slider_banner_detail",
                        "id"            =>  "slider_banner_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('slider_banner_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("slider_banner_detail", $slider_banner->slider_banner_detail),
                        "placeholder"   =>  $this->lang->line('slider_banner_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("slider_banner_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('slider_banner_image')."<br />".file_type(base_url("assets/uploads/".$slider_banner->slider_banner_image)), "slider_banner_image", $label);     ?>

                <div class="col-md-10">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "slider_banner_image",
                        "id"            =>  "slider_banner_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('slider_banner_image'),
                        "value"         =>  set_value("slider_banner_image", $slider_banner->slider_banner_image),
                        "placeholder"   =>  $this->lang->line('slider_banner_image')
                    );
                    echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$slider_banner->slider_banner_image")); ?>-->
                    
                <?php echo form_error("slider_banner_image", "<p class=\"text-danger\">", "</p>"); ?>
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

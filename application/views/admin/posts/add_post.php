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
				<a href="<?php echo site_url(ADMIN_DIR."posts/view/"); ?>"><?php echo $this->lang->line('Posts'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."posts/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."posts/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."posts/save_data", $add_form_attr);
            ?>
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('post_title'), "post_title", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "post_title",
                        "id"            =>  "post_title",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('post_title'),
                        "value"         =>  set_value("post_title"),
                        "placeholder"   =>  $this->lang->line('post_title')
                    );
                    echo  form_input($text);
                ?>
                <?php echo form_error("post_title", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('post_summary'), "post_summary", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "post_summary",
                        "id"            =>  "post_summary",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('post_summary'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("post_summary"),
                        "placeholder"   =>  $this->lang->line('post_summary')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("post_summary", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('post_detail'), "post_detail", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "post_detail",
                        "id"            =>  "post_detail",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('post_detail'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("post_detail"),
                        "placeholder"   =>  $this->lang->line('post_detail')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("post_detail", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
            </div>
    
            <div class="form-group">
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('post_type'), "post_type", $label);
                ?>

                <div class="col-md-8">
                    <?php 
					$options = array("Yes" => "Yes", "No" => "No");
                        foreach($options as $option_value => $options_name){
                            
                            $data = array(
                                "name"        => "post_type",
                                "id"          => "post_type",
                                "value"       => $option_value,
                                "style"       => "","required"	  => "required",
                                "class"       => "uniform"
                                );
                            echo form_radio($data)."<label for=\"post_type\" style=\"margin-left:10px;\">$options_name</label><br />";
                            
                        }
                    ?>
                    <?php echo form_error("post_type", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
            </div>
            
            
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('image'), "image", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "image",
                        "id"            =>  "image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('image'),
                        "value"         =>  set_value("image"),
                        "placeholder"   =>  $this->lang->line('image')
                    );
                    echo  form_input($file);
                ?>
                <?php echo form_error("image", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('video_link'), "video_link", $label);      ?>

                <div class="col-md-8">
                <?php
                    
                    $url = array(
                        "type"          =>  "url",
                        "name"          =>  "video_link",
                        "id"            =>  "video_link",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('video_link'),
                        "value"         =>  set_value("video_link"),
                        "placeholder"   =>  $this->lang->line('video_link')
                    );
                    echo  form_input($url);
                ?>
                <?php echo form_error("video_link", "<p class=\"text-danger\">", "</p>"); ?>
                </div>
                
                
                
            </div>
    
            <div class="form-group">
            
                <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('post_keywords'), "post_keywords", $label);
                ?>

                <div class="col-md-8">
                <?php
                    
                    $textarea = array(
                        "name"          =>  "post_keywords",
                        "id"            =>  "post_keywords",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('post_keywords'),"required"	  => "required",
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("post_keywords"),
                        "placeholder"   =>  $this->lang->line('post_keywords')
                    );
                    echo form_textarea($textarea);
                ?>
                <?php echo form_error("post_keywords", "<p class=\"text-danger\">", "</p>"); ?>
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

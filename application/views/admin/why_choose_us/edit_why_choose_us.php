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
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li>
                    <i class="fa fa-table"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . "why_choose_us/view/"); ?>"><?php echo $this->lang->line('Why Choose Us'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR . "why_choose_us/update_data/$why_choose_us->why_choose_us_id", $edit_form_attr);
                ?>
                <?php echo form_hidden("why_choose_us_id", $why_choose_us->why_choose_us_id); ?>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('why_choose_us_title'), "why_choose_us_title", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "why_choose_us_title",
                            "id"            =>  "why_choose_us_title",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('why_choose_us_title'),
                            "value"         =>  set_value("why_choose_us_title", $why_choose_us->why_choose_us_title),
                            "placeholder"   =>  $this->lang->line('why_choose_us_title')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("why_choose_us_title", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('why_choose_us_detail'), "why_choose_us_detail", $label);
                    ?>

                    <div class="col-md-10">
                        <?php

                        $textarea = array(
                            "name"          =>  "why_choose_us_detail",
                            "id"            =>  "why_choose_us_detail",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('why_choose_us_detail'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("why_choose_us_detail", $why_choose_us->why_choose_us_detail),
                            "placeholder"   =>  $this->lang->line('why_choose_us_detail')
                        );
                        echo form_textarea($textarea);
                        ?>
                        <?php echo form_error("why_choose_us_detail", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>

                </div>


                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label("Image" . "<br />" . file_type(base_url("assets/uploads/" . $why_choose_us->attachment)), "attachment", $label);     ?>

                    <div class="col-md-10">
                        <?php

                        $file = array(
                            "type"          =>  "file",
                            "name"          =>  "attachment",
                            "id"            =>  "attachment",
                            "class"         =>  "form-control",
                            "style"         =>  "", "title"         =>  "Image",
                            "value"         =>  set_value("attachment", $why_choose_us->attachment),
                            "placeholder"   =>  "Image"
                        );
                        echo  form_input($file);
                        ?>
                        <!--<?php echo file_type(base_url("assets/uploads/$why_choose_us->attachment")); ?>-->

                        <?php echo form_error("attachment", "<p class=\"text-danger\">", "</p>"); ?>
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
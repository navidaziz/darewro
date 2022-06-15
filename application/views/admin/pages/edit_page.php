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
                    <a href="<?php echo site_url(ADMIN_DIR . "pages/view/"); ?>"><?php echo $this->lang->line('Pages'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "pages/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "pages/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR . "pages/update_data/$page->page_id", $edit_form_attr);
                ?>
                <?php echo form_hidden("page_id", $page->page_id); ?>


                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label('Icon', "icon", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "icon",
                            "id"            =>  "icon",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required",
                            "title"         =>  'icon',
                            "value"         =>  set_value("icon", $page->icon),
                            "placeholder"   =>  'icon'
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("icon", "<p class=\"text-danger\">", "</p>"); ?>
                        <small style="color:gray"> eg: fas fa-cog. you can get from font awesome website</small>
                    </div>



                </div>


                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_name'), "page_name", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "page_name",
                            "id"            =>  "page_name",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('page_name'),
                            "value"         =>  set_value("page_name", $page->page_name),
                            "placeholder"   =>  $this->lang->line('page_name')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("page_name", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_content'), "page_content", $label);
                    ?>

                    <div class="col-md-10">
                        <?php

                        $textarea = array(
                            "name"          =>  "page_content",
                            "id"            =>  "page_content",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('page_content'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("page_content", $page->page_content),
                            "placeholder"   =>  $this->lang->line('page_content')
                        );
                        echo form_textarea($textarea);
                        ?>
                        <?php echo form_error("page_content", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>

                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_title'), "page_title", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "page_title",
                            "id"            =>  "page_title",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('page_title'),
                            "value"         =>  set_value("page_title", $page->page_title),
                            "placeholder"   =>  $this->lang->line('page_title')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("page_title", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_description'), "page_description", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "page_description",
                            "id"            =>  "page_description",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('page_description'),
                            "value"         =>  set_value("page_description", $page->page_description),
                            "placeholder"   =>  $this->lang->line('page_description')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("page_description", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('page_keywords'), "page_keywords", $label);
                    ?>

                    <div class="col-md-10">
                        <?php

                        $textarea = array(
                            "name"          =>  "page_keywords",
                            "id"            =>  "page_keywords",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('page_keywords'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("page_keywords", $page->page_keywords),
                            "placeholder"   =>  $this->lang->line('page_keywords')
                        );
                        echo form_textarea($textarea);
                        ?>
                        <?php echo form_error("page_keywords", "<p class=\"text-danger\">", "</p>"); ?>
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
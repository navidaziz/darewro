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
                    <a href="<?php echo site_url(ADMIN_DIR . "posts/view/"); ?>"><?php echo $this->lang->line('Posts'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR . "posts/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "posts/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                echo form_open_multipart(ADMIN_DIR . "posts/update_data/$post->post_id", $edit_form_attr);
                ?>
                <?php echo form_hidden("post_id", $post->post_id); ?>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('post_title'), "post_title", $label);      ?>

                    <div class="col-md-8">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "post_title",
                            "id"            =>  "post_title",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('post_title'),
                            "value"         =>  set_value("post_title", $post->post_title),
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
                            "title"         =>  $this->lang->line('post_summary'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("post_summary", $post->post_summary),
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
                            "title"         =>  $this->lang->line('post_detail'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("post_detail", $post->post_detail),
                            "placeholder"   =>  $this->lang->line('post_detail')
                        );
                        echo form_textarea($textarea);
                        ?>
                        <?php echo form_error("post_detail", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>

                </div>



                <div class="form-group">
                    <label for="post_type" class="col-md-2 control-label" style="">Post Type</label>
                    <div class="col-md-8">
                        <input type="radio" name="post_type" value="Image" id="post_type" style="" required="required" onclick="$('#videolink').hide(); $('#videolink').prop( 'disabled', true ); $('#ImageFile').show(); $('#ImageFile').prop( 'disabled', false );" class="uniform" <?php if ($post->post_type == 'Image') { ?> checked <?php } ?>>
                        <label for="post_type" style="margin-left:10px;">Image</label><br>
                        <input type="radio" name="post_type" value="Video" id="post_type" style="" required="required" onclick="$('#videolink').show(); $('#videolink').prop( 'disabled', true ); $('#ImageFile').hide(); $('#ImageFile').prop( 'disabled', false );" class="uniform" <?php if ($post->post_type == 'Video') { ?> checked <?php } ?>>
                        <label for="post_type" style="margin-left:10px;">Video</label><br>
                    </div>
                </div>


                <div class="form-group" <?php if ($post->post_type != 'Image') { ?> style="display: none;" <?php } ?> id="ImageFile">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('image'), "image", $label);     ?>



                    <div class="col-md-8">
                        <?php if ($post->image) { ?>
                            <img width="100%" src="<?php echo base_url("assets/uploads/" . $post->image); ?>" />
                        <?php } ?>
                        <?php


                        $file = array(
                            "type"          =>  "file",
                            "name"          =>  "image",
                            "id"            =>  "image",
                            "class"         =>  "form-control",
                            "style"         =>  "", "title"         =>  $this->lang->line('image'),
                            "value"         =>  set_value("image", $post->image),
                            "placeholder"   =>  $this->lang->line('image')
                        );
                        echo  form_input($file);
                        ?>
                        <!--<?php echo file_type(base_url("assets/uploads/$post->image")); ?>-->

                        <?php echo form_error("image", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group" <?php if ($post->post_type != 'Video') { ?> style="display: none;" <?php } ?> id="videolink">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('video_link'), "video_link", $label);      ?>

                    <div class="col-md-8">
                        <?php if ($post->video_link) { ?>
                            <iframe width="100%" height="315" src="<?php echo $post->video_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php } ?>
                        <?php

                        $url = array(
                            "type"          =>  "url",
                            "name"          =>  "video_link",
                            "id"            =>  "video_link",
                            "class"         =>  "form-control",
                            "style"         =>  "", "title"         =>  $this->lang->line('video_link'),
                            "value"         =>  set_value("video_link", $post->video_link),
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
                            "title"         =>  $this->lang->line('post_keywords'), "required"      => "required",
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("post_keywords", $post->post_keywords),
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
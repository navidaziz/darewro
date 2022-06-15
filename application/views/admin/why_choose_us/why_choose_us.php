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

                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Attachment</th>
                                <th><?php echo $this->lang->line('why_choose_us_title'); ?></th>
                                <th><?php echo $this->lang->line('why_choose_us_detail'); ?></th>
                                <th><?php echo $this->lang->line('Order'); ?></th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($why_choose_us as $why_choose_us) : ?>

                                <tr>
                                    <td>
                                        <?php
                                        echo file_type(base_url("assets/uploads/" . $why_choose_us->attachment));
                                        ?>
                                    </td>

                                    <td>
                                        <?php echo $why_choose_us->why_choose_us_title; ?>
                                    </td>
                                    <td>
                                        <?php echo $why_choose_us->why_choose_us_detail; ?>
                                    </td>
                                    <td>
                                        <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/up/" . $why_choose_us->why_choose_us_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                        <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/down/" . $why_choose_us->why_choose_us_id . "/" . $this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
                                    </td>
                                    <td>
                                        <?php echo status($why_choose_us->status,  $this->lang); ?>
                                        <?php

                                        //set uri segment
                                        if (!$this->uri->segment(4)) {
                                            $page = 0;
                                        } else {
                                            $page = $this->uri->segment(4);
                                        }

                                        if ($why_choose_us->status == 0) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "why_choose_us/publish/" . $why_choose_us->why_choose_us_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                        } elseif ($why_choose_us->status == 1) {
                                            echo "<a href='" . site_url(ADMIN_DIR . "why_choose_us/draft/" . $why_choose_us->why_choose_us_id . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/view_why_choose_us/" . $why_choose_us->why_choose_us_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                        <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/edit/" . $why_choose_us->why_choose_us_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR . "why_choose_us/trash/" . $why_choose_us->why_choose_us_id . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php echo $pagination; ?>


                </div>


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>
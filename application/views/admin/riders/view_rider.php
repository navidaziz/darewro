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
				<a href="<?php echo site_url(ADMIN_DIR."riders/view/"); ?>"><?php echo $this->lang->line('Riders'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($riders as $rider): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('rider_name'); ?></th>
                <td>
                    <?php echo $rider->rider_name; ?>
                </td>
            </tr>
            <tr>
                <th>Rider Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$rider->rider_image));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('office_no'); ?></th>
                <td>
                    <?php echo $rider->office_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('personal_no'); ?></th>
                <td>
                    <?php echo $rider->personal_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('duty_start'); ?></th>
                <td>
                    <?php echo $rider->duty_start; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('duty_end'); ?></th>
                <td>
                    <?php echo $rider->duty_end; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('is_available'); ?></th>
                <td>
                    <?php echo $rider->is_available; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('is_absent'); ?></th>
                <td>
                    <?php echo $rider->is_absent; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('ability_level'); ?></th>
                <td>
                    <?php echo $rider->ability_level; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('comments'); ?></th>
                <td>
                    <?php echo $rider->comments; ?>
                </td>
            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($rider->status); ?>
                                </td>
                            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>

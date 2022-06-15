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
				<a href="<?php echo site_url(ADMIN_DIR."customer_locations/view/"); ?>"><?php echo $this->lang->line('Customer Locations'); ?></a>
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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."customer_locations/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."customer_locations/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table table-table-bordered">
						<thead>
						  <tr>
							<th><?php echo $this->lang->line('location_address'); ?></th>
<th><?php echo $this->lang->line('latitude'); ?></th>
<th><?php echo $this->lang->line('longitude'); ?></th>
<th><?php echo $this->lang->line('street_number'); ?></th>
<th><?php echo $this->lang->line('route'); ?></th>
<th><?php echo $this->lang->line('city'); ?></th>
<th><?php echo $this->lang->line('province'); ?></th>
<th><?php echo $this->lang->line('country'); ?></th>
<th><?php echo $this->lang->line('postal_code'); ?></th>
                            <th><?php echo $this->lang->line('Action'); ?></th>
						  </tr>
						</thead>
						<tbody>
					  <?php foreach($customer_locations as $customer_location): ?>
                         <tr>
                            
                            
            <td>
                <?php echo $customer_location->location_address; ?>
            </td>
            <td>
                <?php echo $customer_location->latitude; ?>
            </td>
            <td>
                <?php echo $customer_location->longitude; ?>
            </td>
            <td>
                <?php echo $customer_location->street_number; ?>
            </td>
            <td>
                <?php echo $customer_location->route; ?>
            </td>
            <td>
                <?php echo $customer_location->city; ?>
            </td>
            <td>
                <?php echo $customer_location->province; ?>
            </td>
            <td>
                <?php echo $customer_location->country; ?>
            </td>
            <td>
                <?php echo $customer_location->postal_code; ?>
            </td>
                            
                            <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."customer_locations/view_customer_location/".$customer_location->customer_location_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-restore" href="<?php echo site_url(ADMIN_DIR."customer_locations/restore/".$customer_location->customer_location_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-undo"></i></a>
                                <a class="llink llink-delete" href="<?php echo site_url(ADMIN_DIR."customer_locations/delete/".$customer_location->customer_location_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-times"></i></a>
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

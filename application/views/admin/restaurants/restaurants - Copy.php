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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('restaurant_name'); ?></th>
<th><?php echo $this->lang->line('restaurant_location'); ?></th>
<th><?php echo $this->lang->line('restaurant_detail'); ?></th>
<th><?php echo $this->lang->line('restaurant_contact_no'); ?></th>
<th><?php echo $this->lang->line('restaurant_logo'); ?></th>
<th><?php echo $this->lang->line('restaurant_start_time'); ?></th>
<th><?php echo $this->lang->line('restaurant_close_time'); ?></th><th><?php echo $this->lang->line('Order'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($restaurants as $restaurants): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $restaurants->restaurant_name; ?>
            </td>
            <td>
                <?php echo $restaurants->restaurant_location; ?>
            </td>
            <td>
                <?php echo $restaurants->restaurant_detail; ?>
            </td>
            <td>
                <?php echo $restaurants->restaurant_contact_no; ?>
            </td>
            <td>
            <?php
                echo file_type(base_url("assets/uploads/".$restaurants->restaurant_logo));
            ?>
            </td>
            <td>
                <?php echo $restaurants->restaurant_start_time; ?>
            </td>
            <td>
                <?php echo $restaurants->restaurant_close_time; ?>
            </td>
                                <td>
                                  <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."restaurants/up/".$restaurants->restaurant_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                  <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."restaurants/down/".$restaurants->restaurant_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
                                </td>
                                <td>
                                    <?php echo status($restaurants->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($restaurants->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/publish/".$restaurants->restaurant_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($restaurants->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/draft/".$restaurants->restaurant_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurants/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."restaurants/edit/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."restaurants/trash/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
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

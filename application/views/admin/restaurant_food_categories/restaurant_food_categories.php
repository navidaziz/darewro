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
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
                          
							<th><?php echo $this->lang->line('restaurant_food_category'); ?></th>
<th><?php echo $this->lang->line('restaurant_food_category_image'); ?></th><th><?php echo $this->lang->line('Order'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($restaurant_food_categories as $restaurant_food_category): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $restaurant_food_category->restaurant_food_category; ?>
            </td>
            <td>
            <?php
                echo file_type(base_url("assets/uploads/".$restaurant_food_category->restaurant_food_category_image));
            ?>
            </td>
                                <td>
                                  <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/up/".$restaurant_food_category->restaurant_food_category_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a>
                                  <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/down/".$restaurant_food_category->restaurant_food_category_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
                                </td>
                                <td>
                                    <?php echo status($restaurant_food_category->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($restaurant_food_category->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurant_food_categories/publish/".$restaurant_food_category->restaurant_food_category_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($restaurant_food_category->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurant_food_categories/draft/".$restaurant_food_category->restaurant_food_category_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/view_restaurant_food_category/".$restaurant_food_category->restaurant_food_category_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/edit/".$restaurant_food_category->restaurant_food_category_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."restaurant_food_categories/trash/".$restaurant_food_category->restaurant_food_category_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
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

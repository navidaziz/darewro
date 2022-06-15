<!-- Start Banner Area -->
	<section class="banner-area relative">
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
							<?php echo $title; ?>
					</h1>
					<p>Darewro is striving to bring the maximum ease in your life by offering you a wide range of services.</p>
					<div class="link-nav">
						<span class="box">
                        <a href="<?php echo base_url(); ?>"><i class="fa fa-home fa-lg"></i> Home</a> <i class="lnr lnr-arrow-right"></i>
    <a href="#"><?php echo $title; ?></a> 
						
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="rocket-img">
			<img src="img/ro cket.png" alt="">
		</div>
	</section>
	<!-- End Banner Area -->




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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('page_name'); ?></th>
<th><?php echo $this->lang->line('page_content'); ?></th>
<th><?php echo $this->lang->line('page_title'); ?></th>
<th><?php echo $this->lang->line('page_description'); ?></th>
<th><?php echo $this->lang->line('page_keywords'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($pages as $page): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $page->page_name; ?>
            </td>
            <td>
                <?php echo $page->page_content; ?>
            </td>
            <td>
                <?php echo $page->page_title; ?>
            </td>
            <td>
                <?php echo $page->page_description; ?>
            </td>
            <td>
                <?php echo $page->page_keywords; ?>
            </td><td>
                                <a class="llink llink-view" href="<?php echo site_url("pages/view_page/".$page->page_id."/".$this->uri->segment(4)); ?>"> View </a>
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

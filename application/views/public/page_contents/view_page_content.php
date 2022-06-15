<!-- PAGE HEADER-->
<div class="breadcrumb-box">
  <div class="container">
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url("Home"); ?>">Home</a>
					<span class="divider">/</span>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url("page_contents/view/"); ?>">Page Contents</a>
				<span class="divider">/</span>
			</li><li ><?php echo $title; ?> </li>
				</ul>
			</div>
		</div>
		<!-- .breadcrumb-box --><section id="main">
			  <header class="page-header">
				<div class="container">
				  <h1 class="title"><?php echo $title; ?></h1>
				</div>
			  </header>
			  <div class="container">
			  <div class="row">
			  <?php $this->load->view(PUBLIC_DIR."components/nav"); ?><div class="content span9 pull-right">
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($page_contents as $page_content): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('page_content_title'); ?></th>
                <td>
                    <?php echo $page_content->page_content_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('page_content_sub_title'); ?></th>
                <td>
                    <?php echo $page_content->page_content_sub_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('page_content_detail'); ?></th>
                <td>
                    <?php echo $page_content->page_content_detail; ?>
                </td>
            </tr>
            <tr>
                <th>Attachment</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$page_content->attachment));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('page_name'); ?></th>
                <td>
                    <?php echo $page_content->page_name; ?>
                </td>
            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			</div>
		</div>
	 </div>
  <!-- .container --> 
</section>
<!-- #main -->

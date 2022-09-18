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
				<a href="<?php echo site_url("posts/view/"); ?>">Posts</a>
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
					  <?php foreach($posts as $post): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('post_title'); ?></th>
                <td>
                    <?php echo $post->post_title; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('post_summary'); ?></th>
                <td>
                    <?php echo $post->post_summary; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('post_type'); ?></th>
                <td>
                    <?php echo $post->post_type; ?>
                </td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                <?php
                    echo file_type(base_url("assets/uploads/".$post->image));
                ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('video_link'); ?></th>
                <td>
                    <?php echo $post->video_link; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('post_detail'); ?></th>
                <td>
                    <?php echo $post->post_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('post_keywords'); ?></th>
                <td>
                    <?php echo $post->post_keywords; ?>
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

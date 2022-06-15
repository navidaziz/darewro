<div class="breadcrumb-div">
	<div class="container">
		<div class="row">
			<div class="col-6">
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url(); ?>"><i style="color:black !important" class="fa fa-home fa-lg"></i> Home</a></a></li>
				</ol>
			</div>
			<div class="col-6">
				<div class="text-end">
					<h2><?php echo $title; ?></h2>
				</div>
			</div>
		</div>
	</div>

</div>


<section class="div-padding blog-div">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="div-title text-center"><?php echo $title; ?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 posts-list offset-lg-1">
				<div class="single-post row">




					<?php foreach ($page_contents as $page_content) : ?>

						<div class="col-lg-12">
							<div class="si ngle-blog-item" style="margin-bottom: 5px;">

								<div class="blog-text">
									<h4 class="blog-heading"><?php echo $page_content->page_content_title; ?></h4>
								</div>
								<div class="blog-img">
									<img src="<?php echo base_url("assets/uploads/" . $page_content->attachment); ?>" alt="">
								</div>
								<div class="blog-text">
									<p class="blog-time" style="min-height:110px">
										<?php echo $page_content->page_content_sub_title; ?>
									</p>
									<a href="<?php echo base_url("page/view_page_content/" . $page_content->page_content_id); ?>" class="button button-dark tiny">Read More</a>
								</div>
							</div>
						</div>


					<?php endforeach; ?>

				</div>

			</div>
			<?php $this->load->view(PUBLIC_DIR . "components/side_bar"); ?>

		</div>
	</div>
</section>
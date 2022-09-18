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
					<h2><a style="color: #F7BC00; display: inline-block;" href="<?php echo site_url("blogs"); ?>">Blogs</a> / Darewro informationerse</h2>

				</div>
			</div>
		</div>
	</div>

</div>


<div class="div-padding blog-div">
	<div class="container">
		<!-- <div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="text-center">Darewro informationerse</h2>
				<p class="text-center"></p>
			</div>
		</div> -->

		<div class="row">



			<div class="col-lg-8 col-sm-12">
				<h4 class="blog-heading"><?php echo $post->post_title; ?></h4>
				<p class="blog-time" style="min-height:50px">
					<?php echo substr($post->post_summary, 0, 200); ?>


				</p>
				<div class="single-blog-item" style="margin-bottom: 5px; height:auto !important">
					<div class="blog-img">
						<?php if ($post->image) { ?>
							<img style="width: 100%" src="<?php echo base_url("assets/uploads/" . $post->image); ?>" alt="">
						<?php } else { ?>
							<?php if ($post->video_link) { ?>
								<iframe style="width: 100%" src="<?php echo $post->video_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="blog-text">


						<p class="blog-time" style="min-height:50px">
							<?php echo $post->post_detail; ?>


						</p>

						<!-- <a href="<?php echo base_url("service/view_service/" . $service->service_id); ?>" class="button button-dark tiny">Read More</a> -->
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-12">
				<h4>Recent Blogs</h4>
				<hr />
				<?php foreach ($posts as $post) { ?>
					<div class="col-md-12">

						<a style="" href="<?php echo site_url('blogs/view/' . $post->post_id) ?>">
							<div class="single-blog-item" style="margin-bottom: 5px; height:auto !important">
								<!-- <div class="blog-img">
								<?php if ($post->image) { ?>
									<img style="width:100%" src="<?php echo base_url("assets/uploads/" . $post->image); ?>" alt="">
								<?php } else { ?>
									<?php if ($post->video_link) { ?>
										<iframe style="width: 414px; height:270px" src="<?php echo $post->video_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<?php } ?>
								<?php } ?>
							</div> -->
								<div class="blog-text">
									<h4 class="blog-heading"><?php echo $post->post_title; ?></h4>
									<p class="blog-time">
										<?php echo substr($post->post_summary, 0, 200); ?>

									</p>
									<!-- <a href="<?php echo base_url("service/view_service/" . $service->service_id); ?>" class="button button-dark tiny">Read More</a> -->
								</div>
							</div>
						</a>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</div>
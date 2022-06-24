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
					<h2>Our Services</h2>
				</div>
			</div>
		</div>
	</div>

</div>


<div class="div-padding blog-div">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="div-title text-center">Our Services</h2>
				<p class="text-center">We offer a wide range of services to our clients. We are here to help you with your business needs.</p>
			</div>
		</div>

		<div class="row">
			<?php foreach ($services as $service) { ?>
				<div class="col-lg-4 col-sm-6">
					<div class="single-blog-item" style="margin-bottom: 5px; height:600px !important">
						<div class="blog-img">
							<img style="width: 414px; height:270px" src="<?php echo base_url("assets/uploads/" . $service->service_image); ?>" alt="">
						</div>
						<div class="blog-text">
							<h4 class="blog-heading"><?php echo $service->service_title; ?></h4>
							<p class="blog-time" style="min-height:110px">
								<?php echo $service->service_summery; ?>
							</p>
							<!-- <a href="<?php echo base_url("service/view_service/" . $service->service_id); ?>" class="button button-dark tiny">Read More</a> -->
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
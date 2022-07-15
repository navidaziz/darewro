<style>
	/* .carousel-caption {
		position: absolute;
		right: 15%;
		bottom: 7.25rem;
		left: 15%;
		padding-top: 1.25rem;
		padding-bottom: 1.25rem;
		color: #fff;
		text-align: center;
	} */
</style>
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
		<?php
		$query = "SELECT * FROM `slider_banners` where `status` = 1 ORDER by `order` asc";
		$slider_banners = $this->db->query($query)->result();
		$count = 0;
		foreach ($slider_banners as $slider_banner) { ?>
			<?php if ($count == 0) {
			?>
				<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $count; ?>" class="active" aria-label="<?php echo $slider_banner->slider_banner_title; ?>" aria-current="true"></button>
			<?php } else { ?>
				<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $count; ?>" aria-label="<?php echo $slider_banner->slider_banner_title; ?>" class=""></button>
			<?php }
			$count++;
			?>
		<?php } ?>
	</div>


	<div class="carousel-inner">
		<?php
		$query = "SELECT * FROM `slider_banners` where `status` = 1 ORDER by `order` asc";
		$slider_banners = $this->db->query($query)->result();
		$count = 1;
		foreach ($slider_banners as $slider_banner) { ?>
			<div class="carousel-item <?php if ($count == 1) {
											echo "active";
											$count++;
										} ?>" style="height:580px">
				<div style="background-color: #F6E302;">
					<img src="<?php echo base_url("assets/uploads/" . $slider_banner->slider_banner_image); ?>" alt="<?php echo $slider_banner->slider_banner_title; ?>" class="d-block w-100" />

					<div class="carousel-caption d-none d-md-block">
						<?php if ($slider_banner->slider_banner_title) { ?>
							<h4><?php echo $slider_banner->slider_banner_title; ?></h4>
						<?php } ?>
						<?php if ($slider_banner->slider_banner_sub_title) { ?>
							<h4><?php echo $slider_banner->slider_banner_sub_title; ?></h4>
						<?php } ?>
						<?php if ($slider_banner->slider_banner_detail) { ?>
							<p><?php echo $slider_banner->slider_banner_detail; ?></p>
						<?php } ?>
					</div>
				</div>

			</div>
		<?php } ?>



	</div>
	<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Previous</span>
	</button>
	<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="visually-hidden">Next</span>
	</button>
</div>


<div class="download-div div-padding p-b-0">
	<div class="container">


		<div class="row">
			<div class="col-lg-5">
				<div class="download-qrcode">

					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/mobile_app.png" alt="">
					<!-- <img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/qr.png" alt=""> -->
				</div>
			</div>

			<div class="col-lg-7">
				<div class="download-text">
					<h2>Download the Darewro Mobile App</h2>
					<p>

						'Darewro' has a feature rich app which offers an extensive range of services, being the best Delivery Service in Peshawar, we believe in taking ownership of our customers needs, wants and future requirements.

					</p>
				</div>
				<div class="download-buttons">
					<!-- <a href="#"><img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/download-1.png" alt=""></a>
					 -->
					<a target="new" href="https://play.google.com/store/apps/details?id=com.darewro.customer&hl=en"><img style="width:350px; padding:0px; margin:0px" src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/download_app.svg" alt="download android app"></a>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="div-padding blog-div">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 class="text-center">Why Choose Us</h2>

			</div>
			<p>Our story is straightforward; we believe in empowering our customers by enabling them to do more, feel better and live happier. We also believe that services delivery must be a hassle-free and exciting process. We aim to transform the everyday experiences of businesses on how to send and receive their goods and also empowering them by expanding horizon of customers for them. We are also empowering them via our state-of-the-art technology.</p>
		</div>

		<div class="row">
			<?php foreach ($why_choose_us as $why_choose_us) { ?>
				<div class="col-lg-3 col-sm-6">
					<div class="single-service-item" style="height:400px !important">
						<img class="service-icon" title="<?php echo $why_choose_us->why_choose_us_title; ?>" style="height: 100px; object-fit:scale-down;" src="<?php echo base_url("assets/uploads/" . $why_choose_us->attachment); ?>" alt="service icon">
						<h4><?php echo $why_choose_us->why_choose_us_title; ?></h4>
						<p>
							<!-- <details>
                <summary>Read More....</summary> -->
						<p style="overflow: scroll; overflow-x: hidden; overflow-y: hidden; height: 100px; text-align:left; "><?php echo $why_choose_us->why_choose_us_detail; ?></p>
						<!-- </details> -->
						</p>
					</div>
				</div>

			<?php } ?>
		</div>
	</div>
</div>
<!-- 
<div class="div-padding how-work-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 class="text-center">How It Work</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 d-none d-lg-block">
				<div class="icons-div">
					<div class="single-icon">
						<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/1.png" alt="">
					</div>
					<div class="single-icon">
						<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/2.png" alt="">
					</div>
					<div class="single-icon">
						<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/3.png" alt="">
					</div>
					<div class="single-icon">
						<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/4.png" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-3 col-sm-6">
				<div class="single-icon text-center m-b-10 d-block d-lg-none">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/1.png" alt="">
				</div>
				<div class="how-work-text">
					<h4>Book in Just 2 Tabs</h4>
					<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="single-icon text-center m-b-10 d-block d-lg-none">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/2.png" alt="">
				</div>
				<div class="how-work-text">
					<h4>Get a Driver</h4>
					<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="single-icon text-center m-b-10 d-block d-lg-none">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/3.png" alt="">
				</div>
				<div class="how-work-text">
					<h4>Track your Driver</h4>
					<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="single-icon text-center m-b-10 d-block d-lg-none">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/4.png" alt="">
				</div>
				<div class="how-work-text">
					<h4>Arrive safely</h4>
					<p>Curabitur ac quam aliquam urna vehicula semper sed vel elit. Sed et leo purus. Vivamus vitae sapien.</p>
				</div>
			</div>
		</div>
	</div>
</div> -->



<!-- <div class="about-us-area bg-2 div-padding"> -->
<div class="bg-2 div-padding">
	<?php
	$query = "SELECT * FROM about_us where about_us_page_id=1";
	$about_us = $this->db->query($query)->result()[0];
	?>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<h2 class="">About Us</h2>
				<div class="about-us-text">
					<h4><?php echo $about_us->about_us_page_title; ?></h4>
					<p><?php echo $about_us->about_us_page_content; ?></p>

					<a href="<?php echo site_url("about_us") ?>" class="button button-dark tiny">Read More</a>
				</div>
			</div>
			<div class="col-lg-6">

				<img id="logo" width="960" height="389" src="<?php echo base_url("assets/uploads/" . $about_us->image); ?>" />
			</div>
		</div>
	</div>
</div>




<div class="div-padding testimonial-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 class="text-center">Customers reviews</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<?php $query = "SELECT * FROM `testimonials` WHERE status=1  order by `order` ASC";
				$reviews = $this->db->query($query)->result();
				foreach ($reviews as $review) {
				?>
					<div id="testimonial-carousel-1" class="testimonial-carousel owl-carousel">
						<div class="single-testimonial-item text-center">
							<img src="<?php echo base_url("assets/uploads/" . $review->image); ?>" alt="" class="client-img" style="width: 150px !important;">
							<p class="testimonial-text"><?php echo $review->statement; ?></p>
							<h4 class="client-name"><?php echo $review->client_name; ?></h4>
							<p class="theme-color"><?php echo $review->client_designation; ?></p>
						</div>
					<?php } ?>

					</div>
			</div>
		</div>
	</div>
</div>
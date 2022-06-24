<style>
	.hero-area .hero-area-slider .owl-dots button.owl-dot {
		width: 12px;
		height: 12px;
		background-color: transparent;
		margin: 5px;
		border-radius: 0px;
		min-width: 40px;
		border: 1px solid #3B3B3B;
	}
</style>

<div class="hero-area hero-bg-light-yellow">
	<div class="hero-blob">
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="visual" viewBox="0 0 960 540" width="960" height="540" version="1.1">
			<g transform="translate(-19.958786364683874 -119.45603407032678)">
				<path d="M354.6 -312.6C469.8 -239.5 580.4 -119.7 623.9 43.5C667.5 206.8 644 413.7 528.8 530.7C413.7 647.7 206.8 674.8 3 671.8C-200.8 668.8 -401.6 635.6 -506 518.6C-610.3 401.6 -618.2 200.8 -591.3 26.9C-564.4 -147.1 -502.8 -294.2 -398.5 -367.3C-294.2 -440.4 -147.1 -439.6 -13.7 -425.9C119.7 -412.2 239.5 -385.7 354.6 -312.6" fill="#f7bc00" />
			</g>
		</svg>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div id="hero-area-slider" class="hero-area-slider owl-carousel">
					<?php
					$query = "SELECT * FROM `slider_banners` where `status` = 1 ORDER by `order` asc";
					$slider_banners = $this->db->query($query)->result();

					foreach ($slider_banners as $slider_banner) { ?>
						<div class="single-slider-item">
							<div class="hero-area-left">
								<h1 style="color: black;"><?php echo $slider_banner->slider_banner_title; ?></h1>
								<p style="color: black;"><?php echo $slider_banner->slider_banner_sub_title; ?></p>
								<p style="color: black;"><?php echo $slider_banner->slider_banner_detail; ?></p>
								<!-- <a href="signup.html" class="button button-dark big">Sign up Now</a> -->
							</div>
							<div class="hero-area-right" style="border: 1px solid red;">
								<img style="border:1px solid black; width:100%" src="<?php echo base_url("assets/uploads/" . $slider_banner->slider_banner_image); ?>" alt="<?php echo $slider_banner->slider_banner_title; ?>">
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="download-div div-padding p-b-0">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 class="div-title text-center">Download Our Mobile App</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-5">
				<div class="download-qrcode">

					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/mobile_app.png" alt="">
					<!-- <img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/qr.png" alt=""> -->
				</div>
			</div>

			<div class="col-lg-7">
				<div class="download-text">
					<h2>Download the darewro mobile application</h2>
					<p>A delivery service right in your pocket. We have made it too easy for you to place your order and receive your delivery via a user-friendly mobile app.</p>
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
				<h2 class="div-title text-center">Our Services</h2>
			</div>
		</div>

		<div class="row">
			<?php foreach ($services as $service) { ?>
				<div class="col-lg-4 col-sm-6">
					<div class="single-blog-item" style="margin-bottom: 5px;">
						<div class="blog-img">
							<img title="<?php echo $service->service_title; ?>" style="height:270px;" src="<?php echo base_url("assets/uploads/" . $service->service_image); ?>" alt="">
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

<div class="div-padding blog-div">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 class="div-title text-center">Why Choose us</h2>

			</div>
			<p>Our story is straightforward; we believe in empowering our customers by enabling them to do more, feel better and live happier. We also believe that services delivery must be a hassle-free and exciting process. We aim to transform the everyday experiences of businesses on how to send and receive their goods and also empowering them by expanding horizon of customers for them. We are also empowering them via our state-of-the-art technology.</p>
		</div>

		<div class="row">
			<?php foreach ($why_choose_us as $why_choose_us) { ?>
				<div class="col-lg-3 col-sm-6">
					<div class="single-service-item">
						<img class="service-icon" title="<?php echo $why_choose_us->why_choose_us_title; ?>" style="height: 100px; object-fit:scale-down;" src="<?php echo base_url("assets/uploads/" . $why_choose_us->attachment); ?>" alt="service icon">
						<h4><?php echo $why_choose_us->why_choose_us_title; ?></h4>
						<p>
							<!-- <details>
                <summary>Read More....</summary> -->
						<p style="overflow: scroll; overflow-x: hidden; height: 200px; text-align:left; "><?php echo $why_choose_us->why_choose_us_detail; ?></p>
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
				<h2 class="div-title text-center">How It Work</h2>
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
				<h2 class="div-title">About us</h2>
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
				<h2 class="div-title text-center">Customers reviews</h2>
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
							<img src="<?php echo base_url("assets/uploads/" . $review->image); ?>" alt="" class="client-img" style="width: 73px !important;">
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
<style>
	/* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */

	/* Carousel base class */
	.carousel {
		margin-bottom: 4rem;
	}

	/* Since positioning the image, we need to help out the caption */
	.carousel-caption {
		bottom: 3rem;
		z-index: 10;
	}

	/* Declare heights because of positioning of img element */
	.carousel-item {
		height: 32rem;
	}

	.carousel-item>img {
		position: absolute;
		top: 0;
		left: 0;
		min-width: 100%;
		height: 32rem;
	}


	/* MARKETING CONTENT
-------------------------------------------------- */

	/* Center align the text within the three columns below the carousel */
	.marketing .col-lg-4 {
		margin-bottom: 1.5rem;
		text-align: center;
	}

	.marketing h2 {
		font-weight: 400;
	}

	/* rtl:begin:ignore */
	.marketing .col-lg-4 p {
		margin-right: .75rem;
		margin-left: .75rem;
	}

	/* rtl:end:ignore */


	/* Featurettes
------------------------- */

	.featurette-divider {
		margin: 5rem 0;
		/* Space out the Bootstrap <hr> more */
	}

	/* Thin out the marketing headings */
	.featurette-heading {
		font-weight: 300;
		line-height: 1;
		/* rtl:remove */
		letter-spacing: -.05rem;
	}


	/* RESPONSIVE CSS
-------------------------------------------------- */

	@media (min-width: 40em) {

		/* Bump up size of carousel content */
		.carousel-caption p {
			margin-bottom: 1.25rem;
			font-size: 1.25rem;
			line-height: 1.4;
		}

		.featurette-heading {
			font-size: 50px;
		}
	}

	@media (min-width: 62em) {
		.featurette-heading {
			margin-top: 7rem;
		}
	}
</style>






<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
		<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
	</div>


	<div class="carousel-inner" style="height:585px">

		<div class="carousel-item active" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00006.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>

		<div class="carousel-item" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00005.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>

		<div class="carousel-item " style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00004.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00003.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00002.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>

		<div class="carousel-item" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/File 00001.jpg"); ?>" class="d-block w-100" />
			</div>

		</div>

		<div class="carousel-item" style="background-color: #ffcb13; height:585px;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/img_6.svg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item" style="background-color: #ffcb13;">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/img_5.svg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item">
			<div style="background-color: ffcb13;">
				<img src="<?php echo site_url("sliders/img_3.svg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/final_svg.svg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/img_1.webp"); ?>" class="d-block w-100" />
			</div>

		</div>
		<div class="carousel-item ">
			<div>
				<img src="<?php echo site_url("sliders/img.svg"); ?>" class="d-block w-100" />
			</div>

		</div>
		<!-- <div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/my.jpg"); ?>" class="d-block w-100" />
			</div>

		</div> -->

		<!-- <div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/slider_one.png"); ?>" class="d-block w-100" />
			</div>

		</div> -->
		<!-- <div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/slider_two.jpeg"); ?>" style="width:100%" />
			</div>
		</div> -->
		<!-- <div class="carousel-item">
			<div>
				<img src="<?php echo site_url("sliders/slider_three.jpeg"); ?>" style="width:100%" />
			</div>
		</div> -->
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
					dfasdfa
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/image1.jpg" alt="">
					<!-- <img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/qr.png" alt=""> -->
				</div>
			</div>

			<div class="col-lg-7">
				<div class="download-text">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/image1.jpg" alt="">
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
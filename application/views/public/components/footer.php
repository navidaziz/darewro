<footer class="footer-div theme-1">
	<div class="footer-shape">
		<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
		</svg>
	</div>
	<div class="footer-shape">
		<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
		</svg>
	</div>

	<div class="footer-nav-div div-padding theme-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="footer-brand">
						<a href="<?php echo site_url(); ?>">
							<img id="logo" width="122" height="32" title="<?php echo $system_global_settings->system_title; ?> Logo" src="<?php echo base_url("assets/public/assets/images/home/logo_yellow.png"); ?>" />
						</a>
					</div>
					<!-- <div class="footer-text">
              <p>Nulla justo neque, tincidunt id bibendum a, rhoncus et eros. Vestibulum commodo diam ut risus pulvinar consequat vitae a dui. Vivamus sed molestie diam. Maecenas vitae enim lacus.</p>
            </div> -->
					<div class="helpline">
						<h4>Call For Delivery <span>Helpline</span></h4>
						<h4>(+92) 091 724-1-724</h4>
						<h4><span>Working Hours 9:00 AM - 12:00 AM</span></h4>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<h4>Useful links</h4>
					<nav class="footer-navigation">


						<ul>


							<li><a class="nav-link " href="<?php echo base_url("/home"); ?>"> Home</a></li>
							<li><a class="nav-link" href="<?php echo base_url("/about_us"); ?>">About Us</a></li>
							<li><a class="nav-link" href="<?php echo base_url("/services"); ?>">Services</a></li>
							<li><a class="nav-link" href="<?php echo base_url("/contact_us"); ?>">Contacts</a></li>

						</ul>


					</nav>
				</div>
				<div class="col-lg-3 col-sm-6">
					<h4>Head Office</h4>
					<address class="company-address">
						<p class="m-b-20"><?php echo $system_global_settings->address; ?></p>
						<p class="m-b-8">Phone Number : <?php echo $system_global_settings->phone_number; ?></p>
						<p class="m-b-8">WhatsApp : <?php echo $system_global_settings->mobile_number; ?></p>
						<p class="m-b-8">Email Address : <?php echo $system_global_settings->email_address; ?></p>
						
					</address>
				</div>
				<div class="col-lg-3 col-sm-6">
					<h4>Download Mobile App</h4>
					<div class="app-downl oad-box">
						<a target="new" href="https://play.google.com/store/apps/details?id=com.darewro.customer&hl=en"><img style="width:100%; padding:0px; margin:0px" src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/home/download_app.svg" alt=""></a>
						<!-- <a href="#"><img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/apple-store.jpg" alt="Apple store"></a>
					 -->
					</div>
					<!-- <div class="cta-button">
              <a href="my-driver-dashboard.html" class="button button-dark">Become a Driver</a>
              <a href="ride-with-cabgo.html" class="button button-dark">Ride with CarrGo</a>
            </div> -->
				</div>
			</div>
		</div>
	</div>

	<div class="copyright-div">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<p>&copy; Copyright <?php date("Y") ?> by
						<strong><em style="color: black;">DAR</em>
							<span style="color:#F00 !important;font-size: 30px;">e</span>
							<em style="color: black !important; margin-left:-1px">WRO</em></strong>. All Right Reserved.
					</p>
				</div>
				<div class="col-lg-6">
					<ul class="social-nav">

						<?php
						$count = 1;
						foreach ($social_media_icons as $social_media_icon) : ?>
							<li> <a style="color: rgb(255, 201, 10) !important; font-size:24px" target="new" href="<?php echo $social_media_icon->social_media_link; ?>">
									<i class="<?php echo $social_media_icon->social_media_icon; ?>"></i>
								</a>
							</li> <?php
									$count++;
								endforeach; ?>
						<!--      <li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#" class="instagram"><i class="fab fa-instagram"></i></a></li>
              <li><a href="#" class="google-p"><i class="fab fa-google-plus-g"></i></a></li>
              <li><a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
              <li><a href="#" class="pinterest"><i class="fab fa-pinterest-p"></i></a></li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="map-div">
		<?php $query = "SELECT * FROM `contact_us_page` WHERE contact_us_page_id = 1";
		$contact_us_page = $this->db->query($query)->row();
		?>
		<iframe class="we-onmap wow fadeInUp" data-wow-delay="0.3s" style="width:100%; height: 445px;" src="<?php echo $contact_us_page->google_map_link; ?>"></iframe>

	</div>

</footer>

<!-- jQuery -->
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/common/common.min.js"></script>
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/OwlCarousel/owl.carousel.min.js"></script>
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/counterup/waypoints.min.js"></script>
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/counterup/jquery.counterup.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB16sGmIekuGIvYOfNoW9T44377IU2d2Es&sensor=true"></script>
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/gmap3/gmap3.min.js"></script>
<!-- custom scripts -->
<script src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/main/js/scripts.js"></script>
<script>
	$(document).ready(function($) {
		$("#google-reviews").googlePlaces({
			placeId: 'ChIJSdN3fhwX2TgREJaLQc4e-Ig' //Find placeID @: https://developers.google.com/places/place-id
				,
			render: ['reviews'],
			min_rating: 4,
			max_rows: 5,
			rotateTime: false,
			shorten_names: true


		});
	});
</script>

</body>


</html>


<?php exit(); ?>
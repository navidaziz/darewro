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





<div class="div-padding contact-info-div">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-sm-6">
				<div class="single-contact-info text-center">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/contact_info.png" alt="icon">
					<h4>Address</h4>
					<p>Address : <?php echo $system_global_settings->address; ?></p>
				</div>
			</div>
			<div class="col-lg-4 col-sm-6">
				<div class="single-contact-info text-center">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/contact_info-2.png" alt="icon">
					<h4>Phone number</h4>
					<p>Phone : <?php echo $system_global_settings->phone_number; ?> , <?php echo $system_global_settings->mobile_number; ?>, <?php echo $system_global_settings->fax_number; ?></p>
				</div>
			</div>
			<div class="col-lg-4 offset-lg-0 col-sm-6 offset-sm-3">
				<div class="single-contact-info text-center">
					<img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/icon/contact_info-3.png" alt="icon">
					<h4>E-mail</h4>
					<p>Email : <?php echo $system_global_settings->email_address; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="div-padding contact-form-div p-t-0">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<form action="#">
					<h2>Send us an Email</h2>
					
					<p style="color:black !important">For more information, complaint and feedback feel free to contact us </p>
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="name" id="name" placeholder="Name" class="form-control">
						</div>
						<div class="col-lg-6">
							<input type="text" name="email" id="email" placeholder="E-mail" class="form-control">
						</div>
						<div class="col-lg-6">
							<input type="text" name="phone" id="phone" placeholder="Phone" class="form-control">
						</div>
						<div class="col-lg-6">
							<input type="text" name="subject" id="subject" placeholder="Subject" class="form-control">
						</div>
						<div class="col-lg-12">
							<textarea class="form-control" name="message" id="message" placeholder="Text Content"></textarea>
						</div>
					
					<div class="col-lg-4">
					<?php
					$this->load->library('session');
					$this->load->helper('captcha');
					$config = array(
						'img_url' => base_url() . 'image_for_captcha/',
						'img_path' => 'image_for_captcha/',
						'font_path'    => './system/fonts/texb.ttf',
						'img_width'    => '150',
							'img_height' => 30,
							'expiration' => 7200,
							'colors'        => array(
								'background' => array(255, 255, 255),
								'border' => array(255, 255, 255),
								'text' => array(0, 0, 0),
								'grid' => array(255, 40, 40)
)
					);


					
					$captcha = create_captcha($config);
					$this->session->unset_userdata('valuecaptchaCode');
					$this->session->set_userdata('valuecaptchaCode', $captcha['word']);
					//echo $captcha['word'];

					echo $captcha['image'];


					
					?>
</div>
<div class="col-lg-4">
	<input  type="text" name="valuecaptchaCode" id="valuecaptchaCode" placeholder="Captcha Code" class="form-control">
					</div>
					<div class="col-lg-4">
					<button class="button button-dark tiny" onclick="submit_form()" type="button">Send</button>
					<script>
						function submit_form(){
							var name = $("#name").val();
							var email = $("#email").val();
							var phone = $("#phone").val();
							var subject = $("#subject").val();
							var message = $("#message").val();
							var valuecaptchaCode = $("#valuecaptchaCode").val();
							var captchaCode = $("#captchaCode").val();
							if(name == ""){
								alert("Please enter your name");
								return false;
							}
							if(email == ""){
								alert("Please enter your email");
								return false;
							}
							if(phone == ""){
								alert("Please enter your phone");
								return false;
							}
							if(subject == ""){
								alert("Please enter your subject");
								return false;
							}
							if(message == ""){
								alert("Please enter your text content");
								return false;
							}
							if(valuecaptchaCode == ""){
								alert("Please enter your captcha code");
								return false;
							}

							$.ajax({
									type: 'POST',
									url: "<?php echo base_url(); ?>contact_us/send_email",
									data: {
										name: name,
										email: email,
										phone: phone,
										subject: subject,
										message: message,
										valuecaptchaCode: valuecaptchaCode,
										captchaCode: captchaCode
									},
									success: function(data) {
										$('#response').html(data);
										//console.log(data);


									},
									error: function(error) {
										alert("Error occur:" + error);
									}
									});
							
					}
					</script>

				</form>
				</div>
				</div>
				<div id="response"></div>
			</div>
			<div class="col-lg-6">
				<div class="contact-us-map">
					<iframe class="we-onmap wow fadeInUp" data-wow-delay="0.3s" style="width:100%; height: 445px;" src="<?php echo $contact_us_page[0]->google_map_link; ?>"></iframe>

				</div>
			</div>
		</div>
	</div>
</div>
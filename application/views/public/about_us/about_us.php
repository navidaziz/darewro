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

<div class="div-padding">

	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<h2 class="">About us</h2>
				<div class="about-us-text">
					<h4><?php echo $about_us->about_us_page_title; ?></h4>
					<p><?php echo $about_us->about_us_page_content; ?></p>

				</div>
			</div>
			<div class="col-lg-6">

				<img id="logo" width="960" height="389" src="<?php echo base_url("assets/uploads/" . $about_us->image); ?>" />
			</div>
		</div>
	</div>
</div>
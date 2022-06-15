<div id="owl-main-slider" class="owl-carousel enable-owl-carousel" data-single-item="true" data-pagination="false" data-auto-play="true" data-main-slider="true" data-stop-on-hover="true">
  <?php foreach ($slider_banners as $slider_banner) { ?>
    <div class="item"> <img src="<?php echo base_url("assets/uploads/" . $slider_banner->slider_banner_image); ?>" alt="slider">
      <div class="container-fluid">
        <div class="slider-content col-md-6 col-lg-6">
          <div style="display:table;">
            <div style="display:table-cell; width:100px; vertical-align:top;"> <a class="prev"><i class="fa fa-angle-left"></i></a> <a class="next"><i class="fa fa-angle-right"></i></a> </div>
            <div style="display:table-cell;">
              <h1 style="color:black"><?php echo $slider_banner->slider_banner_title; ?></h1>
            </div>
          </div>
          <p style="color:black">
            <strong><?php echo $slider_banner->slider_banner_sub_title; ?></strong>
            <?php echo $slider_banner->slider_banner_detail; ?>
          </p>
        </div>
      </div>
    </div>
  <?php } ?>

</div>
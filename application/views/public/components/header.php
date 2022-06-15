<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php if (isset($pageTitle)) {
            echo $pageTitle;
          } ?></title>
  <meta name="description" content="<?php if (isset($pageDescription)) {
                                      echo $pageDescription;
                                    } ?>">
  <meta name="keywords" content="<?php if (isset($pageKeywords)) {
                                    echo $pageKeywords;
                                  } ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png"> -->

  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/plugins/OwlCarousel/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/main/css/style.css">
</head>

<body class="theme-1">

  <header class="theme-1">
    <div class="header__upper">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="header__upper--left">
              <div class="logo">
                <a href="<?php echo base_url("/home"); ?>">
                  <img id="logo" width="122" height="32" title="<?php echo $system_global_settings->system_title; ?> Logo" src="<?php echo base_url("assets/uploads/" . $system_global_settings->sytem_public_logo); ?>" />
                </a>
              </div>
              <!-- <div class="search-bar">
                <form class="form">
                  <span class="icon icon-left"><i class="fas fa-map-marker-alt"></i></span>
                  <input class="form-control" type="search" name="search-bar" placeholder="Tell us your location" id="search-bar">
                  <button class="button button-dark" type="submit"><img src="<?php echo site_url("assets/" . PUBLIC_DIR); ?>/assets/images/arrow-shape.png" alt=""></button>
                </form>

              </div> -->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="header__upper--right">
              <nav class="navigation">
                <div class="helpline" style=" margin:5px; margin-top: 15px; font-size:20px;">
                  <h4><span style="color: #F7BC00; display: inline-block;">Hotline</span> (091) 724-1-724</h4>
                </div>
              </nav>
              <a style="color: black;" href="tel:+92917241724" class="button button-light big"><i class="fa fa-phone" aria-hidden="true"></i>
                <strong>Call For Delivery</strong></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header__lower">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg navbar-dark">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">


                  <li class="nav-item <?php if ($this->uri->segment(1) == 'home') {
                                        echo "active";
                                      } ?>">
                    <a class="nav-link " href="<?php echo base_url("/home"); ?>">
                      <i class="fas fa-home"></i> Home
                    </a>
                  </li>
                  <?php

                  foreach ($menu_pages as $menu_page) { ?>
                    <?php if (count($menu_page->menu_sub_pages) > 0) { ?>
                      <li class="nav-item dropdown 
                      <?php $page_id = (int) $this->uri->segment(3);
                      $query = "SELECT p.page_id, p.page_name  
                      FROM `menu_sub_pages` as sm
                      INNER JOIN menu_pages as m ON(m.menu_page_id = sm.menu_page_id)
                      INNER JOIN pages as p ON(p.page_id = m.page_id) 
                      WHERE sm.page_id= '" . $page_id . "'";
                      $current_main_page = $this->db->query($query)->row()->page_name;
                      ?>
                      <?php if ($menu_page->page_name == $current_main_page) {
                        echo "active";
                      } ?>
                      ">
                        <a class=" nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo base_url("page/view_page/" . $menu_page->page_id); ?>">
                          <?php if ($menu_page->icon) {     ?>
                            <i class="<?php echo $menu_page->icon; ?>"></i>
                          <?php } ?> <?php echo $menu_page->page_name; ?> </a>
                        <ul class="dropdown-menu">
                          <?php foreach ($menu_page->menu_sub_pages as $menu_sub_page) { ?>
                            <li> <a class="dropdown-item" href="<?php echo base_url("page/view_page/" . $menu_sub_page->page_id); ?>">
                                <?php if ($menu_sub_page->icon) {     ?>
                                  <i class="<?php echo $menu_sub_page->icon; ?>"></i>
                                <?php } ?>
                                <?php echo $menu_sub_page->page_name; ?></a></li>
                          <?php } ?>
                        </ul>
                      </li>
                    <?php } else { ?>
                      <li class="nav-item"><a class="nav-link" href="<?php echo base_url("page/view_page/" . $menu_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a></li>
                    <?php } ?>
                  <?php } ?>
                  <li class="nav-item <?php if ($this->uri->segment(1) == 'about_us') {
                                        echo "active";
                                      } ?>"><a class="nav-link" href="<?php echo base_url("/about_us"); ?>">
                      <i class="fas fa-info"></i> About Us</a></li>
                  <li class="nav-item <?php if ($this->uri->segment(1) == 'services') {
                                        echo "active";
                                      } ?>"><a class="nav-link" href="<?php echo base_url("/services"); ?>">
                      <i class="fas fa-cog"></i> Services</a></li>
                  <li class="nav-item  <?php if ($this->uri->segment(1) == 'contact_us') {
                                          echo "active";
                                        } ?>"><a class="nav-link" href="<?php echo base_url("/contact_us"); ?>">
                      <i class="fas fa-map-marker-alt"></i>Contacts</a></li>


                  <!-- <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" href="index.html"><i class="fas fa-home"></i>Home <span class="sr-only">(current)</span></a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="index-1.html">Home 2</a></li>

                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="about.html"><i class="fas fa-exclamation-circle"></i>About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="our-services.html"><i class="fas fa-cog"></i>Our Services</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="our-vehicles.html"><i class="fas fa-taxi"></i>Our Vehicles</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="packages.html"><i class="fas fa-cube"></i>Packages</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contact-us.html"><i class="fas fa-map-marker-alt"></i>Contacts</a>
                  </li> -->
                </ul>
                <div class="my-2 my-lg-0">

                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>
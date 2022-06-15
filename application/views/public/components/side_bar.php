<div class="col-lg-3">


  <div class="sidebar-module" style="margin: 20px;">
    <h4>Other Links</h4>
    <ul>
      <?php foreach ($menu_pages as $menu_page) { ?>
        <?php if (count($menu_page->menu_sub_pages) > 0) { ?>
          <!-- <li> <a href="<?php echo base_url("page/view_page/" . $menu_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a>
         -->


          <ul>
            <?php foreach ($menu_page->menu_sub_pages as $menu_sub_page) { ?>
              <li> <a href="<?php echo base_url("page/view_page/" . $menu_sub_page->page_id); ?>"><?php echo $menu_sub_page->page_name; ?></a>
              <?php } ?>
          </ul>
          </li>
        <?php } else { ?>
          <li> <a href="<?php echo base_url("page/view_page/" . $menu_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a>
          <?php } ?>

        <?php } ?>


    </ul>
    <!-- <ol class="list-unstyled">
      <li><a href="#">March 2014</a></li>
      <li><a href="#">February 2014</a></li>
      <li><a href="#">January 2014</a></li>
      <li><a href="#">December 2013</a></li>
      <li><a href="#">November 2013</a></li>
      <li><a href="#">October 2013</a></li>
      <li><a href="#">September 2013</a></li>
      <li><a href="#">August 2013</a></li>
      <li><a href="#">July 2013</a></li>
      <li><a href="#">June 2013</a></li>
      <li><a href="#">May 2013</a></li>
      <li><a href="#">April 2013</a></li>
    </ol> -->
  </div>





</div>
<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default" style="  height:100px; -webkit-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
-moz-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);  ">
                <div class="panel-body">
                  <div class="tab-content" style="text-align:center !important"> <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."accounts/riders_rides"); ?>">
                    <h3>All Orders</h3>
                    </a> </div>
                </div>
              </div>
            </div>
            
            
            <div class="col-md-3">
              <div class="panel panel-default" style="  height:100px; -webkit-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
-moz-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);  ">
                <div class="panel-body">
                  <div class="tab-content" style="text-align:center !important"> <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."accounts/riders"); ?>">
                    <h3>Per Rider Detail</h3>
                    </a> </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="panel panel-default" style="  height:100px; -webkit-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
-moz-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);  ">
                <div class="panel-body">
                  <div class="tab-content" style="text-align:center !important"> <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."accounts/staff_report"); ?>">
                    <h3>Staff Report</h3>
                    </a> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

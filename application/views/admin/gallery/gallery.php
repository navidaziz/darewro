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
        <div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."gallery/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."gallery/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
        <div id="filter-items" class="row isotope" >
          <?php foreach($albums as $gallery){ ?>
          <div class="col-md-3" >
            <div class="filter-content"> <img style="" src="<?php echo base_url("assets/uploads/".$gallery->image); ?>" alt="" class="img-responsive"> </div>
            <div >
              <h4><?php echo $gallery->album_title; ?></h4>
              <span class="pull-left"> <?php echo status($gallery->status,  $this->lang); ?>
              <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($gallery->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."gallery/publish/".$gallery->gallery_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($gallery->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."gallery/draft/".$gallery->gallery_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
              </span> <span class="pull-right"> <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."gallery/view_gallery/".$gallery->gallery_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."gallery/edit/".$gallery->gallery_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."gallery/trash/".$gallery->gallery_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a> </span> </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
         
              <?php foreach($restaurants as $restaurants): ?>
              
              
              
              <div class="col-md-3">
                    <div class="panel panel-default" style="  height:230px; -webkit-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
-moz-box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);
box-shadow: -2px 0px 14px -3px rgba(0,0,0,0.37);  ">
                      <div class="panel-body">
                        <div class="tab-content" style="text-align:center !important">
                        <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurants/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>">
                        
                          <?php
                echo file_type(base_url("assets/uploads/".$restaurants->restaurant_logo),false, 100);
            ?>
            
            </a>
             
           <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurants/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>">  <h4> <?php echo $restaurants->restaurant_name; ?></h4></a>
             <h6><?php echo $restaurants->restaurant_contact_no; ?></h6>
             
             
             <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."restaurants/up/".$restaurants->restaurant_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-up"></i> </a> <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."restaurants/down/".$restaurants->restaurant_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-arrow-down"></i></a>
             
             <?php echo status($restaurants->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($restaurants->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/publish/".$restaurants->restaurant_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($restaurants->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/draft/".$restaurants->restaurant_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                    <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurants/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."restaurants/edit/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."restaurants/trash/".$restaurants->restaurant_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                        </div>
                      </div>
                    </div>
                    
                    
                           
                           
                           
                  </div>
              
              
              
              <?php endforeach; ?>
              </div>
            </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

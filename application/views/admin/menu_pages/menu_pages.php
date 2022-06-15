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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."menu_pages/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <!--<a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."menu_pages/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>--> </div>
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
         <script>
          function get_sub_menu_form(menu_page_id){
			  $.ajax({
				  type:"POST",
				  url:"<?php echo base_url(ADMIN_DIR."menu_pages/get_sub_menu_form"); ?>/"+menu_page_id,
				  data:{}
				  }).done(function(data){
					  //page_content_body
					  $('#page_content_header').html("<?php echo $this->lang->line('Add Sub Pages'); ?>");
					  $('#page_content_body').html(data);
					  //
				  $('#page_content_form').modal('show');
				  });
			  }
          </script>
        <div class="modal fade" id="page_content_form" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="page_content_header">Modal Header</h4>
        </div>
        <div class="modal-body" id="page_content_body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
        
          <table class="table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('page_name'); ?></th>
                <th><?php echo $this->lang->line('Order'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($menu_pages as $menu_page): ?>
              <tr>
                <td><?php echo $menu_page->page_name; ?></td>
                <td><a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."menu_pages/up/".$menu_page->menu_page_id); ?>"><i class="fa fa-arrow-up"></i> </a> <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."menu_pages/down/".$menu_page->menu_page_id); ?>"><i class="fa fa-arrow-down"></i></a></td>
                <td><?php echo status($menu_page->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($menu_page->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."menu_pages/publish/".$menu_page->menu_page_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($menu_page->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."menu_pages/draft/".$menu_page->menu_page_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."menu_pages/view_menu_page/".$menu_page->menu_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."menu_pages/edit/".$menu_page->menu_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>--> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."menu_pages/delete/".$menu_page->menu_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                <button class="btn btn-primary btn-sm" onclick="get_sub_menu_form(<?php echo $menu_page->menu_page_id; ?>);"><?php echo $this->lang->line('Add Sub Pages'); ?></button>
                </td>
              </tr>
              
             
					  <?php $sub_page_count = 1; foreach($menu_page->menu_sub_pages as $menu_sub_page): ?>
                         
                         <tr>
                         
                             
           
            <td>
                <span style="margin-left:30px;"><?php echo $sub_page_count++.".  ". $menu_sub_page->page_name; ?></span>
            </td>
                                <td>
                                  <a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."menu_sub_pages/up/".$menu_sub_page->menu_sub_page_id."/".$menu_page->menu_page_id); ?>"><i class="fa fa-arrow-up"></i> </a>
                                  <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."menu_sub_pages/down/".$menu_sub_page->menu_sub_page_id."/".$menu_page->menu_page_id); ?>"><i class="fa fa-arrow-down"></i></a>
                                </td>
                                <td>
                                    <?php echo status($menu_sub_page->status,  $this->lang); ?>
                                    <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($menu_sub_page->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."menu_sub_pages/publish/".$menu_sub_page->menu_sub_page_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($menu_sub_page->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."menu_sub_pages/draft/".$menu_sub_page->menu_sub_page_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                                </td>
                                <td>
                                <!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."menu_sub_pages/view_menu_sub_page/".$menu_sub_page->menu_sub_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."menu_sub_pages/edit/".$menu_sub_page->menu_sub_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>-->
                                <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."menu_sub_pages/delete/".$menu_sub_page->menu_sub_page_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                         </tr>
                      <?php endforeach; ?>
						
              
              
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

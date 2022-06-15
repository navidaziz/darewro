<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."pages/view/"); ?>"><?php echo $this->lang->line('Pages'); ?></a> </li>
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
          <div class="pull-right"> 
          
          <!-- Modal -->
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
          
          
          
          <script>
          function get_page_content_form(){
			  $.ajax({
				  type:"POST",
				  url:"<?php echo base_url(ADMIN_DIR."pages/get_page_content_form/$pageid"); ?>",
				  data:{}
				  }).done(function(data){
					  //page_content_body
					  $('#page_content_header').html("<?php echo $this->lang->line('Add Page Content'); ?>");
					  $('#page_content_body').html(data);
					  //
				  $('#page_content_form').modal('show');
				  });
			  }
          </script>
          
         <script>
          function get_page_content_edit_form(page_content_id){
			  $.ajax({
				  type:"POST",
				  url:"<?php echo base_url(ADMIN_DIR."pages/get_page_content_edit_form/$pageid"); ?>",
				  data:{page_content_id: page_content_id }
				  }).done(function(data){
					  //page_content_body
					  $('#page_content_header').html("<?php echo $this->lang->line('Update Page Content'); ?>");
					  $('#page_content_body').html(data);
					  //
				  $('#page_content_form').modal('show');
				  });
			  }
          </script> 
          <button class="btn btn-primary btn-sm" onclick="get_page_content_form();"><?php echo $this->lang->line('Add Page Content'); ?></button>
           </div>
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
        <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>--> 
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($pages as $page): ?>
              <tr>
                <th><?php echo $this->lang->line('page_name'); ?></th>
                <td><?php echo $page->page_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('page_content'); ?></th>
                <td><?php echo $page->page_content; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('page_title'); ?></th>
                <td><?php echo $page->page_title; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('page_description'); ?></th>
                <td><?php echo $page->page_description; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('page_keywords'); ?></th>
                <td><?php echo $page->page_keywords; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <td><?php echo status($page->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <h4>Page Contents</h4>
          <table class="table ">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('page_content_title'); ?></th>
                <th><?php echo $this->lang->line('page_content_sub_title'); ?></th>
                <th><?php echo $this->lang->line('page_content_detail'); ?></th>
                <th><?php echo $this->lang->line('attachment'); ?></th>
                <th><?php echo $this->lang->line('Order'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($page_contents as $page_content): ?>
              <tr>
                <td><?php echo $page_content->page_content_title; ?></td>
                <td><?php echo $page_content->page_content_sub_title; ?></td>
                <td><?php echo $page_content->page_content_detail; ?></td>
                <td><?php
                echo file_type(base_url("assets/uploads/".$page_content->attachment));
            ?></td>
                <td><a class="llink llink-orderup" href="<?php echo site_url(ADMIN_DIR."page_contents/up/".$page_content->page_content_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-arrow-up"></i> </a> <a class="llink llink-orderdown" href="<?php echo site_url(ADMIN_DIR."page_contents/down/".$page_content->page_content_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-arrow-down"></i></a></td>
                <td><?php echo status($page_content->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($page_content->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."page_contents/publish/".$page_content->page_content_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($page_content->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."page_contents/draft/".$page_content->page_content_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."page_contents/view_page_content/".$page_content->page_content_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>--> <a onclick="get_page_content_edit_form(<?php echo $page_content->page_content_id;  ?>)" class="llink llink-edit" href="javascript:void(0);"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."page_contents/delete/".$page_content->page_content_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

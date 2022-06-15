<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."gallery/view/"); ?>"><?php echo $this->lang->line('Gallery'); ?></a> </li>
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
          <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."gallery/upload_images", $add_form_attr);
            ?>
          <input type="hidden" name="gallery_id" value="<?php echo $gallery_id; ?>" />
          <div class="form-group">
            <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); 
					
					//echo form_label($this->lang->line('image'), "image", $label);      ?>
            <div class="col-md-9">
              <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "image[]",
                        "id"            =>  "image",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('image'),
                        "value"         =>  set_value("image"),
						"multiple" => "multiple",
                        "placeholder"   =>  $this->lang->line('image')
                    );
                    echo  form_input($file);
                ?>
              <?php echo form_error("image", "<p class=\"text-danger\">", "</p>"); ?> </div>
            <div class="col-md-2">
              <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Save'),
					 "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
            </div>
            <div style="clear:both;"></div>
            <?php echo form_close(); ?> </div>
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
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($albums as $gallery): ?>
              <tr>
                <th width="200"><?php echo $this->lang->line('album_title'); ?></th>
                <td><?php echo $gallery->album_title; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('album_description'); ?></th>
                <td><?php echo $gallery->album_description; ?></td>
              </tr>
              <!--<tr>
                <th>Image</th>
                <td><?php
                    echo file_type(base_url("assets/uploads/".$gallery->image));
                ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <td><?php echo status($gallery->status); ?></td>
              </tr>-->
              <?php endforeach; ?>
            </tbody>
          </table>
          <div id="filter-items" class="row isotope" >
            <?php foreach($album_images as $album_image){ ?>
            <div class="col-md-3 " >
              <div class="filter-content box border blue" style="padding:5px;"> <img style="width:100%; height:220px"  src="<?php echo base_url("assets/uploads/".$album_image->image); ?>" alt="" class="img-responsive"> </div>
              <div >
                <h6><?php echo $album_image->image_detail; ?></h6>
                <span class="pull-left"><?php echo status($album_image->status,  $this->lang); ?>
                <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($album_image->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."album_images/publish/".$album_image->album_image_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($album_image->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."album_images/draft/".$album_image->album_image_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?>
                </span> <span class="pull-right"><!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."album_images/view_album_image/".$album_image->album_image_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>--> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."album_images/edit/".$album_image->album_image_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."album_images/delete/".$album_image->album_image_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a> </span> </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

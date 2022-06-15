<div class="modal top_model" id="open_modal"  >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="open_model_title">Title</h4>
      </div>
      <div class="modal-body" >
        <div class="row"> 
          <!-- MESSENGER -->
          <div class="col-md-12">
            <div class="box border blue">
              <div class="box-body" id="open_model_body">
               
              </div>
            </div>
          </div>
         
        </div>
      </div> 
    </div>
  </div>
</div>
<script>

function open_modal(modal_title, controller, con_function, id){
	if(id){ id=id; }else{ id=0; }
		$.ajax({
			type: "POST",
			url: site_url + "/"+controller+"/"+con_function+"/",
			data: {restaurant_id : '<?php echo $restaurant_id ?>', id:id}
		}).done(function(data) {
			 $('#open_model_body').html(data);
		});
	
	$('#open_model_title').html(modal_title);
	$('#open_modal').modal('show');
	
	}

</script>


<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."restaurants/view/"); ?>"><?php echo $this->lang->line('Restaurants'); ?></a> </li>
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
    <?php if($restaurant_user){ ?> 
	<button  onclick="open_modal('Edit Restaurant Manager Profile','users', 'get_user_edit_form','<?php echo $restaurant_user->user_id ?>')"  class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i> Edit Manager</button>
	<?php }else{ ?> 
	<button   onclick="open_modal('Add Restaurant Manager Profile','users', 'get_user_add_form' )"  class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Manager</button>
	<?php }?>     
    
   
   <a href="javascript:;" onclick="open_modal('Add New Food Category','restaurants', 'get_food_category_form' )" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Food Category</a> 
   
   <a   href="javascript:;" onclick="open_modal('Add New Food Menu With Category','restaurants', 'get_add_food_with_category_form' )" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Add Food With New Category</a> 
   
   <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."restaurants/food_menu_trashed/$restaurant_id"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row">
<div class="col-md-12"> 
<div class="alert alert-danger">
  <strong>Hi Dear it's me Navid here!</strong> in case of any problem feel free to contact me 03244424414.
</div>
</div>
  <!-- MESSENGER -->
  <div class="col-md-3">
    <div class="box border blue" id="messenger"> 
      <!--<div class="box-title">
        <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
        
      </div>-->
      <div class="box-body">
        <div class="table-responsive">
          <div style=" text-align:center; padding:10px;">
            <?php
                    echo file_type(base_url("assets/uploads/".$restaurants[0]->restaurant_logo),false, 100, 100);
                ?>
          </div>
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($restaurants as $restaurants): ?>
              <tr>
                <th><?php echo $this->lang->line('restaurant_name'); ?></th>
                <td><?php echo $restaurants->restaurant_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_location'); ?></th>
                <td><?php echo $restaurants->restaurant_location; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_detail'); ?></th>
                <td><?php echo $restaurants->restaurant_detail; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_contact_no'); ?></th>
                <td><?php echo $restaurants->restaurant_contact_no; ?></td>
              </tr>
              <!--<tr>
                <th>Restaurant Logo</th>
                <td><?php
                    echo file_type(base_url("assets/uploads/".$restaurants->restaurant_logo));
                ?></td>
              </tr>-->
              <tr>
                <th><?php echo $this->lang->line('restaurant_start_time'); ?></th>
                <td><?php echo $restaurants->restaurant_start_time; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('restaurant_close_time'); ?></th>
                <td><?php echo $restaurants->restaurant_close_time; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <td><?php echo status($restaurants->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> Food Menu</h4>
      </div>
     
      <div class="box-body">
        <div class="table-responsive">
          <?php 
		  foreach($restaurant_food_categories as $restaurant_food_category){ ?>
          <h4 class="pull-left"><?php echo $restaurant_food_category->restaurant_food_category; ?>
          <?php if($restaurant_food_category->restaurant_id==$restaurant_id){ ?><a style="font-size:13px !important" href="javascript:;" onclick="open_modal('Edit Food Category', 'restaurants', 'get_restaurant_food_categorie_edit_form','<?php echo $restaurant_food_category->restaurant_food_category_id; ?>')" >Edit</a><?php } ?>
          </h4>
          
          <a href="javascript:;" onclick="open_modal('Add New <?php echo $restaurant_food_category->restaurant_food_category; ?> Food Menu','restaurants', 'get_add_food_menu_form', '<?php echo $restaurant_food_category->restaurant_food_category_id;  ?>' )"  data-toggle="modal" href="#add_food_menu" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-plus"></i> Add Food</a>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('restaurant_food_name'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_price'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_quantity'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_description'); ?></th>
                <th><?php echo $this->lang->line('restaurant_food_image'); ?></th>
                <!--<th><?php echo $this->lang->line('restaurant_food_category'); ?></th>--> 
                <!-- <th><?php echo $this->lang->line('restaurant_name'); ?></th>-->
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count =1;
			  foreach($restaurant_food_category->restaurant_food_menus as $restaurant_food_menu): ?>
              <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_name; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_price; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_quantity; ?></td>
                <td><?php echo $restaurant_food_menu->restaurant_food_description; ?></td>
                <td><?php
                echo file_type(base_url("assets/uploads/".$restaurant_food_menu->restaurant_food_image));
            ?></td>
                <!--<td><?php echo $restaurant_food_menu->restaurant_food_category; ?></td>--> 
                <!-- <td><?php echo $restaurant_food_menu->restaurant_name; ?></td>-->
                <td><?php echo status($restaurant_food_menu->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($restaurant_food_menu->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/food_menu_publish/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($restaurant_food_menu->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."restaurants/food_menu_draft/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><!--<a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."restaurants/view_restaurant_food_menu/".$restaurant_food_menu->restaurant_food_menu_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> --> 
                  <a href="javascript:;" onclick="open_modal('Edit Restaurant Food','restaurants', 'get_food_edit_form', '<?php echo $restaurant_food_menu->restaurant_food_menu_id; ?>')" ><i class="fa fa-pencil-square-o"></i></a> <!--<a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."restaurant_food_menus/edit/".$restaurant_food_menu->restaurant_food_menu_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a>--> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."restaurants/food_menu_trash/".$restaurant_food_menu->restaurant_food_menu_id."/".$restaurant_id); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php 
		}
		  //echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- /MESSENGER --> 
</div>

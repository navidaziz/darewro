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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."customers/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."customers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
      
      <script>
      function on_key_press(){
    if (event.keyCode == 13) {
        searched_customer();
    }
    }
      </script>
      <div style=" background-color:#FBFBFB; min-height:40px; margin-bottom:10px;">
          <table width="100%">
            <tr>
              <td width="250" valign="top"><input style="margin:5px;" onkeypress="on_key_press()" type="text" name="search" value="" id="search" class="form-control pull-left"  required="" title="Mobile No" placeholder="Customer mobile number.." /></td>
              <td width="10" valign="top"><input onClick="searched_customer()" type="button" class="btn btn-link pull-left" value="Search" style="margin:5px;"></td>
              <td id="search_customer_detail"></td>
            </tr>
          </table>
        </div>
      
      
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
               
                <th><?php echo $this->lang->line('customer_name'); ?></th>
                <th><?php echo $this->lang->line('comment'); ?></th>
                <th><?php echo $this->lang->line('customer_email_address'); ?></th>
                 <th>Saved Locations</th>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <th><?php echo $this->lang->line('Action'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($customers as $customer): ?>
              <tr>
                
                <td><?php echo $customer->customer_name; ?></td>
                <td><?php echo $customer->comment; ?></td>
                <td><?php echo $customer->customer_email_address; ?></td>
                <td>
                <?php 
				$query="SELECT * FROM `customer_locations` WHERE `customer_id`=".$this->db->escape($customer->customer_id).";";
		$query_result = $this->db->query($query);
		$customer_locations = $query_result->result();
				
				foreach($customer_locations as $customer_location){ ?>
                <?php echo $customer_location->location_address; ?><br />
                <?php } ?>
                
                </td>
                <td><?php echo status($customer->status,  $this->lang); ?>
                  <?php
                                        
                                        //set uri segment
                                        if(!$this->uri->segment(4)){
                                            $page = 0;
                                        }else{
                                            $page = $this->uri->segment(4);
                                        }
                                        
                                        if($customer->status == 0){
                                            echo "<a href='".site_url(ADMIN_DIR."customers/publish/".$customer->customer_id."/".$page)."'> &nbsp;".$this->lang->line('Publish')."</a>";
                                        }elseif($customer->status == 1){
                                            echo "<a href='".site_url(ADMIN_DIR."customers/draft/".$customer->customer_id."/".$page)."'> &nbsp;".$this->lang->line('Draft')."</a>";
                                        }
                                    ?></td>
                <td><a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."customers/view_customer/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a> <a class="llink llink-edit" href="<?php echo site_url(ADMIN_DIR."customers/edit/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-pencil-square-o"></i></a> <a class="llink llink-trash" href="<?php echo site_url(ADMIN_DIR."customers/trash/".$customer->customer_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php echo $pagination; ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

<script>



function searched_customer() {
	//alert();

    var customer_mobile_no = $('#search').val();
    $.ajax({
        type: "POST",
        url: site_url + "/customers/searched_customer/" + customer_mobile_no,
        data: {}
    }).done(function(data) {
        //alert(data);
        //data = jQuery.parseJSON(data);
        $('#search_customer_detail').html(data);
    });

}

</script>

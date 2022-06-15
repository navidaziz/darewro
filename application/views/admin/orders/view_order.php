㪈Ꮹ檐ᐒ class="row">	<

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."orders/view/"); ?>"><?php echo $this->lang->line('Orders'); ?></a> </li>
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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."orders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
              <?php foreach($orders as $order): ?>
              <tr>
                <th><?php echo $this->lang->line('order_detail'); ?></th>
                <td><?php echo $order->order_detail; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('order_picking_address'); ?></th>
                <td><?php echo $order->order_picking_address; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('order_drop_address'); ?></th>
                <td><?php echo $order->order_drop_address; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('delivery_charges'); ?></th>
                <td><?php echo $order->delivery_charges; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('delivery_time'); ?></th>
                <td><?php echo $order->delivery_time; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('order_status'); ?></th>
                <td><?php echo $order->order_status; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('comment'); ?></th>
                <td><?php echo $order->comment; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('customer_name'); ?></th>
                <td><?php echo $order->customer_name; ?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('Status'); ?></th>
                <td><?php echo status($order->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 

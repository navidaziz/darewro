<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."riders/view/"); ?>"><?php echo $this->lang->line('Riders'); ?></a> </li>
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
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."riders/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
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
        <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."riders/update_data/$rider->rider_id", $edit_form_attr);
            ?>
        <?php echo form_hidden("rider_id", $rider->rider_id); ?>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('rider_name'), "rider_name", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "rider_name",
                        "id"            =>  "rider_name",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('rider_name'),
                        "value"         =>  set_value("rider_name", $rider->rider_name),
                        "placeholder"   =>  $this->lang->line('rider_name')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("rider_name", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('office_no'), "office_no", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "office_no",
                        "id"            =>  "office_no",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('office_no'),
                        "value"         =>  set_value("office_no", $rider->office_no),
                        "placeholder"   =>  $this->lang->line('office_no')
                    );
                    echo  form_input($number);
                ?>
            <?php echo form_error("office_no", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('personal_no'), "personal_no", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $number = array(
                        "type"          =>  "number",
                        "name"          =>  "personal_no",
                        "id"            =>  "personal_no",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required","title"         =>  $this->lang->line('personal_no'),
                        "value"         =>  set_value("personal_no", $rider->personal_no),
                        "placeholder"   =>  $this->lang->line('personal_no')
                    );
                    echo  form_input($number);
                ?>
            <?php echo form_error("personal_no", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        <?php //var_dump($rider); ?>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('duty_start'), "duty_start", $label);      ?>
          <div class="col-md-8">
            <select required="required"  onchange="set_end_timing()" class="form-control" name="duty_start" id="duty_start">
              <option value="">Select Duty Start Time</option>
              
              <?php for($i=0; $i<=23; $i++ ){ ?>
              <option 
                <?php if($rider->duty_start==$i){ ?>
                selected="selected"
                <?php } ?> value="<?php echo $i; ?>"><?php echo strtoupper((date("h A", strtotime("00-00-00 ".$i.":00:00")))); ?></option>
              <?php } ?>
            </select>
            <?php echo form_error("duty_start", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <script>
  function set_end_timing(){
		$("#duty_end").children('option:not(:first)').remove();
		var start_time = $('#duty_start').val();
		start_time++;
		time = start_time;
		for(i=1; i<=24; i++){
		   if(time>23){
			 time = 0;  
			   }
			suffix = time >= 12 ? "PM":"AM"; 
			hours = ((time + 11) % 12 + 1) +' '+suffix;
			if(start_time>23){ 
			$("#duty_end").append(new Option(hours+' Next Day', start_time));
			}else{
				$("#duty_end").append(new Option(hours+' Today ', start_time));
				}
			start_time++;
			time++;
		}
		
		}
	//set_end_timing();	
    </script>
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('duty_end'), "duty_end", $label);      ?>
          <div class="col-md-8">
            <select required="required"  class="form-control" name="duty_end" id="duty_end">
             <option value="">Select Duty End Time</option>
            <?php 
			$start_time = $rider->duty_start;
			$start_time++;
			$time = $start_time;
			 if($time>23){
			$time = 0;  
			   }
			
			for($i=$rider->duty_start+1; $i<=24+$rider->duty_start; $i++){ 
			if($time>23){
				$time = $time-24;
				}
			?>
    	<option <?php if($rider->duty_end==$i){ 
		
		?>
                selected="selected"
                <?php } ?> value="<?php echo $i; ?>"><?php echo date("h A", strtotime("00-00-00 ".$time.":00:00")); ?>
                <?php if($start_time>23){ ?> Next Day <?php } ?>                
                </option>
    <?php 
	$time++;
	$start_time++;
	} ?>
            </select>
            <?php echo form_error("duty_end", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        
        
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('ability_level'), "ability_level", $label);      ?>
          <div class="col-md-8">
            <select required="required"  class="form-control" name="ability_level" id="ability_level">
              <?php for($i=1; $i<=5; $i++ ){ ?>
              <option  
                <?php if($rider->ability_level==$i){ ?>  selected="selected" <?php } ?> value="<?php echo $i; ?>">
              <?php for($j=1; $j<=$i; $j++){ echo "*"; } ?>
              </option>
              <?php } ?>
            </select>
            <?php echo form_error("ability_level", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                   echo form_label($this->lang->line('comments'), "comments", $label);
                ?>
          <div class="col-md-8">
            <?php
                    
                    $textarea = array(
                        "name"          =>  "comments",
                        "id"            =>  "comments",
                        "class"         =>  "form-control",
                        "style"         =>  "",
                        "title"         =>  $this->lang->line('comments'),
                        "rows"          =>  "",
                        "cols"          =>  "",
                        "value"         => set_value("comments", $rider->comments),
                        "placeholder"   =>  $this->lang->line('comments')
                    );
                    echo form_textarea($textarea);
                ?>
            <?php echo form_error("comments", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('rider_password'), "rider_password", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "rider_password",
                        "id"            =>  "rider_password",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required",
						"title"         =>  $this->lang->line('rider_password'),
                        "value"         =>  set_value("rider_password", $rider->rider_password),
                        "placeholder"   =>  $this->lang->line('rider_password')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("rider_password", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
         <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    ); echo form_label($this->lang->line('rider_email'), "rider_email", $label);      ?>
          <div class="col-md-8">
            <?php
                    
                    $text = array(
                        "type"          =>  "email",
                        "name"          =>  "rider_email",
                        "id"            =>  "rider_email",
                        "class"         =>  "form-control",
                        "style"         =>  "","required"	  => "required",
						"title"         =>  $this->lang->line('rider_email'),
                        "value"         =>  set_value("rider_email", $rider->rider_email),
                        "placeholder"   =>  $this->lang->line('rider_email')
                    );
                    echo  form_input($text);
                ?>
            <?php echo form_error("rider_email", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        
        
        
        <div class="form-group">
          <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );  echo form_label($this->lang->line('rider_image')."<br />".file_type(base_url("assets/uploads/".$rider->rider_image)), "rider_image", $label);     ?>
          <div class="col-md-8">
            <?php
                    
                    $file = array(
                        "type"          =>  "file",
                        "name"          =>  "rider_image",
                        "id"            =>  "rider_image",
                        "class"         =>  "form-control",
                        "style"         =>  "","title"         =>  $this->lang->line('rider_image'),
                        "value"         =>  set_value("rider_image", $rider->rider_image),
                        "placeholder"   =>  $this->lang->line('rider_image')
                    );
                    echo  form_input($file);
                ?>
            <!--<?php echo file_type(base_url("assets/uploads/$rider->rider_image")); ?>--> 
            
            <?php echo form_error("rider_image", "<p class=\"text-danger\">", "</p>"); ?> </div>
        </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="col-md-offset-2 col-md-10">
          <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Update'),
                    "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?>
          <?php
                $reset = array(
                    "type"  =>  "reset",
                    "name"  =>  "reset",
                    "value" =>  $this->lang->line('Reset'),
                    "class" =>  "btn btn-default",
                    "style" =>  ""
                );
                echo form_reset($reset); 
            ?>
        </div>
        <div style="clear:both;"></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>

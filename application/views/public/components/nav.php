<!--<ul>
<?php
//var_dump($menu_pages);
foreach($menu_pages as $menu_page){ 
echo count($menu_page->menu_sub_pages);
?>
<li><a href="<?php echo base_url("page/view_page/".$menu_page->page_id); ?>" ><?php echo $menu_page->page_name; ?></a></li>
<ul>
<?php foreach($menu_page->menu_sub_pages as $menu_sub_page){ ?>
<li>
<a href="<?php echo base_url("page/view_page/".$menu_sub_page->page_id); ?>" ><?php echo $menu_sub_page->page_name; ?></a></li>
<?php } ?>
</ul>
<?php } ?>
</ul>-->
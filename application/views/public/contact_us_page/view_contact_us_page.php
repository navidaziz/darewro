<div class="breadcrumb-box">
    <div class="container">
        <!-- BREADCRUMBS -->
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url("Home"); ?>">Home</a>
                <span class="divider">/</span>
            </li>
            <li>
                <i class="fa fa-table"></i>
                <a href="<?php echo site_url("contact_us_page/view/"); ?>">Contact Us Page</a>
                <span class="divider">/</span>
            </li>
            <li><?php echo $title; ?> </li>
        </ul>
    </div>
</div>
<!-- .breadcrumb-box -->
<section id="main">
    <header class="page-header">
        <div class="container">
            <h1 class="title"><?php echo $title; ?></h1>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <?php $this->load->view(PUBLIC_DIR . "components/nav"); ?><div class="content span9 pull-right">
                <div class="table-responsive">

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <?php foreach ($contact_us_page as $contact_us_page) : ?>


                                <tr>
                                    <th><?php echo $this->lang->line('contact_us_page_content'); ?></th>
                                    <td>
                                        <?php echo $contact_us_page->contact_us_page_content; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('contact_us_page_title'); ?></th>
                                    <td>
                                        <?php echo $contact_us_page->contact_us_page_title; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('contact_us_page_description'); ?></th>
                                    <td>
                                        <?php echo $contact_us_page->contact_us_page_description; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('contact_us_page_keyword'); ?></th>
                                    <td>
                                        <?php echo $contact_us_page->contact_us_page_keyword; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('google_map_link'); ?></th>
                                    <td>
                                        <?php echo $contact_us_page->google_map_link; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>




                </div>

            </div>
        </div>
    </div>
    <!-- .container -->
</section>
<!-- #main -->
<?php
/*
  Template Name: Fullwidth
 */
if(New_Layout_Helper::isCheckWooPage()){
    echo st()->load_template('layouts/modern/page/page');
    return;
}
if(New_Layout_Helper::isNewLayout()){
    get_header();
    ?>
    <div id="st-content-wrapper" class="st-page-default">
        <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
        <?php st_breadcrumbs_new() ?>
        <div class="st-blog">
            <?php
            if ( have_posts() ) {
                the_post();
                the_content();
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <?php
    get_footer();
}
<?php get_header();
wp_enqueue_script('st-vina-stripe-js');
?>

    <div id="st-content-wrapper" class="st-page-default">
        <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
        <?php st_breadcrumbs_new() ?>
        <div class="container">
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
    </div>
<?php
get_footer();
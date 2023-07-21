<div id="st-content-wrapper" class="search-result-page st-page-default">
    <?php echo st()->load_template('layouts/elementor/hotel/elements/banner'); ?>
    <?php st_breadcrumbs_new() ?>
    <div class="st-blog">
        <?php
        global $st_search_args;
        $st_search_args['location_id'] = get_the_ID();
        if ( have_posts() ) {
            the_post();
            the_content();
        }
        wp_reset_postdata();
        ?>
    </div>
</div>
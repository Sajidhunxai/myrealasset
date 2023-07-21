<?php
get_header();
wp_enqueue_script('filter-tour-js');
?>
<div id="st-content-wrapper" class="search-result-page st-tours st-tour--solo" data-style="grid8">
    <div class="st-tour--solo__banner">
        <?php echo st()->load_template('layouts/modern/blog/banner'); ?>
        <?php st_breadcrumbs_new() ?>
    </div>

    <div class="search-form-top">
        <?php echo st()->load_template('layouts/modern/tour/elements/search-form-solo', '', ['container' => 'container']); ?>
    </div>
    <div class="container">
        <div class="st-hotel-result">
            <div class="row">
                <?php
                $query = array(
                    'post_type' => 'st_tours',
                    'post_status' => 'publish',
                    's' => '',
                    'orderby' => 'post_modified',
                    'order' => 'DESC'
                );
                global $wp_query, $st_search_query;
                $tour = STTour::get_instance();
                $tour->alter_search_query();
                query_posts($query);
                $st_search_query = $wp_query;
                $tour->remove_alter_search_query();
                wp_reset_query();
                echo st()->load_template('layouts/modern/tour/elements/solo');

                echo st()->load_template('layouts/modern/tour/elements/sidebar-solo');
                ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();

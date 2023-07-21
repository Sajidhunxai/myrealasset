<?php
get_header();
wp_enqueue_script('filter-activity');
?>
    <div id="st-content-wrapper" class="search-result-page st-tours st-activity">
        <div id="tour-top-search"></div>
        <?php
        echo st()->load_template('layouts/elementor/hotel/elements/banner');
        ?>
        <div class="full-map d-none d-sm-none d-md-block">
            <div class="search-form-wrapper">
                <div class="container">
                    <div class="row st-padding-col">
                        <?php echo st()->load_template('layouts/elementor/activity/elements/search-form'); ?>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="container">
            <div class="st-results st-hotel-result tour-top-search">
                    <?php
                    $query           = array(
                        'post_type'      => 'st_activity' ,
                        'post_status'    => 'publish' ,
                        's'              => '' ,
                        'orderby' => 'post_modified',
                        'order'   => 'DESC',
                    );
                    global $wp_query , $st_search_query;
                    $activity = STActivity::inst();
                    $activity->alter_search_query();
                    query_posts( $query );
                    $st_search_query = $wp_query;
                    $activity->remove_alter_search_query();
                    wp_reset_query();
                    echo st()->load_template('layouts/elementor/activity/elements/content2');
                    ?>
            </div>
        </div>
    </div>
<?php
echo st()->load_template('layouts/elementor/hotel/elements/popup/date');
echo st()->load_template('layouts/elementor/hotel/elements/popup/guest');
get_footer();
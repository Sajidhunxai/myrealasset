<?php
get_header();
wp_enqueue_script('filter-activity');

$sidebar_pos = get_post_meta(get_the_ID(), 'rs_activity_sidebar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';

?>
    <div id="st-content-wrapper" class="search-result-page st-tours st-activity">
        <?php
        echo st()->load_template('layouts/elementor/hotel/elements/banner');
        ?>
        <div class="container">
            <div class="st-results st-hotel-result st-search-tour style-full-map">
                <div class="row">
                    <?php
                    if($sidebar_pos == 'left') {
                        echo st()->load_template('layouts/elementor/activity/elements/sidebar');
                    }
                    ?>
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
                    echo st()->load_template('layouts/elementor/activity/elements/content');

                    if($sidebar_pos == 'right') {
                        echo st()->load_template('layouts/elementor/activity/elements/sidebar');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
echo st()->load_template('layouts/modern/hotel/elements/popup/date');
echo st()->load_template('layouts/modern/hotel/elements/popup/guest');
get_footer();
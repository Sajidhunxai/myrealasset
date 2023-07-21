<?php
get_header();
wp_enqueue_script('filter-activity');

$sidebar_pos = get_post_meta(get_the_ID(), 'rs_activity_sidebar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';
?>
    <div id="st-content-wrapper" class="st-style-elementor search-result-page activity-layout5" data-layout="5" data-format="top">
        <?php echo stt_elementorv2()->loadView('services/activity/components/banner');
            echo stt_elementorv2()->loadView('services/activity/components/top-filter');
        ?>
        <div class="container">
            <div class="st-results st-hotel-result st-search-tour">
                <div class="row">
                <?php
                    $query           = array(
                        'post_type'      => 'st_activity' ,
                        'post_status'    => 'publish' ,
                        's'              => ''
                    );
                    global $wp_query , $st_search_query;

                    $current_lang = TravelHelper::current_lang();
                    $main_lang = TravelHelper::primary_lang();
                    if (TravelHelper::is_wpml()) {
                        global $sitepress;
                        $sitepress->switch_lang($main_lang, true);
                    }

                    $activity = STActivity::inst();
                    $activity->alter_search_query();
                    query_posts( $query );
                    $st_search_query = $wp_query;
                    $activity->remove_alter_search_query();
                    wp_reset_query();

                    if (TravelHelper::is_wpml()) {
                        global $sitepress;
                        $sitepress->switch_lang($current_lang, true);
                    }

                    echo stt_elementorv2()->loadView('services/activity/components/content-2');
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
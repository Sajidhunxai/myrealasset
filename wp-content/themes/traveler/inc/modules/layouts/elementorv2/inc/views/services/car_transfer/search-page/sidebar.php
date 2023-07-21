<?php
get_header();

wp_enqueue_script('filter-car-transfer');
?>
    <div id="st-content-wrapper" class="st-style-elementor search-result-page" data-layout="3" data-format="popup">
        <?php echo stt_elementorv2()->loadView('services/car_transfer/components/banner'); ?>
        <div class="container">
            <div class="st-results st-hotel-result st-search-tour">
                <div class="row">
                    <?php
                    echo stt_elementorv2()->loadView('services/car_transfer/components/sidebar', ['format' => 'popupmap']);
                    $query           = array(
                        'post_type'      => 'st_cars' ,
                        'post_status'    => 'publish' ,
                        's'              => '' ,
                        'orderby' => 'post_modified',
                        'order'   => 'DESC',
                    );
                    global $wp_query , $st_search_query;
                    $car = STCarTransfer::inst();
                    $car->get_search_results();
                    query_posts( $query );
                    $st_search_query = $wp_query;
                    $car->get_search_results_remove_filter();
                    wp_reset_query();

                    if (TravelHelper::is_wpml()) {
                        global $sitepress;
                        $sitepress->switch_lang($current_lang, true);
                    }

                    echo stt_elementorv2()->loadView('services/car_transfer/components/content');
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
<?php
get_header();
wp_enqueue_script('filter-hotel');
?>
    <div id="st-content-wrapper" class="st-style-elementor search-result-page layout5" data-layout="5" data-format="halfmap">
        <?php
        echo stt_elementorv2()->loadView('services/hotel/components/banner');
        echo stt_elementorv2()->loadView('services/hotel/components/top-filter');
        ?>
        <div class="st-results st-hotel-result" id="sticky-halfmap">
            <?php
            $query = array(
                'post_type' => 'st_hotel',
                'post_status' => 'publish',
                's' => ''
            );
            global $wp_query, $st_search_query;

            $current_lang = TravelHelper::current_lang();
            $main_lang = TravelHelper::primary_lang();
            if (TravelHelper::is_wpml()) {
                global $sitepress;
                $sitepress->switch_lang($main_lang, true);
            }

            $hotel = STHotel::inst();
            $hotel->alter_search_query();
            query_posts($query);
            $st_search_query = $wp_query;
            $hotel->remove_alter_search_query();
            wp_reset_query();

            if (TravelHelper::is_wpml()) {
                global $sitepress;
                $sitepress->switch_lang($current_lang, true);
            }

            echo stt_elementorv2()->loadView('services/hotel/components/content-halfmap');
            echo stt_elementorv2()->loadView('services/hotel/components/popupmap');
            ?>
        </div>
    </div>
<?php
get_footer(); ?>
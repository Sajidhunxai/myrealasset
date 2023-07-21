<?php
get_header();
wp_enqueue_script('filter-rental');
?>
    <div id="st-content-wrapper" class="st-style-elementor search-result-page layout-rental-4" data-layout="4" data-format="halfmap">
        <?php
        echo stt_elementorv2()->loadView('services/rental/components/banner');
        echo stt_elementorv2()->loadView('services/rental/components/top-filter');
        ?>
        <div class="st-results st-hotel-result st-rental-result" id="sticky-halfmap">
            <?php
            $query = array(
                'post_type' => 'st_rental',
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
            $rental = STRental::inst();
            $rental->alter_search_query();
            query_posts($query);
            $st_search_query = $wp_query;
            $rental->remove_alter_search_query();
            wp_reset_query();

            if (TravelHelper::is_wpml()) {
                global $sitepress;
                $sitepress->switch_lang($current_lang, true);
            }

            echo stt_elementorv2()->loadView('services/rental/components/content-halfmap');
            echo stt_elementorv2()->loadView('services/rental/components/popupmap');
            ?>
        </div>
    </div>
<?php
get_footer(); ?>
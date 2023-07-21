<?php
get_header();
wp_enqueue_script('filter-hotel-js');
?>
    <div id="st-content-wrapper" class="search-result-page">
<?php
echo st()->load_template('layouts/modern/hotel/elements/banner');
$zoom_map = get_post_meta(get_the_ID(), 'rs_map_room', true);
$sidebar_pos = get_post_meta(get_the_ID(), 'rs_hotel_siderbar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';
if(empty($zoom_map)) $zoom_map = 13;
$check_enable_map_google = st()->get_option('st_googlemap_enabled');
if($check_enable_map_google === 'on'){
    $height_map = '500px';
} else{
    $height_map = '650px';
}
?>

    <div class="full-map">
        <?php echo st()->load_template('layouts/modern/common/loader', 'map'); ?>
        <div class="full-map-item">
            <div class="title-map-mobile hidden-lg hidden-md"><?php echo __('MAP', 'traveler'); ?> <span class="close-map"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></div>
            <div id="map-search-form" style="width: 100%; height: <?php echo esc_attr($height_map);?>" class="full-map-form" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="<?php echo esc_attr($zoom_map); ?>" data-popup-position="right"></div>
        </div>
        <?php echo st()->load_template('layouts/modern/hotel/elements/search-form'); ?>
    </div>
    <div class="container">
        <div class="st-hotel-result style-full-map">
            <div class="row">
                <?php
                if($sidebar_pos == 'left'){
                    echo st()->load_template('layouts/modern/hotel/elements/sidebar');
                }
                ?>
                <?php
                $query           = array(
                    'post_type'      => 'st_hotel' ,
                    'post_status'    => 'publish' ,
                    's'              => '' ,
                    'orderby' => 'post_modified',
                    'order'   => 'DESC',
                );

                global $wp_query , $st_search_query;

                $current_lang = TravelHelper::current_lang();
                $main_lang = TravelHelper::primary_lang();
                if (TravelHelper::is_wpml()) {
                    global $sitepress;
                    $sitepress->switch_lang($main_lang, true);
                }

                $hotel = STHotel::inst();
                $hotel->alter_search_query();

                query_posts( $query );
                $st_search_query = $wp_query;
                $hotel->remove_alter_search_query();
                wp_reset_query();

                if (TravelHelper::is_wpml()) {
                    global $sitepress;
                    $sitepress->switch_lang($current_lang, true);
                }

                echo st()->load_template('layouts/modern/hotel/elements/content');

                if($sidebar_pos == 'right'){
                    echo st()->load_template('layouts/modern/hotel/elements/sidebar');
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
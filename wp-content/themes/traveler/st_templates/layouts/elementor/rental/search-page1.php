<?php
get_header();
wp_enqueue_script('filter-rental');
$check_enable_map_google = st()->get_option('st_googlemap_enabled');
if($check_enable_map_google === 'on'){
    $height_map = '500px';
} else{
    $height_map = '650px';
}
?>
<div id="st-content-wrapper" class="search-result-page st-search-rental">
    <?php
    echo st()->load_template('layouts/elementor/rental/elements/banner');
    $zoom_map = get_post_meta(get_the_ID(), 'rs_map_room', true);
    if(empty($zoom_map)) $zoom_map = 13;
    ?>
    <div class="full-map">
        <?php echo st()->load_template('layouts/elementor/common/loader', 'map'); ?>
        <div class="full-map-item">
            <div class="title-map-mobile d-block d-sm-none d-md-none"><?php echo __('MAP', 'traveler'); ?> <span class="close-map"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></div>
            <div id="map-search-form" style="width: 100%; height: <?php echo esc_attr($height_map);?>" class="full-map-form" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="<?php echo esc_attr($zoom_map); ?>" data-popup-position="right"></div>
        </div>
        <div class="search-form-wrapper">
            <div class="container">
                <div class="row">
                    <?php echo st()->load_template('layouts/elementor/rental/elements/search-form'); ?>
                </div>
                
            </div>
        </div>
    </div>

    <div class="container">
        <div class="st-results st-hotel-result style-full-map">
            <div class="row">
                <?php echo st()->load_template('layouts/elementor/rental/elements/sidebar'); ?>
                <?php
                $query           = array(
                    'post_type'      => 'st_rental' ,
                    'post_status'    => 'publish' ,
                    's'              => '' ,
                    'posts_per_page' => get_option('posts_per_page', 10)
                );
                global $wp_query , $st_search_query;
                $rental = STRental::inst();
                $rental->alter_search_query();
                query_posts( $query );
                $st_search_query = $wp_query;
                $rental->remove_alter_search_query();
                wp_reset_query();
                echo st()->load_template('layouts/elementor/rental/elements/content');
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    echo st()->load_template('layouts/elementor/rental/elements/popup/date');
    echo st()->load_template('layouts/elementor/rental/elements/popup/guest');
get_footer();
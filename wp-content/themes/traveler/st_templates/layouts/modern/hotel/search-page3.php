<?php
get_header();
wp_enqueue_script('filter-hotel-js');

$sidebar_pos = get_post_meta(get_the_ID(), 'rs_hotel_siderbar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';
?>
    <div id="st-content-wrapper" class="search-result-page">
        <?php
        echo st()->load_template('layouts/modern/hotel/elements/banner');
        ?>
        <div class="container">
            <div class="st-hotel-result">
                <div class="row">
                    <?php
                    if($sidebar_pos == 'left') {
                        echo st()->load_template('layouts/modern/hotel/elements/sidebar', '', array('format' => 'popupmap'));
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

                    echo st()->load_template('layouts/modern/hotel/elements/content3');
                    echo st()->load_template('layouts/modern/hotel/elements/popupmap');

                    if($sidebar_pos == 'right') {
                        echo st()->load_template('layouts/modern/hotel/elements/sidebar', '', array('format' => 'popupmap'));
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
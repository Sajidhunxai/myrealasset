<?php
get_header();
wp_enqueue_script('filter-tour');

$sidebar_pos = get_post_meta(get_the_ID(), 'rs_tour_sidebar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';
?>
    <div id="st-content-wrapper" class="search-result-page st-tours">
        <?php
        echo st()->load_template('layouts/elementor/hotel/elements/banner');
        ?>
        <div class="container">
            <div class="st-results st-hotel-result st-search-tour style-full-map">
                <div class="row">
                    <?php
                    if($sidebar_pos == 'left') {
                        echo st()->load_template('layouts/elementor/tour/elements/sidebar');
                    }
                    ?>
                    <?php
                    $query           = array(
                        'post_type'      => 'st_tours' ,
                        'post_status'    => 'publish' ,
                        'order'   => 'DESC',
                    );
                    global $wp_query , $st_search_query;
                    $tour = STTour::get_instance();
                    $tour->alter_search_query();
                    query_posts( $query );
                    $st_search_query = $wp_query;
                    $tour->remove_alter_search_query();
                    wp_reset_query();
                    echo st()->load_template('layouts/elementor/tour/elements/content');

                    if($sidebar_pos == 'right') {
                        echo st()->load_template('layouts/elementor/tour/elements/sidebar');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
echo st()->load_template('layouts/elementor/hotel/elements/popup/date');
echo st()->load_template('layouts/elementor/hotel/elements/popup/guest');
get_footer();
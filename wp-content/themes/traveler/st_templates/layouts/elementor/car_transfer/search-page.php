<?php
get_header();
wp_enqueue_script('filter-car-transfer');
?>
    <div id="st-content-wrapper" class="search-result-page st-search-car st-search-cartransfer">
        <?php
        echo st()->load_template('layouts/elementor/hotel/elements/banner');
        ?>
        <div class="container">
            <div class="st-results st-hotel-result">
                <div class="row">
                    <?php echo st()->load_template('layouts/elementor/car_transfer/elements/sidebar'); ?>
                    <?php
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
                   
                    echo st()->load_template('layouts/elementor/car_transfer/elements/content');
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
echo st()->load_template('layouts/elementor/car_transfer/elements/popup/date');
get_footer();
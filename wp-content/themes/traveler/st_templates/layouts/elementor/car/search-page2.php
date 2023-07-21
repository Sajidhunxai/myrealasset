<?php
get_header();
wp_enqueue_script('filter-car');
?>
<div id="st-content-wrapper" class="search-result-page st-search-rental st-search-car style-car-2">
    <div id="tour-top-search"></div>
    <?php
    echo st()->load_template('layouts/elementor/hotel/elements/banner');
    ?>
    <div class="full-map">
        <?php echo st()->load_template('layouts/elementor/common/loader', 'map'); ?>
        <div class="search-form-wrapper">
            <div class="container">
                <div class="row">
                <?php echo st()->load_template('layouts/elementor/car/elements/search-form'); ?>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="st-results st-hotel-result style-full-map">
            <?php
            $query           = array(
                'post_type'      => 'st_cars' ,
                'post_status'    => 'publish' ,
                's'              => '' ,
                'orderby' => 'post_modified',
                'order'   => 'DESC',
            );
            global $wp_query , $st_search_query;
            $car = STCars::get_instance();
            $car->alter_search_query();
            query_posts( $query );
            $st_search_query = $wp_query;
            $car->remove_alter_search_query();
            wp_reset_query();
            echo st()->load_template('layouts/elementor/car/elements/content2');
            ?>
        </div>
    </div>
</div>
<?php
echo st()->load_template('layouts/elementor/car/elements/popup/date');
echo st()->load_template('layouts/elementor/car/elements/popup/guest');
get_footer();
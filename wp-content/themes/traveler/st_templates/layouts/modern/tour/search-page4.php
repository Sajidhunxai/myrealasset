<?php
get_header();
wp_enqueue_script('filter-tour-js');

$sidebar_pos = get_post_meta(get_the_ID(), 'rs_tour_sidebar_pos', true);
if(empty($sidebar_pos))
    $sidebar_pos = 'left';
?>
    <div id="st-content-wrapper" class="search-result-page style-2 st-tours">
        <?php
        echo st()->load_template('layouts/modern/hotel/elements/banner');
        ?>
        <div class="search-form-top">
            <?php
            $container = 'container';
            echo st()->load_template('layouts/modern/tour/elements/search-form-new', '', ['container' => $container]); ?>
        </div>
        <div class="container">
            <div class="st-hotel-result tour-sidebar-search">
                <div class="row">
                    <?php
                    if($sidebar_pos == 'left') {
                        echo st()->load_template('layouts/modern/tour/elements/sidebar-new');
                    }
                    ?>
                    <?php
                    $query           = array(
                        'post_type'      => 'st_tours' ,
                        'post_status'    => 'publish' ,
                        's'              => '' ,
                        'orderby' => 'post_modified',
                        'order'   => 'DESC',
                    );
                    global $wp_query , $st_search_query;
                    $tour = STTour::get_instance();
                    $tour->alter_search_query();
                    query_posts( $query );
                    $st_search_query = $wp_query;
                    $tour->remove_alter_search_query();
                    wp_reset_query();
                    echo st()->load_template('layouts/modern/tour/elements/content');

                    if($sidebar_pos == 'right') {
                        echo st()->load_template('layouts/modern/tour/elements/sidebar-new');
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
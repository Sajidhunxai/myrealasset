<?php
get_header();
wp_enqueue_script('filter-rental');
?>
    <div id="st-content-wrapper" class="search-result-page st-search-rental">
        <?php
        echo st()->load_template('layouts/elementor/rental/elements/banner');
        ?>
        <div class="container">
            <div class="st-results st-hotel-result">
                <div class="row">
                    <?php echo st()->load_template('layouts/elementor/rental/elements/sidebar', '', array('format' => 'popupmap')); ?>
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
                    echo st()->load_template('layouts/elementor/rental/elements/content3');
                    echo st()->load_template('layouts/elementor/rental/elements/popupmap');
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
echo st()->load_template('layouts/elementor/rental/elements/popup/date');
echo st()->load_template('layouts/elementor/rental/elements/popup/guest');
get_footer();
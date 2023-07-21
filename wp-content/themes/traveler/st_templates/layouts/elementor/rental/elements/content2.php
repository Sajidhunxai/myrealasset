<?php
$style = get_post_meta(get_the_ID(), 'rs_style_rental', true);
if (empty($style))
    $style = 'grid';

global $wp_query, $st_search_query;
if ($st_search_query) {
    $query = $st_search_query;
} else $query = $wp_query;
?>
<div class="row service-list-wrapper page-half-map">
    <div class="col-lg-6 col-md-6 col-left">
        <?php echo st()->load_template('layouts/elementor/rental/elements/toolbar', '', array('style' => $style)); ?>
        <div id="modern-search-result" class="modern-search-result st-scrollbar" data-format="halfmap" data-layout="2">
            <?php echo st()->load_template('layouts/modern/common/loader', 'content'); ?>
            <div class="<?php echo ($style == 'list') ? 'service-list-wrapper list-style' : 'row service-list-wrapper'; ?>">
                <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        if($style === "grid"){
                            echo st()->load_template('layouts/elementor/rental/loop/normal', $style, array('item_row'=> 2));
                        } else {
                            echo st()->load_template('layouts/elementor/rental/loop/halfmap', $style);
                        }
                        
                    }
                } else {
                    echo '<div class="col-12">';
                    echo st()->load_template('layouts/elementor/rental/elements/none');
                    echo '</div>';
                }
                wp_reset_query();
                ?>
            </div>
        </div>

        <div class="pagination moderm-pagination" id="moderm-pagination">
            <?php echo TravelHelper::paging(false, false); ?>
            <span class="count-string">
                <?php
                if (!empty($st_search_query)) {
                    $query = $st_search_query;
                }
                if ($query->found_posts):
                    $page = get_query_var('paged');
                    $posts_per_page = st()->get_option('rental_posts_per_page', 12);
                    if (!$page) $page = 1;
                    $last = $posts_per_page * ($page);
                    if ($last > $query->found_posts) $last = $query->found_posts;
                    echo sprintf(__('%d - %d of %d ', 'traveler'), $posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                    echo ( $query->found_posts == 1 ) ? __( 'Rental', 'traveler' ) : __( 'Rentals', 'traveler' );
                endif;
                ?>
            </span>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-right">
        <?php echo st()->load_template('layouts/modern/common/loader', 'map'); ?>
        <div class="map-title d-md-none"><?php echo __('Map', 'traveler'); ?> <span class="close-half-map"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></div>
        <div id="map-search-form" class="map-full-height" data-disablecontrol="true"
             data-showcustomcontrol="true"></div>
    </div>
</div>
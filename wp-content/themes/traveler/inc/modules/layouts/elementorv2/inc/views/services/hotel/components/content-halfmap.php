<?php
$style = get_post_meta(get_the_ID(), 'rs_style', true);
if (empty($style))
    $style = 'grid';

global $wp_query, $st_search_query;
if ($st_search_query) {
    $query = $st_search_query;
} else $query = $wp_query;

$map_pos = get_post_meta(get_the_ID(), 'rs_hotel_map_pos', true);
if(empty($map_pos))
    $map_pos = 'right';
?>
<div class="service-list-wrapper page-half-map map-<?php echo esc_attr($map_pos); ?>">
    <?php if($map_pos == 'left'){ ?>
        <div class="col-right maparea">
            <?php echo st()->load_template('layouts/elementor/common/loader', 'map'); ?>
            <div class="map-title d-md-none"><?php echo __('Map', 'traveler'); ?> <span class="close-half-map"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></div>
            <div class="toggle-map" id="st-toggle-map"><span class="stt-icon stt-icon-arrow-left"></span></div>
            <div class="close-map-new" id="st-close-map"><span class="stt-icon stt-icon-close"></span></div>
            <div class="search-move-map">
                <div class="st-icheck-item">
                    <label for="st-move-map" class="c-grey">
                        <input type="checkbox" name="movemap" id="st-move-map" value="1">
                        <?php echo esc_html__('Search as I move the map', 'traveler'); ?>
                        <span class="checkmark fcheckbox"></span>
                    </label>
                </div>
                <input type="hidden" name="st-map-coordinate" value="" id="st-map-coordinate"/>
            </div>
            <div id="map-search-form" class="map-full-height" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="13"></div>
        </div>
    <?php } ?>

    <div class="col-left dataarea">
        <?php echo stt_elementorv2()->loadView('services/hotel/components/toolbar', ['style' => $style]); ?>
        <div id="modern-search-result" class="modern-search-result st-scrollbar" data-format="halfmap" data-layout="2">
            <?php echo st()->load_template('layouts/elementor/common/loader', 'content'); ?>
            <div class="row service-list-wrapper <?php echo ($style == 'list') ? 'list-style' : ''; ?>">
                <?php
                if($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<div class="col-lg-6 col-md-6 col-12 item-service">';
                            echo stt_elementorv2()->loadView('services/hotel/loop/' . esc_html($style));
                        echo '</div>';
                    }
                }else{
                    echo '<div class="col-12">';
                    echo st()->load_template('layouts/elementor/hotel/elements/none');
                    echo '</div>';
                }
                wp_reset_query();
                ?>
            </div>
            <div class="pagination moderm-pagination" id="moderm-pagination">
                <?php echo TravelHelper::paging(false, false); ?>
            </div>
        </div>
        <div class="show-map-mobile">
            <a href="javascript:void(0);">
                <span class="stt-icon stt-icon-map"></span>
                <?php echo esc_html__('Map', 'traveler'); ?>
            </a>
        </div>
    </div>
    <?php if($map_pos == 'right'){ ?>
    <div class="col-right maparea">
        <?php echo st()->load_template('layouts/elementor/common/loader', 'map'); ?>
        <div class="map-title d-md-none"><?php echo __('Map', 'traveler'); ?> <span class="close-half-map"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></div>
        <div class="toggle-map" id="st-toggle-map"><span class="stt-icon stt-icon-arrow-left"></span></div>
        <div class="close-map-new" id="st-close-map"><span class="stt-icon stt-icon-close"></span></div>
        <div class="search-move-map">
            <div class="st-icheck-item">
                <label for="st-move-map" class="c-grey">
                    <input type="checkbox" name="movemap" id="st-move-map" value="1">
                    <?php echo esc_html__('Search as I move the map', 'traveler'); ?>
                    <span class="checkmark fcheckbox"></span>
                </label>
            </div>
            <input type="hidden" name="st-map-coordinate" value="" id="st-map-coordinate"/>
        </div>
        <div id="map-search-form" class="map-full-height" data-disablecontrol="true" data-showcustomcontrol="true" data-zoom="13"></div>
    </div>
    <?php } ?>
</div>

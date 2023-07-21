<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter', true);
if(!isset($format))
    $format = '';
?>
<div class="col-lg-3 col-md-3 sidebar-filter">
    <div class="close-sidebar"><span class="stt-icon stt-icon-close"></span></div>
    <?php if($format == 'popupmap'){ ?>
        <div class="sidebar-item st-border-radius map-view-wrapper d-none d-sm-none d-md-block">
            <div class="map-view">
                <span class="stt-icon stt-icon-location1 icon-marker"></span>
                <div class="map-view-button">
                    <?php echo esc_html__('View in a map', 'traveler'); ?>
                    <span class="stt-icon stt-icon-arrow2-right"></span>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    if(!empty($filters)){
        foreach ($filters as $k => $v){
            echo stt_elementorv2()->loadView('services/hotel/components/sidebar/' . esc_attr($v['rs_filter_type']), ['title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']]);
        }
    }
    ?>
</div>
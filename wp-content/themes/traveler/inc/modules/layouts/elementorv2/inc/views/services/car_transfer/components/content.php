<?php
$style = get_post_meta(get_the_ID(), 'rs_style', true);
if (empty($style))
    $style = 'grid';

global $wp_query, $st_search_query;
if ($st_search_query) {
    $query = $st_search_query;
} else $query = $wp_query;

if(empty($format))
    $format = '';

if(empty($layout))
    $layout = '';
?>
<div class="col-sm-12 col-md-9 col-lg-9">
    <?php echo stt_elementorv2()->loadView('services/hotel/components/toolbar', ['style' => $style, 'has_filter' => false, 'post_type' => 'st_car_transfer', 'service_text' => __('New','traveler')]); ?>
    <div id="modern-search-result" class="modern-search-result" data-layout="4">
        <?php echo st()->load_template('layouts/elementor/common/loader', 'content'); ?>
        <div class="service-list-wrapper service-tour list-style">
        <?php
        if($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="col-12 item-service mb-3">';
                if(wp_is_mobile()){
                    echo stt_elementorv2()->loadView('services/car_transfer/loop/grid');
                } else {
                    echo stt_elementorv2()->loadView('services/car_transfer/loop/list');
                }
                
                echo '</div>';
            }
        }else{
            echo st()->load_template('layouts/modern/car_transfer/elements/loop/none');
        }
        wp_reset_query();
        echo '</div>';
        ?>
    </div>
    <div class="pagination moderm-pagination" id="moderm-pagination">
        <?php echo TravelHelper::paging(false, false); ?>
    </div>
</div>

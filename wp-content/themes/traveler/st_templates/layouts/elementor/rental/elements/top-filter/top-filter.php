<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_rental', true);
if(!isset($format))
    $format = '';
?>
<div class="top-filter d-flex align-items-center justify-content-between">
    <ul>
        <li><h3 class="title"><?php echo __('FILTER BY', 'traveler'); ?></h3> <span class="d-md-none hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></li>
        <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/elementor/rental/elements/top-filter/' . esc_html($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
        ?>
    </ul>
    <?php if($format != 'popup'){ ?>
    <div class="show-map">
        <div class="form-check switch form-switch">
            <label class="form-check-label" for="btn-show-map"><?php echo __('Maps', 'traveler'); ?></label>
            <input class="form-check-input" type="checkbox" id="btn-show-map" checked>
            
        </div>
    </div>

    <div class="show-map show-map-on-mobile d-none">
        <div class="form-check switch form-switch">
            <label class="form-check-label" for="btn-show-map-mobile"><?php echo __('Maps', 'traveler'); ?></label>
            <input class="form-check-input" type="checkbox" id="btn-show-map-mobile" checked>
            
        </div>
    </div>
    <?php }else{ ?>
        <span class="close-map-view-popup"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span>
    <?php } ?>
</div>
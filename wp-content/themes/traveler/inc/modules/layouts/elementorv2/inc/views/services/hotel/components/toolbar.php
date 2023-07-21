<?php
if (!isset($format))
    $format = '';
if (!isset($layout))
    $layout = '';
if (!isset($service_text)) {
    $service_text = __('New hotel', 'traveler');
}
if (!isset($post_type)) {
    $post_type = 'st_hotel';
}

$name_asc = 'name_asc';
$name_desc = 'name_desc';

?>
<div class="toolbar d-flex align-items-center justify-content-between flex-row-reverse">
    <?php if (isset($has_filter)) { ?>
    <div class="show-filter-mobile">
        <div class="btn-filter-wrapper">
            <div class="button-filter">
                <span class="stt-icon stt-icon-filter"></span>
                <?php echo esc_html__('Filters', 'traveler'); ?>
            </div>
            <div class="btn-clear-filter"><?php echo esc_html__('Clear filter', 'traveler') ?></div>
        </div>
        <?php } ?>
        <ul class="toolbar-action d-none d-md-flex align-items-center justify-content-right">
            <li>
                <div class="form-extra-field dropdown <?php echo ($format == 'popup') ? 'popup-sort' : ''; ?>">
                    <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuSort"
                            data-bs-toggle="dropdown" data-bs-auto-close="true" aria-haspopup="true"
                            aria-expanded="false">
                        <?php echo __('Sort', 'traveler'); ?> <span class="stt-icon stt-icon-arrow-down"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end sort-menu" aria-labelledby="dropdownMenuSort">
                        <div class="sort-item st-icheck">
                            <div class="st-icheck-item"><label> <?php echo esc_html($service_text); ?><input
                                            class="service_order" type="radio"
                                            name="service_order_<?php echo esc_attr($format); ?>"
                                            data-value="new"/><span class="checkmark"></span></label></div>
                        </div>
                        <?php 
                        if($post_type != 'st_car_transfer'){?>
                            <div class="sort-item st-icheck">
                                <span class="title"><?php echo __('Price', 'traveler'); ?></span>
                                <div class="st-icheck-item"><label> <?php echo __('Low to High', 'traveler'); ?><input
                                                class="service_order" type="radio"
                                                name="service_order_<?php echo esc_attr($format); ?>"
                                                data-value="price_asc"/><span class="checkmark"></span></label></div>
                                <div class="st-icheck-item"><label> <?php echo __('High to Low', 'traveler'); ?><input
                                                class="service_order" type="radio"
                                                name="service_order_<?php echo esc_attr($format); ?>"
                                                data-value="price_desc"/><span class="checkmark"></span></label></div>
                            </div>
                        <?php }
                        ?>
                        
                        <div class="sort-item st-icheck">
                            <span class="title"><?php echo __('Name', 'traveler'); ?></span>
                            <div class="st-icheck-item"><label> <?php echo __('a - z', 'traveler'); ?><input
                                            class="service_order" type="radio"
                                            name="service_order_<?php echo esc_attr($format); ?>"
                                            data-value="<?php echo esc_attr($name_asc); ?>"/><span
                                            class="checkmark"></span></label></div>
                            <div class="st-icheck-item"><label> <?php echo __('z - a', 'traveler'); ?><input
                                            class="service_order" type="radio"
                                            name="service_order_<?php echo esc_attr($format); ?>"
                                            data-value="<?php echo esc_attr($name_desc); ?>"/><span
                                            class="checkmark"></span></label></div>
                        </div>
                    </div>
                </div>
            </li>
            <?php if ($format != 'popup' and !isset($top_search) &&  $post_type != 'st_car_transfer') { ?>
                <li class="layout">
                <span class="layout-item <?php echo ($style == 'list') ? 'active' : ''; ?>" data-value="list">
                    <span class="stt-icon stt-icon-list"></span>
                </span>
                    <span class="layout-item <?php echo ($style == 'grid') ? 'active' : ''; ?>" data-value="grid">
                    <span class="stt-icon stt-icon-category"></span>
                </span>
                </li>
            <?php } ?>
        </ul>

        <?php if (isset($has_filter)) { ?>
    </div>
<?php } ?>
    <?php
    $result_string = '';
    switch ($post_type) {
        case 'st_hotel':
            if(class_exists('STHotel')){
                $result_string = balanceTags(STHotel::inst()->get_result_string('hotelv2'));
            }
            
            break;
        case 'st_tours':
            if(class_exists('STTour')){
                $result_string = balanceTags(STTour::get_instance()->get_result_string());
            }
            break;
        case 'st_activity':
            if(class_exists('STActivity')){
                $result_string = balanceTags(STActivity::inst()->get_result_string());
            }
            break;
        case 'st_cars':
            if(class_exists('STCars')){
                $result_string = balanceTags(STCars::get_instance()->get_result_string());
            }
            break;
        case 'st_car_transfer':
            if(class_exists('STCarTransfer')){
                $result_string = balanceTags(STCarTransfer::inst()->get_result_string());
            }
            
            break;
        default:
            if(class_exists('STHotel')){
                $result_string = balanceTags(STHotel::inst()->get_result_string());
            }
    }
    ?>
    <h2 class="search-string modern-result-string"
        id="modern-result-string"><?php echo balanceTags($result_string); ?></h2>
</div>

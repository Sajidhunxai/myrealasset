<?php
if(!isset($format))
    $format = '';
if(!isset($layout))
	$layout = '';
if(!isset($service_text)){
    $service_text = __('New hotel', 'traveler');
}
if(!isset($post_type)){
    $post_type = 'st_hotel';
}

$name_asc = 'name_asc';
$name_desc = 'name_desc';
if(in_array($post_type, array('st_tours', 'st_activity'))){
    $name_asc = 'name_a_z';
    $name_desc = 'name_z_a';
}

?>
<div class="toolbar top-toolbar-filter d-flex align-items-center justify-content-between flex-row-reverse<?php echo ($layout == '3') ? 'layout3' : ''; ?>">
    <ul class="toolbar-action hidden-xs d-none d-md-flex align-items-center justify-content-right">
        <li>
            <div class="form-extra-field dropdown <?php echo ($format == 'popup') ? 'popup-sort' : ''; ?>" style="margin-right: 0">
                <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuSort" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 0">
                    <?php echo __('Sort', 'traveler'); ?> <i class="fa fa-angle-down arrow"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end sort-menu" aria-labelledby="dropdownMenuSort">
                    <div class="sort-title">
                        <h3><?php echo __('SORT BY', 'traveler'); ?> <span class="hidden-lg hidden-md hidden-sm close-filter"><i class="fa fa-times" aria-hidden="true"></i></span></h3>
                    </div>
                    <div class="sort-item st-icheck">
                        <div class="st-icheck-item"><label> <?php echo esc_html($service_text); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>" data-value="new" /><span class="checkmark"></span></label></div>
                    </div>
                    <div class="sort-item st-icheck">
                        <span class="title"><?php echo __('Price', 'traveler'); ?></span>
                        <div class="st-icheck-item"><label> <?php echo __('Low to High', 'traveler'); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>"  data-value="price_asc"/><span class="checkmark"></span></label></div>
                        <div class="st-icheck-item"><label> <?php echo __('High to Low', 'traveler'); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>"  data-value="price_desc"/><span class="checkmark"></span></label></div>
                    </div>
                    <div class="sort-item st-icheck">
                        <span class="title"><?php echo __('Name', 'traveler'); ?></span>
                        <div class="st-icheck-item"><label> <?php echo __('a - z', 'traveler'); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>"  data-value="<?php echo esc_attr($name_asc); ?>"/><span class="checkmark"></span></label></div>
                        <div class="st-icheck-item"><label> <?php echo __('z - a', 'traveler'); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>"  data-value="<?php echo esc_attr($name_desc); ?>"/><span class="checkmark"></span></label></div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="dropdown-menu sort-menu sort-menu-mobile">
        <div class="sort-title">
            <h3><?php echo __('SORT BY', 'traveler'); ?> <span class="d-md-none hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>
        </div>
        <div class="sort-item st-icheck">
            <div class="st-icheck-item"><label> <?php echo esc_html($service_text); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>" data-value="new" /><span class="checkmark"></span></label></div>
        </div>
        <div class="sort-item st-icheck">
            <span class="title"><?php echo __('Price', 'traveler'); ?></span>
            <div class="st-icheck-item"><label> <?php echo __('Low to High', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="price_asc"/><span class="checkmark"></span></label></div>
            <div class="st-icheck-item"><label> <?php echo __('High to Low', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="price_desc"/><span class="checkmark"></span></label></div>
        </div>
        <div class="sort-item st-icheck">
            <span class="title"><?php echo __('Name', 'traveler'); ?></span>
            <div class="st-icheck-item"><label> <?php echo __('a - z', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="<?php echo esc_attr($name_asc); ?>"/><span class="checkmark"></span></label></div>
            <div class="st-icheck-item"><label> <?php echo __('z - a', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="<?php echo esc_attr($name_desc); ?>"/><span class="checkmark"></span></label></div>
        </div>
    </div>
    <ul class="toolbar-action-mobile d-md-none">
        <li><a href="#" class="btn btn-primary btn-date"><?php echo __('Date', 'traveler'); ?></a></li>
        <?php if($post_type == 'st_hotel'){ ?>
            <li><a href="#" class="btn btn-primary btn-guest"><?php echo __('Guest', 'traveler'); ?></a></li>
        <?php } ?>

        <?php
        if($post_type == 'st_hotel') {
            if ($layout == '3') {
                ?>
                <li><a href="#" class="btn btn-primary map-view"><?php echo __('Map', 'traveler'); ?></a></li>
                <?php
            } else {
                ?>
                <li><a href="#"
                       class="btn btn-primary <?php echo ($format == 'popup') ? 'map-view' : 'btn-map'; ?>"><?php echo __('Map', 'traveler'); ?></a>
                </li>
                <?php
            }
        }
        ?>
        <li><a href="#" class="btn btn-primary btn-sort"><?php echo __('Sort', 'traveler'); ?></a></li>
        <li><a href="#" class="btn btn-primary btn-filter"><?php echo __('Filter', 'traveler'); ?></a></li>
    </ul>
    <?php
    $result_string = '';
    switch ($post_type){
        case 'st_hotel':
            $result_string = balanceTags(STHotel::inst()->get_result_string());
            break;
        case 'st_tours':
            $result_string = balanceTags(STTour::get_instance()->get_result_string());
            break;
        case 'st_activity':
            $result_string = balanceTags(STActivity::inst()->get_result_string());
            break;
        case 'st_cars':
            $result_string = balanceTags(STCars::get_instance()->get_result_string());
            break;
        case 'st_car_transfer':
            $result_string = balanceTags(STCarTransfer::inst()->get_result_string());
            break;
        default:
            $result_string = balanceTags(STHotel::inst()->get_result_string());
            break;
    }
    ?>
    <h2 class="search-string modern-result-string" id="modern-result-string"><?php echo balanceTags($result_string); ?> <div id="btn-clear-filter" class="btn-clear-filter" style="display: none"><?php echo __('Clear filter', 'traveler'); ?></div> </h2>
</div>

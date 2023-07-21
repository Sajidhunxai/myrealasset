<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_tour', true);
if(!isset($format))
    $format = '';

$name_asc = 'name_a_z';
$name_desc = 'name_z_a';
?>
 <h2 class="search-string modern-result-string" id="modern-result-string"><?php echo balanceTags(STTour::get_instance()->get_result_string()); ?> <div id="btn-clear-filter" class="btn-clear-filter" style="display: none"><?php echo __('Clear filter', 'traveler'); ?></div> </h2>
<div class="top-filter d-md-flex justify-content-between align-items-center">
   
    <ul>
        <li><h3 class="title"><?php echo __('FILTER BY', 'traveler'); ?></h3> <span class="d-block d-sm-none d-md-none close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></li>
        <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/elementor/tour/elements/top-filter/' . esc_attr($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
        ?>
    </ul>

    <div class="toolbar toolbar-intop">
        <ul class="toolbar-action d-none d-sm-block d-md-block">
            <li>
                <div class="form-extra-field dropdown">
                    <button class="btn btn-link dropdown" type="button" id="dropdownMenuSort" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <?php echo __('Sort', 'traveler'); ?> <i class="fa fa-angle-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end sort-menu" aria-labelledby="dropdownMenuSort">
                        <div class="sort-title">
                            <h3><?php echo __('SORT BY', 'traveler'); ?></h3>
                        </div>
                        <div class="sort-item st-icheck">
                            <div class="st-icheck-item"><label> <?php echo __('New tour', 'traveler'); ?><input class="service_order" type="radio" name="service_order_<?php echo esc_attr($format); ?>" data-value="new" /><span class="checkmark"></span></label></div>
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
            <li class="layout hidden">
            <span class="layout-item" data-value="list">
                <span class="icon-active"><?php echo TravelHelper::getNewIcon('ico_list-active', '#A0A9B2'); ?></span>
                <span class="icon-normal"><?php echo TravelHelper::getNewIcon('ico_list', '#A0A9B2'); ?></span>
            </span>
                <span class="layout-item active" data-value="grid">
                <span class="icon-active"><?php echo TravelHelper::getNewIcon('ico_grid_active', '#A0A9B2'); ?></span>
                <span class="icon-normal"><?php echo TravelHelper::getNewIcon('ico_grid', '#A0A9B2'); ?></span>
            </span>
            </li>
        </ul>
    </div>
</div>

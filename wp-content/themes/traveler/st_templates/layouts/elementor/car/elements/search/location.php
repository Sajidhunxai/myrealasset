<?php
$enable_tree = st()->get_option('bc_show_location_tree', 'off');

$location_id = STInput::request('location_id', '');
if(is_singular('location')){
    $location_id = get_the_ID();
}
if (!empty($location_id)) {
    $location_name = get_the_title($location_id);
} else {
    $location_name = '';
}

if ($enable_tree == 'on') {
    $lists = TravelHelper::getListFullNameLocation('st_cars');
    $locations = TravelHelper::buildTreeHasSort($lists);
} else {
    $locations = TravelHelper::getListFullNameLocation('st_cars');
}
$has_icon = (isset($has_icon)) ? $has_icon : false;

?>
<div class="destination-search">
    <div id="dropdown-pickup" class="form-group d-flex align-items-center form-extra-field dropdown field-detination dropdown-toggle field-destination-car <?php if ($has_icon) echo 'has-icon' ?>"  data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
        <?php
        if ($has_icon) {
            echo TravelHelper::getNewIcon('ico_maps_search_box');
        }
        ?>
        <div class="st-form-dropdown-icon" >
            <label><?php echo __('Location', 'traveler'); ?></label>
            <div class="render">
                    <?php
                        if(empty($location_name)) {
                            $placeholder = __('Where are you going?', 'traveler');
                        }else{
                            $placeholder = esc_html($location_name);
                        }
                    ?>
                
                <input type="text" autocomplete = "off" onkeyup="stKeyupsmartSearch(this)" id="st_location_name_car" class="location_name" name="location_name"
                value="<?php echo esc_attr($location_name); ?>" placeholder = "<?php echo esc_attr($placeholder);?>" />
            </div>
            <input type="hidden" class="location_id" name="location_id"
                value="<?php echo esc_attr($location_id); ?>"/>
        </div>
    </div>
    <ul class="dropdown-menu st-scrollbar" aria-labelledby="dropdown-pickup">
        <?php
        if ($enable_tree == 'on') {
            New_Layout_Helper::buildTreeOptionLocation($locations, $location_id);
        } else {
            if (is_array($locations) && count($locations)):
                foreach ($locations as $key => $value):
                    ?>
                    <li class="item" data-value="<?php echo esc_attr( $value->ID); ?>">
                        <?php echo TravelHelper::getNewIcon('ico_maps_search_box', '', '16px', '16px'); ?>
                        <span><?php echo esc_attr($value->fullname); ?></span></li>
                <?php
                endforeach;
            endif;
        }
        ?>
    </ul>
</div>
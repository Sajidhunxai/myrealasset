<?php
$enable_tree = st()->get_option( 'bc_show_location_tree', 'off' );
$location_id = STInput::get( 'location_id', '' );
$location_name = STInput::get( 'location_name', '' );
if(empty($location_name)){
    if(!empty($location_id)){
        $location_name = get_the_title($location_id);
    }
}
if ( $enable_tree == 'on' ) {
    $lists     = TravelHelper::getListFullNameLocation( 'st_cars', -1);
    $locations = TravelHelper::buildTreeHasSort( $lists );
} else {
    $locations = TravelHelper::getListFullNameLocation( 'st_cars', -1);
}

$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
if(is_singular('location')){
    $location_id = get_the_ID();
}
?>
<div class="destination-search border-right">
    <div id="dropdown-destination-car" class="form-group d-flex align-items-center form-extra-field dropdown field-detination dropdown-toggle <?php if ( $has_icon ) echo 'has-icon' ?>" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
        <?php
        if ( $has_icon ) {
            echo '<span class="stt-icon stt-icon-location1"></span>';
        }
        ?>
        <div class="st-form-dropdown-icon" >
            <label><?php echo esc_html__( 'Location', 'traveler' ); ?></label>
            <div class="render">
                <?php
                $placeholder = esc_html__('Where are you going?', 'traveler');
                ?>
                <input type="text" onkeyup="stKeyupsmartSearch(this)" autocomplete = "off" id="location_name_car" name="location_name" value="<?php echo esc_attr($location_name); ?>" placeholder = "<?php echo esc_attr($placeholder);?>" data-post-type="st_cars" data-text-no="<?php echo esc_html__('No locations...', 'traveler') ?>"/>
            </div>

            <input type="hidden" name="location_id" value="<?php echo esc_attr($location_id); ?>"/>
        </div>


    </div>
    <div class="dropdown-menu"  aria-labelledby="dropdown-destination-car">
        <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
        <ul class="st-scrollbar">
            <li class="location-heading"><span><?php echo esc_html__('Popular destinations', 'traveler'); ?></span></li>
            <?php
            if ( $enable_tree == 'on' ) {
                New_Layout_Helper::buildTreeOptionLocation( $locations, $location_id, '<span class="stt-icon stt-icon-location1"></span>', true);
            } else {
                if ( is_array( $locations ) && count( $locations ) ):
                    foreach ( $locations as $key => $value ):
                        ?>
                        <li class="item dropdown-item" data-value="<?php echo esc_attr($value->ID); ?>">
                            <span class="stt-icon stt-icon-location1"></span>
                            <span><?php echo esc_attr($value->fullname); ?></span></li>
                    <?php
                    endforeach;
                endif;
            }
            ?>
        </ul>
    </div>
</div>


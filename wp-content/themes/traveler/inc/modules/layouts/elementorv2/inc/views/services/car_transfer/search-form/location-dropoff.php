<?php
$data = TravelHelper::transferDestinationOptionNewFronend('not_label_select');

$old_data_to = STInput::get('transfer_to','');

$enable_tree = st()->get_option('bc_show_location_tree', 'off');
$transfer_to = STInput::request('transfer_to', '');

if(is_singular('location')){
    $transfer_to = get_the_ID();
}
if (!empty($transfer_to)) {
    $location_name = get_the_title($transfer_to);
} else {
    $location_name = '';
}


$transfer_to_id = STInput::request('transfer_to', '');
if (!empty($transfer_to_id)) {
    $location_name_dropoff = get_the_title($transfer_to_id);
} else {
    $location_name_dropoff = __('Drop-off To','traveler');
}

if ($enable_tree == 'on') {
    $lists = TravelHelper::getListFullNameLocation('st_cars');
    $locations = TravelHelper::buildTreeHasSort($lists);
} else {
    $locations = TravelHelper::getListFullNameLocation('st_cars');
}
$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
?>
<div class="destination-search border-right">
    <div id="dropdown-destination-to" role="menu" class="form-group d-flex align-items-center form-extra-field dropdown field-detination field-detination-to dropdown-toggle <?php if ( $has_icon ) echo 'has-icon' ?>"  data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
        <?php
        if ( $has_icon ) {
            echo '<span class="stt-icon stt-icon-location1"></span>';
        }
        ?>
        <div class="st-form-dropdown-icon" >
            <label><?php echo esc_html__( 'Drop-off', 'traveler' ); ?></label>
            <div class="render">
                <?php
                $placeholder = esc_html__('Enter location', 'traveler');
                ?>
                <input type="text" onkeyup="stKeyupsmartSearch(this)" autocomplete = "off" id="transfer_to_name" name="transfer_to_name" value="<?php echo esc_attr($location_name_dropoff); ?>" placeholder = "<?php echo esc_attr($placeholder);?>" data-post-type="st_cars" data-text-no="<?php echo esc_html__('No locations...', 'traveler') ?>"/>
            </div>
            <input type="hidden" name="transfer_to" value="<?php echo esc_attr($transfer_to); ?>"/>
        </div>


    </div>
    <div class="dropdown-menu"  aria-labelledby="dropdown-destination-to">
        <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
        <ul class="st-scrollbar">
            <li class="location-heading"><span><?php echo esc_html__('Destinations', 'traveler'); ?></span></li>
            <?php
            if ( is_array( $data ) && count( $data ) ):
                foreach ( $data as $key => $value ):
                    ?>
                    <li class="item dropdown-item" data-value="<?php echo esc_attr( $value['value'] ); ?>">
                        <span class="stt-icon stt-icon-location1"></span>
                        <span><?php echo esc_attr( $value['label'] ); ?></span></li>
                <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>


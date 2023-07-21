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
        $lists     = TravelHelper::getListFullNameLocation( 'st_hotel' );
        $locations = TravelHelper::buildTreeHasSort( $lists );
    } else {
        $locations = TravelHelper::getListFullNameLocation( 'st_hotel' );
    }
    $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
    if(is_singular('location')){
        $location_id = get_the_ID();
    }
?>
<div class="form-group form-extra-field dropdown clearfix field-detination <?php if ( $has_icon ) echo 'has-icon' ?>">
    <?php
        if ( $has_icon ) {
            echo TravelHelper::getNewIcon('ico_maps_search_box');
        }
    ?>
    <div class="dropdown" data-toggle="dropdown" id="dropdown-destination">
    <label><?php echo __( 'Destination', 'traveler' ); ?></label>
        <div class="render">
            <input type="text" name="ss" value="" placeholder="e.g. city, region, district or specific hotel" />
        </div>
        
    </div>
    

</div>
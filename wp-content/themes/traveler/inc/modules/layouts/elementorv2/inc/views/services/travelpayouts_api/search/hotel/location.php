<?php
    wp_enqueue_style( 'st-select.css' );
    wp_enqueue_script( 'st-select.js' );
    $default=array(
        'title'=>'',
        'placeholder'=>__('City or hotel name', 'traveler'),
        'is_required'=>'',
    );
    if(isset($data)){
        extract(wp_parse_args($data,$default));
    }else{
        extract($default);
    }

    if($is_required == 'on'){
        $is_required = 'required';
    }

    if(!isset($field_size)) $field_size='lg';

    $locale_default = st()->get_option('tp_locale_default','en');


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
<div class="destination-search">
<div id="dropdown-destination" class="form-group form-group d-flex align-items-center form-extra-field dropdown field-detination   form-group-icon-left st_left" data-next="1">
        <?php
            echo '<span class="stt-icon stt-icon-location1"></span>';
        ?>
        <div class="st-form-dropdown-icon" >
            <div id="dropdown-destination">
                <label><?php echo __( 'Destination', 'traveler' ); ?></label>
                <div class="render">
                    <div class="st-select-wrapper tp-hotel-wrapper" >
                        <input <?php echo esc_attr($is_required); ?> id="location_destination_h" type="text" data-text="<?php echo esc_html__('hotel(s)', 'traveler'); ?>" data-locale="<?php echo esc_attr($locale_default); ?>" class="tp-hotel-destination" autocomplete="off" data-name="destination" value="" placeholder ="<?php echo __( 'City or hotel name', 'traveler' ); ?>" >
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
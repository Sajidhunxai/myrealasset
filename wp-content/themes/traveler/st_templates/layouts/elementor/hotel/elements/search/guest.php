<?php
    $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
    $room_num_search = STInput::get( 'room_num_search', 1 );
    $adult_number    = STInput::get( 'adult_number', 1 );
    $child_number    = STInput::get( 'child_number', 0 );
    $adult_max=st()->get_option('hotel_max_adult',14);
    $child_max=st()->get_option('hotel_max_child',14);
?>
<div class="field-guest form-group">
    <div class="form-extra-field dropdown dropdown-toggle <?php if ( $has_icon ) echo ' has-icon '; ?>" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <?php
            if ( $has_icon ) {
                echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
            }
        ?>
        <div class="st-form-dropdown-icon">
            <label><?php echo __( 'Guests', 'traveler' ); ?></label>
            <div class="render">
                <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>"
                    data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
                -
                <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                    data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
            </div>
        </div>
        <i class="fa fa-angle-down arrow"></i>
    </div>
    <ul class="dropdown-menu">
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__( 'Rooms', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="room_num_search" value="<?php echo esc_attr($room_num_search); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo esc_attr($adult_max);?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo esc_attr($adult_max);?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="<?php echo esc_attr($child_max);?>"/>
                </div>
            </div>
        </li>
    </ul>
    <?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/guest-name', '' ); ?>
</div>

<?php
    $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
    $room_num_search = STInput::get( 'room_num_search', 1 );
    $adult_number    = STInput::get( 'adult_number', 1 );
    $child_number    = STInput::get( 'child_number', 0 );
?>
<div class="form-group form-extra-field dropdown clearfix field-guest <?php if ( $has_icon ) echo ' has-icon '; ?>">
    <?php
        if ( $has_icon ) {
            echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
        }
    ?>
    <div class="dropdown" data-bs-toggle="dropdown">
        <label><?php echo __( 'Guests', 'traveler' ); ?></label>
        <div class="render">
            <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>"
                  data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
            -
            <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                  data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
        </div>
    </div>
    <ul class="dropdown-menu">
        <li class="item">
            <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="20"/>
                </div>
            </div>
        </li>
        <li class="item">
            <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper">
                    <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="20"/>
                </div>
            </div>
        </li>
        <span class="hidden-lg hidden-md hidden-sm btn-close-guest-form"><?php echo __('Close', 'traveler'); ?></span>
    </ul>
    <i class="fa fa-angle-down arrow"></i>
</div>
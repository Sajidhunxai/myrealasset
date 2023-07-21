<?php
    $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
    $room_num_search = STInput::get( 'room_num_search', 1 );
    $adult_number    = STInput::get( 'adult_number', 1 );
    $child_number    = STInput::get( 'child_number', 0 );
?>
<div class="d-inline-block d-lg-flex align-items-center  form-passengers-class  form-extra-field  clearfix" data-next="5">
    <div class="field-guest">
        <div class="form-extra-field dropdown clearfix dropdown dropdown-toggle" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <div class="d-lg-flex align-items-center" >
                
                <div class="st-form-dropdown-icon" >
                    <label><?php echo __( 'Guests', 'traveler' ); ?></label>
                    <div class="render">
                        <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>"
                            data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
                        -
                        <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                            data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <ul class="dropdown-menu">
            <li class="item">
                <label><?php echo esc_html__( 'Rooms', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="no_rooms" value="<?php echo esc_attr($room_num_search); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="100"/>
                    </div>
                </div>
            </li>
            <li class="item">
                <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="group_adults" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="100"/>
                    </div>
                </div>
            </li>
            <li class="item">
                <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="group_children" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    
</div>
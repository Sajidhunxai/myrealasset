<?php
$has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
$adult_number    = STInput::get( 'adult_number', 1 );
$child_number    = STInput::get( 'child_number', 0 );
$class_hide_render = 'hide';
if($adult_number > 1 || !empty($child_number)){
    $class_hide_render = '';
}
?>
<div class="form-group form-extra-field dropdown clearfix field-guest-new  <?php if ( $has_icon ) echo ' has-icon '; ?>">
    <?php
    if ( $has_icon ) {
        echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
    }
    ?>
    <div class="dropdown " data-toggle="dropdown">
        <label class="<?php echo ($class_hide_render == 'hide') ? '' : 'hide' ?>"><?php echo esc_html__( 'Guests', 'traveler' ); ?></label>
        <div class="render <?php echo esc_attr($class_hide_render); ?>">
            <span class="adult" data-text="<?php echo esc_html__( 'Adult', 'traveler' ); ?>"
                  data-text-multi="<?php echo esc_html__( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
            -
            <span class="children" data-text="<?php echo esc_html__( 'Child', 'traveler' ); ?>"
                  data-text-multi="<?php echo esc_html__( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
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

    </ul>

</div>
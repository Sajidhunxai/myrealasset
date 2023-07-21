<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
wp_enqueue_style( 'st-select.css' );
wp_enqueue_script( 'st-select.js' );

$locale_default = st()->get_option('tp_locale_default','en');

?>
<div class="form-group form-group-lg form-group-icon-left st_right" data-next="2">
    <label for="location_destination"><?php echo esc_html__('Destination', 'traveler'); ?></label>
    <div class="st-select-wrapper tp-flight-wrapper" >
        <input required data-id="location_destination" type="text" data-locale="<?php echo esc_attr($locale_default); ?>" class="tp-flight-location st-location-name" autocomplete="off" data-name="destination_iata" value="" placeholder="<?php echo esc_html__('Enter your destination', 'traveler'); ?>">
    </div>
</div>
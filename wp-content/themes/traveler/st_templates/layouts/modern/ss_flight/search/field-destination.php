<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
wp_enqueue_style( 'st-select.css' );
wp_enqueue_script( 'st-select.js' );
?>
<div class="form-group form-group-lg form-group-icon-left st_right">
    <label for="ss_location_destination"><?php echo esc_html__('Destination', 'traveler'); ?></label>
    <div class="st-select-wrapper ss-flight-wrapper" >
        <input required id="ss_location_destination" type="text" class="ss-flight-location required" autocomplete="off" data-value="" data-name="ss_destination" value="" placeholder="<?php echo esc_html__('Enter your destination', 'traveler'); ?>" data-index="2">
    </div>
</div>
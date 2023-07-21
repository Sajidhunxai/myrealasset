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
<div class="form-group form-group-lg form-group-icon-left st_left">
    <label for="ss_location_origin"><?php echo esc_html__('Origin', 'traveler'); ?></label>
    <div class="st-select-wrapper ss-flight-wrapper" >
        <input required id="ss_location_origin" type="text" class="ss-flight-location required" autocomplete="off" data-value="" data-name="ss_origin" value="" placeholder="<?php echo esc_html__('Enter your origin', 'traveler'); ?>" data-index="1">
    </div>
</div>
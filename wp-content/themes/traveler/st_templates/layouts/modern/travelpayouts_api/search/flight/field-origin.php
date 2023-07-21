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
<div class="form-group form-group-lg form-group-icon-left st_left" data-next="1">
    <label for="location_origin"><?php echo esc_html__('Origin', 'traveler'); ?></label>
    <div class="st-select-wrapper tp-flight-wrapper" >
        <input required data-id="location_origin" type="text" data-locale="<?php echo esc_attr($locale_default); ?>" class="tp-flight-location st-location-name" autocomplete="off" data-name="origin_iata" value="" placeholder="<?php echo esc_html__('Enter your origin', 'traveler'); ?>">
    </div>
</div>
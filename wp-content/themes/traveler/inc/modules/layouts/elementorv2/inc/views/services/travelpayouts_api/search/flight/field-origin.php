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
<div class="destination-search">
    <div id="dropdown-destination" class="form-group form-group d-flex align-items-center form-extra-field dropdown field-detination   form-group-icon-left st_left" data-next="1">
        <?php
            echo '<span class="stt-icon stt-icon-location1"></span>';
        ?>
        <div class="st-form-dropdown-icon" >
            <label><?php echo __( 'Origin', 'traveler' ); ?></label>
            <div class="render">
                <?php
                    if(empty($location_name)) {
                        $placeholder = __('Where are you going?', 'traveler');
                    }else{
                        $placeholder = esc_html($location_name);
                    }
                ?>
                <div class="st-select-wrapper tp-flight-wrapper" >
                    <input required data-id="location_origin" type="text" data-locale="<?php echo esc_attr($locale_default); ?>" class="tp-flight-location st-location-name" autocomplete="off" data-name="origin_iata" value="" placeholder="<?php echo esc_html__('Enter your origin', 'traveler'); ?>">
                </div>
            </div>
        </div>
        
    </div>
</div>
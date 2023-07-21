<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
$adult_number    = STInput::get( 'adult_number', 1 );
$child_number    = STInput::get( 'child_number', 0 );
$use_whitelabel = st()->get_option('tp_redirect_option', 'off');
if($use_whitelabel == 'on'){
    $button_class = 'btn-tp-search-flights';

}
?>

<div class="d-block d-md-block d-lg-flex align-items-center justify-content-between form-passengers-class" data-next="5">
    <div class="field-guest">
        <div class=" form-extra-field dropdown dropdown-toggle" id="dropdown-advance" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
			<span class="stt-icon stt-icon-user2"></span>
			<div class="st-form-dropdown-icon">
                <label><?php echo esc_html__('Passengers/Class', 'traveler'); ?></label>
                <div class="tp_group_display render">
                    <span class="display-passengers"><span class="quantity-passengers">1</span> <?php echo esc_html__('passenger(s)', 'traveler')?></span>
                    <span class="display-class" data-economy="<?php echo esc_html__('economy class', 'traveler'); ?>" data-business="<?php echo esc_html__('business class', 'traveler'); ?>"><?php echo esc_html__('economy class', 'traveler'); ?></span>
                </div>
            </div>
        </div>
        <ul class="dropdown-menu passengers-class" aria-labelledby="dropdown-advance">
            <li class="item">
                <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="adults" value="<?php echo esc_attr($adult_number); ?>" class="twidget-num form-control  st-input-number" autocomplete="off" readonly data-min="1" data-max="100"/>
                    </div>
                </div>
            </li>
            <li class="item">
                <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="children" value="<?php echo esc_attr($child_number); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
                    </div>
                </div>
            </li>
            <li class="item">
                <label><?php echo esc_html__( 'Infants', 'traveler' ) ?></label>
                <div class="select-wrapper">
                    <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                        <input type="text" name="infants" value="<?php echo esc_attr($child_number); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
                    </div>
                </div>
            </li>
            <li class="item item-business">
                <span class="notice none">
                    <?php echo esc_html__('Maxium 9 passengers', 'traveler'); ?>
                </span>
                <span class="d-lg-none d-md-none d-sm-none btn-close-guest-form"><?php echo __('Close', 'traveler'); ?></span>
                <hr>
                <?php wp_enqueue_script('icheck-frontent.js');?>
                <script type="text/javascript">
                jQuery(function($){
                    $('.i-radio, .i-check').iCheck({
                        checkboxClass: 'i-check',
                        radioClass: 'i-radio'
                    });
                });

                </script>
                <div class="tp-checkbox-class">
                    <label><input class="i-check checkbox-class" type="checkbox" value="1" /> <?php echo esc_html__('Business class', 'traveler');?></label>
                    <input type="hidden" name="trip_class" value="0">
                    <span class="checkmark"></span>
                </div>
            </li>
        </ul>
    </div>

    <div class="button-search-wrapper">
        <button class="btn btn-primary btn-search btn-bookingdc-search-hotels <?php echo esc_attr($button_class); ?>">
            <span class="stt-icon stt-icon-search-normal"></span>
            <?php echo esc_html__('Search', 'traveler'); ?>
        </button>
    </div>

</div>
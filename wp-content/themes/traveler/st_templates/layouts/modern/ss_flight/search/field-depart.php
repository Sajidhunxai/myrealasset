<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
?>

<div data-tp-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" class="form-group input-daterange  form-group-lg form-group-icon-left st_left">
    <label for="field-depart-date"><?php echo esc_html__('Depart', 'traveler'); ?></label>
    <input  placeholder="<?php echo esc_attr(TravelHelper::getDateFormatJs()); ?>" class="tp_depart_date required" readonly value="" type="text" />
    <input type="hidden" class="tp-date-from ss_depart" value="">
</div>

<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
?>

<div data-tp-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" class="form-group input-daterange input-daterange-return form-group-lg form-group-icon-left"  data-next="4">
    <label for="field-return-date"><?php echo esc_html__('Return date', 'traveler'); ?></label>
    <input  placeholder="<?php echo esc_attr(TravelHelper::getDateFormatJs()); ?>" readonly class="tp_return_date required" value="" type="text"/>
    <input type="hidden" name="return_date" class="tp-date-to" value="">
</div>

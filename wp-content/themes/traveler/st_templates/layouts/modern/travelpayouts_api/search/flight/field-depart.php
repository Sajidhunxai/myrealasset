<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
?>

<div data-tp-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" class="form-group input-daterange  form-group-lg form-group-icon-left" data-next="3">
    <label for="field-depart-date"><?php echo esc_html__('Depart date', 'traveler'); ?></label>
    <input required placeholder="<?php echo esc_attr(TravelHelper::getDateFormatJs()); ?>" class="tp_depart_date required" readonly value="" type="text"/>
    <input type="hidden" name="depart_date" class="tp-date-from" value="">
</div>

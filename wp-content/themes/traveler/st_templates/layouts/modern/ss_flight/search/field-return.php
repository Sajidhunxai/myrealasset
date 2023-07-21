<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
?>

<div data-tp-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" class="form-group input-daterange input-daterange-return form-group-lg form-group-icon-left st_right">
    <label for="field-return-date"><?php echo esc_html__('Return', 'traveler'); ?></label>
    <input  placeholder="<?php echo esc_attr(TravelHelper::getDateFormatJs()); ?>" readonly class="tp_return_date required" value="" type="text" />
    <input type="hidden" class="tp-date-to ss_return" value="">
    <!--<span class="fa fa-question-circle tp-return-note">
        <span class="return-data-tooltip none">
            <?php /*echo esc_html__('Return date empty for search one-way flights', 'traveler');*/?>
        </span>
    </span>-->
</div>

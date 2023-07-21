<?php global $post; ?>

<?php

    $currency_default = '$';

    $currency_arr = TravelHelper::get_default_currency();

    if(isset($currency_arr) && !empty($currency_arr)){

        if(isset($currency_arr['symbol']))

            $currency_default = $currency_arr['symbol'];

    }

?>

<div class="row calendar-wrapper" data-post-id="<?php echo esc_attr($post->ID) ?>">

    <div class="col-xs-12 col-lg-4">

        <div class="calendar-form">

            <div class="form-group">

                <label for="calendar_check_in"><strong><?php echo __('Check In', 'traveler'); ?></strong></label>

                <input readonly="readonly" type="text" class="widefat option-tree-ui-input date-picker" name="calendar_check_in" id="calendar_check_in" placeholder="<?php echo __('Check In', 'traveler'); ?>">

            </div> 

            <div class="form-group">

                <label for="calendar_check_out"><strong><?php echo __('Check Out', 'traveler'); ?></strong></label>

                <input readonly="readonly" type="text" class="widefat option-tree-ui-input date-picker" name="calendar_check_out" id="calendar_check_out" placeholder="<?php echo __('Check Out', 'traveler'); ?>">

            </div>

            <div class="form-group">

                <label for="calendar_price"><strong><?php echo __('Economy Price ('. $currency_default .')', 'traveler'); ?></strong></label>

                <input type="text" name="calendar_price[economy]" id="calendar_price_eco" class="form-control" placeholder="<?php echo __('Economy Price', 'traveler'); ?>">

            </div>

            <div class="form-group">

                <label for="calendar_price"><strong><?php echo __('Business Price ('. $currency_default .')', 'traveler'); ?></strong></label>

                <input type="text" name="calendar_price[business]" id="calendar_price_bus" class="form-control" placeholder="<?php echo __('Business Price', 'traveler'); ?>">

            </div>

            <div class="form-group">

                <label for="calendar_status"><?php echo __('Status', 'traveler'); ?></label>

                <select name="calendar_status" id="calendar_status">

                    <option value="available"><?php echo __('Available', 'traveler'); ?></option>

                    <option value="unavailable"><?php echo __('Unavailble', 'traveler'); ?></option>

                </select>

            </div>

            <div class="form-group">

                <div class="form-message">

                    <p></p>

                </div>

            </div>

            <div class="form-group" style="overflow: hidden">

                <input type="hidden" name="calendar_post_id" value="<?php echo esc_attr($post->ID); ?>">

                <input type="submit" id="calendar_submit" class="option-tree-ui-button button button-primary" name="calendar_submit" value="<?php echo __('Update', 'traveler'); ?>">

                <?php do_action('traveler_after_form_submit_flight_calendar'); ?>

            </div>

        </div>

        <p style="margin-top: 50px;"><i class="fa fa-info-circle"></i> <i><?php echo __('You can select and drag dates in the calendar to select check in and check out date', 'traveler'); ?></i></p>

    </div>

    <div class="col-xs-12 col-lg-8">

        <div class="calendar-content">

            

        </div>

        <div class="overlay">

            <span class="spinner is-active"></span>

        </div>

    </div>

    <?php do_action('traveler_after_form_flight_calendar'); ?>

</div>
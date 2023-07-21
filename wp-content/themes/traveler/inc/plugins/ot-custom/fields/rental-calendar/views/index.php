<?php

global $post;

$post_origin = TravelHelper::post_origin($post->ID, 'st_rental');

?>



<div class="row calendar-wrapper" data-post-id="<?php echo esc_attr($post_origin); ?>">

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

                <label for="calendar_price"><strong><?php echo __('Price ($)', 'traveler'); ?></strong></label>

                <input type="text" name="calendar_price" id="calendar_price" class="form-control" placeholder="<?php echo __('Price', 'traveler'); ?>">

            </div>

            <div class="form-group">

                <label for="calendar_status"><?php echo __('Status', 'traveler'); ?></label>

                <select name="calendar_status" id="calendar_status">

                    <option value="available"><?php echo __('Available', 'traveler'); ?></option>

                    <option value="unavailable"><?php echo __('Unavailble', 'traveler'); ?></option>

                </select>

            </div>



            <div class="form-group is_groupday" style="display: block;">

                <input type="checkbox" name="calendar_groupday" id="calendar_groupday" value="1"><span class="ml5"><?php echo __('Group day', 'traveler'); ?></span>

                <input type="hidden" value="yes" name="is_groupday" />

            </div>



            <div class="form-group">

                <div class="form-message">

                    <p></p>

                </div>

            </div>

            <div class="form-group" style="overflow: hidden">

                <input type="hidden" name="calendar_post_id" value="<?php echo esc_attr($post_origin); ?>">

                <input type="submit" id="calendar_submit" class="option-tree-ui-button button button-primary" name="calendar_submit" value="<?php echo __('Update', 'traveler'); ?>">

                <?php do_action('traveler_after_form_submit_rental_calendar'); ?>

            </div>

        </div>

        <p style="margin-top: 50px;"><i class="fa fa-info-circle"></i> <i><?php echo __('You can select and drag dates in the calendar to select check in and check out date', 'traveler'); ?></i></p>

    </div>

    <div class="col-xs-12 col-lg-8">

        <div class="calendar-content" id="calendar">



        </div>

        <div class="overlay">

            <span class="spinner is-active"></span>

        </div>

    </div>

    <?php do_action('traveler_after_form_rental_calendar'); ?>

</div>

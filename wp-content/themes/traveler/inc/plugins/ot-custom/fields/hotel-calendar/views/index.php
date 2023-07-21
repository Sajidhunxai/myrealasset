<?php global $post; ?>



<div class="row calendar-wrapper" data-post-id="<?php echo esc_attr($post->ID); ?>">

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

            <div class="form-group<?php echo (get_post_meta( $post->ID, 'price_by_per_person', true ) == 'on') ? ' hide' : '' ?>">

                <label for="calendar_price"><strong><?php echo __('Price ($)', 'traveler'); ?></strong></label>

                <input type="text" name="calendar_price" id="calendar_price" class="form-control" placeholder="<?php echo __('Price', 'traveler'); ?>">

            </div>

            <div class="row form-group<?php echo (get_post_meta( $post->ID, 'price_by_per_person', true ) != 'on') ? ' hide' : '' ?>">

                <div class="col-xs-6">

                    <label for="calendar_adult_price"><strong><?php echo __('Adult Price ($)', 'traveler'); ?></strong></label>

                    <input type="text" name="calendar_adult_price" id="calendar_adult_price" class="form-control" placeholder="<?php echo __('Adult Price', 'traveler'); ?>">

                </div>

                <div class="col-xs-6">

                    <label for="calendar_child_price"><strong><?php echo __('Child Price ($)', 'traveler'); ?></strong></label>

                    <input type="text" name="calendar_child_price" id="calendar_child_price" class="form-control" placeholder="<?php echo __('Child Price', 'traveler'); ?>">

                </div>

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

                <?php do_action('traveler_after_form_submit_hotel_calendar'); ?>

            </div>

        </div>

        <p style="margin-top: 50px;"><i class="fa fa-info-circle"></i> <i><?php echo __('You can select and drag dates in the calendar to select check in and check out date', 'traveler'); ?></i></p>

    </div>

    <div class="col-xs-12 col-lg-8">

        <div class="calendar-content" data-price-by-per-person="<?php echo esc_attr( get_post_meta( $post->ID, 'price_by_per_person', true ) == 'on' ? 'on' : 'off') ?>">



        </div>

        <div class="overlay">

            <span class="spinner is-active"></span>

        </div>

    </div>

    <?php do_action('traveler_after_form_hotel_calendar'); ?>

</div>


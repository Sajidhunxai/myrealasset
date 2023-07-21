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
            <?php do_action('st_after_day_tour_calendar'); ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label><strong><?php echo __('Price ($)', 'traveler'); ?></strong></label>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4 hide">
                    <div class="form-group">
                        <label for="calendar_base_price"><?php echo __('Price', 'traveler'); ?></label>
                        <input type="text" name="calendar_base_price" id="calendar_base_price" class="form-control" placeholder="<?php echo __('Base price', 'traveler'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4 <?php if(get_post_meta($post_id,'hide_adult_in_booking_form',true) == 'on') echo 'hide' ?>">
                    <div class="form-group">
                        <label for="calendar_adult_price"><?php echo __('Adult', 'traveler'); ?></label>
                        <input type="text" name="calendar_adult_price" id="calendar_adult_price" class="form-control" placeholder="<?php echo __('Price of adult', 'traveler'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4 <?php if(get_post_meta($post_id,'hide_children_in_booking_form',true) == 'on') echo 'hide' ?>">
                    <div class="form-group">
                        <label for="calendar_child_price"><?php echo __('Children', 'traveler'); ?></label>
                        <input type="text" name="calendar_child_price" id="calendar_child_price" class="form-control" placeholder="<?php echo __('Price of children', 'traveler'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4 <?php if(get_post_meta($post_id,'hide_infant_in_booking_form',true) == 'on') echo 'hide' ?>">
                    <div class="form-group">
                        <label for="calendar_infant_price"><?php echo __('Infant', 'traveler'); ?></label>
                        <input type="text" name="calendar_infant_price" id="calendar_infant_price" class="form-control" placeholder="<?php echo __('Price of infant', 'traveler'); ?>">
                    </div>
                </div>
            </div>
            <!-- StartTime -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label><strong><?php echo __('StartTime', 'traveler'); ?></strong></label>
                    </div>
                    <div class="form-group">
                        <div class="calendar-starttime-wraper starttime-origin">
                            <select class="calendar_starttime_hour" name="">
						        <?php
                                $time_format = st()->get_option('time_format', '24h');
                                if($time_format == '24h'){
                                    for ( $i = 0; $i < 24; $i ++ ) {
                                        echo '<option value="' . (($i < 10) ? ('0' . $i) : $i) . '">' . (($i < 10) ? ('0' . $i) : $i) . '</option>';
                                    }
                                }else{
                                    for ( $i = 1; $i < 13; $i ++ ) {
                                        echo '<option value="' . (($i < 10) ? ('0' . $i) : $i) . '">' . (($i < 10) ? ('0' . $i) : $i) . '</option>';
                                    }
                                }
						        ?>
                            </select>
                            <span dir="rtl"><i><?php echo __( 'hour', 'traveler' ); ?></i></span>
                            <select class="calendar_starttime_minute" name="">
						        <?php
						        for ( $i = 0; $i < 60; $i ++ ) {
							        echo '<option value="' . (($i < 10) ? ('0' . $i) : $i) . '">' . (($i < 10) ? ('0' . $i) : $i) . '</option>';
						        }
						        ?>
                            </select>
                            <span dir="rtl"><i><?php echo __( 'minute', 'traveler' ); ?></i></span>
                            <?php if($time_format == '12h'){ ?>
                                <select class="calendar_starttime_format" name="">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            <?php } ?>
                            <div class="calendar-remove-starttime" data-time-format="<?php echo esc_attr($time_format); ?>"><span class="dashicons dashicons-no-alt"></span></div>
                        </div>
                        <div id="calendar-add-starttime" class="calendar-add-starttime" data-time-format="<?php echo esc_attr($time_format); ?>"><span class="dashicons dashicons-plus"></span></div>
                    </div>
                </div>
            </div>
            <!-- StartTime -->
            <input type="hidden" name="calendar_price_type" id="calendar_price_type" value="<?php echo STTour::get_price_type($post->ID); ?>"/>
            <div class="form-group">
                <label for="calendar_status"><?php echo __('Status', 'traveler'); ?></label>
                <select name="calendar_status" id="calendar_status">
                    <option value="available"><?php echo __('Available', 'traveler'); ?></option>
                    <option value="unavailable"><?php echo __('Unavailble', 'traveler'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <input type="checkbox" name="calendar_groupday" id="calendar_groupday" value="1"><span class="ml5"><?php echo __('Group day', 'traveler'); ?></span>
            </div>
            <div class="form-group">
                <div class="form-message">
                    <p></p>
                </div>
            </div>
            <div class="form-group" style="overflow: hidden">
                <input type="hidden" name="calendar_post_id" value="<?php echo esc_attr($post->ID); ?>">
                <input type="submit" id="calendar_submit" class="option-tree-ui-button button button-primary" name="calendar_submit" value="<?php echo __('Update', 'traveler'); ?>">
                <?php do_action('traveler_after_form_submit_tour_calendar'); ?>
            </div>
        </div>
        <p style="margin-top: 50px;"><i class="fa fa-info-circle"></i> <i><?php echo __('You can select and drag dates in the calendar to select check in and check out date', 'traveler'); ?></i></p>
    </div>
    <div class="col-xs-12 col-lg-8">
        <div class="calendar-content"
             data-hide_adult="<?php echo get_post_meta($post->ID,'hide_adult_in_booking_form',true) ?>"
             data-hide_children="<?php echo get_post_meta($post->ID,'hide_children_in_booking_form',true) ?>"
             data-hide_infant="<?php echo get_post_meta($post->ID,'hide_infant_in_booking_form',true) ?>"
            >
        </div>
        <div class="overlay">
            <span class="spinner is-active"></span>
        </div>
    </div>
        <?php do_action('traveler_after_form_tour_calendar'); ?>
</div>

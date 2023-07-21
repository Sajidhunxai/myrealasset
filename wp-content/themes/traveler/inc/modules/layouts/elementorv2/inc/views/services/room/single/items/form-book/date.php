<div class="form-group form-date-field date-enquire form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
     data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
    <?php
    if ( $has_icon ) {
        echo '<i class="field-icon fa fa-calendar"></i>';
    }
    ?>
    <div class="date-wrapper clearfix">
        <div class="check-in-wrapper">
            <ul class="st_grid_date">
                <li>
                    <div class="st-item-date">
                        <label><?php echo __('Check In', 'traveler'); ?></label>
                        <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                    </div>
                </li>
                <li>
                    <div class="st-item-date">
                        <label><?php echo __('Check Out', 'traveler'); ?></label>
                        </span><div class="render check-out-render"><?php echo esc_html($end); ?></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <input type="hidden" class="check-in-input"
           value="<?php echo esc_attr( $start ) ?>" name="check_in">
    <input type="hidden" class="check-out-input"
           value="<?php echo esc_attr( $end ) ?>" name="check_out">
    <input type="text" class="check-in-out"
           data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
           data-room-id="<?php echo esc_attr($room_id) ?>"
           data-action="st_get_availability_hotel_room"
           value="<?php echo esc_attr( $date ); ?>" name="date">
</div>
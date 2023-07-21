<?php 
$current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
$current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

$start    = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
$end      = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
$date     = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
?>
<div class="form-group form-date-field date-enquire form-date-hotel-room clearfix"
     data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
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
            value="<?php echo esc_attr( $start ) ?>" name="start">
    <input type="hidden" class="check-out-input"
            value="<?php echo esc_attr( $end ) ?>" name="end">
    <input type="text" class="check-in-out"
            data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
            data-room-id="<?php echo esc_attr($room_id) ?>"
            data-action="st_get_availability_rental_single"
            value="<?php echo esc_attr( $date ); ?>" name="date">
</div>
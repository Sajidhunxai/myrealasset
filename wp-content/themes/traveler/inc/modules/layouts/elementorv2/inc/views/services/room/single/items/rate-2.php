<div class="room-rates">
    <h2 class="st-heading-section">
        <?php echo esc_html__('Rates & availability', 'traveler'); ?>
    </h2>
    <div class="rate-calendar style-2">
        <?php
        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
        $date           = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar) ) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar) ) ) );
        $booking_period = intval( get_post_meta( $hotel_id, 'hotel_booking_period', true ) );
        ?>
        <input type="text" class="st-room-availability-input"
               data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
               data-room-id="<?php echo esc_attr($room_id) ?>"
               data-action="st_get_availability_hotel_room"
               value="<?php echo esc_attr( $date ); ?>" name="date">
    </div>
</div>
<div class="st-flex space-between">
    <h2 class="st-heading-section"><?php echo __( 'Rates & availability', 'traveler' ) ?></h2>
</div>
<div class="rate-calendar style-1">
    <div class="st-calendar  clearfix">
        <input type="text" class="calendar_input"
            data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
            data-room-id="<?php echo esc_attr($room_id) ?>"
            data-action="st_get_availability_rental_single"
            value="" name="calendar_input">
    </div>
</div>
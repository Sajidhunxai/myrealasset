<div class="st-flex space-between">
    <h2 class="st-heading-section"><?php echo __( 'Availability', 'traveler' ) ?></h2>
    <ul class="st-list st-list-availability d-flex align-items-center">
        <li>
            <span class="not_available"></span><?php echo esc_html__( 'Not Available', 'traveler' ) ?>
        </li>
        <li>
            <span class="available"></span><?php echo esc_html__( 'Available', 'traveler' ) ?>
        </li>
    </ul>
</div>
<div class="st-house-availability st-availability">
    <div class="st-calendar clearfix">
        <input type="text" class="calendar_input"
                data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                data-room-id="<?php echo esc_attr($room_id) ?>"
                data-action="st_get_availability_rental_single"
                value="" name="calendar_input">
    </div>
</div>
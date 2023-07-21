<div class="form-book-wrapper st-border-radius">
    <?php echo st()->load_template( 'layouts/elementor/common/loader' ); ?>
    <div class="form-head">
        <?php
        if (isset($number_day) && $number_day > 1)
            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per %s nights', 'traveler' ), TravelHelper::format_money($price), $number_day ), [ 'span' => [ 'class' => [] ] ] );
        else
            echo wp_kses( sprintf( __( 'from <span class="price">%s</span> per night', 'traveler' ), TravelHelper::format_money($price) ), [ 'span' => [ 'class' => [] ] ] );
        ?>
    </div>
    <?php 
    $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
    if(empty($room_external) || $room_external == 'off'){ ?>
        <form id="form-booking-inpage" class="form single-room-form form-has-guest-name rental-booking-form" method="post">
            <input name="action" value="rental_add_cart" type="hidden">
            <input name="item_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
            <?php
            $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
            $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

            $start    = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
            $end      = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
            $date     = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
            
            ?>
            <div class="form-group form-date-field form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                    data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                <?php
                if ( $has_icon ) {
                    echo '<i class="field-icon fa fa-calendar"></i>';
                }
                ?>
                <div class="date-wrapper clearfix">
                    <div class="check-in-wrapper">
                        <label><?php echo __( 'Check In - Out', 'traveler' ); ?></label>
                        <div class="render check-in-render"><?php echo esc_attr($start); ?></div> - <div class="render check-out-render"><?php echo esc_html($end); ?></div>
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
            <div class="form-date-search">
                <?php echo st()->load_template( 'layouts/elementor/rental/elements/search/single-guest', '' ); ?>
            </div>
            

            <?php echo st()->load_template( 'layouts/elementor/rental/elements/search/extra', '' ); ?>
            <div class="submit-group">
                <button class="btn btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                        type="submit"
                        name="submit">
                    <?php echo __( 'Book Now', 'traveler' ) ?>
                    <i class="fa fa-spinner fa-spin d-none"></i>
                </button>
                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
            </div>
            <div class="mt30 message-wrapper">
                <?php echo STTemplate::message() ?>
            </div>
        </form>
    <?php }else{ ?>
        <div class="submit-group mb30">
            <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
            <form id="form-booking-inpage" class="form single-room-form rental-booking-form" method="post">
                <input name="action" value="rental_add_cart" type="hidden">
                <input name="item_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                <?php
                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                $start    = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                $end      = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                $date     = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );

                ?>
                <div class="form-group st-external form-date-field form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                        data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">

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
                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
            </form>
        </div>
    <?php } ?>
</div>
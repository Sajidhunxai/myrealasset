<div class="form-book-wrapper st-border-radius">
    <?php echo st()->load_template( 'layouts/elementor/common/loader' ); ?>
    <div class="form-head">
        <?php
        if ( $price_by_per_person == 'on' ) :
            echo __('from ', 'traveler');
            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
            echo '<span class="unit">';
            echo sprintf( _n( '/person', '/%d persons', $total_person, 'traveler' ), $total_person );
            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
            echo '</span>';
        else:
            echo __('from ', 'traveler');
            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
            echo '<span class="unit">';
            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
            echo '</span>';
        endif; ?>
    </div>
    <?php if(empty($room_external) || $room_external == 'off'){ ?>
        <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form" method="post">
            <input name="action" value="hotel_add_to_cart" type="hidden">
            <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
            <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
            <?php
            $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
            $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

            $start          = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
            $end            = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
            $date           = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar) ) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar) ) ) );
            $has_icon       = ( isset( $has_icon ) ) ? $has_icon : false;
            $booking_period = intval( get_post_meta( $hotel_id, 'hotel_booking_period', true ) );
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
                        value="<?php echo esc_attr( $start ) ?>" name="check_in">
                <input type="hidden" class="check-out-input"
                        value="<?php echo esc_attr( $end ) ?>" name="check_out">
                <input type="text" class="check-in-out"
                        data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                        data-room-id="<?php echo esc_attr($room_id) ?>"
                        data-action="st_get_availability_hotel_room"
                        value="<?php echo esc_attr( $date ); ?>" name="date">
            </div>
            <?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/guest', '' ); ?>
            
            <?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/extra', '' ); ?>
            <div class="submit-group">
                <button class="btn btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                        type="submit"
                        name="submit" >
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
            <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form" method="post">
                <input name="action" value="hotel_add_to_cart" type="hidden">
                <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
            </form>
        </div>
    <?php } ?>
</div>
<div class="book-v2">
    <div class="form-book-wrapper st-border-radius">
        <?php echo st()->load_template( 'layouts/elementor/common/loader' ); ?>
        <?php if(empty($room_external) || $room_external == 'off'){ ?>
            <form id="single-room-form" class="form single-room-form hotel-room-booking-form" method="post">
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
                <?php echo stt_elementorv2()->loadView('services/room/single/items/form-book/date', [
                    'has_icon' => $has_icon,
                    'current_calendar_reverb' => $current_calendar_reverb,
                    'start' => $start,
                    'end' => $end,
                    'booking_period' => $booking_period,
                    'room_id' => $room_id,
                    'date' => $date
                ]) ?>
                <?php echo stt_elementorv2()->loadView('services/room/single/items/form-book/guest') ?>
                <?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/extra', '' ); ?>
                <div id="st-price-render" class="st-price-render">
                    <div class="item">
                        <span class="number-night"></span>
                        <span class="sale-price"></span>
                    </div>
                    <div class="item total">
                        <span class="total-label"><?php echo esc_html__('Total', 'traveler') ?></span>
                        <span class="total-price"></span>
                    </div>
                </div>
                <div class="submit-group">
                    <button class="btn btn-green btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                            type="submit"
                            name="submit" >
                        <?php echo __( 'Reserve', 'traveler' ) ?>
                        <i class="fa fa-spinner fa-spin d-none"></i>
                    </button>
                    <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                </div>
                <div class="mt30 message-wrapper">
                    <?php echo STTemplate::message() ?>
                </div>
            </form>
        <?php }else{ ?>
            <div class="submit-group button-external-link mb30">
                <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
            </div>
        <?php } ?>
    </div>
</div>
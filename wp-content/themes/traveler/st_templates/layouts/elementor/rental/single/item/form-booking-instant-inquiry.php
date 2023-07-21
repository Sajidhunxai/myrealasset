<div class="form-book-wrapper">
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
        <nav>
            <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                <li><a  class="active"  id="nav-book-tab" data-bs-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
                <li><a id="nav-inquirement-tab" data-bs-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
            </ul>
        </nav>
        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
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
                    $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
                    ?>
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
                                value="<?php echo esc_attr( $start ) ?>" name="start">
                        <input type="hidden" class="check-out-input"
                                value="<?php echo esc_attr( $end ) ?>" name="end">
                        <input type="text" class="check-in-out"
                                data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                data-room-id="<?php echo esc_attr($room_id) ?>"
                                data-action="st_get_availability_rental_single"
                                value="<?php echo esc_attr( $date ); ?>" name="date">
                    </div>
                    <?php
                    $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
                    $adult_number    = STInput::get( 'adult_number', 1 );
                    $child_number    = STInput::get( 'child_number', 0 );
                    ?>
                    <div class="form-date-search">
                        <?php echo st()->load_template( 'layouts/elementor/rental/elements/search/guest', '' ); ?>
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
            </div>
            <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
                <?php echo st()->load_template( 'email/email_single_service' ); ?>
            </div>
        </div>
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
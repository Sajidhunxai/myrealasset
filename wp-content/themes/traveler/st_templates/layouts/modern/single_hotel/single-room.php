<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 11:19 AM
 */
get_header('hotel-activity'); 
    $booking_type = st_get_booking_option_type();
    ?>
    <?php
    if ( isset( $style ) && $style == 3 ) : ?>
        <div class="st-single-hotel-modern-page sts-single-room-alone style-3">
            <?php echo st()->load_template( 'layouts/modern/single_hotel/elements/banner', '', array( 'is_room_alone' => true, 'style' => $style ) ); ?>

            <?php
            while (have_posts()) {
                the_post();
                $hotel_id = get_post_meta(get_the_ID(), 'room_parent', true);
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-lg-push-9 col-md-push-8">
                            <?php if($booking_type == 'instant_enquire'){
                                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
                                $start           = STInput::get( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                $end             = STInput::get( 'check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                $price = get_post_meta(get_the_ID(), 'price', true);
                                $room_num_search = STInput::request( 'room_num_search', '' );
                                $adult_number = STInput::request( 'adult_num_search', '' );
                                $child_number = STInput::request( 'children_num_search', '' );
                                $start       = TravelHelper::convertDateFormat( $start );
                                $end         = TravelHelper::convertDateFormat( $end );
                                $sale_price  = STPrice::getRoomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_day = STDate::dateDiff(date('Y-m-d', strtotime( $start )), date('Y-m-d', strtotime( $end )));
                                $price = $price * $total_day;
                                if(intval($total_day) > 1){
                                    $text_pernight = $total_day;
                                } else {
                                    $text_pernight = '';
                                }
                                $price_by_per_person = get_post_meta( get_the_ID(), 'price_by_per_person', true );?>
                                <div class="price-wrapper">
                                    <?php
                                    if ( $price_by_per_person == 'on' ): ?>
                                        <?php echo sprintf(__('FROM %s /PERSON /NIGHT', 'traveler'), '<span>'. TravelHelper::format_money($sale_price) .'</span>'); ?>
                                        <?php
                                    else: ?>
                                        <?php echo sprintf(__('FROM %s PER %s NIGHT', 'traveler'), '<span>'. TravelHelper::format_money($price) .'</span>', $text_pernight); ?>
                                        <?php
                                    endif; ?>
                                </div>
                                <nav class="st-sht-tab">
                                    <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                                        <li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
                                        <li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
                                    </ul>
                                </nav>
                                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                    <div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
                                        <div class="sts-booking-form">
                                            <div class="loader-wrapper">
                                                <div class="st-loader"></div>
                                            </div>
                                            <form class="" action="" method="POST">
                                                <div class="item checkin-out people" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                    <div class="date-wrapper">
                                                        <div class="title">
                                                            <span><?php echo __('Check In-Out', 'traveler'); ?></span>
                                                            <?php //echo TravelHelper::getNewIcon('calendar-disable', '#1A2B48', '23px', '23px', true) ?>
                                                        </div>
                                                        <span class="value"><?php echo esc_html($start . ' - ' . $end); ?></span>
                                                    </div>
                                                    <input type="hidden" class="check-in-input" value="<?php echo esc_attr( $start ) ?>" name="check_in">
                                                    <input type="hidden" class="check-out-input" value="<?php echo esc_attr( $end ) ?>" name="check_out">
                                                    <input type="text" class="sts-checkin-out"
                                                           data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                           data-room-id="<?php echo get_the_ID() ?>"
                                                           data-action="st_get_availability_hotel_room"
                                                           value="<?php echo esc_attr( $date ); ?>" data-s="<?php echo wp_create_nonce('st_frontend_security'); ?>" name="check_in_out">
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Rooms', 'traveler'); ?></span>
                                                        <?php
                                                        $rooms = get_post_meta(get_the_ID(), 'number_room', true);
                                                        ?>
                                                        <select name="room_num_search">
                                                            <?php
                                                            for($i = 1; $i <= $rooms; $i++){
                                                                echo '<option value="'. esc_attr($i).'">'. esc_html($i) .'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Adults', 'traveler'); ?></span>
                                                        <?php
                                                            $adult_num_search = ST_Single_Hotel::inst()->getMaxPeopleSearchForm();
                                                            $adult_selected = STInput::get('adult_num_search', 1);
                                                            if($adult_selected > $adult_num_search)
                                                                $adult_selected = $adult_num_search;

                                                            if($adult_selected < 1)
                                                                $adult_selected = 1;
                                                        ?>
                                                        <select name="adult_number">
                                                            <?php
                                                                for($i = 1; $i <= $adult_num_search; $i++){
                                                                    $selected = '';
                                                                    if($adult_selected == $i)
                                                                        $selected = 'selected';
                                                                    echo '<option value="'. esc_attr($i).'" '. ($selected) .'>'. esc_html($i) .'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Children', 'traveler'); ?></span>
                                                        <?php
                                                            $children_num_search = ST_Single_Hotel::inst()->getMaxPeopleSearchForm('child');
                                                            $child_selected = STInput::get('children_num_search', 0);
                                                            if($child_selected > $children_num_search)
                                                                $child_selected = $children_num_search;

                                                            if($child_selected < 0)
                                                                $child_selected = 0;
                                                        ?>
                                                        <select name="child_number">
                                                            <?php
                                                            for($i = 0; $i <= $children_num_search; $i++){
                                                                $selected = '';
                                                                if($child_selected == $i)
                                                                    $selected = 'selected';
                                                                echo '<option value="'. esc_attr($i).'" '. esc_html($selected) .'>'. esc_html($i) .'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item field-guest form-group">
                                                    <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest-name', '' ); ?>
                                                </div>
                                                <div class="item extra">
                                                    <?php echo st()->load_template( 'layouts/modern/single_hotel/elements/extras', '' ); ?>
                                                </div>
                                                <input type="hidden" name="action" value="st_add_to_cart" />
                                                <input type="hidden" name="item_id" value="<?php echo esc_attr($hotel_id); ?>" />
                                                <input type="hidden" name="room_id" value="<?php echo get_the_ID(); ?>" />
                                                <input type="hidden" name="is_search_room" value="true" />
                                                <div class="message alert alert-danger"></div>
                                                <button type="submit" class="sts-single-room-check sts-btn"><span><?php echo __('CHECK AVAILABILITY', 'traveler'); ?> <i class="fa fa-spinner fa-spin"></i></span></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
                                        <div class="form-book-wrapper">
                                            <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                            <?php echo st()->load_template( 'layouts/modern/single_hotel/room/enquiry' ); ?>
                                                
                                        </div>
                                    </div>
                                </div>

                            <?php } elseif($booking_type == 'enquire'){
                                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
                                $start           = STInput::get( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                $end             = STInput::get( 'check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                $price = get_post_meta(get_the_ID(), 'price', true);
                                $room_num_search = STInput::request( 'room_num_search', '' );
                                $adult_number = STInput::request( 'adult_num_search', '' );
                                $child_number = STInput::request( 'children_num_search', '' );
                                $start       = TravelHelper::convertDateFormat( $start );
                                $end         = TravelHelper::convertDateFormat( $end );
                                $sale_price  = STPrice::getRoomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_day = STDate::dateDiff(date('Y-m-d', strtotime( $start )), date('Y-m-d', strtotime( $end )));
                                $price = $price * $total_day;
                                if(intval($total_day) > 1){
                                    $text_pernight = $total_day;
                                } else {
                                    $text_pernight = '';
                                }
                                $price_by_per_person = get_post_meta( get_the_ID(), 'price_by_per_person', true );?>
                                <div class="price-wrapper">
                                    <?php
                                    if ( $price_by_per_person == 'on' ): ?>
                                        <?php echo sprintf(__('FROM %s /PERSON /NIGHT', 'traveler'), '<span>'. TravelHelper::format_money($sale_price) .'</span>'); ?>
                                        <?php
                                    else: ?>
                                        <?php echo sprintf(__('FROM %s PER %s NIGHT', 'traveler'), '<span>'. TravelHelper::format_money($price) .'</span>' , $text_pernight); ?>
                                        <?php
                                    endif; ?>
                                </div>
                                <div class="form-book-wrapper">
                                    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                    <?php echo st()->load_template( 'layouts/modern/single_hotel/room/enquiry' ); ?>
                                        
                                </div>
                            <?php } else {
                                echo st()->load_template( 'layouts/modern/single_hotel/room/book-form' );
                            }?>
                        </div>
                        <div class="col-lg-9 col-md-8 col-lg-pull-3 col-md-pull-4">
                            <h3 class="section-title sts-pf-font"><?php echo __( 'Summary', 'traveler' ); ?></h3>
                            <?php echo st()->load_template( 'layouts/modern/single_hotel/room/facility' ); ?>
                            <div class="desc">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/attributes' );
                    ?>
                </div>
                <div class="container">
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/gallery', 'grid' ); ?>
                </div>
                <div class="container">
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/facility', 'detail' ); ?>
                </div>
                <?php
                $address = get_post_meta( get_the_ID(), 'address', true );
                $hotel_room = get_post_meta( get_the_ID(), 'room_parent', true );
                $hotel_map_longitude = get_post_meta( $hotel_room, 'map_lng', true );
                $hotel_map_latitude = get_post_meta( $hotel_room, 'map_lat', true );
                $hotel_address = get_post_meta( $hotel_room, 'address', true );
                $hotel_map_zoom = get_post_meta( $hotel_room, 'map_zoom', true);
                $location_tmp = new stdClass();
                $location_tmp->location_name = $hotel_address;
                $location_tmp->location_address = $address;
                $location_tmp->location_longitude = $hotel_map_longitude;
                $location_tmp->location_latitude = $hotel_map_latitude;
                $list_location = urlencode( json_encode( [
                    $location_tmp
                ] ));
                echo do_shortcode( '<div class="mt-80">[st_hotel_alone_mapbox map_zoom="'.esc_attr($hotel_map_zoom).'" list_location="'.esc_attr($list_location).'" ]</div>' );
                ?>
                <?php
                echo st()->load_template('layouts/modern/single_hotel/room/other_rooms');
            }
            wp_reset_query();
            ?>
        </div>
        <?php
    else : ?>
        <div class="st-single-hotel-modern-page sts-single-room-alone">
            <?php echo st()->load_template('layouts/modern/single_hotel/elements/banner', '', array('is_room_alone' => true)); ?>

            <?php
            while (have_posts()) {
                the_post();
                $hotel_id = get_post_meta(get_the_ID(), 'room_parent', true);
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-lg-push-9 col-md-push-8">
                            <?php if($booking_type == 'instant_enquire'){
                                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
                                $start_old           = STInput::get( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                $end_old             = STInput::get( 'check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                $price = get_post_meta(get_the_ID(), 'price', true);
                                $room_num_search = STInput::request( 'room_num_search', '' );
                                
                                $adult_number = STInput::request( 'adult_num_search', '' );
                                $child_number = STInput::request( 'children_num_search', '' );
                                $start       = TravelHelper::convertDateFormat( $start_old );
                                $end         = TravelHelper::convertDateFormat( $end_old );
                                $sale_price  = STPrice::getRoomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_day = STDate::dateDiff(date('Y-m-d', strtotime( $start )), date('Y-m-d', strtotime( $end )));
                                $price = $price * $total_day;
                                if(intval($total_day) > 1){
                                    $text_pernight = $total_day;
                                } else {
                                    $text_pernight = '';
                                }
                                $total_person = intval( $adult_number ) + intval( $child_number );
                                $price_by_per_person = get_post_meta( get_the_ID(), 'price_by_per_person', true );?>
                                <div class="price-wrapper">
                                    <?php
                                    if ( $price_by_per_person == 'on' ):
                                        echo __('from ', 'traveler');
                                        echo sprintf( '<span class="stt-price">%s</span>', TravelHelper::format_money($sale_price) );
                                        echo sprintf( _n( '/night', '/%d nights', $total_day, 'traveler' ), $total_day );
                                    else: 
                                        echo __('from ', 'traveler');
                                        echo sprintf( '<span class="stt-price">%s</span>', TravelHelper::format_money($sale_price) );
                                        echo sprintf( _n( '/night', '/%d nights', $total_day, 'traveler' ), $total_day );
                                    endif; ?>
                                </div>
                                <nav class="st-sht-tab">
                                    <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                                        <li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
                                        <li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
                                    </ul>
                                </nav>
                                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                    <div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
                                        <div class="sts-booking-form">
                                            <div class="loader-wrapper">
                                                <div class="st-loader"></div>
                                            </div>
                                            <form class="" action="" method="POST">
                                                <div class="item checkin-out people" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                    <div class="date-wrapper">
                                                        <div class="title">
                                                            <span><?php echo __('Check In-Out', 'traveler'); ?></span>
                                                            <?php //echo TravelHelper::getNewIcon('calendar-disable', '#1A2B48', '23px', '23px', true) ?>
                                                        </div>
                                                        <span class="value"><?php echo esc_html($start_old . ' - ' . $end_old); ?></span>
                                                    </div>
                                                    <input type="hidden" class="check-in-input" value="<?php echo esc_attr( $start_old ) ?>" name="check_in">
                                                    <input type="hidden" class="check-out-input" value="<?php echo esc_attr( $end_old ) ?>" name="check_out">
                                                    <input type="text" class="sts-checkin-out"
                                                           data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                           data-room-id="<?php echo get_the_ID() ?>"
                                                           data-action="st_get_availability_hotel_room"
                                                           value="<?php echo esc_attr( $date ); ?>" data-s="<?php echo wp_create_nonce('st_frontend_security'); ?>" name="check_in_out">
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Rooms', 'traveler'); ?></span>
                                                        <?php
                                                        $rooms = get_post_meta(get_the_ID(), 'number_room', true);
                                                        ?>
                                                        <select name="room_num_search">
                                                            <?php
                                                            for($i = 1; $i <= $rooms; $i++){
                                                                echo '<option value="'. esc_attr($i).'">'. esc_html($i) .'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Adults', 'traveler'); ?></span>
                                                        <?php
                                                            $adult_num_search = ST_Single_Hotel::inst()->getMaxPeopleSearchForm();
                                                            $adult_selected = STInput::get('adult_num_search', 1);
                                                            if($adult_selected > $adult_num_search)
                                                                $adult_selected = $adult_num_search;

                                                            if($adult_selected < 1)
                                                                $adult_selected = 1;
                                                        ?>
                                                        <select name="adult_number">
                                                            <?php
                                                                for($i = 1; $i <= $adult_num_search; $i++){
                                                                    $selected = '';
                                                                    if($adult_selected == $i)
                                                                        $selected = 'selected';
                                                                    echo '<option value="'. esc_attr($i).'" '. esc_html($selected) .'>'. esc_html($i) .'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item people">
                                                    <div class="title">
                                                        <span><?php echo __('Children', 'traveler'); ?></span>
                                                        <?php
                                                            $children_num_search = ST_Single_Hotel::inst()->getMaxPeopleSearchForm('child');
                                                            $child_selected = STInput::get('children_num_search', 0);
                                                            if($child_selected > $children_num_search)
                                                                $child_selected = $children_num_search;

                                                            if($child_selected < 0)
                                                                $child_selected = 0;
                                                        ?>
                                                        <select name="child_number">
                                                            <?php
                                                            for($i = 0; $i <= $children_num_search; $i++){
                                                                $selected = '';
                                                                if($child_selected == $i)
                                                                    $selected = 'selected';
                                                                echo '<option value="'. esc_attr($i).'" '. ($selected) .'>'. esc_html($i) .'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="item field-guest form-group">
                                                    <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest-name', '' ); ?>
                                                </div>
                                                <div class="item extra">
                                                    <?php echo st()->load_template( 'layouts/modern/single_hotel/elements/extras', '' ); ?>
                                                </div>
                                                <input type="hidden" name="action" value="st_add_to_cart" />
                                                <input type="hidden" name="item_id" value="<?php echo esc_attr($hotel_id); ?>" />
                                                <input type="hidden" name="room_id" value="<?php echo get_the_ID(); ?>" />
                                                <input type="hidden" name="is_search_room" value="true" />
                                                <div class="message alert alert-danger"></div>
                                                <button type="submit" class="sts-single-room-check sts-btn"><span><?php echo __('CHECK AVAILABILITY', 'traveler'); ?> <i class="fa fa-spinner fa-spin"></i></span></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
                                        <div class="form-book-wrapper">
                                            <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                            <?php echo st()->load_template( 'layouts/modern/single_hotel/room/enquiry' ); ?>
                                                
                                        </div>
                                    </div>
                                </div>

                            <?php } elseif($booking_type == 'enquire'){
                                $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
                                $start_old           = STInput::get( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                $end_old             = STInput::get( 'check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                $price = get_post_meta(get_the_ID(), 'price', true);
                                $room_num_search = STInput::request( 'room_num_search', '' );
                                $adult_number = STInput::request( 'adult_num_search', '' );
                                $child_number = STInput::request( 'children_num_search', '' );
                                $start       = TravelHelper::convertDateFormat( $start_old );
                                $end         = TravelHelper::convertDateFormat( $end_old );
                                $sale_price  = STPrice::getRoomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_day = STDate::dateDiff(date('Y-m-d', strtotime( $start )), date('Y-m-d', strtotime( $end )));
                                $price = $price * $total_day;
                                if(intval($total_day) > 1){
                                    $text_pernight = $total_day;
                                } else {
                                    $text_pernight = '';
                                }
                                $price_by_per_person = get_post_meta( get_the_ID(), 'price_by_per_person', true );?>
                                <div class="price-wrapper">
                                    <?php
                                    if ( $price_by_per_person == 'on' ):
                                        echo __('from ', 'traveler');
                                        echo sprintf( '<span class="stt-price">%s</span>', TravelHelper::format_money($sale_price) );
                                        echo sprintf( _n( '/night', '/%d nights', $total_day, 'traveler' ), $total_day );
                                    else: 
                                        echo __('from ', 'traveler');
                                        echo sprintf( '<span class="stt-price">%s</span>', TravelHelper::format_money($sale_price) );
                                        echo sprintf( _n( '/night', '/%d nights', $total_day, 'traveler' ), $total_day );
                                    endif; ?>
                                </div>
                                <div class="form-book-wrapper">
                                    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                    <?php echo st()->load_template( 'layouts/modern/single_hotel/room/enquiry' ); ?>
                                        
                                </div>
                            <?php } else {
                                echo st()->load_template( 'layouts/modern/single_hotel/room/book-form' );
                            }?>
                        </div>
                        <div class="col-lg-9 col-md-8 col-lg-pull-3 col-md-pull-4">
                            <h3 class="section-title sts-pf-font"><?php echo __('Summary', 'traveler'); ?></h3>
                            <?php echo st()->load_template('layouts/modern/single_hotel/room/facility'); ?>
                            <div class="desc">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template('layouts/modern/single_hotel/room/attributes');
                    ?>
                </div>
                <?php
                echo st()->load_template('layouts/modern/single_hotel/room/gallery');
                echo st()->load_template('layouts/modern/single_hotel/room/other_rooms');
                echo do_shortcode('[st_single_hotel_check_availability_new title="'. __('BOOK YOUR STAY', 'traveler') .'"]');
            }
            wp_reset_query();
            ?>
        </div>
        <?php
    endif; ?>
<?php get_footer('hotel-activity'); ?>
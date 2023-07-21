<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 2:49 PM
 */
$hotel_id = get_post_meta(get_the_ID(), 'room_parent', true);
$booking_period = intval( get_post_meta( $hotel_id, 'hotel_booking_period', true ) );

$current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
$current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
$start_old           = STInput::get( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
$end_old             = STInput::get( 'check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
$date           = STInput::get( 'check_in_out', $start_old . '-' . $end_old );
$price = get_post_meta(get_the_ID(), 'price', true);
$room_num_search = STInput::request( 'room_num_search', '' );
$adult_number = STInput::request( 'adult_num_search', '' );
$child_number = STInput::request( 'children_num_search', '' );
$start       = TravelHelper::convertDateFormat( $start_old );
$end         = TravelHelper::convertDateFormat( $end_old );
$sale_price  = STPrice::getRoomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
$total_day = STDate::dateDiff(date('Y-m-d', strtotime( $start )), date('Y-m-d', strtotime( $end )));
if(intval($total_day) > 1){
    $text_pernight = $total_day;
} else {
    $text_pernight = '';
}
$total_person = intval( $adult_number ) + intval( $child_number );
$price_by_per_person = get_post_meta( get_the_ID(), 'price_by_per_person', true );

?>
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
<div class="sts-booking-form">
    <div class="loader-wrapper">
        <div class="st-loader"></div>
    </div>
    <form class="form-has-guest-name" action="" method="POST">
        <div class="item checkin-out people" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>">
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
                <select class="adult_number" name="adult_number">
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
                <select class="child_number" name="child_number">
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

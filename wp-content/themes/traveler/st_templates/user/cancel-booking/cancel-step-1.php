<?php
/**
*@since 1.2.8
*	Cancel booking step 1 - Get order infomation and confirm
**/

if( !isset( $order_id ) ):
?>
<div class="text-danger"><?php echo __('Can not get order infomation', 'traveler'); ?></div>
<?php else:
	$item_id = (int) get_post_meta( $order_id, 'st_booking_id', true);

	$post_type = get_post_meta( $order_id, 'st_booking_post_type', true);
	if( $post_type == 'st_hotel' ){
		$room_id = (int) get_post_meta($order_id, 'room_id', true);
	}
	$total_price = (float) get_post_meta( $order_id, 'total_price', true);
	$currency = STUser_f::_get_currency_book_history($order_id);

	$percent = (int) get_post_meta( $item_id, 'st_cancel_percent', true );
	if( $post_type == 'st_hotel' && isset( $room_id ) ){
		$percent = (int) get_post_meta( $room_id, 'st_cancel_percent', true );
	}

	$refunded = $total_price - ( $total_price * $percent / 100 );
	$status = get_post_meta( $order_id, 'status', true);
	if( $status != 'complete' ){
		$refunded = 0;
	}
	if($status === 'complete'){
		$status_string = __('Complete','traveler');
	}elseif($status === 'incomplete'){
		$status_string = __('Incomplete','traveler');
	}elseif($status === 'pending'){
		$status_string = __('Pending','traveler');
	}
	else {
		$status_string = $status;
	}
	$st_is_woocommerce_checkout = apply_filters( 'st_is_woocommerce_checkout', false );
	if($st_is_woocommerce_checkout){
		$st_get_meta_orderby_id = st_get_order_by_order_item_id($order_id);
		$status =  ($st_get_meta_orderby_id['status']);
		if($status === 'wc-on-hold'){
			$status_string = __('On hold','traveler');
		}
		elseif($status === 'wc-pending'){
			$status_string = __('Pending','traveler');
		}
		elseif($status === 'wc-cancelled'){
			$status_string = __('Cancelled','traveler');
		}
		
		elseif($status === 'wc-completed'){
			$status_string = __('Complete','traveler');
		}
		elseif($status === 'wc-processing'){
			$status_string = __('Processing','traveler');
		}
		$item_id = !empty($st_get_meta_orderby_id['st_booking_id']) ? $st_get_meta_orderby_id['st_booking_id'] : 0;
		$wc_order_id = !empty($st_get_meta_orderby_id['wc_order_id']) ? $st_get_meta_orderby_id['wc_order_id'] : 0;
		$total_price = (float) get_post_meta( $wc_order_id, '_order_total', true);
		$percent = (int) get_post_meta( $item_id, 'st_cancel_percent', true );
		if( $post_type == 'st_hotel' && isset( $room_id ) ){
			$percent = (int) get_post_meta( $room_id, 'st_cancel_percent', true );
		}
		$refunded = $total_price - ( $total_price * $percent / 100 );
	}

	$check_in        = strtotime( get_post_meta( $order_id, 'check_in', true));
    $check_out       = strtotime(get_post_meta( $order_id, 'check_out', true));
    $format=TravelHelper::getDateFormat();

    if($check_in and $check_out) {
        $date = date_i18n( $format , $check_in) . ' <i class="fa fa-long-arrow-right"></i> ' . date_i18n( $format , $check_out  );
    }
    if( $post_type == 'st_tours') {
        $type_tour = get_post_meta( $item_id , 'type_tour' , true );
        if($type_tour == 'daily_tour') {
            $duration = get_post_meta( $item_id , 'duration_day' , true );
            if ($date){
                $date     = __( "Check in : " , 'traveler' ) . date_i18n( $format , $check_in ) . "<br>";
                $date .= __( "Duration : " , 'traveler' ) . esc_html($duration). " ";
            }
        }
    }
?>
<div class="info">
	<div><strong><?php echo __('Service: ', 'traveler'); ?> </strong> <em><?php echo get_the_title( $item_id ); ?></em></div>
	<?php if( isset( $room_id ) && !empty( $room_id ) ): ?>
	<div><strong><?php echo __('Room: ', 'traveler'); ?> </strong> <em><?php echo get_the_title( $room_id ); ?></em></div>
	<?php endif; ?>
	<div><strong><?php echo __('Execution Time: ', 'traveler'); ?> </strong> <em><?php echo wp_kses($date, ['i' => ['class' => []]]); ?></em></div>
	<button class="btn btn-primary btn-sm mt10 text-capitalize"><?php echo esc_html($status_string); ?></button>

	<div class="clearfix mt10"><strong><?php echo __('Amount: ', 'traveler'); ?></strong> <div class="pull-right"><strong><?php echo TravelHelper::format_money_raw( $total_price, $currency ); ?></strong></div></div>
	<div class="clearfix"><strong><?php echo __('Cancellation Fee: ', 'traveler'); ?></strong> <div class="pull-right"><strong><?php echo esc_html($percent) . '%'; ?></strong></div></div>
	<div class="line clearfix"></div>
	<div class="clearfix mt10"><strong><?php echo __('Amount refunded: ', 'traveler'); ?></strong> <div class="pull-right"><strong><?php echo TravelHelper::format_money_raw( $refunded, $currency ); ?></strong></div></div>

	<div class="alert alert-warning mt20" role="alert">
		<div class=""><strong><?php echo __('Why do you want to cancel this order?', 'traveler'); ?></strong></div>
		<form action="#" class="form mt10" method="post">
			<div class="form-group">
				<label for="">
					<input type="radio" name="why_cancel" value="booked_wrong_itinerary" data-text="<?php echo __('Booked wrong itinerary', 'traveler'); ?>">
					<span><?php echo __('Booked wrong itinerary', 'traveler'); ?></span>
				</label>
				<label for="">
					<input type="radio" name="why_cancel" value="booked_wrong_dates" data-text="<?php echo __('Booked wrong Dates', 'traveler'); ?>">
					<span><?php echo __('Booked wrong Dates', 'traveler'); ?></span>
				</label>
				<label for="">
					<input type="radio" name="why_cancel" value="found_better_itinerary" data-text="<?php echo __('Found better itinerary', 'traveler'); ?>">
					<span><?php echo __('Found better itinerary', 'traveler'); ?></span>
				</label>
				<label for="">
					<input type="radio" name="why_cancel" value="found_better_price" data-text="<?php echo __('Found better price', 'traveler'); ?>">
					<span><?php echo __('Found better price', 'traveler'); ?></span>
				</label>
				<label for="">
					<input type="radio" name="why_cancel" value="other" >
					<span><?php echo __('Other', 'traveler'); ?></span>
				</label>
			</div>
			<div class="form-group">
				<textarea name="detail" id="" class="form-control hide">

				</textarea>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>

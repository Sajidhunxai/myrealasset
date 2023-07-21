<?php
	$user_id = get_current_user_id();
	$order_item = get_post($order_code);
	wp_reset_postdata();
	$payment_method = get_post_meta($order_item->ID, 'payment_method', true);
	$currency = get_post_meta($order_code, 'currency', true);
    $status = get_post_meta( $order_code, 'status', true);
	if( $status != 'complete' ){
		$refunded = 0;
	}
	if($status === 'complete'){
		$status_string = __('Complete','traveler');
	}elseif($status === 'incomplete'){
		$status_string = __('Incomplete','traveler');
	}elseif($status === 'pending'){
		$status_string = __('Pending','traveler');
	} else {
		$status_string = $status;
	}
?>
<div class="row booking-success-notice">
	<div class="col-lg-8 col-md-8 col-left">
		<img src="<?php echo get_template_directory_uri(); ?>/v2/images/ico_success.svg" alt="Payment Success"/>
		<div class="notice-success">
			<p class="line1"><span><?php echo get_post_meta($order_code, 'st_first_name', true); ?>,</span>
				<?php
				if (get_post_meta($order_code, 'payment_method', true) == 'st_submit_form') {
					echo __('your order was submitted successfully!' , 'traveler' ) ;
				} else
                    if(get_post_meta($order_code, 'status', true) === 'complete' ){
                        echo __('your payment was successful!' , 'traveler' ) ;
                    } else {
                        echo __('your order was submitted successfully!' , 'traveler' ) ;
                    }
					
				?>
			</p>
			<p class="line2"><?php _e('Booking details has been sent to: ','traveler'); ?><span><?php echo get_post_meta($order_code, 'st_email', true) ?></span></p>
		</div>
	</div>
	<div class="col-lg-4 col-md-4">
		<ul class="booking-info-detail">
			<li><span><?php echo __('Booking Number:', 'traveler'); ?></span> <?php echo esc_html($order_code) ?></li>
			<li><span><?php echo __('Booking Date:', 'traveler'); ?></span> <?php echo get_the_time(TravelHelper::getDateFormat(), $order_code) ?></li>
			<li><span><?php echo __('Payment Method:', 'traveler'); ?></span> <?php echo STPaymentGateways::get_gatewayname(get_post_meta($order_code, 'payment_method', true)); ?></li>
			<li><span><?php echo __('Status:', 'traveler'); ?></span> <?php echo esc_html($status_string); ?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-md-4 col-lg-push-8 col-md-push-8">
		<h3 class="title">
			<?php echo __('Your Item', 'traveler'); ?>
		</h3>
		<div class="cart-info">
            <?php
            $i = 0;
            $key = get_post_meta($order_code, 'item_id', true);

            do_action('st_payment_success_cart_info', $key, $order_code);

            $post_type = get_post_type($key);

            $value_cart_info = get_post_meta($order_code,'st_cart_info',true);
            $value = $value_cart_info[$key];

            switch ($post_type) {
                case "st_hotel":
                    echo st()->load_template('layouts/modern/hotel/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
                case "hotel_room":
                    echo st()->load_template('layouts/modern/hotel_room/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
                case "st_tours":
                    echo st()->load_template('layouts/modern/tour/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
                case "st_activity":
                    echo st()->load_template('layouts/modern/activity/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
                case "st_cars":
                    echo st()->load_template('layouts/modern/car/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
                case "st_rental":
                    echo st()->load_template('layouts/modern/rental/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                    break;
            }
            ?>
			<div class="total-section">
                <?php
                $arr_item_custom_info = apply_filters('st_array_item_custom_payment_info', array());
                if(in_array($key, $arr_item_custom_info)){
                    do_action('st_custom_payment_info', $key, $order_code);
                }else{
                $data_price = get_post_meta($order_code, 'data_prices', true);
                if(!$data_price) $data_price = array();
                $adult_price  = isset($data_price['adult_price']) ? $data_price['adult_price'] : 0;
                $child_price  = isset($data_price['child_price']) ? $data_price['child_price'] : 0;
                $infant_price = isset($data_price['infant_price']) ? $data_price['infant_price'] : 0;
                $origin_price = isset($data_price['origin_price']) ? $data_price['origin_price'] : 0;
                $sale_price   = isset($data_price['sale_price']) ? $data_price['sale_price'] : 0;

                $extras         = get_post_meta($order_code, 'extras', true);
                $extra_price    = floatval(get_post_meta($order_code, 'extra_price', true));
                $coupon_price   = isset($data_price['coupon_price']) ? $data_price['coupon_price'] : 0;
                $price_with_tax = isset($data_price['total_price_with_tax']) ? $data_price['total_price_with_tax'] : 0;
                if ( $price_with_tax == 0) {
                    $price_with_tax = STPrice::getPriceWithTax($sale_price + $extra_price);
                    $price_with_tax -= $coupon_price;
                }
                $total_price     = isset($data_price['total_price']) ? $data_price['total_price'] : 0 ;
                $deposit_price   = isset($data_price['deposit_price']) ? $data_price['deposit_price'] : 0;
                $tax             = intval(get_post_meta($order_code, 'st_tax_percent', true));
                $deposit_status  = get_post_meta($order_code, 'deposit_money', true);
                $price_equipment = isset($data_price['price_equipment']) ? $data_price['price_equipment'] : 0;
                //Tour package
                $hotel_package          = get_post_meta($order_code, 'package_hotel', true);
                $hotel_package_price    = get_post_meta($order_code, 'package_hotel_price', true);
                $activity_package       = get_post_meta($order_code, 'package_activity', true);
                $activity_package_price = get_post_meta($order_code, 'package_activity_price', true);
                $car_package            = get_post_meta($order_code, 'package_car', true);
                $car_package_price      = get_post_meta($order_code, 'package_car_price', true);
                $flight_package         = get_post_meta($order_code, 'package_flight', true);
                $flight_package_price   = get_post_meta($order_code, 'package_flight_price', true);
                //End package
                $passenger          = get_post_meta($order_code, 'passenger', true);
                $enable_tax_depart  = get_post_meta($order_code, 'enable_tax_depart', true);
                $tax_percent_depart = get_post_meta($order_code, 'tax_percent_depart', true);
                $enable_tax_return  = get_post_meta($order_code, 'enable_tax_return', true);
                $tax_percent_return = get_post_meta($order_code, 'tax_percent_return', true);
                $discount_rate      = get_post_meta($order_code , 'discount_rate' , true);
                $discount_type      = get_post_meta($order_code , 'discount_type' , true);
                ?>
				<ul>
                    <?php
                    if ($post_type != 'st_flight') {
                        if (isset($data_price['adult_price']) && isset($data_price['child_price']) && isset($data_price['infant_price'])) {
                            ?>
                            <?php if ($adult_price) { ?>
                                <li><span class="label"><?php echo __('Adult Price', 'traveler'); ?></span><span
                                            class="value"><?php echo TravelHelper::format_money_from_db($adult_price, $currency); ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($child_price) { ?>
                                <li><span class="label"><?php echo __('Children Price', 'traveler'); ?></span><span
                                            class="value"><?php echo TravelHelper::format_money_from_db($child_price, $currency); ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($infant_price) { ?>
                                <li><span class="label"><?php echo __('Infant Price', 'traveler'); ?></span><span
                                            class="value"><?php echo TravelHelper::format_money_from_db($infant_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($data_price['adult_price']) && isset($data_price['child_price']) && !isset($data_price['infant_price'])) {
                            ?>
                            <?php if ($adult_price) { ?>
                                <li><span class="label"><?php echo __('Adult Price', 'traveler'); ?></span><span
                                            class="value"><?php echo TravelHelper::format_money_from_db($adult_price, $currency); ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($child_price) { ?>
                                <li><span class="label"><?php echo __('Children Price', 'traveler'); ?></span><span
                                            class="value"><?php echo TravelHelper::format_money_from_db($child_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php
                        }
                        ?>
                        <?php
                        if ($key == 'car_transfer') {
                            $base_price = get_post_meta($order_code, 'base_price', true);
                            $discount_rate = get_post_meta($order_code, 'discount_rate', true);
                            ?>
                            <li>
                                <span class="label"><?php echo __('Car price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($base_price, $currency); ?></span>
                            </li>
                            <li>
                                <span class="label"><?php echo __('Extra price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($extra_price, $currency); ?></span>
                            </li>
                            <?php if (!empty($discount_rate)) { ?>
                                <li>
                                    <span class="label"><?php echo __('Discount rate', 'traveler'); ?></span>
                                    <span class="value"><?php echo esc_html($discount_rate) . '%'; ?></span>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if ( isset($discount_rate) && $discount_rate > 0 ): ?>
                            <li>
                                <span class="label"><?php echo __('Discount', 'traveler'); ?></span>
                                <?php
                                if ( isset($discount_type) && $discount_type == 'amount' ) { ?>
                                    <span class="value"><?php echo esc_html(TravelHelper::format_money_from_db($discount_rate, $currency)); ?></span>
                                    <?php
                                } else { ?>
                                    <span class="value"><?php echo esc_html($discount_rate . '%') ?></span>
                                    <?php
                                } ?>
                            </li>
                            <?php
                        endif; ?>
                       
                        <?php if (!empty($extras['value']) and is_array($extras['value']) && count($extras['value']) && ($extra_price != 0)) { ?>
                            <li>
                                <span class="label"><?php echo __('Extra Price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($extra_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <!-- Hotel package -->
                        <?php 
                        if (!empty($hotel_package) and is_array($hotel_package) && count($hotel_package)) { ?>
                            <li>
                                <span class="label"><?php echo __('Hotel Package Price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($hotel_package_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <?php if (!empty($activity_package) and is_array($activity_package) && count($activity_package)) { ?>
                            <li>
                                <span class="label"><?php echo __('Activity Package Price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($activity_package_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <?php if (!empty($car_package) and is_array($car_package) && count($car_package)) { ?>
                            <li>
                                <span class="label"><?php echo __('Car Package Price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($car_package_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <?php if (!empty($flight_package) and is_array($flight_package) && count($flight_package)) { ?>
                            <li>
                                <span class="label"><?php echo __('Flight Package Price', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($flight_package_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <?php if (isset($data_price['price_equipment'])) { ?>
                            <li>
                                <span class="label"><?php echo __('Equipment Price', 'traveler'); ?></span>
                                                            <span class="value"><?php echo TravelHelper::format_money_from_db($price_equipment, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <?php
                        $total_price_origin = floatval($data_price['total_price_origin']);
                        $total_bulk_discount = !empty($data_price['total_bulk_discount']) ? floatval($data_price['total_bulk_discount']) : '';
                            if($total_price_origin > $sale_price && $total_bulk_discount > 0){ ?>
                                <li>
                                    <span class="label"><?php echo __('Bulk Discount', 'traveler'); ?></span>
                                    <span class="value"> - <?php echo TravelHelper::format_money($total_bulk_discount); ?></span>
                                </li>
                            <?php }
                        ?>
                        <li>
                            <span class="label"><?php echo __('Subtotal', 'traveler'); ?></span>
                            <span class="value"><?php echo TravelHelper::format_money_from_db($sale_price, $currency); ?></span>
                        </li>
                        <li>
                            <span class="label"><?php echo __('Tax', 'traveler'); ?></span>
                            <span class="value"><?php echo esc_html($tax) . ' %'; ?></span>
                        </li>
                        <?php if ($coupon_price) { ?>
                            <li>
                                <span class="label"><?php echo __('Coupon', 'traveler'); ?></span>
                                <span class="value"> - <?php echo TravelHelper::format_money_from_db($coupon_price, $currency); ?></span>
                            </li>
                        <?php } ?>


                        <?php if (is_array($deposit_status) && !empty($deposit_status['type']) && floatval($deposit_status['amount']) > 0) { ?>
                            <li>
                                <span class="label"><?php echo __('Deposit', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($deposit_price, $currency); ?></span>
                            </li>
                            <?php
                            if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                ?>
                                <li>
                                    <span class="label"><?php echo __('Fee', 'traveler'); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <span class="label"><?php echo __('Total', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($price_with_tax, $currency); ?></span>
                            </li>
                            <li>
                                <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($total_price, $currency); ?></span>
                            </li>
                        <?php } else { ?>
                            <?php
                            if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                ?>
                                <li>
                                    <span class="label"><?php echo __('Fee', 'traveler'); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <li class="payment-amount">
                                <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                                <span class="value">
                                    <?php
                                    $booking_fee_add_total = 0;
                                    if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                        $booking_fee_add_total = $booking_fee_price;
                                    }
                                    echo TravelHelper::format_money_from_db($price_with_tax + $booking_fee_add_total, $currency);
                                    ?>
                                </span>
                            </li>
                        <?php
                        }
                    } else {
                        if (!empty($passenger) && intval($passenger) > 0) { ?>
                            <li>
                                <span class="label"><?php echo __('Passenger', 'traveler'); ?></span>
                                <span class="value"><?php echo esc_attr($passenger); ?></span>
                            </li>
                        <?php } ?>
                        <?php if ($enable_tax_depart == 'yes_not_included' && intval($tax_percent_depart) > 0) { ?>
                            <li>
                                <span class="label"><?php echo __('Tax Depart', 'traveler'); ?></span>
                                <span class="value"><?php echo esc_attr($tax_percent_depart) . '%'; ?></span>
                            </li>
                        <?php } ?>
                        <?php if ($enable_tax_return == 'yes_not_included' && intval($tax_percent_return) > 0) { ?>
                            <li>
                                <span class="label"><?php echo __('Tax Return', 'traveler'); ?></span>
                                <span class="value"><?php echo esc_attr($tax_percent_return) . '%'; ?></span>
                            </li>
                        <?php } ?>
                        <?php
                        if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                            ?>
                            <li>
                                <span class="label"><?php echo __('Fee', 'traveler'); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                            </li>
                        <?php } ?>
                        <li class="payment-amount">
                            <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                            <span class="value"><?php echo TravelHelper::format_money_from_db($price_with_tax, $currency); ?></span>
                        </li>
                        <?php
                    }
                    ?>
				</ul>
                <?php } ?>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-lg-pull-4 col-md-pull-4">
		<h3 class="title">
			<?php echo __('Your Information', 'traveler'); ?>
		</h3>
        <?php
        ob_start();
        ?>
		<div class="info-form">
			<ul>
				<li><span class="label"><?php echo __('First Name', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_first_name', true) ?></span></li>
				<li><span class="label"><?php echo __('Last name', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_last_name', true) ?></span></li>
				<li><span class="label"><?php echo __('Email', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_email', true) ?></span></li>
				<li><span class="label"><?php echo __('Address Line 1', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_address', true) ?></span></li>
				<li><span class="label"><?php echo __('Address Line 2', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_address2', true) ?></span></li>
				<li><span class="label"><?php echo __('City', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_city', true) ?></span></li>
				<li><span class="label"><?php echo __('State/Province/Region', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_province', true) ?></span></li>
				<li><span class="label"><?php echo __('ZIP code/Postal code', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_zip_code', true) ?></span></li>
				<li><span class="label"><?php echo __('Country', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_country', true) ?></span></li>
				<li><span class="label"><?php echo __('Special Requirements', 'traveler'); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_note', true) ?></span></li>
			</ul>
		</div>
        <?php
        $customer_infomation = @ob_get_clean();
        echo apply_filters( 'st_order_success_custommer_billing' , $customer_infomation, $order_code );
        ?>
        <div class="text-center mg20 mt30">
            <?php
            if (is_user_logged_in()){
                $page_user = st()->get_option('page_my_account_dashboard');
                if ($link = get_permalink($page_user)){
                    $link = esc_url(add_query_arg(array('sc'=>'booking-history'),$link));
                    ?>
                    <a href="<?php echo esc_url($link)?>" class="btn btn-primary"><i
                                class="fa fa-book"></i> <?php echo __('Booking Management' , 'traveler') ;  ?></a>
                    <?php
                }
            }
            ?>
            <?php
            $option_allow_guest_booking = st()->get_option('is_guest_booking');
            if($option_allow_guest_booking == 'on'){
                do_action('st_after_order_success_page_information_table',$order_code);
            }else{
                if (is_user_logged_in()){
                    do_action('st_after_order_success_page_information_table',$order_code);
                }
            }
            ?>

        </div>
	</div>
</div>

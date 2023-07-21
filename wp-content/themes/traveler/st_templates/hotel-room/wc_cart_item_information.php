<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 02/06/2015
 * Time: 3:32 CH
 */
$format=TravelHelper::getDateFormat();
$div_id = "st_cart_item".md5(json_encode($st_booking_data['cart_item_key']));
$room_id = isset($st_booking_data['room_id']) ? $st_booking_data['room_id'] : 0;
$price_by_per_person = get_post_meta( $room_id, 'price_by_per_person', true );
?>

<p class="booking-item-description">
    <?php echo __('Date:','traveler');?> <?php  echo date_i18n($format,strtotime($st_booking_data['check_in'])) ?> <i class="fa fa-long-arrow-right"></i> <?php echo date_i18n($format,strtotime($st_booking_data['check_out'])) ?>

<div id="<?php echo esc_attr($div_id);?>" class='<?php if (apply_filters('st_woo_cart_is_collapse' , false)) {echo esc_attr("collapse");}?>'>
    <p><small><?php echo __("Booking Details" , 'traveler') ; ?></small> </p>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <ul class="booking-item-description">
            <li><?php echo __('Adult:','traveler');?> <?php echo esc_html($st_booking_data['adult_number']); ?></li>
            <li><?php echo __('Children:','traveler');?> <?php echo esc_html($st_booking_data['child_number']); ?></li>
            <?php
            if ( $price_by_per_person == 'on' ) : ?>
                <li><?php echo __('Number of rooms:','traveler');?> <?php echo ($st_booking_data['room_num_search']); ?></li>
                <li><?php echo __('Adult Price:','traveler');?> <?php echo TravelHelper::format_money(isset($st_booking_data['adult_price']) ? $st_booking_data['adult_price'] : 0) ; ?></li>
                <li><?php echo __('Child Price:','traveler');?>  <?php echo TravelHelper::format_money(isset($st_booking_data['child_price']) ? $st_booking_data['child_price'] : 0) ; ?></li>
                <?php
            else: ?>
                <li><?php echo __('Number of rooms:','traveler');?> <?php echo ($st_booking_data['room_num_search']); ?> x <?php echo TravelHelper::format_money($st_booking_data['ori_price']) ; ?></li>
                <?php
            endif; ?>
        </ul>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
    <?php

        if(!empty($st_booking_data['extras']) and $st_booking_data['extra_price']):
            $extras = $st_booking_data['extras'];
                if(isset($extras['title']) && is_array($extras['title']) && count($extras['title'])): ?>
                     <b class='booking-cart-item-title'><?php _e("Extra prices",'traveler') ?></b>
                    <div class="booking-item-payment-price-amount">
                    <?php foreach($extras['title'] as $key => $title):
                                $price_item = floatval($extras['price'][$key]);
                                if($price_item <= 0) $price_item = 0;
                                $number_item = intval($extras['value'][$key]);
                                if($number_item <= 0) $number_item = 0;
                    ?><?php if($number_item){ ?>
                        <span style="padding-left: 10px ">
                            <?php echo esc_attr($title).": ".esc_attr($number_item).' x '.TravelHelper::format_money($price_item); ?>
                        </span> <br />
                        <?php };?>
                    <?php endforeach;?>
                    </div>
                <?php  endif; ?>
    <?php endif; ?>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php
            $discount = $st_booking_data['discount_rate'];
            if (!empty($discount)){ ?>
                <b class='booking-cart-item-title'><?php echo __( "Discount", 'traveler'); ?>: </b>
                <?php echo esc_attr($discount)."%" ?>
            <?php }
        ?>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php  if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) {
            $wp_cart = WC()->cart->cart_contents;
            $item = $wp_cart[$st_booking_data['cart_item_key']];
            $tax = $item['line_tax'];
            if (!empty($tax)) { ?>
                <b class='booking-cart-item-title'><?php echo __( "Tax", 'traveler'); ?>: </b>
                <?php echo TravelHelper::format_money($tax);?>
            <?php }
        }else {$tax = 0 ;}
        ?>
    </div>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <b class='booking-cart-item-title'><?php echo __("Total amount" , 'traveler') ;  ?>:</b>
	    <?php
	    $include_tax_price =  get_option('woocommerce_prices_include_tax');
	    if($include_tax_price == 'yes')
		    echo TravelHelper::format_money($st_booking_data['ori_price'] );
	    else
		    echo TravelHelper::format_money($st_booking_data['ori_price'] + $tax );
	    ?>
    </div>
</div>

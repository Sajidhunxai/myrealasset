<?php
$woo_order_id = $order_data['order_item_id'];
$order = wc_get_order( $order_id );
$total = $tax = $sub_total = 0;
$data_price = STUser_f::_get_price_item_order_woo($woo_order_id);
$discount_rate = wc_get_order_item_meta($woo_order_id, '_st_discount_rate', true);
$discount_type = wc_get_order_item_meta($woo_order_id, '_st_discount_type', true);

$currency = TravelHelper::_get_currency_book_history($order_id);
//Add fee to detail booking
foreach ( $order->get_items() as $key => $item ) {
    $fee_price = wc_get_order_item_meta( $key, '_st_booking_fee_price' );
}

if(!empty($data_price)){
    if($fee_price > 0){
        $total = $data_price[0]['meta_value'] + $data_price[1]['meta_value'] + $fee_price;
    }else{
        $total = $data_price[0]['meta_value'] + $data_price[1]['meta_value'];
    }

    $tax = $data_price[1]['meta_value'];
    $sub_total = $data_price[0]['meta_value'];
} ?>
<div class="line col-md-12"></div>
<?php
if (isset($discount_rate) && $discount_rate > 0) : ?>
    <div class="col-md-12">
        <strong><?php esc_html_e("Discount: ", 'traveler'); ?></strong>
        <div class="pull-right">
            <?php
            if ( isset($discount_type) && $discount_type == 'amount' )
                echo TravelHelper::format_money_from_db($discount_rate ,$currency);
            else
                echo esc_html($discount_rate . '%');
            ?>
        </div>
    </div>
    <?php
endif; ?>
<div class="col-md-12">
    <strong><?php esc_html_e("Sub Total: ",'traveler') ?></strong>
    <div class="pull-right">
        <strong>
            <?php
                echo TravelHelper::format_money_raw($sub_total, $currency);
            ?>
        </strong>
    </div>
</div>
<div class="col-md-12">
    <strong><?php esc_html_e("Tax: ",'traveler') ?></strong>
    <div class="pull-right">
        <strong>
            <?php
                echo TravelHelper::format_money_raw($tax, $currency);
            ?>
        </strong>
    </div>
</div>
<?php if($fee_price > 0){ ?>
<div class="col-md-12">
    <strong><?php esc_html_e("Fee: ",'traveler') ?></strong>
    <div class="pull-right">
        <strong>
            <?php
                echo TravelHelper::format_money_raw($fee_price, $currency);
            ?>
        </strong>
    </div>
</div>
<?php } ?>
<div class="line col-md-12"></div>
<div class="col-md-12">
    <strong><?php esc_html_e("Pay Amount: ",'traveler') ?></strong>
    <div class="pull-right">
        <strong>
            <?php
                echo TravelHelper::format_money_raw($total, $currency);
            ?> 
        </strong>
    </div>
</div>

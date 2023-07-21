<?php
if(isset($item_id) and $item_id):
    $item = STCart::find_item($item_id);
    $hotel = $item_id;
    $room_id = $item['data']['room_id'];

    $check_in = $item['data']['check_in'];
    $check_out = $item['data']['check_out'];

    $date_diff = STDate::dateDiff($check_in,$check_out);

    $extras = isset($item['data']['extras']) ? $item['data']['extras'] : array();
    $extra_type = isset($item['data']['extra_type']) ? $item['data']['extra_type'] : 'perday';
    $adult_number = intval($item['data']['adult_number']);
    $child_number = intval($item['data']['child_number']);
    $discount_rate = isset($item['data']['discount_rate']) ? $item['data']['discount_rate'] : '';
    $discount_type = get_post_meta($room_id, 'discount_type', true);
?>
<div class="service-section">
    <div class="service-left">
        <a href="<?php echo get_permalink($hotel)?>">
            <?php echo get_the_post_thumbnail($hotel,array(140,110,'bfi_thumb'=>true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($hotel )), 'class' => 'img-responsive'));?>
        </a>
    </div>
    <div class="service-right">
        <h3 class="title"><a href="<?php echo get_permalink($hotel)?>"><?php echo get_the_title($hotel)?></a></h3>
        <?php
        $address = get_post_meta( $item_id, 'address', true);
        if( $address ):
            ?>
            <p class="address"><i class="stt-icon-location1"></i><?php echo esc_html($address); ?> </p>
        <?php
        endif;
        ?>
    </div>
</div>
<div class="room-type">
    <span class="label"><?php echo __('Room type:', 'traveler'); ?></span>
    <span class="value"><a href="<?php echo get_the_permalink($room_id) ?>"><?php echo get_the_title($room_id)?></a></span>
</div>
<div class="info-section">
    <h4 class="info-heading"><?php echo esc_html__('Your trip', 'traveler'); ?></h4>
    <ul>
        <li>
            <span class="label">
                <?php echo __('Date', 'traveler'); ?>
            </span>
            <span class="value">
                <?php echo date_i18n( TravelHelper::getDateFormat(), strtotime( $check_in ) ); ?>
                -
                <?php echo date_i18n( TravelHelper::getDateFormat(), strtotime( $check_out ) ); ?>
                <?php
                    $start = date( TravelHelper::getDateFormat(), strtotime( $check_in ) );
                    $end   = date( TravelHelper::getDateFormat(), strtotime( $check_out ) );
                    $date  = date( 'd/m/Y h:i a', strtotime( $check_in ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $check_out ) );
                    $args  = [
                        'start' => $start,
                        'end'   => $end,
                        'date'  => $date
                    ];
                ?>
                <a class="st-link" style="font-size: 12px;" href="<?php echo add_query_arg( $args, get_the_permalink( $item_id ) ); ?>"><?php echo __( 'Edit', 'traveler' ); ?></a>
            </span>
            <div class="detail">
                <button class="btn btn-primary">
                    <?php echo __('Detail', 'traveler'); ?> <i class="fa fa-caret-down"></i>
                </button>
                <?php echo STPrice::showRoomPriceInfo($room_id, strtotime($check_in), strtotime(($check_out))); ?>
            </div>
        </li>
        <li class="ad-info">
            <ul>
                <li>
                    <span class="label"><?php echo esc_html__('Number of Night', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($date_diff) ?></span>
                </li>
                <?php if($adult_number) {?>
                <li>
                    <span class="label"><?php echo esc_html__('Adults', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_attr($adult_number); ?></span>
                </li>
                <?php } ?>
                <?php if($child_number) {?>
                    <li>
                        <span class="label"><?php echo esc_html__('Children', 'traveler'); ?></span>
                        <span class="value"><?php echo esc_attr($child_number); ?></span>
                    </li>
                <?php } ?>
                <li>
                    <span class="label"><?php echo esc_html__('Room', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($item['number']);?></span>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="coupon-section">
    <h5><?php echo __('Coupon Code', 'traveler'); ?></h5>

    <form method="post" action="<?php the_permalink() ?>">
        <?php if (isset(STCart::$coupon_error['status'])): ?>
            <div
                class="alert alert-<?php echo STCart::$coupon_error['status'] ? 'success' : 'danger'; ?>">
                <p>
                    <?php echo STCart::$coupon_error['message'] ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <?php $code = STInput::post('coupon_code') ? STInput::post('coupon_code') : STCart::get_coupon_code();?>
            <input id="field-coupon_code" value="<?php echo esc_attr($code ); ?>" type="text" name="coupon_code" />
            <input type="hidden" name="st_action" value="apply_coupon">
            <?php if(st()->get_option('use_woocommerce_for_booking','off') == 'off' && st()->get_option('booking_modal','off') == 'on' ){ ?>
                <input type="hidden" name="action" value="ajax_apply_coupon">
                <button type="submit" class="btn btn-primary add-coupon-ajax wp-block-search__button"><?php echo __('APPLY', 'traveler'); ?></button>
                <div class="alert alert-danger hidden"></div>
            <?php }else{ ?>
                <button type="submit" class="btn btn-primary wp-block-search__button"><?php echo __('APPLY', 'traveler'); ?></button>
            <?php } ?>
        </div>
    </form>
</div>
    <?php
    $price = floatval(get_post_meta($room_id, 'price', true));
    $number_room = intval($item['number']);
    $numberday = STDate::dateDiff($check_in, $check_out);
    $origin_price = STPrice::getRoomPriceOnlyCustomPrice($room_id, strtotime($check_in), strtotime($check_out), $number_room, $adult_number, $child_number );
    $sale_price = isset($item['data']['sale_price']) ? floatval($item['data']['sale_price']) : 0;
    $extra_price = isset($item['data']['extra_price']) ? floatval($item['data']['extra_price']) : 0;
    $price_coupon = floatval(STCart::get_coupon_amount());
    $price_with_tax = STPrice::getPriceWithTax($sale_price + $extra_price );
    $price_with_tax -= $price_coupon;
    ?>
<div class="price-details">
    <h5><?php echo __('Price details', 'traveler'); ?></h5>
        <div class="item">
            <span class="label">
                <?php echo sprintf(_n('%s night', '%s nights', $date_diff, 'traveler'), $date_diff) ?>
            </span>
            <span class="value">
                <?php echo TravelHelper::format_money($origin_price) ?>
            </span>
        </div>
    <?php
    $check_extra = false;
    if(!empty($extras["value"]) && is_array(array_values($extras["value"]))){
        foreach(array_values($extras["value"]) as $value_number){
            if($value_number > 0){
                $check_extra = true;
                break;
            }
        }
    }

    ?>
    <?php
    if(isset($item['data']['deposit_money'])):
        $deposit      = $item['data']['deposit_money'];
        if(!empty($deposit['type']) and !empty($deposit['amount'])){
            $deposite_amount = '';
            $deposite_type = '';
            switch($deposit['type']){
                case "percent":
                    $deposite_amount = $deposit['amount'] . ' %';
                    $deposite_type = __('percent', 'traveler');
                    break;
                case "amount":
                    $deposite_amount = TravelHelper::format_money($deposit['amount']);
                    $deposite_type = __('amount', 'traveler');
                    break;
            } ?>
            <li>
                    <span class="label">
                        <?php echo esc_html(__('Deposit','traveler')) ?>
                        <?php echo ' '. esc_html($deposite_type) ?>
                    </span>
                <span class="value pull-right">
                        <?php
                        echo esc_html($deposite_amount);
                        ?>
                    </span>
            </li>
        <?php }
    endif; ?>
</div>
<div class="total-section">
    <ul>
        <?php
        if ( !empty($discount_rate) && isset($discount_type) ) : ?>
            <li>
                <span class="label"><?php echo __('Discount', 'traveler'); ?></span>
                <span class="value">
                    <?php
                    if($discount_type == 'amount'){
                        echo TravelHelper::format_money($discount_rate);
                    }else{
                        echo esc_html($discount_rate).'%';
                    } ?>
                </span>
            </li>
            <?php
        endif;
        ?>
        <?php
        $total_price_origin = floatval($item['data']['total_price_origin']);
            if($total_price_origin > $sale_price){ ?>
                <li>
                    <span class="label"><?php echo __('Bulk Discount', 'traveler'); ?></span>
                    <span class="value"> - <?php echo TravelHelper::format_money($total_price_origin - $sale_price); ?></span>
                </li>
            <?php }
        ?>
        <li><span class="label"><?php echo __('Subtotal', 'traveler'); ?></span><span class="value"><?php echo TravelHelper::format_money($sale_price); ?></span></li>
        <?php
            if(!empty(STPrice::getTax()) && (STPrice::getTax()) > 0){?>
                <?php if(st()->get_option('st_tax_include_enable','off') == 'on') : ?>
                    <li><span class="label"><?php echo __('Tax included', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php else : ?>
                    <li><span class="label"><?php echo __('Tax', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php endif; ?>
            <?php }
        ?>
        <?php if (STCart::use_coupon()):
            if($price_coupon < 0) $price_coupon = 0;
            ?>
            <li>
                <span class="label text-left">
                    <?php printf(st_get_language('coupon_key'), STCart::get_coupon_code()) ?> <br/>
                    <?php if(st()->get_option('use_woocommerce_for_booking','off') == 'off' && st()->get_option('booking_modal','off') == 'on' ){ ?>
                        <a href="javascript: void(0);" title="" class="ajax-remove-coupon" data-coupon="<?php echo STCart::get_coupon_code(); ?>"><small class='text-color'>(<?php st_the_language('Remove coupon') ?> )</small></a>
                    <?php }else{ ?>
                        <a href="<?php echo st_get_link_with_search(get_permalink(), array('remove_coupon'), array('remove_coupon' => STCart::get_coupon_code())) ?>"
                           class="danger"><small class='text-color'>(<?php st_the_language('Remove coupon') ?> )</small></a>
                    <?php } ?>
                </span>
                <span class="value">
                        - <?php echo TravelHelper::format_money( $price_coupon ) ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if($check_extra) :
            ?>
            <li><span class="label"><?php echo __('Extra', 'traveler'); ?></span></li>
            <div class="extra-prices">
                <?php
                foreach ($extras['value'] as $name => $number):
                    $number_item = intval($extras['value'][$name]);
                    if ($number_item <= 0) $number_item = 0;
                    if ($number_item > 0):
                        $price_item = floatval($extras['price'][$name]);
                        if ($price_item <= 0) $price_item = 0;
                        ?>
                        <div class="item">
                            <span class="label">
                                <?php echo esc_html($extras['title'][$name]) . ' x ' . esc_html($number_item) . ' ' . esc_html__('(Extra)', 'traveler') ?>
                            </span>
                            <span class="value">
                                <?php
                                $calc_extra_price = 0;
                                    if($extra_type == 'perday') {
                                        $calc_extra_price = $price_item * $number_item * $date_diff * $item['number'];
                                    }else{
                                        $calc_extra_price = $price_item * $number_item * $item['number'];
                                    }
                                ?>
                                <?php echo TravelHelper::format_money($calc_extra_price) ?>
                            </span>
                        </div>
                    <?php endif;
                endforeach;
                ?>
            </div>
        <?php endif; ?>
        <?php
        if(isset($item['data']['deposit_money']) && count($item['data']['deposit_money']) && floatval($item['data']['deposit_money']['amount']) > 0):

            $deposit      = $item['data']['deposit_money'];

            $deposit_price = $price_with_tax;

            if($deposit['type'] == 'percent'){
                $de_price = floatval($deposit['amount']);
                $deposit_price = $deposit_price * ($de_price /100);
            }elseif($deposit['type'] == 'amount'){
                $de_price = floatval($deposit['amount']);
                $deposit_price = $de_price;
            }
            ?>
            <li>
                <span class="label"><?php echo __('Total', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($price_with_tax); ?></span>
            </li>
            <li>
                <span class="label"><?php echo __('Deposit', 'traveler'); ?></span>
                <span class="value">
                    <?php echo TravelHelper::format_money($deposit_price); ?>
                </span>
            </li>
            <?php
            $total_price = 0;
            if(isset($item['data']['deposit_money']) && floatval($item['data']['deposit_money']['amount']) > 0){
                $total_price = $deposit_price;
            }else{
                $total_price = $price_with_tax;
            }
            ?>
            <?php if(!empty($item['data']['booking_fee_price'])){
            $total_price = $total_price + $item['data']['booking_fee_price'];
            ?>
            <li>
                <span class="label"><?php echo __('Fee', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($item['data']['booking_fee_price']); ?></span>
            </li>
            <?php } ?>
            <li class="payment-amount">
                <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                <span class="value">
                        <?php echo TravelHelper::format_money($total_price); ?>
                </span>
            </li>

        <?php else: ?>
            <?php if(!empty($item['data']['booking_fee_price'])){
                $price_with_tax = $price_with_tax + $item['data']['booking_fee_price'];
                ?>
                <li>
                    <span class="label"><?php echo __('Fee', 'traveler'); ?></span>
                    <span class="value"><?php echo TravelHelper::format_money($item['data']['booking_fee_price']); ?></span>
                </li>
            <?php } ?>
            <li class="payment-amount">
                <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($price_with_tax); ?></span>
            </li>
        <?php endif; ?>
    </ul>
</div>
<?php
endif;
?>

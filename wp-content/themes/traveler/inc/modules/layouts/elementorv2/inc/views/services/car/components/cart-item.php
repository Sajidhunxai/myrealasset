<?php
if(isset($item_id) and $item_id):
    $item = STCart::find_item($item_id);
    $car = $item_id;
    $check_in = $item['data']['check_in'];
    $check_out = $item['data']['check_out'];

    $extras = isset($item['data']['data_equipment']) ? $item['data']['data_equipment'] : array();
    $discount_rate = isset($item['data']['discount_rate']) ? $item['data']['discount_rate'] : '';
    $discount_type = get_post_meta($item_id, 'discount_type', true);
?>
<div class="service-section">
    <div class="service-left">
        <?php echo get_the_post_thumbnail($car,array(110,110,'bfi_thumb'=>true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($car )), 'class' => 'img-responsive'));?>

    </div>
    <div class="service-right">
        <h3 class="title"><a href="<?php echo get_permalink($car)?>"><?php echo get_the_title($car)?></a></h3>
        <?php
        $address = get_post_meta( $item_id, 'address', true);
        if( $address ):
            ?>
            <p class="address d-flex align-items-center"><i class="stt-icon-location1"></i><?php echo esc_html($address); ?> </p>
            <?php
        endif;
        ?>
    </div>
</div>
<div class="info-section">
    <ul>
        <li>
            <span class="label">
                <?php echo __('Car type', 'traveler'); ?>
            </span>
            <span class="value">
                    <?php
                    $cartype = get_the_terms($car, 'st_category_cars');
                    if (!is_wp_error($cartype) && !empty($cartype)) {
                        $cartype_html = '';
                        foreach ($cartype as $type) {
                            $cartype_html .= $type->name . ', ';
                        }
                        if (!empty($cartype_html)) {
                            echo substr($cartype_html, 0, -2);
                        }
                    }
                    ?>
            </span>
        </li>
        <!--Add Info-->
        <li>
            <span class="label"><?php echo __('Address Rent Car', 'traveler'); ?></span>
            <span class="value"><?php echo esc_html($item['data']['pick_up']); ?></span>
        </li>
        <!-- <li>
            <span class="label"><?php echo __('Est. Distance', 'traveler'); ?></span>
            <span class="value"><?php echo round($item['data']['data_destination'], 2); ?> <?php echo strtolower(STCars::get_price_unit('label')) ?></span>
        </li> -->
        <li>
            <span class="label"><?php echo __('Date', 'traveler'); ?></span>
            <span class="value"><?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_in_timestamp']); ?> - <?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_out_timestamp']); ?></span>
        </li>
        <?php
        if (isset($item['data']['car_title_sale_price']['title_price']) && !empty($item['data']['car_title_sale_price']['title_price'])) { ?>
            <li>
				<?php $unit = st()->get_option('cars_price_unit', 'day'); ?>
                <span class="label">
					<?php printf( esc_html__( 'Price by number of %s', 'traveler' ), $unit ) ?>
				</span>
            </li>
            <li class="extra-value">
                <span class="pull-left"><?php echo esc_html($item['data']['car_title_sale_price']['title_price']['title']); ?></span><span
                        class="pull-right"> <?php echo TravelHelper::format_money($item['data']['car_title_sale_price']['title_price']['price']); ?></span>
            </li>
        <?php }
        ?>

        <?php
        /*diff date*/
        /*$date1 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_in_timestamp']));
        $date2 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_out_timestamp']));
        $diff = abs($item['data']['check_out_timestamp'] - $item['data']['check_in_timestamp']);
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
                        / (30*60*60*24));
        $days_extra = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));*/
        $days_extra = $item['data']['numberday'];
        ?>
        <?php if (isset($extras['value']) && is_array($extras['value']) && count($extras['value'])): ?>
            <li>
                <span class="label"><?php echo __('Extra', 'traveler'); ?></span>
            </li>
            <li class="extra-value">
                <?php
                $unit_extra = st()->get_option('cars_price_unit', 'day');
                $text_unit_extra = '';
                switch ($unit_extra) {
                    case 'distance':
                    case 'hour':
                        $text_unit_extra = __('Hour(s)', 'traveler');
                        break;
                    default:
                        $text_unit_extra = __('Day(s)', 'traveler');
                        break;
                }
                foreach ($extras['value'] as $name => $number):
                    $number_item = intval($extras['value'][$name]);
                    if ($number_item <= 0) $number_item = 0;
                    if ($number_item > 0):
                        $price_item = floatval($extras['price'][$name]);
                        if ($price_item <= 0) $price_item = 0;
                        $price_type = $extras['price_type'][$name];
                        ?>
                        <span class="pull-left">
                        <?php
                        if ($price_type == 'fixed') {
                            echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler');
                        } else {
                            echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler') . ' x ' . esc_html($days_extra) . ' ' . esc_html($text_unit_extra);
                        }

                        ?>
                        </span> <br/>
                    <?php endif;
                endforeach;
                ?>
            </li>
        <?php endif; ?>
        <?php
        if (isset($item['data']['deposit_money'])):
            $deposit = $item['data']['deposit_money'];
            if (!empty($deposit['type']) and !empty($deposit['amount'])) {
                $deposite_amount = '';
                $deposite_type = '';
                switch ($deposit['type']) {
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
                        <?php echo esc_html(__('Deposit', 'traveler')) ?>
                        <?php echo ' ' . esc_html($deposite_type) ?>
                    </span>
                    <span class="value pull-right">
                        <?php
                        echo esc_html($deposite_amount);
                        ?>
                    </span>
                </li>
            <?php }
        endif; ?>
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
<div class="total-section">
    <ul>
        <?php
        if (!empty($discount_rate) && isset($discount_type)) : ?>
            <li>
                <span class="label"><?php echo __('Discount', 'traveler'); ?></span>
                <span class="value">
                    <?php
                    if ($discount_type == 'amount') {
                        echo TravelHelper::format_money($discount_rate);
                    } else {
                        echo esc_html($discount_rate) . '%';
                    } ?>
                </span>
            </li>
        <?php
        endif;
        ?>
        <li>
            <span class="label"><?php echo __('Subtotal', 'traveler'); ?></span>
            <span class="value"><?php echo TravelHelper::format_money($item['data']['sale_price']) ?></span>
        </li>
        <?php if ($item['data']['price_equipment']): ?>
            <li>
                <span class="label"><?php echo __('Extra ', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($item['data']['price_equipment']) ?></span>
            </li>
        <?php endif; ?>
        <?php
        if(!empty(STPrice::getTax()) && (STPrice::getTax()) > 0){?>
             <?php if(st()->get_option('st_tax_include_enable','off') == 'on') : ?>
                    <li><span class="label"><?php echo __('Tax included', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php else : ?>
                    <li><span class="label"><?php echo __('Tax', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php endif; ?>
            <?php }
        ?>
        <?php
        $price_coupon = 0;
        $price_with_tax = (float)$item['data']['price_with_tax'];

        if (STCart::use_coupon()):
            $price_coupon = floatval(STCart::get_coupon_amount());
            if ($price_coupon < 0) $price_coupon = 0;
            $price_with_tax -= $price_coupon;
            ?>
            <li>
            <span class="label text-left">
                <?php printf(st_get_language('coupon_key'), STCart::get_coupon_code()) ?> <br/>
                <?php if (st()->get_option('use_woocommerce_for_booking', 'off') == 'off' && st()->get_option('booking_modal', 'off') == 'on') { ?>
                    <a href="javascript: void(0);" title="" class="ajax-remove-coupon"
                        data-coupon="<?php echo STCart::get_coupon_code(); ?>"><small
                                class='text-color'>(<?php st_the_language('Remove coupon') ?> )</small></a>
                <?php } else { ?>
                    <a href="<?php echo st_get_link_with_search(get_permalink(), array('remove_coupon'), array('remove_coupon' => STCart::get_coupon_code())) ?>"
                        class="danger"><small class='text-color'>(<?php st_the_language('Remove coupon') ?> )</small></a>
                <?php } ?>
            </span>
                <span class="value">
                    - <?php echo TravelHelper::format_money($price_coupon) ?>
            </span>
            </li>
        <?php endif; ?>
        <?php
        if (isset($item['data']['deposit_money']) && count($item['data']['deposit_money']) && floatval($item['data']['deposit_money']['amount']) > 0){
            $deposit = $item['data']['deposit_money'];
            $deposit_price = $price_with_tax;

            if ($deposit['type'] == 'percent') {
                $de_price = floatval($deposit['amount']);
                $deposit_price = $deposit_price * ($de_price / 100);
            } elseif ($deposit['type'] == 'amount') {
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
            if (isset($item['data']['deposit_money']) && floatval($item['data']['deposit_money']['amount']) > 0) {
                $total_price = $deposit_price;
            } else {
                $total_price = $price_with_tax;
            }
            ?>
            <?php if (!empty($item['data']['booking_fee_price'])) {
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
        <?php
        } else { ?>
            <?php if (isset($item['data']['booking_fee_price'])):
                $price_with_tax += $item['data']['booking_fee_price'];
                ?>
                <li>
                    <span class="label"><?php echo __('Fee ', 'traveler'); ?></span>
                    <span class="value"><?php echo TravelHelper::format_money($item['data']['booking_fee_price']); ?></span>
                </li>
            <?php endif; ?>
            <li class="payment-amount">
                <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($price_with_tax); ?></span>
            </li>
        <?php
        } ?>
    </ul>
</div>
<?php
endif;
?>

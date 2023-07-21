<?php
if(isset($item_id) and $item_id):
    $item = STCart::find_item($item_id);
    $activity_id = $item_id;
    $check_in = $item['data']['check_in'];
    $check_out = $item['data']['check_out'];
    $starttime = isset($item['data']['starttime']) ? $item['data']['starttime'] : '';
    $type_activity=$item['data']['type_activity'];
    $duration = isset($item['data']['duration']) ? $item['data']['duration'] : '';
    $adult_number = intval($item['data']['adult_number']);
    $child_number = intval($item['data']['child_number']);
    $infant_number = intval($item['data']['infant_number']);
    $extras = isset($item['data']['extras']) ? $item['data']['extras'] : array();
    $discount_rate = isset($item['data']['discount_rate']) ? $item['data']['discount_rate'] : '';
    $discount_type = get_post_meta($item_id, 'discount_type', true);
    $extra_price = isset($item['data']['extra_price']) ? floatval($item['data']['extra_price']) : 0;
?>
<div class="service-section">
    <div class="service-left">
        <h3 class="title"><a href="<?php echo get_permalink($activity_id)?>"><?php echo get_the_title($activity_id)?></a></h3>
        <?php
        $address = get_post_meta( $item_id, 'address', true);
        if( $address ):
            ?>
            <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
            <?php
        endif;
        ?>
    </div>
    <div class="service-right">
        <?php echo get_the_post_thumbnail($activity_id,array(110,110,'bfi_thumb'=>true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($activity_id )), 'class' => 'img-responsive'));?>
    </div>
</div>
<div class="info-section">
    <ul>
        <li>
            <span class="label">
                <?php echo __('Activity type', 'traveler'); ?>
            </span>
            <span class="value">
                <?php
                if($type_activity == 'daily_activity'){
                    echo __('Daily Activity', 'traveler');
                }elseif($type_activity == 'specific_date'){
                    echo __('Special Date', 'traveler');
                }
                ?>
            </span>
        </li>

        <li>
            <span class="label">
                <?php echo __('Date', 'traveler'); ?>
            </span>
            <span class="value">
                <?php if($type_activity == 'daily_activity'){ ?>
                    <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_in)); ?>
                    <?php echo ($starttime != '' && isset($starttime)) ? ' - ' . esc_html($starttime) : ''; ?>
                <?php }else{ ?>
                    <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_in)); ?>
                    -
                    <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_out)); ?>
                    <?php echo ($starttime != '' && isset($starttime)) ? ' - ' . esc_html($starttime) : ''; ?>
                <?php } ?>
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
        </li>

        <?php if($type_activity == 'daily_activity' and $duration): ?>
            <li>
                <span class="label"><?php  _e('Duration','traveler')?> </span>
                <span class="value">
                    <?php
                    echo esc_html($duration);
                    ?>
                </span>
            </li>
        <?php endif; ?>

        <li>
            <span class="label"><?php  _e("Max People",'traveler')?> </span>
            <span class="value">
                <?php
                    $max_people = (int)get_post_meta($item_id ,'max_people',true);
                    if( $max_people == 0 ){
                        $max_people = __('Unlimited', 'traveler');
                    }
                    echo esc_html($max_people);
                ?>
            </span>
        </li>


        <!--Add Info-->
        <li class="ad-info">
            <ul>
                <?php if($adult_number) {?>
                <li><span class="label"><?php echo __('Number of Adult', 'traveler'); ?></span><span class="value"><?php echo esc_html($adult_number); ?></span></li>
                <?php } ?>
                <?php if($child_number) {?>
                    <li><span class="label"><?php echo __('Number of Children', 'traveler'); ?></span><span class="value"><?php echo esc_attr($child_number); ?></span></li>
                <?php } ?>
                <?php if($infant_number) {?>
                    <li><span class="label"><?php echo __('Number of Infant', 'traveler'); ?></span><span class="value"><?php echo esc_html($infant_number); ?></span></li>
                <?php } ?>
            </ul>
        </li>
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

        if($check_extra) :
        ?>
            <li>
                <span class="label"><?php echo __('Extra', 'traveler'); ?></span>
            </li>
            <li class="extra-value">
                    <?php
                    foreach ($extras['value'] as $name => $number):
                        $number_item = intval($extras['value'][$name]);
                        if ($number_item <= 0) $number_item = 0;
                        if ($number_item > 0):
                            $price_item = floatval($extras['price'][$name]);
                            if ($price_item <= 0) $price_item = 0;
                            ?>
                            <span class="pull-right">
                            <?php echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler'); ?>
                            </span> <br/>
                        <?php endif;
                    endforeach;
                    ?>
            </li>
        <?php endif; ?>
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
                        <?php echo ' '.esc_html($deposite_type) ?>
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
                <button type="submit" class="btn btn-primary add-coupon-ajax"><?php echo __('APPLY', 'traveler'); ?></button>
                <div class="alert alert-danger hidden"></div>
            <?php }else{ ?>
                <button type="submit" class="btn btn-primary"><?php echo __('APPLY', 'traveler'); ?></button>
            <?php } ?>
        </div>
    </form>
</div>
<div class="total-section">
    <?php
    $data_price = STPrice::getPriceByPeopleTour($item_id, strtotime($check_in), strtotime($check_out),  $adult_number, $child_number, $infant_number);
    $origin_price = floatval($data_price['total_price']);
    $sale_price = $origin_price;
    $price_coupon = floatval(STCart::get_coupon_amount());

    $price_with_tax = STPrice::getPriceWithTax($origin_price+$extra_price);
    $price_with_tax -= $price_coupon;
    ?>
    <ul>
        <li>
            <span class="label">
                <?php echo __('Adult Price', 'traveler'); ?>
            </span>
            <span class="value">
                <?php if($data_price['adult_price']) echo TravelHelper::format_money($data_price['adult_price']); else echo '0'; ?>
            </span>
        </li>

        <li>
            <span class="label">
                <?php echo __('Children Price', 'traveler'); ?>
            </span>
            <span class="value">
                <?php if($data_price['child_price']) echo TravelHelper::format_money($data_price['child_price']); else echo '0'; ?>
            </span>
        </li>

        <li>
            <span class="label">
                <?php echo __('Infant Price', 'traveler'); ?>
            </span>
            <span class="value">
               <?php if($data_price['infant_price']) echo TravelHelper::format_money($data_price['infant_price']); else echo '0'; ?>
            </span>
        </li>

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
        $total_price_origin = floatval($data_price['total_price_origin']);
            if($total_price_origin > $sale_price){ ?>
                <li>
                    <span class="label"><?php echo __('Bulk Discount', 'traveler'); ?></span>
                    <span class="value"> - <?php echo TravelHelper::format_money($total_price_origin - $origin_price); ?></span>
                </li>
            <?php }
        ?>
        <li><span class="label"><?php echo __('Subtotal', 'traveler'); ?></span><span class="value"><?php echo TravelHelper::format_money($origin_price); ?></span></li>
        <?php if($check_extra): ?>
            <li>
                <span class="label"><?php echo __('Extra Price', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($extra_price); ?></span>
            </li>
        <?php endif; ?>
        <?php 
            if(!empty(STPrice::getTax()) && (STPrice::getTax()) != 0){?>
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
                        <a href="javascript: void(0);" title="" class="ajax-remove-coupon" data-coupon="<?php echo STCart::get_coupon_code(); ?>"><small class='text-color'>(<?php st_the_language('Remove coupon') ?> )</a>
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

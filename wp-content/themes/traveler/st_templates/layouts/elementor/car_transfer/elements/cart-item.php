<?php
if($item_id === 'car_transfer'){
    if (isset($item_id) and $item_id):
        $item_id = STCart::find_item($item_id);
        $id_car = $item_id['data']['car_id'];
        $check_in = $item_id['data']['check_in'];
        $check_out = $item_id['data']['check_out'];
        $extras = isset($item_id['data']['data_equipment']) ? $item_id['data']['data_equipment'] : array();
        $extras_new = isset($item_id['data']['extras']) ? $item_id['data']['extras'] : array();
        ?>
        <div class="service-section">
            <div class="service-left">
                <h3 class="title"><a href="<?php echo get_permalink($id_car) ?>"><?php echo get_the_title($id_car) ?></a></h3>
                <?php
                $address = get_post_meta($id_car, 'cars_address', true);
                if ($address):
                    ?>
                    <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
                <?php
                endif;
                ?>
            </div>
            <div class="service-right">
                <?php echo get_the_post_thumbnail($id_car, array(110, 110, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($id_car)), 'class' => 'img-responsive')); ?>
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
                         $cartype = get_the_terms($id_car, 'st_category_cars');
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
                    <span class="label"><?php echo __('Pick Up From', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($item_id['data']['pick_up']); ?></span>
                </li>
                <li>
                    <span class="label"><?php echo __('Drop Off To', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($item_id['data']['drop_off']); ?></span>
                </li>
                <li>
                    <span class="label"><?php echo __('Est. Distance', 'traveler'); ?></span>
                    <span class="value">
                        <?php
                        $time = $item_id['data']['distance'];
                        $hour = ( $time[ 'hour' ] >= 2 ) ? esc_html($time[ 'hour' ]) . ' ' . esc_html__( 'hours', 'traveler' ) : $time[ 'hour' ] . ' ' . esc_html__( 'hour', 'traveler' );
                        $minute = ( $time[ 'minute' ] >= 2 ) ? esc_html($time[ 'minute' ]) . ' ' . esc_html__( 'minutes', 'traveler' ) : esc_html($time[ 'minute' ]) . ' ' . esc_html__( 'minute', 'traveler' );
                        echo esc_attr( $hour ) . ' ' . esc_attr( $minute ) . ' - ' .esc_html( $time['distance']) . __('Km', 'traveler');
                        ?>
                    </span>
                </li>
                <li>
                    <span class="label"><?php echo __('Pickup Date', 'traveler'); ?></span>
                    <span class="value"><?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item_id['data']['check_in_timestamp']); ?></span>
                </li>
                <?php
                    /*diff date*/
                    /*$date1 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_in_timestamp']));
                    $date2 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_out_timestamp'])); 
                    $diff = abs($item['data']['check_out_timestamp'] - $item['data']['check_in_timestamp']);
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) 
                                   / (30*60*60*24));
                    $days_extra = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));*/
                $days_extra = $item_id['data']['numberday'];
                $passengers = $item_id['data']['passenger'];
                if (isset($extras['value']) && is_array($extras['value']) && count($extras['value'])){ ?>
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
                                $price_type = $extras['price_type'][$name];
                                ?>
                                <span class="pull-right">
                                <?php
                                    if($price_type == 'fixed'){
                                        echo esc_html( $extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler');
                                    }else{
                                        echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler');
                                    }

                                ?>
                                </span> <br/>
                            <?php endif;
                        endforeach;
                        ?>
                    </li>
                    
                <?php } else { ?>
                    <li>
                        <span class="label"><?php echo __('Extra', 'traveler'); ?></span>
                    </li>
                    <li class="extra-value">
                        <?php
                        foreach ($extras_new as $name => $number):
                            $number_item = intval($number['number']);
                            $price_item = floatval($number['price']);
                            if ($price_item <= 0) $price_item = 0;
                            ?>
                            <span class="pull-left">
                                <?php
                                    echo esc_html($number['title']) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler'). ' x '.esc_html($days_extra).' '. __('Day(s)', 'traveler');

                                ?>
                                </span> <br/>
                        <?php endforeach;
                        ?>
                    </li>
                <?php }?>
                <?php
                if(isset($passengers) && $passengers > 0 ){ ?>
                    <li>
                        <span class="label"><?php echo __('Passengers', 'traveler'); ?></span>
                        <span class="value"><?php echo esc_html($passengers); ?></span>
                    </li>
                <?php    }
                    if($item_id['data']['has_return'] === 'yes'){
                        echo '<li>
                                <span class="label">'. __("Direction Price", 'traveler').'</span>
                                <span class="value">'.TravelHelper::format_money($item_id['data']['price']).'</span>
                            </li>';
                        echo '<li>
                            <span class="label">'. __("Towards Price", 'traveler').'</span>
                            <span class="value">'.TravelHelper::format_money($item_id['data']['price_return']).'</span>
                        </li>';
                    }
                    

                ?>
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
                    <?php $code = STInput::post('coupon_code') ? STInput::post('coupon_code') : STCart::get_coupon_code(); ?>
                    <input id="field-coupon_code" value="<?php echo esc_attr($code); ?>" type="text" name="coupon_code"/>
                    <input type="hidden" name="st_action" value="apply_coupon">
                    <?php if (st()->get_option('use_woocommerce_for_booking', 'off') == 'off' && st()->get_option('booking_modal', 'off') == 'on') { ?>
                        <input type="hidden" name="action" value="ajax_apply_coupon">
                        <button type="submit"
                                class="btn btn-primary add-coupon-ajax"><?php echo __('APPLY', 'traveler'); ?></button>
                        <div class="alert alert-danger hidden"></div>
                    <?php } else { ?>
                        <button type="submit" class="btn btn-primary"><?php echo __('APPLY', 'traveler'); ?></button>
                    <?php } ?>
                </div>
            </form>
        </div>
        <div class="total-section">
            <ul>
                <?php 
                    if($item_id['data']['discount_rate'] > 0){ ?>
                        <li>
                            <span class="label"><?php echo __('Discount', 'traveler'); ?></span>
                            <span class="value"><?php 
                            $price_discount = floatval($item_id['data']['item_price']) - floatval($item_id['data']['sale_price']);
                            echo TravelHelper::format_money($price_discount) ?></span>
                        </li>
                    <?php }
                ?>
                <li>
                    <span class="label"><?php echo __('Subtotal', 'traveler'); ?></span>
                    <span class="value"><?php echo TravelHelper::format_money($item_id['data']['sale_price']) ?></span>
                </li>
                <?php if ($item_id['data']['price_equipment']): ?>
                    <li>
                        <span class="label"><?php echo __('Extra ', 'traveler'); ?></span>
                        <span class="value"><?php echo TravelHelper::format_money($item_id['data']['price_equipment']) ?></span>
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
                <?php
                if(isset($item_id['data']['deposit_money'])):
                    $deposit      = $item_id['data']['deposit_money'];
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
                <?php
                $price_coupon = 0;
                if(isset($item_id['data']['price_with_tax'])){
                    $price_with_tax = (float)$item_id['data']['price_with_tax'];
                }
                
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
                                        class='text-color'>(<?php st_the_language('Remove coupon') ?> )</a>
                        <?php } else { ?>
                            <a href="<?php echo st_get_link_with_search(get_permalink(), array('remove_coupon'), array('remove_coupon' => STCart::get_coupon_code())) ?>"
                               class="danger"><small class='text-color'>(<?php st_the_language('Remove coupon') ?> )</small></a>
                        <?php } ?>
                    </span>
                        <span class="value">
                            - <?php echo TravelHelper::format_money($price_coupon) ?>
                    </span>
                    </li>
                <?php endif;

                if(isset($item_id['data']['deposit_money']) && count($item_id['data']['deposit_money']) && floatval($item_id['data']['deposit_money']['amount']) > 0){

                    $deposit      = $item_id['data']['deposit_money'];

                    $deposit_price = $price_with_tax;

                    if($deposit['type'] == 'percent'){
                        $de_price = floatval($deposit['amount']);
                        $deposit_price = $deposit_price * ($de_price /100);
                    }elseif($deposit['type'] == 'amount'){
                        $de_price = floatval($deposit['amount']);
                        $deposit_price = $de_price;
                    }
                }
                
                if(isset($item_id['data']['deposit_money']) && floatval($item_id['data']['deposit_money']['amount']) > 0){
                    $total_price = $deposit_price;
                }else{
                    $total_price = $price_with_tax;
                } ?>
                <?php if (isset($item_id['data']['booking_fee_price'])):
                    $price_with_tax += $item_id['data']['booking_fee_price'];
                    ?>
                    <li>
                        <span class="label"><?php echo __('Fee ', 'traveler'); ?></span>
                        <span class="value"><?php echo TravelHelper::format_money($item_id['data']['booking_fee_price']); ?></span>
                    </li>
                <?php endif; ?>
                <li class="payment-amount">
                    <span class="label"><?php echo __('Pay Amount', 'traveler'); ?></span>
                    <span class="value"><?php echo TravelHelper::format_money($total_price); ?></span>
                </li>
            </ul>
        </div>
    <?php
    endif; 
} else {
   if (isset($item_id) and $item_id):
    $item = STCart::find_item($item_id);
    $tour = $item_id;

    $check_in = $item['data']['check_in'];
    $check_out = $item['data']['check_out'];

    $extras = isset($item['data']['data_equipment']) ? $item['data']['data_equipment'] : array();
    ?>
    <div class="service-section">
        <div class="service-left">
            <h3 class="title"><a href="<?php echo get_permalink($tour) ?>"><?php echo get_the_title($tour) ?></a></h3>
            <?php
            $address = get_post_meta($item_id, 'cars_address', true);
            if ($address):
                ?>
                <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
            <?php
            endif;
            ?>
        </div>
        <div class="service-right">
            <?php echo get_the_post_thumbnail($tour, array(110, 110, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($tour)), 'class' => 'img-responsive')); ?>
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
                     $cartype = get_the_terms($tour, 'st_category_cars');
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
                <span class="label"><?php echo __('Pick Up From', 'traveler'); ?></span>
                <span class="value"><?php echo esc_html($item['data']['pick_up']); ?></span>
            </li>
            <li>
                <span class="label"><?php echo __('Drop Off To', 'traveler'); ?></span>
                <span class="value"><?php echo esc_html($item['data']['drop_off']); ?></span>
            </li>
            <li>
                <span class="label"><?php echo __('Est. Distance', 'traveler'); ?></span>
                <span class="value"><?php echo round($item['data']['data_destination'], 2); ?> <?php echo strtolower(STCars::get_price_unit('label')) ?></span>
            </li>
            <li>
                <span class="label"><?php echo __('Date', 'traveler'); ?></span>
                <span class="value"><?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_in_timestamp']); ?> - <?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_out_timestamp']); ?></span>
            </li>
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
                    foreach ($extras['value'] as $name => $number):
                        $number_item = intval($extras['value'][$name]);
                        if ($number_item <= 0) $number_item = 0;
                        if ($number_item > 0):
                            $price_item = floatval($extras['price'][$name]);
                            if ($price_item <= 0) $price_item = 0;
                            $price_type = $extras['price_type'][$name];
                            ?>
                            <span class="pull-right">
                            <?php
                                if($price_type == 'fixed'){
                                    echo esc_html( $extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler');
                                }else{
                                    echo esc_html($extras['title'][$name] ). ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler'). ' x '.esc_html($days_extra).' '. __('Day(s)', 'traveler');
                                }

                            ?>
                            </span> <br/>
                        <?php endif;
                    endforeach;
                    ?>
                </li>
            <?php endif; ?>
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
                <?php $code = STInput::post('coupon_code') ? STInput::post('coupon_code') : STCart::get_coupon_code(); ?>
                <input id="field-coupon_code" value="<?php echo esc_attr($code); ?>" type="text" name="coupon_code"/>
                <input type="hidden" name="st_action" value="apply_coupon">
                <?php if (st()->get_option('use_woocommerce_for_booking', 'off') == 'off' && st()->get_option('booking_modal', 'off') == 'on') { ?>
                    <input type="hidden" name="action" value="ajax_apply_coupon">
                    <button type="submit"
                            class="btn btn-primary add-coupon-ajax"><?php echo __('APPLY', 'traveler'); ?></button>
                    <div class="alert alert-danger hidden"></div>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary"><?php echo __('APPLY', 'traveler'); ?></button>
                <?php } ?>
            </div>
        </form>
    </div>
    <div class="total-section">
        <ul>
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
            if(!empty(STPrice::getTax()) && (STPrice::getTax()) != 0){?>
                <?php if(st()->get_option('st_tax_include_enable','off') == 'on') : ?>
                    <li><span class="label"><?php echo __('Tax included', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php else : ?>
                    <li><span class="label"><?php echo __('Tax', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
                <?php endif; ?>
                <?php }
            ?>
            <?php
            $price_coupon = 0;
            if(isset($item['data']['price_with_tax'])){
                $price_with_tax = (float)$item['data']['price_with_tax'];
            }
            
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
                                    class='text-color'>(<?php st_the_language('Remove coupon') ?> )</a>
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
        </ul>
    </div>
<?php
endif; 
}
?>
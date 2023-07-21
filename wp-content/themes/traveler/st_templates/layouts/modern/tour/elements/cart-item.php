<?php
if(isset($item_id) and $item_id):
    $item = STCart::find_item($item_id);
    $extra_price = isset($item['data']['extra_price']) ? floatval($item['data']['extra_price']) : 0;
    $tour = $item_id;
    $check_in = $item['data']['check_in'];
    $check_out = $item['data']['check_out'];
    $type_tour=$item['data']['type_tour'];
    $duration = isset($item['data']['duration']) ? $item['data']['duration'] : 0;
    $tour_price_by = get_post_meta($tour, 'tour_price_by', true);

    $date_diff = STDate::dateDiff($check_in,$check_out);

    $adult_number = intval($item['data']['adult_number']);
    $child_number = intval($item['data']['child_number']);
    $infant_number = intval($item['data']['infant_number']);
    $extras = isset($item['data']['extras']) ? $item['data']['extras'] : array();

    $hotel_package = isset($item['data']['package_hotel']) ? $item['data']['package_hotel'] : array();
    $activity_package = isset($item['data']['package_activity']) ? $item['data']['package_activity'] : array();
    $car_package = isset($item['data']['package_car']) ? $item['data']['package_car'] : array();
    $flight_package = isset($item['data']['package_flight']) ? $item['data']['package_flight'] : array();
    $discount_rate = isset($item['data']['discount_rate']) ? $item['data']['discount_rate'] : '';
    $discount_type = get_post_meta($item_id, 'discount_type', true);
?>
<div class="service-section">
    <div class="service-left">
        <h3 class="title"><a href="<?php echo get_permalink($tour)?>"><?php echo get_the_title($tour)?></a></h3>
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
        <?php echo get_the_post_thumbnail($tour,array(110,110,'bfi_thumb'=>true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($tour )), 'class' => 'img-responsive'));?>
    </div>
</div>
<div class="info-section">
    <ul>
        <?php if($tour_price_by != 'fixed_depart'){ ?>
            <li>
                <span class="label">
                    <?php echo __('Tour type', 'traveler'); ?>
                </span>
                <span class="value">
                     <?php
                     if($type_tour == 'daily_tour'){
                         echo __('Daily Tour', 'traveler');
                     }elseif($type_tour == 'specific_date'){
                         echo __('Special Date', 'traveler');
                     }
                     ?>
                </span>
            </li>
            <?php if($type_tour == 'daily_tour'): ?>
            <li>
                <span class="label">
                    <?php echo __('Departure date', 'traveler'); ?>
                </span>
                <span class="value">
                    <?php echo date_i18n( TravelHelper::getDateFormat(), strtotime( $check_in ) ); ?>
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
            <?php else: ?>
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
                </li>
            <?php endif; ?>
            <?php
            /*Starttime*/
            if(isset($item['data']['starttime']) && !empty($item['data']['starttime'])){
                ?>
                <li>
                <span class="label">
                    <?php echo __('Start time', 'traveler'); ?>
                </span>
                    <span class="value">
                        <?php echo esc_html($item['data']['starttime']); ?>
                    </span>
                </li>
                <?php
            }
            ?>
            <?php if($type_tour == 'daily_tour' and $duration): ?>
                <li>
                    <span class="label">
                        <?php echo __('Duration', 'traveler'); ?>
                    </span>
                        <span class="value">
                         <?php
                         echo STTour::get_duration_unit($item_id);
                         ?>
                    </span>
                </li>
            <?php endif; ?>
        <?php }else{ ?>
            <li><b><?php echo __('Fixed Departure', 'traveler'); ?></b></li>
            <li>
                <span class="label">
                    <?php echo __('Start', 'traveler'); ?>
                </span>
                <span class="value">
                     <?php
                     echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_in));
                     ?>
                </span>
            </li>
            <li>
                <span class="label">
                    <?php echo __('End', 'traveler'); ?>
                </span>
                <span class="value">
                     <?php
                     echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_out));
                     ?>
                </span>
            </li>
        <?php } ?>


        <!--Add Info-->
        <li class="ad-info">
            <ul>
                <?php if($adult_number) {?>
                <li><span class="label"><?php echo __('Number of Adult', 'traveler'); ?></span><span class="value"><?php echo esc_attr($adult_number); ?></span></li>
                <?php } ?>
                <?php if($child_number) {?>
                    <li><span class="label"><?php echo __('Number of Children', 'traveler'); ?></span><span class="value"><?php echo esc_attr($child_number); ?></span></li>
                <?php } ?>
                <?php if($infant_number) {?>
                    <li><span class="label"><?php echo __('Number of Infant', 'traveler'); ?></span><span class="value"><?php echo esc_attr($infant_number); ?></span></li>
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

        <!-- Tour Package -->
        <?php if(is_array($hotel_package) && count($hotel_package)): ?>
            <li class="package-value">
                <p class="booking-item-payment-price-title"><?php _e("Selected Hotel Package",'traveler') ?></p>
                <p class="booking-item-payment-price-amount">
                    <?php
                    foreach($hotel_package as $k_hp => $v_hp):
                        if(!empty($v_hp->qty) && intval($v_hp->qty) > 0){ ?>
                             <span class="pull-right">
                                <?php echo esc_html($v_hp->hotel_name) . ' (' . TravelHelper::format_money($v_hp->hotel_price) . ') x ' . esc_attr($v_hp->qty) . ' ' . __('Item(s)', 'traveler'); ?>
                            </span> <br />
                        <?php }?>
                    <?php endforeach;?>
                </p>
            </li>
        <?php  endif; ?>
        <?php if(is_array($activity_package) && count($activity_package)): ?>
            <li class="package-value">
                <p class="booking-item-payment-price-title"><?php _e("Selected Activity Package",'traveler') ?></p>
                <p class="booking-item-payment-price-amount">
                    <?php
                    foreach($activity_package as $k_hp => $v_hp):
                        if(!empty($v_hp->qty) && intval($v_hp->qty) > 0){ ?>
                            <span class="pull-right">
                            <?php echo esc_html($v_hp->activity_name) . ' (' . TravelHelper::format_money($v_hp->activity_price) . ') x ' . esc_attr($v_hp->qty) . ' ' . __('Item(s)', 'traveler'); ?>
                            </span> <br />
                       <?php } ?>
                    <?php endforeach;?>
                </p>
            </li>
        <?php  endif; ?>
        <?php if(is_array($car_package) && count($car_package)): ?>
            <li class="package-value">
                <p class="booking-item-payment-price-title"><?php _e("Selected Car Package",'traveler') ?></p>
                <p class="booking-item-payment-price-amount">
                    <?php
                    foreach($car_package as $k_hp => $v_hp):
                        if(!empty($v_hp->qty) && intval($v_hp->qty) > 0){ ?>
                            <span class="pull-right">
                                <?php echo esc_html($v_hp->car_name ). ' ('.TravelHelper::format_money($v_hp->car_price).') x ' . esc_html($v_hp->car_quantity). ' ' . __('Item(s)', 'traveler'); ?>
                            </span> <br />
                       <?php }?>
                    <?php endforeach;?>
                </p>
            </li>
        <?php  endif; ?>
        <?php if(is_array($flight_package) && count($flight_package)): ?>
            <li>
                <p class="booking-item-payment-price-title"><?php _e("Selected Flight Package",'traveler') ?></p>
                <p class="booking-item-payment-price-amount">
                    <?php
                    foreach($flight_package as $k_fp => $v_fp):
                        if(!empty($v_hp->qty) && intval($v_hp->qty) > 0){ ?>

                            <span class="pull-right">
                                <?php
                                $name_flight_package = $v_fp->flight_origin . ' <i class="fa fa-long-arrow-right"></i> ' . esc_attr($v_fp->flight_destination);
                                $price_flight_package = '';
                                if($v_fp->flight_price_type == 'business'){
                                    $price_flight_package = TravelHelper::format_money($v_fp->flight_price_business);
                                }else{
                                    $price_flight_package = TravelHelper::format_money($v_fp->flight_price_economy);
                                }
                                ?>
                                <?php echo htmlspecialchars_decode( $name_flight_package) . ' (' . esc_attr($price_flight_package) . ')'; ?>
                            </span> <br />
                        <?php }?>
                    <?php endforeach;?>
                </p>
            </li>
        <?php  endif; ?>
        <!-- End Tour Package -->
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
    $price_type = STTour::get_price_type($item_id);
    $data_price = !empty( $item['data']['data_price'] ) ? $item['data']['data_price'] : [];
    $base_price = isset($item['data']['base_price']) ? floatval($item['data']['base_price']) : 0;
    $origin_price = floatval($data_price['total_price']);
    $sale_price = floatval($item['data']['sale_price']);

    $hotel_package_price = isset($item['data']['package_hotel_price']) ? floatval($item['data']['package_hotel_price']) : 0;
    $activity_package_price = isset($item['data']['package_activity_price']) ? floatval($item['data']['package_activity_price']) : 0;
    $car_package_price = isset($item['data']['package_car_price']) ? floatval($item['data']['package_car_price']) : 0;
    $flight_package_price = isset($item['data']['package_flight_price']) ? floatval($item['data']['package_flight_price']) : 0;

    $price_coupon = floatval(STCart::get_coupon_amount());
    $price_with_tax = STPrice::getPriceWithTax($sale_price);
    $price_with_tax -= $price_coupon;
    ?>
    <ul>
        <?php if($price_type == 'person' or $price_type == 'fixed_depart'){ ?>
            <?php if(!empty($adult_number) && $adult_number > 0) {?>
            <li>
                <span class="label">
                    <?php echo __('Adult Price', 'traveler'); ?>
                </span>
                <span class="value">
                    <?php if($item['data']['adult_price']) echo TravelHelper::format_money($item['data']['adult_price']); else echo '0'; ?>
                </span>
            </li>
            <?php }?>
            <?php if(!empty($child_number) && $child_number > 0) {?>
            <li>
                <span class="label">
                    <?php echo __('Children Price', 'traveler'); ?>
                </span>
                <span class="value">
                    <?php if($item['data']['child_price']) echo TravelHelper::format_money($item['data']['child_price']); else echo '0'; ?>
                </span>
            </li>
            <?php }?>
            <?php if(!empty($infant_number) && $infant_number > 0) {?>
            <li>
                <span class="label">
                    <?php echo __('Infant Price', 'traveler'); ?>
                </span>
                <span class="value">
                    <?php if($item['data']['infant_price']) echo TravelHelper::format_money($item['data']['infant_price']); else echo '0'; ?>
                </span>
            </li>
            <?php }?>
        <?php }else{ ?>
            <li>
                <span class="label">
                    <?php echo __('Price', 'traveler'); ?>
                </span>
                <span class="value">
                    <?php if($base_price) echo TravelHelper::format_money($base_price); else echo '0'; ?>
                </span>
            </li>
        <?php } ?>

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


        <?php if($check_extra): ?>
            <li>
                <span class="label"><?php echo __('Extra Price', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($extra_price); ?></span>
            </li>
        <?php endif; ?>

    <!--Package Amount-->
    <?php if(is_array($hotel_package) && count($hotel_package)): ?>
        <li>
                <span class="label"><?php echo __('Hotel Package', 'traveler'); ?></span>
            <span class="value"><?php echo TravelHelper::format_money($hotel_package_price); ?></span>
            </li>
        <?php endif; ?>
        <?php if(is_array($activity_package) && count($activity_package)): ?>
            <li>
                <span class="label"><?php echo __('Activity Package', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($activity_package_price); ?></span>
            </li>
        <?php endif; ?>
        <?php if(is_array($car_package) && count($car_package)): ?>
            <li>
                <span class="label"><?php echo __('Car Package', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($car_package_price); ?></span>
            </li>
        <?php endif; ?>
        <?php if(is_array($flight_package) && count($flight_package)): ?>
            <li>
                <span class="label"><?php echo __('Flight Package', 'traveler'); ?></span>
                <span class="value"><?php echo TravelHelper::format_money($flight_package_price); ?></span>
            </li>
        <?php endif; ?>
        <!--End Package amount-->
        <?php
        $total_price_origin = floatval($data_price['total_price_origin']);
            if(!empty($data_price['total_bulk_discount']) && $total_price_origin > $sale_price && floatval($data_price['total_bulk_discount']) > 0){
                ?>
                <li>
                    <span class="label"><?php echo __('Bulk Discount', 'traveler'); ?></span>
                    <span class="value"> - <?php echo TravelHelper::format_money(floatval($data_price['total_bulk_discount'])); ?></span>
                </li>
            <?php }
        ?>
        <li><span class="label"><?php echo __('Subtotal', 'traveler'); ?></span><span class="value"><?php echo TravelHelper::format_money($sale_price); ?></span></li>
        <?php if(STPrice::getTax() > 0){ ?>
            <li><span class="label"><?php echo __('Tax', 'traveler'); ?></span><span class="value"><?php echo STPrice::getTax().' %'; ?></span></li>
        <?php }?>

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
        <?php if($check_extra){
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
                                <?php echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_attr($number_item) . ' ' . __('Item(s)', 'traveler'); ?>
                                </span> <br/>
                            <?php endif;
                    endforeach;
                    ?>
            </li>
        <?php
        }

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

<?php
$date_format = TravelHelper::getDateFormat();
$woo_order_id = $order_data['order_item_id'];
$order = wc_get_order( $order_id );
?>
<div class="st_tab st_tab_order tabbable">
    <ul class="nav nav-tabs tab_order">
        <li class="active">
            <?php
            $post_type = get_post_type( $service_id );
            $obj = get_post_type_object( $post_type ); ?>
            <a data-toggle="tab" href="#tab-booking-detail" aria-expanded="true"> <?php echo sprintf(esc_html__("%s Details",'traveler'),$obj->labels->singular_name) ?></a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab-customer-detail" aria-expanded="false"> <?php esc_html_e("Customer Details",'traveler') ?></a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent973">
        <div id="tab-booking-detail" class="tab-pane fade active in">
            <div class="info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Booking ID",'traveler') ?>:  </strong>
                            #<?php echo esc_html($order_id) ?>
                        </div>
                    </div>
                    <?php
                    $payment_gateway =  wc_get_payment_gateway_by_order( $order_id );
                    if(isset($payment_gateway) && !empty($payment_gateway)){ ?>
                        <div class="col-md-6">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Payment Method: ",'traveler') ?> </strong>
                                <?php echo esc_html($payment_gateway->get_title());?>
                            </div>
                        </div>
                    <?php  } ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Order Date",'traveler') ?>:  </strong>
                            <?php echo esc_html(date_i18n($date_format, strtotime($order_data['created']))) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Booking Status",'traveler') ?>:  </strong>
                            <?php
                            $data_status =  STUser_f::_get_all_order_statuses();
                            $status = $order_data['status'];
                            $status_string = $data_status[$status];
                            if( isset( $order_data['cancel_refund_status'] ) && $order_data['cancel_refund_status'] == 'pending'){
                                $status_string = __('Cancelling', 'traveler');
                            }
                            ?>
                            <span class=""> <?php  echo esc_html($status_string); ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Car Name",'traveler') ?>:  </strong>
                            <a href="<?php echo get_the_permalink($service_id) ?>"><?php echo get_the_title($service_id) ?></a>
                        </div>
                    </div>

                    <?php if($pickup=wc_get_order_item_meta( $woo_order_id,'_st_pick_up',true)): ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Pick-up: ",'traveler') ?>:  </strong>
                                <?php  echo esc_html($pickup); ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if($drop_off=wc_get_order_item_meta( $woo_order_id,'_st_drop_off',true)): ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Drop-off: ",'traveler') ?>:  </strong>
                                <?php  echo esc_html($drop_off); ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php
                    $check_in =wc_get_order_item_meta( $woo_order_id,'_st_check_in',true);
                    $check_in_timestamp=wc_get_order_item_meta( $woo_order_id,'_st_check_in_timestamp',true);
                    $check_out=wc_get_order_item_meta( $woo_order_id,'_st_check_out',true);
                    $check_out_timestamp=wc_get_order_item_meta( $woo_order_id,'_st_check_out_timestamp',true);
                    ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Pick-up Time:",'traveler') ?> </strong>
                            <?php  echo @date_i18n($date_format.' '.get_option('time_format'),$check_in_timestamp)  ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Drop-off Time:",'traveler') ?> </strong>
                            <?php  echo @date_i18n($date_format.' '.get_option('time_format'),$check_out_timestamp)  ?>
                        </div>
                    </div>

                    <div class="line col-md-12"></div>
                    <div class="col-md-12">
                        <div class="item_booking_detail">
                            <?php $price = wc_get_order_item_meta($woo_order_id,'_st_item_price',true); ?>
                            <strong><?php esc_html_e("Car Price:",'traveler') ?> </strong>
                            <?php echo wc_price($price,array( 'currency' => $order->get_currency()))
                            ?> / <?php echo STCars::get_price_unit_by_unit_id(wc_get_order_item_meta($woo_order_id,'_st_duration_unit',true) , 'plural');
                            ?>
                        </div>
                    </div>
                    <?php
                    $car_title_sale_price = wc_get_order_item_meta($woo_order_id, '_st_car_title_sale_price', true);
                    if(isset($car_title_sale_price['title_price']) && !empty($car_title_sale_price['title_price'])){ ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php echo __('Price by number of day', 'traveler'); ?>:</strong>
                                <?php echo esc_html($car_title_sale_price['title_price']['title']); ?></span>
                                <span class="pull-right"> <?php echo wc_price($car_title_sale_price['title_price']['price'], array( 'currency' => $order->get_currency())) ;?>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php if(!empty($discount = wc_get_order_item_meta($woo_order_id , '_st_discount_rate' , true))) {?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Discount Rate:",'traveler') ?> </strong>
                                <?php echo esc_html($discount); ?> %
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    $selected_equipments = wc_get_order_item_meta($woo_order_id,'_st_data_equipment',true);
                    $price_equipment = wc_get_order_item_meta($woo_order_id,'_st_price_equipment',true);
                    ?>
                    <div class="col-md-6 <?php if(empty($price_equipment)) echo "hide"; ?>">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Equipment Price:",'traveler') ?> </strong>
                            <?php echo wc_price($price_equipment,array( 'currency' => $order->get_currency()))?>
                            <?php if(!empty($selected_equipments)){
                                ?>
                                <p><strong><?php _e("Equipments: ", 'traveler') ?></strong>
                                <ul>
                                    <?php foreach($selected_equipments as $equipment){
                                        if(!empty($equipment->number_item)){
                                            $price_unit='';
                                            echo "<li>".balanceTags($equipment->title .' ('. wc_price($equipment->price,array( 'currency' => $order->get_currency())));
                                            if( (int)$equipment->number_item < 2){
                                                $equipment->number_item = 1;
                                            }
                                            echo esc_html(' x'.(int)$equipment->number_item.')');
                                            echo "</li>";
                                        }
                                    } ?>
                                </ul>
                                </p>

                                <?php
                            } ?>
                        </div>
                    </div>
                    <?php echo st()->load_template('user/detail-booking-history/woo/detail-price',false,
                        array(
                            'order_data'=>$order_data,
                            'order_id'=>$order_id,
                            'service_id'=>$service_id,
                        )
                    ) ?>
                </div>
            </div>
        </div>
        <div id="tab-customer-detail" class="tab-pane fade">
            <div class="container-customer">
                <?php echo st()->load_template('user/detail-booking-history/woo/customer',false,array("order_id"=>$order_id)) ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <?php do_action("st_after_body_order_information_table",$order_data['order_item_id']); ?>
    <button data-dismiss="modal" class="btn btn-default" type="button"><?php esc_html_e("Close",'traveler') ?></button>
</div>

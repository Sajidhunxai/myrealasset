<?php
$date_format = TravelHelper::getDateFormat();
$woo_order_id = $order_data['order_item_id'];
$order = wc_get_order( $order_id );
$price_type = wc_get_order_item_meta( $woo_order_id, '_st_price_type', true );
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
                            <strong><?php esc_html_e("Tour Name",'traveler') ?>:  </strong>
                            <a href="<?php echo get_the_permalink($service_id) ?>"><?php echo get_the_title($service_id) ?></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Tour Type",'traveler') ?>:  </strong>
                            <?php
                            $tour_type = wc_get_order_item_meta( $woo_order_id, '_st_type_tour', true );
                            $tour_name = '';
                            if ( $tour_type == 'daily_tour' ) {
                                $tour_name = __( 'Daily Tour', 'traveler' );
                            } elseif ( $tour_type == 'specific_date' ) {
                                $tour_name = __( 'Specific Date', 'traveler' );
                            }
                            echo esc_html($tour_name);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Address: ",'traveler') ?>:  </strong>
                            <?php  echo get_post_meta( $service_id, 'address', true); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Departure date:",'traveler') ?> </strong>
                            <?php
                            $check_in = date( $date_format, $order_data['check_in_timestamp'] );
                            echo esc_html($check_in);
                            if($tour_type == 'daily_tour'){
    	                        echo ($order_data['starttime'] != '') ? ' - ' . esc_html($order_data['starttime'] ): '';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 <?php if ( $tour_type == 'daily_tour' ) echo 'hide'; ?>">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Return date:",'traveler') ?> </strong>
                            <?php
                            $check_out = date( $date_format, $order_data['check_out_timestamp'] );
                            echo esc_html($check_out . ($order_data['starttime'] != '' ? ' - ' . $order_data['starttime'] : ''));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 <?php if ( $tour_type != 'daily_tour' ) echo 'hide'; ?>">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Duration:",'traveler') ?> </strong>
                            <?php
                            echo wc_get_order_item_meta( $woo_order_id, '_st_duration', true );
                            ?>
                        </div>
                    </div>
                    <div class="line col-md-12"></div>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("No. Adults :",'traveler') ?> </strong>
                            <?php echo wc_get_order_item_meta( $woo_order_id, '_st_adult_number', true ); ?>
                        </div>
                    </div>
                    <?php if($price_type == 'person'): ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Adult Price :",'traveler') ?> </strong>
                            <?php $adult_price =  wc_get_order_item_meta( $woo_order_id, '_st_adult_price', true ); ?>
                            <?php echo wc_price($adult_price,array( 'currency' => $order->get_currency())) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("No. Children :",'traveler') ?> </strong>
                            <?php echo wc_get_order_item_meta( $woo_order_id, '_st_child_number', true ); ?>
                        </div>
                    </div>
	                <?php if($price_type == 'person'): ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Children Price :",'traveler') ?> </strong>
                            <?php $child_price =  wc_get_order_item_meta( $woo_order_id, '_st_child_price', true ); ?>
                            <?php echo wc_price($child_price,array( 'currency' => $order->get_currency())) ?>
                        </div>
                    </div>
	                <?php endif; ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("No. Infant :",'traveler') ?> </strong>
                            <?php echo wc_get_order_item_meta( $woo_order_id, '_st_infant_number', true ); ?>
                        </div>
                    </div>
	                <?php if($price_type == 'person'): ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Infant Price :",'traveler') ?> </strong>
                            <?php $infant_price =  wc_get_order_item_meta( $woo_order_id, '_st_infant_price', true ); ?>
                            <?php echo wc_price($infant_price,array( 'currency' => $order->get_currency())) ?>
                        </div>
                    </div>
	                <?php endif; ?>
	                <?php if($price_type == 'fixed'): ?>
                        <div class="col-md-6">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Base Price :",'traveler') ?> </strong>
    			                <?php $base_price =  wc_get_order_item_meta( $woo_order_id, '_st_base_price', true ); ?>
    			                <?php echo wc_price($base_price,array( 'currency' => $order->get_currency())) ?>
                            </div>
                        </div>
	                <?php endif; ?>
                     <?php if(!empty(st_print_order_item_guest_name(json_decode($order_data['raw_data'],true)))){?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <?php st_print_order_item_guest_name(json_decode($order_data['raw_data'],true)) ?>
                            </div>
                        </div>
                    <?php
                    }
                    $extra_price = wc_get_order_item_meta( $woo_order_id, '_st_extra_price', true );
                    $extras      = wc_get_order_item_meta( $woo_order_id, '_st_extras', true );
                    $data_extra = [];
                    if ( isset( $extras[ 'value' ] ) && is_array( $extras[ 'value' ] ) && count( $extras[ 'value' ] ) ) {
                        foreach ( $extras[ 'value' ] as $name => $number ) {
                            if(!empty($extras[ 'value' ][ $name ])){
                                $data_extra[ $name ] = array(
                                    'title'=>$extras[ 'title' ][ $name ],
                                    'price'=>$extras[ 'price' ][ $name ],
                                    'value'=>$extras[ 'value' ][ $name ],
                                );
                            }
                        }
                    }
                    ?>
                    <div class="col-md-6 <?php if(empty($extra_price)) echo "hide"; ?>">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Extra Price:",'traveler') ?> </strong>
                            <?php echo wc_price($extra_price,array( 'currency' => $order->get_currency())) ?>
                            <?php if ( is_array( $data_extra ) && count( $extras ) ){ ?>
                                <table class="table mt10 mb10" style="table-layout: fixed;" width="200">
                                    <tr>
                                        <td>
                                            <label>
                                                <strong><?php esc_html_e("Name Extra",'traveler') ?></strong>
                                            </label>
                                        </td>
                                        <td width="40%">
                                            <strong><?php esc_html_e("Price",'traveler') ?></strong>
                                        </td>
                                    </tr>
                                    <?php foreach ( $data_extra as $key => $val ):
                                        $price = $val[ 'value' ] * $val[ 'price' ];
                                        ?>
                                        <tr>
                                            <td>
                                                <label>
                                                    <?php echo esc_html($val[ 'title' ]); ?>
                                                </label>
                                            </td>
                                            <td width="40%">
                                                <?php echo wc_price($price,array( 'currency' => $order->get_currency())) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php }else{ echo 0 ;} ?>
                        </div>
                    </div>
                    <!-- Tour Package -->
                    <?php
                    $hotel_package = wc_get_order_item_meta( $woo_order_id, '_st_package_hotel', true );
                    $hotel_price_package      = wc_get_order_item_meta( $woo_order_id, '_st_package_hotel_price', true );
                    ?>
                    <div class="col-md-6 <?php if(empty($hotel_package)) echo "hide"; ?>">
                        <strong><?php esc_html_e("Hotel Package:",'traveler') ?> </strong>
                        <?php echo wc_price($hotel_price_package,array( 'currency' => $order->get_currency())) ?>
                        <?php if ( is_array( $hotel_package ) && count( $hotel_package ) ){ ?>
                            <table class="table mt10 mb10" style="table-layout: fixed;" width="200">
                                <tr>
                                    <td>
                                        <label>
                                            <strong><?php esc_html_e("Hotel Name",'traveler') ?></strong>
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <strong><?php esc_html_e("Price",'traveler') ?></strong>
                                    </td>
                                </tr>
                                <?php foreach ( $hotel_package as $key => $val ):
                                    $price = $val->hotel_price;
                                    ?>
                                    <tr>
                                        <td>
                                            <label>
                                                <?php echo esc_html($val->hotel_name); ?>
                                            </label>
                                        </td>
                                        <td width="40%">
                                            <?php echo wc_price($price,array( 'currency' => $order->get_currency())) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php }else{ echo 0 ;} ?>
                    </div>

                    <?php
                    $activity_package = wc_get_order_item_meta( $woo_order_id, '_st_package_activity', true );
                    $activity_price_package      = wc_get_order_item_meta( $woo_order_id, '_st_package_activity_price', true );
                    ?>
                    <div class="col-md-6 <?php if(empty($activity_package)) echo "hide"; ?>">
                        <strong><?php esc_html_e("Activity Package:",'traveler') ?> </strong>
                        <?php echo wc_price($activity_price_package,array( 'currency' => $order->get_currency())) ?>
                        <?php if ( is_array( $activity_package ) && count( $activity_package ) ){ ?>
                            <table class="table mt10 mb10" style="table-layout: fixed;" width="200">
                                <tr>
                                    <td>
                                        <label>
                                            <strong><?php esc_html_e("Activity Name",'traveler') ?></strong>
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <strong><?php esc_html_e("Price",'traveler') ?></strong>
                                    </td>
                                </tr>
                                <?php foreach ( $activity_package as $key => $val ):
                                    $price = $val->activity_price;
                                    ?>
                                    <tr>
                                        <td>
                                            <label>
                                                <?php echo esc_html($val->activity_name); ?>
                                            </label>
                                        </td>
                                        <td width="40%">
                                            <?php echo wc_price($price,array( 'currency' => $order->get_currency())) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php }else{ echo 0 ;} ?>
                    </div>

                    <?php
                    $car_package = wc_get_order_item_meta( $woo_order_id, '_st_package_car', true );
                    $car_price_package      = wc_get_order_item_meta( $woo_order_id, '_st_package_car_price', true );
                    ?>
                    <div class="col-md-6 <?php if(empty($car_package)) echo "hide"; ?>">
                        <strong><?php esc_html_e("Car Package:",'traveler') ?> </strong>
                        <?php echo wc_price($car_price_package,array( 'currency' => $order->get_currency())) ?>
                        <?php if ( is_array( $car_package ) && count( $car_package ) ){ ?>
                            <table class="table mt10 mb10" style="table-layout: fixed;" width="200">
                                <tr>
                                    <td>
                                        <label>
                                            <strong><?php esc_html_e("Car Name",'traveler') ?></strong>
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <strong><?php esc_html_e("Price",'traveler') ?></strong>
                                    </td>
                                </tr>
                                <?php foreach ( $car_package as $key => $val ):
                                    $price = $val->car_price;
                                    ?>
                                    <tr>
                                        <td>
                                            <label>
                                                <?php echo esc_html($val->car_name); ?>
                                            </label>
                                        </td>
                                        <td width="40%">
                                            <?php echo esc_html($val->car_quantity) . ' x ' . wc_price($price,array( 'currency' => $order->get_currency())) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php }else{ echo 0 ;} ?>
                    </div>
                    <!-- End Tour Package -->
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

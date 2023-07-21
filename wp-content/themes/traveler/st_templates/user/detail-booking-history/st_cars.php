<?php
$currency = get_post_meta( $order_id, 'currency', true );
$data_prices = get_post_meta( $order_id, 'data_prices', true );

$order_data = STUser_f::get_booking_meta($order_id);
$date_format = TravelHelper::getDateFormat();
$time_format = get_option('time_format');
if (empty($time_format))
    $time_format = 'H:i A';
$price = get_post_meta($order_id,'item_price',true);
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
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Payment Method: ",'traveler') ?> </strong>
                            <?php echo STPaymentGateways::get_gatewayname(get_post_meta($order_id, 'payment_method', true)); ?>
                        </div>
                    </div>
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
                            if(!empty($status_string = $data_status[$status])){
                                //$status_string = $data_status[$status];
    	                        $status_string = $data_status[get_post_meta($order_id, 'status', true)];
                                if( isset( $order_data['cancel_refund_status'] ) && $order_data['cancel_refund_status'] == 'pending'){
                                    $status_string = __('Cancelling', 'traveler');
                                }
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

                    <?php if($pickup=get_post_meta($order_id,'pick_up',true)): ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Pick-up: ",'traveler') ?>:  </strong>
                                <?php  echo esc_html($pickup); ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if($drop_off=get_post_meta($order_id,'drop_off',true)): ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Drop-off: ",'traveler') ?>:  </strong>
                                <?php  echo esc_html($drop_off); ?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php
                    $check_in =get_post_meta($order_id,'check_in',true);
                    $check_in_timestamp=get_post_meta($order_id,'check_in_timestamp',true);
                    $check_out=get_post_meta($order_id,'check_out',true);
                    $check_out_timestamp=get_post_meta($order_id,'check_out_timestamp',true);

                    $date_diff = STCars::get_date_diff($check_in_timestamp, $check_out_timestamp);
                    ?>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Pick-up Time:",'traveler') ?> </strong>
                            <?php  echo esc_html(@date_i18n($date_format.' '.$time_format,$check_in_timestamp))  ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Drop-off Time:",'traveler') ?> </strong>
                            <?php  echo esc_html(@date_i18n($date_format.' '.$time_format,$check_out_timestamp))  ?>
                        </div>
                    </div>
                    <?php if($name = get_post_meta($order_id,'driver_name',true)): ?>
                        <div class="col-md-6">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Driver’s Name:",'traveler') ?> </strong>
                                <?php  echo esc_html($name)  ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if($name_g = get_post_meta($order_id,'driver_age',true)): ?>
                        <div class="col-md-6">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Driver’s Age:",'traveler') ?> </strong>
                                <?php  echo esc_html($name_g)  ?>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="col-md-12"><?php st_print_order_item_guest_name(json_decode($order_data['raw_data'],true)) ?></div>
                    <div class="line col-md-12"></div>
                    <div class="col-md-12">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Car Price:",'traveler') ?> </strong>
                            <?php echo TravelHelper::format_money_from_db($price,$currency);
                            ?> / <?php echo STCars::get_price_unit_by_unit_id($data_prices['unit'] , 'plural');
                            ?>
                        </div>
                    </div>
                    <?php
                    $car_title_sale_price = get_post_meta($order_id, 'car_title_sale_price', true);
                    if(isset($car_title_sale_price['title_price']) && !empty($car_title_sale_price['title_price'])){ ?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php echo __('Price by number of day', 'traveler'); ?>:</strong>
                                <?php echo esc_html($car_title_sale_price['title_price']['title']); ?></span><span class="pull-right"> <?php echo TravelHelper::format_money($car_title_sale_price['title_price']['price']) ;?>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php if(!empty($discount = get_post_meta($order_id , 'discount_rate' , true))) {?>
                        <div class="col-md-12">
                            <div class="item_booking_detail">
                                <strong><?php esc_html_e("Discount Rate:",'traveler') ?> </strong>
                                <?php echo esc_html($discount); ?> %
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    $selected_equipments = get_post_meta($order_id,'data_equipment',true);
                    $price_equipment = get_post_meta($order_id,'price_equipment',true);
                    ?>
                    <div class="col-md-6 <?php if(empty($price_equipment)) echo "hide"; ?>">
                        <div class="item_booking_detail">
                            <strong><?php esc_html_e("Equipment Price:",'traveler') ?> </strong>
                            <?php echo TravelHelper::format_money_from_db($price_equipment ,$currency);
                            $items = ST_Order_Item_Model::getOrderByID($order_id);
                            //foreach ($item[0]['raw_data'] as $key => $value) {
                            $data_equipment = json_decode($items[0]['raw_data'])->data_equipment;
                            $numberday  = json_decode($items[0]['raw_data'])->numberday ;
                                /*Price*/

                               // var_dump($data_equipment->value);

                                foreach($data_equipment->value as $key => $price_data_equipment){
                                    $value_infor[] = $price_data_equipment;
                                }
                                foreach($data_equipment->title as $key => $title_data_equipment){
                                    $title_infor[] = $title_data_equipment;
                                }
                                foreach($data_equipment->price as $key => $price_data_equipment){
                                    $price_infor[] = $price_data_equipment;
                                }
                                foreach($data_equipment->price_type as $key => $price_data_equipment){
                                    $price_type_infor[] = $price_data_equipment;
                                }
                                $data_equipment_infor = array();
                                foreach ($value_infor as $key => $in) {
                                    $list = array(
                                        'number_item' => $in,
                                        'price' => $price_infor[$key],
                                        'title' => $title_infor[$key],
                                        'price_type' => $price_type_infor[$key],
                                        );
                                    array_push($data_equipment_infor, $list);
                                }

                                /*Title*/
                                // foreach ($data_equipment as $key => $title) {
                                //     $title_data_equipments = $title->title;
                                // }
                                // foreach($title_data_equipments as $title_data_equipment){
                                //     $title_equipment[] = $title_data_equipment;
                                // }
                                // $infor_equipments = array();
                                // for($i=0; $i<$count_value ; $i++){
                                //     $infor_eq = array(
                                //         'title' => $title_equipment[$i++],
                                //         'price' => $price_equipment[$i++],
                                //     );
                                //     array_push($infor_equipments, $infor_eq);
                                // }
                                //var_dump($data_equipment['value']);


                            //}
                            ?>

                            <?php if(!empty($data_equipment_infor) && isset($data_equipment_infor)){
                                ?>
                                <p><strong><?php _e("Equipments: ", 'traveler') ?></strong>
                                <ul>
                                    <?php foreach($data_equipment_infor as $equipment){
                                        $price_unit='';
                                        echo "<li>".$equipment['title'] .' ('. esc_html(TravelHelper::format_money_from_db($equipment["price"] ,$currency));
                                        if( (int)$equipment["number_item"] < 2){
                                            $equipment["number_item"] = 1;
                                        }
                                        if($equipment["price_type"] == 'fixed'){
                                            echo esc_html(' x'.(int)$equipment["number_item"].')');
                                        }else{
                                            echo esc_html(' x'.(int)$equipment["number_item"].')'.' x'.$date_diff).' '.__('Days','traveler') ;
                                        }
                                        echo "</li>";
                                    } ?>
                                </ul>
                                </p>

                                <?php
                            } ?>
                        </div>
                    </div>
                    <?php echo st()->load_template('user/detail-booking-history/detail-price-car',false,
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
                <?php echo apply_filters( 'st_customer_info_booking_history', st()->load_template('user/detail-booking-history/customer',false,array("order_id"=>$order_id)),$order_id ); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?php do_action("st_after_body_order_information_table",$order_id); ?>
    <button data-dismiss="modal" class="btn btn-default" type="button"><?php esc_html_e("Close",'traveler') ?></button>
</div>

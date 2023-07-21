<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 5/13/2019
 * Time: 10:04 AM
 */
$hotel_package = get_post_meta(get_the_ID(), 'tour_packages', true);
$hotel_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom', true);
$activity_package = get_post_meta(get_the_ID(), 'tour_packages_activity', true);
$activity_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_activity', true);
$car_package = get_post_meta(get_the_ID(), 'tour_packages_car', true);
$car_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_car', true);
$flight_package = get_post_meta(get_the_ID(), 'tour_packages_flight', true);
$flight_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_flight', true);
$tour_package_service_with = st()->get_option( 'tour_package_service_with', __('Hotel, Car...','traveler') );

$has_tour_package = STTour::get_instance()->checkHasTourPackage($hotel_package, $hotel_package_custom, $activity_package, $activity_package_custom, $car_package, $car_package_custom, $flight_package, $flight_package_custom);

$iCheck = false;


if ($has_tour_package) {
    ?>
    <div class="form-group form-date-search st-form-package clearfix" href="#st-package-popup" data-effect="mfp-zoom-in">
        <div class="date-wrapper clearfix">
            <div class="check-in-wrapper">
                <label><?php echo __('Package', 'traveler'); ?></label>
                <div class="render check-in-render"><?php echo sprintf(__( '%s', 'traveler' ),$tour_package_service_with); ?></div>
            </div>
        </div>
    </div>

    <div class="white-popup mfp-with-anim mfp-hide st-package-popup" id="st-package-popup">
        <div class="st-faq">
            <h3 class="st-section-title">
                <?php echo __('Tour Packages', 'traveler'); ?>
            </h3>
            <!--Hotel Package-->
            <?php if (st_check_service_available("st_hotel") && STTour::_check_empty_package($hotel_package, $hotel_package_custom)) {
                $hotel_selected = STInput::post('hotel_package', '');
                $hotel_ids_selected = TravelHelper::get_ids_selected_tour_package($hotel_selected, 'hotel');
                ?>
                <?php if((is_object($hotel_package) && (!empty((array)$hotel_package))) || (is_object($hotel_package_custom) && (!empty((array)$hotel_package_custom)))){ ?>
                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                    <div class="header">
                        <h5><?php echo __('Select Hotel Package', 'traveler'); ?></h5>
                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                    </div>
                    <div class="body">
                        
                            <?php if (!empty((array)$hotel_package)) { ?>
                                <ul class="item-inner hotel">
                                <?php foreach ($hotel_package as $key => $val): ?>
                                    <li>
                                        <?php
                                        $hotel_package_data = new stdClass();
                                        $hotel_package_data->hotel_name = trim(get_the_title($val->hotel_id));
                                        $hotel_package_data->hotel_price = $val->hotel_price;
                                        $hotel_package_data->hotel_star = STHotel::getStar($val->hotel_id);
                                        ?>
                                        <div class="checkbox-item">
                                            
                                            <label for="field-<?php echo esc_attr($val->hotel_id); ?>">
                                                <?php echo get_the_title($val->hotel_id) . ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                <?php
                                                $star = STHotel::getStar($val->hotel_id);
                                                echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                echo TravelHelper::rate_to_string($star);
                                                echo '</ul>';
                                                ?>
                                            </label>
                                        </div>
                                        <div class="select-wrapper">
                                            <div class="caculator-item">
                                                <i class="fa fa-minus"></i>
                                                    <input class="form-control app extra-service-select" id="field_qty_<?php echo esc_attr($val->hotel_id); ?>" type="input" value="0" name="hotel_package[<?php echo '_qty_'.esc_attr($val->hotel_id); ?>][]" step="1"  min="0">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
                                        <input id="field-<?php echo esc_attr($val->hotel_id); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" name="hotel_package[<?php echo esc_attr($val->hotel_id); ?>][]">
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                        <?php
                            }
                        ?>
                        <?php if(is_object($hotel_package_custom)){ ?>
                            <?php if (!empty((array)$hotel_package_custom)) { ?>
                                <ul class="item-inner hotel">
                                    <?php foreach ($hotel_package_custom as $key => $val): 
                                        if(!empty($val->hotel_name)) :
                                        ?>
                                        <li>
                                            <?php
                                            $hotel_package_data = new stdClass();
                                            $hotel_package_data->hotel_name = trim($val->hotel_name);
                                            $hotel_package_data->hotel_price = $val->hotel_price;
                                            $hotel_package_data->hotel_star = $val->hotel_star;
                                            ?>
                                            <div class="checkbox-item">
                                                <label for="hotel-custom-<?php echo esc_attr($key); ?>">
                                                    <?php echo esc_html($val->hotel_name) . ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                    <?php
                                                    $star = $val->hotel_star;
                                                    echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                    echo TravelHelper::rate_to_string($star);
                                                    echo '</ul>';
                                                    ?>
                                                </label>
                                            </div>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="hotel-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="text" value="0" name="hotel_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                            <input id="hotel-custom-<?php echo 'custom_' . esc_attr($key); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" name="hotel_package[<?php echo 'custom_' . esc_attr($key); ?>][]" <?php echo in_array('custom_' . $key, $hotel_ids_selected) ? 'checked': ''; ?>>
                                        </li>
                                    <?php 
                                        endif;
                                    endforeach; ?>
                                </ul>
                            <?php } } ?>
                    </div>
                </div>
            <?php } $iCheck = true; } ?>
            <!--End Hotel Package-->

            <!--Activity package-->
            <?php if (st_check_service_available("st_activity") && STTour::_check_empty_package($activity_package, $activity_package_custom)) {
                $activity_selected = STInput::post('activity_package', '');
                $activity_ids_selected = TravelHelper::get_ids_selected_tour_package($activity_selected, 'hotel');
                ?>
                <?php if((is_object($activity_package) && (!empty((array)$activity_package))) || (is_object($activity_package_custom) && (!empty((array)$activity_package_custom)))){ ?>
                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                    <div class="header">
                        <h5><?php echo __('Select Activity Package', 'traveler'); ?></h5>
                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                    </div>
                    <div class="body">
                            <?php if (!empty((array)$activity_package)) { ?>
                                <ul class="item-inner">
                                    <?php foreach ($activity_package as $key => $val): ?>
                                        <li>
                                            <?php
                                            $activity_package_data = new stdClass();
                                            $activity_package_data->activity_name = trim(get_the_title($val->activity_id));
                                            $activity_package_data->activity_price = $val->activity_price;
                                            ?>
                                            <div class="checkbox-item">
                                                
                                                <label for="field-<?php echo esc_attr($val->activity_id); ?>">
                                                    <?php echo get_the_title($val->activity_id) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                </label>
                                            </div>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="field_qty_<?php echo esc_attr($val->activity_id); ?>" type="input" value="0" name="activity_package[<?php echo '_qty_'.esc_attr($val->activity_id); ?>][]" step="1"  min="0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                            <input id="field-<?php echo esc_attr($val->activity_id); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" name="activity_package[<?php echo esc_attr($val->activity_id); ?>][]">
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php
                            }
                        ?>
                        <?php if(is_object($activity_package_custom)){ ?>
                            <?php if (!empty((array)$activity_package_custom)) { ?>
                                <ul class="item-inner">
                                    <?php foreach ($activity_package_custom as $key => $val): 
                                        if(!empty($val->activity_name)) :
                                        ?>
                                        <li>
                                            <?php
                                            $activity_package_data = new stdClass();
                                            $activity_package_data->activity_name = trim($val->activity_name);
                                            $activity_package_data->activity_price = $val->activity_price;
                                            ?>
                                            <div class="checkbox-item">
                                                <label for="activity-custom-<?php echo esc_attr($key); ?>">
                                                    <?php echo esc_attr($val->activity_name) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                </label>
                                            </div>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="activity-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="text" value="0" name="activity_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                            <input id="activity-custom-<?php echo 'custom_' . esc_attr($key); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" name="activity_package[<?php echo 'custom_' . esc_attr($key); ?>][]" <?php echo in_array('custom_' . $key, $activity_ids_selected) ? 'checked': ''; ?>>
                                        </li>
                                    <?php endif;  endforeach; ?>
                                </ul>
                            <?php } } ?>
                    </div>
                </div>
            <?php } $iCheck = true;} ?>
            <!--End Activity package-->

            <!--Car Package-->
            <?php if (st_check_service_available("st_cars") && STTour::_check_empty_package($car_package, $car_package_custom)) {
                $car_selected = STInput::post('car_quantity', '');
                $car_ids_selected = TravelHelper::get_ids_selected_tour_package($car_selected, 'car');
                ?>
                <?php if((is_object($car_package) && (!empty((array)$car_package))) || (is_object($car_package_custom) && (!empty((array)$car_package_custom)))){ ?>
                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                    <div class="header">
                        <h5><?php echo __('Select Car Package', 'traveler'); ?></h5>
                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                    </div>
                    <div class="body">
                        <?php if(is_object($car_package)){ ?>
                            <?php if (!empty((array)$car_package)) { ?>
                                <ul class="item-inner car">
                                    <?php foreach ($car_package as $key => $val): ?>
                                        <li>
                                            <label for="field-<?php echo esc_attr($val->car_id); ?>"><?php echo get_the_title($val->car_id) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?></label>
                                            <input type="hidden" name="car_name[<?php echo esc_attr($val->car_id); ?>][]"
                                                   value="<?php echo trim(get_the_title($val->car_id)); ?>"/>
                                            <input type="hidden" name="car_price[<?php echo esc_attr($val->car_id); ?>][]"
                                                   value="<?php echo esc_attr($val->car_price); ?>"/>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="car_field_qty_<?php echo esc_attr($val->car_id); ?>" type="input" value="0" name="car_quantity[<?php echo esc_attr($val->car_id); ?>][]" step="1"  min="0" <?php if(!empty($car_quantity)){?> max="<?php echo esc_attr($car_quantity);?>" <?php }?>>
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php
                            }
                        }
                        ?>
                        <?php if(is_object($car_package_custom)){ ?>
                            <?php if (!empty((array)$car_package_custom)) { ?>
                                <ul class="item-inner car">
                                    <?php foreach ($car_package_custom as $key => $val): ?>
                                        <li>
                                            <label for="car-custom-<?php echo esc_attr($key); ?>"><?php echo esc_html($val->car_name) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?></label>
                                            <input type="hidden" name="car_name[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                   value="<?php echo esc_attr($val->car_name); ?>"/>
                                            <input type="hidden" name="car_price[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                   value="<?php echo esc_attr($val->car_price); ?>"/>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="car_field_qty_<?php echo esc_attr($val->car_id); ?>" type="input" value="0" name="car_quantity[<?php echo 'custom_' . esc_attr($key); ?>][]" step="1"  min="0" <?php if(!empty($car_quantity)){?> max="<?php echo esc_attr($car_quantity);?>" <?php }?>>
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php } } ?>
                    </div>
                </div>
                <?php } $iCheck = true;} ?>
            <!--End Car Package-->

            <!--Flight Package-->
            <?php if (st_check_service_available("st_flight") && STTour::_check_empty_package($flight_package, $flight_package_custom)) {
                $flight_selected = STInput::post('flight_package', '');
                $flight_ids_selected = TravelHelper::get_ids_selected_tour_package($flight_selected, 'flight');
                ?>
                <?php if((is_object($flight_package) && (!empty((array)$flight_package))) || (is_object($flight_package_custom) && (!empty((array)$flight_package_custom)))){ ?>
                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                    <div class="header">
                        <h5><?php echo __('Select Flight Package', 'traveler'); ?></h5>
                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                    </div>
                    <div class="body">
                        <?php if(is_object($flight_package)){ ?>
                            <?php if (!empty((array)$flight_package)) { ?>
                                <ul class="item-inner flight">
                                    <?php foreach ($flight_package as $key => $val): ?>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php
                                                    $flight_package_data = new stdClass();

                                                    $flight_id = $val->flight_id;

                                                    $origin_iata = '';
                                                    $origin_name = '';
                                                    $destination_iata = '';
                                                    $destination_name = '';

                                                    $origin_id = get_post_meta($flight_id, 'origin', true);

                                                    if(!empty($origin_id) && $origin_id > 0){
                                                        $origin = get_term($origin_id, 'st_airport');
                                                        if(is_object($origin)){
                                                            $origin_iata = get_tax_meta($origin->term_id, 'iata_airport', true);
                                                            $origin_name = $origin->name;
                                                        }
                                                    }

                                                    $destination_id = get_post_meta($flight_id, 'destination', true);
                                                    if(!empty($destination_id) && $destination_id > 0){
                                                        $destination = get_term($destination_id, 'st_airport');
                                                        if(is_object($destination)){
                                                            $destination_iata = get_tax_meta($destination->term_id, 'iata_airport', true);
                                                            $destination_name = $destination->name;
                                                        }
                                                    }

                                                    $origin_res = '';
                                                    if(empty($origin_iata) and empty($origin_name)){
                                                        $origin_res = '—';
                                                    }else{
                                                        $origin_res = $origin_name . ' ('. $origin_iata .')';
                                                    }

                                                    $destination_res = '';
                                                    if(empty($destination_iata) and empty($destination_name)){
                                                        $destination_res = '—';
                                                    }else{
                                                        $destination_res = $destination_name . ' ('. $destination_iata .')';
                                                    }

                                                    $depart_time = get_post_meta($flight_id, 'departure_time', true);
                                                    $total_time = get_post_meta($flight_id, 'total_time', true);
                                                    if(isset( $total_time) && !empty( $total_time)){
                                                        $total_time_str = $total_time['hour'] . 'h' . $total_time['minute'] . 'm';
                                                    } else {
                                                        $total_time_str = "";
                                                    }


                                                    $flight_package_data->flight_origin = $origin_res;
                                                    $flight_package_data->flight_destination = $destination_res;
                                                    $flight_package_data->flight_departure_time = $depart_time;
                                                    $flight_package_data->flight_duration = $total_time_str;

                                                    $flight_package_data->flight_price_economy = $val->flight_price_economy;
                                                    $flight_package_data->flight_price_business = $val->flight_price_business;

                                                    $flight_package_data_economy = $flight_package_data_business = $flight_package_data;
                                                    ?>
                                                  <?php echo esc_html($origin_res) . ' <i class="fa fa-long-arrow-right"></i> ' . esc_html($destination_res); ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <b><?php echo __('Departure time', 'traveler') ?>:</b> <?php echo esc_html($depart_time); ?><br />
                                                    <b><?php echo __('Duration', 'traveler') ?>:</b> <?php echo esc_html($total_time_str); ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php $flight_package_data_economy->flight_price_type = 'economy'; ?>
                                                    <label class="ml20 mb10">
                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($flight_id); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_economy)); ?>" checked />
                                                        <span class="mt2 d-i-b">
                                                            <?php echo __('Economy', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_economy); ?>)
                                                        </span>
                                                    </label>
                                                    <?php $flight_package_data_business->flight_price_type = 'business'; ?>
                                                    <label class="ml20">
                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($flight_id); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_business)); ?>" />
                                                        <span class="mt2 d-i-b">
                                                            <?php echo __('Business', 'traveler'); ?>
                                                            (<?php echo TravelHelper::format_money($val->flight_price_business); ?>)
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="flight-<?php echo 'qty_' . esc_attr($key); ?>" type="input" value="0" name="flight_package[<?php echo '_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php
                            }
                        }
                        ?>
                        <?php if(is_object($flight_package_custom)){ ?>
                            <?php if (!empty((array)$flight_package_custom)) { ?>
                                <ul class="item-inner flight">
                                    <?php foreach ($flight_package_custom as $key => $val):
                                        if(!empty($val->flight_origin)) :
                                        ?>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php
                                                    $flight_package_data = new stdClass();

                                                    $flight_package_data->flight_origin = $val->flight_origin;
                                                    $flight_package_data->flight_destination = $val->flight_destination;
                                                    $flight_package_data->flight_departure_time = $val->flight_departure_time;
                                                    $flight_package_data->flight_duration = $val->flight_duration;
                                                    $flight_package_data->flight_price_economy = $val->flight_price_economy;
                                                    $flight_package_data->flight_price_business = $val->flight_price_business;
                                                    $flight_package_data_economy = $flight_package_data_business = $flight_package_data;
                                                    ?>
                                                    <?php echo esc_html($val->flight_origin) . ' <i class="fa fa-long-arrow-right"></i> ' . esc_html($val->flight_destination); ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <b><?php echo __('Departure time', 'traveler') ?>:</b> <?php echo esc_html($val->flight_departure_time); ?><br />
                                                    <b><?php echo __('Duration', 'traveler') ?>:</b> <?php echo esc_html($val->flight_duration); ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php $flight_package_data_economy->flight_price_type = 'economy'; ?>
                                                    <label class="ml20 mb10">
                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_economy)); ?>" checked/>
                                                        <span class="mt2 d-i-b">
                                                            <?php echo __('Economy', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_economy); ?>)
                                                        </span>
                                                    </label>
                                                    <?php $flight_package_data_business->flight_price_type = 'business'; ?>
                                                    <label class="ml20">
                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_business)); ?>"/>
                                                        <span class="mt2 d-i-b">
                                                            <?php echo __('Business', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_business); ?>)
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="select-wrapper">
                                                <div class="caculator-item">
                                                    <i class="fa fa-minus"></i>
                                                        <input class="form-control app extra-service-select" id="flight-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="input" value="0" name="flight_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            <?php } } ?>
                    </div>
                </div>
                <?php } $iCheck = true;} ?>
            <!--End Flight Package-->
        </div>
    </div>
    <?php
}

<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 19-11-2018
     * Time: 8:56 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    $extra_price = get_post_meta( get_the_ID(), 'extra_price', true );
    //Package Solo
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
    $extra = STInput::get( 'extra' );
    if ( empty( $extra ) ) {
        $extra = [];
    }
    if ( !empty( $extra[ 'value' ] ) ) {
        $extra_value = $extra[ 'value' ];
    }

?>
<?php
if (($has_tour_package && !empty($extra_price)) || ($has_tour_package && empty($extra_price)) || ($has_tour_package == false && !empty($extra_price))) { ?>
    <div class="form-more-extra-solo">
        <div class="button-extra">
            <a href="#dropdown-more-extra" class="dropdown-more-extra"  data-bs-toggle="collapse" >
                <span>
                <?php
                    if($has_tour_package != false){
                        echo esc_html__( 'Packages', 'traveler' ) ;
                    }
                    if($has_tour_package  && !empty($extra_price)){
                        echo esc_html__( '-', 'traveler' ) ;
                    }
                    if(!empty($extra_price)){
                        echo esc_html__( 'Extras', 'traveler' );
                    }
                    
                    
                ?>
                </span>
                
                <i class="fa fa-angle-down arrow"></i>
            </a>

        </div>

        <ul id="dropdown-more-extra" class="dropdown-menu extras collapse"  class="collapse">

            <?php
            //Package solo
            if ($has_tour_package != false) {?>
                <li>
                    <span class="name-extra-title"><?php echo __('Package','traveler');?></span>
                </li>
                <div class="st-package-popup-solo">

                    <div class="st-faq">
                        <!--Hotel Package-->
                        <?php
                        if ( st_check_service_available('st_hotel') && STTour::_check_empty_package($hotel_package, $hotel_package_custom)) {
                            $hotel_selected = STInput::post('hotel_package', '');
                            $hotel_ids_selected = TravelHelper::get_ids_selected_tour_package($hotel_selected, 'hotel');
                            if((is_object($hotel_package) && (!empty((array)$hotel_package))) || (is_object($hotel_package_custom) && (!empty((array)$hotel_package_custom)))){ ?>
                                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                                    <div class="header">
                                        <h5><?php echo __('Select Hotel Package', 'traveler'); ?></h5>
                                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                                    </div>
                                    <div class="body">
                                        <?php if(is_object($hotel_package)){ ?>
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
                                                        <div class="st-flex space-between">
                                                            <div class="solo-package">
                                                                <span class="title-extra">
                                                                    <?php echo get_the_title($val->hotel_id) . ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                                </span>
                                                                <div class="extra-price-item">
                                                                    <label for="field-<?php echo esc_attr($val->hotel_id); ?>">
                                                                        <?php
                                                                        $star = STHotel::getStar($val->hotel_id);
                                                                        echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                                        echo TravelHelper::rate_to_string($star);
                                                                        echo '</ul>';
                                                                        ?>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="select-wrapper" style="width: 88px;">
                                                                <div class="caculator-item">
                                                                    <i class="fa fa-minus"></i>
                                                                        <input class="form-control app extra-service-select" id="field_qty_<?php echo esc_attr($val->hotel_id); ?>" type="input" value="0" name="hotel_package[<?php echo '_qty_'.esc_attr($val->hotel_id); ?>][]" step="1"  min="0">
                                                                    <i class="fa fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input id="field-<?php echo esc_attr($val->hotel_id); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" name="hotel_package[<?php echo esc_attr($val->hotel_id); ?>][]">
                                                    </li>
                                                <?php endforeach; ?>
                                                </ul>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php if(is_object($hotel_package_custom)){ ?>
                                            <?php if (!empty((array)$hotel_package_custom)) { ?>
                                                <ul class="item-inner hotel">
                                                    <?php foreach ($hotel_package_custom as $key => $val): ?>
                                                        <li>
                                                            <?php
                                                            $hotel_package_data = new stdClass();
                                                            $hotel_package_data->hotel_name = trim($val->hotel_name);
                                                            $hotel_package_data->hotel_price = $val->hotel_price;
                                                            $hotel_package_data->hotel_star = $val->hotel_star;
                                                            ?>

                                                            <div class="st-flex space-between">
                                                                <div class="solo-package">
                                                                    <span class="title-extra">
                                                                        <?php echo esc_html($val->hotel_name) . ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                                    </span>
                                                                    <div class="extra-price-item">
                                                                        <label for="field-<?php echo sanitize_title($val->hotel_name); ?>">
                                                                            <?php
                                                                            echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                                            $star = $val->hotel_star;
                                                                            echo TravelHelper::rate_to_string($star);
                                                                            echo '</ul>';
                                                                            ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="select-wrapper" style="width: 88px;">
                                                                    <div class="caculator-item">
                                                                        <i class="fa fa-minus"></i>
                                                                            <input class="form-control app extra-service-select" id="hotel-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="input" value="0" name="hotel_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                                        <i class="fa fa-plus"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input id="hotel-custom-<?php echo 'custom_' . esc_attr($key); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" name="hotel_package[<?php echo 'custom_' . esc_attr($key); ?>][]" <?php echo in_array('custom_' . $key, $hotel_ids_selected) ? 'checked': ''; ?>>

                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php } } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $iCheck = true;
                        } ?>
                        <!--End Hotel Package-->

                        <!--Activity package-->
                        <?php
                        if ( st_check_service_available('st_activity') && STTour::_check_empty_package($activity_package, $activity_package_custom)) {
                            $activity_selected = STInput::post('activity_package', '');
                            $activity_ids_selected = TravelHelper::get_ids_selected_tour_package($activity_selected, 'hotel');
                            if((is_object($activity_package) && (!empty((array)$activity_package))) || (is_object($activity_package_custom) && (!empty((array)$activity_package_custom)))){ ?>
                                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                                    <div class="header">
                                        <h5><?php echo __('Select Activity Package', 'traveler'); ?></h5>
                                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                                    </div>
                                    <div class="body">
                                        <?php if(is_object($activity_package)){ ?>
                                            <?php if (!empty((array)$activity_package)) { ?>
                                                <ul class="item-inner">
                                                    <?php foreach ($activity_package as $key => $val): ?>
                                                    <li>
                                                        <?php
                                                        $activity_package_data = new stdClass();
                                                        $activity_package_data->activity_name = trim(get_the_title($val->activity_id));
                                                        $activity_package_data->activity_price = $val->activity_price;
                                                        ?>
                                                        <div class="st-flex space-between">
                                                            <div class="solo-package">
                                                                <span class="title-extra">
                                                                    <?php echo get_the_title($val->activity_id) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                                </span>
                                                            </div>

                                                            <div class="select-wrapper" style="width: 88px;">
                                                                <div class="caculator-item">
                                                                    <i class="fa fa-minus"></i>
                                                                        <input class="form-control app extra-service-select" id="field_qty_<?php echo esc_attr($val->activity_id); ?>" type="input" value="0" name="activity_package[<?php echo '_qty_'.esc_attr($val->activity_id); ?>][]" step="1"  min="0">
                                                                    <i class="fa fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input id="field-<?php echo esc_attr($val->activity_id); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" name="activity_package[<?php echo esc_attr($val->activity_id); ?>][]">
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php if(is_object($activity_package_custom)){ ?>
                                            <?php if (!empty((array)$activity_package_custom)) { ?>
                                                <ul class="item-inner">
                                                    <?php foreach ($activity_package_custom as $key => $val): ?>
                                                        <li>
                                                            <?php
                                                            $activity_package_data = new stdClass();
                                                            $activity_package_data->activity_name = trim($val->activity_name);
                                                            $activity_package_data->activity_price = $val->activity_price;
                                                            ?>

                                                            <div class="st-flex space-between">
                                                                <div class="solo-package">
                                                                    <span class="title-extra">
                                                                        <?php echo esc_html($val->activity_name) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                                    </span>
                                                                </div>
                                                                <div class="select-wrapper" style="width: 88px;">
                                                                    <div class="caculator-item">
                                                                        <i class="fa fa-minus"></i>
                                                                            <input class="form-control app extra-service-select" id="activity-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="input" value="0" name="activity_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                                        <i class="fa fa-plus"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input id="activity-custom-<?php echo 'custom_' . esc_attr($key); ?>" type="hidden" value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" name="activity_package[<?php echo 'custom_' . esc_attr($key); ?>][]" <?php echo in_array('custom_' . $key, $hotel_ids_selected) ? 'checked': ''; ?>>

                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php } } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $iCheck = true;
                        } ?>
                        <!--End Activity package-->

                        <!--Car Package-->
                        <?php
                        if ( st_check_service_available('st_cars') && STTour::_check_empty_package($car_package, $car_package_custom)) {
                            $car_selected = STInput::post('car_quantity', '');
                            $car_ids_selected = TravelHelper::get_ids_selected_tour_package($car_selected, 'car');
                            if((is_object($car_package) && (!empty((array)$car_package))) || (is_object($car_package_custom) && (!empty((array)$car_package_custom)))){ ?>
                                <div class="item <?php echo !$iCheck ? 'active' : ''; ?>">
                                    <div class="header">
                                        <h5><?php echo __('Select Car Package', 'traveler'); ?></h5>
                                        <span class="arrow"><i class="fa fa-angle-down"></i></span>
                                    </div>
                                    <div class="body">
                                        <?php if(is_object($car_package)){ ?>
                                            <?php if (!empty((array)$car_package)) { ?>
                                                <ul class="item-inner car">
                                                    <?php foreach ($car_package as $key => $val):
                                                        $car_quantity = !empty($val->car_quantity) ? $val->car_quantity : "" ;

                                                        ?>
                                                        <li class="car-item-package">
                                                            <label for="field-<?php echo esc_attr($val->car_id); ?>"><?php echo get_the_title($val->car_id) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?></label>
                                                            <input type="hidden" name="car_name[<?php echo esc_attr($val->car_id); ?>][]"
                                                                value="<?php echo trim(get_the_title($val->car_id)); ?>"/>
                                                            <input type="hidden" name="car_price[<?php echo esc_attr($val->car_id); ?>][]"
                                                                value="<?php echo esc_attr($val->car_price); ?>"/>
                                                            <div class="select-wrapper" style="width: 88px;">
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
                                                        <li class="car-item-package">
                                                            <label for="car-custom-<?php echo esc_attr($key); ?>"><?php echo esc_html($val->car_name) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?></label>
                                                            <input type="hidden" name="car_name[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                value="<?php echo esc_attr($val->car_name); ?>"/>
                                                            <input type="hidden" name="car_price[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                value="<?php echo esc_attr($val->car_price); ?>"/>
                                                            <div class="select-wrapper" style="width: 88px;">
                                                                <div class="caculator-item">
                                                                    <i class="fa fa-minus"></i>
                                                                        <input class="form-control app extra-service-select" id="car_custom_field_qty_<?php echo esc_attr($val->car_id); ?>" type="input" value="0" name="car_quantity[<?php echo 'custom_' . esc_attr($key); ?>][]" step="1"  min="0" <?php if(!empty($car_quantity)){?> max="<?php echo esc_attr($car_quantity);?>" <?php }?>>
                                                                    <i class="fa fa-plus"></i>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php } } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $iCheck = true;
                        } ?>
                        <!--End Car Package-->

                        <!--Flight Package-->
                        <?php
                        if ( st_check_service_available('st_flight') && STTour::_check_empty_package($flight_package, $flight_package_custom)) {
                            $flight_selected = STInput::post('flight_package', '');
                            $flight_ids_selected = TravelHelper::get_ids_selected_tour_package($flight_selected, 'flight');
                            if((is_object($flight_package) && (!empty((array)$flight_package))) || (is_object($flight_package_custom) && (!empty((array)$flight_package_custom)))){ ?>
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
                                                        $flight_package_data = new stdClass();
                                                        $flight_package_data->flight_origin = $val->flight_origin;
                                                        $flight_package_data->flight_destination = $val->flight_destination;
                                                        $flight_package_data->flight_departure_time = $val->flight_departure_time;
                                                        $flight_package_data->flight_duration = $val->flight_duration;
                                                        $flight_package_data->flight_price_economy = $val->flight_price_economy;
                                                        $flight_package_data->flight_price_business = $val->flight_price_business;
                                                        $flight_package_data_economy = $flight_package_data_business = $flight_package_data;
                                                        ?>
                                                        <li>
                                                            <div class="package-flight">
                                                                <div class="flight_destination">
                                                                    <?php echo esc_html($val->flight_origin) . ' <i class="fa fa-long-arrow-right"></i> ' . esc_html($val->flight_destination); ?>
                                                                </div>
                                                                <div class="flight_departure_time">
                                                                    <b><?php echo __('Departure time', 'traveler') ?>:</b> <?php echo esc_html($val->flight_departure_time); ?><br />
                                                                    <b><?php echo __('Duration', 'traveler') ?>:</b> <?php echo esc_html($val->flight_duration); ?>
                                                                </div>
                                                                <div class="flight_price_economy">
                                                                    <?php $flight_package_data_economy->flight_price_type = 'economy'; ?>
                                                                    <label class="ml20 mb10">
                                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_economy)); ?>"  checked />
                                                                        <span class="mt2 d-i-b">
                                                                            <?php echo __('Economy', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_economy); ?>)
                                                                        </span>
                                                                    </label>
                                                                    <?php $flight_package_data_business->flight_price_type = 'business'; ?>
                                                                    <label class="ml20">
                                                                        <input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_business)); ?>" />
                                                                        <span class="mt2 d-i-b">
                                                                            <?php echo __('Business', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_business); ?>)
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="select-wrapper" style="width: 88px;">
                                                                <div class="caculator-item">
                                                                    <i class="fa fa-minus"></i>
                                                                        <input class="form-control app extra-service-select" id="flight-custom-<?php echo 'custom_qty_' . esc_attr($key); ?>" type="input" value="0" name="flight_package[<?php echo 'custom_qty_' . esc_attr($key); ?>][]" step="1"  min="0">
                                                                    <i class="fa fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php } } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $iCheck = true;
                        } ?>
                        <!--End Flight Package-->
                    </div>
                </div>
                <?php
            }
            if ( !empty( $extra_price ) ) { ?>
                <li>
                <span class="name-extra-title"><?php echo __('Extra','traveler');?></span>
                </li>
                <?php foreach ( $extra_price as $key => $val ):
                    if ( isset( $val[ 'extra_required' ] ) && $val[ 'extra_required' ] == 'on' ) {
                        ?>
                        <li class="item mt10">
                            <div class="st-flex space-between">
                                <span>
                                    <span class="title-extra">
                                        <?php echo esc_html($val['title']); ?><span class="c-orange">*</span>
                                    </span>
                                    <span class="extra-price-item">
                                        <?php echo TravelHelper::format_money( $val[ 'extra_price' ] ) ?>
                                    </span>
                                </span>
                                <div class="select-wrapper" style="width: 88px;">
                                    <?php
                                        $max_item = intval( $val[ 'extra_max_number' ] );
                                        if ( $max_item <= 0 ) $max_item = 1;
                                        $start_i = 0;
                                        if ( isset( $val[ 'extra_required' ] ) ) {
                                            if ( $val[ 'extra_required' ] == 'on' ) {
                                                $start_i = 1;
                                            }
                                        }
                                    ?>
                                    <div class="caculator-item">
                                        <i class="fa fa-minus"></i>
                                        <input type="number" class="form-control app extra-service-select"
                                            name="extra_price[value][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                            id="field-<?php echo esc_attr($val[ 'extra_name' ]); ?>"
                                            data-extra-price="<?php echo esc_attr($val[ 'extra_price' ]); ?>" step= "1" value="<?php echo intval($start_i)?>" min="<?php echo intval($start_i)?>" max="<?php echo intval($max_item)?>">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="extra_price[price][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                value="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
                            <input type="hidden" name="extra_price[title][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                value="<?php echo esc_attr($val[ 'title' ]); ?>">
                        </li>
                    <?php } else { ?>
                        <li class="item mt10">
                            <div class="st-flex space-between">
                                <span>
                                    <span class="title-extra">
                                        <?php echo esc_html($val['title']); ?>
                                    </span>
                                    <span class="extra-price-item">
                                        <?php echo TravelHelper::format_money( $val[ 'extra_price' ] ) ?>
                                    </span>
                                </span>
                                <div class="select-wrapper" style="width: 88px;">
                                    <?php
                                        $max_item = intval( $val[ 'extra_max_number' ] );
                                        if ( $max_item <= 0 ) $max_item = 1;
                                        $start_i = 0;
                                        if ( isset( $val[ 'extra_required' ] ) ) {
                                            if ( $val[ 'extra_required' ] == 'on' ) {
                                                $start_i = 1;
                                            }
                                        }
                                    ?>
                                    <div class="caculator-item">
                                        <i class="fa fa-minus"></i>
                                        <input type="input" class="form-control app extra-service-select"
                                            name="extra_price[value][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                            id="field-<?php echo esc_attr($val[ 'extra_name' ]); ?>"
                                            data-extra-price="<?php echo esc_attr($val[ 'extra_price' ]); ?>" step= "1" value="<?php echo intval($start_i)?>" min="<?php echo intval($start_i)?>" max="<?php echo intval($max_item)?>">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="extra_price[price][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                value="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
                            <input type="hidden" name="extra_price[title][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
                                value="<?php echo esc_attr($val[ 'title' ]); ?>">
                        </li>
                    <?php } ?>
                <?php endforeach; ?>
            <?php }?>
        </ul>
    </div>
    <?php
} ?>

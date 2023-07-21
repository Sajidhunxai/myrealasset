<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours info
 *
 * Created by ShineTheme
 *
 */
wp_enqueue_script( 'st-qtip' );

//check is booking with modal
$st_is_booking_modal = apply_filters('st_is_booking_modal',false);

$type_tour = get_post_meta(get_the_ID(),'type_tour',true);

$max_people = get_post_meta(get_the_ID(), 'max_people', true);
$max_select = 0;
if($max_people == '' || $max_people == '0' || !is_numeric($max_people)){
    $max_select = 20;
}else{
    $max_select = $max_people;
}

$default = array('font_size'=> "3" , 'title1'=> __("Tour Informations" , 'traveler' ) , 'title2'=> __("Place Order" , 'traveler') )  ;
extract(wp_parse_args( $attr, $default ));

//Tour fixed departure
$tour_price_by = get_post_meta(get_the_ID(), 'tour_price_by', true);
$start_date_fixed = '';
$end_date_fixed = '';
$convert_start_date_fixed = '';
$convert_end_date_fixed = '';
if($tour_price_by == 'fixed_depart') {
	$start_date_fixed = get_post_meta( get_the_ID(), 'start_date_fixed', true );
	$end_date_fixed = get_post_meta( get_the_ID(), 'end_date_fixed', true );

	$convert_start_date_fixed = @date(TravelHelper::getDateFormat(), strtotime($start_date_fixed));
	$convert_end_date_fixed = @date(TravelHelper::getDateFormat(), strtotime($end_date_fixed));
}
$price_by_person = STTour::get_price_person(get_the_ID());
$hide_adult = get_post_meta(get_the_ID(), 'hide_adult_in_booking_form', true);
$hide_child = get_post_meta(get_the_ID(), 'hide_children_in_booking_form', true);
$hide_infant = get_post_meta(get_the_ID(), 'hide_infant_in_booking_form', true);

$booking_type = st_get_booking_option_type();
?>
<div id="booking-request"></div>
<?php 

    $tour_show_calendar = st()->get_option('tour_show_calendar', 'on');
    $tour_show_calendar_below = st()->get_option('tour_show_calendar_below', 'off');
    if($tour_show_calendar == 'on' && $tour_show_calendar_below == 'off' && $tour_price_by != 'fixed_depart'):
?>
<div class='tour_show_caledar_below_off'>
<?php echo st()->load_template('tours/elements/tour_calendar'); ?>
</div>
<?php endif; ?>

<div class="package-info-wrapper packge-info-wrapper-style2" style="width: 100%">
    <div class="overlay-form"><i class="fa fa-refresh text-color"></i></div>

<?php if($booking_type == 'instant_enquire'){ ?>
    <nav>
        <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
          <li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
          <li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
        </ul>
    </nav>
    <?php } ?>
<?php if($booking_type == 'instant_enquire'){ ?>
    <div class="tab-content py-3 px-3 px-sm-0 st-sent-mail-customer" id="nav-tabContent">
        <div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
            <?php } ?>
<?php if($booking_type == 'instant_enquire' || $booking_type == 'instant'){ ?>
            <form id="form-booking-inpage" method="post" action="#booking-request" class="mt10 classic form-has-guest-name">
                <!-- Tour Package -->
                <?php
                $hotel_package = get_post_meta(get_the_ID(), 'tour_packages', true);
                $hotel_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom', true);
                $activity_package = get_post_meta(get_the_ID(), 'tour_packages_activity', true);
                $activity_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_activity', true);
                $car_package = get_post_meta(get_the_ID(), 'tour_packages_car', true);
                $car_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_car', true);
                $flight_package = get_post_meta(get_the_ID(), 'tour_packages_flight', true);
                $flight_package_custom = get_post_meta(get_the_ID(), 'tour_packages_custom_flight', true);
                if(STTour::_check_empty_package($hotel_package, $hotel_package_custom) || STTour::_check_empty_package($activity_package, $activity_package_custom) || STTour::_check_empty_package($car_package, $car_package_custom) || STTour::_check_empty_package($flight_package, $flight_package_custom)) { ?>
                    <h3><?php echo __('Tour Packages', 'traveler'); ?></h3>
                    <div class="accordion stour-accor" id="">
                        <?php
                        if (STTour::_check_empty_package($hotel_package, $hotel_package_custom)) {
                            $hotel_selected = STInput::post('hotel_package', '');
                            $hotel_ids_selected = TravelHelper::get_ids_selected_tour_package($hotel_selected, 'hotel');
                            ?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne">
                                        <?php echo __('Select Hotel Package', 'traveler'); ?>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <div class="sroom-extra-service st-tour-package">
                                            <div class="">
                                                <div class="extra-price">
                                                    <table class="table" style="table-layout: fixed;">
                                                        <?php if(is_object($hotel_package)){ ?>
                                                            <?php if (!empty((array)$hotel_package)) { ?>
                                                                <?php foreach ($hotel_package as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="" class="tour-package-hotel-check">
                                                                            <?php
                                                                            $hotel_package_data = new stdClass();
                                                                            $hotel_package_data->hotel_name = trim(get_the_title($val->hotel_id));
                                                                            $hotel_package_data->hotel_price = $val->hotel_price;
                                                                            $hotel_package_data->hotel_star = STHotel::getStar($val->hotel_id);
                                                                            ?>
                                                                            <input id="field-<?php echo esc_attr($val->hotel_id); ?>"
                                                                                   type="checkbox" class="i-check"
                                                                                   name="hotel_package[<?php echo esc_attr($val->hotel_id); ?>][]"
                                                                                   value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" <?php echo in_array($val->hotel_id, $hotel_ids_selected) ? 'checked': ''; ?>/>
                                                                            <label for="field-<?php echo esc_attr($val->hotel_id); ?>"
                                                                                   class="ml20 mt5"><?php echo get_the_title($val->hotel_id) . ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                                                <?php
                                                                                $star = STHotel::getStar($val->hotel_id);
                                                                                echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                                                echo TravelHelper::rate_to_string($star);
                                                                                echo '</ul>';
                                                                                ?>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                        <?php if(is_object($hotel_package_custom)){ ?>
                                                            <?php if (!empty((array)$hotel_package_custom)) { ?>
                                                                <?php foreach ($hotel_package_custom as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="100%" class="tour-package-hotel-check">
                                                                            <?php
                                                                            $hotel_package_data = new stdClass();
                                                                            $hotel_package_data->hotel_name = trim($val->hotel_name);
                                                                            $hotel_package_data->hotel_price = $val->hotel_price;
                                                                            $hotel_package_data->hotel_star = $val->hotel_star;
                                                                            ?>
                                                                            <input id="hotel-custom-<?php echo 'custom_' . esc_attr($key); ?>" type="checkbox"
                                                                                   class="i-check" name="hotel_package[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                                   value="<?php echo htmlspecialchars(json_encode($hotel_package_data)); ?>" <?php echo in_array('custom_' . esc_attr($key), $hotel_ids_selected) ? 'checked': ''; ?>/>
                                                                            <label for="hotel-custom-<?php echo esc_attr($key); ?>"
                                                                                   class="ml20 mt5"><?php echo esc_attr($val->hotel_name ). ' (' . TravelHelper::format_money($val->hotel_price) . ')'; ?>
                                                                                <?php
                                                                                $star = $val->hotel_star;
                                                                                echo '<ul class="icon-list icon-group booking-item-rating-stars">';
                                                                                echo TravelHelper::rate_to_string($star);
                                                                                echo '</ul>';
                                                                                ?>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (STTour::_check_empty_package($activity_package, $activity_package_custom)) {
                            $activity_selected = STInput::post('activity_package', '');
                            $activity_ids_selected = TravelHelper::get_ids_selected_tour_package($activity_selected, 'hotel');
                            ?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseTwo">
                                        <?php echo __('Select Activity Package', 'traveler'); ?>
                                    </a>
                                </div>
                                <div id="collapseTwo" class="accordion-body collapse">
                                    <div class="accordion-inner">

                                        <div class="sroom-extra-service st-tour-package">
                                            <div class="">
                                                <div class="extra-price">
                                                    <table class="table" style="table-layout: fixed;">
                                                        <?php if(is_object($activity_package)){ ?>
                                                            <?php if (!empty((array)$activity_package)) { ?>
                                                                <?php foreach ($activity_package as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="" class="tour-package-hotel-check car-check">
                                                                            <?php
                                                                            $activity_package_data = new stdClass();
                                                                            $activity_package_data->activity_name = trim(get_the_title($val->activity_id));
                                                                            $activity_package_data->activity_price = $val->activity_price;
                                                                            ?>
                                                                            <input id="field-<?php echo esc_attr($val->activity_id); ?>"
                                                                                   type="checkbox" class="i-check"
                                                                                   name="activity_package[<?php echo esc_attr($val->activity_id); ?>][]"
                                                                                   value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" <?php echo in_array($val->activity_id, $activity_ids_selected) ? 'checked': ''; ?>/>
                                                                            <label for="field-<?php echo esc_attr($val->activity_id); ?>"
                                                                                   class="ml20 mt5"><?php echo get_the_title($val->activity_id) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                        <?php if(is_object($activity_package_custom)){ ?>
                                                            <?php if (!empty((array)$activity_package_custom)) { ?>
                                                                <?php foreach ($activity_package_custom as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td class="tour-package-hotel-check car-check">
                                                                            <?php
                                                                            $activity_package_data = new stdClass();
                                                                            $activity_package_data->activity_name = trim($val->activity_name);
                                                                            $activity_package_data->activity_price = $val->activity_price;
                                                                            ?>
                                                                            <input id="activity-custom-<?php echo esc_attr($key); ?>"
                                                                                   type="checkbox" class="i-check"
                                                                                   name="activity_package[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                                   value="<?php echo htmlspecialchars(json_encode($activity_package_data)); ?>" <?php echo in_array('custom_' . esc_attr($key), $activity_ids_selected) ? 'checked': ''; ?>/>
                                                                            <label for="activity-custom-<?php echo esc_attr($key); ?>"
                                                                                   class="ml20 mt5"><?php echo esc_html($val->activity_name) . ' (' . TravelHelper::format_money($val->activity_price) . ')'; ?>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (STTour::_check_empty_package($car_package, $car_package_custom)) {
                            $car_selected = STInput::post('car_quantity', '');
                            $car_ids_selected = TravelHelper::get_ids_selected_tour_package($car_selected, 'car');
                            ?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseThree">
                                        <?php echo __('Select Car Package', 'traveler'); ?>
                                    </a>
                                </div>
                                <div id="collapseThree" class="accordion-body collapse">
                                    <div class="accordion-inner">

                                        <div class="sroom-extra-service st-tour-package">
                                            <div class="">
                                                <div class="extra-price">
                                                    <table class="table" style="table-layout: fixed;">
                                                        <?php if(is_object($car_package)){ ?>
                                                            <?php if (!empty((array)$car_package)) { ?>
                                                                <?php foreach ($car_package as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="80%" class="tour-package-hotel-check car-check">
                                                                            <label for="field-<?php echo esc_attr($val->car_id); ?>"
                                                                                   class="ml20 mt5"><?php echo get_the_title($val->car_id) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?>
                                                                            </label>
                                                                        </td>
                                                                        <td width="20%">
                                                                            <input type="hidden" name="car_name[<?php echo esc_attr($val->car_id); ?>][]"
                                                                                   value="<?php echo trim(get_the_title($val->car_id)); ?>"/>
                                                                            <input type="hidden" name="car_price[<?php echo esc_attr($val->car_id); ?>][]"
                                                                                   value="<?php echo esc_attr($val->car_price); ?>"/>
                                                                            <select id="field-<?php echo esc_attr($val->car_id); ?>"
                                                                                    style="width: 100px" class="form-control app"
                                                                                    name="car_quantity[<?php echo esc_attr($val->car_id); ?>][]">
                                                                                <?php
                                                                                $car_quantity = $val->car_quantity;
                                                                                for ($i = 0; $i <= $car_quantity; $i++) {
                                                                                    $selected = '';
                                                                                    if(!empty($car_ids_selected)) {
                                                                                        if ($i == $car_ids_selected[$val->car_id])
                                                                                            $selected = 'selected';
                                                                                    }
                                                                                    echo '<option value="' . esc_attr($i) . '" '. $selected .'>' . esc_html($i) . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                        <?php if(is_object($car_package_custom)){ ?>
                                                            <?php if (!empty((array)$car_package_custom)) { ?>
                                                                <?php foreach ($car_package_custom as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="80%" class="tour-package-hotel-check car-check">
                                                                            <label for="car-custom-<?php echo esc_attr($key); ?>"
                                                                                   class="ml20 mt5"><?php echo esc_html($val->car_name) . ' (' . TravelHelper::format_money($val->car_price) . ')'; ?>
                                                                            </label>
                                                                        </td>
                                                                        <td width="20%">
                                                                            <input type="hidden" name="car_name[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                                   value="<?php echo esc_attr($val->car_name); ?>"/>
                                                                            <input type="hidden" name="car_price[<?php echo 'custom_' . esc_attr($key); ?>][]"
                                                                                   value="<?php echo esc_attr($val->car_price); ?>"/>
                                                                            <select id="car-custom-<?php echo esc_attr($key); ?>"
                                                                                    style="width: 100px" class="form-control app"
                                                                                    name="car_quantity[<?php echo 'custom_' . esc_attr($key); ?>][]">
                                                                                <?php
                                                                                $car_quantity = $val->car_quantity;
                                                                                for ($i = 0; $i <= $car_quantity; $i++) {
                                                                                    $selected = '';
                                                                                    if(!empty($car_ids_selected)) {
                                                                                        if ($i == $car_ids_selected['custom_' . $key])
                                                                                            $selected = 'selected';
                                                                                    }
                                                                                    echo '<option value="' . esc_attr($i) . '" '. $selected .'>' . esc_html($i) . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--Flight package-->
                        <?php
                        if (STTour::_check_empty_package($flight_package, $flight_package_custom)) {
                            $flight_selected = STInput::post('flight_package', '');
                            $flight_ids_selected = TravelHelper::get_ids_selected_tour_package($flight_selected, 'hotel');
                            ?>
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseFour">
                                        <?php echo __('Select Flight Package', 'traveler'); ?>
                                    </a>
                                </div>
                                <div id="collapseFour" class="accordion-body collapse">
                                    <div class="accordion-inner">

                                        <div class="sroom-extra-service st-tour-package">
                                            <div class="">
                                                <div class="extra-price">
                                                    <table class="table" style="table-layout: fixed;">
                                                        <?php if(is_object($flight_package)){ ?>
                                                            <?php if (!empty((array)$flight_package)) { ?>
                                                                <?php foreach ($flight_package as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td width="" class="tour-package-hotel-check car-check">
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
                                                                            $total_time_str = $total_time['hour'] . 'h' . $total_time['minute'] . 'm';

                                                                            $flight_package_data->flight_origin = $origin_res;
                                                                            $flight_package_data->flight_destination = $destination_res;
                                                                            $flight_package_data->flight_departure_time = $depart_time;
                                                                            $flight_package_data->flight_duration = $total_time_str;

                                                                            $flight_package_data->flight_price_economy = $val->flight_price_economy;
                                                                            $flight_package_data->flight_price_business = $val->flight_price_business;

                                                                            $flight_package_data_economy = $flight_package_data_business = $flight_package_data;
                                                                            ?>
                                                                            <label for="activity-custom-<?php echo esc_attr($key); ?>"
                                                                                   class="mt5"><?php echo esc_html($origin_res) . ' <i class="fa fa-long-arrow-right"></i> ' . balanceTags($destination_res); ?>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <b><?php echo __('Departure time', 'traveler') ?>:</b> <?php echo esc_html($depart_time); ?><br />
                                                                            <b><?php echo __('Duration', 'traveler') ?>:</b> <?php echo esc_html($total_time_str); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php $flight_package_data_economy->flight_price_type = 'economy'; ?>
                                                                            <label class="ml20 mb10"><input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($flight_id); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_economy)); ?>"/><span class="mt2 d-i-b"><?php echo __('Economy', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_economy); ?>)</span></label>
                                                                            <?php $flight_package_data_business->flight_price_type = 'business'; ?>
                                                                            <label class="ml20"><input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($flight_id); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_business)); ?>"/><span class="mt2 d-i-b"><?php echo __('Business', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_business); ?>)</span></label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                        <?php if(is_object($flight_package_custom)){ ?>
                                                            <?php if (!empty((array)$flight_package_custom)) { ?>
                                                                <?php foreach ($flight_package_custom as $key => $val): ?>
                                                                    <tr class="extra-collapse-control extra-none">
                                                                        <td class="tour-package-hotel-check car-check">
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
                                                                            <label for="activity-custom-<?php echo esc_attr($key); ?>"
                                                                                   class="mt5"><?php echo esc_html($val->flight_origin) . ' <i class="fa fa-long-arrow-right"></i> ' . balanceTags($val->flight_destination); ?>
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <b><?php echo __('Departure time', 'traveler') ?>:</b> <?php echo esc_html($val->flight_departure_time); ?><br />
                                                                            <b><?php echo __('Duration', 'traveler') ?>:</b> <?php echo esc_html($val->flight_duration); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php $flight_package_data_economy->flight_price_type = 'economy'; ?>
                                                                            <label class="ml20 mb10"><input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_economy)); ?>"/><span class="mt2 d-i-b"><?php echo __('Economy', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_economy); ?>)</span></label>
                                                                            <?php $flight_package_data_business->flight_price_type = 'business'; ?>
                                                                            <label class="ml20"><input type="radio" class="i-check flight_package" name="flight_package[<?php echo esc_attr($key); ?>][]" value="<?php echo htmlspecialchars(json_encode($flight_package_data_business)); ?>"/><span class="mt2 d-i-b"><?php echo __('Business', 'traveler'); ?> (<?php echo TravelHelper::format_money($val->flight_price_business); ?>)</span></label>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php } } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--End Flight Package-->
                    </div>
                <?php } ?>
                <!-- End Tour Package -->
                <div class="row">
                    <div class="col-md-6"> 
                        <h<?php echo esc_attr($font_size );?>><?php echo esc_attr($title1) ;?></h<?php echo esc_attr($font_size );?>>
                        <div class="package_info_2 item mt20">
                            <div class="title"><i class="fa fa-info-circle"></i></div>
                            <div class="head">
                                <?php _e('Tour type','traveler') ?>: 
                                <span class='text-color text-uppercase'>
                                    <?php if($type_tour == 'daily_tour') echo __('Daily Tour', 'traveler'); else echo __('Specific Date', 'traveler') ?>
                                </span>
                            </div>
                        </div>
                        <?php if($type_tour == 'daily_tour') {?>
                        <div class="package_info_2 item mt20">
                            <div class="title"><i class="fa fa-clock-o"></i></div>
                            <div class="head">
                                <?php _e('Duration','traveler') ?>:
                                <span class='text-color text-uppercase'>
                                    <?php
                                        echo STTour::get_duration_unit();
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php }?>
                        <div class="package_info_2 item mt20">
                            <div class="title"><i class="fa fa-user-plus"></i></div>
                            <div class="head">
                                <?php _e('Maximum People','traveler') ?>: 
                                <?php $max_people = get_post_meta(get_the_ID(),'max_people', true) ?>
                                <span class='text-color text-uppercase'>
                                    <?php 
                                        if( !$max_people || $max_people == 0 ){
                                            $max_people = __('Unlimited', 'traveler');
                                        }
                                        echo esc_html($max_people) 
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="package_info_2 item mt20">
                            <div class="title"><i class="fa fa-map-marker"></i></div>
                            <div class="head">
                                <?php _e('Location','traveler') ?>: 
                                <span class='text-color text-uppercase'>
                                    <?php echo TravelHelper::locationHtml(get_the_ID()); ?>
                                </span>
                            </div>
                        </div>
                        <div class="package_info_2 item mt20">
                            <div class="title"><i class="fa fa-star"></i></div>
                            <div class="head">
                                <?php _e('Rate','traveler') ?>: 
                                <ul class='text-color'>
                                    <?php 
                                $avg = STReview::get_avg_rate();
                                echo TravelHelper::rate_to_string($avg);
                                ?>
                                </ul>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <h<?php echo esc_attr($font_size );?>><?php echo esc_attr($title2)?></h<?php echo esc_attr($font_size );?>>
                            <?php echo STTemplate::message(); ?>
                                <input type="hidden" name="action" value="tours_add_to_cart" >
                                <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
                                <input type="hidden" name="type_tour" value="<?php echo esc_html($type_tour) ?>">
                                <div class="div_book">
                                    <?php $check_in = STInput::request('check_in', ''); ?>
                                    <?php $check_out = STInput::request('check_out', ''); ?>
                                    <?php
                                    if($tour_price_by != 'fixed_depart'){
                                        if($tour_show_calendar == 'on'):
                                    ?>
                                        <div class="row ">
                                            <div class="col-xs-12 ">
                                                <strong><?php _e('Departure date','traveler')?>: </strong>

                                                <input placeholder ="<?php echo __("Select a day in the calendar", 'traveler') ; ?>" id="check_in" type="text" name="check_in" value="<?php echo esc_attr($check_in); ?>" readonly="readonly" class="form-control mt10">
                                            </div>
                                            <div class="col-xs-12 mt10" style="display: none">
                                                <strong><?php _e('Return date','traveler')?>: </strong>
                                                
                                                <input id="check_out" type="text" name="check_out" value="<?php echo esc_attr($check_out); ?>" readonly="readonly" class="form-control mt10">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="row mt10">
                                            <div class="col-xs-12 mb5">
                                                <a href="#list_tour_item" id="select-a-tour" class="btn btn-primary"><?php echo __('Select a day', 'traveler'); ?></a>
                                            </div>
                                            <div class="col-xs-12 mb5" style="display: none">
                                                <strong><?php _e('Departure date','traveler')?>: </strong>
                                                <input placeholder ="<?php echo __("Select a day in the calendar", 'traveler') ; ?>" id="check_in" type="text" name="check_in" value="<?php echo esc_attr($check_in); ?>" readonly="readonly" class="form-control">
                                            </div>
                                            <div class="col-xs-12 mb5" style="display: none">
                                                <strong><?php _e('Return date','traveler')?>: </strong>
                                                <input id="check_out" type="text" name="check_out" value="<?php echo esc_attr($check_out); ?>" readonly="readonly" class="form-control">
                                            </div>
                                        </div>
                                        <div id="list_tour_item" data-type-tour="<?php echo esc_attr($type_tour); ?>" style="display: none; width: 500px; height: auto;">
                                            <div id="single-tour-calendar">
                                                <?php echo st()->load_template('tours/elements/tour_calendar'); ?>
                                                <style>
                                                    .qtip{
                                                        max-width: 250px !important;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    /**
                                     * @since 2.0.0
                                     * Add select starttime for tour booking
                                     * Check starttime tour booking
                                     * Half single layour
                                     */
                                    $starttime_value = STInput::request('starttime_tour', '');
                                    ?>

                                    <input type="hidden" data-starttime="<?php echo esc_attr($starttime_value); ?>" data-checkin="<?php echo esc_attr($check_in); ?>" data-checkout="<?php echo esc_attr($check_out); ?>" data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" />
                                    <div class="mt10" id="starttime_box" <?php echo ($starttime_value != '') ? '' : 'style="display: none;"' ?>>
                                        <strong><?php _e('Start time','traveler')?>: </strong>
                                        <select class="form-control st_tour_starttime" name="starttime_tour" id="starttime_tour"></select>
                                    </div>
                                    <?php }else{ ?>
                                        <?php if(!empty($start_date_fixed) && !empty($end_date_fixed)){ ?>
                                            <input type="hidden" id="" name="check_in" value="<?php echo esc_attr($convert_start_date_fixed); ?>" readonly="readonly" class="form-control">
                                            <input id="" type="hidden" name="check_out" value="<?php echo esc_attr($convert_end_date_fixed); ?>" readonly="readonly" class="form-control">
                                        <?php } ?>
                                        <!--Display date time for fixed departure tour-->
                                        <div class="row fixed-depart-type">
                                            <div class="col-xs-12 ">
                                                <label class="mt10"><strong><?php _e('Fixed Departure','traveler')?>: </strong></label>
                                                <ul>
                                                    <li class="header">
                                                        <div class="start"><?php echo __('Start', 'traveler'); ?></div>
                                                        <div class="end"><?php echo __('End', 'traveler'); ?></div>
                                                    </li>
                                                    <li class="body">
                                                        <div class="start">
                                                            <span>
                                                                <?php
                                                                $day_of_start_date = @date('N', strtotime($start_date_fixed));
                                                                echo TourHelper::getDayFromNumber($day_of_start_date);
                                                                ?>
                                                            </span><br />
                                                            <b><?php echo esc_html($convert_start_date_fixed); ?></b>
                                                        </div>
                                                        <div class="end">
                                                            <span>
                                                                <?php
                                                                $day_of_end_date = @date('N', strtotime($end_date_fixed));
                                                                echo TourHelper::getDayFromNumber($day_of_end_date);
                                                                ?>
                                                            </span><br />
                                                            <b><?php echo esc_html($convert_end_date_fixed); ?></b>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row fixed-depart-type">
                                            <div class="col-xs-12 ">
                                                <label class="mt10"><strong><?php _e('Price/Person','traveler')?>: </strong></label>
                                                <ul>
                                                    <li class="header">
                                                        <?php if($hide_adult != 'on'){ ?>
                                                            <div class="adult"><?php echo __('Adults', 'traveler'); ?></div>
                                                        <?php } ?>
                                                        <?php if($hide_child != 'on'){ ?>
                                                            <div class="children"><?php echo __('Children', 'traveler'); ?></div>
                                                        <?php } ?>
                                                        <?php if($hide_infant != 'on'){ ?>
                                                            <div class="infant"><?php echo __('Infant', 'traveler'); ?></div>
                                                        <?php } ?>
                                                    </li>
                                                    <li class="body">
                                                        <?php if($hide_adult != 'on'){ ?>
                                                            <div class="adult">
                                                                <?php
                                                                if($price_by_person['adult_new'] != $price_by_person['adult']){
                                                                    echo '<span>'. TravelHelper::format_money($price_by_person['adult']) .'</span><br />';
                                                                }
                                                                echo '<b>' . TravelHelper::format_money($price_by_person['adult_new']) . '</b>';
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($hide_child != 'on'){ ?>
                                                            <div class="children">
                                                                <?php
                                                                if($price_by_person['child_new'] != $price_by_person['child']){
                                                                    echo '<span>'. TravelHelper::format_money($price_by_person['child']) .'</span><br />';
                                                                }
                                                                echo '<b>' . TravelHelper::format_money($price_by_person['child_new']) . '</b>';
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($hide_infant != 'on'){ ?>
                                                            <div class="infant">
                                                                <?php
                                                                if($price_by_person['infant_new'] != $price_by_person['infant']){
                                                                    echo '<span>'. TravelHelper::format_money($price_by_person['infant']) .'</span><br />';
                                                                }
                                                                echo '<b>' . TravelHelper::format_money($price_by_person['infant_new']) . '</b>';
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>

                                        <div class="row mt10">

                                            <?php if(get_post_meta(get_the_ID(),'hide_adult_in_booking_form',true) != 'on'): ?>
                                            <div class="col-xs-12 col-sm-4 ">
                                                <strong><?php _e('Adults','traveler')?>: </strong>
                                                <select class="mt10 form-control st_tour_adult adult_number" name="adult_number" required>
                                                    <?php for($i = 0; $i <= $max_select; $i++){
                                                        $is_select = '';
                                                        if (!empty(STInput::request('adult_number'))) {
                                                            if(STInput::request('adult_number') == $i) {
                                                                $is_select = 'selected="selected"';
                                                            }
                                                        }else{
                                                            if($i == 1){
                                                                $is_select = 'selected="selected"';
                                                            }
                                                        }
                                                        echo  "<option {$is_select} value='{$i}'>{$i}</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php endif;?>

                                            <?php if(get_post_meta(get_the_ID(),'hide_children_in_booking_form',true) != 'on'): ?>
                                            <div class="col-xs-12 col-sm-4 ">
                                                <strong><?php _e('Children','traveler')?>: </strong>
                                                <select class="mt10 form-control st_tour_children child_number" name="child_number" required>
                                                    <?php for($i = 0; $i <= $max_select; $i++){
                                                        $is_select = '';
                                                        if(STInput::request('child_number') == $i){
                                                            $is_select = 'selected="selected"';
                                                        }
                                                        echo  "<option {$is_select} value='{$i}'>{$i}</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php endif;?>

                                            <?php if(get_post_meta(get_the_ID(),'hide_infant_in_booking_form',true) != 'on'): ?>
                                            <div class="col-xs-12 col-sm-4 ">
                                                <strong><?php _e('Infant','traveler')?>: </strong>
                                                <select class="mt10 form-control st_tour_infant infant_number" name="infant_number" required>
                                                    <?php for($i = 0; $i <= $max_select; $i++){
                                                        $is_select = '';
                                                        if(STInput::request('infant_number') == $i){
                                                            $is_select = 'selected="selected"';
                                                        }
                                                        echo  "<option {$is_select} value='{$i}'>{$i}</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <?php endif;?>
                                        </div>
                                        <?php  $extra_price = get_post_meta(get_the_ID(), 'extra_price', true); ?>
                                        <?php if(is_array($extra_price) && count($extra_price)): ?>
                                            <?php $extra = STInput::request("extra_price");
                                            if(!empty($extra['value'])){
                                                $extra_value = $extra['value'];
                                            }
                                            ?>
                                            <label><?php echo __('Extra', 'traveler'); ?></label>
                                            <table class="table">
                                                <?php foreach($extra_price as $key => $val): ?>
                                                    <tr>
                                                        <td width="80%">
                                                            <label for="field-<?php echo esc_attr($val['extra_name']); ?>" class="ml20 mt5"><?php echo esc_html($val['title']).' ('.TravelHelper::format_money($val['extra_price']).')'; ?>
                                                                <?php
                                                                if(isset($val['extra_required'])){
                                                                    if($val['extra_required'] == 'on') {
                                                                        echo '<small class="stour-required-extra" data-toggle="tooltip" data-placement="top" title="' . __('Required extra service', 'traveler') . '">(<span>*</span>)</small>';
                                                                    }
                                                                }
                                                                ?>
                                                            </label>
                                                            <input type="hidden" name="extra_price[price][<?php echo esc_attr($val['extra_name']); ?>]" value="<?php echo esc_attr($val['extra_price']); ?>">
                                                            <input type="hidden" name="extra_price[title][<?php echo esc_attr($val['extra_name']); ?>]" value="<?php echo esc_attr($val['title']); ?>">
                                                        </td>
                                                        <td width="20%">
                                                            <select  style="width: 100px" class="form-control app" name="extra_price[value][<?php echo esc_attr($val['extra_name']); ?>]" id="field-<?php echo esc_attr($val['extra_name']); ?>">
                                                                <?php
                                                                $max_item = intval($val['extra_max_number']);
                                                                if($max_item <= 0) $max_item = 1;
                                                                $start_i = 0;
                                                                if(isset($val['extra_required'])) {
                                                                    if ($val['extra_required'] == 'on') {
                                                                        $start_i = 1;
                                                                    }
                                                                }
                                                                for($i = $start_i; $i <= $max_item; $i++):
                                                                    $check = "";
                                                                    if(!empty($extra_value[$val['extra_name']]) and $i == $extra_value[$val['extra_name']]){
                                                                        $check = "selected";
                                                                    }
                                                                    ?>
                                                                    <option <?php echo esc_html($check) ?>  value="<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                        <?php endif; ?>

                                    <div class="guest_name_input hidden mb15 mt10" data-placeholder="<?php esc_html_e('Guest %d name','traveler') ?>" data-hide-adult="<?php echo get_post_meta(get_the_ID(),'disable_adult_name',true) ?>" data-hide-children="<?php echo get_post_meta(get_the_ID(),'disable_children_name',true) ?>" data-hide-infant="<?php echo get_post_meta(get_the_ID(),'disable_infant_name',true) ?>">
                                        <label ><strong><?php esc_html_e('Guest Name','traveler') ?></strong> <span class="required">*</span></label>
                                        <div class="guest_name_control">
                                            <?php
                                            $controls = STInput::request('guest_name');
                                            $guest_titles = STInput::request('guest_title');
                                            if(!empty($controls) and is_array($controls))
                                            {
                                                foreach ($controls as $k=>$control){
                                                    ?>
                                                    <div class="control-item mb10">
                                                        <select name="guest_title[]" class="form-control" >
                                                            <option value="mr" <?php selected('mr',isset($guest_titles[$k])?$guest_titles[$k]:'') ?>><?php esc_html_e('Mr','traveler') ?></option>
                                                            <option value="miss" <?php selected('miss',isset($guest_titles[$k])?$guest_titles[$k]:'') ?> ><?php esc_html_e('Miss','traveler') ?></option>
                                                            <option value="mrs" <?php selected('mrs',isset($guest_titles[$k])?$guest_titles[$k]:'') ?>><?php esc_html_e('Mrs','traveler') ?></option>
                                                        </select>
                                                        <?php printf('<input class="form-control " placeholder="%s" name="guest_name[]" value="%s">',sprintf(esc_html__('Guest %d name','traveler'),$k+2),esc_attr($control));?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <script type="text/html" id="guest_name_control_item">
                                            <div class="control-item mb10">
                                                <select name="guest_title[]" class="form-control" >
                                                    <option value="mr" ><?php esc_html_e('Mr','traveler') ?></option>
                                                    <option value="miss"  ><?php esc_html_e('Miss','traveler') ?></option>
                                                    <option value="mrs" ><?php esc_html_e('Mrs','traveler') ?></option>
                                                </select>
                                                <?php printf('<input class="form-control " placeholder="%s" name="guest_name[]" value="">',esc_html__('Guest %d name','traveler'));?>
                                            </div>
                                        </script>
                                    </div>

                                        <input type="hidden" name="adult_price" id="adult_price">
                                        <input type="hidden" name="child_price" id="child_price">
                                        <input type="hidden" name="infant_price" id="infant_price">
                                    <div class="message_box mb10"></div>
                                    <div class="div_btn_book_tour">
                                        <?php
                                        $tour_external_booking      = get_post_meta( get_the_ID(), 'st_tour_external_booking', "off" );
                                        if($st_is_booking_modal && $tour_external_booking == 'off'){
                                            if(st_owner_post()) {
                                                echo st_button_send_message(get_the_ID());
                                            }
                                            ?>
                                            <a data-target="#tour_booking_<?php the_ID() ?>" onclick="return false" class="btn btn-primary btn-st-add-cart" data-effect="mfp-zoom-out" ><?php st_the_language('book_now') ?> <i class="fa fa-spinner fa-spin"></i></a>
                                        <?php }else{ ?>
                                        <?php echo STTour::tour_external_booking_submit();?>                                
                                        <?php } ?>
                                        <?php echo st()->load_template('user/html/html_add_wishlist',null,array("title"=>'','class'=>'')) ?>
                                    </div>
                                </div>
                    </div>
                </div>
            </form>
    <?php } ?>
<?php if($booking_type == 'instant_enquire'){ ?>
        </div>
        <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
            <?php } ?>
<?php if($booking_type == 'instant_enquire' || $booking_type == 'enquire'){ ?>
    <?php if( $booking_type == 'enquire'){ ?>
    <h4><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
        <?php } ?>
            <div class="overlay-form" style="display: none;"><i class="fa fa-refresh text-color"></i></div>
            <?php echo st()->load_template( 'email/email_single_service' ); ?>
    <?php } ?>
<?php if($booking_type == 'instant_enquire'){ ?>
        </div>
    </div>
    <?php } ?>
    
</div>
<?php 
    if($tour_show_calendar == 'on' && $tour_show_calendar_below == 'on' && $tour_price_by != 'fixed_depart'):
?>
<div class='tour_show_caledar_below_on'>
<?php echo st()->load_template('tours/elements/tour_calendar'); ?>
</div>
<?php endif; ?>
<?php
if($st_is_booking_modal){?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="tour_booking_<?php echo get_the_ID()?>">
        <?php echo st()->load_template('tours/modal_booking');?>
    </div>

<?php }?>
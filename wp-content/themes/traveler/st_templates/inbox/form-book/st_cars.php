<?php
wp_enqueue_style('daterangepicker-new-css');
wp_enqueue_script('daterangepicker-new-js');
wp_enqueue_script('custom_car_inbox');
wp_enqueue_style('st-select.css');
wp_enqueue_script('st-select.js');
wp_enqueue_script('icheck.js');

$booking_data = $message_data['booking_data'];
$pick_up_date = '';
$pick_up_time = '';
$drop_off_time = '';
$drop_off_date = '';
$pick_up = '';
$drop_off = '';
$location_id_pick_up = '';
$location_id_drop_off = '';
$selected_equipments = '';
$location_id = '';
$location_name = '';

$st_is_booking_modal = apply_filters('st_is_booking_modal',false);

$pick_up_date = TravelHelper::convertDateFormat( STInput::request( 'pick-up-date' ) );
if ( empty( $pick_up_date ) ) {
	$pick_up_date = date( 'm/d/Y', strtotime( "now" ) );
}
$drop_off_date = TravelHelper::convertDateFormat( STInput::request( 'drop-off-date' ) );
if ( empty( $drop_off_date ) ) {
	$drop_off_date = date( 'm/d/Y', strtotime( "+1 day" ) );
}
$time_format = st()->get_option('time_format', '12h');
$string_time_format_js = 'hh:mm A';
$string_time_format = 'h:i A';
if ($time_format === '24h') {
    $string_time_format_js = 'HH:mm';
    $string_time_format = 'H:i';
}

$pick_up_time         = STInput::request( 'pick-up-time', date($string_time_format) );
$drop_off_time        = STInput::request( 'drop-off-time', date($string_time_format) );
$pick_up              = STInput::request( 'pick-up', '' );
$location_id = STInput::request('location_id', '');
if(is_singular('location')){
    $location_id = get_the_ID();
}
if (!empty($location_id)) {
    $location_name = get_the_title($location_id);
} else {
    $location_name = '';
}
if(!empty(STInput::request( 'location_id_drop_off', '' )))
		$location_id_drop_off = STInput::request( 'location_id_drop_off', '' );
$drop_off             = STInput::request( 'drop-off', '' );
if(!empty(STInput::request( 'location_id_pick_up', '' )))
		$location_id_pick_up  = STInput::request( 'location_id_pick_up', '' );
$selected_equipments = STInput::request('selected_equipments');
if(!empty($booking_data)){
	$booking_data = json_decode($booking_data, true);
	$pick_up_date = isset($booking_data['pick-up-date']) ? $booking_data['pick-up-date'] : '';
	$drop_off_date = isset($booking_data['drop-off-date']) ? $booking_data['drop-off-date'] : '';
	$pick_up_time         = isset($booking_data['pick-up-time']) ? $booking_data['pick-up-time'] : '';
	$drop_off_time        = isset($booking_data['drop-off-time']) ? $booking_data['drop-off-time'] : '';
	$pick_up              = isset($booking_data['pick-up']) ? $booking_data['pick-up'] : '';
	$location_id_drop_off = isset($booking_data['location_id_drop_off']) ? $booking_data['location_id_drop_off'] : '';
	$drop_off             = isset($booking_data['drop-off']) ? $booking_data['drop-off'] : '';
	$location_id_pick_up  = isset($booking_data['location_id_pick_up']) ? $booking_data['location_id_pick_up'] : '';
	$selected_equipments = $booking_data['selected_equipments'];
	$location_id = isset($booking_data['location_id']) ? esc_html($booking_data['location_id']) : '';
	$location_name = isset($booking_data['location_name']) ? esc_html($booking_data['location_name']) : '';
}

$arr_equip_title = array();
$selected_equipments_data = $selected_equipments;
if(!empty($selected_equipments)){
    $selected_equipments = json_decode(wp_unslash($selected_equipments), true);
    if(!empty($selected_equipments)){
        foreach ($selected_equipments as $ke => $ve){
            $arr_equip_title[$ve['title']] = array(
              'number' => $ve['number_item']
            );
            //array_push($arr_equip_title, $ve['title']);
        }
    }
}
$start = TravelHelper::convertDateFormat($pick_up_date).' '.$pick_up_time;
$start = strtotime($start);
$end = TravelHelper::convertDateFormat($drop_off_date).' '.$drop_off_time;
$end = strtotime($end);
$time=STCars::get_date_diff($start,$end);

$car_unit_price = st()->get_option('cars_price_unit', 'day');
$car_data_type = '';
if($car_unit_price == 'day' || $car_unit_price == 'hour'){
	$enable_equipment_by_unit = st()->get_option('equipment_by_unit', 'off');
	if($enable_equipment_by_unit == 'on'){
		$car_data_type = ' data-equip="on"';
	}
}

$booking_period = get_post_meta($post_id, 'cars_booking_period', true);
if(empty($booking_period)) $booking_period = 0;
$date= new DateTime();
if($booking_period){
	if($booking_period==1) $date->modify('+1 day');
	else esc_html($date->modify('+'.$booking_period.' days'));
}

///// get Price
$info_price = STCars::get_info_price($post_id,$start,$end);
$cars_price = $info_price['price'];
$count_sale = $info_price['discount'];
$price_origin = $info_price['price_origin'];
$list_price = $info_price['list_price'];
$location_country = get_post_meta($location_id_pick_up, 'location_country', true);

$bg_thumb = '';
if(has_post_thumbnail($post_id)){
	$bg_thumb = get_the_post_thumbnail_url($post_id, 'full');
}else{
	$bg_thumb = get_template_directory_uri() . '/img/no-image.png';
}

$enable_tree = st()->get_option('bc_show_location_tree', 'off');
if ($enable_tree == 'on') {
		$lists = TravelHelper::getListFullNameLocation('st_cars');
		$list_locations = TravelHelper::buildTreeHasSort($lists);
} else {
		$list_locations = TravelHelper::getListFullNameLocation('st_cars');
}
$is_new_layout = (st()->get_option('st_theme_style', 'modern') === 'modern') ? true : false;
if ($is_new_layout) {
	$list_equipments = get_post_meta($post_id,'extra_price',true);
} else {
	$list_equipments = get_post_meta($post_id,'cars_equipment_list',true);
}
$car_external_booking = get_post_meta($post_id, 'st_car_external_booking', "off");
$car_external_booking_link = get_post_meta($post_id, 'st_car_external_booking_link', true);
?>
<?php if($car_external_booking == 'off' || empty($car_external_booking)){ ?>
	<form  id="form-booking-inpage" method="post" class="car_booking_form"  <?php echo esc_attr($car_data_type); ?>>
		<?php
		$current_rate = 1;
		$current      = TravelHelper::get_current_currency('name');
		$default      = TravelHelper::get_default_currency('name');
		if($current != $default) {
			$current_rate = TravelHelper::get_current_currency('rate');
		}
		?>
		<input type="hidden" name="price_rate" value="<?php echo esc_html($current_rate)?>">
		<div class="st-inbox-form-book booking-item-price-calc st-inbox-form-book-car-js" data-car-id="<?php echo esc_attr($post_id); ?>"
				data-format-date="DD/MM/YYYY"
				data-format-time="<?php echo esc_attr($string_time_format_js) ?>">
			<?php if(!empty($bg_thumb)){ ?>
				<a href="<?php echo get_the_permalink($post_id); ?>">
					<div class="thumb" style="background-image: url('<?php echo esc_url($bg_thumb); ?>')"></div>
				</a>
			<?php } ?>
			<h3><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
			<div class="section">
				<div class="package-book-now-button">
					<input type="hidden" disabled data-id="<?php echo esc_attr($post_id);?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
					<input type="hidden" name="action" value="cars_add_to_cart">
					<input type="hidden" name="item_id" value="<?php echo esc_html($post_id); ?>">
					<input type="hidden" name="location_id" value="<?php echo esc_attr($location_id_pick_up) ?>">
					<input type="hidden" name="location_id_drop_off" value="<?php echo esc_attr($location_id_drop_off) ?>">
					<input type="hidden" name="location_id_pick_up" value="<?php echo esc_attr($location_id_pick_up) ?>">
					<input type="hidden" name="pick-up-date" value="<?php echo esc_attr($pick_up_date) ?>">
					<input type="hidden" name="pick-up-time" value="<?php echo esc_attr($pick_up_time) ?>">
					<input type="hidden" name="drop-off-date" value="<?php echo esc_attr($drop_off_date) ?>">
					<input type="hidden" name="drop-off-time" value="<?php echo esc_attr($drop_off_time) ?>">
					<input type="hidden" name="data_price_cars"  class="data_price_cars" value='<?php echo json_encode($data) ?>'>
					<input type="hidden" name="selected_equipments" value="<?php //echo json_encode($tt); ?>" class="st_selected_equipments">
					<input type="hidden" name="county_pick_up" class="county_pick_up" data-address="<?php echo esc_attr($pick_up) ?>" value=''>
			<input type="hidden" name="county_drop_off" class="county_drop_off" data-address="<?php echo esc_attr($drop_off) ?>" value=''>
					<div class="div_book">
						<div class="booking-meta">
							<?php
							if($is_new_layout) : ?>
								<div class="meta-item">
									<div class="meta-title">
										<?php echo esc_html(__('Location', 'traveler')) ?>
									</div>
									<div class="meta-value">
										<div class="st-select-wrapper select-location">
											<input id="field-car-dropoff" data-children="location_id" data-clear="clear" autocomplete="off"
													type="text" name="pick-up" value="<?php echo esc_html($location_name); ?>"
													class="form-control st-location-name-js">
											<select data-current-country="" name="location_id" class="st-location-id st-hidden" tabindex="-1">
													<option value=""></option>
													<?php
													if ($enable_tree == 'on') {
														TravelHelper::buildTreeOptionLocation($list_locations, $location_id);
													} else {
														if (is_array($list_locations) && count($list_locations)):
															foreach ($list_locations as $key => $value):?>
																<option <?php selected($value->ID, $location_id); ?>
																		data-country="<?php echo esc_html($value->Country); ?>"
																		value="<?php echo esc_html($value->ID); ?>"><?php echo esc_html($value->fullname); ?></option>
																<?php
															endforeach;
														endif;
													} ?>
											</select>
											<div class="option-wrapper"></div>
										</div>
									</div>
								</div>
								<?php
							else : ?>
								<div class="meta-item">
									<div class="meta-title">
										<?php echo esc_html(__('Pick Up', 'traveler')) ?>
									</div>
									<div class="meta-value">
										<div class="st-select-wrapper select-location">
											<input id="field-car-dropoff" data-children="location_id_drop_off" data-clear="clear" autocomplete="off"
													type="text" name="pick-up" value="<?php echo esc_html($pick_up); ?>"
													class="form-control st-location-name-js">
											<select data-current-country="" name="location_id_pick_up" class="st-location-id st-hidden" tabindex="-1">
													<option value=""></option>
													<?php
													if ($enable_tree == 'on') {
														TravelHelper::buildTreeOptionLocation($list_locations, $location_id_pick_up);
													} else {
														if (is_array($list_locations) && count($list_locations)):
															foreach ($list_locations as $key => $value): ?>
																<option <?php selected($value->ID, $location_id_pick_up); ?>
																		data-country="<?php echo esc_html($value->Country); ?>"
																		value="<?php echo esc_html($value->ID); ?>"><?php echo esc_html($value->fullname); ?></option>
																<?php
															endforeach;
														endif;
													} ?>
											</select>
											<div class="option-wrapper"></div>
										</div>
									</div>
								</div>
								<div class="meta-item">
									<div class="meta-title">
										<?php echo esc_html(__('Drop Off', 'traveler')) ?>
									</div>
									<div class="meta-value">
										<div class="st-select-wrapper select-location">
											<input id="field-car-pickup" data-parent="location_id_pick_up" data-clear="clear" autocomplete="off"
													type="text" name="drop-off" value="<?php echo esc_html($drop_off); ?>"
													class="form-control st-location-name-js">
											<select data-current-country="<?php if ($location_country) echo esc_html($location_country); ?>"
														name="location_id_drop_off" class="st-location-id st-hidden " tabindex="-1">
												<option value=""></option>
												<?php
												if ($enable_tree == 'on') {
														TravelHelper::buildTreeOptionLocation($list_locations, $location_id_drop_off);
												} else {
													if (is_array($list_locations) && count($list_locations)):
														foreach ($list_locations as $key => $value): ?>
															<option <?php selected($value->ID, $location_id_drop_off); ?>
																	data-country="<?php echo esc_html($value->Country); ?>"
																	value="<?php echo esc_html($value->ID); ?>"><?php echo esc_html($value->fullname); ?></option>
															<?php
														endforeach;
													endif;
												} ?>
											</select>
											<div class="option-wrapper"></div>
										</div>
									</div>
								</div>
								<?php
							endif; ?>
							<div class="meta-item">
								<div class="meta-title">
								</div>
								<div class="meta-value form-date-inbox-rental" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" >
									<div class="date-wrapper clearfix btn btn-primary btn-sm">
										<div class="check-in-wrapper">
											<?php echo __('Select date', 'traveler'); ?>
										</div>
									</div>
									<input type="text" class="check-in-out"
											style="width: 100%;position: absolute;right: 0;z-index: -1;opacity: 0;"
											data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
											data-post-id="<?php echo esc_attr($post_id) ?>"
											value="" name="date">
								</div>
							</div>
							<div class="meta-item">
								<div class="meta-title">
									<?php echo __('Pick Up Date'); ?>
								</div>
								<div class="meta-value">
									<p class="pick-up-date-render"><?php echo esc_html($pick_up_date) ?></p>
								</div>
							</div>
							<div class="meta-item">
								<div class="meta-title">
									<?php echo __('Pick Up Time'); ?>
								</div>
								<div class="meta-value">
									<p class="pick-up-time-render"><?php echo esc_html($pick_up_time) ?></p>
								</div>
							</div>
							<div class="meta-item">
								<div class="meta-title">
									<?php echo __('Drop Off Date'); ?>
								</div>
								<div class="meta-value">
									<p class="drop-off-date-render"><?php echo esc_html($drop_off_date) ?></p>
								</div>
							</div>
							<div class="meta-item">
								<div class="meta-title">
									<?php echo __('Drop Off Time'); ?>
								</div>
								<div class="meta-value">
									<p class="drop-off-time-render"><?php echo esc_html($drop_off_time) ?></p>
								</div>
							</div>
							<?php
							if ( isset($list_equipments) && is_array($list_equipments) && count($list_equipments) > 0) : ?>
								<div class="meta-item">
									<div class="meta-title"><?php echo __('Equipments', 'traveler') ?></div>
									<div class="meta-value"></div>
								</div>
								<div class="meta-item">
									<div class="meta-title"></div>
									<div class="meta-value car-equipment">
										<?php
										if ($is_new_layout) : ?>
											<ul class="extras">
												<?php
												foreach ( $list_equipments as $key => $val ):
													if ( isset( $val[ 'extra_required' ] ) && $val[ 'extra_required' ] == 'on' ) : ?>
														<li class="item mt10">
																<div class="st-flex space-between">
																		<span><?php echo esc_attr($val['title']); ?>(<?php echo TravelHelper::format_money( $val[ 'extra_price' ] ) ?>) <span class="c-orange">*</span> </span>
																		<div class="select-wrapper" style="width: 50px;">
																				<?php
																				$max_item = intval( $val[ 'extra_max_number' ] );
																				if ( $max_item <= 0 ) $max_item = 1;
																				?>
																				<select class="form-control app extra-service-select"
																								name="extra_price[value][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																								id="field-<?php echo esc_attr($val[ 'extra_name' ]); ?>"
																								data-extra-price="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
																						<?php
																						$max_item = intval( $val[ 'extra_max_number' ] );
																						if ( $max_item <= 0 ) $max_item = 1;
																						$start_i = 0;
																						if ( isset( $val[ 'extra_required' ] ) ) {
																								if ( $val[ 'extra_required' ] == 'on' ) {
																										$start_i = 1;
																								}
																						}
																						for ( $i = $start_i; $i <= $max_item; $i++ ):
																								$check = "";
																								if ( !empty( $extra_value[ $val[ 'extra_name' ] ] ) and $i == $extra_value[ $val[ 'extra_name' ] ] ) {
																										$check = "selected";
																								}
																								?>
																								<option <?php echo esc_html( $check ) ?>
																												value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
																						<?php endfor; ?>
																				</select>
																		</div>
																</div>
																<input type="hidden" name="extra_price[price][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
																<input type="hidden" name="extra_price[title][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php echo esc_attr($val[ 'title' ]); ?>">
																<input type="hidden" name="extra_price[price_type][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php if(isset($val[ 'extra_price_type' ])){echo esc_attr($val[ 'extra_price_type' ]);}  ?>">
														</li>
														<?php
													else : ?>
														<li class="item mt10">
																<div class="st-flex space-between">
																		<span><?php echo esc_attr($val['title']); ?>(<?php echo TravelHelper::format_money( $val[ 'extra_price' ] ) ?>)</span>
																		<div class="select-wrapper" style="width: 50px;">
																				<?php
																				$max_item = intval( $val[ 'extra_max_number' ] );
																				if ( $max_item <= 0 ) $max_item = 1;
																				?>
																				<select class="form-control app extra-service-select"
																								name="extra_price[value][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																								id="field-<?php echo esc_attr($val[ 'extra_name' ]); ?>"
																								data-extra-price="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
																						<?php
																						$max_item = intval( $val[ 'extra_max_number' ] );
																						if ( $max_item <= 0 ) $max_item = 1;
																						$start_i = 0;
																						if ( isset( $val[ 'extra_required' ] ) ) {
																								if ( $val[ 'extra_required' ] == 'on' ) {
																										$start_i = 1;
																								}
																						}
																						for ( $i = $start_i; $i <= $max_item; $i++ ):
																								$check = "";
																								if ( !empty( $extra_value[ $val[ 'extra_name' ] ] ) and $i == $extra_value[ $val[ 'extra_name' ] ] ) {
																										$check = "selected";
																								}
																								?>
																								<option <?php echo esc_html( $check ) ?>
																												value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
																						<?php endfor; ?>
																				</select>
																		</div>
																</div>
																<input type="hidden" name="extra_price[price][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php echo esc_attr($val[ 'extra_price' ]); ?>">
																<input type="hidden" name="extra_price[title][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php echo esc_attr($val[ 'title' ]); ?>">

																<input type="hidden" name="extra_price[price_type][<?php echo esc_attr($val[ 'extra_name' ]); ?>]"
																			value="<?php if(isset($val[ 'extra_price_type' ])){echo esc_attr($val[ 'extra_price_type' ]);}  ?>">
														</li>
														<?php
													endif; ?>
													<?php
												endforeach; ?>
											</ul>
											<?php
										else:
											if(!empty($list_equipments)){
												foreach($list_equipments as $k=>$v){
														$check_e = '';
														$number_check = 1;
														if(in_array($v['title'], array_keys($arr_equip_title))) {
																									$check_e = 'checked';
																									$number_check = $arr_equip_title[$v['title']]['number'];
																							}
													$v['cars_equipment_list_price'] = apply_filters('st_apply_tax_amount',$v['cars_equipment_list_price']);

													$price_unit = isset($v['price_unit'])? $v['price_unit']: '';
													$price_max = isset($v['cars_equipment_list_price_max'])? $v['cars_equipment_list_price_max']: '';

													$price_unit_html='';
													switch($price_unit)
													{
														case "per_hour":
															$price_unit_html=__('/hour','traveler');
															$time_per_unit =STCars::get_date_diff($start,$end, $price_unit);
															break;
														case "per_day":
															$price_unit_html=__('/day','traveler');
															$time_per_unit =STCars::get_date_diff($start,$end, $price_unit);
															break;
														default:
															$price_unit_html='';
															$time_per_unit = '1';
															break;
													}
													echo '<div class="car-equipment-list clearfix">';
													//Add price convert equipment
													echo '<div class="checkbox">
																		<label>
																			<input '. esc_attr($check_e) .' class="car-i-check car-equipment" data-price-max="'.esc_attr($price_max).'" data-number-unit="'. esc_attr($time_per_unit) .'" data-price-unit="'.esc_attr($price_unit).'" data-title="'.esc_attr($v['title']).'" data-price="'. esc_attr($v['cars_equipment_list_price']) . '" data-convert-price="'. esc_attr(TravelHelper::convert_money_from_to($v['cars_equipment_list_price'])) .'" type="checkbox" />'.balanceTags($v['title']).'
																			<span class="pull-right">'.TravelHelper::format_money($v['cars_equipment_list_price']).''.balanceTags($price_unit_html).'</span></label>
															</div>';
													if( !empty($v['cars_equipment_list_number']) && (int) $v['cars_equipment_list_number'] > 1){
														echo '<select class="pull-right" name="number_equipment">';
														$numbers = (int) $v['cars_equipment_list_number'];
														for($i = 1; $i <= $numbers; $i++){
																$check_item = '';
																if($i == $number_check)
																		$check_item = 'selected';
															echo '<option value ="'.esc_attr($i).'" '. $check_item .'>'.esc_html($i).'</option>';
														}
														echo '</select>';
													}
													echo '</div>';
												}
											}
										endif;
										?>
										<div class="cars_equipment_display"></div>
									</div>
								</div>
								<?php
							endif; ?>
						</div>
						<div class="message_box mt10"></div>
						<?php echo STTemplate::message(); ?>
						<div class="div_btn_book_tour">
							<?php
							$car_external_booking = get_post_meta($post_id, 'st_car_external_booking', "off");
							if($st_is_booking_modal && $car_external_booking == 'off'){
								?>
																<a href="#car_booking_<?php echo esc_attr($post_id); ?>" class="btn btn-primary btn-st-add-cart" onclick="return false" data-target=#car_booking_<?php echo esc_attr($post_id); ?>  data-effect="mfp-zoom-out" ><?php st_the_language('book_now') ?> <i class="fa fa-spinner fa-spin"></i></a>
							<?php }else{ ?>
								<?php
								$car_external_booking = get_post_meta($post_id, 'st_car_external_booking', "off");
								$car_external_booking_link = get_post_meta($post_id, 'st_car_external_booking_link', true);
								$return = '';
								if ($car_external_booking == "on" && $car_external_booking_link !== "") {
									if (get_post_meta($post_id, 'st_car_external_booking_link', true)) {
										ob_start();
										?>
										<a class='btn btn-primary' href='<?php echo esc_url(get_post_meta($post_id, 'st_car_external_booking_link', true)); ?>'> <?php st_the_language('book_now') ?></a>
										<?php
										$return = ob_get_clean();
									}
								} else {
									$return = TravelerObject::get_book_btn($post_id);
								}
								echo htmlspecialchars_decode($return);
																?>
							<?php } ?>
							<?php //echo st()->load_template('user/html/html_add_wishlist',null,array("title"=>"")) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div id="list_rental_item" data-type-tour="" style="display: none; width: 500px; height: auto;">
		<div id="single-tour-calendar">
			<?php echo st()->load_template('vc-elements/st-rental/st_rental_calendar', null, array('post_id' => $post_id, 'select_date' => 'group_day')); ?>
			<style>
				.qtip {
					max-width: 250px !important;
				}
			</style>
		</div>
	</div>
<?php } else {?>
	<form id="form-booking-inpage" method="post" action="" class="car_booking_form" <?php echo esc_attr($car_data_type); ?>>
        <div class="st-inbox-form-book">
            <?php if(!empty($bg_thumb)){ ?>
                <a href="<?php echo get_the_permalink($post_id); ?>">
                    <div class="thumb" style="background-image: url('<?php echo esc_url($bg_thumb); ?>')"></div>
                </a>
            <?php } ?>
            <h3><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
            <div class="section">
                <div class="package-book-now-button">
                    <div class="div_book">
                        <div class="div_btn_book_tour booking-meta">
                            <a href="<?php echo esc_url($activity_external_link); ?>"
                                    class="btn btn-primary"><?php echo esc_html__( 'External Booking', 'traveler' ) ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php }?>

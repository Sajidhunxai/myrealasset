<?php
wp_enqueue_script('single-hotel-detail');
wp_enqueue_style('owlcarousel');
wp_enqueue_script('owlcarousel');
while (have_posts()): the_post();
    $room_id = get_the_ID();
    $hotel_id = get_post_meta(get_the_ID(), 'room_parent', true);
    $thumbnail = get_the_post_thumbnail_url($room_id, 'full');

    $adult_number = STInput::request('adult_number', 1);
    $child_number = STInput::request('child_number', '');

    $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
    $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

    $start = STInput::get('start', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
    $end = STInput::get('end', date(TravelHelper::getDateFormat(), strtotime("+ 1 day", strtotime($current_calendar))));
    $date = STInput::get('date', date('d/m/Y h:i a', strtotime($current_calendar)) . '-' . date('d/m/Y h:i a', strtotime('+1 day', strtotime($current_calendar))));
    $room_num_search = (int)STInput::get('room_num_search', 1);
    if ($room_num_search <= 0) $room_num_search = 1;
    $start = TravelHelper::convertDateFormat($start);
    $end = TravelHelper::convertDateFormat($end);
    $price_by_per_person = get_post_meta($room_id, 'price_by_per_person', true);
    $total_price = STPrice::getRoomPriceOnlyCustomPrice($room_id, strtotime($start), strtotime($end), $room_num_search, $adult_number, $child_number);
    $sale_price = STPrice::getRoomPrice($room_id, strtotime($start), strtotime($end), $room_num_search, $adult_number, $child_number);


    $gallery = get_post_meta($room_id, 'gallery', true);
    $gallery_array = explode(',', $gallery);

    $room_external = get_post_meta(get_the_ID(), 'st_room_external_booking', true);
    $room_external_link = get_post_meta(get_the_ID(), 'st_room_external_booking_link', true);

    $booking_type = st_get_booking_option_type();
    $numberday = STDate::dateDiff($start, $end);
    $total_person = intval($adult_number) + intval($child_number);
    $address = get_post_meta($room_id, 'address', true);
    $thumb_id = get_post_thumbnail_id(get_the_ID());
    ?>
    <div id="st-content-wrapper" class="st-style-elementor st-style-4">
        <?php echo stt_elementorv2()->loadView('components/banner');?>

        <div class="container-fluid">
            <?php echo stt_elementorv2()->loadView('services/common/single/gallery-2', array('style' => 'slider')) ?>
        </div>

        <div class="container">
			<?php
			$menu_transparent = st()->get_option( 'menu_transparent', '' );
			$class            = $menu_transparent !== 'on' ? '' : 'pt-5';
			?>
            <div class="st-hotel-room-content style-4 <?= esc_html( $class ) ?>">
                <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center d-none">
                    <div class="price-wrapper">
                        <div id="mobile-price">
                            <?php
                            if ($price_by_per_person == 'on') :
                                echo __('From:', 'traveler');
                                echo sprintf('<span class="price">%s</span>', TravelHelper::format_money($sale_price));
                                echo '<span class="unit">';
                                echo sprintf(_n('/person', '/%d persons', $total_person, 'traveler'), $total_person);
                                echo sprintf(_n('/night', '/%d nights', $numberday, 'traveler'), $numberday);
                                echo '</span>';
                            else:
                                echo __('From:', 'traveler');
                                echo sprintf('<span class="price">%s</span>', TravelHelper::format_money($sale_price));
                                echo '<span class="unit">';
                                echo sprintf(_n('/night', '/%d nights', $numberday, 'traveler'), $numberday);
                                echo '</span>';
                            endif; ?>
                        </div>
                    </div>
                    <?php
                    if ($room_external == 'off' || empty($room_external)) {
                        ?>
                        <a href=""
                            class="btn-v2 btn-primary btn-mpopup btn-green">
                            <?php
                                if($booking_type == 'enquire'){
                                    echo esc_html__('Inquiry', 'traveler');
                                } else {
                                    echo esc_html__('Check', 'traveler');
                                }
                            ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo esc_url($room_external_link); ?>"
                           class="btn-v2 btn btn-green"><?php echo esc_html__('Check', 'traveler') ?></a>
                        <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <?php echo stt_elementorv2()->loadView('services/room/single/items/top-info', array(
                            'address' => $address,
                        )) ?>

                        <div class="room-featured-items">
                            <div class="item">
                                <span class="stt-icon stt-icon-area"></span>
                                <?php echo sprintf(__('S: %s', 'traveler'), get_post_meta($room_id, 'room_footage', true)) ?><?php echo __('m', 'traveler') ?>
                                <sup>2</sup>
                            </div>
                            <div class="item">
                                <span class="stt-icon stt-icon-bed"></span>
                                <?php echo sprintf(__('Beds: %s', 'traveler'), get_post_meta($room_id, 'bed_number', true)) ?>
                            </div>
                            <div class="item">
                                <span class="stt-icon stt-icon-adult"></span>
                                <?php echo sprintf(__('Adults: %s', 'traveler'), get_post_meta($room_id, 'adult_number', true)) ?>
                            </div>
                            <div class="item">
                                <span class="stt-icon stt-icon-baby"></span>
                                <?php echo sprintf(__('Children: %s', 'traveler'), get_post_meta($room_id, 'children_number', true)) ?>
                            </div>
                        </div>

                        <?php echo stt_elementorv2()->loadView('services/common/single/description', ['title' => esc_html__('About this room', 'traveler')]) ?>

                        <?php echo stt_elementorv2()->loadView('services/common/single/attributes', ['post_type' => 'hotel_room']) ?>

                        <?php echo stt_elementorv2()->loadView('services/room/single/items/rate-2', [
                            'hotel_id' => $hotel_id,
                            'room_id' => $room_id
                        ]); ?>

                        <?php echo stt_elementorv2()->loadView('services/room/single/items/discount'); ?>

                        <div class="stoped-scroll-section"></div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="widgets">
                            <div class="fixed-on-mobile st-fixed-form-booking" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
                                </div>

                                <?php
                                echo stt_elementorv2()->loadView('services/room/single/items/form-book', [
                                    'price_by_per_person' => $price_by_per_person,
                                    'sale_price' => $sale_price,
                                    'numberday' => $numberday,
                                    'hotel_id' => $hotel_id,
                                    'room_id' => $room_id,
                                    'room_external' => $room_external,
                                    'room_external_link' => $room_external_link,
                                    'total_person' => $total_person,
                                    'booking_type' => $booking_type
                                ]);
                                ?>
                            </div>
                        </div>
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info','',array('size_avatar_custom' => 90)); ?>
                    </div>
                </div>
                <?php echo stt_elementorv2()->loadView('services/room/single/items/relate', [
                    'hotel_id' => $hotel_id,
                    'room_id' => $room_id
                ]) ?>
            </div>
        </div>
    </div>
<?php
endwhile;

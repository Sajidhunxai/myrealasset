<?php extract(shortcode_atts(array(
    'style' => '',
    'number_show_room' => '',
    'service_id' => '',
), $attr));
global $wp_query;
$rooms = Hotel_Alone_Helper::inst()->seach_room_hotel_activity_by_id($service_id, $number_show_room);
$list_extra = [];
$list_extra = get_post_meta(get_the_ID(), 'extra_price', true);
$hotel_id = get_post_meta(get_the_ID(), 'room_parent', true);
$booking_directly = st()->get_option('st_hotel_alone_directly_book_now', 'off');
$check_in = STInput::request('checkin_y') . "-" . STInput::request('checkin_m') . "-" . STInput::request('checkin_d');
$check_in_temp = $check_in;
if ($check_in == '--') $check_in = ''; else$check_in = date(TravelHelper::getDateFormat(), strtotime($check_in));
if (empty($check_in)) {
    $check_in = date(TravelHelper::getDateFormat());
}
$check_out = STInput::request('checkout_y') . "-" . STInput::request('checkout_m') . "-" . STInput::request('checkout_d');
$check_out_temp = $check_out;
if ($check_out == '--') $check_out = ''; else$check_out = date(TravelHelper::getDateFormat(), strtotime($check_out));
if (empty($check_out)) {
    $check_out = date(TravelHelper::getDateFormat(), strtotime('+1 day', strtotime(date('Y-m-d'))));
} ?>
<?php
if ($style === 'style-3') {
    if (!empty($rooms)) {
        if ($rooms['status']) { ?>
            <div class="single-hotel-list-room style-3">
                <div class="list-room-content sts-room-wrapper owl-carousel">
                    <?php
                    if ($rooms['data']->have_posts()) {
                        while ($rooms['data']->have_posts()) {
                            $rooms['data']->the_post();
                            $url = add_query_arg([
                                'checkin_d' => STInput::request('checkin_d'),
                                'checkin_m' => STInput::request('checkin_m'),
                                'checkin_y' => STInput::request('checkin_y'),
                                'checkin' => STInput::request('checkin'),
                                'checkout_d' => STInput::request('checkout_d'),
                                'checkout_m' => STInput::request('checkout_m'),
                                'checkout_y' => STInput::request('checkout_y'),
                                'checkout' => STInput::request('checkout'),
                                'check_in' => $check_in,
                                'check_out' => $check_out,
                                'room_number' => STInput::request('room_number', 1),
                                'room_num_search' => STInput::request('room_number', 1),
                                'check_in_out' => STInput::request('check_in_out'),
                                'adults' => STInput::request('adults', 1),
                                'children' => STInput::request('children', 0),
                                'adult_number' => STInput::request('adults', 1),
                                'child_number' => STInput::request('children', 0),
                            ], get_permalink());
                            ?>
                            <div class="items">
                                <div class="thumb">
                                    <a href="<?php echo esc_url($url); ?>" title="<?php the_title(); ?>">
                                            <?php
                                            if (has_post_thumbnail() and get_the_post_thumbnail()) {
                                                the_post_thumbnail(array(370, 208, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
                                            } else {
                                                if (function_exists('st_get_default_image'))
                                                    echo st_get_default_image();
                                            }
                                            ?>
                                    </a>
                                    <span class="price">
                                            <?php
                                            $price = get_post_meta(get_the_ID(), 'price', true);
                                            echo TravelHelper::format_money($price);
                                            ?>
                                            <span class="text"><?php esc_html_e("/night", 'traveler') ?></span>
                                        </span>
                                </div>

                                <div class="info-item">
                                    <a href="<?php echo esc_url($url); ?>" title="<?php the_title(); ?>">
                                        <div class="info">
                                            <h4><?php the_title(); ?></h4>
                                        </div>
                                    </a>
                                    <?php
                                    $room_type = get_the_terms(get_the_ID(),'room_type');
                                    if(!is_wp_error($room_type)){
                                        if(!empty($room_type)){

                                            ?>
                                            <p class="room-type">
                                                <?php echo esc_html($room_type[0]->name) ?>
                                            </p>
                                        <?php  }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        } else { ?>
            <div class="row">
                <div class="search_room_alert_new">
                    <div class="alert alert-danger"><?php echo esc_attr($rooms['message']); ?></div>
                </div>
            </div>
            <?php
        }
    }
} elseif ($style === 'style-2') {
    if (!empty($rooms)) {
        if ($rooms['status']) { ?>
            <div class="hotel-activity-list-room style-2">
                <div class="list-room-header">
                    <div class="header-left">
                        <h2 class="title">
                            <?php _e("Our Apartments", 'traveler') ?>
                        </h2>
                        <p class="description">
                            <?php echo sprintf(__("Our offers %s apartments in center the city", 'traveler'), $number_show_room) ?>
                        </p>
                    </div>
                    <div class="header-right">
                        <ul class="nav nav-tabs">
                            <?php
                            if ($rooms['data']->have_posts()) :
                                while ($rooms['data']->have_posts()) : $rooms['data']->the_post(); ?>
                                    <li class="<?php echo ($rooms['data']->current_post === 0) ? 'active' : '' ?>">
                                        <a href="#tab-<?php echo get_the_ID() ?>"
                                           data-toggle="tab"><?php echo intval($rooms['data']->current_post + 1) ?></a>
                                    </li>
                                <?php
                                endwhile; ?>
                                <li class="ico-next">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/v2/images/assets/ico_next.svg') ?>"
                                         alt="ico-next">
                                </li>
                            <?php
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="list-room-content sts-room-wrapper">
                    <div class="row">
                        <div class="tab-content">
                            <?php
                            if ($rooms['data']->have_posts()) {
                                while ($rooms['data']->have_posts()) {
                                    $rooms['data']->the_post();
                                    $url = add_query_arg([
                                        'checkin_d' => STInput::request('checkin_d'),
                                        'checkin_m' => STInput::request('checkin_m'),
                                        'checkin_y' => STInput::request('checkin_y'),
                                        'checkin' => STInput::request('checkin'),
                                        'checkout_d' => STInput::request('checkout_d'),
                                        'checkout_m' => STInput::request('checkout_m'),
                                        'checkout_y' => STInput::request('checkout_y'),
                                        'checkout' => STInput::request('checkout'),
                                        'check_in' => $check_in,
                                        'check_out' => $check_out,
                                        'room_number' => STInput::request('room_number', 1),
                                        'room_num_search' => STInput::request('room_number', 1),
                                        'check_in_out' => STInput::request('check_in_out'),
                                        'adults' => STInput::request('adults', 1),
                                        'children' => STInput::request('children', 0),
                                        'adult_number' => STInput::request('adults', 1),
                                        'child_number' => STInput::request('children', 0),
                                    ], get_permalink());
                                    ?>
                                    <div class="col-xs-12 tab-pane fade<?php echo ($rooms['data']->current_post === 0) ? ' in active' : '' ?>"
                                         id="tab-<?php echo get_the_ID(); ?>">
                                        <div class="item-list-room">
                                            <?php
                                            if (has_post_thumbnail() and get_the_post_thumbnail()) {
                                                the_post_thumbnail('medium_large', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
                                            } else {
                                                if (function_exists('st_get_default_image'))
                                                    echo st_get_default_image();
                                            }
                                            ?>
                                            <div class="item item-list-room-overlay">
                                                <div class="info">
                                                    <div class="header">
                                                                <span class="price">
                                                                    <?php
                                                                    $price = get_post_meta(get_the_ID(), 'price', true);
                                                                    echo TravelHelper::format_money($price);
                                                                    ?>
                                                                </span>
                                                        <span class="text">
                                                                    <?php _e('PER NIGHT', 'traveler') ?>
                                                                </span>
                                                    </div>
                                                    <h3 class="title">
                                                        <a href="<?php echo esc_url(get_the_permalink()) ?>">
                                                            <?php the_title(); ?>
                                                        </a>
                                                    </h3>
                                                    <div class="desc">
                                                        <?php echo wp_trim_words(get_the_content(), 20, '...') ?>
                                                    </div>
                                                    <?php
                                                    echo st()->load_template('layouts/modern/single_hotel/room/facility');
                                                    ?>
                                                    <div class="action">
                                                        <div class="message alert alert-danger"></div>
                                                        <?php
                                                        $room_external = get_post_meta(get_the_ID(), 'st_room_external_booking', true);
                                                        $room_external_link = get_post_meta(get_the_ID(), 'st_room_external_booking_link', true);
                                                        if ($room_external == 'on' && !empty($room_external_link)) {
                                                            ?>
                                                            <a class="btn btn-white sts-btn"
                                                               href="<?php echo esc_url($room_external_link); ?>"><span><?php echo __('VIEW MORE', 'traveler'); ?></span></a>
                                                            <?php
                                                        } else {
                                                            if (isset($_GET['check_in']) && isset($_GET['check_out'])) {
                                                                if ($booking_directly == 'on') {
                                                                    //$remaining_room = isset($post->remaining_number) ? $post->remaining_number : get_post_meta(get_the_ID(), 'number_room', true);
                                                                    $remaining_room = get_post_meta(get_the_ID(), 'number_room', true);
                                                                    $remaining_room = (int)$remaining_room;
                                                                    ?>
                                                                    <form class="form-booking-inpage hotel-alone-booking-inpage"
                                                                          method="post">
                                                                        <input type="hidden" name="check_in"
                                                                               value="<?php echo STInput::get('check_in'); ?>">
                                                                        <input type="hidden" name="check_out"
                                                                               value="<?php echo STInput::get('check_out'); ?>">
                                                                        <input type="hidden" name="adult_number"
                                                                               value="<?php echo STInput::get('adult_num_search', 1); ?>">
                                                                        <input type="hidden" name="child_number"
                                                                               value="<?php echo STInput::get('children_num_search', 0); ?>">
                                                                        <input type="hidden" name="require_guest_name"
                                                                               value="no">
                                                                        <input name="action" value="st_add_to_cart"
                                                                               type="hidden">
                                                                        <input name="item_id"
                                                                               value="<?php echo get_post_meta(get_the_ID(), 'room_parent', true); ?>"
                                                                               type="hidden">
                                                                        <input name="room_id"
                                                                               value="<?php echo get_the_ID(); ?>"
                                                                               type="hidden">
                                                                        <input type="hidden" name="start"
                                                                               value="<?php echo STInput::get('check_in'); ?>">
                                                                        <input type="hidden" name="end"
                                                                               value="<?php echo STInput::get('check_out'); ?>">
                                                                        <input type="hidden" name="is_search_room"
                                                                               value="true">
                                                                        <select class="form-control"
                                                                                name="room_num_search">
                                                                            <?php
                                                                            $room_num_search = STInput::get('room_num_search', '');
                                                                            for ($i = 1; $i <= $remaining_room; $i++) {
                                                                                $selected = '';
                                                                                if ($room_num_search == $i)
                                                                                    $selected = 'selected';
                                                                                echo '<option value="' . esc_attr($i) . '" ' . ($selected) . '>' . esc_html($i) . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <a class="btn btn-default btn-booknow sts-btn"
                                                                           href="<?php echo esc_url($url); ?>"><span><?php echo __('BOOK NOW', 'traveler'); ?><i
                                                                                        class="fa fa-spinner fa-spin"></i></span></a>
                                                                        <?php echo st()->load_template('layouts/modern/single_hotel/elements/extras', ''); ?>
                                                                    </form>
                                                                <?php } else { ?>
                                                                    <a class="btn btn-white sts-btn"
                                                                       href="<?php echo esc_url($url); ?>"><span><?php echo __('VIEW MORE', 'traveler'); ?></span></a>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <a class="btn btn-white sts-btn"
                                                                   href="<?php echo esc_url($url); ?>"><span><?php echo __('VIEW MORE', 'traveler'); ?></span></a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else { ?>
            <div class="row">
                <div class="search_room_alert_new">
                    <div class="alert alert-danger"><?php echo esc_attr($rooms['message']); ?></div>
                </div>
            </div>
            <?php
        }
    }
} else { ?>
    <div class="row" style="margin-top: 30px;">
        <?php if (!empty($rooms)) {
            if ($rooms['status']) {
                if ($rooms['data']->have_posts()) {
                    while ($rooms['data']->have_posts()) {
                        $rooms['data']->the_post();
                        $url = add_query_arg([
                            'checkin_d' => STInput::request('checkin_d'),
                            'checkin_m' => STInput::request('checkin_m'),
                            'checkin_y' => STInput::request('checkin_y'),
                            'checkin' => STInput::request('checkin'),
                            'checkout_d' => STInput::request('checkout_d'),
                            'checkout_m' => STInput::request('checkout_m'),
                            'checkout_y' => STInput::request('checkout_y'),
                            'checkout' => STInput::request('checkout'),
                            'check_in' => $check_in,
                            'check_out' => $check_out,
                            'room_number' => STInput::request('room_number', 1),
                            'room_num_search' => STInput::request('room_number', 1),
                            'check_in_out' => STInput::request('check_in_out'),
                            'adults' => STInput::request('adults', 1),
                            'children' => STInput::request('children', 0),
                            'adult_number' => STInput::request('adults', 1),
                            'child_number' => STInput::request('children', 0),
                        ], get_permalink());

                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="item-room">
                                <a href="<?php echo esc_url($url); ?>" title="<?php the_title(); ?>">
                                    <div class="img-thumnail">
                                        <?php
                                        if (has_post_thumbnail() and get_the_post_thumbnail()) {
                                            the_post_thumbnail(array(370, 370, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
                                        } else {
                                            if (function_exists('st_get_default_image'))
                                                echo st_get_default_image();
                                        }
                                        ?>
                                    </div>
                                    <div class="info-item">
                                        <div class="info">
                                        <span class="price"><?php esc_html_e("From", 'traveler') ?>
                                            <?php
                                            $price = get_post_meta(get_the_ID(), 'price', true);
                                            echo TravelHelper::format_money($price);
                                            ?>
                                        </span>
                                            <h4><?php the_title(); ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }

                }
                wp_reset_postdata();
            } else {
                ?>
                <div class="search_room_alert_new">
                    <div class="alert alert-danger"><?php echo esc_attr($rooms['message']); ?></div>
                </div>
                <?php
            }
        } ?>
    </div>
    <?php
} ?>
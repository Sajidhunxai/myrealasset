<?php

/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 10/29/2018
 * Time: 10:56 AM
 */
class New_Layout_Helper {
    /* NgoThoai */

    static function isRoomAloneLayout($post_id = false) {
        if (empty($post_id))
            $post_id = get_the_ID();
        $hotel_parent = get_post_meta($post_id, 'room_parent', true);
        if (!empty($hotel_parent)) {
            $hotel_alone_in_setting = st()->get_option('hotel_alone_assign_hotel', '');
            if ($hotel_alone_in_setting == $hotel_parent) {
                $is_room_alone = get_post_meta($post_id, 'hotel_alone_room_layout', true);
                if ($is_room_alone == 'on') {
                    return true;
                }
            }
        }
        return false;
    }

    static function isLayoutHotelActivity() {
        $check = false;
        if (is_page_template('template-hotel-activity.php') || is_page_template('template-single-hotel-modern.php')) {
            $check = true;
        }

        $hotel_parent = st()->get_option('hotel_alone_assign_hotel');
        if ((is_page_template('template-checkout.php') || is_page_template('template-confirm.php') || is_page_template('template-payment-success.php') || self::isCheckWooPage() || is_404() || is_singular('post')) && !empty($hotel_parent)) {
            $check = true;
        }

        if (self::isRoomAloneLayout()) {
            $check = true;
        }

        return $check;
    }

    static function isLayoutTourModern() {
        $check = false;
        if (is_page_template('template-single-tour-modern.php') || is_singular('post')) {
            $check = true;
        }

        return $check;
    }

    static function enqueueTourModern() {
        wp_localize_script('jquery', 'st_checkout_text', [
            'without_pp' => __('Submit Request', 'traveler'),
            'with_pp' => __('Booking Now', 'traveler'),
            'validate_form' => __('Please fill all required fields', 'traveler'),
            'error_accept_term' => __('Please accept our terms and conditions', 'traveler'),
            'email_validate' => __('Email is not valid', 'traveler'),
            'adult_price' => __('Adult', 'traveler'),
            'child_price' => __("Child", 'traveler'),
            'infant_price' => __("Infant", 'traveler'),
            'adult' => __("Adult", 'traveler'),
            'child' => __("Child", 'traveler'),
            'infant' => __("Infant", 'traveler'),
            'price' => __("Price", 'traveler'),
            'origin_price' => __("Origin Price", 'traveler')
        ]);
        $locale = get_locale();
            $locale_fullcalendar = $locale;
            if (substr($locale, 0, 2)) {
                $locale_fullcalendar = strtolower(substr($locale, 0, 2));
            }
        wp_localize_script('jquery', 'st_params', [
            'theme_url' => get_template_directory_uri(),
            'locale_fullcalendar' => $locale_fullcalendar,
            'caculator_price_single_ajax' => st()->get_option( 'caculator_price_single_ajax', 'off' ),
            'site_url' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'loading_url' => admin_url('/images/wpspin_light.gif'),
            'st_search_nonce' => wp_create_nonce("st_search_security"),
            'facebook_enable' => st()->get_option('social_fb_login', 'on'),
            'facbook_app_id' => st()->get_option('social_fb_app_id'),
            'booking_currency_precision' => TravelHelper::get_current_currency('booking_currency_precision'),
            'thousand_separator' => TravelHelper::get_current_currency('thousand_separator'),
            'decimal_separator' => TravelHelper::get_current_currency('decimal_separator'),
            'currency_symbol' => TravelHelper::get_current_currency('symbol'),
            'currency_position' => TravelHelper::get_current_currency('booking_currency_pos'),
            'currency_rtl_support' => TravelHelper::get_current_currency('currency_rtl_support'),
            'free_text' => __('Free', 'traveler'),
            'date_format' => TravelHelper::getDateFormatJs(),
            'date_format_calendar' => TravelHelper::getDateFormatJs(null, 'calendar'),
            'time_format' => st()->get_option('time_format', '12h'),
            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'locale' => get_locale(),
            'header_bgr' => st()->get_option('header_background', ''),
            'text_refresh' => __("Refresh", 'traveler'),
            'date_fomat' => TravelHelper::getDateFormatMoment(),
            'text_loading' => __("Loading...", 'traveler'),
            'text_no_more' => __("No More", 'traveler'),
            'weather_api_key' => st()->get_option('weather_api_key', 'a82498aa9918914fa4ac5ba584a7e623'),
            'no_vacancy' => __('No vacancies', 'traveler'),
            'a_vacancy' => __('a vacancy', 'traveler'),
            'more_vacancy' => __('vacancies', 'traveler'),
            'utm' => (is_ssl() ? 'https' : 'http') . '://shinetheme.com/utm/utm.gif',
            '_s' => wp_create_nonce('st_frontend_security'),
            'mclusmap' => get_template_directory_uri() . '/v2/images/icon_map/ico_gruop_location.svg',
            'icon_contact_map' => get_template_directory_uri() . '/v2/images/markers/ico_location_3.png',
            'text_adult' => __('Adult', 'traveler'),
            'text_adults' => __('Adults', 'traveler'),
            'text_child' => __('Children', 'traveler'),
            'text_childs' => __('Childrens', 'traveler'),
            'text_use_this_media' => __('Use this media', 'traveler'),
            'text_select_image' => __('Select Image', 'traveler'),
            'text_confirm_delete_item' => __('Are you sure want to delete this item?', 'traveler'),
            'text_process_cancel' => __('You cancelled the process', 'traveler'),
                //Set multi lang using js
        ]);
        wp_localize_script('jquery', 'st_timezone', [
            'timezone_string' => get_option('timezone_string', 'local')
        ]);
        wp_localize_script('jquery', 'st_list_map_params', [
            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'text_my_location' => __("3000 m radius", 'traveler'),
            'text_no_result' => __("No Result", 'traveler'),
            'cluster_0' => __("<div class='cluster cluster-1'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_20' => __("<div class='cluster cluster-2'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_50' => __("<div class='cluster cluster-3'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_m1' => get_template_directory_uri() . '/img/map/m1.png',
            'cluster_m2' => get_template_directory_uri() . '/img/map/m2.png',
            'cluster_m3' => get_template_directory_uri() . '/img/map/m3.png',
            'cluster_m4' => get_template_directory_uri() . '/img/map/m4.png',
            'cluster_m5' => get_template_directory_uri() . '/img/map/m5.png',
            'icon_full_screen' => get_template_directory_uri() . '/v2/images/icon_map/ico_fullscreen.svg',
            'icon_my_location' => get_template_directory_uri() . '/v2/images/icon_map/ico_location.svg',
            'icon_my_style' => get_template_directory_uri() . '/v2/images/icon_map/ico_view_maps.svg',
            'icon_zoom_out' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom-out.svg',
            'icon_zoom_in' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom_in.svg',
            'icon_close' => get_template_directory_uri() . '/v2/images/icon_map/icon_close.svg',
        ]);
        wp_localize_script('jquery', 'st_config_partner', [
            'text_er_image_format' => false,
        ]);

        wp_enqueue_style('select2.min-css', get_template_directory_uri() . '/v2/css/select2.min.css');
        wp_enqueue_style('google-font-css', 'https://fonts.googleapis.com/css?family=Playfair+Display|Poppins:400,500,600');
        wp_enqueue_style('google-font-Poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
        wp_enqueue_style('google-font-Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,700&amp;subset=latin-ext');
        wp_enqueue_style('daterangepicker-css', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.css');
        wp_enqueue_style('carousel-css', get_template_directory_uri() . '/v2/js/owlcarousel/assets/owl.carousel.min.css');
        wp_enqueue_style('theme.default-css', get_template_directory_uri() . '/v2/css/owl.theme.default.min.css');
        wp_enqueue_style('helpers-css', get_template_directory_uri() . '/v2/css/helpers.css');

        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/v2/css/bootstrap.min.css');
        wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/v2/css/font-awesome.min.css');
        wp_enqueue_style('fotorama-css', get_template_directory_uri() . '/v2/js/fotorama/fotorama.css');
        wp_enqueue_style('single-tour-modern-css', get_template_directory_uri() . '/v2/css/single-tour.css');

        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/v2/js/bootstrap.min.js', ['jquery'], null, true);
        wp_enqueue_script('fotorama-js', get_template_directory_uri() . '/v2/js/fotorama/fotorama.js', ['jquery'], null, true);
        wp_enqueue_script('owlcarousel-js', get_template_directory_uri() . '/v2/js/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
        wp_enqueue_script('moment-js', get_template_directory_uri() . '/v2/js/moment.min.js', ['jquery'], null, true);
        wp_enqueue_script('select2.full.min-js', get_template_directory_uri() . '/v2/js/select2.full.min.js', ['jquery'], null, true);
        wp_enqueue_script('daterangepicker-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.js', ['jquery'], null, true);

        wp_localize_script('jquery', 'locale_daterangepicker', [
            'direction' => (is_rtl() || st()->get_option('right_to_left') == 'on')? 'rtl': 'ltr',
            'applyLabel' => __('Apply', 'traveler'),
            'cancelLabel' => __('Cancel', 'traveler'),
            'fromLabel' => __('From', 'traveler'),
            'toLabel' => __('To', 'traveler'),
            'customRangeLabel' => __('Custom', 'traveler'),
            'daysOfWeek' =>  [__('Su', 'traveler'), __('Mo', 'traveler'), __('Tu', 'traveler'), __('We', 'traveler'), __('Th', 'traveler'), __('Fr', 'traveler'), __('Sa', 'traveler')],
            'monthNames' => [__('January', 'traveler'), __('February', 'traveler'), __('March', 'traveler'), __('April', 'traveler'), __('May', 'traveler'), __('June', 'traveler'), __('July', 'traveler'), __('August', 'traveler'), __('September', 'traveler'), __('October', 'traveler'), __('November', 'traveler'), __('December', 'traveler')],
            'firstDay' => (int)st()->get_option('start_week', 0),
            'today' => __('Today', 'traveler'),
            'buttons' => __('buttons', 'traveler'),
        ]);
        wp_enqueue_script('map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . st()->get_option('google_api_key'), ['jquery'], null, false);
        wp_enqueue_script('match-height-js', get_template_directory_uri() . '/v2/js/jquery.matchHeight.js', ['jquery'], null, true);
        wp_enqueue_script('single-tour-modern', get_template_directory_uri() . '/v2/js/single-tour.js', ['jquery'], null, true);
    }

    static function enqueueHotelActivity() {
        if (is_rtl() || st()->get_option('right_to_left') == 'on') {
            $text_rtl_mapbox = "https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js";
        } else {
            $text_rtl_mapbox = "";
        }
        wp_enqueue_style('select2-css', get_template_directory_uri() . '/js/select2-new/css/select2.min.css');
        wp_enqueue_script('select2.js', get_template_directory_uri() . '/js/select2-new/js/select2.js', ['jquery'], NULL, TRUE);
        wp_localize_script('jquery', 'hotel_alone_params', array(
            'theme_url' => get_template_directory_uri(),
            'site_url' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'loading_icon' => '<i class="fa fa-spinner fa-spin"></i>',
            'dateformat_convert' => TravelHelper::getDateFormatJs(),
            'dateformat' => TravelHelper::getDateFormatMoment(),
            'month_1' => esc_html__("Jan", 'traveler'),
            'month_2' => esc_html__("Feb", 'traveler'),
            'month_3' => esc_html__("Mar", 'traveler'),
            'month_4' => esc_html__("Apr", 'traveler'),
            'month_5' => esc_html__("May", 'traveler'),
            'month_6' => esc_html__("Jun", 'traveler'),
            'month_7' => esc_html__("Jul", 'traveler'),
            'month_8' => esc_html__("Aug", 'traveler'),
            'month_9' => esc_html__("Sep", 'traveler'),
            'month_10' => esc_html__("Oct", 'traveler'),
            'month_11' => esc_html__("Nov", 'traveler'),
            'month_12' => esc_html__("Dec", 'traveler'),
            'room_required' => esc_html__("Room number field is required!", 'traveler'),
            'add_to_cart_link' => STCart::get_cart_link(),
            'number_room_required' => __('Number room is required.', 'traveler'),
            '_s' => wp_create_nonce('st_frontend_security'),
        ));


        wp_enqueue_style('google-font-css', 'https://fonts.googleapis.com/css?family=Playfair+Display|Poppins:400,500,600');
        wp_enqueue_style('google-font-Poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
        wp_enqueue_style('google-font-Playfair', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,700&amp;subset=latin-ext');
        wp_enqueue_style('daterangepicker-css', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.css');
        wp_enqueue_style('magnific-css', get_template_directory_uri() . '/v2/css/magnific-popup.css');
        wp_enqueue_style('flickity-css', get_template_directory_uri() . '/v2/css/flickity.css');
        wp_enqueue_style('carousel-css', get_template_directory_uri() . '/v2/js/owlcarousel/assets/owl.carousel.min.css');
        wp_enqueue_style('theme.default-css', get_template_directory_uri() . '/v2/css/owl.theme.default.min.css');

        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/v2/css/bootstrap.min.css');
        wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/v2/css/font-awesome.min.css');
        wp_enqueue_style('fotorama-css', get_template_directory_uri() . '/v2/js/fotorama/fotorama.css');
        wp_enqueue_style('single-hotel-css', get_template_directory_uri() . '/v2/css/single-hotel.css');

        wp_enqueue_style('sts-single-hotel-checkout-css', get_template_directory_uri() . '/v2/css/single-hotel-checkout.css');
        wp_enqueue_style('sts-single-hotel-page', get_template_directory_uri() . '/v2/css/single-hotel-page.css');
        wp_enqueue_style('sts-fsafari-single-hotel-page', get_template_directory_uri() . '/v2/css/fsafari-single-hotel.css');
        wp_enqueue_style('sts-single-hotel-page-responsive', get_template_directory_uri() . '/v2/css/single-hotel-page-responsive.css');
        wp_enqueue_style('sts-rtl', get_template_directory_uri() . '/v2/css/rtl3.css');
        if (is_page() and is_page_template('template-member-package-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        if (is_page() and is_page_template('template-checkout-packages-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        if (is_page() and is_page_template('template-package-success-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        if (is_rtl() || st()->get_option('right_to_left') == 'on') {
            wp_enqueue_style('sts-rtl', get_template_directory_uri() . '/v2/css/rtl3.css');
        }

        wp_enqueue_style('single-hotel-responsive-css', get_template_directory_uri() . '/v2/css/single-hotel-responsive.css');
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/v2/js/bootstrap.min.js', ['jquery'], null, true);
        wp_enqueue_script('fotorama-js', get_template_directory_uri() . '/v2/js/fotorama/fotorama.js', ['jquery'], null, true);
        wp_enqueue_script('match-height-js', get_template_directory_uri() . '/v2/js/jquery.matchHeight.js', ['jquery'], null, true);
        wp_enqueue_script('owlcarousel-js', get_template_directory_uri() . '/v2/js/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
        wp_enqueue_script('flickity-js', get_template_directory_uri() . '/v2/js/flickity.pkgd.min.js', ['jquery']);
        wp_enqueue_script('masonry-js', get_template_directory_uri() . '/v2/js/masonry.pkgd.min.js', ['jquery'], null, true);
        wp_enqueue_script('moment-js', get_template_directory_uri() . '/v2/js/moment.min.js', ['jquery'], null, true);
        wp_enqueue_script('modernizr-js', get_template_directory_uri() . '/inc/modules/hotel-alone/assets/lib/mutimenu/js/modernizr.custom.js', ['jquery'], null, true);

        wp_enqueue_script('daterangepicker-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.js', ['jquery'], null, true);
        wp_enqueue_script('scrollreveal-js', get_template_directory_uri() . '/v2/js/scrollreveal.js', ['jquery'], null, true);
        wp_enqueue_script('magnific-popup-js', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', ['jquery'], null, true);

        //Load Hai Slider
        wp_register_style('sts-hai-slider', get_template_directory_uri() . '/v2/js/hai-slider/css/style.css');
        wp_enqueue_script('sts-hai-imagesloaded', get_template_directory_uri() . '/v2/js/hai-slider/js/imagesloaded.pkgd.min.js', ['jquery'], null, true);
        wp_enqueue_script('sts-hai-slider', get_template_directory_uri() . '/v2/js/hai-slider/js/vinhomeSlider.js', ['jquery'], null, true);

        wp_enqueue_script('scroll-desktop-smoothjs', get_template_directory_uri() . '/v2/js/scroll-desktop-smooth.js', ['jquery'], null, true);
        wp_enqueue_script('scroll-desktop-js', get_template_directory_uri() . '/v2/js/scroll-desktop.js', ['jquery'], null, true);
        wp_enqueue_script('single-hotel-origin', get_template_directory_uri() . '/v2/js/single-hotel.js', ['jquery'], null, true);
        wp_enqueue_script('sts-single-hotel-filter', get_template_directory_uri() . '/v2/js/filter/single-hotel.js', ['jquery'], null, true);
        wp_register_script('checkout-js', get_template_directory_uri() . '/js/init/template-checkout.js', ['jquery'], null, true);
        $google_api_key = st()->get_option('google_api_key');
        wp_enqueue_script('map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $google_api_key, ['jquery'], null, false);

        wp_enqueue_style('single-hotel-new-css', get_template_directory_uri() . '/v2/css/single-hotel-new.css');
        wp_enqueue_style('single-hotel-page-new-css', get_template_directory_uri() . '/v2/css/single-hotel-page-new.css');
        wp_enqueue_style('single-hotel-responsive-new-css', get_template_directory_uri() . '/v2/css/single-hotel-responsive-new.css');
        wp_enqueue_script('single-hotel-new-js', get_template_directory_uri() . '/v2/js/single-hotel-new.js', ['jquery'], null, true);
        wp_register_style('st-hotel-alone-mapbox-gl-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css');
        wp_register_style('st-hotel-alone-mapbox-css', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.0/mapbox-gl-geocoder.css');
        wp_register_script('st-hotel-alone-mapbox-gl-js', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js', ['jquery'], null, true);
        wp_register_script('st-hotel-alone-mapbox-js', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.0/mapbox-gl-geocoder.min.js', ['jquery'], null, true);
        wp_register_script('st-hotel-alone-mapbox-custom-js', get_template_directory_uri() . '/v2/js/st-hotel-alone-mapbox-custom.js', ['st-hotel-alone-mapbox-js'], null, true);
        wp_localize_script('st-hotel-alone-mapbox-js', 'st_mapbox_params', [
            'access_token' => st()->get_option('st_token_mapbox', ''),
            'icon_location_3' => get_template_directory_uri() . '/v2/images/markers/icon_location_3.png',
            'st_googlemap_enabled' => st()->get_option('st_googlemap_enabled'),
            'text_rtl_mapbox' => $text_rtl_mapbox,
        ]);

        wp_localize_script('jquery', 'st_checkout_text', [
            'without_pp' => __('Submit Request', 'traveler'),
            'with_pp' => __('Booking Now', 'traveler'),
            'validate_form' => __('Please fill all required fields', 'traveler'),
            'error_accept_term' => __('Please accept our terms and conditions', 'traveler'),
            'email_validate' => __('Email is not valid', 'traveler'),
            'adult_price' => __('Adult', 'traveler'),
            'child_price' => __("Child", 'traveler'),
            'infant_price' => __("Infant", 'traveler'),
            'adult' => __("Adult", 'traveler'),
            'child' => __("Child", 'traveler'),
            'infant' => __("Infant", 'traveler'),
            'price' => __("Price", 'traveler'),
            'origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available: ', 'traveler'),
        ]);
        $locale = get_locale();
            $locale_fullcalendar = $locale;
            if (substr($locale, 0, 2)) {
                $locale_fullcalendar = strtolower(substr($locale, 0, 2));
            }
        wp_localize_script('jquery', 'st_params', [
            'theme_url' => get_template_directory_uri(),
            'locale_fullcalendar' => $locale_fullcalendar,
            'caculator_price_single_ajax' => st()->get_option( 'caculator_price_single_ajax', 'off' ),
            'site_url' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'loading_url' => admin_url('/images/wpspin_light.gif'),
            'text_adult' => __('Adult ', 'traveler'),
            'text_child' => __('Child ', 'traveler'),
            'text_adult_price' => __('Adult Price ', 'traveler'),
            'text_child_price' => __('Child Price ', 'traveler'),
            'text_infant_price' => __("Infant ", 'traveler'),
            'text_use_this_media' => __('Use this media', 'traveler'),
            'text_select_image' => __('Select Image', 'traveler'),
            'text_confirm_delete_item' => __('Are you sure want to delete this item?', 'traveler'),
            'text_process_cancel' => __('You cancelled the process', 'traveler'),
        ]);
        wp_localize_script('jquery', 'locale_daterangepicker', [
            'direction' => (is_rtl() || st()->get_option('right_to_left') == 'on')? 'rtl': 'ltr',
            'applyLabel' => __('Apply', 'traveler'),
            'cancelLabel' => __('Cancel', 'traveler'),
            'fromLabel' => __('From', 'traveler'),
            'toLabel' => __('To', 'traveler'),
            'customRangeLabel' => __('Custom', 'traveler'),
            'daysOfWeek' =>  [__('Su', 'traveler'), __('Mo', 'traveler'), __('Tu', 'traveler'), __('We', 'traveler'), __('Th', 'traveler'), __('Fr', 'traveler'), __('Sa', 'traveler')],
            'monthNames' => [__('January', 'traveler'), __('February', 'traveler'), __('March', 'traveler'), __('April', 'traveler'), __('May', 'traveler'), __('June', 'traveler'), __('July', 'traveler'), __('August', 'traveler'), __('September', 'traveler'), __('October', 'traveler'), __('November', 'traveler'), __('December', 'traveler')],
            'firstDay' => (int)st()->get_option('start_week', 0),
            'today' => __('Today', 'traveler')
        ]);
    }

    static function isNewLayout() {
        $check = false;
        global $post;
        $new_layout = st()->get_option('st_theme_style', 'modern');
        if ($new_layout == 'modern') {
            if ((is_front_page() || is_page() || is_home()) && is_page_template('template-home-modern.php')) {
                $check = true;
            }
            if (is_singular('elementor_library')) {
                $check = true;
            }
            if(is_page() || is_front_page()){
                $check = true;
            }
            
            if (is_singular() and get_post_type(get_the_ID()) == 'st_hotel') {
                $check = true;
            }
            if (is_singular('hotel_room')) {
                $check = true;
            }
            if (is_singular('st_rental')) {
                $check = true;
            }
            if (is_singular('st_tours')) {
                $check = true;
            }
            if (is_singular('st_activity')) {
                $check = true;
            }
            if (is_singular('st_cars')) {
                $check = true;
            }
            if (is_singular('post')) {
                $check = true;
            }
            if ('location' === get_post_type()) {
                $check = true;
            }
            if (is_page() && ( is_page_template('template-blank.php'))) {
                $check = true;
            }

            if (is_page() && ( is_page_template('template-hotel-search.php'))) {
                $check = true;
            }

            if (is_page() && ( is_page_template('template-tour-search.php'))) {
                $check = true;
            }
            if (is_page() && ( is_page_template('template-activity-search.php'))) {
                $check = true;
            }

            if (is_page() && ( is_page_template('template-activity-search.php'))) {
                $check = true;
            }
            if (is_page() && ( is_page_template('template-rental-search.php'))) {
                $check = true;
            }
            if (is_page() && ( is_page_template('template-cars-search.php'))) {
                $check = true;
            }

            if (is_page() && is_page_template('template-checkout.php')) {
                $check = true;
            }

            if (is_page() && is_page_template('template-payment-success.php')) {
                $check = true;
            }
            if (is_page() && is_page_template('template-transfer-search.php')) {
                $check = true;
            }

            if (is_404()) {
                $check = true;
            }

            if (is_page() && is_page_template('template-blog.php')) {
                $check = true;
            }

            if (is_archive() && !is_author()) {
                $check = true;
            }

            if (is_search()) {
                $check = true;
            }

            if (is_page_template('template-confirm.php')) {
                $check = true;
            }

            if (is_author()) {
                $check = true;
            }

            //Woo check
            if (self::isCheckWooPage() and ! is_page_template('template-user.php')) {
                $check = true;
            }
            if (is_page() && is_page_template('template-member-package-new.php')) {
                $check = true;
            }
            if (is_page() && is_page_template('template-checkout-packages-new.php')) {
                $check = true;
            }
            if (is_page() && is_page_template('template-package-success-new.php')) {
                $check = true;
            }
            if (is_page() && ( is_page_template('template-tp-flights-search-modern.php'))) {
                $check = true;
            }
            //Check other post type
            if(is_single()){
                $check = true;
            }
        } else {
            if (is_page() && is_page_template('template-member-package-new.php')) {
                $check = true;
            }
        }

        


        return $check;
    }

    static function buildTreeOptionLocation($locations, $location_id, $icon = '', $show_icon_all_level = false) {
        if (is_array($locations) && count($locations)):
            foreach ($locations as $key => $value):
                $level = 20;
                if ($value['lv'] == 2) {
                    $level = $value['lv'] * 10;
                }
                if ($value['lv'] > 2) {
                    $level = $value['lv'] * 10 + (($value['lv'] - 2) * 10);
                }
                $class_f = '';
                if ($value['lv'] == 1)
                    $class_f = 'parent_li';
                ?>
                <li style="padding-left: <?php echo esc_attr($level) . 'px;'; ?>" <?php selected($value['ID'], $location_id); ?>
                    data-country="<?php echo esc_attr($value['Country']); ?>"
                    data-value="<?php echo esc_attr($value['ID']); ?>" class="item <?php echo esc_attr($class_f); ?>">
                        <?php
                        if ($value['lv'] == 2) {
                            echo !empty($icon) ? $icon : TravelHelper::getNewIcon('ico_maps_search_box', 'gray', '16px', '16px', true);
                            echo '<span class="lv2">' . esc_html($value['post_title']) . '</span>';
                        } else {
                            if ($value['lv'] == 1) {
                                echo '<span class="parent">' . esc_html($value['post_title']) . '</span>';
                            } else {
                                if($show_icon_all_level) {
                                    echo !empty($icon) ? $icon : TravelHelper::getNewIcon('ico_maps_search_box', 'gray', '16px', '16px', true);
                                }
                                echo '<span class="child">' . esc_html($value['post_title']) . '</span>';
                            }
                        }
                        ?>
                </li>
                <?php
                if (isset($value['children'])) {
                    if (is_array($value['children'])) {
                        self::buildTreeOptionLocation($value['children'], $location_id, $icon, $show_icon_all_level);
                    }
                }
            endforeach;
        endif;
    }

    static function listTaxTreeFilter($taxonomy = 'category', $parent = 0, $level = 0, $post_type = 'post', $more = true, &$term_parent = '', $count = 0, $current_show = 3) {
        $key = $taxonomy;
        $terms = get_terms($taxonomy, ['hide_empty' => false, 'parent' => $parent]);
        if (isset($terms) && !empty($terms)):
            $level += 1;
            $count_hidden = 1;
            echo '<ul>';
            foreach ($terms as $key2 => $value2) {
                $count++;
                if (isset($value2->term_id)) {
                    if ($post_type == 'hotel_room') {
                        $name_field = "taxonomy_hotel_room";
                    } else {
                        $name_field = "taxonomy";
                    }

                    $current = STInput::get($name_field);

                    if (isset($current[$key]))
                        $current = $current[$key];
                    else
                        $current = '';

                    $checked = TravelHelper::checked_array(explode(',', $current), $value2->term_id);

                    if ($level == 0) {
                        $term_parent = $value2->term_id;
                    }

                    $style_rtl = '';
                    if (is_rtl()) {
                        $style_rtl = '';
                    }
                    ?>
                    <?php if($level == 0){ ?>
                        <li class="<?php echo ($count_hidden > $current_show && $more) ? 'hidden' : ''; ?> st-icheck-item"
                        style="<?php echo esc_attr($style_rtl); ?>"><label><?php echo esc_html($value2->name) ?>
                    <?php } else { ?>
                        <li class="st-icheck-item"
                        style="<?php echo esc_attr($style_rtl); ?>"><label><?php echo esc_html($value2->name) ?>
                    <?php } ?>
                    <input
                                data-tax="taxonomy" data-type="<?php echo esc_attr($taxonomy); ?>"
                                value="<?php echo esc_attr($value2->term_id); ?>" type="checkbox"
                                name="taxonomy" <?php if ($checked) echo "checked"; ?> class="filter-tax"/><span
                                class="checkmark fcheckbox"></span>
                        </label>
                        <?php
                        self::listTaxTreeFilter($taxonomy, $value2->term_id, $level, $post_type, $term_parent, $count);
                        $count_hidden++;
                        echo '</li>';
                }
            }
            echo '</ul>';
        endif;
    }

    static function cutStringByNumWord($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . ' ...';
        }
        return $text;
    }

    //Using elementor
    static function enqueueNewScriptElementor(){
        //Style v3
        //Popper affect performance
        wp_enqueue_script('popper', get_template_directory_uri() . '/v3/bootstrap/popper.min.js', ['jquery'], null, true);
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/v3/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('sweetalert2-css', get_template_directory_uri() . '/v3/css/sweetalert2.css');
        wp_enqueue_script('sweetalert2.min-js', get_template_directory_uri() . '/v3/js/sweetalert2.min.js', ['jquery'], null, true);
        //wp_enqueue_style('swiper', 'https://unpkg.com/swiper@7/swiper-bundle.min.css');
        if (is_rtl()) {
            wp_enqueue_style('bootstrap-rtl', get_template_directory_uri() . '/v3/bootstrap/css/bootstrap.rtl.min.css');
        }
        wp_enqueue_style('fontawesome', get_template_directory_uri() . '/v3/fonts/fontawesome/css/all.min.css');
        wp_enqueue_style('google-font-css', 'https://fonts.googleapis.com/css?family=Poppins:400,500,600&display=swap');
        
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/v3/bootstrap/js/bootstrap.bundle.min.js', ['jquery'], null, true);
        wp_enqueue_style('daterangepicker', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.css');
        
        //Param
        if (is_rtl()) {
            $text_rtl_mapbox = "https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js";
        } else {
            $text_rtl_mapbox = "";
        }
        $st_icon_mapbox = "https://i.imgur.com/MK4NUzI.png";
        $st_token_mapbox = st()->get_option('st_token_mapbox');
        if (is_singular('st_hotel') || is_page_template('template-hotel-search.php')) {
            $st_icon_mapbox = st()->get_option('st_hotel_icon_map_marker');
        } elseif (is_singular('st_tours') || is_page_template('template-tour-search.php')) {
            $st_icon_mapbox = st()->get_option('st_tours_icon_map_marker');
        } elseif (is_singular('st_rental') || is_page_template('template-rental-search.php')) {
            $st_icon_mapbox = st()->get_option('st_rental_icon_map_marker');
        } elseif (is_singular('st_activity') || is_page_template('template-activity-search.php')) {
            $st_icon_mapbox = st()->get_option('st_activity_icon_map_marker');
        } elseif (is_singular('st_cars') || is_page_template('template-cars-search.php')) {
            $st_icon_mapbox = st()->get_option('st_cars_icon_map_marker');
        }
        if (isset($st_token_mapbox) && !empty($st_token_mapbox)) {
            $st_token_mapbox = $st_token_mapbox;
        } else {
            $st_token_mapbox = 'pk.eyJ1IjoidGhvYWluZ28iLCJhIjoiY2p3dTE4bDFtMDAweTQ5cm5rMXA5anUwMSJ9.RkIx76muBIvcZ5HDb2g0Bw';
        }
        $locale = get_locale();
            $locale_fullcalendar = $locale;
            if (substr($locale, 0, 2)) {
                $locale_fullcalendar = strtolower(substr($locale, 0, 2));
            }
        wp_localize_script('jquery', 'st_params', [
            'theme_url' => get_template_directory_uri(),
            'locale_fullcalendar' => $locale_fullcalendar,
            'caculator_price_single_ajax' => st()->get_option( 'caculator_price_single_ajax', 'off' ),
            'site_url' => site_url(),
            'load_price' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'loading_url' => admin_url('/images/wpspin_light.gif'),
            'st_search_nonce' => wp_create_nonce("st_search_security"),
            'facebook_enable' => st()->get_option('social_fb_login', 'on'),
            'facbook_app_id' => st()->get_option('social_fb_app_id'),
            'booking_currency_precision' => TravelHelper::get_current_currency('booking_currency_precision'),
            'thousand_separator' => TravelHelper::get_current_currency('thousand_separator'),
            'decimal_separator' => TravelHelper::get_current_currency('decimal_separator'),
            'currency_symbol' => TravelHelper::get_current_currency('symbol'),
            'currency_position' => TravelHelper::get_current_currency('booking_currency_pos'),
            'currency_rtl_support' => TravelHelper::get_current_currency('currency_rtl_support'),
            'free_text' => __('Free', 'traveler'),
            'date_format' => TravelHelper::getDateFormatJs(),
            'date_format_calendar' => TravelHelper::getDateFormatJs(null, 'calendar'),
            'time_format' => st()->get_option('time_format', '12h'),

            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'locale' => get_locale(),
            'header_bgr' => st()->get_option('header_background', ''),
            'text_refresh' => __("Refresh", 'traveler'),
            'date_fomat' => TravelHelper::getDateFormatMoment(),
            'text_loading' => __("Loading...", 'traveler'),
            'text_no_more' => __("No More", 'traveler'),
            'weather_api_key' => st()->get_option('weather_api_key', 'a82498aa9918914fa4ac5ba584a7e623'),
            'no_vacancy' => __('No vacancies', 'traveler'),
            'a_vacancy' => __('a vacancy', 'traveler'),
            'more_vacancy' => __('vacancies', 'traveler'),
            'utm' => (is_ssl() ? 'https' : 'http') . '://shinetheme.com/utm/utm.gif',
            '_s' => wp_create_nonce('st_frontend_security'),
            'mclusmap' => get_template_directory_uri() . '/v2/images/icon_map/ico_gruop_location.svg',
            'icon_contact_map' => get_template_directory_uri() . '/v2/images/markers/ico_location_3.png',
            'text_adult' => __('Adult', 'traveler'),
            'text_adults' => __('Adults', 'traveler'),
            'text_child' => __('Children', 'traveler'),
            'text_childs' => __('Childrens', 'traveler'),
            'text_price' => __("Price", 'traveler'),
            'text_origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available ', 'traveler'),
            'text_available' => __('Available ', 'traveler'),
            'text_adult_price' => __('Adult Price ', 'traveler'),
            'text_child_price' => __('Child Price ', 'traveler'),
            'text_infant_price' => __("Infant Price", 'traveler'),
            'text_update' => __('Update ', 'traveler'),
            'token_mapbox' => $st_token_mapbox,
            'text_rtl_mapbox' => $text_rtl_mapbox,
            'st_icon_mapbox' => $st_icon_mapbox,
            'text_use_this_media' => __('Use this media', 'traveler'),
            'text_select_image' => __('Select Image', 'traveler'),
            'text_confirm_delete_item' => __('Are you sure want to delete this item?', 'traveler'),
            'text_process_cancel' => __('You cancelled the process', 'traveler'),
            'start_at_text' => __('Start at', 'traveler'),
            'end_at_text' => __('End at', 'traveler'),
            //Set multi lang using js
        ]);
        wp_enqueue_script('nicescroll', get_template_directory_uri() . '/v2/js/jquery.nicescroll.min.js', ['jquery'], null, true);
        //Range slider
        wp_enqueue_script('match-height', get_template_directory_uri() . '/v2/js/jquery.matchHeight.js', ['jquery'], null, true);
        //wp_enqueue_script('swiper', get_template_directory_uri() . '/v3/swiper/swiper-bundle.min.js', ['jquery'], null, true);
        wp_enqueue_style('rangeSlider', get_template_directory_uri() . '/v3/ion.rangeSlider/css/ion.rangeSlider.css');
        wp_enqueue_style('rangeSlider-skinHTML5', get_template_directory_uri() . '/v3/ion.rangeSlider/css/ion.rangeSlider.skinHTML5.css');
        wp_enqueue_script('ion-rangeslider', get_template_directory_uri() . '/v3/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.js', ['jquery'], null, true);
        wp_enqueue_script('moment', get_template_directory_uri() . '/v2/js/moment.min.js', ['jquery'], null, true);
        wp_enqueue_script('daterangepicker-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.js', ['jquery'], null, true);
        if(is_singular('st_location')){
            wp_enqueue_script('st-location-detail', get_template_directory_uri() . '/v3/js/location.js', ['jquery'], null, true);
        }
        if(is_singular('st_hotel') || is_singular('st_tours') || is_singular('st_activity') || is_singular('st_cars') || is_singular('post') || is_singular('st_rental') || is_singular('hotel_room') || is_search() || is_tag() || is_archive() || is_category() ||is_tax() || is_page_template('template-blog.php')){
            wp_enqueue_style('single-hotel-detail', get_template_directory_uri() . '/v3/css/single-hotel-detail.css');
            wp_enqueue_style('fotorama', get_template_directory_uri() . '/v2/js/fotorama/fotorama.css');
            wp_enqueue_style('magnific', get_template_directory_uri() . '/v2/css/magnific-popup.css');
            wp_enqueue_script('fotorama', get_template_directory_uri() . '/v2/js/fotorama/fotorama.js', ['jquery'], null, true);
            wp_enqueue_script('magnific', get_template_directory_uri() . '/v2/js/magnific-popup/jquery.magnific-popup.min.js');
            
            wp_enqueue_script('single-hotel-detail', get_template_directory_uri() . '/v3/js/single-hotel-detail.js', ['jquery'], null, true);
            
        }
        wp_enqueue_style('awesome-line-awesome-css',  'https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.1.0/css/line-awesome.min.css');
        if ((is_page() && is_page_template('template-tour-search.php')) || is_singular('st_tours')
        || is_page_template('template-activity-search.php') || is_singular('st_activity') || is_singular('st_cars') || is_singular('st_rental')
        ){
            wp_enqueue_style('owlcarousel', get_template_directory_uri() . '/v2/js/owlcarousel/assets/owl.carousel.min.css');
            wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/v2/js/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
        }
        if (is_page() and is_page_template('template-checkout-packages-new.php') || is_page_template('template-package-success-new.php') ) {
            $new_layout = st()->get_option('member_packages_layout');
            if($new_layout === '2') {
                wp_enqueue_style('menbership2-css', get_template_directory_uri() . '/v3/css/member-package-page.css');
            }
        }
        //Google Map / Mapbox API
        $check_enable_map_google = st()->get_option('st_googlemap_enabled');
        $google_api_key = st()->get_option('google_api_key');
        if ($check_enable_map_google === 'on') {
            
            if (is_singular('st_hotel') || (is_page() && is_page_template('template-tour-search.php')) || is_singular('st_tours')
            || is_page_template('template-activity-search.php') || is_singular('st_activity') || is_singular('st_rental')
            || is_page_template('template-rental-search.php') || is_page_template('template-hotel-search.php')
            ) {
                wp_enqueue_script('infobox', get_template_directory_uri() . '/v3/js/infobox.js', ['jquery'], null, true);
            }

            wp_enqueue_script('map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $google_api_key, ['jquery'], null, false);
            wp_enqueue_script('custom-google-map', get_template_directory_uri() . '/v3/js/filter/custom-map-google.js', ['jquery'], null, true);
            if (is_page() && (is_page_template('template-hotel-search.php') ||
            is_page_template('template-rental-search.php')
            ) ) {
                wp_register_script('filter-hotel', get_template_directory_uri() . '/v3/js/filter/hotel.js', ['jquery'], null, true);
            }
            if(is_page_template('template-rental-search.php') || is_singular('st_rental')){
                wp_register_script('filter-rental', get_template_directory_uri() . '/v3/js/rental.js', ['jquery'], null, true);
            }

            if ((is_page() && is_page_template('template-tour-search.php')) || is_singular('st_tours')){
                
                wp_register_script('filter-tour', get_template_directory_uri() . '/v3/js/tour.js', ['jquery'], null, true);
            }

            //Activity
            if ((is_page() && is_page_template('template-activity-search.php')) || is_singular('st_activity')){
                wp_register_script('filter-activity', get_template_directory_uri() . '/v3/js/activity.js', ['jquery'], null, true);
            }
            

        } else {
            wp_enqueue_script('mapbox-js', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js', ['jquery'], null, false);
            wp_enqueue_style('mapbox-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css?optimize=true');
            wp_enqueue_style('mapbox-css-api', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css');
        
            wp_enqueue_style('mapbox-custom-css', get_template_directory_uri() . '/v2/css/mapbox-custom.css');

            //Mapbox
            wp_enqueue_script('custom-mapboxjs', get_template_directory_uri() . '/v3/js/filter/mapbox/custom.js', ['jquery'], null, true);
            wp_register_script('filter-hotel', get_template_directory_uri() . '/v3/js/filter/mapbox/filter-hotel-mapbox.js', ['jquery'], null, true);
            if(is_page_template('template-rental-search.php') || is_singular('st_rental')){
                wp_register_script('filter-rental', get_template_directory_uri() . '/v3/js/filter/mapbox/filter-rental-mapbox.js', ['jquery'], null, true);
            }
            if ((is_page() && is_page_template('template-tour-search.php')) || is_singular('st_tours')){
            
                wp_register_script('filter-tour', get_template_directory_uri() . '/v3/js/filter/mapbox/filter-tours-mapbox.js', ['jquery'], null, true);
                
            }
            //Activity
            if ((is_page() && is_page_template('template-activity-search.php'))){
                wp_register_script('filter-activity', get_template_directory_uri() . '/v3/js/filter/mapbox/filter-activity-mapbox.js', ['jquery'], null, true);
            }
            
        }
        if ((is_page() && is_page_template('template-cars-search.php')) || is_singular('st_cars')){
            wp_register_script('filter-car', get_template_directory_uri() . '/v3/js/car.js', ['jquery'], null, true);
        }
        wp_register_style('select2.min', get_template_directory_uri() . '/v2/css/select2.min.css');
        wp_register_script('select2.full.min', get_template_directory_uri() . '/v2/js/select2.full.min.js', ['jquery'], null, true);
        if ((is_page() && is_page_template('template-transfer-search.php')) || is_page_template('template-user.php')) {
            $menu_style = st()->get_option('menu_style_modern', 1);
            if ($menu_style != 9) {
                wp_enqueue_style('select2.min');
                wp_enqueue_script('select2.full.min');
            }
            wp_enqueue_script('filter-transfer', get_template_directory_uri() . '/v3/js/cartransfer.js', ['jquery'], null, true);
          
        }

        if(is_singular('st_tours')){
            wp_enqueue_script('single-tour', get_template_directory_uri() . '/v3/js/single-tour-detail.js', ['jquery'], null, true);
        }
        if(is_singular('st_rental')){
            wp_enqueue_script('single-rental', get_template_directory_uri() . '/v3/js/single-rental-detail.js', ['jquery'], null, true);
        }
        if(is_singular('st_activity')){
            wp_enqueue_script('single-activity', get_template_directory_uri() . '/v3/js/single-activity-detail.js', ['jquery'], null, true);
        }

        if(is_singular('hotel_room') || is_singular('st_hotel')) {
            wp_register_style('owlcarousel', get_template_directory_uri() . '/v2/js/owlcarousel/assets/owl.carousel.min.css');
            wp_register_script('owlcarousel', get_template_directory_uri() . '/v2/js/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
        }
        

        wp_localize_script('jquery', 'st_list_map_params', [
            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'text_my_location' => __("3000 m radius", 'traveler'),
            'text_no_result' => __("No Result", 'traveler'),
            'cluster_0' => __("<div class='cluster cluster-1'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_20' => __("<div class='cluster cluster-2'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_50' => __("<div class='cluster cluster-3'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_m1' => get_template_directory_uri() . '/img/map/m1.png',
            'cluster_m2' => get_template_directory_uri() . '/img/map/m2.png',
            'cluster_m3' => get_template_directory_uri() . '/img/map/m3.png',
            'cluster_m4' => get_template_directory_uri() . '/img/map/m4.png',
            'cluster_m5' => get_template_directory_uri() . '/img/map/m5.png',
            'icon_full_screen' => get_template_directory_uri() . '/v2/images/icon_map/ico_fullscreen.svg',
            'icon_my_location' => get_template_directory_uri() . '/v2/images/icon_map/ico_location.svg',
            'icon_my_style' => get_template_directory_uri() . '/v2/images/icon_map/ico_view_maps.svg',
            'icon_zoom_out' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom-out.svg',
            'icon_zoom_in' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom_in.svg',
            'icon_close' => get_template_directory_uri() . '/v2/images/icon_map/icon_close.svg',

        ]);

        //End Google Map
        

        //Hotel search page

        if(is_singular('hotel_room') ||is_singular('st_rental')){
            wp_enqueue_style('flickity', get_template_directory_uri() . '/v2/css/flickity.css');
            wp_enqueue_script('flickity.pkgd.min', get_template_directory_uri() . '/v2/js/flickity.pkgd.min.js', ['jquery'], null, true);
        }
        

        wp_enqueue_style('main', get_template_directory_uri() . '/v3/css/main.css');

        //Affiliate
        wp_register_script('icheck-frontent.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        wp_register_script('affilate-api.js', get_template_directory_uri() . '/v2/js/affilate-api.js', ['jquery'], null, true);
        
        if(is_rtl() || st()->get_option('right_to_left') == 'on'){
            wp_enqueue_style('_rtl', get_template_directory_uri() . '/v3/css/_rtl.css');
        }
        if(is_page_template('template-checkout.php')){
            wp_register_script('checkout-modern', get_template_directory_uri() . '/v3/js/checkout.js', ['jquery'], null, true);
            wp_localize_script('jquery', 'st_checkout_text', [
                'without_pp' => __('Submit Request', 'traveler'),
                'with_pp' => __('Booking Now', 'traveler'),
                'validate_form' => __('Please fill all required fields', 'traveler'),
                'error_accept_term' => __('Please accept our terms and conditions', 'traveler'),
                'email_validate' => __('Email is not valid', 'traveler'),
                'adult_price' => __('Adult', 'traveler'),
                'child_price' => __("Child", 'traveler'),
                'infant_price' => __("Infant", 'traveler'),
                'adult' => __("Adult", 'traveler'),
                'child' => __("Child", 'traveler'),
                'infant' => __("Infant", 'traveler'),
                'price' => __("Price", 'traveler'),
                'origin_price' => __("Origin Price", 'traveler'),
                'text_unavailable' => __('Not Available: ', 'traveler'),
            ]);
        }
        if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
            if (is_page() && ( is_page_template('template-checkout.php') || is_page_template('template-checkout-packages-new.php') || is_page_template('template-checkout-packages.php')) ) {
                $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                wp_enqueue_script('recaptcha.js', 'https://www.google.com/recaptcha/api.js?render='.$st_site_key_captcha,['jquery'], true, false);
            }

        }
        wp_register_script('checkout-js', get_template_directory_uri() . '/js/init/template-checkout.js', ['jquery'], null, true);
        wp_enqueue_script('form-search', get_template_directory_uri() . '/v3/js/form-search.js', ['jquery'], null, true);
        wp_enqueue_script('elementor', get_template_directory_uri() . '/v3/js/elementor.js', ['jquery'], null, true);
        wp_enqueue_script('main', get_template_directory_uri() . '/v3/js/main.js', ['jquery'], null, true);

        //param
        wp_localize_script('jquery', 'st_checkout_text', [
            'without_pp' => __('Submit Request', 'traveler'),
            'with_pp' => __('Booking Now', 'traveler'),
            'validate_form' => __('Please fill all required fields', 'traveler'),
            'error_accept_term' => __('Please accept our terms and conditions', 'traveler'),
            'email_validate' => __('Email is not valid', 'traveler'),
            'adult_price' => __('Adult', 'traveler'),
            'child_price' => __("Child", 'traveler'),
            'infant_price' => __("Infant", 'traveler'),
            'adult' => __("Adult", 'traveler'),
            'child' => __("Child", 'traveler'),
            'infant' => __("Infant", 'traveler'),
            'price' => __("Price", 'traveler'),
            'origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available: ', 'traveler'),
        ]);
        
        wp_localize_script('jquery', 'st_timezone', [
            'timezone_string' => get_option('timezone_string', 'local'),
        ]);

        wp_localize_script('jquery', 'locale_daterangepicker', [
                'direction' => (is_rtl() || st()->get_option('right_to_left') == 'on')? 'rtl': 'ltr',
                'applyLabel' => __('Apply', 'traveler'),
                'cancelLabel' => __('Cancel', 'traveler'),
                'fromLabel' => __('From', 'traveler'),
                'toLabel' => __('To', 'traveler'),
                'customRangeLabel' => __('Custom', 'traveler'),
                'daysOfWeek' =>  [__('Su', 'traveler'), __('Mo', 'traveler'), __('Tu', 'traveler'), __('We', 'traveler'), __('Th', 'traveler'), __('Fr', 'traveler'), __('Sa', 'traveler')],
                'monthNames' => [__('January', 'traveler'), __('February', 'traveler'), __('March', 'traveler'), __('April', 'traveler'), __('May', 'traveler'), __('June', 'traveler'), __('July', 'traveler'), __('August', 'traveler'), __('September', 'traveler'), __('October', 'traveler'), __('November', 'traveler'), __('December', 'traveler')],
                'firstDay' => (int)st()->get_option('start_week', 0),
                'today' => __('Today', 'traveler')
        ]);
        wp_register_script('bootstrap-datepicker.js', get_template_directory_uri() . '/js/bootstrap-datepicker.js', ['jquery'], null, true);
        $lang = get_locale();
        $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
        if (file_exists($lang_file)) {
            wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
        } else {
            $locale_array = explode('_', $lang);
            if (!empty($locale_array) and $locale_array[0]) {
                $locale = $locale_array[0];

                $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                if (file_exists($lang_file)) {
                    wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
                } else {
                    $lang = TravelHelper::get_minify_locale(get_locale());
                    $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                    if (file_exists($lang_file))
                        wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
                }
            } else {
                $lang = TravelHelper::get_minify_locale(get_locale());
                $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                if (file_exists($lang_file))
                    wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
            }
        }

        wp_localize_script('jquery', 'st_list_map_params', [
            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'text_my_location' => __("3000 m radius", 'traveler'),
            'text_no_result' => __("No Result", 'traveler'),
            'cluster_0' => __("<div class='cluster cluster-1'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_20' => __("<div class='cluster cluster-2'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_50' => __("<div class='cluster cluster-3'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_m1' => get_template_directory_uri() . '/img/map/m1.png',
            'cluster_m2' => get_template_directory_uri() . '/img/map/m2.png',
            'cluster_m3' => get_template_directory_uri() . '/img/map/m3.png',
            'cluster_m4' => get_template_directory_uri() . '/img/map/m4.png',
            'cluster_m5' => get_template_directory_uri() . '/img/map/m5.png',
            'icon_full_screen' => get_template_directory_uri() . '/v2/images/icon_map/ico_fullscreen.svg',
            'icon_my_location' => get_template_directory_uri() . '/v2/images/icon_map/ico_location.svg',
            'icon_my_style' => get_template_directory_uri() . '/v2/images/icon_map/ico_view_maps.svg',
            'icon_zoom_out' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom-out.svg',
            'icon_zoom_in' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom_in.svg',
            'icon_close' => get_template_directory_uri() . '/v2/images/icon_map/icon_close.svg',

        ]);
        wp_localize_script('jquery', 'st_config_partner', [
            'text_er_image_format' => false,
        ]);
    }

    static function enqueueNewScript() {
        if (is_rtl()) {
            $text_rtl_mapbox = "https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js";
        } else {
            $text_rtl_mapbox = "";
        }
        $st_icon_mapbox = "https://i.imgur.com/MK4NUzI.png";
        $st_token_mapbox = st()->get_option('st_token_mapbox');
        if (is_singular('st_hotel') || is_page_template('template-hotel-search.php')) {
            $st_icon_mapbox = st()->get_option('st_hotel_icon_map_marker');
        } elseif (is_singular('st_tours') || is_page_template('template-tour-search.php')) {
            $st_icon_mapbox = st()->get_option('st_tours_icon_map_marker');
        } elseif (is_singular('st_rental') || is_page_template('template-rental-search.php')) {
            $st_icon_mapbox = st()->get_option('st_rental_icon_map_marker');
        } elseif (is_singular('st_activity') || is_page_template('template-activity-search.php')) {
            $st_icon_mapbox = st()->get_option('st_activity_icon_map_marker');
        } elseif (is_singular('st_cars') || is_page_template('template-cars-search.php')) {
            $st_icon_mapbox = st()->get_option('st_cars_icon_map_marker');
        }
        if (isset($st_token_mapbox) && !empty($st_token_mapbox)) {
            $st_token_mapbox = $st_token_mapbox;
        } else {
            $st_token_mapbox = 'pk.eyJ1IjoidGhvYWluZ28iLCJhIjoiY2p3dTE4bDFtMDAweTQ5cm5rMXA5anUwMSJ9.RkIx76muBIvcZ5HDb2g0Bw';
        }
        //Enqueue new script here
        wp_enqueue_style('google-font-css', 'https://fonts.googleapis.com/css?family=Poppins:400,500,600');
        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/v2/css/bootstrap.min.css');
        wp_enqueue_style('helpers-css', get_template_directory_uri() . '/v2/css/helpers.css');
        wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/v2/css/font-awesome.min.css');
        wp_enqueue_style('fotorama-css', get_template_directory_uri() . '/v2/js/fotorama/fotorama.css');
        wp_enqueue_style('rangeSlider-css', get_template_directory_uri() . '/v2/js/ion.rangeSlider/css/ion.rangeSlider.css');
        wp_enqueue_style('rangeSlider-skinHTML5-css', get_template_directory_uri() . '/v2/js/ion.rangeSlider/css/ion.rangeSlider.skinHTML5.css');
        wp_enqueue_style('daterangepicker-css', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.css');
        wp_enqueue_style('awesome-line-awesome-css',  'https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.1.0/css/line-awesome.min.css');
        wp_enqueue_style('sweetalert2-css', get_template_directory_uri() . '/v2/css/sweetalert2.css');
        wp_enqueue_style('select2.min-css', get_template_directory_uri() . '/v2/css/select2.min.css');
        wp_enqueue_style('flickity-css', get_template_directory_uri() . '/v2/css/flickity.css');
        wp_enqueue_style('magnific-css', get_template_directory_uri() . '/v2/js/magnific-popup/magnific-popup.css');
        wp_enqueue_style('owlcarousel-css', get_template_directory_uri() . '/v2/js/owlcarousel/assets/owl.carousel.min.css');
        wp_enqueue_style('st-style-css', get_template_directory_uri() . '/v2/css/style.css');
        wp_enqueue_style('affilate-css', get_template_directory_uri() . '/v2/css/affilate.css');
        wp_enqueue_style('affilate-h-css', get_template_directory_uri() . '/v2/css/affilate-h.css');
        wp_enqueue_style('search-result-css', get_template_directory_uri() . '/v2/css/search_result.css');
        wp_enqueue_style('st-fix-safari-css', get_template_directory_uri() . '/v2/css/fsafari.css');
        wp_enqueue_style('checkout-css', get_template_directory_uri() . '/v2/css/checkout.css');
        wp_enqueue_style('partner-page-css', get_template_directory_uri() . '/v2/css/partner_page.css');
        wp_enqueue_style('responsive-css', get_template_directory_uri() . '/v2/css/responsive.css');
        wp_enqueue_style('mCustomScrollbar-css', 'https://cdn.jsdelivr.net/jquery.mcustomscrollbar/3.1.3/jquery.mCustomScrollbar.min.css');
        wp_enqueue_style('single-tour', get_template_directory_uri() . '/v2/css/sin-tour.css');
        wp_register_script('icheck-frontent.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        if (is_page() and is_page_template('template-member-package-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        if (is_page() and is_page_template('template-checkout-packages-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        if (is_page() and is_page_template('template-package-success-new.php')) {
            wp_enqueue_style('menbership-css', get_template_directory_uri() . '/v2/css/membership.css');
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);
        }
        wp_enqueue_style('enquire-css', get_template_directory_uri() . '/v2/css/enquire.css');
        if ('location' === get_post_type()) {
            wp_enqueue_style('location-css', get_template_directory_uri() . '/v2/css/location.css');
            wp_enqueue_script('location-js', get_template_directory_uri() . '/v2/js/location.js', ['jquery'], null, true);
        }

        $check_enable_map_google = st()->get_option('st_googlemap_enabled');
        $google_api_key = st()->get_option('google_api_key');
        if ($check_enable_map_google === 'on') {
            wp_enqueue_script('map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $google_api_key, ['jquery'], null, false);
        } else {
            wp_enqueue_script('mapbox-js', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js', ['jquery'], null, false);
            wp_enqueue_style('mapbox-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css?optimize=true');
            wp_enqueue_style('mapbox-css-api', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css');
            wp_enqueue_script('mapbox-custom', get_template_directory_uri() . '/v2/js/mapbox-custom.js', ['jquery'], null, true);
            wp_enqueue_style('mapbox-custom-css', get_template_directory_uri() . '/v2/css/mapbox-custom.css');
        }

        if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
            if (is_page() && ( is_page_template('template-checkout.php') || is_page_template('template-checkout-packages-new.php') || is_page_template('template-checkout-packages.php')) ) {
                $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                wp_enqueue_script('recaptcha.js', 'https://www.google.com/recaptcha/api.js?render='.$st_site_key_captcha,['jquery'], true, false);
            }

        }

        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/v2/js/bootstrap.min.js', ['jquery'], null, true);
        wp_enqueue_script('match-height-js', get_template_directory_uri() . '/v2/js/jquery.matchHeight.js', ['jquery'], null, true);
        wp_enqueue_script('fotorama-js', get_template_directory_uri() . '/v2/js/fotorama/fotorama.js', ['jquery'], null, true);
        wp_enqueue_script('ion-rangeslider-js', get_template_directory_uri() . '/v2/js/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.js', ['jquery'], null, true);
        wp_enqueue_script('moment-js', get_template_directory_uri() . '/v2/js/moment.min.js', ['jquery'], null, true);
        wp_enqueue_script('daterangepicker-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.js', ['jquery'], null, true);

        wp_enqueue_script('nicescroll-js', get_template_directory_uri() . '/v2/js/jquery.nicescroll.min.js', ['jquery'], null, true);
        wp_enqueue_script('sweetalert2.min-js', get_template_directory_uri() . '/v2/js/sweetalert2.min.js', ['jquery'], null, true);
        wp_enqueue_script('markerclusterer-js', get_template_directory_uri() . '/v2/js/markerclusterer.js', ['jquery'], null, true);
        wp_enqueue_script('select2.full.min-js', get_template_directory_uri() . '/v2/js/select2.full.min.js', ['jquery'], null, true);

        if ($check_enable_map_google === 'on') {
            wp_enqueue_script('infobox-js', get_template_directory_uri() . '/v2/js/infobox.js', ['jquery'], null, true);
            wp_register_script('filter-hotel-js', get_template_directory_uri() . '/v2/js/filter/hotel.js', ['jquery'], null, true);
            wp_register_script('filter-tour-js', get_template_directory_uri() . '/v2/js/filter/tour.js', ['jquery'], null, true);
            wp_register_script('filter-activity-js', get_template_directory_uri() . '/v2/js/filter/activity.js', ['jquery'], null, true);
            wp_register_script('filter-rental-js', get_template_directory_uri() . '/v2/js/filter/rental.js', ['jquery'], null, true);
            wp_register_script('filter-car-js', get_template_directory_uri() . '/v2/js/filter/car.js', ['jquery'], null, true);
        } else {
            wp_enqueue_script('custom-mapboxjs', get_template_directory_uri() . '/v2/js/mapbox/custom.js', ['jquery'], null, true);
            wp_register_script('filter-hotel-js', get_template_directory_uri() . '/v2/js/mapbox/filter-hotel-mapbox.js', ['jquery'], null, true);
            wp_register_script('filter-rental-js', get_template_directory_uri() . '/v2/js/mapbox/filter-rental-mapbox.js', ['jquery'], null, true);
            wp_register_script('filter-tour-js', get_template_directory_uri() . '/v2/js/mapbox/filter-tours-mapbox.js', ['jquery'], null, true);
            wp_register_script('filter-car-js', get_template_directory_uri() . '/v2/js/filter/car.js', ['jquery'], null, true);
            wp_register_script('filter-activity-js', get_template_directory_uri() . '/v2/js/filter/activity.js', ['jquery'], null, true);
        }
        wp_register_script('filter-car-transfer-js', get_template_directory_uri() . '/v2/js/filter/car-transfer.js', ['jquery'], null, true);
        wp_enqueue_script('send-message-owner-js', get_template_directory_uri() . '/v2/js/send-message-owner.js', ['jquery'], null, true);
        wp_enqueue_script('magnific-js', get_template_directory_uri() . '/v2/js/magnific-popup/jquery.magnific-popup.min.js');
        wp_register_script('affilate-api.js', get_template_directory_uri() . '/v2/js/affilate-api.js', ['jquery'], null, true);
        wp_register_script('bootstrap-datepicker.js', get_template_directory_uri() . '/js/bootstrap-datepicker.js', ['jquery'], null, true);

        $lang = get_locale();
        $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
        if (file_exists($lang_file)) {
            wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
        } else {
            $locale_array = explode('_', $lang);
            if (!empty($locale_array) and $locale_array[0]) {
                $locale = $locale_array[0];

                $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                if (file_exists($lang_file)) {
                    wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
                } else {
                    $lang = TravelHelper::get_minify_locale(get_locale());
                    $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                    if (file_exists($lang_file))
                        wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
                }
            } else {
                $lang = TravelHelper::get_minify_locale(get_locale());
                $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
                if (file_exists($lang_file))
                    wp_register_script('bootstrap-datepicker-lang.js', get_template_directory_uri() . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js', ['jquery'], null, true);
            }
        }

        wp_enqueue_script('flickity.pkgd.min-js', get_template_directory_uri() . '/v2/js/flickity.pkgd.min.js', ['jquery'], null, true);
        wp_enqueue_script('owlcarousel-js', get_template_directory_uri() . '/v2/js/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
        wp_enqueue_script('mb-YTPlayer', get_template_directory_uri() . '/v2/js/jquery.mb.YTPlayer.min.js', array('jquery'), null, true);
        wp_enqueue_script('mCustomScrollbar', 'https://cdn.jsdelivr.net/jquery.mcustomscrollbar/3.1.3/jquery.mCustomScrollbar.concat.min.js', array('jquery'), null, true);
        wp_enqueue_script('car-tranfer-js', get_template_directory_uri() . '/v2/js/car-tranfer.js', ['jquery'], null, true);
        wp_enqueue_script('custom-js', get_template_directory_uri() . '/v2/js/custom.js', ['jquery'], null, true);
        wp_enqueue_script('sin-tour-js', get_template_directory_uri() . '/v2/js/sin-tour.js', ['jquery'], null, true);

        wp_register_script('checkout-js', get_template_directory_uri() . '/js/init/template-checkout.js', ['jquery'], null, true);

        if (is_rtl() || st()->get_option('right_to_left') == 'on') {
            wp_enqueue_style('rtl-css', get_template_directory_uri() . '/v2/css/rtl.css');
            wp_enqueue_style('rtl2-css', get_template_directory_uri() . '/v2/css/rtl2.css');
        }

        wp_localize_script('jquery', 'st_checkout_text', [
            'without_pp' => __('Submit Request', 'traveler'),
            'with_pp' => __('Booking Now', 'traveler'),
            'validate_form' => __('Please fill all required fields', 'traveler'),
            'error_accept_term' => __('Please accept our terms and conditions', 'traveler'),
            'email_validate' => __('Email is not valid', 'traveler'),
            'adult_price' => __('Adult', 'traveler'),
            'child_price' => __("Child", 'traveler'),
            'infant_price' => __("Infant", 'traveler'),
            'adult' => __("Adult", 'traveler'),
            'child' => __("Child", 'traveler'),
            'infant' => __("Infant", 'traveler'),
            'price' => __("Price", 'traveler'),
            'origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available: ', 'traveler'),
        ]);
        $locale = get_locale();
            $locale_fullcalendar = $locale;
            if (substr($locale, 0, 2)) {
                $locale_fullcalendar = strtolower(substr($locale, 0, 2));
            }
        wp_localize_script('jquery', 'st_params', [
            'theme_url' => get_template_directory_uri(),
            'locale_fullcalendar' => $locale_fullcalendar,
            'caculator_price_single_ajax' => st()->get_option( 'caculator_price_single_ajax', 'off' ),
            'site_url' => site_url(),
            'load_price' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'loading_url' => admin_url('/images/wpspin_light.gif'),
            'st_search_nonce' => wp_create_nonce("st_search_security"),
            'facebook_enable' => st()->get_option('social_fb_login', 'on'),
            'facbook_app_id' => st()->get_option('social_fb_app_id'),
            'booking_currency_precision' => TravelHelper::get_current_currency('booking_currency_precision'),
            'thousand_separator' => TravelHelper::get_current_currency('thousand_separator'),
            'decimal_separator' => TravelHelper::get_current_currency('decimal_separator'),
            'currency_symbol' => TravelHelper::get_current_currency('symbol'),
            'currency_position' => TravelHelper::get_current_currency('booking_currency_pos'),
            'currency_rtl_support' => TravelHelper::get_current_currency('currency_rtl_support'),
            'free_text' => __('Free', 'traveler'),
            'date_format' => TravelHelper::getDateFormatJs(),
            'date_format_calendar' => TravelHelper::getDateFormatJs(null, 'calendar'),
            'time_format' => st()->get_option('time_format', '12h'),

            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'locale' => get_locale(),
            'header_bgr' => st()->get_option('header_background', ''),
            'text_refresh' => __("Refresh", 'traveler'),
            'date_fomat' => TravelHelper::getDateFormatMoment(),
            'text_loading' => __("Loading...", 'traveler'),
            'text_no_more' => __("No More", 'traveler'),
            'weather_api_key' => st()->get_option('weather_api_key', 'a82498aa9918914fa4ac5ba584a7e623'),
            'no_vacancy' => __('No vacancies', 'traveler'),
            'a_vacancy' => __('a vacancy', 'traveler'),
            'more_vacancy' => __('vacancies', 'traveler'),
            'utm' => (is_ssl() ? 'https' : 'http') . '://shinetheme.com/utm/utm.gif',
            '_s' => wp_create_nonce('st_frontend_security'),
            'mclusmap' => get_template_directory_uri() . '/v2/images/icon_map/ico_gruop_location.svg',
            'icon_contact_map' => get_template_directory_uri() . '/v2/images/markers/ico_location_3.png',
            'text_adult' => __('Adult', 'traveler'),
            'text_adults' => __('Adults', 'traveler'),
            'text_child' => __('Children', 'traveler'),
            'text_childs' => __('Childrens', 'traveler'),
            'text_price' => __("Price", 'traveler'),
            'text_origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available ', 'traveler'),
            'text_available' => __('Available ', 'traveler'),
            'text_adult_price' => __('Adult Price ', 'traveler'),
            'text_child_price' => __('Child Price ', 'traveler'),
            'text_infant_price' => __("Infant Price", 'traveler'),
            'text_update' => __('Update ', 'traveler'),
            'token_mapbox' => $st_token_mapbox,
            'text_rtl_mapbox' => $text_rtl_mapbox,
            'st_icon_mapbox' => $st_icon_mapbox,
            'text_use_this_media' => __('Use this media', 'traveler'),
            'text_select_image' => __('Select Image', 'traveler'),
            'text_confirm_delete_item' => __('Are you sure want to delete this item?', 'traveler'),
            'text_process_cancel' => __('You cancelled the process', 'traveler'),
            'start_at_text' => __('Start at', 'traveler'),
            'end_at_text' => __('End at', 'traveler'),
            //Set multi lang using js
        ]);
        wp_localize_script('jquery', 'st_timezone', [
            'timezone_string' => get_option('timezone_string', 'local'),
        ]);

        wp_localize_script('jquery', 'locale_daterangepicker', [
                'direction' => (is_rtl() || st()->get_option('right_to_left') == 'on')? 'rtl': 'ltr',
                'applyLabel' => __('Apply', 'traveler'),
                'cancelLabel' => __('Cancel', 'traveler'),
                'fromLabel' => __('From', 'traveler'),
                'toLabel' => __('To', 'traveler'),
                'customRangeLabel' => __('Custom', 'traveler'),
                'daysOfWeek' =>  [__('Su', 'traveler'), __('Mo', 'traveler'), __('Tu', 'traveler'), __('We', 'traveler'), __('Th', 'traveler'), __('Fr', 'traveler'), __('Sa', 'traveler')],
                'monthNames' => [__('January', 'traveler'), __('February', 'traveler'), __('March', 'traveler'), __('April', 'traveler'), __('May', 'traveler'), __('June', 'traveler'), __('July', 'traveler'), __('August', 'traveler'), __('September', 'traveler'), __('October', 'traveler'), __('November', 'traveler'), __('December', 'traveler')],
                'firstDay' => (int)st()->get_option('start_week', 0),
                'today' => __('Today', 'traveler')
        ]);

        wp_localize_script('jquery', 'st_list_map_params', [
            'mk_my_location' => get_template_directory_uri() . '/img/my_location.png',
            'text_my_location' => __("3000 m radius", 'traveler'),
            'text_no_result' => __("No Result", 'traveler'),
            'cluster_0' => __("<div class='cluster cluster-1'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_20' => __("<div class='cluster cluster-2'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_50' => __("<div class='cluster cluster-3'>CLUSTER_COUNT</div>", 'traveler'),
            'cluster_m1' => get_template_directory_uri() . '/img/map/m1.png',
            'cluster_m2' => get_template_directory_uri() . '/img/map/m2.png',
            'cluster_m3' => get_template_directory_uri() . '/img/map/m3.png',
            'cluster_m4' => get_template_directory_uri() . '/img/map/m4.png',
            'cluster_m5' => get_template_directory_uri() . '/img/map/m5.png',
            'icon_full_screen' => get_template_directory_uri() . '/v2/images/icon_map/ico_fullscreen.svg',
            'icon_my_location' => get_template_directory_uri() . '/v2/images/icon_map/ico_location.svg',
            'icon_my_style' => get_template_directory_uri() . '/v2/images/icon_map/ico_view_maps.svg',
            'icon_zoom_out' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom-out.svg',
            'icon_zoom_in' => get_template_directory_uri() . '/v2/images/icon_map/ico_maps_zoom_in.svg',
            'icon_close' => get_template_directory_uri() . '/v2/images/icon_map/icon_close.svg',

        ]);
        wp_localize_script('jquery', 'st_config_partner', [
            'text_er_image_format' => false,
        ]);

    }

    static function isCheckWooPage()
    {
        $new_layout = st()->get_option('st_theme_style', 'modern');
        if ($new_layout == 'modern') {
            if (function_exists("is_woocommerce") && is_woocommerce()) {
                return true;
            }
            $woocommerce_keys = array("woocommerce_shop_page_id",
                "woocommerce_terms_page_id",
                "woocommerce_cart_page_id",
                "woocommerce_checkout_page_id",
                "woocommerce_pay_page_id",
                "woocommerce_thanks_page_id",
                "woocommerce_myaccount_page_id",
                "woocommerce_edit_address_page_id",
                "woocommerce_view_order_page_id",
                "woocommerce_change_password_page_id",
                "woocommerce_logout_page_id",
                "woocommerce_lost_password_page_id");

            foreach ($woocommerce_keys as $wc_page_id) {
                if (get_the_ID() == get_option($wc_page_id, 0)) {
                    return true;
                }
                $woocommerce_keys = array("woocommerce_shop_page_id",
                    "woocommerce_terms_page_id",
                    "woocommerce_cart_page_id",
                    "woocommerce_checkout_page_id",
                    "woocommerce_pay_page_id",
                    "woocommerce_thanks_page_id",
                    "woocommerce_myaccount_page_id",
                    "woocommerce_edit_address_page_id",
                    "woocommerce_view_order_page_id",
                    "woocommerce_change_password_page_id",
                    "woocommerce_logout_page_id",
                    "woocommerce_lost_password_page_id");

                foreach ($woocommerce_keys as $wc_page_id) {
                    if (get_the_ID() == get_option($wc_page_id, 0)) {
                        return true;
                    }
                }
            }
            return false;
        }

    }
}

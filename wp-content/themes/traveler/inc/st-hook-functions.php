<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * List all hook function
 *
 * Created by ShineTheme
 *
 */
if (!function_exists('st_setup_theme')) :

    function st_setup_theme() {

        add_role('partner', 'Partner', [
            'read' => true, // true allows this capability
            'delete_posts' => true, // true allows this capability
            'edit_posts' => true, // true allows this capability
            'edit_published_posts' => true,
            'upload_files' => true,
            'delete_published_posts' => true,
            'manage_options' => false,
            'wpcf7_edit_contact_form' => false,
        ]);
        // Add caps for Author role
        $role = get_role('partner');
        $role->add_cap('level_2');
        $role->add_cap('level_1');
        $role->add_cap('level_0');
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on stframework, use a find and replace
         * to change $'traveler' to the name of your theme in all the template files
         */

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        //add_theme_support( 'post-thumbnails' );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus([
            'primary' => __('Primary Navigation', 'traveler'),
        ]);


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', [
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ]);
        add_theme_support('custom-header', []);
        add_theme_support('custom-background', []);
        add_theme_support('woocommerce');

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-thumbnails');

        add_theme_support('post-formats', [
            'image', 'video', 'gallery', 'audio', 'quote', 'link'
        ]);
        add_theme_support("title-tag");

        load_theme_textdomain('traveler', ST_TRAVELER_DIR . '/language');

        // Setup the WordPress core custom background feature.
//        add_theme_support( 'custom-background', apply_filters( 'stframework_custom_background_args', array(
//            'default-color' => 'ffffff',
//            'default-image' => '',
//        ) ) );

    }

endif; // stframework_setup

if (! function_exists('st_set_script')) {
    function st_set_script( $scripts, $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
        $script = $scripts->query( $handle, 'registered' );

        if ( $script ) {
            // If already added
            $script->src  = $src;
            $script->deps = $deps;
            $script->ver  = $ver;
            $script->args = $in_footer;

            unset( $script->extra['group'] );

            if ( $in_footer ) {
                $script->add_data( 'group', 1 );
            }
        } else {
            // Add the script
            if ( $in_footer ) {
                $scripts->add( $handle, $src, $deps, $ver, 1 );
            } else {
                $scripts->add( $handle, $src, $deps, $ver );
            }
        }
    }
}


if (!function_exists('st_get_packpage')) {

    function st_get_packpage() {
        $cls_packages = STAdminPackages::get_inst();
        $packages = $cls_packages->get_packages();
        $arr_package = array(
            __('Setting', 'traveler') => 'no',
        );
        foreach ($packages as $key => $value) {
            $arr_package[$value->package_name] = $value->id;
        }
        return $arr_package;
    }

}

if (!function_exists('st_add_sidebar')) {

    function st_add_sidebar() {
        register_sidebar([
            'name' => __('Blog Sidebar', 'traveler'),
            'id' => 'blog-sidebar',
            'description' => __('Widgets in this area will be shown on all posts and pages.', 'traveler'),
            'before_title' => '<label class="h4">',
            'after_title' => '</label>',
            'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
            'after_widget' => '</div>',
        ]);
        if(st()->get_option('option_style', 'modern')== 'classic'){
            register_sidebar([
                'name' => __('Page Sidebar', 'traveler'),
                'id' => 'page-sidebar',
                'description' => __('Widgets in this area will be shown on all  pages.', 'traveler'),
                'before_title' => '<label class="h4">',
                'after_title' => '</label>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
            ]);
            register_sidebar([
                'name' => __('Shop Sidebar', 'traveler'),
                'id' => 'shop',
                'description' => __('Widgets in this area will be shown on all shop page.', 'traveler'),
                'before_title' => '<label class="shop-widget-title">',
                'after_title' => '</label>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget shop-widget %2$s">',
                'after_widget' => '</div>',
            ]);
        }
    }

}

function st_allow_contributor_uploads() {
    $contributor = get_role("subscriber");
    $contributor->add_cap("upload_files");
}

if (!function_exists('st_setup_author')) {

    function st_setup_author() {
        global $wp_query;

        if ($wp_query->is_author() && isset($wp_query->post)) {
            $GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
        }
    }

}

if (!function_exists('st_wp_title')) {

    function st_wp_title($title) {
        if (is_feed()) {
            return $title;
        }

        global $page, $paged;

        if (is_search()) {
            $post_type = STInput::get('post_type');
            $s = STInput::get('s');
            $location_id = STInput::get('location_id');

            $extra = '';
            if (post_type_exists($post_type)) {
                $post_type_obj = get_post_type_object($post_type);
                $extra .= '  ' . $post_type_obj->labels->singular_name;
            }

            $location_name = get_the_title($location_id);

            if ($location_id and $location_name) {
                $extra .= sprintf(__(' in %s', 'traveler'), $location_name);
            }

            if ($extra)
                $extra = __('Search ', 'traveler') . $extra;


            $title['title'] = $extra;
        }


        return $title;
    }

}


if (!function_exists('st_add_scripts')) {

    function st_add_scripts() {
        $check_enable_map_google = st()->get_option('st_googlemap_enabled');
        if (is_page_template('template-member-package-new.php') || is_page_template('template-checkout-packages-new.php') || is_page_template('template-package-success-new.php')) {
            if(function_exists('check_using_elementor') && check_using_elementor()){
                New_Layout_Helper::enqueueNewScriptElementor();
            } else {
                New_Layout_Helper::enqueueNewScript();
            }
            return;
        }
        if (New_Layout_Helper::isLayoutHotelActivity()) {
            if(function_exists('check_using_elementor') && check_using_elementor()){
               
            } else {
                New_Layout_Helper::enqueueHotelActivity();
                return;
            }
           
        }
        if (New_Layout_Helper::isNewLayout()) {
            if (!is_page_template('template-user.php')) {
                if(function_exists('check_using_elementor') && check_using_elementor()){
                    New_Layout_Helper::enqueueNewScriptElementor();
                } else {
                    New_Layout_Helper::enqueueNewScript();
                }
                return;
            }
        }
        //wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'bootstrap-traveler', get_template_directory_uri() . '/js/bootstrap.js', [ 'jquery' ], null, true );

        $gg_api_key = st()->get_option('google_api_key', "");

        if (is_ssl()) {
            $url = add_query_arg([
                'v' => '3', //v=3.exp
                'libraries' => 'places',
                'language' => 'en',
                'key' => $gg_api_key
                    ], 'https://maps.googleapis.com/maps/api/js');
        } else {
            $url = add_query_arg([
                'v' => '3',
                'libraries' => 'places',
                'language' => 'en',
                'key' => $gg_api_key
                    ], 'http://maps.googleapis.com/maps/api/js');
        }
        wp_enqueue_script('gmap-apiv3', $url, ['jquery'], null, true);


        wp_register_script('markerclusterer.js', get_template_directory_uri() . '/js/markerclusterer.js', ['jquery'], null, true);
        wp_register_script('gmapv3', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/gmap/js/gmap3.min.js', ['jquery', 'gmap-apiv3'], null, true);
        wp_register_script('bt-gmapv3-init', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/gmap/js/init.js', ['gmapv3'], null, true);
        wp_register_style('bt-gmapv3', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/gmap/css/bt-gmap.css');

        wp_register_script('gmap-init', get_template_directory_uri() . '/js/init/gmap-init.js', ['gmapv3'], null, true);
        wp_register_script('gmap-init-list-map', get_template_directory_uri() . '/js/init/init-list-map.js', ['gmapv3'], null, true);
        //wp_register_script( 'detailed-map', get_template_directory_uri() . '/js/custom_google_map.js', [ 'gmapv3', 'markerclusterer.js' ], null, true );
        // check out template
        wp_register_script('checkout-js', get_template_directory_uri() . '/js/init/template-checkout.js', ['jquery'], null, true);
        //wp_register_script( 'st-reviews-form', get_template_directory_uri() . '/js/init/review_form.js', [ 'jquery' ], null, true );

        wp_register_script('template-user-js', get_template_directory_uri() . '/js/template-user.js', ['jquery', 'markerclusterer.js'], null, true);
        //wp_register_script( 'user.js', get_template_directory_uri() . '/js/user.js', [ 'jquery' ], null, true );
        //wp_register_script( 'user.js', get_template_directory_uri() . '/js/user.dev.js', [ 'jquery' ], null, true );

        wp_register_script('bulk-calendar', get_template_directory_uri() . '/js/init/bulk-calendar.js', ['jquery',], null, true);

        wp_register_script('google-location', get_template_directory_uri() . '/js/google-location.js', ['jquery',], null, true);

        //wp_register_script( 'date.js', get_template_directory_uri() . '/js/date.js', [ 'jquery' ], null, true );

        wp_register_script( 'moment.js', 'http://localhost/traveler/wp-includes/js/dist/vendor/moment.min.js?ver=2.29.2', [ 'jquery' ], NULL, TRUE );
        wp_register_script( 'fullcalendar', get_template_directory_uri() . '/js/fullcalendar-5.8.0/lib/main.min.js', [ 'jquery', 'moment.js' ], NULL, TRUE );
        wp_register_script( 'fullcalendar-lang', get_template_directory_uri() . '/js/fullcalendar-5.8.0/lib/locales-all.js', [ 'jquery', 'fullcalendar' ], NULL, TRUE );
        wp_register_style('fullcalendar-css', get_template_directory_uri() . '/js/fullcalendar-5.8.0/lib/main.min.css');

        wp_enqueue_script('slimmenu', get_template_directory_uri() . '/js/jquery.slimmenu.min.js', ['jquery'], null, true);

        //wp_enqueue_script( 'bootstrap-datepicker.js', get_template_directory_uri() . '/js/bootstrap-datepicker.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'bootstrap-timepicker.js', get_template_directory_uri() . '/js/bootstrap-timepicker.js', [ 'jquery' ], null, true );
        wp_register_script( 'bootstrap-select-js', get_template_directory_uri() . '/js/bootstrap-select.js', [ 'jquery' ], null, true );

        /* to be Continued */

        //wp_enqueue_script( 'jquery.form', get_template_directory_uri() . '/js/jquery.form.js', [ 'jquery' ], null, true );
        wp_register_script('jquery.matchHeight-min', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', ['jquery'], null, true);

        //wp_register_script( 'ionrangeslider.js', get_template_directory_uri() . '/js/ionrangeslider.js', [ 'jquery' ], null, true );

        wp_register_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', ['jquery'], null, true);

        //Filter js
        //Hotel Room
        wp_register_script('filter-ajax-hotel-room.js', get_template_directory_uri() . '/js/filter-ajax-hotel-room.js', ['jquery'], null, true);
        //Tour
        wp_register_script('filter-ajax.js', get_template_directory_uri() . '/js/filter-ajax.js', ['jquery'], null, true);
        //Hotel
        wp_register_script('filter-ajax-hotel.js', get_template_directory_uri() . '/js/filter-ajax-hotel.js', ['jquery'], null, true);
        //Car
        wp_register_script('filter-ajax-cars.js', get_template_directory_uri() . '/js/filter-ajax-cars.js', ['jquery'], null, true);
        //Activity
        wp_register_script('filter-ajax-activity.js', get_template_directory_uri() . '/js/filter-ajax-activity.js', ['jquery'], null, true);
        //Rental
        wp_register_script('filter-ajax-rental.js', get_template_directory_uri() . '/js/filter-ajax-rental.js', ['jquery'], null, true);
        //Flight
        wp_register_script('filter-ajax-flights.js', get_template_directory_uri() . '/js/filter-ajax-flights.js', ['jquery'], null, true);

        wp_register_script('filter-ajax-all-posttype.js', get_template_directory_uri() . '/js/filter-ajax-all-posttype.js', ['jquery'], null, true);
        //End Filter Ajax
        //fix layout js file
        wp_enqueue_script('custom-3', get_template_directory_uri() . '/js/custom3.js', ['jquery'], null, true);

        //wp_register_script( 'fotorama.js', get_template_directory_uri() . '/js/fotorama.js', [ 'jquery' ], null, true );
        //wp_register_script( 'handlebars-v2.0.0.js', get_template_directory_uri() . '/js/handlebars-v2.0.0.js', [], null, true );
        //wp_register_script( 'typeahead.js', get_template_directory_uri() . '/js/typeahead.js', [ 'jquery', 'handlebars-v2.0.0.js' ], null, true );
        //wp_register_script( 'magnific.js', get_template_directory_uri() . '/js/magnific.js', [ 'jquery' ], null, true );
        //wp_register_script( 'owl-carousel.js', get_template_directory_uri() . '/js/owl-carousel.js', [ 'jquery' ], null, true );

        wp_register_script('syotimer.js', get_template_directory_uri() . '/js/coming-soon/st_tour_ver/jquery.syotimer.js', ['jquery'], null, true);

        wp_register_script('countdown.js', get_template_directory_uri() . '/js/coming-soon/countdown.js', ['jquery'], null, true);
        if (is_page_template('template-commingsoon.php')) {

            wp_enqueue_script('countdown.js');
            wp_enqueue_script('syotimer.js');
        }


        $lang = get_locale();
        $lang_file = ST_TRAVELER_DIR . '/js/locales/bootstrap-datepicker.' . $lang . '.min.js';
        wp_register_script('bootstrap-datepicker.js', get_template_directory_uri() . '/js/bootstrap-datepicker.js', ['jquery'], null, true);
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


        wp_register_script('gridrotator.js', get_template_directory_uri() . '/js/gridrotator.js', ['jquery'], null, true);

        //wp_enqueue_script( 'gmap-info-box', get_template_directory_uri() . '/js/infobox.js', [ 'gmap-apiv3' ], null, true );
        wp_register_script('jquery.noty', get_template_directory_uri() . '/js/noty/packaged/jquery.noty.packaged.min.js', ['jquery'], null, true);

        wp_register_script('chosen.jquery', get_template_directory_uri() . '/js/chosen/chosen.jquery.min.js', ['jquery'], null, true);

        //wp_register_script( 'richmarker.jquery', get_template_directory_uri() . '/js/richmarker.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'st.noty', get_template_directory_uri() . '/js/init/class.notice.js', [ 'jquery', 'jquery.noty' ], null, true );

        wp_register_style('availability', get_template_directory_uri() . '/css/availability.css');

        // is booking modal
        //wp_enqueue_script( 'booking_modal', get_template_directory_uri() . '/js/init/booking_modal.js', [ 'jquery' ], null, true );

        wp_register_script('st.flight', get_template_directory_uri() . '/js/select-flight-location.js', ['jquery'], null, true);

        //wp_register_script( 'st.travelpayouts', get_template_directory_uri() . '/js/custom-travelpayouts.js', [ 'jquery' ], null, true );

        /**
         * @since 1.1.3
         * */
        

        //wp_register_script( 'st-qtip', get_template_directory_uri() . '/js/jquery.qtip.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'mousewheel.js', get_template_directory_uri() . '/js/jquery.mousewheel-3.0.6.pack.js', [ 'jquery' ], null, true );

        /** https://github.com/atomiks/tippyjs */
        wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', [ 'jquery' ], null, true );
        wp_enqueue_script( 'tippy', get_template_directory_uri() . '/js/tippy.min.js', [ 'jquery', 'popper' ], null, true );

        wp_register_script('fancybox.js', get_template_directory_uri() . '/js/jquery.fancybox.js', ['jquery'], null, true);
        wp_register_script('fancybox-buttons.js', get_template_directory_uri() . '/js/helpers/jquery.fancybox-buttons.js', ['jquery', 'fancybox.js'], null, true);
        wp_register_script('fancybox-media.js', get_template_directory_uri() . '/js/helpers/jquery.fancybox-media.js', ['jquery', 'fancybox-buttons.js'], null, true);
        wp_register_script('fancybox-thumbs.js', get_template_directory_uri() . '/js/helpers/jquery.fancybox-thumbs.js', ['jquery', 'fancybox-media.js'], null, true);

        wp_register_style('fancybox.css', get_template_directory_uri() . '/css/jquery.fancybox.css');
        wp_register_style('fancybox-buttons.css', get_template_directory_uri() . '/js/helpers/jquery.fancybox-buttons.css', ['fancybox.css']);
        wp_register_style('fancybox-thumbs.css', get_template_directory_uri() . '/js/helpers/jquery.fancybox-thumbs.css', ['fancybox-buttons.css']);


        //wp_register_script( 'st-select.js', get_template_directory_uri() . '/js/init/st-select.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'st-custom-price', get_template_directory_uri() . '/js/admin/custom-price.js', [ 'jquery' ], null, true );
//            wp_enqueue_script( 'custom.js', get_template_directory_uri() . '/js/custom.js', [ 'jquery' ], null, true );
        wp_register_script('custom.js', get_template_directory_uri() . '/js/custom.js', ['jquery'], null, true);

        wp_register_script('custom2.js', get_template_directory_uri() . '/js/custom2.js', ['jquery'], null, true);
        // if (is_page_template('template-transfer-search.php')){
        //     wp_register_script('transfer-car-mapbox.js', get_template_directory_uri() . '/js/transfer-car-mapbox.js', ['jquery'], null, true);
        // }
        //wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/sticky.js', [ 'jquery' ], null, true );


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
        $st_token_mapbox = st()->get_option('st_token_mapbox');
        if (isset($st_token_mapbox) && !empty($st_token_mapbox)) {
            $st_token_mapbox = $st_token_mapbox;
        } else {
            $st_token_mapbox = 'pk.eyJ1IjoidGhvYWluZ28iLCJhIjoiY2p3dTE4bDFtMDAweTQ5cm5rMXA5anUwMSJ9.RkIx76muBIvcZ5HDb2g0Bw';
        }
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
        $locale = get_locale();
            $locale_fullcalendar = $locale;
            if (substr($locale, 0, 2)) {
                $locale_fullcalendar = strtolower(substr($locale, 0, 2));
            }
        wp_localize_script('jquery', 'st_params', [
            'theme_url' => get_template_directory_uri(),
            'locale_fullcalendar' => $locale_fullcalendar,
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
            //'locale' => TravelHelper::get_minify_locale(get_locale()),
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
            'text_price' => __("Price", 'traveler'),
            'text_origin_price' => __("Origin Price", 'traveler'),
            'text_unavailable' => __('Not Available ', 'traveler'),
            'text_available' => __('Available ', 'traveler'),
            'text_adult_price' => __('Adult Price ', 'traveler'),
            'text_child_price' => __('Child Price ', 'traveler'),
            'text_infant_price' => __("Infant", 'traveler'),
            'text_update' => __('Update ', 'traveler'),
            'text_adult' => __('Adult ', 'traveler'),
            'text_child' => __('Child ', 'traveler'),
            'token_mapbox' => $st_token_mapbox,
            'text_use_this_media' => __('Use this media', 'traveler'),
            'st_icon_mapbox' => $st_icon_mapbox,
            'text_rtl_mapbox' => $text_rtl_mapbox,
            'text_select_image' => __('Select Image', 'traveler'),
            'text_confirm_delete_item' => __('Are you sure want to delete this item?', 'traveler'),
            'text_process_cancel' => __('You cancelled the process', 'traveler'),
            'prev_month' => __('prev month', 'traveler'),
            'next_month' => __('next month', 'traveler'),
            'please_waite' => __('Please wait...', 'traveler'),
                //Set multi lang using js
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
            'today' => __('Today', 'traveler'),
            'please_waite' => __('Please wait...', 'traveler'),
            'buttons' => __('buttons', 'traveler'),
        ]);
        wp_localize_script('jquery', 'gantt', [
            'notice_guide' => __(
                '<h3>How to use?</h3><p><strong>Change price/availability:</strong> Click on <strong>start date</strong> then hover to <strong>end date</strong> and click again. Enter the price in the text field when the popup is displayed</p><p><strong>Change the display date range</strong>: Click on the icons at the bottom (today, previous month, next month) or enter the date in <strong>the start date, end date</strong> field and click <strong>the View button</strong>.</p><p><strong>Change the number of room</strong>: Click on the pen icon near the name of room. Enter the number in the text field when the popup is displayed</p>',
                'traveler'
             ),
        ]);
        wp_localize_script('jquery', 'st_timezone', [
            'timezone_string' => get_option('timezone_string', 'local'),
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
        ]);
        wp_localize_script('jquery', 'st_config_partner', [
            'text_er_image_format' => false,
        ]);


        // template user
        wp_register_script('select2.js', get_template_directory_uri() . '/js/select2-new/js/select2.full.js', ['jquery'], NULL, TRUE);
        $lang = get_locale();
        $lang_file = ST_TRAVELER_DIR . '/js/select2-new/js/i18n/' . $lang . '.js';
        if (file_exists($lang_file)) {
            wp_register_script('select2-lang', get_template_directory_uri() . '/js/select2-new/js/i18n/' . $lang . '.js', ['jquery', 'select2.js'], null, true);
        } else {
            $locale = TravelHelper::get_minify_locale($lang);
            $lang_file = get_template_directory_uri() . '/js/select2-new/js/i18n/' . $locale . '.js';
            if (file_exists($lang_file)) {
                wp_register_script('select2-lang', get_template_directory_uri() . '/js/select2-new/js/i18n/' . $locale . '.js', ['jquery', 'select2.js'], null, true);
            }
        }
        wp_register_style('st-select2', get_template_directory_uri() . '/js/select2-new/css/select2.css');

        $post_id = (int) STInput::get('id', '');
        $lists = [];
        $results = st_get_data_location_from_to($post_id);
        if (!empty($results)) {
            foreach ($results as $item) {
                $lists[] = [
                    'pickup' => (int) $item['location_from'],
                    'pickup_text' => get_the_title((int) $item['location_from']),
                    'dropoff' => (int) $item['location_to'],
                    'dropoff_text' => get_the_title((int) $item['location_to'])
                ];
            }
        }
        wp_localize_script('jquery', 'st_location_from_to', [
            'lists' => $lists
        ]);

        if (is_page_template('template-user.php')) {
            //wp_enqueue_script( 'Chart.min.js', get_template_directory_uri() . '/inc/plugins/chart-master/Chart.js', [ 'jquery' ], null, true );
            if ($check_enable_map_google === 'on') {

            } else {
                wp_register_script('mapboxv5', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js', array(), true, false);
                wp_register_script('mapboxv5-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.min.js', array(), true, false);
                wp_register_style('mapbox-css-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css');
                wp_register_style('mapbox-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css');
                wp_register_style('init-mapbox-partner', get_template_directory_uri() . '/v2/js/mapbox/init-mapbox.js', ['jquery'], null, true);
            }



            wp_enqueue_script('Chart.min2.js', get_template_directory_uri() . '/v2/js/Chart.min.js', ['jquery'], null, true);
            wp_register_style('availability_partner', get_template_directory_uri() . '/css/availability_partner.css');
            wp_enqueue_script('select2.js');
            wp_enqueue_script('select2-lang');
            wp_enqueue_style('st-select2');
            // edit room
            if (get_query_var('sc') == 'edit-room') {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');
                wp_enqueue_script('hotel_room_availability_partner', get_template_directory_uri() . '/js/availability_hotel_partner.js', ['jquery'], NULL, TRUE);
                wp_enqueue_style('availability_partner');
            }

            // edit tour
            if (get_query_var('sc') == 'edit-tours') {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');

                wp_enqueue_script('tour_availability_partner', get_template_directory_uri() . '/js/availability_tour_partner.js', ['jquery'], NULL, TRUE);
                wp_enqueue_style('availability_partner');
            }

            // edit activity
            if (get_query_var('sc') == 'edit-activity') {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');
                wp_enqueue_style('availability_partner');
                wp_enqueue_script('activity_availability_partner', get_template_directory_uri() . '/js/availability_activity_partner.js', ['jquery'], NULL, TRUE);
            }

            // edit flight
            if (get_query_var('sc') == 'create-flight' || get_query_var('sc') == 'edit-flight') {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');
                wp_enqueue_style('availability_partner');
                wp_enqueue_script('flight_availability_partner', get_template_directory_uri() . '/js/availability_flight_partner.js', ['jquery'], NULL, TRUE);
            }

            // edit rental
            if (get_query_var('sc') == 'edit-rental') {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');
                wp_enqueue_style('availability_partner');
                wp_enqueue_script('rental_availability_partner', get_template_directory_uri() . '/js/availability_rental_partner.js', ['jquery'], NULL, TRUE);
            }

            // add tour booking
            if (in_array(get_query_var('sc'), ['add-hotel-booking', 'add-hotel-room-booking', 'add-tour-booking', 'add-activity-booking', 'add-car-booking', 'add-cartransfer-booking', 'add-rental-booking'])) {
                wp_enqueue_script('fullcalendar');
                wp_enqueue_script('fullcalendar-lang');
                wp_enqueue_style('fullcalendar-css');
                wp_enqueue_style('availability');
                wp_enqueue_script('booking-partner.js', get_template_directory_uri() . '/js/booking_partner.js', ['jquery'], null, true);
                wp_enqueue_script('booking-partner-v2.js', get_template_directory_uri() . '/v2/js/booking_partner.js', ['jquery'], null, true);
            }

            //Inventory enque script
            wp_register_script('moment.min', get_template_directory_uri() . '/js/moment.js', array('jquery'), NULL, TRUE);
            wp_register_script('prettify', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/inventory/js/prettify.js', array('moment.min'), NULL, TRUE);
            wp_register_script('jquery.lang.gantt', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/inventory/js/lang.js', array('jquery', 'prettify'), NULL, TRUE);
            wp_register_script('gantt-js', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/inventory/js/jquery.fn.gantt.js', array('moment.min'), NULL, TRUE);
            wp_register_script('inventory-js', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/inventory/js/inventory.js', ['gantt-js'], null, true);
            wp_register_style('gantt-css', get_template_directory_uri() . '/inc/plugins/ot-custom/fields/inventory/css/style.css');

            if (get_query_var('sc') == 'inbox') {
                $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
                wp_enqueue_style('custom_inbox', get_template_directory_uri() . '/css/custom-inbox.css');
                wp_register_script('custom_tour_inbox', get_template_directory_uri() . '/js/inbox/custom-tour-inbox'. $suffix .'.js', ['jquery'], NULL, TRUE);
                wp_register_script('custom_activity_inbox', get_template_directory_uri() . '/js/inbox/custom-activity-inbox'. $suffix .'.js', ['jquery'], NULL, TRUE);
                wp_register_script('custom_rental_inbox', get_template_directory_uri() . '/js/inbox/custom-rental-inbox'. $suffix .'.js', ['jquery'], NULL, TRUE);
                wp_register_script('custom_hotel_room_inbox', get_template_directory_uri() . '/js/inbox/custom-hotel-room-inbox'. $suffix .'.js', ['jquery'], NULL, TRUE);
                wp_register_script('custom_car_inbox', get_template_directory_uri() . '/js/inbox/custom-car-inbox'. $suffix .'.js', ['jquery'], NULL, TRUE);
            }
            $new_layout = st()->get_option('st_theme_style', 'modern');
            if ($new_layout == 'modern') {
                wp_enqueue_style('google-font-css', 'https://fonts.googleapis.com/css?family=Poppins:400,500,600');
            }
            wp_enqueue_style('fixudashboard-css', get_template_directory_uri() . '/v2/css/fixudashboard.css');

            if (is_rtl() && st()->get_option('right_to_left') == 'on') {
                wp_enqueue_style('v2-rtl.css', get_template_directory_uri() . '/v2/css/rtl.css');
            }
        }


        //Stripe token
        $sanbox_stripe = st()->get_option('stripe_enable_sandbox', 'on');
        $stripe_params['stripe'] = [
            'publishKey' => st()->get_option('stripe_publish_key', ''),
            'testPublishKey' => st()->get_option('stripe_test_publish_key', ''),
            'sanbox' => ($sanbox_stripe == 'on') ? 'sandbox' : 'live',
        ];
        wp_localize_script('jquery', 'st_stripe_params', $stripe_params);

        /**
         * @since 1.1.0
         * */
        if (is_singular('st_rental')) {
            //wp_enqueue_script( 'rental-js', get_template_directory_uri() . '/js/init/rental-date-ajax.js', [ 'jquery' ], null, true );
            wp_enqueue_script( 'single-rental-js', get_template_directory_uri() . '/js/init/single-rental.js', ['jquery'], NULL, true);
        }

        if (is_singular('hotel_room')) {
            wp_enqueue_script( 'single-hotel-room-js', get_template_directory_uri() . '/js/init/single-hotel-room.js', [ 'jquery' ], NULL, true );
            //Add js for change price when select extra service
            //wp_enqueue_script( 'custom-4.js', get_template_directory_uri() . '/js/custom4.js', [ 'jquery' ], null, true );
        }
        if (is_singular('st_hotel')) {
            wp_register_script('map_box_single_hotel', get_template_directory_uri() . '/js/single/map_box_single_hotel.js');
            //wp_enqueue_script( 'hotel-ajax', get_template_directory_uri() . '/js/init/hotel-ajax.js', [ 'jquery' ], null, true );
            //wp_enqueue_script( 'single-hotel-js', get_template_directory_uri() . '/js/init/single-hotel.js', [ 'jquery' ], NULL, true );
            //wp_enqueue_script( 'custom-5.js', get_template_directory_uri() . '/js/custom5.js', [ 'jquery' ], null, true );
        }
        if (is_singular('st_tours')) {
            wp_enqueue_script('single-tour-js', get_template_directory_uri() . '/js/init/single-tour.js', ['jquery'], NULL, true);
            wp_register_script('map_box_single_hotel', get_template_directory_uri() . '/js/single/map_box_single_hotel.js');
        }
        if (is_singular('st_activity')) {
            wp_enqueue_script('single-activity-js', get_template_directory_uri() . '/js/init/single-activity.js', ['jquery'], NULL, true);
        }
        if (is_singular('st_cars')) {
            wp_enqueue_script('single-car', get_template_directory_uri() . '/js/init/single-car.js', ['jquery'], null, true);
        }
        if (is_singular('location')) {
            wp_enqueue_script('single-location', get_template_directory_uri() . '/js/init/single-location.js', ['jquery'], null, true);
        }

        //icon picker
        //wp_enqueue_script( 'iconpicker', get_template_directory_uri() . '/js/iconpicker/js/fontawesome-iconpicker.min.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 'jquery.scrollTo.min.js', get_template_directory_uri() . '/js/jquery.scrollTo.min.js', [ 'jquery' ], null, true );

        if (class_exists('WooCommerce')) {
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-smallscreen');
            wp_dequeue_style('woocommerce-general');
        }
        // remove some css stylesheet from external plugins
        wp_deregister_style('js_composer_front');
        wp_deregister_style('wsl-widget');
        wp_deregister_style('contact-form-7');

        wp_enqueue_script('traveler', get_template_directory_uri() . '/dist/traveler.js', array('jquery'), null, true);
        $check_enable_map_google = st()->get_option('st_googlemap_enabled');
        if ($check_enable_map_google === 'on') {

        } else {
            wp_enqueue_script('mapbox-js', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js', ['jquery'], null, false);
            wp_enqueue_style('mapbox-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css');
            wp_enqueue_script('custom-init-mapbox-js', get_template_directory_uri() . '/js/custom_init_mapbox.js', ['jquery'], NULL, true);
        }
        wp_enqueue_style('traveler', get_template_directory_uri() . '/css/traveler.css');
        wp_enqueue_style('traveler-ext', get_template_directory_uri() . '/css/traveler-ext.css');
        wp_enqueue_style('traveler-enquire', get_template_directory_uri() . '/css/custom-enquire.css');
        //wp_enqueue_script('custom-lazyload-js',get_template_directory_uri().'/js/custom-lazyload.js');
        //wp_enqueue_style('custom-lazyload-css',get_template_directory_uri().'/css/custom-lazyload.css');
//            wp_enqueue_style( 'slimmenu-css', get_template_directory_uri() . '/css/slimmenu.min.css' );
//            wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css' );
//            wp_enqueue_style( 'animate.css', get_template_directory_uri() . '/css/animate.css' );
//            wp_enqueue_style( 'selectize-css' );
//            wp_enqueue_style( 'selectize-bt3-css' );
//            wp_enqueue_style( 'iconpicker-css' );
//            wp_enqueue_style( 'switcher' );

        if (class_exists('Vc_Base') and function_exists('vc_asset_url')) {
            $front_css_file = vc_asset_url('css/js_composer.min.css');
            wp_enqueue_style('js_composer_front', $front_css_file, [], WPB_VC_VERSION);
        }

        if (class_exists('WooCommerce')) {
            wp_enqueue_style('woocommerce-layout');
            wp_enqueue_style('woocommerce-smallscreen');
            wp_enqueue_style('woocommerce-general');
        }
        if (function_exists('wsl_activate')) {
            wp_enqueue_style("wsl-widget", WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . "assets/css/style.css");
        }
        if (defined('WPCF7_VERSION')) {
            wp_enqueue_style('contact-form-7', wpcf7_plugin_url('includes/css/styles.css'), [], WPCF7_VERSION, 'all');

            if (wpcf7_is_rtl()) {
                wp_enqueue_style('contact-form-7-rtl', wpcf7_plugin_url('includes/css/styles-rtl.css'), [], WPCF7_VERSION, 'all');
            }

            do_action('wpcf7_enqueue_styles');
        }

        if (function_exists('w3tc_cdncache_purge_url')) {

            function remove_cssjs_ver($src) {
                if (strpos($src, '?ver='))
                    $src = remove_query_arg('ver', $src);

                return $src;
            }

            add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
            add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);
        }

        //wp_enqueue_style( 'icomoon.css', get_template_directory_uri() . '/css/icomoon.css' );
        //wp_register_style( 'weather-icons.css', get_template_directory_uri() . '/css/weather-icons.min.css' );
       
        //wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.css' );
        wp_register_style( 'bootstrap-select-css', get_template_directory_uri() . '/css/bootstrap-select.css' );
        wp_register_style('iconpicker-css', get_template_directory_uri() . '/js/iconpicker/css/fontawesome-iconpicker.css');
        //wp_enqueue_style( 'styles.css', get_template_directory_uri() . '/css/styles.css' );
        //wp_enqueue_style( 'tooltip-classic.css', get_template_directory_uri() . '/css/tooltip-classic.css' );

        wp_register_style('chosen-css', get_template_directory_uri() . '/js/chosen/chosen.min.css');

        //wp_enqueue_style( 'default-style', get_stylesheet_uri() );
        // wp_enqueue_style( 'custom.css', get_template_directory_uri() . '/css/custom.css' );
        // wp_enqueue_style( 'custom2css', get_template_directory_uri() . '/css/custom2.css' );
        // wp_enqueue_style( 'custom5css', get_template_directory_uri() . '/css/custom5.css' );
        //xsearch style ajax filter
        // wp_enqueue_style('ajax-filter', get_template_directory_uri() . '/css/ajax-filter.css');
        //custom css fix layout
        // wp_enqueue_style('custom-3', get_template_directory_uri() . '/css/custom3.css');
        // wp_enqueue_style( 'filter-ajax-styles', get_template_directory_uri() . '/css/filter-ajax-styles.css' );
        // wp_enqueue_style( 'st_tour_ver', get_template_directory_uri() . '/css/st_tour_ver.css' );
        // wp_enqueue_style( 'user.css', get_template_directory_uri() . '/css/user.css' );
        // wp_enqueue_style( 'custom-responsive', get_template_directory_uri() . '/css/custom-responsive.css' );
        //wp_register_style( 'st-select.css', get_template_directory_uri() . '/css/st-select.css' );

        wp_register_script('testimonial', get_template_directory_uri() . '/js/testimonial.js', ['jquery'], null, true);

//            wp_enqueue_style( 'hover_effect_demo', get_template_directory_uri() . '/css/hover_effect/demo.css' );
//            wp_enqueue_style( 'hover_effect_normal', get_template_directory_uri() . '/css/hover_effect/normalize.css' );
//            wp_enqueue_style( 'hover_effect_set1', get_template_directory_uri() . '/css/hover_effect/set1.css' );
//            wp_enqueue_style( 'hover_effect_set2', get_template_directory_uri() . '/css/hover_effect/set2.css' );
//            wp_enqueue_style( 'box_icon_color', get_template_directory_uri() . '/css/box-icon-color.css' );


        if (st_is_https()) {
            wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:500,700,400,300,100');
        } else {
            wp_enqueue_style('roboto-font', 'http://fonts.googleapis.com/css?family=Roboto:500,700,400,300,100');
        }
        if (st()->get_option('right_to_left') == 'on') {
            wp_enqueue_style('rtl.css', get_template_directory_uri() . '/rtl.css');
        }
        //$menu_style = st()->get_option( 'menu_style', '1' );
        //wp_enqueue_style( 'menu_style' . $menu_style . '.css', get_template_directory_uri() . '/css/menu_style' . $menu_style . '.css' );

        $list_icon = get_option('st_list_fonticon_', []);
        if (is_array($list_icon) && count($list_icon)) {
            foreach ($list_icon as $item => $val) {
                $url_font = ($val['link_file_css']);
                if (is_ssl()) {
                    $url_font = str_ireplace("http://", "https://", $url_font);
                }
                wp_enqueue_style($item, $url_font);
            }
        }

        if (is_page() && is_page_template('template-user.php')) {
            if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
                $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                wp_enqueue_script('recaptcha.js', 'https://www.google.com/recaptcha/api.js?render='.$st_site_key_captcha,['jquery'], true, false);

            }
            $new_layout = st()->get_option('st_theme_style', 'modern');
            
            //wp_dequeue_script('traveler');
            wp_dequeue_style('fixudashboard-css');
            wp_dequeue_style('traveler-ext');
            wp_dequeue_style('js_composer_front');
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-smallscreen');
            wp_dequeue_style('woocommerce-general');
            wp_dequeue_style('contact-form-7');
            //wp_dequeue_style('st-select2');
            wp_dequeue_style('traveler');
            //wp_dequeue_script('nicescroll.js');
            wp_localize_script('jquery', 'dashboard_params', array(
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
                'complete_registration_text' => __('COMPLETE YOUR REGISTRATION', 'traveler'),
                'complete_text' => __('COMPLETE', 'traveler'),
                'continue_text' => __('CONTINUE', 'traveler'),
            ));
            wp_enqueue_style('google-font-Poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
            wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.css');
            wp_enqueue_style('daterangepicker-css', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.css');
            wp_enqueue_style('sts-single-hotel-page', get_template_directory_uri() . '/v2/css/single-hotel-page.css');
            wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.css');
            wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/v2/css/bootstrap.min.css');
            wp_enqueue_style('st-partner-v2', get_template_directory_uri() . '/v2/css/partner.css');
            $sc = STInput::get('sc');
            $array_sc = array('create-hotel', 'edit-hotel', 'create-room', 'edit-room', 'create-tours', 'edit-tours', 'create-activity', 'edit-activity', 'create-rental', 'edit-rental', 'create-room-rental', 'edit-room-rental', 'create-cars', 'edit-cars', 'create-flight', 'edit-flight');
            if (!empty($sc) && in_array($sc, $array_sc)) {
                wp_enqueue_style('st-user-css', get_template_directory_uri() . '/css/user.css');
            }

            wp_enqueue_style('st-partner-h-v2', get_template_directory_uri() . '/v2/css/partner-h.css');

            // wp_enqueue_script('daterangepicker-lang-js', get_template_directory_uri() . '/v2/js/daterangepicker/languages/' . get_locale() . '.js', ['jquery'], null, true);
            $lang = get_locale();
            $lang_file = ST_TRAVELER_DIR . '/v2/js/daterangepicker/languages/' . $lang . '.js';
            if (file_exists($lang_file)) {
                wp_enqueue_script('daterangepicker-lang-js', get_template_directory_uri() . '/v2/js/daterangepicker/languages/' . $lang . '.js', ['jquery'], null, true);
            } else {
                $locale_array = explode('_', $lang);
                if (!empty($locale_array) and $locale_array[0]) {
                    $locale = $locale_array[0];

                    $lang_file = ST_TRAVELER_DIR . '/v2/js/daterangepicker/languages/' . $lang . '.js';
                    if (file_exists($lang_file)) {
                        wp_enqueue_script('daterangepicker-lang-js', get_template_directory_uri() . '/v2/js/daterangepicker/languages/' . $lang . '.js', ['jquery'], null, true);
                    } else {
                        $lang = TravelHelper::get_minify_locale(get_locale());
                        $lang_file = ST_TRAVELER_DIR . '/v2/js/daterangepicker/languages/' . $lang . '.js';
                        if (file_exists($lang_file))
                            wp_enqueue_script('daterangepicker-lang-js', get_template_directory_uri() . '/v2/js/daterangepicker/languages/' . $lang . '.js', ['jquery'], null, true);
                    }
                } else {
                    $lang = TravelHelper::get_minify_locale(get_locale());
                    $lang_file = ST_TRAVELER_DIR . '/v2/js/daterangepicker/languages/' . $lang . '.js';
                    if (file_exists($lang_file))
                        wp_enqueue_script('daterangepicker-lang-js', get_template_directory_uri() . '/v2/js/daterangepicker/languages/' . $lang . '.js', ['jquery'], null, true);
                }
            }
            wp_enqueue_script('daterangepicker-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker.js', ['jquery'], null, true);
            wp_enqueue_script('st-partner-v2', get_template_directory_uri() . '/v2/js/partner.js', ['jquery'], null, true);
            wp_enqueue_script('st-partner-h-v2', get_template_directory_uri() . '/v2/js/partner-h.js', ['jquery'], null, true);
            //wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/v2/js/bootstrap.min.js', ['jquery'], null, true);
            wp_enqueue_script('bootstrap-timepicker-js', get_template_directory_uri() . '/v2/js/bootstrap-timepicker.js', ['jquery'], null, true);
            wp_enqueue_script('jquery.matchHeight-min');
            $gg_api_key = st()->get_option('google_api_key', "");

            if (is_ssl()) {
                $url = add_query_arg([
                    'v' => '3', //v=3.exp
                    'libraries' => 'places',
                    'language' => 'en',
                    'key' => $gg_api_key
                        ], 'https://maps.googleapis.com/maps/api/js');
            } else {
                $url = add_query_arg([
                    'v' => '3',
                    'libraries' => 'places',
                    'language' => 'en',
                    'key' => $gg_api_key
                        ], 'https://maps.googleapis.com/maps/api/js');
            }

            wp_register_script('gmap-apiv3', $url, ['jquery'], null, true);

            wp_register_script('st-partner-address_autocomplete', get_template_directory_uri() . '/v2/js/address_autocomplete.js', array('jquery', 'gmap-apiv3'), false, true);
            wp_register_style('st-partner-address_autocomplete', get_template_directory_uri() . '/v2/css/address_autocomplete.css');

            wp_register_script('st-partner-gmapv3', get_template_directory_uri() . '/v2/js/gmap3.min.js', array('jquery', 'gmap-apiv3'), false, true);
            wp_register_script('st-partner-gmapv3-init', get_template_directory_uri() . '/v2/js/partner-map.js', array('st-partner-gmapv3'), false, true);
            wp_register_script('init-mapbox-partner', get_template_directory_uri() . '/v2/js/mapbox/init-mapbox.js', array(), false, true);
            wp_enqueue_style('mapbox-custom-css', get_template_directory_uri() . '/v2/css/mapbox-custom.css');
            wp_register_script('daterangepicker-new-js', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker-new.js', ['jquery'], null, true);
            wp_register_style('daterangepicker-new-css', get_template_directory_uri() . '/v2/js/daterangepicker/daterangepicker-new.css');
        }
    }

}

if (!function_exists('st_enqueue_scripts_footer')) {

    function st_enqueue_scripts_footer() {
        //wp_enqueue_script( 'custom.js');
    }

}
if (!function_exists('st_before_footer')) {
    add_action('st_before_footer', 'st_before_footer');

    function st_before_footer() {
        if (defined('W3TC')) {
            //echo "<!-- W3TC-include-css -->";
        }
    }

}
if (!function_exists('st_add_custom_css')) {
    add_action(defined('W3TC') ? 'st_after_footer' : 'wp_head', 'st_add_custom_css', 21);

    function st_add_custom_css() {

        $css = '';

        if ($scheme = st()->get_option('style_default_scheme')) {
            if (New_Layout_Helper::isNewLayout()) {
                $css .= st()->load_template('layouts/modern/custom_css', null, ['main_color_char' => $scheme]);
            } else {
                $css .= st()->load_template('custom_css', null, ['main_color_char' => $scheme]);
            }
        } else {
            if (New_Layout_Helper::isNewLayout()) {
                $css .= st()->load_template('layouts/modern/custom_css', null, ['main_color_char' => $scheme]);
            } else {
                $css .= st()->load_template('custom_css');
            }
        }

        echo "\r\n";
        ?>
        <!-- Custom_css.php-->
        <style id="st_custom_css_php">
        <?php echo ($css) ?>
        </style>
        <!-- End Custom_css.php-->
        <!-- start css hook filter -->
        <style type="text/css" id="st_custom_css">
        <?php echo apply_filters('st_custom_css', ""); ?>
        </style>
        <!-- end css hook filter -->
        <!-- css disable javascript -->
        <?php $allow_disable_script = st()->get_option("sp_disable_javascript", "off"); ?>
        <style type="text/css" id="st_enable_javascript">
        <?php
        if ($allow_disable_script != "on") {
            echo ".search-tabs-bg > .tabbable >.tab-content > .tab-pane{display: none; opacity: 0;}.search-tabs-bg > .tabbable >.tab-content > .tab-pane.active{display: block;opacity: 1;}.search-tabs-to-top { margin-top: -120px;}";
        }
        ?>
        </style>

        <style>
        <?php echo st()->get_option('custom_css'); ?>
        </style>
        <?php
    }

}


if (!function_exists('st_before_body_content')) {

    function st_before_body_content() {
        if (st()->get_option('gen_disable_preload') == "off") {
            ?>
            <!-- Preload -->
            <div id="bt-preload"></div>
            <!-- End Preload -->
            <?php
        }

        echo st()->get_option('adv_before_body_content');
    }

}

if (!function_exists('st_add_compress_html')) {

    function st_add_compress_html() {
//            if (st()->get_option('adv_compress_html') == "on") {
//                include_once st()->dir('plugins/html-compression.php');
//            }
    }

}

if (!function_exists('st_add_ie8_support')) {

    function st_add_ie8_support() {
        ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php
        if (st()->get_option('social_gg_login', 'off') == 'on') {
            ?>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <?php
        }
    }

}

if (!function_exists('st_add_custom_style')) {

    function st_add_custom_style() {
        get_template_part('custom-style');
    }

}

if (!function_exists('st_control_container')) {

    function st_control_container($is_wrap = false) {
        $layout = st()->get_option('style_layout');

        if (is_singular()) {
            if ($layout_meta = get_post_meta(get_the_ID(), 'style_layout', true)) {
                $layout = $layout_meta;
            }
        }

        if ($layout == "boxed") {
            return "container";
        } else {
            return "container-fluid";
        }
    }

}

if (!function_exists('st_blog_sidebar')) {

    function st_blog_sidebar() {
        $sidebar_pos = st()->get_option('blog_sidebar_pos', 'right');


        if (is_single()) {
            if ($sidebar_pos_meta = get_post_meta(get_the_ID(), 'post_sidebar_pos', true)) {
                $sidebar_pos = $sidebar_pos_meta;
            }
        } else if (is_page()) {

            if ($sidebar_pos_meta = get_post_meta(get_the_ID(), 'post_sidebar_pos', true)) {
                $sidebar_pos = $sidebar_pos_meta;
            }
        }

        return $sidebar_pos;
    }

}

if (!function_exists('st_blog_sidebar_id')) {

    function st_blog_sidebar_id() {
        $sidebar_id = st()->get_option('blog_sidebar_id');


        if (is_single()) {
            if ($sidebar_id_meta = get_post_meta(get_the_ID(), 'post_sidebar', true)) {
                $sidebar_id = $sidebar_id_meta;
            }
        } else if (is_page()) {

            if ($sidebar_id_meta = get_post_meta(get_the_ID(), 'post_sidebar', true)) {
                $sidebar_id = $sidebar_id_meta;
            }
        }

        return $sidebar_id;
    }

}


if (!function_exists('st_change_comment_excerpt_limit')) {

    function st_change_comment_excerpt_limit($comment) {
        return TravelHelper::cutnchar($comment, 55);
    }

}
if (!function_exists('st_set_post_view')) {

    function st_set_post_view() {
        if (is_singular()) {
            $count_key = 'post_views_count';
            $count = get_post_meta(get_the_ID(), $count_key, true);


            if ($count) {
                $count = 0;
                $count++;
            }
            update_post_meta(get_the_ID(), $count_key, $count);
        }
    }

}


if (!function_exists('st_admin_add_scripts')) {

    function st_admin_add_scripts() {
        wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.css');
        wp_register_script('bulk-calendar', get_template_directory_uri() . '/js/init/bulk-calendar.js', ['jquery',], null, true);

        //wp_enqueue_script('admin-custom-js', st()->url('js/custom.js'), array('gmapv3'));
        wp_enqueue_style('admin-custom-css', st()->url('css/custom_admin.css'));
    }

}

if (!function_exists('st_admin_body_class')) {

    function st_admin_body_class($class = []) {

        return $class;
    }

}


if (!function_exists('st_add_body_class')) {

    function st_add_body_class($class) {
        $class[] = (st()->get_option('body_class', ''));
        $class[] = (st()->get_option('style_layout', ''));
        $class[] = "menu_style" . st()->get_option('menu_style', '1');
        if (st()->get_option('menu_style', '1') == '4')
            $class[] = "menu_position_" . (st()->get_option('menu_position', 'default'));
        if (st()->get_option('enable_topbar', 'off') == 'on')
            $class[] = "topbar_position_" . (st()->get_option('topbar_position', 'default'));
        

        $class[] = STInput::get("sc");
        if (st()->get_option('search_enable_preload', 'on') == 'on' and is_search()) {
            $class[] = 'search_enable_preload';
        }

        if (st()->get_option('search_enable_preload', 'on') == 'on') {
            $class[] = 'search_enable_preload';
        }

        if (st()->get_option('gen_enable_sticky_topbar', 'off') == 'on') {
            $class[] = 'enable_sticky_topbar';
        }

        if (st()->get_option('gen_enable_sticky_header', 'off') == 'on') {
            $class[] = 'enable_sticky_header';
        }
        if (st()->get_option('gen_enable_sticky_menu', 'off') == 'on') {
            $class[] = 'enable_sticky_menu';
        }

        if (st()->get_option('header_transparent') == 'on') {
            $class[] = 'header_transparent';
        }

        if (is_admin_bar_showing()) {
            $class[] = 'admin_bar_showing';
        }

        return apply_filters('st_body_class', $class);
    }

}


add_action('admin_footer', 'st_add_vc_element_icon');
if (!function_exists('st_add_vc_element_icon')) {

    function st_add_vc_element_icon() {
        ?>
        <style>
            .vc-element-icon.icon-st,
            .vc_element-icon.icon-st {
                background-image: url('<?php echo get_template_directory_uri() . '/img/logo80x80.png' ?>') !important;
                background-size: 100% 100%;
            }

            .vc_shortcodes_container > .wpb_element_wrapper > .wpb_element_title .vc_element-icon.icon-st {
                background-position: 0px
            }

        </style>
        <?php
    }

}


if (!function_exists('st_get_layout')) {

    function st_get_layout($post_type, $q = null) {
        if (empty($q))
            $q = '';
        if (empty($post_type))
            return false;
        $data[] = [
            'value' => '',
            'label' => __('Default', 'traveler')
        ];
        global $wpdb;
        $default = explode('_search', $post_type);
        $default = $default[0];
        $sql = st_get_layout_sql($post_type, $q);
        $rs = $wpdb->get_results($sql, OBJECT);
        if (empty($rs)) {
            $rs = $wpdb->get_results(st_get_layout_sql($default, $q), OBJECT);
        }
        if (!empty($rs)) {
            foreach ($rs as $k => $v) {
                if ($v->post_title) {
                    $data[] = [
                        'value' => $v->ID,
                        'label' => $v->post_title
                    ];
                }
            }
        }

        return $data;
    }

}
if (!function_exists('st_get_layout_sql')) {

    function st_get_layout_sql($post_type, $q = null) {
        if (!$post_type)
            return '';
        global $wpdb;

        $like_name = "";
        if (!empty($q))
            $like_name = " AND {$wpdb->posts}.post_title LIKE '%{$q}%' ";

        return $sql = "SELECT {$wpdb->posts}.ID, {$wpdb->posts}.post_title FROM " . $wpdb->posts . "  INNER JOIN $wpdb->postmeta ON ( " . $wpdb->posts . ".ID = " . $wpdb->postmeta . ".post_id )
                    WHERE 1=1
                    AND
                    (
                      ( " . $wpdb->postmeta . ".meta_key = 'st_type_layout' AND CAST(" . $wpdb->postmeta . ".meta_value AS CHAR) = '" . $post_type . "' )
                    )
                    AND " . $wpdb->posts . ".post_type = 'st_layouts'
                    AND (" . $wpdb->posts . ".post_status = 'publish')
                    {$like_name}
                    GROUP BY " . $wpdb->posts . ".ID ORDER BY " . $wpdb->posts . ".post_date DESC ";
    }

}

if (!function_exists('st_inside_post_gallery')) {

    function st_inside_post_gallery($output, $attr) {
        global $post, $wp_locale;

        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if (isset($attr['orderby'])) {
            $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
            if (!$attr['orderby'])
                unset($attr['orderby']);
        }

        extract(shortcode_atts([
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'id' => $post->ID,
            'itemtag' => 'dl',
            'icontag' => 'dt',
            'captiontag' => 'dd',
            'columns' => 3,
            'size' => [1000, 9999],
            'include' => '',
            'exclude' => ''
                        ], $attr));

        $id = intval($id);
        if ('RAND' == $order)
            $orderby = 'none';

        if (!empty($include)) {
            $include = preg_replace('/[^0-9,]+/', '', $include);
            $_attachments = get_posts(['include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);

            $attachments = [];
            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif (!empty($exclude)) {
            $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
            $attachments = get_children(['post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);
        } else {
            $attachments = get_children(['post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);
        }

        if (empty($attachments))
            return '';

        if (is_feed()) {
            $output = "\n";
            foreach ($attachments as $att_id => $attachment)
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";

            return $output;
        }

        $itemtag = tag_escape($itemtag);
        $captiontag = tag_escape($captiontag);
        $columns = intval($columns);
        $itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $output = apply_filters('gallery_style', "

        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div data-width=\"100%\" class=\"fotorama gallery galleryid-{$id} \" data-allowfullscreen=\"true\">");

        $i = 0;
        foreach ($attachments as $id => $attachment) {
            $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

            $output .= $link;
        }

        $output .= "

        </div>\n";

        return $output;
    }

}
if (!function_exists('st_add_login_css')) {

    function st_add_login_css() {
        ?>
        <style type="text/css">
            .wp-social-login-widget {
                display: none;
            }
        </style>

        <?php
    }

}

if (!function_exists('st_check_is_checkout_woocomerce')) {

    function st_check_is_checkout_woocomerce($check=false) {
        if (st()->get_option('use_woocommerce_for_booking') == 'on' and class_exists('Woocommerce')) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }

}
if (!function_exists('st_check_is_booking_modal')) {

    function st_check_is_booking_modal() {
        //check is woocommerce
        $st_is_woocommerce_checkout = apply_filters('st_is_woocommerce_checkout', false);

        if (st()->get_option('booking_modal', 'off') == 'on' and ! $st_is_woocommerce_checkout) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 *
 *
 * @since 1.1.2
 * */
if (!function_exists('st_limit_partner_goto_dashboard')) {

    function st_limit_partner_goto_dashboard() {
        if (is_admin() && !current_user_can('administrator') &&
                !(defined('DOING_AJAX') && DOING_AJAX)
        ) {
            wp_redirect(home_url());
            exit;
        }
    }

}

/**
 *
 *
 * @since 1.1.3
 * */
if (!function_exists('st_check_service_available')) {

    function st_check_service_available($post_type = false) {
        if ($post_type) {
            if (function_exists('st_options_id')) {
                $disable_list = st_traveler_get_option('list_disabled_feature');
                $disable_list = is_array($disable_list) ? $disable_list : [];

                if (!empty($disable_list)) {
                    foreach ($disable_list as $key) {
                        if ($key == $post_type)
                            return false;
                    }
                }
            }


            return true;
        }

        return false;
    }

}


if (!function_exists('st_after_login_redirect')) {

    function st_after_login_redirect($redirect_to, $request, $user) {
        $page = st()->get_option('page_redirect_to_after_login');
        if ($page) {
            $redirect_to = get_permalink($page);
        }

        return $redirect_to;
    }

}

/**
 * Get locale, country, currency of skyscanner
 *
 * @author: Nasanji
 * @since : 1.4.2
 *
 * @params: $f_key
 */
if (!function_exists('st_get_ss_content_array')) {

    function st_get_ss_content_array($f_key) {
        $api_key = 'prtl6749387986743898559646983194';
        if (!empty($key = st()->get_option('ss_api_key', ''))) {
            $api_key = $key;
        }
        $list = [];
        switch ($f_key) {
            case 'locale':
                $locale_xml = wp_remote_get("http://partners.api.skyscanner.net/apiservices/reference/v1.0/locales?apiKey={$api_key}");
                $locale_json = wp_remote_retrieve_body($locale_xml);
                $locale_json = json_decode($locale_json);
                if (!empty($locale_json) and ! empty($locale_json->Locales) and is_array($locale_json->Locales)) {
                    foreach ($locale_json->Locales as $key => $val) {
                        $list[$key] = [
                            'value' => $val->Code,
                            'label' => $val->Name
                        ];
                    }
                }
                break;
            case 'currency':
                $currency_xml = wp_remote_get("http://partners.api.skyscanner.net/apiservices/reference/v1.0/currencies?apiKey={$api_key}");
                $currency_json = wp_remote_retrieve_body($currency_xml);
                $currency_json = json_decode($currency_json);
                if (!empty($currency_json) and ! empty($currency_json->Currencies) and is_array($currency_json->Currencies)) {
                    foreach ($currency_json->Currencies as $key => $val) {
                        $list[$key] = [
                            'value' => $val->Code,
                            'label' => $val->Code . ' (' . $val->Symbol . ')'
                        ];
                    }
                }
                break;
            case 'market':
                $locate = st()->get_option('ss_locale');
                if (empty($locate)) {
                    $locate = 'en-US';
                }
                $market_xml = wp_remote_get("http://partners.api.skyscanner.net/apiservices/reference/v1.0/countries/{$locate}?apiKey={$api_key}");
                $market_json = wp_remote_retrieve_body($market_xml);
                $market_json = json_decode($market_json);
                if (!empty($market_json) and ! empty($market_json->Countries) and is_array($market_json->Countries)) {
                    foreach ($market_json->Countries as $key => $val) {
                        $list[$key] = [
                            'value' => $val->Code,
                            'label' => $val->Name
                        ];
                    }
                }
                break;
        }

        return $list;
    }

}

if (!function_exists('st_add_meta_keywords')) {

    function st_add_meta_keywords() {
        if (st()->get_option('social_gg_login', 'off') == 'on') {
            $clientID = st()->get_option('social_gg_client_id', '');
            ?>
            <meta name="google-signin-client_id" content="<?php echo trim($clientID); ?>">
            <?php
        }
    }

}

if (!function_exists('st_edit_admin_bar')) {

    function st_edit_admin_bar(WP_Admin_Bar $wp_admin_bar) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $wp_admin_bar->add_menu( array(
            'id'    => 'ot-theme-options',
            'parent' => null,
            'group'  => null,
            'title' => __( 'Theme Options', 'traveler'), //you can use img tag with image link. it will show the image icon Instead of the title.
            'href'  => admin_url('admin.php?page=st_traveler_option'),
            'meta' => [
                'title' => __( 'Theme Options', 'traveler' ), //This title will show on hover
            ]
        ) );
    }

}

if (!function_exists('st_load_google_fonts_css')) {

    function st_load_google_fonts_css() {
        if (is_admin())
            return;

        $google_fonts = st()->get_option('google_fonts');

        $families = array();
        $subsets = array();
        $append = '';

        if (!empty($google_fonts)) {
            foreach ($google_fonts as $id => $font) {
                if (!empty($font['variants']) && is_array($font['variants'])) {
                    $variants = ':' . implode(',', $font['variants']);
                    if (!empty($font['subsets']) && is_array($font['subsets'])) {
                        foreach ($font['subsets'] as $subset) {
                            $subsets[] = $subset;
                        }
                    }
                }
                if (isset($variants)) {
                    $families[] = str_replace(' ', '+', $font['family']) . $variants;
                }
            }
        }

        if (!empty($families)) {
            $families = array_unique($families);
            if (!empty($subsets)) {
                $subsets = implode(',', array_unique($subsets));
                if ($subsets != 'latin') {
                    $append = '&subset=' . $subsets;
                }
            }
            wp_enqueue_style('st-google-fonts', esc_url('//fonts.googleapis.com/css?family=' . implode('', $families)) . $append, false, null);
        }
    }

}

if (!function_exists('st_convert_array_for_partner_field')) {

    function st_convert_array_for_partner_field($arr) {
        $arr_temp = [];
        if (!empty($arr)) {
            foreach ($arr as $k => $v) {
                $arr_temp[$v['value']] = $v['label'];
            }
        }
        return $arr_temp;
    }

}

if (!function_exists('st_get_list_hotels')) {

    function st_get_list_hotels($posttype = 'st_hotel') {
        $args = [
            'post_type' => $posttype,
            'posts_per_page' => -1,
        ];

        if (!current_user_can('manage_options')) {
            $args['author'] = get_current_user_id();
        }

        $custom_query = new WP_Query($args);
        $arr_temp = [];
        if($posttype = 'st_hotel'){
            $arr_temp = [
                '' => esc_html__('Select hotel' , 'traveler')
            ];
        }
        
        if ($custom_query->have_posts()) {
            while ($custom_query->have_posts()) {
                $custom_query->the_post();
                $arr_temp[get_the_ID()] = get_the_title();
            }
        }
        wp_reset_postdata();
        return $arr_temp;
    }

}

if (!function_exists('st_get_list_car_taxonomy')) {

    function st_get_list_car_taxonomy() {
        $data_value = [];

        $taxonomy = get_object_taxonomies('st_cars', 'object');
        foreach ($taxonomy as $key => $value) {
            if ($key != 'st_category_cars') {
                if ($key != 'st_cars_pickup_features') {
                    if ($key != 'cabin_type') {
                        if ($key != 'room_type') {
                            $args = [
                                'hide_empty' => 0
                            ];
                            $data_term = get_terms($key, $args);
                            if (!empty($data_term)) {
                                foreach ($data_term as $k => $v) {
                                    $data_value[$v->term_id] = $v->name;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data_value;
    }

}


if (!function_exists('st_get_list_taxonomy')) {

    function st_get_list_taxonomy($tax) {
        $terms = get_terms(array(
            'taxonomy' => $tax,
            'hide_empty' => false,
        ));
        $arr_temp = [];
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $k => $v) {
                $arr_temp[$v->term_id] = $v->name;
            }
        }
        return $arr_temp;
    }

}

if (!function_exists('st_get_list_flight_time')) {

    function st_get_list_flight_time($type) {
        $arr = array();
        switch ($type) {
            case 'hour':
                for ($i = 0; $i <= 48; $i++) {
                    $arr[$i] = $i;
                }
                break;
            case 'minute':
                for ($i = 0; $i <= 59; $i++) {
                    $arr[$i] = $i;
                }
                break;
        }

        return $arr;
    }

}
if (!function_exists('st_detected_device')) {

    function st_detected_device() {
        if (is_page_template('template-user.php')) {
            get_template_part('inc/is_mobile_or_table');
            $detected_device = new CheckMobileTable();
            return $detected_device;
        }
    }

}

if (!function_exists('st_convert_destination_car_transfer')) {

    function st_convert_destination_car_transfer() {
        $return = [];
        $return[] = [
            'label' => __('---- Select ----', 'traveler'),
            'value' => ''
        ];
        $list_location = [];
        $locations = TravelHelper::treeLocationHtml();
        if (!empty($locations)) {
            foreach ($locations as $k => $v) {
                $list_location[] = [
                    'id' => $v['ID'],
                    'name' => $v['post_title'],
                    'address' => '',
                    'type' => 'location',
                    'level' => $v['level'] / 20
                ];
            }
        }
        foreach ($list_location as $location) {
            $char = '';
            if ($location['level'] > 1) {
                for ($i = 0; $i < $location['level']; $i++) {
                    $char .= '-';
                }
            }
            $return[] = [
                'label' => $char . $location['name'],
                'value' => $location['id']
            ];
        }
        $transfers = TravelHelper::transferDestination();
        foreach ($transfers as $transfer) {
            $name = ($transfer['type'] == 'hotel') ? __('Hotel: ', 'traveler') : __('Airport: ', 'traveler');
            $return[] = [
                'label' => $name . $transfer['name'],
                'value' => $transfer['id']
            ];
        }

        $arr = array();
        //$transfers = TravelHelper::transferDestination();

        if (!empty($return)) {
            foreach ($return as $k => $v) {
                $arr[$v['value']] = ucfirst($v['label']);
            }
        }

        return $arr;
    }

}

/* Send email on single service */
/* Ajax send email on single service */
add_action('wp_ajax_st_send_email_single_service', 'st_send_email_single_service');
add_action('wp_ajax_nopriv_st_send_email_single_service', 'st_send_email_single_service');

function st_send_email_single_service() {
    $type_service = isset($_GET['type_service']) ? $_GET['type_service'] : '';
    $name_service = isset($_GET['name_service']) ? $_GET['name_service'] : '';
    $name_st = isset($_GET['name_st']) ? $_GET['name_st'] : '';
    $email_st = isset($_GET['email_st']) ? $_GET['email_st'] : '';
    $phone_st = isset($_GET['phone_st']) ? $_GET['phone_st'] : '';
    $content_st = isset($_GET['content_st']) ? $_GET['content_st'] : '';
    $email_owl = isset($_GET['email_owl']) ? $_GET['email_owl'] : '';
    $status = 0;
    $message = '';
    $subject_st = $name_st . ' - ' . $email_st;
    if (empty($name_st) || (empty($email_st)) || (empty($phone_st)) || (empty($content_st))) {
        $status = 0;
        if (empty($name_st)) {
            $message .= __('Please enter your name', 'traveler') . '<br>';
        }
        if (empty($email_st)) {
            $message .= __('Please enter your mail', 'traveler') . '<br>';
        }
        if (empty($phone_st)) {
            $message .= __('Please enter your phone', 'traveler') . '<br>';
        }
        if (empty($content_st)) {
            $message .= __('Please enter your content', 'traveler') . '<br>';
        }
        echo json_encode(
                array(
                    'status' => $status,
                    'message' => $message,
                )
        );
    } else {
        $status = 1;
        $admin_email = st()->get_option('email_admin_address');
        $body_email = "<html><body><h2>" . $subject_st . "</h2>";
        $body_email .= "<strong>" . __('Type Service', 'traveler') . "</strong>: " . $type_service . "<br/>" .
                "<strong>" . __('Name Service', 'traveler') . "</strong>: " . $name_service . "<br/>" .
                "<strong>" . __('Name customer', 'traveler') . "</strong>: " . $name_st . "<br/>" .
                "<strong>" . __('Email customer', 'traveler') . "</strong>: " . $email_st . "<br/>" .
                "<strong>" . __('Phone customer', 'traveler') . "</strong>: " . $phone_st . "<br/>" .
                "<strong>" . __('Note', 'traveler') . "</strong>: " . $content_st . "<br/></html></body>";


        $multiple_to_recipients = array($email_owl, $email_st, $admin_email);
        $subject = $subject_st;
        $body = $body_email;
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From:" . $name_st . "<" . $email_st . ">" . "\r\n";
        $headers .= "Cc: " . $admin_email;
        $attachment = false;
        add_filter('wp_mail_content_type', 'set_html_content_type_sent_email');
        $check = wp_mail($multiple_to_recipients, $subject, $body, $headers, $attachment);
        remove_filter('wp_mail_content_type', 'set_html_content_type_sent_email');
        echo json_encode(
                array(
                    'status' => $status,
                    'message' => __('Thank you for contacting us!<br>We will be in contact shortly.', 'traveler'),
                )
        );
    }
    die();
}

//Empty image
add_filter( 'wp_get_attachment_image_src', 'wp_get_attachment_image_srcc',99,4 );
add_filter('wp_get_attachment_url', 'wp_get_attachment_url_func',99,2);
add_filter('has_post_thumbnail', 'has_post_thumbnail_func',99,3);
add_filter('wp_get_attachment_image_attributes', 'wp_get_attachment_image_attributes_func',99,3);
add_filter('post_thumbnail_html', 'post_thumbnail_html_func',99,5);

 function post_thumbnail_html_func($html, $post, $thumb, $size, $attr){
    if (empty($html)) {
        $class = isset($attr['class']) ? $attr['class'] : "";
        $alt = isset($attr['alt']) ? $attr['alt'] : "";
        return '<img src="https://via.placeholder.com/300x200"  class="'.$class.'"  alt="'.$alt.'"/>';
    }
    return $html;
}
 function wp_get_attachment_image_attributes_func($attr, $attachment, $size){
    if(empty($attr['src'])){
        $attr['src'] = 'https://via.placeholder.com/300x200';
    }

    return $attr;
}
 function has_post_thumbnail_func($has, $post, $thumb){
    return true;
}

 function wp_get_attachment_url_func($url, $post_id){
    if(empty($post_id)){
        $url = 'https://via.placeholder.com/300x200';
    }

    return $url;
}
function wp_get_attachment_image_srcc( $image, $attachment_id, $size, $icon) {

    if (empty($image[0])){
        $image = [];
        $image[0] = 'https://via.placeholder.com/300x200';
        $image[1] = 900;
        $image[2] = 600;
 }

    return $image;
}

function set_html_content_type_sent_email() {
    return 'text/html';
}

function vv($arr){
    echo '<pre style="background:#000;color:#fff;padding:20px;">';
    print_r($arr);
    echo '</pre>';die;
}
if(class_exists('WPCF7_FormTag')){
    add_action( 'wpcf7_init', 'st_add_custom_contact' );
    function st_add_custom_contact(){
        wpcf7_add_form_tag('custom_title', 'wpcf7_custom_title_shortcode_handler', true);
        wpcf7_add_form_tag('st_mail_partner', 'wpcf7_st_mail_partner_shortcode_handler', true);
        wpcf7_add_form_tag('st_type_services', 'wpcf7_st_type_service_shortcode_handler', true);
    }
}
function wpcf7_custom_title_shortcode_handler($tag) {
    if (!is_object($tag)) return '';
    $name = $tag['name'];
    if (empty($name)) return '';
    $the_title = get_the_title();
    $html = '<input type="hidden" name="' . $name . '" value="' . $the_title . '" />';
    return $html;
}

function wpcf7_st_mail_partner_shortcode_handler($tag) {
    if (!is_object($tag)) return '';
    $name = $tag['name'];
    if (empty($name)) return '';

    $author_id = get_post_field( 'post_author', get_the_ID() );
    $email_owl = get_the_author_meta('user_email',$author_id);
    $html = '<input type="hidden" name="' . $name . '" value="' . $email_owl . '" />';
    return $html;
}

function wpcf7_st_type_service_shortcode_handler($tag){
    if (!is_object($tag)) return '';
    $name = $tag['name'];
    if (empty($name)) return '';
    $get_post_type = get_post_type(get_the_ID());

    switch ($get_post_type) {
        case 'st_hotel':
                $type_service = __('Hotel','traveler');
            break;
        case 'hotel_room':
                $type_service = __('Hotel Room','traveler');
            break;
        case 'st_rental':
                $type_service = __('Rental','traveler');
            break;
        case 'rental_room':
                $type_service = __('Rental Room','traveler');
            break;
        case 'st_activity':
                $type_service = __('Activity','traveler');
            break;
        case 'st_tours':
                $type_service = __('Tours','traveler');
            break;
        case 'st_cars':
                $type_service = __('Cars','traveler');
            break;
        default:
            break;
    }
    $html = '<input type="hidden" name="' . $name . '" value="' . $type_service . '" />';
    return $html;
}

function st_get_meta_orderby_id($order_id){
    global $wpdb;
    $querystr  = "SELECT * FROM
                            " . $wpdb->prefix . "st_order_item_meta
                                                WHERE 1=1
                                                AND wc_order_id = " . $order_id;
    $pageposts = $wpdb->get_row( $querystr, ARRAY_A );
    return $pageposts;
}

function st_get_order_by_order_item_id($order_item_id){
    global $wpdb;
    $querystr  = "SELECT * FROM  " . $wpdb->prefix . "st_order_item_meta WHERE 1=1 AND order_item_id = " . $order_item_id;
    $pageposts = $wpdb->get_row( $querystr, ARRAY_A );
    return $pageposts;
}
if (!function_exists('st_get_all_ids_posttype')) {

    function st_get_all_ids_posttype($post_type = 'post') {
        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $postsID = array();
        $posts_query = new WP_Query($args);
        // Starting the loop
        while ($posts_query->have_posts()) {
            $posts_query->the_post();
            // Including the post IDs one by one
            $postsID[] = get_the_ID();
        }
        wp_reset_postdata();
        return $postsID;
    }

}
//function update option tree by id key
if (!function_exists('st_update_optiontree_by_id_key')) {
    function st_update_optiontree_by_id_key($key, $value){
        $option_value = get_option(st_options_id());
        $option_value[$key] = $value;
        update_option(st_options_id(), $option_value,false);
    }
}

//get checkin checkout a group day by date checkin
if (!function_exists('st_get_date_checkin_checkout_groupday_tour')) {
    function st_get_date_checkin_checkout_groupday_tour($post_id,$timestamp_checkin){
        global $wpdb;
        $post_type = get_post_type($post_id);
        $table="";
        
        $results = array();
        if($post_type == 'st_activity'){
            $table = $wpdb->prefix . 'st_activity_availability';
        }elseif($post_type == 'st_tours'){
            $table = $wpdb->prefix . 'st_tour_availability';
        }
        if(!empty($table)){
            $sql = "
                SELECT check_in , check_out
                FROM
                    {$table}
                WHERE
                    post_id = {$post_id}
                AND
                    status = 'available'
                AND
                    check_in = {$timestamp_checkin}
                LIMIT 1";
                $results = $wpdb->get_results($sql, ARRAY_A);
                if(!empty($results) && ($results[0]['check_out'] > $results[0]['check_in'])){
                    return $results;
                } else {
                    return false;
                }
        } else {
            return false;
        }
    }
}

if(!function_exists('check_using_elementor')){
    function check_using_elementor(){
        $theme_style = st()->get_option('option_style', 'modern');
        $style_page_builder = st()->get_option('option_style_page_builder', 'wp_page_builder');
        if(class_exists('Elementor\Plugin') && $theme_style === 'modern' &&  $style_page_builder === 'elementor'){
            return true;
        } else {
            return false;
        }
        
    }
}
if (!function_exists('st_is_elementor_preview_mode')) {
    /**
     * Whether the preview mode is active.
     *
     * @since 1.0.0
     */
    function st_is_elementor_preview_mode()
    {
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }

        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
            return 'preview';
        } else{
            return false;
        }
    }
}
if(!function_exists('st_render_html_attributes')){
    function st_render_html_attributes(array $attributes)
    {
        $rendered_attributes = [];
        if(!empty($attributes)){
            foreach ($attributes as $attribute_key => $attribute_values) {
                if (is_array($attribute_values)) {
                    if ($attribute_key == 'style') {
                        $attribute_values = implode('; ', $attribute_values);
                    } else {
                        $attribute_values = implode(' ', $attribute_values);
                    }
                }
    
                $rendered_attributes[] = sprintf('%1$s="%2$s"', $attribute_key, esc_attr($attribute_values));
            }
    
        }   
        
        return (!empty($rendered_attributes)) ? implode(' ', $rendered_attributes) : '';
    }
}

//function get content page elementor
if(!function_exists('st_get_elementor_content_page')){
    function st_get_elementor_content_page($page_id)
    {
        if (class_exists('Elementor\Plugin')) {
            $page = get_post($page_id);
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content($page_id);
            if (!empty($content)) {
                return $content;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}

//Lazy load img 
function skip_lazyloading_on_first_three_archive_images( $omit_threshold ) {
    if ( is_home() || is_archive() ) {
        return 3;
    }
    return $omit_threshold;
}
add_filter( 'wp_omit_loading_attr_threshold', 'skip_lazyloading_on_first_three_archive_images' );
function st_rocket_deactivate_on_front_page() {
	if ( is_single() ) {
		add_filter( 'do_rocket_lazyload', '__return_false' );
	}
}
add_filter( 'wp', 'st_rocket_deactivate_on_front_page' );

//End lazy load img
function st_convert_characers_to_slug($str, $options = array()){
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
    );
    
    // Merge options
    $options = array_merge($defaults, $options);
    
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
        'ß' => 'ss', 
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
        'ÿ' => 'y',

        // Latin symbols
        '©' => '(c)',

        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',

        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
        'Ž' => 'Z', 
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z', 

        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
        'Ż' => 'Z', 
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',

        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    
    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    
    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    
    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    
    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    
    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    
    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);
    
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;

}

if(!function_exists('st_notice_enqueue_css_js')){
    function st_notice_enqueue_css_js(){
        $pointer_name = 'install-plugin-library';
		$dismissed = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
        $content = $content_demo  =  $pointer_name_demo =  $pointer_name_demo = '';
		if ( false === array_search( $pointer_name, $dismissed, true ) ) {
			$content  = '';
			$content .= '<h3>' . __( 'Important!', 'traveler' ) . '</h3>';
			$content .= '<p>' . __( 'You should install <a target="__blank" href="admin.php?page=st-vina-extensions">Traveler Library Layout Elementor Plugin</a> for more demo build by elementor .', 'traveler' ) . '</p>';
			
		}

        //Notice new demo
        $pointer_name_demo = 'install-new-demo-3-0-8';
        
		if ( false === array_search( $pointer_name_demo, $dismissed, true ) ) {
			$content_demo  = '';
			$content_demo .= '<h3>' . __( 'New Update!', 'traveler' ) . '</h3>';
			$content_demo .= '<p>' . __( 'Having 6 in one layout Resort Spa Hotel demo : <strong>Seaside Resort Hotel, Heaven Resort Hotel, Escape Resort Hotel, Seaside Resort Hotel, Retreat Resort Hotel, Golf Resort Hotel </strong>  <a target="__blank" href="https://travelerwp.com/new-version-3-0-8-new-updated-demos-for-hotels-and-resorts-business/#utm_source=admin&utm_medium=cpc&utm_campaign=new_demo&utm_id=notice-popup-dashboard">Check Now</a> build by elementor .', 'traveler' ) . '</p>';
            if(!in_array('traveler-layout-essential-for-elementor/traveler-layout-essential-for-elementor.php', apply_filters('active_plugins', get_option('active_plugins')))){
                $content_demo .= '<p>' . __( 'You need install <a target="__blank" href="admin.php?page=st-vina-extensions">Traveler Library Layout Elementor Plugin</a> for checking these demo.', 'traveler' ) . '</p>';
            }
		}
        if(!empty($content) || !empty($pointer_name)|| !empty($content_demo) || !empty($pointer_name_demo) ){
            wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'st-traveler-pointer', get_template_directory_uri() . '/js/admin/settings-pointer.js', array( 'wp-pointer' ), false );

			wp_localize_script(
				'st-traveler-pointer',
				'Traveler_Settings_Pointer',
				array(
					'content' => $content,
					'name'    => $pointer_name,
                    'content2' => $content_demo,
					'name2'    => $pointer_name_demo,
				)
			);
        }

        //End Notice new demo
    }
}

//Run file css/js
function st_check_single_style_mod(){
    if(check_using_elementor()){
        if(is_singular('st_hotel')){
            $style = get_post_meta( get_the_ID(), 'hotel_layout_style', true );
            if(in_array($style,['4','5'])){
                return true;
            }
        }
        if(is_singular('hotel_room')){
            $style = get_post_meta( get_the_ID(), 'st_custom_layout', true );
            if(in_array($style,['3','4'])){
                return true;
            }
        }
        if(is_singular('st_tours')){
            $style = get_post_meta( get_the_ID(), 'st_custom_layout_new', true );
            if(in_array($style,['8','9'])){
                return true;
            }
        }
        if(is_singular('st_rental')){
            $style = get_post_meta( get_the_ID(), 'rental_single_layout_v2', true );
            if(in_array($style,['3','4'])){
                return true;
            }
        }
        if(is_singular('st_activity')){
            $style = get_post_meta( get_the_ID(), 'st_custom_layout_new', true );
            if(in_array($style,['4','5'])){
                return true;
            }
        }
    }
    return false;
}
<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Class STAdminHotel
 *
 * Created by ShineTheme
 *
 */
$order_id = 0;
if (!class_exists('STAdminHotel')) {

    class STAdminHotel extends STAdmin
    {
        static $parent_key = 'room_parent';
        static $booking_page;
        static $_table_version = "1.3.6";
        protected $post_type = 'st_hotel';

        /**
         *
         *
         * @update 1.1.3
         * */
        function __construct()
        {

            add_action('init', [$this, 'init_post_type'], 8);

            if (!st_check_service_available($this->post_type)) return;

            add_action('current_screen', [$this, 'init_metabox']);

            self::$booking_page = admin_url('edit.php?post_type=st_hotel&page=st_hotel_booking');

            //add colum for rooms
            add_filter('manage_hotel_room_posts_columns', [$this, 'add_col_header'], 10);
            add_action('manage_hotel_room_posts_custom_column', [$this, 'add_col_content'], 10, 2);

            //add colum for rooms
            add_filter('manage_st_hotel_posts_columns', [$this, 'add_hotel_col_header'], 10);
            add_action('manage_st_hotel_posts_custom_column', [$this, 'add_hotel_col_content'], 10, 2);

            add_action('admin_menu', [$this, 'add_menu_page']);

            //Check booking edit and redirect
            if (self::is_booking_page()) {

                add_action('admin_enqueue_scripts', [__CLASS__, 'add_edit_scripts']);

                add_action('admin_init', [$this, '_do_save_booking']);
            }


            if (isset($_GET['send_mail']) and $_GET['send_mail'] == 'success') {
                self::set_message(__('Email sent', 'traveler'), 'updated');
            }

            add_action('wp_ajax_st_room_select_ajax_admin', [__CLASS__, 'st_room_select_ajax']);

            //parent::__construct();

            add_action('save_post', [$this, '_update_avg_price'], 50);
            add_action('save_post', [$this, '_update_min_price'], 50);
            add_action('save_post', [$this, '_update_list_location'], 10, 2);
            add_action('save_post', [$this, '_update_duplicate_data'], 51, 2);
            add_action('before_delete_post', [$this, '_delete_data'], 50);

            add_action('wp_ajax_st_getRoomHotelInfo', [__CLASS__, 'getRoomHotelInfo'], 9999);
            add_action('wp_ajax_st_getRoomHotel', [__CLASS__, 'getRoomHotel'], 9999);

            /**
             *   since 1.2.4
             *   auto create & update table st_hotel
             **/
            add_action('after_setup_theme', [__CLASS__, '_check_table_hotel']);

            add_action('admin_init', [$this, '_upgradeHotelTable136']);
        }

        public function _upgradeHotelTable136()
        {
            $updated = get_option('_upgradeHotelTable136', false);
            if (!$updated) {
                global $wpdb;
                $table = $wpdb->prefix . $this->post_type;
                $sql = "Update {$table} as t inner join {$wpdb->postmeta} as m on (t.post_id = m.post_id and m.meta_key = 'is_featured') set t.is_featured = m.meta_value";
                $wpdb->query($sql);
                update_option('_upgradeHotelTable136', 'updated');
            }
        }

        static function check_ver_working()
        {
            $dbhelper = new DatabaseHelper(self::$_table_version);

            return $dbhelper->check_ver_working('st_hotel_table_version');
        }

        static function _check_table_hotel()
        {
            $dbhelper = new DatabaseHelper(self::$_table_version);
            $dbhelper->setTableName('st_hotel');
            $column = [
                'post_id' => [
                    'type' => 'INT',
                    'length' => 11,
                ],
                'multi_location' => [
                    'type' => 'text',
                ],
                'id_location' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'address' => [
                    'type' => 'text',
                ],
                'allow_full_day' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'rate_review' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'hotel_star' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'price_avg' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'min_price' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'hotel_booking_period' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'map_lat' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'map_lng' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'is_sale_schedule' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'post_origin' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'is_featured' => [
                    'type' => 'varchar',
                    'length' => 5
                ],
            ];

            $column = apply_filters('st_change_column_st_hotel', $column);

            $dbhelper->setDefaultColums($column);
            $dbhelper->check_meta_table_is_working('st_hotel_table_version');

            return array_keys($column);
        }

        function _do_save_booking()
        {
            $section = isset($_GET['section']) ? $_GET['section'] : false;
            switch ($section) {
                case "edit_order_item":
                    $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : false;
                    if (!$item_id or get_post_type($item_id) != 'st_order') {
                        return false;
                    }
                    if (isset($_POST['submit']) and $_POST['submit']) $this->_save_booking($item_id);
                    break;
                case 'resend_email':
                    $this->_resend_mail();
                    break;
            }
        }

        /**
         * @since 1.1.8
         **/

        static function _update_duplicate_data($id, $data)
        {
            if (!TravelHelper::checkTableDuplicate('st_hotel')) return;
            if (get_post_type($id) == 'st_hotel') {
                $num_rows = TravelHelper::checkIssetPost($id, 'st_hotel');
                $location_str = get_post_meta($id, 'multi_location', true);
                $location_id = ''; // location_id
                $address = get_post_meta($id, 'address', true); // address
                $allow_full_day = get_post_meta($id, 'allow_full_day', true); // address

                $rate_review = STReview::get_avg_rate($id); // rate review
                $hotel_star = get_post_meta($id, 'hotel_star', true); // hotel star
                $price_avg = get_post_meta($id, 'price_avg', true); // price avg
                $min_price = get_post_meta($id, 'min_price', true); // price avg
                $hotel_booking_period = get_post_meta($id, 'hotel_booking_period', true); // price avg
                $map_lat = get_post_meta($id, 'map_lat', true); // map_lat
                $map_lng = get_post_meta($id, 'map_lng', true); // map_lng
                $is_featured = get_post_meta($id, 'is_featured', true);
                if ($num_rows == 1) {
                    $data = [
                        'multi_location' => $location_str,
                        'id_location' => $location_id,
                        'address' => $address,
                        'allow_full_day' => $allow_full_day,
                        'rate_review' => $rate_review,
                        'hotel_star' => $hotel_star,
                        'price_avg' => $price_avg,
                        'min_price' => $min_price,
                        'hotel_booking_period' => $hotel_booking_period,
                        'map_lat' => $map_lat,
                        'map_lng' => $map_lng,
                        'is_featured' => $is_featured,
                    ];
                    $where = [
                        'post_id' => $id
                    ];
                    TravelHelper::updateDuplicate('st_hotel', $data, $where);
                } elseif ($num_rows == 0) {
                    $data = [
                        'post_id' => $id,
                        'multi_location' => $location_str,
                        'id_location' => $location_id,
                        'address' => $address,
                        'allow_full_day' => $allow_full_day,
                        'rate_review' => $rate_review,
                        'hotel_star' => $hotel_star,
                        'price_avg' => $price_avg,
                        'min_price' => $min_price,
                        'hotel_booking_period' => $hotel_booking_period,
                        'map_lat' => $map_lat,
                        'map_lng' => $map_lng,
                        'is_featured' => $is_featured,
                    ];
                    TravelHelper::insertDuplicate('st_hotel', $data);
                }
            }
        }

        public function _delete_data($post_id)
        {
            if (get_post_type($post_id) == 'st_hotel') {
                global $wpdb;
                $table = $wpdb->prefix . 'st_hotel';
                $rs = TravelHelper::deleteDuplicateData($post_id, $table);
                if (!$rs)
                    return false;

                return true;
            }
        }

        static function _get_list_room_by_hotel($post_id)
        {
            global $wpdb;
            $sql = "SELECT * ,mt1.meta_value as multi_location
                    FROM {$wpdb->postmeta}
                    JOIN {$wpdb->postmeta} as mt1 ON mt1.post_id = {$wpdb->postmeta}.post_id and mt1.meta_key = 'multi_location'
                    WHERE
                    {$wpdb->postmeta}.meta_key = 'room_parent'

                    AND

                    {$wpdb->postmeta}.meta_value = '{$post_id}'

                    GROUP BY {$wpdb->postmeta}.post_id";

            $list_room = $wpdb->get_results($sql);

            return $list_room;
        }

        /**
         * @since 1.1.5
         **/
        function _update_list_location($id, $data)
        {
            $location = STInput::request('multi_location', '');
            if (isset($_REQUEST['multi_location'])) {
                if (is_array($location) && count($location)) {
                    $location_str = '';
                    foreach ($location as $item) {
                        if (empty($location_str)) {
                            $location_str .= $item;
                        } else {
                            $location_str .= ',' . $item;
                        }
                    }
                } else {
                    $location_str = '';
                }
                update_post_meta($id, 'multi_location', $location_str);
                update_post_meta($id, 'id_location', '');
            }

        }

        /**
         * Init the post type
         *
         * */
        function init_post_type()
        {
            if (!st_check_service_available($this->post_type)) {
                return;
            }

            if (!function_exists('st_reg_post_type')) return;

            $labels = [
                'name' => __('Hotels', 'traveler'),
                'singular_name' => __('Hotel', 'traveler'),
                'menu_name' => __('Hotels', 'traveler'),
                'name_admin_bar' => __('Hotel', 'traveler'),
                'add_new' => __('Add New', 'traveler'),
                'add_new_item' => __('Add New Hotel', 'traveler'),
                'new_item' => __('New Hotel', 'traveler'),
                'edit_item' => __('Edit Hotel', 'traveler'),
                'view_item' => __('View Hotel', 'traveler'),
                'all_items' => __('All Hotels', 'traveler'),
                'search_items' => __('Search Hotels', 'traveler'),
                'parent_item_colon' => __('Parent Hotels:', 'traveler'),
                'not_found' => __('No hotels found.', 'traveler'),
                'not_found_in_trash' => __('No hotels found in Trash.', 'traveler'),
                'insert_into_item' => __('Insert into Hotel', 'traveler'),
                'uploaded_to_this_item' => __("Uploaded to this Hotel", 'traveler'),
                'featured_image' => __("Feature Image", 'traveler'),
                'set_featured_image' => __("Set featured image", 'traveler')
            ];

            $args = [
                'labels' => $labels,
                'menu_icon' => 'dashicons-building-yl',
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => ['slug' => get_option('hotel_permalink', 'st_hotel')],
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments']
            ];

            st_reg_post_type('st_hotel', $args);

            $labels = [
                'name' => __('Room(s)', 'traveler'),
                'singular_name' => __('Room', 'traveler'),
                'menu_name' => __('Room(s)', 'traveler'),
                'name_admin_bar' => __('Room', 'traveler'),
                'add_new' => __('Add New', 'traveler'),
                'add_new_item' => __('Add New Room', 'traveler'),
                'new_item' => __('New Room', 'traveler'),
                'edit_item' => __('Edit Room', 'traveler'),
                'view_item' => __('View Room', 'traveler'),
                'all_items' => __('All Rooms', 'traveler'),
                'search_items' => __('Search Rooms', 'traveler'),
                'parent_item_colon' => __('Parent Rooms:', 'traveler'),
                'not_found' => __('No rooms found.', 'traveler'),
                'not_found_in_trash' => __('No rooms found in Trash.', 'traveler'),
                'insert_into_item' => __('Insert into Room', 'traveler'),
                'uploaded_to_this_item' => __("Uploaded to this Room", 'traveler'),
                'featured_image' => __("Feature Image", 'traveler'),
                'set_featured_image' => __("Set featured image", 'traveler')
            ];

            $args = [
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => ['slug' => get_option('hotel_room_permalink', 'hotel_room')],
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
                'menu_icon' => 'dashicons-building-yl',
                'exclude_from_search' => true
            ];

            st_reg_post_type('hotel_room', $args);

            $name = __('Room Type', 'traveler');
            $labels = [
                'name' => $name,
                'singular_name' => $name,
                'search_items' => sprintf(__('Search %s', 'traveler'), $name),
                'all_items' => sprintf(__('All %s', 'traveler'), $name),
                'parent_item' => sprintf(__('Parent %s', 'traveler'), $name),
                'parent_item_colon' => sprintf(__('Parent %s', 'traveler'), $name),
                'edit_item' => sprintf(__('Edit %s', 'traveler'), $name),
                'update_item' => sprintf(__('Update %s', 'traveler'), $name),
                'add_new_item' => sprintf(__('New %s', 'traveler'), $name),
                'new_item_name' => sprintf(__('New %s', 'traveler'), $name),
                'menu_name' => $name,
            ];

            $args = [
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => 'edit.php?post_type=st_hotel',
                'query_var' => true,
                'public' => apply_filters('stt_show_term_frontend',false),
            ];

            st_reg_taxonomy('room_type', 'hotel_room', $args);
        }

        /**
         *
         * @since 1.1.1
         * */
        function init_metabox()
        {
            $screen = get_current_screen();
            if ($screen->id != 'st_hotel') {
                return false;
            }
            $layout_single = [
                [
                    'value' => '1',
                    'label' => esc_html__('Layout 1', 'traveler'),
                    'src' => get_template_directory_uri() . '/v2/images/layouts/hotel_detail_1_preview.jpg',
                ],
                [
                    'value' => '2',
                    'label' => esc_html__('Layout 2', 'traveler'),
                    'src' => get_template_directory_uri() . '/v2/images/layouts/hotel_detail_2_preview.jpg',
                ],
                [
                    'value' => '3',
                    'label' => esc_html__('Layout 3', 'traveler'),
                    'src' => get_template_directory_uri() . '/v2/images/layouts/hotel_detail_3_preview.jpg',
                ],
               
            ];

            if(check_using_elementor()){
                $array_elementor = [
                   
                    [
                        'value' => '4',
                        'label' => esc_html__('Layout 4', 'traveler'),
                        'src' => get_template_directory_uri() . '/v2/images/layouts/hotel_detail_4_preview.jpg',
                    ],
                    [
                        'value' => '5',
                        'label' => esc_html__('Layout 5', 'traveler'),
                        'src' => get_template_directory_uri() . '/v2/images/layouts/hotel_detail_5_preview.png',
                    ],
                ];
                $layout_single = array_merge($layout_single,$array_elementor);
            }


            $layout_single = apply_filters('st_layout_single_hotel',$layout_single);
            $this->metabox[] = [
                'id' => 'hotel_metabox',
                'title' => __('Hotel information', 'traveler'),
                'desc' => '',
                'pages' => ['st_hotel'],
                'context' => 'normal',
                'priority' => 'high',
                'fields' => [
                    [
                        'label' => __('Location', 'traveler'),
                        'id' => 'location_tab',
                        'type' => 'tab'
                    ],

                    [
                        'label' => __('Hotel location', 'traveler'),
                        'id' => 'multi_location', // id_location
                        'type' => 'list_item_post_type',
                        'desc' => __('Select one or more locations for your hotel (Enter the name you need to search in search box to filter address faster)', 'traveler'),
                        'post_type' => 'location'
                    ],
                    [
                        'label' => __('Hotel address', 'traveler'),
                        'id' => 'address',
                        'type' => 'address_autocomplete',
                        'desc' => __('Enter your hotel address detail', 'traveler'),
                    ],
                    [
                        'label' => __('Location on map', 'traveler'),
                        'id' => 'st_google_map',
                        'type' => 'bt_gmap',
                        'std' => 'off',
                        'desc'  => __( 'Kindly input Map API in Theme Settings > Other Options . Select one location on map to see latiture and longiture', 'traveler' )
                    ],
                    [
                        'label' => __('Properties near by', 'traveler'),
                        'id' => 'properties_near_by',
                        'type' => 'list-item',
                        'desc' => __('Properties near by this hotel', 'traveler'),
                        'settings' => [
                            [
                                'id' => 'featured_image',
                                'label' => __('Featured Image', 'traveler'),
                                'type' => 'upload',
                            ],
                            [
                                'id' => 'description',
                                'label' => __('Description', 'traveler'),
                                'type' => 'textarea',
                                'row' => 5
                            ],
                            [
                                'id' => 'icon',
                                'label' => __('Map icon', 'traveler'),
                                'type' => 'upload'
                            ],
                            [
                                'id' => 'map_lat',
                                'label' => __('Map lat', 'traveler'),
                                'type' => 'text'
                            ],
                            [
                                'id' => 'map_lng',
                                'label' => __('Map long', 'traveler'),
                                'type' => 'text'
                            ]
                        ]
                    ],
                    // [
                    //     'label' => __('Streetview mode', 'traveler'),
                    //     'id' => 'enable_street_views_google_map',
                    //     'type' => 'on-off',
                    //     'desc' => __('Turn on/off streetview mode for this location', 'traveler'),
                    //     'std' => 'on'
                    // ],
                    [
                        'label' => __('Hotel detail', 'traveler'),
                        'id' => 'detail_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Set hotel as feature', 'traveler'),
                        'id' => 'is_featured',
                        'type' => 'on-off',
                        'desc' => __('ON: Set this hotel to be featured', 'traveler'),
                        'std' => 'off'
                    ],
                    [
                        'label' => __('Hotel logo', 'traveler'),
                        'id' => 'logo',
                        'type' => 'upload',
                        'class' => '',
                        'desc' => __('Upload the hotel logo (it is recommended using size: 256 x 195 px)', 'traveler'),
                    ],
                    // [
                    //     'label' => __('Hotel accepted cards', 'traveler'),
                    //     'desc' => __('Accepted cards for payment of hotel', 'traveler'),
                    //     'id' => 'card_accepted',
                    //     'type' => 'checkbox',
                    //     'choices' => $this->get_card_accepted_list()
                    // ],
                    [
                        'label' => __('Hotel single layout', 'traveler'),
                        'id' => 'hotel_layout_style',
                        'post_type' => 'st_layouts',
                        'desc' => __('Select one default layout to show single hotel', 'traveler'),
                        'type' => 'radio-image',
                        'section' => 'layout_tab',
                        'class' => 'custom-radio-image',
                        'choices' => $layout_single
                    ],
                    [
                        'label' => __('Hotel gallery', 'traveler'),
                        'id' => 'gallery',
                        'type' => 'gallery',
                        'desc' => __('Upload one or many images to make a hotel image gallery for customers', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel video', 'traveler'),
                        'id' => 'video',
                        'type' => 'text',
                        'desc' => __('Enter YouTube/Vimeo URL here', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel rating standard', 'traveler'),
                        'desc' => __('Hotel rating standard', 'traveler'),
                        'id' => 'hotel_star',
                        'type' => 'numeric-slider',
                        'min_max_step' => '0,5,1',
                        'std' => 0
                    ],
                    [
                        'label' => __('Contact information', 'traveler'),
                        'id' => 'agent_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Contact Info', 'traveler'),
                        'id' => 'show_agent_contact_info',
                        'type' => 'select',
                        'choices' => [

                            [
                                'label' => __("----Select----", 'traveler'),
                                'value' => ''
                            ],
                            [
                                'label' => __("Use Agent Contact Info", 'traveler'),
                                'value' => 'user_agent_info'
                            ],
                            [
                                'label' => __("Use Item Info", 'traveler'),
                                'value' => 'user_item_info'
                            ],
                        ],
                        'desc' => __(' Use contact info of people who upload hotel || Use contact info in hotel details', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel email', 'traveler'),
                        'id' => 'email',
                        'type' => 'text',
                        'desc' => __('This email will received notification when have booking order', 'traveler'),
                    ],

                    [
                        'label' => __('Hotel website', 'traveler'),
                        'id' => 'website',
                        'type' => 'text',
                        'desc' => __('Enter hotel website', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel phone number', 'traveler'),
                        'id' => 'phone',
                        'type' => 'text',
                        'desc' => __('Enter hotel phone number', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel fax', 'traveler'),
                        'id' => 'fax',
                        'type' => 'text',
                        'desc' => __('Enter hotel fax number', 'traveler'),
                    ],
                    [
                        'label' => __('Price', 'traveler'),
                        'id' => 'sale_number_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Set auto calculation average price', 'traveler'),
                        'id' => 'is_auto_caculate',
                        'type' => 'on-off',
                        'desc' => __('The average price of hotel<br/>ON: Automatically<br/>OFF: Input manually', 'traveler'),
                        'std' => 'on'
                    ],
                    [
                        'label' => __('Average price', 'traveler'),
                        'id' => 'price_avg',
                        'type' => 'text',
                        'desc' => __('Enter default average price', 'traveler'),
                        'std' => 0,
                        'conditions' => 'is_auto_caculate:is(on)'
                    ],

                    [
                        'label' => __('Check in/out time', 'traveler'),
                        'id' => 'check_in_out_time',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Allowed full day booking ', 'traveler'),
                        'id' => 'allow_full_day',
                        'type' => 'on-off',
                        'std' => 'on',
                        'desc' => __('You can book room with full day<br/>Eg: booking from 22 -23, then all days 22 and 23 are full, other people cannot book', 'traveler')
                    ],
                    [
                        'label' => __('Time for check in', 'traveler'),
                        'id' => 'check_in_time',
                        'type' => 'text',
                        'std' => '12:00 pm',
                        'desc' => __('Enter time for check in at hotel', 'traveler')
                    ],
                    [
                        'label' => __('Time for check out', 'traveler'),
                        'id' => 'check_out_time',
                        'type' => 'text',
                        'std' => '12:00 pm',
                        'desc' => __('Enter time for checkout at hotel', 'traveler')
                    ],
                    [
                        'label' => __('Other options', 'traveler'),
                        'id' => 'hotel_options',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Book before number of day', 'traveler'),
                        'id' => 'hotel_booking_period',
                        'type' => 'numeric-slider',
                        'min_max_step' => '0,30,1',
                        'std' => 0,
                        'desc' => __('Input number of day can book before from check in date', 'traveler'),
                    ],
                    [
                        'label' => __('Minimum number of days to book', 'traveler'),
                        'id' => 'min_book_room',
                        'type' => 'numeric-slider',
                        'min_max_step' => '0,30,1',
                        'std' => 0,
                        'desc' => __('Booking time period.', 'traveler'),
                    ],
                    [
                        'label' => __('Hotel policy', 'traveler'),
                        'id' => 'hotel_policy_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Hotel policy', 'traveler'),
                        'id' => 'hotel_policy',
                        'desc' => __('Enter hotel policy', 'traveler'),
                        'type' => 'list-item',
                        'settings' => [
                            [
                                'label' => __('Policy Description', 'traveler'),
                                'id' => 'policy_description',
                                'type' => 'textarea'
                            ]
                        ],

                    ],
                    [
                        'label' => __('Inventory', 'traveler'),
                        'id' => 'inventory_tab',
                        'type' => 'tab',
                    ],
                    [
                        'label' => __('Inventory', 'traveler'),
                        'id' => 'inventory',
                        'type' => 'inventory'
                    ]
                ]
            ];

            $custom_field = st()->get_option('hotel_unlimited_custom_field');
            if (!empty($custom_field) and is_array($custom_field)) {
                $this->metabox[0]['fields'][] = [
                    'label' => __('Custom fields', 'traveler'),
                    'id' => 'custom_field_tab',
                    'type' => 'tab'
                ];
                foreach ($custom_field as $k => $v) {
                    $key = str_ireplace('-', '_', 'st_custom_' . sanitize_title($v['title']));
                    $this->metabox[0]['fields'][] = [
                        'label' => $v['title'],
                        'id' => $key,
                        'type' => $v['type_field'],
                        'desc' => '<input value=\'[st_custom_meta key="' . $key . '"]\' type=text readonly />',
                        'std' => $v['default_field']
                    ];
                }
            }

            parent::register_metabox($this->metabox);
        }

        /**
         *
         *
         * @since 1.1.1
         * */
        function get_card_accepted_list()
        {
            $data = [];

            $options = st()->get_option('booking_card_accepted', []);

            if (!empty($options)) {
                foreach ($options as $key => $value) {
                    $data[] = [
                        'label' => $value['title'],
                        'src' => $value['image'],
                        'value' => sanitize_title_with_dashes($value['title'])
                    ];
                }
            }

            return $data;
        }

        /**
         *
         *
         * @update 1.2.4
         *
         */
        static function _update_avg_price($post_id = false)
        {
            if (!$post_id) {
                $post_id = get_the_ID();
            }
            $post_type = get_post_type($post_id);
            if ($post_type == 'st_hotel') {
                $hotel_id = $post_id;
                $is_auto_caculate = get_post_meta($hotel_id, 'is_auto_caculate', true);
                if ($is_auto_caculate != 'off') {
                    $query = [
                        'post_type' => 'hotel_room',
                        'posts_per_page' => -1,
                        'meta_key' => 'room_parent',
                        'meta_value' => $hotel_id,
                        'post_status' => array( 'publish' )
                    ];
                    $traver = new WP_Query($query);
                    $price = 0;
                    while ($traver->have_posts()) {
                        $traver->the_post();
                        if (get_post_meta(get_the_ID(), 'price_by_per_person', true) == 'on') {
                            $item_price = (float)get_post_meta(get_the_ID(), 'adult_price', true);
                        } else {
                            $item_price = (float)get_post_meta(get_the_ID(), 'price', true);
                        }

                        $price += $item_price;
                    }
                    wp_reset_query();
                    wp_reset_postdata();
                    $avg_price = 0;
                    if ($traver->post_count) {
                        $avg_price = $price / $traver->post_count;
                    }
                    update_post_meta($hotel_id, 'price_avg', $avg_price);
                }
            }
        }

        /**
         *
         *
         * @update 1.2.4
         *
         */
        static function _update_min_price($post_id = false)
        {
            if (!$post_id) {
                $post_id = get_the_ID();
            }

            $post_type = get_post_type($post_id);
            if ($post_type == 'st_hotel') {
                $hotel_id = $post_id;
                $query = [
                    'post_type' => 'hotel_room',
                    'posts_per_page' => -1,
                    'meta_key' => 'room_parent',
                    'meta_value' => $hotel_id,
                    'post_status' => array('publish')
                ];
                $traver = new WP_Query($query);

                $prices = [];
                while ($traver->have_posts()) {
                    $traver->the_post();
                    $disable_avai_check = st()->get_option('disable_availability_check', 'off');
                    if (get_post_meta(get_the_ID(), 'price_by_per_person', true) == 'on') {
                        $query_price = ST_Hotel_Room_Availability::inst()
                            ->select("min(CAST(adult_price as DECIMAL)) as min_price")
                            ->where('status', 'available')
                            ->where('post_id', get_the_ID())
                            ->where("check_in >= UNIX_TIMESTAMP(CURRENT_DATE)", null, true)
                            ->get()->result();
                            
                        if (!empty($query_price)) {
                            $item_price = floatval($query_price[0]['min_price']);
                        } else {
                            $item_price = floatval(get_post_meta(get_the_ID(), 'price', true));
                        }
                    } else {
                        $query_price = ST_Hotel_Room_Availability::inst()
                            ->select("min(CAST(price as DECIMAL)) as min_price")
                            ->where('status', 'available')
                            ->where('post_id', get_the_ID())
                            ->where("check_in >= UNIX_TIMESTAMP(CURRENT_DATE)", null, true)
                            ->get()->result();
                        if (!empty($query_price)) {
                            $item_price = $query_price[0]['min_price'];
                        } else {
                            
                            $item_price = get_post_meta(get_the_ID(), 'price', true);
                        }
                    }
                    // if ($disable_avai_check == 'off') {
                    //     $item_price = get_post_meta(get_the_ID(), 'price', true);
                       
                    // } else {
                    //     if (get_post_meta(get_the_ID(), 'price_by_per_person', true) == 'on') {
                    //         $query_price = ST_Hotel_Room_Availability::inst()
                    //             ->select("min(CAST(adult_price as DECIMAL)) as min_price")
                    //             ->where('status', 'available')
                    //             ->where('post_id', get_the_ID())
                    //             ->where("check_in >= UNIX_TIMESTAMP(CURRENT_DATE)", null, true)
                    //             ->get()->result();

                    //         if (!empty($query_price)) {
                    //             $item_price = floatval($query_price[0]['min_price']);
                    //         } else {
                    //             $item_price = floatval(get_post_meta(get_the_ID(), 'price', true));
                    //         }
                    //     } else {
                    //         $query_price = ST_Hotel_Room_Availability::inst()
                    //             ->select("min(CAST(price as DECIMAL)) as min_price")
                    //             ->where('status', 'available')
                    //             ->where('post_id', get_the_ID())
                    //             ->where("check_in >= UNIX_TIMESTAMP(CURRENT_DATE)", null, true)
                    //             ->get()->result();

                    //         if (!empty($query_price)) {
                    //             $item_price = $query_price[0]['min_price'];
                    //         } else {
                    //             $item_price = get_post_meta(get_the_ID(), 'price', true);
                    //         }
                    //     }
                    // }

                    $prices[] = $item_price;
                }
                // wp_reset_query();
                wp_reset_postdata();
                if (!empty($prices)) {
                    $min_price = min($prices);
                    update_post_meta($post_id, 'min_price', $min_price);
                } else {
                    update_post_meta($hotel_id, 'min_price', '0');
                }
            }
        }


        function _resend_mail()
        {
            $order_item = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : false;

            $test = isset($_GET['test']) ? $_GET['test'] : false;

            if ($order_item) {

                $order = $order_item;

                if ($test) {
                    global $order_id;
                    $order_id = $order_item;
                    $id_page_email_for_admin = st()->get_option('email_for_admin', '');
                    $content = !empty(get_post($id_page_email_for_admin)) ? wp_kses_post(get_post($id_page_email_for_admin)->post_content) : "";
                    $email          = "";
                    $email .= TravelHelper::_get_template_email($email, $content);
                    echo($email);
                    die;

                }


                if ($order) {
                    $booking_by = get_post_meta($order_item, 'booking_by', true);
                    $made_by_admin = false;
                    if ($booking_by && $booking_by == 'admin') {
                        $made_by_admin = true;
                    }
                    STCart::send_mail_after_booking($order, $made_by_admin);
                }
            }

            wp_safe_redirect(self::$booking_page . '&send_mail=success');
        }

        static function st_room_select_ajax()
        {
            extract(wp_parse_args($_GET, [
                'room_parent' => '',
                'post_type' => '',
                'q' => ''
            ]));

            $query = [
                'post_type' => $post_type,
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'meta_query' => [
                    [
                        'key' => 'room_parent',
                        'value' => $room_parent,
                        'compare' => 'IN',
                    ],
                ],
            ];
            query_posts($query);

            $r = [
                'items' => [],
            ];
            while (have_posts()) {
                the_post();
                $r['items'][] = [
                    'id' => get_the_ID(),
                    'name' => get_the_title(),
                    'description' => ''
                ];
            }

            wp_reset_query();

            echo json_encode($r);
            die;

        }

        static function add_edit_scripts()
        {
            wp_enqueue_script('st-hotel-edit-booking', get_template_directory_uri() . '/js/admin/hotel-booking.js', ['jquery', 'jquery-ui-datepicker'], null, true);
            wp_enqueue_style('jjquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css');

        }

        static function is_booking_page()
        {
            if (is_admin()
                and isset($_GET['post_type'])
                and $_GET['post_type'] == 'st_hotel'
                and isset($_GET['page'])
                and $_GET['page'] = 'st_hotel_booking'
            ) return true;

            return false;
        }

        function add_menu_page()
        {
            //Add booking page

            add_submenu_page('edit.php?post_type=st_hotel', __('Hotel Bookings', 'traveler'), __('Hotel Bookings', 'traveler'), 'manage_options', 'st_hotel_booking', [$this, '__hotel_booking_page']);
        }

        function __hotel_booking_page()
        {

            $section = isset($_GET['section']) ? $_GET['section'] : false;

            if ($section) {
                switch ($section) {
                    case "edit_order_item":
                        $this->edit_order_item();
                        break;
                }
            } else {

                $action = isset($_POST['st_action']) ? $_POST['st_action'] : false;
                switch ($action) {
                    case "delete":
                        $this->_delete_items();
                        break;
                }
                echo balanceTags($this->load_view('hotel/booking_index', false));
            }

        }

        function add_booking()
        {

            echo balanceTags($this->load_view('hotel/booking_edit', false, ['page_title' => __('Add new Hotel Booking', 'traveler')]));
        }

        function _delete_items()
        {

            if (empty($_POST) or !check_admin_referer('shb_action', 'shb_field')) {
                //// process form data, e.g. update fields
                return;
            }
            $ids = isset($_POST['post']) ? $_POST['post'] : [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    wp_delete_post($id, true);
                    do_action('st_admin_delete_booking', $id);
                }

            }

            STAdmin::set_message(__("Delete item(s) success", 'traveler'), 'updated');

        }

        function edit_order_item()
        {
            $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : false;
            if (!$item_id or get_post_type($item_id) != 'st_order') {
                return false;
            }

            echo balanceTags($this->load_view('hotel/booking_edit'));
        }

        function _save_booking($order_id)
        {
            if (!check_admin_referer('shb_action', 'shb_field')) die;
            if ($this->_check_validate()) {

                $item_data = [
                    'status' => $_POST['status'],
                ];

                foreach ($item_data as $val => $value) {
                    update_post_meta($order_id, $val, $value);
                }

                $check_out_field = STCart::get_checkout_fields();

                if (!empty($check_out_field)) {
                    foreach ($check_out_field as $field_name => $field_desc) {
                        if ($field_name != 'st_note') {
                            update_post_meta($order_id, $field_name, STInput::post($field_name));
                        }
                    }
                }

                if (TravelHelper::checkTableDuplicate('st_hotel')) {
                    global $wpdb;
                    $table = $wpdb->prefix . 'st_order_item_meta';
                    $where = [
                        'order_item_id' => $order_id,
                        
                    ];
                    $data = [
                        'status' => $_POST['status'],
                        'cancel_refund_status' => 'complete'
                    ];
                    $wpdb->update($table, $data, $where);
                }

                do_action('update_booking_hotel', $order_id);

                STCart::send_mail_after_booking($order_id, true);

                do_action('st_admin_edit_booking_status', $item_data['status'], $order_id);

                wp_safe_redirect(self::$booking_page);
            }
        }

        public function _check_validate()
        {

            $st_first_name = STInput::request('st_first_name', '');
            if (empty($st_first_name)) {
                STAdmin::set_message(__('The firstname field is not empty.', 'traveler'), 'danger');

                return false;
            }

            $st_last_name = STInput::request('st_last_name', '');
            if (empty($st_last_name)) {
                STAdmin::set_message(__('The lastname field is not empty.', 'traveler'), 'danger');

                return false;
            }

            $st_email = STInput::request('st_email', '');
            if (empty($st_email)) {
                STAdmin::set_message(__('The email field is not empty.', 'traveler'), 'danger');

                return false;
            }

            if (!filter_var($st_email, FILTER_VALIDATE_EMAIL)) {
                STAdmin::set_message(__('Invalid email format.', 'traveler'), 'danger');

                return false;
            }

            $st_phone = STInput::request('st_phone', '');
            if (empty($st_phone)) {
                STAdmin::set_message(__('The phone field is not empty.', 'traveler'), 'danger');

                return false;
            }

            return true;
        }

        function is_able_edit()
        {
            $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : false;
            if (!$item_id or get_post_type($item_id) != 'st_order') {
                wp_safe_redirect(self::$booking_page);
                die;
            }

            return true;
        }


        function add_col_header($defaults)
        {

            $this->array_splice_assoc($defaults, 2, 0, ['room_number' => __('Room(s)', 'traveler')]);
            $this->array_splice_assoc($defaults, 2, 0, ['hotel_parent' => __('Hotel', 'traveler')]);

            return $defaults;
        }

        function add_hotel_col_header($defaults)
        {
            $this->array_splice_assoc($defaults, 2, 0, ['hotel_layout' => __('Layout', 'traveler')]);

            return $defaults;
        }

        function array_splice_assoc(&$input, $offset, $length = 0, $replacement = [])
        {
            $tail = array_splice($input, $offset);
            $extracted = array_splice($tail, 0, $length);
            $input += $replacement + $tail;

            return $extracted;
        }

        function add_col_content($column_name, $post_ID)
        {

            if ($column_name == 'hotel_parent') {
                // show content of 'directors_name' column
                $parent = get_post_meta($post_ID, 'room_parent', true);

                if ($parent) {
                    echo "<a href='" . get_edit_post_link($parent) . "'>" . get_the_title($parent) . "</a>";
                }

            }
            if ($column_name == 'room_number') {
                echo get_post_meta($post_ID, 'number_room', true);
            }
        }

        function add_hotel_col_content($column_name, $post_ID)
        {

            if ($column_name == 'hotel_layout') {
                // show content of 'directors_name' column
                $parent = get_post_meta($post_ID, 'st_custom_layout', true);

                if ($parent) {
                    echo "<a href='" . get_edit_post_link($parent) . "'>" . get_the_title($parent) . "</a>";
                } else {
                    echo __('Default', 'traveler');
                }


            }
        }

        static function st_get_custom_price_by_date($post_id, $start_date = null, $price_type = 'default')
        {
            global $wpdb;
            if (!$post_id)
                $post_id = get_the_ID();
            if (empty($start_date))
                $start_date = date("Y-m-d");
            $rs = $wpdb->get_results("SELECT * FROM " . $wpdb->base_prefix . "st_price WHERE post_id=" . $post_id . " AND price_type='" . $price_type . "'  AND start_date <='" . $start_date . "' AND end_date >='" . $start_date . "' AND status=1 ORDER BY priority DESC LIMIT 1");
            if (!empty($rs)) {
                return $rs[0]->price;
            } else {
                return false;
            }
        }

        static function getRoomHotelInfo()
        {
            $room_id = intval(STInput::request('room_id', ''));
            $data = [
                'price' => '',
                'extras' => 'None',
                'adult_html' => '',
                'child_html' => '',
                'room_html' => '',
                'adult_price' => '',
                'child_price' => '',
            ];
            if ($room_id <= 0 || get_post_type($room_id) != 'hotel_room') {
                echo json_encode($data);
            } else {
                $html = '';
                $price = floatval(get_post_meta($room_id, 'price', true));
                $adult_price = floatval(get_post_meta($room_id, 'adult_price', true));
                $child_price = floatval(get_post_meta($room_id, 'child_price', true));
                $adult_number = intval(get_post_meta($room_id, 'adult_number', true));
                
                $adult_max=st()->get_option('hotel_max_adult',20);
                $child_max=st()->get_option('hotel_max_child',20);
                if ($adult_max <= 0) $adult_max = 1;
                $adult_html = '<select name="adult_number" class="form-control" style="width: 100%">';
                $selected = '';
                for ($i = 1; $i <= $adult_max; $i++) {
                    if($i == 1){
                        $adult_html .= '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                    }else {
                        $adult_html .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                    
                }
                $adult_html .= '</select>';

                $child_number = intval(get_post_meta($room_id, 'children_number', true));
                if ($child_number <= 0) $child_max = 0;
                $child_html = '<select name="child_number" class="form-control" style="width: 100%">';
                for ($i = 0; $i <= $child_max; $i++) {
                    if($i == 1){
                        $child_html .= '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                    }else {
                        $child_html .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                $child_html .= '</select>';

                $room_number = intval(get_post_meta($room_id, 'number_room', true));
                if ($room_number <= 0) $room_number = 1;
                $room_html = '<select name="room_num_search" class="form-control" style="width: 100%">';
                for ($i = 1; $i <= $room_number; $i++) {
                    $room_html .= '<option value="' . $i . '">' . $i . '</option>';
                }
                $room_html .= '</select>';

                $extras = get_post_meta($room_id, 'extra_price', true);
                if (is_array($extras) && count($extras)):
                    $html = '<table class="table">';
                    foreach ($extras as $key => $val):
                        $html .= '
                    <tr>
                        <td width="80%">
                            <label for="' . $val['extra_name'] . '" class="ml20">' . $val['title'] . ' (' . TravelHelper::format_money($val['extra_price']) . ')' . '</label>
                            <input type="hidden" name="extra_price[price][' . $val['extra_name'] . ']" value="' . $val['extra_price'] . '">
                            <input type="hidden" name="extra_price[title][' . $val['extra_name'] . ']" value="' . $val['title'] . '">
                        </td>
                        <td width="20%">
                            <select style="width: 100%" class="form-control" name="extra_price[value][' . $val['extra_name'] . ']" id="">';

                        $max_item = intval($val['extra_max_number']);
                        if ($max_item <= 0) $max_item = 1;
                        for ($i = 0; $i <= $max_item; $i++):
                            $html .= '<option value="' . $i . '">' . $i . '</option>';
                        endfor;
                        $html .= '
                            </select>
                        </td>
                    </tr>';
                    endforeach;
                    $html .= '</table>';
                endif;

                $html_required_name = '';
                $disable_adult_name = get_post_meta($room_id, 'disable_adult_name', true);
                $disable_children_name = get_post_meta($room_id, 'disable_children_name', true);
                $disable_infant_name = get_post_meta($room_id, 'disable_infant_name', true);
                if($disable_adult_name == 'off' || $disable_children_name == "off" || $disable_infant_name == "off"){
                    $html_required_name .= '
                    <div class="guest_name_input d-none"
                        data-placeholder="'.esc_html__('Guest %d name', 'traveler').'"
                        data-hide-adult="'.get_post_meta($room_id, 'disable_adult_name', true).'"
                        data-hide-children="'.get_post_meta($room_id, 'disable_children_name', true).'"
                        >
                        <label><span>'.esc_html__('Guest Name', 'traveler').'</span> <span class="required">*</span></label>
                        <div class="guest_name_control">
                            
                        </div>
                        <script type="text/html" id="guest_name_control_item">
                            <div class="control-item mb10">
                                <select name="guest_title[]" class="form-control">
                                <option value="mr">'.esc_html__('Mr', 'traveler').'</option>
                                <option value="miss">'.esc_html__('Miss', 'traveler').'</option>
                                <option value="mrs">'.esc_html__('Mrs', 'traveler').'</option>
                                </select>
                                <input class="form-control " placeholder="" name="guest_name[]" value="">
                            </div>
                        </script>
                    </div>
                    ';
                }

                $data['price'] = TravelHelper::format_money_from_db($price, false);
                $data['adult_price'] = TravelHelper::format_money_from_db($adult_price, false);
                $data['child_price'] = TravelHelper::format_money_from_db($child_price, false);
                $data['extras'] = $html;
                $data['adult_html'] = $adult_html;
                $data['child_html'] = $child_html;
                $data['room_html'] = $room_html;
                $data['required_name_html'] = $html_required_name;
                echo json_encode($data);
            }
            die();
        }

        static function getRoomHotel()
        {
            $hotel_id = intval(STInput::request('hotel_id', ''));
            $room_id = intval(STInput::request('room_id', ''));
            if ($hotel_id <= 0 || get_post_type($hotel_id) != 'st_hotel') {
                echo "";
                die();
            } else {
                $list_room = "<select name='room_id' id='room_id' class='form-control form-control-admin'>";
                $list_room .= "<option value=''>" . __('----Select a room----', 'traveler') . "</option>";
                $query = [
                    'post_status' => 'publish',
                    'post_type' => 'hotel_room',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'DESC',
                    'meta_query' => [
                        [
                            'key' => 'room_parent',
                            'value' => $hotel_id,
                            'compare' => 'IN',
                        ],
                    ],
                ];

                query_posts($query);
                while (have_posts()): the_post();
                    $selected = ($room_id == intval(get_the_ID())) ? 'selected' : '';
                    $list_room .= "<option " . $selected . " value='" . get_the_ID() . "'>" . get_the_title() . "</option>";
                endwhile;
                wp_reset_query();
                wp_reset_postdata();
                $list_room .= "</select>";

                echo balanceTags($list_room);
                die();
            }
        }

        public static function __cronjob_update_min_avg_price($offset, $limit = 2)
        {
            global $wpdb;
            $list_hotel = new WP_Query(array(
                'posts_per_page' => $limit,
                'post_type' => 'st_hotel',
                'offset' => $offset
            ));

            $hotel_ids=[];
            if ($list_hotel->have_posts()) {
                while ($list_hotel->have_posts())
                {
                    $list_hotel->the_post();
                    $hotel_id = get_the_ID();
                    STAdminHotel::_update_avg_price($hotel_id);
                    STAdminHotel::_update_min_price($hotel_id);
                    STAdminHotel::_update_duplicate_data($hotel_id, []);
                }
            }

            wp_reset_postdata();
        }
    }

    new STAdminHotel();
}

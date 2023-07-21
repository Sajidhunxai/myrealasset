<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/27/2019
 * Time: 8:33 AM
 */
$is_feature_hotel = array();
$is_feature_tour = array();
$is_feature_car = array();
$is_feature_rental = array();
$is_feature_activity = array();
$partner_set_feature = st()->get_option( 'partner_set_feature' );
if(!empty( $partner_set_feature ) and ( $partner_set_feature == 'on' )) {
    $is_feature_hotel  = array(
        'type' => 'select',
        'label' => __('Set hotel as feature', 'traveler'),
        'name' => 'is_featured',
        'col' => '4',
        'plh' => '',
        'clear' => true,
        'required' => false,
        'options' => array(
            'off' => __('Off', 'traveler'),
            'on' => __('On', 'traveler'),
        ),
    );
    $is_feature_tour  = array(
        'type' => 'select',
        'label' => __('Set tour as feature', 'traveler'),
        'name' => 'is_featured',
        'col' => '4',
        'plh' => '',
        'clear' => true,
        'required' => false,
        'options' => array(
            'off' => __('Off', 'traveler'),
            'on' => __('On', 'traveler'),
        ),
    );
    $is_feature_car  = array(
        'type' => 'select',
        'label' => __('Set car as feature', 'traveler'),
        'name' => 'is_featured',
        'col' => '4',
        'plh' => '',
        'clear' => true,
        'required' => false,
        'options' => array(
            'off' => __('Off', 'traveler'),
            'on' => __('On', 'traveler'),
        ),
    );
    $is_feature_rental  = array(
        'type' => 'select',
        'label' => __('Set rental as feature', 'traveler'),
        'name' => 'is_featured',
        'col' => '4',
        'plh' => '',
        'required' => false,
        'options' => array(
            'off' => __('Off', 'traveler'),
            'on' => __('On', 'traveler'),
        ),
    );
    $is_feature_activity  = array(
        'type' => 'select',
        'label' => __('Set rental as feature', 'traveler'),
        'name' => 'is_featured',
        'col' => '4',
        'plh' => '',
        'clear' => true,
        'required' => true,
        'options' => array(
            'off' => __('Off', 'traveler'),
            'on' => __('On', 'traveler'),
        ),
    );
}

//Layout hotel
$layout_single_hotel = [
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
    $layout_single_hotel = array_merge($layout_single_hotel,$array_elementor);
}


$layout_single_hotel = apply_filters('st_layout_single_hotel',$layout_single_hotel);
//End layout hotel

//Layout Room
$arr_layout_room = [
    [
        'value' => '1',
        'label' => esc_html__('Layout 1', 'traveler'),
        'src' => get_template_directory_uri() . '/v2/images/layouts/room_detail_1_preview.jpg',
    ],
    [
        'value' => '2',
        'label' => esc_html__('Layout 2', 'traveler'),
        'src' => get_template_directory_uri() . '/v2/images/layouts/room_detail_2_preview.jpg',
    ],
];
$layout_room_single = apply_filters('st_layout_single_room',$arr_layout_room);
//End layout room

//Layout rental
$layout_rental_single = [
    [
        'value' => '1',
        'label' => esc_html__( 'Layout 1', 'traveler' ),
        'src'   => get_template_directory_uri() . '/v2/images/layouts/room_detail_2_preview.jpg',
    ],
    [
        'value' => '2',
        'label' => esc_html__( 'Layout 2', 'traveler' ),
        'src'   => get_template_directory_uri() . '/v2/images/layouts/room_detail_1_preview.jpg',
    ],
];
if(check_using_elementor()){
    $array_rental_elementor = [
       
        [
            'value' => '3',
            'label' => esc_html__('Layout 3', 'traveler'),
            'src' => get_template_directory_uri() . '/v2/images/layouts/rental_detail_3_preview.png',
        ],
        [
            'value' => '4',
            'label' => esc_html__('Layout 4', 'traveler'),
            'src' => get_template_directory_uri() . '/v2/images/layouts/rental_detail_4_preview.png',
        ],
    ];
    $layout_rental_single = array_merge($layout_rental_single,$array_rental_elementor);
}
$layout_rental_single = apply_filters('st_layout_single_rental',$layout_rental_single);

//End layout rental

//Layout Car Single
$array_car_elementor=[];
$layout_car_single = [
    [
        'value' => '1',
        'label' => esc_html__('Layout 1', 'traveler'),
        'src' => get_template_directory_uri() . '/v2/images/layouts/car_layout_1.png',
    ],
    
    
];
if(check_using_elementor()){
    $array_car_elementor = [
        [
            'value' => '2',
            'label' => esc_html__('Layout 2', 'traveler'),
            'src' => get_template_directory_uri() . '/v2/images/layouts/car_layout_2.png',
        ],
        [
            'value' => '3',
            'label' => esc_html__('Layout 3', 'traveler'),
            'src' => get_template_directory_uri() . '/v2/images/layouts/car_layout_3.png',
        ],
    ];
    $layout_car_single = array_merge($layout_car_single,$array_car_elementor);
}
$layout_car_single = apply_filters('st_layout_single_car',$layout_car_single);
//End Layout Car Single

$new_layout = st()->get_option('st_theme_style', 'modern');
if($new_layout === 'modern'){
    return array(
        'add' => array(
            'hotel' => array(
                'tabs' => apply_filters('st_partner_hotel_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('Facilities', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                        array(
                            'name' => 'policy',
                            'label' => __('Policy', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_hotel_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hotel Star', 'traveler'),
                                        'name' => 'hotel_star',
                                        'col' => '6',
                                        'plh' => '',
                                        'options' => array(
                                            '5' => '5',
                                            '4' => '4',
                                            '3' => '3',
                                            '2' => '2',
                                            '1' => '1',
                                            '0' => '0',
                                        ),
                                        'required' => true
                                    ),
                                    array(
                                        //'type' => 'textarea',
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                    $is_feature_hotel,
    
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Hotel Logo', 'traveler'),
                                        'name' => 'id_logo',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
    
                            array(
                                'type' => 'group',
                                'label' => __('DETAIL CONTACT', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Select contact info will show', 'traveler'),
                                        'name' => 'show_agent_contact_info',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => array(
                                            '-1' => __('Select', 'traveler'),
                                            'user_agent_info' => __('Use Agent Contact Info', 'traveler'),
                                            'user_item_info' => __('Use Item Info', 'traveler'),
                                        ),
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Email', 'traveler'),
                                        'name' => 'email',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Website', 'traveler'),
                                        'name' => 'website',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Phone', 'traveler'),
                                        'name' => 'phone',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Fax', 'traveler'),
                                        'name' => 'fax',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Video', 'traveler'),
                                        'name' => 'video',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    )
                                )
                            ),
    
                           /* array(
                                'type' => 'group',
                                'label' => __('LAYOUT', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hotel Detail Layout', 'traveler'),
                                        'name' => 'st_custom_layout',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => st_convert_array_for_partner_field(st_get_layout('st_hotel')),
                                        'required' => false
                                    ),
                                )
                            ),*/
    
                            array(
                                'type' => 'group',
                                'label' => __('BOOK SETTING', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Book before number of day', 'traveler'),
                                        'name' => 'hotel_booking_period',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => true,
                                        'std' => '0'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Minimum stay', 'traveler'),
                                        'name' => 'min_book_room',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false,
                                        'std' => '0'
                                    )
                                )
                            ),
    
                            array(
                                'type' => 'group',
                                'label' => __('PRICE SETTING', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Set auto calculation average price', 'traveler'),
                                        'name' => 'is_auto_caculate',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => array(
                                            'on' => __('Yes', 'traveler'),
                                            'off' => __('No', 'traveler')
                                        ),
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Average price', 'traveler'),
                                        'name' => 'price_avg',
                                        'col' => '4',
                                        'required' => false,
                                        //'operator' => 'or',
                                        'condition' => 'is_auto_caculate:is(off)'
                                    )
                                )
                            ),
                            array(
                                'type' => 'radio-image',
                                'label' => __('Hotel single layout', 'traveler'),
                                'name' => 'hotel_layout_style',
                                'col' => '12',
                                'plh' => '',
                                'choices' => $layout_single_hotel,
                                'std'     => '1',
                                'seperate' => true
                            ),
                        ),
                        'facility' => apply_filters('st_partner_hotel_facility', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('HOTEL IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Hotel Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real hotel address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                        'policy' => array(
                            array(
                                'type' => 'list-item',
                                'label' => __('ADD A POLICY', 'traveler'),
                                'name' => 'hotel_policy',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add A Policy', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'policy_title'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'policy_description',
                                        'rows' => 5
                                    ),
                                )
                            )
                        )
                    )
                ),
            ),
            'room' => array(
                'tabs' => apply_filters('st_partner_hotel_room_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('Facilities', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_hotel_room_content',
                    array(
                        'basic_info' => apply_filters( 'st_partner_hotel_room_basic_info', array(
                                array(
                                    'type' => 'group',
                                    'label' => __('PERSONAL INFORMATION', 'traveler'),
                                    'col' => '12',
                                    'fields' => array(
                                        array(
                                            'type' => 'text',
                                            'label' => __('Hotel Room Name', 'traveler'),
                                            'name' => 'st_title',
                                            'col' => '6',
                                            'plh' => '',
                                            'required' => true
                                        ),
                                        array(
                                            'type' => 'select',
                                            'label' => __('Select the hotel own this room', 'traveler'),
                                            'name' => 'room_parent',
                                            'col' => '6',
                                            'plh' => '',
                                            'required' => false,
                                            'options' => st_get_list_hotels('st_hotel'),
                                        ),
                                        /*array(
                                            'type' => 'select',
                                            'label' => __('Room Detail Layout', 'traveler'),
                                            'name' => 'st_custom_layout',
                                            'col' => '4',
                                            'plh' => '',
                                            'options' => st_convert_array_for_partner_field(st_get_layout('hotel_room')),
                                            'required' => false
                                        ),*/
                                        array(
                                            'type' => 'editor',
                                            'label' => __('Description', 'traveler'),
                                            'name' => 'st_content',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true,
                                            'rows' => 6
                                        ),
                                    )
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of this room', 'traveler'),
                                    'name' => 'number_room',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Adults', 'traveler'),
                                    'name' => 'adult_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Children', 'traveler'),
                                    'name' => 'children_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Beds', 'traveler'),
                                    'name' => 'bed_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Room Footage (square meters)', 'traveler'),
                                    'name' => 'room_footage',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => __('External Booking', 'traveler'),
                                    'name' => 'st_room_external_booking',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('External booking URL', 'traveler'),
                                    'name' => 'st_room_external_booking_link',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_room_external_booking:is(on)'
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => __('Allow Cancel', 'traveler'),
                                    'name' => 'st_allow_cancel',
                                    'col' => '4',
                                    'plh' => '',
                                    'clear' => true,
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of days before the arrival', 'traveler'),
                                    'name' => 'st_cancel_number_days',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_allow_cancel:is(on)',
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Cancellation Fee', 'traveler'),
                                    'name' => 'st_cancel_percent',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_allow_cancel:is(on)'
                                ),
    
                                array(
                                    'type' => 'radio-image',
                                    'label' => __('Hotel Room Layout', 'traveler'),
                                    'name' => 'st_custom_layout',
                                    'col' => '12',
                                    'plh' => '',
                                    'choices' => $layout_room_single,
                                    'std'     => '1',
                                    'seperate' => true
                                ),
                            )
                        ),
                        'facility' => apply_filters('st_partner_hotel_room_facility', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('HOTEL ROOM IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                           
                            array(
                                'type' => 'select',
                                'label' => __('Allow price per person', 'traveler'),
                                'name' => 'price_by_per_person',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Pricing', 'traveler'),
                                'name' => 'price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(off)'
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Adult Pricing', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(on)'
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child Pricing', 'traveler'),
                                'name' => 'child_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(on)'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Discount type.', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent(%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount rating', 'traveler'),
                                'name' => 'discount_rate',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra pricing', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max Of Number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Extra price unit (Accompanied service Price Unit)', 'traveler'),
                                'name' => 'extra_price_unit',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'perday' => __('per Day', 'traveler'),
                                    'fixed' => __('Fixed', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by No.Days', 'traveler'),
                                'name' => 'discount_by_day',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_day[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('From No. days', 'traveler'),
                                        'name' => 'discount_by_day[number_day]',
                                        'plh' => __('Enter From No. days will be discounted', 'traveler')
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('To No. days', 'traveler'),
                                        'name' => 'discount_by_day[number_day_to]',
                                        'plh' => __('Enter To No. days will be discounted', 'traveler')
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Discount', 'traveler'),
                                        'name' => 'discount_by_day[discount]',
                                    ),
                                )
                            ),
                            
                            array(
                                'type' => 'select',
                                'label' => __('Discount type. This only use for discount by number of days.', 'traveler'),
                                'name' => 'discount_type_no_day',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent(%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
                           
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            
                            
                            array(
                                'type' => 'select',
                                'label' => __('Allow customer can booking full day', 'traveler'),
                                'name' => 'allow_full_day',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'on' => __('On', 'traveler'),
                                    'off' => __('Off', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Sale Schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '12',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit options. ', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit by percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit Payment Amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                
                                'condition' => 'deposit_payment_status:is(percent)'
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Hotel Room Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real hotel room address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                        ),
                    )
                )
            ),
            'tour' => array(
                'tabs' => apply_filters('st_partner_tour_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_tour_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Tour Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                    $is_feature_tour,
                                )
                            ),
                           
                        ),
                        'info' => apply_filters('st_partner_tour_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('TOUR IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true,
                                'class' => 'st_border_bottom'
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Video', 'traveler'),
                                'name' => 'video',
                                'col' => '4',
                                'plh' => '',
                                'required' => false
                            ),
                        ),
                        'prices' => array(
                            array(
                                'type' => 'select',
                                'label' => __('Show price by', 'traveler'),
                                'name' => 'tour_price_by',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'person' => __('Price by person', 'traveler'),
                                    'fixed' => __('Price by fixed', 'traveler'),
                                    'fixed_depart' => __('Fixed departure', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Start date', 'traveler'),
                                'name' => 'start_date_fixed',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(fixed_depart)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('End date', 'traveler'),
                                'name' => 'end_date_fixed',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(fixed_depart)',
                                'required' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Adult price', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false,
                                'clear' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child price', 'traveler'),
                                'name' => 'child_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Infant price', 'traveler'),
                                'name' => 'infant_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Base price', 'traveler'),
                                'name' => 'base_price',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'tour_price_by:is(fixed)',
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide adult on booking form', 'traveler'),
                                'name' => 'hide_adult_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide child on booking form', 'traveler'),
                                'name' => 'hide_children_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide infant on booking form', 'traveler'),
                                'name' => 'hide_infant_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by Adults', 'traveler'),
                                'name' => 'discount_by_adult',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'clear' => true,
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_adult_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (From)', 'traveler'),
                                        'name' => 'discount_by_adult_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (To)', 'traveler'),
                                        'name' => 'discount_by_adult_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_adult_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by children', 'traveler'),
                                'name' => 'discount_by_child',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_child_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (From)', 'traveler'),
                                        'name' => 'discount_by_child_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (To)', 'traveler'),
                                        'name' => 'discount_by_child_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_child_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount by people', 'traveler'),
                                'name' => 'discount_by_people_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Sale Schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Tour Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real tour address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'activity' => array(
                'tabs' => apply_filters('st_partner_activity_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_activity_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Activity Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                )
                            ),
                            $is_feature_activity
                            // array(
                            //     'type' => 'select',
                            //     'label' => __('Select contact info will be shown?', 'traveler'),
                            //     'name' => 'show_agent_contact_info',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false,
                            //     'options' => array(
                            //         '' => __('Select', 'traveler'),
                            //         'user_agent_info' => __('Use agent contact Info', 'traveler'),
                            //         'user_item_info' => __('Use item info', 'traveler'),
                            //     ),
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Email', 'traveler'),
                            //     'name' => 'contact_email',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Website', 'traveler'),
                            //     'name' => 'contact_web',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Phone', 'traveler'),
                            //     'name' => 'contact_phone',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Fax', 'traveler'),
                            //     'name' => 'contact_fax',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Video', 'traveler'),
                            //     'name' => 'video',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false
                            // ),
                        ),
                        'info' => apply_filters('st_partner_activity_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('ACTIVITY IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Video', 'traveler'),
                                'name' => 'video',
                                'col' => '4',
                                'plh' => '',
                                'required' => false
                            ),
                        ),
                        'prices' => array(
                            array(
                                'type' => 'number',
                                'label' => __('Adult price', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child price', 'traveler'),
                                'name' => 'child_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Infant price', 'traveler'),
                                'name' => 'infant_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true
                            ),
    
                            array(
                                'type' => 'select',
                                'label' => __('Hide adult on booking form', 'traveler'),
                                'name' => 'hide_adult_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide child on booking form', 'traveler'),
                                'name' => 'hide_children_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide infant on booking form', 'traveler'),
                                'name' => 'hide_infant_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by Adults', 'traveler'),
                                'name' => 'discount_by_adult',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'clear' => true,
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_adult_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (From)', 'traveler'),
                                        'name' => 'discount_by_adult_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (To)', 'traveler'),
                                        'name' => 'discount_by_adult_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_adult_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by children', 'traveler'),
                                'name' => 'discount_by_child',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_child_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (From)', 'traveler'),
                                        'name' => 'discount_by_child_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (To)', 'traveler'),
                                        'name' => 'discount_by_child_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_child_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount by people', 'traveler'),
                                'name' => 'discount_by_people_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Sale Schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            // array(
                            //     'type' => 'select',
                            //     'label' => __('Best Price Guarantee', 'traveler'),
                            //     'name' => 'best-price-guarantee',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'required' => false,
                            //     'clear' => true,
                            //     'options' => array(
                            //         'off' => __('Off', 'traveler'),
                            //         'on' => __('On', 'traveler'),
                            //     ),
                            // ),
                            // array(
                            //     'type' => 'text',
                            //     'label' => __('Best Price Guarantee Text', 'traveler'),
                            //     'name' => 'best-price-guarantee-text',
                            //     'col' => '4',
                            //     'plh' => '',
                            //     'condition' => __('best-price-guarantee:is(on)'),
                            //     'required' => true,
                            // ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Activity Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real activity address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'car' => array(
                'tabs' => apply_filters('st_partner_car_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_car_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Car Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => false,
                                        'rows' => 6
                                    ),
                                )
                            ),
                            array(
                                'type' => 'radio-image',
                                'label' => __('Car single layout', 'traveler'),
                                'name' => 'st_custom_layout_new',
                                'col' => '12',
                                'plh' => '',
                                'choices' => $layout_car_single,
                                'std'     => '1',
                                'seperate' => true
                            ),
                            $is_feature_car
                        ),
                        'info' => apply_filters('st_partner_car_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('CAR IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                            array(
                                'type' => 'select',
                                'label' => __('Car Types', 'traveler'),
                                'name' => 'car_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'normal' => __('Normal', 'traveler'),
                                    'car_transfer' => __('Car Transfer', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Price Type', 'traveler'),
                                'name' => 'price_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'car_type:is(car_transfer)',
                                'options' => array(
                                    'distance' => __('By Distance', 'traveler'),
                                    'fixed' => __('By Fixed', 'traveler'),
                                    'passenger' => __('By Passenger', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Passengers', 'traveler'),
                                'name' => 'num_passenger',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'car_type:is(car_transfer)',
                                'required' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Price', 'traveler'),
                                'name' => 'cars_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => true
                            ),
    
                            array(
                                'type' => 'list-item',
                                'label' => __('Journey', 'traveler'),
                                'name' => 'journey',
                                'col' => '8',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'car_type:is(car_transfer)',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'journey_title'
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Transfer from', 'traveler'),
                                        'name' => 'journey_transfer_from',
                                        'options' => st_convert_destination_car_transfer()
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Transfer to', 'traveler'),
                                        'name' => 'journey_transfer_to',
                                        'options' => st_convert_destination_car_transfer()
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'journey_price',
                                    ),
                                    array(
                                        'type' => 'checkbox',
                                        'label' => __('Return', 'traveler'),
                                        'name' => 'journey_return',
                                        'options' => array(
                                            'yes' => 'Return'
                                        )
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Custom Price', 'traveler'),
                                'name' => 'is_custom_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'price_by_date' => __('Price by Date', 'traveler'),
                                    'price_by_number' => __('Price by number of day/hour', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Price by date', 'traveler'),
                                'name' => 'price_by_date',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'is_custom_price:is(price_by_date)',
                                'fields' => array(
                                    array(
                                        'type' => 'datepicker',
                                        'label' => __('Start date', 'traveler'),
                                        'name' => 'st_start_date'
                                    ),
                                    array(
                                        'type' => 'datepicker',
                                        'label' => __('End date', 'traveler'),
                                        'name' => 'st_end_date',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'st_price',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Price by number', 'traveler'),
                                'name' => 'price_by_number_of_day_hour',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'is_custom_price:is(price_by_number)',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'st_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Number start', 'traveler'),
                                        'name' => 'st_number_start',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Number end', 'traveler'),
                                        'name' => 'st_number_end',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'st_price_by_number',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Price type', 'traveler'),
                                        'name' => 'extra[extra_price_type]',
                                        'options' => array(
                                            'by_day' => __('By day', 'traveler'),
                                            'fixed' => __('Fixed', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'std' => '0',
                                'required' => false
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Create sale schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'st_allow_cancel:is(on)',
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'st_allow_cancel:is(on)'
                            ),
                            
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Car Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real car address', 'traveler'),
                                'name' => 'cars_address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'rental' => array(
                'tabs' => apply_filters('st_partner_rental_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_rental_content',
                    array(
                        'basic_info' => apply_filters( 'st_partner_rental_basic_info', array(
                                array(
                                    'type' => 'group',
                                    'label' => __('PERSONAL INFORMATION', 'traveler'),
                                    'col' => '12',
                                    'fields' => array(
                                        array(
                                            'type' => 'text',
                                            'label' => __('Rental Name', 'traveler'),
                                            'name' => 'st_title',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true
                                        ),
                                        array(
                                            'type' => 'editor',
                                            'label' => __('Description', 'traveler'),
                                            'name' => 'st_content',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true,
                                            'rows' => 6
                                        ),
                                    )
                                ),
                                array(
                                    'type' => 'radio-image',
                                    'label' => __('Rental single layout', 'traveler'),
                                    'name' => 'rental_single_layout_v2',
                                    'col' => '12',
                                    'plh' => '',
                                    'choices' => $layout_rental_single,
                                    'std'     => '1',
                                    'seperate' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Numbers', 'traveler'),
                                    'name' => 'rental_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'clear' => true,
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Max of Adult', 'traveler'),
                                    'name' => 'rental_max_adult',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Max of Children', 'traveler'),
                                    'name' => 'rental_max_children',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Bed', 'traveler'),
                                    'name' => 'rental_bed',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Bath', 'traveler'),
                                    'name' => 'rental_bath',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Room Size', 'traveler'),
                                    'name' => 'rental_size',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Book before number of day', 'traveler'),
                                    'name' => 'rentals_booking_period',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Minimum stay', 'traveler'),
                                    'name' => 'rentals_booking_min_day',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => __('External Booking', 'traveler'),
                                    'name' => 'st_rental_external_booking',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('External booking URL', 'traveler'),
                                    'name' => 'st_rental_external_booking_link',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_rental_external_booking:is(on)',
                                    
                                ),
                                $is_feature_rental,
                                array(
                                    'type' => 'select',
                                    'label' => __('Allow Cancel', 'traveler'),
                                    'name' => 'st_allow_cancel',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of days before the arrival', 'traveler'),
                                    'name' => 'st_cancel_number_days',
                                    'col' => '4',
                                    'plh' => '',
                                    'condition' => 'st_allow_cancel:is(on)',
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Cancellation Fee', 'traveler'),
                                    'name' => 'st_cancel_percent',
                                    'col' => '4',
                                    'plh' => '',
                                    'condition' => 'st_allow_cancel:is(on)'
                                ),
                            )
                        ),
                        'info' => apply_filters('st_partner_rental_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('RENTAL IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Price', 'traveler'),
                                'name' => 'price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => true
                            ),

                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount_rate',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => false
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Discount type (Discount rate by)', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amont', 'traveler'),
                                ),
                            ),
                            
                            array(
                                'type' => 'select',
                                'label' => __('Create sale schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '12',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                           
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Extra price unit (Accompanied service Price Unit)', 'traveler'),
                                'name' => 'extra_price_unit',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'perday' => __('per Day', 'traveler'),
                                    'fixed' => __('Fixed', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by number of days', 'traveler'),
                                'name' => 'discount_by_day',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_day[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('From No. days', 'traveler'),
                                        'name' => 'discount_by_day[number_day]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('To No. days', 'traveler'),
                                        'name' => 'discount_by_day[number_day_to]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Discount', 'traveler'),
                                        'name' => 'discount_by_day[discount]',
                                    ),
                                )
                            ),
                            
                            array(
                                'type' => 'select',
                                'label' => __('Discount Type for No.Day', 'traveler'),
                                'name' => 'discount_type_no_day',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent (%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
    
                            
                            
                           
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => false,
                            ),

                            
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Rental Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real rental address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Distance', 'traveler'),
                                'name' => 'distance_closest',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'rdistance-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'rdistance-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name position', 'traveler'),
                                        'name' => 'rdistance-item[name]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Distance', 'traveler'),
                                        'name' => 'rdistance-item[distance]',
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'rental_room' => array(
                'tabs' => apply_filters('st_partner_rental_room_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('1. BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('3. Photos', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('2. Facility', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_rental_room_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Rental Room Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Select Rental', 'traveler'),
                                        'name' => 'room_parent',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_hotels('st_rental'),
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                )
                            )
                        ),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('RENTAL ROOM IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'facility' => apply_filters('st_partner_rental_room_facility', array()),
                    )
                )
            ),
            'flight' => array(
                'tabs' => apply_filters('st_partner_flight_tabs',
                    array(
                        array(
                            'name' => 'general',
                            'label' => __('General', 'traveler')
                        ),
                        array(
                            'name' => 'tax_option',
                            'label' => __('Tax Options', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_flight_content',
                    array(
                        'general' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Name of flight', 'traveler'),
                                'name' => 'st_title',
                                'col' => '6',
                                'plh' => '',
                                'required' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Airline Company', 'traveler'),
                                'name' => 'airline',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airline'),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Origin', 'traveler'),
                                'name' => 'origin',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'clear' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Destination', 'traveler'),
                                'name' => 'destination',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'timepicker',
                                'label' => __('Departure time', 'traveler'),
                                'name' => 'departure_time',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'group',
                                'label' => __('Total time', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hour(s)', 'traveler'),
                                        'name' => 'total_time[hour]',
                                        'col' => '3',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_flight_time('hour'),
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Minute(s)', 'traveler'),
                                        'name' => 'total_time[minute]',
                                        'col' => '3',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_flight_time('minute'),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Flight Type', 'traveler'),
                                'name' => 'flight_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => array(
                                    'direct' => __('Direct', 'traveler'),
                                    'one_stop' => __('One stop', 'traveler'),
                                    'two_stops' => __('Two stops', 'traveler'),
                                )
                            ),
                        ),
                        'tax_option' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Max Ticket', 'traveler'),
                                'name' => 'max_ticket',
                                'col' => '6',
                                'plh' => '',
                                'required' => false
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Enable Tax', 'traveler'),
                                'name' => 'enable_tax',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'no' => __('No', 'traveler'),
                                    'yes_not_included' => __('Yes, Not included', 'traveler'),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Tax Percent (%)', 'traveler'),
                                'name' => 'vat_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'enable_tax:is(yes_not_included)',
                                'required' => false
                            ),
                        ),
                    )
                )
            )
        )
    );
    
} else {
    return array(
        'add' => array(
            'hotel' => array(
                'tabs' => apply_filters('st_partner_hotel_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('Facilities', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                        array(
                            'name' => 'policy',
                            'label' => __('Policy', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_hotel_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hotel Star', 'traveler'),
                                        'name' => 'hotel_star',
                                        'col' => '6',
                                        'plh' => '',
                                        'options' => array(
                                            '5' => '5',
                                            '4' => '4',
                                            '3' => '3',
                                            '2' => '2',
                                            '1' => '1',
                                            '0' => '0',
                                        ),
                                        'required' => true
                                    ),
                                    array(
                                        //'type' => 'textarea',
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                    $is_feature_hotel,
    
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Hotel Logo', 'traveler'),
                                        'name' => 'id_logo',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
    
                            array(
                                'type' => 'group',
                                'label' => __('DETAIL CONTACT', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Select contact info will show', 'traveler'),
                                        'name' => 'show_agent_contact_info',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => array(
                                            '-1' => __('Select', 'traveler'),
                                            'user_agent_info' => __('Use Agent Contact Info', 'traveler'),
                                            'user_item_info' => __('Use Item Info', 'traveler'),
                                        ),
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Email', 'traveler'),
                                        'name' => 'email',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Website', 'traveler'),
                                        'name' => 'website',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Phone', 'traveler'),
                                        'name' => 'phone',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Fax', 'traveler'),
                                        'name' => 'fax',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Hotel Video', 'traveler'),
                                        'name' => 'video',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false
                                    )
                                )
                            ),
    
                           /* array(
                                'type' => 'group',
                                'label' => __('LAYOUT', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hotel Detail Layout', 'traveler'),
                                        'name' => 'st_custom_layout',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => st_convert_array_for_partner_field(st_get_layout('st_hotel')),
                                        'required' => false
                                    ),
                                )
                            ),*/
    
                            array(
                                'type' => 'group',
                                'label' => __('BOOK SETTING', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Book before number of day', 'traveler'),
                                        'name' => 'hotel_booking_period',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => true,
                                        'std' => '0'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Minimum stay', 'traveler'),
                                        'name' => 'min_book_room',
                                        'col' => '4',
                                        'plh' => '',
                                        'required' => false,
                                        'std' => '0'
                                    )
                                )
                            ),
    
                            array(
                                'type' => 'group',
                                'label' => __('PRICE SETTING', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Set auto calculation average price', 'traveler'),
                                        'name' => 'is_auto_caculate',
                                        'col' => '4',
                                        'plh' => '',
                                        'options' => array(
                                            'on' => __('Yes', 'traveler'),
                                            'off' => __('No', 'traveler')
                                        ),
                                        'required' => false
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Average price', 'traveler'),
                                        'name' => 'price_avg',
                                        'col' => '4',
                                        'required' => false,
                                        //'operator' => 'or',
                                        'condition' => 'is_auto_caculate:is(off)'
                                    )
                                )
                            ),
                        ),
                        'facility' => apply_filters('st_partner_hotel_facility', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('HOTEL IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Hotel Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real hotel address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                        'policy' => array(
                            array(
                                'type' => 'list-item',
                                'label' => __('ADD A POLICY', 'traveler'),
                                'name' => 'hotel_policy',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add A Policy', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'policy_title'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'policy_description',
                                        'rows' => 5
                                    ),
                                )
                            )
                        )
                    )
                ),
            ),
            'room' => array(
                'tabs' => apply_filters('st_partner_hotel_room_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('Facilities', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_hotel_room_content',
                    array(
                        'basic_info' => apply_filters( 'st_partner_hotel_room_basic_info', array(
                                array(
                                    'type' => 'group',
                                    'label' => __('PERSONAL INFORMATION', 'traveler'),
                                    'col' => '12',
                                    'fields' => array(
                                        array(
                                            'type' => 'text',
                                            'label' => __('Hotel Room Name', 'traveler'),
                                            'name' => 'st_title',
                                            'col' => '6',
                                            'plh' => '',
                                            'required' => true
                                        ),
                                        array(
                                            'type' => 'select',
                                            'label' => __('Select the hotel own this room', 'traveler'),
                                            'name' => 'room_parent',
                                            'col' => '6',
                                            'plh' => '',
                                            'required' => false,
                                            'options' => st_get_list_hotels('st_hotel'),
                                        ),
                                        array(
                                            'type' => 'editor',
                                            'label' => __('Description', 'traveler'),
                                            'name' => 'st_content',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true,
                                            'rows' => 6
                                        ),
                                    )
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of this room', 'traveler'),
                                    'name' => 'number_room',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Adults', 'traveler'),
                                    'name' => 'adult_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Children', 'traveler'),
                                    'name' => 'children_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Beds', 'traveler'),
                                    'name' => 'bed_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Room Footage (square meters)', 'traveler'),
                                    'name' => 'room_footage',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => __('External Booking', 'traveler'),
                                    'name' => 'st_room_external_booking',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('External booking URL', 'traveler'),
                                    'name' => 'st_room_external_booking_link',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_room_external_booking:is(on)'
                                ),
                            )
                        ),
                        'facility' => apply_filters('st_partner_hotel_room_facility', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('HOTEL ROOM IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                            array(
                                'type' => 'select',
                                'label' => __('Allow customer can booking full day', 'traveler'),
                                'name' => 'allow_full_day',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'on' => __('On', 'traveler'),
                                    'off' => __('Off', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow price per person', 'traveler'),
                                'name' => 'price_by_per_person',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Pricing', 'traveler'),
                                'name' => 'price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(off)'
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Adult Pricing', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(on)'
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child Pricing', 'traveler'),
                                'name' => 'child_price',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'price_by_per_person:is(on)'
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by No.Days', 'traveler'),
                                'name' => 'discount_by_day',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_day[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. days', 'traveler'),
                                        'name' => 'discount_by_day[number_day]',
                                        'plh' => __('Enter No. days will be discounted', 'traveler')
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Discount', 'traveler'),
                                        'name' => 'discount_by_day[discount]',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Discount type. This only use for discount by number of days.', 'traveler'),
                                'name' => 'discount_type_no_day',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent(%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Discount type.', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent(%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount rating', 'traveler'),
                                'name' => 'discount_rate',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit options. ', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit by percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit Payment Amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'deposit_payment_status:is(percent)'
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra pricing', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max Of Number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'st_allow_cancel:is(on)',
                                'clear' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'st_allow_cancel:is(on)'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Hotel Room Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real hotel room address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                        ),
                    )
                )
            ),
            'tour' => array(
                'tabs' => apply_filters('st_partner_tour_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_tour_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Tour Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                    $is_feature_tour,
                                )
                            ),
                        ),
                        'info' => apply_filters('st_partner_tour_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('TOUR IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true,
                                'class' => 'st_border_bottom'
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Video', 'traveler'),
                                'name' => 'video',
                                'col' => '4',
                                'plh' => '',
                                'required' => false
                            ),
                        ),
                        'prices' => array(
                            array(
                                'type' => 'select',
                                'label' => __('Show price by', 'traveler'),
                                'name' => 'tour_price_by',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'person' => __('Price by person', 'traveler'),
                                    'fixed' => __('Price by fixed', 'traveler'),
                                    'fixed_depart' => __('Fixed departure', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Start date', 'traveler'),
                                'name' => 'start_date_fixed',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(fixed_depart)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('End date', 'traveler'),
                                'name' => 'end_date_fixed',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(fixed_depart)',
                                'required' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Adult price', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false,
                                'clear' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child price', 'traveler'),
                                'name' => 'child_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Infant price', 'traveler'),
                                'name' => 'infant_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'required' => false
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Base price', 'traveler'),
                                'name' => 'base_price',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'tour_price_by:is(fixed)',
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide adult on booking form', 'traveler'),
                                'name' => 'hide_adult_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide child on booking form', 'traveler'),
                                'name' => 'hide_children_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide infant on booking form', 'traveler'),
                                'name' => 'hide_infant_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'tour_price_by:is(person),tour_price_by:is(fixed_depart)',
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by Adults', 'traveler'),
                                'name' => 'discount_by_adult',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'clear' => true,
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_adult_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (From)', 'traveler'),
                                        'name' => 'discount_by_adult_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (To)', 'traveler'),
                                        'name' => 'discount_by_adult_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_adult_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by children', 'traveler'),
                                'name' => 'discount_by_child',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_child_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (From)', 'traveler'),
                                        'name' => 'discount_by_child_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (To)', 'traveler'),
                                        'name' => 'discount_by_child_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_child_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount by people', 'traveler'),
                                'name' => 'discount_by_people_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Sale Schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Tour Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real tour address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'activity' => array(
                'tabs' => apply_filters('st_partner_activity_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_activity_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Activity Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                )
                            ),
                            $is_feature_activity
                        ),
                        'info' => apply_filters('st_partner_activity_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('ACTIVITY IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Video', 'traveler'),
                                'name' => 'video',
                                'col' => '4',
                                'plh' => '',
                                'required' => false
                            ),
                        ),
                        'prices' => array(
                            array(
                                'type' => 'number',
                                'label' => __('Adult price', 'traveler'),
                                'name' => 'adult_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true,
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Child price', 'traveler'),
                                'name' => 'child_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true
                            ),
                            array(
                                'type' => 'number',
                                'label' => __('Infant price', 'traveler'),
                                'name' => 'infant_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => true
                            ),
    
                            array(
                                'type' => 'select',
                                'label' => __('Hide adult on booking form', 'traveler'),
                                'name' => 'hide_adult_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide child on booking form', 'traveler'),
                                'name' => 'hide_children_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Hide infant on booking form', 'traveler'),
                                'name' => 'hide_infant_in_booking_form',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by Adults', 'traveler'),
                                'name' => 'discount_by_adult',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'clear' => true,
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_adult_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (From)', 'traveler'),
                                        'name' => 'discount_by_adult_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Adult (To)', 'traveler'),
                                        'name' => 'discount_by_adult_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_adult_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by children', 'traveler'),
                                'name' => 'discount_by_child',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_child_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (From)', 'traveler'),
                                        'name' => 'discount_by_child_key',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No. Children (To)', 'traveler'),
                                        'name' => 'discount_by_child_key_to',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Percentage of discount', 'traveler'),
                                        'name' => 'discount_by_child_value',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount by people', 'traveler'),
                                'name' => 'discount_by_people_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Type of discount', 'traveler'),
                                'name' => 'discount_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent', 'traveler'),
                                    'amount' => __('Amount', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Sale Schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('is_sale_schedule:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('st_allow_cancel:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Best Price Guarantee', 'traveler'),
                                'name' => 'best-price-guarantee',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Best Price Guarantee Text', 'traveler'),
                                'name' => 'best-price-guarantee-text',
                                'col' => '4',
                                'plh' => '',
                                'condition' => __('best-price-guarantee:is(on)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Activity Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real activity address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'car' => array(
                'tabs' => apply_filters('st_partner_car_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_car_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Car Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Manufacture logo', 'traveler'),
                                'name' => 'cars_logo',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'multi' => false,
                                'output' => 'url'
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Car Manufacturer Name', 'traveler'),
                                'name' => 'cars_name',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'required' => true
                            ),
                            $is_feature_car
                        ),
                        'info' => apply_filters('st_partner_car_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('CAR IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                            array(
                                'type' => 'select',
                                'label' => __('Car Types', 'traveler'),
                                'name' => 'car_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'normal' => __('Normal', 'traveler'),
                                    'car_transfer' => __('Car Transfer', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Price Type', 'traveler'),
                                'name' => 'price_type',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'condition' => 'car_type:is(car_transfer)',
                                'options' => array(
                                    'distance' => __('By Distance', 'traveler'),
                                    'fixed' => __('By Fixed', 'traveler'),
                                    'passenger' => __('By Passenger', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Passengers', 'traveler'),
                                'name' => 'num_passenger',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'car_type:is(car_transfer)',
                                'required' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Price', 'traveler'),
                                'name' => 'cars_price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => true
                            ),
    
                            array(
                                'type' => 'list-item',
                                'label' => __('Journey', 'traveler'),
                                'name' => 'journey',
                                'col' => '8',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'car_type:is(car_transfer)',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'journey_title'
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Transfer from', 'traveler'),
                                        'name' => 'journey_transfer_from',
                                        'options' => st_convert_destination_car_transfer()
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Transfer to', 'traveler'),
                                        'name' => 'journey_transfer_to',
                                        'options' => st_convert_destination_car_transfer()
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'journey_price',
                                    ),
                                    array(
                                        'type' => 'checkbox',
                                        'label' => __('Return', 'traveler'),
                                        'name' => 'journey_return',
                                        'options' => array(
                                            'yes' => 'Return'
                                        )
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Custom Price', 'traveler'),
                                'name' => 'is_custom_price',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'price_by_date' => __('Price by Date', 'traveler'),
                                    'price_by_number' => __('Price by number of day/hour', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Price by date', 'traveler'),
                                'name' => 'price_by_date',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'is_custom_price:is(price_by_date)',
                                'fields' => array(
                                    array(
                                        'type' => 'datepicker',
                                        'label' => __('Start date', 'traveler'),
                                        'name' => 'st_start_date'
                                    ),
                                    array(
                                        'type' => 'datepicker',
                                        'label' => __('End date', 'traveler'),
                                        'name' => 'st_end_date',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'st_price',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Price by number', 'traveler'),
                                'name' => 'price_by_number_of_day_hour',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'condition' => 'is_custom_price:is(price_by_number)',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'st_title'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Number start', 'traveler'),
                                        'name' => 'st_number_start',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Number end', 'traveler'),
                                        'name' => 'st_number_end',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'st_price_by_number',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Price type', 'traveler'),
                                        'name' => 'extra[extra_price_type]',
                                        'options' => array(
                                            'by_day' => __('By day', 'traveler'),
                                            'fixed' => __('Fixed', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount rate', 'traveler'),
                                'name' => 'discount',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'std' => '0',
                                'required' => false
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Create sale schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of cars for rent', 'traveler'),
                                'name' => 'number_car',
                                'col' => '6',
                                'plh' => '',
                                'required' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => true,
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'st_allow_cancel:is(on)',
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'condition' => 'st_allow_cancel:is(on)'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Car Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real car address', 'traveler'),
                                'name' => 'cars_address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'rental' => array(
                'tabs' => apply_filters('st_partner_rental_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'info',
                            'label' => __('Info', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('Photos', 'traveler')
                        ),
                        array(
                            'name' => 'prices',
                            'label' => __('Price', 'traveler')
                        ),
                        array(
                            'name' => 'locations',
                            'label' => __('Locations', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_rental_content',
                    array(
                        'basic_info' => apply_filters( 'st_partner_rental_basic_info', array(
                                array(
                                    'type' => 'group',
                                    'label' => __('PERSONAL INFORMATION', 'traveler'),
                                    'col' => '12',
                                    'fields' => array(
                                        array(
                                            'type' => 'text',
                                            'label' => __('Rental Name', 'traveler'),
                                            'name' => 'st_title',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true
                                        ),
                                        array(
                                            'type' => 'editor',
                                            'label' => __('Description', 'traveler'),
                                            'name' => 'st_content',
                                            'col' => '12',
                                            'plh' => '',
                                            'required' => true,
                                            'rows' => 6
                                        ),
                                    )
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Numbers', 'traveler'),
                                    'name' => 'rental_number',
                                    'col' => '4',
                                    'plh' => '',
                                    'clear' => true,
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Max of Adult', 'traveler'),
                                    'name' => 'rental_max_adult',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Max of Children', 'traveler'),
                                    'name' => 'rental_max_children',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Bed', 'traveler'),
                                    'name' => 'rental_bed',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Number of Bath', 'traveler'),
                                    'name' => 'rental_bath',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Room Size', 'traveler'),
                                    'name' => 'rental_size',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true
                                ),
    
                                array(
                                    'type' => 'text',
                                    'label' => __('Booking Period', 'traveler'),
                                    'name' => 'rentals_booking_period',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('Minimum stay', 'traveler'),
                                    'name' => 'rentals_booking_min_day',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => __('External Booking', 'traveler'),
                                    'name' => 'st_rental_external_booking',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => false,
                                    'options' => array(
                                        'off' => __('No', 'traveler'),
                                        'on' => __('Yes', 'traveler'),
                                    ),
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => __('External booking URL', 'traveler'),
                                    'name' => 'st_rental_external_booking_link',
                                    'col' => '4',
                                    'plh' => '',
                                    'required' => true,
                                    'condition' => 'st_rental_external_booking:is(on)'
                                ),
                                $is_feature_rental
                            )
                        ),
                        'info' => apply_filters('st_partner_rental_info', array()),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('RENTAL IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'prices' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Price', 'traveler'),
                                'name' => 'price',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Discount Rate', 'traveler'),
                                'name' => 'discount_rate',
                                'col' => '4',
                                'plh' => '',
                                'operator' => 'or',
                                'required' => false
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Create sale schedule', 'traveler'),
                                'name' => 'is_sale_schedule',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale start date', 'traveler'),
                                'name' => 'sale_price_from',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'datepicker',
                                'label' => __('Sale end date', 'traveler'),
                                'name' => 'sale_price_to',
                                'col' => '4',
                                'plh' => '',
                                'condition' => 'is_sale_schedule:is(on)',
                                'required' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Deposit payment options', 'traveler'),
                                'name' => 'deposit_payment_status',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    '' => __('Disallow Deposit', 'traveler'),
                                    'percent' => __('Deposit By Percent', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Deposit amount', 'traveler'),
                                'name' => 'deposit_payment_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => __('deposit_payment_status:is(percent)'),
                                'required' => false,
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Extra', 'traveler'),
                                'name' => 'extra_price',
                                'col' => '6',
                                'plh' => '',
                                'clear' => true,
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'extra[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name', 'traveler'),
                                        'name' => 'extra[extra_name]',
                                        'std' => 'extra_'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Max of number', 'traveler'),
                                        'name' => 'extra[extra_max_number]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Price', 'traveler'),
                                        'name' => 'extra[extra_price]',
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Required Extra', 'traveler'),
                                        'name' => 'extra[extra_required]',
                                        'options' => array(
                                            'off' => __('Off', 'traveler'),
                                            'on' => __('On', 'traveler'),
                                        ),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Discount by number of days', 'traveler'),
                                'name' => 'discount_by_day',
                                'col' => '6',
                                'plh' => '',
                                'text_add' => __('Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'discount_by_day[title]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('No.days', 'traveler'),
                                        'name' => 'discount_by_day[number_day]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Discount', 'traveler'),
                                        'name' => 'discount_by_day[discount]',
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Discount Type', 'traveler'),
                                'name' => 'discount_type_no_day',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'percent' => __('Percent (%)', 'traveler'),
                                    'fixed' => __('Amount', 'traveler'),
                                ),
                            ),
    
                            array(
                                'type' => 'select',
                                'label' => __('Allow Cancel', 'traveler'),
                                'name' => 'st_allow_cancel',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('No', 'traveler'),
                                    'on' => __('Yes', 'traveler'),
                                ),
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Number of days before the arrival', 'traveler'),
                                'name' => 'st_cancel_number_days',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'st_allow_cancel:is(on)',
                                'clear' => true
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Cancellation Fee', 'traveler'),
                                'name' => 'st_cancel_percent',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'st_allow_cancel:is(on)'
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Disable "Adult Name Required"', 'traveler'),
                                'name' => 'disable_adult_name',
                                'col' => '4',
                                'plh' => '',
                                'clear' => true,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Children Name Required"', 'traveler'),
                                'name' => 'disable_children_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),

                            array(
                                'type' => 'select',
                                'label' => __('Disable "Infant Name Required"', 'traveler'),
                                'name' => 'disable_infant_name',
                                'col' => '4',
                                'plh' => '',
                                'required' => false,
                                'options' => array(
                                    'off' => __('Off', 'traveler'),
                                    'on' => __('On', 'traveler'),
                                ),
                            ),
                        ),
                        'locations' => array(
                            array(
                                'type' => 'multi_location',
                                'label' => __('Rental Location', 'traveler'),
                                'name' => 'multi_location',
                                'col' => '6',
                                'plh' => __('SELECT LOCATION', 'traveler'),
                                'required' => true
                            ),
                            array(
                                'type' => 'address_autocomplete',
                                'label' => __('Real rental address', 'traveler'),
                                'name' => 'address',
                                'col' => '6',
                                'plh' => __('Address', 'traveler'),
                                'required' => true,
                                'clear' => true
                            ),
                            array(
                                'type' => 'map',
                                'label' => '',
                                'name' => 'st_map',
                                'col' => '12',
                                'plh' => '',
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Properties near by', 'traveler'),
                                'name' => 'properties_near_by',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'property-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[featured_image]'
                                    ),
                                    array(
                                        'type' => 'textarea',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'property-item[description]',
                                        'rows' => 5
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Icon Map', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'property-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lat', 'traveler'),
                                        'name' => 'property-item[map_lat]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Lng', 'traveler'),
                                        'name' => 'property-item[map_lng]'
                                    ),
                                )
                            ),
                            array(
                                'type' => 'list-item',
                                'label' => __('Distance', 'traveler'),
                                'name' => 'distance_closest',
                                'col' => '12',
                                'plh' => '',
                                'text_add' => __('+ Add New', 'traveler'),
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Title', 'traveler'),
                                        'name' => 'rdistance-item[title]'
                                    ),
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured Image', 'traveler'),
                                        'output' => 'url',
                                        'name' => 'rdistance-item[icon]'
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Name position', 'traveler'),
                                        'name' => 'rdistance-item[name]',
                                    ),
                                    array(
                                        'type' => 'text',
                                        'label' => __('Distance', 'traveler'),
                                        'name' => 'rdistance-item[distance]',
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'rental_room' => array(
                'tabs' => apply_filters('st_partner_rental_room_tabs',
                    array(
                        array(
                            'name' => 'basic_info',
                            'label' => __('1. BASIC INFO', 'traveler')
                        ),
                        array(
                            'name' => 'photos',
                            'label' => __('3. Photos', 'traveler')
                        ),
                        array(
                            'name' => 'facility',
                            'label' => __('2. Facility', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_rental_room_content',
                    array(
                        'basic_info' => array(
                            array(
                                'type' => 'group',
                                'label' => __('PERSONAL INFORMATION', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'text',
                                        'label' => __('Rental Room Name', 'traveler'),
                                        'name' => 'st_title',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Select Rental', 'traveler'),
                                        'name' => 'room_parent',
                                        'col' => '6',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_hotels('st_rental'),
                                    ),
                                    array(
                                        'type' => 'editor',
                                        'label' => __('Description', 'traveler'),
                                        'name' => 'st_content',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'rows' => 6
                                    ),
                                )
                            )
                        ),
                        'photos' => array(
                            array(
                                'type' => 'group',
                                'label' => __('RENTAL ROOM IMAGE', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'upload',
                                        'label' => __('Featured image', 'traveler'),
                                        'name' => 'id_featured_image',
                                        'col' => '12',
                                        'plh' => '',
                                        'required' => true,
                                        'multi' => false
                                    ),
                                )
                            ),
                            array(
                                'type' => 'upload',
                                'label' => __('Gallery', 'traveler'),
                                'name' => 'id_gallery',
                                'col' => '12',
                                'plh' => '',
                                'required' => true,
                                'multi' => true
                            )
                        ),
                        'facility' => apply_filters('st_partner_rental_room_facility', array()),
                    )
                )
            ),
            'flight' => array(
                'tabs' => apply_filters('st_partner_flight_tabs',
                    array(
                        array(
                            'name' => 'general',
                            'label' => __('General', 'traveler')
                        ),
                        array(
                            'name' => 'tax_option',
                            'label' => __('Tax Options', 'traveler')
                        ),
                    )
                ),
                'content' => apply_filters('st_partner_flight_content',
                    array(
                        'general' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Name of flight', 'traveler'),
                                'name' => 'st_title',
                                'col' => '6',
                                'plh' => '',
                                'required' => true
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Airline Company', 'traveler'),
                                'name' => 'airline',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airline'),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Origin', 'traveler'),
                                'name' => 'origin',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'clear' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Destination', 'traveler'),
                                'name' => 'destination',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'timepicker',
                                'label' => __('Departure time', 'traveler'),
                                'name' => 'departure_time',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => st_get_list_taxonomy('st_airport'),
                            ),
                            array(
                                'type' => 'group',
                                'label' => __('Total time', 'traveler'),
                                'col' => '12',
                                'fields' => array(
                                    array(
                                        'type' => 'select',
                                        'label' => __('Hour(s)', 'traveler'),
                                        'name' => 'total_time[hour]',
                                        'col' => '3',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_flight_time('hour'),
                                    ),
                                    array(
                                        'type' => 'select',
                                        'label' => __('Minute(s)', 'traveler'),
                                        'name' => 'total_time[minute]',
                                        'col' => '3',
                                        'plh' => '',
                                        'required' => true,
                                        'options' => st_get_list_flight_time('minute'),
                                    ),
                                )
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Flight Type', 'traveler'),
                                'name' => 'flight_type',
                                'col' => '6',
                                'plh' => '',
                                'required' => true,
                                'options' => array(
                                    'direct' => __('Direct', 'traveler'),
                                    'one_stop' => __('One stop', 'traveler'),
                                    'two_stops' => __('Two stops', 'traveler'),
                                )
                            ),
                        ),
                        'tax_option' => array(
                            array(
                                'type' => 'text',
                                'label' => __('Max Ticket', 'traveler'),
                                'name' => 'max_ticket',
                                'col' => '6',
                                'plh' => '',
                                'required' => false
                            ),
                            array(
                                'type' => 'select',
                                'label' => __('Enable Tax', 'traveler'),
                                'name' => 'enable_tax',
                                'col' => '6',
                                'plh' => '',
                                'required' => false,
                                'clear' => true,
                                'options' => array(
                                    'no' => __('No', 'traveler'),
                                    'yes_not_included' => __('Yes, Not included', 'traveler'),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => __('Tax Percent (%)', 'traveler'),
                                'name' => 'vat_amount',
                                'col' => '6',
                                'plh' => '',
                                'condition' => 'enable_tax:is(yes_not_included)',
                                'required' => false
                            ),
                        ),
                    )
                )
            )
        )
    );
    
}

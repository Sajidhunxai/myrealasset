<?php

add_action('vc_before_init', 'loadVCMapNewLayout');

function loadVCMapNewLayout() {

    vc_map(array(
        'name' => esc_html__('ST Video', 'traveler'),
        'base' => 'st_video_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'description' => esc_html__('Play video in page', 'traveler'),
        'params' => array(
            array(
                'type' => 'textarea',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'label_video',
                'description' => esc_html__('Enter a text for title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Youtube ID', 'traveler'),
                'param_name' => 'link',
                'description' => esc_html__('Enter a video id for element. Ex: gdXDJ9TIcZQ', 'traveler')
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'traveler'),
                'param_name' => 'background_image'
            ),
        )
    ));



    vc_map([
        'name' => __('ST List of Related Services', 'traveler'),
        'base' => 'st_list_of_related_services_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title',
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Service', 'traveler'),
                'param_name' => 'service',
                'value' => [
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Car', 'traveler') => 'st_cars',
                    __('Rental', 'traveler') => 'st_rental',
                ],
                'std' => 'st_hotel'
            ],
            [
                'type' => 'textfield',
                'param_name' => 'ids',
                'heading' => __('Service ID', 'traveler'),
                'description' => __('Ids separated by commas. Example: 123,456', 'traveler')
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 4
            ]
        ]
    ]);



    vc_map([
        "name" => __("ST FAQs", 'traveler'),
        "base" => "st_faq_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_faq',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Title", 'traveler'),
                        "param_name" => "title",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content", 'traveler'),
                        "param_name" => "content",
                    ],
                ),
            ]
        )
    ]);



    vc_map([
        "name" => __("ST FAQs Solo", 'traveler'),
        "base" => "st_faq_solo",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_faq',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Title", 'traveler'),
                        "param_name" => "title",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content", 'traveler'),
                        "param_name" => "content",
                    ],
                ),
            ]
        )
    ]);



    vc_map([
        "name" => __("ST About Team", 'traveler'),
        "base" => "st_about_us_team_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_team',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Photo", 'traveler'),
                        "param_name" => "photo",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Name", 'traveler'),
                        "param_name" => "name",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Position", 'traveler'),
                        "param_name" => "position",
                        "description" => "",
                    ],
                    [
                        'type' => 'param_group',
                        'heading' => esc_html__('Social', 'traveler'),
                        'param_name' => 'list_social',
                        'value' => '',
                        'params' => array(
                            [
                                "type" => "iconpicker",
                                "heading" => __("Icon", 'traveler'),
                                "param_name" => "icon",
                                "description" => "",
                            ],
                            [
                                "type" => "vc_link",
                                "heading" => __("Link to", 'traveler'),
                                "param_name" => "link",
                                "description" => "",
                            ],
                        ),
                    ]
                ),
            ]
        )
    ]);



    vc_map([
        "name" => __("ST About Solo", 'traveler'),
        "base" => "st_about_us_team_solo",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_team',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Photo", 'traveler'),
                        "param_name" => "photo",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Name", 'traveler'),
                        "param_name" => "name",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Position", 'traveler'),
                        "param_name" => "position",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Country", 'traveler'),
                        "param_name" => "country",
                        "description" => "",
                    ],
                    [
                        'type' => 'param_group',
                        'heading' => esc_html__('Social', 'traveler'),
                        'param_name' => 'list_social',
                        'value' => '',
                        'params' => array(
                            [
                                "type" => "iconpicker",
                                "heading" => __("Icon", 'traveler'),
                                "param_name" => "icon",
                                "description" => "",
                            ],
                            [
                                "type" => "vc_link",
                                "heading" => __("Link to", 'traveler'),
                                "param_name" => "link",
                                "description" => "",
                            ],
                        ),
                    ]
                ),
            ]
        )
    ]);



    vc_map([
        "name" => __("ST About Us Gallery", 'traveler'),
        "base" => "st_about_us_gallery_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "attach_images",
                "heading" => __("Gallery", 'traveler'),
                "param_name" => "images",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                "type" => "vc_link",
                "heading" => __("Link to", 'traveler'),
                "param_name" => "link",
                "description" => "",
            ],
        )
    ]);



    vc_map([
        "name" => __("ST About Us Information", 'traveler'),
        "base" => "st_about_us_info_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "attach_image",
                "heading" => __("Image", 'traveler'),
                "param_name" => "image",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Name", 'traveler'),
                "param_name" => "name",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Position", 'traveler'),
                "param_name" => "position",
                "description" => "",
            ],
            [
                "type" => "textarea",
                "heading" => __("More Information", 'traveler'),
                "param_name" => "more_info",
                "description" => "",
            ],
        )
    ]);



    vc_map([
        "name" => __("ST About Us Statistic", 'traveler'),
        "base" => "st_about_us_statistic",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_statistic',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Main text", 'traveler'),
                        "param_name" => "main_text",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Sub text", 'traveler'),
                        "param_name" => "sub_text",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Description", 'traveler'),
                        "param_name" => "desc",
                        "description" => "",
                    ],
                ),
            )
        )
    ]);



    vc_map([
        "name" => __("ST Contact Info", 'traveler'),
        "base" => "st_contact_info_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => [
            [
                "type" => "attach_image",
                "heading" => __("Background Image", 'traveler'),
                "param_name" => "contact_bg",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Company Name", 'traveler'),
                "param_name" => "company_name",
                "description" => "",
            ],
            [
                "type" => "textarea_html",
                "heading" => __("Company Info", 'traveler'),
                "param_name" => "content",
                "description" => "",
            ],
        ]
    ]);



    vc_map([
        "name" => __("ST Contact Map", 'traveler'),
        "base" => "st_contact_map_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => [
            [
                "type" => "textfield",
                "heading" => __("Lat", 'traveler'),
                "param_name" => "lat",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Lng", 'traveler'),
                "param_name" => "lng",
                "description" => "",
            ],
        ]
    ]);



    vc_map([
        'name' => __('ST Search Form', 'traveler'),
        'base' => 'st_search_form_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'dropdown',
                'heading' => __('Search Form Type', 'traveler'),
                'param_name' => 'form_type',
                'value' => [
                    __('Single service', 'traveler') => 'single',
                    __('Mix services', 'traveler') => 'mix',
                ],
                'std' => 'single'
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Service', 'traveler'),
                'param_name' => 'service',
                'value' => apply_filters('stt_search_filter_bakery',
                [
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Car', 'traveler') => 'st_cars',
                    __('TravelPayouts Flight', 'traveler') => 'tp_flight',
                    __('TravelPayout Hotel', 'traveler') => 'tp_hotel',
                    __('Booking.com', 'traveler') => 'bookingdc',
                    __('Expedia', 'traveler') => 'expedia',
                ]),
                'std' => 'st_hotel',
                'dependency' => array(
                    'element' => 'form_type',
                    'value' => array('single')
                ),
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Tour Style', 'traveler'),
                'param_name' => 'tour_style',
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2',
                ],
                'std' => 'style1',
                'dependency' => array(
                    'element' => 'service',
                    'value' => array('st_tours')
                ),
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Search items', 'traveler'),
                'param_name' => 'service_items',
                'value' => '',
                'dependency' => array(
                    'element' => 'form_type',
                    'value' => array('mix')
                ),
                'params' => apply_filters('st_mixed_search_form_group_fields', array(
                    [
                        "type" => "textfield",
                        "heading" => __("Tab title", 'traveler'),
                        "param_name" => "tab_title",
                    ],
                    [
                        "type" => "dropdown",
                        "heading" => __("Service", 'traveler'),
                        "param_name" => "tab_service",
                        'value' => apply_filters('st_mixed_search_form_tab', [
                            __('Hotel', 'traveler') => 'st_hotel',
                            __('Tour', 'traveler') => 'st_tours',
                            __('Activity', 'traveler') => 'st_activity',
                            __('Rental', 'traveler') => 'st_rental',
                            __('Car', 'traveler') => 'st_cars',
                            __('Car Transfer', 'traveler') => 'st_cartranfer',
                            __('TravelPayouts Flight', 'traveler') => 'tp_flight',
                            __('TravelPayout Hotel', 'traveler') => 'tp_hotel',
                            __('Booking.com', 'traveler') => 'bookingdc',
                            __('Expedia', 'traveler') => 'expedia',
                        ]),
                    ],
                ))
            ],
            [
                'type' => 'textfield',
                'heading' => __('Heading', 'traveler'),
                'param_name' => 'heading'
            ],
            [
                'type' => 'textfield',
                'heading' => __('Description', 'traveler'),
                'param_name' => 'description'
            ],
            [
                "type" => "dropdown",
                "heading" => __("Heading align", 'traveler'),
                "param_name" => "heading_align",
                'value' => [
                    __('Center', 'traveler') => 'center',
                    __('Left', 'traveler') => 'left',
                    __('Right', 'traveler') => 'right',
                ],
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => array(
                    __('Normal', 'traveler') => 'normal',
                    __('Slider', 'traveler') => 'slider',
                ),
                'std' => 'normal',
            ],
            [
                "type" => "attach_images",
                "heading" => __("Slider images", 'traveler'),
                "param_name" => "images",
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('slider')
                ),
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Featured Item', 'traveler'),
                'param_name' => 'feature_item',
                'value' => '',
                'dependency' => array(
                    'element' => 'service',
                    'value' => array('st_rental')
                ),
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Heading", 'traveler'),
                        "param_name" => "heading",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Description", 'traveler'),
                        "param_name" => "description",
                    ],
                ),
            ],
        ]
    ]);

    vc_map([
        'name' => __('ST Car Types', 'traveler'),
        'base' => 'st_car_type_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
        ]
    ]);

    vc_map([
        'name' => __('ST Featured Item', 'traveler'),
        'base' => 'st_featured_item_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'attach_image',
                'heading' => __('Icon', 'traveler'),
                'param_name' => 'icon'
            ],
            [
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title'
            ],
            [
                'type' => 'textarea',
                'heading' => __('Description', 'traveler'),
                'param_name' => 'desc'
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Styles', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Icon in Top(Style 1)', 'traveler') => 'icon_top_1',
                    __('Icon in Top(Style 2)', 'traveler') => 'icon_top_2',
                    __('Icon in Top(Style 3)', 'traveler') => 'icon_top_3',
                    __('Icon in Left', 'traveler') => 'icon_left',
                ],
                'std' => 'icon_left'
            ]
        ]
    ]);



    vc_map([
        'name' => __('ST Offer Item', 'traveler'),
        'base' => 'st_offer_item_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'attach_image',
                'heading' => __('Background', 'traveler'),
                'param_name' => 'background'
            ],
            [
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title'
            ],
            [
                'type' => 'textfield',
                'heading' => __('Sub Title', 'traveler'),
                'param_name' => 'sub_title'
            ],
            [
                'type' => 'vc_link',
                'heading' => __('Link', 'traveler'),
                'param_name' => 'link'
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('With featured label', 'traveler') => 'featured',
                    __('With icon', 'traveler') => 'icon',
                ],
                'std' => 'icon'
            ],
            [
                'type' => 'textfield',
                'heading' => __('Featured text', 'traveler'),
                'param_name' => 'featured_text',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('featured')
                )
            ],
            [
                "type" => "attach_image",
                "heading" => __("Icon", 'traveler'),
                "param_name" => "icon",
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('icon')
                )
            ],
        ]
    ]);



    vc_map([
        'name' => __('ST List of Services', 'traveler'),
        'base' => 'st_list_of_services_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'dropdown',
                'heading' => __('Service', 'traveler'),
                'param_name' => 'service',
                'value' => [
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Car', 'traveler') => 'st_cars',
                ],
                'std' => 'st_hotel'
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2',
                    __('Style 3', 'traveler') => 'style3',
                    __('Style 4', 'traveler') => 'style4',
                    __('Style 5', 'traveler') => 'style5',
                    __('Style 6', 'traveler') => 'style6',
                    __('Style 7', 'traveler') => 'style7',
                    __('Style 8', 'traveler') => 'style8',
                ],
                'std' => 'style1',
                'dependency' => array(
                    'element' => 'service',
                    'value' => array('st_tours')
                ),
            ],
            [
                'type' => 'textfield',
                'param_name' => 'title',
                'heading' => __('Title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style5')
                ),
            ],
            [
                'type' => 'textarea',
                'param_name' => 'description',
                'heading' => __('Description', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style5')
                ),
            ],
            [
                'type' => 'textfield',
                'param_name' => 'ids',
                'heading' => __('Service ID', 'traveler'),
                'description' => __('Ids separated by commas. Example: 123,456', 'traveler')
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 8
            ],
        ]
    ]);

    vc_map([
        'name' => __('ST List of Hotel service Load more', 'traveler'),
        'base' => 'st_list_of_hotel_service_loadmore',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'textfield',
                'param_name' => 'ids',
                'heading' => __('Service ID', 'traveler'),
                'description' => __('Ids separated by commas. Example: 123,456', 'traveler')
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 8
            ],
        ]
    ]);



    vc_map([
        'name' => __('ST Rental Types', 'traveler'),
        'base' => 'st_rental_amenities',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('0 for unlimited', 'traveler'),
                'std' => 6
            ]
        ]
    ]);





    vc_map([
        'name' => __('ST List of Multi Services', 'traveler'),
        'base' => 'st_list_of_multi_services_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                "type" => "textfield",
                "heading" => __("Heading", 'traveler'),
                "param_name" => "heading",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_services',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Name of service", 'traveler'),
                        "param_name" => "name",
                    ],
                    [
                        'type' => 'dropdown',
                        'heading' => __('Service', 'traveler'),
                        'param_name' => 'service',
                        'value' => [
                            __('Hotel', 'traveler') => 'st_hotel',
                            __('Tour', 'traveler') => 'st_tours',
                            __('Activity', 'traveler') => 'st_activity',
                            __('Rental', 'traveler') => 'st_rental',
                            __('Car', 'traveler') => 'st_cars',
                        ],
                        'std' => 'st_hotel'
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Service ID", 'traveler'),
                        "param_name" => "ids",
                    ]
                ),
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 8
            ]
        ]
    ]);



    vc_map([
        'name' => __('ST List of Destinations', 'traveler'),
        'base' => 'st_list_of_destinations_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'checkbox',
                'heading' => __('Service', 'traveler'),
                'param_name' => 'service',
                'value' => [
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Car', 'traveler') => 'st_cars',
                ],
                'std' => 'st_hotel'
            ],
            [
                'type' => 'textfield',
                'param_name' => 'ids',
                'heading' => __('Destination ID', 'traveler'),
                'description' => __('Ids separated by commas. Example: 123,456', 'traveler')
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 8
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Layout 1', 'traveler') => 'normal',
                    __('Layout 2 (Masonry)', 'traveler') => 'masonry',
                    __('Layout 3', 'traveler') => 'layout3',
                    __('Layout 4', 'traveler') => 'layout4',
                    __('Layout 5', 'traveler') => 'layout5',
                    __('Layout 6', 'traveler') => 'layout6',
                    __('Layout 7(3 Column)', 'traveler') => 'layout7',
                    __('Layout 8', 'traveler') => 'layout8',
                    __('Layout only support solo demo', 'traveler') => 'layout9', //layout solo
                ],
                'std' => 'normal'
            ],
        ]
    ]);



    vc_map([
        'name' => __('ST Language & Currency', 'traveler'),
        'base' => 'st_language_currency_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
        ]
    ]);



    vc_map([
        "name" => __("ST Testimonial", 'traveler'),
        "base" => "st_testimonial_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_team',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Avatar", 'traveler'),
                        "param_name" => "avatar",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Name", 'traveler'),
                        "param_name" => "name",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Rating", 'traveler'),
                        "param_name" => "rating",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content", 'traveler'),
                        "param_name" => "content",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Source", 'traveler'),
                        "param_name" => "source",
                        "description" => "",
                    ]
                ),
            ],
            [
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style_layout",
                "value" => [
                    __('Default', 'traveler') => '',
                    __('Style 1', 'traveler') => 'style-1',
                    __('Style 2', 'traveler') => 'style-2',
                    __('Style 3', 'traveler') => 'style-3',
                    __('Style 4', 'traveler') => 'style-4',
                    __('Style 5', 'traveler') => 'style-5',
                    __('Style 6', 'traveler') => 'style-6', //solo layout
                ],
                'std' => 'style-1'
            ],
        )
    ]);



    /* Ngothoai */

    vc_map([
        'name' => __('ST Text And Button', 'traveler'),
        'base' => 'st_text_and_button',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'textfield',
                'heading' => __('Title text', 'traveler'),
                'param_name' => 'header_title',
                'value' => __('Title text', 'traveler')
            ],
            [
                'type' => 'textarea',
                'heading' => __('Content', 'traveler'),
                'param_name' => 'st_content_ht',
                'value' => ''
            ],
            [
                'type' => 'textfield',
                'heading' => __('Text button', 'traveler'),
                'param_name' => 'text_button_ht',
                'value' => '',
            ],
            [
                'type' => 'textfield',
                'heading' => __('Url button', 'traveler'),
                'param_name' => 'url_button_ht',
                'value' => '#',
            ],
            [
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style_layout",
                "value" => [
                    __('Default', 'traveler') => '',
                    __('Style 1', 'traveler') => 'style-1',
                    __('Style 2', 'traveler') => 'style-2',
                ],
                'std' => 'style-1'
            ],
        )
    ]);

    vc_map([
        'name' => __('ST Title and content', 'traveler'),
        'base' => 'st_title_line',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'textfield',
                'heading' => __('Title text', 'traveler'),
                'param_name' => 'header_title',
                'value' => __('Title text', 'traveler')
            ],
            [
                'type' => 'textarea_html',
                'heading' => __('Content', 'traveler'),
                'param_name' => 'content',
                'value' => ''
            ],
            [
                "type" => "dropdown",
                "heading" => __("Layout default", 'traveler'),
                "param_name" => "layout_title",
                "value" => [
                    __('Default', 'traveler') => 'st_default',
                    __('Center', 'traveler') => 'st_center',
                ],
                'std' => 'st_center'
            ],
            [
                "type" => "dropdown",
                "heading" => __("Style layout", 'traveler'),
                "param_name" => "style_layout",
                "value" => [
                    __('Title and line', 'traveler') => 'style-1',
                    __('Title and line(style2)', 'traveler') => 'style-9',
                    __('Line and title', 'traveler') => 'style-2',
                    __('No line', 'traveler') => 'style-3',
                    __('Title line style 2', 'traveler') => 'style-4',
                    __('With icon', 'traveler') => 'style-5',
                    __('No line style 2', 'traveler') => 'style-6',
                    __('Wase style(black color)', 'traveler') => 'style-7',
                    __('Wase style(White color)', 'traveler') => 'style-8',
                ],
                'std' => 'style-1'
            ],
        )
    ]);

    vc_map([
        'name' => __('ST Box Item Text', 'traveler'),
        'base' => 'st_box_item_text',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Box title', 'traveler'),
                'param_name' => 'box_title',
                'value' => __('', 'traveler')
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Box content', 'traveler'),
                'param_name' => 'box_content',
                'value' => __('', 'traveler')
            ),
        )
    ]);

    vc_map([
        'name' => __('ST Box Item Icon', 'traveler'),
        'base' => 'st_box_item_icon',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'textfield',
                'heading' => __('Box title', 'traveler'),
                'param_name' => 'box_title',
                'value' => __('', 'traveler')
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Social', 'traveler'),
                'param_name' => 'list_social',
                'value' => '',
                'params' => array(
                    [
                        "type" => "iconpicker",
                        "heading" => __("Icon", 'traveler'),
                        "param_name" => "icon",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
            ]
        )
    ]);



    vc_map([
        'name' => esc_html__('[Hotel Single] ST List Room Hotel', 'traveler'),
        'base' => 'hotel_activity_list_room',
        'description' => esc_html__('[Hotel Single] ST List Room Hotel', 'traveler'),
        'icon' => 'icon-st',
        'category' => '[New] Hotel Single',
        'params' => array(
            [
                'type' => 'st_dropdown',
                'class' => '',
                'heading' => esc_html__('Select Hotel', 'traveler'),
                'param_name' => 'service_id',
                'stype' => 'post_type',
                'sparam' => 'st_hotel',
                'sautocomplete' => 'yes',
                'description' => esc_html__('Enter List of Services', 'traveler'),
            ],
            [
                'type' => 'textfield',
                'heading' => __('Number show', 'traveler'),
                'param_name' => 'number_show_room',
                'value' => __('', 'traveler'),
                'description' => esc_html__('Enter number show room, example -1 for show all', 'traveler'),
            ],
            [
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('Style Options', 'traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1' => array(
                        'title' => esc_html__('Style List', 'traveler'),
                        'image' => function_exists('st_hotel_alone_load_assets_dir') ? st_hotel_alone_load_assets_dir() . '/images/st-reservation-content/style-1.jpg' : '',
                    ),
                    'style-2' => array(
                        'title' => esc_html__('Style Tab', 'traveler'),
                        'image' => function_exists('st_hotel_alone_load_assets_dir') ? st_hotel_alone_load_assets_dir() . '/images/st-reservation-content/style-1.jpg' : '',
                    ),
                    'style-3' => array(
                        'title' => esc_html__('Style Slider', 'traveler'),
                        'image' => function_exists('st_hotel_alone_load_assets_dir') ? st_hotel_alone_load_assets_dir() . '/images/st-reservation-content/style-1.jpg' : '',
                    ),
                )
            ],
        )
    ]);





    vc_map([
        'name' => __('ST Room Item', 'traveler'),
        'base' => 'st_room_item',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'st_dropdown',
                'class' => '',
                'heading' => esc_html__('Select Room', 'traveler'),
                'param_name' => 'room_id',
                'stype' => 'post_type',
                'sparam' => 'hotel_room',
                'sautocomplete' => 'yes',
                'description' => esc_html__('Select Room of Services', 'traveler'),
            ],
        )
    ]);



    vc_map([
        'name' => __('ST Service New', 'traveler'),
        'base' => 'st_service_icon_slider',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Style 1', 'traveler') => 'style-1',
                    __('Style 2', 'traveler') => 'style-2',
                    __('Style 3', 'traveler') => 'style-3',
                ],
                'std' => 'style-1'
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Social', 'traveler'),
                'param_name' => 'list_service',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Icon Image", 'traveler'),
                        "param_name" => "icon",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Name service", 'traveler'),
                        "param_name" => "name_service",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content service", 'traveler'),
                        "param_name" => "content_service",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
            ]
        )
    ]);



    // vc_map([
    //     'name' => __('ST Instagram', 'traveler'),
    //     'base' => 'st_instagram',
    //     'content_element' => true,
    //     'icon' => 'icon-st',
    //     "category" => "[New] Hotel Single",
    //     'params' => array(
    //         [
    //             "type" => "textfield",
    //             "heading" => __("Token Key access token", 'traveler'),
    //             "param_name" => "token_api",
    //             "description" => "Enter code token Instagram: link : https://instagram.pixelunion.net/",
    //         ],
    //         [
    //             "type" => "textfield",
    //             "heading" => __("UserID Instagram", 'traveler'),
    //             "param_name" => "user_id",
    //             "description" => "Enter user id Instagram",
    //         ],
    //     )
    // ]);

    vc_map([
        'name' => __('ST Icon image - text', 'traveler'),
        'base' => 'iconimg_text',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                "type" => "attach_image",
                "heading" => __("Image icon", 'traveler'),
                "param_name" => "image_icon",
                "description" => "Upload image icon: 32px x 32px",
            ],
            [
                "type" => "textfield",
                "heading" => __("Text", 'traveler'),
                "param_name" => "text_icon",
                "description" => "Enter text",
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Style 1', 'traveler') => 'style-1',
                    __('Style 2', 'traveler') => 'style-2',
                ],
                'std' => 'style-1'
            ],
        )
    ]);

    vc_map([
        'name' => __('ST Filter Activity', 'traveler'),
        'base' => 'st_filter_activity',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array()
    ]);

    vc_map([
        'name' => __('ST Slider Hotel', 'traveler'),
        'base' => 'st_slider_activity',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'textfield',
                'param_name' => 'speed_slider',
                'heading' => __('Speed slider', 'traveler'),
                'description' => __('Input time (number) in milliseconds.', 'traveler'),
                'std' => 3000,
                "dependency" => [
                    "element" => "style_gallery",
                    "value" => ["style1", "style2", "style3", "style4"]
                ]
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style_gallery',
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2',
                    __('Style 3', 'traveler') => 'style3',
                    __('Style 4', 'traveler') => 'style4',
                    __('Style 5', 'traveler') => 'style5',
                ],
                'std' => 'style1',
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Add slider', 'traveler'),
                'param_name' => 'list_slider',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Image", 'traveler'),
                        "param_name" => "image",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Title", 'traveler'),
                        "param_name" => "title_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content slider", 'traveler'),
                        "param_name" => "content_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
                "dependency" => [
                    "element" => "style_gallery",
                    "value" => ["style1", "style2", "style5"]
                ]
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Add slider for style 3', 'traveler'),
                'param_name' => 'list_slider_style_3',
                'value' => '',
                'params' => array(
                    /* [

                      "type" => "attach_image",

                      "heading" => __("Image", 'traveler'),

                      "param_name" => "image",

                      "description" => "",

                      ], */

                    [
                        "type" => "textfield",
                        "heading" => __("Title", 'traveler'),
                        "param_name" => "title_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content slider", 'traveler'),
                        "param_name" => "content_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                    [
                        "type" => "attach_image",
                        "heading" => __("Customer Avatar", 'traveler'),
                        "param_name" => "customer_avatar",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Customer Name", 'traveler'),
                        "param_name" => "customer_name",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Customer Description", 'traveler'),
                        "param_name" => "customer_description",
                        "description" => "",
                    ],
                ),
                "dependency" => [
                    "element" => "style_gallery",
                    "value" => ["style3"]
                ]
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Add slider', 'traveler'),
                'param_name' => 'list_slider_style_4',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Image", 'traveler'),
                        "param_name" => "image",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Title", 'traveler'),
                        "param_name" => "title_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
                "dependency" => [
                    "element" => "style_gallery",
                    "value" => ["style4"]
                ]
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Text animation', 'traveler'),
                'param_name' => 'text_animation',
                'value' => [
                    __('Style 1', 'traveler') => 'text-normal',
                    __('Style 2', 'traveler') => 'text-hoz',
                    __('Style 3', 'traveler') => 'text-rotate',
                    __('Style 4', 'traveler') => 'text-up',
                ],
                'dependency' => array(
                    'element' => 'style_gallery',
                    'value' => array('style2')
                )
            ],
        )
    ]);





    vc_map([
        'name' => __('ST Gallery Hotel', 'traveler'),
        'base' => 'st_gallery_hotel_single',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style_gallery',
                'value' => [
                    __('Grid', 'traveler') => 'grid-style',
                    __('Slider', 'traveler') => 'slider',
                    __('Masonry', 'traveler') => 'masonry',
                ],
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Column', 'traveler'),
                'param_name' => 'colums_gallery',
                'value' => [
                    __('Select', 'traveler') => '3-colum',
                    __('1 Column', 'traveler') => '1-colum',
                    __('2 Columns', 'traveler') => '2-colum',
                    __('3 Columns', 'traveler') => '3-colum',
                    __('4 Columns', 'traveler') => '4-colum',
                    __('5 Columns', 'traveler') => '5-colum',
                ],
            ],
            [
                "type" => "attach_images",
                "heading" => __("Images", 'traveler'),
                "param_name" => "images_gallery",
                "description" => "Choose all image gallery",
            ],
        )
    ]);



    vc_map([
        "name" => __("Tab List menu", 'traveler'),
        "base" => "st_hotel_tab",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                'type' => 'param_group',
                'heading' => esc_html__('Tab items', 'traveler'),
                'param_name' => 'st_item_tab',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "heading" => __("Name tab", 'traveler'),
                        "param_name" => "st_name_tab",
                        "description" => "",
                    ],
                    [
                        "type" => "param_group",
                        "heading" => __("Item content", 'traveler'),
                        "param_name" => "st_item_content_tab",
                        'value' => '',
                        'params' => array(
                            [
                                "type" => "textfield",
                                "heading" => __("Title", 'traveler'),
                                "param_name" => "st_title",
                                "description" => "",
                            ],
                            [
                                "type" => "attach_image",
                                "heading" => __("Image", 'traveler'),
                                "param_name" => "st_image",
                                "description" => "",
                            ],
                            [
                                "type" => "textarea",
                                "heading" => __("Content", 'traveler'),
                                "param_name" => "st_content",
                                "description" => "",
                            ],
                            [
                                "type" => "textfield",
                                "heading" => __("Price", 'traveler'),
                                "param_name" => "st_price",
                                "description" => "",
                            ],
                        ),
                    ],
                ),
            ]
        )
    ]);





    vc_map([
        "name" => __("[Hotel Single]ST Testimonial", 'traveler'),
        "base" => "st_testimonial_single",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "dropdown",
                "heading" => esc_html__("Style", 'traveler'),
                "param_name" => "style",
                "value" => [
                    esc_html__("Style 1") => "style1",
                    esc_html__("Style2") => "style2"
                ],
                "std" => "style1"
            ],
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "dependency" => array(
                    "element" => "style",
                    "value" => array("style1"),
                )
            ],
            [
                "type" => "attach_image",
                "heading" => __("Image icon", 'traveler'),
                "param_name" => "icon_image",
                "description" => "",
                "dependency" => array(
                    "element" => "style",
                    "value" => array("style1"),
                )
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List items', 'traveler'),
                'param_name' => 'list_testimonial',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => __("Avatar", 'traveler'),
                        "param_name" => "avatar",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Name", 'traveler'),
                        "param_name" => "name",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Work", 'traveler'),
                        "param_name" => "job",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => __("Content", 'traveler'),
                        "param_name" => "content",
                        "description" => "",
                    ]
                ),
            ]
        )
    ]);

    vc_map([
        "name" => __("[Hotel Single]Button scroll Down", 'traveler'),
        "base" => "st_scroll_single",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "attach_image",
                "heading" => __("Image icon", 'traveler'),
                "param_name" => "icon_scroll",
                "description" => "",
            ],
        )
    ]);

    vc_map([
        "name" => __("[Hotel Single]ST Map", 'traveler'),
        "base" => "st_single_map",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Lat map", 'traveler'),
                "param_name" => "latmap",
                "description" => "",
            ],
            [
                "type" => "textfield",
                "heading" => __("Long map", 'traveler'),
                "param_name" => "longmap",
                "description" => "",
            ],
            [
                "type" => "attach_image",
                "heading" => __("Location icon", 'traveler'),
                "param_name" => "icon_local",
                "description" => "",
            ],
        )
    ]);



    vc_map([
        'name' => __('ST Hotel Timeline', 'traveler'),
        'base' => 'st_timeline',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "[New] Hotel Single",
        'params' => array(
            [
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'timeline_title',
                'value' => '',
            ],
            [
                "type" => "attach_image",
                "heading" => __("Image", 'traveler'),
                "param_name" => "image_timeline",
                'value' => '',
                "description" => "Upload image Min width 500px and min height 500px",
            ],
            [
                'type' => 'textarea_html',
                'heading' => __('Content', 'traveler'),
                'param_name' => 'content',
                'value' => ''
            ],
            [
                "type" => "dropdown",
                "heading" => __("Style layout", 'traveler'),
                "param_name" => "style_layout",
                "value" => [
                    __('Left', 'traveler') => 'left',
                    __('Right', 'traveler') => 'right',
                    __('Center', 'traveler') => 'center',
                ],
                'std' => 'left'
            ],
        )
    ]);

    vc_map([
        "name" => __("[Singel Hotel] Slider single", 'traveler'),
        "base" => "st_single_hotel_slider",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "dropdown",
                "heading" => __("Choose colum", 'traveler'),
                "param_name" => "style_layout",
                "value" => [
                    __('Default', 'traveler') => '',
                    __('1', 'traveler') => 'one',
                    __('2', 'traveler') => 'two',
                    __('3', 'traveler') => 'three',
                    __('4', 'traveler') => 'four',
                ],
                'default' => 'one'
            ],
            [
                "type" => "attach_images",
                "heading" => __("Choose all image slider", 'traveler'),
                "param_name" => "st_images_slider",
                "description" => "",
            ],
        )
    ]);

    vc_map([
        "name" => __("[Singel Hotel] Team", 'traveler'),
        "base" => "st_single_hotel_team",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "attach_image",
                "heading" => __("Image", 'traveler'),
                "param_name" => "st_images_team",
                "description" => "",
            ],
            [
                'type' => 'textfield',
                'heading' => __('Name', 'traveler'),
                'param_name' => 'st_team_name',
                'value' => '',
            ],
            [
                'type' => 'textfield',
                'heading' => __('Work', 'traveler'),
                'param_name' => 'st_team_work',
                'value' => '',
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Social', 'traveler'),
                'param_name' => 'list_social',
                'value' => '',
                'params' => array(
                    [
                        "type" => "iconpicker",
                        "heading" => __("Icon", 'traveler'),
                        "param_name" => "icon",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => __("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
            ]
        )
    ]);

    vc_map([
        "name" => __("[Singel Hotel] Popup Gallery Single", 'traveler'),
        "base" => "st_single_hotel_gallery",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "attach_images",
                "heading" => __("Choose all image gallery", 'traveler'),
                "param_name" => "st_images_gallery",
                "description" => "",
            ],
        )
    ]);

    vc_map([
        "name" => __("[Singel Hotel] Popup Video Single", 'traveler'),
        "base" => "st_video_popup",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Link video youtube", 'traveler'),
                "param_name" => "st_video_pupop",
                "description" => "",
            ],
            [
                "type" => "attach_images",
                "heading" => __("Choose all image video", 'traveler'),
                "param_name" => "st_images_video",
                "description" => "",
            ],
        )
    ]);

    vc_map([
        'name' => esc_html__('[Hotel Single] ST Blog Single', 'traveler'),
        'base' => 'hotel_activity_blog',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('List blog', 'traveler'),
        'params' => array(
            [
                'type' => 'dropdown',
                'heading' => esc_html__('Style', 'traveler'),
                'param_name' => 'style',
                'value' => array(
                    esc_html__('Default', 'traveler') => '',
                    esc_html__('Tab', 'traveler') => 'style-1',
                    esc_html__('List', 'traveler') => 'style-2',
                ),
            ],
            [
                'type' => 'st_checkbox',
                'heading' => esc_html__('Select Categories', 'traveler'),
                'param_name' => 'select_category',
                'desc' => esc_html__('Check the box to choose category', 'traveler'),
                'stype' => 'tax',
                'sparam' => false
            ],
            [
                'type' => 'dropdown',
                'heading' => esc_html__('Order By', 'traveler'),
                'param_name' => 'order_by',
                'value' => function_exists('hotel_alone_get_order_list') ? array_flip(hotel_alone_get_order_list()) : '',
                'std' => 'ID'
            ],
            [
                'type' => 'dropdown',
                'heading' => esc_html__('Order', 'traveler'),
                'param_name' => 'order',
                'value' => array(
                    esc_html__('Descending', 'traveler') => 'DESC',
                    esc_html__('Ascending', 'traveler') => 'ASC',
                ),
                'std' => 'DESC'
            ],
            [
                "type" => "textfield",
                "heading" => __("Number item", 'traveler'),
                "param_name" => "number_items",
                "description" => "",
            ],
        )
    ]);





    vc_map([
        "name" => __("[Singel Hotel] Table Membership", 'traveler'),
        "base" => "st_single_hotel_table",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "attach_image",
                "heading" => __("Icon", 'traveler'),
                "param_name" => "st_images_icon",
                "description" => "",
            ],
            [
                'param_name' => 'id_package',
                'type' => 'dropdown',
                'value' => st_get_packpage(), // here I'm stuck
                'heading' => __('Choose package', 'traveler'),
                'description' => '',
                'holder' => 'div',
            ],
            [
                'param_name' => 'sale_member',
                'type' => 'textfield',
                'value' => '', // here I'm stuck
                'heading' => __('Enter number sale', 'traveler'),
                'description' => '',
                'holder' => 'div',
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Support', 'traveler'),
                'param_name' => 'list_support',
                'value' => '',
                'params' => array(
                    [
                        "type" => "checkbox",
                        "class" => "",
                        "heading" => __("Support", 'traveler'),
                        "param_name" => "check",
                        "value" => __("", 'traveler'),
                        "description" => __("Enter description.", 'traveler')
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Title item", 'traveler'),
                        "param_name" => "title_items",
                        "description" => "",
                    ],
                ),
            ]
        )
    ]);



    vc_map([
        "name" => __("Checkout package", 'traveler'),
        "base" => "st_checkout_package_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
        )
    ]);

    vc_map([
        "name" => __("Success checkout Package", 'traveler'),
        "base" => "st_success_checkout_package_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array()
    ]);

    /**

     * VC Map for Single Hotel

     */
    vc_map([
        "name" => __("[Single Hotel] Room Taxonomy", 'traveler'),
        "base" => "st_room_taxonomy",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array()
    ]);



    vc_map([
        "name" => __("[Singel Hotel] List of Rooms", 'traveler'),
        "base" => "st_single_hotel_list_of_room_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "dropdown",
                "heading" => __("Type of page", 'traveler'),
                "param_name" => "type_of_page",
                "value" => array(
                    __('List of rooms page', 'traveler') => 'list_page',
                    __('Search result page', 'traveler') => 'search_page',
                ),
            ],
            [
                "type" => "dropdown",
                "heading" => __("Layout default", 'traveler'),
                "param_name" => "layout",
                "value" => array(
                    __('List', 'traveler') => 'list',
                    __('Grid', 'traveler') => 'grid',
                ),
            ],
        )
    ]);



    vc_map([
        "name" => __("[Single Hotel] Check Availability Form", 'traveler'),
        "base" => "st_single_hotel_check_availability_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2'
                ],
                'std' => 'style1'
            ],
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
            ],
        )
    ]);



    vc_map([
        "name" => __("[Hotel Single] Banner Apartment", 'traveler'),
        "base" => "st_banner_apartment",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => array(
            [
                "type" => "dropdown",
                "heading" => esc_html__("Style", 'traveler'),
                "param_name" => "style",
                "value" => [
                    esc_html__("Style 1", 'traveler') => 'style1',
                    esc_html__("Style 2", 'traveler') => 'style2'
                ],
                "std" => "style1"
            ],
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
            ],
            [
                "type" => "vc_link",
                "heading" => __("URL", 'traveler'),
                "param_name" => "link_url",
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style1')
                ),
            ],
            [
                "type" => "textarea",
                "heading" => __("Description", 'traveler'),
                "param_name" => "description",
            ],
            [
                "type" => "attach_image",
                "heading" => __("Background Image"),
                "param_name" => "background_image"
            ],
        )
    ]);



    vc_map([
        "name" => __("[Hotel Single] Mapbox", 'traveler'),
        "base" => "st_hotel_alone_mapbox",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "[New] Hotel Single",
        "params" => [
            [
                'type' => 'textfield',
                'heading' => esc_html__('Map Zoom', 'traveler'),
                'param_name' => 'map_zoom',
                'description' => esc_html__('Enter a number for map zoom', 'traveler'),
                'std' => 12,
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('List Location', 'traveler'),
                'param_name' => 'list_location',
                'value' => '',
                'params' => array(
                    [
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Location Name", 'traveler'),
                        "param_name" => "location_name",
                        "value" => __("", 'traveler'),
                        "description" => __("Enter location name.", 'traveler')
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Location Address", 'traveler'),
                        "param_name" => "location_address",
                        "description" => __("Enter location address.", 'traveler')
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Location Longitude", 'traveler'),
                        "param_name" => "location_longitude",
                        "description" => __("Enter location longitude.", 'traveler')
                    ],
                    [
                        "type" => "textfield",
                        "heading" => __("Location Latitude", 'traveler'),
                        "param_name" => "location_latitude",
                        "description" => __("Enter location latitude.", 'traveler')
                    ],
                ),
            ],
        ]
    ]);



    // vc_map(array(
    //     'name' => esc_html__('[ST] Half Slider', 'traveler'),
    //     'base' => 'st_half_slider',
    //     'icon' => 'icon-st',
    //     'category' => 'Tour Modern',
    //     'params' => array(
    //         array(
    //             'type' => 'textfield',
    //             'admin_label' => true,
    //             'heading' => esc_html__('Heading', 'traveler'),
    //             'param_name' => 'heading',
    //             'description' => esc_html__('Enter a text for heading', 'traveler'),
    //         ),
    //         array(
    //             'type' => 'textarea',
    //             'heading' => esc_html__('Description', 'traveler'),
    //             'param_name' => 'description',
    //             'description' => esc_html__('Enter a text for description', 'traveler')
    //         ),
    //         array(
    //             'type' => 'vc_link',
    //             'heading' => esc_html__('URL', 'traveler'),
    //             'param_name' => 'link'
    //         ),
    //         array(
    //             'type' => 'attach_images',
    //             'heading' => esc_html__('Gallery', 'traveler'),
    //             'param_name' => 'gallery'
    //         ),
    //     )
    // ));

    vc_map(array(
        'name' => esc_html__('[ST] Slider Tour With Search Form', 'traveler'),
        'base' => 'st_slider_tour',
        'icon' => 'icon-st',
        'category' => 'Tour Modern',
        'params' => array(
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2',
                    __('Style 3', 'traveler') => 'style3',
                ],
                'std' => 'style1'
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Add slider', 'traveler'),
                'param_name' => 'list_slider',
                'value' => '',
                'params' => array(
                    [
                        "type" => "attach_image",
                        "heading" => esc_html__("Image", 'traveler'),
                        "param_name" => "image",
                        "description" => "",
                    ],
                    [
                        "type" => "textfield",
                        "heading" => esc_html__("Title", 'traveler'),
                        "param_name" => "title_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "textarea",
                        "heading" => esc_html__("Content slider", 'traveler'),
                        "param_name" => "content_slider",
                        "description" => "",
                    ],
                    [
                        "type" => "vc_link",
                        "heading" => esc_html__("Link to", 'traveler'),
                        "param_name" => "link",
                        "description" => "",
                    ],
                ),
            ],
        )
    ));

    vc_map(array(
        'name' => esc_html__('[ST] List Tour Categories', 'traveler'),
        'base' => 'st_list_categories',
        'icon' => 'icon-st',
        'category' => 'Tour Modern',
        'params' => array(
            [
                'type' => 'textfield',
                'param_name' => 'category_ids',
                'heading' => __('Category tour ID', 'traveler'),
                'description' => __('Ids separated by commas. Example: 123,456', 'traveler')
            ],
            [
                'type' => 'textfield',
                'param_name' => 'number',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 4
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Style', 'traveler'),
                'param_name' => 'style',
                'value' => [
                    __('Layout 1', 'traveler') => 'layout1',
                    __('Layout 2', 'traveler') => 'layout2'
                ],
                'std' => 'layout1'
            ],
        )
    ));

    // vc_map(array(
    //     'name' => esc_html__('[ST] Images of Instagram', 'traveler'),
    //     'base' => 'st_insta_image',
    //     'icon' => 'icon-st',
    //     'category' => 'Tour Modern',
    //     'params' => array(
    //         [
    //             'type' => 'textfield',
    //             'param_name' => 'user_name',
    //             'heading' => __('User Name', 'traveler'),
    //             'description' => __('Enter your username of your instagram', 'traveler')
    //         ],
    //         [
    //             'type' => 'textfield',
    //             'param_name' => 'number_image',
    //             'heading' => __('Number of Image', 'traveler'),
    //             'description' => ''
    //         ],
    //     )
    // ));

    vc_map(array(
        'name' => esc_html__('[ST] Best Seller', 'traveler'),
        'base' => 'st_best_seller',
        'icon' => 'icon-st',
        'category' => 'Tour Modern',
        'params' => array(
            [
                'type' => 'textfield',
                'param_name' => 'best_seller',
                'heading' => __('Text', 'traveler'),
                'description' => ''
            ],
            [
                'type' => 'textfield',
                'param_name' => 'id',
                'heading' => __('Tour ID', 'traveler'),
                'description' => __('Enter only one ID. Example: 123', 'traveler')
            ],
            [
                "type" => "vc_link",
                "heading" => __("Link to", 'traveler'),
                "param_name" => "link",
                "description" => "",
            ],
        )
    ));

    vc_map(array(
        'name' => esc_html__('[ST] Introduce', 'traveler'),
        'base' => 'st_introduce',
        'icon' => 'icon-st',
        'category' => 'Tour Modern',
        'params' => array(
            [
                'type' => 'dropdown',
                'param_name' => 'style',
                'heading' => __('Style', 'traveler'),
                'value' => [
                    __('Style 1', 'traveler') => 'style1',
                    __('Style 2', 'traveler') => 'style2',
                    __('Style 3', 'traveler') => 'style3'
                ],
                'std' => 'layout1'
            ],
            [
                "type" => "attach_image",
                "heading" => esc_html__("Image", 'traveler'),
                "param_name" => "image",
                "description" => "",
            ],
            [
                "type" => "attach_image",
                "heading" => esc_html__("Logo", 'traveler'),
                "param_name" => "logo",
                "description" => "",
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style3')
                ),
            ],
            [
                'type' => 'textfield',
                'param_name' => 'text',
                'heading' => __('Text', 'traveler'),
                'description' => ''
            ],
            [
                'type' => 'textfield',
                'param_name' => 'title',
                'heading' => __('Title', 'traveler'),
                'description' => ''
            ],
            [
                'type' => 'textarea',
                'param_name' => 'st_content',
                'heading' => __('Description', 'traveler'),
                'description' => ''
            ],
            [
                "type" => "vc_link",
                "heading" => __("Link to", 'traveler'),
                "param_name" => "link",
                "description" => "",
            ],
        )
    ));



    /* Single location */

    vc_map([
        'name' => __('ST Search Form Single Location', 'traveler'),
        'base' => 'st_search_form_new_single_location',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'dropdown',
                'heading' => __('Search Form Type', 'traveler'),
                'param_name' => 'form_type',
                'value' => [
                    __('Single service', 'traveler') => 'single',
                    __('Mix services', 'traveler') => 'mix',
                ],
                'std' => 'single'
            ],
            [
                'type' => 'dropdown',
                'heading' => __('Service', 'traveler'),
                'param_name' => 'service',
                'value' => [
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Car', 'traveler') => 'st_cars',
                    __('Car Transfer', 'traveler') => 'st_cartranfer',
                ],
                'std' => 'st_hotel',
                'dependency' => array(
                    'element' => 'form_type',
                    'value' => array('single')
                ),
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Search items', 'traveler'),
                'param_name' => 'service_items',
                'value' => '',
                'dependency' => array(
                    'element' => 'form_type',
                    'value' => array('mix')
                ),
                'params' => apply_filters('st_mixed_search_form_group_fields', array(
                    [
                        "type" => "textfield",
                        "heading" => __("Tab title", 'traveler'),
                        "param_name" => "tab_title",
                    ],
                    [
                        "type" => "dropdown",
                        "heading" => __("Service", 'traveler'),
                        "param_name" => "tab_service",
                        'value' => apply_filters('st_mixed_search_form_tab', [
                            __('Hotel', 'traveler') => 'st_hotel',
                            __('Tour', 'traveler') => 'st_tours',
                            __('Activity', 'traveler') => 'st_activity',
                            __('Rental', 'traveler') => 'st_rental',
                            __('Car', 'traveler') => 'st_cars',
                            __('Car Transfer', 'traveler') => 'st_cartranfer',
                        ]),
                    ],
                ))
            ],
        ]
    ]);

    /* Content and image */

    vc_map([
        "name" => __("ST Overview", 'traveler'),
        "base" => "st_overview_new",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Modern Layout",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ],
            [
                "type" => "textarea",
                "heading" => __("Content", 'traveler'),
                "param_name" => "content_over",
                "description" => "",
            ],
            [
                "type" => "vc_link",
                "heading" => __("Link to", 'traveler'),
                "param_name" => "link",
                "description" => "",
            ],
        )
    ]);

    vc_map([
        'name' => __('ST Tab Service Location', 'traveler'),
        'base' => 'st_tab_service_location',
        'icon' => 'icon-st',
        'category' => 'Location',
        'params' => [
            [
                'type' => 'textfield',
                'param_name' => 'title_tab',
                'heading' => __('Title tab', 'traveler'),
                'description' => __('Enter title', 'traveler')
            ],
            [
                'type' => 'param_group',
                'heading' => esc_html__('Filter items', 'traveler'),
                'param_name' => 'service_tab',
                'value' => '',
                'params' => apply_filters('st_tab_service_group_fields', array(
                    [
                        "type" => "textfield",
                        "heading" => __("Tab title", 'traveler'),
                        "param_name" => "tab_title",
                    ],
                    [
                        "type" => "dropdown",
                        "heading" => __("Service", 'traveler'),
                        "param_name" => "tab_service",
                        'value' => apply_filters('st_mixed_search_form_tab', [
                            __('Hotel', 'traveler') => 'st_hotel',
                            __('Tour', 'traveler') => 'st_tours',
                            __('Activity', 'traveler') => 'st_activity',
                            __('Rental', 'traveler') => 'st_rental',
                            __('Car', 'traveler') => 'st_cars',
                        ]),
                    ],
                ))
            ],
            [
                'type' => 'textfield',
                'param_name' => 'posts_per_page',
                'heading' => __('Number of Items', 'traveler'),
                'description' => __('-1 for unlimited', 'traveler'),
                'std' => 8
            ],
        ]
    ]);

    vc_map([
        "name" => __("ST List posts", 'traveler'),
        "base" => "st_list_post_ccv",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Location",
        "params" => array(
            [
                "type" => "textfield",
                "heading" => __("IDs post", 'traveler'),
                "param_name" => "ids_post",
                "description" => "",
            ],
        )
    ]);



    /* Add st offer new */

    vc_map([
        'name' => __('ST Offer New', 'traveler'),
        'base' => 'st_offer_new',
        'content_element' => true,
        'icon' => 'icon-st',
        "category" => "Modern Layout",
        'params' => array(
            [
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'traveler'),
                'param_name' => 'background_image'
            ],
            [
                'type' => 'textarea_html',
                'heading' => __('Content', 'traveler'),
                'param_name' => 'content',
                'value' => ''
            ],
            [
                'type' => 'vc_link',
                'heading' => __('Link', 'traveler'),
                'param_name' => 'link'
            ],
            [
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style",
                'value' => [
                    __('Style 1', 'traveler') => 'style-1',
                    __('Style 2', 'traveler') => 'style-2',
                    __('Style 3', 'traveler') => 'style-3',
                ],
            ],
        )
    ]);

    // Mailchimp
    vc_map([
        'name' => esc_html__('ST Mailchimp', 'traveler'),
        'base' => 'st_mailchimp',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => [
            [
                'type' => 'attach_image',
                'heading' => esc_html__('Icon', 'traveler'),
                'param_name' => 'icon'
            ],
            [
                'type' => 'textfield',
                'heading' => esc_html__('Heading Title', 'traveler'),
                'param_name' => 'heading_title'
            ],
            [
                'type' => 'textarea',
                'heading' => esc_html__('Sub Title', 'traveler'),
                'param_name' => 'sub_title'
            ]
        ]
    ]);
}

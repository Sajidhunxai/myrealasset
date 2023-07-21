<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/04/2018
 * Time: 14:18 CH
 */
add_action( 'vc_before_init', 'st_map_hotel_alone_shortcodes' );

function st_map_hotel_alone_shortcodes()
{
    vc_map(array(
        'name' => esc_html__('[Hotel Single] About', 'traveler'),
        'base' => 'hotel_alone_about',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Icon and information', 'traveler'),
        'params' => array(
            array(
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1'=> array(
                        'title'=>esc_html__('Style 1','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir() .'/images/st-about/a-style-1.png',
                    ),
                    'style-2'=> array(
                        'title'=>esc_html__('Style 2','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir() . '/images/st-about/a-style-2.png',
                    )
                ),
                'w' => 'w320'
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'traveler'),
                'param_name' => 'icon',
                'description' => esc_html__('Choose a icon', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'traveler'),
                'param_name' => 'description',
                'description' => esc_html__('Enter description', 'traveler')
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__('Enter a link','traveler'),
                'param_name' => 'link',
                'description' => esc_html__('Enter a link for element', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Banner Single Room','traveler'),
        'base' => 'hotel_alone_banner_single_room',
        'description' => esc_html__('ST Banner Single Room','traveler'),
        'icon' => 'icon-st',
        'category'    => array("Hotel Single") ,
        'params' => array(
            array(
                'type'        => 'radio_image' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Style Options' , 'traveler' ) ,
                'param_name'  => 'style' ,
                'std'         => 'style-1' ,
                'value'       => array(
                    'style-1' => array(
                        'title' => esc_html__( 'Style Slide' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-banner-single-room/style-1.png' ,
                    ) ,
                    'style-2' => array(
                        'title' => esc_html__( 'Style Image' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-banner-single-room/style-2.png' ,
                    ) ,
                )
            ) ,
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('#scroll','traveler'),
                'param_name' => 'link_scroll',
                'description' => esc_html__('Enter a ID for scroll','traveler'),
                'std' => '',
                'edit_field_class' => 'vc_column vc_col-sm-12'
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Blog','traveler'),
        'base' => 'hotel_alone_blog',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('List blog', 'traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Type','traveler'),
                'param_name' => 'type',
                'value' => array(
                    esc_html__('Grid','traveler') => 'grid',
                    esc_html__('List','traveler') => 'list',
                    esc_html__('Carousel','traveler') => 'carousel',
                    esc_html__('Isotope','traveler') => 'isotope',
                ),
                'std' => 'grid'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'style',
                'value' => array(
                    esc_html__('Style 1','traveler') => 'style-1',
                    esc_html__('Style 2','traveler') => 'style-2',
                    esc_html__('Style Hotel activity','traveler') => 'style-activity',
                ),
                'std' => 'style-1',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('grid')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'carousel_style',
                'value' => array(
                    esc_html__('Style 1','traveler') => 'style-1',
                    esc_html__('Style 2','traveler') => 'style-2',
                ),
                'std' => 'style-1',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('carousel')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'isotope_style',
                'value' => array(
                    esc_html__('Style 1','traveler') => 'style-1',
                    esc_html__('Style 2','traveler') => 'style-2',
                ),
                'std' => 'style-1',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('isotope')
                )
            ),
            array(
                'type' => 'st_number',
                'admin_label' => true,
                'heading' => esc_html__('Number Post Items','traveler'),
                'param_name' => 'number_items',
                'description' => esc_html__('Enter number post items','traveler')
            ),
            array(
                'type' => 'st_checkbox',
                'heading' => esc_html__('Select Categories','traveler'),
                'param_name' => 'select_category',
                'desc' => esc_html__('Check the box to choose category','traveler'),
                'stype' => 'tax',
                'sparam' => false
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order By','traveler'),
                'param_name' => 'order_by',
                'value' => array_flip(hotel_alone_get_order_list()),
                'std' => 'ID'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order','traveler'),
                'param_name' => 'order',
                'value' => array(
                    esc_html__('Descending','traveler') => 'DESC',
                    esc_html__('Ascending','traveler') => 'ASC',
                ),
                'std' => 'DESC'
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show Load More','traveler'),
                'param_name' => 'load_more',
                'desc' => esc_html__('Choose yes to show load more button in type isotope','traveler'),
                'value' => array(
                    esc_html__('Yes' ,'traveler') => 'yes'
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('isotope')
                )
            ),
        )
    ));
    vc_map( array(
        'name'        => esc_html__( '[Hotel Single] ST Booking Room' , 'traveler' ) ,
        'base'        => 'hotel_alone_booking_room' ,
        'description' => esc_html__( 'ST Booking Room' , 'traveler' ) ,
        'icon'        => 'icon-st' ,
        'category'    => array('Hotel Single') ,
        'params'      => array(
            array(
                'type'        => 'radio_image' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Style Options' , 'traveler' ) ,
                'param_name'  => 'style' ,
                'std'         => 'style-1' ,
                'value'       => array(
                    'style-1' => array(
                        'title' => esc_html__( 'Style 1' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-booking-room/style-1.jpg' ,
                    ) ,
                    'style-2' => array(
                        'title' => esc_html__( 'Style 2' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-booking-room/style-2.jpg' ,
                    ) ,
                )
            ) ,
            array(
                'type'        => 'textfield' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Title' , 'traveler' ) ,
                'param_name'  => 'title' ,
                'description' => esc_html__( 'Enter a text for title' , 'traveler' ) ,
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2')
                )
            ) ,
            array(
                'type'        => 'textfield' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Reservation Hotline' , 'traveler' ) ,
                'param_name'  => 'phone' ,
                'description' => esc_html__( 'Reservation Hotline' , 'traveler' ) ,
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ) ,
            array(
                'type'       => 'param_group' ,
                'heading'    => esc_html__( 'Hotel Room Fields Search' , 'traveler' ) ,
                'param_name' => 'hotel_room_fields' ,
                'params'     => array(
                    array(
                        'type'        => 'textfield' ,
                        'admin_label' => true ,
                        'heading'     => esc_html__( 'Label' , 'traveler' ) ,
                        'param_name'  => 'label'
                    ) ,
                    array(
                        'type'       => 'dropdown' ,
                        'heading'    => esc_html__( 'Field Attribute' , 'traveler' ) ,
                        'param_name' => 'field_attribute' ,
                        'value'      => hotel_alone_vc_convert_array( st_hotel_alone_get_search_fields_for_element() ) ,

                    ) ,
                    array(
                        'type'       => 'dropdown' ,
                        'heading'    => esc_html__( 'Layout Normal Size' , 'traveler' ) ,
                        'param_name' => 'layout_size' ,
                        'value'      => array(
                            esc_html__( '1 column' , 'traveler' )   => '1' ,
                            esc_html__( '2 columns' , 'traveler' )  => '2' ,
                            esc_html__( '3 columns' , 'traveler' )  => '3' ,
                            esc_html__( '4 columns' , 'traveler' )  => '4' ,
                            esc_html__( '5 columns' , 'traveler' )  => '5' ,
                            esc_html__( '6 columns' , 'traveler' )  => '6' ,
                            esc_html__( '7 columns' , 'traveler' )  => '7' ,
                            esc_html__( '8 columns' , 'traveler' )  => '8' ,
                            esc_html__( '9 columns' , 'traveler' )  => '9' ,
                            esc_html__( '10 columns' , 'traveler' ) => '10' ,
                            esc_html__( '11 columns' , 'traveler' ) => '11' ,
                            esc_html__( '12 columns' , 'traveler' ) => '12' ,
                        ) ,
                        'std'        => '12'
                    ) ,
                ) ,
                'callbacks'  => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ) ,
            ) ,
        )
    ) );
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Breadcrumb','traveler'),
        'base' => 'hotel_alone_breadcrumb',
        'description' => esc_html__('ST Breadcrumb','traveler'),
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Title Source','traveler'),
                'param_name' => 'title_source',
                'description' => esc_html__('Select title source','traveler'),
                'value' => array(
                    esc_html__('Custom Title','traveler') => 'custom_title',
                    esc_html__('Post or page,... title','traveler') => 'get_title'
                ),
                'std' => 'custom_title'
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title','traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title','traveler'),
                'dependency' => array(
                    'element' => 'title_source',
                    'value' => array('custom_title')
                )
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Text Color','traveler'),
                'param_name' => 'title_color',
                'description' => esc_html__('Choose color for text','traveler'),
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('ST Clients', 'traveler'),
        'base' => 'st_clients',
        'icon' => 'icon-st',
        'category' => 'Shinetheme',
        'description' => esc_html__('List clients', 'traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('No of items', 'traveler'),
                'param_name' => 'items',
                'description' => esc_html__('Number item to display in element', 'traveler'),
                'value' => array(
                    esc_html__('3 items', 'traveler') => 3,
                    esc_html__('4 items', 'traveler') => 4,
                ),
                'std' => 4
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List Clients', 'traveler'),
                'param_name' => 'list_clients',
                'value' => '',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'admin_label' => true,
                        'heading' => esc_html__('Logo', 'traveler'),
                        'param_name' => 'logo',
                        'description' => esc_html__('Upload an image for logo', 'traveler')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link Social', 'traveler'),
                        'param_name' => 'link',
                        'description' => esc_html__('Insert a link for client', 'traveler')
                    )
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )

        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Form Search Room','traveler'),
        'base' => 'hotel_alone_form_search_room',
        'description' => esc_html__('ST Form Search Room','traveler'),
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'params' => array(
            array(
                'type' => 'textarea',
                'admin_label' => true,
                'heading' => esc_html__('Title','traveler'),
                'param_name' => 'content',
                'description' => esc_html__('Enter a text for title','traveler'),
            ),
            array(
                'type' 			=> 'st_dropdown',
                'class' 		=> '',
                'heading' => esc_html__( 'Select Hotel', 'traveler' ),
                'param_name' => 'service_id',
                'stype' => 'post_type',
                'sparam' => 'st_hotel',
                'sautocomplete' => 'yes',
                'description' => esc_html__( 'Enter List of Hotels', 'traveler' ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Hotel Room Fields Search', 'traveler'),
                'param_name' => 'hotel_room_fields',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => esc_html__('Label', 'traveler'),
                        'param_name' => 'label'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Field Attribute', 'traveler'),
                        'param_name' => 'field_attribute',
                        'value' => hotel_alone_vc_convert_array(st_hotel_alone_get_search_fields_for_element())

                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Layout Normal Size','traveler'),
                        'param_name' => 'layout_size',
                        'value' => array(
                            esc_html__('1 column','traveler') => '1',
                            esc_html__('2 columns','traveler') => '2',
                            esc_html__('3 columns','traveler') => '3',
                            esc_html__('4 columns','traveler') => '4',
                            esc_html__('5 columns','traveler') => '5',
                            esc_html__('6 columns','traveler') => '6',
                            esc_html__('7 columns','traveler') => '7',
                            esc_html__('8 columns','traveler') => '8',
                            esc_html__('9 columns','traveler') => '9',
                            esc_html__('10 columns','traveler') => '10',
                            esc_html__('11 columns','traveler') => '11',
                            esc_html__('12 columns','traveler') => '12',
                        ),
                        'std' => '12'
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ),
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Hotel Info', 'traveler'),
        'base' => 'hotel_alone_el_hotel_info',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Add info for hotel', 'traveler'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Hotel Logo', 'traveler'),
                'param_name' => 'logo',
                'description' => esc_html__('Upload an image for logo of hotel', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sub Title', 'traveler'),
                'param_name' => 'sub_title',
                'description' => esc_html__('Enter a text for sub title', 'traveler')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Hotel Stars', 'traveler'),
                'param_name' => 'star',
                'value' => array(
                    esc_html__('5 stars', 'traveler') => 5,
                    esc_html__('4 stars', 'traveler') => 4,
                    esc_html__('3 stars', 'traveler') => 3,
                    esc_html__('2 stars', 'traveler') => 2,
                    esc_html__('1 stars', 'traveler') => 1
                ),
                'std' => 5
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Reservation Hotline','traveler'),
                'param_name' => 'hotline',
                'description' => esc_html__('Reservation Hotline', 'traveler')
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'traveler'),
                'param_name' => 'description',
                'description' => esc_html__('Enter description', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('ST List Carousel Hotel Room', 'traveler'),
        'base' => 'hotel_alone_list_feature_hotel_room',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'params' => array(
            array(
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('List Style Options','traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1'=> array(
                        'title'=>esc_html__('Style 1','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir() .'/images/st-list-feature-hotel-room/style-1.jpg',
                    ),
                    'style-2'=> array(
                        'title'=>esc_html__('Style 2','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-list-feature-hotel-room/style-2.jpg',
                    ),
                    'style-3'=> array(
                        'title'=>esc_html__('Style 3','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-list-feature-hotel-room/style-3.jpg',
                    ),
                ),
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'traveler'),
                'param_name' => 'description',
                'description' => esc_html__('Enter description', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' 			=> 'st_dropdown',
                'class' 		=> '',
                'heading' => esc_html__( 'Select Hotel', 'traveler' ),
                'param_name' => 'service_id',
                'stype' => 'post_type',
                'sparam' => 'st_hotel',
                'description' => esc_html__( 'Enter List of Services', 'traveler' ),
            ),

            array(
                'type' => 'st_checkbox',
                'heading' => esc_html__('Select Categories','traveler'),
                'param_name' => 'select_category',
                'desc' => esc_html__('Check the box to choose category','traveler'),
                'stype' => 'tax',
                'sparam' => 'room_type'
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Number Items','traveler'),
                'param_name' => 'number_post',
                'description' => esc_html__('Number services', 'traveler'),
                'value' => array(
                    esc_html__('2 Item', 'traveler') => '2',
                    esc_html__('3 Item', 'traveler') => '3',
                    esc_html__('4 Item', 'traveler') => '4',
                    esc_html__('6 Item', 'traveler') => '6',
                ),
                'prefix' => esc_html__('service', 'traveler'),
                'edit_field_class' => 'vc_column vc_col-sm-6',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order By', 'traveler'),
                'param_name' => 'order_by',
                'value' => hotel_alone_vc_convert_array(hotel_alone_get_order_list()),
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'std' => 'ID'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order', 'traveler'),
                'param_name' => 'order',
                'value' => array(
                    esc_html__('ASC', 'traveler') => 'ASC',
                    esc_html__('DESC', 'traveler') => 'DESC'
                ),
                'std' => 'DESC',
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST List Offers','traveler'),
        'base' => 'hotel_alone_list_offers',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('List offers', 'traveler'),
        'params' => array(
            array(
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1'=> array(
                        'title'=>esc_html__('Style 1','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-list-offers/o-style-1.png',
                    ),
                    'style-2'=> array(
                        'title'=>esc_html__('Style 2','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-list-offers/o-style-2.png',
                    ),
                    'style-3'=> array(
                        'title'=>esc_html__('Style 3','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-list-offers/o-style-3.png',
                    )
                ),
                'w' => 'w320'
            ),

            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sub Title', 'traveler'),
                'param_name' => 'sub_title',
                'description' => esc_html__('Enter a text for sub title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'traveler'),
                'param_name' => 'description',
                'description' => esc_html__('Enter a text for description', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),

            array(
                'type' => 'param_group',
                "heading" => esc_html__("List Offer", 'traveler'),
                "param_name" => "list_offfer",
                'value' =>'',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Offer Image', 'traveler'),
                        'param_name' => 'image',
                        'description' => esc_html__('Image of this offer', 'traveler'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'traveler'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'description' => esc_html__('Name of offer', 'traveler')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Description', 'traveler'),
                        'param_name' => 'desc',
                        'description' => esc_html__('Description to this offer', 'traveler')
                    ),
                    array(
                        'type' => 'st_number',
                        'heading' => esc_html__('Price per person', 'traveler'),
                        'param_name' => 'price',
                        'min' => 0,
                        'max' => 200,
                        'prefix' => ''
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link', 'traveler'),
                        'param_name' => 'link',
                        'description' => esc_html__('Custom link of service', 'traveler')
                    )
                )
            ),

        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Related Room', 'traveler'),
        'base' => 'hotel_alone_room_related',
        'icon' => 'icon-st',
        'category' => array("Hotel Single","Single"),
        'description' => esc_html__('Related Room', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Number Items','traveler'),
                'param_name' => 'number_post',
                'description' => esc_html__('Number services', 'traveler'),
                'value' => '3',
                'prefix' => esc_html__('service', 'traveler'),
                'edit_field_class' => 'vc_column vc_col-sm-12',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Reservation Contact', 'traveler'),
        'base' => 'hotel_alone_reservation_contact',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Icon and information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Description', 'traveler'),
                'param_name' => 'description',
                'description' => esc_html__('Enter description', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Phone', 'traveler'),
                'param_name' => 'phone',
                'description' => esc_html__('Enter a phone', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Email', 'traveler'),
                'param_name' => 'email',
                'description' => esc_html__('Enter a email', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map( array(
        'name'        => esc_html__( '[Hotel Single] ST Reservation Content' , 'traveler' ) ,
        'base'        => 'hotel_alone_reservation_content' ,
        'description' => esc_html__( 'ST Reservation Content' , 'traveler' ) ,
        'icon'        => 'icon-st' ,
        'category'    => 'Hotel Single' ,
        'params'      => array(
            array(
                'type'        => 'st_dropdown' ,
                'class'       => '' ,
                'heading'     => esc_html__( 'Select Hotel' , 'traveler' ) ,
                'param_name'  => 'service_id' ,
                'stype' => 'post_type',
                'sparam' => 'st_hotel',
                'sautocomplete' => 'yes',
                'description' => esc_html__( 'Enter List of Services' , 'traveler' ) ,
            ) ,
            array(
                'type'        => 'radio_image' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Style Options' , 'traveler' ) ,
                'param_name'  => 'style' ,
                'std'         => 'style-1' ,
                'value'       => array(
                    'style-1' => array(
                        'title' => esc_html__( 'Style List' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-reservation-content/style-1.jpg' ,
                    ) ,
                    'style-2' => array(
                        'title' => esc_html__( 'Style Grid' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-reservation-content/style-2.jpg' ,
                    ) ,
                )
            ) ,
        )
    ) );
    vc_map( array(
        'name'        => esc_html__( '[Hotel Single] ST Reservation Room' , 'traveler' ) ,
        'base'        => 'hotel_alone_reservation_room' ,
        'description' => esc_html__( 'ST Reservation Room' , 'traveler' ) ,
        'icon'        => 'icon-st' ,
        'category'    => 'Hotel Single' ,
        'params'      => array(
            array(
                'type'        => 'textarea' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Title' , 'traveler' ) ,
                'param_name'  => 'content' ,
                'description' => esc_html__( 'Enter a text for title' , 'traveler' ) ,
            ) ,
            array(
                'type'        => 'st_dropdown' ,
                'class'       => '' ,
                'heading'     => esc_html__( 'Select Hotel' , 'traveler' ) ,
                'param_name'  => 'service_id' ,
                'stype' => 'post_type',
                'sparam' => 'st_hotel',
                'sautocomplete' => 'yes',
                'description' => esc_html__( 'Enter List of Services' , 'traveler' ) ,
            ) ,
            array(
                'type'       => 'param_group' ,
                'heading'    => esc_html__( 'Hotel Room Fields Search' , 'traveler' ) ,
                'param_name' => 'hotel_room_fields' ,
                'params'     => array(
                    array(
                        'type'        => 'textfield' ,
                        'admin_label' => true ,
                        'heading'     => esc_html__( 'Label' , 'traveler' ) ,
                        'param_name'  => 'label'
                    ) ,
                    array(
                        'type'       => 'dropdown' ,
                        'heading'    => esc_html__( 'Field Attribute' , 'traveler' ) ,
                        'param_name' => 'field_attribute' ,
                        'value'      => hotel_alone_vc_convert_array(st_hotel_alone_get_search_fields_for_element()),

                    ) ,
                    array(
                        'type'       => 'dropdown' ,
                        'heading'    => esc_html__( 'Layout Normal Size' , 'traveler' ) ,
                        'param_name' => 'layout_size' ,
                        'value'      => array(
                            esc_html__( '1 column' , 'traveler' )   => '1' ,
                            esc_html__( '2 columns' , 'traveler' )  => '2' ,
                            esc_html__( '3 columns' , 'traveler' )  => '3' ,
                            esc_html__( '4 columns' , 'traveler' )  => '4' ,
                            esc_html__( '5 columns' , 'traveler' )  => '5' ,
                            esc_html__( '6 columns' , 'traveler' )  => '6' ,
                            esc_html__( '7 columns' , 'traveler' )  => '7' ,
                            esc_html__( '8 columns' , 'traveler' )  => '8' ,
                            esc_html__( '9 columns' , 'traveler' )  => '9' ,
                            esc_html__( '10 columns' , 'traveler' ) => '10' ,
                            esc_html__( '11 columns' , 'traveler' ) => '11' ,
                            esc_html__( '12 columns' , 'traveler' ) => '12' ,
                        ) ,
                        'std'        => '12'
                    ) ,
                ) ,
                'callbacks'  => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ) ,
            ) ,
        )
    ) );
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Discount By Day Info', 'traveler'),
        'base' => 'hotel_alone_room_discount_by_day_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('Room Extra Service Information', 'traveler'),
        'base' => 'hotel_alone_room_extra_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room Extra Service Information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Other Facility Info', 'traveler'),
        'base' => 'hotel_alone_room_facility_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Number item/row ','traveler'),
                'param_name' => 'number_of_row',
                'value' => array(
                    esc_html__('4 Item','traveler') => '4',
                    esc_html__('3 Item','traveler') => '3',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Check In/Out Info', 'traveler'),
        'base' => 'hotel_alone_room_in_out_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Info', 'traveler'),
        'base' => 'hotel_alone_room_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single","Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type'        => 'radio_image' ,
                'admin_label' => true ,
                'heading'     => esc_html__( 'Style Options' , 'traveler' ) ,
                'param_name'  => 'style' ,
                'std'         => 'style-1' ,
                'value'       => array(
                    'style-1' => array(
                        'title' => esc_html__( 'Style 1' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-room-info/style-1.jpg' ,
                    ) ,
                    'style-2' => array(
                        'title' => esc_html__( 'Style 2' , 'traveler' ) ,
                        'image' => st_hotel_alone_load_assets_dir() . '/images/st-room-info/style-2.jpg' ,
                    ) ,
                )
            ) ,
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Meta', 'traveler'),
        'base' => 'hotel_alone_room_meta',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Meta', 'traveler'),
                'param_name' => 'meta',
                'description' => esc_html__('Select a meta', 'traveler'),
                'value' => array(
                    esc_html__('Room Description', 'traveler') => 'room_description',
                ),
                'std' => 'room_description'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Room Taxonomy Info', 'traveler'),
        'base' => 'hotel_alone_room_taxonomy_info',
        'icon' => 'icon-st',
        'category' => array("Hotel Single"),
        'description' => esc_html__('Room information', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'st_dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Choose taxonomy ','traveler'),
                'param_name' => 'choose_taxonomy',
                'stype' => 'tax',
                'sparam' => 'hotel_room',
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Number item/row ','traveler'),
                'param_name' => 'number_of_row',
                'value' => array(
                    esc_html__('4 Item','traveler') => '4',
                    esc_html__('3 Item','traveler') => '3',
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('ST Share', 'traveler'),
        'base' => 'st_share',
        'icon' => 'icon-st',
        'category' => array("Shinetheme","Single"),
        'description' => esc_html__('Share Service', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Signature', 'traveler'),
        'base' => 'hotel_alone_signature',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Create signature', 'traveler'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Signature Image', 'traveler'),
                'param_name' => 'sig_image',
                'description' => esc_html__('Upload an image', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Name', 'traveler'),
                'param_name' => 'name',
                'description' => esc_html__('Enter a name', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Position', 'traveler'),
                'param_name' => 'position',
                'description' => esc_html__('Enter position', 'traveler')
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Signature Align', 'traveler'),
                'param_name' => 'align',
                'description' => esc_html__('Select a align', 'traveler'),
                'value' => array(
                    esc_html__('Left', 'traveler') => 'left',
                    esc_html__('Center', 'traveler') => 'center'
                ),
                'std' => 'style-1'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] Slider', 'traveler'),
        'base' => 'hotel_alone_slider',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Create slider','traveler'),
        'params' => array(
            array(
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('Style Option','traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1'=> array(
                        'title'=>esc_html__('Style 1','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir() .'/images/st-slide/style-1.jpg',
                    ),
                    'style-2'=> array(
                        'title'=>esc_html__('Style 2','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-slide/style-2.jpg',
                    ),
                    'style-3'=> array(
                        'title'=>esc_html__('Style 3','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-slide/style-3.jpg',
                    ),
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title','traveler'),
                'param_name' => 'st_title',
                'description' => esc_html__('Input a text for title','traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1','style-2','style-3')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content','traveler'),
                'param_name' => 'st_content',
                'description' => esc_html__('Input a text for sub title','traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1','style-2','style-3')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sub Title','traveler'),
                'param_name' => 'st_sub_title',
                'description' => esc_html__('Input a text for sub title','traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__('Link ViewMore','traveler'),
                'param_name' => 'st_link_viewmore',
                'description' => esc_html__('Link ViewMore','traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2','style-3')
                )
            ),
            array(
                'type' => 'attach_images',
                'heading' => esc_html__('List Feature Images','traveler'),
                'param_name' => 'list_images',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1','style-2','style-3')
                )
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('#scroll','traveler'),
                'param_name' => 'link_scroll',
                'description' => esc_html__('Enter a ID for scroll','traveler'),
                'std' => '',
                'edit_field_class' => 'vc_column vc_col-sm-12',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1','style-2')
                )
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Text scroll 1','traveler'),
                'param_name' => 'text_sroll_1',
                'description' => esc_html__('Enter a text for scroll','traveler'),
                'std' => '',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2')
                )
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Text scroll 2','traveler'),
                'param_name' => 'text_sroll_2',
                'description' => esc_html__('Enter a text for scroll','traveler'),
                'std' => '',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2')
                )
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('ST Socials', 'traveler'),
        'base' => 'st_socials',
        'icon' => 'icon-st',
        'category' => 'Shinetheme',
        'description' => esc_html__('List socials', 'traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Align', 'traveler'),
                'param_name' => 'align',
                'description' => esc_html__('Select a style', 'traveler'),
                'value' => array(
                    esc_html__('Left', 'traveler') => 'text-left',
                    esc_html__('Center', 'traveler') => 'text-center',
                    esc_html__('Right', 'traveler') => 'text-right'
                ),
                'std' => 'text-left'
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show Follow us text', 'traveler'),
                'param_name' => 'follow_us',
                'value' => array(
                    esc_html__('Yes', 'traveler') => 'yes'
                )
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List Socials', 'traveler'),
                'param_name' => 'list_social',
                'value' => '',
                'params' => array(
                    array(
                        'type' => 'iconpicker',
                        'admin_label' => true,
                        'heading' => esc_html__('Icon', 'traveler'),
                        'param_name' => 'icon',
                        'description' => esc_html__('Choose a icon', 'traveler')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link Social', 'traveler'),
                        'param_name' => 'link',
                        'description' => esc_html__('Insert a link for social', 'traveler')
                    )
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )

        )
    ));
    vc_map(array(
        'name' => esc_html__('ST Special Services', 'traveler'),
        'base' => 'hotel_alone_special_services',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('List our services', 'traveler'),
        'params' => array(
            array(
                'type' => 'radio_image',
                'admin_label' => true,
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'style',
                'std' => 'style-1',
                'value' => array(
                    'style-1'=> array(
                        'title'=>esc_html__('Style 1 (carousel)','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-special-services/s-style-1.png',
                    ),
                    'style-2'=> array(
                        'title'=>esc_html__('Style 2','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-special-services/s-style-2.png',
                    ),
                    'style-3'=> array(
                        'title'=>esc_html__('Style 3','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-special-services/s-style-3.png',
                    ),
                    'style-4'=> array(
                        'title'=>esc_html__('Style 4','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-special-services/s-style-4.png',
                    ),
                    'style-5'=> array(
                        'title'=>esc_html__('Style 5','traveler'),
                        'image'=>st_hotel_alone_load_assets_dir().'/images/st-special-services/s-style-5.png',
                    ),
                ),
                'w' => 'w320'
            ),
            array(
                'type' => 'param_group',
                "heading" => esc_html__("List Services", 'traveler'),
                "param_name" => "list_style_1",
                'value' =>'',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Service Image', 'traveler'),
                        'param_name' => 'image',
                        'description' => esc_html__('Image of this service', 'traveler'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'traveler'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'description' => esc_html__('Name of service', 'traveler')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Description', 'traveler'),
                        'param_name' => 'desc',
                        'description' => esc_html__('Description to this service', 'traveler')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link', 'traveler'),
                        'param_name' => 'link',
                        'description' => esc_html__('Custom link of service', 'traveler')
                    )
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )

            ),
            array(
                'type' => 'param_group',
                "heading" => esc_html__("List Services", 'traveler'),
                "param_name" => "list_style_2",
                'value' =>'',
                'params' => array(
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__('Icon', 'traveler'),
                        'param_name' => 'icon',
                        'description' => esc_html__('Choose a icon', 'traveler')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Service Image', 'traveler'),
                        'param_name' => 'image',
                        'description' => esc_html__('Image of this service', 'traveler'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'traveler'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'description' => esc_html__('Name of service', 'traveler')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Description', 'traveler'),
                        'param_name' => 'desc',
                        'description' => esc_html__('Description to this service', 'traveler')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link', 'traveler'),
                        'param_name' => 'link',
                        'description' => esc_html__('Custom link of service', 'traveler')
                    )
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2', 'style-3', 'style-4', 'style-5')
                )

            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('[Hotel Single] ST Testimonials', 'traveler'),
        'base' => 'hotel_alone_testimonials',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Customer review', 'traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Style', 'traveler'),
                'param_name' => 'style',
                'description' => esc_html__('Select a style', 'traveler'),
                'value' => array(
                    esc_html__('Style 1 (full width)', 'traveler') => 'style-1',
                    esc_html__('Style 2 (small)', 'traveler') => 'style-2'
                ),
                'std' => 'style-1'
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Show Navigation', 'traveler'),
                'param_name' => 'show_nav',
                'description' => esc_html__('Show navigation for slide','traveler'),
                'value' => array(
                    esc_html__('Yes', 'traveler') => 1,
                    esc_html__('No', 'traveler') => 0
                ),
                'std' => 1
            ),
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Show Pagination', 'traveler'),
                'param_name' => 'show_pagi',
                'description' => esc_html__('Show pagination for slide','traveler'),
                'value' => array(
                    esc_html__('Yes', 'traveler') => 1,
                    esc_html__('No', 'traveler') => 0
                ),
                'std' => 1
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Version Style', 'traveler'),
                'param_name' => 'v_style',
                'value' => array(
                    esc_html__('Light', 'traveler') => 'light',
                    esc_html__('Dark', 'traveler') => 'dark'
                ),
                'std' => 'light',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List Reviews', 'traveler'),
                'param_name' => 'lists',
                'value' => '',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'admin_label' => true,
                        'heading' => esc_html__('Name', 'traveler'),
                        'param_name' => 'name',
                        'description' => esc_html__('Name of customer', 'traveler')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Position', 'traveler'),
                        'param_name' => 'position',
                        'description' => esc_html__('Position of customer', 'traveler')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Avatar', 'traveler'),
                        'param_name' => 'avatar',
                        'description' => esc_html__('Upload avatar for customer', 'traveler')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Content Review', 'traveler'),
                        'param_name' => 'content_review',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Review Stars','traveler'),
                        'param_name' => 'stars',
                        'value' => array(
                            esc_html__('5 stars', 'traveler') => 5,
                            esc_html__('4 stars', 'traveler') => 4,
                            esc_html__('3 stars', 'traveler') => 3,
                            esc_html__('2 stars', 'traveler') => 2,
                            esc_html__('1 stars', 'traveler') => 1
                        ),
                        'std' => 5
                    )
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )

        )
    ));
    vc_map(array(
        'base' => 'hotel_alone_title',
        'name' => esc_html__('ST Title', 'traveler'),
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Customize text', 'traveler'),
        'params' => array(
            array(
                'type' => 'textarea',
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'title',
                'admin_label' => true,
                'description' => esc_html__('Enter a text for title', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sub Title', 'traveler'),
                'param_name' => 'sub_title',
                'description' => esc_html__('Enter a sub title', 'traveler')
            ),
            array(
                'type' => 'vc_link',
                'heading' => esc_html__('Title Link', 'traveler'),
                'param_name' => 'title_link'
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show Separator', 'traveler'),
                'param_name' => 'separator',
                'value' => array(
                    esc_html__('Yes', 'traveler') => 'yes'
                ),
                'std' => 'yes'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Heading', 'traveler'),
                'param_name' => 'heading',
                'std' => 'h3',
                'value' => array(
                    esc_html__('Heading 1', 'traveler') => 'h1',
                    esc_html__('Heading 2', 'traveler') => 'h2',
                    esc_html__('Heading 3', 'traveler') => 'h3',
                    esc_html__('Heading 4', 'traveler') => 'h4',
                    esc_html__('Heading 5', 'traveler') => 'h5',
                    esc_html__('Heading 6', 'traveler') => 'h6'
                )
            ),
            array(
                'type' => 'st_number',
                'heading' => esc_html__('Font Size(title)', 'traveler'),
                'param_name' => 'title_font_size',
                'min' => 1,
                'max' => 200,
                'prefix' => 'px',
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
            array(
                'type' => 'st_number',
                'heading' => esc_html__('Line Height(title)', 'traveler'),
                'param_name' => 'title_line_height',
                'min' => 1,
                'max' => 200,
                'prefix' => 'px',
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Font Weight(title)', 'traveler'),
                'param_name' => 'title_font_weight',
                'std' => '400',
                'value' => array(
                    esc_html__('100' ,'traveler') => 100,
                    esc_html__('200' ,'traveler') => 200,
                    esc_html__('300' ,'traveler') => 300,
                    esc_html__('400' ,'traveler') => 400,
                    esc_html__('500' ,'traveler') => 500,
                    esc_html__('600' ,'traveler') => 600,
                    esc_html__('700' ,'traveler') => 700,
                    esc_html__('800' ,'traveler') => 800,
                    esc_html__('900' ,'traveler') => 900,
                    esc_html__('Bold' ,'traveler') => 'bold',
                    esc_html__('Normal' ,'traveler') => 'normal',
                ),
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Text Align', 'traveler'),
                'param_name' => 'text_align',
                'std' => 'center',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'value' => array(
                    esc_html__('Left' ,'traveler') => 'left',
                    esc_html__('Center' ,'traveler') => 'center',
                    esc_html__('Right' ,'traveler') => 'right',
                )
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'traveler'),
                'param_name' => 'title_color',
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Font Style (title)', 'traveler'),
                'param_name' => 'title_font_style',
                'std' => 'normal',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'value' => array(
                    esc_html__('Normal' ,'traveler') => 'normal',
                    esc_html__('Italic' ,'traveler') => 'italic',
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Title Font', 'traveler'),
                'param_name' => 'title_font',
                'value' => array(
                    esc_html__('Playfair Display', 'traveler') => 'playfair',
                    esc_html__('Lato', 'traveler') => 'st_lato',
                    esc_html__('AmaticSC', 'traveler') => 'st_amatic'
                )
            ),
            array(
                'type' => 'st_number',
                'heading' => esc_html__('Margin Bottom', 'traveler'),
                'param_name' => 'm_bottom',
                'value' => 0,
                'min' => 0,
                'prefix' => 'px',
                'edit_field_class' => 'vc_column vc_col-sm-6'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            ),
        )
    ));
    vc_map(array(
        'name' => esc_html__('ST Video', 'traveler'),
        'base' => 'st_video',
        'icon' => 'icon-st',
        'category' => 'Hotel Single',
        'description' => esc_html__('Play video in page', 'traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Style', 'traveler'),
                'param_name' => 'style',
                'description' => esc_html__('Select a style', 'traveler'),
                'value' => array(
                    esc_html__('Style 1', 'traveler') => 'style-1',
                    esc_html__('Style 2 (No Caption)', 'traveler') => 'style-2'
                ),
                'std' => 'style-1'
            ),
            array(
                'type' => 'textarea_html',
                'admin_label' => true,
                'heading' => esc_html__('Title', 'traveler'),
                'param_name' => 'content',
                'description' => esc_html__('Enter a text for title', 'traveler'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Youtube ID','traveler'),
                'param_name' => 'link',
                'description' => esc_html__('Enter a video id for element. Ex: gdXDJ9TIcZQ', 'traveler')
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Background Image', 'traveler'),
                'param_name' => 'background_image'
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'traveler'),
                'param_name' => 'title_color',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Label Color', 'traveler'),
                'param_name' => 'label_color',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Overlay', 'traveler'),
                'param_name' => 'overlay',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Enable Label Text', 'traveler'),
                'param_name' => 'enable_label',
                'value' => array(
                    esc_html__('Yes', 'traveler') => 'yes'
                ),
                'std' => 'yes',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-1')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Height Element (px)', 'traveler'),
                'param_name' => 'height',
                'description' => esc_html__('Input height for element','traveler'),
                'value' => '800'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            )
        )
    ));
    vc_map( array(
        'name'        => esc_html__( 'ST Weather', 'traveler' ),
        'base'        => 'st_weather',
        'icon'        => 'icon-st',
        'category'    => 'Shinetheme',
        'description' => esc_html__( 'Icon and information', 'traveler' ),
        'params'      => array(
            array(
                'param_name' => 'location_id',
                'heading'    => esc_html__( 'Location', 'traveler' ),
                'type'       => 'st_dropdown',
                'stype'=>'post_type',
                'sparam'=>'location'

            ),
            array(
                'type'       => 'checkbox',
                'heading'    => esc_html__( 'Show time now', 'traveler' ),
                'param_name' => 'show_time',
                'value'      => array(
                    esc_html__( 'Yes', 'traveler' ) => 'yes'
                ),
                'std'        => ''
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Extra Class', 'traveler' ),
                'param_name'  => 'extra_class',
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler' )
            )
        )
    ) );
}

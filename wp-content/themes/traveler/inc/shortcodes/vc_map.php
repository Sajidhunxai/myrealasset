<?php
/**
 * Created by PhpStorm.
 * User: Dannie
 * Date: 8/30/2018
 * Time: 2:01 PM
 */
add_action( 'vc_before_init', 'st_map_general_shortcodes' );
add_action( 'vc_before_init', 'st_map_tour_shortcodes' );
//add_action( 'vc_before_init', 'st_map_rental_shortcodes' );
add_action( 'vc_before_init', 'st_map_rental_room_shortcodes' );
add_action( 'vc_before_init', 'st_map_hotel_shortcodes' );
add_action( 'vc_before_init', 'st_map_car_shortcodes' );
add_action( 'vc_before_init', 'st_map_activity_shortcodes' );
add_action( 'vc_before_init', 'st_map_single_hotel' );



function st_map_activity_shortcodes()
{
    if(!st_check_service_available( 'st_activity' )) return;

    vc_map(
        array(
            'name' => __("ST Activity Thumbnail", 'traveler'),
            'base' => 'st_thumbnail_activity',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Booking Form", 'traveler'),
            'base' => 'st_form_book',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Excerpt", 'traveler'),
            'base' => 'st_excerpt_activity',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Content", 'traveler'),
            'base' => 'st_activity_content',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Detailed Activity Map", 'traveler'),
            'base' => 'st_activity_detail_map',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => true,
            'params'=>array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Range" , 'traveler' ) ,
                    "param_name"  => "range" ,
                    "description" => "Km" ,
                    "value"       => "20" ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Number" , 'traveler' ) ,
                    "param_name"  => "number" ,
                    "description" => "" ,
                    "value"       => "12" ,
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Show Circle" , 'traveler' ) ,
                    "param_name"  => "show_circle" ,
                    "description" => "" ,
                    "value"       => array(
                        __( "No" , 'traveler' )  => "no" ,
                        __( "Yes" , 'traveler' ) => "yes"
                    ) ,
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Review Summary", 'traveler'),
            'base' => 'st_activity_detail_review_summary',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Detailed Activity Review", 'traveler'),
            'base' => 'st_activity_detail_review_detail',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Review", 'traveler'),
            'base' => 'st_activity_review',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => true,
            'params'=>array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Title" , 'traveler' ) ,
                    "param_name"  => "title" ,
                    "description" => "" ,
                    "value"       => "",
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Font Size" , 'traveler' ) ,
                    "param_name"  => "font_size" ,
                    "description" => "" ,
                    "value"       => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ),
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Video", 'traveler'),
            'base' => 'st_activity_video',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Activity Nearby", 'traveler'),
            'base' => 'st_activity_nearby',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Activity',
            'show_settings_on_create' => true,
            'params'=>array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Title" , 'traveler' ) ,
                    "param_name"  => "title" ,
                    "description" => "" ,
                    "value"       => "",
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Font Size" , 'traveler' ) ,
                    "param_name"  => "font_size" ,
                    "description" => "" ,
                    "value"       => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ),
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Activity Show Discount' , 'traveler' ) ,
            'base'                    => 'st_activity_show_discount' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Activity' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );


}

function st_map_car_shortcodes()
{
    if(!st_check_service_available( 'st_cars' )) return;
    vc_map(
        array(
            'name'                    => __( "ST Car Thumbnail" , 'traveler' ) ,
            'base'                    => 'st_thumbnail_cars' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Car Excerpt" , 'traveler' ) ,
            'base'                    => 'st_excerpt_cars' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'            => __( "ST Detailed Car Location" , 'traveler' ) ,
            'base'            => 'st_detail_date_location_cars' ,
            'content_element' => true ,
            'icon'            => 'icon-st' ,
            'category'        => 'Car' ,
            'params'          => array(
                array(
                    'type'       => 'textfield' ,
                    'heading'    => __( 'Drop Off' , 'traveler' ) ,
                    'param_name' => 'drop-off' ,
                    'value'      => ''
                ) ,
                array(
                    'type'       => 'textfield' ,
                    'heading'    => __( 'Pick Up' , 'traveler' ) ,
                    'param_name' => 'pick-up' ,
                    'value'      => ''
                ) ,
                array(
                    'type'       => 'textfield' ,
                    'heading'    => __( 'Location ID Drop Off' , 'traveler' ) ,
                    'param_name' => 'location_id_drop_off' ,
                    'value'      => ''
                ) ,
                array(
                    'type'       => 'textfield' ,
                    'heading'    => __( 'Location ID Pick Up' , 'traveler' ) ,
                    'param_name' => 'location_id_pick_up' ,
                    'value'      => ''
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Car Video" , 'traveler' ) ,
            'base'                    => 'st_car_video' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Car - Write Review Form" , 'traveler' ) ,
            'base'                    => 'st_car_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Detailed Car Map" , 'traveler' ) ,
            'base'                    => 'st_cars_detail_map' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Range" , 'traveler' ) ,
                    "param_name"  => "range" ,
                    "description" => "Km" ,
                    "value"       => "20" ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Number" , 'traveler' ) ,
                    "param_name"  => "number" ,
                    "description" => "" ,
                    "value"       => "12" ,
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Show Circle" , 'traveler' ) ,
                    "param_name"  => "show_circle" ,
                    "description" => "" ,
                    "value"       => array(
                        __( "No" , 'traveler' )  => "no" ,
                        __( "Yes" , 'traveler' ) => "yes"
                    ) ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Detailed Car Review' , 'traveler' ) ,
            'base'                    => 'st_car_detail_review_detail' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Car  detail review summary" , 'traveler' ) ,
            'base'                    => 'st_car_detail_review_summary' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Car Show Discount' , 'traveler' ) ,
            'base'                    => 'st_car_show_discount' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Car Show Distance' , 'traveler' ) ,
            'base'                    => 'st_car_show_distance' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Car' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map( array(
        "name"            => __( "ST Sum of Car Transfer Search Results" , 'traveler' ) ,
        "base"            => "st_search_car_transfer_title" ,
        "content_element" => true ,
        "icon"            => "icon-st" ,
        "category"        => "Transfer" ,
        "params"          => array(
            array(
                "type"        => "dropdown" ,
                "holder"      => "div" ,
                "heading"     => __( "Search Modal" , 'traveler' ) ,
                "param_name"  => "search_modal" ,
                "description" => "" ,
                "value"       => array(
                    __( '--Select--' , 'traveler' ) => '' ,
                    __( 'Yes' , 'traveler' )        => '1' ,
                    __( 'No' , 'traveler' )         => '0' ,
                ) ,
            )
        )
    ) );


}
function st_map_general_shortcodes()
{
    vc_map(
        array(
            'name'                    => __( "ST Post Data" , 'traveler' ) ,
            'base'                    => 'st_post_data' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Shinetheme' ,
            'show_settings_on_create' => true ,
            "params"                  => array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Title" , 'traveler' ) ,
                    "param_name"  => "title" ,
                    "description" => "" ,
                    "value"       => "",
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Font Size" , 'traveler' ) ,
                    "param_name"  => "font_size" ,
                    "description" => "" ,
                    "value"       => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ),
                    'edit_field_class'=>'vc_col-sm-6',
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Data Type" , 'traveler' ) ,
                    "param_name"  => "field" ,
                    "description" => "" ,
                    "value"       => array(
                        __('--Select--','traveler')=>'',
                        __( "Title" , 'traveler' )   => 'title' ,
                        __( "Content" , 'traveler' ) => 'content' ,
                        __( "Excerpt" , 'traveler' ) => 'excerpt' ,
                        __( "Thumbnail" , 'traveler' ) => 'thumbnail' ,
                    )
                ) ,

                array(
                    'type'        => 'dropdown',
                    'holder'      => "div" ,
                    'heading'     => __("Thumbnail size " , 'traveler'),
                    'param_name'  => "thumb_size",
                    'description' => "",
                    "value"       => array(
                        __('--Select--','traveler')=>'',
                        __( "Thumbnail" , 'traveler' ) => 'thumbnail' ,
                        __( "Medium" , 'traveler' ) => 'medium' ,
                        __( "Large" , 'traveler' ) => 'large' ,
                        __( "Full" , 'traveler' ) => 'full' ,
                    ),
                    'dependency'    => array(
                        'element'   => "field",
                        'value'     => 'thumbnail'
                    )
                ),

            ) ,
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Partner Info" , 'traveler' ) ,
            'base'                    => 'st_partner_info' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => __('Shinetheme', 'traveler') ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Partner Average Rating" , 'traveler' ) ,
            'base'                    => 'st_partner_average_rating' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => __('Shinetheme', 'traveler') ,
            'params'=>array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Partner Contact Form" , 'traveler' ) ,
            'base'                    => 'st_partner_contact_form' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => __('Shinetheme', 'traveler') ,
            'params'=>array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Partner List Services" , 'traveler' ) ,
            'base'                    => 'st_partner_list_service' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => __('Shinetheme', 'traveler') ,
            'params'=>array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Post per page of service" , 'traveler' ) ,
                    "param_name"       => "post_per_page_service" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Post per page of review" , 'traveler' ) ,
                    "param_name"       => "post_per_page_review" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
            )
        )
    );

    $list_tabs = array(
        esc_html__('All') => 'all',
        esc_html__('Avatar') => 'avatar',
        esc_html__('Email') => 'email',
        esc_html__('Phone') => 'phone',
        esc_html__('Email PayPal') => 'email_paypal',
        esc_html__('Home Airport') => 'home_airport',
        esc_html__('Address') => 'address'
    );
    vc_map(
        array(
            'name'                    => __( "ST Partner Info (Single Post)" , 'traveler' ) ,
            'base'                    => 'st_partner_info_in_post' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => __('Shinetheme', 'traveler') ,
            'params'=>array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ),
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Avatar type" , 'traveler' ) ,
                    "param_name"       => "avatar_type" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "Square" , 'traveler' ) => 'square' ,
                        __( "Circle" , 'traveler' ) => 'circle' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Layout" , 'traveler' ) ,
                    "param_name"       => "format_column" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "1 Column" , 'traveler' ) => '1' ,
                        __( "2 Column" , 'traveler' ) => '2' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    'type' => 'checkbox',
                    'admin_label' => true,
                    'heading' => __('Select Information Display', 'traveler'),
                    'param_name' => 'display_info',
                    'description' => __('Please choose information to display in page', 'traveler'),
                    'value' => $list_tabs,
                    'std' => 'all'
                )
            )
        )
    );
    vc_map(array(
        "name" => __("Custom menu", 'traveler'),
        "base" => "st_custom_menu",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Content",
        'show_settings_on_create' => true,
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "st_dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "menu",
                'stype' => 'list_terms',
                'sparam' => 'nav_menu',
            ),
        )
    ));
    vc_map(array(
        'name' => __('ST Cancellation Data', 'traveler'),
        'base' => 'st_cancellation',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Rental',
        'show_settings_on_create' => true,
        'params' => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Font Size", 'traveler'),
                "param_name" => "font_size",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __("H1", 'traveler') => '1',
                    __("H2", 'traveler') => '2',
                    __("H3", 'traveler') => '3',
                    __("H4", 'traveler') => '4',
                    __("H5", 'traveler') => '5',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));

    vc_map(array(
        'name' => esc_html__('[Ajax] ST Flight Search Result', 'traveler'),
        'base' => 'st_flight_search_results_ajax',
        'icon' => 'icon-st',
        'category' => esc_html__('Flights', 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class'
            )
        )
    ));
}

function st_map_hotel_shortcodes()
{
    if(!st_check_service_available( 'st_hotel' )) return;
    vc_map(array(
        'name'                    => __('ST Hotel Room Header','traveler'),
        'base'                    => 'st_hotel_room_header',
        'content_element'         => true,
        'icon'                    => 'icon-st',
        'category'                => 'Hotel',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));
    vc_map(array(
        'name' => __('Hotel Room Facility', 'traveler'),
        'base' => 'st_hotel_room_facility',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => true,
        'params' => array(
            array(
                'type' => 'st_checkbox',
                'heading' => __('Choose taxonomies', 'traveler'),
                'param_name' => 'choose_taxonomies',
                'description' => __('Will be shown in layout', 'traveler'),
                'stype' => 'list_tax',
                'sparam' => 'hotel_room'
            )
        )
    ));
    vc_map(array(
        'name' => __('Hotel Room Description', 'traveler'),
        'base' => 'st_hotel_room_description',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => true,
        'title'	=>__('Description' , 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title',
                'description' => __('Title in layout', 'traveler'),
            )
        )
    ));

    vc_map(array(
        'name' => __('Hotel Room Amenities', 'traveler'),
        'base' => 'st_hotel_room_amenities',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => true,
        'title'	=>__('Amenities' , 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title',
                'description' => __('Title in layout', 'traveler'),
            )
        )
    ));

    vc_map(array(
        'name' => __('Hotel Room Space', 'traveler'),
        'base' => 'st_hotel_room_space',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => true,
        'title'	=>__('The Space' , 'traveler'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'traveler'),
                'param_name' => 'title',
                'description' => __('Title in layout', 'traveler'),
            )
        )
    ));

    vc_map(array(
        'name' => __('Hotel Room Content', 'traveler'),
        'base' => 'st_hotel_room_content',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map( array(
        "name" => __("ST Hotel Room Gallery", 'traveler'),
        "base" => "st_hotel_room_gallery",
        "content_element" => true,
        "icon" => "icon-st",
        "category"=>'Hotel',
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style",
                "description" =>"",
                "value" => array(
                    __('--Select--','traveler')=>'',
                    __('Slide','traveler')=>'slide',
                    __('Grid','traveler')=>'grid',
                ),
            )
        )
    ) );
    vc_map(array(
        'name' => __('ST Hotel Room Sidebar','traveler'),
        'base' => 'st_hotel_room_sidebar',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show sidebar?', 'traveler'),
                'param_name' => 'show_sidebar',
                'value' => array(
                    esc_html__( '---- Select ----', 'traveler' ) => '',
                    esc_html__( 'Fixed on Top', 'traveler' ) => 'fixed_top',
                    esc_html__( 'Scroll', 'traveler' ) => 'scroll',
                ),
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map(array(
        'name' => __('ST Room Hotel Review','traveler'),
        'base' => 'st_hotel_room_review',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map(array(
        'name' => __('ST Room Hotel Calendar','traveler'),
        'base' => 'st_hotel_room_calendar',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Hotel',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map(
        array(
            'name'                    => __( "ST Hotel Header" , 'traveler' ) ,
            'base'                    => 'st_hotel_header' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show Location ?", 'traveler'),
                    "param_name" => "is_location",
                    "description" =>"",
                    "value" => array(
                        __('--Select--','traveler')=>'',
                        __('Yes','traveler')=>'1',
                        __('No','traveler')=>'2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show contact", 'traveler'),
                    "param_name" => "is_contact",
                    "description" =>"",
                    "value" => array(
                        __('--Select--','traveler')=>'',
                        __('Yes','traveler')=>'1',
                        __('No','traveler')=>'2',
                    ),
                ),
            )
        )
    );

    vc_map(
        array(
            'name'            => __( "ST Hotel Star" , 'traveler' ) ,
            'base'            => 'st_hotel_star' ,
            'content_element' => true ,
            'icon'            => 'icon-st' ,
            'category'        => 'Hotel' ,
            'params'          => array(
                array(
                    "type"        => "textfield" ,
                    "heading"     => __( "Title" , 'traveler' ) ,
                    "param_name"  => "title" ,
                    'admin_label' => true ,
                    'std'         => 'Hotel Star'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Hotel Video' , 'traveler' ) ,
            'base'                    => 'st_hotel_video' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'            => __( 'ST Hotel Price' , 'traveler' ) ,
            'base'            => 'st_hotel_price' ,
            'icon'            => 'icon-st' ,
            'category'        => 'Hotel' ,
            "content_element" => true ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'            => __( 'ST Hotel Policy' , 'traveler' ) ,
            'base'            => 'st_hotel_policy' ,
            'icon'            => 'icon-st' ,
            'category'        => 'Hotel' ,
            "content_element" => true ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'            => __( 'ST Hotel Logo' , 'traveler' ) ,
            'base'            => 'st_hotel_logo' ,
            'content_element' => true ,
            'icon'            => 'icon-st' ,
            'category'        => 'Hotel' ,
            'params'          => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    'type'       => 'dropdown' ,
                    'heading'    => __( 'Thumbnail Size' , 'traveler' ) ,
                    'param_name' => 'thumbnail_size' ,
                    'value'      => array(
                        'Full'      => 'full' ,
                        'Large'     => 'large' ,
                        'Medium'    => 'medium' ,
                        'Thumbnail' => 'thumbnail'
                    )
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Add Hotel Review' , 'traveler' ) ,
            'base'                    => 'st_hotel_add_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Hotel Nearby' , 'traveler' ) ,
            'base'                    => 'st_hotel_nearby' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    'type' => 'dropdown',
                    'admin_label' => true,
                    'heading' => esc_html__('Style', 'traveler'),
                    'param_name' => 'style',
                    'value' => array(
                        esc_html__('Style 1', 'traveler') => 'style-1',
                        esc_html__('Style 2', 'traveler') => 'style-2'
                    ),
                    'std' => 'style-1'
                ),
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __( '--Select--' , 'traveler' ) => '' ,
                        __( "H1" , 'traveler' )         => '1' ,
                        __( "H2" , 'traveler' )         => '2' ,
                        __( "H3" , 'traveler' )         => '3' ,
                        __( "H4" , 'traveler' )         => '4' ,
                        __( "H5" , 'traveler' )         => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Hotel Review' , 'traveler' ) ,
            'base'                    => 'st_hotel_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __( '--Select--' , 'traveler' ) => '' ,
                        __( "H1" , 'traveler' )         => '1' ,
                        __( "H2" , 'traveler' )         => '2' ,
                        __( "H3" , 'traveler' )         => '3' ,
                        __( "H4" , 'traveler' )         => '4' ,
                        __( "H5" , 'traveler' )         => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Detailed List of Hotel Rooms' , 'traveler' ) ,
            'base'                    => 'st_hotel_detail_list_rooms' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'            => __( 'ST Detailed Hotel Card Accept' , 'traveler' ) ,
            'base'            => 'st_hotel_detail_card_accept' ,
            'content_element' => true ,
            'icon'            => 'icon-st' ,
            'category'        => 'Hotel' ,
            "params"          => array(
                // add params same as with any other content element
                array(
                    "type"        => "textfield" ,
                    "heading"     => __( "Title" , 'traveler' ) ,
                    "param_name"  => "title" ,
                    "description" => "" ,
                ) ,
            )
        )
    );


    vc_map(
        array(
            'name'                    => __( 'ST Hotel Rooms Available' , 'traveler' ) ,
            'base'                    => 'st_hotel_detail_search_room' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "admin_label"           => true ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "admin_label"           => true ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __( '--Select--' , 'traveler' ) => '' ,
                        __( "H1" , 'traveler' )         => '1' ,
                        __( "H2" , 'traveler' )         => '2' ,
                        __( "H3" , 'traveler' )         => '3' ,
                        __( "H4" , 'traveler' )         => '4' ,
                        __( "H5" , 'traveler' )         => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "heading"          => __( "Style" , 'traveler' ) ,
                    "param_name"       => "style" ,
                    "description"      => "" ,
                    "value"            => array(
                        __( "Horizontal" , 'traveler' )         => 'horizon' ,
                        __( "Vertical" , 'traveler' )         => 'vertical' ,
                        __( "Vertical 2" , 'traveler' )         => 'style_3' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Detailed Hotel Review' , 'traveler' ) ,
            'base'                    => 'st_hotel_detail_review_detail' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Hotel Review Summary' , 'traveler' ) ,
            'base'                    => 'st_hotel_detail_review_summary' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Detailed Hotel Map' , 'traveler' ) ,
            'base'                    => 'st_hotel_detail_map' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Range" , 'traveler' ) ,
                    "param_name"  => "range" ,
                    "description" => "Km" ,
                    "value"       => "20" ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Number" , 'traveler' ) ,
                    "param_name"  => "number" ,
                    "description" => "" ,
                    "value"       => "12" ,
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Show Circle" , 'traveler' ) ,
                    "param_name"  => "show_circle" ,
                    "description" => "" ,
                    "value"       => array(
                        __("No",'traveler')=>"no",
                        __("Yes",'traveler')=>"yes"
                    ) ,
                ) ,
            )
        )
    );

    vc_map(array(
        'name' => esc_html__('ST Hotel Map And Gallery','traveler'),
        'base' => 'st_hotel_map_gallery',
        'category' => '[ST] Single Hotel',
        'icon' => 'icon-st',
        'description' => esc_html__('Display map and gallery in hotel single','traveler'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Style','traveler'),
                'param_name' => 'style',
                'description' => esc_html__('Select a style','traveler'),
                'value' => array(
                    esc_html__('Full Map', 'traveler') => 'full_map',
                    esc_html__('Half Map', 'traveler') => 'half_map'
                ),
                'std' => 'full_map',
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'heading' => esc_html__('Number Image','traveler'),
                'param_name' => 'num_image',
                'description' => esc_html__('Max image for gallery','traveler'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Map Style', 'traveler'),
                'param_name' => 'map_style',
                'description' => esc_html__('Select a style for map', 'traveler'),
                'value' => array(
                    esc_html__('Normal', 'traveler') => 'style_normal',
                    esc_html__('Midnight', 'traveler') => 'style_midnight',
                    esc_html__('Icy Blue', 'traveler') => 'style_icy_blue',
                    esc_html__('Family Fest', 'traveler') => 'style_family_fest',
                    esc_html__('Open Dark', 'traveler') => 'style_open_dark',
                    esc_html__('Riverside', 'traveler') => 'style_riverside',
                    esc_html__('Ozan', 'traveler') => 'style_ozan'
                ),
                'std' => 'style_icy_blue'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'traveler'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'traveler')
            ),
        )
    ));

    vc_map( array(
        "name"            => esc_html__( "ST Hotel Title - Address" , 'traveler' ) ,
        "base"            => "st_hotel_title_address" ,
        "icon"            => "icon-st" ,
        "category"        => '[ST] Single Hotel',
        'content_element'         => true ,
        'description' => esc_html__('Display title and address', 'traveler'),
        "params"          => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Content Align','oceaus'),
                'param_name' => 'align',
                'description' => esc_html__('Select align content','oceaus'),
                'value' => array(
                    esc_html__('Center','oceaus') => 'text-center',
                    esc_html__('Left','oceaus') => 'text-left'
                )
            ),
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );

    vc_map(array(
        'name' => esc_html__('ST Hotel Review Score List','oceaus'),
        'base' => 'st_hotel_review_score_list',
        'category' => '[ST] Single Hotel',
        'icon' => 'icon-st',
        'description' => esc_html__('Display list reviews score','oceaus'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'oceaus'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'oceaus')
            ),
        )
    ));

    vc_map( array(
        "name"            => esc_html__( "ST Hotel Tabs Content" , 'traveler' ) ,
        "base"            => "st_hotel_tabs_content" ,
        "icon"            => "icon-st" ,
        "category"        => '[ST] Single Hotel',
        'content_element'         => true ,
        'description' => esc_html__('Display tabs content', 'traveler'),
        "params"          => array(
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Display Tabs', 'traveler'),
                'param_name' => 'display_tabs',
                'description' => esc_html__('Select tabs to show in single', 'traveler'),
                'value' => array(
                    esc_html__('Overview', 'traveler') => 'overview',
                    esc_html__('Facilities', 'traveler') => 'facilities',
                    esc_html__('Policies & FAQ', 'traveler') => 'policies_fqa',
                    esc_html__('Reviews', 'traveler') => 'reviews',
                    esc_html__('Gallery', 'traveler') => 'gallery',
                    esc_html__('Check Availability', 'traveler') => 'check_availability',
                ),
                'std' => 'overview,facilities,policies_fqa,reviews,gallery,check_availability'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Tab Align','oceaus'),
                'param_name' => 'tab_align',
                'value' => array(
                    esc_html__('Center','oceaus') => '',
                    esc_html__('Left','oceaus') => 'text-left'
                ),
                'std' => ''
            ),
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );

    vc_map(array(
        'name' => esc_html__('ST Information','oceaus'),
        'base' => 'st_hotel_more_info',
        'category' => array('Shinetheme','[ST] Single Hotel'),
        'icon' => 'icon-st',
        'description' => esc_html__('More information for accommodation single','oceaus'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'admin_label' => true,
                'heading' => esc_html__('Style','oceaus'),
                'param_name' => 'style',
                'value' => array(
                    esc_html__('Normal','oceaus') => 'style-1',
                    esc_html__('More Icon','oceaus') => 'style-2'
                )
            ),
            array(
                "type" => "iconpicker",
                "heading" => esc_html__("Icon", 'oceaus'),
                "param_name" => "icon",
                "description" => esc_html__("Icon", 'oceaus'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style-2')
                )
            ),
            array(
                'type' => 'textfield',
                'admin_label' => true,
                'param_name' => 'title',
                'heading' => esc_html__('Title','oceaus')
            ),
            array(
                'type' => 'textarea_html',
                'param_name' => 'content',
                'heading' => esc_html__('Content','oceaus')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class', 'oceaus'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'oceaus')
            ),
        )
    ));

    vc_map(
        array(
            'name'                    => __( "ST Hotel Share" , 'traveler' ) ,
            'base'                    => 'st_hotel_share' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Hotel' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra Class', 'traveler'),
                    'param_name' => 'extra_class'
                )
            )
        )
    );

    vc_map( array(
        "name"            => esc_html__( "ST Hotel Contact Info" , 'traveler' ) ,
        "base"            => "st_hotel_contact_info" ,
        "icon"            => "icon-st" ,
        "category"        => '[ST] Single Hotel',
        'content_element'         => true ,
        'description' => esc_html__('Display Contact Info', 'traveler'),
        "params"          => array(
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );
    

}
function st_map_tour_shortcodes()
{
    if(!st_check_service_available( 'st_tours' )) return;

    vc_map(
        array(
            'name'                    => __( "ST Tour Thumbnail" , 'traveler' ) ,
            'base'                    => 'st_thumbnail_tours' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Excerpt" , 'traveler' ) ,
            'base'                    => 'st_excerpt_tour' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Content" , 'traveler' ) ,
            'base'                    => 'st_tour_content' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Info" , 'traveler' ) ,
            'base'                    => 'st_info_tours' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false ,
            'params'                  => array(
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Style" , 'traveler' ) ,
                    "param_name"  => "style" ,
                    "value"       => array(
                        __( "--Select--" , 'traveler' )  => "" ,
                        __( "Style 1" , 'traveler' ) => "1",
                        __( "Style 2" , 'traveler' ) => "2"
                    ) ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Title 1" , 'traveler' ) ,
                    "param_name"  => "title1" ,
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array( '2' )
                    ),
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Title 2" , 'traveler' ) ,
                    "param_name"  => "title2" ,
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array( '2' )
                    ),
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array( '2' )
                    ),
                ) ,
            )

        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Detailed Tour Map" , 'traveler' ) ,
            'base'                    => 'st_tour_detail_map' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Range" , 'traveler' ) ,
                    "param_name"  => "range" ,
                    "description" => "Km" ,
                    "value"       => "20" ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Number" , 'traveler' ) ,
                    "param_name"  => "number" ,
                    "description" => "" ,
                    "value"       => "12" ,
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Show Circle" , 'traveler' ) ,
                    "param_name"  => "show_circle" ,
                    "description" => "" ,
                    "value"       => array(
                        __( "No" , 'traveler' )  => "no" ,
                        __( "Yes" , 'traveler' ) => "yes"
                    ) ,
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Review Summary" , 'traveler' ) ,
            'base'                    => 'st_tour_detail_review_summary' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Detailed Tour Review" , 'traveler' ) ,
            'base'                    => 'st_tour_detail_review_detail' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Program" , 'traveler' ) ,
            'base'                    => 'st_tour_program' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Share" , 'traveler' ) ,
            'base'                    => 'st_tour_share' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Style', 'traveler'),
                    'param_name' => 'style',
                    'description' => esc_html__('Select a style', 'traveler'),
                    'value' => array(
                        esc_html__('Style 1', 'traveler') => 'style-1',
                        esc_html__('Style 2', 'traveler') => 'style-2'
                    ),
                    'std' => 'style-1'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra Class', 'traveler'),
                    'param_name' => 'extra_class'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Review" , 'traveler' ) ,
            'base'                    => 'st_tour_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Price" , 'traveler' ) ,
            'base'                    => 'st_tour_price' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Video" , 'traveler' ) ,
            'base'                    => 'st_tour_video' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( "ST Tour Nearby" , 'traveler' ) ,
            'base'                    => 'st_tour_nearby' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    'type' => 'dropdown',
                    'admin_label' => true,
                    'heading' => esc_html__('Style', 'traveler'),
                    'param_name' => 'style',
                    'value' => array(
                        esc_html__('Style 1', 'traveler') => 'style-1',
                        esc_html__('Style 2', 'traveler') => 'style-2'
                    ),
                    'std' => 'style-1'
                ),
                array(
                    "type"             => "textfield" ,
                    'admin_label' => true,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('style-1')
                    )
                ) ,
                array(
                    "type"             => "dropdown" ,
                    'admin_label' => true,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array('style-1')
                    )
                ) ,
            )
        )
    );

    vc_map(
        array(
            'name'                    => __( 'ST Tour Show Discount' , 'traveler' ) ,
            'base'                    => 'st_tour_show_discount' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Tour' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map( array(
        "name"            => esc_html__( "ST Tour Gallery Map" , 'traveler' ) ,
        "base"            => "st_tour_gallery_map" ,
        "content_element" => true ,
        "icon"            => "icon-st" ,
        "category"        => 'Tour',
        'description' => esc_html__('Display gallery image and map', 'traveler'),
        "params"          => array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style', 'traveler'),
                'admin_label' => true,
                'param_name' => 'style',
                'description' => esc_html__('Select a style', 'traveler'),
                'value' => array(
                    esc_html__('Default', 'traveler') => 'style-1',
                    esc_html__('Half Map', 'traveler') => 'half_map'
                ),
                'std' => 'default'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Map Style', 'traveler'),
                'param_name' => 'map_style',
                'description' => esc_html__('Select a style for map', 'traveler'),
                'value' => array(
                    esc_html__('Normal', 'traveler') => 'style_normal',
                    esc_html__('Midnight', 'traveler') => 'style_midnight',
                    esc_html__('Icy Blue', 'traveler') => 'style_icy_blue',
                    esc_html__('Family Fest', 'traveler') => 'style_family_fest',
                    esc_html__('Open Dark', 'traveler') => 'style_open_dark',
                    esc_html__('Riverside', 'traveler') => 'style_riverside',
                    esc_html__('Ozan', 'traveler') => 'style_ozan'
                ),
                'std' => 'style_icy_blue'
            )
        )
    ) );

    vc_map( array(
        "name"            => esc_html__( "ST Tour Title - Address" , 'traveler' ) ,
        "base"            => "st_tour_title_address" ,
        "icon"            => "icon-st" ,
        "category"        => 'Tour',
        'content_element'         => true ,
        'description' => esc_html__('Display title and address', 'traveler'),
        "params"          => array(
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );


    vc_map( array(
        "name"            => esc_html__( "ST Tour List Info" , 'traveler' ) ,
        "base"            => "st_tour_list_info" ,
        "icon"            => "icon-st" ,
        "category"        => 'Tour',
        'content_element'         => true ,
        'description' => esc_html__('Display list tour info', 'traveler'),
        "params"          => array(
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );

    vc_map( array(
        "name"            => esc_html__( "ST Tour Tabs Content" , 'traveler' ) ,
        "base"            => "st_tour_tabs_content" ,
        "icon"            => "icon-st" ,
        "category"        => 'Tour',
        'content_element'         => true ,
        'description' => esc_html__('Display tabs content', 'traveler'),
        "params"          => array(
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Display Tabs', 'traveler'),
                'param_name' => 'display_tabs',
                'description' => esc_html__('Select tabs to show in single', 'traveler'),
                'value' => array(
                    esc_html__('Overview', 'traveler') => 'overview',
                    esc_html__('Itinerary', 'traveler') => 'itinerary',
                    esc_html__('FAQ & Reviews', 'traveler') => 'review',
                    esc_html__('Gallery', 'traveler') => 'gallery',
                    esc_html__('Prices & Payment', 'traveler') => 'payment',
                    esc_html__('Request To Book', 'traveler') => 'request',
                ),
                'std' => 'overview,itinerary,review,gallery,payment,request'
            ),
            array(
                "type"        => "textfield" ,
                'admin_label' => true,
                "heading"     => esc_html__( "Extra Class" , 'traveler' ) ,
                "param_name"  => "extra_class" ,
                "description" => ""
            ) ,
        )
    ) );
}

function st_map_rental_room_shortcodes()
{
    if(!st_check_service_available( 'st_rental' )) return;

    vc_map(
        array(
            'name'                    => __( "ST Detailed Rental Map" , 'traveler' ) ,
            'base'                    => 'st_rental_map' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => true,
            'params'=>array(
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Range" , 'traveler' ) ,
                    "param_name"  => "range" ,
                    "description" => "Km" ,
                    "value"       => "20" ,
                ) ,
                array(
                    "type"        => "textfield" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Number" , 'traveler' ) ,
                    "param_name"  => "number" ,
                    "description" => "" ,
                    "value"       => "12" ,
                ) ,
                array(
                    "type"        => "dropdown" ,
                    "holder"      => "div" ,
                    "heading"     => __( "Show Circle" , 'traveler' ) ,
                    "param_name"  => "show_circle" ,
                    "description" => "" ,
                    "value"       => array(
                        __( "No" , 'traveler' )  => "no" ,
                        __( "Yes" , 'traveler' ) => "yes"
                    ) ,
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Review Summary" , 'traveler' ) ,
            'base'                    => 'st_rental_review_summary' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Detailed Rental Review" , 'traveler' ) ,
            'base'                    => 'st_rental_review_detail' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Review" , 'traveler' ) ,
            'base'                    => 'st_rental_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Nearby" , 'traveler' ) ,
            'base'                    => 'st_rental_nearby' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => true ,
            'params'                  => array(
                array(
                    "type"             => "textfield" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Title" , 'traveler' ) ,
                    "param_name"       => "title" ,
                    "description"      => "" ,
                    "value"            => "" ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
                array(
                    "type"             => "dropdown" ,
                    "holder"           => "div" ,
                    "heading"          => __( "Font Size" , 'traveler' ) ,
                    "param_name"       => "font_size" ,
                    "description"      => "" ,
                    "value"            => array(
                        __('--Select--','traveler')=>'',
                        __( "H1" , 'traveler' ) => '1' ,
                        __( "H2" , 'traveler' ) => '2' ,
                        __( "H3" , 'traveler' ) => '3' ,
                        __( "H4" , 'traveler' ) => '4' ,
                        __( "H5" , 'traveler' ) => '5' ,
                    ) ,
                    'edit_field_class' => 'vc_col-sm-6' ,
                ) ,
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Add Rental Rental Review" , 'traveler' ) ,
            'base'                    => 'st_rental_add_review' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Price" , 'traveler' ) ,
            'base'                    => 'st_rental_price' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Video" , 'traveler' ) ,
            'base'                    => 'st_rental_video' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Header" , 'traveler' ) ,
            'base'                    => 'st_rental_header' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show Location ?", 'traveler'),
                    "param_name" => "is_location",
                    "description" =>"",
                    "value" => array(
                        __('--Select--','traveler')=>'',
                        __('Yes','traveler')=>'1',
                        __('No','traveler')=>'2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show contact", 'traveler'),
                    "param_name" => "is_contact",
                    "description" =>"",
                    "value" => array(
                        __('--Select--','traveler')=>'',
                        __('Yes','traveler')=>'1',
                        __('No','traveler')=>'2',
                    ),
                ),
            )
        )
    );
    vc_map(
        array(
            'name'                    => __( "ST Rental Book Form" , 'traveler' ) ,
            'base'                    => 'st_rental_book_form' ,
            'content_element'         => true ,
            'icon'                    => 'icon-st' ,
            'category'                => 'Rental' ,
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );
    vc_map(array(
        'name' => __('ST Rental Calendar','traveler'),
        'base' => 'st_rental_calendar',
        'content_element' => true,
        'icon' => 'icon-st',
        'category' => 'Rental',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));



    vc_map(array(
        'name'                    => __('ST Rental Room Header','traveler'),
        'base'                    => 'st_rental_room_header',
        'content_element'         => true,
        'icon'                    => 'icon-st',
        'category'                => 'Rental',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map(array(
        'name'                    => __('ST Rental Room Content','traveler'),
        'base'                    => 'st_rental_room_content',
        'content_element'         => true,
        'icon'                    => 'icon-st',
        'category'                => 'Rental',
        'show_settings_on_create' => false,
        'params'=>array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));

    vc_map( array(
        "name" => __("ST Rental Room Gallery", 'traveler'),
        "base" => "st_rental_room_gallery",
        "content_element" => true,
        "icon" => "icon-st",
        "category"=>'Rental',
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style",
                "description" =>"",
                "value" => array(
                    __('--Select--','traveler')=>'',
                    __('Slide','traveler')=>'slide',
                    __('Grid','traveler')=>'grid',
                ),
            )
        )
    ) );

    vc_map(array(
        'name' => __('ST List Rental Room','traveler'),
        'base' => 'st_list_rental_room',
        'content_element' => true,
        'show_settings_on_create' => true,
        'icon' => 'icon-st',
        'category' => 'Rental',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Header text', 'traveler'),
                'param_name' => 'header_title',
                'value' => __('Rental Room List', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Posts per page','traveler'),
                'param_name' => 'post_per_page',
                'value' => 12
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order by', 'traveler'),
                'param_name' => 'order_by',
                'value' => array(
                    __('--Select--','traveler')=>'',
                    __('none','traveler') => 'none',
                    __('ID','traveler') => 'ID',
                    __('Name','traveler') => 'name',
                    __('Date','traveler') => 'date',
                    __('Random','traveler') => 'rand'
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order','traveler'),
                'param_name' => 'order',
                'value' => array(
                    __('--Select--','traveler')=>'',
                    __('Ascending','traveler') => 'asc',
                    __('Descending','traveler') => 'desc'
                )
            ),
        ),

    ));

    vc_map(array(
        'name' => __('ST Related Rental Room','traveler'),
        'base' => 'st_related_rental_room',
        'content_element' => true,
        'show_settings_on_create' => true,
        'icon' => 'icon-st',
        'category' => 'Rental',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Header text', 'traveler'),
                'param_name' => 'header_title',
                'value' => __('Related Rental Room', 'traveler')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Number of room', 'traveler'),
                'param_name' => 'number_of_room',
                'value' => 5
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Show Excerpt', 'traveler'),
                'param_name' => 'show_excerpt',
                'value' => array(
                    __('--Select--','traveler')=>'',
                    __('Yes', 'traveler') => 'yes',
                    __('No', 'traveler') => 'no'
                ),
                'std' => 'no'
            )
        )
    ));

    vc_map(
        array(
            'name' => __("ST Rental Room Review", 'traveler'),
            'base' => 'st_rental_room_review',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Rental',
            'show_settings_on_create' => false,
            'params'=>array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        )
    );

    vc_map(
        array(
            'name' => __("ST Rental Room Facility", 'traveler'),
            'base' => 'st_rental_room_facility',
            'content_element' => true,
            'icon' => 'icon-st',
            'category' => 'Hotel',
            'show_settings_on_create' => true,
            'params' => array(
                array(
                    'type' => 'st_checkbox',
                    'heading' => __('Choose taxonomies', 'traveler'),
                    'param_name' => 'choose_taxonomies',
                    'description' => __('Will be shown in layout', 'traveler'),
                    'stype' => 'tax_rental',
                    'sparam' => false
                )
            )
        )
    );

}
function st_map_single_hotel(){
    // if(!st_check_service_available( 'st_hotel' )) return;
   
} 
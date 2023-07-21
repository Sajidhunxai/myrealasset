<?php

/**

 * Created by PhpStorm.

 * User: Dannie

 * Date: 8/30/2018

 * Time: 2:44 PM

 */

add_action( 'vc_before_init', 'st_map_flights_shortcodes' );



function st_map_flights_shortcodes()

{



    vc_map(array(

        'name' => esc_html__('ST Flight Destinations', 'traveler'),

        'base' => 'st_flight_destinations',

        'icon' => 'icon-st',

        'category' => esc_html__('Flights', 'traveler'),

        'params' => array(

            array(

                "type" => "st_post_type_location",

                "heading" => __("List IDs in Location", 'traveler'),

                "param_name" => "st_ids",

                "description" =>__("Ids separated by commas",'traveler'),

                'value'=>"",

            ),

            array(

                'type' => 'dropdown',

                'param_name' => 'column',

                'admin_label' => true,

                'heading' => esc_html__('No Of Columns', 'traveler'),

                'description' => esc_html__('Choose column to display element', 'traveler'),

                'value' => array(

                    esc_html__('3 columns', 'traveler') => 'col-md-4',

                    esc_html__('4 columns', 'traveler') => 'col-md-3'

                ),

                'std' => 'col-md-3'

            )

        )

    ));

    vc_map(array(

        "name" => esc_html__("ST Flight Search Filter", 'traveler'),

        "base" => "st_flight_search_filter",

        "as_parent" => array('only' => 'st_flight_filter_price,st_flight_filter_stops,st_flight_filter_departure,st_flight_filter_airlines'),

        "content_element" => true,

        "show_settings_on_create" => true,

        "js_view" => 'VcColumnView',

        "icon" => "icon-st",

        "category" => esc_html__('Flights', 'traveler'),

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => "",

            ),

            array(

                "type" => "dropdown",

                "heading" => esc_html__("Style", 'traveler'),

                "param_name" => "style",

                "value" => array(

                    esc_html__('--Select--', 'traveler') => '',

                    esc_html__('Dark', 'traveler') => 'dark',

                    esc_html__('Light', 'traveler') => 'light',

                ),

            ),

        )

    ));

    vc_map(array(

        "name" => esc_html__("ST Flight Filter Price", 'traveler'),

        "base" => "st_flight_filter_price",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));



    vc_map(array(

        "name" => esc_html__("ST Flight Filter Stops", 'traveler'),

        "base" => "st_flight_filter_stops",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));

    vc_map(array(

        "name" => esc_html__("ST Flight Filter Departure Time", 'traveler'),

        "base" => "st_flight_filter_departure",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));

    vc_map(array(

        "name" => esc_html__("ST Flight Filter Airlines", 'traveler'),

        "base" => "st_flight_filter_airlines",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));



    vc_map(array(

        "name" => esc_html__("[Ajax] ST Flight Search Filter", 'traveler'),

        "base" => "st_flight_search_filter_ajax",

        "as_parent" => array('only' => 'st_flight_filter_price_ajax,st_flight_filter_stops_ajax,st_flight_filter_departure_ajax,st_flight_filter_airlines_ajax'),

        "content_element" => true,

        "show_settings_on_create" => true,

        "js_view" => 'VcColumnView',

        "icon" => "icon-st",

        "category" => esc_html__('Flights', 'traveler'),

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => "",

            ),

            array(

                "type" => "dropdown",

                "heading" => esc_html__("Style", 'traveler'),

                "param_name" => "style",

                "value" => array(

                    esc_html__('--Select--', 'traveler') => '',

                    esc_html__('Dark', 'traveler') => 'dark',

                    esc_html__('Light', 'traveler') => 'light',

                ),

            ),

        )

    ));

    vc_map(array(

        "name" => esc_html__("[Ajax] ST Flight Filter Price", 'traveler'),

        "base" => "st_flight_filter_price_ajax",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter_ajax'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));



    vc_map(array(

        "name" => esc_html__("[Ajax] ST Flight Filter Stops", 'traveler'),

        "base" => "st_flight_filter_stops_ajax",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter_ajax'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));

    vc_map(array(

        "name" => esc_html__("[Ajax] ST Flight Filter Departure Time", 'traveler'),

        "base" => "st_flight_filter_departure_ajax",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter_ajax'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));

    vc_map(array(

        "name" => esc_html__("[Ajax] ST Flight Filter Airlines", 'traveler'),

        "base" => "st_flight_filter_airlines_ajax",

        "content_element" => true,

        "as_child" => array('only' => 'st_flight_search_filter_ajax'),

        "icon" => "icon-st",

        "params" => array(

            array(

                "type" => "textfield",

                "heading" => esc_html__("Title", 'traveler'),

                "param_name" => "title",

                "description" => ""

            )

        )

    ));



    vc_map(array(

        'name' => esc_html__('ST Flight Search Result', 'traveler'),

        'base' => 'st_flight_search_results',

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



    vc_map(array(

        'name' => esc_html__('ST Single Search Flights', 'traveler'),

        'base' => 'st_single_search_flights',

        'icon' => 'icon-st',

        'category' => esc_html__('Flights', 'traveler'),

        'params' => array(

            array(

                'type' => 'textfield',

                'param_name' => 'title',

                'heading' => esc_html__('Title Form', 'traveler'),

                'admin_label' => true,

                'description' => esc_html__('Add a text for title form', 'traveler')

            ),

            array(

                'type' => 'dropdown',

                'param_name' => 'style',

                'admin_label' => true,

                'heading' => esc_html__('Style', 'traveler'),

                'description' => esc_html__('Choose a style', 'traveler'),

                'value' => array(

                    esc_html__('Default', 'traveler') => 'default',

                    esc_html__('Small', 'traveler') => 'small'

                ),

                'std' => 'default'

            ),

            array(

                'type' => 'dropdown',

                'param_name' => 'search_type',

                'heading' => esc_html__('Search Type', 'traveler'),

                'value' => array(

                    esc_html__('One-Way', 'traveler') => 'one_way',

                    esc_html__('Return', 'traveler') => 'return',

                    esc_html__('Both', 'traveler') => 'both',

                ),

                'std' => 'both'

            ),

            array(

                'type' => 'dropdown',

                'param_name' => 'box_shadow',

                'heading' => esc_html__('Show Box Shadow', 'traveler'),

                'value' => array(

                    esc_html__('No', 'traveler') => 'no',

                    esc_html__('Yes', 'traveler') => 'yes',

                ),

                'std' => 'no'

            ),

        )

    ));



    vc_map(array(

        'name' => esc_html__('ST Sum Of Flight Search Results', 'traveler'),

        'base' => 'st_sum_of_flight_search_result',

        'icon' => 'icon-st',

        'category' => esc_html__('Flights', 'traveler'),

        'params' => array(

            array(

                "type" => "textfield",

                "heading" => __("Extra Class", 'traveler'),

                "param_name" => "extra_class",

                'value'=>"",

            )

        )

    ));



    vc_map(array(

        'name' => esc_html__('[Ajax] ST Sum Of Flight Search Results', 'traveler'),

        'base' => 'st_sum_of_flight_search_result_ajax',

        'icon' => 'icon-st',

        'category' => esc_html__('Flights', 'traveler'),

        'params' => array(

            array(

                "type" => "textfield",

                "heading" => __("Extra Class", 'traveler'),

                "param_name" => "extra_class",

                'value'=>"",

            )

        )

    ));



}
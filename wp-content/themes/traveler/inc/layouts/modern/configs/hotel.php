<?php

if(!class_exists('ST_Traveler_Modern_Hotel_Configs')){

    class ST_Traveler_Modern_Hotel_Configs{

        static $_inst;



        function __construct()

        {

            add_action( 'admin_init', array($this, 'customMetaBoxSearchResultPage') );

        }



        function customMetaBoxSearchResultPage(){



            $meta_data_box = array(

                'id' => 'st_hotel_search_result_options',

                'title' => esc_html__('Hotel Search Result Settings', 'traveler'),

                'desc' => '',

                'pages' => array('page'),

                'context' => 'normal',

                'priority' => 'high',

                'fields' => array(

                    array(

                        'id' => 'layout_tab',

                        'label' => esc_html__('General', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id' => 'rs_layout',

                        'label' => esc_html__('Choose layout for page', 'traveler'),

                        'desc' => '',

                        'type' => 'radio-image',

                        'section' => 'layout_tab',

                        'std' => '1',

                        'choices' => array(

                            array(

                                'value' => '1',

                                'label' => esc_html__('Layout Full Map', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_1.png',

                            ),

                            array(

                                'value' => '2',

                                'label' => esc_html__('Layout Half Map', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_2.png'

                            ),

                            array(

                                'value' => '5',

                                'label' => esc_html__('Layout Half Map (Style 2)', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_5.PNG'

                            ),

                            array(

                                'value' => '3',

                                'label' => esc_html__('Popup Map', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_3.png'

                            ),

                            array(

                                'value' => '6',

                                'label' => esc_html__('Popup Map (Style 2)', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_6.png'

                            ),

                            array(

                                'value' => '4',

                                'label' => esc_html__('Full Width', 'traveler'),

                                'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_4.png'

                            ),

                        )

                    ),

                    array(

                        'id'          => 'rs_hotel_map_pos',

                        'label'       => __( 'Map Position', 'traveler'),

                        'std'         => 'right',

                        'type'        => 'select',

                        'section'     => 'layout_tab',

                        'choices'     => array(

                            array(

                                'value'       => 'left',

                                'label'       => __( 'Left', 'traveler'),

                            ),

                            array(

                                'value'       => 'right',

                                'label'       => __( 'Right', 'traveler'),

                            ),

                        ),

                        'operator' => 'OR',

                        'condition' => 'rs_layout:is(2),rs_layout:is(5)',

                    ),

                    array(

                        'id'          => 'rs_hotel_siderbar_pos',

                        'label'       => __( 'Sidebar Position', 'traveler'),

                        'std'         => 'left',

                        'type'        => 'select',

                        'section'     => 'layout_tab',

                        'choices'     => array(

                            array(

                                'value'       => 'left',

                                'label'       => __( 'Left', 'traveler'),

                            ),

                            array(

                                'value'       => 'right',

                                'label'       => __( 'Right', 'traveler'),

                            ),

                        ),

                        'operator' => 'OR',

                        'condition' => 'rs_layout:is(1),rs_layout:is(3),rs_layout:is(6)',

                    ),

                    array(

                        'id'          => 'rs_style',

                        'label'       => __( 'Style default', 'traveler'),

                        'desc'        => __( 'Select defaul style to display in the search result page', 'traveler'),

                        'std'         => 'grid',

                        'type'        => 'select',

                        'section'     => 'layout_tab',

                        'choices'     => array(

                            array(

                                'value'       => 'grid',

                                'label'       => __( 'Grid', 'traveler'),

                            ),

                            array(

                                'value'       => 'list',

                                'label'       => __( 'List', 'traveler'),

                            ),

                        ),

                        'operator' => 'OR',

                        'condition' => 'rs_layout:is(1),rs_layout:is(2),rs_layout:is(5),rs_layout:is(3),rs_layout:is(6)',

                    ),

                    array(

                        'id'          => 'rs_map_room',

                        'label'       => __( 'Map zoom', 'traveler'),

                        'desc'        => __( 'Set map zoom in search result page', 'traveler'),

                        'std'         => '13',

                        'type'        => 'numeric-slider',

                        'min_max_step' => '1, 30, 1',

                        'section'     => 'layout_tab',

                    ),

                    array(

                        'id' => 'filter_tab',

                        'label' => esc_html__('Filter', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id'          => 'rs_filter',

                        'label'       => __( 'Create filter option', 'traveler'),

                        'desc' => __('Create filter option for search page result', 'traveler'),

                        'type'        => 'list-item',

                        'section'     => 'filter_tab',

                        'std' => array(

                            array(

                                'title' => 'Filter Price',

                                'rs_filter_type' => 'price',

                                'rs_filter_type_taxonomy' => 'hotel_theme'

                            ),

                            array(

                                'title' => 'Review Score',

                                'rs_filter_type' => 'review_score',

                                'rs_filter_type_taxonomy' => 'hotel_theme'

                            ),

                            array(

                                'title' => 'Hotel Star',

                                'rs_filter_type' => 'hotel_star',

                                'rs_filter_type_taxonomy' => 'hotel_theme'

                            ),

                            array(

                                'title' => 'Facilities',

                                'rs_filter_type' => 'taxonomy',

                                'rs_filter_type_taxonomy' => 'hotel_facilities'

                            ),

                            array(

                                'title' => 'Hotel Theme',

                                'rs_filter_type' => 'taxonomy',

                                'rs_filter_type_taxonomy' => 'hotel_theme'

                            ),

                        ),

                        'settings'    => array(

                            array(

                                'id'          => 'rs_filter_type',

                                'label'       => __( 'Filter item', 'traveler'),

                                'std'         => 'price',

                                'type'        => 'select',

                                'choices'     => array(

                                    array(

                                        'value'       => 'price',

                                        'label'       => __( 'Price', 'traveler'),

                                    ),

                                    array(

                                        'value'       => 'review_score',

                                        'label'       => __( 'Review score', 'traveler'),

                                    ),

                                    array(

                                        'value'       => 'hotel_star',

                                        'label'       => __( 'Hotel star', 'traveler'),

                                    ),

                                    array(

                                        'value'       => 'taxonomy',

                                        'label'       => __( 'Taxonomy', 'traveler'),

                                    ),

                                )

                            ),

                            array(

                                'id'          => 'rs_filter_type_taxonomy',

                                'label'       => __( 'Taxonomy select', 'traveler'),

                                'std'         => '',

                                'type'        => 'select',

                                'condition' => 'rs_filter_type:is(taxonomy)',

                                'choices'     => st_get_post_taxonomy('st_hotel')

                            ),

                        )

                    ),

                )

            );



            if(function_exists('ot_register_meta_box')) {

                ot_register_meta_box($meta_data_box);

            }



            /*if(isset($_GET['post']))

                $post_id = $_GET['post'];



            $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);

            if ($template_file == 'template-hotel-search.php') {

                ot_register_meta_box( $meta_data_box );

            }*/

        }



        static function inst(){

            if(!self::$_inst)

                self::$_inst = new self();



            return self::$_inst;

        }



    }

    ST_Traveler_Modern_Hotel_Configs::inst();

}
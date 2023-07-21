<?php

if(!class_exists('ST_Traveler_Modern_Rental_Configs')){

    class ST_Traveler_Modern_Rental_Configs{

        static $_inst;



        function __construct()

        {

            add_action( 'admin_init', array($this, 'customMetaBoxSearchResultPage') );

        }



        function customMetaBoxSearchResultPage(){
            $array_modern = array();
            $layout_search = [
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

                    'value' => '3',

                    'label' => esc_html__('Popup Map', 'traveler'),

                    'src' =>  get_template_directory_uri() . '/v2/images/layouts/rs_layout_3.png'

                ),
                
            ];
            if(check_using_elementor()){
                $array_modern = [
                    array(

                        'value' => '4',

                        'label' => esc_html__('Layout Half Map (Style mordern)', 'traveler'),

                        'src' =>  get_template_directory_uri() . '/v2/images/layouts/rental_search_4.png'

                    ),
                    array(

                        'value' => '5',

                        'label' => esc_html__('Popup Map (Style mordern)', 'traveler'),

                        'src' =>  get_template_directory_uri() . '/v2/images/layouts/rental_search_5.png'

                    ),
                ];
                
            }
            $layout_search = array_merge($layout_search,$array_modern);
            $layout_search = apply_filters('st_layout_search_rental',$layout_search);

            $meta_data_box = array(

                'id' => 'st_rental_search_result_options',

                'title' => esc_html__('Rental Search Result Settings', 'traveler'),

                'desc' => '',

                'pages' => array('page'),

                'context' => 'normal',

                'priority' => 'high',

                'fields' => array(

                    array(

                        'id' => 'layout_tab_rental',

                        'label' => esc_html__('General', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id' => 'rs_layout_rental',

                        'label' => esc_html__('Choose layout for page', 'traveler'),

                        'desc' => '',

                        'type' => 'radio-image',

                        'section' => 'layout_tab',

                        'std' => '1',

                        'class' => 'custom-radio-image',

                        'choices' => $layout_search

                    ),

                    array(

                        'id'          => 'rs_style_rental',

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

                        )

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

                        'id' => 'filter_tab_rental',

                        'label' => esc_html__('Filter', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id'          => 'rs_filter_rental',

                        'label'       => __( 'Create filter option', 'traveler'),

                        'desc' => __('Create filter option for search page result', 'traveler'),

                        'type'        => 'list-item',

                        'section'     => 'filter_tab',

                        'std' => array(

                            array(

                                'title' => 'Filter Price',

                                'rs_filter_type' => 'price',

                                'rs_filter_type_taxonomy' => 'amenities'

                            ),

                            array(

                                'title' => 'Review Score',

                                'rs_filter_type' => 'review_score',

                                'rs_filter_type_taxonomy' => 'amenities'

                            ),

                            array(

                                'title' => 'Rental Amenities',

                                'rs_filter_type' => 'taxonomy',

                                'rs_filter_type_taxonomy' => 'amenities'

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

                                'choices'     => st_get_post_taxonomy('st_rental')

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

    ST_Traveler_Modern_Rental_Configs::inst();

}
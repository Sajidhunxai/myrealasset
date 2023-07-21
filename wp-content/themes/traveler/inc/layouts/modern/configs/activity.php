<?php

if(!class_exists('ST_Traveler_Modern_Activity_Configs')){

    class ST_Traveler_Modern_Activity_Configs{

        static $_inst;



        function __construct()

        {

            add_action( 'admin_init', array($this, 'customMetaBoxSearchResultPage') );

        }



        function customMetaBoxSearchResultPage(){
            $array_modern =[];
            $layout_search = [
                array(

                    'value' => '1',

                    'label' => esc_html__('Sidebar Layout', 'traveler'),

                    'src' =>  get_template_directory_uri() . '/v2/images/layouts/activity_rs_layout_1.png',

                ),

                array(

                    'value' => '2',

                    'label' => esc_html__('Topbar Layout', 'traveler'),

                    'src' =>  get_template_directory_uri() . '/v2/images/layouts/activity_rs_layout_2.png'

                ),
                
            ];

            if(check_using_elementor()){
                $array_modern = [
                    array(

                        'value' => '3',

                        'label' => esc_html__('Sidebar Layout (Style mordern)', 'traveler'),

                        'src' =>  get_template_directory_uri() . '/v2/images/layouts/tour_rs_layout_6.png'

                    ),
                    array(

                        'value' => '4',

                        'label' => esc_html__('Topbar Layout (Style mordern)', 'traveler'),

                        'src' =>  get_template_directory_uri() . '/v2/images/layouts/tour_rs_layout_7.png'

                    ),
                ];
            }

            $layout_search = array_merge($layout_search,$array_modern);
            $layout_search = apply_filters('st_layout_search_activity',$layout_search);
            $meta_data_box = array(

                'id' => 'st_activity_search_result_options',

                'title' => esc_html__('Activity Search Result Settings', 'traveler'),

                'desc' => '',

                'pages' => array('page'),

                'context' => 'normal',

                'priority' => 'high',

                'fields' => array(

                    array(

                        'id' => 'layout_activity_tab',

                        'label' => esc_html__('General', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id' => 'rs_layout_activity',

                        'label' => esc_html__('Choose layout for page', 'traveler'),

                        'desc' => '',

                        'type' => 'radio-image',

                        'section' => 'layout_activity_tab',

                        'std' => '1',

                        'choices' => $layout_search

                    ),

                    array(

                        'id'          => 'rs_activity_sidebar_pos',

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

                        'condition' => 'rs_layout_activity:is(1)',

                    ),

                    array(

                        'id'          => 'rs_style_activity',

                        'label'       => __( 'Style default', 'traveler'),

                        'desc'        => __( 'Select defaul style to display in the search result page', 'traveler'),

                        'std'         => 'grid',

                        'type'        => 'select',

                        'section'     => 'layout_activity_tab',

                        'condition' => 'rs_layout_activity:is(1)',

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

                        'id' => 'filter_activity_tab',

                        'label' => esc_html__('Filter', 'traveler'),

                        'type' => 'tab',

                    ),

                    array(

                        'id'          => 'rs_filter_activity',

                        'label'       => __( 'Create filter option', 'traveler'),

                        'desc' => __('Create filter option for search page result', 'traveler'),

                        'type'        => 'list-item',

                        'section'     => 'filter_activity_tab',

                        'std' => array(

                            array(

                                'title' => 'Filter Price',

                                'rs_filter_type' => 'price',

                                'rs_filter_type_taxonomy' => ''

                            ),

                            array(

                                'title' => 'Review Score',

                                'rs_filter_type' => 'review_score',

                                'rs_filter_type_taxonomy' => ''

                            ),

                            array(

                                'title' => 'Attractions',

                                'rs_filter_type' => 'taxonomy',

                                'rs_filter_type_taxonomy' => 'attractions'

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

                                'choices'     => st_get_post_taxonomy('st_activity')

                            ),

                        )

                    ),

                )

            );



            if(function_exists('ot_register_meta_box')) {

                ot_register_meta_box($meta_data_box);

            }

        }



        static function inst(){

            if(!self::$_inst)

                self::$_inst = new self();



            return self::$_inst;

        }



    }

    ST_Traveler_Modern_Activity_Configs::inst();

}
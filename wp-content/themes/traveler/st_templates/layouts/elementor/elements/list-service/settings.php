<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_List_Service_Element')) {
    class ST_List_Service_Element extends \Elementor\Widget_Base
    {   
        public function __construct($data = [], $args = null) {
            parent::__construct($data, $args);
            wp_register_script('st-select-taxonomy-ajax-control', get_template_directory_uri() . '/v3/js/admin/widget/select-taxonomy.js', ['jquery' , 'elementor-frontend'], null, true);
         }

        public function get_name()
        {
            return 'st_list_service';
        }

        public function get_title()
        {
            return esc_html__('List item service', 'traveler');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_elements'];
        }


        public function get_script_depends()
        {
            
            return ['swiper'];
        }

        public function get_attribute_settings($post_type='st_hotel'){
            $attribute_setting = '';
            if($post_type =='st_hotel'){
                $attribute_setting =  apply_filters( 'st_tax_query_hotel', st()->get_option( 'attribute_search_form_hotel') );
            } elseif($post_type == 'st_tours') {
                $attribute_setting =  apply_filters( 'st_tax_query_tour', st()->get_option( 'attribute_search_form_tour') );
            }elseif($post_type == 'st_rental') {
                $attribute_setting =  apply_filters( 'st_tax_query_rental', st()->get_option( 'attribute_search_form_rental') );
            }elseif($post_type == 'st_cars') {
                $attribute_setting =  apply_filters( 'st_tax_query_car', st()->get_option( 'attribute_search_form_car') ); 
            }elseif($post_type == 'st_activity') {
                $attribute_setting = apply_filters( 'st_tax_query_activity', st()->get_option( 'attribute_search_form_activity') );
            }
            
            $taxonomy_settings = get_taxonomy($attribute_setting);
            if(!empty($taxonomy_settings)){
                return [
                    'label'=>$taxonomy_settings->label,
                    'name'=>$taxonomy_settings->name,
                ];
            } else {
                return  [
                    'label'=> '',
                    'name'=>'',
                ];
            }
        }

        protected function register_controls()
        {
            $layout_style = apply_filters('st_layout_service_style', [
                'style_1'  => esc_html__( 'Style 1', 'traveler' ),
                'style_2' => esc_html__( 'Style 2', 'traveler' )
            ]);
            $this->start_controls_section(
                'settings_section',
                [
                    'label' => esc_html__('Settings', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );
            $this->add_control(
                'type_form',
                [
                    'label' => esc_html__('Type form list', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'single'  => esc_html__( 'Single', 'traveler' ),
                        'mix_service' => esc_html__( 'Mix service', 'traveler' ),
                    ],
                    'default' => 'single',
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'list_style',
                [
                    'label' => esc_html__('Layout', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'grid'  => esc_html__( 'Grid', 'traveler' ),
                        'list' => esc_html__( 'List', 'traveler' ),
                        'slider' => esc_html__( 'Slider (Not support Mix service)', 'traveler' ),
                    ],
                    'default' => 'grid',
                ]
            );
            $this->add_control(
                'style_list',
                [
                    'label' => esc_html__( 'Style List item', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'none'  => esc_html__( 'None', 'traveler' ),
                        'vertical'  => esc_html__( 'Vertical', 'traveler' ),
                        
                    ],
                    'label_block' => true,
                    'default' => 'none',
                    'condition' => [
                        'list_style' => 'list'
                    ]
                ]
            );
            $this->add_control(
                'style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => $layout_style,
                    'default' => 'style_1',
                ]
            );
            
            $this->add_control(
                'services',
                [
                    'label' => esc_html__('Choose service', 'traveler'),
                    'type' => 'select2_ajax',
                    'multiple' => true,
                    'label_block' => true,
                    'cache' => false,
                    'post_type' => 'find_service',
                    'callback' => 'ST_Elementor:get_list_of_service_ajax',
                    'default' => [],
                    'condition' => [
                        'type_form' => 'mix_service'
                    ]
                ]
            );
            $this->add_control(
                'service',
                [
                    'label' => esc_html__( 'Choose service', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => ST_Elementor::listSerrviceSelectionName(array('st_cartransfer')),
                    'default' => 'st_hotel',
                    'condition' => [
                        'type_form' => 'single'
                    ]
                ]
            );
            
            $this->add_control(
                'heading',
                [
                    'label' => esc_html__('Title', 'traveler'),
                    'description' => esc_html__('Title mix service', 'traveler'),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Trending',
                    'condition' => [
                        'type_form' => 'mix_service'
                    ]
                ]
            );
            $this->add_control(
                'category_hotel',
                [
                    'label' => esc_html__( 'Choose category hotel', 'traveler' ),
                    'description' => esc_html__('Category by attribute', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy('st_hotel'),
                    'default' => '0:'.$this->get_attribute_settings('st_hotel')['name'],
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_hotel'
                    ]
                ]
            );
            $this->add_control(
                'category_activity',
                [
                    'label' => esc_html__( 'Choose category activity', 'traveler' ),
                    'description' => esc_html__('Category by attribute', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy('st_activity'),
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_activity'
                    ]
                ]
            );
            $this->add_control(
                'category_rental',
                [
                    'label' => esc_html__( 'Choose category rental', 'traveler' ),
                    'description' => esc_html__('Category by attribute', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy('st_rental'),
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_rental'
                    ]
                ]
            );
            $this->add_control(
                'category_car',
                [
                    'label' => esc_html__( 'Choose category car', 'traveler' ),
                    'description' => esc_html__('Category by attribute', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy('st_cars'),
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_cars'
                    ]
                ]
            );
            $this->add_control(
                'category_tour',
                [
                    'label' => esc_html__( 'Choose category tour', 'traveler' ),
                    'description' => esc_html__('Category by attribute', 'traveler').' '.$this->get_attribute_settings('st_tours')['label'],
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy('st_tours'),
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_tours'
                    ]
                ]
            );
            $this->add_control(
                'order',
                [
                    'label' => esc_html__('Order', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'ASC'  => esc_html__( 'Ascending', 'traveler' ),
                        'DESC' => esc_html__( 'Descending', 'traveler' ),
                    ],
                    'default' => 'ASC',
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'orderby',
                [
                    'label' => esc_html__('Orderby', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__("Order don't work with settings Show Featured Item On Top Results ", 'traveler'),
                    'label_block' => true,
                    'options' => [
                        ''  => esc_html__( 'None', 'traveler' ),
                        'ID' => esc_html__( 'ID', 'traveler' ),
                        'title' => esc_html__( 'Title', 'traveler' ),
                        'name' => esc_html__( 'Name', 'traveler' ),
                        'date' => esc_html__( 'Date', 'traveler' ),
                        'post__in' => esc_html__( 'Preserve post ID', 'traveler' ),
                    ],
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'post_ids_tour',
                [
                    'label' => esc_html__( 'Choose item', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'st_tours',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_tours',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'post_ids_hotel',
                [
                    'label' => esc_html__( 'Choose item hotel', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'st_hotel',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_hotel',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'post_ids_room',
                [
                    'label' => esc_html__( 'Choose item room', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'hotel_room',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'hotel-room',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'post_ids_activity',
                [
                    'label' => esc_html__( 'Choose item activity', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'st_activity',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_activity',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'post_ids_rental',
                [
                    'label' => esc_html__( 'Choose item rental', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'st_rental',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_rental',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'post_ids_car',
                [
                    'label' => esc_html__( 'Choose item car', 'traveler' ),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'st_cars',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'type_form' => 'single',
                        'service' => 'st_cars',
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->add_control(
                'item_row',
                [
                    'label' => esc_html__('Item in row', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        '1'  => esc_html__( '1 items', 'traveler' ),
                        '2'  => esc_html__( '2 items', 'traveler' ),
                        '3' => esc_html__( '3 items', 'traveler' ),
                        '4' => esc_html__( '4 items', 'traveler' ),
                    ],
                    'default' => '4',
                    'frontend_available' => true,
                    'condition' => [
                        'list_style' => 'grid',
                    ]
                ]
            );
            $this->add_control(
                'posts_per_page',
                [
                    'label' => esc_html__( 'Number item', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 4,
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'list_style' => 'slider'
                    ]
                ]
            );
            $this->add_control(
                'pagination',
                [
                    'label' => esc_html__('Pagination', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__( 'On', 'traveler' ),
                        'off' => esc_html__( 'Off', 'traveler' ),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'navigation',
                [
                    'label' => esc_html__('Navigation', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__( 'On', 'traveler' ),
                        'off' => esc_html__( 'Off', 'traveler' ),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'effect_style',
                [
                    'label' => esc_html__('Style Effect', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'creative'  => esc_html__( 'Creative', 'traveler' ),
                        'coverflow' => esc_html__( 'Coverflow', 'traveler' ),
                        'cards' => esc_html__( 'Cards', 'traveler' ),
                    ],
                    'default' => 'creative',
                ]
            );

            $this->add_control(
                'auto_play',
                [
                    'label' => esc_html__('Auto play', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__( 'On', 'traveler' ),
                        'off' => esc_html__( 'Off', 'traveler' ),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'delay',
                [
                    'label' => esc_html__('Delay auto play', 'traveler'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'default' => '3000',
                    'condition' => [
                        'auto_play' => 'on'
                    ]
                ]
            );
            $this->add_control(
                'loop',
                [
                    'label' => esc_html__('Loop slider', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'true'  => esc_html__( 'On', 'traveler' ),
                        'false' => esc_html__( 'Off', 'traveler' ),
                    ],
                    'default' => 'false',
                    'condition' => [
                        'auto_play!' => 'on'
                    ]
                ]
            );
            
            $this->add_control(
                'slides_per_view',
                [
                    'label' => esc_html__('Slides PerView in content', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        '1'  => esc_html__( '1 items', 'traveler' ),
                        '2'  => esc_html__( '2 items', 'traveler' ),
                        '3' => esc_html__( '3 items', 'traveler' ),
                        '4' => esc_html__( '4 items', 'traveler' ),
                    ],
                    'default' => '4',
                    'frontend_available' => true
                ]
            );

            
            $this->end_controls_section();

            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'default' => 'single',
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Style title mix service', 'traveler'),
                    'selector' => '{{WRAPPER}} .st-list-service .title h2',
                    'condition' => [
                        'type_form' => 'mix_service'
                    ]
                ]
            );
           
            $this->end_controls_section();

            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_list_service_view', ST_Elementor::view('list-service.template', $settings, true), $settings);
        }
    }
}

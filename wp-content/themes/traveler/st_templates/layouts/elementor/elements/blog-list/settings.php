<?php

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Blog_List_Element')) {
    class ST_Blog_List_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_blog_list';
        }

        public function get_title()
        {
            return esc_html__('Blog list', 'traveler');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_elements'];
        }
        public function get_attribute_settings()
        {
           
            $taxonomy_settings = get_taxonomy('category');
            if (!empty($taxonomy_settings)) {
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
           
            $layout_style = apply_filters('st_layout_blog_style', [
                'grid'  => esc_html__('Grid', 'traveler'),
                'slider' => esc_html__('Slider', 'traveler'),
            ]);

            $settings_slider_condition = apply_filters('st_settings_blog_slider_condition', [
                'layout_style' => ['slider']
            ]);

            $settings_slider_loop_condition = apply_filters('st_settings_blog_slider_loop_condition', []);
            
            $this->start_controls_section(
                'settings_section',
                [
                    'label' => esc_html__('Settings', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );

            $this->add_control(
                'layout_style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => $layout_style,
                    'default' => 'grid',
                ]
            );
            $this->add_control(
                'category_blog',
                [
                    'label' => esc_html__('Choose category Blog', 'traveler'),
                    'description' => esc_html__('Category by attribute', 'traveler').' '.$this->get_attribute_settings()['label'],
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'options' => ST_Elementor::listCategoryByTaxnomy($this->get_attribute_settings()['name']),
                    'default' => '0:'.$this->get_attribute_settings()['name'],
                    'condition' => [
                        'layout_style' => 'style-lib-slider-9',
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
                        '1'  => esc_html__('1 items', 'traveler'),
                        '2'  => esc_html__('2 items', 'traveler'),
                        '3' => esc_html__('3 items', 'traveler'),
                        '4' => esc_html__('4 items', 'traveler'),
                    ],
                    'default' => '4',
                    'frontend_available' => true,
                ]
            );
            $this->add_responsive_control(
                'posts_per_page',
                [
                    'label' => esc_html__('Number item', 'traveler'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 8,
                ]
            );
            $this->add_control(
                'order',
                [
                    'label' => esc_html__('Order', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'ASC'  => esc_html__('Ascending', 'traveler'),
                        'DESC' => esc_html__('Descending', 'traveler'),
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
                    'label_block' => true,
                    'options' => [
                        ''  => esc_html__('None', 'traveler'),
                        'ID' => esc_html__('ID', 'traveler'),
                        'title' => esc_html__('Title', 'traveler'),
                        'name' => esc_html__('Name', 'traveler'),
                        'date' => esc_html__('Date', 'traveler'),
                        'post__in' => esc_html__('Preserve post ID', 'traveler'),
                    ],
                    'frontend_available' => true,
                ]
            );
            $this->add_control(
                'post_ids',
                [
                    'label' => esc_html__('Choose item', 'traveler'),
                    'description' => esc_html__('Orderby Post in', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'post',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'orderby' => 'post__in',
                    ]
                ]
            );
            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => $settings_slider_condition
                ]
            );
            $this->add_control(
                'center_slider',
                [
                    'label' => esc_html__('Center', 'traveler'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__('On', 'traveler'),
                        'off' => esc_html__('Off', 'traveler'),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_responsive_control(
                'width_slider_center',
                [
                    'label' => esc_html__('Set width slider item center', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 500,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 75,
                    ],
                    'condition' => [
                        'center_slider' => 'on'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-sliders .swiper-slide' => 'width: {{SIZE}}{{UNIT}} !important;',
                    ],
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
                        'on'  => esc_html__('On', 'traveler'),
                        'off' => esc_html__('Off', 'traveler'),
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
                        'on'  => esc_html__('On', 'traveler'),
                        'off' => esc_html__('Off', 'traveler'),
                    ],
                    'default' => 'on',
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
                        'on'  => esc_html__('On', 'traveler'),
                        'off' => esc_html__('Off', 'traveler'),
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
                        'true'  => esc_html__('On', 'traveler'),
                        'false' => esc_html__('Off', 'traveler'),
                    ],
                    'default' => 'false',
                    'condition' => [
                        'auto_play' => 'on',
                        'layout_style!' => $settings_slider_loop_condition,
                        
                    ]
                ]
            );


            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_blog_list_view', ST_Elementor::view('blog-list.template', $settings, true), $settings);
        }
    }
}

<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Sliders_Element')) {
    class ST_Sliders_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_sliders';
        }

        public function get_title()
        {
            return esc_html__('Sliders', 'traveler');
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

        protected function register_controls()
        {
            $st_style_slider = apply_filters('st_style_slider', [
                'style-1'  => esc_html__( 'Style 1', 'traveler' ),
                'style-2'  => esc_html__( 'Style 2', 'traveler' ),
                'style-3'  => esc_html__( 'Style 3', 'traveler' ),
            ]);
            $stt_st_sliders = apply_filters('stt_st_sliders', [
                'style_slider' => ['style-1','style-2']
            ]);
            $this->start_controls_section(
                'settings_section',
                [
                    'label' => esc_html__('Settings', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );
            $this->add_control(
                'style_slider',
                [
                    'label' => esc_html__('Style slider', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => $st_style_slider,
                    'default' => 'style-1',
                ]
            );
            $this->add_control(
                'st_sliders',
                [
                    'label' => esc_html__( 'Add Images Slider', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::GALLERY,
                    'condition' => $stt_st_sliders,
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'title', [
                    'label' => esc_html__( 'Title', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => '',
                ]
            );

            $repeater->add_control(
                'url', [
                    'label' => esc_html__( 'Url', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
                    ],
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'image',
                    [
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'label' => esc_html__( 'Choose Image', 'traveler' ),
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ]
                    ]
            );

            $this->add_control(
                'list_st_sliders',
                [
                    'label' => esc_html__( 'List Slider', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ title }}}',
                    'condition' => [
                        'style_slider' => 'style-3'
                    ],
                ]
            );


            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT,
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
                        'on'  => esc_html__( 'On', 'traveler' ),
                        'off' => esc_html__( 'Off', 'traveler' ),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
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
                        '{{WRAPPER}} .st-sliders .swiper-slide' => 'width: {{SIZE}}{{UNIT}};',
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
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler'),
                    'label_block' => true,
                    'default' => '1',
                    'frontend_available' => true,
                    'condition' => [
                        'center_slider!' => 'on'
                    ],
                ]
            );

            $this->end_controls_section();


            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_responsive_control(
                'height_item',
                [
                    'label' => esc_html__('Set height for slider', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 660,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-sliders .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'space_slider',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__( 'Space item', 'traveler' ),
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 50,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                            'step' => 5,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 30,
                    ],
                ]
            );

            $this->add_responsive_control(
                'space_image_and_title',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Space image and title', 'traveler'),
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-list-slider .title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'style_slider' => 'style-3'
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Typography for title', 'traveler'),
                    'selector' => '{{WRAPPER}} .st-list-slider .title span',
                    'condition' => [
                        'style_slider' => 'style-3'
                    ],
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Color for title', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#232323',
                    'selectors' => [
                        '{{WRAPPER}} .st-list-slider .title span' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'style_slider' => 'style-3'
                    ],
                ]
            );
            $this->add_control(
                'title_align',
                [
                    'label' => esc_html__( 'Alignment', 'traveler' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'traveler' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'traveler' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'traveler' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-list-slider .title' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();
            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_slider_view', ST_Elementor::view('sliders.template', $settings, true), $settings);
        }
    }
}

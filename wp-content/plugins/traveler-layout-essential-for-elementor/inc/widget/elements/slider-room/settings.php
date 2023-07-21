<?php
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Slider_Room_Element')) {
    class ST_Slider_Room_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_slider_room';
        }

        public function get_title()
        {
            return esc_html__('ST Slider Room', 'traveler-layout-essential');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_agency_elements'];
        }

        public function get_script_depends()
        {
            return ['swiper'];
        }

        protected function register_controls()
        {
           
            $this->start_controls_section(
                'settings_section',
                [
                    'label' => esc_html__('Settings', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );
            $this->add_control(
                'style_slider',
                [
                    'label' => esc_html__('Style slider', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'style-1'  => esc_html__('Style 1', 'traveler-layout-essential'),
                    ],
                    'default' => 'style-1',
                ]
            );
            $this->add_control(
                'post_ids_room',
                [
                    'label' => esc_html__('Choose item room', 'traveler-layout-essential'),
                    'description' => esc_html__('Choose multi room you need display', 'traveler-layout-essential'),
                    'type' => 'select2_ajax',
                    'post_type' => 'hotel_room',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                ]
            );
            
            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'center_slider',
                [
                    'label' => esc_html__('Center', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__('On', 'traveler-layout-essential'),
                        'off' => esc_html__('Off', 'traveler-layout-essential'),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'width_slider_center',
                [
                    'label' => esc_html__('Set width slider item center', 'traveler-layout-essential'),
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
                    'label' => esc_html__('Pagination', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__('On', 'traveler-layout-essential'),
                        'off' => esc_html__('Off', 'traveler-layout-essential'),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'navigation',
                [
                    'label' => esc_html__('Navigation', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__('On', 'traveler-layout-essential'),
                        'off' => esc_html__('Off', 'traveler-layout-essential'),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'effect_style',
                [
                    'label' => esc_html__('Style Effect', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'creative'  => esc_html__('Creative', 'traveler-layout-essential'),
                        'coverflow' => esc_html__('Coverflow', 'traveler-layout-essential'),
                        'cards' => esc_html__('Cards', 'traveler-layout-essential'),
                    ],
                    'default' => 'creative',
                ]
            );

            $this->add_control(
                'auto_play',
                [
                    'label' => esc_html__('Auto play', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'on'  => esc_html__('On', 'traveler-layout-essential'),
                        'off' => esc_html__('Off', 'traveler-layout-essential'),
                    ],
                    'default' => 'off',
                ]
            );
            $this->add_control(
                'delay',
                [
                    'label' => esc_html__('Delay auto play', 'traveler-layout-essential'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
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
                    'label' => esc_html__('Loop slider', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        'true'  => esc_html__('On', 'traveler-layout-essential'),
                        'false' => esc_html__('Off', 'traveler-layout-essential'),
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
                    'label' => esc_html__('Slides PerView in content', 'traveler-layout-essential'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
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
                'settings_title_section',
                [
                    'label' => esc_html__('Settings Title', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Title Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_slider_room .st-img h3' => 'color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                ]
            );
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .st_slider_room .st-img h3',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                ]
            );

            $this->end_controls_section();
            $this->start_controls_section(
                'settings_button_section',
                [
                    'label' => esc_html__('Settings Button', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'button_color',
                [
                    'label' => esc_html__('Background Button Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_slider_room .st-img .btn' => 'background-color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                ]
            );
            $this->add_control(
                'button_color_hover',
                [
                    'label' => esc_html__('Background Button Hover Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_slider_room .st-img .btn:hover' => 'background-color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                ]
            );
            $this->add_control(
                'button_title_color',
                [
                    'label' => esc_html__('Title Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_slider_room .st-img .btn' => 'color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                ]
            );

           
            $this->add_control(
                'button_title_color_hover',
                [
                    'label' => esc_html__('Title Hover Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_slider_room .st-img .btn:hover' => 'color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                ]
            );
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_title_typography',
                    'selector' => '{{WRAPPER}} .st_slider_room .st-img .btn',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_responsive_control(
                'height_item',
                [
                    'label' => esc_html__('Set height for slider', 'traveler-layout-essential'),
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
                    'label' => esc_html__('Space item', 'traveler-layout-essential'),
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

            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings = array_merge(array('_element' => $this), $settings);
            $style = $settings['style_slider'];
            $stElementorWidget = new ST_Elementor_Widget;
            echo  apply_filters('stt_elementor_slider_room_view', $stElementorWidget->loadTemplate("slider-room/template-$style", $settings), $settings);
        }
    }
}

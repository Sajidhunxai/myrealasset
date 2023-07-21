<?php
use Elementor\Utils;
use Elementor\Repeater;
use \Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Destination_Element')) {
    class ST_Destination_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_destination';
        }

        public function get_title()
        {
            return esc_html__('Destination', 'traveler');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_elements'];
        }

        protected function register_controls()
        {
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
                    'label' => esc_html__('Layout', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'normal'  => esc_html__( 'Normal', 'traveler' ),
                        'slider' => esc_html__( 'Slider', 'traveler' ),
                    ],
                    'default' => 'normal',
                    'frontend_available' => true
                ]
            );
            $this->add_control(
                'style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'normal'  => esc_html__( 'Normal', 'traveler' ),
                        'button' => esc_html__( 'Button', 'traveler' ),
                    ],
                    'default' => 'normal',
                ]
            );

            $this->add_control(
                'ids',
                [
                    'label' => esc_html__('Choose Destination', 'traveler'),
                    'type' => 'select2_ajax',
                    'post_type' => 'location',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                ]
            );
            $this->add_control(
                'position_text',
                [
                    'label' => esc_html__('Postion Text', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'top'  => esc_html__( 'Top', 'traveler' ),
                        'middle' => esc_html__( 'Middle', 'traveler' ),
                        'bottom' => esc_html__( 'Bottom', 'traveler' ),
                    ],
                    'default' => 'middle',
                    'condition' => [
                        'layout_style!' => 'slider'
                    ]
                ]
            );
            $this->add_control(
                'number_show_in_row',
                [
                    'label' => esc_html__('Number item in row', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        '2'  => esc_html__( '2 locations', 'traveler' ),
                        '3' => esc_html__( '3 locations', 'traveler' ),
                        '4' => esc_html__( '4 locations', 'traveler' ),
                    ],
                    'default' => '3',
                    'condition' => [
                        'layout_style!' => 'slider'
                    ]
                ]
            );

            $this->add_control(
                'number_item_show',
                [
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label' => esc_html__( 'Number item to show', 'traveler' ),
                    'options' => [
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                    ],
                    'default' => 6,
                    'condition' => ['layout_style' => ['slider']]
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => ['layout_style' => ['slider']]
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
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Style name destination', 'traveler'),
                    'selector' => '{{WRAPPER}} .st-list-destination .title',
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'number_item_typography',
                    'label' => esc_html__('Style number item service', 'traveler'),
                    'selector' => '{{WRAPPER}} .st-list-destination .desc',
                ]
            );
            $this->add_control(
                'height_item',
                [
                    'label' => esc_html__('Set height for item', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 500,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 100,
                            'max' => 500,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 357,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .destination-item img' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'layout_style!' => 'slider'
                    ]
                ]
            );
            $this->add_responsive_control(
                'space_bottom',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Space bottom', 'traveler'),
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default' => [
                        'size' => 24,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 24,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 10,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .destination-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'layout_style!' => 'slider'
                    ]
                ]
            );
            $this->add_responsive_control(
                'item_margin',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__( 'Space item', 'traveler' ),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '4',
                        'right' => '4',
                        'bottom' => '4',
                        'left' => '4',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .destination-item .desc a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'style' => 'button'
                    ],
                ]
            );
            $this->add_responsive_control(
                'item_padding',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__( 'Padding button', 'traveler' ),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '4',
                        'right' => '4',
                        'bottom' => '4',
                        'left' => '4',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .destination-item .desc a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'style' => 'button'
                    ],
                ]
            );
            $this->add_control(
                'bg_button',
                [
                    'label' => esc_html__( 'Background button', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .destination-item .desc a' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'style' => 'button'
                    ],
                ]
            );
            $this->add_responsive_control(
                'border_radius',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__('Border radius', 'traveler'),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '8',
                        'right' => '8',
                        'bottom' => '8',
                        'left' => '8',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .destination-item .desc a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'style' => 'button'
                    ],
                ]
            );
            $this->end_controls_section();

            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_destination_view', ST_Elementor::view('destination.template', $settings, true), $settings);
        }
    }
}

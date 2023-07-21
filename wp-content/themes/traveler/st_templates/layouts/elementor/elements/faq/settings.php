<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Faq_Element')) {
    class ST_Faq_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_faq';
        }

        public function get_title()
        {
            return esc_html__('Faq', 'traveler');
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
            $layout_style = apply_filters('st_layout_faq_style', [
                'default'  => esc_html__( 'Default', 'traveler' ),
            ]);

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
                    'default' => 'default',
                ]
            );
            $this->add_control(
                'ask_faq',
                [
                    'label' => esc_html__('Ask', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'layout_style' => 'default',
                    ]
                ]
            );
            $this->add_control(
                'question_faq',
                [
                    'label' => esc_html__( 'Question', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'condition' => [
                        'layout_style' => 'default',
                    ]
                ]
            );
            $this->add_control(
                'open_faq', [
                    'label' => esc_html__( 'Open or Close Question Faq', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'true'  => esc_html__( 'Open', 'traveler' ),
                        'false' => esc_html__( 'Close', 'traveler' ),
                    ],
                    'default' => 'false',
                    'condition' => [
                        'layout_style' => 'default',
                    ]
                ]
            );
            
            $repeater = new \Elementor\Repeater();
            $repeater->add_control(
                'label_faq',
                [
                    'label' => esc_html__('Label', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'description' =>  '(Label display for style 3 , style 4, style 8)',
                ]
                
            );
            $repeater->add_control(
                'ask_faq',
                [
                    'label' => esc_html__('Ask', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    
                ]
                
            );
            $repeater->add_control(
                'question_faq',
                [
                    'label' => esc_html__( 'Question', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                   
                ]
            );
            $repeater->add_control(
                'open_faq', [
                    'label' => esc_html__( 'Open or Close Question Faq', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'true'  => esc_html__( 'Open', 'traveler' ),
                        'false' => esc_html__( 'Close', 'traveler' ),
                    ],
                    'default' => 'false',
                    
                ]
            );
            $this->add_control(
                'list_faq',
                [
                    'label' => esc_html__( 'List faq', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ ask_faq }}}',
                    'condition' => [
                        'layout_style!' => 'default',
                    ]
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
                'space_bottom',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Space item', 'traveler-layout-essential'),
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default' => [
                        'size' => 30,
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => 20,
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => 10,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .accordion-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'border_style',
                [
                    'label' => esc_html__('Border Style','traveler'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__( 'None', 'traveler' ),
                        'solid' => _x( 'Solid', 'Border Control', 'traveler' ),
                        'double' => _x( 'Double', 'Border Control', 'traveler' ),
                        'dotted' => _x( 'Dotted', 'Border Control', 'traveler' ),
                        'dashed' => _x( 'Dashed', 'Border Control', 'traveler' ),
                        'groove' => _x( 'Groove', 'Border Control', 'traveler' ),
                    ],
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-item' => 'border-style: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_width',
                [
                    'label' => esc_html__( 'Border Width', 'traveler' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 10,
                        ],
                    ],
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-item' => 'border-width: {{SIZE}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_control(
                'border_color',
                [
                    'label' => esc_html__( 'Border Color', 'traveler' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-item' => 'border-color: {{VALUE}};'
                    ],
                ]
            );
    
            $this->add_control(
                'border_radius', 
                [   
                    'label' => __('Border Radius', 'traveler'), 
                    'type' => \Elementor\Controls_Manager::DIMENSIONS, 
                    'size_units' => ['px', '%'],
                    'default' => [
                        'top' => '8',
                        'right' => '8',
                        'bottom' => '8',
                        'left' => '8',
                        'unit' => 'px',
                        'isLinked' => 'true',
                    ], 
                    'selectors' => [
                        '{{WRAPPER}} .accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                ]
            );
            
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'traveler' ),
                    'selector' => '{{WRAPPER}} .accordion-item',
                ]
            );
            $this->add_responsive_control(
                'item_padding',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__( 'Item padding', 'traveler' ),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '10',
                        'right' => '10',
                        'bottom' => '10',
                        'left' => '10',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'content_padding',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__( 'Content padding', 'traveler' ),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '10',
                        'right' => '10',
                        'bottom' => '10',
                        'left' => '10',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'label_typography',
                    'label' => esc_html__('Typography for label', 'traveler'),
                    'selector' => '{{WRAPPER}} .accordion-item .accordion-button .label',
                ]
            );
            $this->add_control(
                'label_color',
                [
                    'label' => esc_html__( 'Text Color for label', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .accordion-item .accordion-button .label' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'ask_typography',
                    'label' => esc_html__('Typography for ask', 'traveler'),
                    'selector' => '#st-content-wrapper {{WRAPPER}} .accordion-item .accordion-button',
                ]
            );
            $this->add_control(
                'ask_color',
                [
                    'label' => esc_html__( 'Text Color for ask', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-item .accordion-button' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'question_typography',
                    'label' => esc_html__('Typography for question', 'traveler'),
                    'selector' => '#st-content-wrapper {{WRAPPER}} .accordion-item .accordion-body',
                ]
            );
            $this->add_control(
                'question_color',
                [
                    'label' => esc_html__( 'Text Color for question', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '#st-content-wrapper {{WRAPPER}} .accordion-item .accordion-body' => 'color: {{VALUE}};',
                    ],
                ]
            );
            
            $this->end_controls_section();
            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings['id'] = $this->get_id();
            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_faq_view', ST_Elementor::view('faq.template', $settings, true), $settings);
        }
    }
}

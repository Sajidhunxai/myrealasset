<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Text_Shadow;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Counter_Element')) {
   
    class ST_Counter_Element extends \Elementor\Widget_Base
    {
        public function get_name()
        {
            return 'counter';
        }
        public function get_script_depends()
        {
            return [ 'jquery-numerator' ];
        }
        public function get_title()
        {
            return esc_html__('Counter', 'traveler-layout-essential');
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
                    'label' => esc_html__('Settings', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );
           
            $this->add_control(
                'starting_number',
                [
                    'label' => esc_html__('Starting Number', 'elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
    
            $this->add_control(
                'ending_number',
                [
                    'label' => esc_html__('Ending Number', 'elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 100,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $this->add_control(
                'prefix',
                [
                    'label' => esc_html__('Number Prefix', 'elementor'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => '',
                    'placeholder' => 1,
                ]
            );
    
            $this->add_control(
                'suffix',
                [
                    'label' => esc_html__('Number Suffix', 'elementor'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => '',
                    'placeholder' => esc_html__('Plus', 'elementor'),
                ]
            );
    
            $this->add_control(
                'duration',
                [
                    'label' => esc_html__('Animation Duration', 'elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 2000,
                    'min' => 100,
                    'step' => 100,
                ]
            );
    
           
            $this->add_control(
                'title',
                [
                    'label' => esc_html__('Title', 'elementor'),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => esc_html__('Cool Number', 'elementor'),
                    'placeholder' => esc_html__('Cool Number', 'elementor'),
                ]
            );

            $this->add_control(
                'icon_counter',
                [
                    'label' => esc_html__('Icon', 'traveler-layout-essential'),
                    'type' => Controls_Manager::ICONS,
                    'skin' => 'media',
                    'label_block' => true,
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_title',
                [
                    'label' => esc_html__('Title', 'elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            
            $this->add_control(
                'title_position',
                [
                    'label' => esc_html__('Title Position', 'elementor'),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'relative' => esc_html__('Relative', 'traveler-layout-essential'),
                        'absolute'  => esc_html__('Absolute', 'traveler-layout-essential'),
                    ],
                    'default' => 'relative',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-title' => 'position: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_align',
                [
                    'label' => esc_html__('Alignment', 'plugin-name'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'plugin-name'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'plugin-name'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'plugin-name'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-title' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_offset',
                [
                    'label' => esc_html__('Offset', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-title' => 'top: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};transform:translate(-{{SIZE}}{{UNIT}},-{{SIZE}}{{UNIT}});',
                    ],
                    'condition' => [
                        'title_position' => 'absolute'
                    ]
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Text Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_SECONDARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-title' => 'color: {{VALUE}};',
                    ],
                ]
            );

          
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_title',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                    ],
                    'selector' => '{{WRAPPER}} .elementor-counter-title',
                ]
            );
    
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'title_shadow',
                    'selector' => '{{WRAPPER}} .elementor-counter-title',
                ]
            );
            
            $this->end_controls_section();
           
            $this->start_controls_section(
                'section_number',
                [
                    'label' => esc_html__('Number', 'elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography_number',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                    ],
                    'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
                ]
            );
            $this->add_control(
                'number_align',
                [
                    'label' => esc_html__('Alignment', 'plugin-name'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'plugin-name'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'plugin-name'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'plugin-name'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-number-wrapper' => 'justify-content: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'number_color',
                [
                    'label' => esc_html__('Number Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_SECONDARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-counter-number-wrapper' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'number_fill_color',
                [
                    'label' => esc_html__('Number Fill Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_SECONDARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}  .elementor-counter-number-wrapper' => '-webkit-text-fill-color: {{VALUE}};',
                    ],
                    
                ]
            );

            $this->add_control(
                'number_stroke_width',
                [
                    'label' => esc_html__('Number Stroke Width', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}  .elementor-counter-number-wrapper' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                    ],
                    
                ]
            );

            $this->add_control(
                'number_stroke_color',
                [
                    'label' => esc_html__('Number Stroke Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_SECONDARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}  .elementor-counter-number-wrapper' => '-webkit-text-stroke-color: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_responsive_control(
                'number_space',
                [
                    'label' => esc_html__('Number Space', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}  .elementor-counter-number-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    
                ]
            );
            $this->end_controls_section();

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => esc_html__('Icon', 'elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
            $this->add_control(
                'icon_size',
                [
                    'label' => esc_html__('Size', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}  .st-icon-counter i' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'icon_color',
                [
                    'label' => esc_html__('Icon Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_SECONDARY,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-icon-counter i' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'icon_position',
                [
                    'label' => esc_html__('Icon Position', 'elementor'),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'top' => esc_html__('Top', 'traveler-layout-essential'),
                        'left' => esc_html__('Left', 'traveler-layout-essential'),
                        'absolute'  => esc_html__('Absolute', 'traveler-layout-essential'),
                    ],
                    'default' => 'top',
                ]
            );
            $this->add_control(
                'icon_offset',
                [
                    'label' => esc_html__('Offset', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-icon-counter' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'icon_position' => 'absolute'
                    ]
                ]
            );
            $this->add_control(
                'icon_align',
                [
                    'label' => esc_html__('Alignment', 'plugin-name'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'plugin-name'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'plugin-name'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'plugin-name'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .st-icon-counter' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'icon_space',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__('Item margin', 'traveler-layout-essential'),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '0',
                        'right' => '0',
                        'bottom' => '0',
                        'left' => '0',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-icon-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
          
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings['id'] = $this->get_id();
        
            $settings = array_merge($settings, array('_element' => $this));
            $stElementorWidget = new ST_Elementor_Widget;
           
            echo $stElementorWidget->loadTemplate('counter/template', $settings);
        }
    }
}

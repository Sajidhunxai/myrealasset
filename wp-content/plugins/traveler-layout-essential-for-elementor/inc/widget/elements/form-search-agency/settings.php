<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Form_Search_Agency_Element')) {
 
    class ST_Form_Search_Agency_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
           
            return 'st_search_agency';
        }

        public function get_title()
        {
            return esc_html__('Form Search Room/Rental', 'traveler-layout-essential');
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
            return ['st-search-agency'];
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


            $this->add_control('link_page_search', [
                'label' => esc_html__('Link page search', 'traveler-layout-essential'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => ST_Elementor::listPageSelectionName(),
                'default' => '',
            ]);

            $this->add_control('type', [
                'label' => esc_html__('Type', 'traveler-layout-essential'),
                'type' => 'select',
                'options' => [
                    'search_room' => esc_html__('Search room', 'traveler-layout-essential'),
                    'search_rental' => esc_html__('Search rental', 'traveler-layout-essential'),
                ],
                'default' => 'search_room',
                'frontend_available' => true
            ]);

            $this->add_control('layout', [
                'label' => esc_html__('Layout', 'traveler-layout-essential'),
                'type' => 'select',
                'options' => [
                    'style1' => esc_html__('Style 1', 'traveler-layout-essential'),
                    'style2' => esc_html__('Style 2', 'traveler-layout-essential'),
                    'style3' => esc_html__('Style 3', 'traveler-layout-essential'),
                ],
                'default' => 'style1',
                'frontend_available' => true
            ]);

            $this->end_controls_section();
            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'default' => 'single',
                ]
            );
            $this->add_control(
                'border_type',
                [
                    'label' => esc_html__('Border Type', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__('None', 'elementor'),
                        'solid' => _x('Solid', 'Border Control', 'elementor'),
                        'double' => _x('Double', 'Border Control', 'elementor'),
                        'dotted' => _x('Dotted', 'Border Control', 'elementor'),
                        'dashed' => _x('Dashed', 'Border Control', 'elementor'),
                        'groove' => _x('Groove', 'Border Control', 'elementor'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .st-search-form-el .st-search-el .search-form' => 'border-style: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'border_width',
                [
                    'label' => esc_html__('Border Width', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .st-search-form-el .st-search-el .search-form' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'border_type!' => '',
                    ],
                    
                ]
            );
            $this->add_control(
                'border_color',
                [
                    'label' => esc_html__('Border Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st-search-form-el .st-search-el .search-form' => 'border-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'border_type!' => '',
                    ],
                ]
            );
            $this->add_responsive_control(
                'border_radius',
                [
                    'label' => esc_html__('Border Radius', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .st-search-form-el .st-search-el .search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                   
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'section_normal_box_shadow',
                    'label' => esc_html__('Box Shadow', 'elementor-pro'),
                    'selector' => '{{WRAPPER}} .st-search-form-el',
                ]
            );

            $this->add_control(
                'bg_color',
                [
                    'label' => esc_html__('Background Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st-search-form-el .search-form' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .search-form form .form-group' => 'background: none;'
                    ],
                    'condition' => [
                        'layout' => 'style1',
                    ],
                    
                ]
            );
            $this->add_control(
                'bg_color_style2',
                [
                    'label' => esc_html__('Background Color Style 2', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room.style2 .search-form form .form-group.form-date-search .date-wrapper' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .st_search_room.style2 .search-form form .form-group.field-guest' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .search-form form .form-group,.st_search_room .st-search-el .search-form' => 'background: none;'
                    ],
                    'condition' => [
                        'layout' => 'style2',
                    ],
                ]
            );
            $this->add_control(
                'icon_color',
                [
                    'label' => esc_html__('Icon Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'var(--grey-color,#5E6D77)',
                    'selectors' => [
                        '{{WRAPPER}} .has-icon svg path' => 'fill: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'label_color',
                [
                    'label' => esc_html__('Label Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'var(--grey-color,#5E6D77)',
                    'selectors' => [
                        '{{WRAPPER}} .st-search-el .search-form form .check-in-wrapper > label' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .st-search-el .search-form form .st-form-dropdown-icon > label' => 'color: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'text_color',
                [
                    'label' => esc_html__('Text Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .search-form form .form-group.form-date-search .date-wrapper .render' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .search-form form .form-group.field-guest .render span' => 'color: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->end_controls_section();
            $this->start_controls_section(
                'style_button_section',
                [
                    'label' => esc_html__('Style Button', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'default' => 'single',
                ]
            );
            $this->add_control(
                'bg_button_color',
                [
                    'label' => esc_html__('Background Button Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'var(--main-color, #3B71FE)',
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room .search-form form .form-button .btn' => 'background: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'bg_button_color_hover',
                [
                    'label' => esc_html__('Background Button Color Hover', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'var(--main-color, #3B71FE)',
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room .search-form form .form-button .btn:hover' => 'background: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Title Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room .search-form form .form-button:hover' => 'color: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_control(
                'title_color_hover',
                [
                    'label' => esc_html__('Title Color Hover', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room .search-form form .form-button:hover' => 'color: {{VALUE}};',
                    ],
                    
                ]
            );
            $this->add_responsive_control(
                'button_padding',
                [
                    'label' => esc_html__('Padding Button', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .st_search_room.style2 .search-form form .form-button .btn.btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                   
                ]
            );
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $settings = array_merge(array('_element' => $this), $settings);
            $stElementorWidget = new ST_Elementor_Widget;
            echo  apply_filters('stt_elementor_search_agency_view', $stElementorWidget->loadTemplate('form-search-agency/template', $settings), $settings);
        }
    }
}

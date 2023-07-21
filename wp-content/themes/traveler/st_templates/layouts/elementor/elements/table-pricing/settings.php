<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Table_Pricing_Element')) {
    class ST_Table_Pricing_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_table_pricing';
        }

        public function get_title()
        {
            return esc_html__('Table Pricing', 'traveler');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_elements'];
        }

        public function st_get_packpage() {
            $cls_packages = STAdminPackages::get_inst();
            $packages = $cls_packages->get_packages();
            $arr_package = array();
            foreach ($packages as $key => $value) {
                $arr_package[$value->id] = $value->package_name;
            }
            $arr_package['no'] =  __('Setting', 'traveler');
            return $arr_package;
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
                'layout', [
                    'label' => esc_html__( 'Layout Style', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'style1'  => esc_html__( 'Style 1', 'traveler' ),
                        'style2' => esc_html__( 'Style 2', 'traveler' ),
                    ],
                    'default' => 'style1',
                ]
            );
            $this->add_control(
                'id_package',
                [
                    'label' => esc_html__('Member Package', 'traveler'),
                    'description' => esc_html__('Choose member package', 'traveler'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => $this->st_get_packpage(),
                    'default' => 'no'
                ]
            );
            $this->add_control(
                'title_table',
                [
                    'label' => esc_html__('Title table', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'id_package' => 'no'
                    ]
                ]
            );
            $this->add_control(
                'st_images_icon',
                [
                    'label' => esc_html__( 'Icon image', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'layout!' => 'style2',
                    ]
                ]
            );
            $this->add_control(
                'sale_member',
                [
                    'label' => esc_html__('Enter number sale', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'frontend_available' => true,
                    'condition' => [
                        'id_package' => 'no'
                    ]
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'check', [
                    'label' => esc_html__( 'Support', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'check'  => esc_html__( 'Check', 'traveler' ),
                        'no' => esc_html__( 'No check', 'traveler' ),
                    ],
                    'default' => 'check',
                ]
            );
            $repeater->add_control(
                'title_items', [
                    'label' => esc_html__( 'Title item', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'list_support',
                [
                    'label' => esc_html__( 'List item', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ title_items }}}',
                ]
            );

            $this->add_control(
                'text_button',
                [
                    'label' => esc_html__('Text button', 'traveler'),
                    'description' => esc_html__('Choose Text button', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => esc_html__('Get started', 'traveler'),
                    'condition' => [
                        'id_package' => 'no'
                    ]
                ]
            );
            $this->add_control(
                'url_button',
                [
                    'label' => esc_html__('URL button', 'traveler'),
                    'description' => esc_html__('URL redirect', 'traveler'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'label_block' => true,
                    'condition' => [
                        'id_package' => 'no'
                    ]
                ]
            );

            

            $this->end_controls_section();

            $this->start_controls_section(
                'style_section_general',
                [
                    'label' => esc_html__('General Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography_general',
                    'label' => esc_html__('Typography', 'traveler'),
                    'selector' => '{{WRAPPER}} .item-member-ship',
                ]
            );
            $this->add_control(
                'general_color',
                [
                    'label' => esc_html__( 'Text Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .item-member-ship .item-st .title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .item-member-ship .item-st .price span' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .add_cart_package_new' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'general_background_color',
                [
                    'label' => esc_html__( 'Background Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship .item-st' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_style_general',
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
                        '{{WRAPPER}} .item-member-ship > .item-st' => 'border-style: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_width_general',
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
                        '{{WRAPPER}} .item-member-ship > .item-st' => 'border-width: {{SIZE}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_control(
                'border_color_general',
                [
                    'label' => esc_html__( 'Border Color', 'traveler' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship > .item-st' => 'border-color: {{VALUE}};'
                    ],
                ]
            );
            $this->add_control(
                'border_radius_general', 
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
                        '{{WRAPPER}} .item-member-ship > .item-st' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow_general',
                    'label' => esc_html__( 'Box Shadow', 'traveler' ),
                    'selector' => '{{WRAPPER}} .item-member-ship > .item-st',
                ]
            );
            $this->end_controls_section();

            $this->start_controls_section(
                'style_section_other',
                [
                    'label' => esc_html__('Title Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Title Typography', 'traveler'),
                    'selector' => '{{WRAPPER}} .item-member-ship .item-st .title',
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Title Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship .item-st .title' => 'color: {{VALUE}};',
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
                        '{{WRAPPER}} .item-member-ship .item-st .title' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_space_top',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Title Space top', 'traveler'),
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
                        '{{WRAPPER}} .item-member-ship .item-st .title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'title_space_bottom',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Title Space bottom', 'traveler'),
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
                        '{{WRAPPER}} .item-member-ship .item-st .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();
            
            

            $this->start_controls_section(
                'style_section_price',
                [
                    'label' => esc_html__('Price Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'price_typography',
                    'label' => esc_html__('Price Typography', 'traveler'),
                    'selector' => '{{WRAPPER}} .item-member-ship .item-st .price span',
                ]
            );
            $this->add_control(
                'price_color',
                [
                    'label' => esc_html__( 'Price Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship .item-st .price span' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'price_align',
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
                        '{{WRAPPER}} .item-member-ship .item-st .price' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'style_section_time_packpage',
                [
                    'label' => esc_html__('Time Packpage Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'time_packpage_typography',
                    'label' => esc_html__('Time Packpage Typography', 'traveler'),
                    'selector' => '{{WRAPPER}} .item-member-ship .item-st .price .time-packpage',
                ]
            );
            $this->add_control(
                'time_packpage_color',
                [
                    'label' => esc_html__( 'Time Packpage Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .item-member-ship .item-st .price .time-packpage' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'time_packpage_align',
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
                        '{{WRAPPER}} .item-member-ship .item-st .price .time-packpage' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            
            $this->end_controls_section();

            $this->start_controls_section(
                'style_section_button',
                [
                    'label' => esc_html__('Button Style', 'traveler'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => esc_html__('Button Typography', 'traveler'),
                    'selector' => '{{WRAPPER}} .add_cart_package_new',
                ]
            );
            $this->add_control(
                'button_color',
                [
                    'label' => esc_html__( 'Button Color', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .add_cart_package_new' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'button_align',
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
                        '{{WRAPPER}} .add_cart_package_new' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_radius_button', 
                [   
                    'label' => __('Button Border Radius', 'traveler'), 
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
                        '{{WRAPPER}} .button-get' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                        ]
                ]
            );

            $this->end_controls_section();
        }


        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            echo apply_filters('stt_elementor_table_pricing_view', ST_Elementor::view('table-pricing.template', $settings, true), $settings);
        }
    }
}

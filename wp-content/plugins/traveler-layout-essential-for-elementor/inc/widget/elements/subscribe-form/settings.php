<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Subscribe_Form_Element')) {
   
    class ST_Subscribe_Form_Element extends \Elementor\Widget_Base
    {
        public function get_name()
        {
            return 'st-subscribe-form';
        }

        public function get_title()
        {
            return esc_html__('Subscribe Form', 'traveler-layout-essential');
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
                'st_style_form',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'style-1'  => esc_html__('Style 1', 'traveler-layout-essential'),
                        'style-2' => esc_html__('Style 2', 'traveler-layout-essential'),
                        'style-3' => esc_html__('Style 3', 'traveler-layout-essential'),
                    ],
                    'default' => 'style-1',
                ]
            );
            $this->add_control(
                'text_email',
                [
                    'label' => esc_html__('Text Email', 'traveler-layout-essential'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Your email', 'traveler-layout-essential'),
                    'label_block' => true
                ]
            );

            $this->add_control(
                'text_button',
                [
                    'label' => esc_html__('Button Text', 'traveler-layout-essential'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('Subscribe', 'traveler-layout-essential'),
                    'label_block' => true
                ]
            );
            $this->add_control(
                'icon_button',
                [
                    'label' => esc_html__('Button Icon', 'traveler-layout-essential'),
                    'type' => Controls_Manager::ICONS,
                    'skin' => 'media',
                    'label_block' => true,
                ]
            );
            $this->add_control(
                'key_api_mailchimp',
                [
                    'label' => esc_html__('Key Api Mailchimp', 'traveler-layout-essential'),
                    'description' => esc_html__('https://us3.admin.mailchimp.com/account/api/', 'traveler-layout-essential'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('', 'traveler-layout-essential'),
                    'label_block' => true
                ]
            );

            $this->add_control(
                'id_list_mailchimp',
                [
                    'label' => esc_html__('ID List in Mailchimp (Id Audience)', 'traveler-layout-essential'),
                    'description' => esc_html__('https://us3.admin.mailchimp.com/lists/', 'traveler-layout-essential'),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__('', 'traveler-layout-essential'),
                    'label_block' => true
                ]
            );
            $this->add_control(
                'status_email',
                [
                    'label' => esc_html__('Status Mailchimp', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'subscribed'  => esc_html__('Subscribed', 'traveler-layout-essential'),
                        'unsubscribed' => esc_html__('Unsubscribed', 'traveler-layout-essential'),
                        'cleaned' => esc_html__('Cleaned', 'traveler-layout-essential'),
                        'pending' => esc_html__('Pending', 'traveler-layout-essential'),
                    ],
                    'default' => 'subscribed',
                    'label_block' => true
                ]
            );
            $this->end_controls_section();

            $this->start_controls_section(
                'layout_section',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );
            $this->add_control(
                'input_heading',
                [
                    'label' => esc_html__('Input Style', 'traveler-layout-essential'),
                    'type' => Controls_Manager::HEADING,
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__('Input Typography', 'traveler-layout-essential'),
                    'name' => 'input_typo',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input::placeholder',
                ]
            );
            $this->add_control(
                'input_text_color',
                [
                    'label' => esc_html__('Input Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input::placeholder' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'input_background_color',
                [
                    'label' => esc_html__('Input Background Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

        
            $this->add_responsive_control(
                'input_padding',
                [
                    'label' => esc_html__('Input Padding', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'input_border',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input',
                    'separator' => 'before',
                ]
            );


            $this->add_control(
                'input_border_radius',
                [
                    'label' => esc_html__('Input Border Radius', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'input_width',
                [
                    'label' => esc_html__('Input Width', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'tablet_default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'mobile_default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'input_box_shadow',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form .form-input',
                ]
            );

            $this->add_control(
                'button_heading',
                [
                    'label' => esc_html__('Submit Button Style', 'traveler-layout-essential'),
                    'type' => Controls_Manager::HEADING,
                ]
            );


            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__('Button Typography', 'traveler-layout-essential'),
                    'name' => 'button_typo',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]',
                ]
            );

            $this->add_control(
                'button_text_color',
                [
                    'label' => esc_html__('Button Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_background_color',
                [
                    'label' => esc_html__('Button Background Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_hover_background_color',
                [
                    'label' => esc_html__('Button Hover Background Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'button_border',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]',
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'button_hover_border_color',
                [
                    'label' => esc_html__('Button Hover Border Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]:hover' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'button_padding',
                [
                    'label' => esc_html__('Button Padding', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'button_margin',
                [
                    'label' => esc_html__('Button Margin', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'button_border_radius',
                [
                    'label' => esc_html__('Button Border Radius', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'button_box_shadow',
                    'selector' => '{{WRAPPER}} .stt-subscribe-form-wrapper .traveler-form button[type="submit"]',
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
            echo $stElementorWidget->loadTemplate('subscribe-form/template', $settings);
        }
    }
}

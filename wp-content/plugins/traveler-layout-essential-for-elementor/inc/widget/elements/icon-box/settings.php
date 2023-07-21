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

if (!class_exists('ST_Icon_Box_Element')) {
   
    class ST_Icon_Box_Element extends \Elementor\Widget_Base
    {
        public function get_name()
        {
            return 'icon-box';
        }
     
        public function get_title()
        {
            return esc_html__('Icon box', 'traveler-layout-essential');
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
                'section_icon',
                [
                    'label' => esc_html__('Icon Box', 'traveler-layout-essential'),
                ]
            );
    
            $this->add_control(
                'selected_icon',
                [
                    'label' => esc_html__('Icon', 'traveler-layout-essential'),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'fa-solid',
                    ],
                ]
            );
    
            $this->add_control(
                'view',
                [
                    'label' => esc_html__('View', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'default' => esc_html__('Default', 'traveler-layout-essential'),
                        'stacked' => esc_html__('Stacked', 'traveler-layout-essential'),
                        'framed' => esc_html__('Framed', 'traveler-layout-essential'),
                    ],
                    'default' => 'default',
                    'prefix_class' => 'elementor-view-',
                ]
            );
    
            $this->add_control(
                'shape',
                [
                    'label' => esc_html__('Shape', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'circle' => esc_html__('Circle', 'traveler-layout-essential'),
                        'square' => esc_html__('Square', 'traveler-layout-essential'),
                    ],
                    'default' => 'circle',
                    'condition' => [
                        'view!' => 'default',
                        'selected_icon[value]!' => '',
                    ],
                    'prefix_class' => 'elementor-shape-',
                ]
            );
    
            $this->add_control(
                'title_text',
                [
                    'label' => esc_html__('Title & Description', 'traveler-layout-essential'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => esc_html__('This is the heading', 'traveler-layout-essential'),
                    'placeholder' => esc_html__('Enter your title', 'traveler-layout-essential'),
                    'label_block' => true,
                ]
            );
    
            $this->add_control(
                'description_text',
                [
                    'label' => '',
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor'),
                    'placeholder' => esc_html__('Enter your description', 'elementor'),
                    'rows' => 10,
                    'separator' => 'none',
                    'show_label' => false,
                ]
            );
    
            $this->add_control(
                'link',
                [
                    'label' => esc_html__('Link', 'traveler-layout-essential'),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => esc_html__('https://your-link.com', 'traveler-layout-essential'),
                    'separator' => 'before',
                ]
            );
    
            $this->add_responsive_control(
                'position',
                [
                    'label' => esc_html__('Icon Position', 'traveler-layout-essential'),
                    'type' => Controls_Manager::CHOOSE,
                    'mobile_default' => 'top',
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'traveler-layout-essential'),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'top' => [
                            'title' => esc_html__('Top', 'traveler-layout-essential'),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'traveler-layout-essential'),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'prefix_class' => 'elementor%s-position-',
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'selected_icon[value]',
                                'operator' => '!=',
                                'value' => '',
                            ],
                        ],
                    ],
                ]
            );
            
            $this->add_control(
                'show_before_title',
                [
                    'label' => esc_html__('Show Before Title', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Show', 'traveler-layout-essential'),
                    'label_off' => esc_html__('Hide', 'traveler-layout-essential'),
                    'return_value' => 'yes',
                    'default' => 'no',
                    
                ]
            );
    
            $this->add_control(
                'title_size',
                [
                    'label' => esc_html__('Title HTML Tag', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                        'div' => 'div',
                        'span' => 'span',
                        'p' => 'p',
                    ],
                    'default' => 'h3',
                ]
            );
    
            $this->end_controls_section();
    
            $this->start_controls_section(
                'section_style_icon',
                [
                    'label' => esc_html__('Icon', 'traveler-layout-essential'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'selected_icon[value]',
                                'operator' => '!=',
                                'value' => '',
                            ],
                        ],
                    ],
                ]
            );
    
            $this->start_controls_tabs('icon_colors');
    
            $this->start_controls_tab(
                'icon_colors_normal',
                [
                    'label' => esc_html__('Normal', 'traveler-layout-essential'),
                ]
            );
    
            $this->add_control(
                'primary_color',
                [
                    'label' => esc_html__('Primary Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => Global_Colors::COLOR_PRIMARY,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                    ],
                ]
            );
    
            $this->add_control(
                'secondary_color',
                [
                    'label' => esc_html__('Secondary Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'view!' => 'default',
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    ],
                ]
            );
    
            $this->end_controls_tab();
    
            $this->start_controls_tab(
                'icon_colors_hover',
                [
                    'label' => esc_html__('Hover', 'traveler-layout-essential'),
                ]
            );
    
            $this->add_control(
                'hover_primary_color',
                [
                    'label' => esc_html__('Primary Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                    ],
                ]
            );
    
            $this->add_control(
                'hover_secondary_color',
                [
                    'label' => esc_html__('Secondary Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'condition' => [
                        'view!' => 'default',
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    ],
                ]
            );
    
            $this->add_control(
                'hover_animation',
                [
                    'label' => esc_html__('Hover Animation', 'traveler-layout-essential'),
                    'type' => Controls_Manager::HOVER_ANIMATION,
                ]
            );
            
           
            $this->end_controls_tab();
    
            $this->end_controls_tabs();
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'icon_box_shadow',
                    'selector' => '{{WRAPPER}} .elementor-icon',
                ]
            );
            $this->add_responsive_control(
                'item_padding',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__('Item padding', 'traveler-layout-essential'),
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
                        '{{WRAPPER}} .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'icon_space',
                [
                    'label' => esc_html__('Spacing', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 15,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => '--icon-box-icon-margin: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );
    
            $this->add_responsive_control(
                'icon_size',
                [
                    'label' => esc_html__('Size', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 6,
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
    
            $this->add_responsive_control(
                'icon_padding',
                [
                    'label' => esc_html__('Padding', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'em' => [
                            'min' => 0,
                            'max' => 5,
                        ],
                    ],
                    'condition' => [
                        'view!' => 'default',
                    ],
                ]
            );
    
            $active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();
    
            $rotate_device_args = [];
    
            $rotate_device_settings = [
                'default' => [
                    'unit' => 'deg',
                    'size' => '',
                ],
            ];
    
            foreach ($active_breakpoints as $breakpoint_name => $breakpoint) {
                $rotate_device_args[ $breakpoint_name ] = $rotate_device_settings;
            }
    
            $this->add_responsive_control(
                'rotate',
                [
                    'label' => esc_html__('Rotate', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'deg' ],
                    'range' => [
                        'deg' => [
                            'min' => 0,
                            'max' => 360,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'deg',
                        'size' => '',
                    ],
                    'device_args' => $rotate_device_args,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                    ],
                ]
            );
    
            $this->add_responsive_control(
                'border_width',
                [
                    'label' => esc_html__('Border Width', 'traveler-layout-essential'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'view' => 'framed',
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
                        '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'view!' => 'default',
                    ],
                ]
            );
    
            $this->end_controls_section();
    
            $this->start_controls_section(
                'section_style_content',
                [
                    'label' => esc_html__('Content', 'traveler-layout-essential'),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );
    
            $this->add_responsive_control(
                'text_align',
                [
                    'label' => esc_html__('Alignment', 'traveler-layout-essential'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'traveler-layout-essential'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'traveler-layout-essential'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__('Right', 'traveler-layout-essential'),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__('Justified', 'traveler-layout-essential'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-wrapper' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
    
            $this->add_control(
                'content_vertical_alignment',
                [
                    'label' => esc_html__('Vertical Alignment', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'top' => esc_html__('Top', 'traveler-layout-essential'),
                        'middle' => esc_html__('Middle', 'traveler-layout-essential'),
                        'bottom' => esc_html__('Bottom', 'traveler-layout-essential'),
                    ],
                    'default' => 'top',
                    'prefix_class' => 'elementor-vertical-align-',
                ]
            );
    
            $this->add_control(
                'heading_title',
                [
                    'label' => esc_html__('Title', 'traveler-layout-essential'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
    
            $this->add_responsive_control(
                'title_bottom_space',
                [
                    'label' => esc_html__('Spacing', 'traveler-layout-essential'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
    
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-title' => 'color: {{VALUE}};',
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
                    'selector' => '{{WRAPPER}} .elementor-icon-box-title, {{WRAPPER}} .elementor-icon-box-title a',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                ]
            );
    
            $this->add_group_control(
                Group_Control_Text_Stroke::get_type(),
                [
                    'name' => 'text_stroke',
                    'selector' => '{{WRAPPER}} .elementor-icon-box-title',
                ]
            );
    
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'title_shadow',
                    'selector' => '{{WRAPPER}} .elementor-icon-box-title',
                ]
            );
    
            $this->add_control(
                'heading_description',
                [
                    'label' => esc_html__('Description', 'traveler-layout-essential'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
    
            $this->add_control(
                'description_color',
                [
                    'label' => esc_html__('Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .elementor-icon-box-description' => 'color: {{VALUE}};',
                    ],
                    'global' => [
                        'default' => Global_Colors::COLOR_TEXT,
                    ],
                ]
            );
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'selector' => '{{WRAPPER}} .elementor-icon-box-description',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_TEXT,
                    ],
                ]
            );
    
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'description_shadow',
                    'selector' => '{{WRAPPER}} .elementor-icon-box-description',
                ]
            );
    
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
    
            $this->add_render_attribute('icon', 'class', [ 'elementor-icon', 'elementor-animation-' . $settings['hover_animation'] ]);
    
            $icon_tag = 'span';
    
            if (! isset($settings['icon']) && ! Icons_Manager::is_migration_allowed()) {
                // add old default
                $settings['icon'] = 'fa fa-star';
            }
    
            $has_icon = ! empty($settings['icon']);
    
            if (! empty($settings['link']['url'])) {
                $icon_tag = 'a';
    
                $this->add_link_attributes('link', $settings['link']);
            }
    
            if ($has_icon) {
                $this->add_render_attribute('i', 'class', $settings['icon']);
                $this->add_render_attribute('i', 'aria-hidden', 'true');
            }
    
            $this->add_render_attribute('description_text', 'class', 'elementor-icon-box-description');
    
            $this->add_inline_editing_attributes('title_text', 'none');
            $this->add_inline_editing_attributes('description_text');
            if (! $has_icon && ! empty($settings['selected_icon']['value'])) {
                $has_icon = true;
            }
            $migrated = isset($settings['__fa4_migrated']['selected_icon']);
            $is_new = ! isset($settings['icon']) && Icons_Manager::is_migration_allowed();
    
            ?>
            <div class="elementor-icon-box-wrapper ">
                <?php if ($settings['show_before_title'] ==="no") { ?>
                    <?php if ($has_icon) : ?>
                    <div class="elementor-icon-box-icon">
                        <<?php Utils::print_validated_html_tag($icon_tag); ?> <?php $this->print_render_attribute_string('icon'); ?> <?php $this->print_render_attribute_string('link'); ?>>
                        <?php
                        if ($is_new || $migrated) {
                            Icons_Manager::render_icon($settings['selected_icon'], [ 'aria-hidden' => 'true' ]);
                        } elseif (! empty($settings['icon'])) {
                            ?><i <?php $this->print_render_attribute_string('i'); ?>></i><?php
                        }
                        ?>
                        </<?php Utils::print_validated_html_tag($icon_tag); ?>>
                    </div>
                    <?php endif; ?>
                <?php } ?> 
                <div class="elementor-icon-box-content">
                   <?php if ($settings['show_before_title'] ==="yes") {
                        $style_css = "display:flex;align-items: center;";
                        $class ="icon-left";
                   } else {
                       $style_css = "display:block;";
                       $class="";
                   } ?>
                    <<?php Utils::print_validated_html_tag($settings['title_size']); ?> class="elementor-icon-box-title <?php echo esc_attr($class);?>">
                        <<?php Utils::print_validated_html_tag($icon_tag); ?> <?php $this->print_render_attribute_string('link'); ?> <?php $this->print_render_attribute_string('title_text'); ?> style="<?php echo esc_attr($style_css);?>">
                       
                        <?php if ($settings['show_before_title'] ==="yes") { ?>
                            <?php if ($has_icon) : ?>
                                <div class="elementor-icon-box-icon">
                                    <<?php Utils::print_validated_html_tag($icon_tag); ?> <?php $this->print_render_attribute_string('icon'); ?> <?php $this->print_render_attribute_string('link'); ?>>
                                    <?php
                                    if ($is_new || $migrated) {
                                        Icons_Manager::render_icon($settings['selected_icon'], [ 'aria-hidden' => 'true' ]);
                                    } elseif (! empty($settings['icon'])) {
                                        ?><i <?php $this->print_render_attribute_string('i'); ?>></i><?php
                                    }
                                    ?>
                                    </<?php Utils::print_validated_html_tag($icon_tag); ?>>
                                </div>
                            <?php endif; ?>
                        <?php } ?> <?php $this->print_unescaped_setting('title_text'); ?>
                        </<?php Utils::print_validated_html_tag($icon_tag); ?>>
                    </<?php Utils::print_validated_html_tag($settings['title_size']); ?>>
                    <?php if (! Utils::is_empty($settings['description_text'])) : ?>
                        <p <?php $this->print_render_attribute_string('description_text'); ?>>
                            <?php $this->print_unescaped_setting('description_text'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
            /**
         * Render icon box widget output in the editor.
         *
         * Written as a Backbone JavaScript template and used to generate the live preview.
         *
         * @since 2.9.0
         * @access protected
         */
        protected function content_template()
        {
            ?>
            <#
            var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
                iconTag = link ? 'a' : 'span',
                iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
                migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );

            view.addRenderAttribute( 'description_text', 'class', 'elementor-icon-box-description' );

            view.addInlineEditingAttributes( 'title_text', 'none' );
            view.addInlineEditingAttributes( 'description_text' );
            #>
            <div class="elementor-icon-box-wrapper">
                <?php // settings.icon is needed for older version ?>
                <# if ( settings.icon || settings.selected_icon.value ) { #>
                <div class="elementor-icon-box-icon">
                    <{{{ iconTag + ' ' + link }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}">
                        <# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
                            {{{ iconHTML.value }}}
                            <# } else { #>
                                <i class="{{ settings.icon }}" aria-hidden="true"></i>
                            <# } #>
                    </{{{ iconTag }}}>
                </div>
                <# } #>
                <div class="elementor-icon-box-content">
                    <# var titleSizeTag = elementor.helpers.validateHTMLTag( settings.title_size ); #>
                    <{{{ titleSizeTag }}} class="elementor-icon-box-title">
                        <{{{ iconTag + ' ' + link }}} {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</{{{ iconTag }}}>
                    </{{{ titleSizeTag }}}>
                    <# if ( settings.description_text ) { #>
                    <p {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</p>
                    <# } #>
                </div>
            </div>
            <?php
        }

        public function on_import($element)
        {
            return Icons_Manager::on_import_migration($element, 'icon', 'selected_icon', true);
        }
    }
}

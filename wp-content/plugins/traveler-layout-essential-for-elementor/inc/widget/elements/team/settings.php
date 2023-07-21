<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Team_Element')) {
    class ST_Team_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_team';
        }

        public function get_title()
        {
            return esc_html__('Team', 'traveler-layout-essential');
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
                'st_style_team',
                [
                    'label' => esc_html__('Type', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => [
                        'grid-lib-1'  => esc_html__('Grid style 1', 'traveler-layout-essential'),
                        'grid-lib-2' => esc_html__('Grid style 2', 'traveler-layout-essential'),
                        'grid-lib-3' => esc_html__('Grid style 3', 'traveler-layout-essential'),
                        'slider-lib-1' => esc_html__('Slider style 1', 'traveler-layout-essential'),
                        'slider-lib-2' => esc_html__('Slider style 2', 'traveler-layout-essential'),
                    ],
                    'default' => 'grid-lib-1',
                ]
            );
            $this->add_control(
                'slides_per_view',
                [
                    'label' => esc_html__('Number item in row ', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        '2'  => esc_html__('2 items', 'traveler-layout-essential'),
                        '3' => esc_html__('3 items', 'traveler-layout-essential'),
                        '4' => esc_html__('4 items', 'traveler-layout-essential'),
                    ],
                    'default' => '3',
                    'frontend_available' => true
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'st_avatar_team',
                [
                    'label' => esc_html__('Avatar', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $repeater->add_control(
                'name_team',
                [
                    'label' => esc_html__('Name', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            $repeater->add_control(
                'office_team',
                [
                    'label' => esc_html__('Office', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                    
                ]
            );
    
            $repeater->add_control(
                'content_team',
                [
                    'label' => esc_html__('Content', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );
            $repeater->add_control(
                'link_facebook',
                [
                    'label' => esc_html__('Link facebook', 'traveler-layout-essential'),
                    'description' => esc_html__('Enter Link facebook', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
                    ],
                ]
            );
            $repeater->add_control(
                'link_instagram',
                [
                    'label' => esc_html__('Link instagram', 'traveler-layout-essential'),
                    'description' => esc_html__('Enter Link instagram', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
                    ],
                ]
            );
            $repeater->add_control(
                'link_twitter',
                [
                    'label' => esc_html__('Link twitter', 'traveler-layout-essential'),
                    'description' => esc_html__('Enter Link twitter', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
                    ],
                ]
            );
            $repeater->add_control(
                'link_youtube',
                [
                    'label' => esc_html__('Link link_youtube', 'traveler-layout-essential'),
                    'description' => esc_html__('Enter Link link_youtube', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
                    ],
                ]
            );
            
            $this->add_control(
                'list_team',
                [
                    'label' => esc_html__('List item', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ name_team }}}',
                ]
            );
            $this->end_controls_section();

            //Addvance Slider
            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'st_style_team' => ['slider-lib-1','slider-lib-2']
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
            
            

            $this->end_controls_section();

            //Style
            $this->start_controls_section(
                'style_section',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'default' => 'single',
                ]
            );
            $this->add_responsive_control(
                'space_bottom',
                [
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'label' => esc_html__('Space bottom', 'traveler-layout-essential'),
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
                        '{{WRAPPER}} .item-team' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'st_style_team' => ['grid-lib-1','grid-lib-2','grid-lib-3']
                    ]
                ]
            );
            $this->add_responsive_control(
                'item_padding',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__('Item padding', 'traveler-layout-essential'),
                    'size_units' => [ 'px', 'em', '%' ],
                    'default' => [
                        'top' => '20',
                        'right' => '20',
                        'bottom' => '20',
                        'left' => '20',
                        'unit' => 'px',
                        'isLinked' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .item-team .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
           
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            $layout = $settings["st_style_team"];
            
            $stElementorWidget = new ST_Elementor_Widget;
            echo $stElementorWidget->loadTemplate('team/template-'.$layout, $settings);
        }
    }
}

<?php
use Elementor\Controls_Manager;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Map_Element')) {
    class ST_Map_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'map';
        }

        public function get_title()
        {
            return esc_html__('ST Map', 'traveler-layout-essential');
        }

        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_agency_elements'];
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
                'marker_icon',
                [
                    'label' => esc_html__('Add Images', 'elementor'),
                    'type' => Controls_Manager::MEDIA,
                    'show_label' => false,
                ]
            );
            $this->add_control(
                'lat',
                [
                    'label' => esc_html__('Latitude', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            $this->add_control(
                'lng',
                [
                    'label' => esc_html__('Longitude', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
           
            
            $google_api_key = st()->get_option('st_googlemap_enabled');
            if ($google_api_key === 'on') {
                $this->add_control(
                    'style_map',
                    [
                        'label' => esc_html__('Style Google Map', 'traveler-layout-essential'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'default',
                        'options' => [
                            'default' => esc_html__('Default', 'traveler-layout-essential'),
                            'silver' => esc_html__('Silver', 'traveler-layout-essential'),
                            'night' => esc_html__('Night', 'traveler-layout-essential'),
                            'retro' => esc_html__('Retro', 'traveler-layout-essential'),
                            'hiding' => esc_html__('Hiding', 'traveler-layout-essential'),
                        ],
                    ]
                );
            } else {
                $this->add_control(
                    'style_map',
                    [
                        'label' => esc_html__('Style Map Box', 'traveler-layout-essential'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'mapbox://styles/mapbox/streets-v12',
                        'options' => [
                            'mapbox://styles/mapbox/streets-v12' => esc_html__('Mapbox Streets', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/outdoors-v12' => esc_html__('Mapbox Outdoors', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/light-v11' => esc_html__('Mapbox Light', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/dark-v11' => esc_html__('Mapbox Dark', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/satellite-v9' => esc_html__('Mapbox Satellite', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/satellite-streets-v12' => esc_html__('Mapbox Satellite Streets', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/navigation-day-v1' => esc_html__('Mapbox Navigation Day', 'traveler-layout-essential'),
                            'mapbox://styles/mapbox/navigation-night-v1' => esc_html__('Mapbox Navigation Night', 'traveler-layout-essential'),
                        ],
                    ]
                );
            }
            $this->add_control(
                'pop_content_map',
                [
                    'label' => esc_html__('Box Content Map', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                    'label_block' => true,
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
                        '{{WRAPPER}} #contact-mapbox-new-agency' => 'width:100%; height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} #contact-map-new-agency' => 'width:100%; height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->end_controls_section();
            $this->start_controls_section(
                'style_box_content_section',
                [
                    'label' => esc_html__('Style Box Content', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_responsive_control(
                'width_box',
                [
                    'label' => esc_html__('Set width for box content', 'traveler-layout-essential'),
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
                        'size' => 410,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .box-content-map' => 'width: {{SIZE}}{{UNIT}};',
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
            echo  apply_filters('stt_elementor_map_view', $stElementorWidget->loadTemplate('map/template', $settings), $settings);
        }
    }
}

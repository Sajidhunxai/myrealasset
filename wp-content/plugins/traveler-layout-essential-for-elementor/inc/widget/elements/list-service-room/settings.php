<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_List_Service_Room_Element')) {
    class ST_List_Service_Room_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_list_service_room';
        }

        public function get_title()
        {
            return esc_html__('List item service Room', 'traveler-layout-essential');
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
                'list_style',
                [
                    'label' => esc_html__('Layout', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'grid'  => esc_html__('Grid', 'traveler-layout-essential'),
                        'list' => esc_html__('List', 'traveler-layout-essential'),
                        'slider' => esc_html__('Slider (Not support Mix service)', 'traveler-layout-essential'),
                    ],
                    'default' => 'grid',
                ]
            );
            $this->add_control(
                'style',
                [
                    'label' => esc_html__('Style', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'style_1'  => esc_html__('Style 1', 'traveler-layout-essential'),
                    ],
                    'default' => 'style_1',
                ]
            );

          
            $this->add_control(
                'order',
                [
                    'label' => esc_html__('Order', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'ASC'  => esc_html__('Ascending', 'traveler-layout-essential'),
                        'DESC' => esc_html__('Descending', 'traveler-layout-essential'),
                    ],
                    'default' => 'ASC',
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'orderby',
                [
                    'label' => esc_html__('Orderby', 'traveler-layout-essential'),
                    'type' => 'select',
                    'description' => esc_html__("Order don't work with settings Show Featured Item On Top Results ", 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        ''  => esc_html__('None', 'traveler-layout-essential'),
                        'ID' => esc_html__('ID', 'traveler-layout-essential'),
                        'title' => esc_html__('Title', 'traveler-layout-essential'),
                        'name' => esc_html__('Name', 'traveler-layout-essential'),
                        'date' => esc_html__('Date', 'traveler-layout-essential'),
                        'post__in' => esc_html__('Preserve post ID', 'traveler-layout-essential'),
                    ],
                    'frontend_available' => true,
                ]
            );
           
            $this->add_control(
                'post_ids_room',
                [
                    'label' => esc_html__('Choose item room', 'traveler-layout-essential'),
                    'description' => esc_html__('Orderby Post in', 'traveler-layout-essential'),
                    'type' => 'select2_ajax',
                    'post_type' => 'hotel_room',
                    'callback' => 'ST_Elementor:get_post_ajax',
                    'label_block' => true,
                    'cache' => false,
                    'delay' => 100,
                    'condition' => [
                        'orderby' => 'post__in',
                    ]
                ]
            );
  
            $this->add_control(
                'item_row',
                [
                    'label' => esc_html__('Item in row', 'traveler-layout-essential'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        '1'  => esc_html__('1 items', 'traveler-layout-essential'),
                        '2'  => esc_html__('2 items', 'traveler-layout-essential'),
                        '3' => esc_html__('3 items', 'traveler-layout-essential'),
                        '4' => esc_html__('4 items', 'traveler-layout-essential'),
                    ],
                    'default' => '4',
                    'frontend_available' => true,
                    'condition' => [
                        'list_style' => 'grid',
                    ]
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'settings_slider_section',
                [
                    'label' => esc_html__('Settings Slider', 'traveler-layout-essential'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'list_style' => 'slider'
                    ]
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
                    'type' => 'select',
                    'description' => esc_html__('See the Swiper API documentation https://swiperjs.com/swiper-api', 'traveler-layout-essential'),
                    'label_block' => true,
                    'options' => [
                        '1'  => esc_html__('1 items', 'traveler-layout-essential'),
                        '2'  => esc_html__('2 items', 'traveler-layout-essential'),
                        '3' => esc_html__('3 items', 'traveler-layout-essential'),
                        '4' => esc_html__('4 items', 'traveler-layout-essential'),
                    ],
                    'default' => '4',
                    'frontend_available' => true
                ]
            );

            
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
                'nav_color',
                [
                    'label' => esc_html__('Navigation Color', 'traveler-layout-essential'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .st-button-next span path' => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .st-button-prev span path' => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .swiper-pagination span' => 'background: {{VALUE}};',
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
            echo  apply_filters('stt_elementor_list_service_room_view', $stElementorWidget->loadTemplate('list-service-room/template', $settings), $settings);
        }
    }
}

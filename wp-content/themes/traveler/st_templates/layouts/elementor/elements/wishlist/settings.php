<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Wishlist_Element')) {
    class ST_Wishlist_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_wishlist';
        }

        public function get_title()
        {
            return esc_html__('Wishlist', 'traveler');
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
                'style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'style_1'  => esc_html__( 'Style 1', 'traveler' ),
                        'style_2' => esc_html__( 'Style 2', 'traveler' )
                    ],
                    'default' => 'style_1',
                ]
            );
           
            $this->end_controls_section();

        
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            ST_Elementor::view('wishlist.template', $settings);
        }
    }
}
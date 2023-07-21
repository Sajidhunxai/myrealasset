<?php
use Elementor\Utils;
use \Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!class_exists('ST_Currency_Element')) {
    class ST_Currency_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_currency';
        }

        public function get_title()
        {
            return esc_html__('Currency', 'traveler');
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
                'layout_style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => [
                        'style-1'  => esc_html__( 'Style 1', 'traveler' ),
                    ],
                    'default' => 'style-1',
                    'frontend_available' => true
                ]
            );
            $this->end_controls_section();

            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            ST_Elementor::view('currency.template', $settings);
        }
    }
}

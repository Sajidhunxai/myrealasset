<?php
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Stt_Gallery_Element')) {
    class ST_Stt_Gallery_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_stt_gallery';
        }

        public function get_title()
        {
            return esc_html__('ST Gallery', 'traveler-layout-essential');
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
                 
            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'st_gallery',
                [
                    'label' => esc_html__('Add Images', 'elementor'),
                    'type' => Controls_Manager::GALLERY,
                    'show_label' => false,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
            $repeater->add_control(
                'name_tab_gallery',
                [
                    'label' => esc_html__('Name Tab Gallery', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
            );
            
            
            $this->add_control(
                'list_gallery',
                [
                    'label' => esc_html__('List Gallery', 'traveler-layout-essential'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ name_tab_gallery }}}',
                ]
            );
            $this->end_controls_section();
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            
            $stElementorWidget = new ST_Elementor_Widget;
            echo $stElementorWidget->loadTemplate('stt-gallery/template', $settings);
        }
    }
}

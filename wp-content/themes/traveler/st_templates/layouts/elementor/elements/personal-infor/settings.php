<?php
use Elementor\Utils;
use \Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;

if (!class_exists('ST_Personal_Infor_Element')) {
    class ST_Personal_Infor_Element extends \Elementor\Widget_Base
    {

        public function get_name()
        {
            return 'st_personal_infor';
        }

        public function get_title()
        {
            return esc_html__('Personal Infor', 'traveler');
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
                'personal_style',
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
            $this->add_control(
                'avatar',
                [
                    'label' => esc_html__( 'Choose Image for avatar', 'traveler' ),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
            $this->add_control(
                'name',
                [
                    'label' => esc_html__('Name', 'traveler'),
                    'description' => esc_html__('Enter Name', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                ]
            );
            $this->add_control(
                'position',
                [
                    'label' => esc_html__('Position', 'traveler'),
                    'description' => esc_html__('Enter Position', 'traveler'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                ]
            );
            $this->add_control(
                'link_facebook',
                [
                    'label' => esc_html__('Link facebook', 'traveler'),
                    'description' => esc_html__('Enter Link facebook', 'traveler'),
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
                'link_instagram',
                [
                    'label' => esc_html__('Link instagram', 'traveler'),
                    'description' => esc_html__('Enter Link instagram', 'traveler'),
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
                'link_twitter',
                [
                    'label' => esc_html__('Link twitter', 'traveler'),
                    'description' => esc_html__('Enter Link twitter', 'traveler'),
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
                'link_youtube',
                [
                    'label' => esc_html__('Link link_youtube', 'traveler'),
                    'description' => esc_html__('Enter Link link_youtube', 'traveler'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                        'custom_attributes' => '',
				    ],
                ]
            );
            

            $this->end_controls_section();

            
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();

            $settings = array_merge(array('_element' => $this), $settings);
            ST_Elementor::view('personal-infor.template', $settings);
        }
    }
}

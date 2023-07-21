<?php

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! class_exists( 'ST_Banner_Form_Element' ) ) {
	class ST_Banner_Form_Element extends \Elementor\Widget_Base {


		public function get_name() {
			return 'st_banner_form';
		}

		public function get_title() {
			return esc_html__( 'Form Search', 'traveler' );
		}

		public function get_icon() {
			return 'traveler-elementor-icon';
		}

		public function get_categories() {
			return [ 'st_elements' ];
		}

		public function get_script_depends() {
			return [ 'st-banner-form' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'settings_section',
				[
					'label' => esc_html__( 'Settings', 'traveler' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control('type_form', [
				'label'              => esc_html__( 'Type form search', 'traveler' ),
				'type'               => 'select',
				'label_block'        => true,
				'options'            => [
					'single'      => esc_html__( 'Single', 'traveler' ),
					'mix_service' => esc_html__( 'Mix service', 'traveler' ),
				],
				'default'            => 'single',
				'frontend_available' => true,
			]);

			$this->add_control('services', [
				'label'       => esc_html__( 'Choose service', 'traveler' ),
				'type'        => 'select2_ajax',
				'multiple'    => true,
				'label_block' => true,
				'cache'       => false,
				'post_type'   => 'find_service',
				'callback'    => 'ST_Elementor:get_post_ajax',
				'default'     => [],
				'condition'   => [
					'type_form' => 'mix_service',
				],
			]);

			$this->add_control('service', [
				'label'     => esc_html__( 'Choose service', 'traveler' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => ST_Elementor::listSerrviceSelectionName(),
				'default'   => 'st_hotel',
				'condition' => [
					'type_form' => 'single',
				],
			]);

			$this->add_control('style', [
				'label'              => esc_html__( 'Style', 'traveler' ),
				'type'               => 'select',
				'options'            => [
					'style_1' => esc_html__( 'Style 1', 'traveler' ),
					'style_2' => esc_html__( 'Style 2', 'traveler' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
			]);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$settings = array_merge( [ '_element' => $this ], $settings );
			echo apply_filters( 'stt_elementor_banner_view', ST_Elementor::view( 'banner-form.template', $settings, true ), $settings );
		}
	}
}

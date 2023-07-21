<?php
if ( ! class_exists( 'STT_Hotelv2_Elememtor' ) ) {
	class STT_Hotelv2_Elememtor {

		private static $_inst;

		public function __construct() {
			add_action( 'elementor/widgets/register', [ $this, '_registerWidgets' ] );
			add_filter( 'stt_elementor_banner_view', [ $this, '_addBannerView' ], 10, 2 );
			add_filter( 'stt_elementor_destination_view', [ $this, '_addDestinationView' ], 10, 2 );
			add_filter( 'stt_elementor_list_service_view', [ $this, '_addListServiceView' ], 10, 2 );
			add_filter( 'stt_elementor_testimonial_view', [ $this, '_addTestimonialView' ], 10, 2 );
			add_filter( 'stt_elementor_table_pricing_view', [ $this, '_addTablePricingView' ], 10, 2 );
			add_filter( 'stt_elementor_slider_view', [ $this, '_addSliderView' ], 10, 2 );
		}

		public function _addSliderView( $html, $settings ) {
			if ( isset( $settings['style_slider'] ) && $settings['style_slider'] == 'style-3' ) {

				return stt_elementorv2()->loadView( 'elementors/sliders', $settings );
			}
			return $html;
		}

		public function _addTablePricingView( $html, $settings ) {
			if ( isset( $settings['layout'] ) && $settings['layout'] == 'style2' ) {
				return stt_elementorv2()->loadView( 'elementors/table-pricing', $settings );
			}
			return $html;
		}

		public function _addTestimonialView( $html, $settings ) {
			if ( isset( $settings['st_style_testimonial'] ) && $settings['st_style_testimonial'] == 'slider-3' ) {
				return stt_elementorv2()->loadView( 'elementors/testimonial', $settings );
			}
			return $html;
		}

		public function _addListServiceView( $html, $settings ) {
			if ( isset( $settings['style'] ) && $settings['style'] == 'style_2' ) {
				return stt_elementorv2()->loadView( 'elementors/list-service', $settings );
			}
			return $html;
		}

		public function _addDestinationView( $html, $settings ) {
			if ( isset( $settings['layout_style'] ) && $settings['layout_style'] == 'slider' ) {
				return stt_elementorv2()->loadView( 'elementors/destination', $settings );
			}
			return $html;
		}

		public function _addBannerView( $html, $settings ) {
			if ( isset( $settings['style'] ) && $settings['style'] == 'style_2' ) {
				return stt_elementorv2()->loadView( 'elementors/search-form', $settings );
			}
			return $html;
		}

		public function _registerWidgets( $manager, $folder = '' ) {
			$elementors = glob( STT_Module_Layout::inst()->layoutPath . STT_ElementorV2::inst()->layoutName . '/inc/elementors/*' );
			if ( ! empty( $elementors ) ) {
				foreach ( $elementors as $elementor ) {
					require $elementor;
					$name_name = ucfirst( str_replace( '.php', '', basename( $elementor ) ) );
					$name      = 'STT_ElementorV2_' . $name_name . '_Widget';
					if ( class_exists( $name ) ) {
						\Elementor\Plugin::instance()->widgets_manager->register( new $name() );
					}
				}
			}
		}

		public static function inst() {
			if ( empty( self::$_inst ) ) {
				self::$_inst = new self();
			}
			return self::$_inst;
		}
	}

	STT_Hotelv2_Elememtor::inst();
}

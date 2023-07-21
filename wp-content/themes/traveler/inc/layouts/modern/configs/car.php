<?php

if ( ! class_exists( 'ST_Traveler_Modern_Car_Configs' ) ) {

	class ST_Traveler_Modern_Car_Configs {

		static $_inst;

		function __construct() {

			add_action( 'admin_init', [ $this, 'customMetaBoxSearchResultPage' ] );
		}

		function customMetaBoxSearchResultPage() {
			$array_modern  = [];
			$layout_search = [
				[

					'value' => '1',

					'label' => esc_html__( 'Sidebar Layout', 'traveler' ),

					'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_rs_layout_1.png',

				],

				[

					'value' => '2',

					'label' => esc_html__( 'Topbar Layout', 'traveler' ),

					'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_rs_layout_2.png',

				],

			];

			if ( check_using_elementor() ) {
				$array_modern = [
					[

						'value' => '3',

						'label' => esc_html__( 'Sidebar Layout (Style mordern)', 'traveler' ),

						'src'   => get_template_directory_uri() . '/v2/images/layouts/car_rs_layout_sidebar.png',

					],
					[

						'value' => '4',

						'label' => esc_html__( 'Topbar Layout (Style mordern)', 'traveler' ),

						'src'   => get_template_directory_uri() . '/v2/images/layouts/car_rs_layout_topbar.png',

					],
				];
			}

			$layout_search = array_merge( $layout_search, $array_modern );
			$layout_search = apply_filters( 'st_layout_search_car', $layout_search );

			$meta_data_box = [

				'id'       => 'st_car_search_result_options',

				'title'    => esc_html__( 'Car Search Result Settings', 'traveler' ),

				'desc'     => '',

				'pages'    => [ 'page' ],

				'context'  => 'normal',

				'priority' => 'high',

				'fields'   => [

					[

						'id'    => 'layout_car_tab',

						'label' => esc_html__( 'General', 'traveler' ),

						'type'  => 'tab',

					],

					[

						'id'      => 'rs_layout_car',

						'label'   => esc_html__( 'Choose layout for page', 'traveler' ),

						'desc'    => '',

						'type'    => 'radio-image',

						'section' => 'layout_car_tab',

						'std'     => '1',

						'choices' => $layout_search,

					],

					[

						'id'      => 'rs_style_car',

						'label'   => __( 'Style default', 'traveler' ),

						'desc'    => __( 'Select default style to display in the search result page', 'traveler' ),

						'std'     => 'grid',

						'type'    => 'select',

						'section' => 'layout_car_tab',

						'choices' => [

							[

								'value' => 'grid',

								'label' => __( 'Grid', 'traveler' ),

							],

							[

								'value' => 'list',

								'label' => __( 'List', 'traveler' ),

							],

						],

					],

					[

						'id'    => 'filter_car_tab',

						'label' => esc_html__( 'Filter', 'traveler' ),

						'type'  => 'tab',

					],

					[

						'id'       => 'rs_filter_car',

						'label'    => __( 'Create filter option', 'traveler' ),

						'desc'     => __( 'Create filter option for search page result', 'traveler' ),

						'type'     => 'list-item',

						'section'  => 'filter_car_tab',

						'std'      => [

							[

								'title'                   => 'Filter Price',

								'rs_filter_type'          => 'price',

								'rs_filter_type_taxonomy' => 'hotel_theme',

							],

							[

								'title'                   => 'Categories',

								'rs_filter_type'          => 'taxonomy',

								'rs_filter_type_taxonomy' => 'st_category_cars',

							],

						],

						'settings' => [

							[

								'id'      => 'rs_filter_type',

								'label'   => __( 'Filter item', 'traveler' ),

								'std'     => 'price',

								'type'    => 'select',

								'choices' => [

									[

										'value' => 'price',

										'label' => __( 'Price', 'traveler' ),

									],

									[

										'value' => 'taxonomy',

										'label' => __( 'Taxonomy', 'traveler' ),

									],

								],

							],

							[

								'id'        => 'rs_filter_type_taxonomy',

								'label'     => __( 'Taxonomy select', 'traveler' ),

								'std'       => '',

								'type'      => 'select',

								'condition' => 'rs_filter_type:is(taxonomy)',

								'choices'   => st_get_post_taxonomy( 'st_cars' ),

							],

						],

					],

				],

			];
			$meta_data_box_carstranfer = [

				'id'       => 'st_car_transfer_search_result_options',

				'title'    => esc_html__( 'Car Transfer Search Result Settings', 'traveler' ),

				'desc'     => '',

				'pages'    => [ 'page' ],

				'context'  => 'normal',

				'priority' => 'high',

				'fields'   => [
					[

						'id'    => 'filter_car_transfer_tab',

						'label' => esc_html__( 'Filter', 'traveler' ),

						'type'  => 'tab',

					],

					[

						'id'       => 'rs_filter_car_transfer',

						'label'    => __( 'Create filter option', 'traveler' ),

						'desc'     => __( 'Create filter option for search page result', 'traveler' ),

						'type'     => 'list-item',

						'section'  => 'filter_car_transfer_tab',

						'std'      => [

							[

								'title'                   => 'Filter Price',

								'rs_filter_type'          => 'price',

								'rs_filter_type_taxonomy' => 'hotel_theme',

							],

							[

								'title'                   => 'Categories',

								'rs_filter_type'          => 'taxonomy',

								'rs_filter_type_taxonomy' => 'st_category_cars',

							],

						],

						'settings' => [

							[

								'id'      => 'rs_filter_type',

								'label'   => __( 'Filter item', 'traveler' ),

								'std'     => 'price',

								'type'    => 'select',

								'choices' => [

									[

										'value' => 'price',

										'label' => __( 'Price', 'traveler' ),

									],

									[

										'value' => 'taxonomy',

										'label' => __( 'Taxonomy', 'traveler' ),

									],

								],

							],

							[

								'id'        => 'rs_filter_type_taxonomy',

								'label'     => __( 'Taxonomy select', 'traveler' ),

								'std'       => '',

								'type'      => 'select',

								'condition' => 'rs_filter_type:is(taxonomy)',

								'choices'   => st_get_post_taxonomy( 'st_cars' ),

							],

						],

					],

				],

			];

			if ( function_exists( 'ot_register_meta_box' ) ) {

				ot_register_meta_box( $meta_data_box );
				ot_register_meta_box( $meta_data_box_carstranfer );

			}
		}



		static function inst() {

			if ( ! self::$_inst ) {

				self::$_inst = new self();
			}

			return self::$_inst;
		}



	}

	ST_Traveler_Modern_Car_Configs::inst();

}

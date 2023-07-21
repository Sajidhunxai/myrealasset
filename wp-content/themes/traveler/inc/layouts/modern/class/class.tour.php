<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Class STTour
 *
 * Created by ShineTheme
 */
if ( ! class_exists( 'STTour' ) ) {
	class STTour extends TravelerObject {
		static $_inst;
		protected $post_type = 'st_tours';
		protected $orderby;
		/**
		 * @var string
		 * @since 1.1.7
		 */
		protected $template_folder = 'tours';
		function __construct( $tours_id = false ) {
			$this->orderby = [
				'new'        => [
					'key'  => 'new',
					'name' => __( 'New', 'traveler' ),
				],
				'price_asc'  => [
					'key'  => 'price_asc',
					'name' => __( 'Price ', 'traveler' ) . ' (<i class="fa fa-long-arrow-up"></i>)',
				],
				'price_desc' => [
					'key'  => 'price_desc',
					'name' => __( 'Price ', 'traveler' ) . ' (<i class="fa fa-long-arrow-down"></i>)',
				],
				'name_a_z'   => [
					'key'  => 'name_a_z',
					'name' => __( 'Name (A-Z)', 'traveler' ),
				],
				'name_z_a'   => [
					'key'  => 'name_z_a',
					'name' => __( 'Name (Z-A)', 'traveler' ),
				],
			];
		}
		public function getOrderby() {
			return $this->orderby;
		}
		/**
		 * @since 1.1.7
		 *
		 * @param $type
		 *
		 * @return string
		 */
		function _get_post_type_icon( $type ) {
			return 'fa fa-flag-o';
		}
		/**
		 *
		 *
		 * @update 1.1.3
		 * */
		function init() {
			if ( ! $this->is_available() ) {
				return;
			}
			parent::init();
			add_filter( 'st_tours_detail_layout', [ $this, 'custom_tour_layout' ] );
			// add to cart
			add_action( 'wp', [ $this, 'tours_add_to_cart' ], 20 );
			// custom search cars template
			add_filter( 'template_include', [ $this, 'choose_search_template' ] );
			// Sidebar Pos for SEARCH
			add_filter( 'st_tours_sidebar', [ $this, 'change_sidebar' ] );
			// Save car Review Stats
			add_action( 'comment_post', [ $this, '_save_review_stats' ] );
			// Change cars review arg
			add_filter( 'st_tours_wp_review_form_args', [ $this, 'comment_args' ], 10, 2 );
			// Filter the search tour
			// add_action('pre_get_posts',array($this,'change_search_tour_arg'));
			// add Widget Area

			add_filter( 'st_search_preload_page', [ $this, '_change_preload_search_title' ] );
			// add_filter('st_data_custom_price',array($this,'_st_data_custom_price'));
			// Woocommerce cart item information
			add_action( 'st_wc_cart_item_information_st_tours', [ $this, '_show_wc_cart_item_information' ] );
			add_action( 'st_wc_cart_item_information_btn_st_tours', [ $this, '_show_wc_cart_item_information_btn' ] );
			add_action( 'st_before_cart_item_st_tours', [ $this, '_show_wc_cart_post_type_icon' ] );
			add_filter( 'st_add_to_cart_item_st_tours', [ $this, '_deposit_calculator' ], 10, 2 );
			if ( is_singular( 'st_tours' ) ) {
				add_action( 'wp_enqueue_scripts', [ $this, 'add_scripts' ] );
			}
			/**
			 * Filter Class Icon
			 *
			 * @since 1.4.7
			 *
			 * author: quandq
			 */
			add_filter( 'st_post_type_' . $this->post_type . '_icon', [ $this, '_change_icon' ] );
			// xsearch Load post tour filter ajax
			add_action( 'wp_ajax_st_filter_tour_ajax', [ $this, 'st_filter_tour_ajax' ] );
			add_action( 'wp_ajax_nopriv_st_filter_tour_ajax', [ $this, 'st_filter_tour_ajax' ] );
			// Load list hotel in tour package
			add_action( 'wp_ajax_st_load_hotel_tour_package', [ $this, 'st_load_hotel_tour_package' ] );
			add_action( 'wp_ajax_st_save_hotel_tour_package', [ $this, 'st_save_hotel_tour_package' ] );
			add_filter( 'tour_external_booking_submit', [ $this, '__addSendMessageButton' ] );
			// xsearch Load post tour filter ajax location
			add_action( 'wp_ajax_st_filter_tour_ajax_location', [ $this, 'st_filter_tour_ajax_location' ] );
			add_action( 'wp_ajax_nopriv_st_filter_tour_ajax_location', [ $this, 'st_filter_tour_ajax_location' ] );
			// tour booking form ajax
			add_action( 'wp_ajax_tours_add_to_cart', [ $this, 'ajax_tours_add_to_cart' ] );
			add_action( 'wp_ajax_nopriv_tours_add_to_cart', [ $this, 'ajax_tours_add_to_cart' ] );
			// Load instagram ajax
			add_action( 'wp_ajax_load_instagram', [ $this, 'st_load_instagram_images' ] );
			add_action( 'wp_ajax_nopriv_load_instagram', [ $this, 'st_load_instagram_images' ] );

			// Change price ajax
			add_action( 'wp_ajax_st_format_tour_price', [ $this, 'st_format_tour_price' ] );
			add_action( 'wp_ajax_nopriv_st_format_tour_price', [ $this, 'st_format_tour_price' ] );

			// Ajax multi of service
			add_action( 'wp_ajax_st_list_of_service_st_tours', [ $this, 'st_list_of_service_st_tours' ] );
			add_action( 'wp_ajax_nopriv_st_list_of_service_st_tours', [ $this, 'st_list_of_service_st_tours' ] );
		}

		public function st_list_of_service_st_tours() {
			if ( STInput::request( 'dataArg' ) ) {

				$args = ( STInput::request( 'dataArg' ) );
				if ( st_check_service_available( 'st_tours' ) ) {
					ob_start();
					echo '<div class="tab-content st_tours">';
					$tour = self::get_instance();
					$tour->alter_search_query();
					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {
						if ( function_exists( 'check_using_elementor' ) && check_using_elementor() ) {
							$item_style_array = ( STInput::request( 'datastyleitem' ) );
							$st_style         = ! empty( $item_style_array['st_style'] ) ? $item_style_array['st_style'] : 'grid';
							$arr_data         = ! empty( $item_style_array ) ? $item_style_array : [ 'item_row' => 4 ];
							echo ( $st_style == 'grid' ) ? '<div class="service-list-wrapper row">' : '<div class="service-list-wrapper list-style">';
						} else {
							echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="owl-carousel st-service-slider">';
						}

						while ( $query->have_posts() ) :
							$query->the_post();
							if ( function_exists( 'check_using_elementor' ) && check_using_elementor() ) {

								echo st()->load_template( 'layouts/elementor/tour/loop/normal-' . $st_style, '', $arr_data );
							} else {
								echo st()->load_template( 'layouts/modern/tour/elements/loop/grid', '', [ 'slider' => true ] );
							}

						endwhile;
						echo '</div></div></div>';
					}
					$tour->remove_alter_search_query();
					wp_reset_postdata();
					echo '</div>';
					$html = ob_get_clean();
				}
				$response['html'] = $html;

				echo json_encode( $response );

				wp_die();
			}
		}

		public function st_format_tour_price() {

			$pass_validate = true;
			$item_id       = STInput::request( 'item_id', '' );
			ob_start();
			?>
			<span class="label">
				<?php echo esc_html__( 'from', 'traveler' ) ?>
			</span>
			<span class="value">
				<?php
				echo self::get_price_html( $item_id );
				?>
			</span>
			<?php
				$price_from = ob_get_contents();
				ob_clean();
				ob_end_flush();
			?>
			<?php
			if ( $item_id <= 0 || get_post_type( $item_id ) != 'st_tours' ) {
				wp_send_json( [
					'message'    => __( 'This tour is not available.', 'traveler' ),
					'price_from' => $price_from,
				] );
				die();
			}
			$tour_origin           = TravelHelper::post_origin( $item_id, 'st_tours' );
			$tour_price_by         = get_post_meta( $tour_origin, 'tour_price_by', true );
			$number                = 1;
			$adult_number          = intval( STInput::request( 'adult_number', 0 ) );
			$child_number          = intval( STInput::request( 'child_number', 0 ) );
			$infant_number         = intval( STInput::request( 'infant_number', 0 ) );
			$starttime             = STInput::request( 'starttime_tour', '' );
			$data['adult_number']  = $adult_number;
			$data['child_number']  = $child_number;
			$data['infant_number'] = $infant_number;
			$data['starttime']     = $starttime;
			$min_number            = intval( get_post_meta( $item_id, 'min_people', true ) );
			if ( $min_number <= 0 ) {
				$min_number = 1;
			}
			$max_number         = intval( get_post_meta( $item_id, 'max_people', true ) );
			$type_tour          = get_post_meta( $item_id, 'type_tour', true );
			$data['type_tour']  = $type_tour;
			$data['price_type'] = self::get_price_type( $item_id );
			$today              = date( 'Y-m-d' );
			$check_in           = TravelHelper::convertDateFormat( STInput::request( 'check_in', '' ) );
			$check_out          = TravelHelper::convertDateFormat( STInput::request( 'check_out', '' ) );

			if ( ! $adult_number and ! $child_number and ! $infant_number ) {
				wp_send_json( [
					'message'    => __( 'Please select at least one person.', 'traveler' ),
					'price_from' => $price_from,
				] );
				die();
			}
			if ( $adult_number + $child_number + $infant_number < $min_number ) {
				wp_send_json( [
					'message'    => sprintf( __( 'Min number of people for this tour is %d people', 'traveler' ), $min_number ),
					'price_from' => $price_from,
				] );
				die();
			}
			/**
			 * @since 1.2.8
			 *        Only check limit people when max_people > 0 (unlimited)
			 * */
			if ( $max_number > 0 ) {
				if ( $adult_number + $child_number + $infant_number > $max_number ) {
					wp_send_json( [
						'message'    => sprintf( __( 'Max of people for this tour is %d people', 'traveler' ), $max_number ),
						'price_from' => $price_from,
					] );
					die();
				}
			}
			if ( ! $check_in || ! $check_out ) {
				wp_send_json( [ 'message' => __( 'Select a day in the calendar.', 'traveler' ) ] );
				die();
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				$compare = TravelHelper::dateCompare( $today, $check_in );
				if ( $compare < 0 ) {
					wp_send_json( [ 'message' => __( 'This tour has expired', 'traveler' ) ] );
					die();
				}
			}
			$booking_period = intval( get_post_meta( $item_id, 'tours_booking_period', true ) );
			$period         = STDate::dateDiff( $today, $check_in );
			if ( $period < $booking_period ) {
				wp_send_json( [
					'message'    => sprintf( __( 'This tour allow minimum booking is %d day(s)', 'traveler' ), $booking_period ),
					'price_from' => $price_from,
				] );
				die();
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				$tour_available = TourHelper::checkAvailableTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );

				if ( ! $tour_available ) {
					wp_send_json( [
						'message'    => __( 'The check in, check out day is invalid or this tour not available.', 'traveler' ),
						'price_from' => $price_from,
					] );
					die();
				}
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				if ( $max_number > 0 ) {
					$free_people = $max_number;
					if ( empty( trim( $starttime ) ) ) {
						$result = TourHelper::_get_free_peple( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
					} else {
						$result = TourHelper::_get_free_peple_by_time( $tour_origin, strtotime( $check_in ), strtotime( $check_out ), $starttime );
					}
					if ( $tour_price_by == 'fixed' ) {
						if ( ! empty( $result ) && ! empty( trim( $starttime ) ) ) {
							wp_send_json( [
								'message'    => sprintf( __( 'This tour is not available.', 'traveler' ) ),
								'price_from' => $price_from,
							] );
						}
					}
					if ( is_array( $result ) && count( $result ) ) {
						$free_people = intval( $result['free_people'] );
					}

					/**
					 * @since 1.2.8
					 *        Only check limit people when max_people > 0 (unlimited)
					 * */
					if ( $free_people < ( $adult_number + $child_number + $infant_number ) ) {
						if ( empty( trim( $starttime ) ) ) {
							wp_send_json( [
								'message'    => sprintf( __( 'This tour is only available for %d people', 'traveler' ), $free_people ),
								'price_from' => $price_from,
							] );
						} else {
							wp_send_json( [
								'message'    => sprintf( __( 'This tour is only available for %1$d people at %2$s', 'traveler' ), $free_people, $starttime ),
								'price_from' => $price_from,
							] );
						}
						$pass_validate = false;
						return false;
					}
				}
			} else {
				/**
				 * Get Free people
				 * If adult + child + infant < total -> return true
				 * else return false
				 */
				if ( $max_number > 0 ) {
					$free_people = TourHelper::getFreePeopleTourFixedDepart( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
					if ( $free_people < ( $adult_number + $child_number + $infant_number ) ) {
						wp_send_json( [
							'message'    => sprintf( __( 'This tour is only available for %d people', 'traveler' ), $free_people ),
							'price_from' => $price_from,
						] );
					}
				}
			}
			$extras              = STInput::request( 'extra_price', [] );
			$extra_price         = self::geExtraPrice( $extras );
			$data['extras']      = $extras;
			$data['extra_price'] = $extra_price;
			$data['guest_title'] = STInput::post( 'guest_title' );
			$data['guest_name']  = STInput::post( 'guest_name' );
			// Hotel package
			$hotel_packages      = STInput::request( 'hotel_package', [] );
			$package_hotels      = [];
			$arr_hotel_temp      = [];
			$package_hotel_price = 0;
			if ( ! empty( $hotel_packages ) ) {
				foreach ( $hotel_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_hotel_temp, $v[0] );
					}
				}
				if ( ! empty( $arr_hotel_temp ) ) {
					$hp = 0;
					foreach ( $arr_hotel_temp as $k => $v ) {
						$sub_hotel_package = json_decode( stripcslashes( $v ) );
						if ( intval( $arr_hotel_temp[ $k - 1 ] ) > 0 ) {
							if ( ( $k > 0 ) && is_object( $sub_hotel_package ) ) {
								$sub_hotel_package->qty = intval( $arr_hotel_temp[ $k - 1 ] );
							}
							if ( is_object( $sub_hotel_package ) ) {
								$package_hotels[ $hp ] = $sub_hotel_package;
								++$hp;
							}
						}
					}
				}
				$package_hotel_price = self::_get_hotel_package_price( $package_hotels );
			}

			$data['package_hotel']       = $package_hotels;
			$data['package_hotel_price'] = $package_hotel_price;
			// Activity package
			$activity_packages = STInput::request( 'activity_package', [] );
			$arr_activity_temp = [];
			if ( ! empty( $activity_packages ) ) {
				foreach ( $activity_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_activity_temp, $v[0] );
					}
				}
			}
			$package_activities = [];
			if ( ! empty( $arr_activity_temp ) ) {
				$hp = 0;
				foreach ( $arr_activity_temp as $k => $v ) {
					$sub_activity_package = json_decode( stripcslashes( $v ) );
					if ( intval( $arr_activity_temp[ $k - 1 ] ) > 0 ) {
						if ( ( $k > 0 ) && is_object( $sub_activity_package ) ) {
							$sub_activity_package->qty = $arr_activity_temp[ $k - 1 ];
						}
						if ( is_object( $sub_activity_package ) ) {
							$package_activities[ $hp ] = $sub_activity_package;
							++$hp;
						}
					}
				}
			}
			$package_activity_price         = self::_get_activity_package_price( $package_activities );
			$data['package_activity']       = $package_activities;
			$data['package_activity_price'] = $package_activity_price;
			// Car package
			$car_name_packages_temp = STInput::request( 'car_name', [] );
			$car_name_packages      = [];
			if ( ! empty( $car_name_packages_temp ) ) {
				foreach ( $car_name_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_name_packages, $v[0] );
					}
				}
			}
			$car_price_packages_temp = STInput::request( 'car_price', [] );
			$car_price_packages      = [];
			if ( ! empty( $car_price_packages_temp ) ) {
				foreach ( $car_price_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_price_packages, $v[0] );
					}
				}
			}
			$car_quantity_packages_temp = STInput::request( 'car_quantity', [] );
			$car_quantity_packages      = [];
			if ( ! empty( $car_quantity_packages_temp ) ) {
				foreach ( $car_quantity_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_quantity_packages, $v[0] );
					}
				}
			}
			$package_cars              = self::_convert_data_car_package( $car_name_packages, $car_price_packages, $car_quantity_packages );
			$package_car_price         = self::_get_car_package_price( $package_cars );
			$data['package_car']       = $package_cars;
			$data['package_car_price'] = $package_car_price;
			// Flight package
			$flight_packages = STInput::request( 'flight_package', [] );

			$arr_flight_temp = [];
			if ( ! empty( $flight_packages ) ) {
				foreach ( $flight_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_flight_temp, $v[0] );
					}
				}
			}
			$package_flight = [];

			if ( ! empty( $arr_flight_temp ) ) {
				$hp = 0;
				foreach ( $arr_flight_temp as $k => $v ) {
					$sub_flight_package = json_decode( stripcslashes( $v ) );
					if ( intval( $arr_flight_temp[ $k + 1 ] ) > 0 ) {
						if ( is_object( $sub_flight_package ) ) {
							$sub_flight_package->qty = $arr_flight_temp[ $k + 1 ];
						}
						if ( is_object( $sub_flight_package ) ) {
							$package_flight[ $hp ] = $sub_flight_package;
							++$hp;
						}
					}
				}
			}
			$package_flight_price = self::_get_flight_package_price( $package_flight );
			// End flight package
			$price_type = self::get_price_type( $tour_origin );
			if ( $price_type == 'person' or $price_type == 'fixed_depart' ) {
				$data_price = STPrice::getPriceByPeopleTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ), $adult_number, $child_number, $infant_number );
			} else {
				$data_price = STPrice::getPriceByFixedTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
			}
			$total_price = $data_price['total_price'];

			$data['ori_price'] = $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price;
			$price_new_html    = TravelHelper::format_money( $data['ori_price'] );
			$html              = '<span class="value"> <span class="text-lg lh1em item "> ' . esc_html( $price_new_html ) . '</span> </span>';
			$data              = [
				'price'      => $total_price,
				'price_html' => $html,
			];
			wp_send_json( $data );
		}

		public function st_load_instagram_images() {
			$number_image = STInput::post( 'number' );
			$user_name    = STInput::post( 'name' );
			$list_image   = $this->stt_get_instagram_images( $user_name, $number_image );
			if ( ! empty( $list_image ) ) {
				$html = '';
				$html = '<div class="stt-image-item owl-carousel">';
				foreach ( $list_image as $value ) {
					$html .= '<div class="item">';
					$html .= '<div class="thumb">';
					$html .= '<img src="' . esc_url( $value ) . '" alt="' . get_bloginfo( 'description' ) . '" class="img-fluid" >';
					$html .= '</div></div>';
				}
				$html .= '</div>';
			}
			echo json_encode(
				[
					'status' => 1,
					'html'   => $html,
				]
			);
			die();
		}
		public function stt_get_instagram_images( $username, $limit = 20 ) {
			$profile_url   = "https://www.instagram.com/$username/?__a=1";
			$iteration_url = $profile_url;
			$tryNext       = true;
			$found         = 0;
			$images        = [];
			while ( $tryNext ) {
				$tryNext = false;
				$remote  = wp_remote_get( $iteration_url );
				if ( is_wp_error( $remote ) ) {
					return false;
				}
				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return false;
				}
				$response = wp_remote_retrieve_body( $remote );
				if ( $response === false ) {
					return false;
				}
				$data = json_decode( $response, true );
				if ( $data === null ) {
					return false;
				}
				$media = $data['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				foreach ( $media as $key => $media_item ) {
					if ( $found + $key < $limit ) {
						if ( isset( $media_item['node']['thumbnail_src'] ) ) {
							$image_item = $media_item['node']['thumbnail_src'];
							array_push( $images, $image_item );
						}
					}
				}
				$found += count( $media );
			}
			return $images;
		}
		public function __addSendMessageButton( $return ) {
			$res = '';
			if ( st_owner_post() && is_single() ) {
				$post_id = get_the_ID();
				if ( STInput::request( 'post_id' ) ) {
					$post_id = STInput::request( 'post_id' );
				}
				$tour_external_booking = get_post_meta( $post_id, 'st_tour_external_booking', 'off' );
				if ( $tour_external_booking == 'off' ) {
					$res = st_button_send_message( $post_id );
				}
			}
			return $res . $return;
		}
		public function st_save_hotel_tour_package() {
			$tour_package                 = STInput::post( 'tour_package', '' );
			$tour_package_car             = STInput::post( 'tour_package_car', '' );
			$tour_package_activity        = STInput::post( 'tour_package_activity', '' );
			$tour_package_flight          = STInput::post( 'tour_package_flight', '' );
			$tour_package_custom          = STInput::post( 'tour_package_custom', '' );
			$tour_package_custom_car      = STInput::post( 'tour_package_custom_car', '' );
			$tour_package_custom_activity = STInput::post( 'tour_package_custom_activity', '' );
			$tour_package_custom_flight   = STInput::post( 'tour_package_custom_flight', '' );
			$post_id                      = STInput::post( 'post_id', '' );
			if ( $post_id ) {
				if ( $tour_package != '' ) {
					$data_package = json_decode( stripcslashes( $tour_package ) );
					if ( ! empty( $data_package ) ) {
						update_post_meta( $post_id, 'tour_packages', json_decode( stripcslashes( $tour_package ) ) );
						update_post_meta( $post_id, 'tour_packages_car', json_decode( stripcslashes( $tour_package_car ) ) );
						update_post_meta( $post_id, 'tour_packages_activity', json_decode( stripcslashes( $tour_package_activity ) ) );
						update_post_meta( $post_id, 'tour_packages_flight', json_decode( stripcslashes( $tour_package_flight ) ) );
						update_post_meta( $post_id, 'tour_packages_custom', json_decode( stripcslashes( $tour_package_custom ) ) );
						update_post_meta( $post_id, 'tour_packages_custom_car', json_decode( stripcslashes( $tour_package_custom_car ) ) );
						update_post_meta( $post_id, 'tour_packages_custom_activity', json_decode( stripcslashes( $tour_package_custom_activity ) ) );
						update_post_meta( $post_id, 'tour_packages_custom_flight', json_decode( stripcslashes( $tour_package_custom_flight ) ) );
					}
					$return = [
						'status'  => true,
						'message' => __( 'Update tour packages success!', 'traveler' ),
					];
				} else {
					$return = [
						'status'  => false,
						'message' => __( 'Tour packages is empty!', 'traveler' ),
					];
				}
			} else {
				$return = [
					'status'  => false,
					'message' => __( 'Tour is not exists!', 'traveler' ),
				];
			}
			echo json_encode( $return );
			die;
		}
		public function st_load_hotel_tour_package() {
			$location_string = STInput::post( 'locations', '' );
			$address         = STInput::post( 'address', '' );
			$post_id         = STInput::post( 'post_id', '' );
			$type            = STInput::post( 'post_type', 'hotel' );
			if ( $location_string == '' && $address == '' ) {
				$return = [
					'status'  => false,
					'content' => '',
					'message' => __( 'Location or address is required field!', 'traveler' ),
				];
			} else {
				$locations = [];
				if ( trim( $location_string ) != '' ) {
					$location_arr = explode( ',', $location_string );
					if ( ! empty( $location_arr ) ) {
						foreach ( $location_arr as $k => $v ) {
							$sub_location = str_replace( '_', '', $v );
							array_push( $locations, $sub_location );
						}
					}
				}
				switch ( $type ) {
					case 'hotel':
						if ( class_exists( 'STHotel' ) ) {
							$list_hotel = STHotel::get_list_hotel_by_location_or_address( $locations, $address );
							$content    = st()->load_template( 'tours/elements/stour', 'package', [
								'ids'     => $list_hotel,
								'post_id' => $post_id,
							] );
							$message    = __( 'Getting list hotels success!', 'traveler' );
						}
						break;
					case 'car':
						if ( class_exists( 'STCars' ) ) {
							$list_car = STCars::get_list_car_by_location_or_address( $locations, $address );
							$content  = st()->load_template( 'tours/elements/stour', 'package-car', [
								'ids'     => $list_car,
								'post_id' => $post_id,
							] );
							$message  = __( 'Getting list cars success!', 'traveler' );
						}
						break;
					case 'activity':
						if ( class_exists( 'STActivity' ) ) {
							$list_activity = STActivity::get_list_activity_by_location_or_address( $locations, $address );
							$content       = st()->load_template( 'tours/elements/stour', 'package-activity', [
								'ids'     => $list_activity,
								'post_id' => $post_id,
							] );
							$message       = __( 'Getting list activities success!', 'traveler' );
						}
						break;
					case 'flight':
						$args_flight = [
							'post_type'     => 'st_flight',
							'post_per_page' => '-1',
							'post_status'   => 'publish',
							'meta_query'    => [
								'relation' => 'AND',
								[
									'key'     => 'origin',
									'value'   => '',
									'compare' => '!=',
								],
								[
									'key'     => 'destination',
									'value'   => '',
									'compare' => '!=',
								],
							],
						];
						$user_id     = get_current_user_id();
						if ( ! is_super_admin( $user_id ) ) {
							$args_flight['post_author'] = $user_id;
						}
						$query_flight = new WP_Query( $args_flight );
						$list_flight  = [];
						if ( $query_flight->have_posts() ) {
							$i = 0;
							while ( $query_flight->have_posts() ) {
								$query_flight->the_post();
								$list_flight[ $i ] = [ 'ID' => get_the_ID() ];
								++$i;
							}
						}
						$content = st()->load_template( 'tours/elements/stour', 'package-flight', [
							'ids'     => $list_flight,
							'post_id' => $post_id,
						] );
						$message = __( 'Getting list flight success!', 'traveler' );
						break;
					default:
						if ( class_exists( 'STHotel' ) ) {
							$list_hotel = STHotel::get_list_hotel_by_location_or_address( $locations, $address );
							$content    = st()->load_template( 'tours/elements/stour', 'package', [
								'ids'     => $list_hotel,
								'post_id' => $post_id,
							] );
							$message    = __( 'Getting list hotels success!', 'traveler' );
						}
						break;
				}
				$return = [
					'status'  => true,
					'content' => $content,
					'message' => $message,
				];
			}
			echo json_encode( $return );
			die;
		}
		public function setQueryTourSearch() {
			$page_number = STInput::get( 'page' );
			global $wp_query, $st_search_query;
			$this->alter_search_query();
			set_query_var( 'paged', $page_number );
			$paged = $page_number;
			$args  = [
				'post_type'   => 'st_tours',
				's'           => '',
				'post_status' => [ 'publish' ],
				'paged'       => $paged,
			];
			if ( ! empty( $_GET['st_order'] ) ) {
				$args['order'] = $_GET['st_order'];
			}
			if ( ! empty( $_GET['st_orderby'] ) ) {
				$args['orderby'] = $_GET['st_orderby'];
			}
			query_posts( $args );
			$st_search_query = $wp_query;
			$this->remove_alter_search_query();
		}
		public function removeSearchServiceLocationByAuthor( $query ) {
			$query->set( 'author', '' );
			return $query;
		}
		public function st_filter_tour_ajax_location() {
			$_REQUEST['location_id'] = intval( STInput::get( 'id_location' ) );
			$page_number             = STInput::get( 'page' );
			$st_style                = STInput::get( 'layout' );
			$arr_data                = [];
			$top_search              = STInput::get( 'top_search' );
			if ( $top_search ) {
				$arr_data = [ 'top_search' => true ];
			}
			global $wp_query, $st_search_query;
			add_filter( 'pre_get_posts', [ $this, 'removeSearchServiceLocationByAuthor' ] );
			$this->setQueryTourSearch();
			$query = $st_search_query;
			ob_start();
			?>
			<div class="row row-wrapper">
				<?php
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						echo st()->load_template( 'layouts/modern/location/elements/loop/tour/grid', '' );
					}
				} else {
					echo '<div class="col-xs-12">';
					echo st()->load_template( 'layouts/modern/tour/elemefeaturents/loop/none' );
					echo '</div>';
				}
				wp_reset_postdata();
				?>
			</div>
			<?php
			$ajax_filter_content = ob_get_contents();
			ob_clean();
			ob_end_flush();
			ob_start();
			TravelHelper::paging( false, false, true );
			?>
			<span class="count-string count-string--solo">
				<?php
				if ( ! empty( $st_search_query ) ) {
					$wp_query = $st_search_query;
				}
				if ( $wp_query->found_posts ) :
					$page           = get_query_var( 'paged' );
					$posts_per_page = get_query_var( 'posts_per_page' );
					if ( ! $page ) {
						$page = 1;
					}
					$last = $posts_per_page * ( $page );
					if ( $last > $wp_query->found_posts ) {
						$last = $wp_query->found_posts;
					}
					if ( $st_style != 'grid8' ) {
						echo sprintf( __( '%1$d - %2$d of %3$d ', 'traveler' ), $posts_per_page * ( $page - 1 ) + 1, $last, $wp_query->found_posts );
						echo ( $wp_query->found_posts == 1 ) ? __( 'Tour', 'traveler' ) : __( 'Tours', 'traveler' );
					}
				endif;
				?>
			</span>
			<?php
			$ajax_filter_pag = ob_get_contents();
			ob_clean();
			ob_end_flush();
			$count  = balanceTags( $this->get_result_string() ) . '<div id="btn-clear-filter" class="btn-clear-filter" style="display: none;">' . __( 'Clear filter', 'traveler' ) . '</div>';
			$result = [
				'content' => $ajax_filter_content,
				'pag'     => $ajax_filter_pag,
				'count'   => $count,
				'page'    => $page_number,
			];
			$result = [
				'content' => $ajax_filter_content,
				'pag'     => $ajax_filter_pag,
				'page'    => $page_number,
			];
			wp_reset_postdata();
			echo json_encode( $result );
			die;
		}
		public function st_filter_tour_ajax() {
			$page_number = STInput::get( 'page' );
			$st_style    = STInput::get( 'layout', 'grid' );
			$arr_data    = [ 'item_row' => 3 ];
			$top_search  = STInput::get( 'top_search' );
			if ( $top_search ) {
				$arr_data = [
					'top_search' => true,
					'item_row'   => 4,
				];
			}

			global $wp_query, $st_search_query;
			$this->setQueryTourSearch();
			$query = $st_search_query;

			ob_start();
			echo st()->load_template( 'layouts/modern/common/loader', 'content' );
			if ( function_exists( 'check_using_elementor' ) && check_using_elementor() ) {
				echo ( $st_style == 'grid' ) ? '<div class="service-list-wrapper service-tour row">' : '<div class="service-list-wrapper service-tour list-style style-list">';
			} else {
				echo ( $st_style == 'grid' ) ? '<div class="row row-wrapper">' : '<div class="row style-list">';
			}
			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {
					$query->the_post();
					if ( function_exists( 'check_using_elementor' ) && check_using_elementor() ) {
						$st_item_row              = STInput::request( 'st_item_row' );
						$st_item_row_tablet       = STInput::request( 'st_item_row_tablet' );
						$st_item_row_tablet_extra = STInput::request( 'st_item_row_tablet_extra' );
						$layoutRequest            = STInput::request( 'version_layout' );
						$formatRequest            = STInput::request( 'version_format' );
						$version                  = STInput::get( 'version' );
						if ( $version == 'elementorv2' ) {
							$classes = '';
							if ( $layoutRequest == 6 ) {
								$classes = 'col-lg-4 col-md-6 col-12 item-service';
							} elseif ( ! empty( $st_item_row ) ) {
									$classes = ' item-service col-12' . ' col-sm-' . ( 12 / $st_item_row_tablet ) . ' col-md-' . ( 12 / $st_item_row_tablet_extra ) . ' col-lg-' . ( 12 / $st_item_row ) . ' col-xl-' . ( 12 / $st_item_row );
							} else {
								$classes = ' col-12 col-md-6 col-lg-3  item-service';
							}
							echo '<div class="' . esc_attr( $classes ) . '">';
							echo stt_elementorv2()->loadView( 'services/tour/loop/' . $st_style );
							echo '</div>';
						} else {
							echo st()->load_template( 'layouts/elementor/tour/loop/normal-' . $st_style, '', $arr_data );
						}
					} else {
						echo st()->load_template( 'layouts/modern/tour/elements/loop/' . $st_style, '', $arr_data );
					}
				}
			} else {
				echo '<div class="col-xs-12">';
				if ( function_exists( 'check_using_elementor' ) && check_using_elementor() ) {
					echo st()->load_template( 'layouts/elementor/tour/loop/none' );
				} else {
					echo st()->load_template( 'layouts/modern/tour/elements/loop/none' );
				}

				echo '</div>';
			}
			echo '</div>';
			$ajax_filter_content = ob_get_contents();
			ob_clean();
			ob_end_flush();
			ob_start();
			TravelHelper::paging( false, false, true );
			?>
			<span class="count-string count-string--solo">
				<?php
				if ( ! empty( $st_search_query ) ) {
					$wp_query = $st_search_query;
				}
				if ( $wp_query->found_posts ) :
					$page           = get_query_var( 'paged' );
					$posts_per_page = get_query_var( 'posts_per_page' );
					if ( ! $page ) {
						$page = 1;
					}
					$last = $posts_per_page * ( $page );
					if ( $last > $wp_query->found_posts ) {
						$last = $wp_query->found_posts;
					}
					if ( $st_style != 'grid8' ) {
						echo sprintf( __( '%1$d - %2$d of %3$d ', 'traveler' ), $posts_per_page * ( $page - 1 ) + 1, $last, $wp_query->found_posts );
						echo ( $wp_query->found_posts == 1 ) ? __( 'Tour', 'traveler' ) : __( 'Tours', 'traveler' );
					}
				endif;
				?>
			</span>
			<?php
			$ajax_filter_pag = ob_get_contents();
			ob_clean();
			ob_end_flush();
			$count  = balanceTags( $this->get_result_string() ) . '<div id="btn-clear-filter" class="btn-clear-filter" style="display: none;">' . __( 'Clear filter', 'traveler' ) . '</div>';
			$result = [
				'content' => $ajax_filter_content,
				'pag'     => $ajax_filter_pag,
				'count'   => $count,
				'page'    => $page_number,
			];
			wp_reset_postdata();
			echo json_encode( $result );
			die;
		}
		function _change_icon( $icon ) {
			return $icon = 'fa-flag-o';
		}
		/**
		 * @since 1.1.9
		 *
		 * @param $comment_id
		 */
		function _save_review_stats( $comment_id ) {
			$comemntObj = get_comment( $comment_id );
			$post_id    = $comemntObj->comment_post_ID;
			$post_type  = get_post_type( $post_id );
			if ( $post_type == 'st_tours' ) {
				$all_stats       = $this->get_review_stats();
				$st_review_stats = STInput::post( 'st_review_stats' );
				if ( ! empty( $all_stats ) and is_array( $all_stats ) ) {
					$total_point = 0;
					foreach ( $all_stats as $key => $value ) {
						if ( isset( $st_review_stats[ $value['title'] ] ) ) {
							// Now Update the Each Stat Value
							if ( is_numeric( $st_review_stats[ $value['title'] ] ) ) {
								$st_review_stats[ $value['title'] ] = intval( $st_review_stats[ $value['title'] ] );
							} else {
								$st_review_stats[ $value['title'] ] = 5;
							}
							$total_point += $st_review_stats[ $value['title'] ];
							update_comment_meta( $comment_id, 'st_stat_' . sanitize_title( $value['title'] ), $st_review_stats[ $value['title'] ] );
						}
					}
					$avg = round( $total_point / count( $all_stats ), 1 );
					// Update comment rate with avg point
					$rate = wp_filter_nohtml_kses( $avg );
					if ( $rate > 5 ) {
						// Max rate is 5
						$rate = 5;
					}
					update_comment_meta( $comment_id, 'comment_rate', $rate );
					// Now Update the Stats Value
					update_comment_meta( $comment_id, 'st_review_stats', $st_review_stats );
				}
				if ( STInput::post( 'comment_rate' ) ) {
					update_comment_meta( $comment_id, 'comment_rate', STInput::post( 'comment_rate' ) );
				}
				// review_stats
				$avg = STReview::get_avg_rate( $post_id );
				update_post_meta( $post_id, 'rate_review', $avg );

				TravelHelper::_update_rate_review( $post_id, $avg, $post_type );
			}
		}
		/**
		 *
		 *
		 * @since 1.1.9
		 * */
		function change_sidebar( $sidebar = false ) {
			return st()->get_option( 'tour_sidebar_pos', 'left' );
		}
		/**
		 * @since 1.1.9
		 * @return bool
		 */
		function get_review_stats() {
			$review_stat = st()->get_option( 'tour_review_stats' );
			return $review_stat;
		}
		/**
		 * @since 1.1.9
		 *
		 * @param      $comment_form
		 * @param bool         $post_id
		 *
		 * @return mixed
		 */
		function comment_args( $comment_form, $post_id = false ) {
			/* since 1.1.0 */
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			if ( get_post_type( $post_id ) == 'st_tours' ) {
				$stats = $this->get_review_stats();
				if ( $stats and is_array( $stats ) ) {
					$stat_html = '<ul class="list booking-item-raiting-summary-list stats-list-select">';
					foreach ( $stats as $key => $value ) {
						$stat_html .= '<li class=""><div class="booking-item-raiting-list-title">' . esc_html( $value['title'] ) . '</div>
                                                    <ul class="icon-group booking-item-rating-stars">
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li><i class="fa fa-smile-o"></i>
                                                    </li>
                                                </ul>
                                                <input type="hidden" class="st_review_stats" value="0" name="st_review_stats[' . esc_attr( $value['title'] ) . ']">
                                                    </li>';
					}
					$stat_html                     .= '</ul>';
					$comment_form['comment_field']  = "
                        <div class='row'>
                            <div class=\"col-sm-8\">
                    ";
					$comment_form['comment_field'] .= '<div class="form-group">
                                            <label for="label_comment_title">' . __( 'Review Title', 'traveler' ) . '</label>
                                            <input class="form-control" type="text" name="comment_title" id="label_comment_title">
                                        </div>';
					$comment_form['comment_field'] .= '<div class="form-group">
                                            <label for="comment">' . __( 'Review Text', 'traveler' ) . '</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="6"></textarea>
                                        </div>
                                        </div><!--End col-sm-8-->
                                        ';
					$comment_form['comment_field'] .= '<div class="col-sm-4">' . $stat_html . '</div></div><!--End Row-->';
				}
			}
			return $comment_form;
		}
		/**
		 *
		 *
		 * @since 1.1.1
		 * */
		function _show_wc_cart_item_information( $st_booking_data = [] ) {
			echo st()->load_template( 'tours/wc_cart_item_information', false, [ 'st_booking_data' => $st_booking_data ] );
		}
		/**
		 *
		 *
		 * @since 1.1.1
		 * */
		function _show_wc_cart_post_type_icon() {
			echo '<span class="booking-item-wishlist-title"><i class="fa fa-flag-o"></i> ' . __( 'tour', 'traveler' ) . ' <span></span></span>';
		}
		function _st_data_custom_price() {
			return [
				'title'     => 'Price Custom Settings',
				'post_type' => 'st_tours',
			];
		}
		/**
		 *
		 *
		 * @update 1.1.1
		 * */
		static function get_search_fields_name() {
			return [/*
					'google_map_location' => array(
					'value' => 'google_map_location',
					'label' => __('Google Map Location', 'traveler')
					), */
				'address'       => [
					'value' => 'address',
					'label' => __( 'Location', 'traveler' ),
				], /*
					'address-2'=>array(
					'value'=>'address-2',
					'label'=>__('Address (geobytes.com)','traveler')
					), */
				'people'        => [
					'value' => 'people',
					'label' => __( 'People', 'traveler' ),
				],
				'check_in'      => [
					'value' => 'check_in',
					'label' => __( 'Departure date', 'traveler' ),
				],
				'check_out'     => [
					'value' => 'check_out',
					'label' => __( 'Arrival Date', 'traveler' ),
				],
				'taxonomy'      => [
					'value' => 'taxonomy',
					'label' => __( 'Taxonomy', 'traveler' ),
				],
				'list_location' => [
					'value' => 'list_location',
					'label' => __( 'Location List', 'traveler' ),
				], /*
					'duration'=>array(
					'value'=>'duration',
					'label'=>__('Duration','traveler')
					),
					'duration-dropdown'=>array(
					'value'=>'duration-dropdown',
					'label'=>__('Duration Dropdown','traveler')
					), */
				'item_name'     => [
					'value' => 'item_name',
					'label' => __( 'Tour Name', 'traveler' ),
				],
				'list_name'     => [
					'value' => 'list_name',
					'label' => __( 'List Name', 'traveler' ),
				],
				'price_slider'  => [
					'value' => 'price_slider',
					'label' => __( 'Price slider ', 'traveler' ),
				],
			];
		}
		function _change_preload_search_title( $return ) {
			if ( get_query_var( 'post_type' ) == 'st_tours' || is_page_template( 'template-tour-search.php' ) ) {
				$return = __( ' Tours in %s', 'traveler' );
				if ( STInput::get( 'location_id' ) ) {
					$return = sprintf( $return, get_the_title( intval( STInput::get( 'location_id' ) ) ) );
				} elseif ( STInput::get( 'location_name' ) ) {
					$return = sprintf( $return, STInput::get( 'location_name' ) );
				} elseif ( STInput::get( 'address' ) ) {
					$return = sprintf( $return, STInput::get( 'address' ) );
				} else {
					$return = __( ' Tours', 'traveler' );
				}
				$return .= '...';
			}
			return $return;
		}

		/**
		 * @since 1.1.7
		 * */
		function search_distinct() {
			return 'DISTINCT';
		}
		/**
		 *
		 *
		 * @since 1.1.3
		 * */
		function _alter_search_query( $where ) {
			global $wpdb;
			return $where;
		}
		/**
		 * @since 1.1.7
		 *
		 * @param $JOIN
		 *
		 * @return string
		 */
		function _alter_join_query( $JOIN ) {
			return $JOIN;
			global $wpdb;
			return $JOIN;
		}
		function _get_join_query( $join ) {
			if ( ! TravelHelper::checkTableDuplicate( 'st_tours' ) ) {
				return $join;
			}
			global $wpdb;
			$table          = $wpdb->prefix . 'st_tours';
			$table_postmeta = $wpdb->prefix . 'postmeta';
			$table_st_tours = $wpdb->prefix . 'st_tours';
			$join          .= " LEFT JOIN {$table} as tb ON {$wpdb->prefix}posts.ID = tb.post_id";
			$join          .= " LEFT JOIN {$table_postmeta} as tb_postmeta ON tb.post_id = tb_postmeta.post_id AND tb_postmeta.meta_key = 'discount_type' ";
			$join          .= " LEFT JOIN {$table_st_tours} as tb_st_tours ON {$wpdb->prefix}posts.ID = tb_st_tours.post_id";
			return $join;
		}
		/**
		 * @update 1.1.8
		 */
		function _get_where_query_tab_location( $where ) {
			$location_id = get_the_ID();
			if ( ! TravelHelper::checkTableDuplicate( 'st_tours' ) ) {
				return $where;
			}
			if ( ! empty( $location_id ) ) {
				$where = TravelHelper::_st_get_where_location( $location_id, [ 'st_tours' ], $where );
			}
			return $where;
		}
		function _get_where_query( $where ) {

			if ( ! TravelHelper::checkTableDuplicate( 'st_tours' ) ) {
				return $where;
			}
			global $wpdb, $st_search_args;
			if ( ! $st_search_args ) {
				$st_search_args = $_REQUEST;
			}
			/**
			 * Merge data with element args with search args
			 * @since  1.2.4
			 * @author dungdt
			 */

			// Check in single location
			if ( STInput::request( 'location_id' ) ) {
				$st_search_args['location_id'] = STInput::request( 'location_id' );
			}
			if ( ! empty( $st_search_args['st_location'] ) ) {
				if ( empty( $st_search_args['only_featured_location'] ) or $st_search_args['only_featured_location'] == 'no' ) {
					$st_search_args['location_id'] = $st_search_args['st_location'];
				}
			}
			
			if ( isset( $st_search_args['location_id'] ) && ! empty( $st_search_args['location_id'] ) ) {
				$location_id = $st_search_args['location_id'];
				$where       = TravelHelper::_st_get_where_location( $location_id, [ 'st_tours' ], $where );
			} elseif ( isset( $_REQUEST['location_name'] ) && ! empty( $_REQUEST['location_name'] ) ) {
				$location_name = STInput::request( 'location_name', '' );
				$ids_location  = TravelerObject::_get_location_by_name( $location_name );
				if ( ! empty( $ids_location ) && is_array( $ids_location ) ) {
					$where .= TravelHelper::_st_get_where_location( $ids_location, [ 'st_tours' ], $where );
				} else {
					$where .= $wpdb->prepare( ' AND (tb.address LIKE %s', '%' . $location_name . '%' );
					$where .= $wpdb->prepare( " OR {$wpdb->prefix}posts.post_title LIKE %s)", '%' . $location_name . '%' );
				}
			}
			if ( isset( $_REQUEST['item_name'] ) && ! empty( $_REQUEST['item_name'] ) ) {
				$item_name = STInput::request( 'item_name', '' );
				$where    .= $wpdb->prepare( " AND {$wpdb->prefix}posts.post_title LIKE %s", '%' . $item_name . '%' );
			}
			if ( isset( $_REQUEST['item_id'] ) and ! empty( $_REQUEST['item_id'] ) ) {
				$item_id = STInput::request( 'item_id', '' );
				$where  .= $wpdb->prepare( " AND ({$wpdb->prefix}posts.ID = %s)", $item_id );
			}
			$adult_number = (int) STInput::get( 'adult_number', '1' );
			$child_number = (int) STInput::get( 'child_number', '0' );
			$people       = $adult_number + $child_number;
			if ( ! empty( $people ) ) {
				$people_max = apply_filters( 'max_people_tour', $people );
				if ( $people_max > 0 ) {
					$where .= " AND
                    CASE
                      WHEN ISNULL(tb.max_people) THEN 1=1
                      WHEN tb.max_people = '' THEN 1=1
                      WHEN tb.max_people = '0' THEN 1=1
                      ELSE tb.max_people >= " . $people_max . ' END
                    ';
					// $where .= $wpdb->prepare(" AND (tb.max_people >= %d)", $people);
				}
			}
			$start = STInput::request( 'start' );
			$end   = STInput::request( 'end' );
			if ( ! empty( $start ) && ! empty( $end ) ) {
				$list_date = TourHelper::_tourValidate( strtotime( TravelHelper::convertDateFormat( $start ) ), strtotime( TravelHelper::convertDateFormat( $end ) ) );
				$where    .= " AND {$wpdb->posts}.ID IN ({$list_date})";
			} elseif ( ! empty( $_REQUEST['isajax'] ) ) {
					$list_date = TourHelper::_tourHasAvai();
					$where    .= " AND {$wpdb->posts}.ID IN ({$list_date})";
			}
			if ( isset( $_REQUEST['star_rate'] ) && ! empty( $_REQUEST['star_rate'] ) ) {
				$stars    = STInput::get( 'star_rate', 1 );
				$stars    = explode( ',', $stars );
				$all_star = [];
				if ( ! empty( $stars ) && is_array( $stars ) ) {
					foreach ( $stars as $val ) {
						if ( empty( $all_star ) ) {
							$all_star = range( $val, $val + 0.9, 0.1 );
						} else {
							$all_star = array_merge( $all_star, range( $val, $val + 0.9, 0.1 ) );
						}
					}
				}
				$list_star = implode( ',', array_unique( $all_star ) );
				if ( $list_star ) {
					$where .= " AND (tb.rate_review IN ({$list_star}))";
				}
			}
			if ( isset( $_REQUEST['range'] ) and isset( $_REQUEST['location_id'] ) ) {
				$range       = STInput::get( 'range', '0;5' );
				$rangeobj    = explode( ';', $range );
				$range_min   = $rangeobj[0];
				$range_max   = $rangeobj[1];
				$location_id = intval( STInput::request( 'location_id' ) );
				$post_type   = get_query_var( 'post_type' );
				$map_lat     = (float) get_post_meta( $location_id, 'map_lat', true );
				$map_lng     = (float) get_post_meta( $location_id, 'map_lng', true );
				global $wpdb;
				$where .= "
                    AND $wpdb->posts.ID IN (
                        SELECT ID FROM (
                            SELECT $wpdb->posts.*,( 6371 * acos( cos( radians({$map_lat}) ) * cos( radians( mt1.meta_value ) ) *
                                cos( radians( mt2.meta_value ) - radians({$map_lng}) ) + sin( radians({$map_lat}) ) *
                                sin( radians( mt1.meta_value ) ) ) ) AS distance
                                    FROM $wpdb->posts, $wpdb->postmeta as mt1,$wpdb->postmeta as mt2
                                    WHERE $wpdb->posts.ID = mt1.post_id
                                    and $wpdb->posts.ID=mt2.post_id
                                    AND mt1.meta_key = 'map_lat'
                                    and mt2.meta_key = 'map_lng'
                                    AND $wpdb->posts.post_status = 'publish'
                                    AND $wpdb->posts.post_type = '{$post_type}'
                                    AND $wpdb->posts.post_date < NOW()
                                    GROUP BY $wpdb->posts.ID HAVING distance >= {$range_min} and distance <= {$range_max}
                                    ORDER BY distance ASC
                        ) as st_data
                    )";
			}
			/**
			 * Change Where for Element List
			 * @since  1.2.4
			 * @author dungdt
			 */
			if ( ! empty( $st_search_args['only_featured_location'] ) and ! empty( $st_search_args['featured_location'] ) ) {
				$featured = $st_search_args['featured_location'];
				if ( $st_search_args['only_featured_location'] == 'yes' and is_array( $featured ) ) {
					if ( is_array( $featured ) && count( $featured ) ) {
						$where    .= ' AND (';
						$where_tmp = '';
						foreach ( $featured as $item ) {
							if ( empty( $where_tmp ) ) {
								$where_tmp .= $wpdb->prepare( ' tb.multi_location LIKE %s', '%_' . $item . '_%' );
							} else {
								$where_tmp .= $wpdb->prepare( ' OR tb.multi_location LIKE %s', '%_' . $item . '_%' );
							}
						}
						$featured   = implode( ',', $featured );
						$where_tmp .= " OR tb.id_location IN ({$featured})";
						$where     .= $where_tmp . ')';
					}
				}
			}
			return $where;
		}
		/**
		 *  since 1.2.3
		 */
		static function _get_order_by_query( $orderby, $wp_query ) {

			if ( strpos( $orderby, 'FIELD(' ) !== false && ( strpos( $orderby, 'posts.ID' ) !== false ) ) {
				return $orderby;
			}
			if ( $check = STInput::get( 'orderby' ) ) {
				global $wpdb;

				$is_featured = st()->get_option( 'is_featured_search_tour', 'off' );
				if ( ! empty( $is_featured ) and $is_featured == 'on' ) {
					if ( ! empty( STInput::get( 'check_single_location' ) ) && STInput::get( 'check_single_location' ) === 'is_location' ) {
						$orderby = 'tb_st_tours.is_featured desc';
						$check   = 'is_featured';
					} else {
						$check = $check;
					}
				}
				switch ( $check ) {
					case 'price_asc':
						$orderby = ' CAST(st_tour_price as DECIMAL) asc';
						break;
					case 'price_desc':
						$orderby = ' CAST(st_tour_price as DECIMAL) desc';
						break;

					case 'name_asc':
						$orderby = $wpdb->posts . '.post_title';
						break;
					case 'name_a_z':
						$orderby = $wpdb->posts . '.post_title';
						break;
					case 'name_z_a':
						$orderby = $wpdb->posts . '.post_title desc';
						break;
					case 'name_desc':
						$orderby = $wpdb->posts . '.post_title desc';
						break;
					case 'rand':
						$orderby = ' rand()';
						break;
					case 'new':
						$orderby = $wpdb->posts . '.post_modified desc';
						break;
					default:
						if ( ! empty( $is_featured ) and $is_featured == 'on' ) {
							$orderby = 'tb_st_tours.is_featured desc';

						} else {
							$orderby = $orderby;
						}

						break;
				}
			} else {
				global $wpdb;
				// Check in list of service element
				if ( empty( $wp_query->query['orderby'] ) ) {
					$is_featured = st()->get_option( 'is_featured_search_tour', 'off' );
					if ( ! empty( $is_featured ) and $is_featured == 'on' ) {
						$orderby = 'tb_st_tours.is_featured desc';
					} else {

					}
				}
			}
			return $orderby;
		}
		function alter_search_query() {
			// zzz
			add_action( 'pre_get_posts', [ $this, 'change_search_tour_arg' ] );
			add_filter( 'posts_where', [ $this, '_get_where_query' ] );
			add_filter( 'posts_join', [ $this, '_get_join_query' ] );
			add_filter( 'posts_fields', [ $this, '_get_select_query' ] );
			add_filter( 'posts_orderby', [ $this, '_get_order_by_query' ], 10, 2 );
			add_filter( 'posts_clauses', [ $this, '_get_query_clauses' ] );
		}
		function remove_alter_search_query() {
			remove_action( 'pre_get_posts', [ $this, 'change_search_tour_arg' ] );
			remove_filter( 'posts_where', [ $this, '_get_where_query' ] );
			remove_filter( 'posts_join', [ $this, '_get_join_query' ] );
			remove_filter( 'posts_fields', [ $this, '_get_select_query' ] );
			remove_filter( 'posts_orderby', [ $this, '_get_order_by_query' ] );
			remove_filter( 'posts_clauses', [ $this, '_get_query_clauses' ] );
		}
		/**
		 *
		 *
		 * @since 1.2.4
		 */
		function _get_query_clauses( $clauses ) {
			if ( STAdminTours::check_ver_working() == false ) {
				return $clauses;
			}
			global $wpdb;
			if ( empty( $clauses['groupby'] ) ) {
				$clauses['groupby'] = $wpdb->posts . '.ID';
			}
			if ( isset( $_REQUEST['price_range'] ) && isset( $clauses['groupby'] ) ) {
				$price               = STInput::get( 'price_range', '0;0' );
				$priceobj            = explode( ';', $price );
				$priceobj[0]         = TravelHelper::convert_money_to_default( $priceobj[0] );
				$priceobj[1]         = TravelHelper::convert_money_to_default( $priceobj[1] );
				$min_range           = $priceobj[0];
				$max_range           = $priceobj[1];
				$clauses['groupby'] .= " HAVING CAST(st_tour_price AS DECIMAL) >= {$min_range} AND CAST(st_tour_price AS DECIMAL) <= {$max_range}";
			}
			return $clauses;
		}
		/**
		 *
		 *
		 * @since 1.2.4
		 */
		function _get_select_query( $query ) {
			if ( STAdminTours::check_ver_working() == false ) {
				return $query;
			}
			$post_type = get_query_var( 'post_type' );
			if ( $post_type == 'st_tours' ) {
				$query .= ",
				CASE
					WHEN tb.is_sale_schedule != 'on'
					THEN
						CASE
							WHEN tb.discount_type = 'percent'
							THEN CAST(tb.min_price AS DECIMAL) - ( CAST(tb.min_price AS DECIMAL) / 100 ) * CAST(tb.discount AS DECIMAL)
							ELSE CAST(tb.min_price AS DECIMAL) - CAST(tb.discount AS DECIMAL)
						END
					WHEN tb.is_sale_schedule = 'on'
						AND tb.sale_price_from <= CURDATE() AND tb.sale_price_to >= CURDATE()
					THEN
						CASE
							WHEN tb.discount_type = 'percent'
							THEN CAST(tb.min_price AS DECIMAL) - ( CAST(tb.min_price AS DECIMAL) / 100 ) * CAST(tb.discount AS DECIMAL)
							ELSE CAST(tb.min_price AS DECIMAL) - CAST(tb.discount AS DECIMAL)
						END
					ELSE tb.min_price
				END as st_tour_price";
			}
			return $query;
		}
		/**
		 *
		 *
		 * @update 1.1.3
		 * @update 1.2.4 Use this functions for ST List Tour also
		 * */
		function change_search_tour_arg( $query ) {
			/**
			 * Global Search Args used in Element list and map display
			 * @since 1.2.4
			 */
			$query->set( 'post_status', 'publish' );
			global $st_search_args;
			if ( ! $st_search_args ) {
				$st_search_args = $_REQUEST;
			}
			if ( is_admin() and empty( $_REQUEST['is_search_map'] ) and empty( $_REQUEST['is_search_page'] ) ) {
				return $query;
			}
			$tax_query      = [];
			$post_type      = get_query_var( 'post_type' );
			$posts_per_page = st()->get_option( 'tour_posts_per_page', 12 );
			if ( ! empty( $_REQUEST['posts_per_page'] ) ) {
				$posts_per_page = $_REQUEST['posts_per_page'];
			}
			if ( $post_type == 'st_tours' ) {
				$query->set( 'author', '' );
				if ( STInput::get( 'item_name' ) ) {
					$query->set( 's', STInput::get( 'item_name' ) );
				}
				// Check posts per page for tour
				// if (  !empty( $_REQUEST[ 'is_search_page' ] ) ) {
				$query->set( 'posts_per_page', $posts_per_page );
				// }
				$has_tax_in_element = [];
				if ( is_array( $st_search_args ) ) {
					foreach ( $st_search_args as $key => $val ) {
						if ( strpos( $key, 'taxonomies--' ) === 0 && ! empty( $val ) ) {
							$has_tax_in_element[ $key ] = $val;
						}
					}
				}
				if ( ! empty( $has_tax_in_element ) ) {
					$tax_query = [];
					foreach ( $has_tax_in_element as $tax => $value ) {
						$tax_name = str_replace( 'taxonomies--', '', $tax );
						if ( ! empty( $value ) ) {
							$value       = explode( ',', $value );
							$tax_query[] = [
								'taxonomy' => $tax_name,
								'terms'    => $value,
								'operator' => 'IN',
							];
						}
					}
					if ( ! empty( $tax_query ) ) {
						$query->set( 'tax_query', $tax_query );
					}
				}
				$tax = STInput::get( 'taxonomy' );
				if ( ! empty( $tax ) and is_array( $tax ) ) {
					foreach ( $tax as $key => $value ) {
						if ( $value ) {
							$value = explode( ',', $value );
							if ( ! empty( $value ) and is_array( $value ) ) {
								foreach ( $value as $k => $v ) {
									if ( ! empty( $v ) ) {
										$ids[] = $v;
									}
								}
							}
							if ( ! empty( $ids ) ) {
								$tax_query[] = [
									'taxonomy'         => $key,
									'terms'            => $ids,
									// 'COMPARE'=>"IN",
									'operator'         => 'IN',
									'include_children' => false,
								];
							}
							$ids = [];
						}
					}
				}
				/**
				 * Post In and Post Order By from Element
				 * @since  1.2.4
				 * @author dungdt
				 */
				if ( ! empty( $st_search_args['st_ids'] ) ) {
					$query->set( 'post__in', explode( ',', $st_search_args['st_ids'] ) );
					$query->set( 'orderby', 'post__in' );
				}

				if ( ! empty( $_REQUEST['stt_order'] ) ) {
					$query->set( 'order', $_REQUEST['stt_order'] );
				}
				if ( ! empty( $_REQUEST['stt_orderby'] ) ) {
					$query->set( 'orderby', $_REQUEST['stt_orderby'] );
				}
				if ( ! empty( $st_search_args['st_orderby'] ) and $st_orderby = $st_search_args['st_orderby'] ) {
					if ( $st_orderby == 'rate' ) {
						$query->set( 'meta_key', 'rate_review' );
						$query->set( 'orderby', 'meta_value_num' );
					}
					if ( $st_orderby == 'discount' ) {
						$query->set( 'order', $st_search_args['st_order'] );
						$query->set( 'meta_key', 'discount' );
						$query->set( 'orderby', 'meta_value_num' );
					}
					if ( $st_orderby == 'last_minute_deal' ) {
						$query->set( 'order', 'DESC' );
						$query->set( 'orderby', 'meta_value' );
						$query->set( 'meta_key', 'sale_price_from' );
						$meta_query[] = [
							'key'     => 'is_sale_schedule',
							'value'   => 'on',
							'compare' => '=',
						];
					}
					if ( $st_orderby == 'featured' ) {
						$query->set( 'meta_key', 'is_featured' );
						$query->set( 'orderby', 'meta_value' );
						$query->set( 'order', 'DESC' );
					}
				}
				if ( ! empty( $st_search_args['sort_taxonomy'] ) and $sort_taxonomy = $st_search_args['sort_taxonomy'] ) {
					if ( isset( $st_search_args[ 'id_term_' . $sort_taxonomy ] ) ) {
						$id_term     = $st_search_args[ 'id_term_' . $sort_taxonomy ];
						$tax_query[] = [
							[
								'taxonomy'         => $sort_taxonomy,
								'field'            => 'id',
								'terms'            => explode( ',', $id_term ),
								'include_children' => false,
							],
						];
					}
				}
				if ( ! empty( $meta_query ) ) {
					$query->set( 'meta_query', $meta_query );
				}
				if ( ! empty( $tax_query ) ) {
					$type_filter_option_attribute = st()->get_option( 'type_filter_option_attribute_tour', 'and' );
					array_push( $tax_query, [ 'relation' => $type_filter_option_attribute ] );
					$query->set( 'tax_query', $tax_query );
				}
			}
		}
		function choose_search_template( $template ) {
			global $wp_query;
			$post_type = get_query_var( 'post_type' );
			if ( $wp_query->is_search && $post_type == 'st_tours' ) {
				return locate_template( 'search-tour.php' );  // redirect to archive-search.php
			}
			return $template;
		}
		function get_result_string() {
			global $wp_query, $st_search_query;
			if ( $st_search_query ) {
				$query = $st_search_query;
			} else {
				$query = $wp_query;
			}
			$p1          = $p2 = '';
			$location_id = intval( STInput::get( 'location_id' ) );
			if ( $location_id and $location = get_post( $location_id ) ) {
				$p1 = sprintf( __( '%s: ', 'traveler' ), get_the_title( $location_id ) );
			} elseif ( STInput::request( 'location_name' ) ) {
				$p1 = sprintf( __( '%s: ', 'traveler' ), STInput::request( 'location_name' ) );
			} elseif ( STInput::request( 'address' ) ) {
				$p1 = sprintf( __( '%s: ', 'traveler' ), STInput::request( 'address' ) );
			}
			if ( $query->found_posts ) {
				if ( $query->found_posts > 1 ) {
					$p2 = sprintf( __( '%s tours found', 'traveler' ), $query->found_posts );
				} else {
					$p2 = sprintf( __( '%s tour found', 'traveler' ), $query->found_posts );
				}
			} else {
				$p2 = __( 'Could not find any tours', 'traveler' );
			}
			// check Right to left
			if ( st()->get_option( 'right_to_left' ) == 'on' || is_rtl() ) {
				return $p2 . $p1;
			}
			return esc_html( $p1 . $p2 );
		}
		static function get_count_book( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			// $post_type = get_post_type($id_post);
			$query = [
				'post_type'     => 'st_order',
				'post_per_page' => '-1',
				'meta_query'    => [
					[
						'key'     => 'item_id',
						'value'   => $post_id,
						'compare' => '=',
					],
				],
			];
			$query = new WP_Query( $query );
			$count = $query->post_count;
			wp_reset_postdata();
			return $count;
		}
		static function get_count_user_book( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$count = 0;
			if ( st()->get_option( 'use_woocommerce_for_booking', 'off' ) == 'on' ) {
				global $wpdb;
				$query = '  SELECT ' . $wpdb->prefix . 'woocommerce_order_items.*,' . $wpdb->prefix . 'woocommerce_order_itemmeta.meta_value,st_meta1.meta_value FROM ' . $wpdb->prefix . 'woocommerce_order_items
                                INNER JOIN ' . $wpdb->prefix . 'woocommerce_order_itemmeta  ON ' . $wpdb->prefix . 'woocommerce_order_itemmeta.order_item_id = ' . $wpdb->prefix . 'woocommerce_order_items.order_item_id and ' . $wpdb->prefix . "woocommerce_order_itemmeta.meta_key='_st_st_booking_id'
                                INNER JOIN " . $wpdb->prefix . 'woocommerce_order_itemmeta as st_meta1  ON st_meta1.order_item_id = ' . $wpdb->prefix . "woocommerce_order_items.order_item_id and st_meta1.meta_key='_st_number_book'
                                WHERE 1=1
                                AND " . $wpdb->prefix . 'woocommerce_order_itemmeta.meta_value = ' . get_the_ID();
				$rs    = $wpdb->get_results( $query, OBJECT );
				if ( ! empty( $rs ) ) {
					foreach ( $rs as $k => $v ) {
						$count = $count + $v->meta_value;
					}
				}
			} else {
				$query     = [
					'post_type'     => 'st_order',
					'post_per_page' => '-1',
					'meta_query'    => [
						[
							'key'     => 'item_id',
							'value'   => $post_id,
							'compare' => '=',
						],
					],
				];
				$type_tour = get_post_meta( $post_id, 'type_tour', true );
				if ( $type_tour == 'daily_tour' ) {
					$query['date_query'] = [
						[
							'after'     => date( 'Y-m-d' ),
							'before'    => date( 'Y-m-d' ),
							'inclusive' => true,
						],
					];
				}
				$query = new WP_Query( $query );
				while ( $query->have_posts() ) {
					$query->the_post();
					$count = $count + get_post_meta( get_the_ID(), 'adult_number', true );
					$count = $count + get_post_meta( get_the_ID(), 'child_number', true );
				}
				wp_reset_postdata();
			}
			return $count;
		}
		function tours_add_to_cart() {
			if ( STInput::request( 'action' ) == 'tours_add_to_cart' ) {
				if ( self::do_add_to_cart() ) {
					$link = STCart::get_cart_link();
					wp_safe_redirect( $link );
					die;
				}
			}
		}
		/**
		 * from 1.1.7 fix price child adult by person booking
		 */
		function filter_price_by_person( $price_old, $number, $key = 1 ) {
			$discount_by_adult = ( get_post_meta( STInput::request( 'item_id' ), 'discount_by_adult', true ) );
			$discount_by_child = ( get_post_meta( STInput::request( 'item_id' ), 'discount_by_child', true ) );
			if ( $key == 1 and is_array( $discount_by_adult ) and ! empty( $discount_by_adult ) ) {
				foreach ( $discount_by_adult as $key => $value ) {
					if ( $number >= $value['key'] ) {
						$flag_return = ( 1 - $value['value'] / 100 ) * $price_old;
					}
					if ( ! $flag_return ) {
						$flag_return = $price_old;
					}
				}
				return $flag_return;
			}
			if ( $key == 2 and is_array( $discount_by_child ) and ! empty( $discount_by_child ) ) {
				foreach ( $discount_by_child as $key => $value ) {
					if ( $number >= $value['key'] ) {
						$flag_return = ( 1 - $value['value'] / 100 ) * $price_old;
					}
					if ( ! $flag_return ) {
						$flag_return = $price_old;
					}
				}
				return $flag_return;
			}
			return $price_old;
		}
		/*
		 * @updated 1.2.3
		 */
		function do_add_to_cart() {
			$pass_validate = true;
			$item_id       = STInput::request( 'item_id', '' );
			if ( $item_id <= 0 || get_post_type( $item_id ) != 'st_tours' ) {
				STTemplate::set_message( __( 'This tour is not available..', 'traveler' ), 'danger' );
				$pass_validate = false;
				return false;
			}
			$tour_origin           = TravelHelper::post_origin( $item_id, 'st_tours' );
			$tour_price_by         = get_post_meta( $tour_origin, 'tour_price_by', true );
			$number                = 1;
			$adult_number          = intval( STInput::request( 'adult_number', 0 ) );
			$child_number          = intval( STInput::request( 'child_number', 0 ) );
			$infant_number         = intval( STInput::request( 'infant_number', 0 ) );
			$starttime             = STInput::request( 'starttime_tour', '' );
			$data['adult_number']  = $adult_number;
			$data['child_number']  = $child_number;
			$data['infant_number'] = $infant_number;
			$data['starttime']     = $starttime;
			$min_number            = intval( get_post_meta( $item_id, 'min_people', true ) );
			if ( $min_number <= 0 ) {
				$min_number = 1;
			}
			$max_number         = intval( get_post_meta( $item_id, 'max_people', true ) );
			$type_tour          = get_post_meta( $item_id, 'type_tour', true );
			$data['type_tour']  = $type_tour;
			$data['price_type'] = self::get_price_type( $item_id );
			$today              = date( 'Y-m-d' );
			// echo STInput::request( 'check_in', '' );die;
			$check_in  = TravelHelper::convertDateFormat( STInput::request( 'check_in', '' ) );
			$check_out = TravelHelper::convertDateFormat( STInput::request( 'check_out', '' ) );
			if ( ! $adult_number and ! $child_number and ! $infant_number ) {
				STTemplate::set_message( __( 'Please select at least one person.', 'traveler' ), 'danger' );
				$pass_validate = false;
				return false;
			}
			if ( $adult_number + $child_number + $infant_number < $min_number ) {
				STTemplate::set_message( sprintf( __( 'Min number of people for this tour is %d people', 'traveler' ), $min_number ), 'danger' );
				$pass_validate = false;
				return false;
			}

			if ( empty( STInput::request( 'disable_require_name' ) ) ) {
				if ( ! st_validate_guest_name( $tour_origin, $adult_number, $child_number, 0 ) ) {
					STTemplate::set_message( __( 'Please enter the Guest Name', 'traveler' ), 'danger' );
					$pass_validate = false;
					return false;
				}
			}

			/**
			 * @since 1.2.8
			 *        Only check limit people when max_people > 0 (unlimited)
			 * */
			if ( $max_number > 0 ) {
				if ( $adult_number + $child_number + $infant_number > $max_number ) {
					STTemplate::set_message( sprintf( __( 'Max of people for this tour is %d people', 'traveler' ), $max_number ), 'danger' );
					$pass_validate = false;
					return false;
				}
			}
			if ( ! $check_in || ! $check_out ) {
				STTemplate::set_message( __( 'Select a day in the calendar.', 'traveler' ), 'danger' );
				$pass_validate = false;
				return false;
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				$compare = TravelHelper::dateCompare( $today, $check_in );
				if ( $compare < 0 ) {
					STTemplate::set_message( __( 'This tour has expired', 'traveler' ), 'danger' );
					$pass_validate = false;
					return false;
				}
			}
			$booking_period = intval( get_post_meta( $item_id, 'tours_booking_period', true ) );
			$period         = STDate::dateDiff( $today, $check_in );
			if ( $period < $booking_period ) {
				STTemplate::set_message( sprintf( __( 'This tour allow minimum booking is %d day(s)', 'traveler' ), $booking_period ), 'danger' );
				$pass_validate = false;
				return false;
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				$tour_available = TourHelper::checkAvailableTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
				if ( ! $tour_available ) {
					STTemplate::set_message( __( 'The check in, check out day is invalid or this tour not available.', 'traveler' ), 'danger' );
					$pass_validate = false;
					return false;
				}
			}
			if ( $tour_price_by != 'fixed_depart' ) {
				if ( $max_number > 0 ) {
					$free_people = $max_number;
					if ( empty( trim( $starttime ) ) ) {
						$result = TourHelper::_get_free_peple( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
					} else {
						$result = TourHelper::_get_free_peple_by_time( $tour_origin, strtotime( $check_in ), strtotime( $check_out ), $starttime );
					}
					if ( $tour_price_by == 'fixed' ) {
						if ( ! empty( $result ) && ! empty( trim( $starttime ) ) ) {
							STTemplate::set_message( sprintf( __( 'This tour is not available.', 'traveler' ) ), 'danger' );
							$pass_validate = false;
							return false;
						}
					}
					if ( is_array( $result ) && count( $result ) ) {
						$free_people = intval( $result['free_people'] );
					}
					/**
					 * @since 1.2.8
					 *        Only check limit people when max_people > 0 (unlimited)
					 * */
					if ( $free_people < ( $adult_number + $child_number + $infant_number ) ) {
						if ( empty( trim( $starttime ) ) ) {
							STTemplate::set_message( sprintf( __( 'This tour is only available for %d people', 'traveler' ), $free_people ), 'danger' );
						} else {
							STTemplate::set_message( sprintf( __( 'This tour is only available for %1$d people at %2$s', 'traveler' ), $free_people, $starttime ), 'danger' );
						}
						$pass_validate = false;
						return false;
					}
				}
			} else {
				/**
				 * Get Free people
				 * If adult + child + infant < total -> return true
				 * else return false
				 */
				if ( $max_number > 0 ) {
					$free_people = TourHelper::getFreePeopleTourFixedDepart( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
					if ( $free_people < ( $adult_number + $child_number + $infant_number ) ) {
						STTemplate::set_message( sprintf( __( 'This tour is only available for %d people', 'traveler' ), $free_people ), 'danger' );
						$pass_validate = false;
						return false;
					}
				}
			}
			/**
			 * Validate Guest Name
			 *
			 * @since 2.1.2
			 * @author dannie
			 */
			/*
			if(!st_validate_guest_name($tour_origin,$adult_number,$child_number,$infant_number))
				{
				STTemplate::set_message(esc_html__('Please enter the Guest Name','traveler'), 'danger');
				$pass_validate = FALSE;
				return FALSE;
				} */
			$extras              = STInput::request( 'extra_price', [] );
			$extra_price         = self::geExtraPrice( $extras );
			$data['extras']      = $extras;
			$data['extra_price'] = $extra_price;
			$data['guest_title'] = STInput::post( 'guest_title' );
			$data['guest_name']  = STInput::post( 'guest_name' );
			// Hotel package
			$hotel_packages = STInput::request( 'hotel_package', [] );
			$arr_hotel_temp = [];
			if ( ! empty( $hotel_packages ) ) {
				foreach ( $hotel_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_hotel_temp, $v[0] );
					}
				}
			}
			$package_hotels = [];
			if ( ! empty( $arr_hotel_temp ) ) {
				$hp = 0;
				foreach ( $arr_hotel_temp as $k => $v ) {
					$sub_hotel_package = json_decode( stripcslashes( $v ) );
					if ( intval( $arr_hotel_temp[ $k - 1 ] ) > 0 ) {
						if ( ( $k > 0 ) && is_object( $sub_hotel_package ) ) {
							$sub_hotel_package->qty = intval( $arr_hotel_temp[ $k - 1 ] );
						}
						if ( is_object( $sub_hotel_package ) ) {
							$package_hotels[ $hp ] = $sub_hotel_package;
							++$hp;
						}
					}
				}
			}
			$package_hotel_price         = self::_get_hotel_package_price( $package_hotels );
			$data['package_hotel']       = $package_hotels;
			$data['package_hotel_price'] = $package_hotel_price;
			// Activity package
			$activity_packages = STInput::request( 'activity_package', [] );
			$arr_activity_temp = [];
			if ( ! empty( $activity_packages ) ) {
				foreach ( $activity_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_activity_temp, $v[0] );
					}
				}
			}
			$package_activities = [];
			if ( ! empty( $arr_activity_temp ) ) {
				$hp = 0;
				foreach ( $arr_activity_temp as $k => $v ) {
					$sub_activity_package = json_decode( stripcslashes( $v ) );
					if ( intval( $arr_activity_temp[ $k - 1 ] ) > 0 ) {
						if ( ( $k > 0 ) && is_object( $sub_activity_package ) ) {
							$sub_activity_package->qty = $arr_activity_temp[ $k - 1 ];
						}
						if ( is_object( $sub_activity_package ) ) {
							$package_activities[ $hp ] = $sub_activity_package;
							++$hp;
						}
					}
				}
			}
			$package_activity_price         = self::_get_activity_package_price( $package_activities );
			$data['package_activity']       = $package_activities;
			$data['package_activity_price'] = $package_activity_price;
			// Car package
			$car_name_packages_temp = STInput::request( 'car_name', [] );
			$car_name_packages      = [];
			if ( ! empty( $car_name_packages_temp ) ) {
				foreach ( $car_name_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_name_packages, $v[0] );
					}
				}
			}
			$car_price_packages_temp = STInput::request( 'car_price', [] );
			$car_price_packages      = [];
			if ( ! empty( $car_price_packages_temp ) ) {
				foreach ( $car_price_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_price_packages, $v[0] );
					}
				}
			}
			$car_quantity_packages_temp = STInput::request( 'car_quantity', [] );
			$car_quantity_packages      = [];
			if ( ! empty( $car_quantity_packages_temp ) ) {
				foreach ( $car_quantity_packages_temp as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $car_quantity_packages, $v[0] );
					}
				}
			}
			$package_cars              = self::_convert_data_car_package( $car_name_packages, $car_price_packages, $car_quantity_packages );
			$package_car_price         = self::_get_car_package_price( $package_cars );
			$data['package_car']       = $package_cars;
			$data['package_car_price'] = $package_car_price;
			// Flight package
			$flight_packages = STInput::request( 'flight_package', [] );

			$arr_flight_temp = [];
			if ( ! empty( $flight_packages ) ) {
				foreach ( $flight_packages as $k => $v ) {
					if ( ! empty( $v ) ) {
						array_push( $arr_flight_temp, $v[0] );
					}
				}
			}
			$package_flight = [];

			if ( ! empty( $arr_flight_temp ) ) {
				$hp = 0;
				foreach ( $arr_flight_temp as $k => $v ) {
					$sub_flight_package = json_decode( stripcslashes( $v ) );
					if ( intval( $arr_flight_temp[ $k + 1 ] ) > 0 ) {
						if ( is_object( $sub_flight_package ) ) {
							$sub_flight_package->qty = $arr_flight_temp[ $k + 1 ];
						}
						if ( is_object( $sub_flight_package ) ) {
							$package_flight[ $hp ] = $sub_flight_package;
							++$hp;
						}
					}
				}
			}
			$package_flight_price         = self::_get_flight_package_price( $package_flight );
			$data['package_flight']       = $package_flight;
			$data['package_flight_price'] = $package_flight_price;
			// End flight package
			$price_type = self::get_price_type( $tour_origin );
			if ( $price_type == 'person' ) {
				$data_price = STPrice::getPriceByPeopleTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ), $adult_number, $child_number, $infant_number );
			} else {
				$data_price = STPrice::getPriceByFixedTour( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
			}
			$total_price       = $data_price['total_price'];
			$data['check_in']  = date( 'm/d/Y', strtotime( $check_in ) );
			$data['check_out'] = date( 'm/d/Y', strtotime( $check_out ) );
			if ( $price_type == 'fixed_depart' ) {
				$people_price                 = [];
				$people_price['adult_price']  = get_post_meta( $tour_origin, 'adult_price', true );
				$people_price['child_price']  = get_post_meta( $tour_origin, 'child_price', true );
				$people_price['infant_price'] = get_post_meta( $tour_origin, 'infant_price', true );
				$data                         = wp_parse_args( $data, $people_price );
			} elseif ( $price_type == 'person' ) {
				$people_price = STPrice::getPeoplePrice( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
				$data         = wp_parse_args( $data, $people_price );
			} else {
				$fixed_price = STPrice::getFixedPrice( $tour_origin, strtotime( $check_in ), strtotime( $check_out ) );
				$data        = wp_parse_args( $data, $fixed_price );
			}
			$data['ori_price']     = $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price;
			$data['sale_price']    = $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price;
			$data['commission']    = TravelHelper::get_commission( $item_id );
			$data['data_price']    = $data_price;
			$data['discount_rate'] = STPrice::get_discount_rate( $tour_origin, strtotime( $check_in ) );
			$data['discount_type'] = get_post_meta( $tour_origin, 'discount_type', true );
			if ( $pass_validate ) {
				$data['duration'] = ( $type_tour == 'daily_tour' ) ? get_post_meta( $tour_origin, 'duration_day', true ) : '';
				if ( $pass_validate ) {
					STCart::add_cart( $tour_origin, $number, $data['sale_price'], $data );
				}
			}
			return $pass_validate;
		}
		static function geExtraPrice( $extra_price = [] ) {
			$total_price = 0;
			if ( isset( $extra_price['value'] ) && is_array( $extra_price['value'] ) && count( $extra_price['value'] ) ) {
				foreach ( $extra_price['value'] as $name => $number ) {
					$price_item = floatval( $extra_price['price'][ $name ] );
					if ( $price_item <= 0 ) {
						$price_item = 0;
					}
					$number_item = intval( $extra_price['value'][ $name ] );
					if ( $number_item <= 0 ) {
						$number_item = 0;
					}
					$total_price += $price_item * $number_item;
				}
			}
			return $total_price;
		}
		function get_cart_item_html( $item_id = false ) {
			$page_style = st()->get_option( 'page_checkout_style', 1 );
			if ( $page_style == '2' ) {
				return stt_elementorv2()->loadView( 'services/tour/components/cart-item', [ 'item_id' => $item_id ] );
			} else {
				return st()->load_template( 'layouts/modern/tour/elements/cart-item', null, [ 'item_id' => $item_id ] );
			}
		}
		function custom_tour_layout( $old_layout_id ) {
			if ( is_singular( 'st_tours' ) ) {
				$meta = get_post_meta( get_the_ID(), 'st_custom_layout', true );
				if ( $meta ) {
					return $meta;
				}
			}
			return $old_layout_id;
		}
		function get_search_fields() {
			$fields = st()->get_option( 'activity_tour_search_fields' );
			return $fields;
		}
		static function get_info_price( $post_id = null ) {
			/**
			 * @since 1.2.5
			 * filter hook get_price_html
			 * author quandq
			 */
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$prices    = self::get_price_person( $post_id );
			$price_old = $price_new = 0;
			if ( ! empty( $prices['adult'] ) ) {
				$price_old = $prices['adult'];
				$price_new = $prices['adult_new'];
			} elseif ( ! empty( $prices['child'] ) ) {
				$price_old = $prices['child'];
				$price_new = $prices['child_new'];
			} elseif ( ! empty( $prices['infant'] ) ) {
				$price_old = $prices['infant'];
				$price_new = $prices['infant_new'];
			}
			return [
				'price_old' => $price_old,
				'price_new' => $price_new,
				'discount'  => $prices['discount'],
			];
		}
		static function get_price_person( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$adult_price  = (float) get_post_meta( $post_id, 'adult_price', true );
			$child_price  = (float) get_post_meta( $post_id, 'child_price', true );
			$infant_price = (float) get_post_meta( $post_id, 'infant_price', true );
			if ( $adult_price < 0 ) {
				$adult_price = 0;
			}
			if ( $child_price < 0 ) {
				$child_price = 0;
			}
			if ( $infant_price < 0 ) {
				$infant_price = 0;
			}
			/*
			$adult_price = apply_filters('st_apply_tax_amount',$adult_price);
				$child_price = apply_filters('st_apply_tax_amount',$child_price);
				$infant_price = apply_filters('st_apply_tax_amount',$infant_price); */
			$discount         = get_post_meta( $post_id, 'discount', true );
			$is_sale_schedule = get_post_meta( $post_id, 'is_sale_schedule', true );
			if ( $is_sale_schedule == 'on' ) {
				$sale_from = get_post_meta( $post_id, 'sale_price_from', true );
				$sale_to   = get_post_meta( $post_id, 'sale_price_to', true );
				if ( $sale_from and $sale_from ) {
					$today     = date( 'Y-m-d' );
					$sale_from = date( 'Y-m-d', strtotime( $sale_from ) );
					$sale_to   = date( 'Y-m-d', strtotime( $sale_to ) );
					if ( ( $today >= $sale_from ) && ( $today <= $sale_to ) ) {
					} else {
						$discount = 0;
					}
				} else {
					$discount = 0;
				}
			}
			if ( $discount ) {
				$discount_type = get_post_meta( $post_id, 'discount_type', true );
				if ( $discount < 0 ) {
					$discount = 0;
				}
				if ( $discount > 100 && $discount_type == 'percent' ) {
					$discount = 100;
				}
				switch ( $discount_type ) {
					case 'amount':
						$adult_price_new  = $adult_price - $discount;
						$child_price_new  = $child_price - $discount;
						$infant_price_new = $infant_price - $discount;
						break;
					default:
						$adult_price_new  = $adult_price - ( $adult_price / 100 ) * $discount;
						$child_price_new  = $child_price - ( $child_price / 100 ) * $discount;
						$infant_price_new = $infant_price - ( $infant_price / 100 ) * $discount;
						break;
				}
				$data = [
					'adult'         => $adult_price,
					'adult_new'     => $adult_price_new,
					'child'         => $child_price,
					'child_new'     => $child_price_new,
					'infant'        => $infant_price,
					'infant_new'    => $infant_price_new,
					'discount'      => $discount,
					'discount_type' => $discount_type,
				];
			} else {
				$data = [
					'adult_new'  => $adult_price,
					'adult'      => $adult_price,
					'child'      => $child_price,
					'child_new'  => $child_price,
					'infant'     => $infant_price,
					'infant_new' => $infant_price,
					'discount'   => $discount,
				];
			}
			$off_adult  = get_post_meta( $post_id, 'hide_adult_in_booking_form', true );
			$off_child  = get_post_meta( $post_id, 'hide_children_in_booking_form', true );
			$off_infant = get_post_meta( $post_id, 'hide_infant_in_booking_form', true );
			if ( $off_adult == 'on' ) {
				unset( $data['adult'] );
				unset( $data['adult_new'] );
			}
			if ( $off_child == 'on' ) {
				unset( $data['child'] );
				unset( $data['child_new'] );
			}
			if ( $off_infant == 'on' ) {
				unset( $data['infant'] );
				unset( $data['infant_new'] );
			}
			return $data;
		}
		static function get_price_fixed( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$base_price = (float) get_post_meta( $post_id, 'base_price', true );
			if ( $base_price < 0 ) {
				$base_price = 0;
			}
			$discount         = get_post_meta( $post_id, 'discount', true );
			$is_sale_schedule = get_post_meta( $post_id, 'is_sale_schedule', true );
			if ( $is_sale_schedule == 'on' ) {
				$sale_from = get_post_meta( $post_id, 'sale_price_from', true );
				$sale_to   = get_post_meta( $post_id, 'sale_price_to', true );
				if ( $sale_from and $sale_from ) {
					$today     = date( 'Y-m-d' );
					$sale_from = date( 'Y-m-d', strtotime( $sale_from ) );
					$sale_to   = date( 'Y-m-d', strtotime( $sale_to ) );
					if ( ( $today >= $sale_from ) && ( $today <= $sale_to ) ) {
						$discount = $discount;
					} else {
						$discount = 0;
					}
				} else {
					$discount = 0;
				}
			}
			if ( $discount ) {
				$discount_type = get_post_meta( $post_id, 'discount_type', true );
				if ( $discount < 0 ) {
					$discount = 0;
				}
				if ( $discount > 100 && $discount_type == 'percent' ) {
					$discount = 100;
				}
				switch ( $discount_type ) {
					case 'amount':
						$base_price_new = $base_price - $discount;
						break;
					default:
						$base_price_new = $base_price - ( $base_price / 100 ) * $discount;
						break;
				}
				$data = [
					'base'          => $base_price,
					'base_new'      => $base_price_new,
					'discount'      => $discount,
					'discount_type' => $discount_type,
				];
			} else {
				$data = [
					'base_new' => $base_price,
					'base'     => $base_price,
					'discount' => $discount,
				];
			}
			return $data;
		}
		static function get_price_html( $post_id = false, $get = false, $st_mid = '', $class = '', $hide_title = true ) {
			/*
				* since 1.1.3
				* filter hook get_price_html
			*/
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$post_id    = TravelHelper::post_origin( $post_id, 'st_tours' );
			$price_type = self::get_price_type( $post_id );
			if ( $price_type == 'person' or $price_type == 'fixed_depart' ) {
				$prices = self::get_price_person( $post_id );
			} else {
				$prices = self::get_price_fixed( $post_id );
			}
			$price_old = $price_new = 0;
			if ( $price_type == 'person' or $price_type == 'fixed_depart' ) {
				if ( ! empty( $prices['adult'] ) ) {
					$price_old = $prices['adult'];
					$price_new = $prices['adult_new'];
				} elseif ( ! empty( $prices['child'] ) && empty( $prices['adult'] ) ) {
					$price_old = $prices['child'];
					$price_new = $prices['child_new'];
				} elseif ( ! empty( $prices['infant'] ) && empty( $prices['adult'] ) && empty( $prices['child'] ) ) {
					$price_old = $prices['infant'];
					$price_new = $prices['infant_new'];
				}
			} else {
				$price_old = $prices['base'];
				$price_new = $prices['base_new'];
			}
			$discount_type = isset( $prices['discount_type'] ) ? $prices['discount_type'] : '';
			$discount      = isset( $prices['discount'] ) ? $prices['discount'] : 0;
			$post_type     = 'st_tours';
			global $wpdb;
			$current_lang = TravelHelper::current_lang();
			$main_lang    = TravelHelper::primary_lang();
			if ( TravelHelper::is_wpml() ) {
				global $sitepress;
				$sitepress->switch_lang( $main_lang, true );
			}
			$meta_key = 'min_price';
			$where    = "where 1=1 and ( {$wpdb->prefix}{$post_type}.post_id = {$post_id})";
			$sql      = "SELECT
                    min(CAST(`min_price` as DECIMAL(15,6))) as min
                FROM
                    {$wpdb->prefix}{$post_type}
                {$where}";
			$results  = $wpdb->get_results( $sql, OBJECT );
			if ( TravelHelper::is_wpml() ) {
				global $sitepress;
				$sitepress->switch_lang( $current_lang, true );
			}
			$price_new      = $results[0]->min;
			$price_new_sale = $price_new;
			if ( ! empty( $discount_type ) && ( $discount > 0 ) ) {
				switch ( $discount_type ) {
					case 'amount':
						if ( $price_new < $discount ) {

							$price_new_sale = 0;
						} else {
							$price_new_sale = $price_new - $discount;
						}
						break;
					default:
						if ( isset( $discount ) && ( $discount > 0 ) ) {
							$price_new_sale = $price_new - ( $price_new / 100 ) * $discount;
						} else {
							$price_new_sale = $price_new;
						}
						break;
				}
			}
			$html = '';
			if ( $class == 'sale-top' ) {
				if ( $price_new_sale != $price_new ) {
					$html .= '<span class="text-small lh1em item onsale ">' . TravelHelper::format_money( $price_new ) . '</span>';
				}
				$html .= '<span class="' . esc_attr( $class ) . '">';
				if ( ! $hide_title and $price_new > 0 ) {
					$html .= __( 'From  ', 'traveler' );
				}

				$price_new = TravelHelper::format_money( $price_new );
				$html     .= '<span class="text-lg lh1em item "> ' . TravelHelper::format_money( $price_new_sale ) . '</span>';
				$html     .= '</span>';
			} else {
				if ( ! $hide_title and $price_new > 0 ) {
					$html .= __( 'From  ', 'traveler' );
				}
				if ( $price_new_sale != $price_new ) {
					$html .= '<span class="text-small lh1em item onsale ">' . TravelHelper::format_money( $price_new ) . '</span>';
				}
				$price_new = TravelHelper::format_money( $price_new );
				$html     .= '<span class="text-lg lh1em item "> ' . TravelHelper::format_money( $price_new_sale ) . '</span>';
			}

			return apply_filters( 'st_get_tour_price_html', $html );
		}
		static function get_array_discount_by_person_num( $item_id = false ) {
			/* @since 1.1.1 */
			$return            = [];
			$discount_by_adult = get_post_meta( $item_id, 'discount_by_adult', true );
			$discount_by_child = get_post_meta( $item_id, 'discount_by_child', true );
			if ( ! $discount_by_adult and ! $discount_by_child ) {
				return false;
			}
			if ( is_array( $discount_by_adult ) and ! empty( $discount_by_adult ) ) {
				foreach ( $discount_by_adult as $row ) {
					$key                     = (int) $row['key'];
					$value                   = (int) $row['value'] / 100;
					$return['adult'][ $key ] = $value;
				}
			} else {
				$return['adult'] = [];
			}
			if ( is_array( $discount_by_child ) and ! empty( $discount_by_child ) ) {
				foreach ( $discount_by_child as $row ) {
					$key                     = (int) $row['key'];
					$value                   = (int) $row['value'] / 100;
					$return['child'][ $key ] = $value;
				}
			} else {
				$return['child'] = [];
			}
			return $return;
		}
		static function get_cart_item_total( $item_id, $item ) {
			$count_sale = 0;
			$price_sale = $item['price'];
			if ( ! empty( $item['data']['discount'] ) ) {
				$count_sale = $item['data']['discount'];
				$price_sale = $item['data']['price_sale'] * $item['number'];
			}
			$adult_number = $item['data']['adult_number'];
			$child_number = $item['data']['child_number'];
			$adult_price  = $item['data']['adult_price'];
			$child_price  = $item['data']['child_price'];
			if ( $adult_price < 0 ) {
				$adult_price = 0;
			}
			if ( $child_price < 0 ) {
				$child_price = 0;
			}
			if ( $get_array_discount_by_person_num = self::get_array_discount_by_person_num( $item_id ) ) {
				if ( $array_adult = $get_array_discount_by_person_num['adult'] ) {
					if ( is_array( $array_adult ) and ! empty( $array_adult ) ) {
						foreach ( $array_adult as $key => $value ) {
							if ( $adult_number >= (int) $key ) {
								$adult_price2 = $adult_price * $value;
							}
						}
						if ( ! empty( $adult_price2 ) ) {
							$adult_price -= $adult_price2;
						}
					}
				}
				if ( $array_child = $get_array_discount_by_person_num['child'] ) {
					if ( is_array( $array_child ) and ! empty( $array_child ) ) {
						foreach ( $array_child as $key => $value ) {
							if ( $child_number >= (int) $key ) {
								$child_price2 = $child_price * $value;
							}
						}
						if ( ! empty( $child_price2 ) ) {
							$child_price -= $child_price2;
						}
					}
				}
			}
			$adult_price  = round( $adult_price );
			$child_price  = round( $child_price );
			$total_price  = $adult_number * st_get_discount_value( $adult_price, $count_sale, false );
			$total_price += $child_number * st_get_discount_value( $child_price, $count_sale, false );
			return $total_price;
		}
		function get_near_by( $post_id = false, $range = 20, $limit = 5 ) {
			$this->post_type = 'st_tours';
			return parent::get_near_by( $post_id, $range, $limit );
		}
		static function get_owner_email( $item_id ) {
			$theme_option   = st()->get_option( 'partner_show_contact_info' );
			$metabox        = get_post_meta( $item_id, 'show_agent_contact_info', true );
			$use_agent_info = false;
			if ( $theme_option == 'on' ) {
				$use_agent_info = true;
			}
			if ( $metabox == 'user_agent_info' ) {
				$use_agent_info = true;
			}
			if ( $metabox == 'user_item_info' ) {
				$use_agent_info = false;
			}
			if ( $use_agent_info ) {
				$post = get_post( $item_id );
				if ( $post ) {
					return get_the_author_meta( 'user_email', $post->post_author );
				}
			}
			return get_post_meta( $item_id, 'contact_email', true );
		}
		public static function tour_external_booking_submit() {
			/*
			 * since 1.1.1
			 * filter hook tour_external_booking_submit
			 */
			$post_id = get_the_ID();
			if ( STInput::request( 'post_id' ) ) {
				$post_id = STInput::request( 'post_id' );
			}
			$tour_external_booking      = get_post_meta( $post_id, 'st_tour_external_booking', 'off' );
			$tour_external_booking_link = get_post_meta( $post_id, 'st_tour_external_booking_link', true );
			if ( $tour_external_booking == 'on' and $tour_external_booking_link !== '' ) {
				if ( get_post_meta( $post_id, 'st_tour_external_booking_link', true ) ) {
					ob_start();
					?>
					<a class='btn btn-primary'
						href='<?php echo get_post_meta( $post_id, 'st_tour_external_booking_link', true ) ?>'> <?php st_the_language( 'book_now' ) ?></a>
					<?php
					$return = ob_get_clean();
				}
			} else {
				$return = TravelerObject::get_book_btn();
			}
			return apply_filters( 'tour_external_booking_submit', $return );
		}
		/* @since 1.1.3 */
		static function get_taxonomy_and_id_term_tour() {
			$list_taxonomy = st_list_taxonomy( 'st_tours' );
			$list_id_vc    = [];
			$param         = [];
			$list_value    = [];
			foreach ( $list_taxonomy as $k => $v ) {
				$param[]                       = [
					'type'       => 'st_checkbox',
					'holder'     => 'div',
					'heading'    => $k,
					'param_name' => 'id_term_' . $v,
					'stype'      => 'list_terms',
					'sparam'     => $v,
					'dependency' => [
						'element' => 'sort_taxonomy',
						'value'   => [ $v ],
					],
				];
				$list_value                    = '';
				$list_id_vc[ 'id_term_' . $v ] = '';
			}
			return [
				'list_vc'    => $param,
				'list_id_vc' => $list_id_vc,
			];
		}
		/**
		 * from 1.1.7
		 * removed $duration_unit from 1.2.7
		 */
		static function get_duration_unit( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$duration = get_post_meta( $post_id, 'duration_day', true );
			return $duration;
		}
		/**
		 * from 2.0.0
		 * @param null $post_id
		 * @return mixed
		 */
		static function get_starttime_unit( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$starttime = get_post_meta( $post_id, 'starttime', true );
			return $starttime;
		}
		static function _get_hotel_package_price( $hotel_packages ) {
			$total = 0;
			if ( ! empty( $hotel_packages ) ) {
				foreach ( $hotel_packages as $k => $v ) {
					$total += (float) ( $v->hotel_price ) * ( intval( $v->qty ) );
				}
			}
			return $total;
		}
		static function _get_flight_package_price( $flight_packages ) {
			$total = 0;
			if ( ! empty( $flight_packages ) ) {
				foreach ( $flight_packages as $k => $v ) {
					if ( $v->flight_price_type === 'economy' ) {
						$total += (float) ( $v->flight_price_economy ) * ( intval( $v->qty ) );
					} else {
						$total += (float) ( $v->flight_price_business ) * ( intval( $v->qty ) );
					}
				}
			}
			return $total;
		}
		static function _get_activity_package_price( $package_activities ) {
			$total = 0;
			if ( ! empty( $package_activities ) ) {
				foreach ( $package_activities as $k => $v ) {
					$total += (float) ( $v->activity_price ) * ( intval( $v->qty ) );
				}
			}
			return $total;
		}
		static function _get_car_package_price( $package_cars ) {
			$total = 0;
			if ( ! empty( $package_cars ) ) {
				foreach ( $package_cars as $k => $v ) {
					$total += (float) ( $v->car_price ) * ( intval( $v->car_quantity ) );
				}
			}
			return $total;
		}
		static function _convert_data_car_package( $car_name_packages, $car_price_packages, $car_quantity_packages ) {
			$get_ids     = [];
			$car_package = [];
			if ( ! empty( $car_name_packages ) ) {
				foreach ( $car_quantity_packages as $k => $v ) {
					if ( $v > 0 ) {
						array_push( $get_ids, $k );
					}
				}
				if ( ! empty( $get_ids ) ) {
					foreach ( $get_ids as $k => $v ) {
						$data               = new stdClass();
						$data->car_name     = $car_name_packages[ $v ];
						$data->car_price    = $car_price_packages[ $v ];
						$data->car_quantity = $car_quantity_packages[ $v ];
						array_push( $car_package, $data );
					}
				}
			}
			return $car_package;
		}
		static function _check_empty_package( $package, $custom_package ) {
			$check = false;
			if ( is_object( $package ) ) {
				if ( ! empty( (array) $package ) ) {
					$check = true;
				}
			}
			if ( is_object( $custom_package ) ) {
				if ( ! empty( (array) $custom_package ) ) {
					$check = true;
				}
			}
			return $check;
		}
		static function get_instance() {
			if ( ! self::$_inst ) {
				self::$_inst = new self();
			}
			return self::$_inst;
		}
		static function get_price_type( $id = null ) {
			if ( empty( $id ) ) {
				$id = get_the_ID();
			}
			$price_type = get_post_meta( $id, 'tour_price_by', true );
			if ( empty( $price_type ) ) {
				$price_type = 'person';
			}
			return $price_type;
		}
		public function checkHasTourPackage( $hotel_package, $hotel_package_custom, $activity_package, $activity_package_custom, $car_package, $car_package_custom, $flight_package, $flight_package_custom ) {
			if ( st_check_service_available( 'st_hotel' ) && ! empty( $hotel_package ) && ( is_object( $hotel_package ) && ! empty( (array) $hotel_package ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_hotel' ) && ! empty( $hotel_package_custom ) && ( is_object( $hotel_package_custom ) && ! empty( (array) $hotel_package_custom ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_activity' ) && ! empty( $activity_package ) && ( is_object( $activity_package ) && ! empty( (array) $activity_package ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_activity' ) && ! empty( $activity_package_custom ) && ( is_object( $activity_package_custom ) && ! empty( (array) $activity_package_custom ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_cars' ) && ! empty( $car_package ) && ( is_object( $car_package ) && ! empty( (array) $car_package ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_cars' ) && ! empty( $car_package_custom ) && ( is_object( $car_package_custom ) && ! empty( (array) $car_package_custom ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_flight' ) && ! empty( $flight_package ) && ( is_object( $flight_package ) && ! empty( (array) $flight_package ) ) ) {
				return true;
			}
			if ( st_check_service_available( 'st_flight' ) && ! empty( $flight_package_custom ) && ( is_object( $flight_package_custom ) && ! empty( (array) $flight_package_custom ) ) ) {
				return true;
			}
			return false;
		}
		/*
		 * @return json
		 * hook tours_add_to_cart
		 */
		function ajax_tours_add_to_cart() {
			if ( STInput::request( 'action' ) == 'tours_add_to_cart' ) {
				$response             = [];
				$response['status']   = 0;
				$response['message']  = '';
				$response['redirect'] = '';
				if ( $this->do_add_to_cart() ) {
					$link                 = STCart::get_cart_link();
					$response['redirect'] = $link;
					$response['status']   = 1;
					echo json_encode( $response );
					wp_die();
				} else {
					$message             = STTemplate::message();
					$response['message'] = $message;
					echo json_encode( $response );
					wp_die();
				}
			}
		}
	}
	st()->tour = STTour::get_instance();
	st()->tour->init();
}

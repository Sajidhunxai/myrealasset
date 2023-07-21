<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 2/25/2019
 * Time: 2:06 PM
 */
class ST_Single_Hotel extends TravelerObject {
	static $_inst;
	public function __construct() {
		add_action( 'wp_ajax_sts_filter_room_ajax', [ $this, '__singleRoomFilterAjax' ] );
		add_action( 'wp_ajax_nopriv_sts_filter_room_ajax', [ $this, '__singleRoomFilterAjax' ] );
		// Load instagram ajax
		add_action( 'wp_ajax_load_instagram', [ $this, 'st_load_instagram_images' ] );
		add_action( 'wp_ajax_nopriv_load_instagram', [ $this, 'st_load_instagram_images' ] );
		add_filter( 'body_class', [ $this, 'custom_class_date_calendar' ] );
	}
	function custom_class_date_calendar( $classes ) {
		if ( is_singular( 'hotel_room' ) ) {
			$id_room             = get_the_ID();
			$hotel_id            = get_post_meta( get_the_ID(), 'room_parent', true );
			$allow_full_day_room = get_post_meta( get_the_ID(), 'allow_full_day', true );
			$allow_full_day      = get_post_meta( $hotel_id, 'allow_full_day', true );
			if ( $allow_full_day_room !== 'on' && $allow_full_day !== 'on' ) {
				$classes[] = 'st-no-fullday-booking';
			}
		}
		return $classes;
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
	public function getMaxPeopleSearchForm( $key = false ) {
		$res = 20;
		switch ( $key ) {
			case 'adult':
				$res = st()->get_option( 'st_hotel_alone_max_adult', 20 );
				if ( empty( $res ) || ! is_numeric( $res ) ) {
					$res = 20;
				}
				break;
			case 'child':
				$res = st()->get_option( 'st_hotel_alone_max_child', 20 );
				if ( empty( $res ) || ! is_numeric( $res ) ) {
					$res = 20;
				}
				break;
			default:
				$res = st()->get_option( 'st_hotel_alone_max_adult', 20 );
				if ( empty( $res ) || ! is_numeric( $res ) ) {
					$res = 20;
				}
				break;
		}
		return $res;
	}
	public function __singleRoomFilterAjax() {
		$this->checkSecurity();
		set_query_var( 'paged', STInput::get( 'page', 1 ) );
		$layout_val = STInput::get( 'layout', 'list' );

		if ( ! empty( $_GET['version'] ) && ( $_GET['version'] == 'elementorv2' ) ) {
			$res = st()->load_template( 'layouts/elementor/common/loader', 'content' );
		} else {
			$res = '<div class="st-loader"></div>';
		}
		$this->setQueryRoomSearch();
		if ( have_posts() ) {
			if ( $layout_val == 'grid' ) {
				$res .= '<div class="row">';
			} elseif ( ! empty( $_GET['version'] ) && ( $_GET['version'] == 'elementorv2' ) && ( in_array( 'traveler-layout-essential-for-elementor/traveler-layout-essential-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) {
					$res .= '<div class="row service-list-wrapper list-style">';
			}

			while ( have_posts() ) {
				the_post();
				if ( ! empty( $_GET['version'] ) && ( $_GET['version'] == 'elementorv2' ) && ( in_array( 'traveler-layout-essential-for-elementor/traveler-layout-essential-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) {
					$res .= '<div class="col-12">';
					$res .= apply_filters( 'ste_load_template', ste_loadTemplate( 'list-service-room/room/loop/list' ) );
					$res .= '</div>';
				} else {
					$res .= st()->load_template( 'layouts/modern/single_hotel/elements/loop/' . $layout_val );
				}
			}
			if ( $layout_val == 'grid' ) {
				$res .= '</div>';
			} elseif ( ! empty( $_GET['version'] ) && ( $_GET['version'] == 'elementorv2' ) && ( in_array( 'traveler-layout-essential-for-elementor/traveler-layout-essential-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) {
					$res .= '</div>';
			}

			if ( ! empty( $_GET['version'] ) && ( $_GET['version'] == 'elementorv2' ) && ( in_array( 'traveler-layout-essential-for-elementor/traveler-layout-essential-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) {
				$st_order = $st_orderby = '';
				if ( ! empty( $_GET['st_order'] ) ) {
					$st_order = $_GET['st_order'];
				}
				if ( ! empty( $_GET['st_orderby'] ) ) {
					$st_orderby = $_GET['st_orderby'];
				}
				$res .= '<div class="panigation-list-new-style pagination moderm-pagination" data-action_service="sts_filter_room_ajax" data-order="' . esc_attr( $order ) . '" data-orderby="' . esc_attr( $orderby ) . '">';
				$res .= st()->load_template( 'layouts/modern/single_hotel/elements/pag', '', [] );
				$res .= '</div>';
			} else {
				$res .= st()->load_template( 'layouts/modern/single_hotel/elements/pag' );
			}
		} else {
			$res .= st()->load_template( 'layouts/modern/single_hotel/elements/loop/none' );
		}
		wp_reset_postdata();
		wp_reset_query();
		echo json_encode([
			'status'  => true,
			'content' => $res,
		]);
		die;
	}
	public function setQueryRoomSearch() {
		global $wp_query, $st_search_query;
		if ( TravelHelper::is_wpml() ) {
			$current_lang = TravelHelper::current_lang();
			$main_lang    = TravelHelper::primary_lang();
			global $sitepress;
			$sitepress->switch_lang( $current_lang, true );
		}
		$this->startInjectQuery();
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : '1';
		$args  = [
			'post_type'   => 'hotel_room',
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
		$this->endInjectQuery();
	}
	public function startInjectQuery() {
		add_action( 'pre_get_posts', [ $this, '__changeSearchRoomArgs' ] );
		add_filter( 'posts_where', [ $this, '__changeWhereQuery' ] );
		add_action( 'posts_fields', [ $this, '__changePostField' ] );
		add_filter( 'posts_join', [ $this, '__changeJoinQuery' ] );
		add_filter( 'posts_groupby', [ $this, '__changeGroupBy' ] );
	}
	public function endInjectQuery() {
		remove_action( 'pre_get_posts', [ $this, '__changeSearchRoomArgs' ] );
		remove_filter( 'posts_where', [ $this, '__changeWhereQuery' ] );
		remove_action( 'posts_fields', [ $this, '__changePostField' ] );
		remove_filter( 'posts_join', [ $this, '__changeJoinQuery' ] );
		remove_filter( 'posts_groupby', [ $this, '__changeGroupBy' ] );
	}
	public function __changeGroupBy( $groupby ) {
		global $wpdb;
		if ( ! $groupby or strpos( $wpdb->posts . '.ID', $groupby ) === false ) {
			$groupby .= $wpdb->posts . '.ID ';
		}
		return $groupby;
	}
	public function __changeSearchRoomArgs( $query ) {
		$post_type = get_query_var( 'post_type' );
		if ( $post_type == 'hotel_room' ) {
			$query->set( 'author', '' );

			$posts_per_page = st()->get_option( 'st_hotel_alone_room_search_page_number' );
			if ( empty( $posts_per_page ) || ! is_numeric( $posts_per_page ) ) {
				$posts_per_page = get_option( 'posts_per_page' );
			} else {
				$posts_per_page = (int) $posts_per_page;
			}
			$query->set( 'posts_per_page', $posts_per_page );

			$term_id           = STInput::get( 'term_id', '' );
			$taxonomy_filtered = st()->get_option( 'st_hotel_alone_tax_in_room_page' );
			if ( ! empty( $taxonomy_filtered ) ) {
				if ( $term_id != 'all' ) {
					if ( ! empty( $term_id ) ) {
						$tax_query[] = [
							[
								'taxonomy' => $taxonomy_filtered,
								'field'    => 'id',
								'terms'    => $term_id,
							],
						];
						$query->set( 'tax_query', $tax_query );
					}
				}
			}

			$meta_query = [
				'relation' => 'AND',
				[
					'key'     => 'adult_number',
					'value'   => STInput::get( 'adult_number', 0 ),
					'compare' => '>=',
				],
				[
					'key'     => 'children_number',
					'value'   => STInput::get( 'child_number', 0 ),
					'compare' => '>=',
				],
			];
			$query->set( 'meta_query', $meta_query );
		}
	}
	public function __changeWhereQuery( $where ) {
		global $wpdb;
		$whereNumber = '';
		$check_in    = STInput::get( 'check_in' );
		$check_out   = STInput::get( 'check_out' );

		$hotel_parent = st()->get_option( 'hotel_alone_assign_hotel' );
		if ( ! empty( $hotel_parent ) ) {
			$sql = $wpdb->prepare( ' AND parent_id = %d ', $hotel_parent );
		}

		$adult_number = STInput::get( 'adult_number', 0 );
		if ( intval( $adult_number ) < 0 ) {
			$adult_number = 0;
		}
		$child_number = STInput::get( 'child_number', 0 );
		$where       .= " AND tb.status = 'available'";
		if ( intval( $child_number ) < 0 ) {
			$child_number = 0;
		}
		if ( ! empty( $check_in ) && ! empty( $check_out ) ) {
			$checkin_ymd  = date( 'Y-m-d', strtotime( TravelHelper::convertDateFormat( STInput::request( 'check_in' ) ) ) );
			$checkout_ymd = date( 'Y-m-d', strtotime( TravelHelper::convertDateFormat( STInput::request( 'check_out' ) ) ) );
			$check_in     = strtotime( TravelHelper::convertDateFormat( $check_in ) );
			$check_out    = strtotime( TravelHelper::convertDateFormat( $check_out ) );
		} else {
			$checkin_ymd  = date( 'Y-m-d' ,strtotime( 'now' ) );
			$checkout_ymd = date( 'Y-m-d', strtotime( '+ 1 day' ) );
			$check_in     = strtotime( 'now' );
			$check_out    = strtotime( '+ 1 day' );
		}

		$room_full_ordereds = HotelHelper::_get_full_ordered_new( $hotel_parent, $check_in, $check_out, true );
		// find hotel unavailability with date check in and date checkout
		$st_room                       = new STRoom();
		$get_unavailability_room_check = $st_room->get_unavailability_room( $checkin_ymd, $checkout_ymd, intval( $adult_number ), intval( $child_number ), $number_room = 1 );

		$list = [];
		if ( ! empty( $room_full_ordereds ) ) {
			foreach ( $room_full_ordereds as $item ) {

				if ( ! empty( $item['room_origin'] ) && ! HotelHelper::_check_room_only_available(
					$item['room_origin'], $checkin_ymd,
					$checkout_ymd,
				1) ) {
					$list[] = $item['room_origin'];
				} else {

				}
			}
		}

		$list = array_unique( $list );

		$list_new = '';
		if ( ! is_array( $list ) || count( $list ) <= 0 ) {

			$list     = $get_unavailability_room_check;
			$list_new = implode( ',', $list );
		} else {

			if ( ! empty( $get_unavailability_room_check ) ) {
				$list = array_push( $list, $get_unavailability_room_check );
			}
			$list_new = implode( ',', $list );

		}
		if ( ! empty( $list_new ) ) {
			$where .= " AND {$wpdb->prefix}posts.ID NOT IN ({$list_new}) ";
		}
		$where .= ' AND tb.number > 0';
		$where .= " AND tb.check_in >= {$check_in} && tb.check_in <= {$check_out}";
		return $where;
	}
	public function __changeJoinQuery( $join ) {
		global $wpdb;
		$table  = $wpdb->prefix . 'st_room_availability';
		$table2 = $wpdb->prefix . 'hotel_room';
		$join  .= " INNER JOIN {$table} as tb ON {$wpdb->prefix}posts.ID = tb.post_id";
		return $join;
	}
	public function __changePostField( $fields ) {
		$fields .= ', SUM(CAST(CASE WHEN IFNULL(tb.adult_price, 0) = 0 THEN tb.price ELSE tb.adult_price END AS DECIMAL)) as st_price, (IFNULL(number, 0) - IFNULL(number_booked, 0)) as remaining_number';
		return $fields;
	}
	static function inst() {
		if ( ! self::$_inst ) {
			self::$_inst = new self();
		}
		return self::$_inst;
	}
}
ST_Single_Hotel::inst();

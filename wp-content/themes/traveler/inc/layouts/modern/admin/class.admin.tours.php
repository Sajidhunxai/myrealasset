<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Class STAdminTours
 *
 * Created by ShineTheme
 */
$order_id = 0;
if ( ! class_exists( 'STAdminTours' ) ) {

	class STAdminTours extends STAdmin {

		static $booking_page;
		static $_table_version = '1.3.5';
		protected $post_type   = 'st_tours';
		protected static $_inst;

		/**
		 *
		 *
		 * @update 1.1.3
		 * */
		function __construct() {
			add_action( 'init', [ $this, '_init_post_type' ], 8 );
			if ( ! st_check_service_available( $this->post_type ) ) {
				return;
			}

			add_action( 'current_screen', [ $this, 'init_metabox' ] );

			// add_action( 'save_post', array($this,'tours_update_location') );
			add_action( 'save_post', [ $this, 'tours_update_price_sale' ] );
			add_filter( 'manage_st_tours_posts_columns', [ $this, 'add_col_header' ], 10 );
			add_action( 'manage_st_tours_posts_custom_column', [ $this, 'add_col_content' ], 10, 2 );

			// ==========================================================================

			self::$booking_page = admin_url( 'edit.php?post_type=st_tours&page=st_tours_booking' );
			add_action( 'admin_menu', [ $this, 'new_menu_page' ] );

			// Check booking edit and redirect
			if ( self::is_booking_page() ) {
				add_action( 'admin_enqueue_scripts', [ __CLASS__, 'add_edit_scripts' ] );
				add_action( 'admin_init', [ $this, '_do_save_booking' ] );
			}

			if ( isset( $_GET['send_mail'] ) and $_GET['send_mail'] == 'success' ) {
				self::set_message( __( 'Email sent', 'traveler' ), 'updated' );
			}

			add_action( 'wp_ajax_st_room_select_ajax', [ __CLASS__, 'st_room_select_ajax' ] );
			add_action( 'save_post', [ $this, 'meta_update_sale_price' ], 10, 4 );
			add_action( 'save_post', [ $this, 'meta_update_min_price' ], 10, 4 );
			// parent::__construct();

			add_action( 'save_post', [ $this, '_update_list_location' ], 10, 2 );
			add_action( 'save_post', [ $this, '_update_duplicate_data' ], 50, 2 );
			add_action( 'before_delete_post', [ $this, '_delete_data' ], 50 );

			add_action( 'wp_ajax_st_getInfoTour', [ __CLASS__, '_getInfoTour' ], 9999 );

			/**
			 *   since 1.2.4
			 *   auto create & update table st_tours
			 * */
			add_action( 'after_setup_theme', [ __CLASS__, '_check_table_tour' ] );

			/**
			 * @since 1.3.0
			 *        Bulk calendar
			 * */
			add_action( 'traveler_after_form_tour_calendar', [ $this, 'custom_traveler_after_form_tour_calendar' ] );
			add_action( 'traveler_after_form_submit_tour_calendar', [ $this, 'custom_traveler_after_form_submit_tour_calendar' ] );

			add_action( 'init', [ $this, '__update_db_available_first_run' ], 99 );

			add_action( 'st_availability_cronjob', [ $this, '__cronjob_fill_availability' ] );

			add_action( 'admin_init', [ $this, '_upgradeTourTable133' ] );
			add_action( 'st_tour_type_add_form_fields', [ $this, 'st_tour_type_add_fields' ] );
			add_action( 'st_tour_type_edit_form_fields', [ $this, 'st_tour_type_edit_fields' ] );
			add_action( 'created_st_tour_type', [ $this, 'st_tour_type_save' ], 10, 1 );
			add_action( 'edited_st_tour_type', [ $this, 'st_tour_type_save' ], 10, 1 );
			add_filter( 'manage_edit-st_tour_type_columns', [ $this, 'st_tour_type_set_colums' ] );
			add_filter( 'manage_st_tour_type_custom_column', [ $this, 'st_tour_type_custom_colums' ], 10, 3 );
			add_action( 'wp_ajax_st_dashboard_change_avatar', [ $this, 'sttDashboardChangeAvatar' ] );

			add_action( 'admin_init', [ $this, '_upgradeColumnDiscountTypeTourTable' ] );
			add_action( 'admin_init', [ $this, '_upgrade_min_max_price' ] );
		}

		public function sttDashboardChangeAvatar() {
			$stAttachment = STInput::post( 'attachment_id' );
			if ( ! empty( $stAttachment ) ) {
				$url       = '';
				$thumbnail = wp_get_attachment_image_url( $stAttachment, [ 80, 80 ] );
				$url      .= '<img src="' . esc_url( $thumbnail ) . '" data-id="' . esc_attr( $stAttachment ) . '" alt="' . get_bloginfo( 'description' ) . '" />';
				echo json_encode(
					[
						'status' => 1,
						'avatar' => $stAttachment,
						'url'    => $url,
					]
				);
			}

			die();
		}

		public function st_tour_type_add_fields() {
			wp_enqueue_media();
			?>
			<div class="form-field">
				<label class="stt-submit-text" > <?php echo esc_html__( 'Attachment', 'traveler' ) ?></label>
				<div class="stt-edit-avatar">

				</div>
				<input type="hidden" name="upload_value" value="">
				<div class="stt-upload-avatar">
					<input type="button" class="button button-defautl stt-update-avatar" value="<?php echo esc_html__( 'Upload Image', 'traveler' ) ?>">

				</div>

			</div>
			<?php
		}

		public function st_tour_type_edit_fields() {
			wp_enqueue_media();
			$termID  = STInput::get( 'tag_ID' );
			$imageID = get_term_meta( $termID, 'st_tour_type_image', true );
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label class="stt-submit-text" > <?php echo esc_html__( 'Attachment', 'traveler' ) ?></label>
				</th>
				<td>
					<input type="hidden" name="upload_value" value="<?php echo esc_attr( $imageID ) ?>">
					<div class="stt-edit-avatar">
						<?php
						$imageURL = wp_get_attachment_image_url( $imageID, [ 80, 80 ] );
						if ( ! empty( $imageURL ) ) {
							?>
							<img src="<?php echo esc_url( $imageURL ); ?>" alt="<?php echo get_bloginfo( 'description' ) ?>">
						<?php } ?>
					</div>
					<div class="stt-upload-avatar">
						<input type="button" class="button button-defautl stt-update-avatar" value="<?php echo esc_html__( 'Upload Image', 'traveler' ) ?>">

					</div>
				</td>
			</tr>
			<?php
		}

		public function st_tour_type_save( $term_id ) {
			$imageCate = sanitize_text_field( STInput::post( 'upload_value' ) );
			if ( $imageCate ) {

				update_term_meta( $term_id, 'st_tour_type_image', $imageCate );
			}
		}

		public function st_tour_type_set_colums( $columns ) {
			$newColumns = [
				'image' => esc_html__( 'Image', 'traveler' ),
			];
			$columns    = array_merge( $columns, $newColumns );
			return $columns;
		}

		public function st_tour_type_custom_colums( $content, $columns, $term_id ) {
			switch ( $columns ) {
				case 'image':
					$imageID  = get_term_meta( $term_id, 'st_tour_type_image', true );
					$imageUrl = wp_get_attachment_image_url( $imageID, [ 40, 40 ] );
					$content  = '<img src="' . esc_url( $imageUrl ) . '" alt="' . get_bloginfo( 'description' ) . '">';
					break;

				default:
					// code...
					break;
			}
			return $content;
		}

		public function _upgradeTourTable133() {
			$updated = get_option( 'st_upgradeTourTable133', false );
			if ( ! $updated ) {
				global $wpdb;
				$table = $wpdb->prefix . $this->post_type;
				$sql   = "Update {$table} as t inner join {$wpdb->postmeta} as m on (t.post_id = m.post_id and m.meta_key = 'is_featured') set t.is_featured = m.meta_value";
				$wpdb->query( $sql );
				update_option( 'st_upgradeTourTable133', 'updated' );
			}
		}

		public function __run_fill_old_order( $key = '' ) {
			$ids = [];
			global $wpdb;
			$table      = $wpdb->prefix . 'st_tour_availability';
			$model      = ST_Order_Item_Model::inst();
			$orderItems = $model->where( "st_booking_post_type in ('st_tours')", false, true )
							->where( 'check_in_timestamp >= UNIX_TIMESTAMP(CURRENT_DATE)', false, true )
							->where( "STATUS NOT IN('canceled','trash')", false, true )->get()->result();

			if ( ! empty( $orderItems ) ) {
				foreach ( $orderItems as $data ) {
					if ( ! empty( $data['origin_id'] ) ) {
						if ( in_array( $data['id'], $ids ) ) {
							continue;
						}
						$ids[]  = $data['id'];
						$booked = $data['adult_number'] + $data['child_number'] + $data['infant_number'];

						$where = [
							'post_id'  => $data['origin_id'],
							'check_in' => $data['check_in_timestamp'],
						];
						$check = ST_Tour_Availability::inst()->where( $where )->get( 1 )->row();
						if ( $check ) {
							$sql = $wpdb->prepare( "UPDATE {$table} SET number_booked = IFNULL(number_booked, 0) + %d WHERE post_id = %d AND check_in = %s", $booked, $data['origin_id'], $data['check_in_timestamp'] );
							$wpdb->query( $sql );
						} else {
							for ( $i_d = $data['check_in_timestamp']; $i_d <= $data['check_out_timestamp']; $i_d = strtotime( '+1 day', $i_d ) ) {
								$data_insert = [
									'post_id'         => $data['origin_id'],
									'check_in'        => $i_d,
									'check_out'       => $i_d,
									'starttime'       => '',
									'count_starttime' => 1,
									'number'          => get_post_meta( $data['origin_id'], 'max_people', true ),
									'price'           => get_post_meta( $data['origin_id'], 'base_price', true ),
									'adult_price'     => get_post_meta( $data['origin_id'], 'adult_price', true ),
									'child_price'     => get_post_meta( $data['origin_id'], 'child_price', true ),
									'infant_price'    => get_post_meta( $data['origin_id'], 'infant_price', true ),
									'status'          => 'available',
									'groupday'        => 0,
									'number_booked'   => $booked,
									'booking_period'  => get_post_meta( $data['origin_id'], 'tours_booking_period', true ),
									'is_base'         => 0,
								];
								ST_Tour_Availability::inst()->insert( $data_insert );
							}
						}
					}
				}
			}
		}

		public function __cronjob_fill_availability( $offset = 0, $limit = 0, $day = null ) {
			global $wpdb;
			if ( ! $day ) {
				$today = new DateTime( date( 'Y-m-d' ) );
				$today->modify( '+ 6 months' );
				$day = $today->modify( '+ 1 day' );
			}
			$table     = 'st_tour_availability';
			$post_type = 'st_tours';

			$tours       = new WP_Query([
				'posts_per_page' => $limit,
				'post_type'      => $post_type,
				'meta_key'       => 'type_tour',
				'meta_value'     => 'daily_tour',
				'offset'         => $offset,
			]);
			$insertBatch = [];
			$ids         = [];
			while ( $tours->have_posts() ) {
				$tours->the_post();
				$adult_price = get_post_meta( get_the_ID(), 'adult_price', true );
				if ( empty( $adult_price ) ) {
					$adult_price = 0;
				}
				$child_price = get_post_meta( get_the_ID(), 'child_price', true );
				if ( empty( $child_price ) ) {
					$child_price = 0;
				}
				$infant_price = get_post_meta( get_the_ID(), 'infant_price', true );
				if ( empty( $infant_price ) ) {
					$infant_price = 0;
				}
				$base_price = get_post_meta( get_the_ID(), 'base_price', true );
				if ( empty( $base_price ) ) {
					$base_price = 0;
				}
				$max_people = get_post_meta( get_the_ID(), 'max_people', true );
				if ( empty( $max_people ) ) {
					$max_people = 0;
				}
				$booking_period = get_post_meta( get_the_ID(), 'tours_booking_period', true );
				if ( empty( $booking_period ) ) {
					$booking_period = 0;
				}
				$status        = 'available';
				$insertBatch[] = $wpdb->prepare( '(%d,%d,%d,%s,%s,%s,%s,%s,%d,%d,%s,%d)', $day->getTimestamp(), $day->getTimestamp(), get_the_ID(), $status, $base_price, $adult_price, $child_price, $infant_price, 1, 0, $max_people, $booking_period );

				$ids[] = get_the_ID();
			}
			if ( ! empty( $insertBatch ) ) {
				$wpdb->query( "INSERT IGNORE INTO {$wpdb->prefix}{$table} (check_in,check_out,post_id,`status`,price,adult_price,child_price,infant_price,is_base,groupday,`number`,booking_period) VALUES " . implode( ",\r\n", $insertBatch ) );
			}

			wp_reset_postdata();
		}

		public function __update_db_available_first_run() {
			// Fill old data
			$key = 'st_tour_availability_fill_old_data';
			if ( empty( get_option( $key ) ) ) {
				$model_avail = ST_Availability_Model::inst()
								->where( 'post_type', 'st_tours' )
								->where( 'check_in >= UNIX_TIMESTAMP(CURRENT_DATE)', false, true )->get()->result();
				if ( ! empty( $model_avail ) ) {
					global $wpdb;
					$table       = $wpdb->prefix . 'st_tour_availability';
					$insertBatch = [];
					$ids         = [];
					$i           = 1;
					foreach ( $model_avail as $k => $v ) {
						$max_people = get_post_meta( $v['post_id'], 'max_people', true );
						if ( empty( $max_people ) ) {
							$max_people = 0;
						}
						$booking_period = get_post_meta( $v['post_id'], 'tours_booking_period', true );
						if ( empty( $booking_period ) ) {
							$booking_period = 0;
						}
						$insertBatch[] = $wpdb->prepare( '(%d,%s,%s,%s,%d,%d,%s,%s,%s,%s,%s,%d,%d,%d,%d)', $v['post_id'], $v['check_in'], $v['check_out'], $v['starttime'], $v['count_starttime'], $max_people, $v['price'], $v['adult_price'], $v['child_price'], $v['infant_price'], $v['status'], $v['groupday'], 0, $booking_period, 1 );
						++$i;
						$ids[] = $v['id'];
					}
					if ( ! empty( $insertBatch ) ) {
						$res = $wpdb->query( "INSERT IGNORE INTO {$table} (post_id, check_in, check_out, starttime, count_starttime, `number`, price, adult_price, child_price, infant_price, `status`, groupday, number_booked, booking_period, is_base) VALUES " . implode( ",\r\n", $insertBatch ) );
						if ( $res ) {
							$sql_delete = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}st_availability WHERE post_type=%s", 'st_tours' );
							$wpdb->query( $sql_delete );
						}
					}
				}
				update_option( $key, 1 );
			}

			// Fill old starttime data
			$key_st = 'st_tour_availability_fill_old_starttime_data';
			if ( empty( get_option( $key_st ) ) ) {
				$model_st_avail = ST_Availability_Model::inst()
								->where( 'post_type', 'st_starttime_tours' )
								->where( 'check_in >= UNIX_TIMESTAMP(CURRENT_DATE)', false, true )
								->get()->result();
				if ( ! empty( $model_st_avail ) ) {
					global $wpdb;
					foreach ( $model_st_avail as $k => $v ) {
						$starttime_arr = explode( $v['starttime'] );
						ST_Tour_Availability::inst()
								->where( 'post_id', $v['post_id'] )
								->where( 'check_in', $v['check_in'] )
								->update([
									'starttime'       => $v['starttime'],
									'count_starttime' => count( $starttime_arr ),
								]);
						$sql_delete = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}st_availability WHERE post_type=%s", 'st_starttime_tours' );
						$wpdb->query( $sql_delete );
					}
				}

				update_option( $key_st, 1 );
			}
		}

		public function custom_traveler_after_form_tour_calendar() {
			echo balanceTags( st()->load_template( 'tours/tour-calendar', false ) );
		}

		public function custom_traveler_after_form_submit_tour_calendar() {
			echo '<button type="button" id="calendar-bulk-edit" class="option-tree-ui-button option-tree-ui-button traveler_after_form_submit_tour_calendar button button-primary button-large btn btn-primary btn-sm" style="float: right;">' . __( 'Bulk Edit', 'traveler' ) . '</button>';
		}

		static function check_ver_working() {
			$dbhelper = new DatabaseHelper( self::$_table_version );

			return $dbhelper->check_ver_working( 'st_tours_table_version' );
		}

		static function _check_table_tour() {
			$dbhelper = new DatabaseHelper( self::$_table_version );
			$dbhelper->setTableName( 'st_tours' );
			$column = [
				'post_id'              => [
					'type'   => 'INT',
					'length' => 11,
				],
				'multi_location'       => [
					'type' => 'text',
				],
				'id_location'          => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'address'              => [
					'type' => 'text',
				],
				'price'                => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'sale_price'           => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'child_price'          => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'adult_price'          => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'infant_price'         => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'min_price'            => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'max_people'           => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'type_tour'            => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'check_in'             => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'check_out'            => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'rate_review'          => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'duration_day'         => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'tours_booking_period' => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'is_sale_schedule'     => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'discount'             => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'sale_price_from'      => [
					'type'   => 'date',
					'length' => 255,
				],
				'sale_price_to'        => [
					'type'   => 'date',
					'length' => 255,
				],
				'price_type'           => [
					'type'   => 'varchar',
					'length' => 255,
				],
				'is_featured'          => [
					'type'   => 'varchar',
					'length' => 5,
				],
				'discount_type'        => [
					'type'   => 'varchar',
					'length' => 10,
				],
			];

			$column = apply_filters( 'st_change_column_st_tours', $column );

			$dbhelper->setDefaultColums( $column );
			$dbhelper->check_meta_table_is_working( 'st_tours_table_version' );

			return array_keys( $column );
		}

		static function _getInfoTour() {
			$tour_id  = intval( STInput::request( 'tour_id', '' ) );
			$result   = [
				'type_tour'    => '',
				'max_people'   => 20,
				'adult_html'   => '',
				'child_html'   => '',
				'infant_html'  => '',
				'child_price'  => '',
				'adult_price'  => '',
				'infant_price' => '',
			];
			$duration = 0;
			if ( get_post_type( $tour_id ) == 'st_tours' ) {
				$html_extra             = '';
				$child_price            = get_post_meta( $tour_id, 'child_price', true );
				$adult_price            = get_post_meta( $tour_id, 'adult_price', true );
				$infant_price           = get_post_meta( $tour_id, 'infant_price', true );
				$result['child_price']  = $child_price;
				$result['adult_price']  = $adult_price;
				$result['infant_price'] = $infant_price;

				$type_tour           = get_post_meta( $tour_id, 'type_tour', true );
				$extra_price         = get_post_meta( $tour_id, 'extra_price', true );
				$content_extra_price = st()->load_template( 'user/extra/tour', 'extra', [
					'tour_id'     => $tour_id,
					'extra_price' => $extra_price,
				] );
				$max_people          = intval( get_post_meta( $tour_id, 'max_people', true ) );
				if ($max_people < 1){
					$max_people = 20;
				}
				$adult_html  = '<select name="adult_number" class="form-control" style="width: 100%">';
				$child_html  = '<select name="child_number" class="form-control" style="width: 100%">';
				$infant_html = '<select name="infant_number" class="form-control" style="width: 100%">';
				for ( $i = 0; $i <= $max_people; $i++ ) {
					$adult_html  .= '<option value="' . $i . '">' . $i . '</option>';
					$child_html  .= '<option value="' . $i . '">' . $i . '</option>';
					$infant_html .= '<option value="' . $i . '">' . $i . '</option>';
				}
				$adult_html .= '</select>';
				$child_html .= '</select>';
				$child_html .= '</select>';

				if ( $type_tour && $type_tour == 'daily_tour' ) {
					$html                      = "<select name='type_tour' class='form-control form-control-admin'>
                        <option value='daily_tour'>" . __( 'Daily Tour', 'traveler' ) . '</option>
                    </select>';
					$result['type_tour']       = $html;
					$result['tour_text']       = $type_tour;
					$result['label_type_tour'] = __( 'Daily Tour', 'traveler' );
					$duration                  = get_post_meta( $tour_id, 'duration_day', true );
				} elseif ( $type_tour && $type_tour == 'specific_date' ) {
					$html                          = "<select name='type_tour' class='form-control form-control-admin'>
                        <option value='specific_date'>" . __( 'Specific Date', 'traveler' ) . '</option>
                    </select>';
					$result['type_tour']           = $html;
					$result['tour_text']           = $type_tour;
					$result['label_type_tour']     = __( 'Specific Date', 'traveler' );
					$result['content_extra_price'] = $content_extra_price;
				}
				$extras = get_post_meta( $tour_id, 'extra_price', true );
				if ( is_array( $extras ) && count( $extras ) ) :
					$html_extra = '<table class="table">';
					foreach ( $extras as $key => $val ) :
						$html_extra .= '
                    <tr>
                        <td width="80%">
                            <label for="' . $val['extra_name'] . '" class="ml20">' . $val['title'] . ' (' . TravelHelper::format_money( $val['extra_price'] ) . ')' . '</label>
                            <input type="hidden" name="extra_price[price][' . $val['extra_name'] . ']" value="' . $val['extra_price'] . '">
                            <input type="hidden" name="extra_price[title][' . $val['extra_name'] . ']" value="' . $val['title'] . '">
                        </td>
                        <td width="20%">
                            <select style="width: 100px" class="form-control" name="extra_price[value][' . $val['extra_name'] . ']" id="">';

						$max_item = intval( $val['extra_max_number'] );
						if ( $max_item <= 0 ) {
							$max_item = 1;
						}
						for ( $i = 0; $i <= $max_item; $i++ ) :
							$html_extra .= '<option value="' . $i . '">' . $i . '</option>';
						endfor;
						$html_extra .= '
                            </select>
                        </td>
                    </tr>';
					endforeach;
					$html_extra .= '</table>';
				endif;
				$disable_adult_name    = get_post_meta( $tour_id, 'disable_adult_name', true );
				$disable_children_name = get_post_meta( $tour_id, 'disable_children_name', true );
				$disable_infant_name   = get_post_meta( $tour_id, 'disable_infant_name', true );

				if ( $disable_adult_name == 'off' || $disable_children_name == 'off' || $disable_infant_name == 'off' ) {
					$html_required_name .= '
                    <div class="guest_name_input d-none"
                        data-placeholder="' . esc_html__( 'Guest %d name', 'traveler' ) . '"
                        data-hide-adult="' . get_post_meta( $tour_id, 'disable_adult_name', true ) . '"
                        data-hide-children="' . get_post_meta( $tour_id, 'disable_children_name', true ) . '"
                        >
                        <label><span>' . esc_html__( 'Guest Name', 'traveler' ) . '</span> <span class="required">*</span></label>
                        <div class="guest_name_control">

                        </div>
                        <script type="text/html" id="guest_name_control_item">
                            <div class="control-item mb10">
                                <select name="guest_title[]" class="form-control">
                                <option value="mr">' . esc_html__( 'Mr', 'traveler' ) . '</option>
                                <option value="miss">' . esc_html__( 'Miss', 'traveler' ) . '</option>
                                <option value="mrs">' . esc_html__( 'Mrs', 'traveler' ) . '</option>
                                </select>
                                <input class="form-control " placeholder="" name="guest_name[]" value="">
                            </div>
                        </script>
                    </div>
                    ';
				}
				$result['extras']             = $html_extra;
				$result['max_people']         = ( $max_people == 0 ) ? __( 'Unlimited', 'traveler' ) : $max_people;
				$result['adult_html']         = $adult_html;
				$result['child_html']         = $child_html;
				$result['infant_html']        = $infant_html;
				$result['duration']           = $duration;
				$result['required_name_html'] = $html_required_name;
			}

			echo json_encode( $result );
			die();
		}

		function _do_save_booking() {
			$section = isset( $_GET['section'] ) ? $_GET['section'] : false;
			switch ( $section ) {
				case 'edit_order_item':
					if ( $this->is_able_edit() ) {
						if ( isset( $_POST['submit'] ) and $_POST['submit'] ) {
							$this->_save_booking( STInput::get( 'order_item_id' ) );
						}
					}

					break;
				case 'resend_email_tours':
					$this->_resend_mail();
					break;
			}
		}

		public function _delete_data( $post_id ) {
			if ( get_post_type( $post_id ) == 'st_tours' ) {
				global $wpdb;
				$table = $wpdb->prefix . 'st_tours';
				$rs    = TravelHelper::deleteDuplicateData( $post_id, $table );
				if ( ! $rs ) {
					return false;
				}

				return true;
			}
		}

		static function _update_duplicate_data( $id, $data ) {
			if ( ! TravelHelper::checkTableDuplicate( 'st_tours' ) ) {
				return;
			}

			if ( get_post_type( $id ) == 'st_tours' ) {
				$num_rows = TravelHelper::checkIssetPost( $id, 'st_tours' );

				$location_id          = '';                                                           // location_id
				$location_str         = get_post_meta( $id, 'multi_location', true );
				$address              = get_post_meta( $id, 'address', true );                        // address
				$max_people           = get_post_meta( $id, 'max_people', true );                     // maxpeople
				$check_in             = get_post_meta( $id, 'check_in', true );                       // check in
				$check_out            = get_post_meta( $id, 'check_out', true );                      // check out
				$type_tour            = get_post_meta( $id, 'type_tour', true );                      // check out
				$duration_day         = get_post_meta( $id, 'duration_day', true );                   // duration_day
				$tours_booking_period = get_post_meta( $id, 'tours_booking_period', true );           // tours_booking_period
				$tour_price_type      = get_post_meta( $id, 'tour_price_by', true );
				$sale_price           = get_post_meta( $id, 'sale_price', true );                     // sale_price
				$base_price           = get_post_meta( $id, 'base_price', true );
				$child_price          = get_post_meta( $id, 'child_price', true );
				$adult_price          = get_post_meta( $id, 'adult_price', true );
				$infant_price         = get_post_meta( $id, 'infant_price', true );
				$off_adult            = get_post_meta( $id, 'hide_adult_in_booking_form', true );
				$off_child            = get_post_meta( $id, 'hide_children_in_booking_form', true );
				$off_infant           = get_post_meta( $id, 'hide_infant_in_booking_form', true );
				if ( $off_adult == 'on' ) {
					$adult_price = 0;
				}
				if ( $off_child == 'on' ) {
					$child_price = 0;
				}
				if ( $off_infant == 'on' ) {
					$infant_price = 0;
				}
				$min_price        = get_post_meta( $id, 'min_price', true );
				$discount         = get_post_meta( $id, 'discount', true );
				$is_sale_schedule = get_post_meta( $id, 'is_sale_schedule', true );
				$sale_from        = get_post_meta( $id, 'sale_price_from', true );
				$sale_to          = get_post_meta( $id, 'sale_price_to', true );
				$is_featured      = get_post_meta( $id, 'is_featured', true );
				$discount_type    = get_post_meta( $id, 'discount_type', true );
				if ( $is_sale_schedule == 'on' ) {
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
					$sale_price = floatval( $sale_price );
					if ( $discount_type == 'amount' ) {
						$sale_price = $sale_price - floatval( $discount );
					} else {
						$sale_price = $sale_price - ( $sale_price / 100 ) * floatval( $discount );
					}
				}

				$rate_review = STReview::get_avg_rate( $id ); // rate review

				if ( $num_rows == 1 ) {
					$data  = [
						'multi_location'       => $location_str,
						'id_location'          => $location_id,
						'address'              => $address,
						'type_tour'            => $type_tour,
						'check_in'             => $check_in,
						'check_out'            => $check_out,
						'sale_price'           => $sale_price,
						'child_price'          => $child_price,
						'adult_price'          => $adult_price,
						'infant_price'         => $infant_price,
						'min_price'            => $min_price,
						'max_people'           => $max_people,
						'rate_review'          => $rate_review,
						'duration_day'         => $duration_day,
						'tours_booking_period' => $tours_booking_period,
						'discount'             => $discount,
						'sale_price_from'      => $sale_from,
						'sale_price_to'        => $sale_to,
						'is_sale_schedule'     => $is_sale_schedule,
						'price'                => $base_price,
						'price_type'           => $tour_price_type,
						'is_featured'          => $is_featured,
						'discount_type'        => $discount_type,
					];
					$where = [
						'post_id' => $id,
					];

					TravelHelper::updateDuplicate( 'st_tours', $data, $where );
				} elseif ( $num_rows == 0 ) {
					$data = [
						'post_id'              => $id,
						'multi_location'       => $location_str,
						'id_location'          => $location_id,
						'address'              => $address,
						'type_tour'            => $type_tour,
						'check_in'             => $check_in,
						'check_out'            => $check_out,
						'sale_price'           => $sale_price,
						'child_price'          => $child_price,
						'adult_price'          => $adult_price,
						'infant_price'         => $infant_price,
						'min_price'            => $min_price,
						'max_people'           => $max_people,
						'rate_review'          => $rate_review,
						'duration_day'         => $duration_day,
						'tours_booking_period' => $tours_booking_period,
						'discount'             => $discount,
						'sale_price_from'      => $sale_from,
						'sale_price_to'        => $sale_to,
						'is_sale_schedule'     => $is_sale_schedule,
						'price'                => $base_price,
						'price_type'           => $tour_price_type,
						'is_featured'          => $is_featured,
						'discount_type'        => $discount_type,
					];

					TravelHelper::insertDuplicate( 'st_tours', $data );
				}

				// Update Availability
				$model = ST_Tour_Availability::inst();
				$model->where( 'post_id', $id )
						->where( 'check_in', 'UNIX_TIMESTAMP(CURRENT_DATE)', '>=' )
						->update([
							'number'         => empty( $max_people ) ? 0 : $max_people,
							'booking_period' => empty( $tours_booking_period ) ? 0 : $tours_booking_period,
						]);

				$data_prices = $model->get_prices_by_id( $id );
				if ( ! empty( $data_prices ) ) {
					$data_price = $data_prices[0];
					if ( $tour_price_type == 'person' ) {
						$adult_price_db  = $data_price['adult_price'];
						$child_price_db  = $data_price['child_price'];
						$infant_price_db = $data_price['infant_price'];
						if ( $adult_price_db != $adult_price or $child_price_db != $child_price or $infant_price_db != $infant_price ) {
							$model->where( [
								'post_id' => $id,
								'is_base' => 1,
							] )
									->where( 'check_in', 'UNIX_TIMESTAMP(CURRENT_DATE)', '>=' )
									->update([
										'adult_price'  => $adult_price,
										'child_price'  => $child_price,
										'infant_price' => $infant_price,
									]);
						}
					} else {
						$base_price_db = $data_price['price'];
						if ( $base_price_db != $base_price ) {
							$model->where( [
								'post_id' => $id,
								'is_base' => 1,
							] )
								->where( 'check_in', 'UNIX_TIMESTAMP(CURRENT_DATE)', '>=' )
									->update([
										'price' => $base_price,
									]);
						}
					}
				}
			}
		}

		/**
		 * @since 1.1.7
		 * */
		function _update_list_location( $id, $data ) {
			$location = STInput::request( 'multi_location', '' );
			if ( isset( $_REQUEST['multi_location'] ) ) {
				if ( is_array( $location ) && count( $location ) ) {
					$location_str = '';
					foreach ( $location as $item ) {
						if ( empty( $location_str ) ) {
							$location_str .= $item;
						} else {
							$location_str .= ',' . $item;
						}
					}
				} else {
					$location_str = '';
				}
				update_post_meta( $id, 'multi_location', $location_str );
				update_post_meta( $id, 'id_location', '' );
			}
		}

		/**
		 * Init the post type
		 *
		 * @since 1.1.3
		 * */
		function _init_post_type() {
			if ( ! st_check_service_available( $this->post_type ) ) {
				return;
			}

			if ( ! function_exists( 'st_reg_post_type' ) ) {
				return;
			}
			// Tours ==============================================================
			$labels = [
				'name'                  => __( 'Tours', 'traveler' ),
				'singular_name'         => __( 'Tour', 'traveler' ),
				'menu_name'             => __( 'Tours', 'traveler' ),
				'name_admin_bar'        => __( 'Tour', 'traveler' ),
				'add_new'               => __( 'Add New', 'traveler' ),
				'add_new_item'          => __( 'Add New Tour', 'traveler' ),
				'new_item'              => __( 'New Tour', 'traveler' ),
				'edit_item'             => __( 'Edit Tour', 'traveler' ),
				'view_item'             => __( 'View Tour', 'traveler' ),
				'all_items'             => __( 'All Tour', 'traveler' ),
				'search_items'          => __( 'Search Tour', 'traveler' ),
				'parent_item_colon'     => __( 'Parent Tour:', 'traveler' ),
				'not_found'             => __( 'No Tours found.', 'traveler' ),
				'not_found_in_trash'    => __( 'No Tours found in Trash.', 'traveler' ),
				'insert_into_item'      => __( 'Insert into Tour', 'traveler' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Tour', 'traveler' ),
				'featured_image'        => __( 'Feature Image', 'traveler' ),
				'set_featured_image'    => __( 'Set featured image', 'traveler' ),
			];

			$args = [
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'query_var'          => true,
				'rewrite'            => [ 'slug' => get_option( 'tour_permalink', 'st_tour' ) ],
				'capability_type'    => 'post',
				'hierarchical'       => false,
				'supports'           => [ 'author', 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ],
				'menu_icon'          => 'dashicons-palmtree-st',
			];

			st_reg_post_type( 'st_tours', $args );

			$labels = [
				'name'                       => __( 'Tour Categories', 'traveler' ),
				'singular_name'              => __( 'Tour Categories', 'traveler' ),
				'search_items'               => __( 'Search Tour Categories', 'traveler' ),
				'popular_items'              => __( 'Popular Tour Categories', 'traveler' ),
				'all_items'                  => __( 'All Tour Categories', 'traveler' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Tour Categories', 'traveler' ),
				'update_item'                => __( 'Update Tour Categories', 'traveler' ),
				'add_new_item'               => __( 'Add New Tour Categories', 'traveler' ),
				'new_item_name'              => __( 'New Tour Type Name', 'traveler' ),
				'separate_items_with_commas' => __( 'Separate Tour Categories with commas', 'traveler' ),
				'add_or_remove_items'        => __( 'Add or remove Tour Categories', 'traveler' ),
				'choose_from_most_used'      => __( 'Choose from the most used Tour Categories', 'traveler' ),
				'not_found'                  => __( 'No Tour Categories.', 'traveler' ),
				'menu_name'                  => __( 'Tour Categories', 'traveler' ),
			];
			$args   = [
				'hierarchical'      => true,
				'labels'            => $labels,
				'public'            => apply_filters( 'stt_show_term_frontend', false ),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => [ 'slug' => 'st_tour_type' ],
			];

			st_reg_taxonomy( 'st_tour_type', 'st_tours', $args );
		}

		/**
		 *
		 *
		 * @since  1.1.1
		 * @update 1.1.2
		 * */
		function init_metabox() {
			$screen = get_current_screen();
			if ( $screen->id != 'st_tours' ) {
				return false;
			}
			$value_tours_booking_period = apply_filters( 'tours_booking_period', 30 );
			$array_elementor            = [];
			$layout_single              = [
				[
					'value' => '1',
					'label' => esc_html__( 'Layout 1', 'traveler' ),
					'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_1.png',
				],
				[
					'value' => '2',
					'label' => esc_html__( 'Layout 2', 'traveler' ),
					'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_2.png',
				],
				[
					'value' => '3',
					'label' => esc_html__( 'Layout 3', 'traveler' ),
					'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_3.jpg',
				],

			];
			if ( ! check_using_elementor() ) {
				$array_modern  = [

					[
						'value' => '4',
						'label' => esc_html__( 'Layout 4', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_4.png',
					],
					[
						'value' => '5',
						'label' => esc_html__( 'Layout 5', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_5.png',
					],
					[
						'value' => '6',
						'label' => esc_html__( 'Layout 6', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_6.png',
					],
					[
						'value' => '7',
						'label' => esc_html__( 'Layout 7', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_7.png',
					],
				];
				$layout_single = array_merge( $layout_single, $array_modern );
			}
			if ( check_using_elementor() ) {
				$array_elementor = [
					[
						'value' => '8',
						'label' => esc_html__( 'Layout modern 1', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_8.jpg',
					],
					[
						'value' => '9',
						'label' => esc_html__( 'Layout modern 2', 'traveler' ),
						'src'   => get_template_directory_uri() . '/v2/images/layouts/tour_detail_layout_9.jpg',
					],
				];
				$layout_single   = array_merge( $layout_single, $array_elementor );
			}
			$layout_single = apply_filters( 'st_layout_single_tour', $layout_single );
			// Room
			$this->metabox[] = [
				'id'       => 'tour_metabox',
				'title'    => __( 'Tour Setting', 'traveler' ),
				'desc'     => '',
				'pages'    => [ 'st_tours' ],
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => [
					[
						'label' => __( 'Location', 'traveler' ),
						'id'    => 'location_reneral_tab',
						'type'  => 'tab',
					],
					[
						'label'     => __( 'Tour location', 'traveler' ),
						'id'        => 'multi_location', // id_location
						'type'      => 'list_item_post_type',
						'desc'      => __( 'Select one or more location for your tour', 'traveler' ),
						'post_type' => 'location',
					],
					[
						'label' => __( 'Real tour address ', 'traveler' ),
						'id'    => 'address',
						'type'  => 'address_autocomplete',
						'desc'  => __( 'Input your tour address detail', 'traveler' ),
					],
					[
						'label' => __( 'Location on map', 'traveler' ),
						'id'    => 'st_google_map',
						'type'  => 'bt_gmap',
						'std'   => 'off',
						'desc'  => __( 'Kindly input Map API in Theme Settings > Other Options . Select one location on map to see latiture and longiture', 'traveler' ),
					],
					[
						'label'    => __( 'Properties near by', 'traveler' ),
						'id'       => 'properties_near_by',
						'type'     => 'list-item',
						'desc'     => __( 'Properties near by this tour', 'traveler' ),
						'settings' => [
							[
								'id'    => 'featured_image',
								'label' => __( 'Featured Image', 'traveler' ),
								'type'  => 'upload',
							],
							[
								'id'    => 'description',
								'label' => __( 'Description', 'traveler' ),
								'type'  => 'textarea',
								'row'   => 5,
							],
							[
								'id'    => 'icon',
								'label' => __( 'Map icon', 'traveler' ),
								'type'  => 'upload',
							],
							[
								'id'    => 'map_lat',
								'label' => __( 'Map lat', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'map_lng',
								'label' => __( 'Map long', 'traveler' ),
								'type'  => 'text',
							],
						],
					],
					[
						'label' => __( 'Street view mode', 'traveler' ),
						'id'    => 'enable_street_views_google_map',
						'type'  => 'on-off',
						'desc'  => __( 'Turn on/off street view mode for this location', 'traveler' ),
						'std'   => 'off',
					],
					[
						'label' => __( 'Is Iframe', 'traveler' ),
						'id'    => 'is_iframe',
						'type'  => 'on-off',
						'desc'  => __( 'Turn on/off Iframe', 'traveler' ),
						'std'   => 'off',
					],
					[
						'label'     => __( 'Iframe', 'traveler' ),
						'id'        => 'map_iframe',
						'type'      => 'textarea',
						'desc'      => __( 'Enter the iframe you took on google map', 'traveler' ),
						'condition' => 'is_iframe:is(on)',
					],
					[
						'label' => __( 'General', 'traveler' ),
						'id'    => 'room_reneral_tab',
						'type'  => 'tab',
					],
					[
						'label' => __( 'Set tour as feature', 'traveler' ),
						'id'    => 'is_featured',
						'type'  => 'on-off',
						'desc'  => __( 'Will show this tour with feature label or not', 'traveler' ),
						'std'   => 'off',
					],
					/**
					 * version 2.7.4
					 */
					[
						'label'   => __( 'Booking Options', 'traveler' ),
						'id'      => 'st_booking_option_type',
						'type'    => 'select',
						'choices' => [
							[
								'label' => __( 'Instant Booking', 'traveler' ),
								'value' => 'instant',
							],
							[
								'label' => __( 'Enquire Booking', 'traveler' ),
								'value' => 'enquire',
							],
							[
								'label' => __( 'Instant & Enquire Booking', 'traveler' ),
								'value' => 'instant_enquire',
							],
						],
						'std'     => 'instant',
					],
					[
						'label'     => __( 'Tour single layout', 'traveler' ),
						'id'        => 'st_custom_layout_new',
						'post_type' => 'st_layouts',
						'desc'      => __( 'Select one tour single layout', 'traveler' ),
						'type'      => 'radio-image',
						'section'   => 'layout_tab',
						'class'     => 'custom-radio-image',
						'choices'   => $layout_single,
					],
					[
						'label' => __( 'Tour gallery', 'traveler' ),
						'id'    => 'gallery',
						'type'  => 'gallery',
						'desc'  => __( 'Upload tour images to show to customers', 'traveler' ),
					],
					[
						'label' => __( 'Tour video', 'traveler' ),
						'id'    => 'video',
						'type'  => 'text',
						'desc'  => __( 'Input youtube/vimeo url here', 'traveler' ),
					],
					[
						'label' => __( 'Contact information', 'traveler' ),
						'id'    => 'contact_info_tab',
						'type'  => 'tab',
					],
					[
						'label'   => __( 'Select contact info will show', 'traveler' ),
						'id'      => 'show_agent_contact_info',
						'type'    => 'select',
						'choices' => [
							[
								'label' => __( '----Select----', 'traveler' ),
								'value' => '',
							],
							[
								'label' => __( 'Use agent contact info', 'traveler' ),
								'value' => 'user_agent_info',
							],
							[
								'label' => __( 'Use item info', 'traveler' ),
								'value' => 'user_item_info',
							],
						],
						'desc'    => __( 'Use info configuration in theme option || Use contact info of people who upload hotel || Use contact info in hotel detail', 'traveler' ),
					],
					[
						'label' => __( 'Email address', 'traveler' ),
						'id'    => 'contact_email',
						'type'  => 'text',
						'desc'  => __( 'Email address', 'traveler' ),
					],
					[
						'label' => __( 'Website address', 'traveler' ),
						'id'    => 'website',
						'type'  => 'text',
						'desc'  => __( 'Website. Ex: <em>http://domain.com</em>', 'traveler' ),
					],
					[
						'label' => __( 'Phone', 'traveler' ),
						'id'    => 'phone',
						'type'  => 'text',
						'desc'  => __( 'Phone number', 'traveler' ),
					],
					[
						'label' => __( 'Fax number', 'traveler' ),
						'id'    => 'fax',
						'type'  => 'text',
						'desc'  => __( 'Fax number', 'traveler' ),
					],
					[
						'label' => __( 'Price settings', 'traveler' ),
						'id'    => 'price_number_tab',
						'type'  => 'tab',
					],
					// Option price by...
					[
						'label'   => __( 'Show price by person/fixed', 'traveler' ),
						'id'      => 'tour_price_by',
						'type'    => 'select',
						'choices' => [
							[
								'label' => __( 'Price by person', 'traveler' ),
								'value' => 'person',
							],
							[
								'label' => __( 'Price by fixed', 'traveler' ),
								'value' => 'fixed',
							],
						],
						'desc'    => __( 'Show price by person or fixed.', 'traveler' ),
					],
					[
						'label'     => __( 'Base price', 'traveler' ),
						'id'        => 'base_price',
						'type'      => 'text',
						'std'       => 0,
						'condition' => 'tour_price_by:is(fixed)',
					],
					[
						'label'     => __( 'Adult price', 'traveler' ),
						'id'        => 'adult_price',
						'type'      => 'text',
						'desc'      => __( 'Price per adult. Input number only. No decimal or thousand separator or any other character', 'traveler' ),
						'std'       => 0,
						'condition' => 'hide_adult_in_booking_form:is(off),tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Fields list discount by adult number booking', 'traveler' ),
						'id'        => 'discount_by_adult',
						'type'      => 'list-item',
						'desc'      => __( 'Fields list discount by adult number booking', 'traveler' ),
						'std'       => 0,
						'settings'  => [
							[
								'id'    => 'key',
								'label' => __( 'Number of adult (From)', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'key_to',
								'label' => __( 'Number of adult (To)', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'value',
								'label' => __( 'Discount', 'traveler' ),
								'desc'  => __( 'Enter amount: For example: 50', 'traveler' ),
								'type'  => 'text',
							],
						],
						'condition' => 'hide_adult_in_booking_form:is(off),tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Child price', 'traveler' ),
						'id'        => 'child_price',
						'type'      => 'text',
						'desc'      => __( 'Price per Child', 'traveler' ),
						'std'       => 0,
						'condition' => 'hide_children_in_booking_form:is(off),tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Fields list discount by child number booking', 'traveler' ),
						'id'        => 'discount_by_child',
						'type'      => 'list-item',
						'desc'      => __( 'Fields list discount by child number booking', 'traveler' ),
						'std'       => 0,
						'settings'  => [
							[
								'id'    => 'key',
								'label' => __( 'Number of children (From)', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'key_to',
								'label' => __( 'Number of children (To)', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'value',
								'label' => __( 'Discount', 'traveler' ),
								'desc'  => __( 'Enter amount: For example: 50', 'traveler' ),
								'type'  => 'text',
							],
						],
						'condition' => 'hide_children_in_booking_form:is(off),tour_price_by:not(fixed)',
					],
					[
						'id'        => 'discount_by_people_type',
						'label'     => __( 'Type of discount by people', 'traveler' ),
						'type'      => 'select',
						'choices'   => [
							[
								'label' => __( 'Percent', 'traveler' ),
								'value' => 'percent',
							],
							[
								'label' => __( 'Amount', 'traveler' ),
								'value' => 'amount',
							],
						],
						'condition' => 'tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Infant price', 'traveler' ),
						'id'        => 'infant_price',
						'type'      => 'text',
						'desc'      => __( 'Price per infant', 'traveler' ),
						'std'       => 0,
						'condition' => 'hide_infant_in_booking_form:is(off),tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Disable adult booking', 'traveler' ),
						'id'        => 'hide_adult_in_booking_form',
						'type'      => 'on-off',
						'desc'      => __( 'Hide No of adult in booking form', 'traveler' ),
						'std'       => 'off',
						'condition' => 'tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Disable child booking', 'traveler' ),
						'id'        => 'hide_children_in_booking_form',
						'type'      => 'on-off',
						'desc'      => __( 'Hide No of child in booking form', 'traveler' ),
						'std'       => 'off',
						'condition' => 'tour_price_by:not(fixed)',
					],
					[
						'label'     => __( 'Disable infant booking', 'traveler' ),
						'id'        => 'hide_infant_in_booking_form',
						'type'      => 'on-off',
						'desc'      => __( 'Hide No of infant in booking form', 'traveler' ),
						'std'       => 'off',
						'condition' => 'tour_price_by:not(fixed)',
					],
					[
						'label' => esc_html__( 'Disable "Adult Name Required"', 'traveler' ),
						'type'  => 'on-off',
						'std'   => 'off',
						'id'    => 'disable_adult_name',
					],
					[
						'label' => esc_html__( 'Disable "Children Name Required"', 'traveler' ),
						'type'  => 'on-off',
						'std'   => 'off',
						'id'    => 'disable_children_name',
					],
					[
						'label' => esc_html__( 'Disable "Infant Name Required"', 'traveler' ),
						'type'  => 'on-off',
						'std'   => 'off',
						'id'    => 'disable_infant_name',
					],
					[
						'label'    => __( 'Extra pricing', 'traveler' ),
						'id'       => 'extra_price',
						'type'     => 'list-item',
						'settings' => [
							[
								'id'    => 'extra_name',
								'type'  => 'text',
								'std'   => 'extra_',
								'label' => __( 'Name of Item', 'traveler' ),
							],
							[
								'id'    => 'extra_max_number',
								'type'  => 'text',
								'std'   => '',
								'label' => __( 'Max of Number', 'traveler' ),
							],
							[
								'id'    => 'extra_price',
								'type'  => 'text',
								'std'   => '',
								'label' => __( 'Price', 'traveler' ),
								'desc'  => __( 'per 1 Item', 'traveler' ),
							],
							[
								'id'    => 'extra_required',
								'type'  => 'on-off',
								'std'   => 'off',
								'label' => __( 'Required Extra', 'traveler' ),
								'desc'  => __( '', 'traveler' ),
							],
						],
						'desc'     => __( 'You can define any extra service and price for with name, quantity, and price', 'traveler' ),
					],
					[
						'label' => __( 'Discount', 'traveler' ),
						'id'    => 'discount',
						'type'  => 'text',
						'desc'  => __( 'Discount of this tour (percent | amount)', 'traveler' ),
						'std'   => 0,
					],
					[
						'label'   => __( 'Type of discount', 'traveler' ),
						'id'      => 'discount_type',
						'type'    => 'select',
						'choices' => [
							[
								'label' => __( 'Percent', 'traveler' ),
								'value' => 'percent',
							],
							[
								'label' => __( 'Amount', 'traveler' ),
								'value' => 'amount',
							],
						],
					],
					[
						'label' => __( 'Sale schedule', 'traveler' ),
						'id'    => 'is_sale_schedule',
						'type'  => 'on-off',
						'std'   => 'off',
					],
					[
						'label'     => __( 'Sale start date', 'traveler' ),
						'desc'      => __( 'Sale start date', 'traveler' ),
						'id'        => 'sale_price_from',
						'type'      => 'date-picker',
						'condition' => 'is_sale_schedule:is(on)',
					],
					[
						'label'     => __( 'Sale end date', 'traveler' ),
						'desc'      => __( 'Sale end date', 'traveler' ),
						'id'        => 'sale_price_to',
						'type'      => 'date-picker',
						'condition' => 'is_sale_schedule:is(on)',
					],
					[
						'id'      => 'deposit_payment_status',
						'label'   => __( 'Deposit payment options', 'traveler' ),
						'desc'    => __( 'You can select <code>Disallow Deposit</code>, <code>Deposit by percent</code>' ),
						'type'    => 'select',
						'choices' => [
							[
								'value' => '',
								'label' => __( 'Disallow Deposit', 'traveler' ),
							],
							[
								'value' => 'percent',
								'label' => __( 'Deposit by percent', 'traveler' ),
							],
							/*
							[
							'value' => 'amount',
							'label' => __( 'Deposit by amount', 'traveler' )
							], */
						],
					],
					[
						'label'     => __( 'Deposit percent', 'traveler' ),
						'desc'      => __( 'Leave empty for disallow deposit payment', 'traveler' ),
						'id'        => 'deposit_payment_amount',
						'type'      => 'text',
						'condition' => 'deposit_payment_status:not()',
					],
					[
						'label' => __( 'Information', 'traveler' ),
						'id'    => 'st_info_tours_tab',
						'type'  => 'tab',
					],
					[
						'label'   => __( 'Tour type', 'traveler' ),
						'id'      => 'type_tour',
						'type'    => 'select',
						'desc'    => __( 'Select tour type. If you selected the \'Specific Date\' tour, you need to set price in \'Availability\' tab (required)', 'traveler' ),
						'choices' => [
							[
								'value' => 'daily_tour',
								'label' => __( 'Daily tour', 'traveler' ),
							],
							[
								'value' => 'specific_date',
								'label' => __( 'Specific date', 'traveler' ),
							],
						],
					],
					[
						'label' => __( 'Duration', 'traveler' ),
						'id'    => 'duration_day',
						'type'  => 'text',
						'desc'  => __( 'Enter tour duration. Example: <em>3 days 2 nights</em>', 'traveler' ),
						'std'   => '',
					],
					[
						'label'        => __( 'Minimum days to book before departure', 'traveler' ),
						'desc'         => __( 'Minimum days to book before departure', 'traveler' ),
						'id'           => 'tours_booking_period',
						'type'         => 'numeric-slider',
						'min_max_step' => '0,' . $value_tours_booking_period . ',1',
						'std'          => 0,
					],
					[
						'label' => __( 'Allow external booking', 'traveler' ),
						'id'    => 'st_tour_external_booking',
						'type'  => 'on-off',
						'std'   => 'off',
						'desc'  => __( 'You can set booking by an external link', 'traveler' ),
					],
					[
						'label'     => __( 'Tour external booking link ', 'traveler' ),
						'id'        => 'st_tour_external_booking_link',
						'type'      => 'text',
						'std'       => '',
						'condition' => 'st_tour_external_booking:is(on)',
						'desc'      => '<em>' . __( 'Notice: Must be http://...', 'traveler' ) . '</em>',
					],
					[
						'label' => __( 'Min of people', 'traveler' ),
						'id'    => 'min_people',
						'type'  => 'numeric-slider',
						'desc'  => __( 'Min of people', 'traveler' ),
						'std'   => 1,
					],
					/**
					 * @updated 1.2.8
					 * Can set unlimited peope
					 * */
					[
						'label'        => __( 'Max of people', 'traveler' ),
						'id'           => 'max_people',
						'type'         => 'numeric-slider',
						'desc'         => __( 'Max No. People. Enter \'0\' for unlimited', 'traveler' ),
						'min_max_step' => '0,100,1',
						'std'          => 1,
					],
					[
						'id'    => 'tours_include',
						'label' => __( 'Tour Included', 'traveler' ),
						'type'  => 'textarea',
						'rows'  => 5,
					],
					[
						'id'    => 'tours_exclude',
						'label' => __( 'Tour Excluded', 'traveler' ),
						'type'  => 'textarea',
						'rows'  => 5,
					],
					[
						'id'    => 'tours_highlight',
						'label' => __( 'Tour Highlight', 'traveler' ),
						'type'  => 'textarea',
						'rows'  => 5,
					],
					[
						'id'      => 'tours_program_style',
						'label'   => __( 'Tour program style', 'traveler' ),
						'type'    => 'select',
						'choices' => [
							[
								'label' => __( 'Image with text', 'traveler' ),
								'value' => 'style1',
							],
							[
								'label' => __( 'Background image', 'traveler' ),
								'value' => 'style2',
							],
							[
								'label' => __( 'Text with icon', 'traveler' ),
								'value' => 'style3',
							],
							[
								'label' => __( 'Background image with text', 'traveler' ),
								'value' => 'style4',
							],
						],
						'std'     => 'style1',
					],
					[
						'id'        => 'tours_program',
						'label'     => __( 'Tour program', 'traveler' ),
						'type'      => 'list-item',
						'condition' => 'tours_program_style:not(style2),tours_program_style:not(style4)',
						'settings'  => [
							[
								'id'    => 'image',
								'label' => __( 'Image', 'traveler' ),
								'type'  => 'upload',
							],
							[
								'id'    => 'desc',
								'label' => __( 'Description', 'traveler' ),
								'type'  => 'wpeditor',
								'rows'  => '5',
							],
						],
					],
					[
						'id'        => 'tours_program_bgr',
						'label'     => __( 'Tour program', 'traveler' ),
						'type'      => 'list-item',
						'condition' => 'tours_program_style:is(style2)',
						'settings'  => [
							[
								'id'    => 'time',
								'label' => __( 'Sub title', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'image',
								'label' => __( 'Image', 'traveler' ),
								'type'  => 'upload',
							],
							[
								'id'    => 'desc',
								'label' => __( 'Description', 'traveler' ),
								'type'  => 'wpeditor',
								'rows'  => '5',
							],
						],
					],
					[
						'id'        => 'tours_program_style4',
						'label'     => __( 'Tour program', 'traveler' ),
						'type'      => 'list-item',
						'condition' => 'tours_program_style:is(style4)',
						'settings'  => [
							[
								'id'    => 'time',
								'label' => __( 'Sub title', 'traveler' ),
								'type'  => 'text',
							],
							[
								'id'    => 'image',
								'label' => __( 'Image', 'traveler' ),
								'type'  => 'upload',
							],
							[
								'id'    => 'desc',
								'label' => __( 'Description', 'traveler' ),
								'type'  => 'wpeditor',
								'rows'  => '5',
							],
						],
					],
					[
						'id'       => 'tours_faq',
						'label'    => __( 'Tour FAQ', 'traveler' ),
						'type'     => 'list-item',
						'settings' => [
							[
								'id'    => 'desc',
								'label' => __( 'Description', 'traveler' ),
								'type'  => 'wpeditor',
								'rows'  => '5',
							],
						],
					],
					[
						'id'        => 'tour_over_view_bg_img',
						'label'     => __( 'Overview Background Image', 'traveler' ),
						'type'      => 'upload',
						'condition' => 'st_custom_layout_new:is(7)',
					],
					[
						'id'        => 'tours_highlight_bg_img',
						'label'     => __( 'Tour Highlight Background Image', 'traveler' ),
						'type'      => 'upload',
						'condition' => 'st_custom_layout_new:is(7)',
					],
					[
						'id'        => 'tours_related_bg_img',
						'label'     => __( 'Related Tour Background Image', 'traveler' ),
						'type'      => 'upload',
						'condition' => 'st_custom_layout_new:is(7)',
					],
					[
						'label' => __( 'Availability', 'traveler' ),
						'id'    => 'availability_tab',
						'type'  => 'tab',
					],
					[
						'label' => __( 'Tour calendar', 'traveler' ),
						'id'    => 'st_tour_calendar',
						'type'  => 'st_tour_calendar',
					],
					/**
					 * Tour package(Hotel)
					 */
					[
						'label' => __( 'Tour package', 'traveler' ),
						'id'    => 'st_tour_package_tab',
						'type'  => 'tab',
					],
					[
						'label' => __( 'Setting Tour Packages', 'traveler' ),
						'id'    => 'st_tour_package',
						'type'  => 'st_tour_package',
					],
					// End Tour package
					[
						'label' => __( 'Cancel booking', 'traveler' ),
						'id'    => 'st_cancel_booking_tab',
						'type'  => 'tab',
					],
					[
						'label' => __( 'Allow cancellation', 'traveler' ),
						'id'    => 'st_allow_cancel',
						'type'  => 'on-off',
						'std'   => 'off',
					],
					[
						'label'     => __( 'Number of days before the arrival', 'traveler' ),
						'desc'      => __( 'Number of days before the arrival', 'traveler' ),
						'id'        => 'st_cancel_number_days',
						'type'      => 'text',
						'condition' => 'st_allow_cancel:is(on)',
					],
					[
						'label'        => __( 'Cancellation Fee', 'traveler' ),
						'desc'         => __( 'A percentage of money customers will be deducted if they cancel a reservation', 'traveler' ),
						'id'           => 'st_cancel_percent',
						'type'         => 'numeric-slider',
						'min_max_step' => '0,100,1',
						'condition'    => 'st_allow_cancel:is(on)',
					],
					[
						'label' => __( 'Ical Sysc', 'traveler' ),
						'id'    => 'ical_sys_tab',
						'type'  => 'tab',
					],
					[
						'label' => __( 'Ical URL', 'traveler' ),
						'id'    => 'ical_url',
						'type'  => 'ical',
						'desc'  => __( 'Enter an ical url and click Import button. All data will be updated and shown in the Availability tab', 'traveler' ),
					],
				],
			];
			$data_paypment = STPaymentGateways::get_payment_gateways();
			if ( ! empty( $data_paypment ) and is_array( $data_paypment ) ) {
				$this->metabox[0]['fields'][] = [
					'label' => __( 'Payment', 'traveler' ),
					'id'    => 'payment_detail_tab',
					'type'  => 'tab',
				];
				foreach ( $data_paypment as $k => $v ) {
					$this->metabox[0]['fields'][] = [
						'label' => $v->get_name(),
						'id'    => 'is_meta_payment_gateway_' . $k,
						'type'  => 'on-off',
						'desc'  => $v->get_name(),
						'std'   => 'on',
					];
				}
			}
			$custom_field = st()->get_option( 'tours_unlimited_custom_field' );
			if ( ! empty( $custom_field ) and is_array( $custom_field ) ) {
				$this->metabox[0]['fields'][] = [
					'label' => __( 'Custom fields', 'traveler' ),
					'id'    => 'custom_field_tab',
					'type'  => 'tab',
				];
				foreach ( $custom_field as $k => $v ) {
					$key                          = str_ireplace( '-', '_', 'st_custom_' . sanitize_title( $v['title'] ) );
					$this->metabox[0]['fields'][] = [
						'label' => $v['title'],
						'id'    => $key,
						'type'  => $v['type_field'],
						'desc'  => '<input value=\'[st_custom_meta key="' . $key . '"]\' type=text readonly />',
						'std'   => $v['default_field'],
					];
				}
			}

			parent::register_metabox( $this->metabox );
		}

		// from 1.2.4
		static function get_min_price( $post_id = null ) {
			// if disable == 0ff, allow add to array
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$post_id = TravelHelper::post_origin( $post_id, 'st_tours' );
			global $wpdb;
			$price_min_max       = [];
			$table               = $wpdb->prefix . 'st_tour_availability';
			$query_sql_min       = "SELECT min(CAST(`adult_price` as DECIMAL(15,6))) as adult_price , min(CAST(`child_price` as DECIMAL(15,6))) as child_price ,  min(CAST(`infant_price` as DECIMAL(15,6))) as infant_price FROM {$table} WHERE check_in >= UNIX_TIMESTAMP(CURRENT_DATE) AND post_id = {$post_id} AND status = 'available'";
			$get_min_price_avail = $wpdb->get_results( $query_sql_min, ARRAY_A );
			$query_sql_max       = "SELECT max(CAST(`adult_price` as DECIMAL(15,6))) as adult_price , max(CAST(`child_price` as DECIMAL(15,6))) as child_price ,  max(CAST(`infant_price` as DECIMAL(15,6))) as infant_price FROM {$table} WHERE check_in >= UNIX_TIMESTAMP(CURRENT_DATE) AND post_id = {$post_id} AND status = 'available'";
			$get_max_price_avail = $wpdb->get_results( $query_sql_max, ARRAY_A );
			$price_min_max       = [];
			if ( isset( $get_min_price_avail ) ) {
				$price_min_max    = [
					'min' => $get_min_price_avail[0],
					'max' => $get_max_price_avail[0],
				];
				$price_adule_min  = $price_min_max['min']['adult_price'];
				$price_child_min  = $price_min_max['min']['child_price'];
				$price_infant_min = $price_min_max['min']['infant_price'];
			}
			$prices = [];

			$off_adult     = get_post_meta( $post_id, 'hide_adult_in_booking_form', true );
			$off_child     = get_post_meta( $post_id, 'hide_children_in_booking_form', true );
			$off_infant    = get_post_meta( $post_id, 'hide_infant_in_booking_form', true );
			$tour_price_by = get_post_meta( $post_id, 'tour_price_by', true );
			if ( $tour_price_by === 'fixed' ) {
				$prices[] = get_post_meta( $post_id, 'base_price', true );
			} else {
				$price_adule  = get_post_meta( $post_id, 'adult_price', true );
				$price_adule  = ! empty( $price_adule ) ? $price_adule : '';
				$price_child  = get_post_meta( $post_id, 'child_price', true );
				$price_child  = ! empty( $price_child ) ? $price_child : '';
				$price_infant = get_post_meta( $post_id, 'infant_price', true );
				$price_infant = ! empty( $price_infant ) ? $price_infant : '';
				if ( $off_adult != 'on' && $price_adule != '' ) {
					if ( isset( $price_adule_min ) && ( $price_adule_min < $price_adule ) ) {
						$prices[] = $price_adule_min;
					} else {
						$prices[] = $price_adule;
					}
				} elseif ( empty( $price_adule ) ) {

					if ( $off_adult != 'on' && $price_child != '' ) {
						if ( isset( $price_child_min ) && ( $price_child_min < $price_child ) ) {
							$prices[] = $price_child_min;
						} else {
							$prices[] = $price_child;
						}
					}
				} elseif ( empty( $price_adule ) && empty( $price_child ) ) {

					if ( $off_infant != 'on' && $price_infant != '' ) {
						if ( isset( $price_infant_min ) && ( $price_infant_min < $price_infant ) ) {
							$prices[] = $price_infant_min;
						} else {
							$prices[] = $price_infant;
						}
					}
				} else {
					$prices[] = 0;
				}
			}

			return empty( $prices ) ? 0 : min( $prices );
		}

		// from 1.2.4
		static function meta_update_min_price( $post_id ) {
			$post_type = get_post_type( $post_id );
			if ( $post_type == 'st_tours' ) {
				$min_price = self::get_min_price( $post_id );
				update_post_meta( $post_id, 'min_price', $min_price );
			}
		}

		function meta_update_sale_price( $post_id ) {
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}
			$post_type = get_post_type( $post_id );
			if ( $post_type == 'st_tours' ) {
				$sale_price       = get_post_meta( $post_id, 'adult_price', true );
				$discount         = get_post_meta( $post_id, 'discount', true );
				$is_sale_schedule = get_post_meta( $post_id, 'is_sale_schedule', true );
				$tour_price_type  = get_post_meta( $post_id, 'tour_price_by', true );
				if ( $tour_price_type == 'fixed' ) {
					$base_price = get_post_meta( $post_id, 'base_price', true );
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
						$sale_price = $base_price - ( $base_price / 100 ) * $discount;
					}
				} else {
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
						$sale_price = $sale_price - ( $sale_price / 100 ) * $discount;
					}
				}

				update_post_meta( $post_id, 'sale_price', $sale_price );
			}
		}

		function _resend_mail() {
			$order_item = isset( $_GET['order_item_id'] ) ? $_GET['order_item_id'] : false;

			$test = isset( $_GET['test'] ) ? $_GET['test'] : false;
			if ( $order_item ) {

				$order = $order_item;

				if ( $test ) {
					global $order_id;
					$order_id                = $order_item;
					$id_page_email_for_admin = st()->get_option( 'email_for_admin', '' );
					$content                 = ! empty( get_post( $id_page_email_for_admin ) ) ? wp_kses_post( get_post( $id_page_email_for_admin )->post_content ) : '';
					$email                   = '';
					$email                  .= TravelHelper::_get_template_email( $email, $content );
					echo( $email );
					die;
				}

				if ( $order ) {
					STCart::send_mail_after_booking( $order );
				}
			}

			wp_safe_redirect( self::$booking_page . '&send_mail=success' );
		}

		static function st_room_select_ajax() {
			extract(wp_parse_args($_GET, [
				'room_parent' => '',
				'post_type'   => '',
				'q'           => '',
			]));

			query_posts( [
				'post_type'      => $post_type,
				'posts_per_page' => 10,
				's'              => $q,
				'meta_key'       => 'room_parent',
				'meta_value'     => $room_parent,
			] );

			$r = [
				'items' => [],
			];
			while ( have_posts() ) {
				the_post();
				$r['items'][] = [
					'id'          => get_the_ID(),
					'name'        => get_the_title(),
					'description' => '',
				];
			}

			wp_reset_query();

			echo json_encode( $r );
			die;
		}

		static function add_edit_scripts() {
			wp_enqueue_script( 'tour-booking', get_template_directory_uri() . '/js/admin/tour-booking.js', [ 'jquery', 'jquery-ui-datepicker' ], null, true );
			wp_enqueue_style( 'jjquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css' );
		}

		static function is_booking_page() {
			if ( is_admin()
					and isset( $_GET['post_type'] )
					and $_GET['post_type'] == 'st_tours'
					and isset( $_GET['page'] )
					and $_GET['page'] = 'st_tours_booking'
			) {
				return true;
			}

			return false;
		}

		function new_menu_page() {
			// Add booking page
			add_submenu_page( 'edit.php?post_type=st_tours', __( 'Tour Booking', 'traveler' ), __( 'Tour Booking', 'traveler' ), 'manage_options', 'st_tours_booking', [ $this, '__tours_booking_page' ] );
		}

		function __tours_booking_page() {

			$section = isset( $_GET['section'] ) ? $_GET['section'] : false;

			if ( $section ) {
				switch ( $section ) {
					case 'edit_order_item':
						// show edit page
						$this->edit_order_item();
						break;
				}
			} else {

				$action = isset( $_POST['st_action'] ) ? $_POST['st_action'] : false;
				switch ( $action ) {
					case 'delete':
						$this->_delete_items();
						break;
				}
				echo balanceTags( $this->load_view( 'tour/booking_index', false ) );
			}
		}

		function add_booking() {

			echo balanceTags( $this->load_view( 'tour/booking_edit', false, [ 'page_title' => __( 'Add new Tour Booking', 'traveler' ) ] ) );
		}

		function _delete_items() {
			if ( empty( $_POST ) or ! check_admin_referer( 'shb_action', 'shb_field' ) ) {
				// process form data, e.g. update fields
				return;
			}
			$ids = isset( $_POST['post'] ) ? $_POST['post'] : [];
			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					$status = get_post_meta( $id, 'status', true );
					if ( ! empty( $status ) ) {
						if ( $status != 'canceled' ) {
							AvailabilityHelper::syncAvailabilityAfterCanceled( $id );
						}
					}
					wp_delete_post( $id, true );
					do_action( 'st_admin_delete_booking', $id );
				}
				die;
			}

			STAdmin::set_message( __( 'Delete item(s) success', 'traveler' ), 'updated' );
		}

		function edit_order_item() {
			$item_id = isset( $_GET['order_item_id'] ) ? $_GET['order_item_id'] : false;
			if ( ! $item_id or get_post_type( $item_id ) != 'st_order' ) {
				return false;
			}

			echo balanceTags( $this->load_view( 'tour/booking_edit' ) );
		}

		function _save_booking( $order_id ) {
			if ( ! check_admin_referer( 'shb_action', 'shb_field' ) ) {
				die;
			}
			if ( $this->_check_validate() ) {

				$check_out_field = STCart::get_checkout_fields();

				if ( ! empty( $check_out_field ) ) {
					foreach ( $check_out_field as $field_name => $field_desc ) {
						if ( $field_name != 'st_note' ) {
							update_post_meta( $order_id, $field_name, STInput::post( $field_name ) );
						}
					}
				}

				$item_data = [
					'status' => $_POST['status'],
				];

				foreach ( $item_data as $key => $value ) {
					update_post_meta( $order_id, $key, $value );
				}

				if ( TravelHelper::checkTableDuplicate( 'st_tours' ) ) {
					global $wpdb;

					$table = $wpdb->prefix . 'st_order_item_meta';
					$data  = [
						'status'               => $_POST['status'],
						'cancel_refund_status' => 'complete',
					];
					$where = [
						'order_item_id' => $order_id,
					];
					$wpdb->update( $table, $data, $where );
				}

				STCart::send_mail_after_booking( $order_id, true );

				do_action( 'st_admin_edit_booking_status', $item_data['status'], $order_id );

				wp_safe_redirect( self::$booking_page );
			}
		}

		function _check_validate() {
			$st_first_name = STInput::request( 'st_first_name', '' );
			if ( empty( $st_first_name ) ) {
				STAdmin::set_message( __( 'The firstname field is not empty.', 'traveler' ), 'danger' );

				return false;
			}

			$st_last_name = STInput::request( 'st_last_name', '' );
			if ( empty( $st_last_name ) ) {
				STAdmin::set_message( __( 'The lastname field is not empty.', 'traveler' ), 'danger' );

				return false;
			}

			$st_email = STInput::request( 'st_email', '' );
			if ( empty( $st_email ) ) {
				STAdmin::set_message( __( 'The email field is not empty.', 'traveler' ), 'danger' );

				return false;
			}

			$st_phone = STInput::request( 'st_phone', '' );
			if ( empty( $st_phone ) ) {
				STAdmin::set_message( __( 'The phone field is not empty.', 'traveler' ), 'danger' );

				return false;
			}

			return true;
		}

		static function get_price_person( $post_id = null ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}

			$adult_price = get_post_meta( $post_id, 'adult_price', true );
			$child_price = get_post_meta( $post_id, 'child_price', true );

			$adult_price = apply_filters( 'st_apply_tax_amount', $adult_price );
			$child_price = apply_filters( 'st_apply_tax_amount', $child_price );

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
				if ( $discount > 100 ) {
					$discount = 100;
				}

				$adult_price_new = $adult_price - ( $adult_price / 100 ) * $discount;
				$child_price_new = $child_price - ( $child_price / 100 ) * $discount;
				$data            = [
					'adult'     => $adult_price,
					'adult_new' => $adult_price_new,
					'child'     => $child_price,
					'child_new' => $child_price_new,
					'discount'  => $discount,
				];
			} else {
				$data = [
					'adult_new' => $adult_price,
					'adult'     => $adult_price,
					'child'     => $child_price,
					'child_new' => $child_price,
					'discount'  => $discount,
				];
			}

			return $data;
		}

		function get_price_by_tour( $tour_id ) {
			if ( ! empty( $tour_id ) && get_post_type( $tour_id ) == 'st_tours' ) {
				$price            = floatval( get_post_meta( $tour_id, 'price', true ) );
				$discount         = get_post_meta( $tour_id, 'discount', true );
				$is_sale_schedule = get_post_meta( $tour_id, 'is_sale_schedule', true );

				if ( $is_sale_schedule == 'on' ) {
					$sale_from = get_post_meta( $tour_id, 'sale_price_from', true );
					$sale_to   = get_post_meta( $tour_id, 'sale_price_to', true );
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
					if ( $discount > 100 ) {
						$discount = 100;
					}

					$price_new = $price - ( $price / 100 ) * $discount;

					return $price_new;
				} else {
					return $price;
				}
			}
		}

		function filter_price_by_person( $price_old, $number, $key = 1 ) {
			$flag_return = false;

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

		function is_able_edit() {
			$item_id = isset( $_GET['order_item_id'] ) ? $_GET['order_item_id'] : false;
			if ( ! $item_id or get_post_type( $item_id ) != 'st_order' ) {
				wp_safe_redirect( self::$booking_page );
				die;
			}

			return true;
		}

		/* Function  update ========================================================= */

		function tours_update_location( $post_id ) {
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}
			$post_type = get_post_type( $post_id );

			if ( $post_type == 'st_tours' ) {
				$location_id = get_post_meta( $post_id, 'id_location', true );
				$ids_in      = [];
				$parents     = get_posts( [
					'numberposts' => -1,
					'post_status' => 'publish',
					'post_type'   => 'location',
					'post_parent' => $location_id,
				] );

				$ids_in[] = $location_id;

				foreach ( $parents as $child ) {
					$ids_in[] = $child->ID;
				}
				$arg         = [
					'post_type'  => 'st_tours',
					'meta_query' => [
						[
							'key'            => 'id_location',
							'posts_per_page' => '-1',
							'value'          => $ids_in,
							'compare'        => 'IN',
						],
					],
				];
				$query       = new WP_Query( $arg );
				$offer_tours = $query->post_count;

				// get total review
				$arg   = [
					'post_type'      => 'st_tours',
					'posts_per_page' => '-1',
					'meta_query'     => [
						[
							'key'     => 'id_location',
							'value'   => [ $location_id ],
							'compare' => 'IN',
						],
					],
				];
				$query = new WP_Query( $arg );
				$total = 0;
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$total += get_comments_number();
					}
				}
				// get car min price
				$arg   = [
					'post_type'      => 'st_tours',
					'posts_per_page' => '1',
					'order'          => 'ASC',
					'meta_key'       => 'price',
					'orderby'        => 'meta_value_num',
					'meta_query'     => [
						[
							'key'     => 'id_location',
							'value'   => [ $location_id ],
							'compare' => 'IN',
						],
					],
				];
				$query = new WP_Query( $arg );
				if ( $query->have_posts() ) {
					$query->the_post();
					$price_min = get_post_meta( get_the_ID(), 'price', true );
					update_post_meta( $location_id, 'review_st_tours', $total );
					update_post_meta( $location_id, 'min_price_st_tours', $price_min );
					update_post_meta( $location_id, 'offer_st_tours', $offer_tours );
				}
				wp_reset_postdata();
			}
		}

		function tours_update_price_sale( $post_id ) {
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}
			$post_type = get_post_type( $post_id );

			if ( $post_type == 'st_tours' ) {
				$discount = get_post_meta( $post_id, 'discount', true );
				$price    = (float) get_post_meta( $post_id, 'price', true );
				if ( ! empty( $discount ) ) {
					$price_sale = $price - $price * ( $discount / 100 );
					update_post_meta( $post_id, 'price_sale', $price_sale );
				}
			}
		}

		function add_col_header( $defaults ) {

			$this->array_splice_assoc($defaults, 2, 0, [
				'tour_type'   => __( 'Tour Type', 'traveler' ),
				'price'       => __( 'Price', 'traveler' ),
				'tour_layout' => __( 'Layout', 'traveler' ),
			]);

			return $defaults;
		}

		function array_splice_assoc( &$input, $offset, $length = 0, $replacement = [] ) {
			$tail      = array_splice( $input, $offset );
			$extracted = array_splice( $tail, 0, $length );
			$input    += $replacement + $tail;

			return $extracted;
		}

		function add_col_content( $column_name, $post_ID ) {
			if ( $column_name == 'tour_layout' ) {
				// show content of 'directors_name' column
				$parent = get_post_meta( $post_ID, 'st_custom_layout', true );

				if ( $parent ) {
					echo "<a href='" . get_edit_post_link( $parent ) . "'>" . get_the_title( $parent ) . '</a>';
				} else {
					echo __( 'Default', 'traveler' );
				}
			}
			if ( $column_name == 'tour_type' ) {
				$type = get_post_meta( $post_ID, 'type_tour', true );
				switch ( $type ) {
					case 'daily_tour':
						echo __( 'Daily Tour', 'traveler' );
						break;
					case 'specific_date':
						echo __( 'Specific Date', 'traveler' );
						break;
					default:
						echo 'none';
						break;
				}
			}

			if ( $column_name == 'price' ) {
				$tour_price_type = get_post_meta( $post_ID, 'tour_price_by', true );
				if ( $tour_price_type == 'fixed' ) {
					$discount          = get_post_meta( $post_ID, 'discount', true );
					$discount_type     = get_post_meta( $post_ID, 'discount_type', true );
					$base_price        = get_post_meta( $post_ID, 'base_price', true );
					$str_discount_type = ( $discount_type == 'percent' ) ? '%' : '';
					if ( ! empty( $discount ) ) {
						$is_sale_schedule = get_post_meta( $post_ID, 'is_sale_schedule', true );
						$base_price       = ! empty( $base_price ) ? $base_price - $base_price * ( $discount / 100 ) : 0;
						if ( isset( $base_price ) && intval( $base_price ) < 0 ) {
							$base_price = 0;
						}

						if ( $is_sale_schedule == 'on' ) {
							$sale_from = get_post_meta( $post_ID, 'sale_price_from', true );
							$sale_from = mysql2date( 'd/m/Y', $sale_from );
							$sale_to   = get_post_meta( $post_ID, 'sale_price_to', true );
							$sale_to   = mysql2date( 'd/m/Y', $sale_to );
							echo '<span>' . __( 'Price', 'traveler' ) . ': ' . TravelHelper::format_money( $base_price ) . '</span><br>';
							if ( isset( $discount_type ) && $discount_type == 'amount' ) {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . TravelHelper::format_money( $discount ) . '</span><br>';
							} else {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . $discount . $str_discount_type . '</span><br>';
							}
							echo '<span> ' . $sale_from . ' <i class="fa fa-arrow-right"></i> ' . $sale_to . '</span>';
						} else {
							echo '<span>' . __( 'Price', 'traveler' ) . ': ' . TravelHelper::format_money( $base_price ) . '</span><br>';
							if ( isset( $discount_type ) && $discount_type == 'amount' ) {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . TravelHelper::format_money( $discount ) . '</span><br>';
							} else {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . $discount . $str_discount_type . '</span><br>';
							}
						}
					} else {
						echo '<span>' . __( 'Price', 'traveler' ) . ': ' . TravelHelper::format_money( $discount ) . '</span>';
					}
				} else {
					$discount          = get_post_meta( $post_ID, 'discount', true );
					$discount_type     = get_post_meta( $post_ID, 'discount_type', true );
					$price_adult       = ! empty( get_post_meta( $post_ID, 'adult_price', true ) ) ? get_post_meta( $post_ID, 'adult_price', true ) : 0;
					$price_child       = ! empty( get_post_meta( $post_ID, 'child_price', true ) ) ? get_post_meta( $post_ID, 'child_price', true ) : 0;
					$str_discount_type = ( $discount_type == 'percent' ) ? '%' : '';
					if ( ! empty( $discount ) ) {
						$is_sale_schedule = get_post_meta( $post_ID, 'is_sale_schedule', true );

						if ( isset( $discount_type ) && $discount_type == 'amount' ) {
							$sale_adult = $price_adult - $discount;
							$sale_child = $price_child - $discount;
						} else {
							$sale_adult = ! empty( $price_adult ) ? $price_adult - $price_adult * ( $discount / 100 ) : 0;
							$sale_child = ! empty( $price_child ) ? $price_child - $price_child * ( $discount / 100 ) : 0;
						}
						if ( isset( $sale_adult ) && intval( $sale_adult ) < 0 ) {
							$sale_adult = 0;
						}
						if ( isset( $sale_child ) && intval( $sale_child ) < 0 ) {
							$sale_child = 0;
						}
						if ( $is_sale_schedule == 'on' ) {
							$sale_from = get_post_meta( $post_ID, 'sale_price_from', true );
							$sale_from = mysql2date( 'd/m/Y', $sale_from );
							$sale_to   = get_post_meta( $post_ID, 'sale_price_to', true );
							$sale_to   = mysql2date( 'd/m/Y', $sale_to );
							echo '<span> ' . __( 'Adult Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_adult ) . '</span> <i class="fa fa-arrow-right"></i> <strong>' . TravelHelper::format_money( $sale_adult ) . '</strong><br>';
							echo '<span>' . __( 'Child Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_child ) . '</span> <i class="fa fa-arrow-right"></i> <strong>' . TravelHelper::format_money( $sale_child ) . '</strong><br>';
							if ( isset( $discount_type ) && $discount_type == 'amount' ) {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . TravelHelper::format_money( $discount ) . '</span><br>';
							} else {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . $discount . $str_discount_type . '</span><br>';
							}
							echo '<span> ' . $sale_from . ' <i class="fa fa-arrow-right"></i> ' . $sale_to . '</span>';
						} else {
							echo '<span> ' . __( 'Adult Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_adult ) . '</span> <i class="fa fa-arrow-right"></i> <strong>' . TravelHelper::format_money( $sale_adult ) . '</strong><br>';
							echo '<span>' . __( 'Child Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_child ) . '</span> <i class="fa fa-arrow-right"></i> <strong>' . TravelHelper::format_money( $sale_child ) . '</strong><br>';
							if ( isset( $discount_type ) && $discount_type == 'amount' ) {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . TravelHelper::format_money( $discount ) . '</span><br>';
							} else {
								echo '<span>' . __( 'Discount rate', 'traveler' ) . ' : ' . $discount . $str_discount_type . '</span><br>';
							}
						}
					} else {
						echo '<span> ' . __( 'Adult Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_adult ) . '</span><br>';
						echo '<span>' . __( 'Child Price', 'traveler' ) . ': ' . TravelHelper::format_money( $price_child ) . '</span>';
					}
				}
			}
		}

		public function _upgradeColumnDiscountTypeTourTable() {
			$updated = get_option( 'st_upgrade_column_discount_type_tour_table', false );
			if ( ! $updated ) {
				global $wpdb;
				$updated = get_option( 'update_min_price_version_2791', false );
				if ( ! $updated ) {
					$list_tour = new WP_Query([
						'posts_per_page' => -1,
						'post_type'      => 'st_tours',
					]);

					if ( $list_tour->have_posts() ) {
						while ( $list_tour->have_posts() ) {
							$list_tour->the_post();
							$tour_id = get_the_ID();
							self::meta_update_min_price( $tour_id );
							self::_update_duplicate_data( $tour_id, [] );
						}
					}
					wp_reset_postdata();
					update_option( 'update_min_price_version_2791', true );
				}
			}
		}

		public function _upgrade_min_max_price() {
			global $wpdb;
			$updated = get_option( 'update_min_price_version_2789', false );
			if ( ! $updated ) {
				$list_tour = new WP_Query([
					'posts_per_page' => -1,
					'post_type'      => 'st_tours',
				]);

				if ( $list_tour->have_posts() ) {
					while ( $list_tour->have_posts() ) {
						$list_tour->the_post();
						$tour_id = get_the_ID();
						self::meta_update_min_price( $tour_id );
						self::_update_duplicate_data( $tour_id, [] );
					}
				}
				wp_reset_postdata();
				update_option( 'update_min_price_version_2789', true );
			}
		}

		public static function __cronjob_update_min_price( $offset, $limit = 2 ) {
			global $wpdb;
			$list_tour = new WP_Query([
				'posts_per_page' => $limit,
				'post_type'      => 'st_tours',
				'offset'         => $offset,
			]);

			if ( $list_tour->have_posts() ) {
				while ( $list_tour->have_posts() ) {
					$list_tour->the_post();
					$tour_id = get_the_ID();
					self::meta_update_min_price( $tour_id );
					self::_update_duplicate_data( $tour_id, [] );
				}
			}

			wp_reset_postdata();
		}

		static function inst() {
			if ( ! self::$_inst ) {
				self::$_inst = new self();
			}

			return self::$_inst;
		}

	}

	STAdminTours::inst();
}

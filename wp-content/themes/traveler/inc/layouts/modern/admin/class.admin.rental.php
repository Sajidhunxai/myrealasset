<?php
    /**
     * @package    WordPress
     * @subpackage Traveler
     * @since      1.0
     *
     * Class STAdminRental
     *
     * Created by ShineTheme
     *
     */
    $order_id = 0;
    if ( !class_exists( 'STAdminRental' ) ) {

        class STAdminRental extends STAdmin
        {

            static $booking_page;
            public $metabox;
            static $_table_version = "1.3.3";
            public $post_type      = 'st_rental';

            protected static $_inst;


            function __construct()
            {


                add_action( 'init', [ $this, '_reg_post_type' ], 8 );

                if ( !st_check_service_available( $this->post_type ) ) return;

                //add colum for rooms
                add_filter( 'manage_st_rental_posts_columns', [ $this, 'add_col_header' ], 10 );
                add_action( 'manage_st_rental_posts_custom_column', [ $this, 'add_col_content' ], 10, 2 );

                self::$booking_page = admin_url( 'edit.php?post_type=st_rental&page=st_rental_booking' );
                //rental Hook
                /*
                 * todo Re-cal rental min price
                 * */

                add_action( 'save_post', [ $this, 'meta_update_sale_price' ], 10, 4 );
                add_action( 'admin_menu', [ $this, 'new_menu_page' ] );

                //Check booking edit and redirect
                if ( self::is_booking_page() ) {
                    add_action( 'admin_enqueue_scripts', [ __CLASS__, 'add_edit_scripts' ] );

                    add_action( 'admin_init', [ $this, '_do_save_booking' ] );
                }

                if ( isset( $_GET[ 'send_mail' ] ) and $_GET[ 'send_mail' ] == 'success' ) {
                    self::set_message( __( 'Email sent', 'traveler' ), 'updated' );
                }

                add_action( 'wp_ajax_st_room_select_ajax', [ __CLASS__, 'st_room_select_ajax' ] );


                add_action( 'current_screen', [ $this, '_add_metabox' ] );

                add_action( 'st_search_fields_name', [ $this, 'get_search_fields_name' ], 10, 2 );
                /**
                 * @since 1.1.6
                 **/
                add_action( 'save_post', [ $this, '_update_list_location' ], 10, 2 );
                add_action( 'save_post', [ $this, '_update_min_price' ], 50, 2 );
                add_action( 'save_post', [ $this, '_update_duplicate_data' ], 50, 2 );
                add_action( 'before_delete_post', [ $this, '_delete_data' ], 50 );

                //parent::__construct();

                add_action( 'wp_ajax_st_getRentalInfo', [ __CLASS__, 'getRentalInfo' ], 9999 );

                /**
                 *   since 1.2.4
                 *   auto create & update table st_rental
                 **/
                add_action( 'after_setup_theme', [ __CLASS__, '_check_table_rental' ] );

                /**
                 * @since 1.3.0
                 *        Bulk calendar
                 **/
                add_action( 'traveler_after_form_rental_calendar', [ $this, 'custom_traveler_after_form_rental_calendar' ] );
                add_action( 'traveler_after_form_submit_rental_calendar', [ $this, 'custom_traveler_after_form_submit_rental_calendar' ] );

	            add_action( 'wp_ajax_get_distance_placeid', [ $this, 'get_distance_placeid' ], 9999 );


                add_action('st_availability_cronjob',array($this,'__cronjob_fill_availability'));

                add_action('admin_init', [$this, '_upgradeRentalTable131']);
            }
            public function _upgradeRentalTable131(){
                $updated = get_option('_upgradeRentalTable131', false);
                if(!$updated){
                    global $wpdb;
                    $table = $wpdb->prefix. $this->post_type;
                    $sql = "Update {$table} as t inner join {$wpdb->postmeta} as m on (t.post_id = m.post_id and m.meta_key = 'is_featured') set t.is_featured = m.meta_value";
                    $wpdb->query($sql);
                    update_option('_upgradeRentalTable131', 'updated');
                }
            }

            public function __cronjob_fill_availability($offset = 0, $limit = -1, $day=null)
            {
                global $wpdb;
                if(!$day){
                    $today=new DateTime(date('Y-m-d'));
                    $today->modify('+ 6 months');
                    $day=$today->modify('+ 1 day');
                }
                $table='st_rental_availability';
                $post_type='st_rental';

                $rooms=new WP_Query(array(
	                'posts_per_page'=>$limit,
                    'post_type'=>$post_type,
	                'offset' => $offset
                ));
                $insertBatch=[];
                $ids=[];
                while ($rooms->have_posts())
                {
                    $rooms->the_post();
                    $price=get_post_meta(get_the_ID(),'price',true);
                    $status='available';//default
                    $number=get_post_meta(get_the_ID(),'rental_number',true);
                    $allow_full_day=get_post_meta(get_the_ID(),'allow_full_day',true);
                    $rental_max_adult=get_post_meta(get_the_ID(),'rental_max_adult',true);
                    $rental_max_children=get_post_meta(get_the_ID(),'rental_max_children',true);
                    $booking_period = get_post_meta(get_the_ID(), 'rentals_booking_period', true);
                    if(empty($booking_period)) $booking_period = 0;
                    if(!$allow_full_day) $allow_full_day='on';

                    $insertBatch[]=$wpdb->prepare("(%d,%d,%d,%s,%d,%s,%d,%s,%d,%d,%d,%d)",$day->getTimestamp(),$day->getTimestamp(),get_the_ID(),$post_type,$number,$status,$price,$allow_full_day,$rental_max_adult,$rental_max_children,1,$booking_period);

                    $ids[]=get_the_ID();
                }
                if(!empty($insertBatch))
                {
                    $wpdb->query("INSERT IGNORE INTO {$wpdb->prefix}{$table} (check_in,check_out,post_id,post_type,`number`,`status`,price,allow_full_day,adult_number,child_number,is_base,booking_period) VALUES ".implode(",\r\n",$insertBatch));
                }

                wp_reset_postdata();
            }

            public static function fill_post_availability($post_id,$timestamp=null)
            {
                $data=[];
                global $wpdb;
                $table='st_rental_availability';

                $price=get_post_meta($post_id,'price',true);
                $number=get_post_meta($post_id,'rental_number',true);
                $allow_full_day=get_post_meta($post_id,'allow_full_day',true);
                $rental_max_adult=get_post_meta($post_id,'rental_max_adult',true);
                $rental_max_children=get_post_meta($post_id,'rental_max_children',true);
                $status='available';
                if(!$allow_full_day) $allow_full_day='on';
                $rs=ST_Order_Item_Model::inst()
                    ->select('count(room_num_search) as number_booked')
                    ->where('post_id',$post_id)
                    ->where('check_in_timestamp <=',$timestamp)
                    ->where('check_out_timestamp >=',$timestamp)
                    ->where("STATUS NOT IN ('trash', 'canceled')",false,true)
                    ->get(1)->row();
                $number_end=ST_Order_Item_Model::inst()
                    ->select('count(room_num_search) as number_booked')
                    ->where('post_id',$post_id)
                    ->where('check_out_timestamp',$timestamp)
                    ->where("STATUS NOT IN ('trash', 'canceled')",false,true)
                    ->get(1)->row();


                $data['check_in']=$timestamp;
                $data['check_out']=$timestamp;
                $data['post_type']='st_rental';
                $data['number']=$number;
                $data['status']=$status;
                $data['price']=$price;
                $data['allow_full_day']=$allow_full_day;
                $data['number_booked']=$rs['number_booked'];
                $data['number_end']=$number_end['number_booked'];
                $data['adult_number']=$rental_max_adult;
                $data['child_number']=$rental_max_children;

//                $model=ST_Availability_Model::inst();
//
//                $data['id']=$model->insert($data);

                $insert=$wpdb->prepare("(%d,%d,%d,%s,%d,%d,%d,%s,%d,%s,%d,%d)",$timestamp,$timestamp,$post_id,'st_rental',$number,$rs['number_booked'],$number_end['number_booked'],$status,$price,$allow_full_day,$rental_max_adult,$rental_max_children);

                $wpdb->query("INSERT IGNORE INTO {$wpdb->prefix}{$table} (check_in,check_out,post_id,post_type,`number`,number_booked,number_end,`status`,price,allow_full_day,adult_number,child_number) VALUES ".$insert);


                return $data;

            }

            public function get_distance_placeid(){
            	$lat = STInput::post('lat');
	            $lng = STInput::post('lng');
	            $place_id = STInput::post('placeid');

	            $dist = $time = 0;
	            $return = [];

	            if(!empty($place_id)){
	            	foreach ($place_id as $k => $v){
			            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . $lat . "," . $lng . "&destinations=place_id:" . $v . "&mode=driving&language=en-US&key=" . st()->get_option( 'google_api_key', '' );
			            $response   = wp_remote_get( $url );
			            $response_a = json_decode( wp_remote_retrieve_body( $response ), true );
			            if ( $response_a[ 'rows' ][ 0 ][ 'elements' ][ 0 ][ 'status' ] == 'OK' ) {
				            $dist = (float)$response_a[ 'rows' ][ 0 ][ 'elements' ][ 0 ][ 'distance' ][ 'value' ];
				            $time = (float)$response_a[ 'rows' ][ 0 ][ 'elements' ][ 0 ][ 'duration' ][ 'value' ];

				            $dist   = round( ( $dist / 1000 ), 2 );
				            $hour   = (int)( $time / ( 60 * 60 ) );
				            $minute = (int)( ( $time / ( 60 * 60 ) - $hour ) * 60 );

				            $return[$v] = [
					            'distance' => $dist .' '. __('km', 'traveler'),
					            'time'     => $time,
					            'hour'     => $hour,
					            'minute'   => $minute
				            ];
			            }
		            }
		            echo json_encode($return);
		            die;
	            }
            }

            public function custom_traveler_after_form_rental_calendar()
            {
                echo balanceTags( st()->load_template( 'rental/rental-calendar', false ) );
            }

            public function custom_traveler_after_form_submit_rental_calendar()
            {
                echo '<button type="button" id="calendar-bulk-edit" class="option-tree-ui-button button button-primary button-large btn btn-primary btn-sm" style="float: right;">' . __( 'Bulk Edit', 'traveler' ) . '</button>';
            }

            public function change_allday_to_group( $all_days = [] )
            {
                $return_tmp = [];
                $return     = [];

                foreach ( $all_days as $item ) {
                    $month = date( 'm', $item );
                    if ( !isset( $return_tmp[ $month ] ) ) {
                        $return_tmp[ $month ][ 'min' ] = $item;
                        $return_tmp[ $month ][ 'max' ] = $item;
                    } else {
                        if ( $return_tmp[ $month ][ 'min' ] > $item ) {
                            $return_tmp[ $month ][ 'min' ] = $item;
                        }
                        if ( $return_tmp[ $month ][ 'max' ] < $item ) {
                            $return_tmp[ $month ][ 'max' ] = $item;
                        }
                    }
                }

                foreach ( $return_tmp as $key => $val ) {
                    $return[] = [
                        'min' => $val[ 'min' ],
                        'max' => $val[ 'max' ],
                    ];
                }

                return $return;
            }

            static function check_ver_working()
            {
                $dbhelper = new DatabaseHelper( self::$_table_version );

                return $dbhelper->check_ver_working( 'st_rental_table_version' );
            }

            static function _check_table_rental()
            {
                $dbhelper = new DatabaseHelper( self::$_table_version );
                $dbhelper->setTableName( 'st_rental' );
                $column = [
                    'post_id'                => [
                        'type'   => 'INT',
                        'length' => 11,
                    ],
                    'multi_location'         => [
                        'type' => 'text',
                    ],
                    'location_id'            => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'address'                => [
                        'type' => 'text',
                    ],
                    'allow_full_day'         => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'rental_max_adult'       => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'rental_max_children'    => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'rate_review'            => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'sale_price'             => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'rentals_booking_period' => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'is_sale_schedule'       => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'discount_type'                  => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'discount_rate'          => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'sale_price_from'        => [
                        'type'   => 'date',
                        'length' => 255
                    ],
                    'sale_price_to'          => [
                        'type'   => 'date',
                        'length' => 255
                    ],
                    'price'                  => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'max_price'                  => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'min_price'                  => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    
                    'is_featured'        => [
                        'type'   => 'varchar',
                        'length' => 5
                    ]
                ];

                $column = apply_filters( 'st_change_column_st_rental', $column );

                $dbhelper->setDefaultColums( $column );
                $dbhelper->check_meta_table_is_working( 'st_rental_table_version' );

                return array_keys( $column );
            }

            function _do_save_booking()
            {
                $section = isset( $_GET[ 'section' ] ) ? $_GET[ 'section' ] : FALSE;
                switch ( $section ) {
                    case "edit_order_item":
                        $item_id = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : FALSE;
                        if ( !$item_id or get_post_type( $item_id ) != 'st_order' ) {
                            return FALSE;
                        }
                        if ( isset( $_POST[ 'submit' ] ) and $_POST[ 'submit' ] ) $this->_save_booking( $item_id );
                        break;
                    case 'resend_email':
                        $this->_resend_mail();
                        break;
                        break;
                }
            }

            public function _delete_data( $post_id )
            {
                if ( get_post_type( $post_id ) == 'st_rental' ) {
                    global $wpdb;
                    $table = $wpdb->prefix . 'st_rental';
                    $rs    = TravelHelper::deleteDuplicateData( $post_id, $table );
                    if ( !$rs )
                        return false;

                    return true;
                }
            }
            static function _update_min_price($post_id = false){
                //update min price and max price for rental
                if (!$post_id) {
                    $post_id = get_the_ID();
                }
    
                $post_type = get_post_type($post_id);
                if ($post_type == 'st_rental') {
                    $query = [
                        'post_type' => 'st_rental',
                        'posts_per_page' => -1,
                    ];
                    $traver = new WP_Query($query);
    
                    $prices = [];
                    while ($traver->have_posts()) {
                        $traver->the_post();
                        $query_price = ST_Rental_Availability::inst()
                            ->select("min(CAST(price as DECIMAL)) as min_price ")
                            ->select("max(CAST(price as DECIMAL)) as max_price ")
                            ->where('status', 'available')
                            ->where('post_id', $post_id)
                            ->where("check_in >= UNIX_TIMESTAMP(CURRENT_DATE)", null, true)
                            ->get()->result();
                        if (!empty($query_price)) {
                            $item_price = $query_price[0]['min_price'];
                            $item_price_max = $query_price[0]['max_price'];
                        } else {
                            $item_price = get_post_meta($post_id, 'price', true);
                            $$item_price_max = get_post_meta($post_id, 'price', true);
                        }
    
                        $prices[] = $item_price;
                        $prices_max[] = $item_price_max;
                    }
                    // wp_reset_query();
                    wp_reset_postdata();
                    if (!empty($prices)) {
                        $min_price = min($prices);
                        $max_price = max($prices_max);
                        update_post_meta($post_id, 'min_price', $min_price);
                        update_post_meta($post_id, 'max_price', $max_price);
                    } else {
                        update_post_meta($post_id, 'min_price', '0');
                        update_post_meta($post_id, 'max_price', '0');
                    }
                }
            }
            static function  _update_duplicate_data( $id, $data )
            {
                $create_post_by_partner = false;
                if(isset($_POST['action']) && $_POST['action'] == 'st_partner_create_service_rental'){
                    $create_post_by_partner = true;
                }
                if ( !TravelHelper::checkTableDuplicate( 'st_rental' ) ) return;
                
                if ( get_post_type( $id ) == 'st_rental' ) {
                    $num_rows = TravelHelper::checkIssetPost( $id, 'st_rental' );

                    $location_str = get_post_meta( $id, 'multi_location', true );
                    $location_id  = ''; // location_id
                    $is_featured = get_post_meta($id, 'is_featured', true);

                    $address                = get_post_meta( $id, 'address', true ); // address
                    $allow_full_day         = get_post_meta( $id, 'allow_full_day', true ); // address
                    $rentals_booking_period = get_post_meta( $id, 'rentals_booking_period', true ); // rentals_booking_period
                    $rental_max_adult       = get_post_meta( $id, 'rental_max_adult', true ); // rental max adult
                    $rental_max_children    = get_post_meta( $id, 'rental_max_children', true ); // rental max children

                    $sale_price = get_post_meta( $id, 'price', true ); // sale price
                    $price      = $sale_price;
                    $min_price = get_post_meta($id, 'min_price', true);
                    $max_price = get_post_meta($id, 'max_price', true);
                    $discount         = get_post_meta( $id, 'discount_rate', true );
                    $is_sale_schedule = get_post_meta( $id, 'is_sale_schedule', true );
                    $sale_from        = get_post_meta( $id, 'sale_price_from', true );
                    $sale_to          = get_post_meta( $id, 'sale_price_to', true );
                    $discount_type          = get_post_meta( $id, 'discount_type', true );
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
                        $sale_price = $sale_price - ( $sale_price / 100 ) * $discount;
                    }
                    $rate_review = STReview::get_avg_rate( $id ); // rate review

                    if ( $num_rows == 1 ) {
                        $data  = [
                            'multi_location'         => $location_str,
                            'location_id'            => $location_id,
                            'address'                => $address,
                            'rental_max_adult'       => $rental_max_adult,
                            'rental_max_children'    => $rental_max_children,
                            'rate_review'            => $rate_review,
                            'price'                  => $price,
                            'sale_price'             => $sale_price,
                            'discount_rate'          => $discount,
                            'min_price'              => $min_price,
                            'max_price'              => $max_price,
                            'sale_price_from'        => $sale_from,
                            'sale_price_to'          => $sale_to,
                            'is_sale_schedule'       => $is_sale_schedule,
                            'rentals_booking_period' => $rentals_booking_period,
                            'allow_full_day'         => $allow_full_day,
                            'is_featured'            => $is_featured,
                            'discount_type'          => $discount_type
                        ];
                        $where = [
                            'post_id' => $id
                        ];
                        TravelHelper::updateDuplicate( 'st_rental', $data, $where );
                    } elseif ( $num_rows == 0 ) {
                        $data = [
                            'post_id'                => $id,
                            'multi_location'         => $location_str,
                            'location_id'            => $location_id,
                            'address'                => $address,
                            'rental_max_adult'       => $rental_max_adult,
                            'rental_max_children'    => $rental_max_children,
                            'rate_review'            => $rate_review,
                            'min_price'              => $min_price,
                            'max_price'              => $max_price,
                            'price'                  => $price,
                            'sale_price'             => $sale_price,
                            'discount_rate'          => $discount,
                            'sale_price_from'        => $sale_from,
                            'sale_price_to'          => $sale_to,
                            'is_sale_schedule'       => $is_sale_schedule,
                            'rentals_booking_period' => $rentals_booking_period,
                            'is_featured'         => $is_featured,
                            'discount_type'          => $discount_type
                        ];
                        TravelHelper::insertDuplicate( 'st_rental', $data );
                    }


                    // Update Availability
                    $model=ST_Rental_Availability::inst();
                    $model->where('post_id',$id)
                            ->where("check_in", "UNIX_TIMESTAMP(CURRENT_DATE)", ">=")
                          ->update(array(
                            'allow_full_day'=>$allow_full_day,
                            'number'=>get_post_meta($id,'rental_number',true),
		                    'booking_period' => $rentals_booking_period,
		                    'adult_number' => $rental_max_adult,
		                    'child_number' => $rental_max_children
                    ));
	                $model->where(array('post_id' => $id, 'is_base' => 1))
                            ->where("check_in", "UNIX_TIMESTAMP(CURRENT_DATE)", ">=")
                          ->update(array(
			                'price'=>$data['price'] ));


                }
            }

            /**
             * @since 1.1.7
             **/
            function _update_list_location( $id, $data )
            {
                $location = STInput::request( 'multi_location', '' );
                if ( isset( $_REQUEST[ 'multi_location' ] ) ) {
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
                    update_post_meta( $id, 'location_id', '' );
                }

            }

            /**
             *
             *
             * @since 1.1.3
             * */
            function _reg_post_type()
            {
                if ( !st_check_service_available( $this->post_type ) ) {
                    return;
                }
                if ( !function_exists( 'st_reg_post_type' ) ) return;
                // Rental ==============================================================
                $labels = [
                    'name'                  => __( 'Rental', 'traveler' ),
                    'singular_name'         => __( 'Rental', 'traveler' ),
                    'menu_name'             => __( 'Rental', 'traveler' ),
                    'name_admin_bar'        => __( 'Rental', 'traveler' ),
                    'add_new'               => __( 'Add Rental', 'traveler' ),
                    'add_new_item'          => __( 'Add New Rental', 'traveler' ),
                    'new_item'              => __( 'New Rental', 'traveler' ),
                    'edit_item'             => __( 'Edit Rental', 'traveler' ),
                    'view_item'             => __( 'View Rental', 'traveler' ),
                    'all_items'             => __( 'All Rental', 'traveler' ),
                    'search_items'          => __( 'Search Rental', 'traveler' ),
                    'parent_item_colon'     => __( 'Parent Rental:', 'traveler' ),
                    'not_found'             => __( 'No Rental found.', 'traveler' ),
                    'not_found_in_trash'    => __( 'No Rental found in Trash.', 'traveler' ),
                    'insert_into_item'      => __( 'Insert into Rental', 'traveler' ),
                    'uploaded_to_this_item' => __( "Uploaded to this Rental", 'traveler' ),
                    'featured_image'        => __( "Feature Image", 'traveler' ),
                    'set_featured_image'    => __( "Set featured image", 'traveler' )
                ];

                $args = [
                    'labels'             => $labels,
                    'public'             => true,
                    'publicly_queryable' => true,
                    'show_ui'            => true,
                    'query_var'          => true,
                    'rewrite'            => [ 'slug' => get_option( 'rental_permalink', 'st_rental' ) ],
                    'capability_type'    => 'post',
                    'hierarchical'       => false,
                    'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
                    'menu_icon'          => 'dashicons-admin-home-st'
                ];
                st_reg_post_type( 'st_rental', $args );// post type rental

                /**
                 * @since 1.1.3
                 *        Rental room
                 **/
                // $labels = [
                //     'name'               => __( 'Rental Room', 'traveler' ),
                //     'singular_name'      => __( 'Room', 'traveler' ),
                //     'menu_name'          => __( 'Rental Room', 'traveler' ),
                //     'name_admin_bar'     => __( 'Room', 'traveler' ),
                //     'add_new'            => __( 'Add New', 'traveler' ),
                //     'add_new_item'       => __( 'Add New Room', 'traveler' ),
                //     'new_item'           => __( 'New Room', 'traveler' ),
                //     'edit_item'          => __( 'Edit Room', 'traveler' ),
                //     'view_item'          => __( 'View Room', 'traveler' ),
                //     'all_items'          => __( 'All Rooms', 'traveler' ),
                //     'search_items'       => __( 'Search Rooms', 'traveler' ),
                //     'parent_item_colon'  => __( 'Parent Rooms:', 'traveler' ),
                //     'not_found'          => __( 'No rooms found.', 'traveler' ),
                //     'not_found_in_trash' => __( 'No rooms found in Trash.', 'traveler' )
                // ];

                // $args = [
                //     'labels'              => $labels,
                //     'public'              => true,
                //     'publicly_queryable'  => true,
                //     'show_ui'             => true,
                //     'query_var'           => true,
                //     'rewrite'             => [ 'slug' => get_option( 'rental_room_permalink', 'rental_room' ) ],
                //     'capability_type'     => 'post',
                //     'has_archive'         => true,
                //     'hierarchical'        => false,
                //     'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
                //     'menu_icon'           => 'dashicons-admin-home-st',
                //     'exclude_from_search' => true,
                // ];

                //st_reg_post_type( 'rental_room', $args );
            }

            /**
             *
             * @since 1.1.0
             * */
            function get_search_fields_name( $fields, $post_type )
            {
                if ( $post_type == $this->post_type ) {
                    $fields = [
                        'location'      => [
                            'value' => 'location',
                            'label' => __( 'Location', 'traveler' )
                        ],
                        'list_location' => [
                            'value' => 'list_location',
                            'label' => __( 'Location List', 'traveler' )
                        ],
                        'checkin'       => [
                            'value' => 'checkin',
                            'label' => __( 'Check in', 'traveler' )
                        ],
                        'checkout'      => [
                            'value' => 'checkout',
                            'label' => __( 'Check out', 'traveler' )
                        ],
                        'adult'         => [
                            'value' => 'adult',
                            'label' => __( 'Adult', 'traveler' )
                        ],
                        'children'      => [
                            'value' => 'children',
                            'label' => __( 'Children', 'traveler' )
                        ],
                        'room_num'      => [
                            'value' => 'room_num',
                            'label' => __( 'Room(s)', 'traveler' )
                        ],
                        'taxonomy'      => [
                            'value' => 'taxonomy',
                            'label' => __( 'Taxonomy', 'traveler' )
                        ]

                    ];
                }

                return $fields;
            }

            /**
             *
             * @since 1.0.9
             * */
            function _add_metabox()
            {
                $screen = get_current_screen();
                if ( $screen->id != 'st_rental' ) {
                    return false;
                }

                $layout_single = [
                    [
                        'value' => '1',
                        'label' => esc_html__( 'Layout 1', 'traveler' ),
                        'src'   => get_template_directory_uri() . '/v2/images/layouts/room_detail_2_preview.jpg',
                    ],
                    [
                        'value' => '2',
                        'label' => esc_html__( 'Layout 2', 'traveler' ),
                        'src'   => get_template_directory_uri() . '/v2/images/layouts/room_detail_1_preview.jpg',
                    ],
                ];
                if(check_using_elementor()){
                    $array_elementor = [
                       
                        [
                            'value' => '3',
                            'label' => esc_html__('Layout 3', 'traveler'),
                            'src' => get_template_directory_uri() . '/v2/images/layouts/rental_detail_3_preview.png',
                        ],
                        [
                            'value' => '4',
                            'label' => esc_html__('Layout 4', 'traveler'),
                            'src' => get_template_directory_uri() . '/v2/images/layouts/rental_detail_4_preview.png',
                        ],
                    ];
                    $layout_single = array_merge($layout_single,$array_elementor);
                }
                $layout_single = apply_filters('st_layout_single_rental',$layout_single);
                $this->metabox[] = [
                    'id'       => 'rental_metabox',
                    'title'    => __( 'Rental details', 'traveler' ),
                    'desc'     => '',
                    'pages'    => [ 'st_rental' ],
                    'context'  => 'normal',
                    'priority' => 'high',
                    'fields'   => [
                        [
                            'label' => __( 'Location', 'traveler' ),
                            'id'    => 'location_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label'     => __( 'Rental location', 'traveler' ),
                            'id'        => 'multi_location', // id_location
                            'type'      => 'list_item_post_type',
                            'desc'      => __( 'Select one or more location for your rental', 'traveler' ),
                            'post_type' => 'location'
                        ],

                        [
                            'label' => __( 'Real rental address ', 'traveler' ),
                            'id'    => 'address',
                            'type'  => 'address_autocomplete',
                            'desc'  => __( 'Input your rental address detail', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Location on map', 'traveler' ),
                            'id'    => 'st_google_map',
                            'type'  => 'bt_gmap',
                            'std'   => 'off',
                            'desc'  => __( 'Kindly input Map API in Theme Settings > Other Options . Select one location on map to see latiture and longiture', 'traveler' )
                        ],
                        [
                            'label'    => __( 'Properties near by', 'traveler' ),
                            'id'       => 'properties_near_by',
                            'type'     => 'list-item',
                            'desc'     => __( 'Properties near by this rental', 'traveler' ),
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
                                    'row'   => 5
                                ],
                                [
                                    'id'    => 'icon',
                                    'label' => __( 'Map icon', 'traveler' ),
                                    'type'  => 'upload'
                                ],
                                [
                                    'id'    => 'map_lat',
                                    'label' => __( 'Map lat', 'traveler' ),
                                    'type'  => 'text'
                                ],
                                [
                                    'id'    => 'map_lng',
                                    'label' => __( 'Map long', 'traveler' ),
                                    'type'  => 'text'
                                ]
                            ]
                        ],
                        [
                            'label' => __( 'Street view mode', 'traveler' ),
                            'id'    => 'enable_street_views_google_map',
                            'type'  => 'on-off',
                            'desc'  => __( 'Turn on/off streetview mode for this location', 'traveler' ),
                            'std'   => 'off'
                        ],
	                    
	                    /*[
		                    'label' => __( 'Rental distances nearest', 'traveler' ),
		                    'id'    => 'st_rental_distance',
		                    'type'  => 'st_rental_distance'
	                    ],*/
                        [
                            'label' => __( 'Rental information', 'traveler' ),
                            'id'    => 'detail_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __( 'Set rental as feature', 'traveler' ),
                            'id'    => 'is_featured',
                            'type'  => 'on-off',
                            'desc'  => __( 'Will show this rental with feature label or not', 'traveler' ),
                            'std'   => 'off'
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
                                    'value' => 'instant'
                                ],
                                [
                                    'label' => __( 'Enquire Booking', 'traveler' ),
                                    'value' => 'enquire'
                                ],
                                [
                                    'label' => __( 'Instant & Enquire Booking', 'traveler' ),
                                    'value' => 'instant_enquire'
                                ],
                            ],
                            'std'     => 'instant',
                        ],

                        [
                            'id'    => 'rental_number',
                            'label' => __( 'Numbers', 'traveler' ),
                            'desc'  => __( 'Number of rental available for booking', 'traveler' ),
                            'type'  => 'text',
                            'std'   => '1'
                        ],
                        [
                            'id'           => 'rental_max_adult',
                            'label'        => __( 'Max adults', 'traveler' ),
                            'desc'         => __( 'Max adults', 'traveler' ),
                            'type'         => 'numeric-slider',
                            'min_max_step' => '1,100,1',
                            'std'          => 1
                        ],
                        [
                            'id'           => 'rental_max_children',
                            'label'        => __( 'Max children', 'traveler' ),
                            'desc'         => __( 'Max children', 'traveler' ),
                            'type'         => 'numeric-slider',
                            'min_max_step' => '0,100,1',
                            'std'          => 1
                        ],
                        [
                            'id'           => 'rental_bed',
                            'label'        => __( 'No. Bed', 'traveler' ),
                            'desc'         => __( 'Bed Number', 'traveler' ),
                            'type'         => 'text',
                            'std'          => 1
                        ],
                        [
                            'id'           => 'rental_bath',
                            'label'        => __( 'No. Bath', 'traveler' ),
                            'desc'         => __( 'Bath Number', 'traveler' ),
                            'type'         => 'text',
                            'std'          => 1
                        ],
                        [
                            'id'           => 'rental_size',
                            'label'        => __( 'Size', 'traveler' ),
                            'desc'         => __( 'Room Size', 'traveler' ),
                            'type'         => 'text',
                            'std'          => ''
                        ],
                        [
                            'label'     => __( 'Rental single layout', 'traveler' ),
                            'id'        => 'rental_single_layout_v2',
                            'post_type' => 'st_layouts',
                            'type'      =>'radio-image',
                            'class' => 'custom-radio-image',
                            'choices'   => $layout_single,
                            'desc'      => __( 'Select the layout for display one single rental', 'traveler' )
                        ],

                        [
                            'label' => __( 'Rental gallery', 'traveler' ),
                            'id'    => 'gallery',
                            'type'  => 'gallery',
                            'desc'  => __( 'Upload room images to show to customers', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Rental video', 'traveler' ),
                            'id'    => 'video',
                            'type'  => 'text',
                            'desc'  => __( 'Input youtube/vimeo url here', 'traveler' ),
                        ],
                        [
                            'label'=>esc_html__('Disable "Adult Name Required"','traveler'),
                            'type'=>'on-off',
                            'std'=>'on',
                            'id'=>'disable_adult_name'
                        ],
                        [
                            'label'=>esc_html__('Disable "Children Name Required"','traveler'),
                            'type'=>'on-off',
                            'std'=>'on',
                            'id'=>'disable_children_name'
                        ],

                        [
                            'label' => __( 'Contact information', 'traveler' ),
                            'id'    => 'agent_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label'   => __( 'Select contact info will show', 'traveler' ),
                            'id'      => 'show_agent_contact_info',
                            'type'    => 'select',
                            'choices' => [

                                [
                                    'label' => __( "----Select----", 'traveler' ),
                                    'value' => ''
                                ],
                                [
                                    'label' => __( "Use agent contact info", 'traveler' ),
                                    'value' => 'user_agent_info'
                                ],
                                [
                                    'label' => __( "Use item info", 'traveler' ),
                                    'value' => 'user_item_info'
                                ],
                            ],
                            'desc'    => __( 'Use info configuration in theme option || Use contact info of people who upload hotel || Use contact info in hotel detail', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Agent email', 'traveler' ),
                            'id'    => 'agent_email',
                            'type'  => 'text',
                            'desc'  => __( 'Agent email. This email will receive emails notifying new booking', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Agent website', 'traveler' ),
                            'id'    => 'agent_website',
                            'type'  => 'text',
                            'desc'  => __( 'Agent website', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Agent phone', 'traveler' ),
                            'id'    => 'agent_phone',
                            'type'  => 'text',
                            'desc'  => __( 'Agent phone', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Agent fax number', 'traveler' ),
                            'id'    => 'st_fax',
                            'type'  => 'text',
                            'desc'  => __( 'Agent fax number', 'traveler' ),
                        ]

                        , [
                            'label' => __( 'Rental price', 'traveler' ),
                            'id'    => 'price_tab',
                            'type'  => 'tab'
                        ]
                        , [
                            'label' => sprintf( __( 'Pricing (%s)', 'traveler' ), TravelHelper::get_default_currency( 'symbol' ) ),
                            'id'    => 'price',
                            'type'  => 'text',
                            'desc'  => __( 'Regular price', 'traveler' )
                        ],
                        [
                            'label'    => __( 'Discount by number of days', 'traveler' ),
                            'type'     => 'list-item',
                            'id'       => 'discount_by_day',
                            'settings' => [
                                [
                                    'id'    => 'number_day',
                                    'label' => __( 'From No. days', 'traveler' ),
                                    'type'  => 'text',
                                    'desc'  => __( 'Enter From No. days will be discounted', 'traveler' )
                                ],
                                [
                                    'id' => 'number_day_to',
                                    'label' => __('To No. days', 'traveler'),
                                    'type' => 'text',
                                    'desc' => __('Enter To No. days will be discounted', 'traveler')
                                ],
                                [
                                    'id'    => 'discount',
                                    'label' => __( 'Discount', 'traveler' ),
                                    'type'  => 'text',
                                    'desc'  => 'Input 0 < number < 100 if discount by percent </br>
                                    Input number < base price if discount by amount'
                                ]
                            ]
                        ],
                        [
                            'label'   => __( 'Discount type for number of days', 'traveler' ),
                            'id'      => 'discount_type_no_day',
                            'type'    => 'select',
                            'choices' => [
                                [
                                    'label' => __( 'Percent (%)', 'traveler' ),
                                    'value' => 'percent'
                                ],
                                [
                                    'label' => __( 'Amount', 'traveler' ),
                                    'value' => 'fixed'
                                ]
                            ],
                            'std'     => 'percent',
                            'desc'    => __( 'This only use for discount by number of days. Caculation by: fixed or %', 'traveler' )
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
                                    'label' => __( 'Name of item', 'traveler' ),
                                ],
                                [
                                    'id'    => 'extra_max_number',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Max of number', 'traveler' ),
                                ],
                                [
                                    'id'    => 'extra_price',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Price', 'traveler' ),
                                    'desc'  => __( 'per 1 item', 'traveler' ),
                                ],
                                [
                                    'id'    => 'extra_required',
                                    'type'  => 'on-off',
                                    'std'   => 'off',
                                    'label' => __( 'Required Extra', 'traveler' ),
                                    'desc'  => __( '', 'traveler' ),
                                ]
                            ]

                        ],

                        [
                            'label'   => __( 'Extra pricing unit', 'traveler' ),
                            'type'    => 'select',
                            'id'      => 'extra_price_unit',
                            'choices' => [
                                [
                                    'label' => __( 'per Day', 'traveler' ),
                                    'value' => 'perday'
                                ],
                                [
                                    'label' => __( 'Fixed', 'traveler' ),
                                    'value' => 'fixed'
                                ],
                            ]
                        ],
                        [
                            'label'   => __( 'Discount type', 'traveler' ),
                            'id'      => 'discount_type',
                            'type'    => 'select',
                            'choices' => [
                                [
                                    'label' => __( 'Percent (%)', 'traveler' ),
                                    'value' => 'percent'
                                ],
                                [
                                    'label' => __( 'Amount', 'traveler' ),
                                    'value' => 'amount'
                                ]
                            ],
                            'std'     => 'percent',
                            'desc'    => __( 'This  use for discount . Caculation by:fixed or % ', 'traveler' )
                        ],
                        [
                            'label' => __( 'Discount rating', 'traveler' ),
                            'id'    => 'discount_rate',
                            'type'  => 'text',
                            'desc'  => __( 'Discount rate by %', 'traveler' )
                        ]
                        ,
                        [
                            'label' => __( 'Sale schedule', 'traveler' ),
                            'id'    => 'is_sale_schedule',
                            'type'  => 'on-off',
                            'std'   => 'off',
                        ],
                        [
                            'label'     => __( 'Sale price date from', 'traveler' ),
                            'desc'      => __( 'Sale price date from', 'traveler' ),
                            'id'        => 'sale_price_from',
                            'type'      => 'date-picker',
                            'condition' => 'is_sale_schedule:is(on)'
                        ],

                        [
                            'label'     => __( 'Sale price date to', 'traveler' ),
                            'desc'      => __( 'Sale price date to', 'traveler' ),
                            'id'        => 'sale_price_to',
                            'type'      => 'date-picker',
                            'condition' => 'is_sale_schedule:is(on)'
                        ],
                        [
                            'id'      => 'deposit_payment_status',
                            'label'   => __( "Deposit options", 'traveler' ),
                            'desc'    => __( 'You can select <code>Disallow Deposit</code>, <code>Deposit by percent</code>' ),
                            'type'    => 'select',
                            'choices' => [
                                [
                                    'value' => '',
                                    'label' => __( 'Disallow deposit', 'traveler' )
                                ],
                                [
                                    'value' => 'percent',
                                    'label' => __( 'Deposit by percent', 'traveler' )
                                ],
                                /*[
                                    'value' => 'amount',
                                    'label' => __( 'Deposit by amount', 'traveler' )
                                ],*/
                            ]
                        ],
                        [
                            'label'     => __( 'Deposit percent', 'traveler' ),
                            'desc'      => __( 'Leave empty for disallow deposit payment', 'traveler' ),
                            'id'        => 'deposit_payment_amount',
                            'type'      => 'text',
                            'condition' => 'deposit_payment_status:not()'
                        ],

                        [
                            'label' => __( 'Availability', 'traveler' ),
                            'id'    => 'availability_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __( 'Rental calendar', 'traveler' ),
                            'id'    => 'st_rental_calendar',
                            'type'  => 'st_rental_calendar'
                        ],
                        [
                            'label' => __( 'Rental options', 'traveler' ),
                            'id'    => 'rental_options',
                            'type'  => 'tab'
                        ],
                        [
                            'label'        => __( 'Book before number of day', 'traveler' ),
                            'id'           => 'rentals_booking_period',
                            'type'         => 'numeric-slider',
                            'min_max_step' => '0,30,1',
                            'std'          => 0,
                            'desc'         => __( 'Input number of day can book before from check in date', 'traveler' ),
                        ],
                        [
                            'label'        => __( 'Minimum stay', 'traveler' ),
                            'id'           => 'rentals_booking_min_day',
                            'type'         => 'numeric-slider',
                            'min_max_step' => '0,180,1',
                            'std'          => 0,
                            'desc'         => __( 'Minimum stay in this rental', 'traveler' ),
                        ],
                        [
                            'label' => __( 'Allow external booking', 'traveler' ),
                            'id'    => 'st_rental_external_booking',
                            'type'  => 'on-off',
                            'std'   => "off",
                        ],
                        [
                            'label'     => __( 'Rental external booking link', 'traveler' ),
                            'id'        => 'st_rental_external_booking_link',
                            'type'      => 'text',
                            'std'       => "",
                            'condition' => 'st_rental_external_booking:is(on)',
                            'desc'      => "<em>" . __( 'Notice: Must be http://...', 'traveler' ) . "</em>",
                        ],
	                    [
		                    'label' => __( 'Allow rental groupday', 'traveler' ),
		                    'id'    => 'allow_group_day',
		                    'type'  => 'on-off',
		                    'std'   => 'off'
	                    ],
                        [
                            'label' => __( 'Cancel booking', 'traveler' ),
                            'id'    => 'st_cancel_booking_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __( 'Allow cancellation', 'traveler' ),
                            'id'    => 'st_allow_cancel',
                            'type'  => 'on-off',
                            'std'   => 'off'
                        ],
                        [
                            'label'     => __( 'Number of days before the arrival', 'traveler' ),
                            'desc'      => __( 'Number of days before the arrival', 'traveler' ),
                            'id'        => 'st_cancel_number_days',
                            'type'      => 'text',
                            'condition' => 'st_allow_cancel:is(on)'
                        ],
                        [
                            'label'        => __( 'Cancellation Fee', 'traveler' ),
                            'desc'         => __( 'A percentage of money customers will be deducted if they cancel a reservation', 'traveler' ),
                            'id'           => 'st_cancel_percent',
                            'type'         => 'numeric-slider',
                            'min_max_step' => '0,100,1',
                            'condition'    => 'st_allow_cancel:is(on)'
                        ],
                        [
                            'label' => __( 'Ical Sysc', 'traveler' ),
                            'id'    => 'ical_sys_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __('Ical URL', 'traveler'),
                            'id' => 'ical_url',
                            'type' => 'ical',
                            'desc' => __('Enter an ical url and click Import button. All data will be updated and shown in the Availability tab', 'traveler')
                        ]
                    ]
                ];
                $data_paypment   = STPaymentGateways::get_payment_gateways();
                if ( !empty( $data_paypment ) and is_array( $data_paypment ) ) {
                    $this->metabox[ 0 ][ 'fields' ][] = [
                        'label' => __( 'Payment', 'traveler' ),
                        'id'    => 'payment_detail_tab',
                        'type'  => 'tab'
                    ];
                    foreach ( $data_paypment as $k => $v ) {
                        $this->metabox[ 0 ][ 'fields' ][] = [
                            'label' => $v->get_name(),
                            'id'    => 'is_meta_payment_gateway_' . $k,
                            'type'  => 'on-off',
                            'desc'  => $v->get_name(),
                            'std'   => 'on'
                        ];
                    }
                }
                $custom_field = self::get_custom_fields();
                if ( !empty( $custom_field ) and is_array( $custom_field ) ) {
                    $this->metabox[ 0 ][ 'fields' ][] = [
                        'label' => __( 'Custom fields', 'traveler' ),
                        'id'    => 'custom_field_tab',
                        'type'  => 'tab'
                    ];
                    foreach ( $custom_field as $k => $v ) {
                        $key                              = str_ireplace( '-', '_', 'st_custom_' . sanitize_title( $v[ 'title' ] ) );
                        $this->metabox[ 0 ][ 'fields' ][] = [
                            'label' => $v[ 'title' ],
                            'id'    => $key,
                            'type'  => $v[ 'type_field' ],
                            'desc'  => '<input value=\'[st_custom_meta key="' . $key . '"]\' type=text readonly />',
                            'std'   => $v[ 'default_field' ]
                        ];
                    }
                }

                parent::register_metabox( $this->metabox );

            }

            /**
             *
             * @since 1.0.9
             * */
            static function get_custom_fields()
            {
                return st()->get_option( 'rental_unlimited_custom_field', [] );
            }

            function add_col_header( $defaults )
            {
                $this->array_splice_assoc( $defaults, 2, 0, [ 'layout_id' => __( 'Layout', 'traveler' ) ] );

                return $defaults;
            }

            function add_col_content( $column_name, $post_ID )
            {
                if ( $column_name == 'layout_id' ) {
                    // show content of 'directors_name' column
                    $parent = get_post_meta( $post_ID, 'custom_layout', true );

                    if ( $parent ) {
                        echo "<a href='" . get_edit_post_link( $parent ) . "' target='_blank'>" . get_the_title( $parent ) . "</a>";
                    } else {
                        $layout = st()->get_option( 'rental_single_layout' );
                        if ( $layout ) {
                            echo "<a href='" . get_edit_post_link( $layout ) . "' target='_blank'>" . get_the_title( $layout ) . "</a>";
                        } else {

                        }
                    }

                }
            }

            function meta_update_sale_price( $post_id )
            {
                if ( wp_is_post_revision( $post_id ) )
                    return;
                $post_type = get_post_type( $post_id );
                if ( $post_type == 'st_rental' ) {
                    $sale_price       = get_post_meta( $post_id, 'price', true );
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
                        $sale_price = $sale_price - ( $sale_price / 100 ) * $discount;
                    }
                    update_post_meta( $post_id, 'sale_price', $sale_price );
                }
            }

            function _resend_mail()
            {
                $order_item = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : false;

                $test = isset( $_GET[ 'test' ] ) ? $_GET[ 'test' ] : false;
                if ( $order_item ) {

                    $order = $order_item;

                    if ( $test ) {
                        global $order_id;
                        $order_id       = $order_item;
                        $id_page_email_for_admin = st()->get_option('email_for_admin', '');
                        $content = !empty(get_post($id_page_email_for_admin)) ? wp_kses_post(get_post($id_page_email_for_admin)->post_content) : "";
                        $email          = "";
                        $email .= TravelHelper::_get_template_email($email, $content);
                        echo( $email );
                        die;
                    }

                    if ( $order ) {
                        $check = STCart::send_mail_after_booking( $order );
                    }
                }

                wp_safe_redirect( self::$booking_page . '&send_mail=success' );
            }

            static function st_room_select_ajax()
            {
                extract( wp_parse_args( $_GET, [
                    'post_type' => '',
                    'q'         => ''
                ] ) );


                query_posts( [ 'post_type' => $post_type, 'posts_per_page' => 10, 's' => $q ] );

                $r = [
                    'items' => [],
                    't'     => [ 'post_type' => $post_type, 'posts_per_page' => 10, 's' => $q ]
                ];
                while ( have_posts() ) {
                    the_post();
                    $r[ 'items' ][] = [
                        'id'          => get_the_ID(),
                        'name'        => get_the_title(),
                        'description' => ''
                    ];
                }

                wp_reset_query();

                echo json_encode( $r );
                die;

            }

            static function add_edit_scripts()
            {
                wp_enqueue_script( 'admin-rental-booking', get_template_directory_uri() . '/js/admin/rental-booking.js', [ 'jquery', 'jquery-ui-datepicker' ], null, true );
                wp_enqueue_style( 'jjquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css' );
            }

            static function is_booking_page()
            {
                if ( is_admin()
                    and isset( $_GET[ 'post_type' ] )
                    and $_GET[ 'post_type' ] == 'st_rental'
                    and isset( $_GET[ 'page' ] )
                    and $_GET[ 'page' ] = 'st_rental_booking'
                ) return true;

                return false;
            }

            function new_menu_page()
            {
                //Add booking page
                add_submenu_page( 'edit.php?post_type=st_rental', __( 'Rental Booking', 'traveler' ), __( 'Rental Booking', 'traveler' ), 'manage_options', 'st_rental_booking', [ $this, '__rental_booking_page' ] );
            }

            function __rental_booking_page()
            {

                $section = isset( $_GET[ 'section' ] ) ? $_GET[ 'section' ] : false;

                if ( $section ) {
                    switch ( $section ) {
                        case "edit_order_item":
                            $this->edit_order_item();
                            break;
                    }
                } else {

                    $action = isset( $_POST[ 'st_action' ] ) ? $_POST[ 'st_action' ] : false;
                    switch ( $action ) {
                        case "delete":
                            $this->_delete_items();
                            break;
                    }
                    echo balanceTags( $this->load_view( 'rental/booking_index', false ) );
                }

            }

            function add_booking()
            {

                echo balanceTags( $this->load_view( 'rental/booking_edit', false, [ 'page_title' => __( 'Add new Rental Booking', 'traveler' ) ] ) );
            }

            function _delete_items()
            {

                if ( empty( $_POST ) or !check_admin_referer( 'shb_action', 'shb_field' ) ) {
                    //// process form data, e.g. update fields
                    return;
                }
                $ids = isset( $_POST[ 'post' ] ) ? $_POST[ 'post' ] : [];
                if ( !empty( $ids ) ) {
                    foreach ( $ids as $id )
                    {
                        wp_delete_post( $id, true );
                        do_action('st_admin_delete_booking',$id);
                    }


                }

                STAdmin::set_message( __( "Delete item(s) success", 'traveler' ), 'updated' );

            }

            function edit_order_item()
            {
                $item_id = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : false;
                if ( !$item_id or get_post_type( $item_id ) != 'st_order' ) {
                    return false;
                }


                // if ( isset( $_POST[ 'submit' ] ) and $_POST[ 'submit' ] ) $this->_save_booking( $item_id );

                echo balanceTags( $this->load_view( 'rental/booking_edit' ) );
            }

            function _save_booking( $order_id )
            {
                //Update availability rental
                    
                if(!empty(st_get_order_by_order_item_id($order_id))){
                    global $wpdb;
                    $check_in_timestamp = st_get_order_by_order_item_id($order_id)['check_in_timestamp'];
                    $check_out_timestamp = st_get_order_by_order_item_id($order_id)['check_out_timestamp'];
                    $status_order = st_get_order_by_order_item_id($order_id)['status'];
                    $post_id = st_get_order_by_order_item_id($order_id)['st_booking_id'];
                    $table_st_rental_avai = $wpdb->prefix . 'st_rental_availability';
                    $booked = 0;
                    if($status_order == 'complete' && $_POST[ 'status' ] != 'complete'){
                        $booked = (-1);
                        $sql = $wpdb->prepare("UPDATE {$table_st_rental_avai} SET number_booked = IFNULL(number_booked, 0) + %d WHERE post_id = %d AND check_in >= %d AND check_out <= %d", $booked, $post_id, $check_in_timestamp , $check_out_timestamp);
                        $wpdb->query($sql);
                    } elseif ($status_order != 'complete' && $_POST[ 'status' ] == 'complete') {
                        $booked = 1;
                        $sql = $wpdb->prepare("UPDATE {$table_st_rental_avai} SET number_booked = IFNULL(number_booked, 0) + %d WHERE post_id = %d AND check_in >= %d AND check_out <= %d", $booked, $post_id, $check_in_timestamp , $check_out_timestamp);
                        $wpdb->query($sql);
                    }
                    
                    
                    
                }
                if ( !check_admin_referer( 'shb_action', 'shb_field' ) ) die;
                if ( $this->_check_validate() ) {

                    $check_out_field = STCart::get_checkout_fields();

                    if ( !empty( $check_out_field ) ) {
                        foreach ( $check_out_field as $field_name => $field_desc ) {
                            if($field_name != 'st_note'){
                                update_post_meta( $order_id, $field_name, STInput::post( $field_name ) );
                            }
                        }
                    }

                    $item_data = [
                        'status' => $_POST[ 'status' ]

                    ];
                    foreach ( $item_data as $val => $value ) {
                        update_post_meta( $order_id, $val, $value );
                    }

                    if ( TravelHelper::checkTableDuplicate( 'st_rental' ) ) {
                        global $wpdb;

                        $table = $wpdb->prefix . 'st_order_item_meta';
                        $where = [
                            'order_item_id' => $order_id,
                            
                        ];
                        $data  = [
                            'status' => $_POST[ 'status' ],
                            'cancel_refund_status' => 'complete'
                        ];
                        $wpdb->update( $table, $data, $where );
                    }

                    STCart::send_mail_after_booking( $order_id, true );


                    do_action('st_admin_edit_booking_status',$item_data['status'],$order_id);
                    

                    wp_safe_redirect( self::$booking_page );
                }

            }

            public function _check_validate()
            {

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

            function is_able_edit()
            {
                $item_id = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : false;
                if ( !$item_id or get_post_type( $item_id ) != 'st_order' ) {
                    wp_safe_redirect( self::$booking_page );
                    die;
                }

                return true;
            }

            static function getRentalInfo()
            {
                $rental_id = intval( STInput::request( 'rental_id', '' ) );
                $data      = [
                    'price'      => '',
                    'extras'     => 'None',
                    'adult_html' => '',
                    'child_html' => ''
                ];
                if ( $rental_id <= 0 || get_post_type( $rental_id ) != 'st_rental' ) {
                    echo json_encode( $data );
                } else {
                    $adult_number = intval( get_post_meta( $rental_id, 'rental_max_adult', true ) );
                    if ( $adult_number <= 0 ) $adult_number = 1;
                    $adult_html = '<select name="adult_number" class="form-control" style="width: 100px;">';
                    for ( $i = 1; $i <= $adult_number; $i++ ) {
                        $adult_html .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                    $adult_html .= '</select>';

                    $child_number = intval( get_post_meta( $rental_id, 'rental_max_children', true ) );
                    if ( $child_number <= 0 ) $child_number = 0;
                    $child_html = '<select name="child_number" class="form-control" style="width: 100px;">';
                    for ( $i = 0; $i <= $child_number; $i++ ) {
                        $child_html .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                    $child_html .= '</select>';

                    $html   = '';
                    $price  = floatval( get_post_meta( $rental_id, 'price', true ) );
                    $extras = get_post_meta( $rental_id, 'extra_price', true );
                    if ( is_array( $extras ) && count( $extras ) ):
                        $html = '<table class="table">';
                        foreach ( $extras as $key => $val ):
                            $html .= '
                    <tr>
                        <td width="80%">
                            <label for="' . $val[ 'extra_name' ] . '" class="ml20">' . $val[ 'title' ] . ' (' . TravelHelper::format_money( $val[ 'extra_price' ] ) . ')' . '</label>
                            <input type="hidden" name="extra_price[price][' . $val[ 'extra_name' ] . ']" value="' . $val[ 'extra_price' ] . '">
                            <input type="hidden" name="extra_price[title][' . $val[ 'extra_name' ] . ']" value="' . $val[ 'title' ] . '">
                        </td>
                        <td width="20%">
                            <select style="width: 100px" class="form-control" name="extra_price[value][' . $val[ 'extra_name' ] . ']" id="">';
                            $max_item = intval( $val[ 'extra_max_number' ] );
                            if ( $max_item <= 0 ) $max_item = 1;
                            for ( $i = 0; $i <= $max_item; $i++ ):
                                $html .= '<option value="' . $i . '">' . $i . '</option>';
                            endfor;
                            $html .= '
                            </select>
                        </td>
                    </tr>';
                        endforeach;
                        $html .= '</table>';
                    endif;
                    $disable_adult_name = get_post_meta($rental_id, 'disable_adult_name', true);
                    $disable_children_name = get_post_meta($rental_id, 'disable_children_name', true);

                    if($disable_adult_name == 'off' || $disable_children_name == "off" ){
                        $html_required_name .= '
                        <div class="guest_name_input d-none"
                            data-placeholder="'.esc_html__('Guest %d name', 'traveler').'"
                            data-hide-adult="'.get_post_meta($rental_id, 'disable_adult_name', true).'"
                            data-hide-children="'.get_post_meta($rental_id, 'disable_children_name', true).'"
                            >
                            <label><span>'.esc_html__('Guest Name', 'traveler').'</span> <span class="required">*</span></label>
                            <div class="guest_name_control">
                                
                            </div>
                            <script type="text/html" id="guest_name_control_item">
                                <div class="control-item mb10">
                                    <select name="guest_title[]" class="form-control">
                                    <option value="mr">'.esc_html__('Mr', 'traveler').'</option>
                                    <option value="miss">'.esc_html__('Miss', 'traveler').'</option>
                                    <option value="mrs">'.esc_html__('Mrs', 'traveler').'</option>
                                    </select>
                                    <input class="form-control " placeholder="" name="guest_name[]" value="">
                                </div>
                            </script>
                        </div>
                        ';
                    }
                    $data[ 'price' ]      = TravelHelper::format_money_from_db( $price, false );
                    $data[ 'extras' ]     = $html;
                    $data[ 'adult_html' ] = $adult_html;
                    $data[ 'child_html' ] = $child_html;
                    $data['required_name_html'] = $html_required_name;
                    echo json_encode( $data );
                }
                die();
            }
            public static function __cronjob_update_min_price($offset, $limit = 2) {
                global $wpdb;
                $list_rental = new WP_Query(array(
                    'posts_per_page' => $limit,
                    'post_type' => 'st_rental',
                    'offset' => $offset
                ));
    
                if ($list_rental->have_posts()) {
                    while ($list_rental->have_posts()) {
                        $list_rental->the_post();
                        $rental_id = get_the_ID();
                        STAdminRental::_update_min_price($rental_id, []);
                        STAdminRental::_update_duplicate_data($rental_id, []);
                    }
                }
    
                wp_reset_postdata();
            }

            static function inst()
            {
                if(!self::$_inst)
                {
                    self::$_inst=new self();
                }
                return self::$_inst;
            }

        }

        STAdminRental::inst();
    }

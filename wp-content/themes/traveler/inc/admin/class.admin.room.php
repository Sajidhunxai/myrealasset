<?php
    /**
     * @package    WordPress
     * @subpackage Traveler
     * @since      1.0
     *
     * Class STAdminRoom
     *
     * Created by ShineTheme
     *
     */
    if ( !class_exists( 'STAdminRoom' ) ) {

        class STAdminRoom extends STAdmin
        {
            protected static    $_inst;
            static    $_table_version = "1.3.6";
            static    $booking_page;
            protected $post_type      = 'hotel_room';

            /**
             *
             *
             * @update 1.1.3
             * */
            function __construct()
            {
                if ( !st_check_service_available( $this->post_type ) ) return;

                add_filter( 'st_hotel_room_layout', [ $this, 'custom_hotel_room_layout' ] );

                add_action( 'current_screen', [ $this, 'init_metabox' ] );

                self::$booking_page = admin_url( 'edit.php?post_type=hotel_room&page=st_hotel_room_booking' );

                //alter where for search room
                add_filter( 'posts_where', [ __CLASS__, '_alter_search_query' ] );


                //Hotel Hook
                /*
                 * todo Re-cal hotel min price
                 * */
                add_action( 'update_post_meta', [ $this, 'hotel_update_min_price' ], 10, 4 );
                add_action( 'updated_post_meta', [ $this, 'meta_updated_update_min_price' ], 10, 4 );
                add_action( 'added_post_meta', [ $this, 'hotel_update_min_price' ], 10, 4 );
                add_action( 'save_post', [ $this, '_update_avg_price' ], 50 );
                add_action( 'save_post', [ $this, '_update_min_price' ], 50 );
                add_action( 'save_post', [ $this, '_update_duplicate_data' ], 51, 2 );
                add_action('before_delete_post', [$this, '_update_min_price'], 50);

                add_action( 'save_post', [ $this, '_update_list_location' ], 999999, 2 );


                /**
                 *   since 1.2.6
                 *   auto create & update table st_hotel
                 **/
                add_action( 'after_setup_theme', [ __CLASS__, '_check_table_hotel_room' ] );


                add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
                //Check booking edit and redirect
                if ( self::is_booking_page() ) {
                    add_action( 'admin_enqueue_scripts', [ __CLASS__, 'add_edit_scripts' ] );
                    add_action( 'admin_init', [ $this, '_do_save_booking' ] );
                }
                //parent::__construct();

                /**
                 * @since 1.2.8
                 **/
                add_action( 'restrict_manage_posts', [ $this, 'restrict_manage_posts_hotel_room' ] );
                add_action( 'parse_query', [ $this, 'parse_query_hotel_room' ] );

                /**
                 * @since 1.3.0
                 *        Bulk calendar
                 **/
                add_action( 'traveler_after_form_hotel_calendar', [ $this, 'custom_traveler_after_form_hotel_calendar' ] );
                add_action( 'traveler_after_form_submit_hotel_calendar', [ $this, 'custom_traveler_after_form_submit_hotel_calendar' ] );


                add_action('init',array($this,'__register_cronjob'),1);
                add_action('st_availability_cronjob',array($this,'__cronjob_fill_availability'));

                add_filter( 'st_change_column_st_hotel_room', [ $this, 'st_change_column_st_hotel_room_fnc' ] );

                add_action('admin_init', [$this, '_upgradeRoomTable135']);

            }

            public function _upgradeRoomTable135()
            {
                $updated = get_option('_upgradeRoomTable135', false);
                if (!$updated) {
                    global $wpdb;
                    $table = $wpdb->prefix . $this->post_type;
                    $sql = "Update {$table} as t inner join {$wpdb->posts} as m on (t.post_id = m.ID and m.post_type='hotel_room') set t.`status` = m.post_status";
                    $wpdb->query($sql);
                    update_option('_upgradeRoomTable135', 'updated');
                }
            }

            public function __run_fill_old_order($key='')
            {
                $ids = [];
               global $wpdb;
                $table  = $wpdb->prefix . 'st_availability';
                $model=ST_Order_Item_Model::inst();
                $orderItems=$model->where("st_booking_post_type in ('st_hotel','hotel_room')",false,true)
                                  ->where("STATUS NOT IN('canceled','trash')",false,true)->get()->result();
                if(!empty($orderItems))
                {

                    foreach($orderItems as $data)
                    {
                        if (!empty($data['room_origin']))
                        {
                            if(in_array($data['id'],$ids)) continue;
                            $ids[]=$data['id'];
                            $booked =  !empty($data['room_num_search'])?intval($data['room_num_search']):1;

                            $sql = $wpdb->prepare("UPDATE {$table} SET number_booked = IFNULL(number_booked, 0) + %d WHERE post_id = %d AND check_in = %s",$booked,$data['room_origin'],$data['check_in_timestamp']);
                            $wpdb->query( $sql );
                            // Check allowed to set Number End
                            if(get_post_meta($data['st_booking_id'],'allow_full_day',true)!='off'){
                                $sql = $wpdb->prepare("UPDATE {$table} SET number_end = IFNULL(number_end, 0) + %d WHERE post_id = %d AND check_in = %s",$booked,$data['room_origin'],$data['check_out_timestamp']);
                                $wpdb->query( $sql );
                            }

                        }
                    }
                }
            }

            public function __cronjob_fill_availability($offset=0, $limit=-1, $day=null)
            {
                global $wpdb;
                if(!$day){
                    $today=new DateTime(date('Y-m-d'));
                    $today->modify('+ 6 months');
                    $day=$today->modify('+ 1 day');
                }

                $table='st_room_availability';

                $rooms=new WP_Query(array(
                    'posts_per_page'=>$limit,
                    'post_type'=>'hotel_room',
                    'offset' => $offset
                ));
                $insertBatch=[];
                $ids=[];

                while ($rooms->have_posts())
                {
                    $rooms->the_post();
                    $price=get_post_meta(get_the_ID(),'price',true);
                    $parent=get_post_meta(get_the_ID(),'room_parent',true);
                    $status=get_post_meta(get_the_ID(),'default_state',true);
                    $number=get_post_meta(get_the_ID(),'number_room',true);
                    $allow_full_day=get_post_meta(get_the_ID(),'allow_full_day',true);
                    $adult_number = intval( get_post_meta( get_the_ID(), 'adult_number', true ) );
                    $child_number = intval( get_post_meta( get_the_ID(), 'children_number', true ) );
                    $booking_period = intval(get_post_meta($parent, 'hotel_booking_period', true));
                    if(empty($booking_period)) $booking_period = 0;
                    if(!$allow_full_day) $allow_full_day='on';
                    $adult_price = get_post_meta( get_the_ID(), 'adult_price', true );
                    $child_price = get_post_meta( get_the_ID(), 'child_price', true );

                    $insertBatch[]=$wpdb->prepare("(%d,%d,%d,%d,%s,%d,%s,%d,%s,%d,%d,%d,%d,%d,%d)",$day->getTimestamp(),$day->getTimestamp(),get_the_ID(),$parent,'hotel_room',$number,$status,$price,$allow_full_day,$adult_number,$child_number,1,$booking_period, $adult_price, $child_price);

                    $ids[]=get_the_ID();
                }

                if(!empty($insertBatch))
                {
                    $wpdb->query("INSERT IGNORE INTO {$wpdb->prefix}{$table} (check_in,check_out,post_id,parent_id,post_type,`number`,`status`,price,	allow_full_day,adult_number,child_number,is_base,booking_period, adult_price, child_price) VALUES ".implode(",\r\n",$insertBatch));

                    // add log
                    //ST_Cronjob_Log_Model::inst()->log('room_fill_availability_'.$day->format('Y_m_d'),json_encode($ids));
                }

                wp_reset_postdata();
            }
            public static function fill_post_availability($post_id,$timestamp=null)
            {
                $data=[];
                global $wpdb;
                $table='st_room_availability';

                $price=get_post_meta($post_id,'price',true);
                $parent=get_post_meta($post_id,'room_parent',true);
                $status=get_post_meta($post_id,'default_state',true);
                $number=get_post_meta($post_id,'number_room',true);
                $allow_full_day=get_post_meta($post_id,'allow_full_day',true);
                if(!$allow_full_day) $allow_full_day='on';
                $rs=ST_Order_Item_Model::inst()
                    ->select('count(room_num_search) as number_booked')
                    ->where('room_origin',$post_id)
                    ->where('check_in_timestamp <=',$timestamp)
                    ->where('check_out_timestamp >=',$timestamp)
                    ->where("STATUS NOT IN ('trash', 'canceled')",false,true)
                    ->get(1)->row();
                $number_end=ST_Order_Item_Model::inst()
                    ->select('count(room_num_search) as number_booked')
                    ->where('room_origin',$post_id)
                    ->where('check_out_timestamp',$timestamp)
                    ->where("STATUS NOT IN ('trash', 'canceled')",false,true)
                    ->get(1)->row();
                $adult_number = intval( get_post_meta( get_the_ID(), 'adult_number', true ) );
                $child_number = intval( get_post_meta( get_the_ID(), 'child_number', true ) );
                $adult_price = get_post_meta( $post_id, 'adult_price', true );
                $child_price = get_post_meta( $post_id, 'child_price', true );

                $data['check_in']=$timestamp;
                $data['check_out']=$timestamp;
                $data['parent_id']=$parent;
                $data['post_type']='hotel_room';
                $data['number']=$number;
                $data['status']=$status;
                $data['price']=$price;
                $data['allow_full_day']=$allow_full_day;
                $data['number_booked']=$rs['number_booked'];
                $data['number_end']=$number_end['number_booked'];
                $data['adult_number']=$adult_number;
                $data['child_number']=$child_number;
                $data['adult_price'] = $adult_price;
                $data['child_price'] = $child_price;

//                $model=ST_Availability_Model::inst();
//
//                $data['id']=$model->insert($data);

                $insert=$wpdb->prepare("(%d,%d,%d,%d,%s,%d,%d,%d,%s,%d,%s,%d,%d,%d,%d)",$timestamp,$timestamp,$post_id,$parent,'hotel_room',$number,$rs['number_booked'],$number_end['number_booked'],$status,$price,$allow_full_day,$adult_number,$child_number, $adult_price, $child_price);

                $wpdb->query("INSERT IGNORE INTO {$wpdb->prefix}{$table} (check_in,check_out,post_id,parent_id,post_type,`number`,number_booked,number_end,`status`,price,allow_full_day,adult_number, child_number, adult_price, child_price) VALUES ".$insert);


                return $data;

            }

            public function __register_cronjob()
            {
                $key='st_availability_cronjob';
                if(!get_option($key))
                {
                    if (! wp_next_scheduled ( $key )) {
                        wp_schedule_event(strtotime('2017-01-01 01:00:00'), 'daily', $key);
                        update_option($key,1);
                    }

                }
            }

            public function custom_traveler_after_form_hotel_calendar()
            {
                echo balanceTags( st()->load_template( 'hotel/hotel-calendar', false ) );
            }

            public function custom_traveler_after_form_submit_hotel_calendar()
            {
                echo '<button type="button" id="calendar-bulk-edit" class="option-tree-ui-button button button-primary button-large btn btn-primary btn-sm" style="float: right;">' . __( 'Bulk Edit', 'traveler' ) . '</button>';
            }

            public function restrict_manage_posts_hotel_room( $post_type )
            {
                if ( $post_type == 'hotel_room' ):
                    global $wp_query;
                    ?>
                    <div class="alignleft actions">
                        <input type="text" class="filter-by-hotel" name="filter_st_hotel"
                               value="<?php echo STInput::request( 'filter_st_hotel', '' ); ?>"
                               placeholder="Filter by hotel name">
                    </div>
                    <?php
                endif;
            }

            public function parse_query_hotel_room( $query )
            {
                global $pagenow;
                if ( isset( $_GET[ 'post_type' ] ) ) {
                    $type = $_GET[ 'post_type' ];
                    if ( 'hotel_room' == $type && is_admin() && $pagenow == 'edit.php' && isset( $_GET[ 'filter_st_hotel' ] ) && $_GET[ 'filter_st_hotel' ] != '' ) {
                        add_filter( 'posts_where', [ $this, 'posts_where_hotel_room' ] );
                        add_filter( 'posts_join', [ $this, 'posts_join_hotel_room' ] );
                    }
                }

            }

            public function posts_where_hotel_room( $where )
            {
                global $wpdb;
                $hotel_name = $_GET[ 'filter_st_hotel' ];
                $where .= " AND mt2.meta_value in (select ID from {$wpdb->prefix}posts where post_title like '%{$hotel_name}%' and post_type = 'st_hotel' and post_status in ('publish', 'private') ) ";

                return $where;
            }

            public function posts_join_hotel_room( $join )
            {
                global $wpdb;
                $join .= " inner join {$wpdb->prefix}postmeta as mt2 on mt2.post_id = {$wpdb->prefix}posts.ID and mt2.meta_key='room_parent' ";

                return $join;
            }

            static function check_ver_working()
            {
                $dbhelper = new DatabaseHelper( self::$_table_version );

                return $dbhelper->check_ver_working( 'st_hotel_room_table_version' );
            }

            static function _check_table_hotel_room()
            {
                $dbhelper = new DatabaseHelper( self::$_table_version );
                $dbhelper->setTableName( 'hotel_room' );
                $column = [
                    'post_id'        => [
                        'type'   => 'INT',
                        'length' => 11,
                    ],
                    'room_parent'    => [
                        'type'   => 'INT',
                        'length' => 11,
                    ],
                    'multi_location' => [
                        'type' => 'text',
                    ],
                    'id_location'    => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'address'        => [
                        'type' => 'text',
                    ],
                    'allow_full_day' => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'price'          => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'number_room'    => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'discount_rate'  => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'adult_number'    => [
	                    'type'   => 'varchar',
	                    'length' => 255
                    ],
                    'child_number'    => [
	                    'type'   => 'varchar',
	                    'length' => 255
                    ],
                    'status' => [
                        'type' => 'varchar',
                        'length' => 20
                    ],
                ];

                $column = apply_filters( 'st_change_column_st_hotel_room', $column );

                $dbhelper->setDefaultColums( $column );
                $dbhelper->check_meta_table_is_working( 'st_hotel_room_table_version' );

                return array_keys( $column );
            }

            /**
             * @since 1.2.6
             **/
            static function is_booking_page()
            {
                if ( is_admin()
                    and isset( $_GET[ 'post_type' ] )
                    and $_GET[ 'post_type' ] == 'hotel_room'
                    and isset( $_GET[ 'page' ] )
                    and $_GET[ 'page' ] = 'st_hotel_room_booking'
                ) return TRUE;

                return FALSE;
            }

            /**
             * @since 1.2.6
             **/
            static function add_edit_scripts()
            {
                wp_enqueue_script( 'st-hotel-edit-booking', get_template_directory_uri() . '/js/admin/hotel-booking.js', [ 'jquery', 'jquery-ui-datepicker' ], NULL, TRUE );
                wp_enqueue_style( 'jjquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css' );
            }

            /**
             * @since 1.2.6
             **/
            function add_menu_page()
            {

                //Add booking page
                add_submenu_page( 'edit.php?post_type=hotel_room', __( 'Room Bookings', 'traveler' ), __( 'Room Bookings', 'traveler' ), 'manage_options', 'st_hotel_room_booking', [ $this, '__hotel_room_booking_page' ] );
            }

            /**
             * @since 1.2.6
             **/
            function __hotel_room_booking_page()
            {

                $section = isset( $_GET[ 'section' ] ) ? $_GET[ 'section' ] : FALSE;

                if ( $section ) {
                    switch ( $section ) {
                        case "edit_order_item":
                            $this->edit_order_item();
                            break;
                    }
                } else {

                    $action = isset( $_POST[ 'st_action' ] ) ? $_POST[ 'st_action' ] : FALSE;
                    switch ( $action ) {
                        case "delete":
                            $this->_delete_items();
                            break;
                    }
                    echo balanceTags( $this->load_view( 'hotel_room/booking_index', FALSE ) );
                }

            }

            /**
             * @since 1.2.6
             **/
            function add_booking()
            {
                echo balanceTags( $this->load_view( 'hotel_room/booking_edit', FALSE, [ 'page_title' => __( 'Add new Hotel Booking', 'traveler' ) ] ) );
            }

            /**
             * @since 1.2.6
             **/
            function _delete_items()
            {

                if ( empty( $_POST ) or !check_admin_referer( 'shb_action', 'shb_field' ) ) {
                    //// process form data, e.g. update fields
                    return;
                }
                $ids = isset( $_POST[ 'post' ] ) ? $_POST[ 'post' ] : [];
                if ( !empty( $ids ) ) {
                    foreach ( $ids as $id )
                        wp_delete_post( $id, TRUE );

                }

                STAdmin::set_message( __( "Delete item(s) success", 'traveler' ), 'updated' );

            }

            /**
             * @since 1.2.6
             **/
            function edit_order_item()
            {
                $item_id = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : FALSE;
                if ( !$item_id or get_post_type( $item_id ) != 'st_order' ) {
                    //wp_safe_redirect(self::$booking_page); die;
                    return FALSE;
                }
                echo balanceTags( $this->load_view( 'hotel_room/booking_edit' ) );
            }

            /**
             * @since 1.2.6
             **/
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
                }
            }

            /**
             * @since 1.2.6
             **/
            function _save_booking( $order_id )
            {
                if ( !check_admin_referer( 'shb_action', 'shb_field' ) ) die;
                if ( $this->_check_validate() ) {

                    $item_data = [
                        'status' => $_POST[ 'status' ],
                    ];

                    foreach ( $item_data as $val => $value ) {
                        update_post_meta( $order_id, $val, $value );
                    }

                    $check_out_field = STCart::get_checkout_fields();

                    if ( !empty( $check_out_field ) ) {
                        foreach ( $check_out_field as $field_name => $field_desc ) {
                            if($field_name != 'st_note'){
                                update_post_meta( $order_id, $field_name, STInput::post( $field_name ) );
                            }
                        }
                    }

                    if ( TravelHelper::checkTableDuplicate( 'hotel_room' ) ) {
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

                    do_action( 'update_booking_hotel_room', $order_id );

                    STCart::send_mail_after_booking( $order_id, true );
                    wp_safe_redirect( self::$booking_page );
                }
            }

            /**
             * @since 1.2.6
             **/
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

                if ( !filter_var( $st_email, FILTER_VALIDATE_EMAIL ) ) {
                    STAdmin::set_message( __( 'Invalid email format.', 'traveler' ), 'danger' );

                    return false;
                }

                $st_phone = STInput::request( 'st_phone', '' );
                if ( empty( $st_phone ) ) {
                    STAdmin::set_message( __( 'The phone field is not empty.', 'traveler' ), 'danger' );

                    return false;
                }

                return true;
            }

            /**
             * @since 1.2.6
             **/
            function _resend_mail()
            {
                $order_item = isset( $_GET[ 'order_item_id' ] ) ? $_GET[ 'order_item_id' ] : FALSE;

                $test = isset( $_GET[ 'test' ] ) ? $_GET[ 'test' ] : FALSE;

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
                        $booking_by    = get_post_meta( $order_item, 'booking_by', true );
                        $made_by_admin = false;
                        if ( $booking_by && $booking_by == 'admin' ) {
                            $made_by_admin = true;
                        }
                        STCart::send_mail_after_booking( $order, $made_by_admin );
                    }
                }

                wp_safe_redirect( self::$booking_page . '&send_mail=success' );
            }


            /**
             * @since 1.2.6
             **/
            public function custom_hotel_room_layout( $old_layout_id = false )
            {

                if ( is_singular( 'hotel_room' ) ) {

                    $meta = get_post_meta( get_the_ID(), 'st_custom_layout', true );
                    if ( $meta ) {
                        return $meta;
                    }
                }

                return $old_layout_id;
            }

            /**
             * @since 1.2.6
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
                    update_post_meta( $id, 'id_location', '' );
                }

            }

            /**
             *
             *
             * @since 1.1.1
             * */
            function init_metabox()
            {
                $screen = get_current_screen();
                if ( $screen->id != 'hotel_room' ) {
                    return false;
                }

                //Room
                $this->metabox[] = [
                    'id'       => 'room_metabox',
                    'title'    => __( 'Room Setting', 'traveler' ),
                    'desc'     => '',
                    'pages'    => [ 'hotel_room' ],
                    'context'  => 'normal',
                    'priority' => 'high',
                    'fields'   => [
                        [
                            'label' => __( 'Location', 'traveler' ),
                            'id'    => 'location_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label'     => __( 'Location', 'traveler' ),
                            'id'        => 'multi_location', // id_location
                            'type'      => 'list_item_post_type',
                            'desc'      => __( 'Enter location of room', 'traveler' ),
                            'post_type' => 'location'
                        ],
                        [
                            'label' => __( 'Room Address', 'traveler' ),
                            'id'    => 'address',
                            'type'  => 'address_autocomplete',
                            'desc'  => __( 'Enter full address of room', 'traveler' ),
                        ],
                        [
                            'label' => __( 'General', 'traveler' ),
                            'id'    => 'room_reneral_tab',
                            'type'  => 'tab'
                        ],

                        [
                            'label'       => __( 'Hotel room', 'traveler' ),
                            'id'          => 'room_parent',
                            'type'        => 'post_select_ajax',
                            'desc'        => __( 'Select a hotel for this type of room', 'traveler' ),
                            'post_type'   => 'st_hotel',
                            'placeholder' => __( 'Search for a Hotel', 'traveler' )
                        ],

                        [
                            'label' => __( 'Number of rooms', 'traveler' ),
                            'id'    => 'number_room',
                            'type'  => 'text',
                            'desc'  => __( 'Number of available rooms for booking', 'traveler' ),
                            'std'   => 1
                        ],

                        /**
                         * version 2.7.7
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

                        /**
                         ** @since 1.1.3
                         **/

                        [
                            'label' => __( 'Gallery', 'traveler' ),
                            'id'    => 'gallery',
                            'type'  => 'gallery',
                            'desc'  => __( 'Upload images to make a gallery image for room', 'traveler' )
                        ],
                        [
                            'label' => __( 'Hotel Alone Room Layout ', 'traveler' ),
                            'id'    => 'hotel_alone_room_layout',
                            'type'  => 'on-off',
                            'std'   => 'off',
                            'desc'  => __( '', 'traveler' )
                        ],
                        [
                            'label'     => __( 'Hotel Room Layout', 'traveler' ),
                            'id'        => 'st_custom_layout',
                            'post_type' => 'st_layouts',
                            'desc'      => __( 'Select a layout to show single room', 'traveler' ),
                            'type'      => 'select',
                            'choices'   => st_get_layout( 'hotel_room' ),
                            'condition' => 'hotel_alone_room_layout:is(off)',
                        ],
                        [
                            'label'     => __( 'Hotel Room Layout', 'traveler' ),
                            'id'        => 'st_custom_layout_hotel_alone_room',
                            'post_type' => 'st_layouts',
                            'desc'      => __( 'Select a layout to show single room', 'traveler' ),
                            'type'      => 'select',
                            'choices'   => st_get_layout( 'hotel_alone_room' ),
                            'condition' => 'hotel_alone_room_layout:is(on)',
                        ],
                        [
                            'label'=>esc_html__('Disable "Adult Name Required"','traveler'),
                            'type'=>'on-off',
                            'std'=>'off',
                            'id'=>'disable_adult_name'
                        ],
                        [
                            'label'=>esc_html__('Disable "Children Name Required"','traveler'),
                            'type'=>'on-off',
                            'std'=>'off',
                            'id'=>'disable_children_name'
                        ],
                        [
                            'label' => __( 'Room price', 'traveler' ),
                            'id'    => 'room_price_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __( 'Price with per person', 'traveler' ),
                            'id'    => 'price_by_per_person',
                            'type'  => 'on-off',
                            'std'   => 'off',
                            'desc'  => __( 'It allows calculate price with per person', 'traveler' )
                        ],
                        [
                            'label' => __( 'Allowed full day booking ', 'traveler' ),
                            'id'    => 'allow_full_day',
                            'type'  => 'on-off',
                            'std'   => 'on',
                            'desc'  => __( 'It allows booking with full day', 'traveler' )
                        ],
                        [
                            'label' => sprintf( __( 'Pricing (%s)', 'traveler' ), TravelHelper::get_default_currency( 'symbol' ) ),
                            'id'    => 'price',
                            'type'  => 'text',
                            'desc'  => __( 'The price of room per one night', 'traveler' ),
                            'condition' => 'price_by_per_person:is(off)'
                        ],
                        [
                            'label' => sprintf( __( 'Adult Pricing (%s)', 'traveler' ), TravelHelper::get_default_currency( 'symbol' ) ),
                            'id'    => 'adult_price',
                            'type'  => 'text',
                            'desc'  => __( 'The price per adult', 'traveler' ),
                            'condition' => 'price_by_per_person:is(on)'
                        ],
                        [
                            'label' => sprintf( __( 'Child Pricing (%s)', 'traveler' ), TravelHelper::get_default_currency( 'symbol' ) ),
                            'id'    => 'child_price',
                            'type'  => 'text',
                            'desc'  => __( 'The price per child', 'traveler' ),
                            'condition' => 'price_by_per_person:is(on)'
                        ],
                        [
                            'label'    => __( 'Discount By No. days', 'traveler' ),
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
                                    'desc'  => __( 'Amount. For example: 50 ', 'traveler' ),
                                ],
                            ]
                        ],
                        [
                            'label'   => __( 'Discount type', 'traveler' ),
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
                            'label'    => __( 'Extra Price', 'traveler' ),
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
                                ]
                            ],
                            'desc'     => __( 'Accompanied service price', 'traveler' ),

                        ],
                        [
                            'label'   => __( 'Extra price unit', 'traveler' ),
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
                            ],
                            'desc'    => __( 'Accompanied service Price Unit', 'traveler' )
                        ],
                        [
                            'label' => __( 'Discount rate (%)', 'traveler' ),
                            'id'    => 'discount_rate',
                            'type'  => 'text',
                            'desc'  => __( 'Discount rate (%)', 'traveler' ),
                        ],

                        [
                            'id'      => 'deposit_payment_status',
                            'label'   => __( "Deposit options", 'traveler' ),
                            'desc'    => __( 'You can select <code>Disallow Deposit</code>, <code>Deposit by percent</code>' ),
                            'type'    => 'select',
                            'choices' => [
                                [
                                    'value' => '',
                                    'label' => __( 'Disallow Deposit', 'traveler' )
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
                            'label'     => __( 'Deposit payment amount', 'traveler' ),
                            'desc'      => __( 'Leave empty for disallow deposit payment', 'traveler' ),
                            'id'        => 'deposit_payment_amount',
                            'type'      => 'text',
                            'condition' => 'deposit_payment_status:not()'
                        ],
                        [
                            'label' => __( 'Room Facility', 'traveler' ),
                            'id'    => 'room_detail_tab',
                            'type'  => 'tab'
                        ],

                        [
                            'label'        => __( 'Number of adults', 'traveler' ),
                            'id'           => 'adult_number',
                            'type'         => 'numeric-slider',
                            'min_max_step' => '1,50,1',
                            'desc'         => __( 'Number of adults in room', 'traveler' ),
                            'std'          => 1
                        ],
                        [
                            'label'        => __( 'Number of children', 'traveler' ),
                            'id'           => 'children_number',
                            'type'         => 'numeric-slider',
                            'min_max_step' => '0,50,1',
                            'desc'         => __( 'Number of children in room', 'traveler' ),
                            'std'          => 0
                        ],
                        [
                            'label' => __( 'Number of beds', 'traveler' ),
                            'id'    => 'bed_number',
                            'type'  => 'text',
                            'desc'  => __( 'Number of Beds in room', 'traveler' ),
                            'std'   => 0
                        ],
                        [
                            'label' => __( 'Room footage ( square meters )', 'traveler' ),
                            'desc'  => __( 'Room footage (square meters)', 'traveler' ),
                            'id'    => 'room_footage',
                            'type'  => 'text',
                        ],
                        [
                            'label' => __( 'Room external booking', 'traveler' ),
                            'id'    => 'st_room_external_booking',
                            'type'  => 'on-off',
                            'std'   => "off",
                            'desc'  => __( 'It allows ON/OFF in booking by an external link', 'traveler' )
                        ],
                        [
                            'label'     => __( 'Room external booking', 'traveler' ),
                            'id'        => 'st_room_external_booking_link',
                            'type'      => 'text',
                            'std'       => "",
                            'condition' => 'st_room_external_booking:is(on)',
                            'desc'      => "<em>" . __( 'Notice: Must be http://...', 'traveler' ) . "</em>",
                        ],
                        [
                            'label' => __( 'Other facility', 'traveler' ),
                            'id'    => 'other_facility',
                            'type'  => 'tab'
                        ],
                        [
                            'label'    => __( 'Add new facility', 'traveler' ),
                            'id'       => 'add_new_facility',
                            'type'     => 'list-item',
                            'settings' => [
                                [
                                    'id'    => 'facility_value',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Value', 'traveler' )
                                ],
                                [
                                    'id'    => 'facility_icon',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Icon', 'traveler' ),
                                    'desc'  => __( 'Support: fonticon <code>(eg: fa-facebook)</code>', 'traveler' )
                                ],
                            ],
                            'desc'     => __( 'You can add unlimited facility ', 'traveler' )

                        ],
                        [
                            'label' => __( 'Room description', 'traveler' ),
                            'id'    => 'room_description',
                            'type'  => 'textarea',
                            'std'   => ''
                        ],
                        [
                            'label' => __( 'Availability', 'traveler' ),
                            'id'    => 'availability_tab',
                            'type'  => 'tab'
                        ],
                        [
                            'label'   => __( "Default calendar state", 'traveler' ),
                            'id'      => 'default_state',
                            'type'    => 'select',
                            'choices' => [
                                [
                                    'value' => "available",
                                    'label' => __( "Available", 'traveler' )
                                ],
                                [
                                    'value' => "not_available",
                                    'label' => __( "Not Available", 'traveler' )
                                ],
                            ],
                            'desc'    => __( 'Calendar set as state selected below', 'traveler' )
                        ],
                        [
                            'label' => __( 'Calendar', 'traveler' ),
                            'id'    => 'st_hotel_calendar',
                            'type'  => 'st_hotel_calendar'
                        ],
                        [
                            'label' => __( 'Cancel Booking', 'traveler' ),
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

                $data_paypment = STPaymentGateways::get_payment_gateways();
                if ( !empty( $data_paypment ) and is_array( $data_paypment ) ) {
                    $this->metabox[ 0 ][ 'fields' ][] = [
                        'label' => __( 'Payment methods', 'traveler' ),
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

                parent::register_metabox( $this->metabox );
            }


            /**
             *
             *
             * @since 1.0.9
             *
             */
            static function _update_avg_price( $post_id = false )
            {
                if ( empty( $post_id ) ) {
                    $post_id = get_the_ID();
                }
                $post_type = get_post_type( $post_id );
                if ( $post_type == 'hotel_room' ) {
                    $hotel_id = get_post_meta( $post_id, 'room_parent', true );
                    if ( !empty( $hotel_id ) ) {
                        $is_auto_caculate = get_post_meta( $hotel_id, 'is_auto_caculate', true );
                        if ( $is_auto_caculate != 'off' ) {
                            $query  = [
                                'post_type'      => 'hotel_room',
                                'post_status' => 'publish',
                                'posts_per_page' => 999,
                                'meta_key'       => 'room_parent',
                                'meta_value'     => $hotel_id
                            ];
                            $traver = new WP_Query( $query );
                            $price  = 0;
                            while ( $traver->have_posts() ) {
                                $traver->the_post();
                                $discount   = get_post_meta( get_the_ID(), 'discount_rate', TRUE );
                                if ( get_post_meta( get_the_ID(), 'price_by_per_person', true ) == 'on' ) {
                                    $adult_price = floatval( get_post_meta( get_the_ID(), 'adult_price', true ) );
                                    $child_price = floatval( get_post_meta( get_the_ID(), 'child_price', true ) );
                                    $item_price = max( $adult_price, $child_price );
                                } else {
                                    $item_price = get_post_meta( get_the_ID(), 'price', TRUE );
                                }
                                if ( $discount ) {
                                    if ( $discount > 100 ) $discount = 100;
                                    $item_price = $item_price - ( $item_price / 100 ) * $discount;
                                }
                                $price += $item_price;
                            }
                            wp_reset_query();
                            $avg_price = 0;
                            if ( $traver->post_count ) {
                                $avg_price = $price / $traver->post_count;
                            }
                            update_post_meta( $hotel_id, 'price_avg', $avg_price );
                        }
                    }
                }
            }

            // since 1.2.4
            static function _update_min_price( $post_id = false )
            {
                if ( empty( $post_id ) ) {
                    $post_id = get_the_ID();
                }
                $post_type = get_post_type( $post_id );
                if ( $post_type == 'hotel_room' ) {
                    $hotel_id = get_post_meta( $post_id, 'room_parent', true );
                    if ( !empty( $hotel_id ) ) {
                        $query  = [
                            'post_type'      => 'hotel_room',
                            'posts_per_page' => 999,
                            'meta_key'       => 'room_parent',
                            'meta_value'     => $hotel_id
                        ];
                        $traver = new WP_Query( $query );

                        $prices = [];
                        while ( $traver->have_posts() ) {
                            $traver->the_post();
                            $discount   = get_post_meta( get_the_ID(), 'discount_rate', TRUE );
                            if ( get_post_meta( get_the_ID(), 'price_by_per_person', true ) == 'on' ) {
                                $adult_price = floatval( get_post_meta( get_the_ID(), 'adult_price', true ) );
                                $child_price = floatval( get_post_meta( get_the_ID(), 'child_price', true ) );
                                $item_price = min( $adult_price, $child_price );
                            } else {
                                $item_price = get_post_meta( get_the_ID(), 'price', TRUE );
                            }
                            if ( $discount ) {
                                if ( $discount > 100 ) $discount = 100;
                                $item_price = $item_price - ( $item_price / 100 ) * $discount;
                            }
                            $prices[] = $item_price;
                        }
                        wp_reset_query();
                        if ( !empty( $prices ) ) {
                            $min_price = min( $prices );
                            update_post_meta( $hotel_id, 'min_price', $min_price );
                        }
                    }
                }
            }

            /**from 1.1.9*/
            function _update_duplicate_data( $id, $data )
            {
                // for room
                if ( !TravelHelper::checkTableDuplicate( 'hotel_room' ) ) return;
                if ( get_post_type( $id ) == 'hotel_room' ) {
                    $num_rows       = TravelHelper::checkIssetPost( $id, 'hotel_room' );
                    $allow_full_day = get_post_meta( $id, 'allow_full_day', true ); // address
                    $data           = [
                        'room_parent'    => get_post_meta( $id, 'room_parent', true ),
                        'multi_location' => get_post_meta( $id, 'multi_location', true ),
                        'id_location'    => get_post_meta( $id, 'id_location', true ),
                        'address'        => get_post_meta( $id, 'address', true ),
                        'allow_full_day' => $allow_full_day,
                        'price'          => get_post_meta( $id, 'price', true ),
                        'number_room'    => get_post_meta( $id, 'number_room', true ),
                        'discount_rate'  => get_post_meta( $id, 'discount_rate', true ),
                        'adult_number'   => get_post_meta($id, 'adult_number', true),
                        'child_number'   => get_post_meta($id, 'children_number', true),
                        'adult_price'    => get_post_meta( $id, 'adult_price', true ),
                        'child_price'    => get_post_meta( $id, 'child_price', true ),
                        'status' =>     get_post_field('post_status', $id)
                    ];
                    if ( $num_rows == 1 ) {
                        $where = [
                            'post_id' => $id
                        ];
                        TravelHelper::updateDuplicate( 'hotel_room', $data, $where );
                    } elseif ( $num_rows == 0 ) {
                        $data[ 'post_id' ] = $id;
                        TravelHelper::insertDuplicate( 'hotel_room', $data );
                    }


                    // Update Availability
                    $model=ST_Hotel_Room_Availability::inst();
                    $model->where('post_id',$id)
                          ->where("check_in", "UNIX_TIMESTAMP(CURRENT_DATE)", ">=")
                          ->update(array(
                                'parent_id'=>$data['room_parent'],
                                'allow_full_day'=>$data['allow_full_day'],
                                'number'=>$data['number_room'],
                                'adult_number' => $data['adult_number'],
                                'child_number' => $data['child_number']
                    ));

	                $model->where('post_id',$id)
	                      ->where("check_in", "UNIX_TIMESTAMP(CURRENT_DATE)", ">=")
                          ->where('is_base', '1')
	                      ->update(array(
                              'price'=>$data['price'],
                              'adult_price' => $data['adult_price'],
                              'child_price' => $data['child_price'],
	                      ));
                    $model->where('post_id', $id)->update(['parent_id' => get_post_meta( $id, 'room_parent', true )]);
                }

                // for hotel
                if ( !TravelHelper::checkTableDuplicate( 'st_hotel' ) ) return;
                if ( get_post_type( $id ) == 'hotel_room' ) {
                    $hotel_id = get_post_meta( $id, 'room_parent', true );

                    $price_avg = ( get_post_meta( $hotel_id, 'price_avg', true ) );
                    $min_price = ( get_post_meta( $hotel_id, 'min_price', true ) );
                    if ( !$price_avg ) {
                        return;
                    }


                    $data  = [
                        'multi_location'       => get_post_meta( $hotel_id, 'multi_location', true ),
                        'id_location'          => get_post_meta( $hotel_id, 'id_location', true ),
                        'address'              => get_post_meta( $hotel_id, 'address', true ),
                        'rate_review'          => get_post_meta( $hotel_id, 'rate_review', true ),
                        'hotel_star'           => get_post_meta( $hotel_id, 'hotel_star', true ),
                        'price_avg'            => $price_avg,
                        'min_price'            => $min_price,
                        'hotel_booking_period' => get_post_meta( $hotel_id, 'hotel_booking_period', true ),
                        'map_lat'              => get_post_meta( $hotel_id, 'map_lat', true ),
                        'map_lng'              => get_post_meta( $hotel_id, 'map_lng', true ),
                    ];
                    $where = [
                        'post_id' => $hotel_id
                    ];
                    TravelHelper::updateDuplicate( 'st_hotel', $data, $where );
                }

            }

            static function _alter_search_query( $where )
            {
                global $wp_query;

                if ( !is_admin() ) return $where;

                if ( $wp_query->get( 'post_type' ) != 'hotel_room' ) return $where;

                global $wpdb;

                if ( $wp_query->get( 's' ) ) {
                    $_GET[ 's' ] = isset( $_GET[ 's' ] ) ? sanitize_title_for_query( $_GET[ 's' ] ) : '';
                    $add_where   = " OR $wpdb->posts.ID IN (SELECT post_id FROM
                     $wpdb->postmeta
                    WHERE $wpdb->postmeta.meta_key ='room_parent'
                    AND $wpdb->postmeta.meta_value IN (SELECT $wpdb->posts.ID
                        FROM $wpdb->posts WHERE  $wpdb->posts.post_title LIKE '%{$_GET['s']}%'
                    )

             )  ";

                    $where .= $add_where;


                }

                return $where;
            }

            function hotel_update_min_price( $meta_id, $object_id, $meta_key, $meta_value )
            {

                $post_type = get_post_type( $object_id );
                if ( wp_is_post_revision( $object_id ) )
                    return;
                if ( $post_type == 'hotel_room' ) {
                    //Update old room and new room
                    if ( $meta_key == 'room_parent' ) {

                        $old = get_post_meta( $object_id, $meta_key, true );


                        if ( $old != $meta_value ) {
                            $this->_do_update_hotel_min_price( $old, false, $object_id );
                            $this->_do_update_hotel_min_price( $meta_value );
                        } else {

                            $this->_do_update_hotel_min_price( $meta_value );
                        }
                    }


                }

            }

            function meta_updated_update_min_price( $meta_id, $object_id, $meta_key, $meta_value )
            {
                if ( $meta_key == 'price' ) {
                    $hotel_id = get_post_meta( $object_id, 'room_parent', true );
                    $this->_do_update_hotel_min_price( $hotel_id );

                }
            }

            function _do_update_hotel_min_price( $hotel_id, $current_meta_price = false, $room_id = false )
            {
                if ( !$hotel_id ) return;
                $query = [
                    'post_type'      => 'hotel_room',
                    'posts_per_page' => 100,
                    'meta_key'       => 'room_parent',
                    'meta_value'     => $hotel_id
                ];

                if ( $room_id ) {
                    $query[ 'posts_not_in' ] = [ $room_id ];
                }


                $q = new WP_Query( $query );

                $min_price = 0;
                $i         = 1;
                while ( $q->have_posts() ) {
                    $q->the_post();
                    if ( get_post_meta( get_the_ID(), 'price_by_per_person', true ) == 'on' ) {
                        $adult_price = floatval( get_post_meta( get_the_ID(), 'adult_price', true ) );
                        $child_price = floatval( get_post_meta( get_the_ID(), 'child_price', true ) );
                        $price = min($adult_price, $child_price);
                    } else {
                        $price = get_post_meta( get_the_ID(), 'price', true );
                    }
                    if ( $i == 1 ) {
                        $min_price = $price;
                    } else {
                        if ( $price < $min_price ) {
                            $min_price = $price;
                        }
                    }


                    $i++;
                }

                wp_reset_query();

                if ( $current_meta_price !== FALSE ) {
                    if ( $current_meta_price < $min_price ) {
                        $min_price = $current_meta_price;
                    }
                }

                update_post_meta( $hotel_id, 'min_price', $min_price );

            }

            function st_change_column_st_hotel_room_fnc($column) {
                $new_column = array_merge( $column, [
                    'adult_price'          => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                    'child_price'          => [
                        'type'   => 'varchar',
                        'length' => 255
                    ],
                ]);
                return $new_column;
            }

            static function inst()
            {
                if ( !self::$_inst ) {
                    self::$_inst = new self();
                }

                return self::$_inst;
            }
        }

        STAdminRoom::inst();
    }

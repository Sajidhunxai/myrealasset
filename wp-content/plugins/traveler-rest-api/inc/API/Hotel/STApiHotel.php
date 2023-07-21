<?php 
namespace Inc\API\Hotel;
use \WP_REST_Server;
use \WP_REST_Request;
use \TravelHelper;
use \STHotel;
use \STDate;
use \STPrice;
use \HotelHelper;
use Inc\API\Settings;
use \Inc\API\STApiCore;
use \TravelerObject;
use \Nested_set;
if (!class_exists('STApiHotel')) {
    class STApiHotel extends Settings {
        public $settings = [];
        private $rest_url = 'traveler';

        public function _init_rest_api(){
            
            register_rest_route( $this->rest_url, '/hotel-add-to-cart', array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback'    => array($this, 'hotel_add_to_cart_api'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'token' => array (
                        'required' => true
                    ),  
                )
            ) );

            register_rest_route( $this->rest_url, '/hotel-filter', array(
                'methods' => WP_REST_Server::READABLE,
                'callback'    => array($this, 'hotel_filter_api'),
                'permission_callback' => '__return_true',
                'args' => array(),
            ) );


        }
        public function hotel_add_to_cart_api(WP_REST_Request $request) {
            {
                $pass_validate = true;
                $get_params = $request->get_params();
                $token = $get_params['token'];
                $item_id = $get_params['item_id'];
                if ($item_id <= 0) {
                    echo json_encode(
                        [
                            'notification' =>  'This hotel is not available.',
                            'success'=> false,
                        ]
                    );
                    $pass_validate = false;
                    return false;
                }
                $room_id = intval($get_params['room_id']);
                if ($room_id <= 0 || get_post_type($room_id) != 'hotel_room') {
                    echo json_encode(
                        [
                            'notification' =>  'This room is not available.',
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $room_origin = TravelHelper::post_origin($room_id, 'hotel_room');
                $check_in =  $get_params['check_in'];
                if (empty($check_in)) {
                    echo json_encode(
                        [
                            'notification' =>  'Date is invalid',
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $check_in = TravelHelper::convertDateFormat($check_in);
                $check_out = $get_params['check_out'];
                if (empty($check_out)) {
                    echo json_encode(
                        [
                            'notification' =>  'Date is invalid',
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $check_out = TravelHelper::convertDateFormat($check_out);
                $room_num_search = intval($get_params['room_num_search']);
                if (empty($room_num_search))
                    $room_num_search = intval($get_params['number_room']);
                if ($room_num_search <= 0) $room_num_search = 1;
                $adult_number = intval($get_params['adult_number']);
                if ($adult_number <= 0) $adult_number = 1;
                $child_number = intval($get_params['child_number']);
                if ($child_number <= 0) $child_number = 0;
                $checkin_ymd = date('Y-m-d', strtotime($check_in));
                $checkout_ymd = date('Y-m-d', strtotime($check_out));
                if (!HotelHelper::check_day_cant_order($room_origin, $checkin_ymd, $checkout_ymd, $room_num_search, $adult_number, $child_number)) {
                    echo json_encode(
                        [
                            'notification' =>  'This room is not available from '.$checkin_ymd.' to '.$checkout_ymd ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                if (!HotelHelper::_check_room_only_available($room_origin, $checkin_ymd, $checkout_ymd, $room_num_search)) {
                    echo json_encode(
                        [
                            'notification' =>  'This room is not available.' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
            
                if (strtotime($check_out) - strtotime($check_in) <= 0) {
                    echo json_encode(
                        [
                            'notification' =>  'The check-out is later than the check-in.' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $num_room = intval(get_post_meta($room_origin, 'number_room', true));
                $adult = intval(get_post_meta($room_origin, 'adult_number', true));
                if ($adult == 0) {
                    $adult = 1;
                }
                $children = intval(get_post_meta($room_origin, 'children_number', true));
                if ($room_num_search > $num_room) {
                    echo json_encode(
                        [
                            'notification' =>  'Max of rooms are incorrect.' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                if ($room_num_search * $adult < $adult_number) {
                    if ($room_num_search > 1) {
                        echo json_encode(
                            [
                                'notification' =>  'Max of adults is'.$adult * $room_num_search.' people per '.$room_num_search.' room.' ,
                                'success'=> false,
                            ]
                        ); 
                    } else {
                        echo json_encode(
                            [
                                'notification' =>  'Max of adults is '.$adult.' people.' ,
                                'success'=> false,
                            ]
                        ); 
                    }
                    $pass_validate = false;
                    return false;
                }
                if ($child_number > $children) {
                    echo json_encode(
                        [
                            'notification' =>  'Number of children in the room are incorrect.' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $today = date('m/d/Y');
                $period = STDate::dateDiff($today, $check_in);
                $booking_min_day = intval(get_post_meta($item_id, 'min_book_room', true));
                $compare = TravelHelper::dateCompare($today, $check_in);
                $booking_period = get_post_meta($item_id, 'hotel_booking_period', true);
                if (empty($booking_period) || $booking_period <= 0) $booking_period = 0;
                if ($compare < 0) {
                    echo json_encode(
                        [
                            'notification' =>  'You can not set check-in date in the past' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                if ($period < $booking_period) {
                    echo json_encode(
                        [
                            'notification' =>  'This hotel allow minimum booking is '.$booking_period.' day' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                if ($booking_min_day and $booking_min_day > STDate::dateDiff($check_in, $check_out)) {
                    echo json_encode(
                        [
                            'notification' =>  'Please book at least '.$booking_min_day.' day in total' ,
                            'success'=> false,
                        ]
                    ); 
                    $pass_validate = false;
                    return false;
                }
                $numberday = STDate::dateDiff($check_in, $check_out);
                $price_item_caculator = (new STHotel)->get_data_room_availability($room_origin, strtotime($check_in), strtotime($check_out), $room_num_search, $adult_number, $child_number);

                $extras = $get_params['extra_price'];
                $extra_type = get_post_meta($room_origin, 'extra_price_unit', true);
                $extra_price = STPrice::getExtraPrice($room_origin, $extras, $room_num_search, $numberday);
                $sale_price = STPrice::getRoomPrice($room_origin, strtotime($check_in), strtotime($check_out), $room_num_search, $adult_number, $child_number);
                $ori_price = STPrice::getRoomPriceOrigin($room_origin, strtotime($check_in), strtotime($check_out), $room_num_search, $adult_number, $child_number);
                $discount_rate = STPrice::get_discount_rate($room_origin, strtotime($check_in));
                $data['item_id'] = $item_id;
                $data = [
                    'item_price' => $sale_price,
                    'ori_price' => $sale_price + $extra_price,
                    'sale_price' => $sale_price,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'room_num_search' => $room_num_search,
                    'room_id' => $room_id,
                    'room_name' => get_the_title($room_id),
                    'adult_number' => $adult_number,
                    'child_number' => $child_number,
                    'extras' => $extras,
                    'extra_price' => $extra_price,
                    'extra_type' => $extra_type,
                    'commission' => TravelHelper::get_commission($item_id),
                    'discount_rate' => $discount_rate,
                    'guest_title' => $get_params['guest_title'],
                    'guest_name' => $get_params['guest_name'],
                    'total_price_origin' => $ori_price
                ];
                if (get_post_meta($room_origin, 'price_by_per_person', true) == 'on') {
                    $data['adult_price'] = !empty($price_item_caculator['adult_price']) ? floatval($price_item_caculator['adult_price']) : 0;
                    $data['child_price'] = !empty($price_item_caculator['child_price']) ? floatval($price_item_caculator['child_price']) : 0;
                }
                if ($pass_validate) {
                    $pass_validate = apply_filters('st_hotel_add_cart_validate', $pass_validate, $data);
                }
                if ($pass_validate) {
                    $st_api_core = new STApiCore;
                    $response = $st_api_core->get_user_from_token($token);
                    $user_id = !empty($response['id']) ? $response['id'] : 0;
                    
                
                    $data_cart = $st_api_core->add_cart( $user_id,$item_id, $room_num_search, $sale_price + $extra_price, $data);

                    update_user_meta( $user_id, '_save_cart_data_'.$user_id, $data_cart);
                    echo json_encode (
                        [
                            'data' => $data_cart,
                            'success'=> true,
                        ]
                    );
                    die();
                }
            }

        }
        
        public function hotel_filter_api(WP_REST_Request $request) {
            $get_params = $request->get_params();
            $price_range = $get_params['price_range'];
            $price_range = !empty($get_params['price_range']) ? $get_params['price_range'] : '';
            $star_rate = $get_params['star_rate' ];
            $star_rate = !empty($get_params['star_rate']) ? $get_params['star_rate'] : '';
            $hotel_rate = $get_params['hotel_rate'];
            $hotel_rate = !empty($get_params['hotel_rate']) ? $get_params['hotel_rate'] : '';
            $hotel_tax =  $get_params['hotel_tax']; 
            $hotel_tax = !empty($get_params['hotel_tax']) ? $get_params['hotel_tax'] : '';
            $posts_per_page = $get_params['posts_per_page'];
            $posts_per_page = !empty($get_params['posts_per_page']) ? $get_params['posts_per_page'] : st()->get_option( 'hotel_posts_per_page', 12 );
            $page = $get_params['paged'];
            $page = !empty($get_params['paged']) ? $get_params['paged'] : 1;
            $location_id = $get_params['location_id'];
            $location_id = !empty($get_params['location_id']) ? $get_params['location_id'] : '';
            $check_in   = $get_params['start'];
            $check_in   = !empty($get_params['start']) ? $get_params['start'] : '';
            $check_out = $get_params['end'];
            $check_out = !empty($get_params['end']) ? $get_params['end'] : '';
            $adult_number = $get_params['adult_number'];
            $adult_number = !empty($get_params['adult_number']) ? $get_params['adult_number'] : 0;
            $children_number = $get_params['children_num'];
            $children_number = !empty($get_params['children_num']) ? $get_params['children_num'] : 0;
            $number_room = $get_params['room_num_search'];
            $number_room = !empty($get_params['room_num_search']) ? $get_params['room_num_search'] : 1;
            $post_type = array('st_hotel');
            global $wpdb; 
            if( !empty($posts_per_page) || !empty($page) ) {
                $offset = ( $page * $posts_per_page ) - $posts_per_page; 
            }
            $table_st_hotel = $wpdb->prefix . 'st_hotel'; 
            $table_post = $wpdb->prefix . 'posts';
            $table_term_relationships = $wpdb->prefix . 'term_relationships';
            $where = "{$table_post}.post_status = 'publish' AND {$table_post}.post_type = 'st_hotel' ";
            if ( isset( $location_id ) && !empty($location_id ) ) {
                if ( (int)$location_id > 0 && is_array( $post_type ) ) {
                    $ns = new Nested_set();
                    $ns->setControlParams( $wpdb->prefix . 'st_location_nested' );

                    $post_type_in = "";
                    foreach ( $post_type as $item ) {
                        $post_type_in .= "'" . $item . "',";
                    }
                    $post_type_in = substr( $post_type_in, 0, -1 );

                    $locations = [];

                    if ( is_array( $location_id ) ) {
                        foreach ( $location_id as $location ) {
                            $node = $ns->getNodeWhere( "location_id = " . (int)$location );

                            if ( !empty( $node ) ) {
                                $leftval     = (int)$node[ 'left_key' ];
                                $rightval    = (int)$node[ 'right_key' ];
                                $node_childs = $ns->getNodesWhere( "left_key >= " . $leftval . " AND right_key <= " . $rightval );
                                if ( !empty( $node_childs ) ) {
                                    foreach ( $node_childs as $item ) {
                                        $locations[] = (int)$item[ 'location_id' ];
                                    }
                                } else {
                                    $locations[] = (int)$node[ 'location_id' ];
                                }
                            }
                        }
                    } elseif ( count( explode( ',', $location_id ) ) > 1 ) {
                        $location_tmp = explode( ',', $location_id );
                        foreach ( $location_tmp as $k => $v ) {
                            $node = $ns->getNodeWhere( "location_id = " . $v );
                            if ( !empty( $node ) ) {
                                $leftval     = (int)$node[ 'left_key' ];
                                $rightval    = (int)$node[ 'right_key' ];
                                $node_childs = $ns->getNodesWhere( "left_key >= " . $leftval . " AND right_key <= " . $rightval );
                                if ( !empty( $node_childs ) ) {
                                    foreach ( $node_childs as $item ) {
                                        $locations[] = (int)$item[ 'location_id' ];
                                    }
                                } else {
                                    $locations[] = (int)$node[ 'location_id' ];
                                }
                            }

                        }
                    } else {
                        $node = $ns->getNodeWhere( "location_id = " . $location_id );
                        if ( !empty( $node ) ) {
                            $leftval     = (int)$node[ 'left_key' ];
                            $rightval    = (int)$node[ 'right_key' ];
                            $node_childs = $ns->getNodesWhere( "left_key >= " . $leftval . " AND right_key <= " . $rightval );
                            if ( !empty( $node_childs ) ) {
                                foreach ( $node_childs as $item ) {
                                    $locations[] = (int)$item[ 'location_id' ];
                                }
                            } else {
                                $locations[] = (int)$node[ 'location_id' ];
                            }
                        }
                    }


                    $where_location = " 1=1 ";
                    if ( !empty( $locations ) ) {
                        $where_location .= " AND location_from IN (";
                        $string         = "";
                        foreach ( $locations as $location ) {

                            $string .= "'" . $location . "',";
                        }
                        $string         = substr( $string, 0, -1 );
                        $where_location .= $string . ")";
                    } else {
                        $where_location .= " AND location_from IN ('{$location_id}') ";
                    }

                    if ( !empty( $post_type_in ) ) {
                        $where_location .= " AND post_type IN ({$post_type_in})";
                    }

                    $where .= " AND {$wpdb->prefix}posts.ID IN (SELECT post_id FROM {$wpdb->prefix}st_location_relationships WHERE " . $where_location . ")";

                }
            }
            if (!empty($check_in) && !empty($check_out)) {
                $check_in = date('Y-m-d', strtotime(TravelHelper::convertDateFormat($check_in)));
                $check_out = date('Y-m-d', strtotime(TravelHelper::convertDateFormat($check_out)));
                $check_in_stamp = strtotime($check_in);
                $check_out_stamp = strtotime($check_out);
            } 
            if ($check_in && $check_out) {
                $today = date('m/d/Y');
                $period = STDate::dateDiff($today, $check_in);
                
                if (intval($adult_number) < 0) $adult_number = 0;
              
                if (intval($children_number) < 0) $children_number = 0;

                if (intval($number_room) < 0) {
                    $number_room = 1;
                }
                $disable_avai_check = st()->get_option('disable_availability_check', 'off');
                if ($disable_avai_check == 'off') {
                    $list_hotel = $this->get_unavailability_hotel_new($check_in, $check_out, $adult_number, $children_number, $number_room);
                    
                    if (!is_array($list_hotel) || count($list_hotel) <= 0) {
                        $list_hotel = "''";
                    } else {
                        $list_hotel = array_filter($list_hotel, function ($value) {
                            return $value !== '';
                        });
                        $list_hotel = implode(',', $list_hotel);
                        if (!empty($list_hotel)) {
                            if (!empty($check_in_stamp) || !empty($check_out_stamp)) {
                                $where .= " AND {$wpdb->prefix}posts.ID IN ({$list_hotel}) ";
                            }
                        }
                    }
                    $jointable_st_room = " LEFT JOIN wp_st_room_availability as tb ON wp_posts.ID = tb.parent_id AND status = 'available' LEFT JOIN wp_hotel_room as tb3 ON (tb.post_id = tb3.post_id and tb3.`status` IN ('publish', 'private'))";
                    $where .= " AND tb.check_in >= {$check_in_stamp} AND tb.check_out <= {$check_out_stamp} ";
                }
                $where .= " AND CAST({$table_st_hotel}.hotel_booking_period AS UNSIGNED) <= {$period}";
            } 
            if (isset($star_rate) && !empty($star_rate)) {
                $stars = $star_rate;
                $stars = explode(',', $stars);
                $all_star = [];
                if (!empty($stars) && is_array($stars)) {
                    foreach ($stars as $val) {
                        $start_range = 0;
                        $max_range = 0;
                        if ($val == 'zero') {
                            $val = 0;
                            $start_range = $val;
                            $max_range = $val + 1;
                        } else {
                            $start_range = $val + 0.1;
                            $max_range = $val + 1;
                        }
                        if (empty($all_star)) {
                            $all_star = range($start_range, $max_range, 0.1);
                        } else {
                            $all_star = array_merge($all_star, range($start_range, $max_range, 0.1));
                        }
                    }
                }
                $list_star = implode(',', array_unique($all_star));
                if ($list_star) {
                    $where .= " AND {$table_st_hotel}.rate_review IN ($list_star)";
                }
            }
            if (isset($hotel_rate) && !empty($hotel_rate)) {
                $hotel_rate = $hotel_rate;
                $where .= " AND ({$table_st_hotel}.hotel_star IN ({$hotel_rate}))";
            }
            if (isset($price_range) && !empty($price_range)) {
                $meta_key = st()->get_option('hotel_show_min_price', 'avg_price');
                if ($meta_key == 'avg_price') {$meta_key = "price_avg";} else {$meta_key = "min_price";}; 
                $price = $price_range;
                $priceobj = explode(';', $price);
                // convert to default money
                $priceobj[0] = TravelHelper::convert_money_to_default($priceobj[0]);
                $priceobj[1] = TravelHelper::convert_money_to_default($priceobj[1]);
                $where .= " AND ({$table_st_hotel}.$meta_key >= $priceobj[0]) ";
                if (isset($priceobj[1])) {
                    $where .= " AND ({$table_st_hotel}.$meta_key <= $priceobj[1]) ";
                }
            }
            if(isset($hotel_tax) && !empty($hotel_tax)) {
                $jointable = " LEFT JOIN {$table_term_relationships} ON {$table_post}.ID = {$table_term_relationships}.object_id";
                $where .= " AND ({$table_term_relationships}.term_taxonomy_id IN ({$hotel_tax})) ";
            }else {
                $jointable = "";
            }
            $sql = "SELECT * FROM {$table_post}
            LEFT JOIN {$table_st_hotel} ON {$table_post}.ID = {$table_st_hotel}.post_id
            $jointable
            $jointable_st_room
            WHERE  $where 
            ORDER BY {$table_post}.post_date DESC
            LIMIT $offset,$posts_per_page";
          
            $data = $wpdb->get_results( $wpdb->prepare($sql, $posts_per_page, $offset), ARRAY_A);
            $array_data_hotel = [];
            foreach($data as $array_data){
                
                $post_translated = TravelHelper::post_translated($array_data['ID']);
                $count_review = get_comment_count($post_translated)['approved'];
                $rate_text =  TravelHelper::get_rate_review_text($array_data['rate_review'], $count_review);
                $featured_img_url = get_the_post_thumbnail_url($array_data['ID'],'full'); 
                $meta_key = st()->get_option('hotel_show_min_price', 'avg_price');
                if ($meta_key == 'avg_price') {$meta_key = "price_avg";} else {$meta_key = "min_price";}; 
                $data_filter_hotel  = [
                    'ID' => $array_data['ID'],
                    'title'  => $array_data['post_title'],
                    'image' =>  $featured_img_url,
                    'location' => $array_data['address'],
                    'rate_review' => $array_data['rate_review'],
                    'rate_text'  => $rate_text,
                    'price' => TravelHelper::format_money($array_data[$meta_key]),
                ];
              
                $array_data_hotel[] = $data_filter_hotel;
            }
          
          
            if(!empty($array_data_hotel)){
                echo json_encode([
                    'success' => true,
                    'data' => $array_data_hotel,
                    'notice' => __('Found','traveler-rest-api'),
                ]);
            }else {
                echo json_encode([
                    'success' => false,
                    'notice' => __('Not Found','traveler-rest-api'),
                ]);
            }
           die();
        }


        function get_unavailability_hotel_new($check_in, $check_out, $adult_number, $children_number, $number_room = 1)
        {
            global $wpdb;
            $select = "";
            $where = "";
            $res = array();
            global $wpdb;

            if (!empty($number_room)) {
                $group_by = " GROUP BY {$wpdb->prefix}st_room_availability.parent_id ";
                $ceil_adult = ceil($adult_number / $number_room);
                $children_number = ceil($children_number / $number_room);
                $check_in = strtotime($check_in);
                $check_out = strtotime($check_out);
                $select .= "SELECT SQL_CALC_FOUND_ROWS {$wpdb->prefix}st_room_availability.parent_id
                                    FROM {$wpdb->prefix}st_room_availability";
                $where .= " WHERE 1=1 ";
                $where .= " AND check_in < {$check_out} AND check_in >= {$check_in} AND CAST((number  - IFNULL(number_booked, 0)) AS SIGNED) >= {$number_room}";
                $where .= " AND status = 'available'";
                $where .= " AND adult_number >= {$ceil_adult}";
                $where .= " AND child_number >= {$children_number}";
                $res = [];
                $sql = "
                            {$select}
                            {$where}
                            {$group_by}
                            ";
                          
                $list_hotel = $wpdb->get_results($sql, ARRAY_A);
                if (!empty($list_hotel)) {
                    foreach ($list_hotel as $k => $v) {
                        $hotel_id = $v['parent_id'];
                        $res[] = $hotel_id;
                    }
                }
            }

            return $res;
        }
    }
}
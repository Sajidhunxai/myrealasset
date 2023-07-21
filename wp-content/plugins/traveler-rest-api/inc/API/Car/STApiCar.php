<?php 
namespace Inc\API\Car;
use \WP_REST_Server;
use \WP_REST_Request;
use \TravelHelper;
use \STCars;
use \STDate;
use \STPrice;
use \CarHelper;
use Inc\API\Settings;
use \Inc\API\STApiCore;
use \Nested_set;
class STApiCar extends Settings {
    public $settings = [];
    private $rest_url = 'traveler';

    public function _init_rest_api(){
        
        register_rest_route( $this->rest_url, '/cars-add-to-cart', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback'    => array($this, 'cars_add_to_cart_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'token' => array (
                    'required' => true
                ),  
            )
        ) );
        
        register_rest_route( $this->rest_url, '/car-filter', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'car_filter_api'),
            'permission_callback' => '__return_true',
            'args' => array(),
        ) );

    }



    public function cars_add_to_cart_api(WP_REST_Request $request) {
        $pass_validate = true;
        $get_params = $request->get_params();
        $token = $get_params['token'];
        $item_id = $get_params['item_id'];
        $location_id = $get_params['location_id'];
        $location_id_drop_off = $get_params['location_id_drop_off'];
        $drop_off_date = $get_params['drop-off-date'];
        $pick_up_date = $get_params['pick-up-date'];
        $drop_off_time = $get_params['drop-off-time'];
        if ($item_id <= 0 || get_post_type($item_id) != 'st_cars') {
            echo json_encode(
                [
                    'notification' =>  'This car is not available.',
                    'success'=> false,
                ]
            );
            $pass_validate = FALSE;
            return false;
        }
        $post_origin = TravelHelper::post_origin($item_id, 'st_cars');
        $number = 1;
        // Validate required field
        if ( empty($location_id) ) {
            echo json_encode(
                [
                    'notification' =>  'Location is required',
                    'success'=> false,
                ]
            );
            $pass_validate = FALSE;
            return false;
        }
        if ( empty($location_id_drop_off) ) {
        } else {
            $location_id_drop_off = $location_id;
        }
       
        if ( empty($drop_off_date) ) {
            echo json_encode(
                [
                    'notification' =>  'The Drop Off Date is required',
                    'success'=> false,
                ]
            );
            $pass_validate = FALSE;
            return false;
        }
        $check_in = '';
        $check_in_n = '';
        $check_in_time = '';
        if (isset($pick_up_date) && !empty($pick_up_date)) {
            $check_in = TravelHelper::convertDateFormat($pick_up_date);
            $check_in_n = $check_in;
        }
        if (isset($pick_up_date) && !empty($pick_up_date)) {
            $check_in .= ' ' . $get_params['pick-up-time'];
            $check_in_time = $get_params['pick-up-time'];
        }
        $check_in = date('Y-m-d H:i:s', strtotime($check_in));
        $check_out = '';
        $check_out_n = '';
        $check_out_time = '';
        if (isset($drop_off_date) && !empty($drop_off_date)) {
            $check_out .= TravelHelper::convertDateFormat($drop_off_date);
            $check_out_n = $check_out;
        }
        if (isset($drop_off_time) && !empty($drop_off_time)) {
            $check_out .= ' ' . $drop_off_time;
            $check_out_time = $drop_off_time;
        }
        $check_out = date('Y-m-d H:i:s', strtotime($check_out));
        
        $location_id = $get_params['location_id'];
        $pick_up = get_the_title($location_id);
        $drop_off = !empty($location_id_drop_off) ? get_the_title($location_id_drop_off) : $pick_up;
        if (isset($location_id) && !empty($location_id)) {
            $locations = get_post_meta($item_id, 'multi_location', true);
            if (empty($locations)) {
                echo json_encode(
                    [
                        'notification' =>  'This car is not set location data.',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
            if (!empty($locations) && !is_array($locations)) {
                $locations = explode(',', $locations);
            }
            $location_id = intval($get_params['location_id']);
            $pickup_country = get_post_meta($location_id, 'location_country', true);
            $in_location = false;
            $location_without_s = [];
            foreach ($locations as $location) {
                $location = str_replace("_", "", $location);
                array_push($location_without_s, $location);
            }
            //Check car with current location
            if (!empty($location_without_s)) {
                if (!in_array($location_id, $location_without_s)) {
                    echo json_encode(
                        [
                            'notification' =>  'The location is not match with car location.',
                            'success'=> false,
                        ]
                    );
                    $pass_validate = false;
                    return false;
                }
            }
            if (!$pickup_country) {
                echo json_encode(
                    [
                        'notification' =>  'The \'country\' field not set for the \'' . get_the_title($location_id) . '\'',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        $location_id_drop_off = $location_id;
        if (!empty($get_params['st_country_up']) && !empty($get_params['st_country_off'])) {
            global $wpdb;
            $st_country = $wpdb->get_var("SELECT country FROM {$wpdb->prefix}st_glocation WHERE post_id = {$item_id} LIMIT 0,1");
            $st_country_up = sanitize_title($get_params['st_country_up']);
            $st_country_off = sanitize_title($get_params['st_country_off']);
            if (($st_country != $st_country_up) || ($st_country != $st_country_off) || ($st_country_up != $st_country_off)) {
                echo json_encode(
                    [
                        'notification' =>  'The country is not same',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        $number_distance = STPrice::getDistanceByCar($location_id, $location_id_drop_off);
        $today = date('m/d/Y');
        $booking_period = intval(get_post_meta($post_origin, 'cars_booking_period', true));
        $booking_min_day = intval(get_post_meta($post_origin, 'cars_booking_min_day', true));
        $booking_min_hour = intval(get_post_meta($post_origin, 'cars_booking_min_hour', true));
        if (empty($booking_period) || $booking_period <= 0) $booking_period = 0;
        $check_in_timestamp = '';
        $check_out_timestamp = '';
        if (!empty($check_in_n) && !empty($check_out_n)) {
            $period = STDate::dateDiff($today, $check_in_n);
            $compare = TravelHelper::dateCompare($today, $check_in_n);
         
            $check_in_timestamp = strtotime($check_in);
            $check_out_timestamp = strtotime($check_out);
            if ($check_in_timestamp > $check_out_timestamp) {
                echo json_encode(
                    [
                        'notification' =>  'The drop off datetime is later than the pick up datetime.',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
            if ($compare < 0) {
                echo json_encode(
                    [
                        'notification' =>  'You can not set check-in date in the past',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
            if ($period < $booking_period) {
                echo json_encode(
                    [
                        'notification' =>  'This car allow minimum booking is'. $booking_period .'day(s)',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
            $unit = st()->get_option('cars_price_unit', 'day');
            if ($unit == 'day' and $booking_min_day and $booking_min_day > STCars::get_date_diff($check_in_timestamp, $check_out_timestamp)) {
                echo json_encode(
                    [
                        'notification' =>  'This car allow minimum booking is'. $booking_min_day .'day(s)',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
            if ($unit == 'hour' and $booking_min_hour and $booking_min_hour > STCars::get_date_diff($check_in_timestamp, $check_out_timestamp)) {
                echo json_encode(
                    [
                        'notification' =>  'Please book at least '.$booking_min_hour.' hour(s) in total',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        if ($check_in_timestamp > 0 && $check_out_timestamp > 0) {
            if (!CarHelper::_get_car_cant_order_by_id($post_origin, $check_in_timestamp, $check_out_timestamp)) {
                echo json_encode(
                    [
                        'notification' =>  'This car is full order',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        $selected_destination = STCars::get_route($location_id, $location_id_drop_off);
        $extras = $get_params['extra_price'];
        $extra_price = (new STCars)->geExtraPrice($extras,$check_in,$check_out, $item_id);
        $info_price = STCars::get_info_price($post_origin, strtotime($check_in), strtotime($check_out), $location_id, $location_id_drop_off);
        $price_unit = $info_price['price'];
        $item_price = floatval(get_post_meta($post_origin, 'cars_price', true));
        if ($item_price < 0) $item_price = 0;
        $price_destination = STCars::get_route($location_id, $location_id_drop_off);
        $sale_price = STPrice::getSaleCarPrice($post_origin, $item_price, strtotime($check_in), strtotime($check_out), $location_id, $location_id_drop_off);
        $car_sale_price = STPrice::get_car_price_by_number_of_day_or_hour($post_origin, $item_price, strtotime($check_in), strtotime($check_out));
        $car_title_sale_price = STPrice::get_car_price_title_by_number_of_day_or_hour($post_origin, $item_price, strtotime($check_in), strtotime($check_out));
        $discount_rate = STPrice::get_discount_rate($post_origin, strtotime($check_in));
        $numberday = STCars::get_date_diff(strtotime($check_in), strtotime($check_out), st()->get_option('cars_price_unit', 'day'));
        $data = [
            'check_in' => $check_in_n,
            'check_out' => $check_out_n,
            'check_in_time' => $check_in_time,
            'check_out_time' => $check_out_time,
            'check_in_timestamp' => $check_in_timestamp,
            'check_out_timestamp' => $check_out_timestamp,
            'location_id' => $location_id,
            'location_id_drop_off' => $location_id,
            'pick_up' => $pick_up,
            'drop_off' => $drop_off,
            'ori_price' => $sale_price + $extra_price,
            'item_price' => $item_price,
            'sale_price' => $sale_price,
            'car_title_sale_price' => $car_title_sale_price,
            'numberday' => $numberday,
            'price_equipment' => $extra_price,
            'data_equipment' => $extras,
            'price_destination' => $price_destination,
            'data_destination' => $selected_destination,
            'commission' => TravelHelper::get_commission($item_id),
            'discount_rate' => $discount_rate,
            'type_car'              => 'st_cars',
            'distance' => $number_distance,
            'price_with_tax' => STPrice::getPriceWithTax($sale_price + $extra_price)
        ];
        $pass_validate = apply_filters('st_car_add_cart_validate', $pass_validate, $item_id, $number, $price_unit, $data);
        if ($pass_validate) {
            $st_api_core = new STApiCore;
            $response = $st_api_core->get_user_from_token($token);
            $user_id = !empty($response['id']) ? $response['id'] : 0;
           
            
            $data_cart = $st_api_core->add_cart($user_id,$item_id, $number, $extra_price + $sale_price, $data);
            
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

    public function car_filter_api(WP_REST_Request $request) {

        $get_params = $request->get_params();
        $price_range = $get_params['price_range'];
        $price_range = !empty($get_params['price_range']) ? $get_params['price_range'] : '';
        $car_tax =  $get_params['car_tax']; 
        $car_tax = !empty($get_params['car_tax']) ? $get_params['car_tax'] : '';
        $posts_per_page = $get_params['posts_per_page'];
        $posts_per_page = !empty($get_params['posts_per_page']) ? $get_params['posts_per_page'] : st()->get_option( 'cars_posts_per_page', 12 );
        $page = $get_params['paged'];
        $page = !empty($get_params['paged']) ? $get_params['paged'] : 1;
        $location_id = $get_params['location_id'];
        $location_id = !empty($get_params['location_id']) ? $get_params['location_id'] : '';
        $pick_up_date =  $get_params['pick_up_date'];
        $pick_up_date = !empty($get_params['pick_up_date']) ? $get_params['pick_up_date'] : '';
        $drop_off_date = $get_params['drop_off_date'];
        $drop_off_date = !empty($get_params['drop_off_date']) ? $get_params['drop_off_date'] : '';
        $pick_up_time = $get_params['pick_up_time'];
        $pick_up_time = !empty($get_params['pick_up_time']) ? $get_params['pick_up_time'] : '12:00 PM';
        $drop_off_time  = $get_params['drop_off_time'];
        $drop_off_time = !empty($get_params['drop_off_time']) ? $get_params['drop_off_time'] : '12:00 PM';
        $post_type = array('st_cars');
        global $wpdb; 
        if( !empty($posts_per_page) || !empty($page) ) {
            $offset = ( $page * $posts_per_page ) - $posts_per_page; 
        }
        $table_st_cars = $wpdb->prefix . 'st_cars'; 
        $table_post = $wpdb->prefix . 'posts';
     
        $table_term_relationships = $wpdb->prefix . 'term_relationships';
    
        $where = "{$table_post}.post_status = 'publish' AND {$table_post}.post_type = 'st_cars' ";
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
        if (isset( $pick_up_date) && isset($drop_off_date) && !empty($pick_up_date) && !empty($drop_off_date)) {
            $pick_up_date = TravelHelper::convertDateFormat($pick_up_date);
            $drop_off_date = TravelHelper::convertDateFormat($drop_off_date);
          
            $check_in = $pick_up_date . ' ' . $pick_up_time;
            $check_in = strtotime(urldecode($check_in));
            $check_out = $drop_off_date . ' ' . $drop_off_time;
            $check_out = strtotime(urldecode($check_out));
            $list_date = CarHelper::_get_car_cant_order($check_in, $check_out);
            $where .= " AND ({$table_post}.ID NOT IN ({$list_date}))";
            $today = date('Y-m-d');
            $check_in = date('Y-m-d', $check_in);
            $period = STDate::dateDiff($today, $check_in);
            $where .= " AND (CAST({$table_st_cars}.cars_booking_period AS UNSIGNED) <= {$period})";
        }

        if (isset($price_range) && !empty($price_range)) {
           
            $price = $price_range;
            $priceobj = explode(';', $price);
            // convert to default money
            $priceobj[0] = TravelHelper::convert_money_to_default($priceobj[0]);
            $priceobj[1] = TravelHelper::convert_money_to_default($priceobj[1]);
            $where .= " AND ({$table_st_cars}.sale_price >= $priceobj[0]) ";
            if (isset($priceobj[1])) {
                $where .= " AND ({$table_st_cars}.sale_price <= $priceobj[1]) ";
            }
        }
        if(isset($car_tax) && !empty($car_tax)) {
            $jointable = " LEFT JOIN {$table_term_relationships} ON {$table_post}.ID = {$table_term_relationships}.object_id";
            $where .= " AND ({$table_term_relationships}.term_taxonomy_id IN ({$car_tax})) ";
        }else {
            $jointable = "";
        }
        $sql = "SELECT * FROM {$table_post}
        LEFT JOIN {$table_st_cars} ON {$table_post}.ID = {$table_st_cars}.post_id
        $jointable
        WHERE  $where 
        ORDER BY {$table_post}.post_date DESC
        LIMIT $offset,$posts_per_page";
     
        $data = $wpdb->get_results( $wpdb->prepare($sql, $posts_per_page, $offset), ARRAY_A);
        $array_data_cars = [];
        foreach($data as $array_data){
         
            $featured_img_url = get_the_post_thumbnail_url($array_data['ID'],'full'); 
            $category = get_the_terms($array_data['ID'], 'st_category_cars');
            if (!is_wp_error($category) && is_array($category)) {
                $category = array_shift($category);
            }
            $avatar_html = st_get_avatar_in_list_service($array_data['ID'],70);
            $pasenger = (int)get_post_meta($array_data['ID'], 'passengers', true);
            $auto_transmission = get_post_meta($array_data['ID'], 'auto_transmission', true);
            $baggage = (int)get_post_meta($array_data['ID'], 'baggage', true);
            $door = (int)get_post_meta($array_data['ID'], 'door', true);
            $unit = STCars::get_price_unit('label');
            $data_filter_cars  = [
                'ID' => $array_data['ID'],
                'title'  => $array_data['post_title'],
                'link'  => get_permalink( $array_data['ID'] ),
                'image' =>  $featured_img_url,
                'avatar_html' => $avatar_html,
                'car_type' => $category->name,
                'price' => $array_data['sale_price'],
                'discount' =>   $array_data['discount'],
                'pasenger'  => $pasenger,
                'auto_transmission' => $auto_transmission,
                'baggage' => $baggage,
                'door'  => $door,
                'unit'  => $unit,
            ];
          
            $array_data_cars[] = $data_filter_cars;
        }
      
      
        if(!empty($array_data_cars)){
            echo json_encode([
                'success' => true,
                'data' => $array_data_cars,
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

}
 
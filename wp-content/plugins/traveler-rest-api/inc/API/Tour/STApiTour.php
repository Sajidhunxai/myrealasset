<?php 
namespace Inc\API\Tour;
use \WP_REST_Server;
use \WP_REST_Request;
use \TravelHelper;
use \STTour;
use \STDate;
use \STPrice;
use \TourHelper;
use Inc\API\Settings;
use \Inc\API\STApiCore;
use \Nested_set;
if (!class_exists('STApiTour')) {
    class STApiTour extends Settings {
        public $settings = [];
        private $rest_url = 'traveler';

        public function _init_rest_api(){
            
            register_rest_route( $this->rest_url, '/tour-add-to-cart', array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback'    => array($this, 'tour_add_to_cart_api'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'token' => array (
                        'required' => true
                    ),  
                )
            ) );

            register_rest_route( $this->rest_url, '/tour-filter', array(
                'methods' => WP_REST_Server::READABLE,
                'callback'    => array($this, 'tour_filter_api'),
                'permission_callback' => '__return_true',
                'args' => array(),
            ) );

        }

        public function tour_add_to_cart_api(WP_REST_Request $request) {
            $pass_validate = true;
            $get_params = $request->get_params();
            $token = $get_params['token'];
            $item_id =$get_params['item_id'];
            if ($item_id <= 0 || get_post_type($item_id) != 'st_tours') {
                echo json_encode(
                    [
                        'notification' =>  'This tour is not available..',
                        'success'=> false,
                    ]
                );
                die();
            }
            $tour_origin = TravelHelper::post_origin($item_id, 'st_tours');
            $tour_price_by = get_post_meta($tour_origin, 'tour_price_by', true);
            $number = 1;
            $adult_number = (!empty($get_params['adult_number'])) ? $get_params['adult_number'] : 0;
            $child_number = (!empty($get_params['child_number'])) ? $get_params['child_number'] : 0;
            $infant_number = (!empty($get_params['infant_number'])) ? $get_params['infant_number'] : 0;
            $starttime = $get_params['starttime_tour'];
            $data['adult_number'] = $adult_number;
            $data['child_number'] = $child_number;
            $data['infant_number'] = $infant_number;
            $data['starttime'] = $starttime;
            $min_number = intval(get_post_meta($item_id, 'min_people', true));
            if ($min_number <= 0)
                $min_number = 1;
            $max_number = intval(get_post_meta($item_id, 'max_people', true));
            $type_tour = get_post_meta($item_id, 'type_tour', true);
            $data['type_tour'] = $type_tour;
            $data['price_type'] = STTour::get_price_type($item_id);
            $today = date('Y-m-d');
            //echo STInput::request( 'check_in', '' );die;
            $check_in = (!empty($get_params['check_in'])) ? $get_params['check_in'] : '';
            $check_out = (!empty($get_params['check_out'])) ? $get_params['check_out'] : '';
            $check_in = TravelHelper::convertDateFormat($check_in);
            $check_out = TravelHelper::convertDateFormat($check_out);
            
            if (!$adult_number and ! $child_number and ! $infant_number) {
                echo json_encode(
                    [
                        'notification' =>  'Please select at least one person',
                        'success'=> false,
                    ]
                );
                die();
            }
            if ($adult_number + $child_number + $infant_number < $min_number) {
                echo json_encode(
                    [
                        'notification' =>  'Min number of people for this tour is '.$min_number.' people',
                        'success'=> false,
                    ]
                );
                die();
            }

            if (!((new STApiCore)->st_validate_guest_name($tour_origin, $adult_number, $child_number, 0))) {
                echo json_encode(
                    [
                        'notification' =>  'Please enter the Guest Name',
                        'success'=> false,
                    ]
                );
                die();
            }
                
                
                /**
                 * @since 1.2.8
                 *        Only check limit people when max_people > 0 (unlimited)
                 * */
                if ($max_number > 0) {
                    if ($adult_number + $child_number + $infant_number > $max_number) {
                        echo json_encode(
                            [
                                'notification' =>  'Max of people for this tour is '.$max_number.' people',
                                'success'=> false,
                            ]
                        );
                        die();
                    }
                }
                if (!$check_in || !$check_out) {
                    echo json_encode(
                        [
                            'notification' =>  'Select a day in the calendar.',
                            'success'=> false,
                        ]
                    );
                    die();
                }
                if ($tour_price_by != 'fixed_depart') {
                    $compare = TravelHelper::dateCompare($today, $check_in);
                    if ($compare < 0) {
                        echo json_encode(
                            [
                                'notification' =>  'This tour has expired',
                                'success'=> false,
                            ]
                        );
                        die();
                    }
                }
                $booking_period = intval(get_post_meta($item_id, 'tours_booking_period', true));
                $period = STDate::dateDiff($today, $check_in);
                if ($period < $booking_period) {
                    echo json_encode(
                        [
                            'notification' =>  'This tour allow minimum booking is '.$booking_period.' day(s)',
                            'success'=> false,
                        ]
                    );
                    die();
                }
                if ($tour_price_by != 'fixed_depart') {
                    $tour_available = TourHelper::checkAvailableTour($tour_origin, strtotime($check_in), strtotime($check_out));
                    if (!$tour_available) {
                        echo json_encode(
                            [
                                'notification' =>  'The check in, check out day is invalid or this tour not available.',
                                'success'=> false,
                            ]
                        );
                        die();
                    }
                }
                if ($tour_price_by != 'fixed_depart') {
                    if ($max_number > 0) {
                        $free_people = $max_number;
                        if (empty(trim($starttime))) {
                            $result = TourHelper::_get_free_peple($tour_origin, strtotime($check_in), strtotime($check_out));
                        } else {
                            $result = TourHelper::_get_free_peple_by_time($tour_origin, strtotime($check_in), strtotime($check_out), $starttime);
                        }
                        if($tour_price_by == 'fixed'){
                            if(!empty($result) && !empty(trim($starttime))){
                                echo json_encode(
                                    [
                                        'notification' =>  'This tour is not available.',
                                        'success'=> false,
                                    ]
                                );
                                die();
                            }
                            
                        }
                        if (is_array($result) && count($result)) {
                            $free_people = intval($result['free_people']);
                        }
                        /**
                         * @since 1.2.8
                         *        Only check limit people when max_people > 0 (unlimited)
                         * */
                        if ($free_people < ( $adult_number + $child_number + $infant_number )) {
                            if (empty(trim($starttime))) {
                                echo json_encode(
                                    [
                                        'notification' =>  'This tour is only available for '.$free_people.' people',
                                        'success'=> false,
                                    ]
                                );
                                die();
                            
                            } else {
                                echo json_encode(
                                    [
                                        'notification' =>  'This tour is only available for '.$free_people.' people at '.$starttime,
                                        'success'=> false,
                                    ]
                                );
                                die();
                            }
                        }
                    }
                } else {
                    /**
                     * Get Free people
                     * If adult + child + infant < total -> return true
                     * else return false
                     */
                    if ($max_number > 0) {
                        $free_people = TourHelper::getFreePeopleTourFixedDepart($tour_origin, strtotime($check_in), strtotime($check_out));
                        if ($free_people < ( $adult_number + $child_number + $infant_number )) {
                            echo json_encode(
                                [
                                    'notification' =>  'This tour is only available for '.$free_people.' people',
                                    'success'=> false,
                                ]
                            );
                            die();
                        }
                    }
                }
            
                $extras = $get_params['extra_price'];
                $extra_price = STTour::geExtraPrice($extras);
                $data['extras'] = $extras;
                $data['extra_price'] = $extra_price;
                $data['guest_title'] = $get_params['guest_title'];
                $data['guest_name'] = $get_params['guest_name'];

                //Hotel package
                $hotel_packages = $get_params['hotel_package'];
                $arr_hotel_temp = array();
                if (!empty($hotel_packages)) {
                    foreach ($hotel_packages as $k => $v) {
                        if (!empty($v)) {
                            array_push($arr_hotel_temp, $v[0]);
                        }
                    }
                }
                $package_hotels = [];
                if (!empty($arr_hotel_temp)) {
                    $hp = 0;
                    foreach ($arr_hotel_temp as $k => $v) {
                        $sub_hotel_package = json_decode(stripcslashes($v));
                        $package_hotels[$hp] = $sub_hotel_package;
                        $hp++;
                    }
                }
                $package_hotel_price = STTour::_get_hotel_package_price($package_hotels);
                $data['package_hotel'] = $package_hotels;
                $data['package_hotel_price'] = $package_hotel_price;

                //Activity package
                $activity_packages = $get_params['activity_package'];
                $arr_activity_temp = array();
                if (!empty($activity_packages)) {
                    foreach ($activity_packages as $k => $v) {
                        if (!empty($v)) {
                            array_push($arr_activity_temp, $v[0]);
                        }
                    }
                }
                $package_activities = [];
                if (!empty($arr_activity_temp)) {
                    $hp = 0;
                    foreach ($arr_activity_temp as $k => $v) {
                        $sub_activity_package = json_decode(stripcslashes($v));
                        $package_activities[$hp] = $sub_activity_package;
                        $hp++;
                    }
                }
                $package_activity_price = STTour::_get_activity_package_price($package_activities);
                $data['package_activity'] = $package_activities;
                $data['package_activity_price'] = $package_activity_price;

                //Car package
                $car_name_packages_temp = $get_params['car_name'];
                $car_name_packages = array();
                if (!empty($car_name_packages_temp)) {
                    foreach ($car_name_packages_temp as $k => $v) {
                        if (!empty($v)) {
                            array_push($car_name_packages, $v[0]);
                        }
                    }
                }

                $car_price_packages_temp = $get_params['car_price'];
                $car_price_packages = array();
                if (!empty($car_price_packages_temp)) {
                    foreach ($car_price_packages_temp as $k => $v) {
                        if (!empty($v)) {
                            array_push($car_price_packages, $v[0]);
                        }
                    }
                }

                $car_quantity_packages_temp = $get_params['car_quantity'];
                $car_quantity_packages = array();
                if (!empty($car_quantity_packages_temp)) {
                    foreach ($car_quantity_packages_temp as $k => $v) {
                        if (!empty($v)) {
                            array_push($car_quantity_packages, $v[0]);
                        }
                    }
                }

                $package_cars = STTour::_convert_data_car_package($car_name_packages, $car_price_packages, $car_quantity_packages);
                $package_car_price = STTour::_get_car_package_price($package_cars);
                $data['package_car'] = $package_cars;
                $data['package_car_price'] = $package_car_price;

                //Flight package
                $flight_packages = $get_params['flight_package'];
                $arr_flight_temp = array();
                if (!empty($flight_packages)) {
                    foreach ($flight_packages as $k => $v) {
                        if (!empty($v)) {
                            array_push($arr_flight_temp, $v[0]);
                        }
                    }
                }

                $package_flight = [];
                if (!empty($arr_flight_temp)) {
                    $hp = 0;
                    foreach ($arr_flight_temp as $k => $v) {
                        $sub_flight_package = json_decode(stripcslashes($v));
                        $package_flight[$hp] = $sub_flight_package;
                        $hp++;
                    }
                }

                $package_flight_price = STTour::_get_flight_package_price($package_flight);
                $data['package_flight'] = $package_flight;
                $data['package_flight_price'] = $package_flight_price;
                //End flight package
                $price_type = STTour::get_price_type($tour_origin);
                if ($price_type == 'person') {
                    $data_price = STPrice::getPriceByPeopleTour($tour_origin, strtotime($check_in), strtotime($check_out), $adult_number, $child_number, $infant_number);
                } else {
                    $data_price = STPrice::getPriceByFixedTour($tour_origin, strtotime($check_in), strtotime($check_out));
                }
                $total_price = $data_price['total_price'];
                $sale_price = STPrice::getSaleTourSalePrice($tour_origin, $total_price, $type_tour, strtotime($check_in));
                $data['check_in'] = date('m/d/Y', strtotime($check_in));
                $data['check_out'] = date('m/d/Y', strtotime($check_out));
                if ($price_type == 'fixed_depart') {
                    $people_price = array();
                    $people_price['adult_price'] = get_post_meta($tour_origin, 'adult_price', true);
                    $people_price['child_price'] = get_post_meta($tour_origin, 'child_price', true);
                    $people_price['infant_price'] = get_post_meta($tour_origin, 'infant_price', true);
                    $data = wp_parse_args($data, $people_price);
                } elseif ($price_type == 'person') {
                    $people_price = STPrice::getPeoplePrice($tour_origin, strtotime($check_in), strtotime($check_out));
                    $data = wp_parse_args($data, $people_price);
                } else {
                    $fixed_price = STPrice::getFixedPrice($tour_origin, strtotime($check_in), strtotime($check_out));
                    $data = wp_parse_args($data, $fixed_price);
                }
                $data['ori_price'] = $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price;
                $data['sale_price'] = $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price;
                $data['commission'] = TravelHelper::get_commission($item_id);
                $data['data_price'] = $data_price;
                $data['discount_rate'] = STPrice::get_discount_rate($tour_origin, strtotime($check_in));
                $data['discount_type'] = get_post_meta($tour_origin, 'discount_type', true);

                if ($pass_validate) {
                    $data['duration'] = ( $type_tour == 'daily_tour' ) ? get_post_meta($tour_origin, 'duration_day', true) : '';
                    
                    if ($pass_validate) {
                        $st_api_core = new STApiCore;
                        $response = $st_api_core->get_user_from_token($token);
                        $user_id = !empty($response['id']) ? $response['id'] : 0;
                        
                        $data_cart = $st_api_core->add_cart($user_id,$item_id, $number, $total_price + $extra_price + $package_hotel_price + $package_activity_price + $package_car_price + $package_flight_price, $data);
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

        public function tour_filter_api(WP_REST_Request $request) {
            $get_params = $request->get_params();
            $price_range = $get_params['price_range'];
            $price_range = !empty($get_params['price_range']) ? $get_params['price_range'] : '';
            $star_rate = $get_params['star_rate' ];
            $star_rate = !empty($get_params['star_rate']) ? $get_params['star_rate'] : '';
            $tour_tax =  $get_params['tour_tax']; 
            $tour_tax = !empty($get_params['tour_tax']) ? $get_params['tour_tax'] : '';
            $posts_per_page = $get_params['posts_per_page'];
            $posts_per_page = !empty($get_params['posts_per_page']) ? $get_params['posts_per_page'] : st()->get_option( 'tours_posts_per_page', 12 );
            $page = $get_params['paged'];
            $page = !empty($get_params['paged']) ? $get_params['paged'] : 1;
            $location_id = $get_params['location_id'];
            $location_id = !empty($get_params['location_id']) ? $get_params['location_id'] : '';
            $start   = $get_params['start'];
            $start   = !empty($get_params['start']) ? $get_params['start'] : '';
            $end = $get_params['end'];
            $end = !empty($get_params['end']) ? $get_params['end'] : '';
            $post_type = array('st_tours');
            global $wpdb; 
            if( !empty($posts_per_page) || !empty($page) ) {
                $offset = ( $page * $posts_per_page ) - $posts_per_page; 
            }
            $table_st_tours = $wpdb->prefix . 'st_tours'; 
            $table_post = $wpdb->prefix . 'posts';
         
            $table_term_relationships = $wpdb->prefix . 'term_relationships';
        
            $where = "{$table_post}.post_status = 'publish' AND {$table_post}.post_type = 'st_tours' ";
            if ( isset( $location_id ) && !empty($location_id ) ) {
                if ((int) $location_id > 0 && is_array($post_type)) {
                    $ns = new Nested_set();
                    $ns->setControlParams($wpdb->prefix . 'st_location_nested');
    
                    $post_type_in = "";
                    foreach ($post_type as $item) {
                        $post_type_in .= "'" . $item . "',";
                    }
                    $post_type_in = substr($post_type_in, 0, -1);
    
                    $locations = [];
    
                    if (is_array($location_id)) {
                        foreach ($location_id as $location) {
                            $node = $ns->getNodeWhere("location_id = " . (int) $location);
    
                            if (!empty($node)) {
                                $leftval = (int) $node['left_key'];
                                $rightval = (int) $node['right_key'];
                                $node_childs = $ns->getNodesWhere("left_key >= " . $leftval . " AND right_key <= " . $rightval);
                                if (!empty($node_childs)) {
                                    foreach ($node_childs as $item) {
                                        $locations[] = (int) $item['location_id'];
                                    }
                                } else {
                                    $locations[] = (int) $node['location_id'];
                                }
                            }
                        }
                    } elseif (count(explode(',', $location_id)) > 1) {
                        $location_tmp = explode(',', $location_id);
                        foreach ($location_tmp as $k => $v) {
                            $node = $ns->getNodeWhere("location_id = " . $v);
                            if (!empty($node)) {
                                $leftval = (int) $node['left_key'];
                                $rightval = (int) $node['right_key'];
                                $node_childs = $ns->getNodesWhere("left_key >= " . $leftval . " AND right_key <= " . $rightval);
                                if (!empty($node_childs)) {
                                    foreach ($node_childs as $item) {
                                        $locations[] = (int) $item['location_id'];
                                    }
                                } else {
                                    $locations[] = (int) $node['location_id'];
                                }
                            }
                        }
                    } else {
                        $node = $ns->getNodeWhere("location_id = " . $location_id);
                        if (!empty($node)) {
                            $leftval = (int) $node['left_key'];
                            $rightval = (int) $node['right_key'];
                            $node_childs = $ns->getNodesWhere("left_key >= " . $leftval . " AND right_key <= " . $rightval);
                            if (!empty($node_childs)) {
                                foreach ($node_childs as $item) {
                                    $locations[] = (int) $item['location_id'];
                                }
                            } else {
                                $locations[] = (int) $node['location_id'];
                            }
                        }
                    }
    
    
                    $where_location = " 1=1 ";
                    if (!empty($locations)) {
                        $where_location .= " AND location_from IN (";
                        $string = "";
                        foreach ($locations as $location) {
    
                            $string .= "'" . $location . "',";
                        }
                        $string = substr($string, 0, -1);
                        $where_location .= $string . ")";
                    } else {
                        $where_location .= " AND location_from IN ('{$location_id}') ";
                    }
    
                    if (!empty($post_type_in)) {
                        $where_location .= " AND post_type IN ({$post_type_in})";
                    }
    
                    $where .= " AND {$wpdb->prefix}posts.ID IN (SELECT post_id FROM {$wpdb->prefix}st_location_relationships WHERE " . $where_location . ")";
                } else {
                    $post_type_in = "";
                    foreach ($post_type as $item) {
                        $post_type_in .= "'" . $item . "',";
                    }
                    $post_type_in = substr($post_type_in, 0, -1);
                    $where_location = " AND location_from IN ('{$location_id}') ";
                    if (!empty($post_type_in)) {
                        $where_location .= " AND post_type IN ({$post_type_in})";
                    }
                    $where .= " AND {$wpdb->prefix}posts.ID IN (SELECT post_id FROM {$wpdb->prefix}st_location_relationships WHERE " . $where_location . ")";
                }
            }
            if (!empty($start) && !empty($end)) {
                $list_date = TourHelper::_tourValidate(strtotime(TravelHelper::convertDateFormat($start)), strtotime(TravelHelper::convertDateFormat($end)));
                $where .= " AND {$wpdb->posts}.ID IN ({$list_date})";
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
                    $where .= " AND {$table_st_tours}.rate_review IN ($list_star)";
                }
            }
         
            if (isset($price_range) && !empty($price_range)) {
               
                $price = $price_range;
                $priceobj = explode(';', $price);
                // convert to default money
                $priceobj[0] = TravelHelper::convert_money_to_default($priceobj[0]);
                $priceobj[1] = TravelHelper::convert_money_to_default($priceobj[1]);
                $where .= " AND ({$table_st_tours}.min_price >= $priceobj[0]) ";
                if (isset($priceobj[1])) {
                    $where .= " AND ({$table_st_tours}.min_price <= $priceobj[1]) ";
                }
            }
            if(isset($tour_tax) && !empty($tour_tax)) {
                $jointable = " LEFT JOIN {$table_term_relationships} ON {$table_post}.ID = {$table_term_relationships}.object_id";
                $where .= " AND ({$table_term_relationships}.term_taxonomy_id IN ({$tour_tax})) ";
            }else {
                $jointable = "";
            }
            $sql = "SELECT * FROM {$table_post}
            LEFT JOIN {$table_st_tours} ON {$table_post}.ID = {$table_st_tours}.post_id
            $jointable
            WHERE  $where 
            ORDER BY {$table_post}.post_date DESC
            LIMIT $offset,$posts_per_page";
            $data = $wpdb->get_results( $wpdb->prepare($sql, $posts_per_page, $offset), ARRAY_A);
            $array_data_tours = [];
            foreach($data as $array_data){
             
                $featured_img_url = get_the_post_thumbnail_url($array_data['ID'],'full'); 
                
                $data_filter_tours  = [
                    'ID' => $array_data['ID'],
                    'title'  => $array_data['post_title'],
                    'link'  => get_permalink( $array_data['ID'] ),
                    'image' =>  $featured_img_url,
                    'location' => $array_data['address'],
                    'rate_review' => $array_data['rate_review'],
                    'price' => $array_data['min_price'],
                    'discount' =>   $array_data['discount'],
                    'duration_day'  => $array_data['duration_day'],
                ];
              
                $array_data_tours[] = $data_filter_tours;
            }
          
          
            if(!empty($array_data_tours)){
                echo json_encode([
                    'success' => true,
                    'data' => $array_data_tours,
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
}
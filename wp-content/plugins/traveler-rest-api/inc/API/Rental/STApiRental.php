<?php 
namespace Inc\API\Rental;
use \WP_REST_Server;
use \WP_REST_Request;
use \TravelHelper;
use \STRental;
use \STDate;
use \STPrice;
use \RentalHelper;
use Inc\API\Settings;
use \Inc\API\STApiCore;
use \ST_Rental_Availability;
use \Nested_set;
class STApiRental extends Settings {
    public $settings = [];
    private $rest_url = 'traveler';

    public function _init_rest_api(){
        
        register_rest_route( $this->rest_url, '/rental-add-to-cart', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback'    => array($this, 'rental_add_to_cart_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'token' => array (
                    'required' => true
                ),  
            )
        ) );
        
         
        register_rest_route( $this->rest_url, '/rental-filter', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'rental_filter_api'),
            'permission_callback' => '__return_true',
            'args' => array(),
        ) );


    }
    public function rental_add_to_cart_api(WP_REST_Request $request) {
        $form_validate = true;
        $get_params = $request->get_params();
        $token = $get_params['token'];
        $item_id = $get_params['item_id'];
            if ($item_id <= 0 || get_post_type($item_id) != 'st_rental') {
                echo json_encode(
                    [
                        'notification' =>  'This hotel is not available.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            $rental_origin = (int)TravelHelper::post_origin($item_id, 'st_rental');
           
            $check_in = $get_params['start'];
            if (empty($check_in)) {
                echo json_encode(
                    [
                        'notification' =>  'The check in field is required.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            $check_in = TravelHelper::convertDateFormat($check_in);
            $check_out = $get_params['end'];
            if (empty($check_out)) {
                echo json_encode(
                    [
                        'notification' =>  'The check out field is required.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            $check_out = TravelHelper::convertDateFormat($check_out);
            if (strtotime($check_out) - strtotime($check_in) <= 0) {
                echo json_encode(
                    [
                        'notification' =>  'The check-out is later than the check-in.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
            }
            $today = date('m/d/Y');
            $booking_period = get_post_meta($rental_origin, 'rentals_booking_period', true);
            if (empty($booking_period) || $booking_period <= 0) $booking_period = 0;
            $period = STDate::dateDiff($today, $check_in);
            $compare = TravelHelper::dateCompare($today, $check_in);
            $booking_min_day = intval(get_post_meta($rental_origin, 'rentals_booking_min_day', true));
            if ($compare < 0) {
                echo json_encode(
                    [
                        'notification' =>  'You can not set check-in date in the past',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            if ($period < $booking_period) {
                echo json_encode(
                    [
                        'notification' =>  'This rental required minimum booking is '.$booking_period.' day(s) before return',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            $booking_min_day_diff = STDate::dateDiff($check_in, $check_out);
            if ($booking_min_day) {
                
                if ($booking_min_day_diff < $booking_min_day) {
                    echo json_encode(
                        [
                            'notification' =>  'Please book at least '.$booking_min_day.' day(s) in total',
                            'success'=> false,
                        ]
                    );
                    $form_validate = false;
                    return false;
                }
            }
            $adult_number = intval($get_params['adult_number']);
            $child_number = intval($get_params['child_number']);
            $max_adult = intval(get_post_meta($rental_origin, 'rental_max_adult', true));
            $max_children = intval(get_post_meta($rental_origin, 'rental_max_children', true));
            if ($adult_number > $max_adult) {
                echo json_encode(
                    [
                        'notification' =>  'A maximum number of adult(s): '.$max_adult,
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            if ($child_number > $max_children) {
                echo json_encode(
                    [
                        'notification' =>  'A maximum number of children: '.$max_children,
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            $number_room = intval(get_post_meta($rental_origin, 'rental_number', true));
            $check_in_tmp = date('Y-m-d', strtotime($check_in));
            $check_out_tmp = date('Y-m-d', strtotime($check_out));
            if (!RentalHelper::check_day_cant_order($rental_origin, $check_in_tmp, $check_out_tmp, 1)) {
                echo json_encode(
                    [
                        'notification' =>  'This rental is not available from' .$check_in_tmp. 'to' .$check_out_tmp,
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            if (!RentalHelper::_check_room_available($rental_origin,strtotime($check_in_tmp) , strtotime($check_out_tmp))) {
                echo json_encode(
                    [
                        'notification' =>  'This rental is not available.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
            if (!RentalHelper::_check_has_groupday($rental_origin, $check_in_tmp, $check_out_tmp)) {
                echo json_encode(
                    [
                        'notification' =>  'This rental is not available.',
                        'success'=> false,
                    ]
                );
                $form_validate = false;
                return false;
            }
        
            if (!((new STApiCore)->st_validate_guest_name($rental_origin, $adult_number, $child_number, 0))) {
                echo json_encode(
                    [
                        'notification' =>  'Please enter the Guest Name',
                        'success'=> false,
                    ]
                );
                $pass_validate = FALSE;
                return FALSE;
            }
            $item_price = STPrice::getRentalPriceOnlyCustomPrice($rental_origin, strtotime($check_in), strtotime($check_out));
            $extras = $get_params['extra_price'];
            $numberday = STDate::dateDiff($check_in, $check_out);
            $extra_price = STPrice::getExtraPrice($rental_origin, $extras, 1, $numberday);
            $price_sale = STPrice::getSalePrice($rental_origin, strtotime($check_in), strtotime($check_out));
            $discount_rate = STPrice::get_discount_rate($rental_origin, strtotime($check_in));
            $data = [
                'item_price' => $item_price,
                'ori_price' => $price_sale + $extra_price,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'adult_number' => $adult_number,
                'child_number' => $child_number,
                'extras' => $extras,
                'extra_price' => $extra_price,
                'commission' => TravelHelper::get_commission($item_id),
                'discount_rate' => $discount_rate,
                'guest_title' => $get_params['guest_title'],
                'guest_name' => $get_params['guest_name'],
                'total_price_origin' => $item_price,
            ];
            if ($form_validate)
                $form_validate = apply_filters('st_rental_add_cart_validate', $form_validate);
            if ($form_validate) {
                
               
                $st_api_core = new STApiCore;
                $response = $st_api_core->get_user_from_token($token);
                $user_id = !empty($response['id']) ? $response['id'] : 0;
                $data_cart = $st_api_core->add_cart($user_id,$item_id, 1, $item_price, $data);
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

    public function rental_filter_api(WP_REST_Request $request) {
        $get_params = $request->get_params();
        $price_range = $get_params['price_range'];
        $price_range = !empty($get_params['price_range']) ? $get_params['price_range'] : '';
        $star_rate = $get_params['star_rate' ];
        $star_rate = !empty($get_params['star_rate']) ? $get_params['star_rate'] : '';
        $rental_tax =  $get_params['rental_tax']; 
        $rental_tax = !empty($get_params['rental_tax']) ? $get_params['rental_tax'] : '';
        $posts_per_page = $get_params['posts_per_page'];
        $posts_per_page = !empty($get_params['posts_per_page']) ? $get_params['posts_per_page'] : st()->get_option( 'rental_posts_per_page', 12 );
        $page = $get_params['paged'];
        $page = !empty($get_params['page']) ? $get_params['page'] : 1;
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
        $post_type = array('st_rental');
        global $wpdb; 
        if( !empty($posts_per_page) || !empty($page) ) {
            $offset = ( $page * $posts_per_page ) - $posts_per_page; 
        }
        $table_st_rental = $wpdb->prefix . 'st_rental'; 
        $table_post = $wpdb->prefix . 'posts';
     
        $table_term_relationships = $wpdb->prefix . 'term_relationships';
    
        $where = "{$table_post}.post_status = 'publish' AND {$table_post}.post_type = 'st_rental' ";
       
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
        if (empty($check_in)) {
            $check_in = date('Y-m-d');
        } else {
            $check_in = date('Y-m-d', strtotime(TravelHelper::convertDateFormat($check_in)));
        }
        if (empty($check_out)) {
            $check_out = date('Y-m-d', strtotime('+1 day', strtotime($check_in)));
        } else {
            $check_out = date('Y-m-d', strtotime(TravelHelper::convertDateFormat($check_out)));
        }
        if (!empty($check_in) && !empty($check_out)) {
            $today = date('m/d/Y');
            $period = STDate::dateDiff($today, $check_in);
           
            if (intval($adult_number) < 0) $adult_number = 0;
          
            if (intval($children_number) < 0) $children_number = 0;
            $avai_check = st()->get_option('rental_availability_check', 'on');
            if ($avai_check === 'on') {
                $list_rental = $this->get_unavailable_rental($check_in, $check_out);
                if (is_array($list_rental) and !empty($list_rental)) {
                    $list_rental = implode(',', $list_rental);
                    $where .= " AND {$wpdb->posts}.ID NOT IN ({$list_rental})";
                }
                $where .= " AND CAST({$table_st_rental}.rentals_booking_period AS UNSIGNED) <= {$period}";
            }
            
        }
        if (!empty($adult_number)) {
            $where .= " AND {$table_st_rental}.rental_max_adult>= {$adult_number}";
        }
        if (!empty($children_number)) {
            $where .= " AND {$table_st_rental}.rental_max_children>= {$children_number}";
        }
        if (isset($price_range) && !empty($price_range)) {
           
            $price = $price_range;
            $priceobj = explode(';', $price);
            // convert to default money
            $priceobj[0] = TravelHelper::convert_money_to_default($priceobj[0]);
            $priceobj[1] = TravelHelper::convert_money_to_default($priceobj[1]);
            $where .= " AND ({$table_st_rental}.sale_price >= $priceobj[0]) ";
            if (isset($priceobj[1])) {
                $where .= " AND ({$table_st_rental}.sale_price <= $priceobj[1]) ";
            }
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
                $where .= " AND {$table_st_rental}.rate_review IN ($list_star)";
            }
        }
        if(isset($rental_tax) && !empty($rental_tax)) {
            $jointable = " LEFT JOIN {$table_term_relationships} ON {$table_post}.ID = {$table_term_relationships}.object_id";
            $where .= " AND ({$table_term_relationships}.term_taxonomy_id IN ({$rental_tax})) ";
        }else {
            $jointable = "";
        }
        $sql = "SELECT * FROM {$table_post}
        LEFT JOIN {$table_st_rental} ON {$table_post}.ID = {$table_st_rental}.post_id
        $jointable
        WHERE  $where 
        ORDER BY {$table_post}.post_date DESC
        LIMIT $offset,$posts_per_page";
     
        $data = $wpdb->get_results( $wpdb->prepare($sql, $posts_per_page, $offset), ARRAY_A);
        $array_data_rental = [];
        foreach($data as $array_data){
         
            $featured_img_url = get_the_post_thumbnail_url($array_data['ID'],'full'); 
          
            $avatar_html = st_get_avatar_in_list_service($array_data['ID'],70);

            $people = (int)get_post_meta($array_data['ID'], 'rental_max_adult', true) + (int)get_post_meta($array_data['ID'], 'rental_max_children', true);
            $bed = (int)get_post_meta($array_data['ID'], 'rental_bed', true);
            $bath = (int)get_post_meta($array_data['ID'], 'rental_bath', true);
            $rental_size = (int)get_post_meta($array_data['ID'], 'rental_size', true);
            $data_filter_rental  = [
                'ID' => $array_data['ID'],
                'title'  => $array_data['post_title'],
                'link'  => get_permalink( $array_data['ID'] ),
                'image' =>  $featured_img_url,
                'avatar_html' => $avatar_html,
                'address'  => $array_data['address'],
                'price' => $array_data['sale_price'],
                'people' => $people,
                'bed' => $bed,
                'bath' => $bath,
                'rental_size' => $rental_size,
                'rate_review' => $array_data['rate_review'],
                'discount' =>   $array_data['discount'],
            ];
          
            $array_data_rental[] = $data_filter_rental;
        }
      
      
        if(!empty($array_data_rental)){
            echo json_encode([
                'success' => true,
                'data' => $array_data_rental,
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
    function get_unavailable_rental($check_in, $check_out)
    {
        
        $check_in = strtotime($check_in);
        $check_out = strtotime($check_out);
        $res = ST_Rental_Availability::inst()
            ->select('post_id')
            ->where('check_in >=', $check_in)
            ->where('check_out <=', $check_out)
            ->where("(status = 'unavailable' OR (number - number_booked <= 0))", null, true)
            ->groupby('post_id')
            ->get()->result();
            
        $list = [];
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                array_push($list, $v['post_id']);
            }
        }
      
        return $list;
    }
}
 
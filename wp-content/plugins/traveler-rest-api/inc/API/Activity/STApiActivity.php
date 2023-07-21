<?php 
namespace Inc\API\Activity;
use \WP_REST_Server;
use \WP_REST_Request;
use \TravelHelper;
use \STActivity;
use \STDate;
use \STPrice;
use \ActivityHelper;
use Inc\API\Settings;
use \Inc\API\STApiCore;
use \Nested_set;
class STApiActivity extends Settings {
    public $settings = [];
    private $rest_url = 'traveler';

    public function _init_rest_api(){
        
        register_rest_route( $this->rest_url, '/activity-add-to-cart', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback'    => array($this, 'activity_add_to_cart_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'token' => array (
                    'required' => true
                ),  
            )
        ) );
        
        register_rest_route( $this->rest_url, '/activity-filter', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'activity_filter_api'),
            'permission_callback' => '__return_true',
            'args' => array(),
        ) );

    }
    public function activity_add_to_cart_api(WP_REST_Request $request) {
        $pass_validate = true;
        $get_params = $request->get_params();
        $token = $get_params['token'];
        $item_id = $get_params['item_id'];
        if ( $item_id <= 0 || get_post_type( $item_id ) != 'st_activity' ) {
            echo json_encode(
                [
                    'notification' =>  'This activity is not available..',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        $post_origin = TravelHelper::post_origin( $item_id, 'st_activity' );
        $number                  = 1;
        $adult_number = (!empty(intval($get_params['adult_number']))) ? intval($get_params['adult_number']) : 0;
        $child_number = (!empty(intval($get_params['child_number']))) ? intval($get_params['child_number']) : 0;
        $infant_number = (!empty(intval($get_params['infant_number']))) ? intval($get_params['infant_number']) : 0;
        $starttime = (!empty($get_params['starttime'])) ? intval($get_params['starttime']) : '';
        if(isset($starttime) && $starttime != '')
            $data['starttime'] = $starttime;
        $data[ 'adult_number' ]  = $adult_number;
        $data[ 'child_number' ]  = $child_number;
        $data[ 'infant_number' ] = $infant_number;
        $max_number              = intval( get_post_meta( $post_origin, 'max_people', true ) );
        $type_activity           = get_post_meta( $post_origin, 'type_activity', true );
        $data[ 'type_activity' ] = $type_activity;
        $today                   = date( 'Y-m-d' );
        $check_in = (!empty($get_params['check_in'])) ? $get_params['check_in'] : '';
        $check_in                = TravelHelper::convertDateFormat( $check_in );
        $check_out = (!empty($get_params['check_out'])) ? $get_params['check_out'] : '';
        $check_out               = TravelHelper::convertDateFormat($check_out);
        if ( !$adult_number and !$child_number and !$infant_number ) {
            echo json_encode(
                [
                    'notification' =>  'Please select at least one person.',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        if ( !$check_in || !$check_out ) {
            echo json_encode(
                [
                    'notification' =>  'Select an activity in the calendar.',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        $compare = TravelHelper::dateCompare( $today, $check_in );
        if ( $compare < 0 ) {
            echo json_encode(
                [
                    'notification' =>  'This activity has expired',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        $booking_period = intval( get_post_meta( $post_origin, 'activity_booking_period', true ) );
        $period         = STDate::dateDiff( $today, $check_in );
        if ( $period < $booking_period ) {
            echo json_encode(
                [
                    'notification' =>  'This activity allow minimum booking is '.$booking_period.' day(s)',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        $min_number = intval( get_post_meta( $post_origin, 'min_people', true ) );
        if(empty($min_number))
            $min_number = 1;
        if($max_number > 0){
            if($min_number > $max_number){
                $min_number = $max_number;
            }
        }
        if($min_number > 0){
            if ( $adult_number + $child_number + $infant_number < $min_number ) {
                echo json_encode(
                    [
                        'notification' =>  'Min of people for this activity is '.$min_number.' people',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        if ( $max_number > 0 ) {
            if ( $adult_number + $child_number + $infant_number > $max_number ) {
                echo json_encode(
                    [
                        'notification' =>  'Max of people for this activity is '.$max_number.' people',
                        'success'=> false,
                    ]
                );
                $pass_validate = false;
                return false;
            }
        }
        $tour_available = ActivityHelper::checkAvailableActivity( $post_origin, strtotime( $check_in ), strtotime( $check_out ) );
        if ( !$tour_available ) {
            echo json_encode(
                [
                    'notification' =>  'The check in, check out day is not invalid or this activity not available.',
                    'success'=> false,
                ]
            );
            $pass_validate = false;
            return false;
        }
        if ( $max_number > 0 ) {
            $free_people = $max_number;
            if(empty(trim($starttime))){
                $result      = ActivityHelper::_get_free_peple( $post_origin, strtotime( $check_in ), strtotime( $check_out ) );
            }else{
                $result      = ActivityHelper::_get_free_peple_by_time( $post_origin, strtotime( $check_in ), strtotime( $check_out ), $starttime );
            }
            if ( is_array( $result ) && count( $result ) ) {
                $free_people = intval( $result[ 'free_people' ] );
            }
            if ( $free_people < ( $adult_number + $child_number + $infant_number ) ) {
                if($starttime != '')
                    echo json_encode(
                        [
                            'notification' =>  'This activity only vacant '.$free_people.' people at'. $starttime,
                            'success'=> false,
                        ]
                    );
                else
                    echo json_encode(
                        [
                            'notification' =>  'This activity only vacant '.$free_people.' people',
                            'success'=> false,
                        ]
                    );
                $pass_validate = false;
                return false;
            }
        }
        $extras = (!empty($get_params['extra_price'])) ? $get_params['extra_price'] : [];
        $extra_price           = (new STActivity)->geExtraPrice( $extras );
        $data[ 'extras' ]      = $extras;
        $data[ 'extra_price' ] = $extra_price;
        $data_price            = STPrice::getPriceByPeopleTour( $post_origin, strtotime( $check_in ), strtotime( $check_out ), $adult_number, $child_number, $infant_number );
        $total_price           = $data_price[ 'total_price' ];
        $sale_price            = STPrice::getSaleTourSalePrice( $post_origin, $total_price, false, strtotime( $check_in ) );
        $data[ 'check_in' ]    = date( 'm/d/Y', strtotime( $check_in ) );
        $data[ 'check_out' ]   = date( 'm/d/Y', strtotime( $check_out ) );
        $people_price          = STPrice::getPeoplePrice( $post_origin, strtotime( $check_in ), strtotime( $check_out ) );
        $data                  = wp_parse_args( $data, $people_price );
        $data[ 'ori_price' ]   = $total_price + $extra_price;
        $data[ 'commission' ]    = TravelHelper::get_commission( $post_origin );
        $data[ 'data_price' ]    = $data_price;
        $data[ 'discount_rate' ] = STPrice::get_discount_rate( $post_origin, strtotime( $check_in ) );
        $data['guest_title'] = $get_params['guest_title'];
        $data['guest_name'] =$get_params['guest_name'];
        $data['discount_type'] = get_post_meta( $post_origin, 'discount_type', true );
        if ( $pass_validate ) {
            $data[ 'duration' ] = ( $type_activity == 'daily_activity' ) ? ( get_post_meta( $item_id, 'duration', true ) ) : '';
            if ( $pass_validate ) {
                $st_api_core = new STApiCore;
                $response = $st_api_core->get_user_from_token($token);
                $user_id = !empty($response['id']) ? $response['id'] : 0;
           
                
                $data_cart = $st_api_core->add_cart($user_id,$item_id, $number, $total_price + $extra_price, $data );
            
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

    public function activity_filter_api(WP_REST_Request $request) {
        
        $get_params = $request->get_params();
        $price_range = $get_params['price_range'];
        $price_range = !empty($get_params['price_range']) ? $get_params['price_range'] : '';
        $star_rate = $get_params['star_rate' ];
        $star_rate = !empty($get_params['star_rate']) ? $get_params['star_rate'] : '';
        $activity_tax =  $get_params['activity_tax']; 
        $activity_tax = !empty($get_params['activity_tax']) ? $get_params['activity_tax'] : '';
        $posts_per_page = $get_params['posts_per_page'];
        $posts_per_page = !empty($get_params['posts_per_page']) ? $get_params['posts_per_page'] : st()->get_option( 'activity_posts_per_page', 12 );
        
        $page = $get_params['paged'];
        $page = !empty($get_params['paged']) ? $get_params['paged'] : 1;
        $location_id = $get_params['location_id'];
        $location_id = !empty($get_params['location_id']) ? $get_params['location_id'] : '';
        $start = $get_params['start_date'];
        $start = !empty($get_params['start_date']) ? $get_params['start_date'] : '';
        $end   = $get_params['end_date'];
        $end = !empty($get_params['end_date']) ? $get_params['end_date'] : '';
        $post_type = array('st_activity');
        global $wpdb; 
        if( !empty($posts_per_page) || !empty($page) ) {
            $offset = ( $page * $posts_per_page ) - $posts_per_page; 
        }
       
        $table_st_activity = $wpdb->prefix . 'st_activity'; 
        $table_post = $wpdb->prefix . 'posts';
     
        $table_term_relationships = $wpdb->prefix . 'term_relationships';
    
        $where = "{$table_post}.post_status = 'publish' AND {$table_post}.post_type = 'st_activity' ";
    
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
        if ( !empty( $start ) && !empty( $end ) ) {
            $list_date = ActivityHelper::_activityValidate(strtotime( TravelHelper::convertDateFormat( $start ) ), strtotime( TravelHelper::convertDateFormat( $end ) ));
            $where .= " AND {$table_post}.ID IN ({$list_date})";
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
                $where .= " AND {$table_st_activity}.rate_review IN ($list_star)";
            }
        }
     
        if (isset($price_range) && !empty($price_range)) {
           
            $price = $price_range;
            $priceobj = explode(';', $price);
            // convert to default money
            $priceobj[0] = TravelHelper::convert_money_to_default($priceobj[0]);
            $priceobj[1] = TravelHelper::convert_money_to_default($priceobj[1]);
            $where .= " AND ({$table_st_activity}.adult_price >= $priceobj[0]) ";
            if (isset($priceobj[1])) {
                $where .= " AND ({$table_st_activity}.adult_price <= $priceobj[1]) ";
            }
        }
        if(isset($activity_tax) && !empty($activity_tax)) {
           
            $jointable = " LEFT JOIN {$table_term_relationships} ON {$table_post}.ID = {$table_term_relationships}.object_id";
            $where .= " AND ({$table_term_relationships}.term_taxonomy_id IN ({$activity_tax})) ";
        }else {
            $jointable = "";
        }

        $sql = "SELECT * FROM {$table_post}
        LEFT JOIN {$table_st_activity} ON {$table_post}.ID = {$table_st_activity}.post_id
        $jointable
        WHERE  $where 
        ORDER BY {$table_post}.post_date DESC
        LIMIT $offset,$posts_per_page";
       
        $data = $wpdb->get_results( $wpdb->prepare($sql, $posts_per_page, $offset), ARRAY_A);
        $array_data_activity = [];
        foreach($data as $array_data){
         
            $featured_img_url = get_the_post_thumbnail_url($array_data['ID'],'full'); 
            
            $data_filter_activity  = [
                'ID' => $array_data['ID'],
                'title'  => $array_data['post_title'],
                'link'  => get_permalink( $array_data['ID'] ),
                'image' =>  $featured_img_url,
                'location' => $array_data['address'],
                'rate_review' => $array_data['rate_review'],
                'price' => $array_data['adult_price'],
                'discount' =>   $array_data['discount'],
                'duration'  => $array_data['duration'],
            ];
          
            $array_data_activity[] = $data_filter_activity;
        }
      
      
        if(!empty($array_data_activity)){
            echo json_encode([
                'success' => true,
                'data' => $array_data_activity,
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
 
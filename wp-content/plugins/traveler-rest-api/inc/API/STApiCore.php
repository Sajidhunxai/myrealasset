<?php
declare(strict_types=1);
namespace Inc\API;
use \STPrice;
use \STCart;
use \STPaymentGateways;
use \STTemplate;
use \TravelHelper;
use \STInput;
class STApiCore
{
    public function get_settings() {
        add_filter('stOtherSetings',[$this,'_stOtherSetings'],10 , 1);
	}

    public function get_user_from_token($token=''){
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
            ),
        );
        $response = wp_remote_get( get_site_url().'/wp-json/wp/v2/users/me', $args );
        $response_body = json_decode( wp_remote_retrieve_body( $response ), true );
        if($response_body['code'] != 'jwt_auth_invalid_token'){
            return $response_body;
        } else {
            return -1;
        }
        
    }
    
	public function add_cart( $user_id,$item_id, $number = 1, $price = false, $data = [])
    {
    
        $st_booking_post_type = '';
        if($item_id == 'car_transfer'){
            $st_booking_post_type = 'car_transfer';
        }elseif($item_id == 'travelport_api'){
            $st_booking_post_type = 'travelport_api';
        }else{
            $st_booking_post_type = get_post_type($item_id);
        }
        $data['st_booking_post_type'] = $st_booking_post_type;
        $data['st_booking_id'] = ($item_id == 'car_transfer') ? $data['car_id'] : $item_id;
        $data['sharing'] = get_post_meta($item_id, 'sharing_rate', true);
        $data['duration_unit'] = STCart::get_duration_unit($item_id); // from 1.1.9
        //check is woocommerce
        $st_is_woocommerce_checkout = apply_filters('st_is_woocommerce_checkout', false);
        //Enable booking fee for woocommerce
        $data = STCart::_get_data_booking_fee($price, $data);
        $number = intval($number);
        $title_cart = '';
        if($item_id == 'car_transfer'){
            $title_cart = $data['pick_up'] . ' - ' . $data['drop_off'];
        }elseif($item_id == 'travelport_api'){
            $title_cart = $data['fromCode'] . ' - ' . $data['toCode'];
        }else{
            $title_cart = get_the_title($item_id);
        }
        $data['title_cart'] = $title_cart;
        $cart_data = [
            'number' => $number,
            'price' => $price,
            'data' => $data,
            'title'  => ( $item_id == 'car_transfer' ) ? $data['pick_up'] . ' - ' . $data['drop_off'] : get_the_title( $item_id )
        ];
        
        if ($st_is_woocommerce_checkout) {
            $cart_data['price'] = floatval($data['ori_price']);
            $cart_data['data']['total_price'] = floatval($data['ori_price']);
            if (get_post_type($item_id) == 'st_hotel') {
                $post_id = intval($cart_data['data']['room_id']);
            } else {
                $post_id = intval($item_id);
            }
            if ($item_id == 'car_transfer') {
                $post_id = (int)$data['car_id'];
            }
            $product_id = STCart::_create_new_product($post_id, $cart_data);
            if ($product_id) {
                STCart::_add_product_to_cart($product_id, $cart_data['data']);
            }
        } else {
            if (get_post_type($item_id) == 'st_hotel') {
                $post_id = intval($cart_data['data']['room_id']);
            } else {
                if ($item_id == 'car_transfer') {
                    $post_id = $data['car_id'];
                } else {
                    $post_id = intval($item_id);
                }
            }
            $cart_data = STPrice::getDepositData($post_id, $cart_data);
        }
        $cart_data['data']['user_id'] = $user_id;
        STCart::destroy_cart();
        if (isset($cart_data['data']['transfer_from'])) {
            $data_cart['car_transfer'] = $cart_data;
            STCart::set_cart('st_cart', $data_cart);
        } else {
            $data_cart[$item_id] = $cart_data;
            STCart::set_cart('st_cart', $data_cart);
        }
        return $data_cart;
    }

    public function st_validate_guest_name ($guest_title,$guest_name,$post_id, $adult_number = 0, $children_number = 0, $infant_number = 0) {
        $passValidate = true;
        $total = $adult_number;
        $disable_adult_name = get_post_meta($post_id, 'disable_adult_name', true);
        $disable_children_name = get_post_meta($post_id, 'disable_children_name', true);
        $disable_infant_name = get_post_meta($post_id, 'disable_infant_name', true);
        if ($disable_adult_name == 'on'){
            $total = 0;
        }
           
        if ($disable_children_name != 'on'){
            $total += $children_number;
        }
            
        if ($disable_infant_name != 'on'){
            $total += $infant_number;
        }
            
        if($total > 1){
            $total -= 1;
        }
        
        if ($total > 0) {
            
                
            if (empty($guest_name) or ! is_array($guest_name) or count($guest_name) < $total){
                $passValidate = false;
            }
                
            if (empty($guest_title) or ! is_array($guest_title) or count($guest_title) < $total){
                $passValidate = false;
            }
                
            if ($passValidate) {
                for ($i = 0; $i < $total; $i++) {
                    if (empty($guest_name[$i]) or empty($guest_title[$i]))
                        $passValidate = false;
                }
            }
        }
        return $passValidate;
    }

    public function booking_form_submit($user_id,$data_cart,$st_email,$st_first_name,$st_last_name,$st_phone,$st_address,$st_address2,$st_city,$st_province,$st_zip_code,$st_country,$st_note,$term_condition) {
        
        $selected = 'st_submit_form';
            $first_item_id = STCart::get_booking_id();
            //travelport_api
            // All gateway available
            $gateways = STPaymentGateways::get_payment_gateways();
            if (empty($gateways)) {
                echo json_encode(
                    [
                        'status' => false,
                        'message' => __('Sorry! No payment gateway available', 'traveler')
                    ]
                );
                die();
            }
            $payment_gateway_id = $selected;
            $payment_gateway_used = STPaymentGateways::get_gateway($payment_gateway_id, $first_item_id);
            if (!$payment_gateway_id or !$payment_gateway_used) {
                $payment_gateway_name = apply_filters('st_payment_gateway_' . $payment_gateway_id . '_name', $payment_gateway_id);
                echo json_encode(
                    [
                        'status' => false,
                        'message' => __('Sorry! Payment Gateway: <code>'.$payment_gateway_name.'</code> is not available for this item!', 'traveler')
                    ]
                );
                die();
            }
      
        
            $booking_by =  '';
            if ($booking_by != 'partner') {
                if (!$data_cart) {
                    echo json_encode(
                        [
                            'status' => false,
                            'message' => __('Your cart is currently empty.', 'traveler'),
                            'code' => '1'
                        ]
                    );
                    die();
                }
            } else {
                if (!$data_cart) {
                    echo json_encode(
                        [
                            'status' => 'partner',
                            'message' => '',
                            'code' => '1'
                        ]
                    );
                    die();
                }
            }
            

            //Term and condition
            if (!$term_condition) {
                echo json_encode(
                    [
                        'status' => false,
                        'message' => __('Please accept our terms and conditions', 'traveler')
                    ]
                );
                die();
            }
        
          
            $post = [
                'post_title' => __('Order', 'traveler') . ' - ' . date(get_option('date_format')) . ' @ ' . date(get_option('time_format')),
                'post_type' => 'st_order',
                'post_status' => 'publish'
            ];
            $data_price = STPrice::getDataPrice();
            //save the order
            $insert_post = wp_insert_post($post);
          
            if ($insert_post) {
               
                $fields = [
                    'st_email' => $st_email,
                    'st_first_name' =>$st_first_name,
                    'st_last_name' => $st_last_name,
                    'st_phone'=>$st_phone,
                    'st_address'=>$st_address,
                    'st_address2'=>$st_address2,
                    'st_city'=>$st_city,
                    'st_province'=>$st_province,
                    'st_zip_code'=>$st_zip_code,
                    'st_country' => $st_country,
                    'st_note'=>$st_note];
                if (!empty($fields)) {
                    foreach ($fields as $key => $value) {
                        update_post_meta($insert_post, $key, $value);
                    }
                }
               
                if ($user_id) {
                    //Now Update the Post Meta
                    update_post_meta($insert_post, 'id_user', $user_id);
                    //Update User Meta
                    update_user_meta($user_id, 'st_phone', $st_phone);
                    update_user_meta($user_id, 'first_name', $st_first_name);
                    update_user_meta($user_id, 'last_name', $st_last_name);
                    update_user_meta($user_id, 'st_address', $st_address);
                    update_user_meta($user_id, 'st_address2', $st_address2);
                    update_user_meta($user_id, 'st_city', $st_city);
                    update_user_meta($user_id, 'st_province', $st_province);
                    update_user_meta($user_id, 'st_zip_code', $st_zip_code);
                    update_user_meta($user_id, 'st_country', $st_country);
                }
                STCart::saveOrderItems($insert_post);
                do_action('st_save_order_other_table', $insert_post);
                update_post_meta($insert_post, 'st_tax', STPrice::getTax());
                update_post_meta($insert_post, 'st_tax_percent', STPrice::getTax());
                update_post_meta($insert_post, 'st_is_tax_included_listing_page', STCart::is_tax_included_listing_page() ? 'on' : 'off');
                update_post_meta($insert_post, 'currency', TravelHelper::get_current_currency());
              
                $status_order = 'pending';
                if($payment_gateway_id === 'st_submit_form'){
                    if(st()->get_option('enable_email_confirm_for_customer','on') !== 'off'){
                        $status_order = 'incomplete';
                    }
                }
                update_post_meta($insert_post, 'status', $status_order);
                update_post_meta($insert_post, 'st_cart_info', $data_cart);
                update_post_meta($insert_post, 'total_price', STPrice::getTotal());
                update_post_meta($insert_post, 'ip_address', STInput::ip_address());
                update_post_meta($insert_post, 'order_token_code', wp_hash($insert_post));
                update_post_meta($insert_post, 'data_prices', $data_price);
                update_post_meta($insert_post, 'booking_by', STInput::post('booking_by', ''));
                update_post_meta($insert_post, 'payment_method', $payment_gateway_id);
                update_post_meta($insert_post, 'payment_method_name', STPaymentGateways::get_gatewayname($payment_gateway_id));
            
                // destroy cart
                TravelHelper::setcookie( 'st_cart', '', time() - 3600 );
                delete_user_meta( $user_id, '_save_cart_data_'.$user_id , $data_cart );
            } else {
                echo json_encode(
                    [
                        'status' => false,
                        'message' => __('Can not save order.', 'traveler')
                    ]
                );
                die();
            }
            $data = [
                'st_first_name' => $st_first_name,
                'st_last_name' => $st_last_name,
                'st_email' => $st_email,
                'st_phone' => $st_phone,
                'st_address' => $st_address,
                'st_address2' => $st_address2,
                'st_city' => $st_city,
                'st_province' => $st_province,
                'st_zip_code' => $st_zip_code,
                'st_country' => $st_country,
                'st_note' => $st_note,
                'st_payment_gateway'=> 'st_submit_form',
                'term_condition' => $term_condition,
                'st_cart' => $data_cart, 
            ];
            return $data;
    }

    function get_book_history($user_id,$status, $admin_key,$page)
    {
        
        $items_per_page = 10; 
        $offset = ( $page * $items_per_page ) - $items_per_page;
        if ( st()->get_option('use_woocommerce_for_booking') == 'on' ) {
           
            global $wpdb;
            $where = "";
            $order_by = "";
            if ( !empty( $status ) ) {
                $where .= " AND status = '" . $status . "' ";
            }
            if ( !empty( $_REQUEST[ 'data_type' ] ) ) {
                $where .= " AND status = '" . $_REQUEST[ 'data_type' ] . "' ";
            }
            $where .= " AND type = 'woocommerce' ";
            if($admin_key != st()->get_option('traveler_rest_api_key') || $user_id  !=  st()->get_option('traveler_rest_api_key')) {
                $where_user = " AND user_id = " . $user_id;
            }
            if(!empty($page)) {
                $order_by .=   $wpdb->prefix . "st_order_item_meta.id DESC LIMIT ". $offset.",". $items_per_page;
            }else {
                $order_by .=  $wpdb->prefix . "st_order_item_meta.id DESC";
            }
            $querystr  = "SELECT SQL_CALC_FOUND_ROWS * FROM
                               " . $wpdb->prefix . "st_order_item_meta
                                                    WHERE 1=1 {$where_user}
                                                    {$where}
                 ORDER BY " .$order_by ;
            $pageposts = $wpdb->get_results( $querystr, OBJECT );
            $array_data = [];
            if ( !empty( $pageposts ) ) {
                foreach ( $pageposts as $key => $value ) {
                    $array_data[$key] = $value;
                }
            }
            return $array_data;
        } else {
           
            global $wpdb;
            $where = "";
            $order_by = "";
            if ( !empty( $status ) ) {
                //$where .= " AND status = '" . $status . "' ";
                $where .= " AND pm.meta_value = '" . $status . "' ";
            }
            if ( !empty( $_REQUEST[ 'data_type' ] ) ) {
                //$where .= " AND status = '" . $_REQUEST['data_type'] . "' ";
                $where .= " AND pm.meta_value = '" . $_REQUEST[ 'data_type' ] . "' ";
            }
            if ( st()->get_option('use_woocommerce_for_booking') == 'on' ) {
                $where .= " AND type = 'woocommerce' ";
            } else {
                $where .= " AND type = 'normal_booking' ";
            }
            if($admin_key != st()->get_option('traveler_rest_api_key') || $user_id  !=  st()->get_option('traveler_rest_api_key')) {
                $where_user = " AND user_id = " . $user_id;
            }
            if(!empty($page)) {
                $order_by .=   $wpdb->prefix . "st_order_item_meta.id DESC LIMIT ". $offset.",". $items_per_page;
            }else {
                $order_by .=  $wpdb->prefix . "st_order_item_meta.id DESC";
            }
            if ( $status == '' ) {
                $querystr = "SELECT SQL_CALC_FOUND_ROWS * FROM
                               " . $wpdb->prefix . "st_order_item_meta
                                                    WHERE 1=1 {$where_user} {$where}
                 ORDER BY " .$order_by;
            } else {
                if(!empty($page)) {
                    $order_by .=   $wpdb->prefix . "st.id DESC LIMIT ". $offset.",". $items_per_page;
                }else {
                    $order_by .=  $wpdb->prefix . "st.id DESC";
                }
                $querystr = "SELECT SQL_CALC_FOUND_ROWS * FROM
                               " . $wpdb->prefix . "st_order_item_meta st INNER JOIN " . $wpdb->prefix . "postmeta pm ON st.order_item_id = pm.post_id
                                                    WHERE 1=1 {$where_user}
                                                    {$where}
                 ORDER BY". $order_by;
            }
            $pageposts = $wpdb->get_results( $querystr, OBJECT );
            $array_data = [];
            if ( !empty( $pageposts ) ) {
                foreach ( $pageposts as $key => $value ) {
                    $array_data[$key] = $value;
                }
            }
            return $array_data;
        }
    }

    public function _stOtherSetings($array_settings) {
        
        $api_config = [
            [
                'id' => 'traveler_rest_api_key',
                'label' => __('Traveler Rest Api Key', 'traveler'),
                'desc' => __('Add Traveler Rest Api Key for List Order', 'traveler'),
                'std' => '',
                'rows' => '1',
                'type' => 'textarea-simple',
                'section' => 'option_bc',
                'class' => '',
            ]
        ];
        return array_merge( $array_settings, $api_config );
        
    }
}
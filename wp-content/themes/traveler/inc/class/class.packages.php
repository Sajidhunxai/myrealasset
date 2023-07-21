<?php
    /**
     * @since 1.3.1
     *        Class Packages
     **/
    global $pack_orderdata;
    if ( !class_exists( 'STPackages' ) ) {
        class STPackages extends TravelerObject
        {
            private static $instance;

            public function __construct()
            {
                self::$instance = &$this;
                add_action( 'init', [ $this, 'st_checkout_packages' ] , 20);
                add_action('wp_ajax_booking_form_package_direct_submit', [$this, 'direct_submit_package_form']);
                add_action('wp_ajax_nopriv_booking_form_package_direct_submit', [$this, 'direct_submit_package_form']);
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/

            public function  direct_submit_package_form(){
                $error = "";
                if(STInput::post('st_first_name','') == ''){
                    $error .= '<p>'.__( 'The firstname is required', 'traveler' ).'</p>';
                }
                if(STInput::post('st_last_name','') == ''){
                    $error .= '<p>'.__( 'The lastname is required', 'traveler' ).'</p>';
                }

                if(STInput::post('st_email','') == ''){
                    $error .= '<p>'.__( 'The email is required', 'traveler' ).'</p>';
                }

                if(STInput::post('st_phone','') == ''){
                    $error .= '<p>'.__( 'The phone number is required', 'traveler' ).'</p>';
                }

                $payment_gateway_id   = STInput::post( 'st_payment_gateway', 'st_submit_form' );

                $payment_gateway_used = $this->get_gateway( $payment_gateway_id );

                //=== Check Payment gateway
                if ( !$payment_gateway_id || !$payment_gateway_used ) {
                    $payment_gateway_name = apply_filters( 'st_payment_gateway_' . $payment_gateway_id . '_name', $payment_gateway_id );
                    $error .= '<p>'.sprintf( __( 'Sorry! Payment Gateway: <code>%s</code> is not available for this item!', 'traveler' ), $payment_gateway_name ).'</p>';
                }
                //=== Check cart
                $cls_packages = STAdminPackages::get_inst();
                $cart         = $cls_packages->get_cart();
                if ( !$cart ) {
                    STTemplate::set_message( __( 'Your cart is currently empty', 'traveler' ), 'danger' );
                }
                //=== Check Captcha
                $st_secret_key_captcha = st()->get_option( 'st_secret_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
                    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                    $recaptcha_secret = $st_secret_key_captcha;
                    $recaptcha_response = isset($_POST['st_captcha']) ? $_POST['st_captcha'] : '';
                    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response='.$recaptcha_response );
                    $recaptcha = json_decode($recaptcha);
                    $recaptcha = (array) $recaptcha;
                    if (isset($recaptcha["score"]) && ($recaptcha["score"] >= 0.5)) {
                        // Verified - send email
                    } else {
                        $errors = $recaptcha["error-codes"];
                        $mes_error = '';
                        foreach($errors as $key=> $err){
                            $mes_error .=  esc_html__('Error captcha:','traveler').' '.$err.'<br>';
                        }
                        STTemplate::set_message($mes_error, 'danger' );

                    return false;
                    }
                }
                //=== Term and Condition
                if ( (int) STInput::post( 'term_condition', '' ) != 1 ) {
                    STTemplate::set_message( __( 'Please accept our terms and conditions', 'traveler' ), 'danger' );

                    return false;
                }

                //=== Save data
                global $wpdb;
                $table = $wpdb->prefix . 'st_member_packages_order';
                $cart  = $cls_packages->get_cart();

                $current_user = wp_get_current_user();

                $partner_info = [
                    'firstname' => esc_html( STInput::post( 'st_first_name', '' ) ),
                    'lastname'  => esc_html( STInput::post( 'st_last_name', '' ) ),
                    'email'     => esc_html( STInput::post( 'st_email', $current_user->email ) ),
                    'phone'     => esc_html( STInput::post( 'st_phone', '' ) ),
                ];
                $data         = [
                    'package_id'            => $cart->id,
                    'package_name'          => $cart->package_name,
                    'package_price'         => TravelHelper::convert_money($cart->package_price, false, false),
                    'package_time'          => $cart->package_time,
                    'package_commission'    => $cart->package_commission,
                    'package_item_upload'   => $cart->package_item_upload,
                    'package_item_featured' => $cart->package_item_featured,
                    'package_description'   => $cart->package_description,
                    'package_subname'       => $cart->package_subname,
                    'created'               => time(),
                    'partner'               => get_current_user_id(),
                    'status'                => 'pending',
                    'gateway'               => $payment_gateway_id,
                    'partner_info'          => serialize( $partner_info ),
                    'package_services'      => $cart->package_services,
                ];
                $wpdb->insert( $table, $data );
                $order_id = $wpdb->insert_id;
                update_post_meta( $order_id, 'currency', TravelHelper::get_current_currency() );

                $wpdb->update( $table, [ 'token' => wp_hash( $order_id ) ], [ 'id' => $order_id ] );

                $respon = $cls_packages->complete_purchase( $payment_gateway_id, $order_id );

                if ( TravelHelper::st_compare_encrypt( $order_id . 'st1', $respon[ 'status' ] ) ) {
                    //=== Destroy cart session before redirect to payment
                    $cls_packages->destroy_cart();

                    //=== Incomplete.
                    $cls_packages->update_status( 'incomplete', $order_id );


                    //==== Delete old order
                    $this->delete_old_package(get_current_user_id(), $order_id);

                    if ( !empty( $respon[ 'redirect_url' ] ) ) {
                        wp_redirect( $respon[ 'redirect_url' ] );
                        exit();
                    }
                    if ( !empty( $respon[ 'redirect_form' ] ) ) {
                        echo balanceTags($respon[ 'redirect_form' ]);
                        exit();
                    }
                } elseif ( TravelHelper::st_compare_encrypt( $order_id . 'st0', $respon[ 'status' ] ) ) {
                    STTemplate::set_message( sprintf( __( 'Your order has been created but we can not process. Error Code: %s', 'traveler' ), $respon[ 'message' ] ), 'danger' );

                    return false;
                }
            }
            public function st_checkout_packages()
            {

                if ( STInput::post( 'action', '' ) === 'st_checkout_package' ) {
                    

                    if(STInput::post('st_first_name','') == ''){
                        STTemplate::set_message( __( 'The firstname is required', 'traveler' ), 'danger' );

                        return false;
                    }
                    if(STInput::post('st_last_name','') == ''){
                         STTemplate::set_message( __( 'The lastname is required', 'traveler' ), 'danger' );

                        return false;
                    }

                    if(STInput::post('st_email','') == ''){
                         STTemplate::set_message( __( 'The email is required', 'traveler' ), 'danger' );

                        return false;
                    }

                    if(STInput::post('st_phone','') == ''){
                         STTemplate::set_message( __( 'The phone number is required', 'traveler' ), 'danger' );

                        return false;
                    }
                    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
                    //Request check captcha
                    $st_secret_key_captcha = st()->get_option( 'st_secret_key_captcha', '6LdQ4fsUAAAAAGoHQq3ldFiRr96XaDFgXEN7-HXJ' );
                    if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
                        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                        $recaptcha_secret = $st_secret_key_captcha;
                        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response='.$recaptcha_response );
                        $recaptcha = json_decode($recaptcha);
                        $recaptcha = (array) $recaptcha;
                        if (isset($recaptcha["score"]) && ($recaptcha["score"] >= 0.5)) {
                            // Verified - send email
                        } else {
                            $errors = $recaptcha["error-codes"];
                            $mes_error = '';
                            foreach($errors as $key=> $err){
                                $mes_error .=  esc_html__('Error captcha:','traveler').' '.$err.'<br>';
                            }

                            STTemplate::set_message( $mes_error, 'danger' );
                            return false;
                        }
                    }


                    $payment_gateway_id   = STInput::post( 'st_payment_gateway', 'st_submit_form' );

                    $payment_gateway_used = $this->get_gateway( $payment_gateway_id );

                    //=== Check Payment gateway
                    if ( !$payment_gateway_id || !$payment_gateway_used ) {
                        $payment_gateway_name = apply_filters( 'st_payment_gateway_' . $payment_gateway_id . '_name', $payment_gateway_id );
                        STTemplate::set_message( sprintf( __( 'Sorry! Payment Gateway: <code>%s</code> is not available for this item!', 'traveler' ), $payment_gateway_name ), 'danger' );

                        return false;
                    }
                    //=== Check cart
                    $cls_packages = STAdminPackages::get_inst();
                    $cart         = $cls_packages->get_cart();
                    if ( !$cart ) {
                        STTemplate::set_message( __( 'Your cart is currently empty', 'traveler' ), 'danger' );

                        return false;
                    }
                    //=== Term and Condition
                    if ( (int) STInput::post( 'term_condition', '' ) != 1 ) {
                        STTemplate::set_message( __( 'Please accept our terms and conditions', 'traveler' ), 'danger' );

                        return false;
                    }



                    //=== Save data
                    global $wpdb;
                    $table = $wpdb->prefix . 'st_member_packages_order';
                    $cart  = $cls_packages->get_cart();

                    $current_user = wp_get_current_user();

                    $partner_info = [
                        'firstname' => esc_html( STInput::post( 'st_first_name', '' ) ),
                        'lastname'  => esc_html( STInput::post( 'st_last_name', '' ) ),
                        'email'     => esc_html( STInput::post( 'st_email', $current_user->email ) ),
                        'phone'     => esc_html( STInput::post( 'st_phone', '' ) ),
                    ];
                    $data         = [
                        'package_id'            => $cart->id,
                        'package_name'          => $cart->package_name,
                        'package_price'         => TravelHelper::convert_money($cart->package_price, false, false),
                        'package_time'          => $cart->package_time,
                        'package_commission'    => $cart->package_commission,
                        'package_item_upload'   => $cart->package_item_upload,
                        'package_item_featured' => $cart->package_item_featured,
                        'package_description'   => $cart->package_description,
                        'package_subname'       => $cart->package_subname,
                        'created'               => time(),
                        'partner'               => get_current_user_id(),
                        'status'                => 'pending',
                        'gateway'               => $payment_gateway_id,
                        'partner_info'          => serialize( $partner_info ),
                        'package_services'      => $cart->package_services,
                    ];
                    $wpdb->insert( $table, $data );
                    $order_id = $wpdb->insert_id;
                    update_post_meta( $order_id, 'currency', TravelHelper::get_current_currency() );

                    $wpdb->update( $table, [ 'token' => wp_hash( $order_id ) ], [ 'id' => $order_id ] );

                    $respon = $cls_packages->complete_purchase( $payment_gateway_id, $order_id );

                    if ( TravelHelper::st_compare_encrypt( $order_id . 'st1', $respon[ 'status' ] ) ) {
                        //=== Destroy cart session before redirect to payment
                        $cls_packages->destroy_cart();

                        //=== Incomplete.
                        $cls_packages->update_status( 'incomplete', $order_id );


                        //==== Delete old order
                        $this->delete_old_package(get_current_user_id(), $order_id);

                        if ( !empty( $respon[ 'redirect_url' ] ) ) {
                            wp_redirect( $respon[ 'redirect_url' ] );
                            exit();
                        }
                        if ( !empty( $respon[ 'redirect_form' ] ) ) {
                            echo balanceTags($respon[ 'redirect_form' ]);
                            exit();
                        }
                    } elseif ( TravelHelper::st_compare_encrypt( $order_id . 'st0', $respon[ 'status' ] ) ) {
                        STTemplate::set_message( sprintf( __( 'Your order has been created but we can not process. Error Code: %s', 'traveler' ), $respon[ 'message' ] ), 'danger' );

                        return false;
                    }
                }
            }

            public function delete_old_package($user_id, $new_order){
                global $wpdb;
                $table = $wpdb->prefix . 'st_member_packages_order';
                $sql = "DELETE FROM {$table} WHERE partner = {$user_id} AND id NOT IN ({$new_order})";
                $wpdb->query($sql);
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/
            public function get_gateway( $payment_gateway_id )
            {
                $all = STPaymentGateways::get_payment_gateways();
                if ( isset( $all[ $payment_gateway_id ] ) ) {
                    $value = $all[ $payment_gateway_id ];
                    if ( method_exists( $value, 'is_available' ) ) {
                        return $value;
                    }
                }

                return false;
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/
            public function get_order_by_token( $token )
            {
                $token = esc_sql( $token );

                global $wpdb;
                $table = $wpdb->prefix . 'st_member_packages_order';
                $sql   = "SELECT * FROM {$table} WHERE token = '{$token}' LIMIT 1";

                return $wpdb->get_row( $sql );
            }


            public function get_order_by_id( $id_order )
            {
                $id_order = esc_sql( $id_order );
                global $wpdb;
                $table = $wpdb->prefix . 'st_member_packages_order';
                $sql   = "SELECT * FROM {$table} WHERE `id` = '{$id_order}' LIMIT 1";

                return $wpdb->get_row( $sql );
            }

            public function get_order_package_by( $where = '' )
            {

                global $wpdb;
                $table = $wpdb->prefix . 'st_member_packages_order';
                $sql   = "SELECT * FROM {$table} WHERE 1=1 AND {$where} LIMIT 1";

                return $wpdb->get_row( $sql );
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/
            public function convert_payment( $payment )
            {
                switch ( $payment ) {
                    case 'st_submit_form':
                        $payment = __( 'Bank Transfer', 'traveler' );
                        break;

                    case 'st_paypal':
                        $payment = __( 'Paypal Express', 'traveler' );
                        break;
                    case 'st_payfast':
                        $payment = __( 'PayFast', 'traveler' );
                        break;
                    case 'st_stripe':
                        $payment = __( 'Stripe', 'traveler' );
                        break;
                    case 'st_authorize':
                        $payment = __( 'Authorize.net', 'traveler' );
                        break;
                    case 'st_payu':
                        $payment = __( 'PayuBiz', 'traveler' );
                        break;
                    case 'st_skrill':
                        $payment = __( 'Skrill', 'traveler' );
                        break;
                    case 'st_twocheckout':
                        $payment = __( 'TwoCheckout', 'traveler' );
                        break;
                    case 'vina_stripe':
                        $payment = __( 'Stripe', 'traveler' );
                        break;
                }

                return $payment;
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/
            public function update_order( $token = '', $status = '' )
            {
                global $pack_orderdata;
                $get_order_by_token = $this->get_order_by_token( $token );
                if (( $get_order_by_token && $get_order_by_token->gateway != 'st_submit_form') && ($get_order_by_token->gateway != 'st_razor') ) {
                    $admin_packages = STAdminPackages::get_inst();
                    if ( TravelHelper::st_compare_encrypt( (int) $get_order_by_token->id . 'st1', $status ) ) { //=== Completed
                        //Fix transaction paypal
                        $status_complete = true;
                        if($get_order_by_token->status == 'incomplete'){
                            $status_complete = STAdminPackages::get_inst()->completed_purchase($get_order_by_token->gateway, $get_order_by_token->id);
                        }
                        if($status_complete) {
                            $admin_packages->update_status('completed', (int)$get_order_by_token->id);
                        }else{
                            if ( !empty( $status_complete[ 'redirect_url' ] ) ) {
                                wp_redirect( $status_complete[ 'redirect_url' ] );
                                exit();
                            }
                            if ( !empty( $status_complete[ 'redirect_form' ] ) ) {
                                echo balanceTags($status_complete[ 'redirect_form' ]);
                                exit();
                            }
                            $admin_packages->update_status( 'cancelled', (int) $get_order_by_token->id );
                        }
                    } elseif ( TravelHelper::st_compare_encrypt( (int) $get_order_by_token->id . 'st0', $status ) ) { //=== Cancelled
                        $admin_packages->update_status( 'cancelled', (int) $get_order_by_token->id );
                    }
                }

                //==== Send email
                $pack_orderdata = $get_order_by_token;
                $this->send_email( $get_order_by_token );

                do_action( 'st_after_send_email_package', $get_order_by_token );

                return $get_order_by_token;
            }

            public function send_email( $orderdata )
            {
                $this->_send_admin( $orderdata );
                $this->_send_customer( $orderdata );
            }

            public function _send_admin( $orderdata )
            {

                $message          = "";
                $id_page_membership_email_admin = st()->get_option('membership_email_admin', '');
                $email_content = !empty(get_post($id_page_membership_email_admin)) ? wp_kses_post(get_post($id_page_membership_email_admin)->post_content) : "";
                $message .=  do_shortcode($email_content);
                
                $subject = __( 'Have new a member package', 'traveler' );

                $admin_email = st()->get_option( 'email_admin_address' );

                $this->_send_mail( $admin_email, $subject, $message );

            }

            public function _send_customer( $orderdata )
            {
                $message          = "";
                $id_page_membership_email_partner = st()->get_option('membership_email_partner', '');
                $content = get_post($id_page_membership_email_partner);
                if(!empty($content)){
                    $message .=  do_shortcode($content->post_content);
                }
                
                

                $subject = __( 'You have registed a member package', 'traveler' );

                $partner_info = unserialize( $orderdata->partner_info );
                $email        = $partner_info[ 'email' ];

                $this->_send_mail( $email, $subject, $message );
            }

            public function _send_mail( $to, $subject, $message, $attachment = false )
            {

                $from         = st()->get_option( 'email_from' );
                $from_address = st()->get_option( 'email_from_address' );
                $headers      = [];

                if ( $from and $from_address ) {
                    $headers[] = 'From:' . $from . ' <' . $from_address . '>';
                }

                add_filter( 'wp_mail_content_type', [ $this, 'set_html_content_type' ] );

                @wp_mail( $to, $subject, $message, $headers, $attachment );

                remove_filter( 'wp_mail_content_type', [ $this, 'set_html_content_type' ] );
            }

            public function set_html_content_type()
            {

                return 'text/html';
            }

            static function get_payment_gateways_html( $post_id = false )
            {

                $all = STPaymentGateways::get_payment_gateways();

                if ( is_array( $all ) and !empty( $all ) ) {
                    $i         = 1;
                    $available = [];
                    $cls_package = STAdminPackages::get_inst();
                    $cart = $cls_package->get_cart();
                    $price = (!empty($cart))? (float)$cart->package_price: 0;
                    foreach ( $all as $key => $value ) {
                        if ( method_exists( $value, 'is_available' ) and $value->is_available() ) {
                            if($price == 0 && $key == 'st_submit_form'){
                                $available[ $key ] = $value;
                                break;
                            }else{
                                if($price != 0) {
	                                $available[ $key ] = $value;
                                }
                            }
                        }
                    }
                    if ( !empty( $available ) ) {
                            ?>
                            <div class="st-payment-tabs-wrap">
                                <ul class="st-payment-tabs clearfix">
                                    <?php
                                        $i = 0;
                                        foreach ( $available as $key => $value ) {
                                            ?>
                                            <li class="payment-gateway payment-gateway-<?php echo esc_attr( $key ); ?> <?php echo ( !$i ) ? 'active' : FALSE; ?>"
                                                data-gateway="<?php echo esc_attr( $key ) ?>">
                                                <label class="payment-gateway-wrap">
                                                    <div class="logo">
                                                        <div class="h-center">
                                                            <?php printf( '<img src="%s" alt="%s">', $value->get_logo(), $value->get_name() ) ?>
                                                        </div>
                                                    </div>
                                                    <h4 class="gateway-name"><?php echo esc_html( $value->get_name() ); ?></h4>
                                                    <input type="radio" class="i-radio payment-item-radio"
                                                           name="st_payment_gateway" <?php echo ( !$i ) ? 'checked' : FALSE; ?>
                                                           value="<?php echo esc_attr( $key ) ?>">
                                                </label>
                                            </li>
                                            <?php
                                            $i++;
                                        }
                                    ?>
                                </ul>
                                <div class="st-payment-tab-content">
                                    <?php
                                        foreach ( $available as $key => $value ) {
                                            ?>
                                            <div class="st-tab-content" data-id="<?php echo esc_attr( $key ) ?>">
                                                <?php $value->html(); ?>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>

                            </div>
                            <?php

                    }else{
                        ?>
                        <input type="hidden" name="st_payment_gateway" value="st_submit_form" />
                        <?php
                    }
                }
            }

            /**
             * @since   1.3.1
             * @updated 1.3.1
             **/
            public static function get_inst()
            {
                return self::$instance;
            }
        }

        new STPackages();
    }

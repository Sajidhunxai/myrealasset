<?php
    /**
     * Created by PhpStorm.
     * User: MSI
     * Date: 02/06/2015
     * Time: 3:32 CH
     */

    $selected_equipments = $selected_extras = array();
    if ( !empty( $st_booking_data[ 'data_equipment' ] ) ) {
        $selected_equipments = $st_booking_data[ 'data_equipment' ];
    }
    if ( !empty( $st_booking_data[ 'extras' ] ) ) {
        $selected_extras = $st_booking_data[ 'extras' ];
    }

    $pick_up_date  = $st_booking_data[ 'check_in_timestamp' ];
    $drop_off_date = $st_booking_data[ 'check_out_timestamp' ];
    $passenger = $st_booking_data[ 'passenger' ];
    $format        = TravelHelper::getDateFormat();
    $div_id        = "st_cart_item" . md5( json_encode( $st_booking_data[ 'cart_item_key' ] ) );
?>
<p class="booking-item-description">
    <?php echo __( 'Date:', 'traveler' ); ?> <?php echo date_i18n( $format . ' ' . get_option( 'time_format' ), $pick_up_date );
        if(!empty($st_booking_data['roundtrip']) && $st_booking_data['roundtrip'] === 'yes'){
            echo ' ('.esc_html__('Return','traveler').')';
        }
    ?>
    <br/>
    <?php echo __( 'Transfer:', 'traveler' ); ?>
    <?php if ( !empty( $st_booking_data[ 'pick_up' ] ) && !empty( $st_booking_data[ 'drop_off' ] ) ): ?>
        <?php echo esc_html($st_booking_data[ 'pick_up' ]); ?> <i
            class="fa fa-long-arrow-right"></i> <?php echo esc_html($st_booking_data[ 'drop_off' ]); ?>
    <?php else: ?>
        <?php echo __( 'None', 'traveler' ); ?>
    <?php endif; ?>
</p>
<p class="booking-item-description">
    <?php
        if ( !empty( $st_booking_data[ 'distance' ] ) ):
            $time   = $st_booking_data[ 'distance' ];
            $hour   = ( $time[ 'hour' ] >= 2 ) ? $time[ 'hour' ] . ' ' . esc_html__( 'hours', 'traveler' ) : $time[ 'hour' ] . ' ' . esc_html__( 'hour', 'traveler' );
            $minute = ( $time[ 'minute' ] >= 2 ) ? $time[ 'minute' ] . ' ' . esc_html__( 'minutes', 'traveler' ) : $time[ 'minute' ] . ' ' . esc_html__( 'minute', 'traveler' );
            echo esc_attr( $hour ) . ' ' . esc_attr( $minute ) . ' - ' . esc_html($time[ 'distance' ]) . __( 'Km', 'traveler' );
        endif;
        
    ?>
</p>
<div id="<?php echo esc_attr( $div_id ); ?>" class='<?php if ( apply_filters( 'st_woo_cart_is_collapse', false ) ) {
    echo esc_attr( "collapse" );
} ?>'>
    <p>
        <small><?php echo __( "Booking Details", 'traveler' ); ?></small>
    </p>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <p class="booking-item-description">
            <b class='booking-cart-item-title'><?php echo __( "Car price", 'traveler' ); ?>  </b>
            : <?php echo TravelHelper::format_money( $st_booking_data[ 'sale_price' ] ); ?>
            <?php if(New_Layout_Helper::isNewLayout()){
               
            } else {
                echo "/";if ( $st_booking_data[ 'duration_unit' ] == 'day' ) {
                    echo __( "day", 'traveler' );
                }
                if ( $st_booking_data[ 'duration_unit' ] == 'hour' ) {
                    echo __( "hour", 'traveler' );
                }
                if ( $st_booking_data[ 'duration_unit' ] == "distance" ) {
                    $type_distance = st()->get_option( "cars_price_by_distance", "kilometer" );
                    if ( $type_distance == "kilometer" ) {
                        echo __( "kilometer", 'traveler' );
                    } else {
                        echo __( "mile", 'traveler' );
                    }
                }
            } ?>
           
        </p>
    </div>
    
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <p class="booking-item-description">
            <?php
                if ( isset( $selected_equipments ) and $selected_equipments and !empty( $selected_equipments ) ) {
                    echo "<b class='booking-cart-item-title'>" . __( 'Equipment(s):', 'traveler' ) . "</b>";
                    echo "</br>";
                    foreach ( $selected_equipments as $key => $data ) {
                        $number_item = (int)$data->number_item;
                        if ( $number_item < 2 ) {
                            $number_item = 1;
                        }
                        $price_unit      = $data->price_unit;
                        $price_unit_html = '';
                        switch ( $price_unit ) {
                            case "per_hour":
                                $price_unit_html = __( '/hour', 'traveler' );
                                break;
                            case "per_day":
                                $price_unit_html = __( '/day', 'traveler' );
                                break;
                            default:
                                $price_unit_html = '';
                                break;
                        }
                        echo "&nbsp;&nbsp;&nbsp;- " . esc_html($data->title) . ": " . TravelHelper::format_money( $data->price ) . esc_html($price_unit_html) . " (x" . esc_html($number_item) . ")" . " <br>";

                    }
                    echo "";
                }
            ?>
        </p>
        <p class="booking-item-description">
            <?php
                if ( isset( $selected_extras ) and $selected_extras and !empty( $selected_extras ) ) {
                    echo "<b class='booking-cart-item-title'>" . __( 'Extras(s):', 'traveler' ) . "</b>";
                    echo "</br>";
                    foreach ( $selected_extras as $key => $data ) {
                        echo "&nbsp;&nbsp;&nbsp;- " . esc_html($data["title"]) . ": " . TravelHelper::format_money( $data["price"] ) ." (x" . esc_html($data["number"]) . ")" . " <br>";
                    }
                    echo "</br>";
                }
            ?>
            <?php
                if ( isset($passenger ) and ($passenger > 0) ) {
                    echo "<b class='booking-cart-item-title'>" . __( 'Passenger(s) : ', 'traveler' ) . "&nbsp;&nbsp;&nbsp;" . esc_html($passenger) ."</b>";
                    echo "<br>";
                }
            ?>
        </p>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php
            $discount = $st_booking_data[ 'discount_rate' ];
            if ( !empty( $discount ) ) { ?>
                <b class='booking-cart-item-title'><?php echo __( "Discount", 'traveler' ); ?>: </b>
                <?php echo esc_attr( $discount ) . "%" ?>
            <?php }
        ?>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) {
            $wp_cart = WC()->cart->cart_contents;
            $item    = $wp_cart[ $st_booking_data[ 'cart_item_key' ] ];
            $tax     = $item[ 'line_tax' ];
            if ( !empty( $tax ) ) { ?>
                <b class='booking-cart-item-title'><?php echo __( "Tax", 'traveler' ); ?>: </b>
                <?php echo TravelHelper::format_money( $tax ); ?>
            <?php }
        } else {
            $tax = 0;
        }
        ?>
    </div>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <b class='booking-cart-item-title'><?php echo __( "Total amount", 'traveler' ); ?>:</b>
        <?php echo TravelHelper::format_money( $st_booking_data[ 'ori_price' ] + $tax ) ?>
    </div>
</div>
<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.7.0
 */

    if ( !defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

    $order = wc_get_order( $order_id );

    if ( ! $order ) {
        return;
    }

    $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
    $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
    $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
    $downloads             = $order->get_downloadable_items();
    $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

    if ( $show_downloads ) {
        wc_get_template(
            'order/order-downloads.php',
            array(
                'downloads'  => $downloads,
                'show_title' => true,
            )
        );
    }
?>
<header>
    <h2><?php _e( 'Booking Detail', 'traveler' ) ?></h2>
</header>
<ul class="order-payment-list list mb30">
    <?php
        if ( sizeof( $order->get_items() ) > 0 ) {
            do_action( 'woocommerce_order_details_before_order_table_items', $order );
            foreach ( $order->get_items() as $item_id => $item ) {
                $_product      = apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
                $post_type     = !empty( $item[ 'item_meta' ][ '_st_st_booking_post_type' ] ) ? $item[ 'item_meta' ][ '_st_st_booking_post_type' ] : false;
                $st_booking_id = wc_get_order_item_meta( $item_id, '_st_st_booking_id', true );
                if ( is_array( $post_type ) and isset( $post_type[ 0 ] ) ) $post_type = $post_type[ 0 ];

                if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
                    ?>
                    <li class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
                        <div class="row">
                            <div class="col-xs-9 col-9">
                                <h5>
                                    <i class="fa <?php echo apply_filters( 'st_post_type_' . $post_type . '_icon', '' ) ?>"></i>
                                    <?php
                                        if ( $_product && !$_product->is_visible() ) {
                                            echo apply_filters( 'woocommerce_order_item_name', $item[ 'name' ], $item );
                                        } else {
                                            echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $st_booking_id ), $item[ 'name' ] ), $item );
                                        }
                                    ?>
                                </h5>
                            </div>
                            <div class="col-xs-3 col-3">
                                <p class="text-right"><span
                                        class="text-lg"><?php echo balanceTags($order->get_formatted_line_subtotal( $item )); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="order-item-meta-box">
                            <?php
                                // Allow other plugins to add additional product information here
                                do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );

                                echo wc_display_item_meta( $item );
                                echo wc_display_item_downloads( $item );
                                // Allow other plugins to add additional product information here
                                do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );
                            ?>
                        </div>
                    </li>
                    <?php
                }

                if ( $order->has_status( [ 'completed', 'processing' ] ) && ( $purchase_note = get_post_meta( $_product->get_id(), '_purchase_note', true ) ) ) {
                    ?>
                    <li class="product-purchase-note">
                        <div colspan="3"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></div>
                    </li>
                    <?php
                }
            }
        }

        do_action( 'woocommerce_order_details_after_order_table_items', $order );
    ?>
</ul>
<div class="row">
    <div class="col-xs-9">
    </div>
    <div class="col-xs-3">
        <?php
        $items = $order->get_items();
        $i = 0;
        foreach ( $order->get_items() as $key => $item ) {
            $fee_price = wc_get_order_item_meta( $key, '_st_booking_fee_price' );
            if ($fee_price > 0){
                if($i == 0) {
                    ?>
                    <p class="text-right">
                        <span class="text-lg"><?php _e("Fee") ?>: </span>
                        <span class="text-lg"><?php echo esc_html(TravelHelper::format_money($fee_price, true)); ?></span>
                    </p>
                    <?php
                }
                $i++;
            }
        }
        ?>
        <p class="text-right">
            <span class="text-lg"><?php _e( "Total" ) ?>: </span>
            <span class="text-lg"><?php echo wc_price(intval( $order->get_total()),array( 'currency' => $order->get_currency()));   esc_html( TravelHelper::format_money( $order->get_total(), false ) ) ?></span>
        </p>
    </div>
</div>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<header>
    <h2><?php _e( 'Customer details', 'traveler' ); ?></h2>
</header>
<table class="shop_table shop_table_responsive customer_details">
    <?php
        if ( $order->get_billing_email() ) {
            echo '<tr><th>' . __( 'Email:', 'traveler' ) . '</th><td data-title="' . __( 'Email', 'traveler' ) . '">' . $order->get_billing_email() . '</td></tr>';
        }

        if ( $order->get_billing_phone() ) {
            echo '<tr><th>' . __( 'Telephone:', 'traveler' ) . '</th><td data-title="' . __( 'Telephone', 'traveler' ) . '">' . $order->get_billing_phone() . '</td></tr>';
        }

        // Additional customer details hook
        do_action( 'woocommerce_order_details_after_order_table', $order );
    ?>
</table>

<?php if ( !wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

<div class="col2-set addresses">

    <div class="col-1">

        <?php endif; ?>

        <header class="title">
            <h3><?php _e( 'Billing Address', 'traveler' ); ?></h3>
        </header>
        <address>
            <?php
                if ( !$order->get_formatted_billing_address() ) {
                    _e( 'N/A', 'traveler' );
                } else {
                    echo balanceTags($order->get_formatted_billing_address());
                }
            ?>
        </address>

        <?php if ( !wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

    </div><!-- /.col-1 -->
    <?php
        if ( st()->get_option( 'woo_checkout_show_shipping' ) == 'on' ) {
            ?>
            <div class="col-2">

                <header class="title">
                    <h3><?php _e( 'Shipping Address', 'traveler' ); ?></h3>
                </header>
                <address>
                    <?php
                        if ( !$order->get_formatted_shipping_address() ) {
                            _e( 'N/A', 'traveler' );
                        } else {
                            echo balanceTags($order->get_formatted_shipping_address());
                        }
                    ?>
                </address>

            </div><!-- /.col-2 -->
        <?php } ?>

</div><!-- /.col2-set -->

<?php endif; ?>

<div class="clear"></div>

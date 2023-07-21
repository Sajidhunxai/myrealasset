<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
echo '
    <div class="gap"></div>';
if ( $order ) : ?>
	<?php if ( $order->has_status( 'failed' ) ) : ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <i class="fa fa-close round box-icon-large box-icon-center box-icon-danger mb30"></i>
                <h2 class="text-center"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'traveler' ); ?></h2>
                <h5 class="text-center mb30"><?php
                    if ( is_user_logged_in() )
                        _e( 'Please attempt your purchase again or go to your account page.', 'traveler' );
                    else
                        _e( 'Please attempt your purchase again.', 'traveler' );
                    ?></h5>

                <p>
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn btn-primary pay"><?php _e( 'Pay', 'traveler' ) ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn btn-primary pay"><?php _e( 'My Account', 'traveler' ); ?></a>
                    <?php endif; ?>
                </p>

            </div>
        </div>



	<?php else : ?>
        <?php
        $customer_name=$order->get_billing_first_name();
        if(!$customer_name) $customer_name = $order->get_billing_email(); ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>
                <h2 class="text-center"><?php printf(__('%s, your order has been received!','traveler'),$customer_name)?></h2>
                <h5 class="text-center mb30"><?php printf(__('Booking details has been send to %s','traveler'),$order->get_billing_email())?></h5>
            </div>
        </div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

<?php else : ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>
            <h2 class="text-center"><?php _e('Thank you. Your order has been received.','traveler')?></h2>
        </div>
    </div>

<?php endif; ?>
<style>
    .page-title{
        display: none;
    }
</style>
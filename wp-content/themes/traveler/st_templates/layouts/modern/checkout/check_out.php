<?php
$booking_form = st()->load_template( 'hotel/booking_form', false, [
    'field_coupon' => false
] );

echo apply_filters( 'st_booking_form_billing', $booking_form );


?>

<?php if ( defined( 'ICL_LANGUAGE_CODE' ) and ICL_LANGUAGE_CODE ): ?>
    <input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ) ?>">
<?php endif; ?>

<?php do_action( 'st_booking_form_field' ) ?>

<div class="payment-form">
    <h3 class="title"><?php echo __('Select Payment Method', 'traveler'); ?></h3>
    <?php
    if ( !isset( $post_id ) ) $post_id = false;
    STPaymentGateways::get_payment_gateways_html( $post_id ) ?>
</div>

<div class="cond-form">
    <?php echo STCart::get_default_checkout_fields( 'st_check_create_account' ); ?>
    <?php echo STCart::get_default_checkout_fields( 'st_check_term_conditions' ); ?>
</div>

<div class="clearfix">
    <div class="row">
        <div class="col-sm-6">
            <?php
                $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
                ?>
                <div class="form-group captcha_box">
                    <input type="hidden" id="st_captcha" name="st_captcha">
                </div>
                <script>
                    grecaptcha.ready(function () {
                        grecaptcha.execute('<?php echo esc_attr($st_site_key_captcha);?>', { action: 'st_checkout' }).then(function (token) {
                            var recaptchaResponse = document.getElementById('st_captcha');
                            recaptchaResponse.value = token;
                        });
                    });
                </script>
            <?php } ?>
            
        </div>
    </div>
</div>

<?php
$cart = STCart::get_carts();
$cart = base64_encode( serialize( $cart ) );
?>
<input type="hidden" name="st_cart" value="<?php echo esc_attr( $cart ); ?>">

<div class="alert form_alert hidden"></div>
<a data-action='st_checkout' id ="demo-form" class="btn btn-primary btn-checkout btn-st-checkout-submit btn-st-big "><?php _e( 'Submit', 'traveler' ) ?> <i class="fa fa-spinner fa-spin"></i></a>

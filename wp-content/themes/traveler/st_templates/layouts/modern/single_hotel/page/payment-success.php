<?php
if(New_Layout_Helper::isNewLayout()){
    if(check_using_elementor()){
        echo st()->load_template('layouts/elementor/page/payment-success');
		return;
    }
    
}

$order_code = STInput::get('order_code');
$order_token_code=STInput::get('order_token_code');

if($order_token_code)
{
	$order_code=STOrder::get_order_id_by_token($order_token_code);

}
$user_id = get_current_user_id();
$status_order = get_post_meta($order_code,'status',true);
$st_payment_method = get_post_meta($order_code, 'payment_method', true);
if (!$order_code or get_post_type($order_code) != 'st_order') {
	wp_redirect(home_url('/'));
	exit;
}

$gateway=get_post_meta($order_code,'payment_method',true);
get_header('hotel-activity');
?>
    <div class="st-single-hotel-modern-page">
        <?php echo st()->load_template('layouts/modern/single_hotel/elements/banner'); ?>
		<div class="container">
			<div class="st-checkout-page">
				<?php
					if(isset($_REQUEST['order_token_code']) && $status_order  !== 'complete' && $st_payment_method === 'st_razor'){
						do_action( 'st_receipt_st_razor', $order_code );
					}
					if(isset($_REQUEST['order_token_code']) && $status_order  === 'complete' && $st_payment_method === 'st_razor'){
						do_action( 'st-sendmail-razor-pay', $order_code );
					}
				?>
				<?php
				echo st()->load_template('layouts/modern/single_hotel/page/booking_infomation',null,array('order_code'=>$order_code));
				?>
			</div>
		</div>
    </div>
<?php
get_footer('hotel-activity');
?>
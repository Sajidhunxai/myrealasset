<?php
$order_code = STInput::get('order_code');
$order_token_code=STInput::get('order_token_code');

if($order_token_code)
{
	$order_code=STOrder::get_order_id_by_token($order_token_code);

}
$user_id = get_current_user_id();


if (!$order_code or get_post_type($order_code) != 'st_order') {
	wp_redirect(home_url('/'));
	exit;
}
$status_order = get_post_meta($order_code,'status',true);
$gateway=get_post_meta($order_code,'payment_method',true);
$st_payment_method = get_post_meta($order_code, 'payment_method', true);
get_header();
do_action('st_destroy_cart_complete');

?>
	<div id="st-content-wrapper">
		<div class="st-breadcrumb">
			<div class="container">
				<ul>
					<li>
						<a href="<?php echo site_url('/') ?>"><?php echo __('Home', 'traveler'); ?></a>
					</li>
					<li>
						<span><?php echo get_the_title(); ?></span>
					</li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="st-checkout-page">
				<?php
				if(isset($_REQUEST['order_token_code']) && $status_order  !== 'complete' && $st_payment_method === 'st_razor'){
					do_action( 'st_receipt_st_razor', $order_code );
				}
				if(isset($_REQUEST['order_token_code']) && $status_order  === 'complete' && $st_payment_method === 'st_razor'){
					do_action( 'st-sendmail-razor-pay', $order_code );
				}
				echo STTemplate::message(); 
				STTemplate::clear();
				$is_show_infomation_allow = STPaymentGateways::gateway_success_page_validate($gateway);
				if($is_show_infomation_allow) {
					echo st()->load_template('layouts/modern/page/booking_infomation',null,array('order_code'=>$order_code));
				}else{
					echo st()->load_template('layouts/modern/page/booking_infomation',null,array('order_code'=>$order_code));
				}
				?>
			</div>
		</div>
	</div>
<?php
get_footer();
?>
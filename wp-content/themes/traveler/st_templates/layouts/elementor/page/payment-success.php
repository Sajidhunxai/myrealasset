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
	<div id="st-content-wrapper" class="st-style-elementor">
		<?php
			$inner_style = '';
			$thumb_id = get_post_thumbnail_id(get_the_ID());
			$menu_transparent = st()->get_option('menu_transparent', '');
			$img = wp_get_attachment_image_url($thumb_id, 'full');
			$inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");

			if($menu_transparent == 'on'){?>
				<div class="banner st-bg-feature <?php echo esc_attr($inner_style) ?>">
					<div class="container">
						<div class="st-banner-search-form style_2">
							<h1 class="st-banner-search-form__title"><?php the_title(); ?></h1>
							<?php echo st_breadcrumbs_new();?>
						
						</div>
					</div>
				</div>
			<?php } else {?>
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
			<?php }
			?>
		</div>

		<div class="container">
            <?php $page_style = st()->get_option('page_checkout_style', 1); ?>
			<div class="st-checkout-page <?php echo 'style-' . esc_attr($page_style) ?>">
				<?php
				if(isset($_REQUEST['order_token_code']) && $status_order  !== 'complete' && $st_payment_method === 'st_razor'){
					do_action( 'st_receipt_st_razor', $order_code );
				}
				if(isset($_REQUEST['order_token_code']) && $status_order  === 'complete' && $st_payment_method === 'st_razor'){
					do_action( 'st-sendmail-razor-pay', $order_code );
				}
				$is_show_infomation_allow = STPaymentGateways::gateway_success_page_validate($gateway);
				
				do_action('remove_message_session');
				if($is_show_infomation_allow) {
					
					echo st()->load_template('layouts/elementor/page/booking_infomation',null,array('order_code'=>$order_code));
				}else{
					echo st()->load_template('layouts/elementor/page/booking_infomation',null,array('order_code'=>$order_code));
				}
				?>
			</div>
		</div>
	</div>
<?php
get_footer();
?>
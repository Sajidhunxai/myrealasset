<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<?php
/**
 * Review order table
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.3.0
 */
if (!defined('ABSPATH')) {
    exit;
}
$hotel_alone_in_setting  = st()->get_option('hotel_alone_assign_hotel', '');
$class_wrapper = 'woocommerce-checkout-review-order-table';
if(!empty($hotel_alone_in_setting)){
	$class_wrapper = 'woocommerce-checkout-review-order-table1';
}
?>

<div class="<?php echo esc_attr($class_wrapper); ?> booking-item-payment">

<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$is_woo_product = false;
			if(!isset($cart_item['st_booking_data']))
				$is_woo_product = true;
	
			//product_id
	
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
	
			if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', TRUE, $cart_item, $cart_item_key)) {
	
				$product_url = '';
				$post_type = FALSE;
				// Traveler
				if (isset($cart_item['st_booking_data']) and !empty($cart_item['st_booking_data'])) {
	
					$st_booking_data = $cart_item['st_booking_data'];
	
					$post_type = isset($st_booking_data['st_booking_post_type']) ? $st_booking_data['st_booking_post_type'] : FALSE;
	
					$booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : FALSE;
					if ($booking_id)
						$product_url = esc_url(get_permalink($booking_id));
				}else{
					$product_url = esc_url($_product->get_permalink($cart_item));
				}
	
				?>
				<header class="clearfix">
					<div class="col-left">
						<h5 class="booking-item-payment-title">
							<?php
							if (!$_product->is_visible()){
								echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
							}else{
								if(isset($cart_item['st_booking_data']) && isset($cart_item['st_booking_data']['st_booking_post_type']) && $cart_item['st_booking_data']['st_booking_post_type'] == 'st_hotel'){
									$st_booking_data = $cart_item['st_booking_data'];
									$hotel_id = $st_booking_data['st_booking_id'];
									$room_id = $st_booking_data['room_id'];
								echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" target="_blank">%s</a>', get_the_permalink($hotel_id), get_the_title($hotel_id)), $cart_item, $cart_item_key);
								}else{
									echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" target="_blank">%s </a>', $product_url, $_product->get_title()), $cart_item, $cart_item_key);
								}
							}
	
							// Meta data
							echo wc_get_formatted_cart_item_data($cart_item);
	
							// Backorder notification
							if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity']))
								echo '<p class="backorder_notification">' . __('Available on backorder', 'traveler') . '</p>';
							?>
						</h5>
						<?php
						if(!$is_woo_product) {
							$address = get_post_meta($booking_id, 'address', true);
						?>
							<p class="room-name">
								<?php
								$st_booking_data = $cart_item['st_booking_data'];
								$booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : false;
							$hotel_alone_in_setting = st()->get_option('hotel_alone_assign_hotel', '');
							if(isset($st_booking_data['st_booking_post_type']) && $st_booking_data['st_booking_post_type'] == 'st_hotel' && $hotel_alone_in_setting == $booking_id){
								echo esc_html__('Room Name', 'traveler') . ': ' . sprintf('<a href="%s" target="_blank">%s </a>', get_the_permalink($st_booking_data['room_id']), get_the_title($st_booking_data['room_id']));
							}
								?>
							</p>
								<?php
								if(!empty($address)){
								?>
								<p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
								<?php } ?>
						<?php } ?>
					</div>
					<a class="booking-item-payment-img" target="_blank" href="<?php echo esc_url($product_url); ?>">
						<?php
						if (isset($cart_item['st_booking_data']) and !empty($cart_item['st_booking_data'])) {
							$st_booking_data = $cart_item['st_booking_data'];
							$booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : FALSE;
	
							$hotel_alone_in_setting = st()->get_option('hotel_alone_assign_hotel', '');
							if(isset($st_booking_data['st_booking_post_type']) && $st_booking_data['st_booking_post_type'] == 'st_hotel' && $hotel_alone_in_setting == $booking_id) {
								echo get_the_post_thumbnail($st_booking_data['room_id'], 'thumbnail', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
							}else{
								echo get_the_post_thumbnail($booking_id, 'thumbnail', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
							}
	
						} else {
							$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
	
							if (!$_product->is_visible())
								echo balanceTags($thumbnail);
							else
								echo balanceTags($thumbnail);
						}
						?>
					</a>
				</header>
	
			<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	<table class="shop_table booking-item-payment">
		<tfoot>

			<tr class="cart-subtotal">
				<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
				<td><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
					<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

			<?php endif; ?>

			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<tr class="fee">
					<th><?php echo esc_html( $fee->name ); ?></th>
					<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
						<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<th><?php echo esc_html( $tax->label ); ?></th>
							<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="tax-total">
						<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
						<td><?php wc_cart_totals_taxes_total_html(); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<tr class="order-total">
				<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
				<td><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>

			<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

		</tfoot>
	</table>
</div>

<?php extract(shortcode_atts(array(
	'st_images_icon'         => '',
	'sale_member'         => '',
	'id_package'         => '',
	'list_support'         => '',
), $attr));
$image_src = wp_get_attachment_image_src($st_images_icon, 'full');
$support = vc_param_group_parse_atts($list_support);
$cls_packages = STAdminPackages::get_inst();
$packages = $cls_packages->get_packages_by_id($id_package);
$position_currency_symbol = TravelHelper::get_current_currency('booking_currency_pos');
if (!$position_currency_symbol) {
	$position_currency_symbol = 'left';
}
if (isset($packages) && !empty($packages)) {
	foreach ($packages as $key => $pack) {
		if (!empty($pack->package_name)) {
			$package_name =  $pack->package_name;
		} else {
			$package_name =  "";
		}
		if (!empty($pack->package_name)) {
			$package_price =  $pack->package_price;
		} else {
			$package_price =  0;
		}

		if (!empty($pack->package_time)) {
			$package_time =  $pack->package_time;
		} else {
			$package_time =  0;
		}
		$cls_packages = STAdminPackages::get_inst();
		$curency_symbol = TravelHelper::get_current_currency('symbol');
	} ?>
	<div class="item-member-ship">
		<div class="item-st">
			<div class="icon-table">
				<?php
				if (!empty($image_src) && !empty($image_src)) { ?>
					<img src="<?php echo esc_url($image_src[0]); ?>" alt="">
				<?php }
				?>
			</div>
			<div class="title">
				<?php echo esc_html($package_name); ?>
			</div>
			<div class="price">
				<span class="price">
					<?php
					if (!empty($position_currency_symbol) && $position_currency_symbol == 'right' or $position_currency_symbol == 'right_space') :?>
						<span class="currency"><?php echo esc_attr(TravelHelper::convert_money($package_price)); ?></span>
						<span class="sign"><?php echo esc_attr($curency_symbol) ?></span>
					<?php
					else : ?>
						<span class="sign"><?php echo esc_attr($curency_symbol) ?></span>
						<span class="currency"><?php echo esc_attr(TravelHelper::convert_money($package_price)); ?></span>
						<?php
					endif; ?>
				</span>
			</div>
			<div class="time-packpage">
				<p><?php echo __("per ", 'traveler'); ?> <?php echo esc_html($cls_packages->convert_item($package_time, true)); ?></p>
			</div>
			<div class="pricingContent">
				<ul>
					<?php foreach ($support as $sp) {
						if (isset($sp["check"]) && !empty($sp["check"])) {
							$icon = get_template_directory_uri() . '/v2/images/ico_check.svg';
						} else {
							$icon = get_template_directory_uri() . '/v2/images/ico_uncheck.svg';
						}
					?>
						<li><span><img src="<?php echo esc_url($icon); ?>" alt=""></span><?php echo esc_html($sp["title_items"]) ?></li>
					<?php } ?>
				</ul>
			</div>
			<div class="button-get">
				<div class="clearfix">
					<form action="#" method="post">
						<input type="hidden" name="package_new" value="<?php echo esc_attr($pack->id); ?>">
						<input type="hidden" name="iconpackage_new" value="<?php echo esc_url($icon); ?>">
						<input type="hidden" name="package_encrypt_new" value="<?php echo TravelHelper::st_encrypt($pack->id); ?>">
						<input type="submit" name="add_cart_package_new" value="<?php echo __('GET STARTED', 'traveler'); ?>" class="btn btn-get add_cart_package_new">
					</form>
				</div>
			</div>
		</div>
	</div>

<?php }
?>

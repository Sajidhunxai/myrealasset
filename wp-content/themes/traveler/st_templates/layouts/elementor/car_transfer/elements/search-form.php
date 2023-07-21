<?php

$id_page = st()->get_option( 'car_transfer_search_page' );
if ( isset( $id_page ) && ! empty( $id_page ) ) {
	$link_action = get_the_permalink( $id_page );
} else {
	$link_action = home_url( '/' );
}
$class = '';
$id    = 'id="sticky-nav"';
if ( isset( $in_tab ) ) {
	$class = 'in_tab';
	$id    = '';
}

?>
<div class="search-form st-border-radius <?php echo esc_attr( $class ); ?>">
	<form action="<?php echo esc_url( $link_action ); ?>" class="form" method="get">
		<div class="row">
			<div class="col-md-4 border-right">
				<?php echo st()->load_template( 'layouts/elementor/car_transfer/elements/search/location-from-search', '', [ 'has_icon' => true ] ) ?>
			</div>
			<div class="col-md-4 border-right">
				<?php echo st()->load_template( 'layouts/elementor/car_transfer/elements/search/location-to-search', '', [ 'has_icon' => true ] ) ?>
			</div>
			<div class="col-md-4">
				<?php echo st()->load_template( 'layouts/elementor/car_transfer/elements/search/advanced', '' ) ?>
			</div>
		</div>
	</form>
</div>


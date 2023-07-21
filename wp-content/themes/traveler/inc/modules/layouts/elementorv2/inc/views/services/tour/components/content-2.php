<?php
$style = get_post_meta( get_the_ID(), 'rs_style_tour', true );
if ( empty( $style ) ) {
	$style = 'grid';
}

global $wp_query, $st_search_query;
if ( $st_search_query ) {
	$query = $st_search_query;
} else {
	$query = $wp_query;
}

if ( empty( $format ) ) {
	$format = '';
}

if ( empty( $layout ) ) {
	$layout = '';
}
?>
<div class="col-sm-12">
	<?php
	echo stt_elementorv2()->loadView( 'services/hotel/components/toolbar', [
		'style'        => $style,
		'post_type'    => 'st_tours',
		'service_text' => __( 'New tour', 'traveler' ),
	] );
	?>
	<div id="modern-search-result" class="modern-search-result" data-layout="7">
		<?php echo st()->load_template( 'layouts/elementor/common/loader', 'content' ); ?>
		<?php
		if ( $style == 'grid' ) {
			echo '<div class="service-list-wrapper service-tour row">';
		} else {
			echo '<div class="service-list-wrapper service-tour list-style">';
		}
		?>
		<?php
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo '<div class="col-12 col-md-6 col-lg-3 item-service">';
				if ( $style == 'grid' ) {
					echo stt_elementorv2()->loadView( 'services/tour/loop/grid' );
				} else {
					echo stt_elementorv2()->loadView( 'services/tour/loop/list' );
				}
				echo '</div>';
			}
		} else {
			echo ( $style == 'grid' ) ? '<div class="col-12">' : '';
			echo st()->load_template( 'layouts/modern/tour/elements/none' );
			echo ( $style == 'grid' ) ? '</div>' : '';
		}
		wp_reset_query();
		echo '</div>';
		?>
	</div>
	<div class="pagination moderm-pagination" id="moderm-pagination">
		<?php echo TravelHelper::paging( false, false ); ?>
	</div>
</div>

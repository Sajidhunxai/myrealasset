<?php
$style = get_post_meta( get_the_ID(), 'rs_style_car', true );
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
	echo st()->load_template( 'layouts/elementor/hotel/elements/toolbar', '', [
		'style'        => $style,
		'format'       => $format,
		'layout'       => $layout,
		'service_text' => __( 'New car', 'traveler' ),
		'post_type'    => 'st_cars',
	] );
	echo st()->load_template( 'layouts/elementor/car/elements/top-filter/top-filter' );
	?>
	<div id="modern-search-result" class="modern-search-result" >
		<?php echo st()->load_template( 'layouts/modern/common/loader', 'content' ); ?>
		<?php
		if ( $style == 'grid' ) {
			echo '<div class="row service-list-wrapper">';
		} else {
			echo '<div class="service-list-wrapper list-style">';
		}
		?>
		<?php
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo st()->load_template( 'layouts/elementor/car/loop/normal-' . esc_attr( $style ), '', [ 'item_row' => 4 ] );
			}
		} else {
			echo ( $style == 'grid' ) ? '<div class="col-12">' : '';
			echo st()->load_template( 'layouts/modern/car/elements/none' );
			echo ( $style == 'grid' ) ? '</div>' : '';
		}
		wp_reset_query();
		?>
		</div>
	</div>

	<div class="pagination moderm-pagination" id="moderm-pagination" data-layout="normal">
		<?php TravelHelper::paging( false, false ); ?>
		<span class="count-string">
			<?php
			if ( ! empty( $st_search_query ) ) {
				$query = $st_search_query;
			}
			if ( $query->found_posts ) :
				$page           = get_query_var( 'paged' );
				$posts_per_page = get_option( 'posts_per_page', 12 );
				if ( ! $page ) {
					$page = 1;
				}
				$last = $posts_per_page * ( $page );
				if ( $last > $query->found_posts ) {
					$last = $query->found_posts;
				}
				echo sprintf( __( '%1$d - %2$d of %3$d ', 'traveler' ), $posts_per_page * ( $page - 1 ) + 1, $last, $query->found_posts );
				echo ( $query->found_posts == 1 ) ? __( 'Car', 'traveler' ) : __( 'Cars', 'traveler' );
			endif;
			?>
		</span>
	</div>

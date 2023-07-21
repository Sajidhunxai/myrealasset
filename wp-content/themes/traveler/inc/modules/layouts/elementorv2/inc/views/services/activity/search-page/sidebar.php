<?php
get_header();
wp_enqueue_script( 'filter-activity' );

$sidebar_pos = get_post_meta( get_the_ID(), 'rs_activity_sidebar_pos', true );
if ( empty( $sidebar_pos ) ) {
	$sidebar_pos = 'left';
}
?>
	<div id="st-content-wrapper" class="st-style-elementor search-result-page activity-layout4" data-layout="4" data-format="popup">
		<?php echo stt_elementorv2()->loadView( 'services/activity/components/banner' ); ?>
		<div class="container">
			<div class="st-results st-hotel-result st-search-tour">
				<div class="row">
					<?php
					if ( $sidebar_pos == 'left' ) {
						echo stt_elementorv2()->loadView( 'services/activity/components/sidebar', [ 'format' => 'popupmap' ] );
					}
					?>
					<?php
					$query = [
						'post_type'   => 'st_activity',
						'post_status' => 'publish',
						's'           => '',
					];
					global $wp_query , $st_search_query;



					$activity = STActivity::inst();
					$activity->alter_search_query();
					query_posts( $query );
					$st_search_query = $wp_query;
					$activity->remove_alter_search_query();
					wp_reset_query();



					echo stt_elementorv2()->loadView( 'services/activity/components/content' );

					if ( $sidebar_pos == 'right' ) {
						echo stt_elementorv2()->loadView( 'services/activity/components/sidebar', [ 'format' => 'popupmap' ] );
					}
					?>
				</div>
				<div class="map-view map-view-mobile">
					<a href="javascript:void(0);">
						<span class="stt-icon stt-icon-map"></span>
						<?php echo esc_html__( 'Map', 'traveler' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();

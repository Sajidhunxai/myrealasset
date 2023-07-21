<?php
	/**
	 * Created by PhpStorm.
	 * User: Administrator
	 * Date: 16-11-2018
	 * Time: 8:47 AM
	 * Since: 1.0.0
	 * Updated: 1.0.0
	 */
while ( have_posts() ) :
	the_post();
	$price         = STHotel::get_price();
	$post_id       = get_the_ID();
	$hotel_star    = (int) get_post_meta( $post_id, 'hotel_star', true );
	$address       = get_post_meta( $post_id, 'address', true );
	$review_rate   = STReview::get_avg_rate();
	$count_review  = get_comment_count( $post_id )['approved'];
	$lat           = get_post_meta( $post_id, 'map_lat', true );
	$lng           = get_post_meta( $post_id, 'map_lng', true );
	$zoom          = get_post_meta( $post_id, 'map_zoom', true );
	$gallery       = get_post_meta( $post_id, 'gallery', true );
	$gallery_array = explode( ',', $gallery );
	$marker_icon   = st()->get_option( 'st_hotel_icon_map_marker', '' );
	?>
		<div id="st-content-wrapper" class="single-hotel-style-2">
		<?php st_breadcrumbs_new() ?>
			<div class="container">
				<div class="st-hotel-content">
					<div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
						<div class="price-wrapper">
						<?php echo wp_kses( sprintf( __( 'from <span class="price">%s</span>', 'traveler' ), TravelHelper::format_money( $price ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
						</div>
						<a href=""
						class="btn btn-mpopup btn-green"><?php echo esc_html__( 'Check Availability', 'traveler' ) ?></a>
					</div>
				</div>
				<div class="st-service-header d-flex justify-content-between align-items-center">
					<div class="left">
					<?php echo st()->load_template( 'layouts/elementor/common/star', '', [ 'star' => $hotel_star ] ); ?>
						<h1 class="st-heading"><?php the_title(); ?></h1>
						<div class="sub-heading">
						<?php
						if ( $address ) {
							echo TravelHelper::getNewIcon( 'Ico_maps', '#5E6D77', '16px', '16px' );
							echo esc_html( $address );
						}
						?>
							<a href="javascript: void(0)" class="st-link font-medium" data-bs-toggle="modal"
						data-bs-target="#st-modal-show-map"> <?php echo esc_html__( 'View on map', 'traveler' ) ?></a>

						</div>
					</div>
					<div class="right d-none d-sm-block">
						<div class="review-score">
							<div class="head d-flex justify-content-between align-items-center clearfix">
								<div class="left">
									<span class="head-rating"><?php echo TravelHelper::get_rate_review_text( $review_rate, $count_review ); ?></span>
									<span class="text-rating"><?php comments_number( __( 'from 0 review', 'traveler' ), __( 'from 1 review', 'traveler' ), __( 'from % reviews', 'traveler' ) ); ?></span>
								</div>
								<div class="score">
								<?php echo esc_html( $review_rate ); ?><span>/5</span>
								</div>
							</div>
							<div class="foot">
							<?php echo esc_html__( '100% guests recommend', 'traveler' ) ?>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-md-9 ">
						<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/gallery', '', [ 'post_id' => $post_id ] ); ?>
						<div class="st-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation">
									<a href="#description-tab" class="active"
									aria-controls="description-tab" role="tab"
									data-bs-toggle="tab">
								<?php echo __( 'Description', 'traveler' ) ?>
									</a>
								</li>
								<li role="presentation">
									<a href="#facilities-tab" aria-controls="facilities-tab"
										role="tab"
										data-bs-toggle="tab">
									<?php echo __( 'Facilities', 'traveler' ) ?>
									</a>
								</li>
								<li role="presentation">
									<a href="#rules-tab" aria-controls="rules-tab" role="tab"
									data-bs-toggle="tab">
									<?php echo __( 'Rules', 'traveler' ) ?>
									</a>
								</li>
							<?php if ( comments_open() and st()->get_option( 'hotel_review' ) == 'on' ) { ?>
								<li role="presentation">
									<a href="#reviews-tab" aria-controls="reviews-tab"
										role="tab"
										data-bs-toggle="tab">
										<?php echo __( 'Reviews', 'traveler' ) ?>
									</a>
								</li>
								<?php } ?>
							</ul>
							<div class="tab-content content-tab-detail">
								<div role="tabpanel" class="tab-pane active" id="description-tab">
									<div class="row">
										<div class="col-xs-12 col-sm-3 col-sm-push-9 order-2 col-md-4 col-md-push-8 hotel-logo">
										<?php
											$logo = get_post_meta( get_the_ID(), 'logo', true );
										if ( $logo ) {
											echo '<img src="' . esc_url( $logo ) . '" class="img-responsivve">';
										}
										?>
										</div>
										<div class="col-xs-12 col-sm-9 col-sm-pull-3 order-1 col-md-8 col-md-pull-4">
											<div class="st-description" data-toggle-section="st-description">
												<?php the_content(); ?>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="facilities-tab">
									<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/attributes', '', [ 'post_type' => 'st_hotel' ] ); ?>
								</div>
								<div role="tabpanel" class="tab-pane" id="rules-tab">
									<table class="table st-properties" data-toggle-section="st-properties">
										<tr>
											<th><?php echo esc_html__( 'Check In', 'traveler' ) ?></th>
											<td>
												<?php echo get_post_meta( $post_id, 'check_in_time', true ); ?>
											</td>
										</tr>
										<tr>
											<th><?php echo esc_html__( 'Check Out', 'traveler' ) ?></th>
											<td>
												<?php echo get_post_meta( $post_id, 'check_out_time', true ); ?>
											</td>
										</tr>
										<?php
										$policies = get_post_meta( $post_id, 'hotel_policy', true );
										if ( $policies ) {
											?>
												<tr>
													<th><?php echo esc_html__( 'Hotel Policies', 'traveler' ) ?></th>
													<td>
													<?php
													foreach ( $policies as $policy ) {
														?>
																<h4 class="f18"><?php echo esc_html( $policy['title'] ); ?></h4>
																<div><?php echo balanceTags( $policy['policy_description'] ) ?></div>
															<?php
													}
													?>
													</td>
												</tr>
												<?php
										}
										?>
									</table>
								</div>
								<?php if ( comments_open() and st()->get_option( 'hotel_review' ) == 'on' ) { ?>
								<div role="tabpanel" class="tab-pane" id="reviews-tab">
									<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/review', '', [ 'post_id' => $post_id ] ); ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="fixed-on-mobile">
							<div class="form-book-wrapper form-single-style-2 relative inline">
								<nav>
									<ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
										<li><a class="active" id="nav-book-tab" data-bs-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
										<li><a id="nav-inquirement-tab" data-bs-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
									</ul>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
										<?php echo st()->load_template( 'layouts/elementor/common/loader' ); ?>
										<form class="form form-check-availability-hotel clearfix">
											<input type="hidden" name="action" value="ajax_search_room">
											<input type="hidden" name="room_search" value="1">
											<input type="hidden" name="is_search_room" value="1">
											<input type="hidden" name="room_parent"
													value="<?php echo esc_attr( get_the_ID() ); ?>">
										<?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/date', '' ); ?>
										<?php echo st()->load_template( 'layouts/elementor/hotel/elements/search/guest', '' ); ?>
											<div class="form-group submit-group">
												<input class="btn btn-large btn-full upper font-medium" type="submit"
														name="submit"
														value="<?php echo esc_html__( 'Check Availability', 'traveler' ) ?>">
												<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
											</div>
										</form>
									</div>
									<div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
										<?php echo st()->load_template( 'email/email_single_service' ); ?>
									</div>
								</div>
							</div>
						</div>

						<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/list-room', '', [ 'post_id' => $post_id ] ); ?>
					</div>
					<div class="col-xs-12 col-md-3 ">
						<div class="widgets">

							<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/owner-info' ); ?>

							<?php echo st()->load_template( 'layouts/modern/common/single/information-contact' ); ?>
							<?php
							$st_show_hotel_nearby = st()->get_option( 'st_show_hotel_nearby', 'off' );
							if ( $st_show_hotel_nearby == 'on' ) {
								global $post;
								$hotel        = new STHotel();
								$nearby_posts = $hotel->get_near_by();
								if ( ! empty( $nearby_posts ) ) {
									?>
								<div class="widget-box  st-border-radius blog default">
									<h4 class="media-heading heading"><?php echo __( 'RELATED HOTEL', 'traveler' ) ?></h4>
									<div class="related-services related-hotel">
										<?php
										foreach ( $nearby_posts as $key => $post ) {
											setup_postdata( $post );
											$hotel_star = (int) get_post_meta( get_the_ID(), 'hotel_star', true );
											$price      = STHotel::get_price();
											?>
												<div class="item">
													<div class="item-service">
														<div class="media">
															<div class="media-left">
																<a href="<?php the_permalink() ?>">
																	<img class="media-object img-full"
																		src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ); ?>">
																</a>
															</div>
															<div class="media-body">
															<?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $hotel_star ] ); ?>
																<h4 class="media-heading"><a
																			href="<?php the_permalink(); ?>"
																			class="st-link c-main"><?php the_title(); ?></a>
																</h4>
																<div class="price-wrapper">
																<?php
																if ( STHotel::is_show_min_price() ) :
																	_e( 'from', 'traveler' );
																	else :
																		_e( 'avg', 'traveler' );
																	endif;
																	?>
																	<?php echo wp_kses( sprintf( __( ' <span class="price">%s</span><span class="unit">/night</span>', 'traveler' ), TravelHelper::format_money( $price ) ), [ 'span' => [ 'class' => [] ] ] ); ?>
																</div>
															</div>
														</div>
													</div>

													<div class="hr"></div>
												</div>

												<?php
										}
											wp_reset_query();
											wp_reset_postdata();
										?>
									</div>
								</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal Map Popup -->
		<div class="modal fade modal-map" id="st-modal-show-map" tabindex="-1" role="dialog"
								aria-labelledby="myModalLabel">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title"><?php the_title(); ?></div>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?></button>
					</div>
					<div class="modal-body">
					<?php
					$default = apply_filters('st_hotel_property_near_by_params', [
						'number'      => '12',
						'range'       => '50',
						'show_circle' => 'no',
					]);
					extract( $default );
					$hotel           = new STHotel();
					$location_center = '[' . $lat . ',' . $lng . ']';
					$map_lat_center  = $lat;
					$map_lng_center  = $lng;
					$map_icon        = st()->get_option( 'st_hotel_icon_map_marker', '' );
					$map_icon        = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
					if ( empty( $map_icon ) ) {
						$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
					}

					$data_map = [];
					$stt      = 1;
					global $post;
					if ( st()->get_option( 'st_show_hotel_nearby' ) == 'on' ) {
						$data = $hotel->get_near_by( get_the_ID(), $range, $number );
						if ( ! empty( $data ) ) {
							$stt = 1;
							foreach ( $data as $post ) :
								setup_postdata( $post );
								$map_lat = get_post_meta( get_the_ID(), 'map_lat', true );
								$map_lng = get_post_meta( get_the_ID(), 'map_lng', true );
								if ( ! empty( $map_lat ) and ! empty( $map_lng ) and is_numeric( $map_lat ) and is_numeric( $map_lng ) ) {
									$data_val                         = [
										'id'          => get_the_ID(),
										'post_id'     => get_the_ID(),
										'name'        => get_the_title(),
										'description' => '',
										'lat'         => (float) $map_lat,
										'lng'         => (float) $map_lng,
										'icon_mk'     => $map_icon,
										'featured'    => get_the_post_thumbnail_url( get_the_ID() ),
										'url'         => get_permalink( get_the_ID() ),
									];
									$post_type                        = get_post_type();
									$data_map[ $stt ]['id']           = get_the_ID();
									$data_map[ $stt ]['name']         = get_the_title();
									$data_map[ $stt ]['post_type']    = $post_type;
									$data_map[ $stt ]['lat']          = $map_lat;
									$data_map[ $stt ]['lng']          = $map_lng;
									$data_map[ $stt ]['icon_mk']      = $map_icon;
									$data_map[ $stt ]['content_html'] = preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/hotel/elements/property', false, [ 'data' => $data_val ] ) );
									++$stt;
								}
								endforeach;
							wp_reset_postdata();
						}
					}
					$properties = $hotel->properties_near_by( get_the_ID(), $lat, $lng, $range );
					if ( ! empty( $properties ) ) {
						foreach ( $properties as $key => $val ) {
							$data_map[] = [
								'id'           => get_the_ID(),
								'name'         => $val['name'],
								'post_type'    => 'st_hotel',
								'lat'          => (float) $val['lat'],
								'lng'          => (float) $val['lng'],
								'icon_mk'      => ( empty( $val['icon'] ) ) ? 'http://maps.google.com/mapfiles/marker_black.png' : $val['icon'],
								'content_html' => preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/hotel/elements/property', false, [ 'data' => $val ] ) ),

							];
						}
					}

					$data_map_origin = [];
					$data_map_origin = [
						'id'          => $post_id,
						'post_id'     => $post_id,
						'name'        => get_the_title(),
						'description' => '',
						'lat'         => $lat,
						'lng'         => $lng,
						'icon_mk'     => $map_icon,
						'featured'    => get_the_post_thumbnail_url( $post_id ),
					];
					$data_map[]      = [
						'id'           => $post_id,
						'name'         => get_the_title(),
						'post_type'    => 'st_hotel',
						'lat'          => $lat,
						'lng'          => $lng,
						'icon_mk'      => $map_icon,
						'content_html' => preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/hotel/elements/property', false, [ 'data' => $data_map_origin ] ) ),

					];

					$data_map = json_encode( $data_map, JSON_FORCE_OBJECT );
					?>
				<?php
					$google_api_key = st()->get_option( 'st_googlemap_enabled' );
				if ( $google_api_key === 'on' ) {
					?>
						<div class="st-map mt30">
							<div class="google-map gmap3" id="list_map"
								data-data_show='<?php echo str_ireplace( [ "'" ], '\"', $data_map ); ?>'
								data-lat="<?php echo trim( $lat ) ?>"
								data-lng="<?php echo trim( $lng ) ?>"
								data-icon="<?php echo esc_url( $marker_icon ); ?>"
								data-zoom="<?php echo (int) $zoom; ?>" data-disablecontrol="true"
								data-showcustomcontrol="true"
								data-style="normal">
							</div>
						</div>
					<?php } else { ?>
						<div class="st-map-box mt30">
							<div class="google-map-mapbox" data-lat="<?php echo trim( $lat ) ?>"
								data-data_show='<?php echo str_ireplace( [ "'" ], '\"', $data_map ); ?>'
									data-lng="<?php echo trim( $lng ) ?>"
									data-icon="<?php echo esc_url( $marker_icon ); ?>"
									data-zoom="<?php echo (int) $zoom; ?>" data-disablecontrol="true"
									data-showcustomcontrol="true"
									data-style="normal">
								<div id="st-map">
								</div>
							</div>
						</div>
					<?php } ?>
					</div>
					<script type="text/javascript">

					</script>
				</div>
			</div>
		</div>
		<!-- End Modal Map Popup -->
		</div>
	<?php
	endwhile;

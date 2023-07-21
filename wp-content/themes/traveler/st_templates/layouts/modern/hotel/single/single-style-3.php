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
	$price        = STHotel::get_price();
	$post_id      = get_the_ID();
	$hotel_star   = (int) get_post_meta( $post_id, 'hotel_star', true );
	$address      = get_post_meta( $post_id, 'address', true );
	$review_rate  = STReview::get_avg_rate();
	$count_review = get_comment_count( $post_id )['approved'];
	$lat          = get_post_meta( $post_id, 'map_lat', true );
	$lng          = get_post_meta( $post_id, 'map_lng', true );
	$zoom         = get_post_meta( $post_id, 'map_zoom', true );

	$gallery       = get_post_meta( $post_id, 'gallery', true );
	$gallery_array = explode( ',', $gallery );
	$marker_icon   = st()->get_option( 'st_hotel_icon_map_marker', '' );
	?>
		<div id="st-content-wrapper">
		<?php st_breadcrumbs_new() ?>
			<div class="st-hotel-map-area clearfix">
			<?php
			if ( ! empty( $gallery_array ) ) {
				?>
						<div class="st-gallery" data-nav="false" data-width="100%"
							data-allowfullscreen="true">
							<div class="fotorama" data-auto="false">
								<?php
								foreach ( $gallery_array as $value ) {
									?>
										<img src="<?php echo wp_get_attachment_image_url( $value, [ 1108, 600 ] ) ?>" alt="<?php echo get_the_title(); ?>">
										<?php
								}
								?>
							</div>
							<div class="shares dropdown">
								<?php
								$video_url = get_post_meta( get_the_ID(), 'video', true );
								if ( ! empty( $video_url ) ) {
									?>
									<a href="<?php echo esc_url( $video_url ); ?>"
										class="st-video-popup share-item"><?php echo TravelHelper::getNewIcon( 'video-player', '#FFFFFF', '20px', '20px' ) ?></a>
									<?php
								}
								?>
								<a href="#" class="share-item social-share">
									<?php echo TravelHelper::getNewIcon( 'ico_share', '', '20px', '20px' ) ?>
								</a>
								<ul class="share-wrapper">
									<li><a class="facebook"
											href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
											target="_blank" rel="noopener" original-title="Facebook"><i
													class="fa fa-facebook fa-lg"></i></a></li>
									<li><a class="twitter"
											href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
											target="_blank" rel="noopener" original-title="Twitter"><i
													class="fa fa-twitter fa-lg"></i></a></li>
									<li><a class="no-open pinterest"
										href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url( get_the_ID() ) ?>"
											target="_blank" rel="noopener" original-title="Pinterest"><i
													class="fa fa-pinterest fa-lg"></i></a></li>
									<li><a class="linkedin"
											href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
											target="_blank" rel="noopener" original-title="LinkedIn"><i
													class="fa fa-linkedin fa-lg"></i></a></li>
								</ul>
								<?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist' ); ?>
							</div>
						</div>
						<?php
			}

			if ( ! wp_is_mobile() ) {
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

				$map_icon = st()->get_option( 'st_hotel_icon_map_marker', '' );
				$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
				if ( empty( $map_icon ) ) {
					$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
				}

				$data_map = [];
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
						<div class="st-map hidden-xs hidden-sm">
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
						<div class="st-map-box hidden-xs hidden-sm">
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
					<?php
			}
			?>

			</div>
			<div class="container">
				<div class="st-hotel-content">
					<div class="row">
						<div class="col-xs-12 col-md-9 ">
							<div class="st-hotel-header">
								<div class="left">
								<?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $hotel_star ] ); ?>
									<h2 class="st-heading"><?php the_title(); ?></h2>
									<div class="sub-heading">
									<?php
									if ( $address ) {
										echo TravelHelper::getNewIcon( 'ico_maps_add_2', '#5E6D77', '16px', '16px' );
										echo esc_html( $address );
									}
									?>
										<a href="" class="st-link font-medium hidden-md hidden-lg" data-toggle="modal"
											data-target="#st-modal-show-map"> <?php echo esc_html__( 'View on map', 'traveler' ) ?></a>
										<?php
										if ( wp_is_mobile() ) {
											?>
											<div class="modal fade modal-map" id="st-modal-show-map" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?></button>
															<div class="modal-title"><?php the_title(); ?></div>
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
															if ( empty( $map_icon ) ) {
																$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
															}
															$data_map = [];
															$stt      = 1;
															global $post;
															if ( st()->get_option( 'st_show_hotel_nearby' ) == 'on' ) {
																$data = $hotel->get_near_by( get_the_ID(), $range, $number );
																if ( ! empty( $data ) ) {
																	foreach ( $data as $post ) :
																		setup_postdata( $post );
																		$map_lat = get_post_meta( get_the_ID(), 'map_lat', true );
																		$map_lng = get_post_meta( get_the_ID(), 'map_lng', true );
																		if ( ! empty( $map_lat ) and ! empty( $map_lng ) and is_numeric( $map_lat ) and is_numeric( $map_lng ) ) {
																			$data_val                         = [
																				'id' => get_the_ID(),
																				'post_id' => get_the_ID(),
																				'name' => get_the_title(),
																				'description' => '',
																				'lat' => (float) $map_lat,
																				'lng' => (float) $map_lng,
																				'icon_mk' => $map_icon,
																				'featured' => get_the_post_thumbnail_url( get_the_ID() ),
																				'url' => get_permalink( get_the_ID() ),
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
																		'id' => get_the_ID(),
																		'name' => $val['name'],
																		'post_type' => 'st_hotel',
																		'lat' => (float) $val['lat'],
																		'lng' => (float) $val['lng'],
																		'icon_mk' => ( empty( $val['icon'] ) ) ? 'http://maps.google.com/mapfiles/marker_black.png' : $val['icon'],
																		'content_html' => preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/hotel/elements/property', false, [ 'data' => $val ] ) ),

																	];
																}
															}



															$data_map_origin = [];
															$data_map_origin = [
																'id' => $post_id,
																'post_id' => $post_id,
																'name' => get_the_title(),
																'description' => '',
																'lat' => $lat,
																'lng' => $lng,
																'icon_mk' => $map_icon,
																'featured' => get_the_post_thumbnail_url( $post_id ),
															];
															$data_map[]      = [
																'id' => $post_id,
																'name' => get_the_title(),
																'post_type' => 'st_hotel',
																'lat' => $lat,
																'lng' => $lng,
																'icon_mk' => $map_icon,
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
											<?php
										}
										?>
									</div>
								</div>
								<div class="right">
									<div class="review-score">
										<div class="head clearfix">
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
							<div class="st-tabs">
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#description-tab"
																				aria-controls="description-tab" role="tab"
																				data-toggle="tab"><?php echo __( 'Description', 'traveler' ) ?></a>
									</li>
									<li role="presentation"><a href="#facilities-tab" aria-controls="facilities-tab"
																role="tab"
																data-toggle="tab"><?php echo __( 'Facilities', 'traveler' ) ?></a>
									</li>
									<li role="presentation"><a href="#rules-tab" aria-controls="rules-tab" role="tab"
																data-toggle="tab"><?php echo __( 'Rules', 'traveler' ) ?></a>
									</li>
									<?php if ( comments_open() and st()->get_option( 'hotel_review' ) == 'on' ) { ?>
									<li role="presentation"><a href="#reviews-tab" aria-controls="reviews-tab"
																role="tab"
																data-toggle="tab"><?php echo __( 'Reviews', 'traveler' ) ?></a>
									</li>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="description-tab">
										<div class="row">
											<div class="col-xs-12 col-sm-3 col-sm-push-9 col-md-4 col-md-push-8 hotel-logo">
											<?php
												$logo = get_post_meta( get_the_ID(), 'logo', true );
											if ( $logo ) {
												echo '<img src="' . esc_url( $logo ) . '" class="img-responsivve">';
											}
											?>
											</div>
											<div class="col-xs-12 col-sm-9 col-sm-pull-3 col-md-8 col-md-pull-4">
												<div class="st-description" data-toggle-section="st-description">
													<?php the_content(); ?>
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="facilities-tab">
									<?php
									$all_attribute = TravelHelper::st_get_attribute_advance( 'st_hotel' );
									foreach ( $all_attribute as $key_attr => $attr ) {
										if ( ! empty( $attr['value'] ) ) {
											$get_label_tax = get_taxonomy( $attr['value'] );
											$facilities    = get_the_terms( get_the_ID(), $attr['value'] );
											?>
												<div class="stt-attr-<?php echo esc_attr( $attr['value'] ); ?>">
												<?php
												if ( ! empty( $get_label_tax ) && ! empty( $facilities ) ) {
													echo '<h2 class="st-heading-section">' . esc_html( $get_label_tax->label ) . '</h2>';
												}
												?>
												<?php


												if ( $facilities ) {
													$count = count( $facilities );
													?>
														<div class="facilities" data-toggle-section="st-<?php echo esc_attr( $attr['value'] ); ?>"
														<?php
														if ( $count > 6 ) {
															echo 'data-show-all="st-' . esc_attr( $attr['value'] ) . '"
                                                        data-height="150"';}
														?>
															>
															<div class="row">
																<?php

																foreach ( $facilities as $term ) {
																	$icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon' ) );
																	$icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new' ) );
																	if ( ! $icon ) {
																		$icon = 'fa fa-cogs';
																	}
																	?>
																		<div class="col-xs-6 col-sm-4">
																			<div class="item has-matchHeight">
																			<?php
																			if ( ! $icon_new ) {
																				echo '<i class="' . esc_attr( $icon ) . '"></i>' . esc_html( $term->name );
																			} else {
																				echo TravelHelper::getNewIcon( $icon_new, '#5E6D77', '24px', '24px' ) . esc_html( $term->name );
																			}
																			?>
																			</div>
																		</div>
																	<?php
																}
																?>
															</div>
														</div>
														<?php if ( $count > 6 ) { ?>
															<a href="#" class="st-link block" data-show-target="st-<?php echo esc_attr( $attr['value'] ); ?>"
															data-text-less="<?php echo esc_html__( 'Show Less', 'traveler' ) ?>"
															data-text-more="<?php echo esc_html__( 'Show All', 'traveler' ) ?>"><span
																		class="text"><?php echo esc_html__( 'Show All', 'traveler' ) ?></span>
																<i
																		class="fa fa-caret-down ml3"></i></a>
															<?php
														}
												}
												if ( $facilities ) {
													?>
													<div class="st-hr large"></div>
												<?php } ?>
												</div>
											<?php
										}
									}
									?>
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
										<div id="reviews">
											<div class="row">
												<div class="col-xs-12 col-sm-4">
													<div class="review-box has-matchHeight">
														<h2 class="heading"><?php echo __( 'Review score', 'traveler' ) ?></h2>
														<div class="review-box-score">
															<?php
																$avg = STReview::get_avg_rate();
															?>
															<div class="review-score">
																<?php echo esc_attr( $avg ); ?><span class="per-total">/5</span>
															</div>
															<div class="review-score-text"><?php echo TravelHelper::get_rate_review_text( $avg, $count_review ); ?></div>
															<div class="review-score-base">
																<?php echo __( 'Based on', 'traveler' ) ?>
																<span><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-4">
													<div class="review-box has-matchHeight">
														<h2 class="heading"><?php echo __( 'Traveler rating', 'traveler' ) ?></h2>
														<?php $total = get_comments_number(); ?>
														<?php $rate_exe = STReview::count_review_by_rate( null, 5 ); ?>
														<div class="item">
															<div class="progress">
																<div class="percent green"
																	style="width: <?php echo TravelHelper::cal_rate( $rate_exe, $total ) ?>%;"></div>
															</div>
															<div class="label">
																<?php echo esc_html__( 'Excellent', 'traveler' ) ?>
																<div class="number"><?php echo esc_html( $rate_exe ); ?></div>
															</div>
														</div>
														<?php $rate_good = STReview::count_review_by_rate( null, 4 ); ?>
														<div class="item">
															<div class="progress">
																<div class="percent darkgreen"
																	style="width: <?php echo TravelHelper::cal_rate( $rate_good, $total ) ?>%;"></div>
															</div>
															<div class="label">
																<?php echo __( 'Very Good', 'traveler' ) ?>
																<div class="number"><?php echo esc_html( $rate_good ); ?></div>
															</div>
														</div>
														<?php $rate_avg = STReview::count_review_by_rate( null, 3 ); ?>
														<div class="item">
															<div class="progress">
																<div class="percent yellow"
																	style="width: <?php echo TravelHelper::cal_rate( $rate_avg, $total ) ?>%;"></div>
															</div>
															<div class="label">
																<?php echo __( 'Average', 'traveler' ) ?>
																<div class="number"><?php echo esc_html( $rate_avg ); ?></div>
															</div>
														</div>
														<?php $rate_poor = STReview::count_review_by_rate( null, 2 ); ?>
														<div class="item">
															<div class="progress">
																<div class="percent orange"
																	style="width: <?php echo TravelHelper::cal_rate( $rate_poor, $total ) ?>%;"></div>
															</div>
															<div class="label">
																<?php echo __( 'Poor', 'traveler' ) ?>
																<div class="number"><?php echo esc_html( $rate_poor ); ?></div>
															</div>
														</div>
														<?php $rate_terible = STReview::count_review_by_rate( null, 1 ); ?>
														<div class="item">
															<div class="progress">
																<div class="percent red"
																	style="width: <?php echo TravelHelper::cal_rate( $rate_terible, $total ) ?>%;"></div>
															</div>
															<div class="label">
																<?php echo __( 'Terrible', 'traveler' ) ?>
																<div class="number"><?php echo esc_html( $rate_terible ); ?></div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-4">
													<div class="review-box has-matchHeight">
														<h2 class="heading"><?php echo __( 'Summary', 'traveler' ) ?></h2>
														<?php
															$stats = STReview::get_review_summary();
														if ( $stats ) {
															foreach ( $stats as $stat ) {
																?>
																	<div class="item">
																		<div class="progress">
																			<div class="percent"
																				style="width: <?php echo esc_attr( $stat['percent'] ); ?>%;"></div>
																		</div>
																		<div class="label">
																		<?php echo esc_html( $stat['name'] ); ?>
																			<div class="number"><?php echo esc_html( $stat['summary'] ) ?>
																				/5
																			</div>
																		</div>
																	</div>
																<?php
															}
														}
														?>
													</div>
												</div>
											</div>
											<div class="review-pagination">
												<div class="summary">
													<?php
														$comments_count   = wp_count_comments( get_the_ID() );
														$total            = (int) $comments_count->approved;
														$comment_per_page = (int) get_option( 'comments_per_page', 10 );
														$paged            = (int) STInput::get( 'comment_page', 1 );
														$from             = $comment_per_page * ( $paged - 1 ) + 1;
														$to               = ( $paged * $comment_per_page < $total ) ? ( $paged * $comment_per_page ) : $total;
													?>
													<?php comments_number( __( '0 review on this Hotel', 'traveler' ), __( '1 review on this Hotel', 'traveler' ), __( '% reviews on this Hotel', 'traveler' ) ); ?>
													- <?php echo sprintf( __( 'Showing %1$s to %2$s', 'traveler' ), $from, $to ) ?>
												</div>
												<div id="reviews" class="review-list">
													<?php
														$offset         = ( $paged - 1 ) * $comment_per_page;
														$args           = [
															'number'  => $comment_per_page,
															'offset'  => $offset,
															'post_id' => get_the_ID(),
															'status' => [ 'approve' ],
														];
														$comments_query = new WP_Comment_Query;
														$comments       = $comments_query->query( $args );

														if ( $comments ) :
															foreach ( $comments as $key => $comment ) :
																echo st()->load_template( 'layouts/modern/common/reviews/review', 'list', [ 'comment' => (object) $comment ] );
															endforeach;
														endif;
														?>
												</div>
											</div>
											<?php TravelHelper::pagination_comment( [ 'total' => $total ] ) ?>
											<?php
											if ( comments_open( $post_id ) ) {
												?>
													<div id="write-review">
														<h4 class="heading">
															<a href="" class="toggle-section c-main f16" data-target="st-review-form"><?php echo __( 'Write a review', 'traveler' ) ?><i class="fa fa-angle-down ml5"></i></a>
														</h4>
													<?php
														TravelHelper::comment_form();
													?>
													</div>
													<?php
											}
											?>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="form-book-wrapper form-single-style-2 relative inline">
								<nav>
									<ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
										<li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
										<li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
									</ul>
								</nav>
								<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
									<div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
										<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
										<form class="form form-check-availability-hotel clearfix">
											<input type="hidden" name="action" value="ajax_search_room">
											<input type="hidden" name="room_search" value="1">
											<input type="hidden" name="is_search_room" value="1">
											<input type="hidden" name="room_parent"
													value="<?php echo esc_attr( get_the_ID() ); ?>">
											<?php echo st()->load_template( 'layouts/modern/hotel/elements/search/date', '' ); ?>
											<?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest', '' ); ?>
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
							<h2 class="st-heading-section"><?php echo esc_html__( 'Rooms', 'traveler' ) ?>
								<a href="#" class="pull-right toggle-section" data-target="st-list-rooms">
									<i class="fa fa-angle-up"></i>
								</a>
							</h2>
							<div class="st-list-rooms relative" data-toggle-section="st-list-rooms">
								<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
								<div class="fetch">
									<?php
									$hotel = new STHotel();
									$query = $hotel->search_room();
									while ( $query->have_posts() ) {
										$query->the_post();
										echo st()->load_template( 'layouts/modern/hotel/loop/room_item' );
									}
									wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-3 ">
							<div class="widgets">
								<div class="owner-info widget-box">
									<h4 class="heading"><?php echo __( 'Owner', 'traveler' ) ?></h4>
									<div class="media">
										<div class="media-left">
										<?php
										$author_id = get_post_field( 'post_author', get_the_ID() );
										$userdata  = get_userdata( $author_id );
										?>
											<a href="<?php echo st_get_author_posts_url( get_the_ID(), 70 ); ?>">
											<?php
											echo st_get_profile_avatar( $author_id, 60 );
											?>
											</a>
										</div>
										<div class="media-body">
											<h4 class="media-heading"><a href="<?php echo st_get_author_posts_url( get_the_ID(), 70 ); ?>" class="author-link"><?php echo TravelHelper::get_username( $author_id ); ?></a></h4>
											<p><?php echo sprintf( __( 'Member Since %s', 'traveler' ), date( 'Y', strtotime( $userdata->user_registered ) ) ) ?></p>
										</div>
									</div>
									<!--
									<?php
									$enable_inbox = st()->get_option( 'enable_inbox' );
									if ( $enable_inbox === 'on' ) {
										?>
											<div class="st_ask_question">
												<?php
												if ( ! is_user_logged_in() ) {
													?>
													<a href="" class="login btn btn-primary upper mt5" data-toggle="modal" data-target="#st-login-form"><?php echo __( 'Ask a Question', 'traveler' ); ?></a>
												<?php } else { ?>
													<a href="" id="btn-send-message-owner" class="btn-send-message-owner btn btn-primary upper mt5" data-id="<?php echo get_the_ID(); ?>"><?php echo __( 'Ask a Question', 'traveler' ); ?></a>
												<?php } ?>
											</div>
									<?php } ?> -->
								</div>
								<?php echo st()->load_template( 'layouts/modern/common/single/information-contact' ); ?>
								<?php if ( comments_open() and st()->get_option( 'hotel_review' ) == 'on' ) { ?>
								<div class="widget-box review-box">
									<h2 class="heading"><?php echo esc_html__( 'Traveler rating', 'traveler' ) ?></h2>
									<?php $total = get_comments_number(); ?>
									<?php $rate_exe = STReview::count_review_by_rate( null, 5 ); ?>
									<div class="item">
										<div class="progress">
											<div class="percent green"
												style="width: <?php echo TravelHelper::cal_rate( $rate_exe, $total ) ?>%;"></div>
										</div>
										<div class="label">
											<?php echo esc_html__( 'Excellent', 'traveler' ) ?>
											<div class="number"><?php echo esc_html( $rate_exe ); ?></div>
										</div>
									</div>
									<?php $rate_good = STReview::count_review_by_rate( null, 4 ); ?>
									<div class="item">
										<div class="progress">
											<div class="percent darkgreen"
												style="width: <?php echo TravelHelper::cal_rate( $rate_good, $total ) ?>%;"></div>
										</div>
										<div class="label">
											<?php echo __( 'Very Good', 'traveler' ) ?>
											<div class="number"><?php echo esc_html( $rate_good ); ?></div>
										</div>
									</div>
									<?php $rate_avg = STReview::count_review_by_rate( null, 3 ); ?>
									<div class="item">
										<div class="progress">
											<div class="percent yellow"
												style="width: <?php echo TravelHelper::cal_rate( $rate_avg, $total ) ?>%;"></div>
										</div>
										<div class="label">
											<?php echo __( 'Average', 'traveler' ) ?>
											<div class="number"><?php echo esc_html( $rate_avg ); ?></div>
										</div>
									</div>
									<?php $rate_poor = STReview::count_review_by_rate( null, 2 ); ?>
									<div class="item">
										<div class="progress">
											<div class="percent orange"
												style="width: <?php echo TravelHelper::cal_rate( $rate_poor, $total ) ?>%;"></div>
										</div>
										<div class="label">
											<?php echo __( 'Poor', 'traveler' ) ?>
											<div class="number"><?php echo esc_html( $rate_poor ); ?></div>
										</div>
									</div>
									<?php $rate_terible = STReview::count_review_by_rate( null, 1 ); ?>
									<div class="item">
										<div class="progress">
											<div class="percent red"
												style="width: <?php echo TravelHelper::cal_rate( $rate_terible, $total ) ?>%;"></div>
										</div>
										<div class="label">
											<?php echo __( 'Terrible', 'traveler' ) ?>
											<div class="number"><?php echo esc_html( $rate_terible ); ?></div>
										</div>
									</div>
								</div>
								<div class="widget-box review-box">
									<h2 class="heading"><?php echo __( 'Summary', 'traveler' ); ?></h2>
									<?php
										$stats = STReview::get_review_summary();
									if ( $stats ) {
										foreach ( $stats as $stat ) {
											?>
												<div class="item">
													<div class="progress">
														<div class="percent" style="width: <?php echo esc_attr( $stat['percent'] ); ?>%;">

														</div>
													</div>
													<div class="label">
													<?php echo esc_html( $stat['name'] ); ?>
														<div class="number"><?php echo esc_html( $stat['summary'] ) ?>
															/5
														</div>
													</div>
												</div>
											<?php
										}
									}
									?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			$st_show_hotel_nearby = st()->get_option( 'st_show_hotel_nearby', 'off' );
			if ( $st_show_hotel_nearby == 'on' ) {
				?>
				<div class="container">
					<div class="st-hr x-large"></div>
					<h2 class="st-heading text-center"><?php echo __( 'Hotel Nearby', 'traveler' ) ?></h2>
					<div class="services-grid services-nearby hotel-nearby grid mt50">
						<div class="row">
							<?php
								global $post;
								$hotel        = new STHotel();
								$nearby_posts = $hotel->get_near_by();
							if ( $nearby_posts ) {
								foreach ( $nearby_posts as $key => $post ) {
									setup_postdata( $post );
									$hotel_star  = (int) get_post_meta( get_the_ID(), 'hotel_star', true );
									$price       = STHotel::get_price();
									$address     = get_post_meta( get_the_ID(), 'address', true );
									$review_rate = STReview::get_avg_rate();
									$is_featured = get_post_meta( get_the_ID(), 'is_featured', true );
									?>
										<div class="col-xs-12 col-sm-6 col-md-3">
											<div class="item">
												<div class="featured-image">
												<?php
												if ( $is_featured == 'on' ) {
													?>
															<div class="featured"><?php echo __( 'Featured', 'traveler' ) ?></div>
														<?php } ?>
													<a href="<?php the_permalink() ?>">
														<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>"
															alt="" class="img-responsive img-full">
													</a>
													<?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $hotel_star ] ); ?>
												</div>
												<h3 class="title">
													<a href="<?php the_permalink(); ?>" class="st-link c-main">
														<?php the_title(); ?>
													</a>
												</h3>
												<div class="sub-title">
													<?php
													if ( $address ) {
														echo TravelHelper::getNewIcon( 'ico_maps_search_box', '', '10px' );
														echo esc_html( $address );
													}
													?>
												</div>
												<div class="reviews">
													<span class="rate"><?php echo esc_attr( $review_rate ); ?>/5
													<?php echo TravelHelper::get_rate_review_text( $review_rate, $count_review ); ?></span><span
															class="summary"><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></span>
												</div>
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
										<?php
								}
								wp_reset_query();
								wp_reset_postdata();
							}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php
	endwhile;

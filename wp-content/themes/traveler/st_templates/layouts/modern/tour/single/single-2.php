<?php
	/**
	 * Created by PhpStorm.
	 * User: Administrator
	 * Date: 20-12-2018
	 * Time: 1:55 PM
	 * Since: 1.0.0
	 * Updated: 1.0.0
	 */
while ( have_posts() ) :
	the_post();
	$post_id                        = get_the_ID();
	$address                        = get_post_meta( $post_id, 'address', true );
	$review_rate                    = STReview::get_avg_rate();
	$count_review                   = STReview::count_review( $post_id );
	$lat                            = get_post_meta( $post_id, 'map_lat', true );
	$lng                            = get_post_meta( $post_id, 'map_lng', true );
	$zoom                           = get_post_meta( $post_id, 'map_zoom', true );
	$enable_street_views_google_map = get_post_meta( $post_id, 'enable_street_views_google_map', true );
	$gallery                        = get_post_meta( $post_id, 'gallery', true );
	$gallery_array                  = explode( ',', $gallery );
	$marker_icon                    = st()->get_option( 'st_tours_icon_map_marker', '' );
	$tour_external                  = get_post_meta( get_the_ID(), 'st_tour_external_booking', true );
	$tour_external_link             = get_post_meta( get_the_ID(), 'st_tour_external_booking_link', true );
	$booking_type                   = st_get_booking_option_type();
	$map_iframe                     = get_post_meta( $post_id, 'map_iframe', true );
	$is_iframe                      = get_post_meta( get_the_ID(), 'is_iframe', true );
	$icon_duration_single_tour      = st()->get_option( 'icon_duration_single_tour', '<i class="lar la-clock"></i>' );
	$icon_tourtype_single_tour      = st()->get_option( 'icon_tourtype_single_tour', '<i class="las la-shoe-prints"></i>' );
	$icon_groupsize_single_tour     = st()->get_option( 'icon_groupsize_single_tour', '<i class="las la-user-friends"></i>' );
	$icon_language_single_tour      = st()->get_option( 'icon_language_single_tour', '<i class="las la-language"></i>' );
	?>
		<div id="st-content-wrapper" class="st-single-tour style-2">
		<?php st_breadcrumbs_new() ?>
			<div class="hotel-target-book-mobile">
				<div class="price-wrapper">
				<?php echo wp_kses( sprintf( __( 'from <span class="price">%s</span>', 'traveler' ), STTour::get_price_html( get_the_ID() ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
				</div>
			<?php
			if ( $tour_external == 'off' || empty( $tour_external ) ) {
				?>
					<a href=""
						class="btn btn-mpopup btn-green">
					<?php
					if ( $booking_type == 'enquire' ) {
						echo esc_html__( 'Inquiry', 'traveler' );
					} else {
						echo esc_html__( 'Book Now', 'traveler' );
					}
					?>
					</a>
					<?php
			} else {
				?>
					<a href="<?php echo esc_url( $tour_external_link ); ?>"
						class="btn btn-green"><?php echo esc_html__( 'Explore', 'traveler' ) ?></a>
					<?php
			}
			?>
			</div>
			<div class="st-tour-content">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-9">
							<div class="st-hotel-header">
								<div class="left">
									<h2 class="st-heading"><?php the_title(); ?></h2>
									<div class="sub-heading">
									<?php
									if ( $address ) {
										echo TravelHelper::getNewIcon( 'ico_maps_add_2', '#5E6D77', '16px', '16px' );
										echo esc_html( $address );
									}
									?>
									</div>
								</div>
								<div class="right">
									<div class="review-score style-2">
										<span class="head-rating"><?php echo TravelHelper::get_rate_review_text( $review_rate, $count_review ); ?></span>
										<?php
										echo st()->load_template( 'layouts/modern/common/star', '', [
											'star'  => $review_rate,
											'style' => 'style-2',
										] );
										?>
										<p class="st-link"><?php comments_number( __( 'from 0 review', 'traveler' ), __( 'from 1 review', 'traveler' ), __( 'from % reviews', 'traveler' ) ); ?></p>
									</div>
								</div>
							</div>

							<!--Tour Info-->
							<div class="st-tour-feature">
								<div class="row">
									<div class="col-xs-6 col-lg-3">
										<div class="item">
											<div class="icon">
											<?php echo htmlspecialchars_decode( $icon_duration_single_tour ); ?>
											</div>
											<div class="info">
												<div class="name"><?php echo __( 'Duration', 'traveler' ); ?></div>
												<p class="value">
												<?php
												$duration = get_post_meta( get_the_ID(), 'duration_day', true );
												echo esc_html( $duration );
												?>
												</p>
											</div>
										</div>
									</div>
									<div class="col-xs-6 col-lg-3">
										<div class="item">
											<div class="icon">
												<?php echo htmlspecialchars_decode( $icon_tourtype_single_tour ); ?>
											</div>
											<div class="info">
												<div class="name"><?php echo __( 'Tour Type', 'traveler' ); ?></div>
												<p class="value">
													<?php
													$tour_type = get_post_meta( get_the_ID(), 'type_tour', true );
													if ( $tour_type == 'daily_tour' ) {
														echo __( 'Daily Tour', 'traveler' );
													} else {
														echo __( 'Specific Tour', 'traveler' );
													}
													?>
												</p>
											</div>
										</div>
									</div>
									<div class="col-xs-6 col-lg-3">
										<div class="item">
											<div class="icon">
												<?php echo htmlspecialchars_decode( $icon_groupsize_single_tour ); ?>
											</div>
											<div class="info">
												<div class="name"><?php echo __( 'Group Size', 'traveler' ); ?></div>
												<p class="value">
													<?php
													$max_people = get_post_meta( get_the_ID(), 'max_people', true );
													if ( empty( $max_people ) or $max_people == 0 or $max_people < 0 ) {
														echo __( 'Unlimited', 'traveler' );
													} elseif ( $max_people == 1 ) {
															echo sprintf( __( '%s person', 'traveler' ), $max_people );
													} else {
														echo sprintf( __( '%s people', 'traveler' ), $max_people );
													}
													?>
												</p>
											</div>
										</div>
									</div>
									<div class="col-xs-6 col-lg-3">
										<div class="item">
											<div class="icon">
												<?php echo htmlspecialchars_decode( $icon_language_single_tour ); ?>
											</div>
											<div class="info">
												<div class="name"><?php echo __( 'Languages', 'traveler' ); ?></div>
												<p class="value">
													<?php
													$term_list    = wp_get_post_terms( get_the_ID(), 'languages' );
													$str_term_arr = [];
													if ( ! is_wp_error( $term_list ) && ! empty( $term_list ) ) {
														foreach ( $term_list as $k => $v ) {
															array_push( $str_term_arr, $v->name );
														}

														echo implode( ', ', $str_term_arr );
													} else {
														echo '___';
													}
													?>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--End Tour info-->
							<?php
							if ( ! empty( $gallery_array ) ) {
								?>
									<div class="st-gallery" data-width="100%"
										data-nav="thumbs" data-allowfullscreen="true">
										<div class="fotorama" data-auto="false">
											<?php
											foreach ( $gallery_array as $value ) {
												?>
													<img src="<?php echo wp_get_attachment_image_url( $value, [ 870, 555 ] ) ?>" alt="<?php echo get_the_title(); ?>">
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
											<?php } ?>
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
							?>
							<!--Tour Overview-->
							<?php
							global $post;
							$content = $post->post_content;
							if ( ! empty( $content ) ) {
								?>
								<div class="st-overview">
									<h3 class="st-section-title"><?php echo __( 'Overview', 'traveler' ); ?></h3>
									<div class="st-description" data-toggle-section="st-description" >
										<?php the_content(); ?>
									</div>
								</div>
							<?php } ?>
							<!--End Tour Overview-->

							<!--Tour highlight-->

							<?php
							$tours_highlight = get_post_meta( get_the_ID(), 'tours_highlight', true );
							if ( ! empty( $tours_highlight ) ) {
								$arr_highlight = explode( "\n", trim( $tours_highlight ) );
								?>
							<div class="st-highlight">
								<h2 class="st-heading-section"><?php echo __( 'Highlights', 'traveler' ); ?></h2>
								<ul>
									<?php
									if ( ! empty( $arr_highlight ) ) {
										foreach ( $arr_highlight as $k => $v ) {
											echo '<li>' . esc_html( $v ) . '</li>';
										}
									}
									?>
								</ul>
							</div>
							<?php } ?>
							<!--End Tour highlight-->
							<!--Table Discount group -->
							<?php
							$discount_by_adult = ! empty( get_post_meta( get_the_ID(), 'discount_by_adult' ) ) ? get_post_meta( get_the_ID(), 'discount_by_adult', true ) : '';
							$discount_by_child = ! empty( get_post_meta( get_the_ID(), 'discount_by_child' ) ) ? get_post_meta( get_the_ID(), 'discount_by_child', true ) : '';
							if ( ! empty( $discount_by_adult ) || ! empty( $discount_by_child ) ) {
								$discount_by_people_type = ! empty( get_post_meta( get_the_ID(), 'discount_by_people_type' ) ) ? get_post_meta( get_the_ID(), 'discount_by_people_type', true ) : '';
								if ( $discount_by_people_type == 'amount' ) {
									$text_discount_by_people_type = __( 'by Amount', 'traveler' );
								} else {
									$text_discount_by_people_type = __( 'by Percent', 'traveler' );
								}
								?>
								<div class="st-program" id="headingDiscount">
									<div class="st-title-wrapper">
										<h3 class="st-section-title"><?php echo __( 'Bulk discount', 'traveler' ) . ' (' . esc_html( $text_discount_by_people_type ) . ')'; ?></h3>
									</div>
									<?php if ( ! empty( $discount_by_adult ) ) { ?>
										<h5><?php echo esc_html__( 'Bulk discount adult', 'traveler' ); ?></h5>
										<table class="table">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col"><?php echo esc_html__( 'Discount group', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'From adult', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'To adult', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'Value', 'traveler' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach ( $discount_by_adult as $key => $discount_adult ) {
													?>
														<tr>
															<th scope="row"><?php echo intval( $key + 1 ) ?></th>
															<td><?php echo esc_html( $discount_adult['title'] ); ?></td>
															<td><?php echo esc_html( $discount_adult['key'] ); ?></td>
															<td><?php echo esc_html( $discount_adult['key_to'] ); ?></td>
															<td>
																<?php
																if ( $discount_by_people_type == 'amount' ) {
																	echo TravelHelper::format_money( $discount_adult['value'] );
																} else {
																	echo esc_html( $discount_adult['value'] ) . '%';
																}
																?>
															</td>
														</tr>
													<?php
												}
												?>

											</tbody>
										</table>
									<?php } ?>
									<?php if ( ! empty( $discount_by_child ) ) { ?>
										<h5><?php echo esc_html__( 'Bulk discount children', 'traveler' ); ?></h5>
										<table class="table">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col"><?php echo esc_html__( 'Discount group', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'From adult', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'To adult', 'traveler' ); ?></th>
													<th scope="col"><?php echo esc_html__( 'Value', 'traveler' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach ( $discount_by_child as $key => $discount_child ) {
													?>
														<tr>
															<th scope="row"><?php echo intval( $key + 1 ) ?></th>
															<td><?php echo esc_html( $discount_child['title'] ); ?></td>
															<td><?php echo esc_html( $discount_child['key'] ); ?></td>
															<td><?php echo esc_html( $discount_child['key_to'] ); ?></td>
															<td>
																<?php
																if ( $discount_by_people_type == 'amount' ) {
																	echo TravelHelper::format_money( $discount_child['value'] );
																} else {
																	echo esc_html( $discount_child['value'] ) . '%';
																}
																?>
															</td>
														</tr>
													<?php
												}
												?>

											</tbody>
										</table>
									<?php } ?>
								</div>
							<?php } ?>
							<!--End Table Discount group -->
							<!--Tour program-->
							<div class="st-program">
							<?php
							$tour_program_style = get_post_meta( get_the_ID(), 'tours_program_style', true );
							if ( empty( $tour_program_style ) ) {
								$tour_program_style = 'style1';
							}
							?>
								<div class="st-title-wrapper">
									<h3 class="st-section-title"><?php echo __( 'Itinerary', 'traveler' ); ?></h3>
								</div>
								<div class="st-program-list <?php echo esc_attr( $tour_program_style ); ?>">
								<?php
								echo st()->load_template( 'layouts/modern/tour/single/items/itenirary/' . esc_attr( $tour_program_style ) );
								?>
								</div>
							</div>
							<!--End Tour program-->

							<!--Tour Include/Exclude-->
							<div class="st-include">
								<h3 class="st-section-title">
								<?php echo __( 'Included/Excluded', 'traveler' ); ?>
								</h3>
								<div class="row">
									<div class="col-lg-6">
										<ul class="include">
										<?php
										$include = get_post_meta( get_the_ID(), 'tours_include', true );
										if ( ! empty( $include ) ) {
											$in_arr = explode( "\n", $include );
											if ( ! empty( $in_arr ) ) {
												foreach ( $in_arr as $k => $v ) {
													echo '<li>' . TravelHelper::getNewIcon( 'check-1', '#2ECC71', '14px', '14px', false ) . esc_html( $v ) . '</li>';
												}
											}
										}
										?>
										</ul>
									</div>
									<div class="col-lg-6">
										<ul class="exclude">
										<?php
										$exclude = get_post_meta( get_the_ID(), 'tours_exclude', true );
										if ( ! empty( $exclude ) ) {
											$ex_arr = explode( "\n", $exclude );
											if ( ! empty( $ex_arr ) ) {
												foreach ( $ex_arr as $k => $v ) {
													echo '<li>' . TravelHelper::getNewIcon( 'remove', '#FA5636', '18px', '18px', false ) . esc_html( $v ) . '</li>';
												}
											}
										}
										?>
										</ul>
									</div>
								</div>
							</div>
							<!--End Tour Include/Exclude-->
							<?php
							$all_attribute = TravelHelper::st_get_attribute_advance( 'st_tours' );
							foreach ( $all_attribute as $key_attr => $attr ) {
								$facilities = get_the_terms( get_the_ID(), $attr['value'] );
								if ( ! empty( $attr['value'] ) && ( ! empty( $facilities ) ) && ( $attr['value'] !== 'languages' ) ) {
									$get_label_tax = get_taxonomy( $attr['value'] );
									if ( $attr['value'] !== 'st_tour_type' ) {
										?>
											<div class="stt-attr-<?php echo esc_attr( $attr['value'] ); ?>">
												<div class="st-hr large"></div>
											<?php
											if ( ! empty( $get_label_tax ) ) {
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
																<i  class="fa fa-caret-down ml3"></i></a>
															<?php
														}
												}
												?>
											</div>
										<?php
									}
								}
							}
							?>
							<!--Tour Map-->
							<?php
							if ( $is_iframe == 'on' ) {
								if ( ! empty( $map_iframe ) ) {
									?>
									<div class="st-hr large st-height2"></div>
									<div class="st-map-wrapper">
										<div class="st-flex space-between">
											<h2 class="st-heading-section mg0"><?php echo __( 'Tour\'s Location', 'traveler' ) ?></h2>
											<?php
											if ( $address ) {
												?>
												<div class="c-grey">
												<?php
													echo TravelHelper::getNewIcon( 'Ico_maps', '#5E6D77', '18px', '18px' );
													echo esc_html( $address );
												?>
													</div>
												<?php
											}
											?>
										</div>
										<div class="map_iframe">
											<?php echo balanceTags( $map_iframe ); ?>
										</div>

									</div>
									<?php
								}
							} else {
								?>
								<div class="st-hr large st-height2"></div>
								<div class="st-map-wrapper">
									<?php
									if ( ! $zoom ) {
										$zoom = 13;
									}
									?>
									<div class="st-flex space-between">
										<h2 class="st-heading-section mg0"><?php echo __( 'Tour\'s Location', 'traveler' ) ?></h2>
										<?php
										if ( $address ) {
											?>
											<div class="c-grey">
											<?php
												echo TravelHelper::getNewIcon( 'Ico_maps', '#5E6D77', '18px', '18px' );
												echo esc_html( $address );
											?>
												</div>
											<?php
										}
										?>
									</div>
																<?php
																$default = apply_filters('st_tour_property_near_by_params', [
																	'number'      => '12',
																	'range'       => '50',
																	'show_circle' => 'no',
																]);
																extract( $default );
																$hotel           = new STTour();
																$location_center = '[' . $lat . ',' . $lng . ']';
																$map_lat_center  = $lat;
																$map_lng_center  = $lng;
																$map_icon        = st()->get_option( 'st_tours_icon_map_marker', '' );
																if ( empty( $map_icon ) ) {
																	$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_tours.png';
																}
																$data_map = [];
																$stt      = 1;
																global $post;
																if ( st()->get_option( 'st_show_tour_nearby' ) == 'on' ) {
																	$data = $hotel->get_near_by( get_the_ID(), $range, $number );
																	if ( ! empty( $data ) ) {
																		$stt = 1;
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
																			'id'      => get_the_ID(),
																			'name'    => $val['name'],
																			'post_type' => 'st_hotel',
																			'lat'     => (float) $val['lat'],
																			'lng'     => (float) $val['lng'],
																			'icon_mk' => ( empty( $val['icon'] ) ) ? 'http://maps.google.com/mapfiles/marker_black.png' : $val['icon'],
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
												data-street_views="<?php echo trim( $enable_street_views_google_map ) ?>"
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
														<?php } ?>
							<!--End Tour Map-->

							<!--Tour FAQ-->
							<?php
							$tour_faq = get_post_meta( get_the_ID(), 'tours_faq', true );
							if ( ! empty( $tour_faq ) ) {
								?>
								<div class="st-faq">
									<h3 class="st-section-title">
										<?php echo __( 'FAQs', 'traveler' ); ?>
									</h3>
									<?php $i = 0; foreach ( $tour_faq as $k => $v ) { ?>
									<div class="item <?php echo ( $i == 0 ) ? 'active' : ''; ?>">
										<div class="header">
											<?php echo TravelHelper::getNewIcon( 'question-help-message', '#5E6D77', '18px', '18px' ); ?>
											<h5><?php echo balanceTags( $v['title'] ); ?></h5>
											<span class="arrow">
												<i class="fa fa-angle-down"></i>
											</span>
										</div>
										<div class="body">
											<?php echo balanceTags( nl2br( $v['desc'] ) ); ?>
										</div>
									</div>
									<?php ++$i; } ?>
								</div>
								<?php
							}
							?>
							<!--End Tour FAQ-->

							<!--Review Option-->
							<?php if ( comments_open() and st()->get_option( 'activity_tour_review' ) == 'on' ) { ?>
							<div class="st-hr large st-height2 st-hr-comment"></div>
							<h2 class="st-heading-section"><?php echo esc_html__( 'Reviews', 'traveler' ) ?></h2>
							<div id="reviews" data-toggle-section="st-reviews">
								<div class="review-box">
									<div class="row">
										<div class="col-lg-5">
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
										<div class="col-lg-7">
											<div class="review-sumary">
												<?php $total = get_comments_number(); ?>
												<?php $rate_exe = STReview::count_review_by_rate( null, 5 ); ?>
												<div class="item">
													<div class="label">
														<?php echo esc_html__( 'Excellent', 'traveler' ) ?>
													</div>
													<div class="progress">
														<div class="percent green"
															style="width: <?php echo TravelHelper::cal_rate( $rate_exe, $total ) ?>%;"></div>
													</div>
													<div class="number"><?php echo esc_html( $rate_exe ); ?></div>
												</div>
												<?php $rate_good = STReview::count_review_by_rate( null, 4 ); ?>
												<div class="item">
													<div class="label">
														<?php echo __( 'Very Good', 'traveler' ) ?>
													</div>
													<div class="progress">
														<div class="percent darkgreen"
															style="width: <?php echo TravelHelper::cal_rate( $rate_good, $total ) ?>%;"></div>
													</div>
													<div class="number"><?php echo esc_html( $rate_good ); ?></div>
												</div>
												<?php $rate_avg = STReview::count_review_by_rate( null, 3 ); ?>
												<div class="item">
													<div class="label">
														<?php echo __( 'Average', 'traveler' ) ?>
													</div>
													<div class="progress">
														<div class="percent yellow"
															style="width: <?php echo TravelHelper::cal_rate( $rate_avg, $total ) ?>%;"></div>
													</div>
													<div class="number"><?php echo esc_html( $rate_avg ); ?></div>
												</div>
												<?php $rate_poor = STReview::count_review_by_rate( null, 2 ); ?>
												<div class="item">
													<div class="label">
														<?php echo __( 'Poor', 'traveler' ) ?>
													</div>
													<div class="progress">
														<div class="percent orange"
															style="width: <?php echo TravelHelper::cal_rate( $rate_poor, $total ) ?>%;"></div>
													</div>
													<div class="number"><?php echo esc_html( $rate_poor ); ?></div>
												</div>
												<?php $rate_terible = STReview::count_review_by_rate( null, 1 ); ?>
												<div class="item">
													<div class="label">
														<?php echo __( 'Terrible', 'traveler' ) ?>
													</div>
													<div class="progress">
														<div class="percent red"
															style="width: <?php echo TravelHelper::cal_rate( $rate_terible, $total ) ?>%;"></div>
													</div>
													<div class="number"><?php echo esc_html( $rate_terible ); ?></div>
												</div>
											</div>
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
									</div>
									<div id="reviews" class="review-list">
										<?php
										$offset         = ( $paged - 1 ) * $comment_per_page;
										$args           = [
											'number'  => $comment_per_page,
											'offset'  => $offset,
											'post_id' => get_the_ID(),
											'status'  => [ 'approve' ],
										];
										$comments_query = new WP_Comment_Query;
										$comments       = $comments_query->query( $args );

										if ( $comments ) :
											foreach ( $comments as $key => $comment ) :
												echo st()->load_template( 'layouts/modern/common/reviews/review', 'list', [
													'comment' => (object) $comment,
													'post_type' => 'st_tours',
												] );
											endforeach;
										endif;
										?>
									</div>
								</div>
								<div class="review-pag-wrapper">
									<div class="review-pag-text">
										<?php echo sprintf( __( 'Showing %1$s - %2$s of %3$s in total', 'traveler' ), $from, $to, get_comments_number_text( '0', '1', '%' ) ) ?>
									</div>
									<?php TravelHelper::pagination_comment( [ 'total' => $total ] ) ?>
								</div>
								<?php
								if ( comments_open( $post_id ) ) {
									?>
									<div id="write-review">
										<h4 class="heading">
											<a href="" class="toggle-section c-main f16"
												data-target="st-review-form"><?php echo __( 'Write a review', 'traveler' ) ?>
												<i class="fa fa-angle-down ml5"></i></a>
										</h4>
										<?php
										TravelHelper::comment_form();
										?>
									</div>
									<?php
								}
								?>
							</div>
							<?php } ?>
							<!--End Review Option-->
							<div class="stoped-scroll-section"></div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3">
							<?php
							$info_price = STTour::get_info_price();
							?>
							<div class="widgets">
								<div class="fixed-on-mobile" id="booking-request" data-screen="992px">
									<div class="close-icon hide">
									<?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
									</div>

								<?php
								if ( $booking_type == 'instant_enquire' ) {
									?>
											<div class="form-book-wrapper relative">
										<?php if ( ! empty( $info_price['discount'] ) and $info_price['discount'] > 0 and $info_price['price_new'] > 0 ) { ?>
													<div class="tour-sale-box">
														<?php echo STFeatured::get_sale( $info_price['discount'] ); ?>
													</div>
												<?php } ?>
										<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
												<div class="form-head">
													<div class="price">
												<span class="label">
											<?php _e( 'from', 'traveler' ) ?>
												</span>
														<span class="value">
											<?php
											echo STTour::get_price_html( get_the_ID() );
											?>
												</span>
													</div>
												</div>
												<nav>
													<ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
														<li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
														<li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
													</ul>
												</nav>
												<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
													<div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
												<?php if ( empty( $tour_external ) || $tour_external == 'off' ) { ?>
															<form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
																<input type="hidden" name="action" value="tours_add_to_cart">
																<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
																<input type="hidden" name="type_tour"
																		value="<?php echo get_post_meta( get_the_ID(), 'type_tour', true ) ?>">
																<?php
																$current_calendar        = TravelHelper::get_current_available_calendar( TravelHelper::post_origin( get_the_ID(), 'st_tours' ) );
																$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );

																$start        = STInput::request( 'start', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
																$end          = STInput::request( 'end', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
																$time_checkin = strtotime( date( TravelHelper::getDateFormat(), strtotime( $start ) ) );
																if ( ! empty( st_get_date_checkin_checkout_groupday_tour( get_the_ID(), $time_checkin ) ) ) {
																	$timestamp_end = st_get_date_checkin_checkout_groupday_tour( get_the_ID(), $time_checkin )[0]['check_out'];
																	$end           = STInput::request( 'end', date( TravelHelper::getDateFormat(), $timestamp_end ) );
																}
																$date     = STInput::request( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) );
																$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
																?>
																<div class="form-group form-date-field form-date-search clearfix
																<?php
																if ( $has_icon ) {
																	echo ' has-icon ';}
																?>
																"
																	data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr( $current_calendar_reverb ); ?>">
																	<?php
																	if ( $has_icon ) {
																		echo TravelHelper::getNewIcon( 'ico_calendar_search_box' );
																	}
																	?>
																	<div class="date-wrapper clearfix">
																		<div class="check-in-wrapper">
																			<label><?php echo __( 'Date', 'traveler' ); ?></label>
																			<div class="render check-in-render"><?php echo esc_html( $start ); ?></div>
																			<?php
																			$class_hidden_enddate = 'hidden';
																			if ( $tour_type != 'daily_tour' && ( strtotime( $end ) - strtotime( $start ) ) > 0 ) {
																				$class_hidden_enddate = '';
																			}
																			?>
																			<span class="sts-tour-checkout-label <?php echo esc_attr( $class_hidden_enddate ); ?>"><span> - </span><div
																						class="render check-out-render"><?php echo esc_html( $end ); ?></div></span>
																		</div>
																		<i class="fa fa-angle-down arrow"></i>
																	</div>
																	<input type="text" class="check-in-input"
																			value="<?php echo esc_attr( $start ) ?>" name="check_in">
																	<input type="hidden" class="check-out-input"
																			value="<?php echo esc_attr( $end ) ?>" name="check_out">
																	<input type="text" class="check-in-out-input"
																			value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
																			data-action="st_get_availability_tour_frontend"
																			data-tour-id="<?php the_ID(); ?>" data-posttype="st_tours">
																</div>

																<?php
																/*Starttime*/
																$starttime_value  = STInput::request( 'starttime_tour', '' );
																$current_calendar = date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) );
																$list_time        = AvailabilityHelper::_get_starttime_tour_frontend_by_date( get_the_ID(), $current_calendar, $current_calendar );
																?>
																<div class="form-group form-more-extra st-form-starttime"
																	<?php
																	if ( ! empty( $list_time['data'] ) && ! empty( $list_time['data'][0] ) ) {
																		echo '';
																	} else {
																		echo 'style="display: none"';
																	}
																	?>
																	>
																	<input type="hidden" data-starttime="<?php echo esc_attr( $starttime_value ); ?>"
																		data-checkin="<?php echo esc_attr( $start ); ?>"
																		data-checkout="<?php echo esc_attr( $end ); ?>"
																		data-tourid="<?php echo get_the_ID(); ?>"
																		id="starttime_hidden_load_form"  data-posttype="st_tours"/>
																	<div class="" id="starttime_box">
																		<label><?php echo __( 'Start time', 'traveler' ); ?></label>
																		<select class="form-control st_tour_starttime" name="starttime_tour"
																				id="starttime_tour">
																			<?php
																			if ( ! empty( $list_time['data'] ) && ! empty( $list_time['data'][0] ) ) {
																				$name = count( $list_time['data'] ) > 1 ? __( 'vacancies', 'traveler' ) : __( 'a vacancy', 'traveler' );
																				foreach ( $list_time['data'] as $key => $time ) {
																					if ( intval( $list_time['check'][ $key ] ) > 0 ) {
																						$num_vacancies = intval( $list_time['check'][ $key ] );
																					} else {
																						$num_vacancies = esc_html__( 'Unlimited', 'traveler' );
																					}
																					?>
																					<option value="<?php echo esc_attr( $time ); ?>"><?php echo esc_attr( $time ); ?> ( <?php echo esc_html( $num_vacancies ); ?> <?php echo esc_html( $name ); ?> )</option>
																					<?php
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<!--End starttime-->

																<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/guest', '' ); ?>
																<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/package', '' ); ?>
																<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/extra', '' ); ?>
																<div class="submit-group">
																	<button class="btn btn-large btn-full upper btn-book-ajax"
																			type="submit"
																			name="submit">
																		<?php echo esc_html__( 'Book Now', 'traveler' ) ?>
																		<i class="fa fa-spinner fa-spin hide"></i>
																	</button>
																	<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
																</div>
																<div class="message-wrapper mt30">

																</div>
															</form>
														<?php } else { ?>
															<div class="submit-group mb30">
																<a href="<?php echo esc_url( $tour_external_link ); ?>"
																class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
																<form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
																	<input type="hidden" name="action" value="tours_add_to_cart">
																	<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
																	<input type="hidden" name="type_tour"
																			value="<?php echo get_post_meta( get_the_ID(), 'type_tour', true ) ?>">
																	<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
																</form>
															</div>
														<?php } ?>
													</div>
													<div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
														<?php echo st()->load_template( 'email/email_single_service' ); ?>
													</div>
												</div>
											</div>
											<?php
								} elseif ( $booking_type == 'enquire' ) {
									?>
												<div class="form-book-wrapper relative">
											<?php if ( ! empty( $info_price['discount'] ) and $info_price['discount'] > 0 and $info_price['price_new'] > 0 ) { ?>
														<div class="tour-sale-box">
															<?php echo STFeatured::get_sale( $info_price['discount'] ); ?>
														</div>
													<?php } ?>
											<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
													<div class="form-head">
														<div class="price">
															<span class="label">
														<?php _e( 'from', 'traveler' ) ?>
															</span>
																		<span class="value">
														<?php
														echo STTour::get_price_html( get_the_ID() );
														?>
															</span>
														</div>
													</div>
													<h4 class="title-enquiry-form"><?php echo esc_html__( 'Inquiry', 'traveler' ); ?></h4>
													<?php echo st()->load_template( 'email/email_single_service' ); ?>
													<form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
														<input type="hidden" name="action" value="tours_add_to_cart">
														<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
														<input type="hidden" name="type_tour"
																value="<?php echo get_post_meta( get_the_ID(), 'type_tour', true ) ?>">
														<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
													</form>
												</div>
												<?php
								} else {
									?>
												<div class="form-book-wrapper relative">
										<?php if ( ! empty( $info_price['discount'] ) and $info_price['discount'] > 0 and $info_price['price_new'] > 0 ) { ?>
														<div class="tour-sale-box">
															<?php echo STFeatured::get_sale( $info_price['discount'] ); ?>
														</div>
													<?php } ?>
										<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
													<div class="form-head">
														<div class="price">
												<span class="label">
										<?php _e( 'from', 'traveler' ) ?>
												</span>
															<span class="value">
										<?php
										echo STTour::get_price_html( get_the_ID() );
										?>
												</span>
														</div>
													</div>
										<?php if ( empty( $tour_external ) || $tour_external == 'off' ) { ?>
														<form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
															<input type="hidden" name="action" value="tours_add_to_cart">
															<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
															<input type="hidden" name="type_tour" value="<?php echo get_post_meta( get_the_ID(), 'type_tour', true ) ?>">
															<?php
															$current_calendar        = TravelHelper::get_current_available_calendar( TravelHelper::post_origin( get_the_ID(), 'st_tours' ) );
															$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );

															$start        = STInput::request( 'start', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$end          = STInput::request( 'end', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$time_checkin = strtotime( date( TravelHelper::getDateFormat(), strtotime( $start ) ) );
															if ( ! empty( st_get_date_checkin_checkout_groupday_tour( get_the_ID(), $time_checkin ) ) ) {
																$timestamp_end = st_get_date_checkin_checkout_groupday_tour( get_the_ID(), $time_checkin )[0]['check_out'];
																$end           = STInput::request( 'end', date( TravelHelper::getDateFormat(), $timestamp_end ) );
															}

															$date     = STInput::request( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) );
															$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
															?>
															<div class="form-group form-date-field form-date-search clearfix
															<?php
															if ( $has_icon ) {
																echo ' has-icon ';}
															?>
															" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr( $current_calendar_reverb ); ?>">
																<?php
																if ( $has_icon ) {
																	echo TravelHelper::getNewIcon( 'ico_calendar_search_box' );
																}
																?>
																<div class="date-wrapper clearfix">
																	<div class="check-in-wrapper">
																		<label><?php echo __( 'Date', 'traveler' ); ?></label>
																		<div class="render check-in-render"><?php echo esc_html( $start ); ?></div>
																		<?php
																		$class_hidden_enddate = 'hidden';
																		if ( $tour_type != 'daily_tour' && ( strtotime( $end ) - strtotime( $start ) ) > 0 ) {
																			$class_hidden_enddate = '';
																		}
																		?>
																		<span class="sts-tour-checkout-label <?php echo esc_attr( $class_hidden_enddate ); ?>"><span> - </span><div class="render check-out-render"><?php echo esc_html( $end ); ?></div></span>
																	</div>
																	<i class="fa fa-angle-down arrow"></i>
																</div>
																<input type="text" class="check-in-input" value="<?php echo esc_attr( $start ) ?>" name="check_in">
																<input type="hidden" class="check-out-input" value="<?php echo esc_attr( $end ) ?>" name="check_out" >
																<input type="text" class="check-in-out-input" value="<?php echo esc_attr( $date ) ?>" name="check_in_out" data-action="st_get_availability_tour_frontend" data-tour-id="<?php the_ID(); ?>" data-posttype="st_tours">
															</div>

															<?php
															/*Starttime*/
															$starttime_value  = STInput::request( 'starttime_tour', '' );
															$current_calendar = date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) );
															$list_time        = AvailabilityHelper::_get_starttime_tour_frontend_by_date( get_the_ID(), $current_calendar, $current_calendar );
															?>
															<div class="form-group form-more-extra st-form-starttime"
																<?php
																if ( ! empty( $list_time['data'] ) && ! empty( $list_time['data'][0] ) ) {
																	echo '';
																} else {
																	echo 'style="display: none"';
																}
																?>
																>
																<input type="hidden" data-starttime="<?php echo esc_attr( $starttime_value ); ?>"
																	data-checkin="<?php echo esc_attr( $start ); ?>"
																	data-checkout="<?php echo esc_attr( $end ); ?>"
																	data-tourid="<?php echo get_the_ID(); ?>"
																	id="starttime_hidden_load_form"  data-posttype="st_tours"/>
																<div class="" id="starttime_box">
																	<label><?php echo __( 'Start time', 'traveler' ); ?></label>
																	<select class="form-control st_tour_starttime" name="starttime_tour"
																			id="starttime_tour">
																		<?php
																		if ( ! empty( $list_time['data'] ) && ! empty( $list_time['data'][0] ) ) {
																			$name = count( $list_time['data'] ) > 1 ? __( 'vacancies', 'traveler' ) : __( 'a vacancy', 'traveler' );
																			foreach ( $list_time['data'] as $key => $time ) {
																				if ( intval( $list_time['check'][ $key ] ) > 0 ) {
																					$num_vacancies = intval( $list_time['check'][ $key ] );
																				} else {
																					$num_vacancies = esc_html__( 'Unlimited', 'traveler' );
																				}
																				?>
																			<option value="<?php echo esc_attr( $time ); ?>"><?php echo esc_attr( $time ); ?> ( <?php echo esc_html( $num_vacancies ); ?> <?php echo esc_html( $name ); ?> )</option>
																				<?php
																			}
																		}
																		?>
																	</select>
																</div>
															</div>
															<!--End starttime-->

															<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/guest', '' ); ?>
															<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/package', '' ); ?>
															<?php echo st()->load_template( 'layouts/modern/tour/elements/search/single/extra', '' ); ?>
															<div class="submit-group">
																<button class="btn btn-large btn-full upper btn-book-ajax"
																		type="submit"
																		name="submit">
																	<?php echo esc_html__( 'Book Now', 'traveler' ) ?>
																	<i class="fa fa-spinner fa-spin hide"></i>
																</button>
																<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
															</div>
															<div class="message-wrapper mt30">

															</div>
														</form>
													<?php } else { ?>
														<div class="submit-group mb30">
															<a href="<?php echo esc_url( $tour_external_link ); ?>" class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
															<form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
																<input type="hidden" name="action" value="tours_add_to_cart">
																<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
																<input type="hidden" name="type_tour"
																		value="<?php echo get_post_meta( get_the_ID(), 'type_tour', true ) ?>">
																<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
															</form>
														</div>
													<?php } ?>
												</div>
												<?php

								}
								?>
									<?php
									$allow_partner = st()->get_option( 'setting_partner', 'off' );
									if ( $allow_partner == 'on' ) {
										?>

										<div class="owner-info widget-box">
											<h4 class="heading"><?php echo __( 'Organized by', 'traveler' ) ?></h4>
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
													<h4 class="media-heading"><a
																href="<?php echo st_get_author_posts_url( get_the_ID(), 70 ); ?>"
																class="author-link"><?php echo TravelHelper::get_username( $author_id ); ?></a>
													</h4>
													<p><?php echo sprintf( __( 'Member Since %s', 'traveler' ), date( 'Y', strtotime( $userdata->user_registered ) ) ) ?></p>
													<?php
													$arr_service = STUser_f::getListServicesAuthor( $userdata );
													$review_data = STUser_f::getReviewsDataAuthor( $arr_service, $userdata );
													if ( ! empty( $review_data ) ) {
														$avg_rating = STUser_f::getAVGRatingAuthor( $review_data );
														?>
														<div class="author-review-box">
															<div class="author-start-rating">
																<div class="stm-star-rating">
																	<div class="inner">
																		<div class="stm-star-rating-upper"
																			style="width:<?php echo (float) $avg_rating / 5 * 100; ?>%;"></div>
																		<div class="stm-star-rating-lower"></div>
																	</div>
																</div>
															</div>
															<p class="author-review-label">
																<?php printf( __( '%d Reviews', 'traveler' ), count( $review_data ) ); ?>
															</p>
														</div>
														<?php
													}
													?>
												</div>
											</div>
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
											<?php } ?>
										</div>
										<?php echo st()->load_template( 'layouts/modern/common/single/information-contact' ); ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					$search_tax_advance = st()->get_option( 'attribute_search_form_tour', 'st_tour_type' );
					$terms_posts        = wp_get_post_terms( get_the_ID(), $search_tax_advance );
					$arr_id_term_post   = [];
					foreach ( $terms_posts as $term_post ) {
						if ( ! empty( $term_post->term_id ) ) {
							$arr_id_term_post[] = $term_post->term_id;
						}
					}
					$args = [
						'posts_per_page' => 4,
						'post_type'      => 'st_tours',
						'post_author'    => get_post_field( 'post_author', get_the_ID() ),
						'post__not_in'   => [ $post_id ],
						'orderby'        => 'rand',
						'tax_query'      => [
							'taxonomy' => $search_tax_advance,
							'terms'    => $arr_id_term_post,
							'field'    => 'term_id',
							'operator' => 'IN',
						],
					];
					global $post;
					$old_post = $post;
					$query    = new WP_Query( $args );
					if ( $query->have_posts() ) :
						?>
							<div class="st-hr large"></div>
							<h2 class="heading text-center f28 mt50"><?php echo esc_html__( 'You might also like', 'traveler' ) ?></h2>
							<div class="st-list-tour-related row mt50">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();
								?>
										<div class="col-xs-12 col-sm-6 col-md-3">
											<div class="item has-matchHeight">
												<div class="featured">
													<a href="<?php the_permalink() ?>">
														<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), [ 800, 600 ] ) ?>"
															alt="<?php echo TravelHelper::get_alt_image() ?>"
															class="img-responsive">
													</a>
											<?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist-2' ); ?>
											<?php echo st_get_avatar_in_list_service( get_the_ID(), 70 ); ?>
												</div>
												<div class="body">
											<?php
												$address = get_post_meta( get_the_ID(), 'address', true );
											if ( $address ) {
												echo TravelHelper::getNewIcon( 'ico_maps_add_2', '#5E6D77', '16px', '16px' );
												echo '<span class="ml5 f14 address">' . esc_html( $address ) . '</span>';
											}
											?>
													<h3 class="title"><a href="<?php the_permalink() ?>"
																		class="st-link c-main"><?php the_title(); ?></a></h3>
													<?php
													$review_rate = STReview::get_avg_rate();
													echo st()->load_template( 'layouts/modern/common/star', '', [
														'star' => $review_rate,
														'style' => 'style-2',
													] );
													?>
													<p class="review-text"><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></p>
													<div class="st-flex space-between">
														<div class="left st-flex">
													<?php echo TravelHelper::getNewIcon( 'time-clock-circle-1', '#5E6D77', '16px', '16px' ); ?>
															<span class="duration"><?php echo get_post_meta( get_the_ID(), 'duration_day', true ); ?></span>
														</div>
														<div class="right st-flex">
													<?php echo TravelHelper::getNewIcon( 'thunder', '#FFAB53', '9px', '16px', false ); ?>
															<span class="price">
														<?php echo sprintf( esc_html__( 'from %s', 'traveler' ), STTour::get_price_html( get_the_ID() ) ); ?>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php
									endwhile;
							?>
							</div>
						<?php
						endif;
					wp_reset_postdata();
					$post = $old_post;
					?>
				</div>
			</div>
		</div>
	<?php
	endwhile;

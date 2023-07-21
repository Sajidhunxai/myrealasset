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
	$marker_icon                    = st()->get_option( 'st_cars_icon_map_marker', '' );

	$car_external      = get_post_meta( get_the_ID(), 'st_car_external_booking', true );
	$car_external_link = get_post_meta( get_the_ID(), 'st_car_external_booking_link', true );

	$pickup_date  = STInput::get( 'pick-up-date' );
	$dropoff_date = STInput::get( 'drop-off-date' );

	$pickup_date  = TravelHelper::convertDateFormat( $pickup_date );
	$dropoff_date = TravelHelper::convertDateFormat( $dropoff_date );

	$pick_up_time  = STInput::get( 'pick-up-time', '12:00 PM' );
	$drop_off_time = STInput::get( 'drop-off-time', '12:00 PM' );

	$info_price   = STCars::get_info_price( get_the_ID(), strtotime( $pickup_date ), strtotime( $dropoff_date ) );
	$cars_price   = $info_price['price'];
	$count_sale   = $info_price['discount'];
	$price_origin = $info_price['price_origin'];
	$list_price   = $info_price['list_price'];

	$booking_type = st_get_booking_option_type();
	?>
	<div id="st-content-wrapper" class="st-single-car style-2">
		<?php st_breadcrumbs_new() ?>
		<div class="hotel-target-book-mobile">
			<div class="price-wrapper">
				<?php echo wp_kses( sprintf( __( 'from <span class="price">%1$s</span><span class="unit">/%2$s</span>', 'traveler' ), TravelHelper::format_money( $cars_price ), strtolower( STCars::get_price_unit( 'label' ) ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
			</div>
			<?php
			if ( $car_external == 'off' || empty( $car_external ) ) {
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
				<a href="<?php echo esc_url( $car_external_link ); ?>"
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
									<div class="item has-matchHeight">
										<div class="icon">
											<?php
											$fee_cancellation = get_post_meta( get_the_ID(), 'fee_cancellation', true );
											if ( $fee_cancellation == 'on' ) {
												echo TravelHelper::getNewIcon( 'check-1', '#5191FA', '16px', '16px' );
											} else {
												echo TravelHelper::getNewIcon( 'remove', '#FA5636', '18px', '18px' );
											}
											?>
										</div>
										<div class="info">
											<div class="name"><?php echo __( 'Free Cancellation', 'traveler' ); ?></div>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-lg-3">
									<div class="item has-matchHeight">
										<div class="icon">
											<?php
											$pay_at_pick_up = get_post_meta( get_the_ID(), 'pay_at_pick_up', true );
											if ( $pay_at_pick_up == 'on' ) {
												echo TravelHelper::getNewIcon( 'check-1', '#5191FA', '16px', '16px' );
											} else {
												echo TravelHelper::getNewIcon( 'remove', '#FA5636', '18px', '18px' );
											}
											?>
										</div>
										<div class="info">
											<div class="name"><?php echo __( 'Pay at Pickup', 'traveler' ); ?></div>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-lg-3">
									<div class="item has-matchHeight">
										<div class="icon">
											<?php
											$unlimited_mileage = get_post_meta( get_the_ID(), 'unlimited_mileage', true );
											if ( $unlimited_mileage == 'on' ) {
												echo TravelHelper::getNewIcon( 'check-1', '#5191FA', '16px', '16px' );
											} else {
												echo TravelHelper::getNewIcon( 'remove', '#FA5636', '18px', '18px' );
											}
											?>
										</div>
										<div class="info">
											<div class="name"><?php echo __( 'Unlimited Mileage', 'traveler' ); ?></div>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-lg-3">
									<div class="item has-matchHeight">
										<div class="icon">
											<?php
											$shuttle_to_car = get_post_meta( get_the_ID(), 'shuttle_to_car', true );
											if ( $shuttle_to_car == 'on' ) {
												echo TravelHelper::getNewIcon( 'check-1', '#5191FA', '16px', '16px' );
											} else {
												echo TravelHelper::getNewIcon( 'remove', '#FA5636', '18px', '18px' );
											}
											?>
										</div>
										<div class="info">
											<div class="name"><?php echo __( 'Shuttle to Car', 'traveler' ); ?></div>
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
										<img src="<?php echo wp_get_attachment_image_url( $value, [ 900, 600 ] ) ?>" alt="<?php echo get_the_title(); ?>">
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
								<div class="st-description"
									data-toggle-section="st-description"
								>
									<?php the_content(); ?>
								</div>
							</div>
						<?php } ?>
						<!--End Tour Overview-->
						<div class="st-hr large"></div>
						<?php
						$all_attribute = TravelHelper::st_get_attribute_advance( 'st_cars' );
						foreach ( $all_attribute as $key_attr => $attr ) {
							if ( ! empty( $attr['value'] ) ) {
								$get_label_tax = get_taxonomy( $attr['value'] );
								$facilities    = wp_get_post_terms( get_the_ID(), $attr['value'] );
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

													?>
														<div class="col-xs-6 col-sm-4">
															<div class="item has-matchHeight">
															<?php
																echo esc_html( $term->name );
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
						<!--Tour Map-->
						<div class="st-map-wrapper">
							<?php
							if ( ! $zoom ) {
								$zoom = 13;
							}
							?>
							<div class="st-flex space-between">
								<h2 class="st-heading-section mg0"><?php echo __( 'Car\'s Location', 'traveler' ) ?></h2>
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
							$default = apply_filters('st_car_property_near_by_params', [
								'number'      => '12',
								'range'       => '50',
								'show_circle' => 'no',
							]);
							extract( $default );
							$car             = new STCars();
							$data            = $car->get_near_by( get_the_ID(), $range, $number );
							$location_center = '[' . esc_attr( $lat ) . ',' . esc_attr( $lng ) . ']';
							$map_lat_center  = $lat;
							$map_lng_center  = $lng;

							$data_map = [];
							$stt      = 1;
							global $post;
							if ( st()->get_option( 'st_show_car_nearby' ) == 'on' ) {
								if ( ! empty( $data ) ) {
									foreach ( $data as $post ) :
										setup_postdata( $post );
										$map_lat = get_post_meta( get_the_ID(), 'map_lat', true );
										$map_lng = get_post_meta( get_the_ID(), 'map_lng', true );
										if ( ! empty( $map_lat ) and ! empty( $map_lng ) and is_numeric( $map_lat ) and is_numeric( $map_lng ) ) {
											$post_type                        = get_post_type();
											$data_map[ $stt ]['id']           = get_the_ID();
											$data_map[ $stt ]['name']         = get_the_title();
											$data_map[ $stt ]['post_type']    = $post_type;
											$data_map[ $stt ]['lat']          = $map_lat;
											$data_map[ $stt ]['lng']          = $map_lng;
											$data_map[ $stt ]['icon_mk']      = st()->get_option( 'st_cars_icon_map_marker', 'http://maps.google.com/mapfiles/marker_black.png' );
											$data_map[ $stt ]['content_html'] = preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/car/elements/content/map-popup' ) );

											++$stt;
										}
									endforeach;
									wp_reset_postdata();
								}
							}
							$properties = $car->properties_near_by( get_the_ID(), $lat, $lng, $range );
							if ( ! empty( $properties ) ) {
								foreach ( $properties as $key => $val ) {
									$data_map[] = [
										'id'           => get_the_ID(),
										'name'         => $val['name'],
										'post_type'    => 'st_cars',
										'lat'          => (float) $val['lat'],
										'lng'          => (float) $val['lng'],
										'icon_mk'      => ( empty( $val['icon'] ) ) ? 'http://maps.google.com/mapfiles/marker_black.png' : $val['icon'],
										'content_html' => preg_replace( '/^\s+|\n|\r|\s+$/m', '', st()->load_template( 'layouts/modern/hotel/elements/property', false, [ 'data' => $val ] ) ),

									];
								}
							}
							$map_icon = st()->get_option( 'st_cars_icon_map_marker', '' );

							if ( empty( $map_icon ) ) {
								$map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
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
								'post_type'    => 'st_cars',
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
						<!--End Tour Map-->

						<!--Review Option-->
						<?php if ( comments_open() and st()->get_option( 'car_review' ) == 'on' ) { ?>
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
						<div class="widgets">
							<div class="fixed-on-mobile" id="booking-request" data-screen="992px">
								<div class="close-icon hide">
									<?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
								</div>

								<?php
								if ( $booking_type == 'instant_enquire' ) {
									?>
									<div class="form-book-wrapper relative">
										<!-- <?php /*if (!empty($info_price['discount']) and $info_price['discount'] > 0) { */ ?>
										<div class="tour-sale-box">
											<?php /*echo STFeatured::get_sale($price_origin); */ ?>
										</div>
									--><?php /*} */ ?>
										<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
										<div class="form-head">
											<?php echo wp_kses( sprintf( __( '<span class="price">%1$s</span><span class="unit">/%2$s</span>', 'traveler' ), TravelHelper::format_money( $cars_price ), strtolower( STCars::get_price_unit( 'label' ) ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
										</div>
										<nav>
											<ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
												<li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
												<li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
											</ul>
										</nav>
										<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
											<div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
												<?php if ( empty( $car_external ) || $car_external == 'off' ) { ?>
													<form id="form-booking-inpage" method="post" action="#booking-request" class="car-booking-form">
														<input type="hidden" name="action" value="cars_add_to_cart">
														<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
														<input type="hidden" name="car_type" value="<?php echo $unit = st()->get_option( 'cars_price_unit', 'day' ); ?>">
														<?php echo st()->load_template( 'layouts/modern/car/elements/search/location-single', '' ); ?>
														<?php echo st()->load_template( 'layouts/modern/car/elements/search/date', '' ); ?>
														<?php echo st()->load_template( 'layouts/modern/car/elements/search/extra', '' ); ?>
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
															<!-- <?php echo STTemplate::message() ?> -->
														</div>
													</form>
												<?php } else { ?>
													<div class="submit-group mb30">
														<a href="<?php echo esc_url( $car_external_link ); ?>"
															class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
														<form id="form-booking-inpage" method="post" action="#booking-request" class="activity-booking-form">
															<input type="hidden" name="action" value="cars_add_to_cart">
															<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
															<?php
															$current_calendar        = TravelHelper::get_current_available_calendar( get_the_ID() );
															$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );

															$start = STInput::request( 'check_in', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$end   = STInput::request( 'check_out', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$date  = STInput::request( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) );
															?>

															<input type="hidden" class="check-in-input"
																	value="<?php echo esc_attr( $start ) ?>" name="check_in">
															<input type="hidden" class="check-out-input"
																	value="<?php echo esc_attr( $end ) ?>" name="check_out">
															<input type="hidden" class="check-in-out-input"
																	value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
																	data-action="st_get_availability_activity_frontend"
																	data-tour-id="<?php the_ID(); ?>" data-posttype="st_cars">
															<?php
															/*Starttime*/
															$starttime_value = STInput::request( 'starttime_tour', '' );
															?>

															<div class="form-group form-more-extra st-form-starttime" <?php echo ( $starttime_value != '' ) ? '' : 'style="display: none"' ?>>
																<input type="hidden" data-starttime="<?php echo esc_attr( $starttime_value ); ?>"
																		data-checkin="<?php echo esc_attr( $start ); ?>" data-checkout="<?php echo esc_attr( $end ); ?>"
																		data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" data-posttype="st_cars"/>
															</div>
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
											<!-- <?php /*if (!empty($info_price['discount']) and $info_price['discount'] > 0) { */ ?>
										<div class="tour-sale-box">
											<?php /*echo STFeatured::get_sale($price_origin); */ ?>
										</div>
										<?php /*} */ ?> -->
											<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
											<div class="form-head">
												<?php echo wp_kses( sprintf( __( '<span class="price">%1$s</span><span class="unit">/%2$s</span>', 'traveler' ), TravelHelper::format_money( $cars_price ), strtolower( STCars::get_price_unit( 'label' ) ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
											</div>

											<h4 class="title-enquiry-form"><?php echo esc_html__( 'Inquiry', 'traveler' ); ?></h4>
											<?php echo st()->load_template( 'email/email_single_service' ); ?>
											<form id="form-booking-inpage" method="post" action="#booking-request" class="activity-booking-form">
												<input type="hidden" name="action" value="activity_add_to_cart">
												<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
												<?php
												$current_calendar        = TravelHelper::get_current_available_calendar( get_the_ID() );
												$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );

												$start = STInput::request( 'check_in', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
												$end   = STInput::request( 'check_out', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
												$date  = STInput::request( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) );
												?>

												<input type="hidden" class="check-in-input"
														value="<?php echo esc_attr( $start ) ?>" name="check_in">
												<input type="hidden" class="check-out-input"
														value="<?php echo esc_attr( $end ) ?>" name="check_out">
												<input type="hidden" class="check-in-out-input"
														value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
														data-action="st_get_availability_activity_frontend"
														data-tour-id="<?php the_ID(); ?>" data-posttype="st_cars">
												<?php
												/*Starttime*/
												$starttime_value = STInput::request( 'starttime_tour', '' );
												?>

												<div class="form-group form-more-extra st-form-starttime" <?php echo ( $starttime_value != '' ) ? '' : 'style="display: none"' ?>>
													<input type="hidden" data-starttime="<?php echo esc_attr( $starttime_value ); ?>"
															data-checkin="<?php echo esc_attr( $start ); ?>" data-checkout="<?php echo esc_attr( $end ); ?>"
															data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" data-posttype="st_cars"/>
												</div>
												<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
											</form>
										</div>
										<?php
								} else {
									?>
										<div class="form-book-wrapper relative">
										<?php if ( ! empty( $info_price['discount'] ) and $info_price['discount'] > 0 and $info_price['price'] > 0 ) { ?>
												<div class="tour-sale-box">
													<?php echo STFeatured::get_sale( $info_price['discount'] ); ?>
												</div>
											<?php } ?>
										<?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
											<div class="form-head">
											<?php echo wp_kses( sprintf( __( '<span class="price">%1$s</span><span class="unit">/%2$s</span>', 'traveler' ), TravelHelper::format_money( $cars_price ), strtolower( STCars::get_price_unit( 'label' ) ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
											</div>
										<?php if ( empty( $car_external ) || $car_external == 'off' ) { ?>
												<form id="form-booking-inpage" method="post" action="#booking-request" class="car-booking-form">
													<input type="hidden" name="action" value="cars_add_to_cart">
													<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
													<input type="hidden" name="car_type" value="<?php echo $unit = st()->get_option( 'cars_price_unit', 'day' ); ?>">
													<?php echo st()->load_template( 'layouts/modern/car/elements/search/location-single', '' ); ?>
													<?php echo st()->load_template( 'layouts/modern/car/elements/search/date', '' ); ?>
													<?php echo st()->load_template( 'layouts/modern/car/elements/search/extra', '' ); ?>
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
														<!-- <?php echo STTemplate::message() ?> -->
													</div>
												</form>
											<?php } else { ?>
												<div class="submit-group mb30">
													<a href="<?php echo esc_url( $car_external_link ); ?>"
														class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
														<form id="form-booking-inpage" method="post" action="#booking-request" class="activity-booking-form">
															<input type="hidden" name="action" value="activity_add_to_cart">
															<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
															<?php
															$current_calendar        = TravelHelper::get_current_available_calendar( get_the_ID() );
															$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );

															$start = STInput::request( 'check_in', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$end   = STInput::request( 'check_out', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
															$date  = STInput::request( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) );
															?>

															<input type="hidden" class="check-in-input"
																	value="<?php echo esc_attr( $start ) ?>" name="check_in">
															<input type="hidden" class="check-out-input"
																	value="<?php echo esc_attr( $end ) ?>" name="check_out">
															<input type="hidden" class="check-in-out-input"
																	value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
																	data-action="st_get_availability_activity_frontend"
																	data-tour-id="<?php the_ID(); ?>" data-posttype="st_cars">
															<?php
															/*Starttime*/
															$starttime_value = STInput::request( 'starttime_tour', '' );
															?>

															<div class="form-group form-more-extra st-form-starttime" <?php echo ( $starttime_value != '' ) ? '' : 'style="display: none"' ?>>
																<input type="hidden" data-starttime="<?php echo esc_attr( $starttime_value ); ?>"
																		data-checkin="<?php echo esc_attr( $start ); ?>" data-checkout="<?php echo esc_attr( $end ); ?>"
																		data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" data-posttype="st_cars"/>
															</div>
															<input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID(); ?>" name="st_send_message" value="<?php echo __( 'Send message', 'traveler' ); ?>">
														</form>
												</div>
											<?php } ?>
										</div>
										<?php

								}
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
								</div>
								<?php echo st()->load_template( 'layouts/modern/common/single/information-contact' ); ?>
							</div>
						</div>
					</div>
				</div>
				<?php
				$args = [
					'posts_per_page' => 4,
					'post_type'      => 'st_car',
					'post_author'    => get_post_field( 'post_author', get_the_ID() ),
					'post__not_in'   => [ get_the_ID() ],
					'orderby'        => 'rand',
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
										<?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist' ); ?>
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
											'star'  => $review_rate,
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

<?php
wp_enqueue_script( 'filter-rental' );
while ( have_posts() ) :
	the_post();
	$room_id   = get_the_ID();
	$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'full' );

	$current_calendar        = TravelHelper::get_current_available_calendar( get_the_ID() );
	$current_calendar_reverb = date( 'm/d/Y', strtotime( $current_calendar ) );


	$start           = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime( $current_calendar ) ) );
	$end             = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( '+ 1 day', strtotime( $current_calendar ) ) ) );
	$date            = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime( $current_calendar ) ) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime( $current_calendar ) ) ) );
	$room_num_search = (int) STInput::get( 'rental_number', 1 );
	if ( $room_num_search <= 0 ) {
		$room_num_search = 1;
	}
	$start         = TravelHelper::convertDateFormat( $start );
	$end           = TravelHelper::convertDateFormat( $end );
	$orgin_price   = STPrice::getRentalPriceOnlyCustomPrice( get_the_ID(), strtotime( $start ), strtotime( $end ) );
	$review_rate   = STReview::get_avg_rate();
	$count_review  = STReview::count_review( $room_id );
	$gallery       = get_post_meta( get_the_ID(), 'gallery', true );
	$gallery_array = explode( ',', $gallery );
	$min_price = get_post_meta( get_the_ID(), 'min_price',true);
	$number_day   = STDate::dateDiff( $start, $end );
	$min_price = $min_price*$number_day;
	$booking_period = (int) get_post_meta( get_the_ID(), 'rentals_booking_period', true );
	$location       = get_post_meta( get_the_ID(), 'multi_location', true );
	if ( ! empty( $location ) ) {
		$location = explode( ',', $location );
		if ( isset( $location[0] ) ) {
			$location = str_replace( '_', '', $location[0] );
		} else {
			$location = false;
		}
	}
	$address     = get_post_meta( get_the_ID(), 'address', true );
	$marker_icon = st()->get_option( 'st_rental_icon_map_marker', '' );

	$room_external      = get_post_meta( get_the_ID(), 'st_rental_external_booking', true );
	$room_external_link = get_post_meta( get_the_ID(), 'st_rental_external_booking_link', true );

	$booking_type = st_get_booking_option_type();
	
	?>
	<div id="st-content-wrapper" class="st-style-elementor st-style-4">
		<?php echo stt_elementorv2()->loadView( 'components/banner' ); ?>
		<div class="container-fluid">
			<?php echo stt_elementorv2()->loadView( 'services/common/single/gallery-2', [ 'style' => 'slider' ] ) ?>
		</div>
		<div class="container">
			<?php
			$menu_transparent = st()->get_option( 'menu_transparent', '' );
			$class            = $menu_transparent !== 'on' ? '' : 'pt-5';
			?>
			<div class="st-hotel-room-content <?= esc_html( $class ) ?>">
				<div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
					<div class="price-wrapper">
						<div id="mobile-price">
							<?php echo wp_kses( sprintf( __( 'From:<span class="price">%s</span>', 'traveler' ), TravelHelper::format_money( $min_price ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
						</div>

						<div class="st-review-booking-form">
							<div class="st-review-box-top d-flex align-items-center">
								<i class="stt-icon-star1"></i>
								<?php
								$count_review = get_comment_count( $room_id )['approved'];
								$avg          = STReview::get_avg_rate();
								?>
								<div class="review-score">
									<?php echo esc_attr( $avg ); ?>
								</div>
								<div class="review-score-base text-center">
									<span>(<?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?>)</span>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( $room_external == 'off' || empty( $room_external ) ) {
						?>
							<a href=""
								class="btn-v2 btn-primary btn-mpopup btn-green">
							<?php
							if ( $booking_type == 'enquire' ) {
								echo esc_html__( 'Inquiry', 'traveler' );
							} else {
								echo esc_html__( 'Check', 'traveler' );
							}
							?>
							</a>
							<?php
					} else {
						?>
							<a href="<?php echo esc_url( $room_external_link ); ?>"
								class="btn-v2 btn btn-green"><?php echo esc_html__( 'Check', 'traveler' ) ?></a>
							<?php
					}
					?>
				</div>



				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-8">
						<?php
						echo stt_elementorv2()->loadView('services/rental/single/items/top-info', [
							'address'      => $address,
							'review_rate'  => $review_rate,
							'count_review' => $count_review,
						])
						?>
						<div class="room-featured-items">
							<div class="item">
								<span class="stt-icon stt-icon-adult"></span>
								<?php
								echo __( 'Adult: ', 'traveler' );
								echo (int) get_post_meta( get_the_ID(), 'rental_max_adult', true );
								?>
							</div>
							<div class="item">
								<span class="stt-icon stt-icon-baby"></span>
								<?php
								echo __( 'Children: ', 'traveler' );
								echo (int) get_post_meta( get_the_ID(), 'rental_max_children', true );
								?>
							</div>
							<div class="item">
								<span class="stt-icon stt-icon-bed"></span>
								<?php echo __( 'Beds: ', 'traveler' ); echo (int) get_post_meta( get_the_ID(), 'rental_bed', true ) ?>
							</div>
							<div class="item">
								<span class="stt-icon stt-icon-area"></span>
								<?php
								echo __( 'Area: ', 'traveler' );
								echo (int) get_post_meta( get_the_ID(), 'rental_size', true );
								?>
								<?php echo __( 'm<sup>2</sup>', 'traveler' ); ?>
							</div>
						</div>

						<?php echo stt_elementorv2()->loadView( 'services/common/single/description', [ 'title' => esc_html__( 'About this room', 'traveler' ) ] ) ?>

						<?php echo stt_elementorv2()->loadView( 'services/common/single/attributes', [ 'post_type' => 'st_rental' ] ) ?>
						<?php
						echo stt_elementorv2()->loadView( 'services/rental/single/items/availability', [
							'booking_period' => $booking_period,
							'room_id'        => $room_id,
						] );
						?>

						<?php echo stt_elementorv2()->loadView( 'services/rental/single/items/discount' ); ?>
						<?php echo stt_elementorv2()->loadView( 'services/rental/single/items/location', [ 'post_id' => $room_id ] ) ?>
						<?php echo stt_elementorv2()->loadView( 'services/rental/single/items/review', [ 'post_id' => $room_id ] ); ?>
						<div class="stoped-scroll-section"></div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-4">
						<div class="widgets">
							<div class="fixed-on-mobile st-fixed-form-booking" data-screen="992px">
								<?php
								echo stt_elementorv2()->loadView('services/rental/single/items/form-book', [
									'price'              => $min_price,
									'room_id'            => $room_id,
									'room_external'      => $room_external,
									'room_external_link' => $room_external_link,
									'booking_period'     => $booking_period,
									'number_day'         => $number_day,
									'booking_type'       => $booking_type,
									'review_rate'        => $review_rate,
									'count_review'       => $count_review,
									'orgin_price'        => $orgin_price,
								]);
								?>
								<?php echo st()->load_template( 'layouts/elementor/hotel/single/item/owner-info', '', [ 'size_avatar_custom' => 90 ] ); ?>
								<?php echo st()->load_template( 'layouts/modern/common/single/information-contact' ); ?>
							</div>
						</div>
					</div>
				</div>

				<?php
				echo stt_elementorv2()->loadView('services/rental/single/items/relate', [
					'post_id' => get_the_ID(),
				])
				?>
			</div>
		</div>
	</div>
	<?php
endwhile;

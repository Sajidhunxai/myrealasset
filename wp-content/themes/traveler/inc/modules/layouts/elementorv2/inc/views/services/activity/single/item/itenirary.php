<?php $tour_program_style = get_post_meta( get_the_ID(), 'activity_program_style', true );

if ( empty( $tour_program_style ) ) {
	$tour_program_style = 'style1';
}

if ( $tour_program_style == 'style1' or $tour_program_style == 'style3' ) {
	$tour_programs = get_post_meta( get_the_ID(), 'activity_program', true );
} else {
	$tour_programs = get_post_meta( get_the_ID(), 'activity_program_bgr', true );
}

if ( ! empty( $tour_programs ) ) {
	?>
	<div class="st-hr"></div>
	<h2 class="st-heading-section" id="st-itinerary">
		<?php echo __( 'Itinerary', 'traveler' ); ?>
	</h2>
	<div class="st-program-list <?php echo esc_attr( $tour_program_style ); ?>">
		<?php if ( $tour_program_style == 'style1' ) : ?>
			<?php
				$i = 0;
			foreach ( $tour_programs as $k => $v ) {
				$section_id = trim( st_convert_characers_to_slug( esc_html( $v['title'] ) ) );
				?>
					<div class="accordion faq st-program style1" id="accordion_<?php echo esc_attr( $section_id ); ?>">
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading_<?php echo esc_attr( $section_id ); ?>">
								<button class="accordion-button<?php echo ( $i == 0 ) ? '' : ' collapsed' ?> "
									type="button"
									data-bs-toggle="collapse"
									data-bs-target="#st-<?php echo esc_attr( $section_id ) ?>"
									aria-expanded="true"
									aria-controls="<?php echo esc_attr( $section_id ) ?>"
								>
								<?php echo balanceTags( $v['title'] ); ?>
								</button>
							</h2>
							<div id="st-<?php echo esc_attr( $section_id ) ?>" class="accordion-collapse collapse <?php echo ( $i == 0 ) ? 'show' : '' ?>"
								aria-labelledby="heading_<?php echo esc_attr( $section_id ); ?>"
								data-bs-parent="#accordion_<?php echo esc_attr( $section_id ); ?>"
							>
								<div class="accordion-body">
								<?php
								if ( isset( $v['image'] ) and ! empty( $v['image'] ) ) {
									$img = $v['image'];
									?>
											<div class="row">
												<div class="col-lg-4">
													<img src="<?php echo esc_url( $v['image'] ) ?>" alt="<?php echo esc_attr( $v['title'] ) ?>" class="img-fluid"/>
												</div>
												<div class="col-lg-8">
													<p class="content-itinerary">
											<?php echo balanceTags( $v['desc'] ); ?>
													</p>
												</div>
											</div>
										<?php
								} else {
									echo '<p class="content-itinerary">';
									echo balanceTags( $v['desc'] );
									echo '</p>';
								}
								?>

								</div>
							</div>
						</div>
					</div>
					<?php
					++$i;
			}
			?>
					<?php elseif ( $tour_program_style == 'style2' ) : ?>
			<div class="owl-carousel-wrapper">
				<div class="owl-carousel owl-tour-program">
						<?php
						foreach ( $tour_programs as $k => $v ) {
							$time = ! empty( $v['time'] ) ? $v['time'] : '';
							?>
							<div class="item" style="background-image: url('<?php echo esc_url( $v['image'] ) ?>')">
								<div class="header">
								<?php
								if ( $time ) {
									?>
											<h5><?php echo esc_html( $v['time'] ); ?></h5>
										<?php
								}
								?>

									<h2><?php echo esc_html( $v['title'] ); ?></h2>
								</div>
								<div class="body ovscroll">
									<?php
									if ( $time ) {
										?>
											<h5><?php echo esc_html( $v['time'] ); ?></h5>
										<?php
									}
									?>
									<h2><?php echo esc_html( $v['title'] ); ?></h2>
									<div class="desc">
									<?php echo balanceTags( nl2br( $v['desc'] ) ); ?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
				</div>
				<a href="#"
				class="prev"><?php echo TravelHelper::getNewIcon( 'arrow-left', '#FFFFFF', '24px', '24px', false ) ?></a>
				<a href="#"
				class="next"><?php echo TravelHelper::getNewIcon( 'arrow-right', '#FFFFFF', '24px', '24px', false ) ?></a>
			</div>
						<?php
		elseif ( $tour_program_style == 'style3' ) :
			foreach ( $tour_programs as $k => $v ) {
				?>
				<div class="item active">
					<?php
					if ( ! empty( $v['image'] ) ) {
						echo '<div class="icon">';
						echo '<img src="' . esc_url( $v['image'] ) . '" alt="' . __( 'Itenirary', 'traveler' ) . '" />';
						echo '</div>';
					}
					?>
					<h5><?php echo balanceTags( $v['title'] ); ?></h5>
					<div class="body">
						<?php echo balanceTags( nl2br( $v['desc'] ) ); ?>
					</div>
				</div>
				<?php
			}
		endif;
		?>
	</div>
	<?php
}
?>

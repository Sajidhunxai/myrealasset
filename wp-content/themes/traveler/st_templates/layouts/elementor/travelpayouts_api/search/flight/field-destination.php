<?php
wp_enqueue_style( 'st-select.css' );
wp_enqueue_script( 'st-select.js' );

$locale_default = st()->get_option( 'tp_locale_default', 'en' );
?>
<div class="destination-search">
	<div class="form-group d-flex align-items-center form-extra-field dropdown field-detination form-group-icon-left st_right" data-next="2">
		<i class="input-icon st-border-radius field-icon fa">
			<svg width="24px" height="24px" viewBox="0 0 17 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<defs></defs>
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
					<g id="Search_Result_1_Grid" transform="translate(-165.000000, -328.000000)" stroke="#A0A9B2">
						<g id="form_search_hotel_row" transform="translate(135.000000, 290.000000)">
							<g transform="translate(30.000000, 0.000000)">
								<g id="where" transform="translate(0.000000, 26.000000)">
									<g transform="translate(0.000000, 12.000000)">
										<g id="ico_maps_search_box">
											<path d="M15.75,8.25 C15.75,12.471 12.817,14.899 10.619,17.25 C9.303,18.658 8.25,23.25 8.25,23.25 C8.25,23.25 7.2,18.661 5.887,17.257 C3.687,14.907 0.75,12.475 0.75,8.25 C0.75,4.10786438 4.10786438,0.75 8.25,0.75 C12.3921356,0.75 15.75,4.10786438 15.75,8.25 Z"></path>
											<circle cx="8.25" cy="8.25" r="3"></circle>
										</g>
									</g>
								</g>
							</g>
						</g>
					</g>
				</g>
			</svg>
		</i>
		<div class="st-form-dropdown-icon" >
			<label><?php echo __( 'Destination', 'traveler' ); ?></label>
			<div class="render">
				<?php
				if ( empty( $location_name ) ) {
					$placeholder = __( 'Where are you going?', 'traveler' );
				} else {
					$placeholder = esc_html( $location_name );
				}
				?>
				<div class="st-select-wrapper tp-flight-wrapper" >
					<input required data-id="location_destination" type="text" data-locale="<?php echo esc_attr( $locale_default ); ?>" class="tp-flight-location st-location-name" autocomplete="off" data-name="destination_iata" value="" placeholder="<?php echo esc_html__( 'Enter your destination', 'traveler' ); ?>">
				</div>
			</div>
		</div>

	</div>
</div>

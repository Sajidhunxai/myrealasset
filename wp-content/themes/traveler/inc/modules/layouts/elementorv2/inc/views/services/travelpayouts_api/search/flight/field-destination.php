<?php
wp_enqueue_style( 'st-select.css' );
wp_enqueue_script( 'st-select.js' );

$locale_default = st()->get_option( 'tp_locale_default', 'en' );
?>
<div class="destination-search">
	<div class="form-group d-flex align-items-center form-extra-field dropdown field-detination form-group-icon-left st_right" data-next="2">
		<span class="stt-icon stt-icon-location1"></span>
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

<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
$adult_number   = STInput::get( 'adult_number', 1 );
$child_number   = STInput::get( 'child_number', 0 );
$use_whitelabel = st()->get_option( 'tp_redirect_option', 'off' );
if ( $use_whitelabel == 'on' ) {
	$button_class = 'btn-tp-search-flights';

}
?>

<div class="form-button d-inline-block d-lg-flex align-items-center justify-content-between form-passengers-class  form-extra-field  clearfix field-guest" data-next="5">
	<div class="form-group">

		<div class=" form-extra-field dropdown dropdown-toggle" id="dropdown-advance" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
			<?php
			if ( ! empty( $has_icon ) ) {
				echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
			}
			?>
			<div class="d-flex align-items-center">
				<i class="input-icon st-border-radius field-icon fa">
					<svg width="24px" height="24px" viewBox="0 0 24 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<defs></defs>
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
							<g id="Search_Result_1_Grid" transform="translate(-735.000000, -331.000000)" stroke="#A0A9B2">
								<g id="form_search_hotel_row" transform="translate(135.000000, 290.000000)">
									<g transform="translate(30.000000, 0.000000)">
										<g id="guest" transform="translate(570.000000, 26.000000)">
											<g id="ico_guest_search_box" transform="translate(0.000000, 15.000000)">
												<g id="Light">
													<path d="M0.5,17.5000001 C0.500000058,13.6340068 3.63400679,10.5000001 7.5,10.5000001 C11.3659932,10.5000001 14.4999999,13.6340068 14.5,17.5000001 L0.5,17.5000001 Z"></path>
													<path d="M13.994,3.558 C15.1539911,4.33669999 16.5198779,4.75172347 17.917,4.75 C18.8777931,4.7508055 19.8286029,4.55513062 20.711,4.175"></path>
													<path d="M13.26,2 C14.7525087,0.243845556 17.3729329,-0.0022836544 19.1663535,1.44523253 C20.9597741,2.89274871 21.2722437,5.50609244 19.8706501,7.3356268 C18.4690565,9.16516115 15.8644725,9.54377036 14,8.189 C13.8228021,8.05875218 13.655663,7.9153468 13.5,7.76"></path>
													<path d="M14.5,10.79 C16.6186472,10.1605491 18.9100973,10.5678907 20.6820104,11.8889503 C22.4539234,13.21001 23.4984514,15.2898253 23.5,17.5 L17,17.5"></path>
													<path d="M3.838,2.592 C5.87773146,4.7056567 9.0128387,5.33602311 11.711,4.175"></path>
													<circle cx="7.5" cy="4.75" r="4.25"></circle>
												</g>
											</g>
										</g>
									</g>
								</g>
							</g>
						</g>
					</svg>
				</i>
				<div class="st-form-dropdown-icon">
					<label><?php echo esc_html__( 'Passengers/Class', 'traveler' ); ?></label>
					<div class="tp_group_display render">
						<span class="display-passengers"><span class="quantity-passengers">1</span> <?php echo esc_html__( 'passenger(s)', 'traveler' ) ?></span>
						<span class="display-class" data-economy="<?php echo esc_html__( 'economy class', 'traveler' ); ?>" data-business="<?php echo esc_html__( 'business class', 'traveler' ); ?>"><?php echo esc_html__( 'economy class', 'traveler' ); ?></span>
						<span class="display-icon-dropdown"><i class="fa fa-chevron-down"></i></span>
					</div>
				</div>
			</div>
		</div>
		<ul class="dropdown-menu passengers-class" aria-labelledby="dropdown-advance">
			<li class="item">
				<label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
				<div class="select-wrapper">
					<div class="st-number-wrapper d-flex align-items-center justify-content-between">
						<input type="text" name="adults" value="<?php echo esc_attr( $adult_number ); ?>" class="twidget-num form-control  st-input-number" autocomplete="off" readonly data-min="1" data-max="100"/>
					</div>
				</div>
			</li>
			<li class="item">
				<label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
				<div class="select-wrapper">
					<div class="st-number-wrapper d-flex align-items-center justify-content-between">
						<input type="text" name="children" value="<?php echo esc_attr( $child_number ); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
					</div>
				</div>
			</li>
			<li class="item">
				<label><?php echo esc_html__( 'Infants', 'traveler' ) ?></label>
				<div class="select-wrapper">
					<div class="st-number-wrapper d-flex align-items-center justify-content-between">
						<input type="text" name="infants" value="<?php echo esc_attr( $child_number ); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
					</div>
				</div>
			</li>
			<span class="notice none">
				<?php echo esc_html__( 'Maxium 9 passengers', 'traveler' ); ?>
			</span>
			<span class="d-lg-none d-md-none d-sm-none btn-close-guest-form"><?php echo __( 'Close', 'traveler' ); ?></span>
			<hr>
			<?php wp_enqueue_script( 'icheck-frontent.js' ); ?>
			<script type="text/javascript">
			jQuery(function($){
				$('.i-radio, .i-check').iCheck({
					checkboxClass: 'i-check',
					radioClass: 'i-radio'
				});
			});

			</script>
			<div class="tp-checkbox-class">
				<label><input class="i-check checkbox-class" type="checkbox" value="1" /> <?php echo esc_html__( 'Business class', 'traveler' ); ?></label>
				<input type="hidden" name="trip_class" value="0">
				<span class="checkmark"></span>
			</div>
		</ul>
	</div>
	<button class="btn btn-primary btn-search btn-bookingdc-search-hotels <?php echo esc_attr( $button_class ); ?>" type="submit"><?php echo esc_html__( 'Search', 'traveler' ); ?></button>


</div>

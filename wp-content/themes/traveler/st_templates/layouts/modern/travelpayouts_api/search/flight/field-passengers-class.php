<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 2/6/2017
 * Version: 1.0
 */
$adult_number = STInput::get( 'adult_number', 1 );
$child_number = STInput::get( 'child_number', 0 );
?>

<div class="form-group form-passengers-class  form-extra-field dropdown clearfix field-guest" data-next="5">
	<?php
	if ( ! empty( $has_icon ) ) {
		echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
	}
	?>
	<div id="dropdown-advance" class="dropdown" data-toggle="dropdown">
		<label><?php echo esc_html__( 'Passengers/Class', 'traveler' ); ?></label>
		<div class="tp_group_display render">
			<span class="display-passengers"><span class="quantity-passengers">1</span> <?php echo esc_html__( 'passenger(s)', 'traveler' ) ?></span>
			<span class="display-class" data-economy="<?php echo esc_html__( 'economy class', 'traveler' ); ?>" data-business="<?php echo esc_html__( 'business class', 'traveler' ); ?>"><?php echo esc_html__( 'economy class', 'traveler' ); ?></span>
			<span class="display-icon-dropdown"><i class="fa fa-chevron-down"></i></span>
		</div>
	</div>
	<ul class="passengers-class dropdown-menu" aria-labelledby="dropdown-advance">
		<li class="item">
			<label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
			<div class="select-wrapper">
				<div class="st-number-wrapper">
					<input type="text" name="adults" value="<?php echo esc_attr( $adult_number ); ?>" class="twidget-num form-control  st-input-number" autocomplete="off" readonly data-min="1" data-max="100"/>
				</div>
			</div>
		</li>
		<li class="item">
			<label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
			<div class="select-wrapper">
				<div class="st-number-wrapper">
					<input type="text" name="children" value="<?php echo esc_attr( $child_number ); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
				</div>
			</div>
		</li>
		<li class="item">
			<label><?php echo esc_html__( 'Infants', 'traveler' ) ?></label>
			<div class="select-wrapper">
				<div class="st-number-wrapper">
					<input type="text" name="infants" value="<?php echo esc_attr( $child_number ); ?>" class="twidget-num form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="100"/>
				</div>
			</div>
		</li>
		<span class="notice none">
			<?php echo esc_html__( 'Maxium 9 passengers', 'traveler' ); ?>
		</span>
		<span class="hidden-lg hidden-md hidden-sm btn-close-guest-form"><?php echo __( 'Close', 'traveler' ); ?></span>
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

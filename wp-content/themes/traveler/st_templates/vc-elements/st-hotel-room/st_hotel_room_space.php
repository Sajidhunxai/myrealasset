<div class="room-facility">
	<h3 class="booking-item-title"><?php echo esc_attr($args['title']); ?></h3>
<?php 
	$adult_number = intval(get_post_meta(get_the_ID(), 'adult_number', true));
	$children_number = intval(get_post_meta(get_the_ID(), 'children_number', true));
	$bed_number = intval(get_post_meta(get_the_ID(), 'bed_number', true));
	$room_footage = intval(get_post_meta(get_the_ID(), 'room_footage', true));
?>
	<div class="row list-facility list-facility-space">
		<div class="col-xs-12"> 
			<div class="col-xs-12 col-sm-12">
				<div class="row">
					<div class="col-xs-12 col-sm-6 sub-item">
							<i rel="tooltip" data-placement="top" title="" data-original-title="<?php echo __('Adults Occupancy', 'traveler'); ?>" class="fa fa-male mr10"></i>
							<strong><?php echo esc_html($adult_number); ?></strong>
							<?php echo ($adult_number>1) ?  __("adults" , 'traveler') :  __("adult" , 'traveler'); ?>
					</div>
					<div class="col-xs-12 col-sm-6 sub-item">
                        <i rel="tooltip" data-placement="top" title="" data-original-title="<?php echo __('Beds', 'traveler'); ?>" class="im im-bed mr10"></i>
                        <strong><?php echo esc_html($bed_number); ?></strong>
							<?php echo ($bed_number>1) ?  __("beds" , 'traveler') : __("bed" , 'traveler') ;   ?>
					</div>
				</div><div class='row'>
					<div class="col-xs-12 col-sm-6 sub-item">
                        <i rel="tooltip" data-placement="top" title="" data-original-title="<?php echo __('Children', 'traveler'); ?>" class="im im-children mr10"></i>
							<strong><?php echo esc_html($children_number); ?></strong>
							<?php echo ($children_number>1) ?  __("children" , 'traveler')  : __("child" , 'traveler') ; ?>
					</span>
					</div>
					<div class="col-xs-12 col-sm-6 sub-item">
							<i rel="tooltip" data-placement="top" title="" data-original-title="<?php echo __('Room footage (square meters)', 'traveler'); ?>" class="im im-width mr10"></i>
							<strong><?php echo esc_html($room_footage); ?></strong>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
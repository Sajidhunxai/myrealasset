<?php global $post; ?>

<div class="row location-car-wrapper" data-post-id="<?php echo esc_attr($post->ID); ?>">

    <div class="overlay">

        <span class="spinner is-active"></span>

    </div>

    <div class="col-xs-12 col-sm-4 col-md-3">

    	<div class="form-group">

    		<label for=""><?php echo __('Select a pick up location', 'traveler'); ?></label><br/><br/>

    		<input style="" type="text" class="car_location_pick_up" name="car_location_pick_up" value="" data-placeholder="<?php echo __('Select a location', 'traveler'); ?>" data-name="">

    	</div>

    </div>

    <div class="col-xs-12 col-sm-4 col-md-3">

    	<div class="form-group">

    		<label for=""><?php echo __('Select a drop off location', 'traveler'); ?></label><br/><br/>

    		<input style="display: none;" type="text" class="car_location_drop_off" name="car_location_drop_off" value="" data-placeholder="<?php echo __('Select a location', 'traveler'); ?>" data-name="">

    	</div>

    </div>

    <div class="col-xs-12" style="margin-top: 15px;">

    	<a href="#" class="button button-primary button-large" id="add-location-from-to"><?php echo __('Add', 'traveler'); ?></a>

    	<p class="location-message">

    		

    	</p>

    </div>

    <div class="col-xs-12">

    	<label for=""><p style="margin: 15px 0;"><strong><?php echo __('Locations is selected', 'traveler'); ?>: </strong></p></label>

    	<div class="col-xs-12 col-sm-6">

    		<div id="location-car-selected">

    		

    		</div>

    	</div>

    </div>

    <div class="location-save-data">

        

    </div>

</div>    
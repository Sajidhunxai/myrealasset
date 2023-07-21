<?php $check_enable_map_google = st()->get_option('st_googlemap_enabled');
    $google_api_key = st()->get_option('google_api_key');
    if($check_enable_map_google === 'on'){ ?>
		<div id="contact-map-new" data-lat="<?php echo esc_attr($lat) ?>" data-lng="<?php echo esc_attr($lng) ?>" style="width: 100%; height: 500px;"></div>
	<?php
	} else{ ?>
		<div id="contact-mapbox-new" data-lat="<?php echo esc_attr($lat) ?>" data-lng="<?php echo esc_attr($lng) ?>" style="width: 100%; height: 500px;"></div>
	<?php }
	?>
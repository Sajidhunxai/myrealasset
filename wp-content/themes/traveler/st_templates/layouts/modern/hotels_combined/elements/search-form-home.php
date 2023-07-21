<div class="search-form hotel-search-form-home hotel-search-form">
	<?php
	    $aff_id = st()->get_option('hotelscb_aff_id', '');
	    $searchbox_id = st()->get_option('hotelscb_searchbox_id', '');
	    if(!empty($aff_id) && !empty($searchbox_id)){
	        echo '<script src="https://sbhc.portalhc.com/'. esc_attr($aff_id) .'/SearchBox/'. esc_attr($searchbox_id) .'" ></script>';
	    }else{
	        echo __('No data for search box.', 'traveler');
	    }
	?>
</div>

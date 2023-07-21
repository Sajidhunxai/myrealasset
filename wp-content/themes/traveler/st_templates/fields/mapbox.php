<?php 
$old_lat = '';
$old_lng = '';
$old_zoom = '';
$old_type = '';
$old_streetmode = '';
$st_token_mapbox = st()->get_option('st_token_mapbox'); 
if(!empty($post_id)){
    $old_lat = get_post_meta($post_id, 'map_lat', true);
    $old_lng = get_post_meta($post_id, 'map_lng', true);
    $old_zoom = get_post_meta($post_id, 'map_zoom', true);
    $old_type = get_post_meta($post_id, 'map_type', true);
    $old_streetmode = get_post_meta($post_id, 'enable_street_views_google_map', true);
}
//wp_enqueue_script('st-partner-gmapv3-init');



?>
<?php
    wp_enqueue_script('mapboxv5');
    wp_enqueue_script('mapboxv5-geocoder');
    wp_enqueue_style('mapbox-css-geocoder');
    wp_enqueue_style('mapbox-custom-css');
    wp_enqueue_script('init-mapbox-partner');
    wp_enqueue_style('mapbox-css');
?>
<style>
    .st_mapbox_custom-form .geocoder {
    position:absolute;
    z-index:1;
    width:50%;
    left:50%;
    margin-left:-25%;
    top:20px;
    }
    .st_mapbox_custom-form .mapboxgl-ctrl-geocoder { min-width:100%; }
    .st-partner-create-form #st_mapbox_custom .mapboxgl-canvas{
        width: 100% !important;
        height: auto !important;
    }
</style>
<div class="st_mapbox_custom-form form-group st-field-<?php echo esc_attr($data['type']); ?>">
     <input type="hidden" name="st_token_mapbox" class="st_token_mapbox" value="<?php echo esc_attr($st_token_mapbox);?>" >
    <div class="st_mapbox_custom" id="st_mapbox_custom" style="width: 100%;height: 450px"></div>

    <div id="geocoder" class="geocoder"></div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="st-map-lat"><?php echo __('Latitude', 'traveler'); ?></label>
                <input id="st-map-lat" type="text" name="gmap[lat]" class="form-control" value="<?php echo esc_html($old_lat); ?>" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="st-map-lng"><?php echo __('Longitude', 'traveler'); ?></label>
                <input id="st-map-lng" type="text" name="gmap[lng]" class="form-control" value="<?php echo esc_html($old_lng); ?>" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="st-map-zoom"><?php echo __('Zoom Level', 'traveler'); ?></label>
                <input id="st-map-zoom" type="text" name="gmap[zoom]" class="form-control" value="13" value="<?php echo esc_html($old_zoom); ?>" />
            </div>
        </div>
        <div class="col-lg-4" style="display: none;">
            <div class="form-group">
                <label for="st-map-style"><?php echo __('Map Style', 'traveler'); ?></label>
                <input id="st-map-style" type="text" name="gmap[type]" class="form-control" value="<?php echo esc_html($old_type); ?>" />
            </div>
        </div>
        <div class="col-lg-4" style="display: none;">
            <div class="form-group">
                <label for="st-map-streetview"><?php echo __('Streetview mode', 'traveler'); ?></label>
                <select id="st-map-streetview" type="text" name="enable_street_views_google_map" class="form-control">
                    <option value="on" <?php echo ($old_streetmode == 'on') ? 'selected' : ''; ?>><?php echo __('On', 'traveler'); ?></option>
                    <option value="off" <?php echo ($old_streetmode == 'off') ? 'selected' : ''; ?>><?php echo __('Off', 'traveler'); ?></option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="mapbox_single">
    <div id="mapbox_wrapper" class="st_list_map">

        <div class="content_map" style="height: <?php echo esc_html( $height ) ?>px !important">
            <div id="list_mapbox"  style="height: <?php echo esc_html( $height ) ?>px; width: 100%"></div>
        </div>
        <div class="st-gmap-loading-bg"></div>
        <div id="st-gmap-loading"><?php _e( 'Loading Maps' , 'traveler' ); ?>
            <div class="spinner spinner_map ">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
    <div class="data_content hidden">
        <?php
        $data_map[0]['content_html']  = str_ireplace("'",'"',$data_map[0]['content_html']);
        echo balanceTags($data_map[0]['content_html']) ?>
    </div>
    <?php
    $data_map       = json_encode( $data_map , JSON_FORCE_OBJECT );
    $data_style_map = '[{featureType: "road.highway",elementType: "geometry",stylers: [{ hue: "#ff0022" },{ saturation: 60 },{ lightness: -20 }]}]';
    $street_views = get_post_meta(get_the_ID(),"enable_street_views_google_map",true);

    $data_style_map = '[{"stylers": [{"hue": "#2c3e50"},{"saturation": 250}] },{"featureType": "road","elementType": "geometry","stylers": [{"lightness": 50},{"visibility": "simplified"}]},{"featureType": "road","elementType": "labels","stylers": [{ "visibility": "off"}]}]';
    ?>
    <div class="hidden st_detailed_mapbox"
    data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
    data-map_height = '<?php echo str_ireplace(array("'"),'\"',esc_html($height)); ?>' 
    data-style_map = '<?php echo str_ireplace(array("'"),'\"',balanceTags($data_style_map))?>'
    data-type_map = '<?php echo str_ireplace(array("'"),'\"',get_post_meta(get_the_ID(),'map_type',true))?>'
    data-street_views = '<?php echo str_ireplace(array("'"),'\"',esc_html($street_views)) ?>'

    data-height = "<?php echo esc_attr($height) ;?>"
    data-location_center = "<?php echo esc_attr($location_center) ;?>"
    data-zoom = "<?php echo esc_attr($zoom); ?>"
    data-range = "<?php echo esc_attr($range) ;?>">&nbsp;</div> 
</div>
    
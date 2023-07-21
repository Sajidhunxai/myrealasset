 <?php
$lat = get_post_meta($post_id, 'map_lat', true);
$lng = get_post_meta($post_id, 'map_lng', true);
$zoom = get_post_meta($post_id, 'map_zoom', true);
$enable_street_views_google_map        = get_post_meta( $post_id, 'enable_street_views_google_map', true );
$marker_icon = st()->get_option('st_activity_icon_map_marker', '');
if (empty($marker_icon)){
    $marker_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_activity.png';
}
$map_iframe = get_post_meta($post_id,'map_iframe',true);
$address = get_post_meta($post_id, 'address', true);
$is_iframe = get_post_meta(get_the_ID(), 'is_iframe', true);
 if($is_iframe == 'on'){
    if(!empty($map_iframe)){ ?>
        
        <div class="st-map-wrapper">
        <div class="st-hr large"></div>
            <div class="st-flex space-between">
                <h2 class="st-heading-section"><?php echo __('Activity\'s Location', 'traveler') ?></h2>
                <?php if ($address) {
                    ?>
                    <div class="c-grey"><?php
                        echo TravelHelper::getNewIcon('Ico_maps', '#5E6D77', '18px', '18px');
                        echo esc_html($address); ?></div>
                    <?php
                } ?>
            </div>
            <div class="map_iframe">
                <?php echo balanceTags($map_iframe); ?>
            </div>

        </div>
    <?php } 
}else{ ?>
    
    <div class="st-map-wrapper">
        <div class="st-hr large"></div>
        <?php
        if (!$zoom) {
            $zoom = 13;
        }
        ?>
        <div class="st-flex space-between">
            <h2 class="st-heading-section"><?php echo __('Activity\'s Location', 'traveler') ?></h2>
            <?php if ($address) {
                ?>
                <div class="c-grey  d-flex align-items-center">
                    <?php
                    echo '<i class="stt-icon-location1"></i>';
                    echo esc_html($address); ?></div>
                <?php
            } ?>
        </div>
        <?php
        $default = apply_filters('st_show_activity_nearby', array(
            'number'      => '12' ,
            'range'       => '100' ,
            'show_circle' => 'no' ,
        ));
        extract($default);
        $hotel = new STActivity();
        $location_center  = '[' . $lat . ',' . $lng . ']';
        $map_lat_center = $lat;
        $map_lng_center = $lng;

        $data_map = array();
        $stt  =  1;
        global $post;

        if (st()->get_option('st_show_activity_nearby') == 'on') {
            $data  = $hotel->get_near_by( get_the_ID() , $range , $number );
            if(!empty( $data )) {
                $stt  =  1;
                foreach( $data as $post ) :
                    setup_postdata( $post );
                    $map_lat = get_post_meta( get_the_ID() , 'map_lat' , true );
                    $map_lng = get_post_meta( get_the_ID() , 'map_lng' , true );
                    if(!empty( $map_lat ) and !empty( $map_lng ) and is_numeric( $map_lat ) and is_numeric( $map_lng )) {
                        $data_val = array(
                            'id' => get_the_ID(),
                            'post_id' => get_the_ID(),
                            'name' => get_the_title(),
                            'description' => "",
                            'lat' => (float)$map_lat,
                            'lng' => (float)$map_lng,
                            'icon_mk' => $marker_icon,
                            'featured' => get_the_post_thumbnail_url(get_the_ID()),
                            'url' => get_permalink(get_the_ID()),
                        );
                        $post_type                              = get_post_type();
                        $data_map[$stt][ 'id' ]               = get_the_ID();
                        $data_map[$stt][ 'name' ]             = get_the_title();
                        $data_map[$stt][ 'post_type' ]        = $post_type;
                        $data_map[$stt][ 'lat' ]              = $map_lat;
                        $data_map[$stt][ 'lng' ]              = $map_lng;
                        $data_map[$stt][ 'icon_mk' ]          = $marker_icon;
                        $data_map[$stt]['content_html'] = preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $data_val]));
                        $stt++;
                    }
                endforeach;
                wp_reset_postdata();
            }
        }

        $properties = $hotel->properties_near_by(get_the_ID(), $lat, $lng, $range);
        
        if( !empty($properties)){
            foreach($properties as $key => $val){
                $data_map[] = array(
                    'id' => get_the_ID(),
                    'name' => $val['name'],
                    'post_type' => 'st_hotel',
                    'lat' => (float)$val['lat'],
                    'lng' => (float)$val['lng'],
                    'icon_mk' => (empty($val['icon']))? 'http://maps.google.com/mapfiles/marker_black.png': $val['icon'],
                    'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $val])),

                );
            }
        }
        $data_map_origin = array(
            'id' => $post_id,
            'post_id' => $post_id,
            'name' => get_the_title(),
            'description' => "",
            'lat' => $lat,
            'lng' => $lng,
            'icon_mk' => $marker_icon,
            'featured' => get_the_post_thumbnail_url($post_id),
        );
        $data_map[] = array(
            'id' => $post_id,
            'name' => get_the_title(),
            'post_type' => 'st_hotel',
            'lat' => $lat,
            'lng' => $lng,
            'icon_mk' => $marker_icon,
            'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $data_map_origin])),

        );
        
        $data_map       = json_encode( $data_map , JSON_FORCE_OBJECT );
        
        ?>
        <?php $google_api_key = st()->get_option('st_googlemap_enabled');
        if ($google_api_key === 'on') { ?>
            <div class="st-map">
                <div class="google-map gmap3" id="list_map"
                    data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
                    data-lat="<?php echo trim($lat) ?>"
                    data-lng="<?php echo trim($lng) ?>"
                    data-icon="<?php echo esc_url($marker_icon); ?>"
                    data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                    data-street_views="<?php echo trim($enable_street_views_google_map) ?>"
                    data-showcustomcontrol="true"
                    data-style="normal">
                </div>
            </div>
        <?php } else { ?>
            <div class="st-map-box">
                <div class="google-map-mapbox" data-lat="<?php echo trim($lat) ?>"
                    data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
                        data-lng="<?php echo trim($lng) ?>"
                        data-icon="<?php echo esc_url($marker_icon); ?>"
                        data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                        data-showcustomcontrol="true"
                        data-style="normal">
                    <div id="st-map">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
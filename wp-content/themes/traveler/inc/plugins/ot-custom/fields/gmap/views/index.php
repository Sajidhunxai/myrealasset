<?php

/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/20/15
 * Time: 3:23 PM
 */
$default = array(
    'field_desc'  => '',
    'field_name'  => '',
    'field_value' => array(),
    'meta'        => '',
    'field_id'    => '',
    'type'        => '',
    'range'       => 50
);
$args = wp_parse_args($args, $default);
extract($args);
if ($field_value == 'off') {
    $zoom = get_post_meta(STInput::request('post'), 'map_zoom', true);
    if (empty($zoom)) $zoom = '1';
    $field_value  = array(
        'lat' => get_post_meta(STInput::request('post'), 'map_lat', true),
        'lng' => get_post_meta(STInput::request('post'), 'map_lng', true),
        'type' => get_post_meta(STInput::request('post'), 'map_type', true),
        'zoom' => $zoom,
    );
}
if (is_page_template('template-user.php')) {
    // for user partner
    if (STInput::request('sc') == "update-info-partner") {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $zoom = get_user_meta($user_id, 'map_zoom', true);
        if (empty($zoom)) $zoom = '1';
        $field_value  = array(
            'lat' => get_user_meta($user_id, 'map_lat', true),
            'lng' => get_user_meta($user_id, 'map_lng', true),
            'type' => get_user_meta($user_id, 'map_type', true),
            'zoom' => $zoom,
        );
    } else {
        // for post partner
        $zoom = get_post_meta(STInput::request('id'), 'map_zoom', true);
        if (empty($zoom)) $zoom = '1';
        $field_value  = array(
            'lat' => get_post_meta(STInput::request('id'), 'map_lat', true),
            'lng' => get_post_meta(STInput::request('id'), 'map_lng', true),
            'type' => get_post_meta(STInput::request('id'), 'map_type', true),
            'zoom' => $zoom,
        );
    }
}
if (!empty($field_post_type)) {
    $post_type = $field_post_type;
}
/* verify a description */
$has_desc = $field_desc ? TRUE : FALSE;
echo '<div class="format-setting type-post_select_ajax ' . ($has_desc ? 'has-desc' : 'no-desc') . '">';
/* description */
echo ($has_desc) ? '<div class="description">' . htmlspecialchars_decode($field_desc) . '</div>' : '';
/* format setting inner wrapper */
echo '<div class="format-setting-inner">';
/* allow fields to be filtered */
echo '<div class="option-tree-ui-' . esc_attr($type) . '-input-wrap">';
?>
<div class="bt_ot_gmap_wrap clearfix">
    <?php $google_api_key = st()->get_option('st_googlemap_enabled');
    $st_token_mapbox = st()->get_option('st_token_mapbox');
    if (isset($st_token_mapbox) && !empty($st_token_mapbox)) {
        $st_token_mapbox = $st_token_mapbox;
    } else {
        $st_token_mapbox = 'pk.eyJ1IjoidGhvYWluZ28iLCJhIjoiY2p3dTE4bDFtMDAweTQ5cm5rMXA5anUwMSJ9.RkIx76muBIvcZ5HDb2g0Bw';
    }
    $properties = [];
    $data_map = [];
    $st_icon_mapbox  = "https://i.imgur.com/MK4NUzI.png";
    $current_screen = get_current_screen();
    if (class_exists('TravelerObject') && isset($field_value['lat']) && isset($field_value['lng'])) {
        $property = new TravelerObject();
        $properties = $property->properties_near_by(get_the_ID(), $field_value['lat'], $field_value['lng'], $range);
        if( !empty($properties)){
            foreach($properties as $key => $val){
                if (isset($val['lat']) && !empty($val['lat']) &&
                    isset($val['lng']) && !empty($val['lng'])
                ) {
                    $data_map[] = array(
                        'lat' => (float) $val['lat'],
                        'lng' => (float) $val['lng'],
                        'icon_mk' => (empty($val['icon']))? 'http://maps.google.com/mapfiles/marker_black.png': $val['icon'],
                    );
                }
            }
        }
    }
    if ($current_screen->post_type === 'st_hotel') {
        $st_icon_mapbox = st()->get_option('st_hotel_icon_map_marker');
    } elseif ($current_screen->post_type === 'st_tours') {
        $st_icon_mapbox = st()->get_option('st_tours_icon_map_marker');
    } elseif ($current_screen->post_type === 'st_rental') {
        $st_icon_mapbox = st()->get_option('st_rental_icon_map_marker');
    } elseif ($current_screen->post_type === 'st_activity') {
        $st_icon_mapbox = st()->get_option('st_activity_icon_map_marker');
    } elseif ($current_screen->post_type === 'st_cars') {
        $st_icon_mapbox = st()->get_option('st_cars_icon_map_marker');
    } elseif ($current_screen->post_type === 'st_location') {
        $st_icon_mapbox = st()->get_option('st_hotel_icon_map_marker');
    }
    if ($google_api_key === 'on') {
    ?>
        <input type="text" placeholder="<?php _e('Search by name...', 'traveler') ?>" class="bt_ot_searchbox" />
        <div class="bt_ot_gmap" data-data_show='<?php echo str_ireplace(array("'"),'\"', json_encode( $data_map , JSON_FORCE_OBJECT )) ;?>'></div>
    <?php } else {
        if (is_rtl()) {
            $text_rtl_mapbox = "https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js";
        } else {
            $text_rtl_mapbox = "";
        }
    ?>
        <input type="hidden" name="text_rtl_mapbox" class="text_rtl_mapbox" value="<?php echo esc_attr($text_rtl_mapbox); ?>">
        <input type="hidden" name="st_token_mapbox" class="st_token_mapbox" value="<?php echo esc_attr($st_token_mapbox); ?>">
        <input type="hidden" name="st_icon_mapbox" class="st_icon_mapbox" value="<?php echo esc_attr($st_icon_mapbox); ?>">
        <div class="bt_ot_gmap" id="st_mapbox_custom" data-data_show='<?php echo str_ireplace(array("'"),'\"', json_encode( $data_map , JSON_FORCE_OBJECT )) ;?>'></div>
        <style>
            .bt_ot_gmap_wrap .geocoder {
                position: absolute;
                z-index: 1;
                width: 50%;
                left: 35%;
                margin-left: -25%;
                top: 20px;
            }

            .bt_ot_gmap_wrap .mapboxgl-ctrl-geocoder {
                min-width: 100%;
            }
        </style>
        <div id="geocoder" class="geocoder"></div>
    <?php } ?>
    <?php $validator = STUser_f::$validator; ?>
    <div class="bt_ot_map_field">
        <div class="" style="padding-left: 10px">
            <?php
            $value = '';
            if (!empty($field_value['lat'])) {
                $value = $field_value['lat'];
            } else {
                $tmp = STInput::request('gmap');
                $value = !empty($tmp['lat'])? esc_html($tmp['lat']): '';
            } ?>
            <label for=""><span class="title"><?php _e('Latitude:', 'traveler') ?></span></label>
            <input type="text" placeholder="<?php _e('Latitude', 'traveler') ?>" id="bt_ot_gmap_input_lat" class="number bt_ot_gmap_input_lat widefat option-tree-ui-input form-control" value="<?php echo esc_html($value) ?>" name="<?php echo esc_attr($field_name) ?>[lat]" />
            <?php
            $value = '';
            if (!empty($field_value['lng'])) {
                $value = $field_value['lng'];
            } else {
                $tmp = STInput::request('gmap');
                $value = !empty($tmp['lng']) ? esc_html($tmp['lng']): '';
            } ?>
            <label for=""><span class="title"><?php _e('Longitude:', 'traveler') ?></span></label>
            <input value="<?php echo esc_html($value) ?>" type="text" placeholder="<?php _e('Longitude', 'traveler') ?>" id="bt_ot_gmap_input_lng" class="number bt_ot_gmap_input_lng widefat option-tree-ui-input form-control" name="<?php echo esc_attr($field_name) ?>[lng]" />
            <?php
            $value = '';
            $tmp = STInput::request('gmap');
            if (!empty($tmp)) {
                $value = $tmp['zoom'];
            } elseif (!empty($field_value['zoom'])) {
                $value = $field_value['zoom'];
            }
            if ($google_api_key === 'on') { ?>
                <label for=""><span class="title"><?php _e('Zoom Level:', 'traveler') ?></span></label>
                <input value="<?php echo esc_html($value) ?>" type="text" placeholder="<?php _e('Zoom Level', 'traveler') ?>" id="bt_ot_gmap_input_zoom" class="number bt_ot_gmap_input_zoom widefat option-tree-ui-input form-control" name="<?php echo esc_attr($field_name) ?>[zoom]" />
                <?php
                $value = '';
                if (!empty($field_value['type'])) {
                    $value = $field_value['type'];
                } else {
                    $tmp = STInput::request('gmap');
                    $value = !empty($tmp['type']) ? esc_html($tmp['type']): '';
                }
                if (is_numeric($value)) {
                    $value = 'roadmap';
                }
                ?>
                <label for=""><span class="title"><?php _e('Map Style:', 'traveler') ?></span></label>
                <input readonly="readonly" value="<?php echo esc_html($value) ?>" type="text" placeholder="<?php _e('Map style', 'traveler') ?>" id="bt_ot_gmap_input_type" class="bt_ot_gmap_input_type widefat option-tree-ui-input form-control" name="<?php echo esc_attr($field_name) ?>[type]" />
            <?php } else { ?>
                <input value="<?php echo esc_html($value) ?>" type="text" placeholder="<?php _e('Zoom Level', 'traveler') ?>" id="bt_ot_gmap_input_zoom" class="number bt_ot_gmap_input_zoom widefat option-tree-ui-input form-control" name="<?php echo esc_attr($field_name) ?>[zoom]" />
                <input value="" type="hidden" placeholder="<?php _e('Map style', 'traveler') ?>" id="bt_ot_gmap_input_type" class="bt_ot_gmap_input_type widefat option-tree-ui-input form-control" name="<?php echo esc_attr($field_name) ?>[type]" />
            <?php } ?>
        </div>
    </div>
</div>
<?php
echo '</div>';
echo '</div>';
echo '</div>';

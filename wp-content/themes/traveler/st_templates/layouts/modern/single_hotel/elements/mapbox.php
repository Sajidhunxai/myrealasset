<?php extract(shortcode_atts(array(
    'list_location' => [],
    'map_zoom' => ''
  ), $attr));
$list_location = vc_param_group_parse_atts($list_location);
$link_google_map = "http://maps.google.com?q=";
$list_lnglat = [];
if ( ! empty( $list_location ) && is_array( $list_location ) && count( $list_location ) > 0 ) :
  foreach ( $list_location as $item_location ) :
    if ( !empty( $item_location['location_longitude'] ) && !empty( $item_location['location_latitude'] ) ) {
      $tmp = [floatval($item_location['location_longitude']), floatval($item_location['location_latitude'])];
      array_push($list_lnglat, $tmp);
    }
  endforeach;
endif;
wp_enqueue_style( 'st-hotel-alone-mapbox-gl-css' );
wp_enqueue_style( 'st-hotel-alone-mapbox-css' );
wp_enqueue_script( 'st-hotel-alone-mapbox-gl-js' );
wp_enqueue_script( 'st-hotel-alone-mapbox-js' );
wp_enqueue_script( 'st-hotel-alone-mapbox-custom-js' );
wp_localize_script( 'st-hotel-alone-mapbox-custom-js', 'list_lnglat', $list_lnglat);
$gg_api_key = st()->get_option( 'google_api_key', "" );
$google_api_key = st()->get_option('st_googlemap_enabled');
if($google_api_key === 'on'){
  ?>
  <div class="st-hotel-alone-mapbox">
    <div class="mapbox-overlay"></div>
    <div class="mapbox" id="st-hotel-alone-googlemap" data-map-zoom="<?php esc_attr_e( $map_zoom ) ?>">
    </div>
    <div class="container">
      <div class="mapbox-content">
        <div class="mapbox-text">
          <h1 class="mapbox-heading"><?php esc_html_e( 'Location', 'traveler' ); ?></h1>
          <div class="row">
            <?php
            if ( ! empty( $list_location ) && is_array( $list_location ) && count( $list_location ) > 0 ) :
              foreach ( $list_location as $item_location ) : ?>
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="list-location-item">
                    <h2 class="item-title"><?php echo esc_html( $item_location[ 'location_name' ] ) ?></h2>
                    <p class="item-address"><?php echo esc_html( $item_location[ 'location_address' ] ) ?></p>
                    <a target="_blank" href="<?php echo esc_url ( $link_google_map . $item_location['location_address'] ) ?>" class="item-link"><?php esc_html_e( 'Get Directions', 'traveler' ) ?></a>
                  </div>
                </div>
                <?php
              endforeach;
            endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
} else {
  ?>
  <div class="st-hotel-alone-mapbox">
    <div class="mapbox-overlay"></div>
    <div class="mapbox" id="st-hotel-alone-mapbox" data-map-zoom="<?php esc_attr_e( $map_zoom ) ?>">
    </div>
    <div class="container">
      <div class="mapbox-content">
        <div class="mapbox-text">
          <h1 class="mapbox-heading"><?php esc_html_e( 'Location', 'traveler' ); ?></h1>
          <div class="row">
            <?php
            if ( ! empty( $list_location ) && is_array( $list_location ) && count( $list_location ) > 0 ) :
              foreach ( $list_location as $item_location ) : ?>
                <div class="col-xs-12<?php echo ( count( $list_location ) != 1 ) ? 'col-sm-6 col-md-6' : ''; ?>">
                  <div class="list-location-item">
                    <h2 class="item-title"><?php echo esc_html( $item_location[ 'location_name' ] ) ?></h2>
                    <p class="item-address"><?php echo esc_html( $item_location[ 'location_address' ] ) ?></p>
                    <a target="_blank" href="<?php echo esc_url ( $link_google_map . $item_location['location_address'] ) ?>" class="item-link"><?php esc_html_e( 'Get Directions', 'traveler' ) ?></a>
                  </div>
                </div>
                <?php
              endforeach;
            endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
} ?>

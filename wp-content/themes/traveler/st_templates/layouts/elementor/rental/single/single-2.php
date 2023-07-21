<?php
    wp_enqueue_script('filter-rental');
    while ( have_posts() ): the_post();
        $room_id  = get_the_ID();
        $post_id   = get_the_ID();
        $thumbnail = get_the_post_thumbnail_url( $room_id, 'full' );

        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
        $enable_street_views_google_map        = get_post_meta( $post_id, 'enable_street_views_google_map', true );

        $start           = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
        $end             = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
        $date            = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
        $room_num_search = (int)STInput::get( 'room_num_search', 1 );
        if ( $room_num_search <= 0 ) $room_num_search = 1;
        $start       = TravelHelper::convertDateFormat( $start );
        $end         = TravelHelper::convertDateFormat( $end );

        $orgin_price=STPrice::getRentalPriceOnlyCustomPrice(get_the_ID(), strtotime($start), strtotime($end));
        $price= STPrice::getSalePrice(get_the_ID(), strtotime($start), strtotime($end));
        $price = !empty($price['total_price']) ? floatval($price['total_price']) : 0;
        $number_day = STDate::dateDiff($start, $end);
        if ( $number_day == 0 ) {
            $number_day = 1;
        }
        $min_price = get_post_meta( get_the_ID(), 'min_price',true);
        $min_price = $min_price*$number_day;

        $booking_period = (int)get_post_meta($room_id, 'rentals_booking_period', true);
        $location       = get_post_meta( $room_id, 'multi_location', true );
        if ( !empty( $location ) ) {
            $location = explode( ',', $location );
            if ( isset( $location[ 0 ] ) ) {
                $location = str_replace( '_', '', $location[ 0 ] );
            } else {
                $location = false;
            }
        }
        $address = get_post_meta($room_id, 'address', true);
        $marker_icon = st()->get_option('st_rental_icon_map_marker', '');

        $review_rate = STReview::get_avg_rate();

        $room_external = get_post_meta(get_the_ID(), 'st_rental_external_booking', true);
        $room_external_link = get_post_meta(get_the_ID(), 'st_rental_external_booking_link', true);
        $booking_type = st_get_booking_option_type();
        ?>
        <div id="st-content-wrapper" class="st-single-rental-2">
            <?php
                $inner_style = '';
                $thumb_id = get_post_thumbnail_id(get_the_ID());
                $menu_transparent = st()->get_option('menu_transparent', '');
                $img = wp_get_attachment_image_url($thumb_id, 'full');
                $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
                if($menu_transparent == 'on'){?>
                    <div class="st-header-transparent st-header-transparent-elementor banner st-bg-feature <?php echo esc_attr($inner_style) ?>">
                        <div class="container">
                            <div class="st-banner-search-form style_2">
                                <h1 class="st-banner-search-form__title"><?php the_title(); ?></h1>
                                <?php echo st_breadcrumbs_new();?>

                            </div>
                        </div>
                    </div>
                <?php } else {
                    st_breadcrumbs_new() ?>
                    <div class="st-featured-background"style="background-image: url('<?php echo esc_url( $thumbnail ) ?>')"></div>
                <?php }
            ?>

            <div class="st-hotel-content">
                <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                    <div class="price-wrapper">
                        <?php echo wp_kses( sprintf( __( 'from <span class="price">%s</span>', 'traveler' ), TravelHelper::format_money( $min_price ) ), [ 'span' => [ 'class' => [] ] ] ) ?>
                    </div>
                    <?php
                    if($room_external == 'off' || empty($room_external)){
                        ?>
                        <a href=""
                            class="btn btn-mpopup btn-green">
                                <?php
                                    if($booking_type == 'enquire'){
                                        echo esc_html__('Inquiry', 'traveler');
                                    } else {
                                        echo esc_html__('Book Now', 'traveler');
                                    }
                                ?>
                            </a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo esc_url($room_external_link); ?>"
                           class="btn btn-green"><?php echo esc_html__( 'Book Now', 'traveler' ) ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-9">
                        <div class="st-service-header d-flex justify-content-between align-items-center">
							<?php
							$menu_transparent = st()->get_option( 'menu_transparent', '' );
							if ( $menu_transparent !== 'on' ) : ?>
								<div class="left">
									<h1 class="st-heading"><?php the_title(); ?></h1>
								</div>
							<?php endif; ?>
                            <div class="right">
                                <div class="review-score style-2">
                                    <?php echo st()->load_template( 'layouts/elementor/common/star', '', [ 'star' => $review_rate, 'style' => 'style-2' ] ); ?>
                                    <p class="st-link"><?php comments_number( __( 'from 0 review', 'traveler' ), __( 'from 1 review', 'traveler' ), __( 'from % reviews', 'traveler' ) ); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="st-hr large"></div>
                        <!-- Infor -->
                        <?php echo st()->load_template('layouts/elementor/rental/single/item/infor', '',['room_id' => $room_id]); ?>
                        <!-- End Info -->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/gallery','',['post_id' => $room_id]); ?>
                        <div class="st-hr large"></div>
                        <!-- Description -->
                        <?php echo st()->load_template('layouts/elementor/rental/single/item/description'); ?>
                        <!-- End description -->
                        <?php echo st()->load_template('layouts/elementor/rental/single/item/discount'); ?>

                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/attributes','',['post_type' => 'st_rental']);?>

                        <!-- Availability -->

                        <?php echo st()->load_template('layouts/elementor/rental/single/item/availability', '',['booking_period' => $booking_period , 'room_id' => $room_id]); ?>
                        <!-- End Availability -->
                        <div class="st-hr large"></div>
                        <?php if ( $location ) {
                            $lat  = get_post_meta( get_the_ID(), 'map_lat', true );
                            $lng  = get_post_meta( get_the_ID(), 'map_lng', true );
                            $zoom = get_post_meta( get_the_ID(), 'map_zoom_location', true );
                            if(!$zoom){
                                $zoom = 13;
                            }
                            ?>
                            <div class="st-flex space-between">
                                <h2 class="st-heading-section mg0"><?php echo __( 'Map', 'traveler' ) ?></h2>
                                <?php if($address){
                                    ?>
                                    <div class="c-grey"><?php
                                            echo TravelHelper::getNewIcon( 'Ico_maps', '#5E6D77', '18px', '18px' );
                                            echo esc_html($address); ?></div>
                                    <?php
                                } ?>
                            </div>
                            <?php
                            $default = apply_filters('st_rental_property_near_by_params', array(
                                'number'      => '12' ,
                                'range'       => '50' ,
                                'show_circle' => 'no' ,
                            ));
                            extract($default);
                            $hotel = new STRental();
                            $data  = $hotel->get_near_by( get_the_ID() , $range , $number );
                            $location_center  = '[' . $lat . ',' . $lng . ']';
                            $map_lat_center = $lat;
                            $map_lng_center = $lng;

                            $data_map = array();
                            $stt  =  1;
                            $map_icon = st()->get_option('st_rental_icon_map_marker', '');
                            if (empty($map_icon)){
                                $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_rental.png';
                            }

                            if (st()->get_option('st_show_rental_nearby') == 'on') {
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
                                                'icon_mk' => $map_icon,
                                                'featured' => get_the_post_thumbnail_url(get_the_ID()),
                                                'url' => get_permalink(get_the_ID()),
                                            );
                                            $post_type                              = get_post_type();
                                            $data_map[$stt][ 'id' ]               = get_the_ID();
                                            $data_map[$stt][ 'name' ]             = get_the_title();
                                            $data_map[$stt][ 'post_type' ]        = $post_type;
                                            $data_map[$stt][ 'lat' ]              = $map_lat;
                                            $data_map[$stt][ 'lng' ]              = $map_lng;
                                            $data_map[$stt][ 'icon_mk' ]          = $map_icon;
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
                                'lat' => (float)$lat,
                                'lng' => (float)$lng,
                                'icon_mk' => $map_icon,
                                'featured' => get_the_post_thumbnail_url($post_id),
                            );
                            $data_map[] = array(
                                'id' => $post_id,
                                'name' => get_the_title(),
                                'post_type' => 'st_hotel',
                                'lat' =>(float) $lat,
                                'lng' => (float)$lng,
                                'icon_mk' => $map_icon,
                                'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $data_map_origin])),

                            );

                            $data_map       = json_encode( $data_map , JSON_FORCE_OBJECT );
                            ?>
                            <?php $google_api_key = st()->get_option('st_googlemap_enabled');
                            if ($google_api_key === 'on') { ?>
                                <div class="st-map mt30">
                                    <div class="google-map gmap3" id="list_map"
                                        data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
                                        data-lat="<?php echo trim($lat) ?>"
                                        data-lng="<?php echo trim($lng) ?>"
                                        data-icon="<?php echo esc_url($marker_icon); ?>"
                                        data-street_views="<?php echo trim($enable_street_views_google_map) ?>"
                                        data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                                        data-showcustomcontrol="true"
                                        data-style="normal">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="st-map-box mt30">
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
                        <?php } ?>

                        <?php echo st()->load_template('layouts/elementor/rental/single/item/review','',['review_rate' => $review_rate,'room_id' => $room_id ]);?>
                        <div class="stoped-scroll-section"></div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="widgets">
                            <div class="fixed-on-mobile" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
                                </div>

                                <?php
                                if($booking_type == 'instant_enquire'){
                                    echo st()->load_template('layouts/elementor/rental/single/item/form-booking','instant-inquiry',
                                    [
                                        'price' => $min_price,
                                        'room_id' => $room_id,
                                        'room_external' => $room_external,
                                        'room_external_link' => $room_external_link,
                                        'booking_period' => $booking_period,
                                        'number_day' => $number_day,
                                    ]);
                                }else{
                                    if($booking_type == 'enquire'){
                                        echo st()->load_template('layouts/elementor/rental/single/item/form-booking','inquiry',
                                        [
                                            'price' => $min_price,
                                            'room_id' => $room_id,
                                            'room_external' => $room_external,
                                            'room_external_link' => $room_external_link,
                                            'booking_period' => $booking_period,
                                            'number_day' => $number_day,
                                        ]);
                                    }else{
                                        echo st()->load_template('layouts/elementor/rental/single/item/form-booking','instant',
                                        [
                                            'price' => $min_price,
                                            'room_id' => $room_id,
                                            'room_external' => $room_external,
                                            'room_external_link' => $room_external_link,
                                            'booking_period' => $booking_period,
                                            'number_day' => $number_day,
                                        ]);
                                    }
                                }
                                ?>
                                <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info'); ?>
                                <?php echo st()->load_template('layouts/modern/common/single/information-contact'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                echo st()->load_template('layouts/elementor/rental/single/item/rental-nearby','',['post_id' =>$post_id]);
            ?>
        </div>
    <?php
    endwhile;

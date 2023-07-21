<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-12-2018
 * Time: 1:55 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
wp_enqueue_script('filter-car');
while (have_posts()): the_post();
    $post_id = get_the_ID();
    $address = get_post_meta($post_id, 'address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = STReview::count_review($post_id);
    $lat = get_post_meta($post_id, 'map_lat', true);
    $lng = get_post_meta($post_id, 'map_lng', true);
    $zoom = get_post_meta($post_id, 'map_zoom', true);
    $enable_street_views_google_map        = get_post_meta( $post_id, 'enable_street_views_google_map', true );
    $gallery = get_post_meta($post_id, 'gallery', true);
    $gallery_array = explode(',', $gallery);
    $marker_icon = st()->get_option('st_cars_icon_map_marker', '');

    $car_external = get_post_meta(get_the_ID(), 'st_car_external_booking', true);
    $car_external_link = get_post_meta(get_the_ID(), 'st_car_external_booking_link', true);

    $pickup_date = STInput::get('pick-up-date');
    $dropoff_date = STInput::get('drop-off-date');

    $pickup_date = TravelHelper::convertDateFormat($pickup_date);
    $dropoff_date = TravelHelper::convertDateFormat($dropoff_date);

    $pick_up_time = STInput::get('pick-up-time', '12:00 PM');
    $drop_off_time = STInput::get('drop-off-time', '12:00 PM');

    $info_price = STCars::get_info_price(get_the_ID(), strtotime($pickup_date), strtotime($dropoff_date));
    $cars_price = $info_price['price'];
    $count_sale = $info_price['discount'];
    $price_origin = $info_price['price_origin'];
    $list_price = $info_price['list_price'];

    $booking_type = st_get_booking_option_type();
    ?>
    <div id="st-content-wrapper" class="st-single-tour st-single-car">
        <?php st_breadcrumbs_new() ?>
        <div class="container">
            <div class="st-hotel-content">
                <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                    <div class="price-wrapper">
                        <?php echo wp_kses(sprintf(__('from <span class="price">%s</span><span class="unit">/%s</span>', 'traveler'), TravelHelper::format_money($cars_price), strtolower(STCars::get_price_unit('label'))), ['span' => ['class' => []]]) ?>
                    </div>
                    <?php
                    if ($car_external == 'off' || empty($car_external)) {
                        ?>
                        <a href=""
                            class="btn btn-mpopup btn-green">
                                <?php
                                    if($booking_type == 'enquire'){
                                        echo esc_html__('Inquiry', 'traveler');
                                    } else {
                                        echo esc_html__('Check Availability', 'traveler');
                                    }
                                ?>
                            </a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo esc_url($car_external_link); ?>"
                        class="btn btn-green"><?php echo esc_html__('Book Now', 'traveler') ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
           
        </div>
        <div class="st-tour-content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-9 col-md-9">
                        <div class="st-service-header d-flex justify-content-between align-items-center">
                            <div class="left">
                                <h1 class="st-heading"><?php the_title(); ?></h1>
                                <div class="sub-heading">
                                    <?php if ($address) {
                                        echo TravelHelper::getNewIcon('ico_maps_add_2', '#5E6D77', '16px', '16px');
                                        echo esc_html($address);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="right">
                                <div class="review-score style-2">
                                    <span class="head-rating"><?php echo TravelHelper::get_rate_review_text($review_rate, $count_review); ?></span>
                                    <?php echo st()->load_template('layouts/elementor/common/star', '', ['star' => $review_rate, 'style' => 'style-2']); ?>
                                    <p class="st-link"><?php comments_number(__('from 0 review', 'traveler'), __('from 1 review', 'traveler'), __('from % reviews', 'traveler')); ?></p>
                                </div>
                            </div>
                        </div>
                        <!--Tour Info-->
                        <?php echo st()->load_template('layouts/elementor/car/single/item/infor', '',['post_id' => $post_id]); ?>
                        <!--End info-->
                        <?php echo st()->load_template('layouts/elementor/car/single/item/gallery', '',['gallery_array' => $gallery_array]); ?>
                        <!--Tour Overview-->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/description'); ?>
                        <div class="st-hr large st-hr-comment"></div>
                        <!--End Tour Overview-->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/attributes','',['post_type' => 'st_cars']);?>
                        <!--Tour Map-->
                        <div class="st-map-wrapper">
                            <?php
                            if (!$zoom) {
                                $zoom = 13;
                            }
                            ?>
                            <div class="st-flex space-between">
                                <h2 class="st-heading-section mg0"><?php echo __('Car\'s Location', 'traveler') ?></h2>
                                <?php if ($address) {
                                    ?>
                                    <div class="c-grey"><?php
                                        echo TravelHelper::getNewIcon('Ico_maps', '#5E6D77', '18px', '18px');
                                        echo esc_html($address); ?></div>
                                    <?php
                                } ?>
                            </div>
                           <?php
                            $default = apply_filters('st_car_property_near_by_params', array(
                                'number'      => '12' ,
                                'range'       => '50' ,
                                'show_circle' => 'no' ,
                            ));
                            extract($default);
                            $car = new STCars();
                            $data  = $car->get_near_by( get_the_ID() , $range , $number );
                            $location_center  = '[' . esc_attr($lat) . ',' . esc_attr($lng) . ']';
                            $map_lat_center = $lat;
                            $map_lng_center = $lng;

                            $data_map = array();
                            $stt  =  1;
                            global $post;
                            if (st()->get_option('st_show_car_nearby') == 'on') {
                                if(!empty( $data )) {
                                    foreach( $data as $post ) :
                                        setup_postdata( $post );
                                        $map_lat = get_post_meta( get_the_ID() , 'map_lat' , true );
                                        $map_lng = get_post_meta( get_the_ID() , 'map_lng' , true );
                                        if(!empty( $map_lat ) and !empty( $map_lng ) and is_numeric( $map_lat ) and is_numeric( $map_lng )) {
                                            $post_type                              = get_post_type();
                                            $data_map[ $stt ][ 'id' ]               = get_the_ID();
                                            $data_map[ $stt ][ 'name' ]             = get_the_title();
                                            $data_map[ $stt ][ 'post_type' ]        = $post_type;
                                            $data_map[ $stt ][ 'lat' ]              = $map_lat;
                                            $data_map[ $stt ][ 'lng' ]              = $map_lng;
                                            $data_map[ $stt ][ 'icon_mk' ]          = st()->get_option( 'st_cars_icon_map_marker' , 'http://maps.google.com/mapfiles/marker_black.png' );
                                            $data_map[$stt]['content_html'] = preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/car/elements/content/map-popup'));

                                            $stt++;
                                        }
                                    endforeach;
                                    wp_reset_postdata();
                                }
                            }
                            $properties = $car->properties_near_by(get_the_ID(), $lat, $lng, $range);
                            if( !empty($properties)){
                                foreach($properties as $key => $val){
                                    $data_map[] = array(
                                        'id' => get_the_ID(),
                                        'name' => $val['name'],
                                        'post_type' => 'st_cars',
                                        'lat' => (float)$val['lat'],
                                        'lng' => (float)$val['lng'],
                                        'icon_mk' => (empty($val['icon']))? 'http://maps.google.com/mapfiles/marker_black.png': $val['icon'],
                                        'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $val])),

                                    );
                                }
                            }
                            $map_icon = st()->get_option('st_cars_icon_map_marker', '');

                            if (empty($map_icon)){
                                $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
                            }


                            $data_map_origin = array();
                            $data_map_origin = array(
                                'id' => $post_id,
                                'post_id' => $post_id,
                                'name' => get_the_title(),
                                'description' => "",
                                'lat' => $lat,
                                'lng' => $lng,
                                'icon_mk' => $map_icon,
                                'featured' => get_the_post_thumbnail_url($post_id),
                            );
                            $data_map[] = array(
                                'id' => $post_id,
                                'name' => get_the_title(),
                                'post_type' => 'st_cars',
                                'lat' => $lat,
                                'lng' => $lng,
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
                        </div>
                        <!--End Tour Map-->

                        <!--Review Option-->
                            <?php echo st()->load_template('layouts/elementor/car/single/item/review','',['count_review'=>$count_review,'review_rate' => $review_rate,'post_id' => $post_id ]);?>
                        <!--End Review Option-->
                        <div class="stoped-scroll-section"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-3">
                        <div class="widgets">
                            <div class="fixed-on-mobile" id="booking-request" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
                                </div>

                                <?php
                                if($booking_type == 'instant_enquire'){
                                    echo st()->load_template('layouts/elementor/car/single/item/form-booking','instant-inquiry',
                                    [
                                        'info_price' => $info_price,
                                        'car_external' => $car_external,
                                        'car_external_link' => $car_external_link,
                                        'cars_price' => $cars_price,
                                    ]);
                                }else{
                                    if($booking_type == 'enquire'){
                                        echo st()->load_template('layouts/elementor/car/single/item/form-booking','inquiry',
                                        [
                                            'info_price' => $info_price,
                                            'car_external' => $car_external,
                                            'car_external_link' => $car_external_link,
                                            'cars_price' => $cars_price,
                                        ]);
                                    }else{
                                        echo st()->load_template('layouts/elementor/car/single/item/form-booking','instant',
                                        [
                                            'info_price' => $info_price,
                                            'car_external' => $car_external,
                                            'car_external_link' => $car_external_link,
                                            'cars_price' => $cars_price,
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
                <?php

                $st_show_car_nearby = st()->get_option('st_show_car_nearby','off');
                $search_tax_advance = st()->get_option( 'attribute_search_form_car', 'st_category_cars' );
                $terms_posts = wp_get_post_terms(get_the_ID(),$search_tax_advance);
                $arr_id_term_post = array();
                foreach($terms_posts as $term_post){
                    $arr_id_term_post[] = $term_post->term_id;
                }
                $args = [
                    'posts_per_page' => 4,
                    'post_type' => 'st_cars',
                    'post_author' => get_post_field('post_author', get_the_ID()),
                    'post__not_in' => [$post_id],
                    'orderby' => 'rand',
                    'tax_query' => array(
                        'taxonomy' => $search_tax_advance,
                        'terms' => $arr_id_term_post,
                        'field' => 'term_id',
                        'operator' => 'IN'
                    ),
                ];
                global $post;
                $old_post = $post;
                $query = new WP_Query($args);
                if ($query->have_posts()):
                    ?>
                    <div class="st-hr large"></div>
                    <h2 class="heading text-center f28 mt50"><?php echo esc_html__('You might also like', 'traveler') ?></h2>
                    <div class="st-list-tour-related row mt50">
                        <?php
                        while ($query->have_posts()): $query->the_post();
                        echo st()->load_template('layouts/elementor/car/loop/normal-grid', '',array('item_row'=> 4));
                        endwhile;
                        ?>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
                $post = $old_post;
                ?>
            </div>
        </div>
    </div>
<?php
endwhile;

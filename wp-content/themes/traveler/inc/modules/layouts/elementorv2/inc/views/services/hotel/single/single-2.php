<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-11-2018
 * Time: 8:47 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
wp_enqueue_script('single-hotel-detail');
while (have_posts()): the_post();
    $price = STHotel::get_price();
    $post_id = get_the_ID();
    $hotel_star = (int)get_post_meta($post_id, 'hotel_star', true);
    $address = get_post_meta($post_id, 'address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = get_comment_count($post_id)['approved'];
    $lat = get_post_meta($post_id, 'map_lat', true);
    $lng = get_post_meta($post_id, 'map_lng', true);
    $zoom = get_post_meta($post_id, 'map_zoom', true);
    $price = STHotel::get_price();
    $marker_icon = st()->get_option('st_hotel_icon_map_marker', '');
    $thumb_id = get_post_thumbnail_id(get_the_ID());
    ?>
    <div id="st-content-wrapper" class="st-style-4 st-style-elementor singe-hotel-layout-<?php echo esc_attr($style_single);?>">
        <?php
        echo stt_elementorv2()->loadView('components/banner');
        ?>
        <div class="container st-single-service-content">
            <?php echo stt_elementorv2()->loadView('services/hotel/single/item/top-infor', array(
                'hotel_star'=> $hotel_star ,
                'address'=> $address,
                'review_rate' => $review_rate,
                'count_review' => $count_review,
                'button_reserve' => true
                )) ?>
            <?php echo stt_elementorv2()->loadView('services/common/single/gallery',array('style'=> 'grid')) ?>
        </div>
        <div class="container st-single-service-content">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xxl-8">
                    <div class="st-hotel-content">
                        <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                            <div class="price-wrapper">
                                <div id="mobile-price">
                                    <?php echo wp_kses(sprintf(__('From:<span class="price">%s</span><span class="unit"> / night</span>', 'traveler'), TravelHelper::format_money($price)), ['span' => ['class' => []]]) ?>
                                </div>
                                
                                <div class="st-review-booking-form">
                                    <div class="st-review-box-top d-flex align-items-center">
                                        <i class="stt-icon-star1"></i>
                                        <?php
                                        $count_review = get_comment_count($post_id)['approved'];
                                        $avg = STReview::get_avg_rate();
                                        ?>
                                        <div class="review-score">
                                            <?php echo esc_attr($avg); ?>
                                        </div>
                                        <div class="review-score-base text-center">
                                            <span>(<?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?>)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href=""
                            class="btn-v2 btn-primary btn-mpopup btn-green"><?php echo esc_html__('Check', 'traveler') ?></a>
                        </div>
                    </div>
                    
                    <!-- <div class="st-hr"></div> -->
                    <?php echo stt_elementorv2()->loadView('services/common/single/description') ?>
                    <div id="st-attributes">
                        <?php echo stt_elementorv2()->loadView('services/common/single/attributes',['post_type' => 'st_hotel']) ?>
                    </div>
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/rules',['post_id' => $post_id]); ?>
                    
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/list-room',['post_id' => $post_id,'price'=>$price,'has_form_search' => true]); ?>
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/review',['post_id' => $post_id]); ?>
                    <div class="stoped-scroll-section"></div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xxl-4">
                    <div class="widgets sticky-top">
                        <div class="st-fixed-form-booking" data-screen="992px">
                            <?php
                                $logo = get_post_meta( get_the_ID(), 'logo', true );
                                if ( $logo ) {
                                    echo '<div class="d-none d-sm-block widget-box st-logo-box st-border-radius">';
                                        echo '<div class="st-border-radius-sidebar">';
                                            echo '<img src="' . esc_url( $logo ) . '" class="img-responsivve" alt="'.esc_attr(get_the_title()).'">';
                                        echo '</div>';
                                    echo '</div>';
                                }
                            ?>
                            <div class="sidebar-item map-view-wrapper widget-box st-logo-box d-none d-sm-block style-2">
                                <div class="map-view">
                                    <span class="stt-icon stt-icon-location1 icon-marker"></span>
                                    <div class="map-view-button">
                                        <?php echo esc_html__('View in a map', 'traveler'); ?>
                                        <span class="stt-icon stt-icon-arrow2-right"></span>
                                    </div>
                                </div>
                            </div>
                            <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info','',array('size_avatar_custom' => 90)); ?>

                            <?php echo st()->load_template('layouts/modern/common/single/information-contact'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                echo stt_elementorv2()->loadView('services/hotel/single/item/hotel-nearby');
            ?>
        </div>
        <!-- Modal Map Popup -->
        <?php echo stt_elementorv2()->loadView('services/hotel/single/item/popupmap',array(
            'lat' => $lat,
            'lng' => $lng,
            'post_id'=>$post_id,
            'zoom'=>$zoom,
            'marker_icon'=>$marker_icon,

        ));?>
        <div class="modal fade modal-map" id="st-modal-show-map" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"><?php the_title(); ?></div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <?php echo TravelHelper::getNewIcon('Ico_close'); ?></button>
                    </div>
                    <div class="modal-body">
                    <?php
                    $default = apply_filters('st_hotel_property_near_by_params', array(
                        'number'      => '12' ,
                        'range'       => '50' ,
                        'show_circle' => 'no' ,
                    ));
                    extract($default);
                    $hotel = new STHotel();
                    $location_center  = '[' . $lat . ',' . $lng . ']';
                    $map_lat_center = $lat;
                    $map_lng_center = $lng;
                    $map_icon = st()->get_option('st_hotel_icon_map_marker', '');
                    $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
                    if (empty($map_icon)){
                        $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_hotel.png';
                    }

                    $data_map = array();
                    $stt  =  1;
                    global $post;
                    if (st()->get_option('st_show_hotel_nearby') == 'on') {
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
                    if( !empty($properties) ){
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
                        'post_type' => 'st_hotel',
                        'lat' => $lat,
                        'lng' => $lng,
                        'icon_mk' => $map_icon,
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
                </div>
            </div>
        </div>
        <!-- End Modal Map Popup -->
    </div>
    
<?php endwhile;

<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 5/29/2017
 * Version: 1.0
 */
wp_enqueue_script( 'owl-carousel.js' );
wp_enqueue_script( 'richmarker.jquery' );
wp_enqueue_script( 'map_box_single_hotel' );
if(!wp_is_mobile()) {
	wp_enqueue_style( 'weather-icons.css' );
}
if(empty($num_image)){
    $num_image = 3;
}

$new_gallery = array();
if(has_post_thumbnail()){
    $new_gallery[] = get_the_post_thumbnail_url(get_the_ID(),'full');
}

$tour_gallery = get_post_meta(get_the_ID(), 'gallery', true);

if(!empty($tour_gallery)){
    $ids = explode(',',$tour_gallery);
    for ($i = 0; $i < ((int)$num_image - 1); $i++) {
        if (!empty($ids[$i])) {
            $img = wp_get_attachment_image_src($ids[$i], 'full');
            if (!empty($img[0])) {
                $new_gallery[] = $img[0];
            }
        }
    }
}

// extract($atts);

if($style == 'style-1'){
?>
<div class="st-gallery-map st-full-height">
    <div class="st-tour-gallery">
        <div class="tour-gallery owl-carousel">
            <?php
            foreach ($new_gallery as $key => $val) {
                $bg = Assets::build_css('background: #ccc url('.esc_url($val).') center no-repeat');
                ?>
                <div class="item <?php echo esc_attr($bg); ?> st-full-height">
                </div>
            <?php } ?>
        </div>
        <div class="caption-star tour">
            <?php
            if(!wp_is_mobile()) {
	            $tour_weather = TravelHelper::get_location_temp();
	            if ( ! empty( $tour_weather ) ) {
		            $temp_format = st()->get_option( 'st_weather_temp_unit', 'c' );
		            ?>
                    <div class="weather">
                        <div class="w-detail">
                            <span class="icon"><?php echo do_shortcode( $tour_weather['icon'] ) ?></span>
                            <span class="temp"><?php echo balanceTags( $tour_weather['temp'] ) ?>
                                <sup>o</sup><span><?php echo esc_attr( $temp_format ); ?></span></span>
                        </div>
                    </div>
		            <?php
	            }
            }
            ?>
            <h4 class="location"><?php echo TravelHelper::locationHtml(get_the_ID()); ?></h4>
            <h1 class="service-title"><?php the_title(); ?></h1>
        </div>
        <div class="owl-prev owl-control"><i class="fa fa-angle-left"></i></div>
        <div class="owl-next owl-control"><i class="fa fa-angle-right"></i></div>
    </div>
    <div class="on_the_map">
        <a class="btn-on-map" data-hide="<?php echo esc_html__('Hide Map', 'traveler'); ?>" data-no-hide="<?php echo esc_html__('On The Map', 'traveler')?>"><?php echo esc_html__('On The Map', 'traveler'); ?></a>
    </div>
    <div class="review-price">
        <?php
        if(!wp_is_mobile()) {
	        $count_review = STReview::count_comment( get_the_ID() );
	        if ( $count_review > 0 ) {
		        ?>
                <span class="review">
            <span>
                <span><?php echo _n( esc_html__( 'Review', 'traveler' ), esc_html__( 'Reviews', 'traveler' ), $count_review ); ?></span>
	            <?php echo esc_attr( $count_review ); ?></span>
        </span>
                <ul class="review-stars">
			        <?php
			        $avg = STReview::get_avg_rate();
			        echo TravelHelper::rate_to_string( $avg );
			        ?>
                </ul>
		        <?php
	        }
        }
        ?>
        <span class="price">
            <?php
            echo STTour::get_price_html(get_the_ID(),false,'<br>');
            $type_tour = get_post_meta(get_the_ID(),'type_tour',true);
            if($type_tour == 'daily_tour'){
            ?>
            <span class="unit-tour">
                <?php
                echo STTour::get_duration_unit();
                ?>
            </span>
            <?php } ?>
        </span>
    </div>
    <div class="st-tour-map st-hide">
        <?php
        $lat = get_post_meta(get_the_ID(),'map_lat', true);
        $lng = get_post_meta(get_the_ID(),'map_lng', true);
        $zoom = get_post_meta(get_the_ID(),'map_zoom', true);
        if(empty($zoom)){
            $zoom = 12;
        }

        if(!empty($lat) && !empty($lng)) {
            $location_center = array(
                'lat' => $lat,
                'lng' => $lng,
                'zoom' => $zoom
            );
        }

        $marker_data = array(
            'thumb' => get_the_post_thumbnail_url(get_the_ID(),array(300,200)),
            'title' => get_the_title(),
            'in' => TravelHelper::locationHtml(get_the_ID())
        );
        if(!empty($location_center)){
        ?>
        <div id="st-hotel-mapbox-new" data-style="<?php echo esc_attr($map_style); ?>" data-autoload_map="0" data-marker-data='<?php echo json_encode($marker_data); ?>' data-location='<?php echo json_encode($location_center)?>'></div>
        <div id="mapbox_single_full_map" class="st-full-height" style="width:100%;height:500px"></div>
       </div>
        <?php } ?>
    </div>
</div>
<?php }else{

    $lat = get_post_meta(get_the_ID(),'map_lat', true);
    $lng = get_post_meta(get_the_ID(),'map_lng', true);
    $zoom = get_post_meta(get_the_ID(),'map_zoom', true);
    if(empty($zoom)){
        $zoom = 12;
    }

    if(!empty($lat) && !empty($lng)) {
        $location_center = array(
            'lat' => $lat,
            'lng' => $lng,
            'zoom' => $zoom
        );
    }

    $marker_icon = st()->get_option('st_tours_icon_map_marker', '');

    ?>
    <div class="st-gallery-map st-gallery-half-map st-full-height">
        <div class="st-tour-gallery <?php echo (empty($location_center)?'no-map':'') ?> ">
            <div class="tour-gallery owl-carousel">
                <?php
                foreach ($new_gallery as $key => $val) {
                    $bg = Assets::build_css('background: #ccc url('.esc_url($val).') center no-repeat');
                    ?>
                    <div class="item <?php echo esc_attr($bg); ?> st-full-height">
                    </div>
                <?php } ?>
            </div>
            <div class="caption-star">
                <h4 class="location"><?php echo TravelHelper::locationHtml(get_the_ID()); ?></h4>
                <h1 class="service-title"><?php the_title(); ?></h1>
                <?php
                $count_review = STReview::count_comment(get_the_ID());
                if($count_review > 0){
                ?>
                <div class="st-review-stars">
                    <ul class="review-stars">
                        <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                        ?>
                    </ul>

                    <?php
                    echo esc_attr($count_review); ?>
                    <span><?php echo _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
                </div>
                <?php } ?>
                <span class="price">
                    <?php
                    echo STTour::get_price_html(get_the_ID(),false,'<br>');
                    $type_tour = get_post_meta(get_the_ID(),'type_tour',true);
                    if($type_tour == 'daily_tour'){
                        ?>
                        <span class="unit-tour">
                            <?php
                            echo STTour::get_duration_unit();
                            ?>
                        </span>
                    <?php } ?>
                </span>

            </div>
            <?php
            if(!wp_is_mobile()) {
	            $tour_weather = TravelHelper::get_location_temp();
	            if ( ! empty( $tour_weather ) ) {
		            $temp_format = st()->get_option( 'st_weather_temp_unit', 'c' );
		            ?>
                    <div class="weather">
                        <div class="w-detail">
                            <span class="icon"><?php echo do_shortcode( $tour_weather['icon'] ) ?></span>
                            <span class="temp"><?php echo balanceTags( $tour_weather['temp'] ) ?>
                                <sup>o</sup><span><?php echo esc_attr( $temp_format ); ?></span></span>
                        </div>
                    </div>
		            <?php
	            }
            }
            ?>
            <div class="owl-prev owl-control"><i class="fa fa-angle-left"></i></div>
            <div class="owl-next owl-control"><i class="fa fa-angle-right"></i></div>
        </div>
        <div class="st-tour-map">
            <?php
            if(!empty($location_center)){
                ?>
                <div id="st-hotelhalf-mapbox-new" data-style="<?php echo esc_attr($map_style); ?>" data-autoload_map="1" data-marker-icon='<?php echo esc_url($marker_icon); ?>' data-location='<?php echo json_encode($location_center)?>'></div>
                <div id="mapbox_single_full_maphalf" class="st-full-height" style="width:100%;height:500px"></div>
            <?php } ?>
        </div>
    </div>
<?php
} ?>
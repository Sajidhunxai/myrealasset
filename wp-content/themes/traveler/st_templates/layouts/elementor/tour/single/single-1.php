<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-12-2018
 * Time: 1:55 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
wp_enqueue_script('filter-tour');
while (have_posts()): the_post();
    $post_id = get_the_ID();
    $address = get_post_meta($post_id, 'address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = STReview::count_review($post_id);
    $lat = get_post_meta($post_id, 'map_lat', true);
    $lng = get_post_meta($post_id, 'map_lng', true);
    $zoom = get_post_meta($post_id, 'map_zoom', true);
    $enable_street_views_google_map        = get_post_meta( $post_id, 'enable_street_views_google_map', true );
    
    $marker_icon = st()->get_option('st_tours_icon_map_marker', '');
    $tour_external = get_post_meta(get_the_ID(), 'st_tour_external_booking', true);
    $tour_external_link = get_post_meta(get_the_ID(), 'st_tour_external_booking_link', true);
    $booking_type = st_get_booking_option_type();
    $map_iframe = get_post_meta($post_id,'map_iframe',true);
    $is_iframe = get_post_meta(get_the_ID(), 'is_iframe', true);
    $tour_type = get_post_meta(get_the_ID(), 'type_tour', true);
    
    ?>
    <div id="st-content-wrapper" class="st-single-tour">
        <?php st_breadcrumbs_new() ?>
        <div class="container">
            <div class="st-hotel-content">
                <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                    <div class="price-wrapper">
                        <?php echo wp_kses(sprintf(__('from <span class="price">%s</span>', 'traveler'), STTour::get_price_html(get_the_ID())), ['span' => ['class' => []]]) ?>
                    </div>
                    <?php
                    if ($tour_external == 'off' || empty($tour_external)) {
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
                        <a href="<?php echo esc_url($tour_external_link); ?>"
                        class="btn btn-green"><?php echo esc_html__('Book Now', 'traveler') ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
           
        </div>
         <!-- Feature image -->
        <?php
        $url = get_the_post_thumbnail_url($post_id, 'full');
        ?>
        <div class="tour-featured-image featured-image-background"
            style="background-image: url('<?php echo esc_url($url); ?>')">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <?php echo st()->load_template('layouts/elementor/tour/single/item/gallery-video','',['post_id' => $post_id]); ?>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- End feature image -->


       
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
                            <div class="right d-none d-sm-block">
                                <div class="review-score style-2">
                                    <span class="head-rating"><?php echo TravelHelper::get_rate_review_text($review_rate, $count_review); ?></span>
                                    <?php echo st()->load_template('layouts/elementor/common/star', '', ['star' => $review_rate, 'style' => 'style-2']); ?>
                                    <p class="st-link"><?php comments_number(__('from 0 review', 'traveler'), __('from 1 review', 'traveler'), __('from % reviews', 'traveler')); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tour Infor -->
                        <?php echo st()->load_template('layouts/elementor/tour/single/item/infor', '', array('tour_type' => $tour_type)); ?>
                        <!--Tour Overview-->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/description'); ?>
                        <!--End Tour Overview-->

                        <!--Tour highlight-->

                        <?php
                        $tours_highlight = get_post_meta(get_the_ID(), 'tours_highlight', true);
                        if (!empty($tours_highlight)) {
                            $arr_highlight = explode("\n", trim($tours_highlight));
                            ?>
                            <div class="st-highlight">
                                <h2 class="st-heading-section"><?php echo __('Highlights', 'traveler'); ?></h2>
                                <ul>
                                    <?php
                                    if (!empty($arr_highlight)) {
                                        foreach ($arr_highlight as $k => $v) {
                                            echo '<li>' . esc_html($v) . '</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!--End Tour highlight-->
                        <!--Table Discount group -->
                        <?php echo st()->load_template('layouts/elementor/tour/single/item/discount'); ?>
                        <!--End Table Discount group -->
                        <!--Tour program-->
                        <?php echo st()->load_template('layouts/elementor/tour/single/item/itinerary'); ?>
                        <!--End Tour program-->

                        <!--Tour Include/Exclude-->
                        <?php echo st()->load_template('layouts/elementor/tour/single/item/include-exclude'); ?>
                        <!--End Tour Include/Exclude-->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/attributes','',['post_type' => 'st_tours']);?>
                        <!--Tour Map-->
                        <?php if($is_iframe == 'on'){
                            if(!empty($map_iframe)){ ?>
                                <div class="st-hr large"></div>
                                <div class="st-map-wrapper">
                                    <div class="st-flex space-between">
                                        <h2 class="st-heading-section mg0"><?php echo __('Tour\'s Location', 'traveler') ?></h2>
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
                            <?php } }else{ ?>
                            <div class="st-hr large"></div>
                            <div class="st-map-wrapper">
                                <?php
                                if (!$zoom) {
                                    $zoom = 13;
                                }
                                ?>
                                <div class="st-flex space-between">
                                    <h2 class="st-heading-section mg0"><?php echo __('Tour\'s Location', 'traveler') ?></h2>
                                    <?php if ($address) {
                                        ?>
                                        <div class="c-grey"><?php
                                            echo TravelHelper::getNewIcon('Ico_maps', '#5E6D77', '18px', '18px');
                                            echo esc_html($address); ?></div>
                                        <?php
                                    } ?>
                                </div>
                                <?php
                                $default = apply_filters('st_tour_property_near_by_params', array(
                                    'number'      => '12' ,
                                    'range'       => '100' ,
                                    'show_circle' => 'no' ,
                                ));
                                extract($default);
                                $hotel = new STTour();
                                $location_center  = '[' . $lat . ',' . $lng . ']';
                                $map_lat_center = $lat;
                                $map_lng_center = $lng;

                                $data_map = array();
                                $stt  =  1;
                                global $post;
                                $map_icon = st()->get_option('st_tours_icon_map_marker', '');
                                if (empty($map_icon)){
                                    $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_tours.png';
                                }

                                if (st()->get_option('st_show_tour_nearby') == 'on') {
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
                                    <div class="st-map mt30">
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
                        <?php } ?>
                        <!--End Tour Map-->

                        <!--Tour FAQ-->
                        <?php echo st()->load_template('layouts/elementor/tour/single/item/faq'); ?>
                        <!--End Tour FAQ-->

                        <!--Review Option-->
                        <?php if(comments_open() and st()->get_option( 'activity_tour_review' ) == 'on') {?>
                        <div class="st-hr large st-hr-comment"></div>
                        <h2 class="st-heading-section"><?php echo esc_html__('Reviews', 'traveler') ?></h2>
                        <div id="reviews" data-toggle-section="st-reviews" >
                            <div class="review-box">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="review-box-score">
                                            <?php
                                            $avg = STReview::get_avg_rate();
                                            ?>
                                            <div class="review-score">
                                                <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                                            </div>
                                            <div class="review-score-text"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></div>
                                            <div class="review-score-base">
                                                <?php echo __('Based on', 'traveler') ?>
                                                <span><?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="review-sumary">
                                            <?php $total = get_comments_number(); ?>
                                            <?php $rate_exe = STReview::count_review_by_rate(null, 5); ?>
                                            <div class="item">
                                                <div class="label">
                                                    <?php echo esc_html__('Excellent', 'traveler') ?>
                                                </div>
                                                <div class="progress">
                                                    <div class="percent green"
                                                         style="width: <?php echo TravelHelper::cal_rate($rate_exe, $total) ?>%;"></div>
                                                </div>
                                                <div class="number"><?php echo esc_html($rate_exe); ?></div>
                                            </div>
                                            <?php $rate_good = STReview::count_review_by_rate(null, 4); ?>
                                            <div class="item">
                                                <div class="label">
                                                    <?php echo __('Very Good', 'traveler') ?>
                                                </div>
                                                <div class="progress">
                                                    <div class="percent darkgreen"
                                                         style="width: <?php echo TravelHelper::cal_rate($rate_good, $total) ?>%;"></div>
                                                </div>
                                                <div class="number"><?php echo esc_html($rate_good); ?></div>
                                            </div>
                                            <?php $rate_avg = STReview::count_review_by_rate(null, 3); ?>
                                            <div class="item">
                                                <div class="label">
                                                    <?php echo __('Average', 'traveler') ?>
                                                </div>
                                                <div class="progress">
                                                    <div class="percent yellow"
                                                         style="width: <?php echo TravelHelper::cal_rate($rate_avg, $total) ?>%;"></div>
                                                </div>
                                                <div class="number"><?php echo esc_html($rate_avg); ?></div>
                                            </div>
                                            <?php $rate_poor = STReview::count_review_by_rate(null, 2); ?>
                                            <div class="item">
                                                <div class="label">
                                                    <?php echo __('Poor', 'traveler') ?>
                                                </div>
                                                <div class="progress">
                                                    <div class="percent orange"
                                                         style="width: <?php echo TravelHelper::cal_rate($rate_poor, $total) ?>%;"></div>
                                                </div>
                                                <div class="number"><?php echo esc_html($rate_poor); ?></div>
                                            </div>
                                            <?php $rate_terible = STReview::count_review_by_rate(null, 1); ?>
                                            <div class="item">
                                                <div class="label">
                                                    <?php echo __('Terrible', 'traveler') ?>
                                                </div>
                                                <div class="progress">
                                                    <div class="percent red"
                                                         style="width: <?php echo TravelHelper::cal_rate($rate_terible, $total) ?>%;"></div>
                                                </div>
                                                <div class="number"><?php echo esc_html($rate_terible); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review-pagination">
                                <div class="summary">
                                    <?php
                                    $comments_count = wp_count_comments(get_the_ID());
                                    $total = (int)$comments_count->approved;
                                    $comment_per_page = (int)get_option('comments_per_page', 10);
                                    $paged = (int)STInput::get('comment_page', 1);
                                    $from = $comment_per_page * ($paged - 1) + 1;
                                    $to = ($paged * $comment_per_page < $total) ? ($paged * $comment_per_page) : $total;
                                    ?>
                                </div>
                                <div id="reviews" class="review-list">
                                    <?php
                                    $offset = ($paged - 1) * $comment_per_page;
                                    $args = [
                                        'number' => $comment_per_page,
                                        'offset' => $offset,
                                        'post_id' => get_the_ID(),
                                        'status' => ['approve']
                                    ];
                                    $comments_query = new WP_Comment_Query;
                                    $comments = $comments_query->query($args);

                                    if ($comments):
                                        foreach ($comments as $key => $comment):
                                            echo st()->load_template('layouts/elementor/common/reviews/review', 'list', ['comment' => (object)$comment, 'post_type' => 'st_tours']);
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <div class="review-pag-wrapper">
                                <div class="review-pag-text">
                                    <?php echo sprintf(__('Showing %s - %s of %s in total', 'traveler'), $from, $to, get_comments_number_text('0', '1', '%')) ?>
                                </div>
                                <?php TravelHelper::pagination_comment(['total' => $total]) ?>
                            </div>
                            <?php
                            if (comments_open($post_id)) {
                                ?>
                                <div id="write-review">
                                    <h4 class="heading">
                                        <a href="" class="toggle-section c-main f16"
                                           data-target="st-review-form"><?php echo __('Write a review', 'traveler') ?>
                                            <i class="fa fa-angle-down ml5"></i></a>
                                    </h4>
                                    <?php
                                    TravelHelper::comment_form();
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <!--End Review Option-->
                        <?php }?>
                        <div class="stoped-scroll-section"></div>
                    </div>
                    <div class="col-12 col-sm-3 col-md-3">
                        <?php
                        $info_price = STTour::get_info_price();
                        ?>
                        <div class="widgets">
                            <div class="fixed-on-mobile" id="booking-request" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
                                </div>

                                <?php
                                    if($booking_type == 'instant_enquire'){
                                        echo st()->load_template('layouts/elementor/tour/single/item/form-booking','instant-inquiry',
                                        [
                                            'info_price' =>$info_price,
                                            'tour_external' => $tour_external,
                                            'tour_external_link' => $tour_external_link,
                                            'tour_type' => $tour_type,
                                        ]);
                                    }else{
                                        if($booking_type == 'enquire'){
                                            echo st()->load_template('layouts/elementor/tour/single/item/form-booking','inquiry',
                                            [
                                                'info_price' => $info_price,
                                                'tour_external' => $tour_external,
                                                'tour_external_link' => $tour_external_link,
                                                'tour_type' => $tour_type,
                                            ]);
                                        }else{
                                            echo st()->load_template('layouts/elementor/tour/single/item/form-booking','instant',
                                            [
                                                'info_price' =>$info_price,
                                                'tour_external' => $tour_external,
                                                'tour_external_link' => $tour_external_link,
                                                'tour_type' => $tour_type,
                                            ]);
                                        }
                                    }
                                ?>
                                <?php
                                $allow_partner = st()->get_option('setting_partner','off');
                                $tour_information_contact = st()->get_option('tour_information_contact','off');
                                if($allow_partner == 'on'){
                                    ?>
                                <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info'); ?>
                                <?php } 
                                echo st()->load_template('layouts/modern/common/single/information-contact');
                                ?>
                                 
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $search_tax_advance = st()->get_option( 'attribute_search_form_tour', 'st_tour_type' );
                $terms_posts = wp_get_post_terms(get_the_ID(),$search_tax_advance);
                $arr_id_term_post = array();
                foreach($terms_posts as $term_post){
                    if(!empty($term_post->term_id)){
                        $arr_id_term_post[] = $term_post->term_id;
                    }
                }
                $args = [
                    'posts_per_page' => 4,
                    'post_type' => 'st_tours',
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
                            echo st()->load_template('layouts/elementor/tour/loop/normal-grid', '',array('item_row'=> 4));
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

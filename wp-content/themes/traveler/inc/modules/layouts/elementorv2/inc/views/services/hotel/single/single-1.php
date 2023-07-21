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
    ?>
    <div id="st-content-wrapper" class="st-style-elementor st-style-4 singe-hotel-layout-<?php echo esc_attr($style_single);?>">
        <?php
        echo stt_elementorv2()->loadView('components/banner');?>
        <div class="container-fluid">
            <?php echo stt_elementorv2()->loadView('services/common/single/gallery',array('style'=> 'grid')) ?>
        </div>
        <div class="container st-single-service-content">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8">
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
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/top-infor', array(
                    'hotel_star'=> $hotel_star ,
                    'address'=> $address,
                    'review_rate' => $review_rate,
                    'count_review' => $count_review,
                    )) ?>
                    <div class="st-hr"></div>
                    <?php echo stt_elementorv2()->loadView('services/common/single/description') ?>
                    <div id="st-attributes">
                        <?php echo stt_elementorv2()->loadView('services/common/single/attributes',['post_type' => 'st_hotel']) ?>
                    </div>
                    
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/rules',['post_id' => $post_id]); ?>
                    
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/list-room',['post_id' => $post_id]); ?>
                    <?php echo stt_elementorv2()->loadView('services/hotel/single/item/review',['post_id' => $post_id]); ?>
                    <div class="stoped-scroll-section"></div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                    <div class="widgets sticky-top">
                        <div class="fixed-on-mobile st-fixed-form-booking" data-screen="992px">
                            
                            <?php echo stt_elementorv2()->loadView('services/hotel/single/item/form-book',['price' => $price, 'post_id' => $post_id]); ?>
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
        
        <!-- End Modal Map Popup -->
    </div>
    
<?php endwhile;

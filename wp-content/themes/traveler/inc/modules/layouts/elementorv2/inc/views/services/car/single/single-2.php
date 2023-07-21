<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-11-2018
 * Time: 8:47 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
wp_enqueue_script('filter-car');
while (have_posts()): the_post();
    $post_id = get_the_ID();
    $address = get_post_meta($post_id, 'cars_address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = STReview::count_review($post_id);
    
    $car_external = get_post_meta(get_the_ID(), 'st_car_external_booking', true);
    $car_external_link = get_post_meta(get_the_ID(), 'st_car_external_booking_link', true);
    $booking_type = st_get_booking_option_type();

    $pickup_date = STInput::get('pick-up-date');
    $dropoff_date = STInput::get('drop-off-date');

    $pickup_date = TravelHelper::convertDateFormat($pickup_date);
    $dropoff_date = TravelHelper::convertDateFormat($dropoff_date);

    $pick_up_time = STInput::get('pick-up-time', '12:00 PM');
    $drop_off_time = STInput::get('drop-off-time', '12:00 PM');

    $info_price = STCars::get_info_price(get_the_ID(), strtotime($pickup_date), strtotime($dropoff_date));
    $cars_price = $info_price['price'];

    
    ?>
    <div id="st-content-wrapper" class="st-style-4 st-style-elementor st-single-tour st-single-car-<?php echo esc_attr($style_single);?>">
        <?php
        echo stt_elementorv2()->loadView('components/banner');
        ?>
        <div class="container-fluid">
            <?php echo stt_elementorv2()->loadView('services/common/single/gallery-2', array('style' => 'slider')) ?>
        </div>
        <div class="container st-single-service-content">
            <?php echo stt_elementorv2()->loadView('services/car/single/item/top-infor', array(
                'address'=> $address,
                'review_rate' => $review_rate,
                'count_review' => $count_review,
            )) ?>
        </div>
        <div class="container st-single-service-content">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="st-hotel-content">
                        <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                            <div class="price-wrapper">
                                <div id="mobile-price">
                                <?php echo wp_kses(sprintf(__('From:<span class="price">%s</span><span class="unit">/%s</span>', 'traveler'), TravelHelper::format_money($cars_price), strtolower(STCars::get_price_unit('label'))), ['span' => ['class' => []]]) ?>
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
                            <?php 
                                if ($car_external == 'off' || empty($car_external)) {
                                    ?>
                                    <a href=""
                                        class="btn-v2 btn-primary btn-mpopup btn-green"><?php echo esc_html__('Book Now', 'traveler') ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo esc_url($car_external_link); ?>"
                                    class="btn-v2 btn btn-green"><?php echo esc_html__('Check', 'traveler') ?></a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <?php echo stt_elementorv2()->loadView('services/car/single/item/infor'); ?>
                    <div class="st-hr"></div>
                    <?php echo stt_elementorv2()->loadView('services/common/single/description') ?>
                    <div id="st-attributes">
                        <?php echo stt_elementorv2()->loadView('services/common/single/attributes',['post_type' => 'st_cars']) ?>
                    </div>
                    <?php echo stt_elementorv2()->loadView('services/car/single/item/location',['post_id'=>$post_id]) ?>


                    
                    <?php echo stt_elementorv2()->loadView('services/car/single/item/review',['post_id' => $post_id]); ?>
                    <div class="stoped-scroll-section"></div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="widgets sticky-top">
                        <div class="fixed-on-mobile st-fixed-form-booking" data-screen="992px">
                            <div class="close-icon hide">
                                <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
                            </div>

                            <?php
                                echo stt_elementorv2()->loadView('services/car/single/item/form-book', [
                                    'info_price' =>$info_price,
                                    'car_external' => $car_external,
                                    'car_external_link' => $car_external_link,
                                    'booking_type' => $booking_type,
                                    'review_rate' => $review_rate,
                                ]);
                            ?>
                            <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info','',array('size_avatar_custom' => 90)); ?>

                            <?php echo st()->load_template('layouts/modern/common/single/information-contact'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo stt_elementorv2()->loadView('services/car/single/item/relate',['post_id' => $post_id]) ?>
        </div>
    </div>
    
<?php endwhile;

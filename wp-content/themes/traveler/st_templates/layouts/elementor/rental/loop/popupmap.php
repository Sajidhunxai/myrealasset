<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/28/2019
 * Time: 1:46 PM
 */
$url=st_get_link_with_search(get_permalink(),array('start','end','date','adult_number','child_number'),$_GET);
$start = STInput::get('start');
$end = STInput::get('end');
$start = TravelHelper::convertDateFormat($start);
$end = TravelHelper::convertDateFormat($end);
$price = STPrice::getSalePrice(get_the_ID(), strtotime($start), strtotime($end));
$price = !empty($price['total_price']) ? floatval($price['total_price']) : 0;
$numberday = STDate::dateDiff($start, $end);
if ( $numberday == 0 ) $numberday = 1;
$price = $price*$numberday;
$min_price = get_post_meta( get_the_ID(), 'min_price',true);
$min_price = floatval($min_price)*$numberday;
?>
<div class="item item-service item-service-inner st-border-radius" itemscope itemtype="https://schema.org/RentAction">
    <div class="row align-content-around flex-wrap item-service-wrapper">
        <div class="col-sm-4">
            <div class="featured-image">
                <?php if (is_user_logged_in()) { ?>
                    <?php $data = STUser_f::get_icon_wishlist(); ?>
                    <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                         data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>"
                         title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                <?php } else { ?>
                    <a href="" class="login" data-bs-toggle="modal" data-target="#st-login-form">
                        <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                            <i class="fa fa-heart"></i>
                            <div class="lds-dual-ring"></div>
                        </div>
                    </a>
                <?php } ?>
                <div class="service-tag bestseller">
                    <?php echo STFeatured::get_featured(); ?>
                </div>
                <a href="<?php echo esc_url($url) ?>">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive', 'itemprop'=>"photo"));
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/img/no-image.png' . '" alt="Default Thumbnail" class="img-responsive" />';
                    }
                    ?>
                </a>
                <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); 
                ?>
                <ul class="icon-group d-block d-sm-none d-md-none text-color booking-item-rating-stars">
                    <?php
                    $avg = STReview::get_avg_rate();
                    echo TravelHelper::rate_to_string($avg);
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-5 item-content">
            <div class="h-100 d-flex align-items-center">
                <div class="item-content-w">
                    <ul class="icon-group d-none d-sm-block d-md-block text-color booking-item-rating-stars">
                        <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                        ?>
                    </ul>
                    <h4 class="service-title" itemprop="name">
                        <a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a>
                    </h4>
                    <div class="amenities clearfix">
                        <span class="amenity total" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. People', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_people_1', '','22px', '22px', false); ?><?php echo (int)get_post_meta(get_the_ID(), 'rental_max_adult', true) + (int)get_post_meta(get_the_ID(), 'rental_max_children', true); ?></span>
                        <span class="amenity bed" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bed', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_bed_1', '','20px', '22px', false); ?><?php echo (int)get_post_meta(get_the_ID(), 'rental_bed', true) ?></span>
                        <span class="amenity bath" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bathroom', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_bathroom_1' ,'','22px', '22px', false); ?><?php echo (int)get_post_meta(get_the_ID(), 'rental_bath', true) ?></span>
                        <span class="amenity size" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Square', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_square_1', '', '21px', '21px', false); ?><?php echo (int)get_post_meta(get_the_ID(), 'rental_size', true); ?><?php echo __('m<sup>2</sup>', 'traveler');?></span>
                    </div>
                    <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
                        <p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3 section-footer">
            <div class="h-100 footer-flex d-flex align-content-between flex-wrap">
                <div class="reviews d-none d-sm-flex d-md-flex" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                    <?php
                    $count_review = STReview::count_comment(get_the_ID());
                    $avg = STReview::get_avg_rate();
                    ?>
                    <div class="count-review">
                        <span class="text-rating"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                        <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                    </div>
                    <span class="rating" itemprop="ratingValue"><?php echo esc_html($avg); ?><small>/5</small></span>
                </div>
                <div class="reviews d-block d-sm-none d-md-none">
                    <?php
                    $count_review = STReview::count_comment(get_the_ID());
                    $avg = STReview::get_avg_rate();
                    ?>
                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                    <span class="st-dot"></span>
                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                </div>
                <div class="price-wrapper  d-flex align-items-center" itemprop="priceRange">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                        <?php _e("From", 'traveler') ?>
                    </span>
                    <span class="price">
                        <?php
                        echo TravelHelper::format_money($min_price);
                        ?>
                    </span>
                    <span class="unit"><?php echo sprintf( __('/ %d night(s)', 'traveler'), $numberday ); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
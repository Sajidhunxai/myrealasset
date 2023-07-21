<?php
global $post;
$url=st_get_link_with_search(get_permalink(),array('start','end','date','adult_number','child_number'),$_GET);
$start = STInput::get('start');
$end = STInput::get('end');
$start = TravelHelper::convertDateFormat($start);
$end = TravelHelper::convertDateFormat($end);
$price = STRental::get_price(get_the_ID());
$min_price = get_post_meta( get_the_ID(), 'min_price',true);
$numberday = STDate::dateDiff($start, $end);
if ( $numberday == 0 ) $numberday = 1;
$price = $price*$numberday;
$min_price = floatval($min_price)*$numberday;
$class = 'col-lg-12 item item-rental';
if($show_map == 'no'){
	$class = ' col-12 col-sm-12 col-md-6 col-lg-6  item item-rental';
}
?>
<div class="<?php echo esc_attr($class); ?>" itemscope itemtype="https://schema.org/RentAction">
    <div class="item-service-inner item st-border-radius">
        <div class="row align-content-around flex-wrap item-service-wrapper">
            <div class="col-lg-6 col-md-12 col-sm-6">
                <div class="featured-image">
                    <?php if (is_user_logged_in()) { ?>
                        <?php $data = STUser_f::get_icon_wishlist(); ?>
                        <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                             data-id="<?php echo get_the_ID(); ?>"
                             data-type="<?php echo get_post_type(get_the_ID()); ?>"
                             title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                            <i class="fa fa-heart"></i>
                            <div class="lds-dual-ring"></div>
                        </div>
                    <?php } else { ?>
                        <a href="" class="login" data-bs-toggle="modal" data-target="#st-login-form">
                            <div class="service-add-wishlist"
                                 title="<?php echo __('Add to wishlist', 'traveler'); ?>">
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
                            the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive','itemprop'=>"photo"));
                        } else {
                            echo '<img src="' . get_template_directory_uri() . '/img/no-image.png' . '" alt="Default Thumbnail" class="img-responsive" />';
                        }
                        ?>
                    </a>
                    <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
                    <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
                    <ul class="icon-group text-color booking-item-rating-stars d-block d-sm-none d-md-none">
                        <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-6 item-content">
                <ul class="icon-group text-color booking-item-rating-stars d-none d-sm-block">
                    <?php
                    $avg = STReview::get_avg_rate();
                    echo TravelHelper::rate_to_string($avg);
                    ?>
                </ul>
                <h4 class="service-title" itemprop="name"><a
                            href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>
                <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
                    <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
                <?php endif; ?>
                <div class="service-review" itemscope itemtype="https://schema.org/Rating">
                    <?php
                    $count_review = STReview::count_comment(get_the_ID());
                    $avg = STReview::get_avg_rate();
                    ?>
                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                    <span class="st-dot"></span>
                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                </div>
                <div class="service-price" itemprop="priceRange">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                        <?php _e("From", 'traveler') ?>
                    </span>
                    <span class="price">
                        <?php
                        echo TravelHelper::format_money($min_price);
                        ?>
                    </span>
                    <span><?php echo sprintf(__('/ %d night(s)', 'traveler'), $numberday ); ?></span>
                </div>
            </div>
            <div class="section-footer">
                <div class="service-review d-block d-sm-none d-md-none" itemscope itemtype="https://schema.org/Rating">
                    <?php
                    $count_review = STReview::count_comment(get_the_ID());
                    $avg = STReview::get_avg_rate();
                    ?>
                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                    <span class="st-dot"></span>
                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                </div>
                <div class="service-price d-block d-sm-none d-md-none" itemprop="priceRange">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                            <?php _e("From", 'traveler') ?>
                    </span>
                    <span class="price">
                        <?php
                        echo TravelHelper::format_money($min_price);
                        ?>
                    </span>
                    <span><?php echo sprintf( __('/ %d night(s)', 'traveler'), $numberday ); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

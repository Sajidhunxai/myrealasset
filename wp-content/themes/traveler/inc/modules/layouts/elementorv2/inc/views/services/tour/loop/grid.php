<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$duration = get_post_meta( get_the_ID(), 'duration_day', true );
$info_price = STTour::get_info_price();
$address = get_post_meta($post_translated, 'address', true);



$review_rate = STReview::get_avg_rate();
$price = STTour::get_info_price();
$count_review = get_comment_count($post_translated)['approved'];
$class_image = 'image-feature st-hover-grow';
$url=st_get_link_with_search(get_permalink($post_translated),array('start','end','date','adult_number','child_number'),$_GET);
?>
<div class="services-item grid item-elementor" itemscope itemtype="https://schema.org/Trip">
    <div class="item service-border st-border-radius">
        <div class="featured-image">
            <div class="st-tag-feature-sale">
                
                <?php
                $is_featured = get_post_meta($post_translated, 'is_featured', true);
                if ($is_featured == 'on') { ?>
                    <div class="featured">
                        <?php 
                            if(!empty(st()->get_option('st_text_featured', ''))){
                                echo esc_html(st()->get_option('st_text_featured', ''));
                            } else {?>
                                <?php echo esc_html__('Featured', 'traveler') ?>
                            <?php }
                        ?>
                    </div>
                <?php } ?>
                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                <?php } ?>
            </div>
            <?php if (is_user_logged_in()) { ?>
                <?php $data = STUser_f::get_icon_wishlist(); ?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                     data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>"
                     title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <?php echo TravelHelper::getNewIconV2('wishlist');?>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php } else { ?>
                <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <?php echo TravelHelper::getNewIconV2('wishlist');?>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="image" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?>"/>
            </a>
            <?php do_action('st_list_compare_button', get_the_ID(), get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <div class="content-item">
            <?php if ($address) { ?>
                <div class="sub-title st-address d-flex align-items-center" itemprop="itinerary" itemscope itemtype="https://schema.org/ItemList">
                     
                    <span itemprop="streetAddress"> <i class="stt-icon-location1"></i> <?php echo esc_html($address); ?></span>
                </div>
            <?php } ?>
            <h3 class="title" itemprop="name">
                <a href="<?php echo esc_url($url); ?>"
                   class="c-main"><?php echo get_the_title($post_translated) ?></a>
            </h3>
            <div class="reviews">
                <i class="stt-icon-star1"></i>
                <span class="rate" itemprop="ratingValue">
                    <?php echo esc_html($review_rate); ?>
                </span>
                <span class="summary">
                    (<?php comments_number(esc_html__('No Review', 'traveler'), esc_html__('1 Review', 'traveler'), get_comments_number() . ' ' . esc_html__('Reviews', 'traveler')); ?>)
                </span>
            </div>
            <div class="section-footer">
                <div class="price-wrapper price-wrapper-tour d-flex align-items-end justify-content-between">
                    <span class="price-tour">
                        <span class="price d-flex justify-content-around flex-column"><?php echo STTour::get_price_html(get_the_ID(),false, '',  'sale-top', false); ?></span>
                    </span>
                    <span class="unit"><?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '16px', '16px'); ?><?php echo esc_html($duration); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


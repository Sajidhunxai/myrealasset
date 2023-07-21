<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$hotel_star = (int)get_post_meta($post_translated, 'hotel_star', true);
$address = get_post_meta($post_translated, 'address', true);
$review_rate = STReview::get_avg_rate();
$price = STHotel::get_price();
$count_review = get_comment_count($post_translated)['approved'];
$class_image = 'image-feature';
$url=st_get_link_with_search(get_permalink($post_translated),array('start','end','date','adult_number','child_number'),$_GET);
$phone_number = get_post_meta($post_translated,'phone',true);
?>
<div class="services-item grid item-elementor" itemscope itemtype="https://schema.org/Hotel" data-id="<?php echo esc_attr($post_id); ?>">
    <div class="item service-border st-border-radius">
        <div class="featured-image">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 7.68998C0.75 4.18927 3.57229 1.34998 7.06 1.34998C8.79674 1.34998 10.3646 2.05596 11.5003 3.19469C12.6385 2.05561 14.2122 1.34998 15.94 1.34998C19.4277 1.34998 22.25 4.18927 22.25 7.68998C22.25 11.4395 20.5107 14.4001 18.4342 16.5276C16.3683 18.6443 13.9235 19.9861 12.3657 20.5186C12.0914 20.6147 11.7773 20.65 11.5 20.65C11.2227 20.65 10.9086 20.6147 10.6343 20.5186C9.07655 19.9861 6.63169 18.6443 4.56577 16.5276C2.48932 14.4001 0.75 11.4395 0.75 7.68998Z" fill="#232323" fill-opacity="0.3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?> st-hover-grow"/>
                <img itemprop="image" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="d-none"/>
            </a>
            <?php 
                if(!empty($phone_number)){?>
                    <span class="d-none" itemprop="telephone"><?php echo esc_html($phone_number);?></span>
                <?php }
            ?>
            <?php do_action('st_list_compare_button', get_the_ID(), get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <div class="content-item">
            <div class="content-inner has-matchHeight">
                <?php echo stt_elementorv2()->loadView('components/star', ['star' => $hotel_star]); ?>
                <h3 class="title" itemprop="name">
                    <a href="<?php echo esc_url($url); ?>"
                       class="c-main"><?php echo get_the_title($post_translated) ?></a>
                </h3>
                <?php if ($address) { ?>
                    <div class="sub-title d-flex align-items-center" itemprop="address" itemscope
                         itemtype="https://schema.org/PostalAddress">
                        <span itemprop="streetAddress"><?php echo esc_html($address); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="section-footer">
                
                <div class="reviews" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                    <span class="rate" itemprop="ratingValue">
                        <?php echo esc_html($review_rate); ?> <span>/</span> 5
                    </span>
                    <span class="rate-text">
                        <?php echo TravelHelper::get_rate_review_text($review_rate, $count_review); ?>
                    </span>
                    <span class="summary">
                        (<?php comments_number(esc_html__('No Review', 'traveler'), esc_html__('1 Review', 'traveler'), get_comments_number() . ' ' . esc_html__('Reviews', 'traveler')); ?>)
                    </span>
                </div>
                <div class="price-wrapper d-flex align-items-center" itemprop="priceRange">
                    <?php echo esc_html__('From:', 'traveler'); ?>
                    <span class="price"><?php echo TravelHelper::format_money($price) ?></span>
                    <span class="unit"><?php echo esc_html__('/ night', 'traveler') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


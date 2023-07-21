<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$address = get_post_meta($post_translated, 'address', true);
$review_rate = STReview::get_avg_rate();
$start = STInput::get('start');
$end = STInput::get('end');
$start = TravelHelper::convertDateFormat($start);
$end = TravelHelper::convertDateFormat($end);
$numberday = (STDate::dateDiff($start, $end) == 0) ? 1 : STDate::dateDiff($start, $end) ;
$price = STPrice::getSalePrice(get_the_ID(), strtotime($start), strtotime($end));
$price = !empty($price['total_price']) ? floatval($price['total_price']) : 0;
$price = $price*$numberday;
$min_price = get_post_meta(get_the_ID(), 'min_price',true);
$min_price = floatval($min_price)*$numberday;
$count_review = get_comment_count($post_translated)['approved'];
$class_image = 'image-feature';
$url=st_get_link_with_search(get_permalink($post_translated),array('start','end','date','adult_number','child_number'),$_GET);
?>
<div class="services-item list list-2 item-elementor" itemscope itemtype="https://schema.org/RentAction" data-id="<?php echo esc_attr($post_id);?>">
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
                        <?php echo TravelHelper::getNewIconV2('wishlist');?>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?> st-hover-grow"/>
            </a>
            <?php do_action('st_list_compare_button', get_the_ID(), get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service( get_the_ID(), 70 ) ?>
        </div>
        <div class="content-item">
            <div class="content-item-left">
                <h3 class="title" itemprop="name">
                    <a href="<?php echo esc_url($url); ?>"
                       class="c-main"><?php echo get_the_title($post_translated) ?></a>
                </h3>
                <?php if ($address) { ?>
                    <div class="sub-title d-flex align-items-center address" itemprop="address" itemscope
                         itemtype="https://schema.org/PostalAddress">
                        <span class="stt-icon stt-icon-location1"></span>
                        <span itemprop="streetAddress"><?php echo esc_html($address); ?></span>
                    </div>
                <?php } ?>
                <div class="amenities d-flex align-items-center clearfix">
                    <span class="amenity d-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. People', 'traveler') ?>">
                        <span class="stt-icon-user2"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_max_adult', true) + (int)get_post_meta(get_the_ID(), 'rental_max_children', true); ?>
                    </span>
                    <span class="amenity d-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bed', 'traveler') ?>">
                        <span class="stt-icon-bed"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_bed', true) ?>
                    </span>
                    <span class="amenity d-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bathroom', 'traveler') ?>">
                        <span class="stt-icon-bathtub"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_bath', true) ?>
                    </span>
                    <span class="amenity d-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Square', 'traveler') ?>">
                    <span class="stt-icon-area"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_size', true); ?><?php echo __('m<sup>2</sup>', 'traveler');?>
                    </span>
                </div>


            </div>
            <div class="content-item-right">
                <div class="reviews style-2" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
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
                    <span class="price-tour">
                        <span class="price d-flex justify-content-around flex-column">
                            <?php 
                                if( !empty($min_price) && ($price != $min_price)){
                                    echo '<p class="text-small text-decoration-line-through lh1em item onsale ">'.esc_html(TravelHelper::format_money($min_price)).'</p>';
                                }
                            ?>
                            <span class="sale-top"><?php echo __('From ', 'traveler');?> 
                                <span class="text-lg lh1em price item "> <?php echo TravelHelper::format_money($price);?></span>
                                <?php echo wp_kses(sprintf(__('<span class="unit">/ %d night(s)</span>', 'traveler'), $numberday), ['span' => ['class' => []]]) ?>
                            </span>
                        </span>
                    </span>
                </div>

                <a href="<?php echo esc_url($url); ?>" class="view-detail"><?php echo esc_html__('View details', 'traveler'); ?></a>
            </div>
        </div>
    </div>
</div>


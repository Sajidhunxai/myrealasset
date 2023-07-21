<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);

$price = get_post_meta(get_the_ID(), 'price', true);
$class_image = 'image-feature';
$count_review = STReview::count_comment(get_the_ID());
$review_rate = STReview::get_avg_rate();
$url = get_the_permalink();
?>
<div class="services-item list item-elementor" itemscope itemtype="https://schema.org/Room" data-id="<?php echo esc_attr($post_id); ?>">
    <div class="item service-border st-border-radius">
        <div class="featured-image">
            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>" alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?> st-hover-grow" />
            </a>
        </div>
        <div class="content-item">
            <div class="price-wrapper d-flex align-items-center" itemprop="priceRange">
                <span class="price"><?php echo TravelHelper::format_money($price) ?></span>
                <span class="unit"><?php echo esc_html__('/ night', 'traveler-layout-essential') ?></span>
            </div>
            <h3 class="title" itemprop="name">
                <a href="<?php echo esc_url($url); ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a>
            </h3>
            <div class="descrition">
                <?php the_excerpt() ?>
            </div>
            <div class="reviews" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                <span class="rate" itemprop="ratingValue">
                    <?php echo esc_html($review_rate); ?>/5
                </span>
                <span class="rate-text">
                    <?php echo TravelHelper::get_rate_review_text($review_rate, $count_review); ?>
                </span>
                <span class="summary">
                    . <?php comments_number(esc_html__('No Review', 'traveler-layout-essential'), esc_html__('1 Review', 'traveler-layout-essential'), get_comments_number() . ' ' . esc_html__('Reviews', 'traveler-layout-essential')); ?>
                </span>
            </div>
            <div class="section-footer">
                <div class="room-featured-items">
                    <div class="item" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Beds', 'traveler') ?>">
                        <span class="stt-icon stt-icon-bed"></span>
                        <?php echo get_post_meta(get_the_ID(), 'bed_number', true) ?>
                    </div>
                    <div class="item" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Adults', 'traveler') ?>">
                        <span class="stt-icon stt-icon-adult"></span>
                        <?php echo get_post_meta(get_the_ID(), 'adult_number', true) ?>
                    </div>
                    <div class="item" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Children', 'traveler') ?>">
                        <span class="stt-icon stt-icon-baby"></span>
                        <?php echo  get_post_meta(get_the_ID(), 'children_number', true) ?>
                    </div>
                    <div class="item" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('Room Footage', 'traveler') ?>">
                        <span class="stt-icon stt-icon-area"></span>
                        <?php echo get_post_meta(get_the_ID(), 'room_footage', true) ?><?php echo __('m', 'traveler-layout-essential') ?>
                        <sup>2</sup>
                    </div>
                </div>
                <a href="<?php echo esc_url($url); ?>" class="btn btn-primary btn-search st-button-main" target="_blank"><?php echo __('Room detail', 'traveler-layout-essential'); ?></a>
            </div>
        </div>
    </div>
</div>
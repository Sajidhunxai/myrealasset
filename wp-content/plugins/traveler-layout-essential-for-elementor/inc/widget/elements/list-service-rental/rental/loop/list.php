<?php
$post_id      = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$start = STInput::get('start', date(TravelHelper::getDateFormat()));
$end = STInput::get('end', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));
$start = TravelHelper::convertDateFormat($start);
$end = TravelHelper::convertDateFormat($end);
$price = STPrice::getSalePrice(get_the_ID(), strtotime($start), strtotime($end));
$numberday = (STDate::dateDiff($start, $end) == 0) ? 1 : STDate::dateDiff($start, $end);
$class_image = 'image-feature st-hover-grow';
$address = get_post_meta($post_translated, 'address', true);
$count_review = STReview::count_comment(get_the_ID());
$review_rate = STReview::get_avg_rate();
$url = st_get_link_with_search(get_permalink(), array('start', 'end', 'date', 'adult_number', 'child_number'), $_GET);
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
                    <div class="item" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. People', 'traveler') ?>">
                        <span class="stt-icon-user2"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_max_adult', true) + (int)get_post_meta(get_the_ID(), 'rental_max_children', true); ?>
                    </div>
                    <div class="item" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bed', 'traveler') ?>">
                        <span class="stt-icon-bed"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_bed', true) ?>
                    </div>
                    <div class="item" data-bs-toggle="tooltip" title="<?php echo esc_attr__('No. Bathroom', 'traveler') ?>">
                        <span class="stt-icon-bathtub"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_bath', true) ?>
                    </div>
                    <div class="item" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Square', 'traveler') ?>">
                        <span class="stt-icon-area"></span>
                        <?php echo (int)get_post_meta(get_the_ID(), 'rental_size', true); ?><?php echo __('m<sup>2</sup>', 'traveler'); ?>
                    </div>
                </div>
                <a href="<?php echo esc_url($url); ?>" class="btn btn-primary btn-search st-button-main" target="_blank"><?php echo __('Room detail', 'traveler-layout-essential'); ?></a>
            </div>
        </div>
    </div>
</div>
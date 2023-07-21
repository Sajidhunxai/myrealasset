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
$review_rate = STReview::get_avg_rate();
$url = st_get_link_with_search(get_permalink(), array('start', 'end', 'date', 'adult_number', 'child_number'), $_GET);
?>
<div class="services-item grid item-elementor" itemscope itemtype="https://schema.org/RentAction" data-id="<?php echo esc_attr($post_id); ?>">
    <div class="item service-border st-border-radius">
        <div class="featured-image">

            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>" alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?> st-hover-grow" />
            </a>
            <div class="price-wrapper d-flex align-items-center" itemprop="priceRange">
                <span class="price"><?php echo TravelHelper::format_money($price) ?> </span>
                <span class="unit"><?php echo esc_html__('/ night', 'traveler-layout-essential') ?></span>
            </div>
        </div>
        <div class="content-item">
            <div class="content-inner has-matchHeight">

                <h3 class="title" itemprop="name">
                    <a href="<?php echo esc_url($url); ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a>
                </h3>

                <div class="descrition">
                    <?php the_excerpt() ?>
                </div>
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

            </div>
        </div>
    </div>
</div>
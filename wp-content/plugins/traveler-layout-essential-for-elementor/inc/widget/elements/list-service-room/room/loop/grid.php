<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$price = get_post_meta(get_the_ID(), 'price', true);
$class_image = 'image-feature';
$url = get_the_permalink();
?>
<div class="services-item grid item-elementor" itemscope itemtype="https://schema.org/Room" data-id="<?php echo esc_attr($post_id); ?>">
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

            </div>
        </div>
    </div>
</div>
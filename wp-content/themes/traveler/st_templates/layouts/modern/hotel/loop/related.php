<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 14-11-2018
     * Time: 8:16 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    $post_id      = get_the_ID();
    $post_translated = TravelHelper::post_translated($post_id);
    $thumbnail_id = get_post_thumbnail_id($post_translated);
    $hotel_star   = (int)get_post_meta( $post_translated, 'hotel_star', true );
    $price        = STHotel::get_price();
?>
<div class="item">
    <div class="thumb">
        <a href="<?php echo get_the_permalink($post_translated); ?>">
            <img src="<?php echo wp_get_attachment_image_url( $thumbnail_id, array(80, 80) ); ?>" alt="<?php echo TravelHelper::get_alt_image($thumbnail_id); ?>"
                 class="img-responsive img-full">
        </a>
    </div>
    <div class="content">
        <?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $hotel_star ] ); ?>
        <h3 class="title"><a href="<?php echo get_the_permalink($post_translated) ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a></h3>
        <div class="price-wrapper">
            <?php echo __('from', 'traveler'); ?> <span class="price"><?php echo TravelHelper::format_money( $price ) ?></span>
            <!--<span class="unit"><?php /*echo __( '/night', 'traveler' ) */?></span>-->
        </div>
    </div>
</div>

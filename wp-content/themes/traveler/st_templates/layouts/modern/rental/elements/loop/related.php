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
    $post_id = TravelHelper::post_translated($post_id);
    $thumbnail_id = get_post_thumbnail_id($post_id);
    $start = STInput::get('start');
    $url=st_get_link_with_search(get_permalink($post_id),array('start','end','date','adult_number','child_number'),$_GET);
    $end = STInput::get('end');
    $start = TravelHelper::convertDateFormat($start);
    $end = TravelHelper::convertDateFormat($end);
    $price = STRental::get_price(get_the_ID());
    $numberday = (STDate::dateDiff($start, $end) == 0) ? 1 : STDate::dateDiff($start, $end) ;
    $price = $price*$numberday;
    $min_price = get_post_meta( get_the_ID(), 'min_price',true);
    $min_price = floatval($min_price)*$numberday;   
?>
<div class="item">
    <div class="thumb">
        <a href="<?php echo esc_url($url); ?>">
            <img src="<?php echo wp_get_attachment_image_url( $thumbnail_id, array(80, 80) ); ?>" alt="<?php echo TravelHelper::get_alt_image($thumbnail_id); ?>"
                 class="img-responsive img-full">
        </a>
    </div>
    <div class="content">
        <h3 class="title"><a href="<?php echo esc_url($url); ?>" class="st-link c-main"><?php the_title() ?></a></h3>
        <div class="price-wrapper">
            <span class="sale-top">
                <?php echo __('From ', 'traveler');?>
            </span>
            <?php echo wp_kses(sprintf(__('<span class="price">%s</span><span class="unit">/ %d night(s)</span>', 'traveler'), TravelHelper::format_money($min_price), $numberday), ['span' => ['class' => []]]) ?>
        </div>
    </div>
</div>

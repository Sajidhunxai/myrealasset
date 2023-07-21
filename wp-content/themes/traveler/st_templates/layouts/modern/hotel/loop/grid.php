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
    $address      = get_post_meta( $post_translated, 'address', true );
    $review_rate  = STReview::get_avg_rate();
    $price        = STHotel::get_price();
    $count_review = get_comment_count($post_translated)['approved'];
    $class='col-xs-12 col-sm-6 col-md-3';
if(isset($slider) and $slider)
    $class = '';
?>

<div class="<?php echo esc_attr($class); ?>">
    <div class="item has-matchHeight">
        <div class="thumb featured-image">
            <?php
                $is_featured = get_post_meta( $post_translated, 'is_featured', true );
                if ( $is_featured == 'on' ) {
                    ?>
                    <div class="featured"><?php echo esc_html__( 'Bestseller', 'traveler' ) ?></div>
                    <?php
                }
            ?>
            <?php if (is_user_logged_in()) { ?>
                <?php $data = STUser_f::get_icon_wishlist(); ?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                    data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>"
                    title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php } else { ?>
                <a href="#" class="login" data-toggle="modal" data-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo get_the_permalink($post_translated); ?>">
                <img src="<?php echo wp_get_attachment_image_url( $thumbnail_id, array(450, 417) ); ?>" alt=""
                     class="img-responsive img-full">
            </a>
            <?php echo st()->load_template( 'layouts/modern/common/star', '', [ 'star' => $hotel_star ] ); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <h3 class="title"><a href="<?php echo get_the_permalink($post_translated) ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a></h3>
        <?php
            if ( $address ) {
                ?>
                <div class="sub-title"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html( $address ); ?></div>
                <?php
            }
        ?>
        <div class="section-footer">
            <div class="reviews">
                <span class="rate"><?php echo esc_attr( $review_rate ); ?>
                    /5 <?php echo TravelHelper::get_rate_review_text( $review_rate, $count_review ); ?>
                </span>
                <span class="summary">
                    <?php comments_number( __( 'No Review', 'traveler' ), __( '1 Review', 'traveler' ), get_comments_number() . ' ' . __( 'Reviews', 'traveler' ) ); ?>
                </span>
            </div>
            <div class="price-wrapper">
                <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                <?php echo __('from', 'traveler'); ?> <span class="price"><?php echo TravelHelper::format_money( $price ) ?></span><span
                        class="unit"><?php echo __( '/night', 'traveler' ) ?></span>
            </div>
        </div>
    </div>
</div>

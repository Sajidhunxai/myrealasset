<?php
global $post;
$info_price = STTour::get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
if(isset($_REQUEST['location_id'])) {
    $_REQUEST['location_id'] = intval($_REQUEST['location_id']);
}
if(isset($col) && !empty($col)){
    $col = $col;
} else {
    $col = 4;
}
$url=st_get_link_with_search(get_permalink(),array('start','end','date','duration','people'),$_REQUEST);

$class = 'col-lg-'.$col.' col-md-6 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($top_search) and $top_search)
    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($slider) and $slider)
    $class = 'item-service grid-item has-matchHeight';
?>
<div class="<?php echo esc_attr($class); ?>">
    <div class="service-border">
        <div class="thumb">
            <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                <?php echo STFeatured::get_sale($info_price['discount']); ?>
            <?php } ?>
            <?php if(is_user_logged_in()){ ?>
                <?php $data = STUser_f::get_icon_wishlist();?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php }else{ ?>
                <a href="#" class="login" data-toggle="modal" data-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>">
                <?php
                if(has_post_thumbnail()){
                    //the_post_thumbnail(array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                    the_post_thumbnail(array(680, 500), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                }else{
                    echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
            <p class="service-location plr15"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
        <?php endif;?>
        <h4 class="service-title plr15"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>

        <div class="service-review plr15">
            <ul class="icon-group text-color booking-item-rating-stars">
                <?php
                $avg = STReview::get_avg_rate();
                echo TravelHelper::rate_to_string($avg);
                ?>
            </ul>
            <?php
            $count_review = get_comment_count(get_the_ID())['approved'];
            ?>
            <span class="review">
                <?php //echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?>
                <?php comments_number(__('0 reviews', 'traveler'), __('1 Review', 'traveler'), __('% Reviews', 'traveler')); ?>
            </span>
        </div>

        <div class="section-footer">
            <div class="footer-inner plr15">
                <?php
                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '16px', '16px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>
                <div class="service-price">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                            <span class="fr_text"><?php _e("from", 'traveler') ?></span>
                    </span>
                    <span class="price">
                        <?php
                        echo STTour::get_price_html(get_the_ID());
                        ?>
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
